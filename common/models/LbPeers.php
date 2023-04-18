<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "lb_peers".
 *
 * @property int $id
 * @property int $uid
 * @property string $peer_stage
 * @property string|null $params
 */
class LbPeers extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'lb_peers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uid', 'peer_stage'], 'required'],
            [['uid'], 'integer'],
            [['params'], 'string'],
            [['peer_stage'], 'string', 'max' => 255],
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
            'params' => 'Params',
        ];
    }
}
