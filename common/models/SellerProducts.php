<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "seller_products".
 *
 * @property int $id
 * @property string $name
 * @property int $client_id
 * @property float|null $summ
 * @property string $date
 * @property int $seller_id
 */
class SellerProducts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'seller_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'client_id', 'seller_id'], 'required'],
            [['client_id', 'seller_id'], 'integer'],
            [['summ'], 'number'],
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
            'name' => 'Name',
            'client_id' => 'Client ID',
            'summ' => 'Summ',
            'date' => 'Date',
            'seller_id' => 'Seller ID',
        ];
    }
}
