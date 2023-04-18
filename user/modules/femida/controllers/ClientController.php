<?php

namespace user\modules\femida\controllers;

use common\models\BuyTechnologies;
use common\models\ByFranchize;
use common\models\CdbArticle;
use common\models\CdbCategory;
use common\models\CdbSubcategory;
use common\models\DbRegion;
use common\models\DialoguePeer;
use common\models\DialoguePeerMessages;
use common\models\Franchise;
use common\models\FranchisePackage;
use common\models\helpers\Robokassa;
use common\models\LeadsCategory;
use common\models\LeadsParams;
use common\models\LeadsSentReport;
use common\models\LeadTemplates;
use common\models\Offers;
use common\models\Orders;
use common\models\Providers;
use common\models\Technologies;
use common\models\UserModel;
use common\models\UsersBonuses;
use common\models\Worker;
use user\controllers\PermissionController;
use user\models\CheckCount;
use Yii;
use yii\data\Pagination;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use common\models\User;
use common\models\Clients;
use common\models\UsersProperties;
use common\models\BudgetLog;
use common\models\UsersNotice;
use common\models\UsersBills;
use common\models\UsersCertificates;
use yii\web\HttpException;
use yii\web\Response;
use common\models\Integrations;
use common\models\LeadsSave;
use common\models\Leads;

/**
 * Default controller for the `femida` module
 */
class ClientController extends PermissionController
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user;
        $client = Clients::find()->where(['user_id' => $user->getId()])->asArray()->one();
        $user_info = User::find()->where(['id' => $user->getId()])->asArray()->one();
        $budget_log = BudgetLog::find()->where(['user_id' => $user->getId()])->asArray()->limit(5)->orderBy('id desc')->all();
        $notice = UsersNotice::find()->where(['user_id' => $user->getId(), 'active' => 1])->orderBy('date desc')->limit(4)->all();
        /* Статистика */
        //        $budget = BudgetLog::find()->where(['user_id' => $user->getId()])->andWhere('date >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY)')->asArray()->all();
        $expression = "date >= DATE_SUB(CURRENT_DATE, INTERVAL 7 DAY) AND (user_id={$user->id}) AND id IN (SELECT MAX(id) FROM budget_log GROUP BY DATE(date))";
        $budget = BudgetLog::find()
            ->where(new Expression($expression))
            ->asArray()
            ->orderBy('date asc')
            ->all();
        /* Статистика */

        return $this->render('index', [
            'client' => $client,
            'user_info' => $user_info,
            'budget_log' => $budget_log,
            'budget' => $budget,
            'notice' => $notice,
        ]);
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

    public function actionCatalog()
    {
        $user = Yii::$app->getUser()->getId();
        $buyFranchize = ByFranchize::find()->where(['user_id' => $user])->select(['franchize_id'])->asArray()->all();
        $arr = [];
        foreach ($buyFranchize as $v){
            $arr[] = $v['franchize_id'];
        }
        $franchizes = Franchise::find()->where(['not in', 'id', $arr])->all();
        return $this->render('catalog', [
            'franchizes' => $franchizes,
        ]);
    }

    public function actionCatalogpage($link = null)
    {
        $franchize = Franchise::find()->where(['link' => $link])->asArray()->one();
        if (empty($franchize)) {
            return $this->redirect('catalog');
        }
        $packages = FranchisePackage::find()->where(['franchise_id' => $franchize['id']])->asArray()->all();

        return $this->render('catalogpage', [
            'franchize' => $franchize,
            'packages' => $packages,
        ]);
    }

    public function actionBuyFranchiseCredit() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(!empty($_REQUEST['id']) && !empty($_REQUEST['hex'])) {
            $id = $_REQUEST['id'];
            $hex = $_REQUEST['hex'];
            $newHex = md5("::{$id}::createSimpleTinkoffHexForValid::");
            if ($newHex !== $hex)
                return ['status' => 'error', 'reason' => "Ошибка контрольной суммы"];
            $uid = Yii::$app->getUser()->getId();
            if (!empty($my))
                return ['status' => 'error', 'reason' => "Франшиза уже куплена"];
            else {
                $budget = CabinetBudget::findOne(['user_id' => $uid]);
                $train = ByFranchize::findOne(['id' => $id]);
                if (!empty($train)) {
                    if (!empty($budget)) {
                        $budget->last_operation = "Покупка ФРАНШИЗЫ (В КРЕДИТ - {$train->price} руб.) {$train->name}";
                        $budget->update();
                        $telegaText = "<a href='tg://resolve?domain=ALEXEY_VOINOVICH'>Алексей</a>, пользователь <b>UID: {$uid}</b> купил ФРАНШИЗУ <b>(В КРЕДИТ)</b> {$train->name}. Связаться с клиентом в срочном порядке.\n\n";
                        Cabinet::telegramBotSendMessage(Cabinet::TELEGRAM_SERVICE_GROUP_PEER, $telegaText);
                        Yii::$app->session->setFlash('buy-franchise', "Франшиза {$train->name} куплена! Пожалуйста свяжитесь с технической поддержкой для получения дополнительной информации.");
                        return $this->redirect(Url::to(['cabinet/franchise']));
                    } else {
                        $budget = new CabinetBudget();
                        $budget->user_id = $uid;
                        $budget->value = 0;
                        $budget->last_operation = "Покупка ФРАНШИЗЫ (В КРЕДИТ - {$train->price} руб.) {$train->name}";
                        $budget->save();
                        $telegaText = "<a href='tg://resolve?domain=ALEXEY_VOINOVICH'>Алексей</a>, пользователь <b>UID: {$uid}</b> купил ФРАНШИЗУ <b>(В КРЕДИТ)</b> {$train->name}. Связаться с клиентом в срочном порядке.\n\n";
                        Cabinet::telegramBotSendMessage(Cabinet::TELEGRAM_SERVICE_GROUP_PEER, $telegaText);
                        Yii::$app->session->setFlash('buy-franchise', "Франшиза {$train->name} куплена! Пожалуйста свяжитесь с технической поддержкой для получения дополнительной информации.");
                        return $this->redirect(Url::to(['cabinet/franchise']));
                    }
                }
            }
        } else
            return ['status' => 'error', 'reason' => "Элемент не найден"];
    }

    public function actionByFranchize()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $idPackage = $_POST['idPackage'];
        $idFranchize = $_POST['idFranchize'];
        $type = $_POST['type'];
        if (empty($idPackage) || empty($type) || empty($idFranchize)) {
            return $rsp = ['status' => 'error', 'message' => 'Нет необходимых данных для покупки франшизы'];
        }
        if ($type === 'pay') {
            $franchize = Franchise::find()->where(['id' => $idFranchize])->asArray()->one();
            if (empty($franchize)) {
                return $rsp = ['status' => 'error', 'message' => 'Франшиза не найдена'];
            }
            $package = FranchisePackage::find()->where(['id' => $idPackage, 'franchise_id' => $idFranchize])->asArray()->one();
            if (empty($package)) {
                return $rsp = ['status' => 'error', 'message' => 'Пакет франшизы не найден'];
            }
            $user = Yii::$app->getUser()->getId();
            if (empty($user)){
                return $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
            }
            $userModel = User::find()->where(['id' => $user])->one();
            $balance = $userModel->budget;
            if (empty($userModel)) {
                return $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
            }
            if ($userModel->budget < $package['price']) {
                return $rsp = ['status' => 'balance', 'message' => 'Недостаточно средств'];
            }
            $franchizeModel = ByFranchize::find()->where(['user_id' => $user, 'franchize_id' => $idFranchize])->asArray()->one();
            if (!empty($franchizeModel)){
                return $rsp = ['status' => 'error', 'message' => 'У вас уже есть эта франшиза'];
            }
            $userModel->budget = $userModel->budget - $package['price'];
            if ($userModel->update() !== false){
                $model = new ByFranchize();
                $model->user_id = $user;
                $model->franchize_id = $idFranchize;
                $model->package_id = $idPackage;
                $model->type = 'оплата сразу';
                if ($model->save()){
                    $noticeModel = new UsersNotice();
                    $noticeModel->user_id = $user;
                    $noticeModel->type = 'Списание средств';
                    $noticeModel->active = 1;
                    $noticeModel->text = "Списание средств: {$package['price']} при покупке франшизы - {$franchize['name']}";
                    if ($noticeModel->save()){
                        $budgetModel = new BudgetLog();
                        $budgetModel->text = "Списание средств: {$package['price']} при покупке франшизы - {$franchize['name']}";
                        $budgetModel->user_id = $user;
                        $budgetModel->budget_was = $balance;
                        $budgetModel->budget_after = $userModel->budget;
                        if ($budgetModel->save()){
                            return $rsp = ['status' => 'success'];
                        } else{
                            return $rsp = ['status' => 'error', 'message' => 'Ошибка создания лога бюджета'];
                        }
                    } else {
                        return $rsp = ['status' => 'error', 'message' => 'Ошибка создания уведомления'];
                    }
                } else {
                    return $rsp = ['status' => 'error', 'message' => 'Ошибка сохранения данных'];
                }
            } else {
                return $rsp = ['status' => 'error', 'message' => 'Ошибка сохранения данных'];
            }
        } else {
            return $rsp = ['status' => 'error', 'message' => 'Не верный тип покупки'];
        }


//        if ($type === 'credit'){
//
//        } else {
//            return $rsp = ['status' => 'error', 'message' => 'Не верный тип покупки'];
//        }


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

        #статистика
        $expression = "(date >= '{$firstDay}') AND (date <= '{$lastDay}') AND (user_id={$user->id}) AND id IN (SELECT MAX(id) FROM budget_log GROUP BY DATE(date))";
        $stats = BudgetLog::find()
            ->where(new Expression($expression))
            ->asArray()
            ->orderBy('date asc')
            ->all();
        #статистика

        $client = Clients::find()->where(['user_id' => $user->id])->asArray()->one();
        return $this->render('balance',
            [
                'user' => $user,
                'balance' => $models,
                'pages' => $pages,
                'pagesBills' => $pagesBills,
                'pagesActs' => $pagesActs,
                'real_user' => $realUser,
                'client' => $client,
                'bills' => $modelsBills,
                'acts' => $modelsActs,
                'stats' => $stats
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
                            'shp' => ['Shp_description' => "Пополнение баланса личного кабинета", 'Shp_user' => $user->id, 'Shp_redirect' => "https://user.myforce.ru/femida/client/balance"]
                        ];
                        $robokassa = new Robokassa($keys);
                        $robokassa->create__pay__link();
                        return ['status' => 'success', 'url' => urldecode($robokassa->url)];
                    } else
                        $rsp = ['status' => 'error', 'message' => 'Ошибка контрольной суммы'];
                } else
                    $rsp = ['status' => 'error', 'message' => 'Необходимо заполнить реквизиты физ.лица-плательщика'];
            } else
                $rsp = ['status' => 'error', 'message' => 'Необходимо заполнить <a href="' . Url::to(['profile']) . '">данные профиля</a> для совершения платежей'];
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
                $rsp = ['status' => 'error', 'message' => 'Необходимо заполнить <a href="' . Url::to(['profile']) . '">данные профиля</a> для совершения платежей'];
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
        return $this->render('profile', [
            'user' => $user,
            'model' => $model,
            'client' => $client,
            'propertis' => $propertis
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

    public function actionBonuses()
    {
        return $this->render('bonuses');
    }

    public function actionPromotion()
    {

        $user = Yii::$app->getUser();
        $client = Clients::find()->where(['user_id' => $user->id])->select('id')->asArray()->one();
        $sphere = LeadsCategory::find()->asArray()->select('name')->all();
        $activeNew = ['status' => 'исполняется'];
        $countOrders = Orders::find()->where(['client' => $client['id']])->count();
        $countOrdersId = Orders::find()->where(['client' => $client['id']])->select(['order_name', 'id', 'category_text'])->asArray()->all();

        if (!empty($client)) {
            $filter = ['AND'];
            $filterNew = 'id asc';
            if (!empty($_GET['filter'])) {
                $filterGet = $_GET['filter'];
                if (!empty($filterGet['sphere'])) {
                    $filter[] = ['=', 'category', $filterGet['sphere']];
                }
                # новые заказы
                if (!empty($filterGet['new'])) {
                    $filterNew = ['id' => SORT_DESC];
                }
                # новые заказы
            }
            $category = LeadTemplates::find()
                ->where(['active' => 1])
                ->select(['category'])
                ->distinct()
                ->asArray()
                ->all();

            $templates = LeadTemplates::find()
                ->where(['active' => 1])
                ->andWhere($filter)
                ->select(['active', 'id', 'category', 'name', 'description', 'regions', 'link', 'price']);
            $countQuery = clone $templates;
            $pages = new Pagination(['totalCount' => $countQuery->count()]);
            $pages->setPageSize(10);
            $pages->pageParam = 'template-page';
            $models = $templates->offset($pages->offset)
                ->limit($pages->limit)
                ->orderBy($filterNew)
                ->asArray()
                ->all();
            /* Статистика */
            $dates = new \DateTime();
            $dates->modify('last day of this month');
            $lastDay = $last_day_this_month = $dates->format('Y-m-d 23:59:59');
            $firstDay = date("Y-m-01 00:00:00");
            $leadsAll = LeadsSentReport::find()
                ->select('DATE(`date`) as `date_lead`, count(1) as `summ`')
                ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
                ->andWhere(['client_id' => $client['id']])
                ->groupBy('date_lead');
            if (!empty($_GET['orderId'])) {
                $leadsAll->andWhere(['order_id' => $_GET['orderId']]);
            }
            $leadsAll = $leadsAll->all();
            /* Статистика */

            /* активные заказы */
            # фильтр заказов
            $activeFilter = ['AND'];
            if (!empty($_GET['activeFilter'])) {
                $activeGet = $_GET['activeFilter'];
                if (!empty($activeGet['status'])) {
                    $activeFilter[] = ['=', 'status', $activeGet['status']];
                } else {
                    $activeFilter[] = ['OR', ['status' => Orders::STATUS_PROCESSING], ['status' => Orders::STATUS_PAUSE], ['status' => Orders::STATUS_STOPPED], ['status' => Orders::STATUS_MODERATION]];
                }
                if (!empty($activeGet['sphere'])) {
                    $activeFilter[] = ['=', 'category_text', $activeGet['sphere']];
                }
                # новые заказы
                if (!empty($activeGet['new'])) {
                    $activeNew = ['date' => SORT_DESC];
                }
                # новые заказы
            } else {
                $activeFilter[] = ['OR', ['status' => Orders::STATUS_PROCESSING], ['status' => Orders::STATUS_PAUSE], ['status' => Orders::STATUS_STOPPED], ['status' => Orders::STATUS_MODERATION]];
            }
            # фильтр заказов

            $activeOrders = Orders::find()
                ->where(['client' => $client['id']])
                ->andWhere($activeFilter)
                ->orderBy($activeNew)
                ->asArray()
                ->all();
            /* активные заказы */

            /* архив */
            #фильтр архива
            $finishedFilter = ['AND'];
            $finishedNew = 'id desc';
            if (!empty($_GET['finishedFilter'])) {
                $finishedGet = $_GET['finishedFilter'];
                if (!empty($finishedGet['sphere'])) {
                    $finishedFilter[] = ['=', 'category_text', $finishedGet['sphere']];
                }
                # новые заказы
                if (!empty($finishedGet['new'])) {
                    $finishedNew = ['date' => SORT_DESC];
                }
                # новые заказы
            }
            #фильтр архива
            $finishedOrders = Orders::find()
                ->where(['client' => $client['id']])
                ->andWhere(['status' => Orders::STATUS_FINISHED])
                ->andWhere($finishedFilter)
                ->orderBy($finishedNew)
                ->asArray()
                ->all();
            /* архив */
        }

        return $this->render('promotion', [
            'user' => $user,
            'client' => $client,
            'activeOrders' => $activeOrders,
            'finishedOrders' => $finishedOrders,
            'sphere' => $sphere,
            'notice' => UsersNotice::find()
                ->where(['user_id' => $user->getId(), 'active' => 1])
                ->orderBy('date desc')->all(),
            'leadsAll' => $leadsAll,
            'countOrders' => $countOrders,
            'bonuses' => UsersBonuses::findOne(['user_id' => $user->id]),
            'dialog' => DialoguePeer::find()
                ->where(['user_id' => $user->id, 'type' => DialoguePeer::TYPE_ORDER, 'status' => DialoguePeer::STATUS_OPENED])
                ->andWhere(['>', 'exp_date', time()])
                ->orderBy('id desc')->one(),
            'firstDay' => $firstDay,
            'lastDay' => $lastDay,
            'countOrdersId' => $countOrdersId,
            'templates' => $models,
            'pages' => $pages,
            'category' => $category
        ]);
    }

    public function actionPopupLeadDate($link = null)
    {
        if (!empty($_POST['id'])) {
            $user = Yii::$app->user;
            if (!empty($user)) {
                $client = Clients::find()->where(['user_id' => $user->getId()])->select('id')->asArray()->one();
                if (!empty($client)) {
                    $orders = Orders::find()->where(['client' => $client['id'], 'id' => $link])->select('id')->asArray()->one();
                    if (!empty($orders)) {
                        $popupData = LeadsSentReport::find()->where(['id' => $_POST['id'], 'order_id' => $orders['id']])->one();
                        if (!empty($popupData)) {
                            $praams = LeadsParams::find()->where(['category' => $popupData->lead->type])->select(['type', 'name', 'description'])->asArray()->all();
                            $rsp = ['status' => 'success'];
                        } else $rsp = ['status' => 'error', 'message' => 'Такого лида в заказе нет'];
                    } else $rsp = ['status' => 'error', 'message' => 'Заказ не найден'];
                } else $rsp = ['status' => 'error', 'message' => 'Клиент не найден'];
            } else $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
        } else $rsp = ['status' => 'error', 'message' => 'Нет данных'];
        return $this->renderPartial('_ablead', ['popupdata' => $popupData, 'rsp' => $rsp, 'params' => $praams]);
    }

    public function actionWasteLead($link)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['id']) && !empty($_POST['why'])) {
            $id = $_POST['id'];
            $why = $_POST['why'];
            $client = Clients::find()
                ->where(['user_id' => Yii::$app->getUser()->getId()])
                ->asArray()
                ->one();
            if (!empty($client)) {
                $order = Orders::findOne(['id' => $link, 'client' => $client['id']]);
                if (!empty($order)) {
                    if ($order->status == Orders::STATUS_PROCESSING || $order->status == Orders::STATUS_PAUSE) {
                        $bonus_waste = 0;
                        $bonuses = UsersBonuses::findOne(['user_id' => $client['user_id']]);
                        if (!empty($bonuses) && !empty($bonuses->additional_waste)){
                            $bonus_waste = $bonuses->additional_waste;
                        }
                        $waste = $order->waste + $bonus_waste;
                        $leadWaste = ($order->leads_waste * 100) / ($order->leads_count - $order->leads_waste);
                        if ($waste > $leadWaste) {
                            if ($why === LeadsSentReport::REASON_WRONG_REGION || $why === LeadsSentReport::REASON_WRONG_PHONE || $why === LeadsSentReport::REASON_NOT_LEAD || $why === LeadsSentReport::REASON_DUPLICATE) {
                                $leads = LeadsSentReport::find()
                                    ->where(['in', 'lead_id', $id])
                                    ->andWhere(['client_id' => $client['id'], 'order_id' => $order->id])
                                    ->andWhere(['status' => Leads::STATUS_SENT])
                                    ->all();
                                if (!empty($leads)) {
                                    foreach ($leads as $item) {
                                        $item->status = Leads::STATUS_WASTE;
                                        if (!empty($item->log)) {
                                            $log = json_decode($item->log, true);
                                            $log[] = ['date' => date('d.m.Y H:i:s'), 'text' => 'Лид отправлен в брак в заказе №'.$order['id']];
                                            $item->status_commentary = $why;
                                        } else {
                                            $log = [['date' => date('d.m.Y H:i:s'), 'text' => 'Лид отправлен в брак в заказе №'.$order['id']]];
                                            $item->status_commentary = $why;
                                        }
                                        $item->log = json_encode($log, JSON_UNESCAPED_UNICODE);
                                        $order->update();
                                        $item->update();
                                    }
                                    $rsp = ['status' => 'success'];
                                } else $rsp = ['status' => 'error', 'message' => 'Лиды не найдены'];
                            } else $rsp = ['status' => 'error', 'message' => 'Указана не верная причина отпраковки'];
                        } else $rsp = ['status' => 'error', 'message' => 'Превышен процент отбраковки'];
                    } else $rsp = ['status' => 'error', 'message' => 'Не правильный статус заказа'];
                } else $rsp = ['status' => 'error', 'message' => 'Заказ не найден'];
            } else $rsp = ['status' => 'error', 'message' => 'Клиент не найден'];
        } else $rsp = ['status' => 'error', 'message' => 'Нет всех данных'];
        return $rsp;
    }

    public function actionConfirmLead($link)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['id'])) {
            $id = $_POST['id'];
            $client = Clients::find()
                ->where(['user_id' => Yii::$app->getUser()->getId()])
                ->asArray()
                ->one();
            if (!empty($client)) {
                $order = Orders::findOne(['id' => $link, 'client' => $client['id']]);
                if (!empty($order)) {
                    $leads = LeadsSentReport::find()
                        ->where(['in', 'lead_id', $id])
                        ->andWhere(['client_id' => $client['id'], 'order_id' => $order->id])
                        ->andWhere(['status' => Leads::STATUS_SENT])
                        ->all();
                    if (!empty($leads)) {
                        foreach ($leads as $item) {
                            if (!empty($item->offer_id) && !empty($item->provider_id)) {
                                $findFirst = LeadsSentReport::find()->where(
                                    [
                                        'offer_id' => $item->offer_id,
                                        'provider_id' => $item->provider_id,
                                        'lead_id' => $item->lead_id,
                                    ])
                                    ->orderBy('id asc')
                                    ->one();
                                if (!empty($findFirst)) {
                                    $offer = Offers::findOne($item->offer_id);
                                    if (!empty($offer)) {
                                        $offer->leads_confirmed++;
                                        $offer->total_payed = round($offer->leads_confirmed * $offer->price * (100 - $offer->tax) * 0.01, 0);
                                        $offer->update();
                                        $provider = Providers::findOne($offer->provider_id);
                                        if (!empty($provider) && !empty($provider->user_id)) {
                                            $user = UserModel::findOne($provider->user_id);
                                            if (!empty($user)) {
                                                $was = $user->budget;
                                                $user->budget += round($offer->price * (100 - $offer->tax) * 0.01, 0);
                                                if ($user->update() !== false) {
                                                    $budget_log = new BudgetLog();
                                                    $budget_log->text = "Пополнение баланса - лид №{$item->lead_id}: +". round($offer->price * (100 - $offer->tax) * 0.01, 0) ." руб.";
                                                    $budget_log->budget_was = $was;
                                                    $budget_log->user_id = $user->id;
                                                    $budget_log->budget_after = $user->budget;
                                                    $budget_log->save();
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                            $item->status = Leads::STATUS_CONFIRMED;
                            if (!empty($item->log)) {
                                $log = json_decode($item->log, true);
                                $log[] = ['date' => date('d.m.Y H:i:s'), 'text' => 'Лид подтвержден в заказе №'.$order['id']];
                            } else {
                                $log = [['date' => date('d.m.Y H:i:s'), 'text' => 'Лид подтвержден в заказе №'.$order['id']]];
                            }
                            $item->log = json_encode($log, JSON_UNESCAPED_UNICODE);
                            $item->update();
                        }
                        $rsp = ['status' => 'success'];
                    } else $rsp = ['status' => 'error', 'message' => 'Лиды не найдены'];
                } else $rsp = ['status' => 'error', 'message' => 'Заказ не найден'];
            } else $rsp = ['status' => 'error', 'message' => 'Клиент не найден'];
        } else $rsp = ['status' => 'error', 'message' => 'Нет выбранных лидов'];
        return $rsp;
    }

    public function actionChangeDay()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (!empty($_POST['day']) && !empty($_POST['link'])) {

            $day = $_POST['day'];
            $user = User::find()
                ->where(['id' => Yii::$app->getUser()->getId()])
                ->select('id')
                ->asArray()
                ->one();
            if (empty($user)) {
                $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
            } else {
                $client = Clients::find()->where(['user_id' => $user['id']])->asArray()->one();
                if (!empty($client)) {
                    $order = Orders::find()
                        ->where(['id' => $_POST['link'], 'client' => $client['id']])
                        ->one();
                    if (empty($order)) {
                        $rsp = ['status' => 'error', 'message' => 'Заказ не найден'];
                    } else {
                        if (!empty($order->params_special)) {
                            $params = json_decode($order->params_special, true);
                            if (!empty($params['days_of_week_leadgain'])) {
                                if (in_array($day, $params['days_of_week_leadgain'])) {
                                    foreach ($params['days_of_week_leadgain'] as $k => $i) {
                                        if ($i === $day) {
                                            unset($params['days_of_week_leadgain'][$k]);
                                            $class = 'delete';
                                            break;
                                        }
                                    }
                                } else {
                                    $params['days_of_week_leadgain'][] = $day;
                                    $class = 'add';
                                }
                            } else {
                                $params['days_of_week_leadgain'] = [$day];
                                $class = 'add';
                            }
                        } else {
                            $params = ['days_of_week_leadgain' => [$day]];
                            $class = 'add';
                        }
                        $order->params_special = json_encode($params, JSON_UNESCAPED_UNICODE);
                        if ($order->update() !== false) {
                            $rsp = ['status' => 'success', 'class' => $class];
                        } else {
                            $rsp = ['status' => 'error', 'message' => 'Ошибка сохранения'];
                        }
                    }
                } else $rsp = ['status' => 'error', 'message' => 'Клиент не найден'];
            }
        } else $rsp = ['status' => 'error', 'message' => 'Нет данных'];
        return $rsp;
    }


    public function actionChangeTime()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['start']) && !empty($_POST['end'])) {
            $user = User::find()
                ->where(['id' => Yii::$app->getUser()->getId()])
                ->select('id')
                ->asArray()
                ->one();
            $start = $_POST['start'];
            $end = $_POST['end'];
            if (!empty($user)) {
                $client = Clients::find()->where(['user_id' => $user['id']])->asArray()->one();
                if (!empty($client)) {
                    $order = Orders::find()
                        ->where(['id' => $_POST['link'], 'client' => $client['id']])
                        ->one();
                    if (!empty($order)) {
                        if (!empty($order->params_special)) {
                            $params = json_decode($order->params_special, true);
                            $params['start_time_leadgain'] = (int)$start;
                            $params['end_time_leadgain'] = (int)$end;
                        } else {
                            $params = ['start_time_leadgain' => (int)$start, 'end_time_leadgain' => (int)$end];
                        }
                        $order->params_special = json_encode($params, JSON_UNESCAPED_UNICODE);
                        if ($order->update() !== false) {
                            $resp = ['status' => 'success', 'message' => 'Изменения сохранены'];
                        } else {
                            $resp = ['status' => 'error', 'message' => 'Ошибка сохранения'];
                        }
                    } else $resp = ['status' => 'error', 'message' => 'Заказ не найден'];
                } else $resp = ['status' => 'error', 'message' => 'Клиент не найден'];
            } else $resp = ['status' => 'error', 'message' => 'Пользователь не найден'];
        }
        return $resp;
    }

    public function actionOrderpage($link)
    {
        $user = User::find()
            ->where(['id' => Yii::$app->getUser()->getId()])
            ->select('budget, id')
            ->asArray()
            ->one();
        if (empty($user)) {
            throw new HttpException(404, "Пользователь не найден");
        }
        $client = Clients::find()->where(['user_id' => $user['id']])->asArray()->one();
        if (!empty($client)) {
            $order = Orders::find()->where(['id' => $link, 'client' => $client['id']])->asArray()->one();
            if (empty($order)) {
                throw new HttpException(404, 'Заказ не найден');
            }

            $filter = ['AND'];
            if (!empty($_GET['tab'])) {
                $tab = $_GET['tab'];

                if ($tab == 'send') {
                    $filter[] = ['=', 'status', Leads::STATUS_SENT];
                }
                if ($tab == 'moderation') {
                    $filter[] = ['AND', ['=', 'status', Leads::STATUS_WASTE], ['=', 'status_confirmed', 0]];
                }
                if ($tab == 'waste') {
                    $filter[] = ['AND', ['=', 'status', Leads::STATUS_WASTE], ['=', 'status_confirmed', 1]];
                }
            }
            if (!empty($_GET['filters'])) {
                $filters = $_GET['filters'];

                if (!empty($filters['first'])) {
                    $filter[] = ['>=', 'date', date('Y-m-d 00:00:00', strtotime($filters['first']))];
                }
                if (!empty($filters['last'])) {
                    $filter[] = ['<=', 'date', date('Y-m-d 23:59:59', strtotime($filters['last']))];
                }
                if (!empty($filters['word'])) {
                    $WordFilter = ['OR',
                        ['like', 'leads.name', '%' . $filters['word'] . '%', false],
                        ['like', 'leads.phone', '%' . $filters['word'] . '%', false],
                        ['like', 'leads.id', '%' . $filters['word'] . '%', false],
                    ];
                }
            }


            $contLead = LeadsSentReport::find()
                ->where(['order_id' => $link, 'client_id' => $client['id']])
                ->count();
            $wasteLead = LeadsSentReport::find()
                ->where(['order_id' => $link, 'client_id' => $client['id']])
                ->andWhere(['status' => Leads::STATUS_WASTE])
                ->count();
            $newLead = LeadsSentReport::find()
                ->where(['order_id' => $link, 'client_id' => $client['id']])
                ->andWhere(['status' => Leads::STATUS_SENT])
                ->count();
            $allLead = LeadsSentReport::find()
                ->where(['order_id' => $link, 'client_id' => $client['id']])
                ->count();
            $leads = LeadsSentReport::find()
                ->where(['order_id' => $link, 'client_id' => $client['id']])
                ->andWhere($filter)
                ->orderBy('date desc');
            $pages = new Pagination(['totalCount' => $leads->count(), 'pageSize' => 25]);
            $models = $leads->offset($pages->offset)
                ->limit($pages->limit)
                ->all();
        } else {
            throw new HttpException(404, 'Клиент не найден');
        }

        return $this->render('orderpage', [
            'order' => $order,
            'user' => $user,
            'leads' => $models,
            'pages' => $pages,
            'contLead' => $contLead,
            'newLead' => $newLead,
            'wordfilter' => $WordFilter,
            'wasteLead' => $wasteLead,
            'allLead' => $allLead,
            'bonuses' => UsersBonuses::findOne(['user_id' => $user['id']]),
        ]);
    }

    public function actionChangeOrders()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = Yii::$app->getUser();
        $orders = Orders::findOne($_POST['order']);
        if (!empty($_POST['order']) && !empty($_POST['hash'])) {
            $hash = $_POST['hash'];
            $order = $_POST['order'];

            $hashOrder = md5("{$user->id}::{$order}::order-hash");

            if ($hash === $hashOrder) {
                if ($orders->status == Orders::STATUS_PROCESSING) {
                    $orders->status = Orders::STATUS_PAUSE;
                } else {
                    $orders->status = Orders::STATUS_PROCESSING;
                }
                $response = ['status' => 'success', 'message' => 'Статус изменен'];
                if ($orders->validate() && $response['status'] == 'success') {
                    if ($orders->update() !== false) {
                        $response = ['status' => 'success', 'message' => 'Статус изменен'];
                    } else {
                        $response = ['status' => 'error', 'message' => 'Ошибка сохранения данных'];
                    }
                } else {
                    $response = ['status' => 'error', 'validation' => [$response, $orders->errors]];
                }
            } else $response = ['status' => 'error', 'message' => 'Такой заказ не найден', 'user' => $user->id];
        } else $response = ['status' => 'error', 'message' => 'Нет данных'];
        return $response;
    }

    public function actionPopupDate()
    {
        if (!empty($_POST['id'])) {
            $popupData = LeadTemplates::find()->where(['id' => $_POST['id']])->asArray()->one();
        }
        return $this->renderPartial('_popup', ['popupdata' => $popupData]);
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

    public function actionTechnology()
    {
        $user = Yii::$app->getUser()->getId();
        $buy = BuyTechnologies::find()->where(['user_id' => $user])->asArray()->select('technologies_id')->all();
        $arr = [];
        if (!empty($buy)){
            foreach ($buy as $k => $i){
                $arr[$k] = $i['technologies_id'];
            }
        }
        $technology = Technologies::find()->asArray()->all();

        $filter = ['AND'];
        if (!empty($_GET['search'])){
            $filter[] = ['OR',
                ['like', 'name', '%'. $_GET['search'] . '%', false],
                ['like', 'preview', '%'. $_GET['search'] . '%', false],
            ];
        }
        $my_technology = Technologies::find()->asArray()->where(['in', 'id', $arr])->andWhere($filter)->all();

        return $this->render('technology', [
            'technology' => $technology,
            'buy' => $arr,
            'my_technology' => $my_technology,
        ]);
    }

    public function actionBuyTechnology()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::findOne(['id' => Yii::$app->getUser()->getId()]);
        $id = $_POST['id'];
        if (empty($user) && empty($id)){
            return $this->redirect('technology');
        }
        $price = Technologies::find()->asArray()->where(['id' => $id])->select('price')->one();
        if (empty($price) || $price['price'] == 0){
            return ['status' => 'error', 'message' => 'Цена ещё не указана'];
        }
        if ($user->budget < $price['price']){
            return ['status' => 'error', 'message' => 'Недостаточно средств на балансе'];
        }
        $user->budget = $user->budget - $price['price'];
        if ($user->update() !== false){
            $model = new BuyTechnologies();
            $model->user_id = $user->id;
            $model->technologies_id = $id;
            $model->sale = 0;
            if ($model->save()){
                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'message' => 'Ошибка сохранения'];
            }
        } else {
            return ['status' => 'error', 'message' => 'Ошибка списания средств'];
        }
    }

    public function actionTechnologyPage($id)
    {
        if (empty($id)){
            return $this->redirect('technology');
        }
        $user = Yii::$app->getUser()->getId();
        $item = Technologies::find()->asArray()->where(['id' => $id])->one();
        $buy = BuyTechnologies::find()->where(['technologies_id' => $id])->andWhere(['user_id' => $user])->one();
        if (empty($item)){
            return $this->redirect('technology');
        }
        return $this->render('technology-page', [
            'item' => $item,
            'buy' => $buy,
        ]);
    }

    public function actionIntegration($order_id = null)
    {
        $user = Yii::$app->getUser()->getId();
        if (!empty($user)) {
            $client = Clients::findOne(['user_id' => $user]);
            if (!empty($client)) {
                $integrations = Integrations::find()->where(['entity' => 'client', 'entity_id' => $client->id])->count();
                if (!empty($order_id)) {
                    $order = Orders::findOne(['client' => $client->id, 'id' => $order_id]);
                    if (empty($order)) {
                        return $this->redirect('integration');
                    } else {
                        $entity = 'order';
                        $entity_id = $order->id;
                    }
                } else {
                    $entity = 'client';
                    $entity_id = $client->id;
                }
                $integration = Integrations::find()
                    ->where(['entity' => $entity, 'entity_id' => $entity_id])
                    ->asArray()
                    ->orderBy('id desc')
                    ->all();
            } else $rsp = ['status' => 'error', 'message' => 'Клиент не найден'];
        } else $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
        $counts = [];
        if (!empty($integration)) {
            foreach ($integration as $k => $i) {
                $counts[] = $i['integration_type'];
            }
        }
        return $this->render('integration',
            [
                'integration' => $integration,
                'current' => $counts,
                'client' => $client,
                'integrations' => $integrations,
            ]);
    }

    public function actionStatis()
    {
        $user = Yii::$app->getUser();
        $client = Clients::find()->where(['user_id' => $user->id])->select('id')->asArray()->one();
        $countOrdersId = Orders::find()->where(['client' => $client['id']])->select(['order_name', 'id', 'category_text'])->asArray()->all();

        if (!empty($client)) {
            /* Статистика */
            $dates = new \DateTime();
            $dates->modify('last day of this month');
            $lastDay = $last_day_this_month = $dates->format('Y-m-d 23:59:59');
            $firstDay = date("Y-m-01 00:00:00");
            $leadsAll = LeadsSentReport::find()
                ->select('DATE(`date`) as `date_lead`, count(1) as `summ`')
                ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
                ->andWhere(['client_id' => $client['id']])
                ->groupBy('date_lead');
            if (!empty($_GET['orderId'])){
                $leadsAll->andWhere(['order_id' => $_GET['orderId']]);
            }
            $leadsAll = $leadsAll->all();
            /* Статистика */
        }

        return $this->render('statis', [
            'client' => $client,
            'leadsAll' => $leadsAll,
            'bonuses' => UsersBonuses::findOne(['user_id' => $user->id]),
            'firstDay' => $firstDay,
            'lastDay' => $lastDay,
            'countOrdersId' => $countOrdersId,
        ]);
    }

    public function actionPopupAucDate()
    {
        if (!empty($_POST['id'])) {
            $user = Yii::$app->user;
            if (!empty($user)) {
                $client = Clients::find()->where(['user_id' => $user->getId()])->select('id')->asArray()->one();
                if (!empty($client)) {
                    $popupData = LeadsSentReport::find()
                        ->where(['id' => $_POST['id']])
                        ->andWhere(['is', 'order_id', null])
                        ->one();
                    if (!empty($popupData)) {
                        $praams = LeadsParams::find()
                            ->where(['category' => $popupData->lead->type])
                            ->select(['type', 'name', 'description'])
                            ->asArray()
                            ->all();
                        $rsp = ['status' => 'success'];
                    } else $rsp = ['status' => 'error', 'message' => 'Такого лида в заказе нет'];
                } else $rsp = ['status' => 'error', 'message' => 'Клиент не найден'];
            } else $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
        } else $rsp = ['status' => 'error', 'message' => 'Нет данных'];
        return $this->renderPartial('_ablead', ['popupdata' => $popupData, 'rsp' => $rsp, 'params' => $praams]);
    }

    public function actionAuction()
    {
        $filter = ['AND'];
        $filterNew = 'date_income asc';
        if (!empty($_GET['filter'])) {
            $post = $_GET['filter'];
            if (!empty($post['sphere'])) {
                $filter[] = ['=', 'type', $post['sphere']];
            }
            if (!empty($post['new'])) {
                $filterNew = 'date_income desc';
            }
        }

        $categories = LeadsCategory::find()->asArray()->select(['name', 'link_name'])->where(['public' => 1])->all();
        $categoryParams = LeadsParams::find()->asArray()->all();
        $client = Clients::findOne(['user_id' => Yii::$app->getUser()->getId()]);
        $lsArr = [];
        if (!empty($client)) {
            $lsp = LeadsSentReport::find()
                ->where(['client_id' => $client->id])
                ->asArray()
                ->select(['lead_id'])
                ->all();
            if (!empty($lsp)) {
                foreach ($lsp as $item)
                    $lsArr[] = $item['lead_id'];
            }
        } else
            return $this->redirect('profile');
        $leads = LeadsSave::find()
            ->where(['>', 'auction_price', 0])
            ->andWhere($filter)
            ->andWhere(['status' => Leads::STATUS_AUCTION])
            ->andWhere(['not in', 'id', $lsArr])
            ->asArray();
        $countQuery = clone $leads;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(10);
        $pages->pageParam = 'leads-page';
        $models = $leads->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy($filterNew)
            ->all();
        if (!empty($client)) {
            $filtersBy = ['AND'];
            if (!empty($_GET['filtersBy'])) {
                $get = $_GET['filtersBy'];
                if (!empty($get['last'])) {
                    $filtersBy[] = ['<=', 'date', date('Y-m-d 23:59:59', strtotime($get['last']))];
                }
                if (!empty($get['first'])) {
                    $filtersBy[] = ['>=', 'date', date('Y-m-d 00:00:00', strtotime($get['first']))];
                }
                if (!empty($get['word'])) {
                    $WordFilter = ['OR',
                        ['like', 'leads.name', '%' . $get['word'] . '%', false],
                        ['like', 'leads.phone', '%' . $get['word'] . '%', false],
                        ['like', 'leads.id', '%' . $get['word'] . '%', false],
                    ];
                }
            }
            $reps = LeadsSentReport::find()
                ->where(['AND', ['client_id' => $client->id], ['is', 'order_id', NULL]])
                ->andWhere($filtersBy);
            $countQuery2 = clone $reps;
            $pages2 = new Pagination(['totalCount' => $countQuery2->count()]);
            $pages2->setPageSize(10);
            $pages2->pageParam = 'avail-page';
            $models2 = $reps->offset($pages2->offset)
                ->limit($pages2->limit)
                ->orderBy('date desc')
                ->all();
        }
        return $this->render('auction', [
            'leads' => $models,
            'reps' => $models2,
            'category' => $categories,
            'params' => $categoryParams,
            'wordfilter' => $WordFilter,
            'pages' => $pages,
            'pages2' => $pages2,
        ]);
    }

    public function actionAuctionBuyLead()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['hash']) && !empty($_POST['id'])) {
            $newHash = md5("{$_POST['id']}::auc-09_buy");
            if ($newHash !== $_POST['hash'])
                return ['status' => 'error', 'title' => 'Ошибка', 'message' => 'Контрольные суммы не совпадают'];
            $uid = Yii::$app->getUser()->getId();
            $user = UserModel::findOne($uid);
            if (empty($user))
                return ['status' => 'error', 'title' => 'Ошибка', 'message' => 'Пользователь не найден'];
            $lead = Leads::findOne($_POST['id']);
            if (empty($lead) || $lead->auction_price === 0)
                return ['status' => 'error', 'title' => 'Ошибка', 'message' => 'Лид не найден'];
            $client = Clients::findOne(['user_id' => $user->id]);
            if (empty($client))
                return ['status' => 'error', 'title' => 'Ошибка', 'message' => "Для попкупки необходимо заполнить <a href='" . Url::to(['profile']) . "'>профиль</a> и данные плательщика"];
            if ($user->budget < $lead->auction_price)
                return ['status' => 'error', 'title' => 'Недостаточно средств', 'message' => "Необходимо пополнить <a href='balance'>баланс</a> для совершения операции"];
            $worker = new Worker($client, $lead);
            $rsp = $worker->processing__new();
            if (isset($rsp['alias_error']))
                return ['status' => 'error', 'title' => 'Ошибка', 'message' => 'Внутренняя ошибка сервера. Пожалуйста, обратитесь в техническую поддержку'];
            else {
                $lead->status = Leads::STATUS_SENT;
                $lead->auction_price = 0;
                $lead->update();
            }
            return ['status' => 'success', 'other' => $rsp];
        } else
            return ['status' => 'error', 'title' => 'Ошибка', 'message' => 'Не указаны обязательные параметры'];
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


    public function actionManual()
    {
        return $this->render('manual');
    }

    public function actionManualauctions()
    {
        return $this->render('manualauctions');
    }

    public function actionManualmain()
    {
        return $this->render('manualmain');
    }

    public function actionManualbalanc()
    {
        return $this->render('manualbalanc');
    }

    public function actionManualprofi()
    {
        return $this->render('manualprofi');
    }

    public function actionManualcatalog()
    {
        return $this->render('manualcatalog');
    }

    public function actionManualpromotion()
    {
        return $this->render('manualpromotion');
    }

    public function actionManualknowledge()
    {
        return $this->render('manualknowledge');
    }

    public function actionManualtechnology()
    {
        return $this->render('manualtechnology');
    }

    public function actionManualstatis()
    {
        return $this->render('manualstatis');
    }

    public function actionOrderLid($template = null)
    {
        $client = Clients::findOne(['user_id' => Yii::$app->getUser()->getId()]);
        $cards = CheckCount::CheckCount($_GET['count']);
        if (empty($template))
            return Yii::$app->response->redirect(Url::to(['order']));
        $t = LeadTemplates::findOne(['link' => $template, 'active' => 1]);
        if (empty($t))
            return Yii::$app->response->redirect(Url::to(['order']));
        return $this->render('order-lid', [
            'template' => $t,
            'client' => $client,
            'cards' => $cards,
        ]);
    }

    public function actionOrderLidAdd()
    {
        $client = Clients::findOne(['user_id' => Yii::$app->getUser()->getId()]);
        $regions = DbRegion::find()->select(['name_with_type'])->asArray()->orderBy('name_with_type asc')->all();
        $cards = CheckCount::CheckCount($_GET['count']);
        return $this->render('order-lid-add', [
            'regions' => $regions,
            'client' => $client,
            'cards' => $cards,
        ]);
    }

    public function actionCreateNewOrderTicket()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['sfera']) || preg_match('/^[а-яё ]++$/ui', $_POST['sfera']) !== 1)
            return ['status' => 'error', 'message' => 'Сфера должна содержать только русские буквы и пробелы'];
        if (empty($_POST['reg']))
            return ['status' => 'error', 'message' => 'Необходимо указать желаемые регионы'];
        if (empty($_POST['lead_count']))
            return ['status' => 'error', 'message' => 'Необходимо указать желаемое количество лидов в заказе'];
        if (empty($_POST['summ-lid']))
            return ['status' => 'error', 'message' => 'Необходимо указать желаемое количество лидов в день'];
        $user_id = Yii::$app->getUser()->getId();
        $user = UserModel::findOne($user_id);
        if (empty($user))
            return ['status' => 'error', 'message' => 'Пользователь не найден'];
        $client = Clients::findOne(['user_id' => $user->id]);
        if (empty($client) || empty($client->company_info) || empty($client->requisites))
            return ['status' => 'error', 'message' => 'Для создания заказа необходимо заполнить профиль'];
        if (!is_array($_POST['reg']))
            return ['status' => 'error', 'message' => 'Некорректно заполнены регионы заказа'];
        if (in_array('Вся Россия', $_POST['reg']))
            $regions = json_encode(['Любой'], JSON_UNESCAPED_UNICODE);
        else
            $regions = json_encode($_POST['reg'], JSON_UNESCAPED_UNICODE);
        if (!empty($_POST['day']) && is_array($_POST['day'])) {
            $props['days_of_week_leadgain'] = $_POST['day'];
        }
        if (!empty($_POST['clock']['start']) && !empty($_POST['clock']['end'])) {
            $props['start_time_leadgain'] = (int)substr($_POST['clock']['start'], 0, -3);
            $props['end_time_leadgain'] = (int)substr($_POST['clock']['end'], 0, -3);
        }
        if (empty($_POST['franchize'])){
            return ['status' => 'error', 'message' => 'Некорректно заполнены навание пакета франшизы'];
        }
        $props['daily_leads_min'] = (int)$_POST['summ-lid'];
        $send = [
            'Orders' => [
                'order_name' => $_POST['sfera'],
                'client' => $client->id,
                'package_id' => $_POST['pack_id'] ?? null,
                'category_link' => "UNDEFINED",
                'category_text' => $_POST['sfera'],
                "status" => Orders::STATUS_MODERATION,
                "price" => 500,
                "leads_count" => (int)$_POST['lead_count'],
                "leads_get" => 0,
                "waste" => 0,
                "regions" => $regions,
                "emails" => $client->email,
                "params_category" => null,
                "date" => date("Y-m-d H:i:s"),
                "date_end" => null,
                "commentary" => Html::encode($_POST['comment']) ?? null,
                "params_special" => json_encode($props, JSON_UNESCAPED_UNICODE)
            ]
        ];
        $peer = DialoguePeer::findOne(['status' => 1, 'user_id' => $user_id]);
        if (empty($peer)){
            $peer = new DialoguePeer();
            $peer->user_id = $user->id;
            $peer->status = 1;
            $peer->type = DialoguePeer::TYPE_ORDER;
            $peer->properties = json_encode($send, JSON_UNESCAPED_UNICODE);
        }

        if ((empty($peer->id) && $peer->save()) || $peer->update() !== false) {
            $message = new DialoguePeerMessages();
            $message->user_id = $user->id;
            $message->peer_id = $peer->id;
            $message->isSupport = 0;
            $text = "<b>Желаемая сфера заказа</b>: {$_POST['sfera']}<br>";
            $text .= "<b>Желаемое количество лидов</b>: {$_POST['lead_count']}<br>";
            $text .= "<b>Желаемое количество лидов в день</b>: {$_POST['summ-lid']}<br>";
            $text .= "<b>Пакет франшизы</b>: {$_POST['franchize']}<br>";
            $text .= "<b>Регионы</b>: " . implode(' ', json_decode($regions, 1)) . "<br>";
            $message->message = $text;
            if ($message->save()) {
                $notice = new UsersNotice();
                $notice->user_id = $user->id;
                $notice->type = UsersNotice::TYPE_MAINPAGE_MODERATION;
                $notice->text = 'Ваш заказ находится на модерации. Вы получите уведомление после его проверки. Подробнее в чате тех. поддержки';
                $notice->save();
                return ['status' => 'success'];
            } else
                return ['status' => 'error', 'message' => 'Ошибка создания заказа. Обратитесь в тех. поддержку'];
        } else {
            return ['status' => 'error', 'message' => 'Ошибка создания заказа. Обратитесь в тех. поддержку'];
        }
    }

    public function actionCreateOrderFromTemplate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['link']) && !empty($_POST['summ-lid']) && !empty($_POST['lead_count'])) {
            $template = LeadTemplates::findOne(['link' => $_POST['link'], 'active' => 1]);
            if (empty($template))
                return ['status' => 'error', 'message' => 'Шаблоне не найден'];
            $client = Clients::findOne(['user_id' => Yii::$app->getUser()->getId()]);
            if (empty($client) || empty($client->requisites) || empty($client->company_info))
                return ['status' => 'error', 'message' => 'Для создания заказа необходимо заполнить профиль'];
            $orders = Orders::find()->where(['AND', ['client' => $client->id], ['status' => Orders::STATUS_MODERATION]])->count();
            if ($orders > 0)
                return ['status' => 'error', 'message' => 'У вас уже есть заказ на модерации. Ожидайте модерации текущего заказа'];
            $new = new Orders();
            $new->order_name = $template->name;
            $new->client = $client->id;
            $new->category_link = $template->category_link;
            $new->category_text = $template->category;
            $new->status = Orders::STATUS_MODERATION;
            $new->price = $template->price;
            $new->leads_count = (int)$_POST['lead_count'];
            $new->leads_get = 0;
            $new->waste = 0;
            $new->regions = $template->regions;
            $new->emails = $client->email;
            $new->params_category = $template->params;
            $new->date = date("Y-m-d H:i:s");
            $new->date_end = null;
            $new->commentary = Html::encode($_POST['comment']) ?? null;
            $props['daily_leads_min'] = (int)$_POST['summ-lid'];
            if (!empty($_POST['day']) && is_array($_POST['day'])) {
                $props['days_of_week_leadgain'] = $_POST['day'];
            }
            if (!empty($_POST['clock']['start']) && !empty($_POST['clock']['end'])) {
                $props['start_time_leadgain'] = (int)substr($_POST['clock']['start'], 0, -3);
                $props['end_time_leadgain'] = (int)substr($_POST['clock']['end'], 0, -3);
            }
            $new->params_special = json_encode($props, JSON_UNESCAPED_UNICODE);
            if (!$new->validate())
                return ['status' => 'error', 'message' => $new->errors];
            else {
                if ($new->save()) {
                    return ['status' => 'success'];
                } else
                    return ['status' => 'error', 'message' => "Ошибка сети. Повторите, пожалуста, попытку позже или свяжитесь с технической поддержкой"];
            }
        } else
            return ['status' => 'error', 'message' => 'Не указаны обязательные параметры'];
    }


    public static function fullInfo($client)
    {
        return !empty($client['f']) && !empty($client['i']) && !empty($client['email']) && !empty($client['company_info']) && !empty($client['requisites']);
    }


    public function actionMyfranchize()
    {
        $user = Yii::$app->getUser()->getId();
        if (empty($user)){
            return $this->redirect('index');
        }
        $buyFranchize = ByFranchize::find()->where(['user_id' => $user])->asArray()->all();
        $arr = [];
        foreach ($buyFranchize as $v){
            $arr[] = $v['package_id'];
        }
        $client = Clients::find()->where(['user_id' => $user])->select('id')->asArray()->one();
        $package = FranchisePackage::find()->where(['in', 'id', $arr])->asArray()->all();
        $myOrders = Orders::find()->where(['client' => $client['id']])->andWhere(['in', 'package_id', $arr])->asArray()->all();
        $idOrders = [];
        foreach ($myOrders as $i){
            $idOrders[] = $i['package_id'];
        }

        return $this->render('myfranchize', [
            'package' => $package,
            'myOrders' => $myOrders,
            'idOrders' => $idOrders,
        ]);
    }

    public function actionWebhookAccept()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $url = $_POST['url'];
        if (!empty($url)) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            $out = curl_exec($curl);
            $code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
            curl_close($curl);
            if ((int)$code === 200)
                $rsp = ['status' => 'success', 'message' => $code];
            else
                $rsp = ['status' => 'error', 'message' => "Возвращаемый код HTTP - " . $code . "<br> Требуемый код - 200"];
        } else
            $rsp = ['status' => 'error', 'message' => 'Укажите URL вебхука'];
        return $rsp;
    }

    public function actionOauth()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['server'])) {
            do {
                if (empty($_POST['client_id'])) {
                    $response = ['status' => 'error', 'message' => 'Не указан идентификатор интеграции'];
                    break;
                }
                if (empty($_POST['client_secret'])) {
                    $response = ['status' => 'error', 'message' => 'Не указан секретный ключ'];
                    break;
                }
                if (empty($_POST['code'])) {
                    $response = ['status' => 'error', 'message' => 'Не указан код авторизации OAuth'];
                    break;
                }
                $server = $_POST['server'];
                $link = "https://{$server}/oauth2/access_token";
                $data = [
                    'client_id' => $_POST['client_id'],
                    'client_secret' => $_POST['client_secret'],
                    'code' => $_POST['code'],
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => 'https://myforce.ru',
                ];
                $amo = new Admin('integrations');
                $amoRsp = $amo->curlAMO($link, $data);
                $code = $amoRsp['code'];
                $out = $amoRsp['out'];
                $code = (int)$code;
                $errors = [
                    400 => 'В отправляемых данных содержится ошибка либо код авторизации уже был использован',
                    401 => 'Ошибка авторизации',
                    402 => 'Аккаунт требует оплаты для работы с API',
                    403 => 'Доступ запрещен или аккаунт заблокирован',
                    404 => 'Страница не найдена',
                    500 => 'Внутренняя ошибка сервиса AmoCRM',
                    502 => 'Apache не смог обработать запрос',
                    503 => 'Сервис не доступен',
                ];
                try {
                    if ($code < 200 || $code > 204) {
                        $response = ['status' => 'error', 'message' => isset($errors[$code]) ? $errors[$code] : 'Неизвестная ошибка', $code];
                        break;
                    }
                } catch (\Exception $e) {
                    $response = ['status' => 'error', 'message' => 'Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode()];
                    break;
                }
                $responseTokens = json_decode($out, true);
                $responseTokens['expires_in'] = time() + (int)$responseTokens['expires_in'];
                $response = [
                    'status' => 'success',
                    'data' => $responseTokens
                ];
                $_SESSION['amoTOKENS'] = ['raw' => array_merge($data, ['server' => $server]), 'response' => $responseTokens];
            } while (false);
        } else
            $response = ['status' => 'error', 'message' => 'Сервер не указан'];
        return $response;
    }

    public function actionAmoGetInfo()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['server']) && !empty($_POST['access_token'])) {
            $not_support = [
                'legal_entity',
                'date_time',
                'birthday',
                'streetaddress',
                'smart_address',
                'date',
                'url',
            ];
            $page = 1;
            $contactsFields = [
                /*'name' => [
                    'name' => 'Название контакта',
                    'type' => 'text',
                    'enums' => null
                ],*/
                'responsible_user_id' => [
                    'name' => 'Ответственный пользователь (ID)',
                    'type' => 'int',
                    'enums' => null
                ],
            ];
            $leadsFields = [
                /*'name' => [
                    'name' => 'Название сделки',
                    'type' => 'text',
                    'enums' => null
                ],*/
                'responsible_user_id' => [
                    'name' => 'Ответственный пользователь (ID)',
                    'type' => 'int',
                    'enums' => null
                ],
                'status_id' => [
                    'name' => 'Статус сделки (ID)',
                    'type' => 'int',
                    'enums' => null
                ],
                'pipeline_id' => [
                    'name' => 'Воронка (ID)',
                    'type' => 'int',
                    'enums' => null
                ]
            ];
            $subdomain = $_POST['server'];
            $link = 'https://' . $subdomain . '/api/v4/contacts/custom_fields?page=' . $page;
            $access_token = $_POST['access_token'];
            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $access_token
            ];
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            $out = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($out, 1);
            if (!empty($response['_embedded']['custom_fields'])) {
                $count = $response['_page_count'];
                foreach ($response['_embedded']['custom_fields'] as $item) {
                    if (in_array($item['type'], $not_support))
                        continue;
                    $contactsFields[$item['id']] = [
                        'name' => $item['name'],
                        'type' => $item['type'],
                        'enums' => $item['enums']
                    ];
                }
                if ($count !== $page) {
                    while ($count >= $page) {
                        $page++;
                        $link = 'https://' . $subdomain . '/api/v4/contacts/custom_fields?page=' . $page;
                        usleep(334000);
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
                        curl_setopt($curl, CURLOPT_URL, $link);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($curl, CURLOPT_HEADER, false);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                        $out = curl_exec($curl);
                        curl_close($curl);
                        $response = json_decode($out, 1);
                        if (!empty($response['_embedded']['custom_fields'])) {
                            $count = $response['_page_count'];
                            foreach ($response['_embedded']['custom_fields'] as $item) {
                                if (in_array($item['type'], $not_support))
                                    continue;
                                $contactsFields[$item['id']] = [
                                    'name' => $item['name'],
                                    'type' => $item['type'],
                                    'enums' => $item['enums']
                                ];
                            }
                        }
                    }
                }
            }
            usleep(334000);
            $page = 1;
            $link = 'https://' . $subdomain . '/api/v4/leads/custom_fields?page=' . $page;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            $out = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($out, 1);
            if (!empty($response['_embedded']['custom_fields'])) {
                $count = $response['_page_count'];
                foreach ($response['_embedded']['custom_fields'] as $item) {
                    if (in_array($item['type'], $not_support))
                        continue;
                    $leadsFields[$item['id']] = [
                        'name' => $item['name'],
                        'type' => $item['type'],
                        'enums' => $item['enums']
                    ];
                }
                if ($count !== $page) {
                    while ($count >= $page) {
                        $page++;
                        $link = 'https://' . $subdomain . '/api/v4/leads/custom_fields?page=' . $page;
                        usleep(334000);
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
                        curl_setopt($curl, CURLOPT_URL, $link);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($curl, CURLOPT_HEADER, false);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                        $out = curl_exec($curl);
                        curl_close($curl);
                        $response = json_decode($out, 1);
                        if (!empty($response['_embedded']['custom_fields'])) {
                            $count = $response['_page_count'];
                            foreach ($response['_embedded']['custom_fields'] as $item) {
                                if (in_array($item['type'], $not_support))
                                    continue;
                                $leadsFields[$item['id']] = [
                                    'name' => $item['name'],
                                    'type' => $item['type'],
                                    'enums' => $item['enums']
                                ];
                            }
                        }
                    }
                }
            }
            $link = 'https://' . $subdomain . '/api/v4/leads/pipelines';
            usleep(334000);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            $out = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($out, 1);
            if (!empty($response['_embedded']['pipelines'])) {
                foreach ($response['_embedded']['pipelines'] as $item) {
                    $pipelines[$item['id']] = [
                        'name' => $item['name'],
                        'statuses' => $item['_embedded']['statuses']
                    ];
                }
            }
            $link = 'https://' . $subdomain . '/api/v4/users';
            usleep(334000);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            $out = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($out, 1);
            if (!empty($response['_embedded']['users'])) {
                foreach ($response['_embedded']['users'] as $item) {
                    $users[$item['id']] = [
                        'name' => $item['name'],
                    ];
                }
            }
            $responseArray = [
                'status' => 'success',
                'data' => [
                    'contacts' => $contactsFields,
                    'leads' => $leadsFields,
                    'pipelines' => $pipelines ?? null,
                    'users' => $users ?? null,
                ],
            ];
        } else
            $responseArray = ['status' => 'error', 'message' => 'Не указан сервер или ключ аутентификации.'];
        return $responseArray;
    }

    public function actionCreateIntegration()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['type_integration'])) {
            $user = Yii::$app->getUser()->getId();
            if (!empty($user)) {
                $client = Clients::findOne(['user_id' => $user]);
                if (!empty($client)) {
                    if (!empty($_POST['order_id'])) {
                        $order = Orders::findOne(['client' => $client->id, 'id' => $_POST['order_id']]);
                        if (!empty($order)) {
                            $entity = 'order';
                            $entity_id = $_POST['order_id'];
                        } else $rsp = ['status' => 'error', 'message' => 'Заказ не найден'];
                    } else {
                        $entity = 'client';
                        $entity_id = $client->id;
                    }
                    switch ($_POST['type_integration']) {
                        case 'webhook':
                            $func = $this::webhookCheck();
                            break;
                        case 'bitrix':
                            $func = $this::bitrixCheck();
                            break;
                        case 'Amo':
                            $func = $this::amoCheck();
                            break;
                    }
                    if (empty($func['rsp'])) {
                        $integrations = Integrations::find()->where(['entity' => $entity, 'entity_id' => $entity_id, 'integration_type' => $func['type']])->one();
                        if (!empty($integrations)) {
                            $integrations->entity_id = $entity_id;
                            $integrations->entity = $entity;
                            $integrations->integration_type = $func['type'];
                            $integrations->config = $func['config'];
                            $integrations->validate();
                            if ($integrations->update() !== false) {
                                $rsp = ['status' => 'success'];
                            } else $rsp = ['status' => 'error', 'message' => 'Ошибка на сервере'];
                        } else {
                            $model = new Integrations();
                            $model->entity_id = $entity_id;
                            $model->entity = $entity;
                            $model->integration_type = $func['type'];
                            $model->config = $func['config'];
                            $model->validate();
                            if ($model->save()) {
                                $rsp = ['status' => 'success'];
                            } else $rsp = ['status' => 'error', 'message' => 'Ошибка на сервере'];
                        }
                    } else $rsp = $func['rsp'];
                } else $rsp = ['status' => 'error', 'message' => 'Клиент не найден'];
            } else $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
        } else $rsp = ['status' => 'error', 'message' => 'Нет данных'];
        return $rsp;
    }

    public static function webhookCheck()
    {
        $type = $_POST['type_integration'];
        if (!empty($_POST['webhook_url'])) {
            $url = $_POST['webhook_url'];
            $config = json_encode(['WEBHOOK_URL' => $url], JSON_UNESCAPED_UNICODE);
        } else $rsp = ['status' => 'error', 'message' => 'Укажите URL вебхука'];
        return ['rsp' => $rsp, 'config' => $config, 'type' => $type];
    }

    public static function bitrixCheck()
    {
        $type = $_POST['type_integration'];
        if (!empty($_POST['params'])) {
            $params = json_decode($_POST['params'], true);
            foreach ($params as $k => $v) {
                if ($k === 'WEBHOOK_URL') {
                    $config = json_encode($params, JSON_UNESCAPED_UNICODE);
                }
            }
        } else $rsp = ['status' => 'error', 'message' => 'Нет параметров'];
        return ['rsp' => $rsp, 'config' => $config, 'type' => $type];
    }

    public static function amoCheck()
    {
        $type = $_POST['type_integration'];
        if (!empty($_POST['config'])) {
            $params = json_decode($_POST['config'], true);
            if (!empty($params['config']['access_token']) && !empty($params['config']['refresh_token']) && !empty($params['config']['expires_in']) && !empty($params['config']['server']) && !empty($params['config']['client_secret']) && !empty($params['config']['client_id'])) {
                $config = json_encode($params, JSON_UNESCAPED_UNICODE);
            } else $rsp = ['status' => 'error', 'message' => 'Нет обязательных параметров'];
        } else $rsp = ['status' => 'error', 'message' => 'Нет параметров'];
        return ['rsp' => $rsp, 'config' => $config, 'type' => $type];
    }

    public function actionUpdateWebhookIntegration($order_id = null)
    {
        $user = Yii::$app->getUser()->getId();
        if (!empty($user)) {
            $client = Clients::findOne(['user_id' => $user]);
            if (!empty($client)) {
                if (!empty($order_id)) {
                    $order = Orders::findOne(['client' => $client->id, 'id' => $order_id]);
                    if (empty($order)) {
                        $rsp = ['status' => 'error', 'message' => 'Заказ не найден'];
                    } else {
                        $entity = 'order';
                        $entity_id = $order->id;
                    }
                } else {
                    $entity = 'client';
                    $entity_id = $client->id;
                }
                $integration = Integrations::find()
                    ->where(['entity' => $entity, 'entity_id' => $entity_id, 'integration_type' => 'webhook'])
                    ->asArray()
                    ->one();
            } else $rsp = ['status' => 'error', 'message' => 'Клиент не найден'];
        } else $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
        return $this->render('update-webhook-integration', ['integer' => $integration]);
    }

    public function actionUpdateBitrixIntegration($order_id = null)
    {
        $user = Yii::$app->getUser()->getId();
        if (!empty($user)) {
            $client = Clients::findOne(['user_id' => $user]);
            if (!empty($client)) {
                if (!empty($order_id)) {
                    $order = Orders::findOne(['client' => $client->id, 'id' => $order_id]);
                    if (empty($order)) {
                        $rsp = ['status' => 'error', 'message' => 'Заказ не найден'];
                    } else {
                        $entity = 'order';
                        $entity_id = $order->id;
                    }
                } else {
                    $entity = 'client';
                    $entity_id = $client->id;
                }
                $integration = Integrations::find()
                    ->where(['entity' => $entity, 'entity_id' => $entity_id, 'integration_type' => 'bitrix'])
                    ->asArray()
                    ->one();
            } else $rsp = ['status' => 'error', 'message' => 'Клиент не найден'];
        } else $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
        return $this->render('update-bitrix-integration', ['integer' => $integration]);
    }

    public function actionUpdateAmoIntegration($order_id = null)
    {
        $user = Yii::$app->getUser()->getId();
        if (!empty($user)) {
            $client = Clients::findOne(['user_id' => $user]);
            if (!empty($client)) {
                if (!empty($order_id)) {
                    $order = Orders::findOne(['client' => $client->id, 'id' => $order_id]);
                    if (empty($order)) {
                        $rsp = ['status' => 'error', 'message' => 'Заказ не найден'];
                    } else {
                        $entity = 'order';
                        $entity_id = $order->id;
                    }
                } else {
                    $entity = 'client';
                    $entity_id = $client->id;
                }
                $integration = Integrations::find()
                    ->where(['entity' => $entity, 'entity_id' => $entity_id, 'integration_type' => 'amo'])
                    ->asArray()
                    ->one();
            } else $rsp = ['status' => 'error', 'message' => 'Клиент не найден'];
        } else $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
        return $this->render('update-amo-integration', ['integer' => $integration]);
    }

    public function actionDeleteIntegration()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['id']) && isset($_POST['order_id'])) {
            $order_id = $_POST['order_id'];
            $user = Yii::$app->getUser()->getId();
            if (!empty($user)) {
                $client = Clients::findOne(['user_id' => $user]);
                if (!empty($client)) {
                    if (!empty($order_id)) {
                        $order = Orders::findOne(['client' => $client->id, 'id' => $order_id]);
                        if (empty($order)) {
                            $rsp = ['status' => 'error', 'message' => 'Заказ не найден'];
                        } else {
                            $entity = 'order';
                            $entity_id = $order->id;
                        }
                    } else {
                        $entity = 'client';
                        $entity_id = $client->id;
                    }
                    $integration = Integrations::findOne(['id' => $_POST['id'], 'entity' => $entity, 'entity_id' => $entity_id]);
                    if ($integration->delete() !== false) {
                        $rsp = ['status' => 'success'];
                    } else $rsp = ['status' => 'error', 'message' => 'Ошибка сохранения'];
                } else $rsp = ['status' => 'error', 'message' => 'Клиент не найден'];
            } else $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
        } else $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
        return $rsp;
    }
}
