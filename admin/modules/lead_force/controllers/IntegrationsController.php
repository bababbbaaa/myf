<?php

namespace admin\modules\lead_force\controllers;

use admin\controllers\AccessController;
use Yii;
use common\models\Integrations;
use common\models\IntegrationsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * IntegrationsController implements the CRUD actions for Integrations model.
 */
class IntegrationsController extends AccessController
{
    /**
     * {@inheritdoc}
     */

    /**
     * Lists all Integrations models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new IntegrationsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Integrations model.
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
     * Creates a new Integrations model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Integrations();

        if ($model->load(Yii::$app->request->post())) {
            if($model->integration_type === 'bitrix' || $model->integration_type === 'webhook') {
                if (!empty($model->url)) {
                    $json = json_decode($model->config, true);
                    $json['WEBHOOK_URL'] = $model->url;
                    $model->config = json_encode($json, JSON_UNESCAPED_UNICODE);
                    if($model->save())
                        return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('webhookEmpty', 'WEBHOOK-URL не указан');
                }
            } else {
                if($model->save())
                    return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Integrations model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->integration_type === 'bitrix' || $model->integration_type === 'webhook') {
                if (!empty($model->url)) {
                    $json = json_decode($model->config, true);
                    $json['WEBHOOK_URL'] = $model->url;
                    $model->config = json_encode($json, JSON_UNESCAPED_UNICODE);
                    if($model->save())
                        return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('webhookEmpty', 'WEBHOOK-URL не указан');
                }
            } else {
                if($model->save())
                    return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Integrations model.
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
     * Finds the Integrations model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Integrations the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Integrations::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
