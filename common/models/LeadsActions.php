<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "leads_actions".
 *
 * @property int $id
 * @property int $lead_id
 * @property string $lead_type
 * @property string $date
 * @property string $action_type
 */
class LeadsActions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'leads_actions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['lead_id', 'lead_type', 'action_type'], 'required'],
            [['lead_id'], 'integer'],
            [['date'], 'safe'],
            [['lead_type', 'action_type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'lead_id' => 'Lead ID',
            'lead_type' => 'Lead Type',
            'date' => 'Date',
            'action_type' => 'Action Type',
        ];
    }
}
