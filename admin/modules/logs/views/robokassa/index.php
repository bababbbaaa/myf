<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RobokassaResultSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логи робокассы';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/logs/main/index']),
    'label' => 'ЛОГИ'
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="robokassa-result-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'user_id',
            #'entity',
            #'entity_id',
            #'crc',
            'status',
            'summ',
            'inv',
            'description',
            //'date',

            ['class' => 'yii\grid\ActionColumn', 'template' => "{view}"],
        ],
    ]); ?>


</div>
