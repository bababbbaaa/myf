<?php

namespace admin\modules\lead_force\controllers;

use admin\controllers\AccessController;
use api\models\Bitrix24;
use common\models\Clients;
use common\models\JobsQueue;
use common\models\LeadsParams;
use common\models\RandomQueue;
use common\models\SellerProducts;
use common\models\UserModel;
use Yii;
use common\models\Orders;
use common\models\OrdersSearch;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\RangeNotSatisfiableHttpException;
use yii\web\Response;

/**
 * OrdersController implements the CRUD actions for Orders model.
 */
class OrdersController extends AccessController
{
    /**
     * {@inheritdoc}
     */


    /**
     * Lists all Orders models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrdersSearch();
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

    /**
     * Displays a single Orders model.
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
     * Creates a new Orders model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Orders();
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if (!empty($post['categoryParam'])) {
                $preparedParams = [];
                $cParam = $post['categoryParam'][$model->category_link];
                if (!empty($cParam)) {
                    $categoryParams = LeadsParams::find()->where(['category' => $model->category_link])->asArray()->all();
                    foreach ($categoryParams as $param) {
                        if (!empty($cParam[$param['name']])) {
                            if ($param['comparison_type'] === 'interval') {
                                if ((!empty($cParam[$param['name']]['min']) || (int)$cParam[$param['name']]['min'] === 0)) {
                                    $preparedParams[$param['name']]['min'] = (int)$cParam[$param['name']]['min'];
                                }
                                if (!empty($cParam[$param['name']]['max']))
                                    $preparedParams[$param['name']]['max'] = (int)$cParam[$param['name']]['max'];
                            } else {
                                $preparedParams[$param['name']] = $param['type'] === 'number' ? (int)$cParam[$param['name']] : $cParam[$param['name']];
                            }
                        }
                    }
                    $model->params_category = json_encode($preparedParams, JSON_UNESCAPED_UNICODE);
                }
            }
            $spc = json_decode($model->params_special, 1);
            if (!empty($spc) && !empty($spc['random_queue'])) {
                $rnd = RandomQueue::findOne(['order_id' => $model->id]);
                if (empty($rnd)) {
                    $rnd = new RandomQueue();
                    $rnd->generateRandom($model->id);
                    $rnd->save();
                }
            }
            if ($model->save()) {
                if (!empty($model->attached_seller)) {
                    $client = Clients::findOne(['id' => $model->client]);
                    if (!empty($client)) {
                        $client->attached_seller = $model->attached_seller;
                        if($client->save()) {
                            $product = SellerProducts::find()->where(['client_id' => $client->id, 'name' => $model->order_name, 'seller_id' => $model->attached_seller])->count();
                            if ($product == 0) {
                                $product = new SellerProducts();
                                $product->client_id = $client->id;
                                $product->name = $model->order_name;
                                $product->seller_id = $model->attached_seller;
                                $product->save();
                            }
                        }
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Orders model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if (!empty($post['categoryParam'])) {
                $preparedParams = [];
                $cParam = $post['categoryParam'][$model->category_link];
                if (!empty($cParam)) {
                    $categoryParams = LeadsParams::find()->where(['category' => $model->category_link])->asArray()->all();
                    foreach ($categoryParams as $param) {
                        if (!empty($cParam[$param['name']])) {
                            if ($param['comparison_type'] === 'interval') {
                                if ((!empty($cParam[$param['name']]['min']) || (int)$cParam[$param['name']]['min'] === 0)) {
                                    $preparedParams[$param['name']]['min'] = (int)$cParam[$param['name']]['min'];
                                }
                                if (!empty($cParam[$param['name']]['max']))
                                    $preparedParams[$param['name']]['max'] = (int)$cParam[$param['name']]['max'];
                            } else {
                                $preparedParams[$param['name']] = $param['type'] === 'number' ? (int)$cParam[$param['name']] : $cParam[$param['name']];
                            }
                        }
                    }
                    $model->params_category = json_encode($preparedParams, JSON_UNESCAPED_UNICODE);
                }
            }
            $spc = json_decode($model->params_special, 1);
            if (!empty($spc) && !empty($spc['random_queue'])) {
                $rnd = RandomQueue::findOne(['order_id' => $model->id]);
                if (empty($rnd)) {
                    $rnd = new RandomQueue();
                    $rnd->generateRandom($model->id);
                    $rnd->save();
                }
            }
            if ($model->save()) {
                if (!empty($model->attached_seller)) {
                    $client = Clients::findOne(['id' => $model->client]);
                    if (!empty($client)) {
                        $client->attached_seller = $model->attached_seller;
                        if($client->save()) {
                            $product = SellerProducts::find()->where(['client_id' => $client->id, 'name' => $model->order_name, 'seller_id' => $model->attached_seller])->count();
                            if ($product == 0) {
                                $product = new SellerProducts();
                                $product->client_id = $client->id;
                                $product->name = $model->order_name;
                                $product->seller_id = $model->attached_seller;
                                $product->save();
                            }
                        }
                    }
                }
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Orders model.
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
     * Finds the Orders model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Orders the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Orders::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionArchive($id)
    {
        $model = $this->findModel($id);
        $model->archive = 1;
        $model->status = Orders::STATUS_STOPPED;
        if ($model->update() !== false)
            return Yii::$app->response->redirect(!empty($_GET['redirect']) ? '/lead-force/clients/index' : 'index');
        else
            throw new RangeNotSatisfiableHttpException("Ошибка архивации");
    }

    public function actionGetFinishedOrdersCsv() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['startDate']) && !empty($_POST['endDate'])) {
            $s = date("Y-m-d 00:00:00", strtotime($_POST['startDate']));
            $e = date("Y-m-d 23:59:59", strtotime($_POST['endDate']));
            $orders = Orders::find()
                ->where(['AND', ['>=', 'date_end', $s], ['<=', 'date_end', $e]])
                ->asArray()
                ->all();
            if (!empty($orders)) {
                $cids = [];
                foreach ($orders as $item) {
                    if (!in_array($item['client'], $cids))
                        $cids[] = $item['client'];
                }
                $clients = Clients::find()->where(['id' => $cids])->select(['user_id', 'id'])->asArray()->all();
                if (!empty($clients)) {
                    $uids = ArrayHelper::getColumn($clients, 'user_id');
                    $users = UserModel::find()->where(['id' => $uids])->select(['username', 'id'])->asArray()->all();
                    if (!empty($users)) {
                        $phones = ArrayHelper::map($users, 'id', 'username');
                    }
                }
                if (!empty($phones)) {
                    $clientMap = ArrayHelper::map($clients, 'id', 'user_id');
                    $ordersMap = ArrayHelper::map($orders, 'id', 'client');
                    $orderToPhoneMap = [];
                    foreach ($ordersMap as $oid => $cid) {
                        $orderToPhoneMap[$oid] = $phones[$clientMap[$cid]];
                    }
                }
                if (!empty($orderToPhoneMap)) {
                    $orders[0]['phone'] = $orderToPhoneMap[$orders[0]['id']];
                    foreach ($orders as $key => $item) {
                        $orders[$key]['phone'] = $orderToPhoneMap[$item['id']];
                    }
                    array_unshift($orders, array_keys($orders[0]));
                } else {
                    array_unshift($orders, array_keys($orders[0]));
                }
                $fp = fopen('finished_orders.csv', 'w');
                foreach ($orders as $fields) {
                    fputcsv($fp, $fields);
                }
                fclose($fp);
                return ['status' => true, 'file' => Url::to(['/finished_orders.csv'])];
            } else
                return ['status' => false, 'message' => 'Не найден ни один завершенный заказ в данном временном промежутке'];
        } else
            return ['status' => false, 'message' => 'Необходимо заполнить оба поля'];
    }
}
