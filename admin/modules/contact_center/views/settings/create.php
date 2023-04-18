<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\UserModel */

$this->title = 'Добавить оператора КЦ';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['main/index']),
    'label' => 'КЦ'
];
$this->params['breadcrumbs'][] = ['label' => 'Настройки операторов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
