<?php

namespace common\models;

use common\models\disk\Cloud;
use Yii;

/**
 * This is the model class for table "users_certificates".
 *
 * @property int $id ID
 * @property int $user_id Пользователь
 * @property string $link Ссылка
 * @property string $date Дата
 * @property string|null $name Название
 */
class UsersCertificates extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_certificates';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'link'], 'required'],
            [['user_id'], 'integer'],
            [['date'], 'safe'],
            [['link', 'name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'Пользователь',
            'link' => 'Ссылка',
            'date' => 'Дата',
            'name' => 'Название',
        ];
    }

    public function beforeDelete()
    {
        $getFilePath = Cloud::WEB_PATH.$this->link;
        if (file_exists($getFilePath)) {
            unlink($getFilePath);
        }
        return parent::beforeDelete();
    }

}
