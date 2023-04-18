<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\M3Projects */

$this->title = 'Обновить проект: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Проекты M3', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="m3-projects-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
