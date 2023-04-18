<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CcFields */

$this->title = 'Добавить поле';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['main/index']),
    'label' => 'КЦ'
];
$this->params['breadcrumbs'][] = ['label' => 'Поля КЦ', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cc-fields-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
