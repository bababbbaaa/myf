<?php

namespace common\models;

use core\models\Bitrix;
use Yii;

/**
 * This is the model class for table "leads_sent_report".
 *
 * @property int $id ID
 * @property string $report_type Тип отчета
 * @property int|null $order_id ID заказа
 * @property int $client_id ID клиента
 * @property int $lead_id ID лида
 * @property int $offer_id ID оффера
 * @property int $provider_id ID провайдера
 * @property string $date Дата создания
 * @property string $status Статус
 * @property int $status_confirmed Статус подтвержден
 * @property string|null $status_commentary Комментарий
 * @property string|null $log Лог отправки
 *
 * @property Clients $client
 * @property Orders $order
 * @property Leads $lead
 */
class LeadsSentReport extends \yii\db\ActiveRecord
{

    const REASON_WRONG_PHONE = 'Битый номер';
    const REASON_WRONG_REGION = 'Не тот регион';
    const REASON_DUPLICATE = 'Дубль';
    const REASON_NOT_LEAD = 'Нет проблемы';

    public $filters;

    public $summ;
    public $date_lead;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads_sent_report';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['report_type', 'log'], 'string'],
            [['order_id', 'client_id', 'lead_id', 'offer_id', 'provider_id', 'status_confirmed', 'summ'], 'integer'],
            [['client_id', 'lead_id', 'status'], 'required'],
            [['date', 'date_lead'], 'safe'],
            [['status', 'status_commentary'], 'string', 'max' => 255],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['order_id'], 'exist', 'skipOnError' => true, 'targetClass' => Orders::className(), 'targetAttribute' => ['order_id' => 'id']],
            [['lead_id'], 'exist', 'skipOnError' => true, 'targetClass' => Leads::className(), 'targetAttribute' => ['lead_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'report_type' => 'Тип отчета',
            'order_id' => 'ID заказа',
            'client_id' => 'ID клиента',
            'offer_id' => 'ID оффера',
            'provider_id' => 'ID провайдера',
            'lead_id' => 'ID лида',
            'date' => 'Дата создания',
            'status' => 'Статус',
            'status_confirmed' => 'Статус подтвержден',
            'status_commentary' => 'Комментарий',
            'log' => 'Лог отправки',
        ];
    }


    public function afterSave($insert, $changedAttributes)
    {
        if (!empty($this->lead)) {
            $new = json_decode($this->log, 1);
            $newText = ['date' => date("d.m.Y H:i:s"), 'text' => $new[array_key_last($new)]['text']];
            $old = $this->lead->system_data;
            $old[] = $newText;
            $this->lead->system_data = $old;
            $this->lead->status = $this->status;
            $this->lead->update();
        }
        if (!$insert) {
            $order = Orders::findOne($this->order_id);
            $bitrix = new Bitrix();
            if ($order->leads_get >= 0) {
                $percent = (int)(($order->leads_get * 100) / $order->leads_count);
                $flags = json_decode($order->bitrix_config, 1);
                if ($percent == 100) {
                    $batch = [
                        'halt' => 0,
                        'cmd' => [
                            'item' => "crm.item.list?entityTypeId=172&filter[ufCrm1612930706779]={$order->id}",
                            'items' => "crm.item.list?entityTypeId=130&filter[ufCrm12_1666617070048]={$order->id}",
                            'item_s' => "crm.item.list?entityTypeId=136&filter[ufCrm1612930706779]={$order->id}",
                            'update' => 'crm.item.update?entityTypeId=172&id=$result[item][items][0][id]&' . http_build_query([
                                'fields' => [
                                    'STAGE_ID' => 'DT172_8:5',
                                    'ufCrm6_1666610637436' => date("Y-m-d H:i:sP")
                                ]
                            ]),
                            'updates' => 'crm.item.update?entityTypeId=130&id=$result[items][items][0][id]&' . http_build_query([
                                'fields' => [
                                    'STAGE_ID' => 'DT130_14:CLIENT'
                                ]
                            ]),
                            'update_s' => 'crm.item.update?entityTypeId=136&id=$result[item_s][items][0][id]&' . http_build_query([
                                'fields' => [
                                    'ufCrm8_1666617197128' => date("Y-m-d H:i:sP"),
                                ]
                            ]),
                        ],
                    ];
                    $bitrix->set__method('batch')->set__params($batch)->process();
                } elseif ($percent > 75) {
                    if ($flags[75] == 0) {
                        $flags[75] = 1;
                        $order->bitrix_config = json_encode($flags, JSON_UNESCAPED_UNICODE);
                        $order->update();
                        $batch = [
                            'halt' => 0,
                            'cmd' => [
                                'item' => "crm.item.list?entityTypeId=172&filter[ufCrm1612930706779]={$order->id}",
                                'items' => "crm.item.list?entityTypeId=130&filter[ufCrm12_1666617070048]={$order->id}",
                                'item_s' => "crm.item.list?entityTypeId=136&filter[ufCrm1612930706779]={$order->id}",
                                'update' => 'crm.item.update?entityTypeId=172&id=$result[item][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'STAGE_ID' => 'DT172_8:4',
                                        'ufCrm6_1666610631836' => date("Y-m-d H:i:sP"),
                                    ]
                                ]),
                                'updates' => 'crm.item.update?entityTypeId=130&id=$result[items][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'STAGE_ID' => 'DT130_14:PREPARATION'
                                    ]
                                ]),
                                'update_s' => 'crm.item.update?entityTypeId=136&id=$result[item_s][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'ufCrm8_1666617191888' => date("Y-m-d H:i:sP"),
                                    ]
                                ]),

                            ],
                        ];
                        $bitrix->set__method('batch')->set__params($batch)->process();
                    }
                } elseif ($percent > 50) {
                    if ($flags[50] == 0) {
                        $flags[50] = 1;
                        $order->bitrix_config = json_encode($flags, JSON_UNESCAPED_UNICODE);
                        $order->update();
                        $batch = [
                            'halt' => 0,
                            'cmd' => [
                                'item' => "crm.item.list?entityTypeId=172&filter[ufCrm1612930706779]={$order->id}",
                                'item_s' => "crm.item.list?entityTypeId=136&filter[ufCrm1612930706779]={$order->id}",
                                'update' => 'crm.item.update?entityTypeId=172&id=$result[item][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'STAGE_ID' => 'DT172_8:3',
                                        'ufCrm6_1666610623986' => date("Y-m-d H:i:sP"),
                                    ]
                                ]),
                                'updates' => 'crm.item.update?entityTypeId=136&id=$result[item_s][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'ufCrm8_1666617187575' => date("Y-m-d H:i:sP"),
                                    ]
                                ]),
                            ],
                        ];
                        $bitrix->set__method('batch')->set__params($batch)->process();
                    }
                } elseif ($percent > 25) {
                    if ($flags[25] == 0) {
                        $flags[25] = 1;
                        $order->bitrix_config = json_encode($flags, JSON_UNESCAPED_UNICODE);
                        $order->update();
                        $batch = [
                            'halt' => 0,
                            'cmd' => [
                                'item' => "crm.item.list?entityTypeId=172&filter[ufCrm1612930706779]={$order->id}",
                                'item_s' => "crm.item.list?entityTypeId=136&filter[ufCrm1612930706779]={$order->id}",
                                'update' => 'crm.item.update?entityTypeId=172&id=$result[item][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'STAGE_ID' => 'DT172_8:2',
                                        'ufCrm6_1666610616306' => date("Y-m-d H:i:sP"),
                                    ]
                                ]),
                                'updates' => 'crm.item.update?entityTypeId=136&id=$result[item_s][items][0][id]&' . http_build_query([
                                    'fields' => [
                                        'ufCrm8_1666617180583' => date("Y-m-d H:i:sP"),
                                    ]
                                ]),
                            ],
                        ];
                        $bitrix->set__method('batch')->set__params($batch)->process();
                    }
                }
            }
        }
        return parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Order]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Orders::className(), ['id' => 'order_id']);
    }

    /**
     * Gets query for [[Lead]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLead()
    {
        return $this->hasOne(Leads::className(), ['id' => 'lead_id']);
    }

    public function getFilteredLeads()
    {
        return $this->hasOne(Leads::className(), ['id' => 'lead_id'])->where($this->filters);
    }
}
