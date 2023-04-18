<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model admin\models\ProvidersUtms */

$this->title = 'Обновить метку: ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => "LEAD.FORCE",
    'url' => Url::to(['main/index']),
];
$this->params['breadcrumbs'][] = [
    'label' => "Офферы",
    'url' => Url::to(['main/offers']),
];
$this->params['breadcrumbs'][] = ['label' => 'Метки поставщиков', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="providers-utms-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
