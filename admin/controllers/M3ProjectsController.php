<?php

namespace admin\controllers;

use common\models\M3Costs;
use Yii;
use common\models\M3Projects;
use common\models\M3ProjectsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * M3ProjectsController implements the CRUD actions for M3Projects model.
 */
class M3ProjectsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all M3Projects models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new M3ProjectsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single M3Projects model.
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
     * Creates a new M3Projects model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new M3Projects();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing M3Projects model.
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
     * Deletes an existing M3Projects model.
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
     * Finds the M3Projects model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return M3Projects the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = M3Projects::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDelItem() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['id'])) {
            $del = M3Costs::findOne($_POST['id']);
            if (!empty($del)) {
                if ($del->delete())
                    return ['status' => 'success'];
            }
        }
        return ['status' => 'error', 'message' => 'Что-то пошло не так :)'];
    }

    public function actionNewItem() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['project'])) {
            $costs = new M3Costs();
            $costs->project_id = (int)$_POST['project'];
            if ($costs->save())
                return ['status' => 'success'];
        }
        return ['status' => 'error', 'message' => "Что-то пошло не так :) "];
    }

    public function actionUpdateItem() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['id']) && !empty($_POST['val']) && !empty($_POST['data'])) {
            $costs = M3Costs::findOne($_POST['id']);
            $costs->{$_POST['val']} = $_POST['val'] === 'value' ? (float)$_POST['data'] : $_POST['data'];
            if ($costs->update() !== false)
                return ['status' => 'success'];
        }
        return ['status' => 'error', 'message' => "Что-то пошло не так :) "];

    }
}
