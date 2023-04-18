<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LeadsSources */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="leads-sources-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'спишемдолг.рф']) ?>

    <?= $form->field($model, 'sendpulse_book')->textInput(['maxlength' => true, 'placeholder' => '9087621395 или оставить пустым']) ?>

    <?= $form->field($model, 'cc')->checkbox(['checked' => empty($model->cc) ? false : true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
