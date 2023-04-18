<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\JobsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="jobs-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'position') ?>

    <?= $form->field($model, 'payment') ?>

    <?= $form->field($model, 'company_name') ?>

    <?= $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'type_employment') ?>

    <?php // echo $form->field($model, 'work_format') ?>

    <?php // echo $form->field($model, 'duties') ?>

    <?php // echo $form->field($model, 'requirements') ?>

    <?php // echo $form->field($model, 'working_conditions') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
