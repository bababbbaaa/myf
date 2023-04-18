<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\ProvidersUtms */
/* @var $form yii\widgets\ActiveForm */

$p = \common\models\Providers::find()->asArray()->select(['f', 'i', 'id'])->all();
$pArr = [];
if(!empty($p)) {
    foreach ($p as $item)
        $pArr[$item['id']] = "#{$item['id']} {$item['f']} {$item['i']}";
}

?>

<div class="providers-utms-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(!empty($model->name)): ?>
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'readonly' => true]) ?>
    <?php endif; ?>

    <?= $form->field($model, 'provider_id')->dropDownList($pArr) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
