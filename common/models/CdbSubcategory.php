<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cdb_subcategory".
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string|null $description
 * @property string $link
 * @property string $date
 */
class CdbSubcategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cdb_subcategory';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'name', 'link'], 'required'],
            [['category_id'], 'integer'],
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
            'category_id' => 'ID категории',
            'name' => 'Название',
            'description' => 'Описание',
            'link' => 'Ссылка',
            'date' => 'Дата',
        ];
    }
}
