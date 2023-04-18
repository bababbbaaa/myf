<?php

namespace admin\modules\lead_force\controllers;

use admin\controllers\AccessController;
use common\models\Leads;
use common\models\LeadsSentReport;
use common\models\OffersAlias;
use common\models\Providers;
use Yii;
use common\models\Offers;
use common\models\OffersSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * OffersController implements the CRUD actions for Offers model.
 */
class OffersController extends AccessController
{
    /**
     * {@inheritdoc}
     */


    /**
     * Lists all Offers models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OffersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Offers model.
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
     * Creates a new Offers model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Offers();

        if ($model->load(Yii::$app->request->post())) {
            if ($model->category === 'chardjbek') {
                $model->regions = '["Любой"]';
                $model->special_params = json_encode(['geo' => !empty($model->geo) ? $model->geo : "Любой"], JSON_UNESCAPED_UNICODE);
            } else {
                if (empty($model->regions) || $model->regions === '[]')
                    $model->regions = '["Любой"]';
                $model->special_params = null;
            }
            $model->leads_waste = 0;
            $model->leads_confirmed = 0;
            $model->leads_total = 0;
            $model->total_payed = 0;
            if (empty($model->offer_id))
                $model->offer_id = null;
            $provider = Providers::findOne(['user_id' => $model->user_id]);
            if (!empty($provider))
                $model->provider_id = $provider->id;
            $model->createOfferToken();
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
            else {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $model->errors;
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Offers model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->category === 'chardjbek') {
                $model->regions = '["Любой"]';
                $model->special_params = json_encode(['geo' => !empty($model->geo) ? $model->geo : "Любой"], JSON_UNESCAPED_UNICODE);
            } else {
                if (empty($model->regions) || $model->regions === '[]')
                    $model->regions = '["Любой"]';
                $model->special_params = null;
            }
            $model->leads_waste = 0;
            $model->leads_confirmed = 0;
            $model->leads_total = 0;
            $model->total_payed = 0;
            if (empty($model->offer_id))
                $model->offer_id = null;
            $provider = Providers::findOne(['user_id' => $model->user_id]);
            if (!empty($provider))
                $model->provider_id = $provider->id;
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
            else
                return $model->errors;
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDetailView($id) {
        $offer = Offers::findOne($id);
        if (!empty($offer)) {
            $alias = OffersAlias::find()->where(['offer_id' => $id])->asArray()->all();
            $ids = [];
            foreach ($alias as $item)
                $ids[] = $item['lead_id'];
            $leads = LeadsSentReport::find()->where(['offer_id' => $id])->andWhere(['in', 'lead_id', $ids])->groupBy('lead_id')->asArray()->all();
            return $this->render('detail-view', ['offer' => $leads]);
        }
        else
            return $this->goHome();
    }

    /**
     * Deletes an existing Offers model.
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
     * Finds the Offers model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Offers the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Offers::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
