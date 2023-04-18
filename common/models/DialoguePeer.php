<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dialogue_peer".
 *
 * @property int $id
 * @property int $user_id
 * @property int $exp_date
 * @property string $date
 * @property string $type
 * @property string $properties
 * @property int $status
 * @property DialoguePeerMessages[] $messages
 */
class DialoguePeer extends \yii\db\ActiveRecord
{

    const STATUS_CLOSED = 0;
    const STATUS_OPENED = 1;
    const TYPE_DEFAULT = 'диалог';
    const TYPE_ORDER = 'заказ';
    const TYPE_OFFER = 'оффер';

    public static $textStatus = [
        self::STATUS_OPENED => 'открыт',
        self::STATUS_CLOSED => 'закрыт',
    ];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dialogue_peer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'status', 'exp_date',], 'integer'],
            [['date'], 'safe'],
            [['properties'], 'string'],
            [['type'], 'string', 'max' => 255],
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
            'date' => 'Дата',
            'status' => 'Статус',
            'type' => 'Тип',
            'properties' => 'Дополнительно',
            'exp_date' => 'Дата скрытия',
        ];
    }

    public function getMessages() {
        return $this->hasMany(DialoguePeerMessages::class, ['peer_id' => 'id']);
    }
}
