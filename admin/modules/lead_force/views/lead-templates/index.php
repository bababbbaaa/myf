<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LeadTemplatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Шаблоны заказов';
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lead-templates-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить шаблон', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'name',
            #'image',
            'category',
            #'category_link',
            'regions:ntext',
            'price',
            //'description:ntext',
            //'advantages:ntext',
            //'params:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
