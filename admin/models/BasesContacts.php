<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "bases_contacts".
 *
 * @property int $id
 * @property string $phone
 * @property int $base_id
 * @property string $date
 * @property BasesUtm[] $utm
 * @property BasesUtm $utmHelper
 */
class BasesContacts extends \yii\db\ActiveRecord
{

    public static $helperName;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bases_contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'base_id'], 'required'],
            [['base_id'], 'integer'],
            [['date'], 'safe'],
            [['phone'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Телефон',
            'base_id' => 'База',
            'date' => 'Дата',
        ];
    }


    public function getUtm() {
        return $this->hasMany(BasesUtm::class, ['contact_id' => 'id']);
    }

    public function getUtmHelper() {
        return $this->hasOne(BasesUtm::class, ['contact_id' => 'id'])->where(['bases_utm.name' => static::$helperName]);
    }

}
