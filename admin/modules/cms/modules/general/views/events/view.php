<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Events */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактор главной My.Force', 'url' => ['/cms/general/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'События', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="events-view">

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
            'link',
            'type',
            'main_page',
            'main_page_text',
            'event_date',
            'event_city',
            'preview_text',
            'date',
        ],
    ]) ?>

</div>
