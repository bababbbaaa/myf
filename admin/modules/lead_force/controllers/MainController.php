<?php

namespace admin\modules\lead_force\controllers;

use admin\controllers\AccessController;
use admin\models\Admin;
use admin\models\BackendContactCenter1;
use admin\models\BasesContacts;
use admin\models\BasesUtm;
use admin\models\DealsBackdoor;
use api\controllers\PaymentsResultController;
use api\models\Bitrix24;
use common\models\BackdoorHooks;
use common\models\BavariaBotMessages;
use common\models\BavariaBotPlaces;
use common\models\BavariaBotPlacesAlias;
use common\models\CcLeads;
use common\models\Clients;
use common\models\DbPhones;
use common\models\DbRegion;
use common\models\helpers\PhoneRegionHelper;
use common\models\helpers\TelegramBot;
use common\models\IntegrationsSpecialParams;
use common\models\JobsQueue;
use common\models\Leads;
use common\models\LeadsBackdoor;
use common\models\LeadsParams;
use common\models\LeadsSentReport;
use common\models\m3\M3TelegramBot;
use common\models\Orders;
use common\models\Providers;
use common\models\TgMessages;
use common\models\Worker;
use console\controllers\CronController;
use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;
use Yii;
use yii\data\Pagination;
use yii\db\Exception;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;

/**
 * Default controller for the `cms` module
 */
class MainController extends AccessController
{


    /**
     *
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->can('partnerManager'))
            $this->redirect('/lead-force/clients');
        return $this->render('index');
    }

    public function actionGetRegionsAjax()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (isset($_POST['find'])) {
            $value = $_POST['find'];
            $regionsRends = new Admin('clients');
            return $regionsRends->getAjaxGeo($value);
        } else
            return ['status' => 'error', 'message' => "Поисковое значение не найдено"];
    }

    public function actionOauth()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['server'])) {
            do {
                if (empty($_POST['client_id'])) {
                    $response = ['status' => 'error', 'message' => 'Не указан идентификатор интеграции'];
                    break;
                }
                if (empty($_POST['client_secret'])) {
                    $response = ['status' => 'error', 'message' => 'Не указан секретный ключ'];
                    break;
                }
                if (empty($_POST['code'])) {
                    $response = ['status' => 'error', 'message' => 'Не указан код авторизации OAuth'];
                    break;
                }
                $server = $_POST['server'];
                $link = "https://{$server}/oauth2/access_token";
                $data = [
                    'client_id' => $_POST['client_id'],
                    'client_secret' => $_POST['client_secret'],
                    'code' => $_POST['code'],
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => 'https://myforce.ru',
                ];
                $amo = new Admin('integrations');
                $amoRsp = $amo->curlAMO($link, $data);
                $code = $amoRsp['code'];
                $out = $amoRsp['out'];
                $code = (int)$code;
                $errors = [
                    400 => 'В отправляемых данных содержится ошибка либо код авторизации уже был использован',
                    401 => 'Ошибка авторизации',
                    402 => 'Аккаунт требует оплаты для работы с API',
                    403 => 'Доступ запрещен или аккаунт заблокирован',
                    404 => 'Страница не найдена',
                    500 => 'Внутренняя ошибка сервиса AmoCRM',
                    502 => 'Apache не смог обработать запрос',
                    503 => 'Сервис не доступен',
                ];
                try {
                    if ($code < 200 || $code > 204) {
                        $response = ['status' => 'error', 'message' => isset($errors[$code]) ? $errors[$code] : 'Неизвестная ошибка', $code];
                        break;
                    }
                } catch (\Exception $e) {
                    $response = ['status' => 'error', 'message' => 'Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode()];
                    break;
                }
                $responseTokens = json_decode($out, true);
                $responseTokens['expires_in'] = time() + (int)$responseTokens['expires_in'];
                $response = [
                    'status' => 'success',
                    'data' => $responseTokens
                ];
                $_SESSION['amoTOKENS'] = ['raw' => array_merge($data, ['server' => $server]), 'response' => $responseTokens];
            } while (false);
        } else
            $response = ['status' => 'error', 'message' => 'Сервер не указан'];
        return $response;
    }

    public function actionAmoGetInfo()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_POST['server']) && !empty($_POST['access_token'])) {
            $not_support = [
                'legal_entity',
                'date_time',
                'birthday',
                'streetaddress',
                'smart_address',
                'date',
                'url',
            ];
            $page = 1;
            $contactsFields = [
                /*'name' => [
                    'name' => 'Название контакта',
                    'type' => 'text',
                    'enums' => null
                ],*/
                'responsible_user_id' => [
                    'name' => 'Ответственный пользователь (ID)',
                    'type' => 'int',
                    'enums' => null
                ],
            ];
            $leadsFields = [
                /*'name' => [
                    'name' => 'Название сделки',
                    'type' => 'text',
                    'enums' => null
                ],*/
                'responsible_user_id' => [
                    'name' => 'Ответственный пользователь (ID)',
                    'type' => 'int',
                    'enums' => null
                ],
                'status_id' => [
                    'name' => 'Статус сделки (ID)',
                    'type' => 'int',
                    'enums' => null
                ],
                'pipeline_id' => [
                    'name' => 'Воронка (ID)',
                    'type' => 'int',
                    'enums' => null
                ]
            ];
            $subdomain = $_POST['server'];
            $link = 'https://' . $subdomain . '/api/v4/contacts/custom_fields?page=' . $page;
            $access_token = $_POST['access_token'];
            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $access_token
            ];
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            $out = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($out, 1);
            if (!empty($response['_embedded']['custom_fields'])) {
                $count = $response['_page_count'];
                foreach ($response['_embedded']['custom_fields'] as $item) {
                    if (in_array($item['type'], $not_support))
                        continue;
                    $contactsFields[$item['id']] = [
                        'name' => $item['name'],
                        'type' => $item['type'],
                        'enums' => $item['enums']
                    ];
                }
                if ($count !== $page) {
                    while ($count >= $page) {
                        $page++;
                        $link = 'https://' . $subdomain . '/api/v4/contacts/custom_fields?page=' . $page;
                        usleep(334000);
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
                        curl_setopt($curl, CURLOPT_URL, $link);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($curl, CURLOPT_HEADER, false);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                        $out = curl_exec($curl);
                        curl_close($curl);
                        $response = json_decode($out, 1);
                        if (!empty($response['_embedded']['custom_fields'])) {
                            $count = $response['_page_count'];
                            foreach ($response['_embedded']['custom_fields'] as $item) {
                                if (in_array($item['type'], $not_support))
                                    continue;
                                $contactsFields[$item['id']] = [
                                    'name' => $item['name'],
                                    'type' => $item['type'],
                                    'enums' => $item['enums']
                                ];
                            }
                        }
                    }
                }
            }
            usleep(334000);
            $page = 1;
            $link = 'https://' . $subdomain . '/api/v4/leads/custom_fields?page=' . $page;
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            $out = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($out, 1);
            if (!empty($response['_embedded']['custom_fields'])) {
                $count = $response['_page_count'];
                foreach ($response['_embedded']['custom_fields'] as $item) {
                    if (in_array($item['type'], $not_support))
                        continue;
                    $leadsFields[$item['id']] = [
                        'name' => $item['name'],
                        'type' => $item['type'],
                        'enums' => $item['enums']
                    ];
                }
                if ($count !== $page) {
                    while ($count >= $page) {
                        $page++;
                        $link = 'https://' . $subdomain . '/api/v4/leads/custom_fields?page=' . $page;
                        usleep(334000);
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
                        curl_setopt($curl, CURLOPT_URL, $link);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
                        curl_setopt($curl, CURLOPT_HEADER, false);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
                        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
                        $out = curl_exec($curl);
                        curl_close($curl);
                        $response = json_decode($out, 1);
                        if (!empty($response['_embedded']['custom_fields'])) {
                            $count = $response['_page_count'];
                            foreach ($response['_embedded']['custom_fields'] as $item) {
                                if (in_array($item['type'], $not_support))
                                    continue;
                                $leadsFields[$item['id']] = [
                                    'name' => $item['name'],
                                    'type' => $item['type'],
                                    'enums' => $item['enums']
                                ];
                            }
                        }
                    }
                }
            }
            $link = 'https://' . $subdomain . '/api/v4/leads/pipelines';
            usleep(334000);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            $out = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($out, 1);
            if (!empty($response['_embedded']['pipelines'])) {
                foreach ($response['_embedded']['pipelines'] as $item) {
                    $pipelines[$item['id']] = [
                        'name' => $item['name'],
                        'statuses' => $item['_embedded']['statuses']
                    ];
                }
            }
            $link = 'https://' . $subdomain . '/api/v4/users';
            usleep(334000);
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
            curl_setopt($curl, CURLOPT_URL, $link);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
            $out = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($out, 1);
            if (!empty($response['_embedded']['users'])) {
                foreach ($response['_embedded']['users'] as $item) {
                    $users[$item['id']] = [
                        'name' => $item['name'],
                    ];
                }
            }
            $responseArray = [
                'status' => 'success',
                'data' => [
                    'contacts' => $contactsFields,
                    'leads' => $leadsFields,
                    'pipelines' => $pipelines ?? null,
                    'users' => $users ?? null,
                ],
            ];
        } else
            $responseArray = ['status' => 'error', 'message' => 'Не указан сервер или ключ аутентификации.'];
        return $responseArray;
    }

    public function actionAmoGetLeads()
    {
        $this->layout = false;
        $subdomain = 'almeo3000.amocrm.ru';
        $link = 'https://' . $subdomain . '/api/v4/users';
        $access_token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjVlNGY2NDQ0NmVlYmYwOWM4MzE5N2FjYzllYjM2ZDRkOGViYzFhODFiNjBlMWQxNzFlZjY2MmU1YTgzMmIxMTdiMjg0ZjM0OGY3ZDhlZTEyIn0.eyJhdWQiOiIxZGI3Mjk3OS1lMDk5LTQwYWItOGYxYi0wNGZiZTQzMGFmOTciLCJqdGkiOiI1ZTRmNjQ0NDZlZWJmMDljODMxOTdhY2M5ZWIzNmQ0ZDhlYmMxYTgxYjYwZTFkMTcxZWY2NjJlNWE4MzJiMTE3YjI4NGYzNDhmN2Q4ZWUxMiIsImlhdCI6MTYxODgzOTM4MiwibmJmIjoxNjE4ODM5MzgyLCJleHAiOjE2MTg5MjU3ODIsInN1YiI6IjY5NjIyMzYiLCJhY2NvdW50X2lkIjoyOTQyNzY1OCwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.MbCxf74le6LXFTbmI3DZKSuTf5xMdqXeU1igqZQMRMMVjD8NXHTPhe1nU18kmGKLLNHSiBAhqGnKKTQkYjAX4lDlCtcs5GEjnzw_Abn257ALVxBj7T2mHHk4LcyjL86BRzaIP2aSRMoOxpW9mIkw_dNm8dwQ8_vk4ByHquYnpXxmkW7sJI0ydHEN0pmXqI_y3hzjXxAdgYYcC0lpI3BObQJLD5HMfZaab9tBAhfBQ3TVWzTEtx6-xH60wjmKYMChpfA8RPJnnXqD0c7HUWDTNkMEHzLPcDjuK4m-FuvIIA51gUq1BXZSx5ETjr-5PPOhAFpisiCg24KdVu10WPyCDQ';
        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $access_token
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'amoCRM-oAuth-client/1.0');
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        $out = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($out, 1);
        die($out);
    }

    public function actionWebhookAccept()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $url = $_POST['url'];
        if (!empty($url)) {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($curl, CURLOPT_TIMEOUT, 1);
            $out = curl_exec($curl);
            $code = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
            curl_close($curl);
            if ((int)$code === 200)
                $rsp = ['status' => 'success', 'message' => $code];
            else
                $rsp = ['status' => 'error', 'message' => "Возвращаемый код HTTP - " . $code . "<br> Требуемый код - 200"];
        } else
            $rsp = ['status' => 'error', 'message' => 'Укажите URL вебхука'];
        return $rsp;
    }

    public function actionTestHttp()
    { // это варик отправки
        $obj = Leads::find()->orderBy('id desc')->asArray()->one();
        $data_string = json_encode($obj, JSON_UNESCAPED_UNICODE);
        $curl = curl_init('https://api.femidafors.ru/site/test-http2');
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($curl);
        curl_close($curl);
        echo '<pre>';
        echo $result;
        die();
    }

    public function actionTestHttp2()
    {  //это варик получения
        $this->layout = false;
        die(file_get_contents("php://input"));
    }

    /*public function actionMail() {
        return var_dump(date("N"));
    }*/

    public function actionOffers()
    {
        return $this->render('offers');
    }

    public function actionTest()
    {
        /*$lead_data = [
            #обязательные
            'type' => 'dolgi', # тип лидов, можно найти в оффере
            'phone' => '8(909)-012-33-66',
            'ip' => $_SERVER['REMOTE_ADDR'], # либо указать регион
            'region' => 'Московская обл', # либо указать IP
            'provider_token' => '16C-31H-01H-34F-34C-91C-03H-93A-W10X', # ваш ключ оффера
            'offer_token' => '701938dd-edb6-4b3d-968c-1fdb77bbb850', # ключ оффера можно найти в его карточке

            #необязательные
            'name' => 'Вася',
            'email' => 'pupkin.ceo@gmail.co.uk',
            'city' => 'Домодедово',
            'comments' => 'Комментарий 1<br>Комментарий 2',
            'params' => json_encode(['sum' => 1500000, 'sum_text' => 'от 500 000 рублей'],
                JSON_UNESCAPED_UNICODE), # параметры лидов можно узнать в оффере
            'utm_source' => 'some_utm',
            'utm_campaign' => 'some_utm',
            'utm_medium' => 'some_utm',
            'utm_content' => 'some_utm',
            'utm_term' => 'some_utm',
            'utm_title' => 'some_utm',
            'utm_device_type' => 'some_utm',
            'utm_age' => 'some_utm',
            'utm_inst' => 'some_utm',
            'utm_special' => 'some_utm'
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => 'https://api.myforce.ru/lead.add',
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($lead_data),
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true
        ]);

        $response = curl_exec($ch);
        if (!$response)
            $response = ['type' => 'error', 'code' => 'curl', 'message' => curl_error($ch)];
        curl_close($ch);
        die($response);*/

        /*$phone = '79812276116';
        if (strlen($phone) === 11) {
            $parsePhone = $phone;
            $first = $parsePhone[1] . $parsePhone[2] . $parsePhone[3];
            $rest = $parsePhone[4] .
                $parsePhone[5] .
                $parsePhone[6] .
                $parsePhone[7] .
                $parsePhone[8] .
                $parsePhone[9] .
                $parsePhone[10];
            $first = (int)$first;
            $rest = (int)$rest;
            $finder = DbPhones::find()
                ->where(['AND', ['first' => $first], ['<=', 'second', $rest], ['>=', 'third', $rest]])
                ->asArray()
                ->one();
            die(var_dump($finder));
            if (!empty($finder)) {
                $region = $finder['region'];
                if (mb_strpos($region, '|') !== false) {
                    $parseRegion = explode('|', $region)[1];
                } elseif (mb_strpos($region, 'Московская область') !== false) {
                    $parseRegion = "Московская обл";
                } elseif (mb_strpos($region, 'Москва') !== false) {
                    $parseRegion = "Москва";
                } elseif (mb_strpos($region, 'Ленинградская') !== false) {
                    $parseRegion = "Ленинградская обл";
                } else {
                    $parseRegion = $region;
                }
                die($parseRegion);
                $parseRegion_2 = explode(' ', $parseRegion);
                if (mb_strpos($parseRegion, 'Кемер') !== false)
                    $reg = 'Кемеровская область - Кузбасс';
                elseif (mb_strpos($parseRegion, 'Ханты') !== false)
                    $reg = 'Ханты-Мансийский Автономный округ - Югра';
                elseif (mb_strpos($parseRegion, 'Москва') !== false)
                    $reg = 'Москва';
                else {
                    if ($parseRegion_2[0] === 'Республика') {
                        if ($parseRegion_2[1] === 'Марий') {
                            $reg = "Марий Эл";
                        } elseif ($parseRegion_2[1] === 'Северная') {
                            $reg = "Северная Осетия - Алания";
                        } elseif ($parseRegion_2[1] === 'Саха') {
                            $reg = "Саха /Якутия/";
                        } else {
                            $reg = $parseRegion_2[1];
                        }
                    } else {
                        if ($parseRegion_2[0] === 'Чувашская') {
                            $reg = "Чувашская Республика";
                        } else
                            $reg = $parseRegion_2[0];
                    }
                }
                $dbReg = DbRegion::findOne(['name' => $reg]);
            }
        }*/
        #die($dbReg->name_with_type);
        #die((PhoneRegionHelper::getValidRegion($phone))->name_with_type);


        /*$ch = curl_init();
        $part = "/v1/users";
        $key = "c6129a4b4bd277470efdb33c09417efb27e98f38";
        $id = '2736779';
        //$data = json_encode([["name" => "Client 1"]], JSON_UNESCAPED_UNICODE);
        $signature = ["GET", $part, '', null, $key];
        $signature = hash('sha256', implode(':', $signature));
        curl_setopt_array($ch, [
            CURLOPT_URL => "https://api.megacrm.ru{$part}",
            //CURLOPT_CUSTOMREQUEST => "GET",
            //CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => [
                //"Content-Type: application/json",
                //"Content-Length: " . strlen($data),
                "X-MegaCrm-ApiAccount: {$id}",
                "X-MegaCrm-ApiSignature: {$signature}",
            ],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 10,
        ]);
        $response = curl_exec($ch);
        die($response);*/

        /*$ccleads = CcLeads::find()->where(['status' => 'целевой', 'assigned_to' => 100])->all();
        foreach ($ccleads as $item) {
            if (empty($item->date_outcome)) {
                $item->date_outcome = $item->date_income;
                $item->update();
            }
        }*/
        /*$test = '{"exclude_commentary_params":["ipoteka","zalog"],"cc_leadgain_queue":"да","only_cc_verified":"да","queue":"да","daily_leads_min":1,"lead_per_day_contract":1,"daily_leads_max":1}';
        $p = json_decode($test, 1);
        $comm = "sum: 250000<br>ipoteka: нет<br>zalog: нет<br>Комментарий: <br>Перезвонить: 13.04.2022 15:00<br>Дополнительная информация : г. Саракташ<br>";
        echo $comm . "<br><hr>";
        foreach ($p['exclude_commentary_params'] as $item) {
            $re = '/('.$item.'\:\s?\W*br>)/mi';
            $comm = preg_replace($re, '', $comm);
        }
        die($comm);*/

//        PaymentsResultController::TriggerDeal(100500);
        //M3TelegramBot::respond(BavariaBotMessages::find()/*->where(['status' => 'wait'])*/->orderBy('id desc')->all()[0]);
        /*$aliasMy = BavariaBotPlacesAlias::findOne(10);
        $myPlace = 1;
        $vacantedPlaces = BavariaBotPlaces::findOne(1)->available_count;
        $approxedStart = $aliasMy->time_start + 3600 * 2;
        $bannedPlaces = BavariaBotPlacesAlias::find()
            ->where(['!=', 'id', 10])
            ->andWhere(['place_id' => $myPlace])
            ->andWhere([
                'OR',
                new Expression("{$aliasMy->time_start} BETWEEN `time_start` AND `time_end_approx`"),
                new Expression("{$approxedStart} BETWEEN `time_start` AND `time_end_approx`"),
                new Expression("{$aliasMy->time_end_approx} BETWEEN `time_start` AND `time_end_approx`"),
            ])
            ->all();
        print_r($bannedPlaces);*/

        /*$alias = BavariaBotPlacesAlias::find()->where(['id' => 12])->one();
        $availablePlaces = BavariaBotPlaces::find()->asArray()->all();
        $availablePlaces = ArrayHelper::map($availablePlaces, 'id', 'name');
        $upperTime = date("d.m.Y 23:59:59", $alias->time_start);
        $upperSetTime = date("d.m.Y 22:00:00", $alias->time_start);
        $upperSetTime = strtotime($upperSetTime);
        $upperTime = strtotime($upperTime);
        $allTimes = BavariaBotPlacesAlias::find()
            ->where(['!=', 'id', 12])
            ->andWhere(['OR', ['>=', 'time_start', $alias->time_start], ['<=', 'time_end_approx', $upperTime]])
            ->asArray()
            ->orderBy('time_end_approx desc')
            ->groupBy('place_id')
            ->all();
        $promisedTimes = [];
        $watchedId = [];
        foreach ($allTimes as $item) {
            $watchedId[] = $item['place_id'];
            if ($item['time_end_approx'] >= $upperSetTime)
                continue;
            else {
                $date = date("d.m.Y H:i", $item['time_end_approx']);
                $promisedTimes[] = "{$availablePlaces[$item['place_id']]}, {$date}";
            }
        }
        $getNewPromises = BavariaBotPlaces::find()->where(['not in', 'id', $watchedId])->asArray()->all();
        $newPromises = [];
        if (!empty($getNewPromises))
            $newPromises = ArrayHelper::map($getNewPromises, 'id', 'name');
        foreach ($newPromises as $key => $item) {
            $date = date("d.m.Y H:i", $alias->time_start);
            $promisedTimes[] = "{$item}, {$date}";
        }*/
        /*$b = BavariaBotMessages::find()->orderBy('id desc')->one();
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "https://api.telegram.org/bot5604816911:AAEYXlJuTNhCZqvSjrmwsePsnfmbEKMIgzc/sendMessage");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query([
            'chat_id' => $b->tg_user_id,
            'latitude' => 47.235173,
            'longitude' => 39.714397,
        ]));
        $result2 = curl_exec($curl);
        curl_close($curl);
        die($result2) ;*/
        $fio = $_REQUEST['fio'];
        $phone = $_REQUEST['phone'];
        $email = $_REQUEST['email'];
        $region = $_REQUEST['region'];
        $commentary = "IP: " . $_SERVER['REMOTE_ADDR'] . "<br>";
        // здесь могут быть прочие поля
        // $commentary .= "...<br>";
        $queryString = $_SERVER['QUERY_STRING'];
        if (session_status() !== PHP_SESSION_ACTIVE)
            session_start();
        if (empty($_SESSION['qs'])) {
            $_SESSION['qs'] = $_SERVER['QUERY_STRING'];
            echo "SESSION SET \n";
        }
        parse_str($queryString, $query);
        die($_SESSION['qs']);
        $utm_source = $query['utm_source'] ?? null;
        $utm_campaign = $query['utm_campaign'] ?? null;



        /*ДАННЫЕ*/
        $curloptURL = 'https://api.myforce.ru/bitrix.lead.add';
        $data = [

            'department' => 'seller',

            'name' => $fio ?? 'Без имени', # указываем ФИО всегда, если нет ставим "Без имени"

            'phone' => $phone ?? null, # указываем полученный телефон с формы

            'phone2' => '' ?? null, # указываем второй полученный телефон с формы, если есть

            'phone_messenger' => $phone ?? null, # указываем телефон с мессенджером, если есть

            'email' => $email ?? null, # указываем email, если есть

            'city' => $region, # указываем РЕГИОН обязательно

            'city_real' => $city ?? null, # указываем город, если есть

            'utm_source' => $UTM ?? '', # указываем UTM метку всегда, если нет, то ставим null

            'utm_campaign' => $UTM2 ?? '', # указываем UTM метку всегда, если нет, то ставим null

            'commentary' => $commentary ?? '', # указываем город, сумму и прочие поля, которые берем с формы,
            # также указываем IP пользователя и сайт откуда лид, поле обязательное

            'category' => 104, # числовое значение категории, можно узнать у админа

            'typeOfService' => 1718,

            'stage' => 'C104:NEW', # заполняется следующим образом: пишется АНГЛИЙСКАЯ БУКВА "С" и
            # ставится номер категории, который ты указал в "category" - C104 затем ставится двоеточие и в 99% случаев нужно будет ставить NEW. Иногда, когда тебя попросят, чтобы лид падал на другую стадию - ты должен будешь поменять NEW на то, что тебе скинут

            'source_bitrix' => '102', # источник из Битрикс24

            'source_real' => 'sale.myforce.ru', # сайт или инфа откуда лид пришел

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
        /*$response = curl_exec($curl);

        echo !$response ? "CURL ERROR: " . curl_error($curl) : $response; # здесь ответ сервера
        curl_close($curl);*/
    }

    public function actionXlsBd() {
        $leads = DealsBackdoor::find()
            ->where(['like', 'region', '%мос%', false])
            ->select(['id', 'source', 'name', 'phone', 'region', 'email', 'date', 'log', 'date_start', 'summ'])
            ->asArray()
            ->all();
        $fp = fopen('file.csv', 'w');
        $labels = DealsBackdoor::find()->one()->attributeLabels();
        unset($labels['comments']);
        fputcsv($fp, $labels, '`');
        foreach ($leads as $k => $fields) {
            fputcsv($fp, $fields, '`');
        }
        fclose($fp);
        die();
    }

    /*public function actionTest2() {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if (!empty($_REQUEST['keys']) && !empty($_REQUEST['order'])) {
            $ids = json_decode($_REQUEST['keys'], true);
            $leads = Leads::find()->where(['in', 'id', $ids])->select('phone, id')->asArray()->all();
            $leadArray = ArrayHelper::map($leads, 'id', 'phone');
            $phoneArray = array_flip($leadArray);

            $duplicates = Leads::find()
                ->select('id, phone')
                ->where(['AND', ['in', 'phone', $leadArray], ['OR', ['status' => Leads::STATUS_SENT], ['status' => Leads::STATUS_WASTE], ['status' => Leads::STATUS_CONFIRMED], ['status' => Leads::STATUS_INTERVAL]]])
                ->asArray()
                ->all();
            if (!empty($duplicates)) {
                $catch = [];
                $orderProps = Orders::findOne($_REQUEST['order']);
                $client = $orderProps->client;
                foreach ($duplicates as $item) {
                    $alias = LeadsSentReport::find()
                        ->where(['AND', ['client_id' => $client], ['lead_id' => $item['id']]])
                        ->count();
                    if ((int)$alias > 0) {
                        if (!empty($phoneArray[$item['phone']])) {
                            unset($phoneArray[$item['phone']]);
                            $catch[] = $item['phone'];
                        }
                    }
                }
            }

            sort($phoneArray);
            $functions = new Admin('leads');
            //$result = $functions->massLead(json_encode($phoneArray), $_REQUEST['order']);
            return $catch;
        } else
            return ['status' => 'error', 'message' => 'Пустая выборка.'];
    }*/


    public function actionProviders()
    {
        if (!empty($_GET['id']))
            $query = Providers::find()->where(['id' => $_GET['id']])->orderBy('id desc')->asArray();
        else
            $query = Providers::find()->orderBy('id desc')->asArray();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('providers', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

}
