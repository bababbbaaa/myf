<?php


namespace api\controllers;

use api\models\Bitrix24;
use Sendpulse\RestApi\ApiClient;
use Sendpulse\RestApi\Storage\FileStorage;
use common\models\BitrixQueue;
use common\models\CcLeads;
use common\models\helpers\TelegramBot;
use common\models\MfBotCounter;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\Response;

class BitrixController extends Controller
{

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function sPulse($addressbookId, $data)
    {

        $clientId = '870468ad97ada8b6336ab6e1b96e33e3';
        $clientSecret = '4af8c1a546ec639acb41c37febf9f1a0';

        $SPApiClient = new ApiClient($clientId, $clientSecret, new FileStorage());

        $emails = [
            [
                'email' => $data['email'],
                'variables' => [
                    'Name' => $data['name'],
                    'Phone' => $data['phone']
                ]
            ]
        ];
        $additionalParams = array(
            'confirmation' => 'force',
            'sender_email' => 'info@myforce.ru',
        );

        return $SPApiClient->addEmails($addressbookId, $emails, $additionalParams);
    }

    public function actionTest()
    {
        $data = [
            'email' => 'oleg123@gmail.com',
            'name' => "tes123t",
            'phone' => '+79188916601'
        ];
        var_dump($this->sPulse('89504448', $data));
        die();
    }

    public function actionLeadAdd()
    {
        if (!empty($_POST)) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            # required: [department] @ string {seller / lawyer-pau / lawyer-seller}
            # required: [phone] @ string any
            # required: [city] @ string any
            # required: [ip] @ string any
            # required: [utm_source & utm_campaign] @ string any
            # required: [name] @ string any
            # required: [category] @ string any
            # required: [commentary] @ string any
            # required: [typeOfService] -> based on [category] @ integer
            # required: [stage] -> based on [category] @ string any
            # required: [source_bitrix] @ string any
            # required: [source_real] @ string any
            # optional: [phone_messenger] @ string any
            # optional: [phone2] @ string any
            # optional: [email] @ string any
            # optional: [city_real] @ string any
            $p = $_POST;
            if (Bitrix24::validatePost($p)) {
                $queue = BitrixQueue::findOne(['type' => $p['department']]);
                $phone = $p['phone'];
                $city = $p['city'];
                $email = $p['email'] ?? null;
                $utm_source = $p['utm_source'];
                $utm_content = $p['utm_content'];
                $utm_medium = $p['utm_medium'];
                $utm_term = $p['utm_term'];
                $utm_campaign = $p['utm_campaign'] ?? $p['utm_web'];
                $name = $p['name'];
                $category = (int)$p['category'];
                $commentary = $p['commentary'];
                $typeOfService = $p['typeOfService'];
                $stage = $p['stage'];
                $source_bitrix = $p['source_bitrix'];
                $source_real = $p['source_real'];
                $ip = $p['ip'];
                $dataArray = [
                    "Телефон" => $phone,
                    "Город/регион" => $city,
                    "Почта" => $email,
                    "utm_source" => $utm_source,
                    "utm_campaign" => $utm_campaign,
                    "utm_medium" => $utm_medium,
                    "utm_term" => $utm_term,
                    "utm_content" => $utm_content,
                    "ФИО" => $name,
                    "Категория Битрикс24" => $category,
                    "Комментарий" => $commentary,
                    "Источник Битрикс24" => $source_bitrix,
                    "Источник текст" => $source_real,
                    "IP" => $ip,
                ];
                $messageForPEER = TelegramBot::makeArrayText($dataArray);
                $bot = new TelegramBot();
                do {
                    if ($source_real === 'business-bfl.ru') {
                        $findPhone = preg_replace('/[^\d]+/', '', $phone);
                        $findPhone1 = $findPhone;
                        $findPhone2 = $findPhone;
                        $findPhone1[0] = 7;
                        $findPhone2[0] = 8;
                        $bc = CcLeads::find()->where(['OR', ['phone' => $findPhone1], ['phone' => $findPhone2]])->andWhere(['category' => 'audit'])->orderBy('id desc')->one();
                        if (!empty($bc)) {
                            $bc->sms_got = 1;
                            $bc->update();
                        }
                    }
                    if (empty($queue) || empty($phone) || empty($category)) {
                        $status = 'error: empty phone || queue || category';
                        break;
                    }
                    $result = Bitrix24::findContactDouble($phone, $category, $source_real, $utm_source);
                    $check = Bitrix24::checkStatusBatch($result);
                    if (in_array('success', $check['status'])) {
                        $status = 'success';
                        $messageForPEER .= "<b>Результат отправки</b>: дубль по контакту и сделкам";
                        break;
                    } else {
                        if (in_array('contact_error', $check['status'])) {
                            $gmtArray = Bitrix24::parse__region($phone);
                            if (!empty($gmtArray)) {
                                $gmt = $gmtArray['gmt'];
                                $commentary .= "<br>Регион по телефону - {$gmtArray['region']}";
                            } else
                                $gmt = "+0";
                            $assigned = Bitrix24::getCurrentAssigned($queue, $category);
                            $service = Bitrix24::$servicesNew[$category];
                            $serviceKey = empty($service) ? null : key($service);
                            if (!empty($serviceKey))
                                $serviceText = $service[$serviceKey][$typeOfService];
                            else
                                $serviceText = '';
                            $contactData = [
                                'fields' => [
                                    'NAME' => $name,
                                    'OPENED' => "Y",
                                    'ASSIGNED_BY_ID' => $assigned,
                                    'SOURCE_ID' => $source_bitrix,
                                    'SOURCE_DESCRIPTION' => $source_real,
                                    "PHONE" => [
                                        ['VALUE' => $phone, 'VALUE_TYPE' => 'WORK'],
                                    ],
                                    "EMAIL" => [['VALUE' => $email, 'VALUE_TYPE' => 'WORK']],
                                    'UTM_SOURCE' => $utm_source,
                                    'UTM_CAMPAIGN' => $utm_campaign,
                                    'UTM_CONTENT' => $utm_content,
                                    'UTM_MEDIUM' => $utm_medium,
                                    'UTM_TERM' => $utm_term,
                                    'UF_CRM_5B3CB3813B0A7' => $city,
                                    'COMMENTS' => $commentary
                                ],
                                'params' => ['REGISTER_SONET_EVENT' => 'Y']
                            ];
                            if (!empty($ip)) {
                                $commentary .= "<br>IP: $ip";
                            }
                            $dealData = [
                                'fields' => [
                                    'TITLE' => "{$name} {$gmt} {$serviceText}",
                                    'UF_CRM_1612845002560' => $name,
                                    'OPENED' => "Y",
                                    'CONTACT_ID' => '$result[contact][result]',
                                    'ASSIGNED_BY_ID' => $assigned,
                                    'SOURCE_ID' => $source_bitrix,
                                    'SOURCE_DESCRIPTION' => $source_real,
                                    'UTM_SOURCE' => $utm_source,
                                    'UTM_CAMPAIGN' => $utm_campaign,
                                    'UTM_CONTENT' => $utm_content,
                                    'UTM_MEDIUM' => $utm_medium,
                                    'UTM_TERM' => $utm_term,
                                    'COMMENTS' => $commentary,
                                    'UF_CRM_1594802948504' => $phone,
                                    'UF_CRM_5B45F025B1888' => $city,
                                    'UF_CRM_5F2D3C2C86613' => $gmt,
                                    'STAGE_ID' => $stage,
                                    'CATEGORY_ID' => $category,
                                    'UF_CRM_1612845320212' => $email
                                ],
                                'params' => ['REGISTER_SONET_EVENT' => 'Y']
                            ];
                            if (!empty($serviceKey))
                                $dealData['fields'][$serviceKey] = $typeOfService;
                            if (!empty($p['phone2'])) {
                                $dealData['fields']['UF_CRM_1612845245649'] = $p['phone2'];
                                $contactData['fields']['PHONE'][] = ['VALUE' => $p['phone2'], 'VALUE_TYPE' => 'WORK'];
                            }
                            if (!empty($p['phone_messenger']))
                                $dealData['fields']['UF_CRM_1612845261637'] = $p['phone_messenger'];
                            $batch = [
                                'halt' => 0,
                                'cmd' => [
                                    'contact' => 'crm.contact.add?' . http_build_query($contactData),
                                    'deal' => 'crm.deal.add?' . http_build_query($dealData),
                                ]
                            ];
                            $response = Bitrix24::useApi('batch', $batch);
                            file_put_contents('bitrix-new.log', json_encode($response) . PHP_EOL, FILE_APPEND);
                            $messageForPEER .= "<b>Результат отправки</b>: создан лид и контакт";
                        } elseif (in_array('deal_error', $check['status'])) {
                            $gmtArray = Bitrix24::parse__region($phone);
                            if (!empty($gmtArray)) {
                                $gmt = $gmtArray['gmt'];
                                $commentary .= "<br>Регион по телефону - {$gmtArray['region']}";
                            } else
                                $gmt = "+0";
                            $service = Bitrix24::$servicesNew[$category];
                            $serviceKey = empty($service) ? null : key($service);
                            if (!empty($serviceKey))
                                $serviceText = $service[$serviceKey][$typeOfService];
                            else
                                $serviceText = '';
                            if (!empty($ip)) {
                                $commentary .= "<br>IP: $ip";
                            }
                            $dealData = [
                                'fields' => [
                                    'TITLE' => "{$name} {$gmt} {$serviceText}",
                                    'UF_CRM_1612845002560' => $name,
                                    'OPENED' => "Y",
                                    'ASSIGNED_BY_ID' => $result['result']['result']['contact_data']['ASSIGNED_BY_ID'],
                                    'CONTACT_ID' => $result['result']['result']['contact_data']['ID'],
                                    'SOURCE_ID' => $source_bitrix,
                                    'SOURCE_DESCRIPTION' => $source_real,
                                    'UTM_SOURCE' => $utm_source,
                                    'UTM_CAMPAIGN' => $utm_campaign,
                                    'UTM_CONTENT' => $utm_content,
                                    'UTM_MEDIUM' => $utm_medium,
                                    'UTM_TERM' => $utm_term,
                                    'COMMENTS' => $commentary,
                                    'UF_CRM_1594802948504' => $phone,
                                    'UF_CRM_5B45F025B1888' => $city,
                                    'UF_CRM_5F2D3C2C86613' => $gmt,
                                    'STAGE_ID' => $stage,
                                    'CATEGORY_ID' => $category,
                                    'UF_CRM_1612845320212' => $email,
                                ],
                                'params' => ['REGISTER_SONET_EVENT' => 'Y']
                            ];
                            if (!empty($serviceKey))
                                $dealData['fields'][$serviceKey] = $typeOfService;
                            if (!empty($p['phone2']))
                                $dealData['fields']['UF_CRM_1612845245649'] = $p['phone2'];
                            if (!empty($p['phone_messenger']))
                                $dealData['fields']['UF_CRM_1612845261637'] = $p['phone_messenger'];
                            $batch = [
                                'halt' => 0,
                                'cmd' => [
                                    'deal' => 'crm.deal.add?' . http_build_query($dealData),
                                ]
                            ];
                            $response = Bitrix24::useApi('batch', $batch);
                            file_put_contents('bitrix-new.log', json_encode($response) . PHP_EOL, FILE_APPEND);
                            $messageForPEER .= "<b>Результат отправки</b>: дубль по контакту, создан лид";
                        } else {
                            $status = 'error: unknown deal status';
                            break;
                        }
                    }
                    $status = 'success';
                    break;
                } while (false);
                $bot->new__message($messageForPEER, TelegramBot::PEER_DOUBLES);
                return ['status' => $status];
            }
        } else
            throw new HttpException('400');
        return null;
    }

    public function actionTelegramNotification($text, $peer_id, $entity_id = null)
    {
        #text = то что нужно написать
        #$entity_id = id сущности
        #$peer_id = id диалога телеги
        #2069550101:AAHGKA21mmZ_B0hashddG7IX17r16CaxX6M
        #-1001395429688

        if (empty($text) || empty($peer_id))
            return null;
        $bot = new TelegramBot();
        $bot->new__message($text, $peer_id);
    }

    public function actionTgCounter($type)
    {
        $counter = MfBotCounter::find()
            ->where(['AND', ['>=', 'date', date('Y-m-d 00:00:00')], ['<=', 'date', date('Y-m-d 23:59:59')]])
            ->one();
        if (empty($counter)) {
            $counter = new MfBotCounter();
            $counter->count_anketa = 0;
            $counter->count_won = 0;
        }
        if ($type === 'won')
            $counter->count_won++;
        else
            $counter->count_anketa++;
        $counter->save();
        die();
    }

    public function actionChangeStageDeal($id)
    {
        $batch = [
            'halt' => 0,
            'cmd' => [
                'update' => "crm.deal.update?id={$id}&fields[STAGE_ID]=C104:PREPAYMENT_INVOI"
            ],
        ];
        Bitrix24::useApi('batch', $batch);
    }

    public function actionCallTracker() {
        file_put_contents('request.log', json_encode($_REQUEST, JSON_UNESCAPED_UNICODE) . PHP_EOL, FILE_APPEND);
    }

}
