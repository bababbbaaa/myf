<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SkillTrainingsBlocksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Блоки';
$this->params['breadcrumbs'][] = ['label' => "Skill.Force", 'url' => '/skill-force/main/index'];
$this->params['breadcrumbs'][] = ['label' => "Конструктор курсов", 'url' => '/skill-force/main/constructor'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-trainings-blocks-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить блок', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'block_link',
            'sort_order',
            'training_id',
            //'small_description',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
