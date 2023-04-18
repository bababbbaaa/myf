<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\TgMessagesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tg-messages-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'peer') ?>

    <?= $form->field($model, 'bot') ?>

    <?= $form->field($model, 'message') ?>

    <?= $form->field($model, 'is_loop') ?>

    <?php // echo $form->field($model, 'date_to_post') ?>

    <?php // echo $form->field($model, 'days_to_post') ?>

    <?php // echo $form->field($model, 'is_done') ?>

    <?php // echo $form->field($model, 'minimum_time') ?>

    <?php // echo $form->field($model, 'date_create') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
