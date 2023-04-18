<?php


namespace api\models;


use admin\models\Admin;
use admin\models\BasesContacts;
use admin\models\BasesConversion;
use admin\models\BasesUtm;
use common\models\CcLeads;
use common\models\DbPhones;
use common\models\DbRegion;
use common\models\helpers\PhoneRegionHelper;
use common\models\LeadsCategory;
use common\models\LeadsRead;
use common\models\LogProcessor;
use common\models\Orders;
use common\models\Worker;

/**
 * Class LeadCall
 * @package api\models
 * @property Orders $order
 * @property integer $order_id
 * @property array $data
 * @property array $ivr
 * @property string $type
 * @property string $utm
 * @property boolean $cc
 * @property LeadsRead $lead
 */
class LeadCall extends Common
{

    public $order_id;
    public $order;
    public $lead;
    public $data;
    public $type;
    public $ivr;
    public $cc;

    public function __construct($type, $order_id = null, $ivr = null, $utm = null)
    {
        $this->order_id = $order_id;
        $this->type = $type;
        $this->ivr = $ivr;
        $this->utm = $utm;
    }

    public function set__order()
    {
        if (!empty($this->order_id)) {
            $this->order = Orders::findOne($this->order_id);
            return !empty($this->order);
        } else
            return false;
    }

    public function get__data()
    {
        $json = file_get_contents('php://input');
        $this->data = json_decode($json, 1);
        return $this;
    }

    public function parse__region()
    {
        $dbReg = PhoneRegionHelper::getValidRegion($this->data['call']['phone']);
        if (!empty($dbReg)) {
            return $dbReg->name_with_type;
        } else
            return null;
    }

    public function check__ivr()
    {
        return !empty($this->data['call']['answer']);
    }

    public function check__type()
    {
        return !empty(LeadsCategory::findOne(['link_name' => $this->type]));
    }

    public function set__lead()
    {
        if (!empty($this->data['call']['phone'])) {
            $this->lead = new LeadsRead();
            $this->lead->type = $this->type;
            $this->lead->source = !empty($this->order_id) ? "Обзвон #{$this->order_id}" : "Обзвон (очередь)";
            $this->lead->ip = "127.0.0.1";
            $this->lead->date_income = date("Y-m-d H:i:s");
            $this->lead->phone = preg_replace("/[^0-9]/", '', (string)$this->data['call']['phone']);
            $this->lead->region = $this->parse__region();
            $this->lead->city = null;
            $this->lead->utm_source = $this->utm ?? null;
            $this->lead->autocall_check = 1;
            if ($this->lead->validate()) {
                if ($this->lead->save())
                    return true;
                else
                    return $this->create__response(500, 'error', $this->lead->errors);
            } else
                return $this->create__response(400, 'error', $this->lead->errors);
        } else
            return $this->create__response(400, 'error', 'Телефон не найден');
    }

    public function sent__lead()
    {
        if (!empty($this->lead->id)) {
            $sender = new Admin('leads');
            $response = $sender->massLead(json_encode([$this->lead->id]), $this->order->id);
            if (!empty($response['status'])) {
                $response['type'] = 'Autocalls';
                $log = new LogProcessor();
                $log->data = json_encode($response, JSON_UNESCAPED_UNICODE);
                $log->lead_id = $this->lead->id;
                $log->entity = "order_{$this->order->id}";
                $log->status = $response['status'] === Worker::LOG_STATUS_SUCCESS ? Worker::LOG_STATUS_SUCCESS : Worker::LOG_STATUS_ERROR;
                return $log->save();
            }
            return false;
        } else
            return false;
    }

    public function save__cc__lead()
    {
        $cc = new CcLeads();
        if (in_array($this->data['call']['phone'], LeadInput::$blockList))
            return true;
        $cc->source = "Обзвон";
        $cc->utm_source = $this->utm;
        if (!empty($cc->utm_source)) {
            $utms = BasesUtm::find()->where(['name' => $cc->utm_source])->count();
            if ($utms > 0) {
                $pregPhone = preg_replace("/[^0-9]/", '', (string)$this->data['call']['phone']);
                $ph1 = $pregPhone;
                $ph2 = $pregPhone;
                $ph1[0] = 7;
                $ph2[0] = 8;
                $contacts = BasesContacts::find()
                    ->where(['OR', ['phone' => $ph1], ['phone' => $ph2]])
                    ->asArray()
                    ->select(['id'])
                    ->all();
                if (!empty($contacts)) {
                    $carr = [];
                    foreach ($contacts as $item)
                        $carr[] = $item['id'];
                    if (!empty($carr)) {
                        $baseUtms = BasesUtm::find()->where(['AND', ['in', 'contact_id', $carr], ['name' => $cc->utm_source]])->all();
                        if (!empty($baseUtms)) {
                            foreach ($baseUtms as $item) {
                                $item->is_1 = 1;
                                $item->update();
                            }
                            $conversion = new BasesConversion();
                            $conversion->name = $cc->utm_source;
                            $conversion->type = "is_1";
                            $conversion->save();
                        }
                    }
                }
            }
        }
        $cc->date_income = date("Y-m-d H:i:s");
        $cc->phone = $this->data['call']['phone'];
        $cc->region = $this->parse__region();
        $cc->city = null;
        $cc->category = $this->type;
        return $cc->save();
    }

    public function useApi($method, $data)
    {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            [
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_POST => true,
                CURLOPT_HEADER => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_URL => \Yii::$app->params['bitrixUrl'] . $method,
                CURLOPT_POSTFIELDS => http_build_query($data),
            ]
        );
        $result = curl_exec($curl);
        curl_close($curl);
        return json_decode($result, 1);
    }

    public function find__doubles()
    {
        $batch = [
            'halt' => 0,
            'cmd' => [
                'duplicate' => 'crm.duplicate.findbycomm?TYPE=PHONE&VALUES[0]=' . $this->data['call']['phone'] . '&ENTITY_TYPE=CONTACT',
                'contact_data' => 'crm.contact.get?id=$result[duplicate][CONTACT][0]',
            ]
        ];
        $contactDeals = 'crm.deal.list?order[id]=desc&filter[CONTACT_ID]=$result[duplicate][CONTACT][0]&filter[UF_CRM_1617109249]=1';
        if (!empty($this->ivr[$this->data['call']['answer']]['CATEGORY_ID']))
            $contactDeals .= '&filter[CATEGORY_ID]=' . $this->ivr[$this->data['call']['answer']]['CATEGORY_ID'];
        if (!empty($this->ivr[$this->data['call']['answer']]['SOURCE_ID']))
            $contactDeals .= '&filter[SOURCE_ID]=' . $this->ivr[$this->data['call']['answer']]['SOURCE_ID'];
        $batch['cmd']['contact_deals'] = $contactDeals;
        $batch['cmd']['deal_data'] = 'crm.deal.get?id=$result[contact_deals][0][ID]';
        $batch['cmd']['comment'] = 'crm.timeline.comment.add?' . http_build_query([
                'fields' => [
                    "ENTITY_ID" => '$result[deal_data][ID]',
                    "ENTITY_TYPE" => "deal",
                    "COMMENT" => 'Повторное обращение от ' . date("d.m.Y H:i:s")
                ]
            ]);
        $batch['cmd']['activity'] = 'crm.activity.add?' . http_build_query([
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
            ]);
        $batch['cmd']['notice'] = 'im.notify?' . http_build_query([
                'to' => '$result[deal_data][ASSIGNED_BY_ID]',
                'type' => 'SYSTEM',
                'message' => 'Лид $result[deal_data][TITLE] оставил повторную заявку'
            ]);
        return $this->useApi('batch', $batch);
    }

    public function check__status__batch($result)
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

    public function do__bitrix__work($check, $result)
    {
        $currentData = $this->ivr[$this->data['call']['answer']];
        do {
            if (in_array('success', $check['status'])) {
                $response = ['success'];
                break;
            } else {
                if (in_array('contact_error', $check['status'])) {
                    $assigned = !empty($currentData['ASSIGNED_BY_ID']) ? $currentData['ASSIGNED_BY_ID'] : 16;
                    $contactData = [
                        'fields' => [
                            'NAME' => $this->data['call']['phone'],
                            'OPENED' => "Y",
                            'ASSIGNED_BY_ID' => $assigned,
                            'SOURCE_ID' => !empty($currentData['SOURCE_ID']) ? $currentData['SOURCE_ID'] : "CALLBACK",
                            'SOURCE_DESCRIPTION' => "Контакт с обзвона " . date("d.m.Y H:i"),
                            "PHONE" => [
                                ['VALUE' => $this->data['call']['phone'], 'VALUE_TYPE' => 'WORK'],
                            ],
                            'UTM_SOURCE' => $this->utm,
                            'COMMENTS' => !empty($currentData['COMMENTS']) ? $currentData['COMMENTS'] : null
                        ],
                        'params' => ['REGISTER_SONET_EVENT' => 'Y']
                    ];
                    $dealData = [
                        'fields' => [
                            'TITLE' => $this->data['call']['phone'],
                            'UF_CRM_1612845002560' => $this->data['call']['phone'],
                            'OPENED' => "Y",
                            'CONTACT_ID' => '$result[contact][result]',
                            'ASSIGNED_BY_ID' => $assigned,
                            'SOURCE_ID' => !empty($currentData['SOURCE_ID']) ? $currentData['SOURCE_ID'] : "CALLBACK",
                            'SOURCE_DESCRIPTION' => "Контакт с обзвона " . date("d.m.Y H:i"),
                            'UTM_SOURCE' => $this->utm,
                            'COMMENTS' => !empty($currentData['COMMENTS']) ? $currentData['COMMENTS'] : null,
                            'UF_CRM_1594802948504' => $this->data['call']['phone'],
                            'CATEGORY_ID' => !empty($currentData['CATEGORY_ID']) ? $currentData['CATEGORY_ID'] : null,
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
                    $response = self::useApi('batch', $batch);
                } elseif (in_array('deal_error', $check['status'])) {
                    $dealData = [
                        'fields' => [
                            'TITLE' => $this->data['call']['phone'],
                            'UF_CRM_1612845002560' => $this->data['call']['phone'],
                            'OPENED' => "Y",
                            'CONTACT_ID' => $result['result']['result']['contact_data']['ID'],
                            'ASSIGNED_BY_ID' => $result['result']['result']['contact_data']['ASSIGNED_BY_ID'],
                            'SOURCE_ID' => !empty($currentData['SOURCE_ID']) ? $currentData['SOURCE_ID'] : "CALLBACK",
                            'SOURCE_DESCRIPTION' => "Контакт с обзвона " . date("d.m.Y H:i"),
                            'UTM_SOURCE' => $this->utm,
                            'COMMENTS' => !empty($currentData['COMMENTS']) ? $currentData['COMMENTS'] : null,
                            'UF_CRM_1594802948504' => $this->data['call']['phone'],
                            'CATEGORY_ID' => !empty($currentData['CATEGORY_ID']) ? $currentData['CATEGORY_ID'] : null,
                        ],
                        'params' => ['REGISTER_SONET_EVENT' => 'Y']
                    ];
                    $batch = [
                        'halt' => 0,
                        'cmd' => [
                            'deal' => 'crm.deal.add?' . http_build_query($dealData),
                        ]
                    ];
                    $response = self::useApi('batch', $batch);
                } else {
                    $response = ['error'];
                    break;
                }
            }
        } while (false);
        return $response;
    }


}