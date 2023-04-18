<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_trainings_tasks_alias".
 *
 * @property int $id ID
 * @property int $training_id ID курса
 * @property int $block_id ID блока
 * @property int $task_id ID задания
 * @property int $user_id ID пользователя
 * @property string $date Дата
 * @property string|null $comment Комментарий ученика
 * @property string|null $link Ссылка на задание
 * @property string $status Статус задания
 * @property string|null $feedback Ответ от преподователя
 * @property string|null $date_exp Срок сдачи задания
 */
class SkillTrainingsTasksAlias extends \yii\db\ActiveRecord
{
    const
        STATUS_SEND         = 'Отправлено',
        STATUS_DEAD         = 'Не зачет',
        STATUS_REVISION     = 'Доработка',
        STATUS_OFFSET       = 'Зачтено';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_trainings_tasks_alias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['training_id', 'block_id', 'user_id', 'task_id'], 'required'],
            [['training_id', 'block_id', 'user_id', 'task_id'], 'integer'],
            [['date', 'date_exp'], 'safe'],
            [['comment'], 'string'],
            [['link'], 'string', 'max' => 512],
            [['status', 'feedback'], 'string', 'max' => 255],
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
            'task_id' => 'ID задания',
            'user_id' => 'ID пользователя',
            'date' => 'Дата',
            'comment' => 'Комментарий ученика',
            'link' => 'Ссылка на задание',
            'status' => 'Статус задания',
            'feedback' => 'Ответ от преподователя',
            'date_exp' => 'Срок сдачи задания',
        ];
    }
}
