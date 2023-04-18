<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dev_project_allias".
 *
 * @property int $id ID
 * @property int $project_id ID проекта
 * @property int $stage_id ID статуса
 * @property string $date Дата выполнения
 */
class DevProjectAllias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dev_project_allias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'stage_id', 'date'], 'required'],
            [['project_id', 'stage_id'], 'integer'],
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
            'project_id' => 'Проект',
            'stage_id' => 'Стадия',
            'date' => 'Дата выполнения',
        ];
    }
}
