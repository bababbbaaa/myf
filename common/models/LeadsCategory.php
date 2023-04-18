<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "leads_category".
 *
 * @property int $id
 * @property string $name
 * @property string $link_name
 * @property string $date
 * @property int $public
 * @property string $params
 *
 * @property LeadsParams[] $leadsParams
 * @property Orders[] $orders
 */
class LeadsCategory extends \yii\db\ActiveRecord
{

    public $params;

    public static $special_categories = [
        'audit',
        'rekruting',
        'kreditnye-karty',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads_category';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'link_name'], 'required'],
            [['date'], 'safe'],
            [['public'], 'integer'],
            [['params'], 'string'],
            [['name', 'link_name'], 'string', 'max' => 255],
            [['link_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Наименование',
            'link_name' => 'Специальная ссылка',
            'date' => 'Дата',
            'public' => 'Публичность',
        ];
    }

    /**
     * Gets query for [[LeadsParams]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLeadsParams()
    {
        return $this->hasMany(LeadsParams::className(), ['category' => 'link_name']);
    }

    public function getOrders()
    {
        return $this->hasMany(Orders::className(), ['category_link' => 'link_name']);
    }

    public function getTemplates() {
        return $this->hasMany(LeadTemplates::class, ['category_link' => 'link_name']);
    }
}
