<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\DevCases */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => "Dev.Force", 'url' => '/dev-force/main/index'];
$this->params['breadcrumbs'][] = ['label' => 'Dev.Cases', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="dev-cases-view">

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
            'logo',
            'name',
            'description_works',
            'fone_img',
            'client',
            'services:ntext',
            'site',
            'project_objective:ntext',
            'results:ntext',
            'done_big_image',
            'done_description:ntext',
            'done_small_image',
            'done_small_image_description',
            'functionality_lk_text:ntext',
            'functionality_lk_image',
            'site_screenshots:ntext',
            'integrations:ntext',
            'link',
            'date',
        ],
    ]) ?>

</div>
