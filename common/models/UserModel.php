<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property int $is_client
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property string $sms_restore_password
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int $cc_daily_get
 * @property int $cc_daily_max
 * @property int $cc_status
 * @property string|null $verification_token
 * @property string|null $referal
 * @property float $budget
 * @property string $inner_name
 * @property string $au_name
 * @property UsersBonuses $bonuses
 */
class UserModel extends \yii\db\ActiveRecord
{

    public $entity;
    public $password;

    const STATUS_WORKING = 1;
    const STATUS_SLEEP = 0;

    public static $statusText = [
        self::STATUS_SLEEP => 'не работаю',
        self::STATUS_WORKING => 'работаю'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public static function isOperator($id) {
        $auth = AuthAssignment::find()->where(['item_name' => 'cc', 'user_id' => $id])->asArray()->one();
        return !empty($auth);
    }

    public static function getOperators() {
        $auth = AuthAssignment::find()->where(['item_name' => 'cc'])->select(['user_id'])->asArray()->all();
        $idArray = [];
        if (!empty($auth)) {
            foreach ($auth as $item)
                $idArray[] = $item['user_id'];
        }
        return $idArray;
    }

    public static function getAu() {
        $auth = AuthAssignment::find()->where(['item_name' => 'au'])->select(['user_id'])->asArray()->all();
        $idArray = [];
        if (!empty($auth)) {
            foreach ($auth as $item)
                $idArray[] = $item['user_id'];
        }
        return $idArray;
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at', 'cc_daily_get', 'cc_daily_max', 'cc_status', 'is_client'], 'integer'],
            [['budget'], 'number'],
            [['username', 'password_hash', 'password', 'password_reset_token', 'email', 'verification_token', 'inner_name', 'au_name', 'sms_restore_password', 'referal'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'referal' => 'Реферальная ссылка',
            'password' => 'Пароль',
            'auth_key' => 'Ключ авторизации',
            'password_hash' => 'Хэш пароль',
            'password_reset_token' => 'Ключ восстановления пароля',
            'is_client' => 'Это клиент',
            'email' => 'Почта',
            'status' => 'Статус',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
            'entity' => 'Сущность',
            'verification_token' => 'Ключ верификации',
            'budget' => 'Бюджет',
            'inner_name' => 'Имя оператора',
            'au_name' => 'Имя АУ',
            'cc_daily_get' => 'Получил сегодня лидов',
            'cc_daily_max' => 'Максимум лидов в день',
            'cc_status' => 'Статус КЦ',
            'sms_restore_password' => 'СМС восстановление пароля',
        ];
    }

    public function getBonuses() {
        return $this->hasOne(UsersBonuses::class, ['user_id' => 'id']);
    }

}
