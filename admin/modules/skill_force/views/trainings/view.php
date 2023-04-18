<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainings */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => "Skill.Force", 'url' => '/skill-force/main/index'];
$this->params['breadcrumbs'][] = ['label' => "Конструктор курсов", 'url' => '/skill-force/main/constructor'];
$this->params['breadcrumbs'][] = ['label' => 'Курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="skill-trainings-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-admin']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-admin-delete',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'link',
            'type',
            'discount',
            'author_id',
            'tags',
            'preview_logo',
            'content_subtitle',
            'content_about:ntext',
            'content_block_income',
            'content_block_description',
            'content_block_tags',
            'content_for_who:ntext',
            'content_what_study:ntext',
            'category_id',
            'content_terms',
            'price',
            'discount_expiration_date',
            'date',
            'date_meetup',
            'lessons_count',
            'study_hours',
            'exist_videos',
            'exist_bonuses',
        ],
    ]) ?>

</div>
