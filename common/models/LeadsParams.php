<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "leads_params".
 *
 * @property int $id
 * @property string $category
 * @property string $name
 * @property string $type
 * @property string $cc_vars
 * @property string $description
 * @property string|null $provider_example
 * @property int $required
 * @property int $filter_type
 * @property string $comparison_type
 * @property string $date
 *
 * @property LeadsCategory $category0
 */
class LeadsParams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads_params';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'name', 'type', 'description'], 'required'],
            [['type', 'cc_vars',], 'string'],
            [['required'], 'integer'],
            [['date'], 'safe'],
            [['category', 'name', 'description', 'provider_example', 'filter_type', 'comparison_type'], 'string', 'max' => 255],
            [['category'], 'exist', 'skipOnError' => true, 'targetClass' => LeadsCategory::className(), 'targetAttribute' => ['category' => 'link_name']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Категория',
            'name' => 'Наименование',
            'type' => 'Тип переменной',
            'description' => 'Описание',
            'cc_vars' => 'Варианты для КЦ',
            'provider_example' => 'Пример для поставщика',
            'required' => 'Параметр заполняется в КЦ',
            'filter_type' => 'Способ фильтрации',
            'comparison_type' => 'Способ проверки',
            'date' => 'Дата',
        ];
    }

    public function addParam($param, $category) {
        $this->category = $category;
        $this->name = $param->name;
        $this->type = $param->type;
        $this->description = $param->description;
        $this->filter_type = 'like';
        $this->comparison_type = 'notNull';
        $this->provider_example = $param->example;
        $this->required = $param->required;
        return $this;
    }

    public function returnComposedObject() {
        $obj = new \stdClass();
        $obj->name = $this->name;
        $obj->type = $this->type;
        $obj->description = $this->description;
        $obj->example = $this->provider_example;
        $obj->required = $this->required;
        return $obj;
    }

    /**
     * Gets query for [[Category0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(LeadsCategory::className(), ['link_name' => 'category']);
    }
}
