<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jobs".
 *
 * @property int $id ID
 * @property string $position Должность
 * @property string $payment Оплата
 * @property string|null $site Сайт компании
 * @property string $company_name Название компании
 * @property string $city Город
 * @property string $email Почта компании
 * @property string $date Дата создания
 * @property string $logo Логотип компании
 * @property string $type_employment Тип занятости
 * @property string $work_format Формат работы
 * @property string $duties Обязанности
 * @property string $requirements Требования
 * @property string $working_conditions Условия работы
 */
class Jobs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jobs';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['position', 'payment', 'company_name', 'email', 'city', 'logo', 'type_employment', 'work_format', 'duties', 'requirements', 'working_conditions'], 'required'],
            [['date'], 'safe'],
            [['duties', 'requirements', 'working_conditions'], 'string'],
            [['position', 'payment', 'email', 'company_name', 'site', 'city', 'logo', 'type_employment', 'work_format'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => 'Должность',
            'payment' => 'Оплата',
            'company_name' => 'Название компании',
            'site' => 'Сайт компании',
            'email' => 'Почта компании',
            'city' => 'Город',
            'date' => 'Дата создания',
            'logo' => 'Логотип компании',
            'type_employment' => 'Тип занятости',
            'work_format' => 'Формат работы',
            'duties' => 'Обязанности',
            'requirements' => 'Требования',
            'working_conditions' => 'Условия работы',
        ];
    }
}
