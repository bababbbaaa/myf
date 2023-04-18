<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "map".
 *
 * @property int $id
 * @property string $partner_name
 * @property string $city
 * @property string $address
 * @property string $region
 * @property string $date
 */
class Map extends \yii\db\ActiveRecord
{
    public static $regions = [
        'central',
        'southern',
        'northwestern',
        'fareastern',
        'siberian',
        'urals',
        'volga'
    ];
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'map';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['partner_name', 'city', 'address', 'region'], 'required'],
            [['date'], 'safe'],
            [['partner_name', 'city', 'address', 'region'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'partner_name' => 'Название',
            'city' => 'Город',
            'address' => 'Адрес',
            'region' => 'Регион РФ',
            'date' => 'Дата',
        ];
    }
    public static function getByRegion($search)
    {
        return self::find()->where(['region' => $search])->asArray()->all();

    }
}
