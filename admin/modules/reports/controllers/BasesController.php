<?php

namespace admin\modules\reports\controllers;

use admin\controllers\AccessController;
use admin\models\BasesBackdoor;
use admin\models\BasesBackdoorHandle;
use admin\models\BasesContacts;
use admin\models\BasesConversion;
use admin\models\BasesFunds;
use admin\models\BasesUtm;
use common\models\JobsQueue;
use Yii;
use admin\models\Bases;
use admin\models\BasesSearch;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * BasesController implements the CRUD actions for Bases model.
 */
class BasesController extends AccessController
{

    /**
     * Lists all Bases models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BasesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->setSort(['defaultOrder' => ['id' => SORT_DESC]]);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bases model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $contacts = BasesContacts::find()->where(['base_id' => $model->id]);
        $countQuery = clone $contacts;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize($_GET['pageSize'] ?? 500);
        $models = $contacts->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();
        return $this->render('view', [
            'model' => $model,
            'contacts' => $models,
            'pages' => $pages
        ]);
    }

    /**
     * Creates a new Bases model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bases();

        if ($model->load(Yii::$app->request->post())) {
            if (!empty($model->date_create)) {
                $d = new \DateTime();
                $d->setTimestamp(strtotime($model->date_create));
                $d->setTime(date("H"), date("i"), date("s"));
                $model->date_create = $d->format('Y-m-d H:i:s');
            }
            if($model->save())
                return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }


    public function actionAddContacts($id) {
        $model = self::findModel($id);
        $err = [];
        if (Yii::$app->request->isPost) {
            $p = $_POST;
            if (!empty($_FILES['base']['error'])) {
                $err[] = 'Необходимо заполнить поле "База"';
            }
            if (empty($err)) {
                $file = $_FILES['base'];
                $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
                if ($ext === 'txt') {
                    $file_data = file_get_contents($file['tmp_name']);
                    if (!empty($file_data)) {
                        $expl = explode(PHP_EOL, $file_data);
                        $phones = [];
                        foreach ($expl as $item) {
                            if (empty($item) || strlen($item) < 11)
                                continue;
                            else
                                $phones[] = $item;
                        }
                        if (empty($phones))
                            $err[] = 'Пустой файл или битые номера';
                        else {
                            foreach ($phones as $item) {
                                $contact = new BasesContacts();
                                $contact->base_id = $model->id;
                                $contact->phone = preg_replace("/[^0-9]/", '', $item);
                                $contact->save();
                            }
                            $model->is_new = 0;
                            $model->update();
                            $this->redirect(['view', 'id' => $model->id]);
                        }
                    } else {
                        $err[] = 'Пустой файл';
                    }
                } else {
                    $err[] = 'Недопустимый формат файла';
                }
            }
        }
        return $this->render('add-contacts', ['model' => $model, 'err' => $err]);
    }

    public function actionNewUtm() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['ser']) && !empty($_POST['utm'])) {
            parse_str($_POST['ser'], $p);
            $key = array_key_first($p['set']);
            $keys = $p['set'][$key];
            if (!empty($keys)) {
                $cont = BasesContacts::find()->where(['in', 'id', $keys])->all();
                if (!empty($cont)) {
                    /**
                     * @var BasesContacts $item
                     */
                    $newDate = date('d.m.y H:i');
                    $translit = 'ruchnoi';
                    $utm_generated = date("d-m-y-H-i") . "_" . $translit . "_" . $_POST['utm'];
                    foreach ($cont as $item) {
                        $utm = json_decode($item->utm_data, 1);
                        $utm[] = [
                            'utm' => $utm_generated,
                            'date' => $newDate,
                        ];
                        $item->utm_data = json_encode($utm, JSON_UNESCAPED_UNICODE);
                        $item->update();
                    }
                    return ['status' => 'success'];
                } else
                    return ['status' => 'error', 'message' => 'Пустая выборка'];
            } else
                return ['status' => 'error', 'message' => 'Пустая выборка'];
        } else
            return ['status' => 'error', 'message' => 'Пустая выборка или UTM'];
    }

    public function actionGetTxtFile() {
        if (!empty($_POST['serialized'])) {
            $parseArray = explode('&', $_POST['serialized']);
            $arr = [];
            foreach ($parseArray as $key => $item) {
                parse_str($item, $p);
                $k = array_key_first($p['set']);
                $arr['set'][$k][] = $p['set'][$k][0];
            }
        } else {
            $arr = null;
        }
        if (!empty($arr)) {
            $keys = [];
            foreach ($arr['set'] as $kk => $v) {
                $keys = array_merge($keys, $v);
            }
            if (!empty($keys)) {
                $conts = BasesContacts::find()->where(['in', 'id', $keys])->orderBy('id desc')->asArray()->select(['phone'])->all();
                header('Content-type: text/plain');
                header('Content-Disposition: attachment; filename="Обзвон '. date("d.m.Y H:i") .'.txt"');
                foreach ($conts as $z => $item) {
                    if ($z !== count($conts) - 1)
                        echo $item['phone'] . PHP_EOL;
                    else
                        echo $item['phone'];
                }
                die();
            } else
                $this->redirect(['index']);
        }
        $this->redirect(['index']);
    }

    public function actionSetNewUtmData() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_POST['seri']))
            return ['status' => 'error', 'message' => 'Необходимо выбрать контакты'];
        if (empty($_POST['utm100']))
            return ['status' => 'error', 'message' => 'Необходимо указать постфикс'];
        $postfix = $_POST['utm100'];
        if (preg_match('/[a-zA-Z_0-9]+/', $postfix, $matches) && $matches[0] === $_POST['utm100']) {
            if (!empty($_POST['seri'])) {
                $parseArray = explode('&', $_POST['seri']);
                $ids = [];
                foreach ($parseArray as $key => $item) {
                    parse_str($item, $p);
                    $k = array_key_first($p['set']);
                    $ids['set'][$k][] = $p['set'][$k][0];
                }
            } else {
                $ids = null;
            }
            if (!empty($ids)) {
                $date = date('dmy');
                do {
                    $utm00 = $date . "_" . BasesUtm::generate_utm_main_part() . "_" . $_POST['utm100'];
                    $finder = BasesUtm::findOne(['name' => $utm00]);
                    if (empty($finder))
                        break;
                } while(true);
                foreach ($ids['set'] as $key => $item) {
                    $base = (int)$key;
                    foreach ($item as $j) {
                        $utm = new BasesUtm();
                        $utm->name = $utm00;
                        $utm->base_id = (int)$base;
                        $utm->contact_id = (int)$j;
                        $utm->save();
                    }
                }
                return ['status' => 'success'];
            } else
                return ['status' => 'error', 'message' => 'Необходимо выбрать контакты'];
        } else
            return ['status' => 'error', 'message' => 'Постфикс может содержать только латиницу, цифры и символ прочерка _'];
    }

    /**
     * Updates an existing Bases model.
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
     * Deletes an existing Bases model.
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
     * Finds the Bases model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bases the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bases::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionUtms() {
        if (!empty($_GET['filters'])) {
            $filters = $_GET['filters'];
            $f = ['AND'];
        }
        $query = BasesUtm::find()
            ->groupBy(['name'])
            ->select(['name', 'base_id', 'date'])
            ->asArray();
        if (!empty($filters['name'])) {
            $f[] = ['like', 'name', "%{$filters['name']}%", false];
            $query->andFilterWhere($f);
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['date' => SORT_DESC])
            ->all();
        return $this->render('utms', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionViewUtm($name) {
        $cids = BasesUtm::find()->where(['name' => $name])->select(['contact_id'])->asArray()->all();
        $utm = BasesUtm::findOne(['name' => $name]);
        BasesContacts::$helperName = $name;
        if (empty($utm))
            throw new HttpException(404);
        $contacts = null;
        if (!empty($cids)) {
            foreach ($cids as $item) {
                $cArr[] = $item['contact_id'];
            }
            if (!empty($cArr))
                $contacts = BasesContacts::find()->where(['in', 'id', $cArr]);
        }
        $pages = null;
        $models = null;
        if (!empty($contacts)) {
            $countQuery = clone $contacts;
            $pages = new Pagination(['totalCount' => $countQuery->count()]);
            $pages->setPageSize($_GET['pageSize'] ?? 500);
            $models = $contacts->offset($pages->offset)
                ->limit($pages->limit)
                ->asArray()
                ->all();
        }
        $statistics = BasesUtm::find()
            ->select('name, date, count(*) as total, SUM(is_1 > 0) as is1Total, SUM(is_cc > 0) as isCcTotal')
            ->where(['name' => $utm->name])
            ->groupBy('name')
            ->orderBy('date asc')
            ->all();
        return $this->render('view-utm', ['models' => $models, 'pages' => $pages, 'utm' => $utm, 'statistics' => $statistics ?? null]);
    }

    public function actionContacts() {
        $cache = Yii::$app->cache;
        if (!empty($_GET['filters'])) {
            $filters = $_GET['filters'];
            $f = ['AND'];
        }
        $query = BasesContacts::find();
        if (!empty($filters['date_start'])) {
            $f[] = ['>=', 'date', date("Y-m-d 00:00:00", strtotime($filters['date_start']))];
        }
        if (!empty($filters['date_stop'])) {
            $f[] = ['<=', 'date', date("Y-m-d 23:59:59", strtotime($filters['date_stop']))];
        }
        if(!empty($f))
            $query->andFilterWhere($f);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $psize = $_GET['pageSize'] ?? 500;
        $pages->setPageSize($psize);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all();
        $view = $this->render('contacts', [
            'models' => $models,
            'pages' => $pages,
        ]);
        return $view;
    }

    public function actionStats() {
        return $this->render('stats');
    }


    public function actionUtmStats() {
        $utms = BasesUtm::find()->groupBy('name')->asArray()->select(['name'])->all();
        if (!empty($_GET['filter'])) {
            $f = ['OR'];
            if (!empty($_GET['filter']['utm']))
                $f[] = ['name' => $_GET['filter']['utm']];
        }
        if (!empty($f) && count($f) > 1) {
            $statistics = BasesUtm::find()
                ->select('name, date, count(*) as total, SUM(is_1 > 0) as is1Total, SUM(is_cc > 0) as isCcTotal')
                ->where($f)
                ->groupBy('name')
                ->orderBy('date asc')
                ->all();
        }
        return $this->render('utm-stats', ['utms' => $utms, 'statistics' => $statistics ?? null]);
    }

    public function actionUtmDynamic() {
        if (!empty($_GET['type'])) {
            if ($_GET['type'] === 'utm') {
                if (!empty($_GET['filter'])) {
                    $f = ['AND'];
                    if (!empty($_GET['filter']['date_start']))
                        $f[] = ['>=', 'date', date("Y-m-d 00:00:00", strtotime($_GET['filter']['date_start']))];
                    if (!empty($_GET['filter']['date_stop']))
                        $f[] = ['<=', 'date', date("Y-m-d 23:59:59", strtotime($_GET['filter']['date_stop']))];
                }
                if (!empty($f) && count($f) > 1) {
                    $statistics = BasesUtm::find()
                        ->select('name, date, count(*) as total, SUM(is_1 > 0) as is1Total, SUM(is_cc > 0) as isCcTotal')
                        ->where($f)
                        ->groupBy('name')
                        ->orderBy('date asc')
                        ->all();
                }
            } elseif ($_GET['type'] === 'region') {
                if (!empty($_GET['filter'])) {
                    $f = ['AND'];
                    if (!empty($_GET['filter']['date_start']))
                        $f[] = ['>=', 'date', date("Y-m-d 00:00:00", strtotime($_GET['filter']['date_start']))];
                    if (!empty($_GET['filter']['date_stop']))
                        $f[] = ['<=', 'date', date("Y-m-d 23:59:59", strtotime($_GET['filter']['date_stop']))];
                    if (!empty($_GET['filter']['region']))
                        $r = ['geo' => $_GET['filter']['region']];
                    if (!empty($r)) {
                        $bases = Bases::find()->where(['geo' => $r])->select('id')->asArray()->all();
                        if (!empty($bases)) {
                            $ids = [];
                            foreach ($bases as $item)
                                $ids[] = $item['id'];
                        }
                        if (!empty($ids)) {
                            $statistics = BasesUtm::find()
                                ->select('name, date, count(*) as total, SUM(is_1 > 0) as is1Total, SUM(is_cc > 0) as isCcTotal')
                                ->where($f)
                                ->andWhere(['in', 'base_id', $ids])
                                ->groupBy('name')
                                ->orderBy('date asc')
                                ->all();
                        }
                    }
                }
            } else {
                if (!empty($_GET['filter'])) {
                    $f = ['AND'];
                    if (!empty($_GET['filter']['date_start']))
                        $f[] = ['>=', 'date', date("Y-m-d 00:00:00", strtotime($_GET['filter']['date_start']))];
                    if (!empty($_GET['filter']['date_stop']))
                        $f[] = ['<=', 'date', date("Y-m-d 23:59:59", strtotime($_GET['filter']['date_stop']))];
                    if (!empty($_GET['filter']['provider']))
                        $r = ['provider' => $_GET['filter']['provider']];
                    if (!empty($r)) {
                        $bases = Bases::find()->where(['provider' => $r])->select('id')->asArray()->all();
                        if (!empty($bases)) {
                            $ids = [];
                            foreach ($bases as $item)
                                $ids[] = $item['id'];
                        }
                        if (!empty($ids)) {
                            $statistics = BasesUtm::find()
                                ->select('name, date, count(*) as total, SUM(is_1 > 0) as is1Total, SUM(is_cc > 0) as isCcTotal')
                                ->where($f)
                                ->andWhere(['in', 'base_id', $ids])
                                ->groupBy('name')
                                ->orderBy('date asc')
                                ->all();
                        }
                    }
                }
            }
        }
        return $this->render('utm-dynamic', ['statistics' => $statistics ?? null]);
    }

    public function actionUtmRegionTotal() {
        if (!empty($_GET['filter'])) {
            $f = ['AND'];
            if (!empty($_GET['filter']['date_start']))
                $f[] = ['>=', 'date', date("Y-m-d 00:00:00", strtotime($_GET['filter']['date_start']))];
            if (!empty($_GET['filter']['date_stop']))
                $f[] = ['<=', 'date', date("Y-m-d 23:59:59", strtotime($_GET['filter']['date_stop']))];
        }
        if (!empty($f) && count($f) > 1) {
            $statistics = BasesConversion::find()
                ->select("id, name, date, count(*) as total, SUM(type = 'is_1') as is1Total, SUM(type = 'is_cc') as isCcTotal, SUM(type = 'is_250') as is250Total")
                ->where($f)
                ->groupBy('name')
                ->orderBy('date asc')
                ->asArray()
                ->all();
            $baseFunds = BasesFunds::find()->where($f)->andWhere(['type' => 'база'])->asArray()->all();
            $obzvonFunds = BasesFunds::find()->where($f)->andWhere(['type' => 'обзвон'])->asArray()->all();
            $baseFundsArray = [];
            $obzvonFundsArray = [];
            foreach ($baseFunds as $item)
                $baseFundsArray[$item['region']][] = $item['value'];
            foreach ($obzvonFunds as $item)
                $obzvonFundsArray[$item['region']][] = $item['value'];
        }
        return $this->render('utm-region-total', ['statistics' => $statistics ?? null, 'baseFunds' => $baseFundsArray, 'obzvonFunds' => $obzvonFundsArray]);
    }

    public function actionMakeTable() {
        $data = $_POST['filter'];
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($data['date_start']) || empty($data['date_stop'])) {
            return ['error' => true, 'message' => 'Необходимо указать дату старта и дату окончания выборки'];
        }
        if (file_exists("/home/master/web/myforce.ru/public_html/admin/web/leads_2_1.csv"))
            unlink("/home/master/web/myforce.ru/public_html/admin/web/leads_2_1.csv");
        $params = [
            'dateStart' => $data['date_start'],
            'dateStop' => $data['date_stop'],
            'cenaKC' => empty($_POST['bd_lead_price']) ? 64 : $_POST['bd_lead_price'],
            'msk' => empty($_POST['msk_price']) ? 790 : $_POST['msk_price'],
            'reg' => empty($_POST['region_price']) ? 700 : $_POST['region_price'],
        ];
        $queue = new JobsQueue();
        $queue->method = "make__table";
        $queue->params = json_encode($params, JSON_UNESCAPED_UNICODE);
        $queue->date_start = date("Y-m-d H:i:s");
        $queue->status = 'wait';
        $queue->user_id = 1;
        $queue->closed = 0;
        $queue->save();
        return ['error' => false, 'message' => 'Задание назначено, как только оно будет выполнено - вы получите ссылку на скачивание на этой странице'];
    }

    public function actionUtmRegionExtended() {
        if (!empty($_GET['filter'])) {
            $f = ['AND'];
            if (!empty($_GET['filter']['date_start']))
                $f[] = ['>=', 'date', date("Y-m-d 00:00:00", strtotime($_GET['filter']['date_start']))];
            if (!empty($_GET['filter']['date_stop']))
                $f[] = ['<=', 'date', date("Y-m-d 23:59:59", strtotime($_GET['filter']['date_stop']))];
        }
        if (!empty($f) && count($f) > 1) {
            $statistics = BasesConversion::find()
                ->select("id, name, date, count(*) as total, SUM(type = 'is_1') as is1Total, SUM(type = 'is_cc') as isCcTotal, SUM(type = 'is_250') as is250Total")
                ->where($f)
                ->groupBy('name')
                ->orderBy('date asc')
                ->asArray()
                ->all();
            $baseFunds = BasesFunds::find()->where($f)->andWhere(['type' => 'база'])->asArray()->all();
            $obzvonFunds = BasesFunds::find()->where($f)->andWhere(['type' => 'обзвон'])->asArray()->all();
            $baseFundsArray = [];
            $obzvonFundsArray = [];
            foreach ($baseFunds as $item) {
                if ($item['region'] === 'г Москва' || $item['region'] === 'Московская обл')
                    $regname = "МСК+МО";
                elseif($item['region'] === 'г Санкт-Петербург' || $item['region'] === 'Ленинградская обл')
                    $regname = "СПБ";
                else
                    $regname = $item['region'];
                $baseFundsArray[$regname][] = $item['value'];
            }
            foreach ($obzvonFunds as $item) {
                if ($item['region'] === 'г Москва' || $item['region'] === 'Московская обл')
                    $regname = "МСК+МО";
                elseif($item['region'] === 'г Санкт-Петербург' || $item['region'] === 'Ленинградская обл')
                    $regname = "СПБ";
                else
                    $regname = $item['region'];
                $obzvonFundsArray[$regname][] = $item['value'];
            }
            $backdoors = BasesBackdoor::find()
                ->select("id, region, date, SUM(type = 'is_cc') as isCcTotal, SUM(type = 'is_250') as is250Total")
                ->where($f)
                ->groupBy('region')
                ->orderBy('date asc')
                ->asArray()
                ->all();
            $backdoorsH = BasesBackdoorHandle::find()
                ->select("id, region, date, SUM(type = 'handle') as is250Total")
                ->where($f)
                ->groupBy('region')
                ->orderBy('date asc')
                ->asArray()
                ->all();
        }
        return $this->renderPartial('utm-region-extended', ['statistics' => $statistics ?? null, 'baseFunds' => $baseFundsArray, 'obzvonFunds' => $obzvonFundsArray, 'bd' => $backdoors ?? [], 'bdh' => $backdoorsH ?? []]);
    }

    public function actionFlush($return) {
        Yii::$app->cache->flush();
        return $this->redirect([$return]);
    }

}
