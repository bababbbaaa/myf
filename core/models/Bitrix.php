<?php


namespace core\models;


use common\models\BitrixQueue;

/**
 * Class Bitrix
 * @package core\models
 * @property string $method
 * @property string $department
 * @property array $params
 */
class Bitrix
{

    const DEFAULT_URL = "https://femidaforce.bitrix24.ru/rest/22/8hgvhbcr19elk576/";
    const DEFAULT_SOURCE = 64;

    public $method;
    public $params;
    public $department = 'seller';

    public function process()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => self::DEFAULT_URL . $this->method,
            CURLOPT_POSTFIELDS => http_build_query($this->params),
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

    public function set__params($data)
    {
        $this->params = $data;
        return $this;
    }

    public function set__method($method)
    {
        $this->method = $method;
        return $this;
    }

    public function findContactDouble($phone, $category)
    {
        $batch = [
            'halt' => 0,
            'cmd' => [
                'duplicate' => 'crm.duplicate.findbycomm?TYPE=PHONE&VALUES[0]=' . $phone . '&ENTITY_TYPE=CONTACT',
                'contact_data' => 'crm.contact.get?id=$result[duplicate][CONTACT][0]',
                'contact_deals' => 'crm.deal.list?order[id]=desc&filter[CONTACT_ID]=$result[duplicate][CONTACT][0]&filter[UF_CRM_1617109249]=1&filter[CATEGORY_ID]=' . $category,
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
                            "SUBJECT" => "Звонок",
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
        $response = $this->set__method('batch')->set__params($batch)->process();
        return $response;
    }

    public function checkStatusBatch($result)
    {
        $response = ['status' => []];
        if (isset($result['result']['result_error']['deal_data']))
            $response['status'][] = 'deal_error';
        if (isset($result['result']['result_error']['contact_data']))
            $response['status'][] = 'contact_error';
        if (empty($response['status']))
            $response['status'][] = 'success';
        return $response;
    }

    public function getCurrentAssigned($queue, $category) {
        $current_id = $queue->current_id;
        $index = null;
        $percentage = false;
        if($queue->type !== 'seller')
            $bypass = true;
        else {
            $alex = [58, 60, 62];
            $courses = [396, 398];
            if ($category == 36) {
                return $courses[mt_rand(0, 1)];
            }
            elseif(in_array($category, $alex))
                return 396;
            elseif($category == 64) {
                $percentage = true;
                $bypass = true;
            } else
                $bypass = true;
        }
        if ($bypass) {
            if ($percentage) {
                $chance = mt_rand(1, 100);
                if ($chance < 20)
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


    public function start($input)
    {
        $queue = BitrixQueue::findOne(['type' => $this->department]);
        do {
            $result = $this->findContactDouble($input['phone'], $input['category']);
            $check = $this->checkStatusBatch($result);
            if (in_array('contact_error', $check['status'])) {
                $gmt = $input['gmt'];
                $assigned = $this->getCurrentAssigned($queue, $input['category']);
                $service = null;
                $serviceText = '';
                $contactData = [
                    'fields' => [
                        'NAME' => $input['name'],
                        'OPENED' => "Y",
                        'ASSIGNED_BY_ID' => $assigned,
                        'SOURCE_ID' => self::DEFAULT_SOURCE,
                        'SOURCE_DESCRIPTION' => $input['formType'],
                        "PHONE" => [
                            ['VALUE' => $input['phone'], 'VALUE_TYPE' => 'WORK'],
                        ],
                        "EMAIL" => [['VALUE' => $input['email'], 'VALUE_TYPE' => 'WORK']],
                        'UTM_SOURCE' => $input['utm_source'],
                        'UTM_CAMPAIGN' => $input['utm_campaign'],
                        'COMMENTS' => $input['comments'],
                        'UF_CRM_1637317951' => $input['section'],
                    ],
                    'params' => ['REGISTER_SONET_EVENT' => 'Y']
                ];
                $dealData = [
                    'fields' => [
                        'TITLE' => "{$input['name']} {$gmt} {$serviceText}",
                        'UF_CRM_1612845002560' => $input['name'],
                        'OPENED' => "Y",
                        'CONTACT_ID' => '$result[contact][result]',
                        'ASSIGNED_BY_ID' => $assigned,
                        'SOURCE_ID' => self::DEFAULT_SOURCE,
                        'SOURCE_DESCRIPTION' => $input['formType'],
                        'UTM_SOURCE' => $input['utm_source'],
                        'UTM_CAMPAIGN' => $input['utm_campaign'],
                        'COMMENTS' => $input['comments'] . "<br>" . $input['URL'],
                        'UF_CRM_1594802948504' => $input['phone'],
                        'UF_CRM_5F2D3C2C86613' => $gmt,
                        'CATEGORY_ID' => $input['category'],
                        'UF_CRM_1612845320212' => $input['email'],
                        'UF_CRM_5B45F025B1888' => $input['region'],
                        'UF_CRM_1630602694' => $input['URL'],
                        'UF_CRM_1637317951' => $input['section'],
                    ],
                    'params' => ['REGISTER_SONET_EVENT' => 'Y']
                ];
                $batch = [
                    'halt' => 0,
                    'cmd' => [
                        'contact' => 'crm.contact.add?' . http_build_query($contactData),
                        'deal' => 'crm.deal.add?' . http_build_query($dealData),
                    ]
                ];
                $response = $this->set__method('batch')->set__params($batch)->process();
            } elseif (in_array('deal_error', $check['status'])) {
                $gmt = $input['gmt'];
                $serviceText = '';
                $dealData = [
                    'fields' => [
                        'TITLE' => "{$input['name']} {$gmt} {$serviceText}",
                        'UF_CRM_1612845002560' => $input['name'],
                        'OPENED' => "Y",
                        'ASSIGNED_BY_ID' => $result['result']['result']['contact_data']['ASSIGNED_BY_ID'],
                        'CONTACT_ID' => $result['result']['result']['contact_data']['ID'],
                        'SOURCE_ID' => self::DEFAULT_SOURCE,
                        'SOURCE_DESCRIPTION' => $input['formType'],
                        'UTM_SOURCE' => $input['utm_source'],
                        'UTM_CAMPAIGN' => $input['utm_campaign'],
                        'COMMENTS' => $input['comments'],
                        'UF_CRM_1594802948504' => $input['phone'],
                        'UF_CRM_5F2D3C2C86613' => $gmt,
                        'CATEGORY_ID' => $input['category'],
                        'UF_CRM_1612845320212' => $input['email'],
                        'UF_CRM_5B45F025B1888' => $input['region'],
                        'UF_CRM_1630602694' => $input['URL'],
                        'UF_CRM_1637317951' => $input['section'],
                    ],
                    'params' => ['REGISTER_SONET_EVENT' => 'Y']
                ];
                $batch = [
                    'halt' => 0,
                    'cmd' => [
                        'deal' => 'crm.deal.add?' . http_build_query($dealData),
                    ]
                ];
                $response = $this->set__method('batch')->set__params($batch)->process();
            } else {
                $response = ['error: unknown deal status'];
                break;
            }
        } while (false);
        return $response;
    }

}