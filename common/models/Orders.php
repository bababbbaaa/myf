<?php

namespace common\models;

use admin\models\StatisticsDaily;
use api\models\Bitrix24;
use common\models\helpers\Mailer;
use common\models\helpers\TelegramBot;
use core\models\Bitrix;
use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property int $id ID
 * @property string $order_name Название заказа
 * @property int $client Клиент
 * @property int|null $package_id id пакета
 * @property int|null $attached_seller прикрепленный продаван
 * @property string $category_link Категория
 * @property string $category_text Название категории
 * @property string $status Статус заказа
 * @property float $price Цена за лид
 * @property int $leads_count Количество лидов
 * @property int $leads_get Лидов получено
 * @property string $regions Регионы
 * @property string $emails Почты для отправки лидов
 * @property string|null $params_category Параметры категории
 * @property string $date Дата создания
 * @property string|null $date_end Дата окончания
 * @property string|null $commentary Комментарий к заказу
 * @property string $params_special Специальные параметры
 * @property int $leads_waste Бракованных лидов
 * @property int $sale Скидка, %
 * @property int $high_priority_order Первоочередной заказ
 * @property int $waste Максимальный брак, %
 * @property int $archive Архивный заказ
 * @property int $last_lead_get Последний раз получал лида
 * @property string $bitrix_config Параметры битрикса
 * @property string $mailer_config Параметры Mailer
 *
 * @property LeadsSentReport[] $leadsSentReports
 * @property Clients $client0
 * @property LeadsCategory $categoryLink
 * @property LeadsSentReport $kpi
 * @property StatisticsDaily $kpiV2
 */
class Orders extends \yii\db\ActiveRecord
{

    const STATUS_MODERATION = "модерация";
    const STATUS_PROCESSING = "исполняется";
    const STATUS_PAUSE = "пауза";
    const STATUS_STOPPED = "остановлен";
    const STATUS_FINISHED = "выполнен";

    public static function allowedStatuses()
    {
        return ['модерация' => 'модерация', 'исполняется' => 'исполняется', 'пауза' => 'пауза', 'остановлен' => 'остановлен', 'выполнен' => 'выполнен'];
    }

    public static $dayStart;
    public static $dayEnd;
    public static $daysArray;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'orders';
    }


    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $client = Clients::findOne($this->client);
            if (!empty($client)) {
                $notice = new UsersNotice();
                $notice->type = $notice::TYPE_MAINPAGE_MODERATION;
                $notice->text = "Создан новый заказ в категории \"{$this->category_text}\". В данный момент он находится на модерации и будет передан в исполнение после одобрения модератором.";
                $notice->user_id = $client->user_id;
                $notice->active = 1;
                $notice->save();
                $batch = [
                    'halt' => 0,
                    'cmd' => [
                        'deal' => "crm.deal.list?filter[UF_CRM_1612930698601]={$client->user_id}&filter[CATEGORY_ID]=104",
                        'update' => 'crm.deal.update?id=$result[deal][0][ID]&fields[UF_CRM_1612930706779]='.$this->id,
                    ],
                ];
                Bitrix24::useApi('batch', $batch);
                if (!empty($client->user_id)) {
                    $tg = new TelegramBot();
                    $tg->new__message($tg::order__message($this->id, $client->user_id), $tg::PEER_OPERATIONS);
                }
                $jq = JobsQueue::find()
                    ->where(['user_id' => $client->user_id, 'method' => 'execute__mailer'])
                    ->andWhere(['like', 'params', "%\"3_orders\"%", false])
                    ->andWhere(['>=', 'date_start', date("Y-m-d H:i:s")])
                    ->all();
                if (!empty($jq)) {
                    foreach ($jq as $item)
                        $item->delete();
                }
            }
        } else {
            $client = Clients::findOne($this->client);
            if (
                isset($changedAttributes['status'])
                && $changedAttributes['status'] === $this::STATUS_MODERATION
                && $changedAttributes['status'] !== $this->status
            ) {
                if (!empty($client)) {
                    $props = UsersProperties::findOne(['user_id' => $client->user_id]);
                    if (!empty($props)) {
                        $params = json_decode($props->params, true);
                        if ($params !== null && $params['push_status'] == 1) {
                            $notice = new UsersNotice();
                            $notice->type = $notice::TYPE_MAINPAGE_MODERATION_SUCCESS;
                            $notice->text = "Заказ в категории \"{$this->category_text}\" одобрен.";
                            $notice->properties = json_encode(['order_id' => $this->id], JSON_UNESCAPED_UNICODE);
                            $notice->user_id = $client->user_id;
                            $notice->active = 1;
                            $notice->save();
                        }
                    }
                    /*if (!empty($client->email)) {
                        $queue = new JobsQueue();
                        $queue->method = "execute__mailer";
                        $queue->params = json_encode(["to" => $client->email, 'html' => '21_orders', 'title' => Mailer::TITLES['21_orders']], JSON_UNESCAPED_UNICODE);
                        $queue->date_start = date("Y-m-d H:i:s");
                        $queue->status = 'wait';
                        $queue->user_id = $client->user_id;
                        $queue->closed = 0;
                        $queue->save();
                    }*/
                }
            }
            $jobs = new JobsQueue();
            $jobs->params = json_encode(['id' => $this->id], JSON_UNESCAPED_UNICODE);
            $jobs->method = 'send__bitrix__info';
            $jobs->date_start = date("Y-m-d H:i:s");
            $jobs->status = 'wait';
            $jobs->user_id = 1;
            $jobs->closed = 0;
            $jobs->save();
        }
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_link', 'category_text', 'status'], 'required'],
            [['client', 'package_id', 'leads_count', 'leads_get', 'leads_waste', 'sale', 'waste', 'archive', 'last_lead_get', 'high_priority_order', 'attached_seller'], 'integer'],
            [['price'], 'number'],
            [['leads_count'], 'default', 'value' => 100],
            [['high_priority_order'], 'default', 'value' => 0],
            [['regions'], 'default', 'value' => '["Любой"]'],
            [['sale'], 'default', 'value' => 0],
            [['regions', 'params_category', 'commentary', 'params_special', 'bitrix_config', 'mailer_config', 'emails'], 'string'],
            [['date', 'date_end'], 'safe'],
            [['category_link', 'category_text', 'status', 'order_name'], 'string', 'max' => 255],
            //[['client'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client' => 'id']],
            //[['category_link'], 'exist', 'skipOnError' => true, 'targetClass' => LeadsCategory::className(), 'targetAttribute' => ['category_link' => 'link_name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_name' => 'Название заказа',
            'client' => 'Клиент',
            'package_id' => 'Пакет франшизы',
            'category_link' => 'Категория',
            'category_text' => 'Название категории',
            'status' => 'Статус заказа',
            'price' => 'Цена за лид',
            'leads_count' => 'Количество лидов',
            'leads_get' => 'Лидов получено',
            'regions' => 'Регионы',
            'emails' => 'Почты для отправки лидов',
            'params_category' => 'Параметры категории',
            'date' => 'Дата создания',
            'date_end' => 'Дата окончания',
            'commentary' => 'Комментарий к заказу',
            'params_special' => 'Специальные параметры',
            'high_priority_order' => 'Первоочередной заказ',
            'leads_waste' => 'Бракованных лидов',
            'sale' => 'Скидка, %',
            'waste' => 'Максимальный брак, %',
            'archive' => 'Архивный заказ',
            'last_lead_get' => 'Последний раз получал лида',
            'attached_seller' => 'Прикрепленный менеджер отдела продаж',
        ];
    }

    /**
     * Gets query for [[LeadsSentReports]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeadsSentReports()
    {
        return $this->hasMany(LeadsSentReport::className(), ['order_id' => 'id']);
    }

    public function getKpi()
    {
        return $this
            ->hasMany(LeadsSentReport::className(), ['order_id' => 'id'])
            ->where(['AND', ['>=', 'leads_sent_report.date', static::$dayStart], ['<=', 'leads_sent_report.date', static::$dayEnd]])
            ->andWhere(['leads_sent_report.report_type' => 'order'])
            ->select('order_id, id, date');
    }

    public function getKpiV2()
    {
        return $this->hasMany(StatisticsDaily::className(), ['order_id' => 'id'])
            ->where(['in', 'date', static::$daysArray]);
    }

    public function getBadLeads()
    {
        return $this->hasMany(LeadsSentReport::className(), ['order_id' => 'id'])->where(['AND', ['leads_sent_report.status' => 'брак'], ['leads_sent_report.status_confirmed' => 1]]);
    }

    public function getBadLeadsCount()
    {
        return $this->hasMany(LeadsSentReport::className(), ['order_id' => 'id'])->where(['AND', ['leads_sent_report.status' => 'брак'], ['leads_sent_report.status_confirmed' => 1]])->count();
    }

    public function getDailyLeads()
    {
        return $this->hasMany(LeadsSentReport::class, ['order_id' => 'id'])->where(['AND', ['>=', 'leads_sent_report.date', date('Y-m-d 00:00:00')], ['<=', 'leads_sent_report.date', date('Y-m-d 23:59:59')]])->count();
    }

    /**
     * Gets query for [[Client0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient0()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client']);
    }

    /**
     * Gets query for [[CategoryLink]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryLink()
    {
        return $this->hasOne(LeadsCategory::className(), ['link_name' => 'category_link']);
    }

    public function colorGetter()
    {
        if ($this->status === 'исполняется')
            return '#bffcc7';
        elseif ($this->status === 'пауза')
            return '#f7ffc3';
        elseif ($this->status === 'модерация')
            return '#b0efff';
        elseif ($this->status === 'остановлен')
            return '#ffb9b9';
        else
            return '#e4e4e4';
    }
}
