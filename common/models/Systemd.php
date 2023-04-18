<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "systemd".
 *
 * @property int $id ID
 * @property string $name Название сервиса
 * @property string $date Дата
 * @property string|null $service_description Описание сервиса
 */
class Systemd extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'systemd';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['date'], 'safe'],
            [['name', 'service_description'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название сервиса',
            'date' => 'Дата',
            'service_description' => 'Описание сервиса',
        ];
    }
}
