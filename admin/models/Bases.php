<?php

namespace admin\models;

use common\models\DbCity;
use common\models\DbRegion;
use common\models\LeadsCategory;
use Yii;

/**
 * This is the model class for table "bases".
 *
 * @property int $id
 * @property string|null $name
 * @property string $category
 * @property string $geo
 * @property string $provider
 * @property string $date_create
 * @property int $is_new
 * @property BasesContacts[] $contacts
 */
class Bases extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category', 'geo', 'provider'], 'required'],
            [['date_create'], 'safe'],
            [['is_new'], 'integer'],
            [['name', 'category', 'geo', 'provider'], 'string', 'max' => 255],
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
            'category' => 'Категория',
            'geo' => 'Регион',
            'provider' => 'Поставщик',
            'date_create' => 'Дата',
            'is_new' => 'Новая?',
        ];
    }

    public static function cats() {
        $cats = LeadsCategory::find()->asArray()->select(['link_name', 'name'])->all();
        $arr = [];
        if (!empty($cats)) {
            foreach ($cats as $item)
                $arr[$item['link_name']] = $item['name'];
        }
        return $arr;
    }

    public static function multiselect_region() {
        $reg = DbRegion::find()->select(['name_with_type'])->asArray()->all();
        $multi = [];
        foreach ($reg as $item) {
            $rar[$item['name_with_type']] = $item['name_with_type'];
        }
        asort($rar);
        $multi['Регионы'] = $rar;
        array_unshift($multi, ['Любой' => ['Любой' => 'Любой']]);
        return $multi;
    }

    public function getContacts() {
        return $this->hasMany(BasesContacts::class, ['base_id' => 'id'])->orderBy('id desc');
    }

    public function beforeDelete()
    {
        $utms = BasesUtm::find()->where(['base_id' => $this->id])->all();
        if (!empty($utms)) {
            foreach ($utms as $item)
                $item->delete();
        }
        if (!empty($this->contacts)) {
            foreach ($this->contacts as $item)
                $item->delete();
        }
        return parent::beforeDelete(); // TODO: Change the autogenerated stub
    }

}