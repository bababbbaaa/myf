<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SkillTrainingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Курсы';
$this->params['breadcrumbs'][] = ['label' => "Skill.Force", 'url' => '/skill-force/main/index'];
$this->params['breadcrumbs'][] = ['label' => "Конструктор курсов", 'url' => '/skill-force/main/constructor'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-trainings-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить курс', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'link',
            'type',
            'discount',
            //'author_id',
            //'tags',
            //'preview_logo',
            //'content_subtitle',
            //'content_about:ntext',
            //'content_block_income',
            //'content_block_description',
            //'content_block_tags',
            //'content_for_who:ntext',
            //'content_what_study:ntext',
            //'category_id',
            //'content_terms',
            //'price',
            //'discount_expiration_date',
            //'date',
            //'date_meetup',
            //'lessons_count',
            //'study_hours',
            //'exist_videos',
            //'exist_bonuses',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
