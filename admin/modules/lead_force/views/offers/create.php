<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Offers */

$this->title = 'Добавить оффер';
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
        'label' => "Принятые офферы",
        'url' => Url::to(['offers/index']),
    ],
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="offers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
