<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReferalLink */

$this->title = 'Обновить реферальную ссылку: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактор главной My.Force', 'url' => ['/cms/general/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Реферальные ссылки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="referal-link-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
