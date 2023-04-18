<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bavaria_bot_places_alias".
 *
 * @property int $id
 * @property int $place_id
 * @property int $time_start
 * @property int $time_end_approx
 * @property string $tg_user_id
 * @property string $status
 * @property string $params
 */
class BavariaBotPlacesAlias extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bavaria_bot_places_alias';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['place_id', 'time_start', 'time_end_approx', 'tg_user_id'], 'required'],
            [['place_id', 'time_start', 'time_end_approx'], 'integer'],
            [['tg_user_id', 'status'], 'string', 'max' => 255],
            [['params'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'place_id' => 'Place ID',
            'time_start' => 'Time Start',
            'time_end_approx' => 'Time End Approx',
            'tg_user_id' => 'Tg User ID',
        ];
    }
}
