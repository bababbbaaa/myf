<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model admin\models\ProvidersUtms */

$this->title = $model->name;
$this->params['breadcrumbs'][] = [
    'label' => "LEAD.FORCE",
    'url' => Url::to(['main/index']),
];
$this->params['breadcrumbs'][] = [
    'label' => "Офферы",
    'url' => Url::to(['main/offers']),
];
$this->params['breadcrumbs'][] = ['label' => 'Метки поставщиков', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="providers-utms-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
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
            'name',
            'provider_id',
            'date',
        ],
    ]) ?>

</div>
