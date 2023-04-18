<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SkillReviewsAboutTrainingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы о курсе';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => '/cms/'];
$this->params['breadcrumbs'][] = ['label' => 'SKILL.FORCE', 'url' => ['/cms/skill/']];
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['/cms/skill/main/reviews']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-reviews-about-training-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить отзыв о курсе', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'training_id',
            'name',
            'grade',
            'content:ntext',
            //'date',
            //'photo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
