<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "db_city".
 *
 * @property int $id
 * @property string|null $address
 * @property int|null $postal_code
 * @property string|null $country
 * @property string|null $federal_district
 * @property string|null $region_type
 * @property string|null $region
 * @property string|null $area_type
 * @property string|null $area
 * @property string|null $city_type
 * @property string|null $city
 * @property string|null $settlement_type
 * @property string|null $settlement
 * @property int|null $kladr_id
 * @property string|null $fias_id
 * @property int|null $fias_level
 * @property int|null $capital_marker
 * @property int|null $okato
 * @property int|null $oktmo
 * @property int|null $tax_office
 * @property string|null $timezone
 * @property float|null $geo_lat
 * @property float|null $geo_lon
 * @property string|null $population
 * @property string|null $foundation_year
 *
 * @property DbRegion $region0
 */
class DbCity extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'db_city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'postal_code', 'kladr_id', 'fias_level', 'capital_marker', 'okato', 'oktmo', 'tax_office'], 'integer'],
            [['geo_lat', 'geo_lon'], 'number'],
            [['address'], 'string', 'max' => 69],
            [['country', 'timezone'], 'string', 'max' => 6],
            [['federal_district'], 'string', 'max' => 17],
            [['region_type'], 'string', 'max' => 7],
            [['region'], 'string', 'max' => 40],
            [['area_type', 'city_type'], 'string', 'max' => 3],
            [['area'], 'string', 'max' => 27],
            [['city'], 'string', 'max' => 25],
            [['settlement_type'], 'string', 'max' => 1],
            [['settlement'], 'string', 'max' => 11],
            [['fias_id'], 'string', 'max' => 36],
            [['population'], 'string', 'max' => 8],
            [['foundation_year'], 'string', 'max' => 18],
            [['id'], 'unique'],
            [['region'], 'exist', 'skipOnError' => true, 'targetClass' => DbRegion::className(), 'targetAttribute' => ['region' => 'name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'address' => 'Address',
            'postal_code' => 'Postal Code',
            'country' => 'Country',
            'federal_district' => 'Federal District',
            'region_type' => 'Region Type',
            'region' => 'Region',
            'area_type' => 'Area Type',
            'area' => 'Area',
            'city_type' => 'City Type',
            'city' => 'City',
            'settlement_type' => 'Settlement Type',
            'settlement' => 'Settlement',
            'kladr_id' => 'Kladr ID',
            'fias_id' => 'Fias ID',
            'fias_level' => 'Fias Level',
            'capital_marker' => 'Capital Marker',
            'okato' => 'Okato',
            'oktmo' => 'Oktmo',
            'tax_office' => 'Tax Office',
            'timezone' => 'Timezone',
            'geo_lat' => 'Geo Lat',
            'geo_lon' => 'Geo Lon',
            'population' => 'Population',
            'foundation_year' => 'Foundation Year',
        ];
    }

    /**
     * Gets query for [[Region0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRegion0()
    {
        return $this->hasOne(DbRegion::className(), ['name' => 'region']);
    }
}
