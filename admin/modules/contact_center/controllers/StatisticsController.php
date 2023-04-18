<?php

namespace admin\modules\contact_center\controllers;

use admin\controllers\AccessController;
use admin\models\Admin;
use common\behaviors\JsonQuery;
use common\models\Leads;
use common\models\UserModel;
use Yii;
use common\models\CcLeads;
use common\models\CcLeadsSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * StatisticsController implements the CRUD actions for CcLeads model.
 */
class StatisticsController extends AccessController
{
    /**
     * {@inheritdoc}
     */


    /**
     * Lists all CcLeads models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CcLeadsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['date_income'=>SORT_DESC]]);
        $dataProvider->pagination->pageSize = $_SESSION['pageSizeCC'] ?? 50;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CcLeads model.
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
     * Creates a new CcLeads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CcLeads();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CcLeads model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CcLeads model.
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
     * Finds the CcLeads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CcLeads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CcLeads::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionOpen() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['keys'])) {
            $functions = new Admin('contact-center');
            return $functions->openSelected($_POST['keys'], CcLeads::class);
        } else
            return ['status' => 'error', 'message' => 'Пустая выборка.'];
    }
    public function actionResetLeads() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['keys'])) {
            $functions = new Admin('contact-center');
            return $functions->resetLeads($_POST['keys'], CcLeads::class);
        } else
            return ['status' => 'error', 'message' => 'Пустая выборка.'];
    }

    public function actionExcelFiltration() {
        $operators = CcLeads::find()->select(['assigned_to'])->distinct()->asArray()->all();
        $opArray = [];
        if (!empty($operators)) {
           foreach ($operators as $item)
               $opArray[] = $item['assigned_to'];
           $names = UserModel::find()->where(['in', 'id', $opArray])->asArray()->all();
        }
        return $this->render('excel-filtration',
            [
                'names' => $names,
            ]);
    }

    public function actionExcelFiltrationUtm() {
        return $this->render('excel-filtration-utm');
    }

    public function actionImportExcel() {
        if (Yii::$app->request->isPost && !empty($_FILES['file'])) {
            $f = $_FILES['file'];
            if (pathinfo($f['name'], PATHINFO_EXTENSION) !== 'xlsx') {
                Yii::$app->session->setFlash('emptyResponse', 'Поддерживаемый формат файла - XLSX');
                return Yii::$app->response->redirect(Url::to(['import-excel']));
            }
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($f['tmp_name']);
            $data = $spreadsheet->getActiveSheet()->toArray();
            if (!empty($data)) {
                $propsArray = array_keys(CcLeads::xlsxAttributeLabels());
                foreach ($data as $key => $item) {
                    if ($key == 0)
                        continue;
                    $cc = new CcLeads();
                    for ($k = 1; $k < count($item); $k++) {
                        $dataArr['CcLeads'][$propsArray[$k]] = $item[$k];
                    }
                    $cc->load($dataArr);
                    $cc->save(false);
                }
                Yii::$app->session->setFlash('emptyResponse', 'Импорт выполнен');
            } else {
                Yii::$app->session->setFlash('emptyResponse', 'Пустой файл');
                return Yii::$app->response->redirect(Url::to(['import-excel']));
            }
        }
        return $this->render('import-excel');
    }

    public function actionImportXlsx() {
        if (Yii::$app->request->isPost && !empty($_FILES['file'])  && !empty($_POST['source']) && !empty($_POST['category']) && !empty($_POST['utm_source'])) {
            $f = $_FILES['file'];
            if (pathinfo($f['name'], PATHINFO_EXTENSION) !== 'xlsx') {
                Yii::$app->session->setFlash('emptyResponse', 'Поддерживаемый формат файла - XLSX');
                return Yii::$app->response->redirect(Url::to(['import-excel']));
            }
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $reader->setReadDataOnly(true);
            $spreadsheet = $reader->load($f['tmp_name']);
            $data = $spreadsheet->getActiveSheet()->toArray();
            if (!empty($data)) {
                foreach ($data as $key => $item) {
                    $cc = new CcLeads();
                    $cc->phone = preg_replace('/[^\d]+/', '', $item[0]);
                    if (empty($cc->phone))
                        continue;
                    $cc->name = $item[1];
                    $cc->source = $_POST['source'];
                    $cc->utm_source = $_POST['utm_source'];
                    $cc->category = $_POST['category'];
                    $cc->validate();
                    $cc->save(false);
                }
                Yii::$app->session->setFlash('emptyResponse', 'Импорт выполнен');
            } else {
                Yii::$app->session->setFlash('emptyResponse', 'Пустой файл');
                return Yii::$app->response->redirect(Url::to(['import-excel']));
            }
        }
        return $this->render('import-xlsx');
    }

    public function actionImportTxt() {
        if (Yii::$app->request->isPost && !empty($_FILES['file']) && !empty($_POST['source']) && !empty($_POST['category']) && !empty($_POST['utm_source']) ) {
            $f = $_FILES['file'];
            if (pathinfo($f['name'], PATHINFO_EXTENSION) !== 'txt') {
                Yii::$app->session->setFlash('emptyResponse', 'Поддерживаемый формат файла - TXT');
                return Yii::$app->response->redirect(Url::to(['import-txt']));
            }
            $data = file_get_contents($f['tmp_name']);
            $data = explode(PHP_EOL, $data);
            if (!empty($data)) {
                foreach ($data as $item) {
                    $phone = preg_replace("/[^0-9]/", '', (string)$item);
                    if (empty($phone))
                        continue;
                    $cc = new CcLeads();
                    $cc->phone = $phone;
                    $cc->source = $_POST['source'];
                    $cc->utm_source = $_POST['utm_source'];
                    $cc->category = $_POST['category'];
                    $cc->save();
                }
                Yii::$app->session->setFlash('emptyResponse', 'Импорт выполнен');
            } else {
                Yii::$app->session->setFlash('emptyResponse', 'Пустой файл');
                return Yii::$app->response->redirect(Url::to(['import-txt']));
            }
        }
        return $this->render('import-txt');
    }

    public function actionUseLeadExportFilter() {
        if (!empty($_POST['filter'])) {
            $filterArray = $_POST['filter'];
            $filters = ['AND'];
            $dateStart = !empty($filterArray['dateStart']) ? $filterArray['dateStart'] : date("2021-03-01 00:00:00");
            $dateStop = !empty($filterArray['dateStop']) ? $filterArray['dateStop'] : date("Y-m-d H:i:s", time() + 3600*24);
            if (!empty($filterArray['operator']))
                $filters[] = ['assigned_to' => (int)$filterArray['operator']];
            if (!empty($filterArray['utm']))
                $filters[] = ['like', 'utm_source', "{$filterArray['utm']}%", false];
            $leads = CcLeads::find();
            if (empty($filterArray['utm'])) {
                $timeFilter = ['AND'];
                $timeFilter[] = ['>=', 'date_outcome', $dateStart];
                $timeFilter[] = ['<=', 'date_outcome', $dateStop];
            } else {
                $timeFilter = ['AND'];
                $timeFilter[] = ['>=', 'date_income', $dateStart];
                $timeFilter[] = ['<=', 'date_income', $dateStop];
            }
            $filters[] = $timeFilter;
            $response = $leads
                ->where($filters)
                ->select(['id'])
                ->orderBy('id desc')
                ->asArray()
                ->batch();
            if(!empty($response)) {
                $ids = [];
                foreach ($response as $item) {
                    foreach ($item as $b) {
                        $ids[] = $b['id'];
                    }
                }
                if (!empty($ids)) {
                    $xlsxResponse = new Admin('contact-center');
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    $rx = $xlsxResponse->excelExport(json_encode($ids), CcLeads::class, false);
                    if (!empty($filterArray['utm'])) {
                        $removeLeads = CcLeads::find()
                            ->where(['in', 'id', $ids])
                            ->all();
                        foreach ($removeLeads as $item)
                            $item->delete();
                    }
                    return $rx;
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

    public function actionSetOperator() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['keys']) && !empty($_POST['op'])) {
            $functions = new Admin('contact-center');
            return $functions->setOP($_POST['keys'], $_POST['op']);
        } else
            return ['status' => 'error', 'message' => 'Пустая выборка.'];
    }

}
