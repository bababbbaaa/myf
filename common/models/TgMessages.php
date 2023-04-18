<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tg_messages".
 *
 * @property int $id
 * @property string $peer
 * @property string $bot
 * @property string $message
 * @property string $image
 * @property int $is_loop
 * @property string|null $date_to_post
 * @property string $days_to_post
 * @property int $is_done
 * @property int $minimum_time
 * @property string $date_create
 */
class TgMessages extends \yii\db\ActiveRecord
{

    public $daysToPublish;

    public static $peers = [
        '-1001401708228' => 'Digital Work - твоя биржа услуг',
        '-610988111' => 'Тестовый чат',
    ];

    public static $bots = [
        'bot2007203088:AAG50-mnGXpvGKk3U-nFGjusDIA0Ns5AdxU' => 'Lead.Force Helper'
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tg_messages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['peer', 'bot', 'message'], 'required'],
            [['message', 'days_to_post'], 'string'],
            [['is_loop', 'is_done', 'minimum_time'], 'integer'],
            [['date_to_post', 'date_create'], 'safe'],
            [['minimum_time'], 'default', 'value' => 9],
            [['peer', 'bot', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'peer' => 'Группа',
            'bot' => 'Бот',
            'message' => 'Сообщение для отправки',
            'image' => 'Картинка',
            'is_loop' => 'Зациклено',
            'date_to_post' => 'Дата и время публикации',
            'days_to_post' => 'Дни публикации сообщения',
            'is_done' => 'Выполнено',
            'minimum_time' => 'Минимальное время отсчета публикации',
            'date_create' => 'Дата создания записи',
        ];
    }

    public function convert__emoji() {
        return preg_replace_callback('/(\\\x\S+)+/mi', function ($m) {
            return hex2bin(str_replace('\x', '', $m[0]));
        }, $this->message);
    }

}
