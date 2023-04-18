<?php
namespace admin\controllers;

use admin\models\CookieValidator;
use common\models\AuthAssignment;
use common\models\AuthItem;
use common\models\CcLeads;
use common\models\DialoguePeer;
use common\models\Leads;
use common\models\LeadsRead;
use common\models\Orders;
use common\models\UserModel;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use yii\web\HttpException;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends AccessController
{


    /**
     * {@inheritdoc}
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }*/

    /**
     * {@inheritdoc}
     */
    /*public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }*/

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    /**
     * ::Главная::
     * Displays homepage.
     *
     * @return string
     * @throws HttpException
     */
    public function actionIndex()
    {
        $user = Yii::$app->getUser();
        $assignment = AuthAssignment::find()
            ->where(['user_id' => $user->id])
            ->asArray()
            ->select(['item_name'])
            ->orderBy('created_at desc')
            ->one();
        if(!empty($assignment)) {
            $myRole = AuthItem::find()
                ->where(['name' => $assignment['item_name']])
                ->select(['description'])
                ->asArray()
                ->one();
            if (!empty($myRole))
                $myRole = $myRole['description'];
        } else
            throw new HttpException(403);
        if ($user->can('viewIndexInfo')) {
            $statistics['lastUsers'] = UserModel::find()
                ->orderBy('id desc')
                ->asArray()
                ->select(['username', 'email', 'id'])
                ->limit(5)
                ->all();
            $statistics['lastOrders'] = Orders::find()
                ->orderBy('id desc')
                ->asArray()
                ->select(['order_name', 'category_text', 'id'])
                ->limit(5)
                ->all();
            $statistics['leadsToSent'] = LeadsRead::find()
                ->where(['status' => Leads::STATUS_MODERATE])
                ->count();
            $statistics['ordersToModerate'] = Orders::find()
                ->where(['status' => Orders::STATUS_MODERATION])
                ->andWhere(['archive' => 0])
                ->count();
            $statistics['ordersStopped'] = Orders::find()
                ->where(['status' => Orders::STATUS_STOPPED])
                ->andWhere(['archive' => 0])
                ->count();
            $statistics['ordersPaused'] = Orders::find()
                ->where(['status' => Orders::STATUS_PAUSE])
                ->andWhere(['archive' => 0])
                ->count();
            $statistics['ordersDone'] = Orders::find()
                ->where(['status' => Orders::STATUS_FINISHED])
                ->count();
            $statistics['ordersActive'] = Orders::find()
                ->where(['status' => Orders::STATUS_PROCESSING])
                ->count();
            $statistics['ordersDoneThisMonth'] = Orders::find()
                ->where(['status' => Orders::STATUS_FINISHED])
                ->andWhere(['AND', ['>=', 'date_end', date("Y-m-01 00:00:00")], ['<=', 'date_end', date("Y-m-d H:i:s")]])
                ->count();
            $statistics['openedTickets'] = DialoguePeer::find()
                ->where(['status' => DialoguePeer::STATUS_OPENED])
                ->count();
        } else
            $statistics = null;
        if ($user->can('contactCenter')) {
            $cc['waiting'] = CcLeads::find()
                ->where(['is', 'status', null])
                ->count();
            $cc['waitForOperator'] = CcLeads::find()
                ->where(['is', 'assigned_to', null])
                ->count();
            $cc['dailyGet'] = CcLeads::find()
                ->where(['AND', ['>=', 'date_income', date("Y-m-d 00:00:00")], ['<=', 'date_income', date("Y-m-d 23:59:59")]])
                ->count();
        } else
            $cc = null;
        $userRole = array_keys(\Yii::$app->authManager->getRolesByUser($user->id));
        if ($userRole[0] === 'cc') {
            $renderInput = true;
        } else
            $renderInput = false;
        $userModel = UserModel::find()
            ->where(['id' => $user->id])
            ->asArray()
            ->select(['inner_name', 'id'])
            ->one();
        return $this->render('index', ['statistics' => $statistics, 'myRole' => $myRole, 'user' => $user, 'cc' => $cc, 'renderInput' => $renderInput, 'model' => $userModel]);
    }

    public function actionSaveName() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if(empty($_POST['val']))
            return ['status' => 'error', 'message' => 'Имя не указано'];
        else {
            $old = UserModel::findOne(['inner_name' => $_POST['val']]);
            if (!empty($old))
                return ['status' => 'error', 'message' => 'Пользователь с таким именем уже есть. Укажите имя иначе.'];
            $id = Yii::$app->getUser()->getId();
            $user = UserModel::findOne($id);
            if (empty($user))
                return ['status' => 'error', 'message' => 'Пользователь не найден'];
            else {
                if (empty($user->inner_name)) {
                    $user->inner_name = trim($_POST['val']);
                    $user->update();
                    return ['status' => 'success'];
                } else
                    return ['status' => 'error', 'message' => 'Имя уже указано'];
            }
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionFadeSidebar() {
        if (!empty($_POST['fade'])) {
            $_SESSION['sidebar'] = !empty($_SESSION['sidebar']) ? 0 : 1;
        }
        die();
    }

    public function actionSetAccess() {
        $open = CookieValidator::findOne(2);
        if ((int)$open->hash === 1) {
            if (!isset($_COOKIE[self::COOKIE_ACCESS_NAME])) {
                $time = time() + 3600 * 24 * 365 * 10;
                $getActualDate = CookieValidator::findOne(1);
                $cookie = setcookie(self::COOKIE_ACCESS_NAME, md5($getActualDate->date_current), $time, '/', 'admin.myforce.ru');
                $response = ['text' => $cookie ? 'Валидация пройдена успешно. Доступ выдан до ' . date("d.m.Y", $time) : 'Валидация невозможна. Необходима настройка браузера.', 'color' => $cookie ? 'green' : 'red', 'success' => $cookie];
            } else {
                $response = ['text' => 'Валидация пройдена', 'color' => '#d9a24f'];
            }
        } else
            $response = ['text' => 'Доступ валидации закрыт', 'color' => 'red'];
        return $this->render('set-access', ['response' => $response]);
    }

}