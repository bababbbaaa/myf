<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "budget_log".
 *
 * @property int $id
 * @property string $text
 * @property string $date
 * @property int $user_id
 * @property float $budget_was
 * @property float $budget_after
 */
class BudgetLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'budget_log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text', 'user_id', 'budget_was'], 'required'],
            [['date'], 'safe'],
            [['user_id'], 'integer'],
            [['budget_was', 'budget_after', ], 'number'],
            [['text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Описание',
            'date' => 'Дата',
            'user_id' => 'Пользователь',
            'budget_was' => 'Бюджет до изменения',
            'budget_after' => 'Бюджет после изменения',
        ];
    }
}
