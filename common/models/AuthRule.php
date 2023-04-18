<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "auth_rule".
 *
 * @property string $name
 * @property resource|null $data
 * @property int|null $created_at
 * @property int|null $updated_at
 *
 * @property AuthItem[] $authItems
 */
class AuthRule extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_rule';
    }


    public function beforeSave($insert)
    {
        if ($insert) {
            $this->created_at = time();
            $this->updated_at = time();
            $class = ucfirst($this->name) . "Rule";
            $path = "admin\\modules\\rbac\\rules\\{$class}";
            $rule = new $path;
            $rule->createdAt = $this->created_at;
            $rule->updatedAt = $this->updated_at;
            $this->data = serialize($rule);
        } else {
            $this->updated_at = time();
            $class = ucfirst($this->name) . "Rule";
            $path = "admin\\modules\\rbac\\rules\\{$class}";
            $rule = new $path;
            $this->data = serialize($rule);
        }
        return parent::beforeSave($insert);
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['data'], 'string'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 64],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название',
            'data' => 'Данные',
            'created_at' => 'Создан',
            'updated_at' => 'Обновлен',
        ];
    }

    /**
     * Gets query for [[AuthItems]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItems()
    {
        return $this->hasMany(AuthItem::className(), ['rule_name' => 'name']);
    }
}
