<?php

namespace user\modules\dev\controllers;

use common\models\CdbArticle;
use common\models\CdbCategory;
use common\models\CdbSubcategory;
use common\models\DevPayments;
use common\models\DevPaymentsAlias;
use common\models\DevProject;
use common\models\DevProjectAllias;
use common\models\DevStageProject;
use common\models\disk\Cloud;
use common\models\helpers\Robokassa;
use common\models\helpers\TelegramBot;
use common\models\UsersBills;
use common\models\UsersCertificates;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\Clients;
use common\models\SkillTrainings;
use common\models\User;
use common\models\UsersNotice;
use common\models\UsersProperties;
use yii\data\Pagination;
use common\models\BudgetLog;
use Yii;
use yii\web\Response;

/**
 * Default controller for the `dev` module
 */
class MainController extends Controller
{
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
        $budget_log = BudgetLog::find()->where(['user_id' => $user])->asArray()->limit(5)->orderBy('id desc')->all();
        $project = DevProject::find()->asArray()->where(['user_id' => $user])->limit(3)->orderBy('id desc')->all();

        return $this->render('index', [
            'user' => $user,
            'client' => $client,
            'user_info' => $user_info,
            'notice' => $notice,
            'budget_log' => $budget_log,
            'project' => $project,
        ]);
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

    public function actionProfile()
    {
        $user = Yii::$app->user;
        $model = User::find()->where(['id' => $user->getId()])->asArray()->one();
        $client = Clients::find()->where(['user_id' => $user->getId()])->asArray()->one();
        $propertis = UsersProperties::find()->where(['user_id' => $user->getId()])->asArray()->one();
        return $this->render('profile', ['user' => $user, 'model' => $model, 'client' => $client, 'propertis' => $propertis]);
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
            $key = ['email', 'status', 'balance', 'push', 'push_status', 'new_lead', 'proposition'];
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

        #СЧЕТА
        /* фильтр счетов */
        $filt = ['AND'];
        if (!empty($_GET['filt'])) {
            $dateFin = $_GET['filt'];
            if (!empty($dateFin['first'])) {
                $filt[] = ['>=', 'date', date('Y-m-d 00:00:00', strtotime($dateFin['first']))];
            }
            if (!empty($dateFin['last'])) {
                $filt[] = ['<=', 'date', date('Y-m-d 23:59:59', strtotime($dateFin['last']))];
            }
        } else {
            $filt[] = ['>=', 'date', $firstDay];
            $filt[] = ['<=', 'date', $lastDay];
        }
        /* фильтр счетов */
        $bills = UsersBills::find()->where(['user_id' => $user->id])->andWhere($filt)->asArray();
        $countQueryBills = clone $bills;
        $pagesBills = new Pagination(['totalCount' => $countQueryBills->count()]);
        $pagesBills->setPageSize(10);
        $pagesBills->pageParam = 'bill-page';
        $modelsBills = $bills->offset($pagesBills->offset)
            ->limit($pagesBills->limit)
            ->orderBy('date desc')
            ->all();
        #СЧЕТА

        #АКТЫ
        /* фильтр актов */
        $filtAct = ['AND'];
        if (!empty($_GET['filtAct'])) {
            $dateAct = $_GET['filtAct'];
            if (!empty($dateAct['first'])) {
                $filtAct[] = ['>=', 'date', date('Y-m-d 00:00:00', strtotime($dateAct['first']))];
            }
            if (!empty($dateAct['last'])) {
                $filtAct[] = ['<=', 'date', date('Y-m-d 23:59:59', strtotime($dateAct['last']))];
            }
        } else {
            $filtAct[] = ['>=', 'date', $firstDay];
            $filtAct[] = ['<=', 'date', $lastDay];
        }
        /* фильтр актов */
        $acts = UsersCertificates::find()->where(['user_id' => $user->id])->andWhere($filtAct)
            ->asArray();
        $countQueryActs = clone $acts;
        $pagesActs = new Pagination(['totalCount' => $countQueryActs->count()]);
        $pagesActs->setPageSize(10);
        $pagesActs->pageParam = 'act-page';
        $modelsActs = $acts->offset($pagesActs->offset)
            ->limit($pagesActs->limit)
            ->orderBy('date desc')
            ->all();
        #АКТЫ

        $client = Clients::find()->where(['user_id' => $user->id])->asArray()->one();
        return $this->render('balance',
            [
                'user' => $user,
                'balance' => $models,
                'pages' => $pages,
                'real_user' => $realUser,
                'client' => $client,
                'bills' => $modelsBills,
                'acts' => $modelsActs,
                'pagesBills' => $pagesBills,
                'pagesActs' => $pagesActs,
            ]);
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

    public function actionMyprojects()
    {
        $user_id = Yii::$app->getUser()->getId();
        $projectsActive = DevProject::find()->asArray()->where(['user_id' => $user_id])->andWhere(['!=', 'status', 'Выполнен'])->all();
        $projectsEnd = DevProject::find()->asArray()->where(['user_id' => $user_id])->andWhere(['status' => 'Выполнен'])->all();
        $stages = DevProjectAllias::find()->asArray()->all();

        return $this->render('myprojects', [
            'projectsActive' => $projectsActive,
            'projectsEnd' => $projectsEnd,
            'stages' => $stages,
        ]);
    }

    public function actionStartproject()
    {
        return $this->render('startproject');
    }

    public function actionProjectpage($link)
    {
        $project = DevProject::find()->asArray()->where(['link' => $link])->one();
        if (empty($project))
            return $this->redirect('/dev/my-projects');
        $user_id = Yii::$app->getUser()->getId();
        $stage = DevStageProject::find()->asArray()->where(['id' => $project['stage_id']])->one();
        $stages = DevStageProject::find()->asArray()->all();
        $stageDone = DevProjectAllias::find()->asArray()->where(['project_id' => $project['id']])->all();
        $payments = DevPaymentsAlias::find()->asArray()->where(['user_id' => $user_id])->andWhere(['project_id' => $project['id']])->all();
        $summ = DevPaymentsAlias::find()->asArray()
            ->where(['user_id' => $user_id])
            ->andWhere(['project_id' => $project['id']])
            ->andWhere(['status' => 'Не оплачено'])
            ->all();
        $last__summ = 0;
        foreach ($summ as $v)
            $last__summ = $last__summ + $v['summ'];

        return $this->render('projectpage', [
            'project' => $project,
            'stage' => $stage,
            'stages' => $stages,
            'stageDone' => $stageDone,
            'payments' => $payments,
            'last__summ' => $last__summ,
            'summ' => $summ,
        ]);
    }

    public function actionAllSummPay()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user_id = Yii::$app->getUser()->getId();
        $user = User::findOne(['id' => $user_id]);
        if (empty($user)) return $this->redirect('my-projects');
        $project_id = $_POST['id'];
        $summ = (int)$_POST['summ'];
        if (empty($project_id) || empty($summ)) return $this->redirect('my-projects');
        $project = DevProject::find()->asArray()->where(['id'=>$project_id])->one();
        $allPay = DevPaymentsAlias::find()->where(['user_id' => $user_id])
            ->andWhere(['project_id' => $project_id])
            ->andWhere(['status' => 'Не оплачено'])->all();
        $totalSumm = 0;
        foreach ($allPay as $i) $totalSumm = $totalSumm + $i->summ;
        if ((int)$totalSumm !== $summ) return $this->redirect('my-projects');
        if ($user->budget < $summ) return ['status' => 'error', 'message' => 'Недостаточно средств на балансе. Перейти к пополнению баланса?'];
        $budget_was = $user->budget;
        $user->budget = $user->budget - $summ;
        $budget_after = $user->budget;
        if ($user->update() !== false){
            foreach ($allPay as $i){
                $i->status = 'Оплачено';
                $i->update();
            }
            $log = new BudgetLog();
            $log->text = "Оплата проекта: {$project['name']}. Полная оплата. -{$summ}";
            $log->date = date('Y-m-d H:i:s');
            $log->user_id = $user_id;
            $log->budget_was = $budget_was;
            $log->budget_after = $budget_after;
            if ($log->save()){
                return ['status' => 'success'];
            } else return ['status' => 'error', 'message' => 'Ошибка записли истории платежей'];
        } else return ['status' => 'error', 'message' => 'Ошибка списания средств!'];
    }

    public function actionOnePay()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user_id = Yii::$app->getUser()->getId();
        $user = User::findOne(['id' => $user_id]);
        if (empty($user)) return $this->redirect('my-projects');
        $project_id = $_POST['id'];
        $summ = (int)$_POST['summ'];
        if (empty($project_id) || empty($summ)) return $this->redirect('my-projects');
        $project = DevProject::find()->asArray()->where(['id'=>$project_id])->one();
        $pay = DevPaymentsAlias::find()->where(['user_id' => $user_id])
            ->andWhere(['project_id' => $project_id])
            ->andWhere(['summ' => $summ])
            ->andWhere(['status' => 'Не оплачено'])
            ->andWhere(['id' => $_POST['pay_id']])
            ->one();
        if (empty($pay)) return ['status' => 'error', 'message' => 'Указан не верный платеж'];
        if ($user->budget < $summ) return ['status' => 'error', 'message' => 'Недостаточно средств балансе. Перейти к пополнению баланса?'];
        $budget_was = $user->budget;
        $user->budget = $user->budget - $summ;
        $budget_after = $user->budget;
        if ($user->update() !== false){
            $pay->status = 'Оплачено';
            if ($pay->update() !== false){
                $log = new BudgetLog();
                $log->text = "Оплата проекта: {$project['name']}. Частичная оплата. -{$summ}";
                $log->date = date('Y-m-d H:i:s');
                $log->user_id = $user_id;
                $log->budget_was = $budget_was;
                $log->budget_after = $budget_after;
                if ($log->save()){
                    return ['status' => 'success'];
                } else return ['status' => 'error', 'message' => 'Ошибка записли истории платежей'];
            } else return ['status' => 'error', 'message' => 'Ошибка обновления '];
        } else return ['status' => 'error', 'message' => 'Ошибка списания средств!'];
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

    public function actionManualproject()
    {
        return $this->render('manualproject');
    }

    public function actionManualstart()
    {
        return $this->render('manualstart');
    }

    public function actionCreateProject()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user_id = Yii::$app->getUser()->getId();
        $user = User::find()->asArray()->where(['id' => $user_id])->one();
        if (empty($user)) return $this->redirect('start-project');
        if (empty($_POST['project-type']) && empty($_POST['project-summ']) && empty($_POST['projects-targer']) && empty($_POST['project-name']) && empty($_POST['project-link']))
            return ['status' => 'error', 'message' => 'Отстутствуют обязательные данные'];
        $integration = "";
        if (!empty($_POST['project-servises']))
            foreach ($_POST['project-servises'] as $i)
                $integration .= "{$i}; ";
        $project = new DevProject();
        $project->user_id = $user_id;
        $project->type = $_POST['project-type'];
        $project->name = $_POST['project-name'];
        $project->status = 'Модерация';
        $project->stage_id = 1;
        $project->about_project = $_POST['projects-targer'] . "<br>" . $integration;
        $project->link = $_POST['project-link']."-id-".$user_id;
        $project->summ = $_POST['project-summ'];
        $project->validate();
        if ($project->save()) {
            $tg = new TelegramBot();
            $tg->new__message($tg::new__project($user_id, $project->id, $_POST['project-name']), $tg::PEER_OPERATIONS);
            return ['status' => 'success', 'message' => 'Проект создан и находится на модерации'];
        } else return ['status' => 'error', 'message' => 'Ошибка создания проекта', 'validate' => $project->errors];
    }

    public static function fullInfo($client)
    {
        return !empty($client['f']) && !empty($client['i']) && !empty($client['email']) && !empty($client['company_info']) && !empty($client['requisites']);
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

        if (!empty($_COOKIE['Views'])){
            $cookie = $_COOKIE['Views'];
            $array = json_decode($cookie, true);
            if (!in_array($id, $array)){
                $array[] = $id;
                $cookie = json_encode($array, JSON_UNESCAPED_UNICODE);
                setcookie('Views', $cookie,time()+3600*24*365*10,'/');
                $article->views = $article->views + 1;
                $article->update();
            }
        } else {
            $cookLink = json_encode([$id], JSON_UNESCAPED_UNICODE);
            setcookie('Views', $cookLink,time()+3600*24*365*10,'/');
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
            $filter = ['OR',
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

}