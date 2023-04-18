<?php

namespace admin\models;

use Yii;

/**
 * This is the model class for table "providers_utms".
 *
 * @property int $id
 * @property string $name
 * @property int $provider_id
 * @property string $date
 */
class ProvidersUtms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'providers_utms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'provider_id'], 'required'],
            [['provider_id'], 'integer'],
            [['date'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'provider_id' => 'Поставщик',
            'date' => 'Дата',
        ];
    }


    public function generate(
        int $provider,
        int $length = 8,
        string $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
    ) {
        do {
            if ($length < 1) {
                throw new \RangeException("Length must be a positive integer");
            }
            $pieces = [];
            $max = mb_strlen($keyspace, '8bit') - 1;
            for ($i = 0; $i < $length; ++$i) {
                $pieces []= $keyspace[random_int(0, $max)];
            }
            $this->name = implode('', $pieces);
            $find = self::findOne(['name' => $this->name]);
            if (empty($find))
                break;
        } while (true);
        $this->provider_id = $provider;
        return $this;
    }

}
