<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RobokassaResultSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="robokassa-result-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'entity') ?>

    <?= $form->field($model, 'entity_id') ?>

    <?= $form->field($model, 'crc') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'summ') ?>

    <?php // echo $form->field($model, 'inv') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
