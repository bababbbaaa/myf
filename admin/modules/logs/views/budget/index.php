<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BudgetLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Логи баланса';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/logs/main/index']),
    'label' => 'ЛОГИ'
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="budget-log-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'date',
            'text',
            'user_id',
            'budget_was',
            ['class' => 'yii\grid\ActionColumn', 'template' => "{view}"],
        ],
    ]); ?>


</div>
