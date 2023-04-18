<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\CustomParams;
use common\models\LeadsSources;

/* @var $this yii\web\View */
/* @var $model common\models\Clients */
/* @var $form yii\widgets\ActiveForm */

$params = CustomParams::find()->where(['OR', ['entity' => \common\models\Clients::tableName()], ['entity' => 'any']])->all();
$getnames = [];
foreach ($params as $name)
    $getnames[$name->name] = $name->description;
$jsonGetNames = json_encode($getnames, JSON_UNESCAPED_UNICODE);
$sources = LeadsSources::find()->all();
$existModel = !empty($model->custom_params) ? $model->custom_params : "{}";
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
$('form').on('keydown', function(event) {
  if (event.key === "Enter") {
        event.preventDefault();
    }
});
var 
    parsedNames = $jsonGetNames;
$(".chosen-select").chosen({disable_search_threshold: 0});

var 
    bufferArrayParam = [],
    paramSelector = $('.get-select-param'),
    arrayPlacer = $('.arrayPlacement'),
    paramsPlacer = $('.params-block'),
    addParam = $('.addParam'),
    params = $existModel;
renderParamsBlock();
paramSelector.on('input', function() {
    var 
        option = $('option:selected', this),
        param = option.val(),
        type = option.attr('data-type'),
        input = option.attr('data-input');
    bufferArrayParam = [];
    $('.showBlock').hide();
    if (input.length > 0) {
        $("." + input + "-block").show();
    } else {
        $("." + type + "-block").show();
    }
});
function renderArrayPlacer() {
    var html = '';
    arrayPlacer.html(html);
    for (var i = 0; i < bufferArrayParam.length; i++) {
        html += "<div class='destroy-array-elem' data-destroy='" + i + "'>";
            html += bufferArrayParam[i];
        html += "</div>";
    }
    arrayPlacer.html(html);
}
function renderParamsBlock() {
    var 
        html = '',
        h4 = $('h4');
    paramsPlacer.html(html);
    for (var key in params) {
        if(params[key] instanceof Array) {
            html += "<div class='destroy-param-elem' data-destroy='" + key + "'>";
                html += "<b>" + parsedNames[key] + "</b>: ";
                var len = params[key].length;
                for (var j = 0; j < len; j++) {
                    var dot = j === len - 1 ? "" : ", ";
                    html += params[key][j] + dot;
                }
            html += "</div>";
        } else {
            html += "<div class='destroy-param-elem' data-destroy='" + key + "'>";
                html += "<b>" + parsedNames[key] + "</b>: " + params[key];
            html += "</div>";
        }
    }
    paramsPlacer.html(html);
    if(html.length > 0)
        h4.show();
    else
        h4.hide();
    $('.object-params').text(JSON.stringify(params));
}
$('.arrayParamAdd').on('click', function(e) {
    e.preventDefault();
    var 
        type = $(this).attr('data-type'),
        inp = null;
    if (type === 'region') {
        inp = $('.inputRegionArray');
    } else if(type === 'source') {
        inp = $('.inputSourceArray');
    } else if(type === 'multi_days') {
        inp = $('.inputMulti_daysArray');
    } else {
        inp = $('.inputArray');
    }
    if(inp.val().length > 0 && bufferArrayParam.indexOf(inp.val()) === -1) {
        if (type === 'multi_days') {
            bufferArrayParam = inp.val(); 
        } else
            bufferArrayParam.push(inp.val());
    }
    renderArrayPlacer();
});
paramsPlacer.on('click', '.destroy-param-elem', function() {
    var
        index = $(this).attr('data-destroy');
    delete params[index];
    renderParamsBlock();
});
arrayPlacer.on('click', '.destroy-array-elem', function() {
    var
        index = $(this).attr('data-destroy');
    bufferArrayParam.splice(index, 1);
    bufferArrayParam.sort();
    renderArrayPlacer();
});
addParam.on('click', function() {
    var 
        option = $('option:selected', paramSelector),
        type = option.attr('data-type'),
        param = option.val(),
        paramInp = $('.' + type + "-block").children().first();
    if (type === 'array') {
        if (bufferArrayParam.length > 0)
            params[param] = bufferArrayParam;
    } else if(type === 'boolean') {
        if(paramInp.prop('checked'))
            params[param] = "да";
        else {
            if (params[param] !== undefined)
                delete params[param];
        }
    } else  {
        if(paramInp.val().length > 0) 
           params[param] = type === 'int' ? parseInt(paramInp.val()) : paramInp.val();
    }
    bufferArrayParam = [];
    renderArrayPlacer();
    renderParamsBlock();
});
JS;
$this->registerJsFile(Url::to(['/js/getRegionAjax.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);

$sellers = \common\models\AuthAssignment::find()->where(['item_name' => 'seller'])->asArray()->all();
$data = [
    null => 'без менеджера',
];
if (!empty($sellers)) {
    $k = \yii\helpers\ArrayHelper::getColumn($sellers, 'user_id');
    $users = \common\models\User::find()->where(['id' => $k, 'status' => 10])->orderBy('id desc')->asArray()->select(['id', 'username'])->all();
    if (!empty($users))
        $k = \yii\helpers\ArrayHelper::map($users, 'id', 'username');
    else
        $k = [];
} else
    $k = [];
$data += $k;
?>

<style>
    .chosen-single {
        border-radius: 0 !important;
    }
</style>

<div class="clients-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'f')->textInput(['maxlength' => true, 'placeholder' => 'Артин']) ?>

    <?= $form->field($model, 'i')->textInput(['maxlength' => true, 'placeholder' => 'Василий']) ?>

    <?= $form->field($model, 'o')->textInput(['maxlength' => true, 'placeholder' => 'Альбертович']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'albert@mail.zn']) ?>

    <?= $form->field($model, 'user_id')->textInput(['placeholder' => 'Указать ID, например - 15']) ?>

    <?= $form->field($model, 'attached_seller')->dropDownList($data) ?>

    <?= $form->field($model, 'commentary')->textarea(['rows' => 6, 'style' => 'resize:none;', 'placeholder' => 'Любая информация о клиенте. Данная информация видна только администрации']) ?>

    <h3><span style="color: #d9534f">Специальные параметры</span> клиента</h3>

    <?php if(!empty($params)): ?>
        <p>Выбрать параметр</p>
        <div style="display: flex; flex-wrap: wrap; margin-bottom: 20px;">
            <div style="margin: 0px 20px 10px 0; max-width: 300px; width: 100%;">
                <div>
                    <select class="chosen-select get-select-param" name="" id="">
                        <?php foreach($params as $param): ?>
                            <option data-type="<?= $param->type ?>" data-input="<?= $param->special_input ?>" value="<?= $param->name ?>"><?= $param->description ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div style="max-width: 450px; width: 100%; margin: 0 20px 0px 0;">
                <div class="showBlock region-block" >
                    <div style="display: flex; flex-wrap: wrap">
                        <div style="max-width: 280px; width: 100%; margin-right: 10px; margin-bottom: 10px;">
                            <select id="findRegionSelect" type="text" class="chosen-select form-control region-city-ajax-block inputRegionArray" >
                                <option  value="" selected disabled>Введите город или регион</option>
                            </select>
                        </div>
                        <div style="max-width: 150px; width: 100%; margin-bottom: 10px;">
                            <a href="#" class="btn btn-admin-delete arrayParamAdd" data-type="region">Добавить</a>
                        </div>
                    </div>
                </div>
                <div class="showBlock source-block" style="display: none">
                    <div style="display: flex; flex-wrap: wrap">
                        <div style="max-width: 280px; width: 100%; margin-right: 10px; margin-bottom: 10px;">
                            <select class="chosen-select get-select-source inputSourceArray" name="" id="">
                                <?php if(!empty($sources)): ?>
                                    <?php foreach($sources as $source): ?>
                                        <option value="<?= $source->name ?>"><?= $source->name ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div style="max-width: 150px; width: 100%; margin-bottom: 10px;">
                            <a href="#" class="btn btn-admin-delete arrayParamAdd" data-type="source">Добавить</a>
                        </div>
                    </div>
                </div>
                <div class="showBlock multi_days-block" style="display: none">
                    <div style="display: flex; flex-wrap: wrap">
                        <div style="max-width: 280px; width: 100%; margin-right: 10px; margin-bottom: 10px;">
                            <select data-placeholder="Укажите несколько опций" multiple class="chosen-select get-select-multi_days inputMulti_daysArray" name="" id="">
                                <option value="1">Понедельник</option>
                                <option value="2">Вторник</option>
                                <option value="3">Среда</option>
                                <option value="4">Четверг</option>
                                <option value="5">Пятница</option>
                                <option value="6">Суббота</option>
                                <option value="7">Воскресенье</option>
                            </select>
                        </div>
                        <div style="max-width: 150px; width: 100%; margin-bottom: 10px;">
                            <a href="#" class="btn btn-admin-delete arrayParamAdd" data-type="multi_days">Добавить</a>
                        </div>
                    </div>
                </div>
                <div class="showBlock array-block" style="display: none">
                    <div style="display: flex; flex-wrap: wrap">
                        <div style="max-width: 280px; width: 100%; margin-right: 10px; margin-bottom: 10px;">
                            <input type="text" class="form-control inputArray" placeholder="Введите значение">
                        </div>
                        <div style="max-width: 150px; width: 100%; margin-bottom: 10px;">
                            <a href="#" class="btn btn-admin-delete arrayParamAdd" data-type="array">Добавить</a>
                        </div>
                    </div>
                </div>
                <div class="showBlock int-block" style="display: none">
                    <input type="number" class="form-control" placeholder="Введите значение">
                </div>
                <div class="showBlock string-block" style="display: none">
                    <input type="text" class="form-control" placeholder="Введите значение">
                </div>
                <div class="showBlock boolean-block" style="display: none">
                    <input type="checkbox" style="width: 20px; height: 20px;" class="form-control">
                </div>
            </div>
        </div>
        <div style="margin-bottom: 20px; display: flex; flex-wrap: ">
            <div class="btn btn-admin-help addParam" style="margin-right: 10px">Добавить параметр</div>
            <div class="arrayPlacement" style="display: flex; flex-wrap: wrap; align-items: center"></div>
        </div>
    <?php endif; ?>

    <h4 style="display: none">Указанные параметры:</h4>
    <div class="params-block">

    </div>
    <hr style="margin-bottom: 40px;">

    <div style="display: none">
        <?= $form->field($model, 'custom_params')->textarea(['rows' => 6, 'readonly' => true, 'style' => 'resize:none', 'class' => 'form-control object-params']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <h4 style="margin: 40px 0">Справка</h4>
    <div class="rbac-info rbac-info-leads" style="max-width: unset">
        <p>Сущность "Клиент" теперь представляет из себя абстрактный класс, описывающий общие данные о заказчике, хранящий в себе совокупную информацию о всех заказах пользователя.</p>
        <p>Почты, указанные в клиенте - это почты поумолчанию для получения лидов. Если в заказах не указана почта для получения лидов - то будет использоваться почта клиента.</p>
        <p>Можно задать несколько почт через пробел, например: <code>vetal1@pravaton.com</code> <code>vetal2@pravaton.com</code> <code>vetal3@pravaton.com</code>. При этом отправка будет идти сразу на все указанные почты.</p>
        <hr>
        <p>ID пользователя указывается, если необходимо связать данного клиента с пользователем ЛК.</p>
        <p>В текущей версии <b>MYFORCE <?= Yii::$app->version ?></b> информация о клиенте - дублирует информацию из профиля ЛК - таким образом пользователь ЛК, заполняя профиль, - создает клиента, и наоборот - создав клиента и связав его с пользователем - в его профиле появится указанная информация.</p>
        <hr>
        <p>Специальные параметры у клиентов позволяют жестко обозначить определенные свойства, которые будут наследовать все заказы данного клиента.</p>
        <p><b>Внимание:</b> <code>специальные параметры заказа</code> имеют приоритет выше, чем <code>специальные параметры клиента</code>, поэтому при двух разных значениях одного и того же параметра для заказа и клиента - будет учтено значение параметра заказа.</p>
        <p>Поиск региона (города) имеет задержку равную 1000 мс, обусловленную оптимизацией поиска.</p>
    </div>

</div>
