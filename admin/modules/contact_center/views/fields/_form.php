<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CcFields */
/* @var $form yii\widgets\ActiveForm */

$types = \common\models\LeadsCategory::find()->asArray()->all();
$arr = [];

foreach ($types as $item)
    $arr[$item['link_name']] = $item['name'];

if (!empty($model->params))
    $params = $model->params;
else
    $params = '[]';

$js = <<<JS
var obj = $params;
console.log(obj);
renderElems();
$('.addElemBtn').on('click', function() {
    var val = $('#addElem').val();
    if (val.length > 0 && obj.indexOf(val) === -1) {
        obj.push(val);
        renderElems();
    }
});
function renderElems() {
  var html = "";
  for (var i = 0; i < obj.length; i++) {
      html += "<div class='elem-block' data-id='"+ i +"'>"+ obj[i] +"</div>";
  }
  $('.elements').html(html);
  $('#ccfields-params').text(JSON.stringify(obj));
}
$('.elements').on('click', '.elem-block', function() {
    obj.splice($(this).attr('data-id'), 1);
    renderElems();
});
$('#ccfields-type').on('input', function() {
    var val = $(this).val(),
        block  = $('.field-type-array');
    if (val === 'array') {
        block.show();
    } else
        block.hide();
});
JS;

$this->registerJs($js);

?>

<style>
    .elements {
        display: flex;
        flex-wrap: wrap;
    }
    .elements > div {
        padding: 7px 14px;
        background-color: gainsboro;
        text-align: center;
        cursor: pointer;
        border-radius: 6px;
        margin: 20px 10px 0 0;
    }
</style>

<div class="cc-fields-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Комментарий']) ?>

    <?= $form->field($model, 'type')->dropDownList(['text' => 'Текстовое', 'number' => 'Числовое', 'date' => 'Выбор времени и даты', 'array' => 'Списковое', ]) ?>

    <?= $form->field($model, 'lead_type')->dropDownList($arr) ?>

    <div class="field-type-array" style="margin-bottom: 15px; display: <?= !empty($model->type) && $model->type === 'array' ? 'block' : 'none' ?>">
        <p><b>Добавить элемент списка</b></p>
        <div style="display: flex; flex-wrap: wrap">
            <div style="margin-right: 10px; max-width: 300px; width: 100%;">
                <input id="addElem" placeholder="Хочет банкротство" type="text" class="form-control">
            </div>
            <div>
                <div class="btn btn-admin-help addElemBtn" style="padding: 6px 22px">Добавить</div>
            </div>
        </div>
        <div class="elements">

        </div>
    </div>

    <div style="display: none">
        <?= $form->field($model, 'params')->textarea(['rows' => 6]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
