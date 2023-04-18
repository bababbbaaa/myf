<?php

namespace admin\modules\cms\controllers;

use admin\controllers\AccessController;
use Yii;
use common\models\TgMessages;
use common\models\TgMessagesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TelegramController implements the CRUD actions for TgMessages model.
 */
class TelegramController extends AccessController
{
    /**
     * Lists all TgMessages models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TgMessagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TgMessages model.
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
     * Creates a new TgMessages model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TgMessages();

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($_POST['TgMessages']['daysToPublish'])) {
                $model->days_to_post = json_encode($_POST['TgMessages']['daysToPublish'], JSON_UNESCAPED_UNICODE);
            }
            $model->minimum_time = (int)$_POST['TgMessages']['minimum_time'];
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing TgMessages model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($_POST['TgMessages']['daysToPublish'])) {
                $model->days_to_post = json_encode($_POST['TgMessages']['daysToPublish'], JSON_UNESCAPED_UNICODE);
            }
            $model->minimum_time = (int)$_POST['TgMessages']['minimum_time'];
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TgMessages model.
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
     * Finds the TgMessages model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TgMessages the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TgMessages::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
