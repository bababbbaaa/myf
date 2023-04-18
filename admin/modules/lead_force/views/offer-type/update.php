<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\LeadTypes */

$this->title = 'Обновить: ' . $model->name;
$this->params['breadcrumbs'] = [
    [
        'label' => "LEAD.FORCE",
        'url' => Url::to(['main/index']),
    ],
    [
        'label' => "Офферы",
        'url' => Url::to(['main/offers']),
    ],
    [
        'label' => "Офферы Lead.Force",
        'url' => Url::to(['offer-type/index']),
    ],
];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="lead-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
