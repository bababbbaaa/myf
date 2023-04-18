<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\M3Projects */
$this->title = 'Добавить проект';
$this->params['breadcrumbs'][] = ['label' => 'Проекты M3', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="m3-projects-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
