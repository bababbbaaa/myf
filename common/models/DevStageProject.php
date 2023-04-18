<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dev_stage_project".
 *
 * @property int $id ID
 * @property string $title Название статуса
 * @property string $subtitle Описание статуса
 */
class DevStageProject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dev_stage_project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'subtitle'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['subtitle'], 'string', 'max' => 511],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название статуса',
            'subtitle' => 'Описание статуса',
        ];
    }
}
