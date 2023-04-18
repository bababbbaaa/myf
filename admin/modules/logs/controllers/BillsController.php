<?php

namespace admin\modules\logs\controllers;

use admin\controllers\AccessController;
use common\models\BudgetLog;
use common\models\disk\Cloud;
use common\models\JobsQueue;
use common\models\User;
use common\models\UsersBonuses;
use common\models\UsersCertificates;
use common\models\UsersNotice;
use Yii;
use common\models\UsersBills;
use common\models\UsersBillsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * BillsController implements the CRUD actions for UsersBills model.
 */
class BillsController extends AccessController
{

    /**
     * Lists all UsersBills models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UsersBillsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id'=>SORT_DESC]]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single UsersBills model.
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
     * Deletes an existing UsersBills model.
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
     * Finds the UsersBills model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return UsersBills the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UsersBills::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionCreateAct($id) {
        $model = $this->findModel($id);
        $cloud = new Cloud($model->user_id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = json_decode($model->act_data, true);
        if ($data !== null) {
            $file = $cloud->create__jur__act($data);
            $act = new UsersCertificates();
            $act->name = "Акт по счету №{$data['id']} от {$data['day']} {$data['month']} {$data['year']}";
            $act->user_id = $model->user_id;
            $act->link = $file['download'];
            if (!in_array('error', $file)) {
                if (file_exists($file['real']) && $act->save()) {
                    $queue = new JobsQueue();
                    $queue->method = "act__mailer";
                    $queue->params = json_encode(['id' => $act->id], JSON_UNESCAPED_UNICODE);
                    $queue->date_start = date("Y-m-d H:i:s");
                    $queue->status = 'wait';
                    $queue->user_id = $act->user_id;
                    $queue->closed = 0;
                    $queue->save();
                    $rsp = ['status' => 'success', '__object' => $act->id, 'url' => $file['download']];
                } else
                    $rsp = ['status' => 'error', 'message' => 'Ошибка сохранения акта'];
            } else
                $rsp = ['status' => 'error', 'message' => 'Ошибка сети. Повторите попытку позже'];
        } else
            return ['status' => 'error', 'message' => 'Данные счета не могут быть определены'];
        return $rsp;
    }

    public function actionAddFunds($id) {
        $model = $this->findModel($id);
        $cloud = new Cloud($model->user_id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        $user = User::findOne($model->user_id);
        if (!empty($user)) {
            $cashback = 0;
            $bonus = UsersBonuses::findOne(['user_id' => $user->id]);
            if (!empty($bonus) && !empty($bonus->cashback))
                $cashback = $bonus->cashback;
            $b_ID = json_decode($model->act_data, 1)['id'];
            $model->status = $model::STATUS_CONFIRMED;
            $was = $user->budget;
            $user->budget += (float)$model->value + (float)(round($cashback * $model->value * 0.01, 0));
            $budget_log = new BudgetLog();
            if (empty($cashback))
                $budget_log->text = "Пополнение баланса - оплата счета №{$b_ID}: +". round($model->value, 2) ." руб.";
            else
                $budget_log->text = "Пополнение баланса - оплата счета №{$b_ID}: +". round($model->value, 2) ." (+ кэшбек {$cashback}%) руб.";
            $budget_log->budget_was = $was;
            $budget_log->user_id = $user->id;
            $budget_log->budget_after = $user->budget;
            $notice = new UsersNotice();
            $notice->user_id = $user->id;
            $notice->type = UsersNotice::TYPE_INCOME_BUDGET;
            $notice->text = "Пополнение баланса - оплата счета №{$b_ID}: +". round($model->value, 2) ." руб.";
            if ($user->update() !== false && $model->update() !== false && $notice->save() && $budget_log->save())
                $rsp = ['status' => 'success'];
            else
                $rsp = ['status' => 'error', 'message' => 'Ошибка сохранения данных'];
        } else
            $rsp = ['status' => 'error', 'message' => 'Пользователь не найден'];
        return $rsp;
    }

}
