<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LeadsCategory */
/* @var $form yii\widgets\ActiveForm */

$js = <<<JS
var jsonInp = $('#paramsText'),
    paramsDiv = $('#paramsDivFlex'),
    gl = JSON.parse(jsonInp.text());
function renderParams(obj) {
    var html = '';
    for (var i = 0; i < obj.length; i++) {
        html += "<div style='margin-right:5px; background-color: #303030; color:#fafafa; position:relative; padding: 2px 10px; border-radius: 3px;'>";
            html += obj[i].name + " - " + obj[i].description;
        html += " <sup class='removeParam' data-remove='"+ i +"' style=' position: absolute; right: 2px; top: 5px; cursor:pointer;'>&#215;</sup></div>";
    }
    paramsDiv.html(html);
}
renderParams(gl);
$('.add-param-btn').on('click', function() {
    var paramInp = $('.paramsInp'),
        obj = [],
        name = $('input[data-name="name"]').val();
    if (jsonInp.text().length > 0)
        obj = JSON.parse(jsonInp.text());
    for (var i = 0; i < obj.length; i++) {
        if(obj[i].name !== undefined && obj[i].name === name) {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: 'Данный ключ уже установлен',
            });
            return false;
        }
    }
    obj.push({});
    paramInp.each(function() {
        if ($(this).val().length <= 0) {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: 'Необходимо заполнить все поля',
            });
            obj.pop();
            return false;
        }
        var key = $(this).attr('data-name');
        obj[obj.length - 1][key] = $(this).val();
        if ($(this)[0].tagName === 'INPUT')
            $(this).val('');
    });
    jsonInp.text(JSON.stringify(obj));
    renderParams(obj);
});
paramsDiv.on('click', '.removeParam', function() {
    var 
        removeId = parseInt($(this).attr('data-remove')),
        obj = JSON.parse(jsonInp.text());
    obj.splice(removeId, 1);
    jsonInp.text(JSON.stringify(obj));
    renderParams(obj);
});
JS;
$this->registerJs($js);

?>

<div class="leads-category-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Долги', 'id' => 'textToLink']) ?>

    <?= $form->field($model, 'link_name')->textInput(['maxlength' => true, 'placeholder' => 'dolgi', 'id' => 'linkText']) ?>

    <?= $form->field($model, 'public')->checkbox(['checked' => empty($model->public) || $model->public === 1 ? true : false, 'style' => 'vertical-align: sub; width: 18px;   height: 18px;']) ?>


    <hr>

    <h3>Параметры категории</h3>

    <div class="rbac-info">
        <b>Параметры категории</b> &ndash; это те дополнительные параметры, которые необходимо передавать при отправке лида в указанную категорию таблицы лидов из внешних источников (с сайтов и других мест).
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-md-8">
            <div><b>Ключ</b></div>
            <div><input placeholder="sum_text" type="text" class="form-control paramsInp" data-name="name" name="params[]"></div>
            <br>
            <div><b>Описание параметра</b></div>
            <div><input placeholder="Сумма долга (текст)" type="text" class="form-control paramsInp" data-name="description" name="params[]"></div>
            <br>
            <div><b>Пример для поставщика</b></div>
            <div><input placeholder="от 100 000 руб. до 500 000 руб." type="text" class="form-control paramsInp" data-name="example" name="params[]"></div>
        </div>
        <div class="col-md-4">
            <div><b>Тип</b></div>
            <div>
                <select class="form-control paramsInp" data-name="type" name="params[]">
                    <option value="string">Строка</option>
                    <option value="number">Число</option>
                </select>
            </div>
            <br>
            <div><b>Обязательность параметра</b></div>
            <div>
                <select class="form-control paramsInp" data-name="required" name="params[]">
                    <option value="0">Нет</option>
                    <option value="1">Да</option>
                </select>
            </div>
        </div>

    </div>
    <div style="margin-top: 20px">
        <div class="btn btn-admin-help add-param-btn">
            Добавить параметр
        </div>
    </div>
    <div style="margin-top: 20px;">
        <p><b>Праметры:</b></p>
        <div id="paramsDivFlex" style="display: flex">

        </div>
    </div>

    <hr>

    <div style="display: none">
        <?= $form->field($model, 'params')->textarea(['id' => 'paramsText', 'style' => 'display:none', 'value' => empty($model->params) ? '[]' : $model->params]) ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
