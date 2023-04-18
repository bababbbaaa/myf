<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "backdoor_webhooks".
 *
 * @property int $id
 * @property string $url
 * @property string $hash
 * @property string $date
 * @property string $lead_type
 */
class BackdoorWebhooks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'backdoor_webhooks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'hash', 'lead_type'], 'required'],
            [['date'], 'safe'],
            [['url', 'hash', 'lead_type'], 'string', 'max' => 255],
        ];
    }


    public function createUUID($data = null) {
        $data = $data ?? random_bytes(16);
        assert(strlen($data) == 16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        $this->hash = vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url' => 'Ссылка',
            'hash' => 'Ключ вебхука',
            'date' => 'Дата',
            'lead_type' => 'Тип лида',
        ];
    }
}
