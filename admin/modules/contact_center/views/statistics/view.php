<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CcLeads */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['main/index']),
    'label' => 'КЦ'
];
$this->params['breadcrumbs'][] = ['label' => 'Статистика', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cc-leads-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p style="display:none;"> 
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-admin']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-admin-delete',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'source',
            'utm_source',
            'date_income',
            'date_outcome',
            'status_temp',
            'status',
            'name',
            'phone',
            'region',
            'city',
            'category',
            'params:ntext',
            'assigned_to',
            'info:ntext',
        ],
    ]) ?>

</div>
