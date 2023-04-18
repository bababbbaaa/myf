<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "offers_alias".
 *
 * @property int $id ID
 * @property int $lead_id ID лида
 * @property int $user_id ID поставщика
 * @property int $offer_id ID оффера
 * @property int $provider_id ID оффера
 * @property string $date Дата создания связи
 */
class OffersAlias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offers_alias';
    }

    public $summ;
    public $date_lead;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lead_id', 'user_id', 'offer_id', 'provider_id'], 'required'],
            [['lead_id', 'user_id', 'offer_id', 'provider_id', 'summ'], 'integer'],
            [['date', 'date_lead'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lead_id' => 'ID лида',
            'user_id' => 'ID пользователя',
            'offer_id' => 'ID оффера',
            'provider_id' => 'ID провайдера',
            'date' => 'Дата создания связи',
        ];
    }
}
