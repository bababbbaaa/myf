<?php

namespace admin\modules\lead_force\controllers;

use admin\controllers\AccessController;
use common\models\LeadsParams;
use Yii;
use common\models\LeadsCategory;
use common\models\LeadsCategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * LeadsCategoryController implements the CRUD actions for LeadsCategory model.
 */
class LeadsCategoryController extends AccessController
{

    protected static function mb_ucfirst($string){
        return mb_strtoupper(mb_substr($string, 0, 1)).mb_substr($string, 1);
    }

    /**
     * {@inheritdoc}
     */

    /**
     * Lists all LeadsCategory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LeadsCategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single LeadsCategory model.
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
     * Creates a new LeadsCategory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new LeadsCategory();
        if ($model->load(Yii::$app->request->post())) {
            $model->name = self::mb_ucfirst(mb_strtolower($model->name));
            $save = $model->save();
            $params = json_decode(stripslashes($model->params));
            if (!empty($params)) {
                foreach ($params as $param) {
                    $cParam = new LeadsParams();
                    $cParam->addParam($param, $model->link_name);
                    $cParam->save();
                    $errors[] = $cParam->errors;
                }
            }
            if ($save)
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing LeadsCategory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $model->name = self::mb_ucfirst(mb_strtolower($model->name));
            $save = $model->save();
            $params = json_decode(stripslashes($model->params));
            if (!empty($params)) {
                $names = [];
                foreach ($params as $param) {
                    $skipParam = LeadsParams::findOne(['name' => $param->name, 'category' => $model->link_name]);
                    $names[] = $param->name;
                    if (!empty($skipParam))
                        continue;
                    $cParam = new LeadsParams();
                    $cParam->addParam($param, $model->link_name);
                    $cParam->save();
                    $errors[] = $cParam->errors;
                }
                $removeParams = LeadsParams::find()->where(['AND', ['not in', 'name', $names], ['category' => $model->link_name]])->all();
                if (!empty($removeParams)) {
                    foreach ($removeParams as $rm)
                        $rm->delete();
                }
            } else {
                $removeParams = LeadsParams::find()->where(['category' => $model->link_name])->all();
                if (!empty($removeParams)) {
                    foreach ($removeParams as $rm)
                        $rm->delete();
                }
            }
            if($save)
                return $this->redirect(['view', 'id' => $model->id]);
        } else {
            $renderParams = LeadsParams::find()->where(['category' => $model->link_name])->all();
            if (!empty($renderParams)) {
                $arr = [];
                foreach ($renderParams as $item) {
                    $arr[] = $item->returnComposedObject();
                }
                $model->params = json_encode($arr, JSON_UNESCAPED_UNICODE);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing LeadsCategory model.
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
     * Finds the LeadsCategory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LeadsCategory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LeadsCategory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
