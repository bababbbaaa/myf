<?php

namespace admin\modules\support\controllers;

use admin\controllers\AccessController;
use common\models\DialoguePeerMessages;
use common\models\Offers;
use common\models\Orders;
use common\models\UsersBonuses;
use Yii;
use common\models\DialoguePeer;
use common\models\DialoguePeerSearch;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * DialoguesController implements the CRUD actions for DialoguePeer model.
 */
class DialoguesController extends AccessController
{
    /**
     * {@inheritdoc}
     */


    /**
     * Lists all DialoguePeer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DialoguePeerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DialoguePeer model.
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

    public function actionPostMessage() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $p = $_POST;
        if (!empty($p['message']) && !empty($p['user_id']) && !empty($p['peer_id']) && !empty($p['hash'])) {
            $hash = $p['hash'];
            $newHash = md5("{$p['user_id']}::{$p['peer_id']}::special_hash_to_prevent_hack::9mb21z");
            if ($hash !== $newHash)
                return ['status' => 'error', 'message' => 'Ошибка контрольной суммы'];
            else {
                $msg = new DialoguePeerMessages();
                $msg->user_id = $p['user_id'];
                $msg->peer_id = $p['peer_id'];
                $msg->message = $p['message'];
                $msg->isSupport = 1;
                $msg->save();
                return ['status' => 'success'];
            }
        } else
            return ['status' => 'error', 'message' => 'Пустое сообщение или не задан ключевой параметр'];
    }

    /**
     * Displays a chat of peer.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionChat($id)
    {
        return $this->render('chat', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DialoguePeer model.
     * If creation is successful, the browser will be redirected to the 'chat' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DialoguePeer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['chat', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DialoguePeer model.
     * If update is successful, the browser will be redirected to the 'chat' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['chat', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DialoguePeer model.
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
     * Finds the DialoguePeer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DialoguePeer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DialoguePeer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionCreateOrder($id) {
        $model = $this->findModel($id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->type === $model::TYPE_ORDER) {
            $props = json_decode($model->properties, 1);
            if (!empty($props) && !empty($_POST['Orders'])) {
                $orders = new Orders();
                $props = ['Orders' => array_merge($props['Orders'], $_POST['Orders'])];
                if (empty($props['Orders']['order_name']))
                    $props['Orders']['order_name'] = "Заказ {$props['Orders']['category_text']}";
                if ($orders->load($props) && $orders->validate()) {
                    if ($orders->save()) {
                        $model->exp_date = time() + 12*3600;
                        $model->update();
                        return ['status' => 'success', 'url' => Url::to(['/lead-force/orders/view', 'id' => $orders->id])];
                    } else
                        return ['status' => 'error', 'message' => 'Ошибка сохранения заказа'];
                } else
                    return ['status' => 'error', 'message' => 'Не указаны обязательные значения в заказе'];
            } else
                return ['status' => 'error', 'message' => 'Заказ не найден в указанном обращении'];
        } else
            return ['status' => 'error', 'message' => 'Заказ не найден в указанном обращении'];
    }

    public function actionCreateOffer($id) {
        $model = $this->findModel($id);
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($model->type === $model::TYPE_OFFER) {
            $props = json_decode($model->properties, 1);
            if (!empty($props) && !empty($_POST['Offers'])) {
                $orders = new Offers();
                $props = ['Offers' => array_merge($props['Offers'], $_POST['Offers'])];
                if (empty($props['Offers']['name']))
                    $props['Offers']['name'] = "Оффер {$props['Offers']['category']}";
                $orders->load($props);
                $orders->createOfferToken();
                if ($orders->validate()) {
                    if ($orders->save()) {
                        $model->exp_date = time() + 12*3600;
                        $model->update();
                        return ['status' => 'success', 'url' => Url::to(['/lead-force/offers/view', 'id' => $orders->id])];
                    } else
                        return ['status' => 'error', 'message' => 'Ошибка сохранения оффера'];
                } else
                    return ['status' => 'error', 'message' => 'Не указаны обязательные значения в оффере', $orders->errors];
            } else
                return ['status' => 'error', 'message' => 'Оффер не найден в указанном обращении'];
        } else
            return ['status' => 'error', 'message' => 'Оффер не найден в указанном обращении'];
    }

}
