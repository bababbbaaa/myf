<?php

namespace user\modules\lead_force\controllers;

use admin\models\ProvidersUtms;
use common\models\BudgetLog;
use common\models\CdbArticle;
use common\models\CdbCategory;
use common\models\CdbSubcategory;
use common\models\Clients;
use common\models\DbRegion;
use common\models\DialoguePeer;
use common\models\DialoguePeerMessages;
use common\models\disk\Cloud;
use common\models\helpers\Robokassa;
use common\models\Integrations;
use common\models\Leads;
use common\models\LeadsCategory;
use common\models\LeadsParams;
use common\models\LeadsSave;
use common\models\LeadsSentReport;
use common\models\LeadTemplates;
use common\models\LeadTypes;
use common\models\Offers;
use common\models\OffersAlias;
use common\models\Orders;
use common\models\Providers;
use common\models\User;
use common\models\UserModel;
use common\models\UsersBills;
use common\models\UsersBonuses;
use common\models\UsersCertificates;
use common\models\UsersNotice;
use common\models\UsersProperties;
use common\models\UsersProviderUploads;
use common\models\UsersProviderUploadsSigned;
use common\models\Worker;
use DateInterval;
use DatePeriod;
use DateTime;
use PhpOffice\PhpWord\TemplateProcessor;
use user\controllers\PermissionController;
use Yii;
use yii\data\Pagination;
use yii\db\Expression;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Site controller
 */
class ProviderController extends PermissionController
{
//    /**
//     * {@inheritdoc}
//     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'rules' => [
//                    [
//                        'actions' => ['login', 'error'],
//                        'allow' => true,
//                    ],
//                    [
//                        'actions' => ['logout', 'index'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }

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
    public function actionReferal() {
        $provider = Providers::findOne(['user_id' => Yii::$app->getUser()->getId()]);
        return $this->render('referal', ['provider' => $provider]);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $user = Yii::$app->user;
        $client = Providers::find()->where(['user_id' => $user->getId()])->asArray()->one();
        $user_info = User::find()->where(['id' => $user->getId()])->asArray()->one();
        $budget_log = BudgetLog::find()->where(['user_id' => $user->getId()])->asArray()->limit(5)->orderBy('id desc')->all();
        $notice = UsersNotice::find()->where(['user_id' => $user->getId(), 'active' => 1])->orderBy('date desc')->all();
        /* Статистика */
        $interval = 7;
        $firstDay = date("Y-m-d 00:00:00", time() - 3600 * 24 * $interval);
        $lastDay = date('Y-m-d 23:59:59');
        $start = new DateTime($firstDay);
        $interval = new DateInterval('P1D');
        $end = new DateTime($lastDay);
        $period = new DatePeriod($start, $interval, $end);
        ##общая стата
        $stats = OffersAlias::find() # это все лиды
        ->select('DATE(`date`) as `date_lead`, count(1) as `summ`')
            ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
            ->andWhere(['provider_id' => $client['id']])
            ->groupBy('date_lead')
            ->all();
        $confirmed = LeadsSentReport::find() # это подтвержденные лиды
        ->select('DATE(`date`) as `date_lead`, count(1) as `summ`, status')
            ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
            ->andWhere(['provider_id' => $client['id']])
            ->andWhere(['status' => Leads::STATUS_CONFIRMED])
            ->groupBy('date_lead')
            ->all();
        $waste = LeadsSentReport::find() # это брак
        ->select('DATE(`date`) as `date_lead`, count(1) as `summ`, status')
            ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
            ->andWhere(['provider_id' => $client['id']])
            ->andWhere(['AND', ['status' => Leads::STATUS_WASTE], ['status_confirmed' => 1]])
            ->groupBy('date_lead')
            ->all();
        ##общая стата
        /* Статистика */

        return $this->render('index', [
            'client' => $client,
            'user_info' => $user_info,
            'budget_log' => $budget_log,
            'notice' => $notice,
            'stats' => $stats,
            'stats2' => $confirmed,
            'stats3' => $waste,
            'date' => $period,
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

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }
    public function actionUsermanualprofile()
    {
        return $this->render('usermanualprofile');
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
                return ['status' => 'error', 'title' => 'Ошибка', 'message' => "Для попкупки необходимо заполнить <a href='" . Url::to(['prof']) . "'>профиль</a> и данные плательщика"];
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
    public function actionOrder()
    {
        $filter = ['AND'];
        if (!empty($_GET['filter'])) {
            $filterGet = $_GET['filter'];
            if (!empty($filterGet['sphere'])) {
                $filter[] = ['=', 'category', $filterGet['sphere']];
            }
            # новые заказы
            if (!empty($filterGet['price'])) {
                $filter[] = ['>=', 'price', 500];
            }
            # новые заказы
            # регионы
            if (!empty($filterGet['region'])) {
                if ($filterGet['region'] == 'Любой'){
                    $filter[] = '';
                } else{
                    $filter[] = ['like', 'regions', "%{$filterGet['region']}%", false];
                }
            }
            # регионы

        }

        $clients = Providers::findOne(['user_id' => Yii::$app->getUser()->getId()]);
        $region = LeadTypes::find()->where(['active' => 1])->select('regions')->asArray()->distinct()->all();
        $category = LeadTypes::find()
            ->where(['active' => 1])
            ->select(['category'])
            ->distinct()
            ->asArray()
            ->all();

        $offers = Offers::find()->where(['provider_id' => $clients->id])->select('offer_id')->asArray()->all();
        $offers_id = [];
        foreach ($offers as $k => $v){
            if (empty($v['offer_id']))
                continue;
            $offers_id[] = $v['offer_id'];
        }

        $templates = LeadTypes::find()
            ->where(['active' => 1])
            ->andWhere($filter)
            ->andWhere(['not in', 'id', $offers_id]);
        
        $countQuery = clone $templates;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(10);
        $pages->pageParam = 'template-page';
        $models = $templates->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy('hot desc')
            ->asArray()
            ->all();

        return $this->render('order', [
            'templates' => $models,
            'pages' => $pages,
            'category' => $category,
            'clients' => $clients,
            'region' => $region
        ]);
    }
    public function actionPopupDate()
    {
        if (!empty($_POST['id'])) {
            $popupData = LeadTemplates::find()->where(['id' => $_POST['id']])->asArray()->one();
        }
        return $this->renderPartial('_popup', ['popupdata' => $popupData]);
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
    public function actionGetProviderDocs() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['type']) && !empty($_POST['link']) && !empty($_POST['hash'])) {
            $provider__report = $_FILES['provider_report'];
            $user = UserModel::findOne(Yii::$app->getUser()->getId());
            if (empty($user))
                return ['status' => 'error', 'message' => 'Пользователь не найден'];
            if ((!empty($_POST['DonateAmount']) && $user->budget < $_POST['DonateAmount']) || (!empty($_POST['DonateAmount2']) && $user->budget < $_POST['DonateAmount2']))
                return ['status' => 'error', 'message' => 'Баланс пользователя ниже, чем сумма вывода'];
            if ((!empty($_POST['DonateAmount']) && $_POST['DonateAmount'] < 10000)  || (!empty($_POST['DonateAmount2']) && $_POST['DonateAmount2'] < 10000))
                return ['status' => 'error', 'message' => 'Нельзя вывести менее 10 000 рублей'];
            if (!empty($_POST['hashForm']) && $_POST['hashForm'] !== md5("{$_POST['DonateAmount']}::b5e33"))
                return ['status' => 'error', 'message' => 'Ошибка контрольной суммы'];
            $val = !empty($_POST['DonateAmount']) ? $_POST['DonateAmount'] : $_POST['DonateAmount2'];
            $newSign = new UsersProviderUploadsSigned();
            $newSign->user_id = $user->id;
            $newSign->type = $_POST['type'];
            $newSign->status = 0;
            $newSign->value = round((float)$val, 0);
            $newSign->upload_id = (int)$_POST['link'];
            $newSign->date_exp = date("Y-m-d H:i:s", time() + 3600*24*5);
            $cloud = new Cloud($user->id);
            if ($provider__report['error'] === UPLOAD_ERR_OK) {
                $newHash = md5('/lead-force/provider/get-locale-file?type=report&id=' . $_POST['link'] . "::j43d7io5");
                if ($_POST['hash'][0] !== $newHash) {
                    return ['status' => 'error', 'message' => 'Файл не найден'];
                } else {
                    $report__file = $cloud->validate__and__save($provider__report, 'provider_report_signed');
                    if (isset($report__file['error']))
                        return $report__file;
                    else {
                        $newSign->link_report = $report__file['download'];
                    }
                }
            }
            if ($_POST['type'] === 'jur') {
                $outcome_bill = $_FILES['provider_outcome'];
                if ($outcome_bill['error'] === UPLOAD_ERR_OK) {
                    $newHash2 = md5('/lead-force/provider/get-locale-file?type=outcome&id=' . $_POST['link'] . "::j43d7io5");
                    if ($_POST['hash'][1] !== $newHash2) {
                        return ['status' => 'error', 'message' => 'Файл не найден'];
                    } else {
                        $report__file = $cloud->validate__and__save($outcome_bill, 'provider_outcome_signed');
                        if (isset($report__file['error']))
                            return $report__file;
                        else {
                            $newSign->link_bill = $report__file['download'];
                        }
                    }
                }
            }
            if (($_POST['type'] === 'fiz' && !empty($newSign->link_report)) || ($_POST['type'] === 'jur' && !empty($newSign->link_report) && !empty($newSign->link_bill))) {
                if ($newSign->save()) {
                    $findUpload = UsersProviderUploads::findOne(['type' => $_POST['type'], 'id' => $_POST['link']]);
                    if (!empty($findUpload)) {
                        $findUpload->status = 1;
                        $findUpload->update();
                    }
                    return ['status' => 'success', 'message' => '<div class="inner-response-popup-text"><p>Ваши данные сейчас на модерации. Пожалуйста, подождите. </p><p>После модерации вы сможете получить средства на указанные реквизиты в течение 5 дней</p></div>'];
                }
            } else {
                return ['status' => 'success', 'message' => '<div class="inner-response-popup-text"><p>Вы запросили вывод средств, однако, не загрузили необходимые документы для совершения процедуры.</p> <p>Для продолжения процедуры вам необходимо загрузить документы в течение 5 дней.</p> <p>Шаблоны документов можно найти во вкладке "Необходимо загрузить"</p></div>'];
            }
        }
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
           /* $filters[] = ['>=', 'date', $firstDay];
            $filters[] = ['<=', 'date', $lastDay];*/
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
        $bills = UsersProviderUploadsSigned::find()
            ->where(['user_id' => $user->id, 'status' => 1, 'type' => 'jur'])
            ->andWhere($filt)
            ->asArray();
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
        /* фильтр отчетов */
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
        /* фильтр отчетов */
        $acts = UsersProviderUploadsSigned::find()
            ->where(['user_id' => $user->id, 'status' => 1])
            ->andWhere($filtAct)
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

        #надо загрузить
        /* фильтр аплоад */
        $filtUpload = ['AND'];
        if (!empty($_GET['filtUpl'])) {
            $dateUpl = $_GET['filtUpl'];
            if (!empty($dateUpl['first'])) {
                $filtUpload[] = ['>=', 'date', date('Y-m-d 00:00:00', strtotime($dateUpl['first']))];
            }
            if (!empty($dateUpl['last'])) {
                $filtUpload[] = ['<=', 'date', date('Y-m-d 23:59:59', strtotime($dateUpl['last']))];
            }
        } else {
            $filtUpload[] = ['>=', 'date', $firstDay];
            $filtUpload[] = ['<=', 'date', $lastDay];
        }
        /* фильтр аплоад */
        $upl = UsersProviderUploads::find()
            ->where(['user_id' => $user->id, 'status' => 0])
            ->andWhere($filtUpload)
            ->asArray();
        $countQueryUpl = clone $upl;
        $pagesUpl = new Pagination(['totalCount' => $countQueryUpl->count()]);
        $pagesUpl->setPageSize(10);
        $pagesUpl->pageParam = 'upl-page';
        $modelsUpl = $upl->offset($pagesUpl->offset)
            ->limit($pagesUpl->limit)
            ->orderBy('date desc')
            ->all();
        #надо загрузить

        #статистика
        $expression = "(date >= '{$firstDay}') AND (date <= '{$lastDay}') AND (user_id={$user->id}) AND id IN (SELECT MAX(id) FROM budget_log GROUP BY DATE(date))";
        $stats = BudgetLog::find()
            ->where(new Expression($expression))
            ->asArray()
            ->orderBy('date asc')
            ->all();
        #статистика

        $client = Providers::find()->where(['user_id' => $user->id])->asArray()->one();
        return $this->render('balance',
            [
                'user' => $user,
                'balance' => $models,
                'pages' => $pages,
                'pagesBills' => $pagesBills,
                'pagesActs' => $pagesActs,
                'pagesUpl' => $pagesUpl,
                'real_user' => $realUser,
                'client' => $client,
                'bills' => $modelsBills,
                'acts' => $modelsActs,
                'stats' => $stats,
                'upl' => $modelsUpl,
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
                            'shp' => ['Shp_description' => "Пополнение баланса личного кабинета", 'Shp_user' => $user->id, 'Shp_redirect' => "https://user.myforce.ru/lead-force/client/balance"]
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
    public function actionCreateProviderFiles() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['value']) && !empty($_POST['type'])) {
            $user = Yii::$app->getUser()->getId();
            $usrModel = UserModel::findOne($user);
            if ($_POST['value'] < 10000)
                return ['status' => 'error', 'message' => 'Сумма для вывода меньше 10 000 рублей'];
            if (empty($usrModel) || $_POST['value'] > $usrModel->budget)
                return ['status' => 'error', 'message' => 'Баланс не может быть ниже, чем сумма вывода'];
            $cloud = new Cloud($user);
            $files = $cloud->create__provider__files(['type' => $_POST['type'], 'value' => $_POST['value']]);
            if ($files['status'] === 'error')
                return $files;
            $providerFiles = new UsersProviderUploads();
            $providerFiles->user_id = $user;
            $providerFiles->type = $_POST['type'];
            $providerFiles->link_report = $files['download_report'];
            $providerFiles->link_bill = $files['download_outcome'] ?? null;
            $providerFiles->value = round((float)$_POST['value'], 0);
            $providerFiles->status = 0;
            $providerFiles->date_exp = date("Y-m-d H:i:s", time() + 3600 * 24 * 5);
            if ($providerFiles->save()) {
                if ($providerFiles->type === 'fiz') {
                    $hash = md5('/lead-force/provider/get-locale-file?type=report&id=' . $providerFiles->id . "::j43d7io5");
                    return ['status' => 'success', 'download' => '/lead-force/provider/get-locale-file?type=report&id=' . $providerFiles->id, 'id' => $providerFiles->id, 'hash' => $hash];
                }
                else {
                    $hash1 = md5('/lead-force/provider/get-locale-file?type=report&id=' . $providerFiles->id . "::j43d7io5");
                    $hash2 = md5('/lead-force/provider/get-locale-file?type=outcome&id=' . $providerFiles->id . "::j43d7io5");
                    return ['status' => 'success', 'download_report' => '/lead-force/provider/get-locale-file?type=report&id=' . $providerFiles->id , 'download_outcome' => '/lead-force/provider/get-locale-file?type=outcome&id=' . $providerFiles->id, 'id' => $providerFiles->id, 'hash' => [$hash1, $hash2]];
                }
            } else
                return ['status' => 'error', 'message' => 'Ошибка сохранения файлов'];
        } else
            return ['status' => 'error', 'message' => 'Сумма не определена'];
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
                        return Yii::$app->response->redirect(['/lead-force/client/index']);
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
                case 'report':
                    $act = UsersProviderUploads::findOne(['user_id' => $user->id, 'id' => $id]);
                    if (!empty($act)) {
                        if (ob_get_length())
                            ob_end_clean();
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="' . basename($act->link_report) . '"');
                        header('Content-Transfer-Encoding: binary');
                        header('Connection: Keep-Alive');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize(Cloud::WEB_PATH . $act->link_report));
                        if ($fd = fopen(Cloud::WEB_PATH . $act->link_report, 'rb')) {
                            while (!feof($fd)) {
                                print fread($fd, 1024);
                            }
                            fclose($fd);
                        }
                        exit;
                    } else
                        return Yii::$app->response->redirect(['/lead-force/provider/index']);
                case 'outcome':
                    $act = UsersProviderUploads::findOne(['user_id' => $user->id, 'id' => $id]);
                    if (!empty($act)) {
                        if (ob_get_length())
                            ob_end_clean();
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename="' . basename($act->link_bill) . '"');
                        header('Content-Transfer-Encoding: binary');
                        header('Connection: Keep-Alive');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize(Cloud::WEB_PATH . $act->link_bill));
                        if ($fd = fopen(Cloud::WEB_PATH . $act->link_bill, 'rb')) {
                            while (!feof($fd)) {
                                print fread($fd, 1024);
                            }
                            fclose($fd);
                        }
                        exit;
                    } else
                        return Yii::$app->response->redirect(['/lead-force/provider/index']);
                case 'report_signed':
                    $act = UsersProviderUploadsSigned::findOne(['user_id' => $user->id, 'id' => $id]);
                    if (!empty($act)) {
                        $path = pathinfo($act->link_report);
                        if (ob_get_length())
                            ob_end_clean();
                        header('Content-Description: File Transfer');
                        header('Content-Type: ' . Cloud::$mimes[$path['extension']]);
                        header('Content-Disposition: attachment; filename="' . basename($act->link_report) . '"');
                        header('Content-Transfer-Encoding: binary');
                        header('Connection: Keep-Alive');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize(Cloud::WEB_PATH . $act->link_report));
                        if ($fd = fopen(Cloud::WEB_PATH . $act->link_report, 'rb')) {
                            while (!feof($fd)) {
                                print fread($fd, 1024);
                            }
                            fclose($fd);
                        }
                        exit;
                    } else
                        return Yii::$app->response->redirect(['/lead-force/provider/index']);
                case 'outcome_signed':
                    $act = UsersProviderUploadsSigned::findOne(['user_id' => $user->id, 'id' => $id]);
                    if (!empty($act)) {
                        $path = pathinfo($act->link_bill);
                        if (ob_get_length())
                            ob_end_clean();
                        header('Content-Description: File Transfer');
                        header('Content-Type: ' . Cloud::$mimes[$path['extension']]);
                        header('Content-Disposition: attachment; filename="' . basename($act->link_bill) . '"');
                        header('Content-Transfer-Encoding: binary');
                        header('Connection: Keep-Alive');
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize(Cloud::WEB_PATH . $act->link_bill));
                        if ($fd = fopen(Cloud::WEB_PATH . $act->link_bill, 'rb')) {
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
    public function actionMyorders()
    {

        $user = Yii::$app->getUser();
        $client = Providers::find()->where(['user_id' => $user->id])->select('id')->asArray()->one();
        $sphere = LeadsCategory::find()->asArray()->all();
        $activeNew = ['status' => 'исполняется'];
        $countOrders = Offers::find()->where(['provider_id' => $client['id']])->count();
        $notice = UsersNotice::find()->where(['user_id' => $user->getId(), 'active' => 1])->orderBy('date desc')->all();

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
                ->groupBy('date_lead')
                ->all();
            /* Статистика */

            /* активные заказы */
            # фильтр заказов
            $activeFilter = ['AND'];
            if (!empty($_GET['activeFilter'])) {
                $activeGet = $_GET['activeFilter'];
                if (!empty($activeGet['status'])) {
                    $activeFilter[] = ['=', 'status', $activeGet['status']];
                } else {
                    $activeFilter[] = ['OR', ['status' => Orders::STATUS_PROCESSING], ['status' => Orders::STATUS_PAUSE]];
                }
                if (!empty($activeGet['sphere'])) {
                    $activeFilter[] = ['=', 'category', $activeGet['sphere']];
                }
                # новые заказы
                if (!empty($activeGet['new'])) {
                    $activeNew = ['date' => SORT_DESC];
                }
                # новые заказы
            } else {
                $activeFilter[] = ['OR', ['status' => Orders::STATUS_PROCESSING], ['status' => Orders::STATUS_PAUSE]];
            }
            # фильтр заказов

            $activeOrders = Offers::find()
                ->where(['provider_id' => $client['id']])
                ->andWhere($activeFilter)
                ->orderBy($activeNew)
                ->asArray()
                ->all();
            /* активные заказы */


            /* заказы на модерации */

            #фильтр модерации
            $moderationFilter = ['AND'];
            $moderationNew = 'id desc';
            if (!empty($_GET['moderationFilter'])) {
                $moderationGet = $_GET['moderationFilter'];
                if (!empty($moderationGet['sphere'])) {
                    $moderationFilter[] = ['=', 'category', $moderationGet['sphere']];
                }
                # новые заказы
                if (!empty($moderationGet['new'])) {
                    $moderationNew = ['date' => SORT_DESC];
                }
                # новые заказы
            }
            #фильтр модерации

            $moderationOrders = Offers::find()
                ->where(['provider_id' => $client['id']])
                ->andWhere(['status' => Orders::STATUS_MODERATION])
                ->andWhere($moderationFilter)
                ->orderBy($moderationNew)
                ->asArray()
                ->all();
            /* заказы на модерации */


            /* архив */
            #фильтр архива
            $finishedFilter = ['AND'];
            $finishedNew = 'id desc';
            if (!empty($_GET['finishedFilter'])) {
                $finishedGet = $_GET['finishedFilter'];
                if (!empty($finishedGet['sphere'])) {
                    $finishedFilter[] = ['=', 'category', $finishedGet['sphere']];
                }
                # новые заказы
                if (!empty($finishedGet['new'])) {
                    $finishedNew = ['date' => SORT_DESC];
                }
                # новые заказы
            }
            #фильтр архива
            $finishedOrders = Offers::find()
                ->where(['provider_id' => $client['id']])
                ->andWhere(['status' => Orders::STATUS_FINISHED])
                ->andWhere($finishedFilter)
                ->orderBy($finishedNew)
                ->asArray()
                ->all();
            /* архив */
        }

        return $this->render('myorders', [
            'user' => $user,
            'client' => $client,
            'activeOrders' => $activeOrders,
            'activeOrdersCategory' => LeadsCategory::find()->where(['link_name' => $activeOrders[0]['category']])->asArray()->one(),
            'moderationOrders' => $moderationOrders,
            'moderationOrdersCategory' => LeadsCategory::find()->where(['link_name' => $moderationOrders[0]['category']])->asArray()->one(),
            'finishedOrders' => $finishedOrders,
            'finishedOrdersCategory' => LeadsCategory::find()->where(['link_name' => $finishedOrders[0]['category']])->asArray()->one(),
            'sphere' => $sphere,
            'notice' => $notice,
            'leadsAll' => $leadsAll,
            'countOrders' => $countOrders,
            'bonuses' => UsersBonuses::findOne(['user_id' => $user->id]),
            'dialog' => DialoguePeer::find()->where(['user_id' => $user->id, 'type' => DialoguePeer::TYPE_ORDER, 'status' => DialoguePeer::STATUS_OPENED])
                ->andWhere(['>', 'exp_date', time()])
                ->orderBy('id desc')->one(),
            'firstDay' => $firstDay,
            'lastDay' => $lastDay,
        ]);
    }
    public function actionChangeOrders()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = Yii::$app->getUser();
        $orders = Offers::findOne($_POST['order']);
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
    public function actionOrderLid($template = null)
    {
        $client = Clients::findOne(['user_id' => Yii::$app->getUser()->getId()]);
        if (empty($template))
            return Yii::$app->response->redirect(Url::to(['order']));
        $t = LeadTemplates::findOne(['link' => $template, 'active' => 1]);
        if (empty($t))
            return Yii::$app->response->redirect(Url::to(['order']));
        return $this->render('order-lid', [
            'template' => $t,
            'client' => $client
        ]);
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
    public function actionCreateNewOrderTicket()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['sfera']) || preg_match('/^[а-яё ]++$/ui', $_POST['sfera']) !== 1)
            return ['status' => 'error', 'message' => 'Сфера должна содержать только русские буквы и пробелы'];
        if (empty($_POST['reg']))
            return ['status' => 'error', 'message' => 'Необходимо указать желаемые регионы'];
        if (empty($_POST['price']))
            return ['status' => 'error', 'message' => 'Необходимо указать желаемую цену лида в оффере'];
        if (empty($_POST['summ-lid']))
            return ['status' => 'error', 'message' => 'Необходимо указать количество лидов в день'];
        $user_id = Yii::$app->getUser()->getId();
        $user = UserModel::findOne($user_id);
        if (empty($user))
            return ['status' => 'error', 'message' => 'Пользователь не найден'];
        $client = Providers::findOne(['user_id' => $user->id]);
        if (empty($client) || empty($client->company_info) || empty($client->requisites))
            return ['status' => 'error', 'message' => 'Для создания заказа необходимо заполнить профиль'];
        if (!is_array($_POST['reg']))
            return ['status' => 'error', 'message' => 'Некорректно заполнены регионы оффера'];
        if (in_array('Вся Россия', $_POST['reg']))
            $regions = json_encode(['Любой'], JSON_UNESCAPED_UNICODE);
        else
            $regions = json_encode($_POST['reg'], JSON_UNESCAPED_UNICODE);

        $props['daily_leads_min'] = (int)$_POST['summ-lid'];
        $send = [
            'Offers' => [
                'name' => $_POST['sfera'],
                'category' => $_POST['sfera'],
                "regions" => $regions,
                "leads_need" => 100,
                "leads_confirmed" => 0,
                "leads_waste" => 0,
                "leads_total" => 0,
                "price" => 150,
                "tax" => 10,
                "total_payed" => 0,
                "date" => date("Y-m-d H:i:s"),
                "offer_id" => null,
                "user_id" => $user_id,
                "provider_id" => $client->id,
                "offer_token" => null,
                'special_params' => json_encode($props, JSON_UNESCAPED_UNICODE),
                "status" => Orders::STATUS_MODERATION,
                "date_stop" => null,
                "commentary" => Html::encode($_POST['comment']) ?? null,
            ]
        ];
        $peer = DialoguePeer::findOne(['status' => 1, 'user_id' => $user_id]);
        if (empty($peer)){
            $peer = new DialoguePeer();
            $peer->user_id = $user->id;
            $peer->status = 1;
            $peer->type = DialoguePeer::TYPE_OFFER;
            $peer->properties = json_encode($send, JSON_UNESCAPED_UNICODE);
        }

        if ((empty($peer->id) && $peer->save()) || $peer->update() !== false) {
            $message = new DialoguePeerMessages();
            $message->user_id = $user->id;
            $message->peer_id = $peer->id;
            $message->isSupport = 0;
            $text = "<b>Желаемая сфера оффера</b>: {$_POST['sfera']}<br>";
            $text .= "<b>Желаемая цена лида</b>: {$_POST['price']}<br>";
            $text .= "<b>Желаемое количество лидов в день</b>: {$_POST['summ-lid']}<br>";
            $text .= "<b>Регионы</b>: " . implode(' ', json_decode($regions, 1)) . "<br>";
            $message->message = $text;
            if ($message->save()) {
                $notice = new UsersNotice();
                $notice->user_id = $user->id;
                $notice->type = UsersNotice::TYPE_MAINPAGE_MODERATION_OFFER;
                $notice->text = 'Ваш оффер находится на модерации. Вы получите уведомление после его проверки. Подробнее в чате тех. поддержки';
                $notice->save();
                return ['status' => 'success'];
            } else
                return ['status' => 'error', 'message' => 'Ошибка создания оффера. Обратитесь в тех. поддержку'];
        } else {
            return ['status' => 'error', 'message' => 'Ошибка создания оффера. Обратитесь в тех. поддержку'];
        }
    }
    public function actionOrderLidAdd()
    {
        $client = Providers::findOne(['user_id' => Yii::$app->getUser()->getId()]);
        $regions = DbRegion::find()->select(['name_with_type'])->asArray()->orderBy('name_with_type asc')->all();
        return $this->render('order-lid-add', [
            'regions' => $regions,
            'client' => $client
        ]);
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
        $client = Providers::find()->where(['user_id' => $user['id']])->asArray()->one();
        if (!empty($client)) {
            $order = Offers::find()->where(['id' => $link, 'provider_id' => $client['id']])->asArray()->one();
            $category = LeadsCategory::findOne(['link_name' => $order['category']]);
            $params = LeadsParams::find()->where(['category' => $order['category']])->asArray()->all();
            if (empty($order)) {
                throw new HttpException(404, 'Заказ не найден');
            }

        } else {
            throw new HttpException(404, 'Клиент не найден');
        }

        /* Статистика */
        $interval = 7;
        $firstDay = date("Y-m-d 00:00:00", time() - 3600 * 24 * $interval);
        $lastDay = date('Y-m-d 23:59:59');
        $start = new DateTime($firstDay);
        $interval = new DateInterval('P1D');
        $end = new DateTime($lastDay);
        $period = new DatePeriod($start, $interval, $end);
        ##общая стата
        $stats = OffersAlias::find() # это все лиды
        ->select('DATE(`date`) as `date_lead`, count(1) as `summ`')
            ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
            ->andWhere(['provider_id' => $client['id']])
            ->andWhere(['offer_id' => $order['id']])
            ->groupBy('date_lead')
            ->all();
        $confirmed = LeadsSentReport::find() # это подтвержденные лиды
        ->select('DATE(`date`) as `date_lead`, count(1) as `summ`, status')
            ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
            ->andWhere(['provider_id' => $client['id']])
            ->andWhere(['status' => Leads::STATUS_CONFIRMED])
            ->andWhere(['offer_id' => $order['id']])
            ->groupBy('date_lead')
            ->all();
        $waste = LeadsSentReport::find() # это брак
        ->select('DATE(`date`) as `date_lead`, count(1) as `summ`, status')
            ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
            ->andWhere(['provider_id' => $client['id']])
            ->andWhere(['AND', ['status' => Leads::STATUS_WASTE], ['status_confirmed' => 1]])
            ->andWhere(['offer_id' => $order['id']])
            ->groupBy('date_lead')
            ->all();
        ##общая стата
        /* Статистика */

        return $this->render('orderpage', [
            'order' => $order,
            'user' => $user,
            'parameters' => $params,
            'category' => $category,
            'stats' => $stats,
            'stats2' => $confirmed,
            'stats3' => $waste,
            'date' => $period,
        ]);
    }
    public function actionProf()
    {
        $user = Yii::$app->user;
        $model = User::find()->where(['id' => $user->getId()])->asArray()->one();
        $client = Providers::find()->where(['user_id' => $user->getId()])->asArray()->one();
        $propertis = UsersProperties::find()->where(['user_id' => $user->getId()])->asArray()->one();
        return $this->render('prof', ['user' => $user, 'model' => $model, 'client' => $client, 'propertis' => $propertis]);
    }
    public function actionProfileSaver()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['fields']) && is_array($_POST['fields'])) {
            $fields = $_POST['fields'];
            $errors = [];
            $user_id = Yii::$app->getUser()->getId();
            $client = Providers::findOne(['user_id' => $user_id]);
            if (empty($client)) {
                $client = new Providers();
                $client->user_id = $user_id;
            }
            $client->f = $fields['familiya'];
            $client->i = $fields['imya'];
            $client->o = $fields['otchestvo'];
            $client->email = $fields['email'];
            do {
                $uid = $client->generate__uuid();
                $double = Providers::findOne(['provider_token' => $uid]);
                if (empty($double))
                    break;
            } while(true);
            $client->provider_token = $uid;
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
            $client = Providers::findOne(['user_id' => $user_id]);
            $requisites = [];
            if (!empty($info['type'])) {
                if ($info['type'] === 'fiz') {
                    $keys = ['f', 'i', 'o', 'address', 'phone', 'email', 'card'];
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
    public function actionSupport()
    {
        $user = Yii::$app->getUser()->getId();
        if (!empty($user)){
            if (!empty($_POST['name'])){
                $dialog = DialoguePeer::find()->where(['user_id' => $user, 'status' => DialoguePeer::STATUS_OPENED])->orderBy('id desc')->one();
                $allDialog = DialoguePeer::find()->where(['user_id' => $user, 'status' => DialoguePeer::STATUS_CLOSED])->orderBy('id desc');
                $pages = new Pagination(['totalCount' => $allDialog->count(), 'pageSize' => 8]);
                $posts = $allDialog->offset($pages->offset)
                    ->limit($pages->limit)
                    ->all();
                if (empty($dialog)){
                    $dialog = new DialoguePeer();
                    $dialog->user_id = $user;
                    $dialog->status = DialoguePeer::STATUS_OPENED;
                    $dialog->type = DialoguePeer::TYPE_DEFAULT;
                    $dialog->save();
                    if ($dialog->save() !== false){
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
            'rsp' => $rsp,
            'pages' => $pages,
        ]);
    }
    public function actionSendMessageHelp()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['pearId']) && !empty($_POST['message'])){
            $msg = $_POST['message'];
            $user = Yii::$app->getUser()->getId();
            if (!empty($user)){
                $dialog = DialoguePeer::find()->where(['user_id' => $user, 'status' => DialoguePeer::STATUS_OPENED])->select('id')->orderBy('id desc')->one();
                if (!empty($dialog)){
                    $message = new DialoguePeerMessages();
                    $message->peer_id = (int)$_POST['pearId'];
                    $message->user_id = $user;
                    $message->message = $msg;
                    $message->isSupport = 0;
                    $message->validate();
                    if ($message->save()){
                        $rsp = ['status' => 'success'];
                    } else $rsp = ['status' => 'error', 'message' => 'Ошибка на сервере'];
                } else $rsp = ['status' => 'error', 'message' => 'Такого диалога нет'];
            } else $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
        } else $rsp = ['status' => 'error', 'message' => 'Нет сообщения'];
        return $message->errors;
    }
    public function actionUsermanual()
    {
        return $this->render('usermanual');
    }
    public function actionUsermanualoffersadd()
    {
        return $this->render('usermanualoffersadd');
    }
    public function actionUsermanualstatistics()
    {
        return $this->render('usermanualstatistics');
    }
    public function actionUsermanualmain()
    {
        return $this->render('usermanualmain');
    }
    public function actionUsermanualmyoffers()
    {
        return $this->render('usermanualmyoffers');
    }
    public function actionUsermanualsprofile()
    {
        return $this->render('usermanualsprofile');
    }
    public function actionViewOffer($id)
    {
        $leads = LeadTypes::findOne(['id' => $id]);
        $regions = DbRegion::find()->select(['name_with_type'])->asArray()->orderBy('name_with_type asc')->all();
        return $this->render('view-offer',
        [
            'leads' => $leads,
            'regions' => $regions,
        ]);
    }
    public function actionConfirmOffers()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = Yii::$app->getUser()->getId();
        $client = Providers::findOne(['user_id' => $user]);
        if (empty($client)){
            return $rsp = ['status' => 'error', 'message' => 'Поставщик не найден'];
        }
        $offers = Offers::find()->where(['AND', ['provider_id' => $client['id']], ['=', 'status', 'модерация']])->count();
        if ($offers > 0){
            return ['status' => 'error', 'message' => 'У вас уже есть оффер на модерации. Ожидайте окончания модерации'];
        }
        if (!empty($user)){
            $leads = LeadTypes::findOne(['id' => $_POST['id']]);
            if (!empty($leads)){
                $offers = Offers::find()->where(['AND', ['offer_id' => $leads->id, 'provider_id' => $client['id']], ['!=', 'status', 'выполнен']])->count();
                if ($offers > 0){
                    return ['status' => 'error', 'message' => 'У вас уже есть такой оффер'];
                }
                if (!empty($_POST['daily_leads_min']) || !empty($_POST['reg'])){
                    if ($leads->category_link !== 'chardjbek'){
                        foreach ($_POST['reg'] as $key => $item){
                            $_POST['reg'][$key] = Html::encode($item);
                        }
                        if (!is_array($_POST['reg']))
                            return ['status' => 'error', 'message' => 'Некорректно заполнены регионы заказа'];
                        if (in_array('Вся Россия', $_POST['reg']))
                            $regions = json_encode(['Любой'], JSON_UNESCAPED_UNICODE);
                        else
                            $regions = json_encode($_POST['reg'], JSON_UNESCAPED_UNICODE);
                    } else{
                        $regions = json_encode(['Любой'], JSON_UNESCAPED_UNICODE);
                    }
                    $_POST['daily_leads_min'] = Html::encode($_POST['daily_leads_min']);
                    $params = json_decode($leads->params, true);
                    $params['daily_leads_min'] = $_POST['daily_leads_min'];
                    $params = json_encode($params, JSON_UNESCAPED_UNICODE);
                } else {
                    $regions = null;
                    $params = $leads->params;
                }
                $model = new Offers();
                $model->createFromTemplate($leads, $user, $client->id, $params, $regions);
                if (empty($model->leads_need)){
                    $model->leads_need = 100;
                }
                if ($model->save()){
                    return ['status' => 'success'];
                } return ['status' => 'error', 'message' => 'Ошибка сохранения'];
            } else $rsp = ['status' => 'error', 'message' => 'Лид не найден'];
        } else $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];

        return $rsp;
    }
    public function actionStatistics()
    {
        $provider = Providers::findOne(['user_id' => Yii::$app->getUser()->getId()]);
        $sphere = LeadsCategory::find()->asArray()->all();
        if (!empty($provider)) {
            $interval = !empty($_GET['interval']) ? $_GET['interval'] : 7;
            if ($interval > 30)
                $interval = 365;
            $firstDay = date("Y-m-d 00:00:00", time() - 3600 * 24 * $interval);
            $lastDay = date('Y-m-d 23:59:59');
            $start = new DateTime($firstDay);
            $interval = new DateInterval('P1D');
            $end = new DateTime($lastDay);
            $period = new DatePeriod($start, $interval, $end);
            ##общая стата
            $stats = OffersAlias::find() # это все лиды
                ->select('DATE(`date`) as `date_lead`, count(1) as `summ`')
                ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
                ->andWhere(['provider_id' => $provider->id])
                ->groupBy('date_lead')
                ->all();
            $confirmed = LeadsSentReport::find() # это подтвержденные лиды
            ->select('DATE(`date`) as `date_lead`, count(1) as `summ`, status')
                ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
                ->andWhere(['provider_id' => $provider->id])
                ->andWhere(['status' => Leads::STATUS_CONFIRMED])
                ->groupBy('date_lead')
                ->all();
            $waste = LeadsSentReport::find() # это брак
            ->select('DATE(`date`) as `date_lead`, count(1) as `summ`, status')
                ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
                ->andWhere(['provider_id' => $provider->id])
                ->andWhere(['AND', ['status' => Leads::STATUS_WASTE], ['status_confirmed' => 1]])
                ->groupBy('date_lead')
                ->all();
            ##общая стата

            /* активные заказы */
            # фильтр заказов
            $activeFilter = ['AND'];
            if (!empty($_GET['activeFilter'])) {
                $activeGet = $_GET['activeFilter'];
                if (!empty($activeGet['status'])) {
                    $activeFilter[] = ['=', 'status', $activeGet['status']];
                } else {
                    $activeFilter[] = ['OR', ['status' => Orders::STATUS_PROCESSING], ['status' => Orders::STATUS_PAUSE], ['status' => Orders::STATUS_STOPPED]];
                }
                if (!empty($activeGet['sphere'])) {
                    $activeFilter[] = ['=', 'category', $activeGet['sphere']];
                }
                # новые заказы
                if (!empty($activeGet['new'])) {
                    $activeNew = ['date' => SORT_DESC];
                }
                # новые заказы
            } else {
                $activeFilter[] = ['OR', ['status' => Orders::STATUS_PROCESSING], ['status' => Orders::STATUS_PAUSE], ['status' => Orders::STATUS_STOPPED]];
            }
            # фильтр заказов
            $activeOrders = Offers::find()
                ->where(['provider_id' => $provider->id])
                ->andWhere($activeFilter)
                ->orderBy($activeNew)
                ->asArray()
                ->all();
            /* активные заказы */

            /* выполненные заказы */
            # фильтр заказов
            $activeFilter2 = ['AND'];
            if (!empty($_GET['finishedFilter'])) {
                $activeGet2 = $_GET['finishedFilter'];
                if (!empty($activeGet2['sphere'])) {
                    $activeFilter2[] = ['=', 'category', $activeGet2['sphere']];
                }
                # новые заказы
                if (!empty($activeGet2['new'])) {
                    $activeNew2 = ['date' => SORT_DESC];
                }
                # новые заказы
            } else {
                $activeFilter2[] = ['OR', ['status' => Orders::STATUS_FINISHED]];
            }
            # фильтр заказов
            $activeOrders2 = Offers::find()
                ->where(['provider_id' => $provider->id, 'status' => Orders::STATUS_FINISHED])
                ->andWhere($activeFilter2)
                ->orderBy($activeNew2)
                ->asArray()
                ->all();
            /* выполненные заказы */

        }
        return $this->render('statistics', [
            'stats' => $stats,
            'stats2' => $confirmed,
            'stats3' => $waste,
            'date' => $period,
            'sphere' => $sphere,
            'activeOrders' => $activeOrders,
            'activeOrders2' => $activeOrders2,
            'provider' => $provider
        ]);
    }
    public function actionGuide()
    {
        $provider = Providers::findOne(['user_id' => Yii::$app->getUser()->getId()]);
        if (!empty($provider)) {
            $offers = \common\models\Offers::find()
                ->where(['provider_id' => $provider->id])
                ->andWhere(['AND', ['!=', 'status', 'модерация'], ['!=', 'status', 'остановлен'], ['!=', 'status', 'выполнен']])
                ->all();
            $utms = ProvidersUtms::find()->where(['provider_id' => $provider->id])->asArray()->all();
        }
        return $this->render('guide', ['provider' => $provider, 'offers' => $offers, 'utms' => $utms]);
    }
    public function actionCreateUtm() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->getUser()->getId();
        $pr = Providers::find()->where(['user_id' => $id])->select(['id'])->one();
        if (!empty($pr) && Yii::$app->request->isPost) {
            $utms = ProvidersUtms::find()->where(['provider_id' => $pr->id])->count();
            if ($utms >= 10)
                return ['status' => 'error', 'message' => 'Разрешено не более 10 активных UTM-меток'];
            $u = new ProvidersUtms();
            return $u->generate($pr->id)->save() ? ['status' => 'success'] : ['status' => 'error', 'message' => 'Ошибка сохранения метки'];
        } else
            return ['status' => 'error', 'message' => 'Для создания собственных меток необходимо полностью заполнить профиль'];
    }
    public function actionRemoveUtm() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $id = Yii::$app->getUser()->getId();
        $pr = Providers::find()->where(['user_id' => $id])->select(['id'])->one();
        if (!empty($pr) && Yii::$app->request->isPost && !empty($_POST['remove'])) {
            $utms = ProvidersUtms::find()->where(['provider_id' => $pr->id, 'name' => $_POST['remove']])->one();
            if (empty($utms))
                return ['status' => 'error', 'message' => 'Метка не найдена'];
            return $utms->delete() ? ['status' => 'success'] : ['status' => 'error', 'message' => 'Ошибка удаления метки'];
        } else
            return ['status' => 'error', 'message' => 'Для удаления меток необходимо полностью заполнить профиль'];
    }
    public static function fullInfo($client)
    {
        return !empty($client['f']) && !empty($client['i']) && !empty($client['email']) && !empty($client['company_info']) && !empty($client['requisites']);
    }
    public function actionNotice()
    {
        $user = Yii::$app->getUser()->getId();
        if (empty($user)){
            return Yii::$app->response->redirect('index');
        }

        $query = UsersNotice::find()->where(['user_id' => $user, 'active' => 0])->orderBy('date desc');
        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 5]);
        $posts = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('notice', ['notice' => $posts, 'pages' => $pages]);
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
