<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SkillReviewsProfessionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отзывы о профессиях';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => '/cms/'];
$this->params['breadcrumbs'][] = ['label' => 'SKILL.FORCE', 'url' => ['/cms/skill/']];
$this->params['breadcrumbs'][] = ['label' => 'Отзывы', 'url' => ['/cms/skill/main/reviews']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-reviews-profession-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить отзыв', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'whois',
            'content:ntext',
            'date',
            //'photo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
