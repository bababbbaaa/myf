<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BackdoorWebhooks */
/* @var $form yii\widgets\ActiveForm */

$leadType = \common\models\LeadsCategory::find()->asArray()->select(['name', 'link_name'])->all();

$leadArr = [];

foreach ($leadType as $item)
    $leadArr[$item['link_name']] = $item['name'];

?>

<div class="backdoor-webhooks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'url')->textInput(['maxlength' => true, 'placeholder' => 'https://femidaforce.bitrix24.ru/rest/11/ys1wjz7e146bhdqr/']) ?>

    <?= $form->field($model, 'lead_type')->dropDownList($leadArr) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
