<?php

namespace admin\modules\lead_force\controllers;

use admin\controllers\AccessController;
use admin\models\Admin;
use admin\models\BasesBackdoorHandle;
use admin\models\DealsBackdoor;
use admin\models\StatisticsDaily;
use common\behaviors\JsonQuery;
use common\models\BackdoorHooks;
use common\models\CcLeads;
use common\models\Clients;
use common\models\Integrations;
use common\models\LeadsBackdoor;
use common\models\LeadsCategory;
use common\models\LeadsParams;
use common\models\LeadsRead;
use common\models\LeadsSave;
use common\models\LeadsSentReport;
use common\models\LeadsSources;
use common\models\Orders;
use common\models\SellerProducts;
use common\models\StatusResponder;
use DateInterval;
use DatePeriod;
use DateTime;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yii;
use common\models\Leads;
use common\models\LeadsSearch;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * LeadsController implements the CRUD actions for Leads model.
 */
class LeadsController extends AccessController
{
    /**
     * {@inheritdoc}
     */

    /**
     * Lists all Leads models.
     * @return mixed
     */

    public function actionCcPropChange() {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['pageSize'])) {
            $_SESSION['pageSizeCC'] = (int)$_POST['pageSize'];
            return ['status' => 'success'];
        } else
            return ['status' => 'error'];
    }


    public function actionIndex()
    {
        if (empty($_GET['LeadsSearch']['type'])) {
            if (empty($_GET['fromLogs'])) {
                $definedRedirect = ['leads/index', 'LeadsSearch[type]' => 'dolgi'];
                return Yii::$app->response->redirect(Url::to($definedRedirect));
            }
        }
        $categories = LeadsCategory::find()->select(['name', 'link_name'])->all();
        $catArray = [];
        if (!empty($categories)) {
            foreach ($categories as $c)
                $catArray[$c->link_name] = $c->name;
        }
        $searchModel = new LeadsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'defaultOrder' => ['date_income' => SORT_DESC],
        ]);
        $dataProvider->pagination->pageSize = $_SESSION['pageSizeCC'] ?? 50;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'cArray' => $catArray,
        ]);
    }

    /**
     * Displays a single Leads model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Leads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Leads();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Leads model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($_POST['SpecialParams'])) {
                $p = $_POST['SpecialParams'];
                if (empty($model->params))
                    $model->params = [];
                foreach ($p as $key => $item) {
                    if (empty($item))
                        continue;
                    $lParr = LeadsParams::findOne(['name' => $key]);
                    if (!empty($lParr))
                        $model->params = array_merge($model->params, [$key => $lParr->type === 'string' ? $item : (integer)$item]);
                }
            }
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Leads model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Leads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Leads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Leads::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionExcelExport() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['keys'])) {
            $functions = new Admin('leads');
            return $functions->excelExport($_POST['keys'], Leads::class);
        } else
            return ['status' => 'error', 'message' => 'Пустая выборка.'];
    }

    public function actionIntervalQuery() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['keys']) && !empty($_POST['order']) && !empty($_POST['start_time']) && !empty($_POST['interval'])) {
            $functions = new Admin('leads');
            return $functions->intervalQuery($_POST);
        } else
            return ['status' => 'error', 'message' => 'Пустая выборка.'];
    }

    public function actionDeleteSelected() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['keys'])) {
            $functions = new Admin('leads');
            return $functions->deleteSelected($_POST['keys'], Leads::class);
        } else
            return ['status' => 'error', 'message' => 'Пустая выборка.'];
    }


    public function actionExcelFiltration() {
        $clients = Clients::find()->asArray()->orderBy('id desc')->all();
        $orders = Orders::find()->asArray()->orderBy('id desc')->all();
        $categories = LeadsCategory::find()->asArray()->orderBy('id desc')->all();
        $sources = LeadsSources::find()->asArray()->orderBy('id desc')->all();
        $params = LeadsParams::find()->asArray()->all();
        return $this->render('excel-filtration',
            [
                'clients' => $clients,
                'orders' => $orders,
                'categories' => $categories,
                'sources' => $sources,
                'params' => $params,
            ]);
    }

    public function actionExcelFiltrationBd() {
        return $this->render('excel-filtration-bd',
            [

            ]);
    }

    public function actionUseLeadExportFilterBd() {
        if (!empty($_POST['filter'])) {
            $filterArray = $_POST['filter'];
            $filters = ['AND'];
            $dateStart = !empty($filterArray['dateStart']) ? $filterArray['dateStart'] : date("2021-03-01 00:00:00");
            $dateStop = !empty($filterArray['dateStop']) ? $filterArray['dateStop'] : date("Y-m-d H:i:s", time() + 3600*24);
            if (!empty($filterArray['source']))
                $filters[] = ['source' => $filterArray['source']];
            if (!empty($filterArray['region'])) {
                $regionBuf = ['OR'];
                $regionBuf[] = ['region' => $filterArray['region']];
                $filters[] = $regionBuf;
            }
            $timeFilter = ['AND'];
            $timeFilter[] = ['>=', 'date', $dateStart];
            $timeFilter[] = ['<=', 'date', $dateStop];
            $filters[] = $timeFilter;
            $bd = LeadsBackdoor::find()->where($filters)->asArray()->select(['id'])->all();
            if (!empty($bd)) {
                $ids = [];
                foreach ($bd as $item) {
                    $ids[] = $item['id'];
                }
                $xlsxResponse = new Admin('lb');
                Yii::$app->response->format = Response::FORMAT_JSON;
                $data = $xlsxResponse->excelExport(json_encode($ids), LeadsBackdoor::class, isset($filterArray['onlyPhone']));
                return Yii::$app->response->redirect($data['url']);
            } else {
                Yii::$app->session->setFlash('emptyResponse', 'По данному запросу лиды не найдены.');
                return Yii::$app->response->redirect(Url::to(['excel-filtration-bd']));
            }
        } else {
            Yii::$app->session->setFlash('emptyResponse', 'Пустая выборка.');
            return Yii::$app->response->redirect(Url::to(['excel-filtration-bd']));
        }
    }

    public function actionUseLeadExportFilter() {
        if (!empty($_POST['filter'])) {
            $filterArray = $_POST['filter'];
            $filters = ['AND'];
            $dateStart = !empty($filterArray['dateStart']) ? $filterArray['dateStart'] : date("2021-03-01 00:00:00");
            $dateStop = !empty($filterArray['dateStop']) ? $filterArray['dateStop'] : date("Y-m-d H:i:s", time() + 3600*24);
            if (!empty($filterArray['region'])) {
                $regionBuf = ['OR'];
                $regionBuf[] = ['leads.region' => $filterArray['region']];
                $regionBuf[] = ['leads.city' => $filterArray['region']];
                $filters[] = $regionBuf;
            }
            if (!empty($filterArray['source']))
                $filters[] = ['leads.source' => $filterArray['source']];
            if (!empty($filterArray['status']))
                $filters[] = ['leads.status' => $filterArray['status']];
            if (!empty($filterArray['type']))
                $filters[] = ['leads.type' => $filterArray['type']];
            if (!empty($filterArray['special'])) {
                $specials = $filterArray['special'];
                $equals = !empty($specials['equals']) ? $specials['equals'] : null;
                $intervals = !empty($specials['interval']) ? $specials['interval'] : null;
                if (!empty($equals)) {
                    foreach ($equals as $key => $eq) {
                        if (empty($eq))
                            continue;
                        $jsonQuery = new JsonQuery('params');
                        $filters[] = $jsonQuery->JsonExtract($key, "= '$eq'");
                    }
                }
                if (!empty($intervals)) {
                    foreach ($intervals as $key => $interval) {
                        if (empty($interval[0]) && empty($interval[1]))
                            continue;
                        $jsonQuery = new JsonQuery('params');
                        $intervalBuf = ['AND'];
                        if(!empty($interval[0]) || (int)$interval[0] === 0)
                            $intervalBuf[] = $jsonQuery->JsonExtract($key, ">= " . (int)$interval[0]);
                        if (!empty($interval[1]))
                            $intervalBuf[] = $jsonQuery->JsonExtract($key, "<= {$interval[1]}");
                        $filters[] = $intervalBuf;
                    }
                }
            }
            if (!empty($filterArray['order']) || !empty($filterArray['client'])) {
                $leads = Leads::find()->joinWith('xlsx');
                $timeFilter = ['AND'];
                $timeFilter[] = ['>=', 'leads_sent_report.date', $dateStart];
                $timeFilter[] = ['<=', 'leads_sent_report.date', $dateStop];
                $filters[] = $timeFilter;
                if(!empty($filterArray['order']))
                    $filters[] = ['leads_sent_report.order_id' => (int)$filterArray['order']];
                else
                    $filters[] = ['leads_sent_report.client_id' => (int)$filterArray['client']];
                $response = $leads
                    ->where($filters)
                    ->select(['leads.id'])
                    ->asArray()
                    ->batch();
            } else {
                $leads = Leads::find();
                $timeFilter = ['AND'];
                $timeFilter[] = ['>=', 'leads.date_income', $dateStart];
                $timeFilter[] = ['<=', 'leads.date_income', $dateStop];
                $filters[] = $timeFilter;
                $response = $leads
                    ->where($filters)
                    ->select(['leads.id'])
                    ->asArray()
                    ->batch();
            }
            if(!empty($response)) {
                $ids = [];
                foreach ($response as $item) {
                    foreach ($item as $b) {
                        $ids[] = $b['id'];
                    }
                }
                if (!empty($ids)) {
                    $xlsxResponse = new Admin('leads');
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    return $xlsxResponse->excelExport(json_encode($ids), Leads::class, isset($filterArray['onlyPhone']));
                } else {
                    Yii::$app->session->setFlash('emptyResponse', 'По данному запросу лиды не найдены.');
                    return Yii::$app->response->redirect(Url::to(['excel-filtration']));
                }
            } else {
                Yii::$app->session->setFlash('emptyResponse', 'По данному запросу лиды не найдены.');
                return Yii::$app->response->redirect(Url::to(['excel-filtration']));
            }
        } else {
            Yii::$app->session->setFlash('emptyResponse', 'Пустая выборка.');
            return Yii::$app->response->redirect(Url::to(['excel-filtration']));
        }
    }

    public function actionMassExport() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['keys']) && !empty($_POST['order'])) {
            $ids = json_decode($_POST['keys'], true);
            $leads = Leads::find()->where(['in', 'id', $ids])->select('phone, id, utm_campaign')->asArray()->all();
            $leadArray = ArrayHelper::map($leads, 'id', 'phone');
            $phoneArray = ArrayHelper::map($leads, 'phone', 'id');
            $duplicates = Leads::find()
                ->select('id, phone')
                ->where(['AND', ['in', 'phone', $leadArray], ['OR', ['status' => Leads::STATUS_SENT], ['status' => Leads::STATUS_WASTE], ['status' => Leads::STATUS_CONFIRMED], ['status' => Leads::STATUS_INTERVAL]]])
                ->asArray()
                ->all();
            $orderProps = Orders::findOne($_POST['order']);
            if (!empty($duplicates)) {
                $catch = [];
                $client = $orderProps->client;
                foreach ($duplicates as $item) {
                    $alias = LeadsSentReport::find()
                        ->where(['AND', ['client_id' => $client], ['lead_id' => $item['id']]])
                        ->count();
                    if ((int)$alias > 0) {
                        if (!empty($phoneArray[$item['phone']])) {
                            unset($phoneArray[$item['phone']]);
                            $catch[] = $item['phone'];
                        }
                    }
                }
            }
            $utms = [];
            foreach ($leads as $item) {
                if (!in_array($item['utm_campaign'], $utms) && !empty($item['utm_campaign']) && (mb_strpos($item['utm_campaign'], ".ru") !== false || mb_strpos($item['utm_campaign'], ".com") !== false)){
                    $utms[$item['id']] = $item['utm_campaign'];
                }
            }
            $bdCatch = [];
            if (!empty($utms)) {
                foreach ($utms as $key => $item) {
                    $integration = Integrations::find()
                        ->where(['integration_type' => 'bitrix'])
                        ->andWhere(['entity' => 'order'])
                        ->andWhere(['entity_id' => $orderProps->id])
                        ->andWhere(['like', 'config', "%{$item}%", false])
                        ->one();
                    $integration2 = Integrations::find()
                        ->where(['integration_type' => 'bitrix'])
                        ->andWhere(['entity' => 'client'])
                        ->andWhere(['entity_id' => $orderProps->client])
                        ->andWhere(['like', 'config', "%{$item}%", false])
                        ->one();
                    if (!empty($integration) || !empty($integration2)) {
                        $bdCatch[] = $key;
                        unset($phoneArray[$leadArray[$key]]);
                    }
                }
            }
            sort($phoneArray);
            $functions = new Admin('leads');
            $result = $functions->massLead(json_encode($phoneArray), $_POST['order']);
            if (empty($catch) && empty($bdCatch))
                return $result;
            else {
                $message = '';
                if (!empty($catch))
                    $message .= 'Найдены дубли в заказе: ' . implode(', ', $catch) . ". Остальные лиды отправлены, перезагрузите страницу.\n\n";
                if (!empty($bdCatch))
                    $message .= 'Найдены дубли бекдора: ' . implode(', ', $bdCatch) . ". Остальные лиды отправлены, перезагрузите страницу.";
                return ['status' => 'error', 'message' => $message];
            }
        } else
            return ['status' => 'error', 'message' => 'Пустая выборка.'];
    }

    public function actionBackdoor() {
        $orders = Orders::find()
            ->where(['status' => Orders::STATUS_PROCESSING])
            ->select(['client', 'id'])
            ->asArray()
            ->all();
        $integrationsRestricted = null;
        if (!empty($orders)) {
            $clientsArray = ArrayHelper::getColumn($orders, 'client');
            $ordersArray = ArrayHelper::getColumn($orders, 'id');
            $integrationsRestricted = Integrations::find()
                ->where([
                    'OR',
                    ['AND', ['in', 'entity_id', $ordersArray], ['entity' => 'order']],
                    ['AND', ['in', 'entity_id', $clientsArray], ['entity' => 'client']]
                ])->andWhere(['integration_type' => 'bitrix'])
                ->select(['config'])
                ->asArray()
                ->all();
            if (!empty($integrationsRestricted)) {
                $rArr = [];
                foreach ($integrationsRestricted as $item) {
                    $cfg = json_decode($item['config'], 1);
                    if (!empty($cfg) && !empty($cfg['WEBHOOK_URL'])) {
                        $hook = $cfg['WEBHOOK_URL'];
                        $url = parse_url($hook);
                        if (is_array($url))
                            $rArr[] = $url['host'];
                    }
                }
            }
        }
        $filters = ['AND'];
        if (!empty($_GET['filters'])) {
            $f = $_GET['filters'];
            if (!empty($f['source']))
                $filters[] = ['like', 'source', "%{$f['source']}%", false];
            if (!empty($f['source_exclude'])) {
                $sourcesArr = explode(',', str_replace(' ', '', $f['source_exclude']));
                $buf = ['AND'];
                foreach ($sourcesArr as $src) {
                    $buf[] = ['not like', 'source', "%{$src}%", false];
                }
                $filters[] = $buf;
            }
            if (!empty($f['region']))
                $filters[] = ['like', 'region', "%{$f['region']}%", false];
            if (!empty($f['start_date']))
                $filters[] = ['>=', 'date', date('Y-m-d 00:00:00', strtotime($f['start_date']))];
            if (!empty($f['stop_date']))
                $filters[] = ['<=', 'date', date('Y-m-d 23:59:59', strtotime($f['stop_date']))];
            if (!empty($f['empty_log']))
                $filters[] = ['is', 'log', null];
            if (!empty($f['drop_restricted'])) {
                if (!empty($rArr)) {
                    $buf = ['AND'];
                    foreach ($rArr as $item) {
                        $buf[] = ['!=', 'source', "$item"];
                    }
                    $filters[] = $buf;
                }
            }
        }
        $query = LeadsBackdoor::find()
            ->orderBy('id desc')
            ->where($filters)
            ->asArray();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(empty($_GET['setPageSize']) ? 100 : $_GET['setPageSize']);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('backdoor', ['models' => $models, 'pages' => $pages, 'count' => $countQuery->count(), 'rArr' => $rArr ?? []]);
    }

    public function actionBackdoorDeals() {
        $orders = Orders::find()
            ->where(['status' => Orders::STATUS_PROCESSING])
            ->select(['client', 'id'])
            ->asArray()
            ->all();
        $integrationsRestricted = null;
        if (!empty($orders)) {
            $clientsArray = ArrayHelper::getColumn($orders, 'client');
            $ordersArray = ArrayHelper::getColumn($orders, 'id');
            $integrationsRestricted = Integrations::find()
                ->where([
                    'OR',
                    ['AND', ['in', 'entity_id', $ordersArray], ['entity' => 'order']],
                    ['AND', ['in', 'entity_id', $clientsArray], ['entity' => 'client']]
                ])->andWhere(['integration_type' => 'bitrix'])
                ->select(['config'])
                ->asArray()
                ->all();
            if (!empty($integrationsRestricted)) {
                $rArr = [];
                foreach ($integrationsRestricted as $item) {
                    $cfg = json_decode($item['config'], 1);
                    if (!empty($cfg) && !empty($cfg['WEBHOOK_URL'])) {
                        $hook = $cfg['WEBHOOK_URL'];
                        $url = parse_url($hook);
                        if (is_array($url))
                            $rArr[] = $url['host'];
                    }
                }
            }
        }
        $filters = ['AND'];
        if (!empty($_GET['filters'])) {
            $f = $_GET['filters'];
            if (!empty($f['source']))
                $filters[] = ['like', 'source', "%{$f['source']}%", false];
            if (!empty($f['source_exclude'])) {
                $sourcesArr = explode(',', str_replace(' ', '', $f['source_exclude']));
                $buf = ['AND'];
                foreach ($sourcesArr as $src) {
                    $buf[] = ['not like', 'source', "%{$src}%", false];
                }
                $filters[] = $buf;
            }
            if (!empty($f['region']))
                $filters[] = ['like', 'region', "%{$f['region']}%", false];
            if (!empty($f['start_date']))
                $filters[] = ['>=', 'date', date('Y-m-d 00:00:00', strtotime($f['start_date']))];
            if (!empty($f['stop_date']))
                $filters[] = ['<=', 'date', date('Y-m-d 23:59:59', strtotime($f['stop_date']))];
            if (!empty($f['empty_log']))
                $filters[] = ['OR', ['is', 'log', null], ['log' => '']];
            if (!empty($f['drop_restricted'])) {
                if (!empty($rArr)) {
                    $buf = ['AND'];
                    foreach ($rArr as $item) {
                        $buf[] = ['!=', 'source', "$item"];
                    }
                    $filters[] = $buf;
                }
            }
        }
        $query = DealsBackdoor::find()
            ->orderBy('id desc')
            ->where($filters)
            ->asArray();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(empty($_GET['setPageSize']) ? 100 : $_GET['setPageSize']);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('backdoor-deals', ['models' => $models, 'pages' => $pages, 'count' => $countQuery->count(), 'rArr' => $rArr ?? []]);
    }



/*
    public function actionSubmitWaste() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['keys'])) {
            $functions = new Admin('leads');
            return $functions->wasteLead($_POST['keys']);
        } else
            return ['status' => 'error', 'message' => 'Пустая выборка.'];
    }*/

    public function actionConfirmStatusWaste() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['id'])) {
            $functions = new Admin('leads');
            return $functions->wasteLead($_POST['id']);
        } else
            return ['status' => 'error', 'message' => 'Пустая выборка.'];
    }

    public function actionCcSend() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['keys'])) {
            $functions = new Admin('contact-center');
            return $functions->sendCC($_POST['keys']);
        } else
            return ['status' => 'error', 'message' => 'Пустая выборка.'];
    }

    public function actionAuctionSend() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['keys']) && !empty($_POST['price'])) {
            $functions = new Admin('leads');
            return $functions->auctionSend($_POST['keys'], $_POST['price']);
        } else
            return ['status' => 'error', 'message' => 'Пустая выборка.'];
    }

    public function actionAlias($id) {
        $model = $this->findModel($id);
        return $this->render('alias', ['model' => $model]);
    }

    public function actionBackdoorActive() {
        $hooks = BackdoorHooks::find()
            ->where(['OR', ['status' => 1], ['status' => '0']])
            ->asArray()
            ->all();
        return $this->render('backdoor-active', ['hooks' => $hooks]);
    }

    public function actionUseBackdoorAction() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['data']) || empty($_POST['type']) || empty($_POST['typeLead']))
            return ['status' => "error", 'message' => 'Пустая выборка'];
        parse_str($_POST['data'], $query);
        if (!empty($_POST['typeBackdoor']))
            $md = DealsBackdoor::find();
        else
            $md = LeadsBackdoor::find();
        switch ($_POST['type']) {
            default:
            case 'send-to-cc':
                if (!empty($query['id'])) {
                    $leads = $md
                        ->where(['in', 'id', $query['id']])
                        ->all();
                    foreach ($leads as $item) {
                        $cc = new CcLeads();
                        $cc->source = !empty($_POST['sourceLead']) ? $_POST['sourceLead'] : $item->source;
                        $cc->utm_source = "backdoor";
                        $cc->utm_campaign = $item->source;
                        $cc->name = $item->name;
                        $cc->phone = $item->phone;
                        $cc->region = $item->region;
                        $cc->category = $_POST['typeLead'];
                        if ($cc->save()) {
                            $item->log = !empty($item->log) ? $item->log . "<hr style='margin-top: 7px; margin-bottom: 7px'>". date('d.m.Y H:i') ."<br>Отправлен в КЦ {$_POST['typeLead']}" : date('d.m.Y H:i') ."<br>Отправлен в КЦ {$_POST['typeLead']}";
                            $item->save();
                        }
                    }
                }
                break;
            case 'send-to-table':
                if (!empty($query['id'])) {
                    $leads = $md
                        ->where(['in', 'id', $query['id']])
                        ->all();
                    foreach ($leads as $item) {
                        $cc = new LeadsSave();
                        $cc->source = !empty($_POST['sourceLead']) ? $_POST['sourceLead'] : $item->source;
                        $cc->utm_source = "backdoor";
                        $cc->name = $item->name;
                        $cc->ip = '127.0.0.1';
                        $cc->status = Leads::STATUS_NEW;
                        $cc->phone = $item->phone;
                        $cc->region = $item->region;
                        $cc->type = $_POST['typeLead'];
                        $cc->comments = $item->comments;
                        if ($cc->save()) {
                            $bb = new BasesBackdoorHandle();
                            $bb->region = $item->region;
                            $bb->type = "handle";
                            $bb->save();
                            $item->log = !empty($item->log) ? $item->log . "<hr style='margin-top: 7px; margin-bottom: 7px'>". date('d.m.Y H:i') ."<br>Отправлен в таблицу {$_POST['typeLead']}" : date('d.m.Y H:i') ."<br>Отправлен в таблицу {$_POST['typeLead']}";
                            $item->save();
                        }
                    }
                }
                break;
        }
        return ['status' => 'success'];
    }

    public function actionSaveNewHook() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['url']))
            return ['status' => 'error', 'message' => 'URL не указан'];
        if (filter_var($_POST['url'], FILTER_VALIDATE_URL) === false)
            return ['status' => 'error', 'message' => 'Указан не валидный URL. Пример - https://cfs.bitrix24.ru/rest/11816/owy8ssv5onynllfs/'];
        $hook = new BackdoorHooks();
        $url = trim($_POST['url']);
        $lastSign = substr($url, -1);
        if ($lastSign === '/')
            $url = substr($url, 0, strlen($url) - 1);
        $hook->url = $url;
        $hook->user_id = 0;
        $hook->status = 0;
        $hook->first_try_passed = 0;
        if ($hook->save())
            return ['status' => 'success'];
        else
            return ['status' => 'error', 'message' => 'Ошибка сохранения'];
    }

    public function actionMonthlyKpi() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $dates = new \DateTime();
        $dates->modify('last day of this month');
        $lastDay = $dates->format('Y-m-d 23:59:59');
        $firstDay = date("Y-m-01 00:00:00");
        Orders::$dayStart = $firstDay;
        Orders::$dayEnd = $lastDay;
        $orders = Orders::find()->where(['!=', 'archive', 1])->all();
        $begin = new DateTime( $firstDay );
        $end = new DateTime( $lastDay );
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);
        $datesValid = [];
        foreach ($daterange as $date) {
            $wd = (int)date('w', strtotime($date->format("d.m.Y")));
            if ($wd !== 0 && $wd !== 6)
                $datesValid[] = $date->format("d.m.Y");
        }
        if (!empty($orders)) {
            $orderArr = [];
            /**
             * @var Orders $item
             */
            foreach ($orders as $item) {
                $params = json_decode($item->params_special, 1);
                $order_name = !empty($item->order_name) ? "#{$item->id} {$item->order_name}" : "#{$item->id} {$item->category_text}";
                if (!empty($params) && !empty($params['daily_leads_min']))
                    $dailyMin = (int)$params['daily_leads_min'];
                else
                    $dailyMin = 0;
                foreach ($datesValid as $date) {
                    $orderArr[$order_name][$date] = [
                        'daily' => $dailyMin,
                        'count' => 0,
                        'percentage' => 0
                    ];
                }
                $orderArr[$order_name]['total'] = 0;
                if (!empty($item->kpi)) {
                    foreach ($item->kpi as $k) {
                        $leadDate = date('d.m.Y', strtotime($k->date));
                        if (isset($orderArr[$order_name][$leadDate])) {
                            $orderArr[$order_name][$leadDate]['count']++;
                            if ($orderArr[$order_name][$leadDate]['daily'] > 0)
                                $orderArr[$order_name][$leadDate]['percentage'] = round($orderArr[$order_name][$leadDate]['count'] / $orderArr[$order_name][$leadDate]['daily'], 2)*100;
                            else
                                $orderArr[$order_name][$leadDate]['percentage'] = 100;
                            $orderArr[$order_name]['total'] = round(($orderArr[$order_name][$leadDate]['percentage'] + $orderArr[$order_name]['total']) / count($orderArr[$order_name]), 2);
                        }
                    }
                }
            }
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValueByColumnAndRow(1, 1, 'Заказ');
            $sheet->getStyleByColumnAndRow(1, 1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('303030');
            $sheet->getStyleByColumnAndRow(1, 1)
                ->getFont()
                ->getColor()
                ->setARGB('ffffff');
            $sheet->getColumnDimensionByColumn(1)->setAutoSize(true);
            foreach ($datesValid as $key => $date) {
                $sheet->setCellValueByColumnAndRow($key + 2, 1, $date);
                $sheet->getStyleByColumnAndRow($key + 2, 1)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('303030');
                $sheet->getStyleByColumnAndRow($key + 2, 1)
                    ->getFont()
                    ->getColor()
                    ->setARGB('ffffff');
            }
            $sheet->setCellValueByColumnAndRow($key + 3, 1, 'Средний показатель');
            $sheet->getStyleByColumnAndRow($key + 3, 1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('303030');
            $sheet->getStyleByColumnAndRow($key + 3, 1)
                ->getFont()
                ->getColor()
                ->setARGB('ffffff');
            $currentRow = 2;
            $sheet->freezePaneByColumnAndRow(1, 2);
            foreach ($orderArr as $key => $item) {
                $sheet->setCellValueByColumnAndRow(1, $currentRow, $key);
                $sheet->getColumnDimensionByColumn(1)->setAutoSize(true);
                $currentCol = 2;
                foreach ($item as $dateVal => $KPI) {
                    if ($dateVal !== 'total') {
                        $print = "{$KPI['count']}/{$KPI['daily']} ({$KPI['percentage']}%)";
                        $sheet->setCellValueByColumnAndRow($currentCol, $currentRow, $print);
                        if ($KPI['count'] >= $KPI['daily']) {
                            $sheet->getStyleByColumnAndRow($currentCol, $currentRow)
                                ->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()
                                ->setARGB('f6fff0');
                            $sheet->getStyleByColumnAndRow($currentCol, $currentRow)
                                ->getBorders()
                                ->getOutline()
                                ->setBorderStyle(Border::BORDER_THIN);
                        } else {
                            $sheet->getStyleByColumnAndRow($currentCol, $currentRow)
                                ->getFill()
                                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                                ->getStartColor()
                                ->setARGB('fff0f0');
                            $sheet->getStyleByColumnAndRow($currentCol, $currentRow)
                                ->getBorders()
                                ->getOutline()
                                ->setBorderStyle(Border::BORDER_THIN);
                        }
                    } else {
                        $print = "{$KPI}%";
                        $sheet->setCellValueByColumnAndRow($currentCol, $currentRow, $print);
                        $sheet->getStyleByColumnAndRow($currentCol, $currentRow)
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB('f0fcff');
                        $sheet->getStyleByColumnAndRow($currentCol, $currentRow)
                            ->getBorders()
                            ->getOutline()
                            ->setBorderStyle(Border::BORDER_THIN);
                    }
                    $sheet->getColumnDimensionByColumn($currentCol)->setAutoSize(true);
                    $currentCol++;
                }
                $currentRow++;
            }
            $writer = new Xlsx($spreadsheet);
            $path = "xlsx/kpi.xlsx";
            $writer->save($path);
            return ['status' => 'success', 'url' => "/$path"];
        } else
            return ['status' => 'error', 'message' => 'Лиды не найдены'];
    }

    public function actionMonthlyKpiV2() { //#TODO MISHA
        Yii::$app->response->format = Response::FORMAT_JSON;
        $dates00 = new \DateTime();
        $dates00->modify('-0 month');
        $getM = $dates00->format("m");
        $dates = new \DateTime($dates00->format('Y-m-d'));
        $dates->modify('last day of this month');
        $lastDay = $dates->format('Y-m-d 23:59:59');
        $firstDay = date("Y-{$getM}-01 00:00:00");
        $begin = new DateTime( $firstDay );
        $end = new DateTime( $lastDay );
        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval, $end);
        $datesValid = [];
        foreach ($daterange as $date) {
            $datesValid[] = $date->format("d.m.Y");
        }
        Orders::$daysArray = $datesValid;
        $orders = Orders::find()->where(['archive' => 0])->all();
        if (!empty($orders)) {
            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValueByColumnAndRow(1, 1, 'Заказ');
            $sheet->getStyleByColumnAndRow(1, 1)
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('303030');
            $sheet->getStyleByColumnAndRow(1, 1)
                ->getFont()
                ->getColor()
                ->setARGB('ffffff');
            $sheet->getColumnDimensionByColumn(1)->setAutoSize(true);
            foreach ($datesValid as $key => $date) {
                $sheet->setCellValueByColumnAndRow($key + 2, 1, $date);
                $sheet->getStyleByColumnAndRow($key + 2, 1)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('303030');
                $sheet->getStyleByColumnAndRow($key + 2, 1)
                    ->getFont()
                    ->getColor()
                    ->setARGB('ffffff');
                $sheet->getColumnDimensionByColumn($key + 2)->setAutoSize(true);
            }
            $colorize = [3,4,5];
            $sheet->setCellValueByColumnAndRow($key + 3, 1, 'KPI (перегруз)');
            $sheet->setCellValueByColumnAndRow($key + 4, 1, 'KPI');
            $sheet->setCellValueByColumnAndRow($key + 5, 1, 'KPI (средний)');
            foreach ($colorize as $j) {
                $sheet->getStyleByColumnAndRow($key + $j, 1)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('303030');
                $sheet->getStyleByColumnAndRow($key + $j, 1)
                    ->getFont()
                    ->getColor()
                    ->setARGB('ffffff');
                $sheet->getColumnDimensionByColumn($key + $j)->setAutoSize(true);
            }
            $currentRow = 2;
            $sheet->freezePaneByColumnAndRow(1, 2);
            /**
             * @var Orders $item
             */
            $countArray = [];
            foreach ($orders as $key => $item) {
                $order_name = !empty($item->order_name) ? "#{$item->id} {$item->order_name}" : "#{$item->id} {$item->category_text}";
                foreach ($datesValid as $dateItem) {
                    $countArray[$order_name][$dateItem] = null;
                }
                if (!empty($item->kpiV2)) {
                    /**
                     * @var StatisticsDaily $v
                     */
                    foreach ($item->kpiV2 as $k => $v) {
                        $countArray[$order_name][$v->date] = $v;
                    }
                    foreach ($datesValid as $dateItem) {
                        if (!isset($countArray[$order_name][$dateItem]))
                            $countArray[$order_name][$dateItem] = null;
                    }
                }
            }
            $checkDatesArray = [];
            for ($i = 2; $i < count($datesValid); $i++)
                $checkDatesArray[$i] = $datesValid[$i - 2];
            if (!empty($countArray)) {
                $totalKpi = [];
                foreach ($countArray as $orderName => $dates) {
                    $kpi1[$orderName] = [];
                    $kpi2[$orderName] = [];
                    $kpi3[$orderName] = [];
                    $sheet->setCellValueByColumnAndRow(1, $currentRow, $orderName);
                    $sheet->getColumnDimensionByColumn(1)->setAutoSize(true);
                    $currentCol = 2;
                    /**
                     * @var StatisticsDaily|null $object
                     */
                    foreach ($dates as $dateVal => $object) {
                        if (!empty($object)) {
                            $print = "{$object->count}/{$object->min_order}({$object->min}) [{$object->percent_order}% / {$object->percent}%]";
                            $sheet->setCellValueByColumnAndRow($currentCol, $currentRow, $print);
                            $kpi1[$orderName][] = $object->percent;
                            $kpi2[$orderName][] = $object->percent_order;
                            $srKpi = round(($object->percent_order + $object->percent) / 2, 0);
                            $kpi3[$orderName][] = $srKpi;
                            if ($object->count >= $object->min_order) {
                                $color = 'ecffef';
                            } else
                                $color = 'ffecec';
                        } else {
                            $sheet->setCellValueByColumnAndRow($currentCol, $currentRow, "Н/Д");
                            $color = 'fafafa';
                        }
                        $sheet->getStyleByColumnAndRow($currentCol, $currentRow)
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB($color);
                        $sheet->getStyleByColumnAndRow($currentCol, $currentRow)
                            ->getBorders()
                            ->getOutline()
                            ->setBorderStyle(Border::BORDER_THIN);
                        $sheet->getColumnDimensionByColumn($currentCol)->setAutoSize(true);
                        $currentCol++;
                    }
                    if (!empty($kpi1[$orderName])) {
                        $sheet->setCellValueByColumnAndRow($currentCol, $currentRow, round(array_sum($kpi1[$orderName]) / count($kpi1[$orderName]), 0) . " %");
                        $c[0] = 'f0f8ff';
                    } else {
                        $sheet->setCellValueByColumnAndRow($currentCol, $currentRow, "Н/Д");
                        $c[0] = 'fafafa';
                    }
                    if (!empty($kpi2[$orderName])) {
                        $sheet->setCellValueByColumnAndRow($currentCol + 1, $currentRow, round(array_sum($kpi2[$orderName]) / count($kpi2[$orderName]), 0) . " %");
                        $c[1] = 'f0f8ff';
                    } else {
                        $c[1] = 'fafafa';
                        $sheet->setCellValueByColumnAndRow($currentCol + 1, $currentRow, "Н/Д");
                    }
                    if (!empty($kpi3[$orderName])) {
                        $srKpiTotal = round(array_sum($kpi3[$orderName]) / count($kpi3[$orderName]), 0);
                        $totalKpi[] = $srKpiTotal;
                        $sheet->setCellValueByColumnAndRow($currentCol + 2, $currentRow, $srKpiTotal . " %");
                        $c[2] = 'f0f8ff';
                    } else {
                        $sheet->setCellValueByColumnAndRow($currentCol + 2, $currentRow, "Н/Д");
                        $c[2] = 'fafafa';
                    }
                    $newColor = [0,1,2];
                    foreach ($newColor as $p) {
                        $sheet->getStyleByColumnAndRow($currentCol + $p, $currentRow)
                            ->getFill()
                            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                            ->getStartColor()
                            ->setARGB($c[$p]);
                        $sheet->getStyleByColumnAndRow($currentCol + $p, $currentRow)
                            ->getBorders()
                            ->getOutline()
                            ->setBorderStyle(Border::BORDER_THIN);
                        $sheet->getColumnDimensionByColumn($currentCol + $p)->setAutoSize(true);
                    }
                    $currentRow++;
                }
                if (!empty($totalKpi))
                    $sheet->setCellValueByColumnAndRow($currentCol + 2, $currentRow, round(array_sum($totalKpi) / count($totalKpi), 0) . " %");
                else
                    $sheet->setCellValueByColumnAndRow($currentCol + 2, $currentRow, "Н/Д");
                $sheet->getStyleByColumnAndRow($currentCol + 2, $currentRow)
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('f9fff0');
                $sheet->getStyleByColumnAndRow($currentCol + 2, $currentRow)
                    ->getBorders()
                    ->getOutline()
                    ->setBorderStyle(Border::BORDER_THIN);
                $sheet->getColumnDimensionByColumn($currentCol + 2)->setAutoSize(true);
                $writer = new Xlsx($spreadsheet);
                $path = "xlsx/kpi-V2.xlsx";
                $writer->save($path);
                return ['status' => 'success', 'url' => "/$path"];
            } else
                return ['status' => 'error', 'message' => 'Данные для выгрузки не найдены'];
        } else
            return ['status' => 'error', 'message' => 'Заказы не найдены'];
    }

    public function actionFixJsonLead()
    {
        $lead = Leads::find()->where(['like', 'region', '%Чувашия%', false])->asArray()->select('params')->all();
        echo '<pre>';
        print_r($lead);
    }

    public function actionChangeLogVisibility() {
        $_SESSION['log_hidden'] = !isset($_SESSION['log_hidden']) || !$_SESSION['log_hidden'];
    }

    public function actionChangeLogVisibility0() {
        $_SESSION['log_hidden0'] = !isset($_SESSION['log_hidden0']) || !$_SESSION['log_hidden0'];
    }

    public function actionLtv() {
        $self = Yii::$app->getUser()->getId();
        $this->view->title = "LTV";
        $clients = Clients::find()->where(['attached_seller' => $self])->asArray()->all();
        $products = SellerProducts::find()->where(['seller_id' => $self])->asArray()->all();
        if (!empty($clients) && !empty($products)) {
            $productsAssign = [];
            foreach ($products as $l => $item) {
                $productsAssign[$item['client_id']][date("Y-m", strtotime($item['date']))][] = [
                    'id' => $item['id'],
                    'name' => $item['name'],
                    'summ' => $item['summ'],
                    'date' => date('d.m.Y', strtotime($item['date'])),
                ];
            }
            foreach ($clients as $item) {
                $startDate = date_create(SellerProducts::find()->where(['seller_id' => $self, 'client_id' => $item['id']])->asArray()->one()['date']);
                $endDate = date_create(SellerProducts::find()->where(['seller_id' => $self, 'client_id' => $item['id']])->orderBy('id desc')->asArray()->one()['date']);
                $datesTrue[$item['id']] = [];
                $interval = DateInterval::createFromDateString('1 month');
                $daterange = new DatePeriod($startDate, $interval, $endDate->modify("+1 day"));
                foreach ($daterange as $d) {
                    $datesTrue[$item['id']][] = $d->format("Y-m");
                }
            }
        }
        return $this->render('ltv', ['productsAssign' => $productsAssign ?? null, 'clients' => $clients, 'dates' => $datesTrue ?? null]);
    }

    public function actionLtvSave()
    {
        $p = $_POST;
        if (isset($p['id'])) {
            if ((empty($p['id']) || !isset($p['value']))) {
                return $this->asJson(['status' => false, 'message' => 'Не указаны обязательные параметры. Обратитесь в тех поддержку']);
            }
        } else {
            if (isset($p['saver-client'])) {
                if (empty($p['saver-prodname']) || empty($p['saver-summ']) || empty($p['saver-client']))
                    return $this->asJson(['status' => false, 'message' => 'Не указаны обязательные параметры. Обратитесь в тех поддержку']);
            }
        }
        if (!empty($p['saver-prodname'])) {
            $product = new SellerProducts();
            $product->name = $p['saver-prodname'];
            $product->summ = (float)$p['saver-summ'];
            $product->seller_id = Yii::$app->getUser()->getId();
            $product->client_id = (int)$p['saver-client'];
            $rsp = $product->save();
        } else {
            $product = SellerProducts::findOne(['id' => $p['id']]);
            if (empty($product))
                return $this->asJson(['status' => false, 'message' => 'Продукт был удален или более не актуален. Обновите страницу']);
            $product->summ = (float)$p['value'];
            $rsp = $product->save();
        }
        return $this->asJson(['status' => $rsp, 'message' => $rsp ? "" : 'Ошибка сохранения. Обратитесь в тех поддержку']);
    }

    public function actionLtvAddForm() {
        return $this->renderAjax('ltv-add-form', ['id' => $_REQUEST['id']]);
    }

}
