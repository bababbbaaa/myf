<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cdb_category".
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property string $link
 * @property string $date
 */
class CdbCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cdb_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'link'], 'required'],
            [['description'], 'string'],
            [['date'], 'safe'],
            [['name', 'link'], 'string', 'max' => 255],
            [['link'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'description' => 'Описание',
            'link' => 'Ссылка',
            'date' => 'Дата',
        ];
    }
}
