<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_trainings_blocks_alias".
 *
 * @property int $id ID
 * @property int $training_id ID курса
 * @property int $block_id ID блока
 * @property int $user_id ID юзера
 * @property string $date Дата
 */
class SkillTrainingsBlocksAlias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_trainings_blocks_alias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_id', 'block_id', 'user_id'], 'required'],
            [['training_id', 'block_id', 'user_id'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'training_id' => 'ID курса',
            'block_id' => 'ID блока',
            'user_id' => 'ID юзера',
            'date' => 'Дата',
        ];
    }
}
