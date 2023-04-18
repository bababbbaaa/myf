<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "users_notice".
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $date
 * @property int $active
 * @property string $text
 * @property string|null $properties
 */
class UsersNotice extends \yii\db\ActiveRecord
{


    const
        TYPE_MAINPAGE_MODERATION                  = "Уведомление о проверке",
        TYPE_MAINPAGE_MODERATION_OFFER            = "Уведомление о проверке",
        TYPE_MAINPAGE_MODERATION_SUCCESS          = "Заказ одобрен",
        TYPE_MAINPAGE_MODERATION_OFFER_SUCCESS    = "Оффер одобрен",
        TYPE_NEED_PROFILE_SUBMISSION              = "Заполнение профиля",
        TYPE_INCOME_BUDGET                        = "Пополнен баланс",
        TYPE_NOT_ENOUGH_BUDGET                    = "Пополнение баланса",
        TYPE_NEW_LEAD                             = "Новый лид";

    public $adminTypesSelect = [
        self::TYPE_NOT_ENOUGH_BUDGET => self::TYPE_NOT_ENOUGH_BUDGET
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_notice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'text'], 'required'],
            [['user_id', 'active'], 'integer'],
            [['date'], 'safe'],
            [['properties'], 'string'],
            [['type', 'text'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'type' => 'Тип',
            'date' => 'Дата',
            'active' => 'Активность',
            'text' => 'Текст',
            'properties' => 'Свойства',
        ];
    }
}
