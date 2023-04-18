<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DevPaymentsAliasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dev-payments-alias-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'project_id') ?>

    <?= $form->field($model, 'summ') ?>

    <?= $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'when_pay') ?>

    <?php // echo $form->field($model, 'date_pay') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
