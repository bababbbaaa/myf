<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model admin\models\Bases */
/* @var $form yii\widgets\ActiveForm */


$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$js = <<<JS
$('.chosen-select').chosen()
JS;

$this->registerJs($js);

if (!$model->date_create) $model->date_create = date('Y-m-d');

$provs = \admin\models\Bases::find()->groupBy('provider')->select(['provider'])->asArray()->all();
?>

<div class="bases-form">

    <?php if(!empty($provs)): ?>
        <datalist id="provs">
            <?php foreach($provs as $item): ?>
                <option value="<?= $item['provider'] ?>"><?= $item['provider'] ?></option>
            <?php endforeach; ?>
        </datalist>
    <?php endif; ?>

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'МСК от 12.10']) ?>

    <?= $form->field($model, 'category')->dropDownList($model::cats(), ['class' => 'chosen-select form-control']) ?>

    <?= $form->field($model, 'geo')->dropDownList($model::multiselect_region(), ['class' => 'chosen-select form-control']) ?>

    <?= $form->field($model, 'provider')->textInput(['list' => 'provs', 'placeholder' => 'Вася']) ?>

    <?= $form->field($model, 'date_create')->widget(\yii\jui\DatePicker::classname(), [
        //'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control', 'placeholder' => '2021-01-01']
    ]) ?>

    <?= $form->field($model, 'is_new')->checkbox(['checked' => !empty($model) && $model->is_new === 1 ]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
