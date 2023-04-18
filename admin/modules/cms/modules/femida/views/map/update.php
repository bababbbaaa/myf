<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Map */

$this->title = 'Обновить: ' . $model->partner_name;
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'FEMIDA.FORCE', 'url' => ['/cms/femida/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Партнеры по регионам', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->partner_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="map-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
