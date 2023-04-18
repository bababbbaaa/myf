<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CdbCategory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cdb-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'id' => 'textToLink', 'placeholder' => 'Нормативные акты регулирующие банкротство физических лиц']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'placeholder' => 'Основные нормативные акты, законы, разъяснения, участвующие в процессе регламентирования процедуры Банкротства физического лица в рамках настройки БИЗНЕС-ПРОЦЕССА исполнения услуг и организации продаж Банкротства гражданам.']) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'placeholder' => 'normativnye-akty-reguliruushchie-bankrotstvo-fizicheskih-lic', 'id' => 'linkText']) ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
        'language'      => 'ru',
        'dateFormat'    => 'yyyy-MM-dd',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Дата создания'],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
