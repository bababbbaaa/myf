<?php

namespace admin\modules\lead_force\controllers;

use admin\controllers\AccessController;
use Yii;
use common\models\LeadTypes;
use common\models\LeadTypesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OfferTypeController implements the CRUD actions for LeadTypes model.
 */
class OfferTypeController extends AccessController
{
    /**
     * {@inheritdoc}
     */

    /**
     * Lists all LeadTypes models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LeadTypesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LeadTypes model.
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
     * Creates a new LeadTypes model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LeadTypes();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->category_link === 'chardjbek') {
                $model->regions = '["Любой"]';
                $model->params = json_encode(['geo' => !empty($model->geo) ? $model->geo : "Любой"], JSON_UNESCAPED_UNICODE);
            } else {
                if (empty($model->regions) || $model->regions === '[]')
                    $model->regions = '["Любой"]';
                $model->params = null;
            }
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LeadTypes model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->category_link === 'chardjbek') {
                $model->regions = '["Любой"]';
                $model->params = json_encode(['geo' => !empty($model->geo) ? $model->geo : "Любой"], JSON_UNESCAPED_UNICODE);
            } else {
                if (empty($model->regions) || $model->regions === '[]')
                    $model->regions = '["Любой"]';
                $model->params = null;
            }
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LeadTypes model.
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
     * Finds the LeadTypes model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LeadTypes the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LeadTypes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
