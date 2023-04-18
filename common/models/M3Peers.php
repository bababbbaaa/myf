<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "m3_peers".
 *
 * @property int $id
 * @property int $uid
 * @property string $peer_stage
 * @property string $params
 */
class M3Peers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'm3_peers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'peer_stage'], 'required'],
            [['uid'], 'integer'],
            [['peer_stage'], 'string', 'max' => 255],
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
            'uid' => 'Uid',
            'peer_stage' => 'Peer Stage',
        ];
    }
}
