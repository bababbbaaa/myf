<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UserModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-model-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(empty($model->id)): ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'placeholder' => '79188916604']) ?>

        <?= $form->field($model, 'password')->input('password', ['placeholder' => 'Укажите новый пароль']) ?>

        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'some@mail.com']) ?>
    <?php endif; ?>

    <?= $form->field($model, 'inner_name')->textInput(['maxlength' => true, 'placeholder' => 'Владимир Ленский']) ?>

    <?= $form->field($model, 'cc_daily_max')->input('number', ['placeholder' => 10]) ?>

    <?= $form->field($model, 'cc_daily_get')->input('number', ['placeholder' => 0]) ?>

    <?= $form->field($model, 'cc_status')->dropDownList([0 => 'не работает', 1 => 'работает']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
