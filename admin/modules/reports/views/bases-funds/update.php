<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model admin\models\BasesFunds */

$this->title = 'Обновить: ' . $model->id;
$this->params['breadcrumbs'][] = ['url' => \yii\helpers\Url::to(['/reports/main/index']), 'label' => 'Статистика'];
$this->params['breadcrumbs'][] = ['label' => 'Расходы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="bases-funds-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
