<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "offer_params".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string|null $area
 * @property string $date
 */
class OfferParams extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'offer_params';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['date'], 'safe'],
            [['name', 'description', 'area'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'area' => 'Area',
            'date' => 'Date',
        ];
    }
}
