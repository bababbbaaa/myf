<?php

namespace user\modules\skill\controllers;

use common\models\BudgetLog;
use common\models\CdbArticle;
use common\models\CdbCategory;
use common\models\CdbSubcategory;
use common\models\Clients;
use common\models\DialoguePeer;
use common\models\DialoguePeerMessages;
use common\models\Jobs;
use common\models\JobsAlias;
use common\models\Resume;
use common\models\SkillTrainings;
use common\models\SkillTrainingsAlias;
use common\models\SkillTrainingsBlocks;
use common\models\SkillTrainingsLessons;
use common\models\SkillTrainingsTasks;
use common\models\SkillTrainingsTasksAlias;
use common\models\SkillTrainingsTests;
use common\models\SkillTrainingsTestsAlias;
use common\models\User;
use common\models\UsersBills;
use common\models\UsersCertificates;
use common\models\UsersNotice;
use common\models\UsersProperties;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;
use user\controllers\PermissionController;
use yii\data\Pagination;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use Yii;
use common\models\helpers\Robokassa;
use common\models\disk\Cloud;
use common\models\helpers\UrlHelper;
use common\models\SkillTrainingsCategory;
use Dompdf\Dompdf;
use yii\helpers\ArrayHelper;

/**
 * Default controller for the `skill` module
 */
class StudentController extends PermissionController
{

    public function actionReadNotice()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['read']) || !empty($_POST['id'])) {
            if (!empty($_POST['id'])) {
                $notice = UsersNotice::find()
                    ->where(['user_id' => Yii::$app->getUser()->getId(), 'active' => 1, 'id' => $_POST['id']])
                    ->orderBy('date desc')
                    ->all();
            } else {
                $notice = UsersNotice::find()
                    ->where(['user_id' => Yii::$app->getUser()->getId(), 'active' => 1])
                    ->orderBy('date desc')
                    ->all();
            }
            if (!empty($notice)) {
                foreach ($notice as $item) {
                    $item->active = 0;
                    $item->update();
                }
                if ($item->update() !== false) {
                    $rsp = ['status' => 'success'];
                } else $rsp = ['status' => 'error', 'message' => 'Произошла ошибка на сервере'];
            } else $rsp = ['status' => 'error', 'message' => 'Все уведомления прочитаны'];
        } else $rsp = ['status' => 'error', 'message' => 'Нет данных'];
        return $rsp;
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {

        $user = Yii::$app->getUser()->getId();
        $client = Clients::find()->where(['user_id' => $user])->asArray()->one();
        $user_info = User::find()->where(['id' => $user])->asArray()->one();
        $notice = UsersNotice::find()->where(['user_id' => $user, 'active' => 1])
            ->orderBy('date desc')->limit(4)->all();
        $date = date('Y-m-d H:i:s');
        $freeWeb = SkillTrainings::find()->where(['>', 'date_meetup', $date])
            ->andWhere(['price' => 0])->limit(4)->all();
        $upcoming_events = SkillTrainings::find()->where(['>', 'date_meetup', $date])->limit(6)->all();

        return $this->render('index', [
            'user' => $user,
            'client' => $client,
            'user_info' => $user_info,
            'notice' => $notice,
            'freeWeb' => $freeWeb,
            'upcoming_events' => $upcoming_events,
        ]);
    }

    public function actionSupport()
    {
        $user = Yii::$app->getUser()->getId();
        if (!empty($user)) {
            if (!empty($_POST['name'])) {
                $dialog = DialoguePeer::find()->where(['user_id' => $user, 'status' => DialoguePeer::STATUS_OPENED])->orderBy('id desc')->one();
                $allDialog = DialoguePeer::find()->where(['user_id' => $user, 'status' => DialoguePeer::STATUS_CLOSED])->orderBy('id desc');
                $pages = new Pagination(['totalCount' => $allDialog->count(), 'pageSize' => 8]);
                $posts = $allDialog->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
                if (empty($dialog)) {
                    $dialog = new DialoguePeer();
                    $dialog->user_id = $user;
                    $dialog->status = DialoguePeer::STATUS_OPENED;
                    $dialog->type = DialoguePeer::TYPE_DEFAULT;
                    $dialog->save();
                    if ($dialog->save() !== false) {
                        $rsp = ['status' => 'success'];
                    } else $rsp = ['status' => 'error', 'message' => 'Ошибка сервера'];
                } else $rsp = ['status' => 'error', 'message' => 'У вас уже есть открытый диалог'];
            } else {
                $dialog = DialoguePeer::find()->where(['user_id' => $user, 'status' => DialoguePeer::STATUS_OPENED])->orderBy('id desc')->one();
                $allDialog = DialoguePeer::find()->where(['user_id' => $user, 'status' => DialoguePeer::STATUS_CLOSED])->orderBy('id desc');
                $pages = new Pagination(['totalCount' => $allDialog->count(), 'pageSize' => 8]);
                $posts = $allDialog->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
            }
        }
        return $this->render('support', [
            'dialog' => $dialog,
            'allDialog' => $posts,
            'pages' => $pages,
            'rsp' => $rsp,
        ]);
    }

    public function actionSendMessageHelp()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['pearId']) && !empty($_POST['message'])) {
            $msg = $_POST['message'];
            $user = Yii::$app->getUser()->getId();
            if (!empty($user)) {
                $dialog = DialoguePeer::find()->where(['user_id' => $user, 'status' => DialoguePeer::STATUS_OPENED])->select('id')->orderBy('id desc')->one();
                if (!empty($dialog)) {
                    $message = new DialoguePeerMessages();
                    $message->peer_id = (int)$_POST['pearId'];
                    $message->user_id = $user;
                    $message->message = $msg;
                    $message->isSupport = 0;
                    $message->validate();
                    if ($message->save()) {
                        $rsp = ['status' => 'success'];
                    } else $rsp = ['status' => 'error', 'message' => 'Ошибка на сервере'];
                } else $rsp = ['status' => 'error', 'message' => 'Такого диалога нет'];
            } else $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
        } else $rsp = ['status' => 'error', 'message' => 'Нет сообщения'];
        return $message->errors;
    }

    public function actionBalance()
    {
        $user = Yii::$app->getUser();
        $realUser = User::findOne(['id' => $user->id]);
        #Логи бюджета
        $dates = new \DateTime();
        $dates->modify('last day of this month');
        $lastDay = $last_day_this_month = $dates->format('Y-m-d 23:59:59');
        $firstDay = date("Y-m-01 00:00:00");


        /* фильтр истории */
        $filters = ['AND'];
        if (!empty($_GET['filters'])) {
            $dateFind = $_GET['filters'];
            if (!empty($dateFind['first'])) {
                $filters[] = ['>=', 'date', date('Y-m-d 00:00:00', strtotime($dateFind['first']))];
            }
            if (!empty($dateFind['last'])) {
                $filters[] = ['<=', 'date', date('Y-m-d 23:59:59', strtotime($dateFind['last']))];
            }
        } else {
            $filters[] = ['>=', 'date', $firstDay];
            $filters[] = ['<=', 'date', $lastDay];
        }
        /* фильтр истории */

        $budget = BudgetLog::find()->where(['user_id' => $user->id])->andWhere($filters)->asArray();
        $countQuery = clone $budget;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(10);
        $pages->pageParam = 'balance-page';
        $models = $budget->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('date asc')
            ->all();
        #Логи бюджета


        $client = Clients::find()->where(['user_id' => $user->id])->asArray()->one();
        return $this->render(
            'balance',
            [
                'user' => $user,
                'balance' => $models,
                'pages' => $pages,
                'real_user' => $realUser,
                'client' => $client,
            ]
        );
    }

    public function actionCreateBalanceLink()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['value']) && !empty($_POST['hash'])) {
            if ($_POST['value'] > 1000000)
                return ['status' => 'error', 'message' => 'Сумма платежа не может быть больше 1 млн. рублей.'];
            $user = Yii::$app->getUser();
            $client = Clients::findOne(['user_id' => $user->id]);
            if (!empty($client->company_info) && !empty($client->requisites)) {
                $reqs = json_decode($client->requisites, 1);
                if ($reqs !== null && isset($reqs['fiz'])) {
                    $required = ['f', 'i', 'address', 'phone', 'email'];
                    foreach ($required as $key => $item) {
                        if (empty($reqs['fiz'][$item])) {
                            return ['status' => 'error', 'message' => 'Реквизиты плательщика заполнены некорректно'];
                        }
                    }
                    $newhash = md5(Robokassa::PASSWORD_MAIN_1 . "::{$user->id}");
                    if ($newhash === $_POST['hash']) {
                        $keys = [
                            'description' => 'Пополнение баланса личного кабинета',
                            'price' => $_POST['value'],
                            'shp' => ['Shp_description' => "Пополнение баланса личного кабинета", 'Shp_user' => $user->id, 'Shp_redirect' => "https://user.myforce.ru/lead-force/provider/balance"]
                        ];
                        $robokassa = new Robokassa($keys);
                        $robokassa->create__pay__link();
                        return ['status' => 'success', 'url' => urldecode($robokassa->url)];
                    } else
                        $rsp = ['status' => 'error', 'message' => 'Ошибка контрольной суммы'];
                } else
                    $rsp = ['status' => 'error', 'message' => 'Необходимо заполнить реквизиты физ.лица-плательщика'];
            } else
                $rsp = ['status' => 'error', 'message' => 'Необходимо заполнить <a href="' . Url::to(['prof']) . '">данные профиля</a> для совершения платежей'];
        } else
            $rsp = ['status' => 'error', 'message' => 'Не указаны обязательные параметры'];
        return $rsp;
    }

    public function actionGetLocaleFile($type, $id)
    {
        if (empty($type) || empty($id))
            return Yii::$app->response->redirect(['/lead-force/provider/index']);
        else {
            $user = Yii::$app->getUser();
            switch ($type) {
                default:
                case 'bill':
                    $bill = UsersBills::findOne(['user_id' => $user->id, 'id' => $id]);
                    if (!empty($bill)) {
                        if (ob_get_length())
                            ob_end_clean();
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="' . basename($bill->link) . '"');
                        header('Content-Transfer-Encoding: binary');
                        header('Connection: Keep-Alive');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize(Cloud::WEB_PATH . $bill->link));
                        if ($fd = fopen(Cloud::WEB_PATH . $bill->link, 'rb')) {
                            while (!feof($fd)) {
                                print fread($fd, 1024);
                            }
                            fclose($fd);
                        }
                        exit;
                    } else
                        return Yii::$app->response->redirect(['/lead-force/provider/index']);
                case 'act':
                    $act = UsersCertificates::findOne(['user_id' => $user->id, 'id' => $id]);
                    if (!empty($act)) {
                        if (ob_get_length())
                            ob_end_clean();
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="' . basename($act->link) . '"');
                        header('Content-Transfer-Encoding: binary');
                        header('Connection: Keep-Alive');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize(Cloud::WEB_PATH . $act->link));
                        if ($fd = fopen(Cloud::WEB_PATH . $act->link, 'rb')) {
                            while (!feof($fd)) {
                                print fread($fd, 1024);
                            }
                            fclose($fd);
                        }
                        exit;
                    } else
                        return Yii::$app->response->redirect(['/lead-force/provider/index']);
            }
        }
    }

    public function actionCreateBill()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['value']) && !empty($_POST['hash'])) {
            if ($_POST['value'] > 1000000)
                return ['status' => 'error', 'message' => 'Сумма платежа не может быть больше 1 млн. рублей.'];
            $user = Yii::$app->getUser();
            $client = Clients::findOne(['user_id' => $user->id]);
            $restriction = UsersBills::find()->where(['AND', ['>=', 'date', date("Y-m-d 00:00:00")], ['<=', 'date', date("Y-m-d 23:59:59")], ['user_id' => $user->id]])->count();
            if ($restriction >= 2)
                return ['status' => 'error', 'message' => 'Выставление более 2 счетов в день запрещено. <br> Попробуйте, пожалуйста, завтра'];
            if (!empty($client->company_info) && !empty($client->requisites)) {
                $newhash = md5(Robokassa::PASSWORD_MAIN_1 . "::{$user->id}");
                if ($newhash === $_POST['hash']) {
                    $reqs = json_decode($client->requisites, 1);
                    if ($reqs !== null && isset($reqs['jur'])) {
                        $required = ['inn', 'ogrn', 'kpp', 'bank', 'bik', 'rs', 'ks', 'organization', 'director', 'jur_address', 'real_address'];
                        foreach ($required as $key => $item) {
                            if (empty($reqs['jur'][$item])) {
                                return ['status' => 'error', 'message' => 'Реквизиты плательщика заполнены некорректно'];
                            }
                        }
                        $cloud = new Cloud($user->id);
                        $file = $cloud->create__bill($reqs['jur'], $_POST['value']);
                        $bills = new UsersBills();
                        $bills->name = "Пополнение баланса личного кабинета";
                        $bills->user_id = $user->id;
                        $bills->act_data = json_encode($file['responseData'], JSON_UNESCAPED_UNICODE);
                        $bills->value = $_POST['value'];
                        $bills->link = $file['download'];
                        if (!in_array('error', $file)) {
                            if (file_exists($file['real']) && $bills->save()) {
                                $rsp = ['status' => 'success', '__object' => $bills->id];
                            } else
                                $rsp = ['status' => 'error', 'message' => 'Ошибка сохранения счета'];
                        } else
                            $rsp = ['status' => 'error', 'message' => 'Ошибка сети. Повторите попытку позже'];
                    } else
                        $rsp = ['status' => 'error', 'message' => 'Реквизиты плательщика заполнены некорректно'];
                } else
                    $rsp = ['status' => 'error', 'message' => 'Ошибка контрольной суммы'];
            } else
                $rsp = ['status' => 'error', 'message' => 'Необходимо заполнить <a href="' . Url::to(['prof']) . '">данные профиля</a> для совершения платежей'];
        } else
            $rsp = ['status' => 'error', 'message' => 'Не указаны обязательные параметры'];
        return $rsp;
    }

    public function actionProfile()
    {
        $user = Yii::$app->user;
        $model = User::find()->where(['id' => $user->getId()])->asArray()->one();
        $client = Clients::find()->where(['user_id' => $user->getId()])->asArray()->one();
        $propertis = UsersProperties::find()->where(['user_id' => $user->getId()])->asArray()->one();
        return $this->render('profile', ['user' => $user, 'model' => $model, 'client' => $client, 'propertis' => $propertis]);
    }

    public function actionProfileSaver()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['fields']) && is_array($_POST['fields'])) {
            $fields = $_POST['fields'];
            $errors = [];
            $user_id = Yii::$app->getUser()->getId();
            $client = Clients::findOne(['user_id' => $user_id]);
            if (empty($client)) {
                $client = new Clients();
                $client->user_id = $user_id;
            }
            $client->f = $fields['familiya'];
            $client->i = $fields['imya'];
            $client->o = $fields['otchestvo'];
            $client->email = $fields['email'];
            if (empty($client->email)) {
                $errors[] = 'Необходимо указать почту!';
            }
            if ($fields['type'] === 'fiz') {
                if (!empty($fields['fiz']['address_registration'])) {
                    $client->company_info = json_encode(['fiz' => ['address' => $fields['fiz']['address_registration']]], JSON_UNESCAPED_UNICODE);
                } else {
                    $errors[] = 'Необходимо указать адрес регистрации по паспорту';
                }
            } else {
                $keys = ['address_jur', 'address_real', 'companyName', 'director', 'web_site', 'work',];
                if (!empty($fields['jur']) && is_array($fields['jur'])) {
                    $companyInfo = [];
                    foreach ($keys as $item) {
                        if ($item == 'web_site' || $item == 'work') {
                            $companyInfo['jur'][$item] = $fields['jur'][$item];
                            continue;
                        }
                        if (empty($fields['jur'][$item])) {
                            $errors[] = 'Не указаны обязательные поля юридического лица';
                            break;
                        } else {
                            $companyInfo['jur'][$item] = $fields['jur'][$item];
                        }
                    }
                    $client->company_info = json_encode($companyInfo, JSON_UNESCAPED_UNICODE);
                }
            }
            if ($client->validate() && empty($errors)) {
                if ((empty($client->id) && $client->save()) || $client->update() !== false) {
                    return ['status' => 'success'];
                } else {
                    return ['status' => 'error', 'message' => 'Ошибка сохранения данных'];
                }
            } else {
                return ['status' => 'error', 'validation' => [$errors, $client->errors]];
            }
        } else return ['status' => 'error', 'message' => 'Данные не указаны'];
    }

    public function actionChangePass()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $user = Yii::$app->getUser();
        $model = User::find()->where(['id' => $user->getId()])->one();
        $pass_hash = $model->password_hash;

        if (!empty($_POST['password']) && is_array($_POST['password']) && !empty($model)) {
            $pass = $_POST['password'];
            if (!empty($pass)) {
                $check = $model->validatePassword($pass['now']);
                if ($check) {
                    if (!empty($pass['new']) && !empty($pass['repeat']) && ($pass['new'] === $pass['repeat'])) {
                        $model['password_hash'] = Yii::$app->security->generatePasswordHash($pass['new']);

                        if ($model->validate()) {
                            if ($model->update() !== false) {
                                return ['status' => 'success'];
                            } else return ['status' => 'error', 'message' => 'Ошибка сохранения данных'];
                        } else return ['status' => 'error', 'message' => $model->errors];
                    } else return ['status' => 'error', 'message' => 'Пароли должны совпадать'];
                } else return ['status' => 'error', 'message' => $check];
            } else return ['status' => 'error', 'message' => 'Не заполнены обязательные поля'];
        } else return ['status' => 'error', 'message' => 'Нет данных'];
    }

    public function actionInfoPayment()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['info']) && is_array($_POST['info'])) {
            $info = $_POST['info'];
            $error = [];
            $user_id = Yii::$app->getUser()->getId();
            $client = Clients::findOne(['user_id' => $user_id]);
            $requisites = [];
            if (!empty($info['type'])) {
                if ($info['type'] === 'fiz') {
                    $keys = ['f', 'i', 'o', 'address', 'phone', 'email'];
                    foreach ($keys as $item) {
                        if (empty($info['fiz'][$item])) {
                            $error[] = 'Не указаны обязательные поля физ.лица';
                            break;
                        } else {
                            $requisites[$item] = $info['fiz'][$item];
                        }
                    }
                    if (empty($error)) {
                        if (!empty($client->requisites)) {
                            $old = json_decode($client->requisites, true);
                            $old['fiz'] = $requisites;
                            $client->requisites = json_encode($old, JSON_UNESCAPED_UNICODE);
                        } else {
                            $client->requisites = json_encode(['fiz' => $requisites], JSON_UNESCAPED_UNICODE);
                        }
                        if ($client->validate()) {
                            if ($client->update() !== false) {
                                return ['status' => 'success'];
                            } else {
                                return ['status' => 'error', 'message' => 'Ошибка сохранения данных'];
                            }
                        } else return ['status' => 'error', 'message' => $client->errors];
                    } else return ['status' => 'error', 'message' => $error];
                } elseif ($info['type'] === 'jur') {
                    $keys = ['inn', 'ogrn', 'kpp', 'bank', 'bik', 'rs', 'ks', 'organization', 'director', 'jur_address', 'real_address'];
                    foreach ($keys as $item) {
                        if (empty($info['jur'][$item])) {
                            $error[] = 'Не указаны обязательные поля юр.лица';
                            break;
                        } else {
                            $requisites[$item] = $info['jur'][$item];
                        }
                    }
                    if (empty($error)) {
                        if (!empty($client->requisites)) {
                            $old = json_decode($client->requisites, true);
                            $old['jur'] = $requisites;
                            $client->requisites = json_encode($old, JSON_UNESCAPED_UNICODE);
                        } else {
                            $client->requisites = json_encode(['jur' => $requisites], JSON_UNESCAPED_UNICODE);
                        }
                        if ($client->validate()) {
                            if ($client->update() !== false) {
                                return ['status' => 'success'];
                            } else {
                                return ['status' => 'error', 'message' => 'Ошибка сохранения данных'];
                            }
                        } else return ['status' => 'error', 'message' => $client->errors];
                    } else return ['status' => 'error', 'message' => $error];
                } else return ['status' => 'error', 'message' => 'Нет данных'];
            } else return ['status' => 'error', 'message' => 'Не выбрана форма оплаты'];
        } else return ['status' => 'error', 'message' => 'Нет данных отправки'];
    }

    public function actionPropertis()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['propertis']) && is_array($_POST['propertis'])) {
            $user = Yii::$app->user;
            $user_id = $user->id;
            $propertis = UsersProperties::findOne(['user_id' => $user_id]);
            $key = ['email', 'status', 'balance', 'push', 'push_status', 'new_lead', 'proposition', 'news', 'verified_tasks', 'webinars', 'course'];
            $arr = [];

            foreach ($key as $i) {
                if (!empty($_POST['propertis'][$i])) {
                    $arr[$i] = 1;
                } else {
                    $arr[$i] = 0;
                }
            }

            if (empty($propertis)) {
                $propertis = new UsersProperties();
                $propertis->user_id = $user_id;
            }
            if (!empty($propertis->params)) {
                $old = json_decode($propertis->params, true);
                $old['profile'] = $arr;
                $propertis->params = json_encode($old, JSON_UNESCAPED_UNICODE);
            } else {
                $propertis->params = json_encode(['profile' => $arr], JSON_UNESCAPED_UNICODE);
            }

            if ($propertis->validate()) {
                if ($propertis->save() || $propertis->update() !== false) {
                    return ['status' => 'success'];
                } else {
                    return ['status' => 'error', 'message' => 'Ошибка сохранения данных'];
                }
            } else return ['status' => 'error', 'message' => $propertis->errors];
        } else return ['status' => 'error', 'message' => 'Не выбраны параметры'];
    }

    public static function fullInfo($client)
    {
        return !empty($client['f']) && !empty($client['i']) && !empty($client['email']) && !empty($client['company_info']) && !empty($client['requisites']);
    }

    public function actionBonuses()
    {
        return $this->render('bonuses');
    }

    public function actionEducation()
    {
        $filter = ['AND'];
        if (!empty($_POST['type'])) {
            if ($_POST['type'] === 'web') {
                $filter[] = ['=', 'type', 'Вебинар'];
            } else {
                $filter[] = ['=', 'type', 'Интенсив'];
            }
        }
        if (!empty($_POST['status'])) {
            $filter[] = ['=', 'category_id', $_POST['status']];
        }

        $user = Yii::$app->getUser()->getId();
        if (empty($user)) return $this->redirect('index');
        $buyCourse = SkillTrainingsAlias::find()->asArray()->where(['user_id' => $user])->all();
        $buyArr = [];
        foreach ($buyCourse as $k => $i) $buyArr[$k] = $i['course_id'];
        $myCourse = SkillTrainings::find()->where(['in', 'id', $buyArr])->andWhere($filter)->all();
        $categoryIdArr = [];
        foreach ($myCourse as $k => $i) $categoryIdArr[$k] = $i['category_id'];
        $category = SkillTrainingsCategory::find()->where(['in', 'id', $categoryIdArr])->distinct()->asArray()->all();
        return $this->render('education', [
            'myCourse' => $myCourse,
            'category' => $category,
        ]);
    }

    public function actionPrograms()
    {
        $filters = ['AND'];
        $cat = $_GET['category'];
        $type = $_GET['type'];
        $search = $_GET['search'];
        $price = (int)$_GET['price'];

        if (!empty($cat)) {
            if (in_array('all', $cat)) {
                $filters[] = '';
            } else {
                $filters[] = ['in', 'category_id', $cat];
            }
        }
        if (!empty($type)) {
            $filters[] = ['in', 'type', $type];
        }
        if (!empty($price)) {
            $filters[] = ['=', 'price', 0];
        }
        if (!empty($search)) {
            $filters[] = [
                'OR',
                ['like', 'name', '%' . $search . '%', false],
                ['like', 'content_subtitle', '%' . $search . '%', false],
                ['like', 'content_about', '%' . $search . '%', false],
                ['like', 'content_block_description', '%' . $search . '%', false],
                ['like', 'content_block_tags', '%' . $search . '%', false],
                ['like', 'content_what_study', '%' . $search . '%', false],
                ['like', 'type', '%' . $search . '%', false],
                ['like', 'content_terms', '%' . $search . '%', false]
            ];
        }

        $category = SkillTrainingsCategory::find()->distinct()->asArray()->all();
        $buyCource = SkillTrainingsAlias::find()->where(['user_id' => Yii::$app->getUser()->getId()])->asArray()->select('course_id')->all();
        $buyArr = [];
        foreach ($buyCource as $k => $i) {
            $buyArr[$k] = $i['course_id'];
        }
        $programs = SkillTrainings::find()->where($filters)->andWhere(['not in', 'id', $buyArr]);
        $pages = new Pagination(['totalCount' => $programs->count(), 'pageSize' => 5]);
        $posts = $programs->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('programs', [
            'program' => $posts,
            'pages' => $pages,
            'category' => $category
        ]);
    }

    function array_sort($array, $on, $order = SORT_ASC)
    {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }

    public function actionMycours($link = null)
    {
        if (empty($link)) return $this->redirect('education');
        $user = Yii::$app->getUser()->getId();
        if (empty($user)) return $this->redirect('education');
        $course = SkillTrainings::findOne(['link' => $link]);
        /*
         * Слияние и сортировка массива
         */
        $newArr = array_merge($course->skillTrainingsLessons, $course->skillTrainingsTests, $course->skillTrainingsTasks);
        ArrayHelper::multisort($newArr, 'sort_order', SORT_ASC);
        foreach ($newArr as $value) {
            $arr[$value['block_id']][] = $value;
        }
        /*
         * Слияние и сортировка массива
         */

        $my = SkillTrainingsAlias::find()->asArray()->where(['user_id' => $user])->all();
        $myArr = [];
        foreach ($my as $k => $i) $myArr[$k] = $i['course_id'];
        if (!in_array($course['id'], $myArr)) return $this->redirect('education');

        return $this->render('mycours', [
            'course' => $course,
            'courseArr' => $arr
        ]);
    }

    public function actionMyvebinar($link = null)
    {
        if (empty($link)) return $this->redirect('education');
        $user = Yii::$app->getUser()->getId();
        if (empty($user)) return $this->redirect('education');
        $course = SkillTrainings::findOne(['link' => $link]);
        $my = SkillTrainingsAlias::find()->asArray()->where(['user_id' => $user])->all();
        $myArr = [];
        foreach ($my as $k => $i) $myArr[$k] = $i['course_id'];
        if (!in_array($course['id'], $myArr)) return $this->redirect('education');

        return $this->render('myvebinar', [
            'course' => $course,
        ]);
    }

    public function actionMyintensiv($link = null)
    {
        if (empty($link)) return $this->redirect('education');
        $user = Yii::$app->getUser()->getId();
        if (empty($user)) return $this->redirect('education');
        $course = SkillTrainings::findOne(['link' => $link]);
        /*
       * Слияние и сортировка массива
       */
        $arr = array_merge($course->skillTrainingsLessons, $course->skillTrainingsTests);
        $newArr = $this->array_sort($arr, 'sort_order', SORT_ASC);
        /*
         * Слияние и сортировка массива
         */

        $my = SkillTrainingsAlias::find()->asArray()->where(['user_id' => $user])->all();
        $myArr = [];
        foreach ($my as $k => $i) $myArr[$k] = $i['course_id'];
        if (!in_array($course['id'], $myArr)) return $this->redirect('education');
        return $this->render('myintensiv', [
            'course' => $course,
            'courseArr' => $newArr
        ]);
    }

    public function actionLesson($id = null)
    {
        $user_id = Yii::$app->getUser()->getId();
        $courses = SkillTrainingsAlias::find()->asArray()->where(['user_id' => $user_id])->all();
        $byCourses = [];
        foreach ($courses as $k => $v) $byCourses[$k] = $v['course_id'];
        $lesson = SkillTrainingsLessons::find()->where(['id' => $id])
            ->andWhere(['in', 'training_id', $byCourses])->one();
        if (empty($lesson)) $this->redirect('education');
        $blocksLessons = SkillTrainingsLessons::find()->asArray()
            ->where(['block_id' => $lesson->block_id])->andWhere(['!=', 'id', $lesson->id])->all();
        $blocksTasks = SkillTrainingsTasks::find()->asArray()->where(['block_id' => $lesson->block_id])->all();
        $blocksTests = SkillTrainingsTests::find()->asArray()->where(['block_id' => $lesson->block_id])->all();
        return $this->render('lesson', [
            'lesson' => $lesson,
            'blocksLessons' => $blocksLessons,
            'blocksTasks' => $blocksTasks,
            'blocksTests' => $blocksTests,
        ]);
    }

    public function actionTask($id = null)
    {
        $user_id = Yii::$app->getUser()->getId();
        $courses = SkillTrainingsAlias::find()->asArray()->where(['user_id' => $user_id])->all();
        $byCourses = [];
        foreach ($courses as $k => $v) $byCourses[$k] = $v['course_id'];
        $task = SkillTrainingsTasks::find()->where(['id' => $id])
            ->andWhere(['in', 'training_id', $byCourses])->one();

        $blocksLessons = SkillTrainingsLessons::find()->asArray()->where(['block_id' => $task->block_id])->all();
        $blocksTasks = SkillTrainingsTasks::find()->asArray()->where(['block_id' => $task->block_id])
            ->andWhere(['!=', 'id', $task->id])->all();
        $blocksTests = SkillTrainingsTests::find()->asArray()->where(['block_id' => $task->block_id])->all();
        $taskAllias = SkillTrainingsTasksAlias::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['block_id' => $task->block_id])
            ->asArray()
            ->one();
        return $this->render('task', [
            'task' => $task,
            'blocksLessons' => $blocksLessons,
            'blocksTasks' => $blocksTasks,
            'blocksTests' => $blocksTests,
            'taskAllias' => $taskAllias,
        ]);
    }

    public function actionTest($id = null)
    {
        $user_id = Yii::$app->getUser()->getId();
        $courses = SkillTrainingsAlias::find()->asArray()->where(['user_id' => $user_id])->all();
        $byCourses = [];
        foreach ($courses as $k => $v) $byCourses[$k] = $v['course_id'];
        $test = SkillTrainingsTests::find()->where(['id' => $id])
            ->andWhere(['in', 'training_id', $byCourses])->one();

        $blocksLessons = SkillTrainingsLessons::find()->asArray()->where(['block_id' => $test->block_id])->all();
        $blocksTasks = SkillTrainingsTasks::find()->asArray()->where(['block_id' => $test->block_id])->all();
        $blocksTests = SkillTrainingsTests::find()->asArray()->where(['block_id' => $test->block_id])
            ->andWhere(['!=', 'id', $test->id])->all();
        $allias = SkillTrainingsTestsAlias::find()->asArray()
            ->where(['block_id' => $test->block_id])
            ->andWhere(['test_id' => $id])
            ->andWhere(['user_id' => $user_id])
            ->one();

        return $this->render('test', [
            'test' => $test,
            'blocksLessons' => $blocksLessons,
            'blocksTasks' => $blocksTasks,
            'blocksTests' => $blocksTests,
            'allias' => $allias,
        ]);
    }

    public function actionCoursepage($link)
    {
        if (empty($link)) {
            return $this->redirect('client');
        }
        $course = SkillTrainings::find()->where(['link' => $link])->one();
        if (empty($course)) {
            return $this->redirect('client');
        }
        $user = Yii::$app->getUser()->getId();
        $buy = SkillTrainingsAlias::find()
            ->where(['user_id' => $user])
            ->all();

        return $this->render('coursepage', [
            'course' => $course,
            'buy' => $buy,
        ]);
    }

    public function actionVebinarpage($link)
    {
        if (empty($link)) {
            return $this->redirect('programs');
        }
        $veb = SkillTrainings::find()->where(['link' => $link])->one();
        if (empty($veb)) {
            return $this->redirect('programs');
        }
        $cat = SkillTrainingsCategory::find()->where(['id' => $veb->category_id])->asArray()->one();

        return $this->render('vebinarpage', [
            'veb' => $veb,
            'cat' => $cat,
        ]);
    }

    public function actionIntensivpage($link)
    {
        if (empty($link)) {
            return $this->redirect('client');
        }
        $course = SkillTrainings::find()->where(['link' => $link])->one();
        if (empty($course)) {
            return $this->redirect('client');
        }
        $user = Yii::$app->getUser()->getId();
        $buy = SkillTrainingsAlias::find()
            ->where(['user_id' => $user])
            ->all();

        return $this->render('intensivpage', [
            'course' => $course,
            'buy' => $buy,
        ]);
    }

    public function actionKnowledge()
    {
        $category = CdbCategory::find()->asArray()->all();
        $subcategory = CdbSubcategory::find()->asArray()->all();
        $popularArticle = CdbArticle::find()->orderBy('views desc')->asArray()->limit(2)->all();

        return $this->render('knowledge', [
            'category' => $category,
            'subcategory' => $subcategory,
            'popularArticle' => $popularArticle,
        ]);
    }

    public function actionKnowledgecat($link = null)
    {
        $category = CdbCategory::find()->where(['link' => $link])->asArray()->one();
        if (empty($category)) {
            return $this->redirect('knowledge');
        }
        $subcategory = CdbSubcategory::find()->where(['category_id' => $category['id']])->asArray()->all();
        $popularArticle = CdbArticle::find()->orderBy('views desc')->asArray()->limit(2)->all();
        return $this->render('knowledgecat', [
            'category' => $category,
            'subcategory' => $subcategory,
            'popularArticle' => $popularArticle,
        ]);
    }

    public function actionKnowledgearticle($link = null)
    {
        $subcategory = CdbSubcategory::find()->where(['link' => $link])->asArray()->one();
        if (empty($subcategory)) {
            return $this->redirect('knowledge');
        }
        $category = CdbCategory::find()
            ->where(['id' => $subcategory['category_id']])
            ->asArray()
            ->one();
        $article = CdbArticle::find()
            ->where(['category_id' => $category['id']])
            ->andWhere(['subcategory_id' => $subcategory['id']])
            ->asArray()
            ->all();
        $popularArticle = CdbArticle::find()->orderBy('views desc')->asArray()->limit(2)->all();
        return $this->render('knowledgearticle', [
            'category' => $category,
            'subcategory' => $subcategory,
            'article' => $article,
            'popularArticle' => $popularArticle,
        ]);
    }

    public function actionKnowledgepage($link = null)
    {
        $article = CdbArticle::findOne(['link' => $link]);
        if (empty($article)) {
            return $this->redirect('knowledge');
        }
        $id = $article->id;
        $category = CdbCategory::find()->where(['id' => $article->category_id])->asArray()->one();
        $subcategory = CdbSubcategory::find()->where(['id' => $article->subcategory_id])->asArray()->one();
        $popularArticle = CdbArticle::find()->orderBy('views desc')->where(['!=', 'id', $id])->asArray()->limit(2)->all();
        $moreArticle = CdbArticle::find()->where(['!=', 'id', $id])->asArray()->limit(2)->all();

        if (!empty($_COOKIE['Views'])) {
            $cookie = $_COOKIE['Views'];
            $array = json_decode($cookie, true);
            if (!in_array($id, $array)) {
                $array[] = $id;
                $cookie = json_encode($array, JSON_UNESCAPED_UNICODE);
                setcookie('Views', $cookie, time() + 3600 * 24 * 365 * 10, '/');
                $article->views = $article->views + 1;
                $article->update();
            }
        } else {
            $cookLink = json_encode([$id], JSON_UNESCAPED_UNICODE);
            setcookie('Views', $cookLink, time() + 3600 * 24 * 365 * 10, '/');
            $article->views = $article->views + 1;
            $article->update();
        }


        return $this->render('knowledgepage', [
            'article' => $article,
            'category' => $category,
            'subcategory' => $subcategory,
            'popularArticle' => $popularArticle,
            'moreArticle' => $moreArticle,
        ]);
    }

    public function actionArticleSearch()
    {
        $filter = ['AND'];
        if (!empty($_GET['word'])) {
            $filter = [
                'OR',
                ['like', 'title', '%' . $_GET['word'] . '%', false],
                ['like', 'description', '%' . $_GET['word'] . '%', false],
                ['like', 'text', '%' . $_GET['word'] . '%', false],
                ['like', 'tags', '%' . $_GET['word'] . '%', false],
            ];
        }
        $article = CdbArticle::find()->where($filter)->asArray();
        $pages = new Pagination(['totalCount' => $article->count(), 'pageSize' => 10]);
        $posts = $article->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        $popularArticle = CdbArticle::find()->orderBy('views desc')->asArray()->limit(2)->all();
        return $this->render('article-search', [
            'article' => $posts,
            'popularArticle' => $popularArticle,
            'pages' => $pages,
        ]);
    }

    public function actionCareercenter()
    {
        $user_id = Yii::$app->getUser()->getId();
        $user_phone = User::find()->asArray()->where(['id' => $user_id])->select('username')->one();
        $rsp = JobsAlias::find()->asArray()
            ->where(['user_id' => $user_id])
            ->select('jobs_id')->all();
        $rspArr = [];
        foreach ($rsp as $k => $i)
            $rspArr[$k] = $i['jobs_id'];

        $filter = ['AND'];

        if (!empty($_POST['city'])) {
            $filter[] = ['=', 'city', $_POST['city']];
        }
        if (!empty($_POST['type'])) {
            $filter[] = ['=', 'type_employment', $_POST['type']];
        }
        if (!empty($_POST['format'])) {
            $filter[] = ['=', 'work_format', $_POST['format']];
        }

        $job = Jobs::find()->asArray()->where(['not in', 'id', $rspArr])->andWhere($filter)->all();
        $responses = Jobs::find()->asArray()->where(['in', 'id', $rspArr])->all();
        $myResume = Resume::find()->asArray()->where(['user_id' => $user_id])->one();
        $client = Clients::find()->asArray()->where(['user_id' => $user_id])->one();
        $city = Jobs::find()->asArray()->select('city')->distinct()->all();
        $type = Jobs::find()->asArray()->select('type_employment')->distinct()->all();
        $format = Jobs::find()->asArray()->select('work_format')->distinct()->all();
        return $this->render('careercenter', [
            'job' => $job,
            'responses' => $responses,
            'myResume' => $myResume,
            'user_phone' => $user_phone,
            'client' => $client,
            'city' => $city,
            'type' => $type,
            'format' => $format,
        ]);
    }

    public function actionVacancypage($id = null)
    {
        if (empty($id)) return $this->redirect('careercenter');
        $job = Jobs::find()->asArray()->where(['id' => $id])->one();
        $user_id = Yii::$app->getUser()->getId();
        $rsp = JobsAlias::find()->where(['jobs_id' => $job['id']])->andWhere(['user_id' => $user_id])->count();
        return $this->render('vacancypage', [
            'job' => $job,
            'rsp' => $rsp,
        ]);
    }

    public function actionRespond()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user_id = Yii::$app->getUser()->getId();
        if (empty($user_id)) return ['status' => 'error', 'message' => 'Пользователь не найден'];
        $jobs_id = $_POST['id'];
        if (empty($jobs_id)) return ['status' => 'error', 'message' => 'ID вакансии не указан'];
        $jobs = JobsAlias::find()->asArray()->where(['user_id' => $user_id])->andWhere(['jobs_id' => $jobs_id])->all();
        if (!empty($jobs)) return ['status' => 'error', 'message' => 'Вы уже откликались на эту вакансию'];
        $model = new JobsAlias();
        $model->user_id = $user_id;
        $model->jobs_id = $jobs_id;
        if ($model->save()) {
            $html = $_POST['html'];
            return Yii::$app->mailer
                ->compose()
                ->setFrom('info@myforce.ru')
                ->setTo('general@myforce.ru')
                ->setHtmlBody($html)
                ->setSubject('MyForce - заявка с сайта')
                ->send();
        } else {
            return ['status' => 'error', 'message' => 'Ошибка сохранения'];
        }
    }

    public function actionManual()
    {
        return $this->render('manual');
    }

    public function actionManualmain()
    {
        return $this->render('manualmain');
    }

    public function actionManualprofile()
    {
        return $this->render('manualprofile');
    }

    public function actionManualbalance()
    {
        return $this->render('manualbalance');
    }

    public function actionManualbonuses()
    {
        return $this->render('manualbonuses');
    }

    public function actionManualeducation()
    {
        return $this->render('manualeducation');
    }

    public function actionManualprograms()
    {
        return $this->render('manualprograms');
    }

    public function actionManualcareer()
    {
        return $this->render('manualcareer');
    }

    public function actionBuyCourse()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = $_POST['id'];
        if (empty($id)) return ['status' => 'error', 'message' => 'Id не указан'];

        $user_id = Yii::$app->getUser()->getId();
        $user = User::findOne(['id' => $user_id]);
        if (empty($user)) return ['status' => 'error', 'message' => 'Пользователь не найден'];

        $cource = SkillTrainings::find()->asArray()->where(['id' => $id])->one();
        if (empty($cource)) return ['status' => 'error', 'message' => 'Курс не найден'];

        if ($user->budget < $cource['price']) return ['status' => 'error', 'message' => 'Не достаточно средств на балансе'];

        if ($cource['discount'] > 0 && $cource['discount_expiration_date'] > date('Y-m-d H:i:s')) {
            $summ = $cource['price'] - (($cource['price'] * $cource['discount']) / 100);
        } else {
            $summ = $cource['price'];
        }
        $budget_was = $user->budget;
        $user->budget = $user->budget - $summ;
        if ($user->update() !== false) {
            $budget_after = $user->budget;
            $model = new SkillTrainingsAlias();
            $model->user_id = $user_id;
            $model->course_id = $cource['id'];
            if ($model->save()) {
                $budget_log = new BudgetLog();
                $budget_log->text = "Покупка {$cource['type']}а: \"{$cource['name']}\": -{$summ} руб.";
                $budget_log->user_id = $user_id;
                $budget_log->budget_was = $budget_was;
                $budget_log->budget_after = $budget_after;
                if ($budget_log->save()) {
                    return ['status' => 'success'];
                }
            } else {
                return ['status' => 'error', 'message' => 'Ошибка списания средств'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Ошибка списания средств'];
        }
    }

    public function actionCreateResume()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = $_POST;
        if (empty($post)) return $this->redirect('index');
        $arr = [];
        foreach ($post as $k => $i) {
            if ($k !== '_csrf-user') {
                $arr[$k] = $i;
            }
        }
        function array_filter_recursive($arr)
        {
            foreach ($arr as &$value) {
                if (is_array($value)) {
                    $value = array_filter_recursive($value);
                }
            }
            return array_filter($arr);
        }

        $arr = array_filter_recursive($arr);
        $user_id = Yii::$app->getUser()->getId();
        if (empty($user_id)) return ['status' => 'error', 'message' => 'Пользователь не найден'];
        $resume = Resume::find()->where(['user_id' => $user_id])->asArray()->one();
        if (!empty($resume)) return ['status' => 'error', 'message' => 'У вас уже создано резюме'];
        $model = new Resume();
        $model->user_id = $user_id;
        $model->info = json_encode($arr, JSON_UNESCAPED_UNICODE);
        if ($model->save()) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'error', 'message' => 'Ошибка сохранения'];
        }
    }

    public function actionUpdateResume()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $post = $_POST;
        if (empty($post)) return $this->redirect('index');
        $arr = [];
        foreach ($post as $k => $i) {
            if ($k !== '_csrf-user') {
                $arr[$k] = $i;
            }
        }
        function array_filter_recursive($arr)
        {
            foreach ($arr as &$value) {
                if (is_array($value)) {
                    $value = array_filter_recursive($value);
                }
            }
            return array_filter($arr);
        }

        $arr = array_filter_recursive($arr);
        $user_id = Yii::$app->getUser()->getId();
        if (empty($user_id)) return ['status' => 'error', 'message' => 'Пользователь не найден'];
        $resume = Resume::findOne(['user_id' => $user_id]);
        $resume->user_id = $user_id;
        $resume->info = json_encode($arr, JSON_UNESCAPED_UNICODE);
        if ($resume->update() !== false) {
            return ['status' => 'success'];
        } else {
            return ['status' => 'error', 'message' => 'Ошибка сохранения'];
        }
    }

    public function actionGetResume()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(14);
        $prop = $phpWord->getDocInfo();
        $prop->setCreator('My name');
        $prop->setCompany('My factory');
        $prop->setTitle('My title');
        $prop->setDescription('My description');
        $prop->setCategory('My category');
        $prop->setLastModifiedBy('My name');
        $prop->setCreated(mktime(0, 0, 0, 3, 12, 2014));
        $prop->setModified(mktime(0, 0, 0, 3, 14, 2014));
        $prop->setSubject('My subject');
        $prop->setKeywords('my, key, word');
        $sectionStyle = [];
        $section = $phpWord->addSection($sectionStyle);
        $user_id = Yii::$app->getUser()->getId();
        $resume = Resume::find()->asArray()->select('info')->where(['user_id' => $user_id])->one();
        $resume = json_decode($resume['info'], 1);
        $client = Clients::find()->asArray()->where(['user_id' => $user_id])->one();
        $userName = User::find()->where(['id' => $user_id])->asArray()->one();
        $projects = [];
        $experiences = [];
        $education = [];
        if (!empty($resume['projects'])) {
            foreach ($resume['projects'] as $k => $i) {
                $projects[] = [
                    "Название прокета: {$i['project-name']}",
                    "Ссылка на проект: {$i['project-link']}",
                    "Описание прокета: {$i['project-discribe']}",
                ];
            }
        }
        if (!empty($resume['experiences'])) {
            foreach ($resume['experiences'] as $k => $i) {
                $experiences[] = [
                    "Название компании: {$i['organization-name']}",
                    "Должность: {$i['position']}",
                    "Начало работы: {$i['start-month']}.{$i['year-start']}",
                    !empty($i['exp']) ? 'По настоящее время' : "Окончание работы: {$i['end-month']}.{$i['year-end']}",
                    "Подробнее: {$i['work-discribe']}",
                ];
            }
        }
        if (!empty($resume['education'])) {
            foreach ($resume['education'] as $k => $i) {
                $education[] = [
                    "Учереждение: {$i['education-name']}",
                    "Факультет: {$i['education-faculty']}",
                    "Начало учебы: {$i['education-month-start']}.{$i['education-year-start']}",
                    !empty($i['education-exp']) ? 'По настоящее время' : "Окончание учебы: {$i['education-month-end']}.{$i['education-year-end']}",
                ];
            }
        }
        $section->addText(htmlspecialchars("{$client['i']} {$client['f']}"), ['bold' => true, 'size' => 18], []);
        $section->addText(htmlspecialchars($userName['username']), [], []);
        $section->addText(htmlspecialchars($userName['email']), [], []);
        $section->addText(htmlspecialchars($resume['city']), [], []);
        $section->addText(htmlspecialchars("Пожелания к работе:"), ['bold' => true], []);
        $section->addText(htmlspecialchars("{$resume['work-format']}, {$resume['employment-type']}"), [], []);
        $section->addText(htmlspecialchars("Зарплатные ожидания: {$resume['money-from']} - {$resume['money-to']}"), [], []);
        $section->addText(htmlspecialchars("Проекты:"), ['bold' => true], []);
        if (!empty($projects)) {
            foreach ($projects as $i) {
                foreach ($i as $item) {
                    $section->addText(htmlspecialchars($item), [], []);
                }
                $section->addText(htmlspecialchars(''), [], []);
            }
        }
        $section->addText(htmlspecialchars("Опыт работы:"), ['bold' => true], []);
        if (!empty($experiences)) {
            foreach ($experiences as $i) {
                foreach ($i as $item) {
                    $section->addText(htmlspecialchars($item), [], []);
                }
                $section->addText(htmlspecialchars(''), [], []);
            }
        }
        $section->addText(htmlspecialchars("Образование:"), ['bold' => true], []);
        if (!empty($education)) {
            foreach ($education as $i) {
                foreach ($i as $item) {
                    $section->addText(htmlspecialchars($item), [], []);
                }
                $section->addText(htmlspecialchars(''), [], []);
            }
        }
        $writer = IOFactory::createWriter($phpWord, 'Word2007');
        $writer->save("resume{$user_id}.docx");
        return ['status' => 'success', 'message' => "resume{$user_id}.docx"];
    }

    public function actionDelResume()
    {
        $url = Url::to($_POST['url']);
        unlink($url);
    }

    public function actionAddTask()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST)) {
            return ['status' => 'error', 'message' => 'Данные отстутствуют'];
        }
        $user_id = Yii::$app->getUser()->getId();
        $training_id = $_POST['training_id'];
        $block_id = $_POST['block_id'];
        $task_id = $_POST['task_id'];
        if (empty($user_id) && empty($training_id) && empty($block_id)) {
            return ['status' => 'error', 'message' => 'Отстутсвуют обязательные данные'];
        }

        $model = SkillTrainingsTasksAlias::find()
            ->where(['user_id' => $user_id])
            ->andWhere(['training_id' => $training_id])
            ->andWhere(['block_id' => $block_id])
            ->one();
        if (!empty($model)) {
            $model->user_id = $user_id;
            $model->training_id = $training_id;
            $model->block_id = $block_id;
            $model->task_id = $task_id;
            $model->comment = $_POST['comment'] ?? 'Коментарий отстутсвует';
            $model->link = $_POST['link'] ?? 'Ссылка отсутствует';
            $model->status = SkillTrainingsTasksAlias::STATUS_SEND;
            $model->validate();
            if ($model->update() !== false) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'message' => $model->errors];
            }
        } else {
            $model = new SkillTrainingsTasksAlias();
            $model->user_id = $user_id;
            $model->training_id = $training_id;
            $model->block_id = $block_id;
            $model->task_id = $task_id;
            $model->comment = $_POST['comment'] ?? 'Коментарий отстутсвует';
            $model->link = $_POST['link'] ?? 'Ссылка отсутствует';
            $model->status = SkillTrainingsTasksAlias::STATUS_SEND;
            $model->validate();
            if ($model->save()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'message' => $model->errors];
            }
        }
    }

    public function actionCheckTest()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        //        $id = 12;
        //        $all = SkillTrainingsTestsAlias::find()->where(['test_id' => $id])->asArray()->one();
        //        $answer = json_decode($all['answer'], 1);

        if (empty($_POST['json'])) {
            return ['status' => 'error', 'message' => 'Отсутствуют данные теста'];
        }
        $user_id = Yii::$app->getUser()->getId();
        $id = $_POST['id'];
        $test = SkillTrainingsTests::find()->where(['id' => $id])->asArray()->select('training_id, block_id, content')->one();
        if (empty($test)) {
            return ['status' => 'error', 'message' => 'Не указан id'];
        }
        $block_id = $test['block_id'];
        $training_id = $test['training_id'];

        $ques = json_decode($test['content'], 1);
        $answer = json_decode($_POST['json'], 1);
        $errors = 0;
        foreach ($ques as $k => $v) {
            if ($v['type'] === 'text') {
                strcmp($v['answer'], $answer[$k]['answer']) !== 0 ? $errors++ : $errors;
            }
            if ($v['type'] === 'sort__answers') {
                $ansArr = $answer[$k]['answer'];
                foreach ($v['answer'] as $key => $item) {
                    if (strcmp($item['answerText'], $ansArr[$key]['answerText']) !== 0) {
                        $errors++;
                        break;
                    }
                }
            }
            if ($v['type'] === 'select__list') {
                $ansArr = $answer[$k]['answer'];
                foreach ($v['answer'] as $key => $item) {
                    if (strcmp($item['correct'], $ansArr[$key]['correct']) !== 0) {
                        $errors++;
                        break;
                    }
                }
            }
        }

        $count = count($ques);
        $pointQuestion = 100 / $count;
        $total = 100 - ($pointQuestion * $errors);

        $testAlias = SkillTrainingsTestsAlias::find()->where(['test_id' => $id])->one();
        if (empty($testAlias)) {
            $testAlias = new SkillTrainingsTestsAlias();
            $testAlias->training_id = $training_id;
            $testAlias->block_id = $block_id;
            $testAlias->test_id = $id;
            $testAlias->answer = $_POST['json'];
            $testAlias->status = SkillTrainingsTestsAlias::STATUS_OFFSET;
            $testAlias->user_id = $user_id;
            $testAlias->try_count = 1;
            $testAlias->result = "{$total}/100";
            $testAlias->validate();
            if ($testAlias->save()) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'message' => 'Ошибка сохранения', $testAlias->errors];
            }
        } else {
            $testAlias->training_id = $training_id;
            $testAlias->block_id = $block_id;
            $testAlias->test_id = $id;
            $testAlias->answer = $_POST['json'];
            $testAlias->status = SkillTrainingsTestsAlias::STATUS_OFFSET;
            $testAlias->user_id = $user_id;
            $testAlias->try_count = $testAlias->try_count + 1;
            $testAlias->result = "{$total}/100";
            if ($testAlias->update() !== false) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'message' => 'Ошибка обновления'];
            }
        }
    }

    public function actionRenderCertificate()
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml("<!DOCTYPE html>
        <html lang='en' style='padding: 0; margin: 0;'>
          <head>
            <meta charset='UTF-8' />
            <meta http-equiv='X-UA-Compatible' content='IE=edge' />
            <meta name='viewport' content='width=device-width, initial-scale=1.0' />
            <title>Document</title>
            <style>
              @page {
                size: 29.7cm 16.74cm;
              }
            </style>
          </head>
          <body style='padding: 0; margin: 0;'>
            <img
              style='width: 100%; height: 100%;'
              src='https://user.myforce.ru/img/skillclient/certificate/certificate.png'
            />
              <p
                style='
                  position: absolute;
                  top: 200px;
                  left: 340px;
                  font-style: italic;
                  font-weight: 300;
                  font-size: 26px;
                  line-height: 46px;
                  color: #030034;
                  border-bottom: 1px solid #B0B0B0;
                '
              >
                Кругленко Александр Витальевич
              </p>
              <p
                style='
                  position: absolute;
                  top: 360px;
                  left: 340px;
                  font-style: italic;
                  font-weight: 300;
                  font-size: 26px;
                  line-height: 46px;
                  color: #030034;
                  border-bottom: 1px solid #B0B0B0;
                '
              >
                Повышение квалификации Б2Б продаж MYFORCE
              </p>
              <p
                style='
                  position: absolute;
                  top: 273px;
                  left: 139px;
                  font-style: normal;
                  font-weight: 100;
                  font-size: 14px;
                  color: #FEF989;
                '
              >
                " . date('Y') . "
              </p>
              <p
                style='
                  position: absolute;
                  top: 537px;
                  left: 340px;
                  font-style: normal;
                  font-weight: 100;
                  font-size: 14px;
                  color: #7c7a95;
                '
              >
                " . date('Y') . "
              </p>
          </body>
        </html>
        ", 'UTF-8');
        $dompdf->setPaper('A3', 'landscape');
        $dompdf->set_option('enable_remote', TRUE);
        $dompdf->set_option('defaultFont', 'dejavu sans');
        $dompdf->render();
        $dompdf->stream('Сертификат MYFORCE');
    }
}
