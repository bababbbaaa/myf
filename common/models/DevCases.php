<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "dev_cases".
 *
 * @property int $id ID
 * @property string $logo Логотип компании
 * @property string $name Название компании
 * @property string $description_works Описание проделанной работы
 * @property string $fone_img Фоновое изображение
 * @property string $client Клиент
 * @property string $services Услуги
 * @property string $tags Теги
 * @property string $sphere Сфера деятельности
 * @property string $site Адресс сайта
 * @property string $project_objective Задача проекта
 * @property string $results Результаты в бизнес-показателях
 * @property string $done_big_image Что сделано Большое изображение
 * @property string $done_description Что сделано Описание
 * @property string $done_small_image Что сделано Дополнительное изображение
 * @property string $done_small_image_description Подпись к дополнительному изображению
 * @property string|null $functionality_lk_text Функционал личного кабинета
 * @property string|null $functionality_lk_image Изображение личного кабинета
 * @property string $site_screenshots Скрины сайта (не более 3-х)
 * @property string $integrations Интеграции
 * @property string $link Ссылка на кейс
 * @property string $date Дата создания
 */
class DevCases extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dev_cases';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['logo', 'name', 'description_works', 'fone_img', 'client', 'services', 'site', 'project_objective', 'results', 'done_big_image', 'done_description', 'done_small_image', 'done_small_image_description', 'site_screenshots', 'integrations', 'link', 'tags', 'sphere'], 'required'],
            [['services', 'project_objective', 'results', 'done_description', 'functionality_lk_text', 'site_screenshots', 'integrations', 'tags', 'sphere'], 'string'],
            [['date'], 'safe'],
            [['logo', 'name', 'fone_img', 'client', 'site', 'done_big_image', 'done_small_image', 'done_small_image_description', 'functionality_lk_image', 'link', 'tags', 'sphere'], 'string', 'max' => 255],
            [['description_works'], 'string', 'max' => 511],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'logo' => 'Логотип компании',
            'name' => 'Название компании',
            'description_works' => 'Описание проделанной работы',
            'fone_img' => 'Фоновое изображение',
            'client' => 'Клиент',
            'services' => 'Услуги',
            'tags' => 'Теги (Через запятую)',
            'sphere' => 'Сфера деятельности',
            'site' => 'Адресс сайта',
            'project_objective' => 'Задача проекта',
            'results' => 'Результаты в бизнес-показателях',
            'done_big_image' => 'Что сделано Большое изображение',
            'done_description' => 'Что сделано Описание',
            'done_small_image' => 'Что сделано Дополнительное изображение',
            'done_small_image_description' => 'Подпись к дополнительному изображению',
            'functionality_lk_text' => 'Функционал личного кабинета',
            'functionality_lk_image' => 'Изображение личного кабинета',
            'site_screenshots' => 'Скрины сайта (не более 3-х)',
            'integrations' => 'Интеграции',
            'link' => 'Ссылка на кейс',
            'date' => 'Дата создания',
        ];
    }
}
