<?php

namespace admin\modules\contact_center\controllers;

use admin\controllers\AccessController;
use common\models\AuthAssignment;
use common\models\User;
use Yii;
use common\models\UserModel;
use common\models\UserModelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SettingsController implements the CRUD actions for UserModel model.
 */
class SettingsController extends AccessController
{
    /**
     * {@inheritdoc}
     */


    /**
     * Lists all UserModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserModelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UserModel model.
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
     * Creates a new UserModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserModel();
        if ($model->load(Yii::$app->request->post())) {
            $user = new User();
            $fUser = UserModel::findOne(['username' => $model->username]);
            if (!empty($fUser))
                return $this->redirect(['view', 'id' => $fUser->id]);
            $user->username = $model->username;
            $user->email = $model->email;
            $user->setPassword($model->password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            if($user->save()/* && Yii::$app
                    ->mailer
                    ->compose(
                        ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                        ['user' => $user]
                    )
                    ->setFrom(['info@myforce.ru' => "My.Force" . ' Робот'])
                    ->setTo($model->email)
                    ->setSubject('Регистрация на проекте ' . "My.Force")
                    ->send()*/)
                $model = UserModel::findOne($user->id);
                $p = $_POST['UserModel'];
                $model->inner_name = $p['inner_name'];
                $model->cc_daily_max = $p['cc_daily_max'] ?? 15;
                $model->cc_daily_get = !empty($p['cc_daily_get']) ? $p['cc_daily_get'] : 0;
                $model->cc_status = $p['cc_status'];
                $model->update();
                $auth = new AuthAssignment(); #where(['item_name' => 'cc', 'user_id' => $id])->asArray()->one();
                $auth->item_name = 'cc';
                $auth->user_id = (string)$user->id;
                $auth->created_at = time();
                $auth->validate();
                $auth->save();
                return $this->redirect(['view', 'id' => $user->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing UserModel model.
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
     * Deletes an existing UserModel model.
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
     * Finds the UserModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UserModel::findOne($id)) !== null && UserModel::isOperator($id)) {
            return $model;
        }

        throw new NotFoundHttpException('Указанный пользователь не является оператором КЦ');
    }

    public function actionBan($id) {
        $model = self::findModel($id);
        $model->status = $model->status === 0 ? 10 : 0;
        $model->save();
        return $this->redirect('index');
    }
}
