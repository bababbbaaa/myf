<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DevCasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Завершенные кейсы';
$this->params['breadcrumbs'][] = ['label' => "Dev.Force", 'url' => '/dev-force/main/index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dev-cases-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить кейс', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'logo',
            'name',
            'description_works',
            'fone_img',
            //'client',
            //'services:ntext',
            //'site',
            //'project_objective:ntext',
            //'results:ntext',
            //'done_big_image',
            //'done_description:ntext',
            //'done_small_image',
            //'done_small_image_description',
            //'functionality_lk_text:ntext',
            //'functionality_lk_image',
            //'site_screenshots:ntext',
            //'integrations:ntext',
            //'link',
            //'date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
