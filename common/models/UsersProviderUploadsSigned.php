<?php

namespace common\models;

use common\models\disk\Cloud;
use Yii;

/**
 * This is the model class for table "users_provider_uploads_signed".
 *
 * @property int $id
 * @property int $user_id
 * @property int $upload_id
 * @property string $type
 * @property string $link_report
 * @property string|null $link_bill
 * @property int $status
 * @property float $value
 * @property string $date
 * @property string $date_exp
 */
class UsersProviderUploadsSigned extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users_provider_uploads_signed';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'link_report', 'upload_id'], 'required'],
            [['user_id', 'status', 'upload_id'], 'integer'],
            [['date', 'date_exp'], 'safe'],
            [['value'], 'number'],
            [['type', 'link_report', 'link_bill'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'link_report' => 'Link Report',
            'link_bill' => 'Link Bill',
            'status' => 'Status',
            'date' => 'Date',
            'date_exp' => 'Date Exp',
        ];
    }

    public function beforeDelete()
    {
        $getFilePath = Cloud::WEB_PATH.$this->link_report;
        if (file_exists($getFilePath)) {
            unlink($getFilePath);
        }
        $getFilePath = Cloud::WEB_PATH.$this->link_bill;
        if (file_exists($getFilePath)) {
            unlink($getFilePath);
        }
        return parent::beforeDelete();
    }

}
