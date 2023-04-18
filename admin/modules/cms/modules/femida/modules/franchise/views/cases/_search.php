<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\FranchiseCasesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="franchise-cases-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'franchise_id') ?>

    <?= $form->field($model, 'date') ?>

    <?= $form->field($model, 'is_active') ?>

    <?= $form->field($model, 'img') ?>

    <?php // echo $form->field($model, 'name') ?>

    <?php // echo $form->field($model, 'whois') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'investments') ?>

    <?php // echo $form->field($model, 'feedback') ?>

    <?php // echo $form->field($model, 'income_approx') ?>

    <?php // echo $form->field($model, 'offices') ?>

    <?php // echo $form->field($model, 'video') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
