<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => '79188916604']) ?>

    <?= $form->field($model, 'au_name')->textInput(['maxlength' => true, 'placeholder' => 'Василий Артин']) ?>

    <?php if(empty($model->id)): ?>
        <?= $form->field($model, 'password')->input('password', ['placeholder' => 'Укажите новый пароль']) ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
