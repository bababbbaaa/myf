<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\VoiceLeads */
/* @var $form yii\widgets\ActiveForm */
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$leads = \common\models\LeadsSave::find()->groupBy(['region'])->select(['region'])->asArray()->all();
$regs = \yii\helpers\ArrayHelper::map($leads, 'region', 'region');
$jss = <<<JS
$('.chosen-select').chosen({
    placeholder_text_single: "Указать регион",
    no_results_text: "Регион не найден",
});
JS;
$this->registerJs($jss);
?>

<div class="voice-leads-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'readonly' => true]) ?>

    <?= $form->field($model, 'region')->dropDownList($regs, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'sum')->dropDownList([100000 => 100000, 300000 => 300000]) ?>

    <?= $form->field($model, 'ipoteka_zalog')->dropDownList(['да' => "да", "нет" => "нет"]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
