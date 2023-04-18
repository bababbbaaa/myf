<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LeadsParams */
/* @var $form yii\widgets\ActiveForm */

$categories = \common\models\LeadsCategory::find()->select(['link_name', 'name'])->all();
$arr = [];
foreach ($categories as $c)
    $arr[$c->link_name] = $c->name;

if (empty($model->cc_vars))
    $obj = '[]';
else
    $obj = $model->cc_vars;

$js = <<<JS
var Objcc = $obj;
$('.add-cc-btn').on('click', function(e) {
    var val = $('.add-cc-inp').val();
    if (val.length > 0 && Objcc.indexOf(val) === -1) {
        Objcc.push(val);
        renderElems();
    }
});
function renderElems() {
  var html = "";
  for (var i = 0; i < Objcc.length; i++) {
      html += "<div class='elem-block' data-id='"+ i +"'>"+ Objcc[i] +"</div>";
  }
  $('.vars-cc').html(html);
  $('#leadsparams-cc_vars').val(JSON.stringify(Objcc));
}
$('.vars-cc').on('click', '.elem-block', function() {
    Objcc.splice($(this).attr('data-id'), 1);
    renderElems();
});
renderElems();
JS;
$this->registerJs($js);

?>
<style>
    .elem-block {
        background-color: #fafafa;
        border: 1px solid gainsboro;
        padding: 5px 10px;
        border-radius: 10px;
        margin-right: 5px;
        margin-bottom: 5px;
        cursor: pointer;
    }
    .vars-cc {
        display: flex; flex-wrap: wrap;
    }
</style>
<div class="leads-params-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category')->dropDownList($arr) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'ipoteka']) ?>

    <?= $form->field($model, 'type')->dropDownList(['string' => 'Строка', 'number' => 'Число', ]) ?>

    <?= $form->field($model, 'filter_type')->dropDownList(['=' => 'Равенство', 'like' => 'Подобие', '>=' => 'От указанного значения', ]) ?>

    <?= $form->field($model, 'comparison_type')->dropDownList(['notNull' => "Не пустой", 'interval' => 'Интервал', 'equals' => 'Точное соответствие' ]) ?>

    <div class="row">
        <div class="col-md-8"><?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Наличие ипотеки']) ?></div>
        <div class="col-md-4"><?= $form->field($model, 'provider_example')->textInput(['maxlength' => true, 'placeholder' => 'Да']) ?></div>
    </div>

    <?= $form->field($model, 'required')->checkbox(['checked' => $model->required === 1 ? true : false, 'style' => 'vertical-align: sub; width: 18px;   height: 18px;']) ?>

    <hr>
    <h4>Если нужны конкретные варианты выбора параметра для КЦ</h4>
    <div style="display: flex; flex-wrap: wrap">
        <div style="margin-right: 5px; margin-bottom: 5px"><input type="text" class="form-control add-cc-inp" placeholder="да"></div>
        <div style="margin-right: 5px; margin-bottom: 5px"><div class="btn btn-admin-help add-cc-btn">добавить</div></div>
    </div>
    <div style="margin-top: 10px;" class="vars-cc"></div>
    <hr>

    <div style="display: none">
        <?= $form->field($model, 'cc_vars')->textInput(['readonly' => true]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
