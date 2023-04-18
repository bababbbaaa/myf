<?php

namespace admin\modules\lead_force\controllers;

use admin\controllers\AccessController;
use admin\models\Admin;
use api\models\Bitrix24;
use common\models\Orders;
use common\models\User;
use common\models\UserModel;
use Yii;
use common\models\Clients;
use common\models\ClientsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\RangeNotSatisfiableHttpException;
use yii\web\Response;

/**
 * ClientsController implements the CRUD actions for Clients model.
 */
class ClientsController extends AccessController
{
    /**
     * {@inheritdoc}
     */

    /**
     * Lists all Clients models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ClientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
        ]);
        $dataProvider->pagination->setPageSize(100);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionEmptyOrders()
    {
        $searchModel = new ClientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
        ]);
        $dataProvider->pagination->setPageSize(100);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAsXls()
    {
        $searchModel = new ClientsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort([
            'defaultOrder' => ['id' => SORT_DESC],
        ]);
        $dataProvider->pagination->setPageSize(500);
        return $this->renderPartial('as-xls', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAdvancedEdit($id) {
        $model = self::findModel($id);
        if (Yii::$app->request->isPost) {
            $p = $_POST;
            if ($p['type'] === 'fiz') {
                $model->company_info = json_encode(['fiz' => $p['fiz_common']], JSON_UNESCAPED_UNICODE);
            } else {
                $model->company_info = json_encode(['jur' => $p['jur_common']], JSON_UNESCAPED_UNICODE);
            }
            if (!empty($p['payments'])) {
                if (in_array('fiz', $p['payments'])) {
                    $reqs['fiz'] = $p['fiz'];
                }
                if (in_array('jur', $p['payments'])) {
                    $reqs['jur'] = $p['jur'];
                }
                if (!empty($reqs))
                    $model->requisites = json_encode($reqs, JSON_UNESCAPED_UNICODE);
            }
            if ($model->update() !== false)
                return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('advanced-edit', ['model' => $model]);
    }

    /**
     * Displays a single Clients model.
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
     * Creates a new Clients model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Clients();

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->user_id)) {
                $user = UserModel::findOne($model->user_id);
                if (!empty($user)) {
                    $user->is_client = 1;
                    $user->update();
                }
            }
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Clients model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->user_id)) {
                $user = UserModel::findOne($model->user_id);
                if (!empty($user)) {
                    $user->is_client = 1;
                    $user->update();
                }
            }
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Clients model.
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
     * Finds the Clients model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Clients the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Clients::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionChangeOrderStatus() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['id']) || empty($_POST['val']))
            return ['status' => 'error', 'message' => 'Пустая выборка'];
        else {
            if (Yii::$app->getUser()->can('changeOrderStatus')) {
                $id = $_POST['id'];
                $val = $_POST['val'];
                $order = Orders::findOne($id);
                if (empty($order))
                    return ['status' => 'error', 'message' => 'Заказ не найден'];
                else {
                    $order->status = $val;
                    if ($order->update() !== false)
                        return ['status' => 'success'];
                    else
                        return ['status' => 'error', 'message' => 'Ошибка во время сохранения'];
                }
            } else
                return ['status' => 'error', 'message' => "В доступе отказано"];
        }
    }

    public function actionArchive($id) {
        $model = $this->findModel($id);
        $model->archive = 1;
        if (!empty($model->orders)) {
            foreach ($model->orders as $item) {
                $item->archive = 1;
                $item->update();
            }
        }
        if ($model->update() !== false)
            return Yii::$app->response->redirect('index');
        else
            throw new RangeNotSatisfiableHttpException("Ошибка архивации");
    }

    public function actionArchiveList() {
        $filter = [];
        if (!empty($_GET['filter'])) {
            $filter = [
                'OR',
                ['like', 'f', "%{$_GET['filter']}%", false],
                ['like', 'i', "%{$_GET['filter']}%", false],
                ['like', 'o', "%{$_GET['filter']}%", false],
                ['like', 'commentary', "%{$_GET['filter']}%", false],
                ['=', 'id', $_GET['filter']],
            ];
        }
        $clients = Clients::find()->andFilterWhere($filter)->all();
        return $this->render('archive-list', ['clients' => $clients]);
    }

    public function actionRestoreArchive($type, $id) {
        if ($type === 'clients') {
            $model = Clients::findOne($id);
        } else {
            $model = Orders::findOne($id);
        }
        if (!empty($model)) {
            if ($model instanceof Clients) {
                if (!empty($model->archiveOrders)) {
                    foreach ($model->archiveOrders as $item) {
                        $item->archive = 0;
                        $item->status = Orders::STATUS_STOPPED;
                        $item->update();
                    }
                }
            }
            $model->archive = 0;
            $model->update();
        }
        return Yii::$app->response->redirect('archive-list');
    }

    public function actionNewBxTask() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $type = $_REQUEST['type'];
        if (empty($type))
            return ['success' => false, 'message' => 'Задача не определена'];
        else {
            if ($type === 'repeat') {
                if (!empty($_REQUEST['cid']) && !empty($_REQUEST['oid'])) {
                    $client = Clients::findOne($_REQUEST['cid']);
                    $order = Orders::findOne($_REQUEST['oid']);
                    $user = User::findOne([$client->user_id]);
                    $phone = !empty($user) ? "Телефон: $user->username, " : '';
                    $data = [
                        'fields' => [
                            'TITLE' => "Продать по новой {$client->f} {$client->i} - заказ {$order->order_name}",
                            'CREATED_BY' => 1,
                            'RESPONSIBLE_ID' => 612,
                            'ACCOMPLICES' => [720],
                            'AUDITORS' => [1],
                            'DESCRIPTION' => "Продать по новой клиенту лиды (отсутствует пролонгация по клиенту или другая причина). \n\n {$phone}{$client->f} {$client->i}, $client->email",
                            "DEADLINE" => date("Y-m-dT18:00:00", time() + 3600 * 24 * 3)
                        ]
                    ];
                    $response = Bitrix24::useApi('tasks.task.add', $data);
                    return ['success' => true, $response];
                } else
                    return ['success' => false, 'message' => 'Заказчик не определен'];
            } else {
                if (!empty($_REQUEST['cid']) && !empty($_REQUEST['oid'])) {
                    $client = Clients::findOne($_REQUEST['cid']);
                    $order = Orders::findOne($_REQUEST['oid']);
                    $user = User::findOne([$client->user_id]);
                    $phone = !empty($user) ? "Телефон: $user->username, " : '';
                    $data = [
                        'fields' => [
                            'TITLE' => "Срочная задача {$client->f} {$client->i} - заказ {$order->order_name}",
                            'CREATED_BY' => 1,
                            'RESPONSIBLE_ID' => 612,
                            'ACCOMPLICES' => [720],
                            'AUDITORS' => [1],
                            'DESCRIPTION' => $_REQUEST['text'] . "\n\n {$phone}{$client->f} {$client->i}, $client->email",
                            "DEADLINE" => date("Y-m-dT18:00:00", time() + 3600 * 24 * 3)
                        ]
                    ];
                    $response = Bitrix24::useApi('tasks.task.add', $data);
                    return ['success' => true, $response];
                } else
                    return ['success' => false, 'message' => 'Заказчик не определен'];
            }
        }
    }


}
