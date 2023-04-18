<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "random_queue".
 *
 * @property int $id
 * @property int $order_id
 * @property int $count250up
 * @property int $count250down
 * @property int $get250up
 * @property int $get250down
 */
class RandomQueue extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'random_queue';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id', 'count250up', 'count250down', 'get250up', 'get250down'], 'required'],
            [['order_id', 'count250up', 'count250down', 'get250up', 'get250down'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'count250up' => 'Count250up',
            'count250down' => 'Count250down',
            'get250up' => 'Get250up',
            'get250down' => 'Get250down',
        ];
    }

    public function generateRandom($id) {
        $this->order_id = $id;
        $this->count250up = 5; //mt_rand(3,5);
        $this->count250down = 5; //6 - $this->count250up;
        $this->get250down = 0;
        $this->get250up = 0;
    }
}
