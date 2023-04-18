<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "leads_params_values".
 *
 * @property int $id
 * @property string $param
 * @property string $value
 * @property int $lead
 * @property string $date
 *
 * @property Leads $lead0
 */
class LeadsParamsValues extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads_params_values';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['param', 'value', 'lead'], 'required'],
            [['lead'], 'integer'],
            [['date'], 'safe'],
            [['param', 'value'], 'string', 'max' => 255],
            [['lead'], 'exist', 'skipOnError' => true, 'targetClass' => Leads::className(), 'targetAttribute' => ['lead' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'param' => 'Param',
            'value' => 'Value',
            'lead' => 'Lead',
            'date' => 'Date',
        ];
    }

    /**
     * Gets query for [[Lead0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getLead0()
    {
        return $this->hasOne(Leads::className(), ['id' => 'lead']);
    }
}
