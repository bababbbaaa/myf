<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DevPaymentsAliasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Графики оплат';
$this->params['breadcrumbs'][] = ['label' => "Dev.Force", 'url' => '/dev-force/main/index'];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dev-payments-alias-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить оплату', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'project_id',
            'summ',
            'status',
            //'when_pay',
            //'date_pay',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
