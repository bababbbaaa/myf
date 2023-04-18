<?php

namespace admin\modules\lead_force\controllers;

use admin\controllers\AccessController;
use common\models\LeadsRead;
use common\models\LeadsSave;
use Yii;
use common\models\VoiceLeads;
use common\models\VoiceLeadsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * VoiceLeadsController implements the CRUD actions for VoiceLeads model.
 */
class VoiceLeadsController extends AccessController
{

    /**
     * Lists all VoiceLeads models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VoiceLeadsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
        ]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VoiceLeads model.
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
     * Creates a new VoiceLeads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    /*public function actionCreate()
    {
        $model = new VoiceLeads();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }*/

    /**
     * Updates an existing VoiceLeads model.
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
     * Deletes an existing VoiceLeads model.
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
     * Finds the VoiceLeads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VoiceLeads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VoiceLeads::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionChangeStatusLead() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['id'])) {
            $model = VoiceLeads::findOne($_POST['id']);
            if (!empty($model)) {
                $model->status = $model->status === 0 ? -1 : 0;
                $model->save();
                return [
                    'status' => true,
                    'text' => $model->status === 0 ? 'В брак' : "Восстановить",
                    'class' => $model->status === 0 ? 'btn btn-admin-delete' : "btn btn-admin",
                    'color' => $model->status === 0 ? 'transparent' : "#ffe5e5",
                    'id' => $model->id
                ];
            }
        }
        return ['status' => false];
    }

    public function actionSendLead() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['id'])) {
            $model = VoiceLeads::findOne($_POST['id']);
            if (!empty($model)) {
                $lead = new LeadsRead();
                $lead->type = 'dolgi';
                $lead->source = 'ivr';
                $lead->ip = "127.0.0.1";
                $lead->date_income = date("Y-m-d H:i:s");
                $lead->name = $model->name;
                $lead->phone = $model->phone;
                $lead->region = $model->region;
                $lead->params = json_encode([
                    'sum' => $model->sum,
                    'ipoteka' => $model->ipoteka_zalog
                ], JSON_UNESCAPED_UNICODE);
                $lead->city = null;
                $lead->utm_source = null;
                $lead->autocall_check = 1;
                $lead->save();
                $model->status = 1;
                $model->save();
                return ['status' => true];
            }
        }
        return ['status' => false];
    }

    public function actionSendAllActual() {
        $voices = VoiceLeads::find()->where(['status' => 0])->all();
        if (!empty($voices)) {
            /**
             * @var VoiceLeads $item
             */
            foreach ($voices as $item) {
                $lead = new LeadsRead();
                $lead->type = 'dolgi';
                $lead->source = 'ivr';
                $lead->ip = "127.0.0.1";
                $lead->date_income = date("Y-m-d H:i:s");
                $lead->name = $item->name;
                $lead->phone = $item->phone;
                $lead->region = $item->region;
                $lead->params = json_encode([
                    'sum' => $item->sum,
                    'ipoteka' => $item->ipoteka_zalog
                ], JSON_UNESCAPED_UNICODE);
                $lead->city = null;
                $lead->utm_source = null;
                $lead->autocall_check = 1;
                $lead->save();
                $item->status = 1;
                $item->save();
            }
        }
        return $this->asJson(['status' => true]);
    }
}
