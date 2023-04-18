<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\ProvidersUtmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Метки поставщиков';
$this->params['breadcrumbs'][] = [
    'label' => "LEAD.FORCE",
    'url' => Url::to(['main/index']),
];
$this->params['breadcrumbs'][] = [
    'label' => "Офферы",
    'url' => Url::to(['main/offers']),
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="providers-utms-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить метку', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'provider_id',
            'date',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
