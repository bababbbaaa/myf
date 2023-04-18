<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bavaria_contacts".
 *
 * @property int $id
 * @property string $phone
 * @property string $tg_user
 */
class BavariaContacts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bavaria_contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['phone', 'tg_user'], 'required'],
            [['phone', 'tg_user'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
            'tg_user' => 'Tg User',
        ];
    }
}
