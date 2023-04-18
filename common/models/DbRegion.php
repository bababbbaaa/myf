<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "db_region".
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $type
 * @property string|null $name_with_type
 * @property string|null $federal_district
 * @property int|null $kladr_id
 * @property string|null $fias_id
 * @property int|null $okato
 * @property int|null $oktmo
 * @property int|null $tax_office
 * @property int|null $postal_code
 * @property string|null $iso_code
 * @property string|null $timezone
 * @property string|null $geoname_code
 * @property int|null $geoname_id
 * @property string|null $geoname_name
 *
 * @property DbCity[] $dbCities
 */
class DbRegion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'db_region';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'kladr_id', 'okato', 'oktmo', 'tax_office', 'postal_code', 'geoname_id'], 'integer'],
            [['name', 'name_with_type'], 'string', 'max' => 40],
            [['type'], 'string', 'max' => 7],
            [['federal_district'], 'string', 'max' => 17],
            [['fias_id'], 'string', 'max' => 36],
            [['iso_code', 'timezone'], 'string', 'max' => 6],
            [['geoname_code'], 'string', 'max' => 5],
            [['geoname_name'], 'string', 'max' => 31],
            [['name'], 'unique'],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'type' => 'Type',
            'name_with_type' => 'Name With Type',
            'federal_district' => 'Federal District',
            'kladr_id' => 'Kladr ID',
            'fias_id' => 'Fias ID',
            'okato' => 'Okato',
            'oktmo' => 'Oktmo',
            'tax_office' => 'Tax Office',
            'postal_code' => 'Postal Code',
            'iso_code' => 'Iso Code',
            'timezone' => 'Timezone',
            'geoname_code' => 'Geoname Code',
            'geoname_id' => 'Geoname ID',
            'geoname_name' => 'Geoname Name',
        ];
    }

    /**
     * Gets query for [[DbCities]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDbCities()
    {
        return $this->hasMany(DbCity::className(), ['region' => 'name']);
    }
}
