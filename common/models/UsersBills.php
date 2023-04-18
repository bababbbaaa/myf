<?php

namespace common\models;

use common\models\disk\Cloud;
use Yii;

/**
 * This is the model class for table "users_bills".
 *
 * @property int $id
 * @property int $user_id
 * @property string $link
 * @property string $act_data
 * @property float $value
 * @property string $date
 * @property string $status
 * @property string|null $name
 */
class UsersBills extends \yii\db\ActiveRecord
{

    const STATUS_WAIT = 'ожидает';
    const STATUS_CONFIRMED = 'исполнен';


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_bills';
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
            [['value'], 'number'],
            [['act_data'], 'string'],
            [['link', 'name', 'status'], 'string', 'max' => 255],
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
            'link' => 'Ссылка на счет',
            'date' => 'Дата',
            'name' => 'Название',
            'value' => 'Сумма',
            'act_data' => 'Данные для выставления акта',
            'status' => 'Статус счета',
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
