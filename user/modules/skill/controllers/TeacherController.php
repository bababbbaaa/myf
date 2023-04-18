<?php


namespace user\modules\skill\controllers;


use common\models\BudgetLog;
use common\models\CdbArticle;
use common\models\CdbCategory;
use common\models\CdbSubcategory;
use common\models\Clients;
use common\models\DialoguePeer;
use common\models\DialoguePeerMessages;
use common\models\disk\Cloud;
use common\models\helpers\Robokassa;
use common\models\Providers;
use common\models\SkillTrainings;
use common\models\SkillTrainingsCategory;
use common\models\User;
use common\models\UserModel;
use common\models\UsersBills;
use common\models\UsersNotice;
use common\models\UsersProperties;
use common\models\UsersProviderUploads;
use common\models\UsersProviderUploadsSigned;
use DateInterval;
use DatePeriod;
use DateTime;
use Yii;
use yii\data\Pagination;
use yii\db\Expression;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;

class TeacherController extends Controller
{
    /*
     * Страницы с одним экшеном
     */
    public function actionIndex()
    {
        $user = Yii::$app->getUser()->getId();
        $client = Providers::find()->where(['user_id' => $user])->asArray()->one();
        $user_info = User::find()->where(['id' => $user])->asArray()->one();
        $notice = UsersNotice::find()->where(['user_id' => $user, 'active' => 1])
            ->orderBy('date desc')->limit(4)->all();
        $date = date('Y-m-d H:i:s');
        /* Статистика */
        $interval = 7;
        $budget_log = BudgetLog::find()->where(['user_id' => $user])->asArray()->limit(5)->orderBy('id desc')->all();
        $firstDay = date("Y-m-d 00:00:00", time() - 3600 * 24 * $interval);
        $lastDay = date('Y-m-d 23:59:59');
        $start = new DateTime($firstDay);
        $interval = new DateInterval('P1D');
        $end = new DateTime($lastDay);
        $period = new DatePeriod($start, $interval, $end);

        return $this->render('index', [
            'client' => $client,
            'user_info' => $user_info,
            'budget_log' => $budget_log,
            'notice' => $notice,
            'date' => $period,
        ]);
    }
    public function actionMyprograms()
    {
        $filters = ['AND'];
        $cat = $_GET['category'];
        $type = $_GET['type'];
        $search = $_GET['search'];
        $price = (int)$_GET['price'];

        if (!empty($cat)) {
            $filters[] = ['in', 'category_id', $cat];
        }
        if (!empty($type)) {
            $filters[] = ['in', 'type', $type];
        }
        if (!empty($price)) {
            $filters[] = ['=', 'price', 0];
        }
        if (!empty($search)) {
            $filters[] = ['OR',
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
        $programs = SkillTrainings::find()->where($filters)->andWhere(['author_id' => Yii::$app->user->getId()]);
        $pages = new Pagination(['totalCount' => $programs->count(), 'pageSize' => 5]);
        $posts = $programs->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('myprograms', compact(
            'posts',
            'pages',
            'category'
        ));
    }
    public function actionMytasks()
    {
        return $this->render('mytasks');
    }
    public function actionHelp()
    {
        return $this->render('help');
    }
    public function actionHelpTasks()
    {
        return $this->render('help-tasks');
    }
    /*
     * Страницы с одним экшеном
     */
// ========================================================================== \\
    public function actionStatis()
    {
        return $this->render('statis');
    }
    public function actionTaskpage()
    {
        return $this->render('taskpage');
    }
    public function actionTaskpageAssistent()
    {
        return $this->render('taskpage-assistent');
    }
    public function actionProgrammpage()
    {
        return $this->render('programmpage');
    }
    public function actionWebinarpage()
    {
        return $this->render('webinarpage');
    }
// ========================================================================== \\
    /*
     * Баланс начало
     */
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
    /*
     * Баланс конец
     */
// ========================================================================== \\
    /*
     * Профиль начало
     */
    public function actionProfile()
    {
        $user = Yii::$app->user;
        $model = User::find()->where(['id' => $user->getId()])->asArray()->one();
        $client = Providers::find()->where(['user_id' => $user->getId()])->asArray()->one();
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
    /*
     * Профиль конец
     */
// ========================================================================== \\
    /*
     * Тех.поддержка начало
     */
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
            'pages' => $pages,
            'rsp' => $rsp,
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
    /*
     * Тех.поддержка конец
     */
// ========================================================================== \\
    /*
     * Руководство пользователя начало
     */
    public function actionManual()
    {
        return $this->render('manual');
    }
    public function actionManualprofile()
    {
        return $this->render('manualprofile');
    }
    public function actionManualbalance()
    {
        return $this->render('manualbalance');
    }
    public function actionManualhelp()
    {
        return $this->render('manualhelp');
    }
    public function actionManualmain()
    {
        return $this->render('manualmain');
    }
    public function actionManualprogram()
    {
        return $this->render('manualprogram');
    }
    public function actionManualstat()
    {
        return $this->render('manualstat');
    }
    public function actionManualtasks()
    {
        return $this->render('manualtasks');
    }
    public function actionManualaddprogram()
    {
        return $this->render('manualaddprogram');
    }
    /*
     * Руководство пользователя Конец
     */
// ========================================================================== \\
    /*
     * База знаний начало
     */
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
    /*
     * База знаний Конец
     */
// ========================================================================== \\
    /*
     * Добавить курс Начало
     */
    public function actionAddprogram()
    {
        $category = SkillTrainingsCategory::find()->asArray()->all();
        return $this->render('addprogram', [
            'category' => $category,
        ]);
    }
    public function actionAddCategory()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['category-name']) || empty($_POST['category-link'])){
            return ['status' => false, 'text' => 'Отсутствуют обязательные параметры'];
        }
        $name = $_POST['category-name'];
        $link = $_POST['category-link'];
        $category = SkillTrainingsCategory::find()->where(['like', 'name', "%{$name}%", false])->one();
        if (!empty($category)) return ['status' => false, 'text' => 'Такая категория уже существует'];
        $model = new SkillTrainingsCategory();
        $model->name = $name;
        $model->link = $link;
        if ($model->save()) return ['status' => true, 'id' => $model->id];
        else return ['status' => false, 'text' => 'Ошибка сохранения категории'];
    }
    /*
     * Добавить курс Конец
     */
// ========================================================================== \\
    /*
     * Проверка на заполненность профиля
     */
    public static function fullInfo($client)
    {
        return !empty($client['f']) && !empty($client['i']) && !empty($client['email']) && !empty($client['company_info']) && !empty($client['requisites']);
    }
    /*
     * Проверка на заполненность профиля
     */
// ========================================================================== \\
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
}
