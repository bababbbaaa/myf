<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "franchise_cases".
 *
 * @property int $id
 * @property int $franchise_id
 * @property string $date
 * @property int $is_active
 * @property string $img
 * @property string $name
 * @property string $whois
 * @property string $status
 * @property int $investments
 * @property string $feedback
 * @property int $income_approx
 * @property string $offices
 * @property string $video
 */
class FranchiseCases extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'franchise_cases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['franchise_id', 'img', 'name', 'whois', 'status', 'investments', 'feedback', 'income_approx', 'offices'], 'required'],
            [['franchise_id', 'is_active', 'investments', 'income_approx'], 'integer'],
            [['date'], 'safe'],
            [['img', 'name', 'whois', 'status', 'feedback', 'offices', 'video'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'franchise_id' => 'Франшиза',
            'date' => 'Дата',
            'is_active' => 'Кейс активен',
            'img' => 'Картинка',
            'name' => 'ФИО',
            'whois' => 'О партнере',
            'status' => 'Статус партнера',
            'investments' => 'Инвестиции',
            'feedback' => 'Точка окупаемости',
            'income_approx' => 'Средний доход',
            'offices' => 'Офисы',
            'video' => 'Видео Youtube',
        ];
    }
}
