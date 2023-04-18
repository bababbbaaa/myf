<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "skill_trainings".
 *
 * @property int $id ID
 * @property string $name Название курса
 * @property string $link Ссылка на курс
 * @property string $type Тип
 * @property int $discount Скидка
 * @property int|null $user_id ID пользователя
 * @property int $author_id Автор
 * @property string|null $teacher_id ID преподавателей
 * @property string $partner_link Партнер
 * @property string|null $tags Теги
 * @property string $preview_logo Превью лого
 * @property string|null $free_lessons Бесплатный урок
 * @property string|null $material Материалы
 * @property string|null $content_subtitle Подзаголовок
 * @property string $content_about О курсе
 * @property string|null $content_block_income Доход профессии
 * @property string|null $content_block_description Описание профессии
 * @property string|null $content_block_tags Теги поиска
 * @property string|null $content_for_who Для кого
 * @property string|null $content_what_study Что изучаем
 * @property int $category_id Категория
 * @property string $content_terms Условия обучения
 * @property float $price Цена
 * @property int $students Количество учеников
 * @property string $student_level Количество учеников
 * @property string|null $discount_expiration_date Дата окончания скидки
 * @property string $date Дата создания
 * @property string|null $date_meetup Дата начала
 * @property string|null $date_end Дата окончания
 * @property int $lessons_count Количество уроков
 * @property int $study_hours Количество часов
 * @property int $exist_videos Есть видео-материал
 * @property int $exist_bonuses Есть бонусы
 * @property string $meta_description МЕТА-описание
 * @property string $meta_keywords МЕТА-ключи
 * @property string|null $og_image OG-картинка
 * @property string|null $og_title OG-заголовок
 * @property string|null $og_description OG-описание
 * @property int $active Активность
 *
 * @property SkillReviewsAboutTraining[] $skillReviewsAboutTrainings
 * @property SkillTrainingsCategory $category
 * @property SkillTrainingsAuthors $author
 * @property SkillPartners $partnerLink
 * @property SkillTrainingsBlocks[] $skillTrainingsBlocks
 * @property SkillTrainingsLessons[] $skillTrainingsLessons
 * @property SkillTrainingsTests[] $skillTrainingsTests
 * @property SkillTrainingsTasks[] $skillTrainingsTasks
 * @property SkillTrainingsTeachers[] $skillTrainingsTeachers
 */
class SkillTrainings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'skill_trainings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'link', 'type', 'author_id', 'preview_logo', 'content_about', 'category_id', 'content_terms', 'price', 'lessons_count', 'study_hours', 'meta_description', 'meta_keywords', 'student_level'], 'required'],
            [['discount', 'author_id', 'user_id', 'students', 'category_id', 'lessons_count', 'study_hours', 'exist_videos', 'exist_bonuses', 'active'], 'integer'],
            [['content_about', 'content_for_who', 'content_what_study', 'student_level', 'teacher_id', 'free_lessons', 'material', 'date_end'], 'string'],
            [['price'], 'number'],
            [['students'], 'default', 'value' => '0'],
            [['discount'], 'default', 'value' => '0'],
            [['active'], 'default', 'value' => '1'],
            [['discount_expiration_date', 'date', 'date_meetup', 'date_end'], 'safe'],
            [['name', 'link', 'type', 'partner_link', 'preview_logo', 'content_subtitle', 'content_block_income', 'content_block_description', 'content_block_tags', 'content_terms', 'meta_description', 'meta_keywords', 'og_image', 'og_title', 'og_description', 'teacher_id'], 'string', 'max' => 255],
            [['tags'], 'string', 'max' => 512],
            [['link'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => SkillTrainingsCategory::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => SkillTrainingsAuthors::className(), 'targetAttribute' => ['author_id' => 'id']],
            //[['partner_link'], 'exist', 'skipOnError' => true, 'targetClass' => SkillPartners::className(), 'targetAttribute' => ['partner_link' => 'link']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название курса',
            'link' => 'Ссылка на курс',
            'type' => 'Тип',
            'discount' => 'Скидка',
            'students' => 'Прошло курс',
            'user_id' => 'ID пользователя',
            'author_id' => 'Автор',
            'teacher_id' => 'Преподаватели',
            'partner_link' => 'Партнер',
            'tags' => 'Теги',
            'preview_logo' => 'Превью лого',
            'free_lessons' => 'Бесплатный урок (не обязательно)',
            'material' => 'Материалы (не обязательно)',
            'content_subtitle' => 'Подзаголовок',
            'content_about' => 'О курсе',
            'content_block_income' => 'Доход профессии',
            'content_block_description' => 'Описание профессии',
            'content_block_tags' => 'Теги поиска',
            'content_for_who' => 'Для кого',
            'content_what_study' => 'Что изучаем',
            'category_id' => 'Категория',
            'content_terms' => 'Условия обучения',
            'student_level' => 'Сложность обучения',
            'price' => 'Цена',
            'discount_expiration_date' => 'Дата окончания скидки',
            'date' => 'Дата создания',
            'date_meetup' => 'Дата начала',
            'date_end' => 'Дата окончания',
            'lessons_count' => 'Количество уроков',
            'study_hours' => 'Количество часов',
            'exist_videos' => 'Есть видео-материал',
            'exist_bonuses' => 'Есть бонусы',
            'meta_description' => 'МЕТА-описание',
            'meta_keywords' => 'МЕТА-ключи',
            'og_image' => 'OG-картинка',
            'og_title' => 'OG-заголовок',
            'og_description' => 'OG-описание',
            'active' => 'Активность',
        ];
    }

    /**
     * Gets query for [[SkillReviewsAboutTrainings]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkillReviewsAboutTrainings()
    {
        return $this->hasMany(SkillReviewsAboutTraining::className(), ['training_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(SkillTrainingsCategory::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Author]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(SkillTrainingsAuthors::className(), ['id' => 'author_id']);
    }

    /**
     * Gets query for [[PartnerLink]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPartnerLink()
    {
        return $this->hasOne(SkillPartners::className(), ['link' => 'partner_link']);
    }

    /**
     * Gets query for [[SkillTrainingsBlocks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkillTrainingsBlocks()
    {
        return $this->hasMany(SkillTrainingsBlocks::className(), ['training_id' => 'id'])->orderBy('sort_order');
    }

    /**
     * Gets query for [[SkillTrainingsLessons]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkillTrainingsLessons()
    {
        return $this->hasMany(SkillTrainingsLessons::className(), ['training_id' => 'id'])->orderBy('sort_order')->asArray();
    }
    /**
     * Gets query for [[SkillTrainingsTests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkillTrainingsTests()
    {
        return $this->hasMany(SkillTrainingsTests::className(), ['training_id' => 'id'])->orderBy('sort_order')->asArray();
    }
    /**
     * Gets query for [[SkillTrainingsTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkillTrainingsTasks()
    {
        return $this->hasMany(SkillTrainingsTasks::className(), ['training_id' => 'id'])->orderBy('sort_order')->asArray();
    }

    /**
     * Gets query for [[SkillTrainingsTeachers]].
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getSkillTrainingsTeachers()
    {
        $id = json_decode($this->teacher_id, 1);
        return !empty($id) ? SkillTrainingsTeachers::find()->asArray()->where(['in', 'id', $id])->all() : null;
    }
}
