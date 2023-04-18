<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "offers".
 *
 * @property int $id ID
 * @property string $name Название оффера
 * @property string $category Категория лидов
 * @property string $regions Регионы
 * @property int $leads_need Нужно лидов
 * @property int $leads_confirmed Принято лидов
 * @property int $leads_waste Отбраковано лидов
 * @property int $leads_total Всего лидов
 * @property float $price Цена
 * @property float $tax Налог
 * @property float $total_payed Всего выплачено
 * @property string $date Дата принятия
 * @property int|null $offer_id ID оффера
 * @property int $user_id ID пользователя
 * @property int $provider_id ID провайдера
 * @property string $offer_token Токен оффера
 * @property string|null $special_params Специальные параметры
 * @property string $status Статус оффера
 * @property string|null $date_stop
 */
class Offers extends \yii\db\ActiveRecord
{

    public $geo;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'category', 'regions', 'leads_confirmed', 'leads_waste', 'leads_total', 'total_payed', 'user_id', 'offer_token', 'leads_need', 'tax'], 'required'],
            [['regions', 'special_params', 'offer_token', 'geo'], 'string'],
            [['leads_need', 'leads_confirmed', 'leads_waste', 'leads_total', 'offer_id', 'user_id', 'provider_id'], 'integer'],
            [['price', 'tax', 'total_payed'], 'number'],
            [['date', 'date_stop'], 'safe'],
            [['name', 'category', 'status'], 'string', 'max' => 255],
        ];
    }

    public function createOfferToken($data = null) {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        $this->offer_token = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название оффера',
            'category' => 'Категория лидов',
            'regions' => 'Регионы',
            'leads_need' => 'Нужно лидов',
            'leads_confirmed' => 'Принято лидов',
            'leads_waste' => 'Отбраковано лидов',
            'leads_total' => 'Всего лидов',
            'price' => 'Цена',
            'tax' => 'Налог',
            'total_payed' => 'Всего выплачено',
            'date' => 'Дата принятия',
            'offer_id' => 'Оффер-шаблон',
            'user_id' => 'ID пользователя',
            'provider_id' => 'ID провайдера',
            'offer_token' => 'Токен оффера',
            'special_params' => 'Специальные параметры',
            'status' => 'Статус оффера',
            'date_stop' => 'Дата остановки',
        ];
    }

    /**
     * @param $leads LeadTypes
     *
     */
    public function createFromTemplate($leads, $userId, $providerId, $params, $regions = null)
    {
        $this->name = $leads->name;
        $this->category = $leads->category_link;
        $this->regions = !empty($regions) ? $regions : $leads->regions;
        $this->leads_need = $leads->lead_count;
        $this->leads_confirmed = 0;
        $this->leads_waste = 0;
        $this->leads_total = 0;
        $this->price = $leads->price;
        $this->tax = 0;
        $this->total_payed = 0;
        $this->offer_id = $leads->id;
        $this->user_id = $userId;
        $this->provider_id = $providerId;
        $this->createOfferToken();
        $this->special_params = $params;
        $this->status = Orders::STATUS_MODERATION;
    }
}
