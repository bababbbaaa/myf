<?php


namespace api\models;


use common\models\BitrixQueue;
use common\models\DbPhones;
use common\models\DbRegion;
use common\models\helpers\PhoneRegionHelper;
use yii\web\HttpException;

class Bitrix24
{

    const
        FEMIDA_BITRIX = "https://femidaforce.bitrix24.ru/rest/22/8hgvhbcr19elk576/";

    public static
        $services = [
        44 => 'B2B Лиды банкротство',
        46 => 'B2B Лиды общий поток',
        48 => 'B2B Воронка продаж',
        50 => 'B2B Реклама для юристов',
        52 => 'B2B Автоматизация',
        54 => 'B2B Франшиза FemidaForce',
        128 => 'B2B Франшиза / Партнерка Чарджбек',
        130 => 'В2В АУ (анкеты)',
        132 => 'В2В Курсы по банкротству',
        134 => 'В2В Курсы по чарджбек',
        136 => 'В2В Иные услуги',
        138 => 'В2С Банкротство и оптимизация Ростов',
        140 => 'В2С Банкротство и оптимизация Россия',
        142 => 'В2С Чарджбек',
        144 => 'Иное',
        362 => 'Лиды БФЛ - регистраиця',
        372 => 'Лиды Чардж - регистрация',
        374 => 'Рекламные услуги',
        376 => 'CRM для бизнеса',
        378 => 'Курсы и обучение',
        380 => 'Арбитражные управляющие',
        382 => 'Публикация в каталоге',
        1314 => 'Лиды на кредитование',
        1324 => 'Услуги контакт центра',
    ],

    $bitrixAllowed = [
        'department' => ['seller', 'lawyer-seller', 'lawyer-pau'],
    ],

    $servicesNew = [
        58 => [ #воронка
            'UF_CRM_1613047575789' => [
                '' => 'не выбрано',
                null => 'не выбрано',
                1712 => 'БФЛ',
                1714 => 'ЧБ',
                1716 => 'Общ',
                1718 => 'Иное',
            ]
        ],
        60 => [ #лиды
            'UF_CRM_1612844872287' => [
                '' => 'не выбрано',
                null => 'не выбрано',
                1334 => 'БФЛ',
                1336 => 'ЧБ',
                1338 => 'Общ',
                1340 => 'КР',
                1342 => 'НЖ',
                1344 => 'Иное',
            ]
        ],
        62 => [ #crm
            'UF_CRM_1613047636013' => [
                '' => 'не выбрано',
                null => 'не выбрано',
                1720 => 'БФЛ',
                1722 => 'ЧБ',
                1724 => 'Общ',
                1726 => 'Иное',
            ]
        ],
        64 => [ #франшиза
            'UF_CRM_1613047860892' => [
                '' => 'не выбрано',
                null => 'не выбрано',
                1728 => 'БФЛ',
                1730 => 'ЧБ',
            ]
        ],
        66 => [ #партнеры
            'UF_CRM_1613048299221' => [
                '' => 'не выбрано',
                null => 'не выбрано',
                1732 => 'Частный практикующий юрист',
                1734 => 'Небольшой региональный офис',
                1736 => 'Крупный офис в регионе',
                1738 => 'Небольшая сеть (2-4 города)',
                1740 => 'Крупная сеть (5-10 городов)',
                1742 => 'Федеральный проект (от 10 и более городов)',
            ]
        ],
        68 => [ #анкета

        ],
    ];

    public static function useApi($method, $data, $url = self::FEMIDA_BITRIX) {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url . $method,
            CURLOPT_POSTFIELDS => http_build_query($data),
        ));
        $response = curl_exec($curl);
        if ($response === false) {
            $r = ['error' => curl_error($curl), 'errorCURL' => 1];
            curl_close($curl);
            return $r;
        } else {
            curl_close($curl);
            return json_decode($response, true);
        }
    }


    public static function validatePost($array){
        if (empty($array['department']))
            throw new HttpException(400, 'Department parameter is required');
        if (!in_array($array['department'], self::$bitrixAllowed['department']))
            throw new HttpException(400, 'Unknown department');
        if (empty($array['phone']))
            throw new HttpException(400, 'Phone is not set or invalid');
        if (!isset($array['utm_campaign']) || !isset($array['utm_source']))
            throw new HttpException(400, 'UTM source or campaign is not set');
        if(!isset($array['name']))
            throw new HttpException(400, 'Deal name is not set');
        if(!isset($array['stage']))
            throw new HttpException(400, 'Deal stage is not set');
        if(!isset($array['category']))
            throw new HttpException(400, 'Deal category is not set');
        if (empty($array['source_bitrix']))
            throw new HttpException(400, 'Bitrix24 SOURCE_ID is not set');
        if (empty($array['source_real']))
            throw new HttpException(400, 'Real source is not set');
        if (!isset($array['city']))
            throw new HttpException(400, 'City is not set');
        if (empty($array['commentary']))
            throw new HttpException(400, 'Commentary is not set');
        if (empty($array['typeOfService']) && $array['category'] !== 68)
            throw new HttpException(400, 'Type of service is not set');
        return true;
    }


    public static function findContactDouble($phone, $category, $source, $utm_source) {
        $batch = [
            'halt' =>  0,
            'cmd' =>  [
                'duplicate' => 'crm.duplicate.findbycomm?TYPE=PHONE&VALUES[0]='.$phone.'&ENTITY_TYPE=CONTACT',
                'contact_data' => 'crm.contact.get?id=$result[duplicate][CONTACT][0]',
                'contact_deals' => 'crm.deal.list?order[id]=desc&filter[CONTACT_ID]=$result[duplicate][CONTACT][0]&filter[UF_CRM_1617109249]=1&filter[CATEGORY_ID]='.$category,
                'deal_data' => 'crm.deal.get?id=$result[contact_deals][0][ID]',
                'comment' => 'crm.timeline.comment.add?' . http_build_query([
                        'fields' => [
                            "ENTITY_ID" => '$result[deal_data][ID]',
                            "ENTITY_TYPE" => "deal",
                            "COMMENT" => 'Повторное обращение от ' . date("d.m.Y H:i:s")
                        ]
                    ]),
                'activity' => 'crm.activity.add?' . http_build_query([
                        'fields' => [
                            "OWNER_TYPE_ID" => 2,
                            "OWNER_ID" => '$result[deal_data][ID]',
                            "TYPE_ID" => 2,
                            "COMMUNICATIONS" => [
                                [
                                    "VALUE" => '$result[contact_data][PHONE][0][VALUE]',
                                    "ENTITY_ID" => '$result[contact_data][ID]',
                                    "ENTITY_TYPE_ID" => 3
                                ]
                            ],
                            "SUBJECT" => "Новое обращение с {$source}. " . (empty($utm_source) ? '' : "Метка: {$utm_source}"),
                            "START_TIME" => (new \DateTime())->modify('-2 hour')->format("Y-m-d H:i:sP"),
                            "END_TIME" => (new \DateTime())->modify('-1 hour')->format("Y-m-d H:i:sP"),
                            "COMPLETED" => "N",
                            "PRIORITY" => 3,
                            "RESPONSIBLE_ID" => '$result[contact_data][ASSIGNED_BY_ID]',
                            "DESCRIPTION" => "Перезвонить по НОВОМУ ОБРАЩЕНИЮ",
                            "DESCRIPTION_TYPE" => 3,
                            "DIRECTION" => 2,
                        ],
                    ]),
                'notice' => 'im.notify?' . http_build_query([
                        'to' => '$result[deal_data][ASSIGNED_BY_ID]',
                        'type' => 'SYSTEM',
                        'message' => 'Лид $result[deal_data][TITLE] оставил повторную заявку'
                    ])
            ]
        ];
        $response = self::useApi('batch', $batch);
        return $response;
    }

    public static function checkStatusBatch($result) {
        $response = ['status' => []];
        if (isset($result['result']['result_error']['deal_data']))
            $response['status'][] = 'deal_error';
        if (isset($result['result']['result_error']['contact_data']))
            $response['status'][] = 'contact_error';
        if (empty($response['status']))
            $response['status'][] = 'success';
        return $response;
    }


    /**
     * @param $queue BitrixQueue
     * @param $category
     * @return int
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public static function getCurrentAssigned($queue, $category) {

        $empl = [
            'denis' => 804,
            'mihail' => 398,
            'alex' => 396,
        ];

        $current_id = $queue->current_id;
        $index = null;
        $percentage = false;
        if($queue->type !== 'seller')
            $bypass = true;
        else {
            if($category == 64) {
                $percentage = true;
                $bypass = true;
            } elseif($category == 74 || $category == 58) {
                if ($category == 74) {
                    $arr = [398, 396];
                    return $arr[mt_rand(0, 1)];
                } else {
                    $chance = mt_rand(1, 100);
                    if ($chance < 40)
                        return 398;
                    else
                        return 396;
                }
            } else
                $bypass = true;
        }
        if ($bypass) {
            if ($percentage) {
                $chance = mt_rand(1, 100);
                if ($chance < 31)
                    return 396;
                else
                    return 398;
            }
            $json = json_decode($queue->department, 1);
            foreach ($json as $key => $item) {
                if ($item == $current_id) {
                    $index = $key;
                    break;
                }
            }
            if (isset($index) && $index !== null) {
                if (isset($json[$index + 1]))
                    $queue->current_id = $json[$index + 1];
                else
                    $queue->current_id = $json[0];
                $queue->update();
            }
        }
        return $current_id;
    }


    public static function parse__region($phone) {
        $phone = preg_replace("/[^0-9]/", '', (string)$phone);
        $dbReg = PhoneRegionHelper::getValidRegion($phone);
        if (!empty($dbReg)) {
            $parseMSK = explode('+', $dbReg->timezone);
            $newMSK = (int)$parseMSK[1] - 3;
            if ($newMSK >= 0)
                $textMSK = "+{$newMSK}";
            else
                $textMSK = "-{$newMSK}";
            return ['region' => $dbReg->name_with_type, 'gmt' => $textMSK];
        } else
            return null;
    }

}