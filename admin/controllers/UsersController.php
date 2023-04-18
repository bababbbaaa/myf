<?php

namespace admin\controllers;

use common\models\BudgetLog;
use common\models\User;
use common\models\UsersBonuses;
use core\models\SignupForm;
use Yii;
use common\models\UserModel;
use common\models\UsersSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * UsersController implements the CRUD actions for UserModel model.
 */
class UsersController extends AccessController
{

    /**
     * Lists all UserModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id'=>SORT_DESC]]);
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

        if ($model->load(Yii::$app->request->post())) {
            $user = User::findOne($model->id);
            $user->username = $model->username;
            $user->email = $model->email;
            $user->setPassword($model->password);
            if($user->update())
                return $this->redirect(['view', 'id' => $user->id]);
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
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionBan($id)
    {
        $model = $this->findModel($id);
        if (!empty($model)) {
            $model->status = $model->status === User::STATUS_DELETED ? User::STATUS_ACTIVE : User::STATUS_DELETED;
            $model->update();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the UserModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UserModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     * @throws ForbiddenHttpException
     */
    protected function findModel($id)
    {
        if($id == Yii::$app->getUser()->getId() || $id == 1 ) {
            throw new ForbiddenHttpException('The requested page does not exist.');
        }
        if (($model = UserModel::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionSaveBonus($id) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = UsersBonuses::findOne(['user_id' => $id]);
        if (!empty($model)) {
            if ($model->load($_POST))  {
                if (!empty($model->additional_materials))
                    $model->additional_materials = json_encode($model->additional_materials, JSON_UNESCAPED_UNICODE);
                if ($model->validate() && $model->update() !== false)
                    return ['status' => 'success'];
                else
                    return ['status' => 'error', 'message' => $model->errors];
            } else
                return ['status' => 'error', 'message' => "Данные не могут быть загружены"];
        } else
            return ['status' => 'error', 'message' => 'Пользовательские данные не найдены'];
    }

    public function actionAddUserFunds() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['id']) && !empty($_POST['hash']) && !empty($_POST['value'])) {
            $hash = md5("{$_POST['id']}::asd4jdf");
            if ($hash !== $_POST['hash'])
                return ['status' => 'error', 'message' => 'Ошибка контрольной суммы'];
            else {
                $cashback = 0;
                if (!empty($_POST['cashback'])) {
                    $userbonus = UsersBonuses::findOne(['user_id' => $_POST['id']]);
                    if (!empty($userbonus))
                        $cashback = $userbonus->cashback;
                }
                $user = UserModel::findOne($_POST['id']);
                if (empty($user))
                    return ['status' => 'error', 'message' => 'Пользователь не найден'];
                $was = $user->budget;
                $user->budget = $user->budget + (float)$_POST['value'] + (round((float)($_POST['value'] * $cashback * 0.01), 0));
                $budget_log = new BudgetLog();
                if (empty($cashback))
                    $budget_log->text = "Пополнение баланса - модерация: +". round($_POST['value'], 2) ." руб.";
                else
                    $budget_log->text = "Пополнение баланса - модерация: +". round($_POST['value'], 2) ." (+ кэшбек {$cashback}%) руб.";
                $budget_log->budget_was = $was;
                $budget_log->user_id = $user->id;
                $budget_log->budget_after = $user->budget;
                $budget_log->save();
                if ($user->update() !== false)
                    return ['status' => 'success'];
                else
                    return ['status' => "error", 'message' => 'Ошибка сохранения'];
            }
        } else
            return ['status' => 'error', 'message' => 'Не указаны обязательные параметры'];
    }

    public function actionRemoveUserFunds() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['id']) && !empty($_POST['hash']) && !empty($_POST['value'])) {
            $hash = md5("{$_POST['id']}::nedfge33");
            if ($hash !== $_POST['hash'])
                return ['status' => 'error', 'message' => 'Ошибка контрольной суммы'];
            else {
                $user = UserModel::findOne($_POST['id']);
                if (empty($user))
                    return ['status' => 'error', 'message' => 'Пользователь не найден'];
                $was = $user->budget;
                $user->budget = $user->budget - (float)$_POST['value'];
                $budget_log = new BudgetLog();
                $budget_log->text = "Списание с баланса - модерация: -". round($_POST['value'], 2) ." руб.";
                $budget_log->budget_was = $was;
                $budget_log->user_id = $user->id;
                $budget_log->budget_after = $user->budget;
                $budget_log->save();
                if ($user->update() !== false)
                    return ['status' => 'success'];
                else
                    return ['status' => "error", 'message' => 'Ошибка сохранения'];
            }
        } else
            return ['status' => 'error', 'message' => 'Не указаны обязательные параметры'];
    }

}
