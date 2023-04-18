<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Systemd */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="systemd-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'interval-leads']) ?>

    <?= $form->field($model, 'service_description')->textInput(['maxlength' => true, 'placeholder' => 'Демон интервальной отгрузки лидов']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
