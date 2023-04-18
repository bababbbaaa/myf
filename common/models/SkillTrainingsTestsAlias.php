<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_trainings_tests_alias".
 *
 * @property int $id ID
 * @property int $training_id ID курса
 * @property int $block_id ID блока
 * @property int $test_id ID теста
 * @property string $date Дата
 * @property string $answer Ответы
 * @property string|null $result Результат
 * @property string $status Статус
 * @property int $try_count Количество попыток
 * @property int $user_id ID юзера
 */
class SkillTrainingsTestsAlias extends \yii\db\ActiveRecord
{

    const
        STATUS_DEAD         = 'Не зачет',
        STATUS_OFFSET       = 'Зачтено';

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_trainings_tests_alias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_id', 'block_id', 'answer', 'user_id'], 'required'],
            [['training_id', 'block_id', 'try_count', 'user_id', 'test_id'], 'integer'],
            [['date'], 'safe'],
            [['answer'], 'string'],
            [['result', 'status'], 'string', 'max' => 255],
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
            'test_id' => 'ID теста',
            'date' => 'Дата',
            'answer' => 'Ответы',
            'result' => 'Результат',
            'status' => 'Статус',
            'try_count' => 'Количество попыток',
            'user_id' => 'ID юзера',
        ];
    }
}
