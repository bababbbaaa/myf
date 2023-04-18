<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "franchise_package".
 *
 * @property int $id
 * @property int $is_active
 * @property int $franchise_id
 * @property string $name
 * @property string|null $parent_package
 * @property string $package_content
 * @property float $price
 */
class FranchisePackage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'franchise_package';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'package_content', 'price', 'franchise_id'], 'required'],
            [['package_content'], 'string'],
            [['price'], 'number'],
            [['franchise_id', 'is_active'], 'integer'],
            [['name', 'parent_package'], 'string', 'max' => 255],
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
            'parent_package' => 'Наследует все особенности пакета',
            'package_content' => 'Контент пакета',
            'price' => 'Цена',
            'franchise_id' => 'Франшиза',
            'is_active' => 'Пакет активен',
        ];
    }
}
