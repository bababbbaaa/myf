<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SkillTrainingsAuthorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Авторы';
$this->params['breadcrumbs'][] = ['label' => "Skill.Force", 'url' => '/skill-force/main/index'];
$this->params['breadcrumbs'][] = ['label' => "Конструктор курсов", 'url' => '/skill-force/main/constructor'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-trainings-authors-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить автора', ['create'], ['class' => 'btn btn-admin']) ?>
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
            'small_description',
            'photo',
            //'about:ntext',
            //'specs:ntext',
            //'video',
            //'comment_article',
            //'comment_text',
            //'date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
