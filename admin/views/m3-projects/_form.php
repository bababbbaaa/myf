<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\M3Projects */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="m3-projects-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'date_start')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd 12:00:00',
        'options' => ['placeholder' => date("Y-m-d 12:00:00"), 'class' => 'form-control', 'autocomplete' => 'off']
    ]) ?>

    <?= $form->field($model, 'date_end')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd 12:00:00',
        'options' => ['placeholder' => date("Y-m-d 12:00:00", time() + 3600 * 24 * 30), 'class' => 'form-control', 'autocomplete' => 'off']
    ]) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Разработка СРМ на Laravel']) ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true, 'placeholder' => 'Биржа']) ?>

    <?= $form->field($model, 'responsible')->dropDownList(['Владислав' => 'Владислав', 'Игорь' => 'Игорь']) ?>

    <?= $form->field($model, 'specs_link')->textInput(['maxlength' => true, 'placeholder' => 'https://docs.google.com/']) ?>

    <?= $form->field($model, 'price')->input('number', ['placeholder' => '1500000']) ?>

    <?= $form->field($model, 'status')->dropDownList(['согласование' => 'согласование', 'в работе' => 'в работе', 'завершен' => 'завершен' , 'отмена' => 'отмена' ]) ?>

    <?= $form->field($model, 'payment_type')->dropDownList(['ИП' => 'ИП', 'Перевод' => 'Перевод' ]) ?>

    <?= $form->field($model, 'money_paid')->input('number', ['placeholder' => '75000', 'min' => 0]) ?>

    <?= $form->field($model, 'money_got')->dropDownList([0 => 'нет', 1 => 'да']) ?>



    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
