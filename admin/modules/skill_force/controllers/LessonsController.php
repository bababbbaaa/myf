<?php

namespace admin\modules\skill_force\controllers;

use admin\controllers\AccessController;
use common\models\SkillTrainings;
use Yii;
use common\models\SkillTrainingsLessons;
use common\models\SkillTrainingsLessonsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * LessonsController implements the CRUD actions for SkillTrainingsLessons model.
 */
class LessonsController extends AccessController
{


    /**
     * Lists all SkillTrainingsLessons models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SkillTrainingsLessonsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SkillTrainingsLessons model.
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
     * Creates a new SkillTrainingsLessons model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SkillTrainingsLessons();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing SkillTrainingsLessons model.
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
     * Deletes an existing SkillTrainingsLessons model.
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
     * Finds the SkillTrainingsLessons model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SkillTrainingsLessons the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SkillTrainingsLessons::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetBlocks() {
        if (!empty($_POST['id'])) {
            $training = SkillTrainings::findOne($_POST['id']);
            if (!empty($training) && !empty($training->skillTrainingsBlocks)) {
                $html = '';
                foreach ($training->skillTrainingsBlocks as $item)
                    $html .= "<option value='{$item->id}'>{$item->name}</option>";
                return $html;
            }
        }
    }

//    public function actionChangeVideo()
//    {
//        $lessons = SkillTrainingsLessons::find()->where(['not like', 'video', '["%', false])->all();
//        foreach ($lessons as $v){
//            if (!empty($v->video)){
//                $v->video = "[\"{$v->video}\"]";
//            } else {
//                $v->video = '[]';
//            }
//                $v->update();
//        }
//    }

}
