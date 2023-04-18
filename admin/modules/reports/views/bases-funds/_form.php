<?php

use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\BasesFunds */
/* @var $form yii\widgets\ActiveForm */

$regions = \common\models\DbRegion::find()
    ->asArray()
    ->select('name_with_type')
    ->all();

$array = \yii\helpers\ArrayHelper::map($regions, 'name_with_type', 'name_with_type');
asort($array);
?>

<div class="bases-funds-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'value')->input('number', ['placeholder' => '2521.33', 'step' => '0.01']) ?>

    <?= $form->field($model, 'type')->dropDownList(['база' => 'база', 'обзвон' => 'обзвон',]) ?>

    <?= $form->field($model, 'region')->dropDownList($array) ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd 00:00:00',
        'options' => ['class' => 'form-control']
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
