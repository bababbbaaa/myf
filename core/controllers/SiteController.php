<?php

namespace core\controllers;

use common\models\Banners;
use common\models\Cases;
use common\models\CreditPay;
use common\models\Events;
use common\models\helpers\Robokassa;
use common\models\helpers\TelegramBot;
use common\models\helpers\UrlHelper;
use common\models\News;
use common\models\ReferalLink;
use common\models\SkillTrainings;
use common\models\User;
use common\models\UserModel;
use core\models\Form;
use core\models\ResendVerificationEmailForm;
use core\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use core\models\PasswordResetRequestForm;
use core\models\ResetPasswordForm;
use core\models\SignupForm;
use core\models\ContactForm;
use yii\web\Response;
use yii\data\Pagination;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup', 'logout'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    public function actionSmsSend()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['phone'])) {
            if (empty($_SESSION['exp_date_sms']) || time() > $_SESSION['exp_date_sms']) {
                $phone = preg_replace('/[^\d]+/', '', Html::encode($_POST['phone']));
                $code_send = hexdec(substr(md5($phone . "myforce_code"), 7, 5));
                //                $code_send = hexdec(substr(md5('657144' . "myforce_code"), 7, 5));
                $client = new \SoapClient('https://smsc.ru/sys/soap.php?wsdl');
                $ret = $client->send_sms(array('login' => 'FemidaForce', 'psw' => '1q2w3e2w1q', 'phones' => $phone, 'mes' => $code_send, 'sender' => 'MYFORCE'));
                $_SESSION['sms-code'] = $code_send;
                //                $_SESSION['sms-code'] = "657144";
                $_SESSION['exp_date_sms'] = time() + 60;
                return ['status' => 'success', 'message' => /*$ret*/ 1];
            } else return ['status' => 'error', 'message' => 'Не более 1 СМС в минуту!'];
        } else return ['status' => 'error', 'message' => 'Не указан номер телефона!'];
    }

    public function actionCodeConfirm()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['code'])) {
            $code = $_POST['code'];
            $code_session = $_SESSION['sms-code'];
            if ($code == $code_session) {
                return ['status' => 'success'];
            } else {
                return ['status' => 'error', 'message' => 'Код не совпадает'];
            }
        } else return ['status' => 'error', 'message' => 'Не верно указан код!'];
    }

    public function actionClub()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Майфорс, Myforce, бизнес сервис, сервис для предпренимателей, купить франшизу, Купить лиды, новости бизнеса']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Мы — команда MYFORCE — вдохновлены тем, что нам удаётся менять жизнь сотен тысяч людей и повышать уровень образования в стране. И уверены, что сможем добиться большего, так как у онлайн‑образования огромный потенциал.']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Клуб MYFORCE']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/mainimg/image.png']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/about']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Мы — команда MYFORCE — вдохновлены тем, что нам удаётся менять жизнь сотен тысяч людей и повышать уровень образования в стране. И уверены, что сможем добиться большего, так как у онлайн‑образования огромный потенциал.']);
        return $this->render('club');
    }

    public function actionRegistr()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Майфорс, Myforce, бизнес сервис, сервис для предпренимателей, купить франшизу, Купить лиды, новости бизнеса']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Присоединяйтесь к нам']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Регистрация на портале MYFORCE']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/mainimg/photo-goup-team.png']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/registr']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Присоединяйтесь к нам']);
        return $this->render('registr');
    }

    public function actionRegistrProvider()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Майфорс, Myforce, бизнес сервис, сервис для предпренимателей, купить франшизу, Купить лиды, новости бизнеса']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Единый кабинет для всех сервисов экосистемы MYFORCE']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Один кабинет - все инструменты']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/mainimg/photo-goup-team.png']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/registr-provider']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Единый кабинет для всех сервисов экосистемы MYFORCE']);
        return $this->render('registr-provider');
    }

    #Старая проверка телефона
    //    public function actionCheckPhoneExist() {
    //        Yii::$app->response->format = Response::FORMAT_JSON;
    //        if (!empty($_POST['phone'])) {
    //            $phone = preg_replace('/[^\d]+/', '', Html::encode($_POST['phone']));
    //            $phone[0] = 7;
    //            $user = User::findOne(['username' => $phone]);
    //            return ['exist' => !empty($user)];
    //        } else return ['status' => 'error', 'message' => 'Не верно указан телефон!'];
    //    }
    #Старая проверка телефона

    public function actionCheckPhoneExist()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['phone'])) {
            $phone = preg_replace('/[^\d]+/', '', Html::encode($_POST['phone']));
            $phone[0] = 7;
            $user = User::findOne(['username' => $phone]);
            if (empty($user)) {
                if (!empty($_POST['email'])) {
                    $user = User::findOne(['email' => $_POST['email']]);
                    return ['exist' => !empty($user)];
                } else return ['status' => 'error', 'message' => 'Укажите почту'];
            } else return ['status' => 'error', 'message' => 'Пользователь с таким телефоном уже существует'];
        } else return ['status' => 'error', 'message' => 'Не верно указан телефон!'];
    }

    public function actionPopupLogin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ((!empty($_POST['phone']) && !empty($_POST['password'])) || !empty($_GET['auth'])) {
            if (!empty($_POST['site'])) {
                switch ($_POST['site']) {
                    case 'femida':
                        $site = 'femida/';
                        break;
                    case 'lead':
                        $site = 'lead-force/';
                        break;
                    case 'dev':
                        $site = 'dev';
                        break;
                    default:
                        $site = 'user-login';
                }
            } else $site = 'lead-force/';
            if (!empty($_POST['phone'])) {
                $phone = preg_replace('/[^\d]+/', '', Html::encode($_POST['phone']));
                $phone[0] = 7;
                $user = User::findOne(['username' => $phone]);
            } else {
                $user = User::findOne(['auth_key' => $_GET['auth']]);
                if ($user->status === 9) {
                    $user->status = 10;
                    $user->update();
                }
            }
            if (!empty($user)) {
                if (!empty($phone)) {
                    $model = new LoginForm();
                    $model->username = $phone;
                    $model->password = $_POST['password'];
                    $model->validate();
                    if ($model->login()) {
                        setcookie('is_valid_user', "{$user->id}::" . md5("{$user->id}::" . User::SPECIAL_LOGIN_HASH), time() + 60, "/", ".myforce.ru", true, true);
                        return Yii::$app->response->redirect("https://user.myforce.ru/site/external-login?url=https://user.myforce.ru/{$site}&auth={$user->auth_key}");
                    } else
                        return ['status' => 'error', 'message' => 'Ошибка авторизации', $model->errors];
                } else {
                    $login = Yii::$app->user->login(User::findIdentity($user->id), 3600 * 24 * 30);
                    if ($login) {
                        setcookie('is_valid_user', "{$user->id}::" . md5("{$user->id}::" . User::SPECIAL_LOGIN_HASH), time() + 60, "/", ".myforce.ru", true, true);
                        return Yii::$app->response->redirect("https://user.myforce.ru/site/external-login?url=https://user.myforce.ru/{$site}&auth={$user->auth_key}");
                    } else {
                        return ['status' => 'error', 'message' => 'Ошибка авторизации'];
                    }
                }
            } else
                return ['status' => 'error', 'message' => 'Пользователь не найден'];
        } else return ['status' => 'error', 'message' => 'Пароль или телефон не указан'];
    }

    public function actionRestorePasswordLogin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['phone']) && !empty($_POST['code'])) {
            $phone = preg_replace('/[^\d]+/', '', Html::encode($_POST['phone']));
            $phone[0] = 7;
            $user = User::findOne(['username' => $phone, 'sms_restore_password' => $_POST['code']]);
            if (!empty($_POST['site'])) {
                switch ($_POST['site']) {
                    case 'femida':
                        $site = 'femida/';
                        break;
                    case 'lead':
                        $site = 'lead-force/';
                        break;
                    case 'dev':
                        $site = 'dev';
                        break;
                    default:
                        $site = 'user-login';
                }
            }
            if (!empty($user)) {
                $newPass = User::generate_string(10);
                $user->setPassword($newPass);
                if ($user->update() !== false) {
                    if (Yii::$app->user->login($user)) {
                        $client = new \SoapClient('https://smsc.ru/sys/soap.php?wsdl');
                        $ret = $client->send_sms(array('login' => 'FemidaForce', 'psw' => '1q2w3e2w1q', 'phones' => $phone, 'mes' => "Ваш пароль: {$newPass}", 'sender' => 'MYFORCE'));
                        setcookie('is_valid_user', "{$user->id}::" . md5("{$user->id}::" . User::SPECIAL_LOGIN_HASH), time() + 60, "/", ".myforce.ru", true, true);
                        return Yii::$app->response->redirect("https://myforce.ru/registr");
                    } else return ['status' => 'error', 'message' => 'Ошибка авторизации'];
                } else
                    return ['status' => 'error', 'message' => 'Ошибка сохранения нового пароля'];
            } else
                return ['status' => 'error', 'message' => 'Пользователь с таким кодом не найден'];
        } else
            return ['status' => 'error', 'message' => 'Пароль или телефон не указан'];
    }

    public function actionRestorePassword()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (empty($_SESSION['exp_date_sending']) || time() > $_SESSION['exp_date_sending']) {
            if (!empty($_POST['phone'])) {
                $phone = preg_replace('/[^\d]+/', '', Html::encode($_POST['phone']));
                $phone[0] = 7;
                $user = User::findOne(['username' => $phone]);
                if (!empty($user)) {
                    $user->smsPasswordReset();
                    $client = new \SoapClient('https://smsc.ru/sys/soap.php?wsdl');
                    $ret = $client->send_sms(array('login' => 'FemidaForce', 'psw' => '1q2w3e2w1q', 'phones' => $phone, 'mes' => "Код восстановления: {$user->sms_restore_password}", 'sender' => 'MYFORCE'));
                    if ($user->update() !== false)
                        $_SESSION['exp_date_sending'] = time() + 120;
                    return ['status' => 'success'];
                } else return ['status' => 'error', 'message' => 'Пользователь не найден'];
            } else return ['status' => 'error', 'message' => 'Не указан телефон'];
        } else
            return ['status' => 'error', 'message' => 'Не более 1 СМС за 2 минуты'];
    }

    public static function afterSignupAction($site, $email, $user_id, $phone, $pwd, $fio, $ext = false)
    {
        if ($user_id !== false && $user_id !== null) {
            $user = User::findOne($user_id);
            if (Yii::$app->user->login($user)) {
                if (!empty($_COOKIE['referal'])) {
                    $usModel = UserModel::findOne($user_id);
                    $usModel->referal = Html::encode($_COOKIE['referal']);
                    $usModel->update();
                }
                # КАК СДЕЛАЮТ СМС РАСКОМЕНТИРОВАТЬ
                //                $client = new \SoapClient('https://smsc.ru/sys/soap.php?wsdl');
                //                $ret = $client->send_sms(array('login' => 'FemidaForce', 'psw' => '1q2w3e2w1q', 'phones' => $phone, 'mes' => "Ваш пароль: {$pwd}", 'sender' => 'MYFORCE'));
                //                setcookie('is_valid_user', "{$user->id}::" . md5("{$user->id}::" . User::SPECIAL_LOGIN_HASH), time() + 60, "/", ".myforce.ru", true, true);
                # КАК СДЕЛАЮТ СМС РАСКОМЕНТИРОВАТЬ

                Yii::$app->mailer->compose()
                    ->setFrom(['info@myforce.ru' => 'MYFORCE - экосистема для бизнеса'])
                    ->setTo($email)
                    ->setSubject('Регистрация в MYFORCE, ваш пароль и ссылка на личный кабине')
                    ->setTextBody('Текст сообщения')
                    ->setHtmlBody("<h1>Приветствуем Вас в экосистеме MYFORCE!</h1>
                                        <p>В команде из более 2000 человек добавился новый участник! Это Вы!</p>
                                        <br/>
                                        <h2>Вам оформлена онлайн регистрация в личном кабинете MYFORCE</h2>
                                        <br/>
                                        <b>Логин: </b><span>{$phone}</span><br>
                                        <b>Пароль: </b><span>{$pwd}</span><br>
                                        <b>Ссылка на личный кабинет: (Внимание! Никому не передавайте эту ссылку, т.к. она является доступом к вашему личному кабинету!) </b><a href='https://myforce.ru/site/popup-login?url=https://user.myforce.ru/{$site}&auth={$user->auth_key}'>https://myforce.ru/site/popup-login?url=https://user.myforce.ru/{$site}&auth={$user->auth_key}</a>
                                        <br/>
                                        <p>Перейдите по ссылке и заполните анкетные данные, чтобы пользоваться всеми возможностями личного кабинета MYFORCE:</p>
                                        <ul>
                                            <li>- Лиды на Банкротство и другие ниши</li>
                                            <li>- Разработка IT продуктов и настройка рекламы</li>
                                            <li>- Обучение менеджеров</li>
                                            <li>- Поиск персонала</li>
                                            <li>- База знаний для партнеров</li>
                                            <li>- Арбитражные управляющие</li>
                                        </ul>
                                        <p>И другие сервисы экосистемы!</p>
                                        <br>
                                        <p>Приятного вам дня!</p>
                                        <p>myforce.ru</p>")
                    ->send();

                $contactArr = [
                    'fields' => [
                        "NAME" => $fio,
                        "OPENED" => "Y",
                        "ASSIGNED_BY_ID" => 720,
                        "SOURCE_ID" => 64,
                        'UF_CRM_1612930698601' => $user_id,
                        "PHONE" => [["VALUE" => $phone, "VALUE_TYPE" => "WORK"]],
                        "EMAIL" => [["VALUE" => $email, "VALUE_TYPE" => "WORK"]],
                    ],
                    'params' => ['REGISTER_SONET_EVENT' => 'Y']
                ];
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_CONNECTTIMEOUT => 10,
                    CURLOPT_POST => 1,
                    CURLOPT_HEADER => 0,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://femidaforce.bitrix24.ru/rest/22/8hgvhbcr19elk576/crm.contact.add',
                    CURLOPT_POSTFIELDS => http_build_query($contactArr),
                ));
                $result = curl_exec($curl);
                $id = json_decode($result, 1)['result'];
                usleep(250000);
                if ($site == 'dev') {
                    $category = 114;
                    $stage = 'C114:10';
                } else {
                    $category = 104;
                    $stage = 'C104:1';
                }
                $contactData = [
                    'fields' => [
                        'TITLE' => "Регистрация в личном кабинете",
                        'UF_CRM_1612845002560' => $fio,
                        'OPENED' => "Y",
                        'ASSIGNED_BY_ID' => 720,
                        'SOURCE_ID' => 64,
                        'CONTACT_ID' => $id,
                        'UF_CRM_1612845320212' => $email,
                        'UF_CRM_1594802948504' => $phone,
                        'UF_CRM_1612930698601' => $user_id,
                        'CATEGORY_ID' => $category,
                        'STAGE_ID' => $stage,
                        "UTM_SOURCE" => !empty($_SESSION['utm_source']) ? $_SESSION['utm_source'] : '',
                        "UTM_CAMPAIGN" => !empty($_SESSION['utm_campaign']) ? $_SESSION['utm_campaign'] : '',
                    ],
                    'params' => ['REGISTER_SONET_EVENT' => 'Y']
                ];
                curl_setopt_array($curl, array(
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_TIMEOUT => 10,
                    CURLOPT_CONNECTTIMEOUT => 10,
                    CURLOPT_POST => 1,
                    CURLOPT_HEADER => 0,
                    CURLOPT_RETURNTRANSFER => 1,
                    CURLOPT_URL => 'https://femidaforce.bitrix24.ru/rest/22/8hgvhbcr19elk576/crm.deal.add',
                    CURLOPT_POSTFIELDS => http_build_query($contactData),
                ));
                $response = curl_exec($curl);
                if ($response === false) {
                    $r = ['error' => curl_error($curl), 'errorCURL' => 1];
                    curl_close($curl);
                    $rsp = $r;
                } else {
                    curl_close($curl);
                    //                    if (!$ext)
                    //                        $rsp = Yii::$app->response->redirect("https://user.myforce.ru/{$site}");
                    //                    else
                    $rsp = ['status' => 'success', 'url_after_login' => "https://user.myforce.ru/{$site}", 'auth' => $user->auth_key];
                }
            } else $rsp = ['status' => 'error', 'message' => 'Ошибка авторизации'];
        } else {
            if ($user_id === false)
                $rsp = ['status' => 'error', 'message' => 'Ошибка сохранения пользователя'];
            else
                $rsp = ['status' => 'error', 'message' => 'Пользователь с таким телефоном уже существует'];
        }
        return $rsp;
    }

    public function beforeAction($action)
    {
        Yii::$app->session->set('voronka', 104);
        $actions = [
            'external-signup',
            'external-login',
            'check-phone-exist',
            'myforce-reg-online',
            'confirm-credit-pay',
            'fail-credit-pay',
        ];
        if (in_array($action->id, $actions))
            $this->enableCsrfValidation = false;
        return parent::beforeAction($action); // TODO: Change the autogenerated stub
    }

    //    public function actionExternalLogin($id, $hash)
    //    {
    //        $md5 = md5("{$id}::fghjkeiur");
    //
    //        if ($hash !== $md5){
    //            return $this->goHome();
    //        } else {
    //            Yii::$app->user->login(User::findIdentity($id), 3600 * 24 * 30);
    //        }
    //    }

    public function actionExternalSignup()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        do {
            $hash = $_POST['signup_code'];
            if (empty($hash)) {
                $rsp = ['status' => 'error', 'message' => 'Ошибочный запрос'];
                break;
            }
            $fio = $_POST['fio'];
            $phone = $_POST['phone']; // значение phone - должно быть обработано регуляркой, т.е. только цифры в POST, первая цифра - 7
            $hash_0 = md5("{$fio}::{$phone}::ext_signup");
            if ($hash_0 !== $hash) {
                $rsp = ['status' => 'error', 'message' => 'Ошибка контрольной суммы'];
                break;
            }
            $userControl = UserModel::findOne(['username' => $phone]);
            if (!empty($userControl)) {
                $rsp = ['status' => 'error', 'message' => 'Пользователь с таким телефоном уже существует'];
                break;
            }
            $model = new SignupForm();
            $model->username = $phone;
            $model->email = $_POST['email'];
            if (!empty($_POST['client'])) {
                $model->is_client = -1;
            } else {
                $model->is_client = 1;
            }
            $model->password = User::generate_string(10);
            $user_id = $model->signup();
            $rsp = $this::afterSignupAction(null, $email ?? null, $user_id, $phone, $model->password, $fio, true);
        } while (false);
        return $rsp;
    }
    #СТАРОЕ ПОДТВЕРЖДЕНИЕ РЕГИ
    //    public function actionConfirmSignup()
    //    {
    //        Yii::$app->response->format = Response::FORMAT_JSON;
    //        if (!empty($_POST['code']) && !empty($_POST['fio']) && !empty($_POST['phone'])) {
    //            $phone = preg_replace('/[^\d]+/', '', Html::encode($_POST['phone']));
    //            $code_send = hexdec(substr(md5($phone . "myforce_code"), 7, 5));
    //            if ($code_send === (int)$_POST['code']) {
    //                $_SESSION['fio'] = $_POST['fio'];
    //                $model = new SignupForm();
    //                $model->username = $phone;
    //                $model->email = $_POST['email'];
    //                if (!empty($_POST['client'])) {
    //                    $model->is_client = -1;
    //                } else {
    //                    $model->is_client = 1;
    //                }
    //                if (!empty($_POST['site'])) {
    //                    switch ($_POST['site']) {
    //                        case 'femida':
    //                            $site = 'femida/';
    //                            break;
    //                        case 'lead':
    //                            $site = 'lead-force/';
    //                            break;
    //                        case 'dev':
    //                            $site = 'dev';
    //                            break;
    //                        default:
    //                            $site = 'user-login';
    //                    }
    //                }
    //                $model->password = User::generate_string(10);
    //                $user_id = $model->signup();
    //                return $this::afterSignupAction($_POST['email'] ?? null, $user_id, $phone, $model->password, $_POST['fio'], $site ?? null);
    //            } else return ['status' => 'error', 'message' => 'Ошибка контрольной суммы'];
    //        } else return ['status' => 'error', 'message' => 'Не указаны обязательные параметры'];
    //    }
    #СТАРОЕ ПОДТВЕРЖДЕНИЕ РЕГИ

    public function actionConfirmSignup()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['fio']) && !empty($_POST['phone']) && !empty($_POST['email'])) {
            $phone = preg_replace('/[^\d]+/', '', Html::encode($_POST['phone']));
            $_SESSION['fio'] = $_POST['fio'];
            $model = new SignupForm();
            $model->username = $phone;
            $model->email = $_POST['email'];
            if (!empty($_POST['client'])) {
                $model->is_client = -1;
            } else {
                $model->is_client = 1;
            }
            if (!empty($_POST['site'])) {
                switch ($_POST['site']) {
                    case 'femida':
                        $site = 'femida/';
                        break;
                    case 'lead':
                        $site = 'lead-force/';
                        break;
                    case 'dev':
                        $site = 'dev';
                        break;
                    default:
                        $site = 'user-login';
                }
            } else {
                $site = 'user-login';
            }
            $model->password = User::generate_string(10);
            $user_id = $model->signup();
            return $this::afterSignupAction($site, $_POST['email'] ?? null, $user_id, $phone, $model->password, $_POST['fio'], $site ?? null);
        } else return ['status' => 'error', 'message' => 'Не указаны обязательные параметры'];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            //            'error' => [
            //                'class' => 'yii\web\ErrorAction',
            //            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Майфорс, Myforce, бизнес сервис, сервис для предпренимателей, купить франшизу, Купить лиды, новости бизнеса']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'MYFORCE - это удобный бизнес-сервис для предпринимателей. У нас вы найдете выгодные франшизи для вас и вашего бизнесса, а также горячие заявки и готовые клиенты!']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Бизнес система для предпринимателей']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/mainimg/photo-goup-team.png']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'MYFORCE - это удобный бизнес-сервис для предпринимателей. У нас вы найдете выгодные франшизи для вас и вашего бизнесса, а также горячие заявки и готовые клиенты!']);
        $cases = Cases::find()
            ->orderBy('id desc')
            ->asArray()
            ->limit(!empty($_GET['count']) ? (int)$_GET['count'] : 7)
            ->all();
        $casesColl = Cases::find()->count();
        $event = Events::find()->orderBy('id desc')->asArray()->all();
        $oneEvents = Events::find()->orderBy('id desc')->where(['type' => 'Мероприятие'])->asArray()->one();
        $events = Events::find()->orderBy('id desc')->where(['type' => 'Мероприятие'])->limit(6)->asArray()->all();
        $sale = Events::find()->orderBy('id desc')->where(['type' => 'Акция'])->limit(6)->asArray()->all();
        $occasion = Events::find()->orderBy('id desc')->where(['type' => 'Событие'])->limit(6)->asArray()->all();
        $news = News::find()->orderBy('id desc')->where(['tag' => 'маркетинг'])->asArray()->limit(3)->all();
        $newses = News::find()->orderBy('id desc')->where(['OR', ['tag' => 'общие'], ['tag' => 'главная']])->asArray()->limit(3)->all();
        $referals = ReferalLink::find()
            ->orderBy('id desc')
            ->asArray()
            ->limit(!empty($_GET['cols']) ? (int)$_GET['cols'] : 7)
            ->all();
        $refCount = ReferalLink::find()->count();
        return $this->render(
            'index',
            [
                'cases' => $cases,
                'event' => [],
                'events' => [],
                'sale' => [],
                'occasion' => [],
                'news' => $news,
                'newses' => $newses,
                'oneEvents' => [],
                'casesColl' => $casesColl,
                'referals' => $referals,
                'refCount' => $refCount,
            ]
        );
    }

    public function actionCase($link)
    {

        if (!empty($link)) {
            $cases = Cases::find()->orderBy('link')->where(['link' => $link])->asArray()->one();
            $cases_one = Cases::find()
                ->orderBy('id desc')
                ->asArray()
                ->limit(!empty($_GET['count']) ? (int)$_GET['count'] : 7)
                ->all();
            $casesColl = Cases::find()->count();

            $this->view->registerMetaTag(['name' => 'keywords', 'content' => $cases['meta_keywords']]);
            $this->view->registerMetaTag(['name' => 'description', 'content' => $cases['og_description']]);
            $this->view->registerMetaTag(['property' => 'og:title', 'content' => $cases['og_title']]);
            $this->view->registerMetaTag(['property' => 'og:image', 'content' => UrlHelper::admin($cases['og_image'])]);
            $this->view->registerMetaTag(['property' => 'og:url', 'content' => Url::to('https://myforce.ru/case/' . $cases['link'])]);
            $this->view->registerMetaTag(['property' => 'og:description', 'content' => $cases['og_description']]);
            if (!empty($cases)) {
                $moreCase = Cases::find()
                    ->where(['!=', 'id', $cases['id']])
                    ->orderBy('id desc')
                    ->asArray()
                    ->all();
                return $this->render('case', ['cases' => $cases, 'moreCase' => $moreCase, 'cases_one' => $cases_one, 'casesColl' => $casesColl]);
            } else return $this->redirect(Url::to(['index']));
        } else return $this->redirect(Url::to(['index']));
    }

    public function actionEvents()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'события Myforce, акции Myforce, вебинары Myforce, мероприятия Myforce, события Майфорс, акции Майфорс, вебинары Майфорс, мероприятия Майфорс']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Вы узнаете о всех акциях и событиях которые у нас проходят!']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Все мероприятия']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/mainimg/logo.png']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/events']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Вы узнаете о всех акциях и событиях которые у нас проходят!']);
        if (!empty($_GET['filters'])) {
            $eventsFilter = $_GET['filters'];
            $filteres = ['AND'];
            if (!empty($eventsFilter['type'])) {
                if ($eventsFilter['type'] == 'all') {
                    $filteres[] = '';
                } elseif ($eventsFilter['type'] == 'miting') {
                    $filteres[] = ['=', 'type', 'Мероприятие'];
                } elseif ($eventsFilter['type'] == 'sale') {
                    $filteres[] = ['=', 'type', 'Акция'];
                } elseif ($eventsFilter['type'] == 'events') {
                    $filteres[] = ['=', 'type', 'Событие'];
                }
            }
            $query = Events::find()
                ->asArray()
                ->orderBy('id desc')
                ->select(['id', 'link', 'type', 'preview_text', 'event_date', 'event_finish_date', 'event_city', 'name', 'category', 'img', 'text_color',])
                ->where($filteres);
        } else {
            $query = Events::find()
                ->asArray()
                ->orderBy('id desc')
                ->select(['id', 'link', 'type', 'preview_text', 'event_date', 'event_finish_date', 'event_city', 'name', 'category', 'img', 'text_color',])
                ->where(['=', 'type', "Мероприятие"]);
        }

        $pages = new Pagination(['totalCount' => $query->count(), 'pageSize' => 10]);
        $num = $query->count();
        $posts = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render(
            'events',
            [
                'events' => $posts,
                'pages' => $pages,
                'num' => $num,
                'query' => $query,
                'filter' => $eventsFilter["type"],
            ]
        );
    }

    public function actionEventPage($link)
    {
        $event = Events::findOne(['link' => $link]);
        $events = Events::find()->where([
            "and",
            ['=', 'type', "Мероприятие"],
            ['not', ['link' => $link]]
        ])->limit(3)->all();
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $event->keywords]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => $event->description]);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => $event->title]);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/event-page/' . $event->link]);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => $event->description]);
        return $this->render("event-page", compact('event', 'events'));
    }

    public function actionSalePage($link)
    {
        $event = Events::findOne(['link' => $link]);
        $events = Events::find()->where([
            "and",
            ['=', 'type', "Акция"],
            ['not', ['link' => $link]]
        ])->limit(3)->all();
        $courses = SkillTrainings::find()->orderBy(["students" => SORT_DESC])->limit(4)->all();
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $event->keywords]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => $event->description]);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => $event->title]);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/sale-page/' . $event->link]);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => $event->description]);
        return $this->render("sale-page", compact('event', 'events', 'courses'));
    }

    public function actionOccasionPage($link)
    {
        $event = Events::findOne(['link' => $link]);
        $events = Events::find()->where([
            "and",
            ['=', 'type', "Событие"],
            ['not', ['link' => $link]]
        ])->limit(3)->all();
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => $event->keywords]);
        $this->view->registerMetaTag(['name' => 'description', 'content' => $event->description]);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => $event->title]);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/occasion-page/' . $event->link]);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => $event->description]);
        return $this->render("occasion-page", compact('event', 'events'));
    }

    public function actionEventForm($title)
    {
        return $this->render("event-form", compact('title'));
    }

    public function actionSaveEventForm()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $type = Html::encode($_POST["type"]);
        $name = Html::encode($_POST["name"]);
        $phone = Html::encode($_POST["tel"]);
    }

    public function actionNews()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'Новости бизнеса, новости предпринимательства, новости банкротства']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Будьте в курсе всех последних событий мирового предпринимательства, и бизнеса!']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Новости бизнеса']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/mainimg/logo.png']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/news']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Будьте в курсе всех последних событий мирового предпринимательства, и бизнеса!']);
        if (!empty($_GET['filter'])) {
            $newsFilter = $_GET['filter'];
            $filters = ['AND'];
            $day = date('Y-m-d H:i:s', time() - (60 * 60 * 24));
            $week = date('Y-m-d H:i:s', time() - (60 * 60 * 24 * 7));
            $month = date('Y-m-d H:i:s', time() - (60 * 60 * 24 * 30));
            $year = date('Y-m-d H:i:s', time() - (60 * 60 * 24 * 365));
            if (!empty($newsFilter['date'])) {
                if ($newsFilter['date'] == 'all') {
                    $filters[] = '';
                } elseif ($newsFilter['date'] == 'day') {
                    $filters[] = ['>=', 'date', $day];
                } elseif ($newsFilter['date'] == 'week') {
                    $filters[] = ['>', 'date', $week];
                } elseif ($newsFilter['date'] == 'month') {
                    $filters[] = ['>', 'date', $month];
                } elseif ($newsFilter['date'] == 'year') {
                    $filters[] = ['>', 'date', $year];
                }
            }
            if (!empty($newsFilter['word'])) {
                $filters[] = [
                    'OR',
                    ['like', 'title', "%{$newsFilter['word']}%", false],
                    ['like', 'author', "%{$newsFilter['word']}%", false],
                    ['like', 'content', "%{$newsFilter['word']}%", false],
                ];
            }
            $query = News::find()
                ->orderBy('date desc')
                ->asArray()
                ->select(['id', 'title', 'content', 'date', 'link', 'og_image'])
                ->where(['OR', ['tag' => 'общие'], ['tag' => 'главная']])
                ->andWhere($filters);
        } else {
            $query = News::find()->asArray()->orderBy('id desc')->where(['OR', ['tag' => 'общие'], ['tag' => 'главная']]);
        }
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->pageSize = 12;
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $banner = Banners::find()->orderBy(['rand()' => SORT_DESC])->where('active' == 1)->asArray()->limit(2)->all();
        return $this->render('news', [
            'news' => $models,
            'pages' => $pages,
            'banner' => $banner,
        ]);
    }

    public function actionNewsPage($link)
    {

        if (!empty($link)) {
            $news = News::find()->where(['link' => $link])->asArray()->one();
            $newses = News::find()->orderBy('id desc')->where(['tag' => 'маркетинг'])->asArray()->limit(6)->all();
            $lastNews = News::find()->orderBy('id desc')->where(['!=', 'id', $news['id']])->andWhere(['OR', ['tag' => 'общие'], ['tag' => 'главная']])->limit(5)->asArray()->all();
            $banner = Banners::find()->orderBy(['rand()' => SORT_DESC])->where('active' == 1)->asArray()->limit(2)->all();
            if (!empty($news)) {
                $this->view->registerMetaTag(['name' => 'keywords', 'content' => $news['meta_keywords']]);
                $this->view->registerMetaTag(['name' => 'description', 'content' => $news['og_description']]);
                $this->view->registerMetaTag(['property' => 'og:title', 'content' => $news['og_title']]);
                $this->view->registerMetaTag(['property' => 'og:type', 'content' => 'article']);
                $this->view->registerMetaTag(['property' => 'og:image', 'content' => UrlHelper::admin($news['og_image'])]);
                $this->view->registerMetaTag(['property' => 'og:url', 'content' => Url::to('https://myforce.ru/news-page/' . $news['link'])]);
                $this->view->registerMetaTag(['property' => 'og:description', 'content' => $news['og_description']]);
                return $this->render('news-page', ['news' => $news, 'newses' => $newses, 'lastNews' => $lastNews, 'banner' => $banner]);
            } else return $this->redirect(Url::to(['news']));
        } else return $this->redirect(Url::to(['news']));
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (!empty($_SESSION['__returnUrl']) && $_SESSION['__returnUrl'] === 'https://myforce.ru/au')
                return $this->redirect('https://myforce.ru/au');
            else
                return $this->redirect('https://user.myforce.ru/');
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            return $this->redirect('https://user.myforce.ru/site/logout');
        } else {
            return $this->redirect('https://myforce.ru');
        }
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    /* public function actionContact()
     {
         $model = new ContactForm();
         if ($model->load(Yii::$app->request->post()) && $model->validate()) {
             if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                 Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
             } else {
                 Yii::$app->session->setFlash('error', 'There was an error sending your message.');
             }

             return $this->refresh();
         } else {
             return $this->render('contact', [
                 'model' => $model,
             ]);
         }
     }*/

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        $news = News::find()
            ->orderBy('id desc')
            ->where(['OR', ['tag' => 'общие'], ['tag' => 'главная']])
            ->asArray()
            ->limit(6)
            ->all();
        return $this->render('about', ['news' => $news]);
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @return yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionForm()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isPost) {
            $form = new Form(Yii::$app->request->post());
            $form->get__ip($_SERVER['REMOTE_ADDR']);
            if ($form->set__properties()) {
                $form->parse__region();
                if ($form->validate__properties()) {
                    return $form->process__form();
                } else
                    return ['status' => 'error', 'message' => 'Форма не прошла валидацию'];
            } else
                return ['status' => 'error', 'message' => 'Не указаны обязательные поля формы'];
        } else {
            return ['status' => 'error', 'message' => 'Неправильный формат запроса'];
        }
    }

    public function actionSuccessPayment()
    {
        if (!empty($_GET)) {
            if (empty($_GET['IsTest']))
                $mrh_pass1 = Robokassa::PASSWORD_MAIN_1;
            else
                $mrh_pass1 = Robokassa::PASSWORD_TEST_1;
            $out_summ = $_REQUEST["OutSum"];
            $inv_id = $_REQUEST["InvId"];
            $crc = $_REQUEST["SignatureValue"];
            $crc = strtoupper($crc);
            $defaultText = "$out_summ:$inv_id:$mrh_pass1";
            $arrGet = $_GET;
            ksort($arrGet);
            foreach ($arrGet as $key => $item) {
                if (strpos($key, 'Shp') !== false)
                    $defaultText .= ":{$key}={$item}";
            }
            $my_crc = strtoupper(md5($defaultText));
            if ($my_crc != $crc) {
                $this->goHome();
            }
            file_put_contents('logs/success.log', json_encode($_GET, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
            $this->view->registerMetaTag(['name' => 'robots', 'content' => "noindex, nofollow"]);
            return $this->render('success-payment', ['redirect' => !empty($_GET['Shp_redirect']) ? $_GET['Shp_redirect'] : null]);
        } else
            return $this->goHome();
    }

    public function actionFailurePayment()
    {
        if (!empty($_GET)) {
            file_put_contents('logs/failure.log', json_encode($_GET, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
            $this->view->registerMetaTag(['name' => 'robots', 'content' => "noindex, nofollow"]);
            return $this->render('failure-payment', ['redirect' => !empty($_GET['Shp_redirect']) ? $_GET['Shp_redirect'] : null]);
        } else
            return $this->goHome();
    }

    public function actionBflQuiz()
    {
        $this->layout = false;
        return $this->render('bfl-quiz');
    }

    public function actionQuiz()
    {
        $this->layout = false;
        return $this->render('quiz');
    }

    public function actionThanks()
    {
        $this->layout = false;
        return $this->render('thanks');
    }

    public function actionLidyNaBankrotstvo()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'купить лиды на банкротство физических лиц, цена на лиды по банкротству физических лиц, заявки от клиентов на банкротство, лиды по банкротству физ лиц']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Купить лиды на банкротство физических лиц с обработкой контакт-центра. Качественные заявки от клиентов на банкротство, узнайте цены на лиды от MYFORCE']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Лиды на банкротство физических лиц (заявки от целевых клиентов)']);
        $this->view->registerMetaTag(['property' => 'og:image', 'content' => 'https://myforce.ru/img/mainimg/photo-goup-team.png']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'https://myforce.ru/']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Купить лиды на банкротство физических лиц с обработкой контакт-центра. Качественные заявки от клиентов на банкротство, узнайте цены на лиды от MYFORCE']);
        Yii::$app->view->title = 'Лиды на банкротство физических лиц (заявки от целевых клиентов)';
        return $this->render('lidy-na-bankrotstvo');
    }

    public function actionBussinessQuiz()
    {
        $this->layout = false;
        return $this->render('bussiness-quiz');
    }

    public function actionQuizB()
    {
        $this->layout = false;
        return $this->render('quiz-b');
    }

    public function actionThanksB()
    {
        $this->layout = false;
        return $this->render('thanks-b');
    }

    public function actionBussinessSend()
    {
        $fio = $_POST['fio'];
        $phone = $_POST['phone'];
        $phone2 = $_POST['phone2'];
        $email = $_POST['email'];
        $new_region = $_POST['new_region'];
        $city = $_POST['city'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $com = ""; //Это если есть не стандартные инпуты

        if (!empty($_POST['query_string']))
            parse_str($_POST['query_string'], $utm);

        if (!empty($_POST)) {
            foreach ($_POST as $key => $item)
                $post[$key] = htmlspecialchars($item);
            $com .= !empty($post['why']) ? "Для чего Вам нужны новые клиенты?: {$post['why']} <br>" : '';
            $com .= !empty($post['convenience']) ? "Насколько вам это подходит?: {$post['convenience']} <br>" : '';
            $com .= !empty($post['when']) ? "Когда Вы готовы принять новых клиентов?: {$post['when']} <br>" : '';
            $com .= !empty($post['ready']) ? "Вы готовы расширить штат сотрудников, если мы закроем вопрос с клиентами?: {$post['ready']} <br>" : '';
            $com .= !empty($utm['utm_medium']) ? "utm_medium :{$utm['utm_medium']} <br>" : '';
            $com .= !empty($utm['utm_content']) ? "utm_content: {$utm['utm_content']} <br>" : '';
            $com .= !empty($utm['utm_term']) ? "utm_term: {$utm['utm_term']} <br>" : '';
            $com .= !empty($ip) ? "IP: {$ip} <br>" : '';
        }
        /*ДАННЫЕ*/
        $curloptURL = 'https://api.femidafors.ru/site/new-lead';
        $data = [

            'department' => 'seller',
            'name' => $fio ?? 'Без имени',
            'phone' => $phone ?? null,
            'phone2' => '' ?? null,
            'phone_messenger' => $phone ?? null,
            'email' => $email ?? null,
            'city' => $new_region ?? null,
            'city_real' => $city ?? null,
            'utm_source' => $utm['utm_source'] ?? '',
            'utm_campaign' => $utm['utm_campaign'] ?? '',
            'commentary' => $com,
            'category' => 60, # числовое значение, указывается из перечня: 58, 60, 62, 64, 66, 68
            # 58 - воронка "воронка", 60 - воронка "лиды", 62 - воронка "срм",
            # 64 - воронка "франшиза", 66 - воронка "партнеры", 68 - воронка "АУ"
            # значение указываем по смыслу отправляемой формы, узнать нужную воронку можно у Мирослава, Ксении или, возможно, Игоря
            'typeOfService' => 1334,
            'stage' => 'C60:NEW',
            'source_bitrix' => '84',
            'source_real' => 'https://myforce.ru/bussiness-quiz',
        ];
        /*ДАННЫЕ*/

        /*ОТПРАВКА*/
        $curl = curl_init();
        curl_setopt_array($curl, array(
            //            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_CONNECTTIMEOUT => 4,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $curloptURL,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        /*ОТПРАВКА*/

        echo !$response ? "CURL ERROR: " . curl_error($curl) : $response; # здесь ответ сервера
        # можно глянуть
    }

    public function actionBflSend()
    {
        $fio = $_POST['fio'];
        $phone = $_POST['phone'];
        $phone2 = $_POST['phone2'];
        $email = $_POST['email'];
        $new_region = $_POST['new_region'];
        $city = $_POST['city'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $com = ""; //Это если есть не стандартные инпуты


        if (!empty($_POST['query_string']))
            parse_str($_POST['query_string'], $utm);

        if (!empty($_POST)) {
            foreach ($_POST as $key => $item)
                $post[$key] = htmlspecialchars($item);
            $com .= !empty($post['why']) ? "Для чего Вам нужны новые клиенты?: {$post['why']} <br>" : '';
            $com .= !empty($post['convenience']) ? "Насколько вам это подходит?: {$post['convenience']} <br>" : '';
            $com .= !empty($post['when']) ? "Когда Вы готовы принять новых клиентов?: {$post['when']} <br>" : '';
            $com .= !empty($post['ready']) ? "Вы готовы расширить штат сотрудников, если мы закроем вопрос с клиентами?: {$post['ready']} <br>" : '';
            $com .= !empty($utm['utm_medium']) ? "utm_medium :{$utm['utm_medium']} <br>" : '';
            $com .= !empty($utm['utm_content']) ? "utm_content: {$utm['utm_content']} <br>" : '';
            $com .= !empty($utm['utm_term']) ? "utm_term: {$utm['utm_term']} <br>" : '';
            $com .= !empty($ip) ? "IP: {$ip} <br>" : '';
        }
        /*ДАННЫЕ*/
        $curloptURL = 'https://api.femidafors.ru/site/new-lead';
        $data = [

            'department' => 'seller',
            'name' => $fio ?? 'Без имени',
            'phone' => $phone ?? null,
            'phone2' => '' ?? null,
            'phone_messenger' => $phone ?? null,
            'email' => $email ?? null,
            'city' => $new_region ?? null,
            'city_real' => $city ?? null,
            'utm_source' => $utm['utm_source'] ?? '',
            'utm_campaign' => $utm['utm_campaign'] ?? '',
            'commentary' => $com,
            'category' => 104, # числовое значение, указывается из перечня: 58, 60, 62, 64, 66, 68
            # 58 - воронка "воронка", 60 - воронка "лиды", 62 - воронка "срм",
            # 64 - воронка "франшиза", 66 - воронка "партнеры", 68 - воронка "АУ"
            # значение указываем по смыслу отправляемой формы, узнать нужную воронку можно у Мирослава, Ксении или, возможно, Игоря

            'typeOfService' => 1334,
            'stage' => 'C104:NEW',
            'source_bitrix' => '83',
            'source_real' => 'https://myforce.ru/bfl-quiz',
        ];
        /*ДАННЫЕ*/

        /*ОТПРАВКА*/
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_CONNECTTIMEOUT => 4,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $curloptURL,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        /*ОТПРАВКА*/

        echo !$response ? "CURL ERROR: " . curl_error($curl) : $response; # здесь ответ сервера
        # можно глянуть
    }

    public function actionEventSend()
    {
        $fio = $_POST['fio'];
        $phone = $_POST['phone'];
        $com = "{$_POST['title']}" ?? 'Заголовок отсутствует';

        /*ДАННЫЕ*/
        $curloptURL = 'https://api.femidafors.ru/site/new-lead';
        $data = [

            'department' => 'seller',
            'name' => $fio ?? 'Без имени',
            'phone' => $phone ?? null,
            'phone2' => '',
            'phone_messenger' => $phone ?? null,
            'email' => '',
            'city' => '',
            'city_real' => '',
            'utm_source' => '',
            'utm_campaign' => '',
            'commentary' => $com,
            'category' => 104, # числовое значение, указывается из перечня: 58, 60, 62, 64, 66, 68
            # 58 - воронка "воронка", 60 - воронка "лиды", 62 - воронка "срм",
            # 64 - воронка "франшиза", 66 - воронка "партнеры", 68 - воронка "АУ"
            # значение указываем по смыслу отправляемой формы, узнать нужную воронку можно у Мирослава, Ксении или, возможно, Игоря

            'typeOfService' => 1334,
            'stage' => 'C104:NEW',
            'source_bitrix' => '64',
            'source_real' => 'https://myforce.ru/event-form',
        ];
        /*ДАННЫЕ*/

        /*ОТПРАВКА*/
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_TIMEOUT => 4,
            CURLOPT_CONNECTTIMEOUT => 4,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $curloptURL,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        /*ОТПРАВКА*/

        echo !$response ? "CURL ERROR: " . curl_error($curl) : $response; # здесь ответ сервера
        die();
        # можно глянуть
    }

    public function actionMyforceRegOnline($phone, $email)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $phone = preg_replace('/[^\d]+/', '', Html::encode($phone));
        $phone[0] = 7;
        $user = User::findOne(['username' => $phone]);
        if (empty($user)) {
            $model = new SignupForm();
            $model->username = $phone;
            $model->is_client = 1;
            $model->email = $email;
            $model->password = User::generate_string(10);
            $user_id = $model->signup();
            return $this::afterSignupAction('lead-force/', $email ?? null, $user_id, $phone, $model->password, null, $site ?? null);
        } else {
            return ['status' => 'error'];
        }
    }

    public function actionConfirmCreditPay($uid, $price, $hash, $pay_id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $payInfo = CreditPay::findOne($pay_id);
        if (empty($payInfo)) {
            return $this->redirect('https://user.myforce.ru?flash=error');
        }
        if ($payInfo->status === 1) {
            return $this->redirect('https://user.myforce.ru?flash=error');
        }

        $paymentHistory = CreditPay::find()->where(['user_id' => $uid])->andWhere(['!=', 'id', $pay_id])->orderBy('id desc')->one();
        if (date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime('+1 day', strtotime($paymentHistory->date)))) {
            $hashCheck = md5("{$price}::{$uid}::{$pay_id}::dfg4ttvsd");
            if ($hashCheck === $hash) {
                $user = User::findOne($uid);
                $user->budget = $user->budget + $price;
                if ($user->update() !== false) {
                    $payInfo->status = 1;
                    if ($payInfo->update() !== false) {
                        $messages = "<a href='https://admin.myforce.ru/users/view?id={$uid}'>Пользователь</a> ЛК: {$user->username}, пополнил баланс личного кабинета в кредит. На сумму {$price} рублей. Зайти в <a href='https://ecom.otpbank.ru/'>ОТП</a> и проверить наличие кредита";
                        $tg = new TelegramBot();
                        $tg->new__message($messages, $tg::PEER_SALE);
                        return $this->redirect('https://user.myforce.ru?flash=success');
                    } else {
                        return $this->redirect('https://user.myforce.ru?flash=error');
                    }
                } else {
                    return $this->redirect('https://user.myforce.ru?flash=error');
                }
            } else {
                return $this->redirect('https://user.myforce.ru?flash=error');
            }
        } else {
            return $this->redirect('https://user.myforce.ru?flash=error');
        }
    }

    public function actionFailCreditPay()
    {
        return $this->redirect('https://user.myforce.ru?flash=error');
    }


    public function actionArbitraj()
    {
        $this->view->registerMetaTag(['name' => 'keywords', 'content' => 'АУ, Арбитражное управление, Партнерская программа, MYFORCE, бфл, банкроство']);
        $this->view->registerMetaTag(['name' => 'description', 'content' => 'Партнерская программа MYFORCE — делегируйте арбитражное управление своих банкротов профессионалам с гарантией на снятие прожиточных минимумов в срок']);
        $this->view->registerMetaTag(['property' => 'og:title', 'content' => 'Арбитражное управление при банкротстве физических и юридических лиц']);
        $this->view->registerMetaTag(['property' => 'og:url', 'content' => 'http://myforce.ru/arbitraj']);
        $this->view->registerMetaTag(['property' => 'og:description', 'content' => 'Партнерская программа MYFORCE — делегируйте арбитражное управление своих банкротов профессионалам с гарантией на снятие прожиточных минимумов в срок']);
        return $this->render('arbitration');
    }

    public function actionArbitrajTnx()
    {
        return $this->render('arbitration-thanks');
    }

    public function actionTested() {

        $credentials = [
            'id' => 22,
            'webhook' => '8hgvhbcr19elk576',
            'domain' => 'femidaforce.bitrix24.ru'
        ];
        $lb = new \f1yback\Bitrix24\LazyBitrix($credentials);
        $lb->request('crm.lead.list', function ($response) {
            $data = json_decode($response, 1);
            print_r($data['result'][2]);
        });
        die();
    }


}
