<?php

namespace admin\modules\logs\controllers;

use admin\controllers\AccessController;
use Yii;
use common\models\RobokassaResult;
use common\models\RobokassaResultSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RobokassaController implements the CRUD actions for RobokassaResult model.
 */
class RobokassaController extends AccessController
{

    /**
     * Lists all RobokassaResult models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RobokassaResultSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RobokassaResult model.
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
     * Finds the RobokassaResult model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RobokassaResult the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = RobokassaResult::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
