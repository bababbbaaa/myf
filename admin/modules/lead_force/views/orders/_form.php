<?php

use common\models\CustomParams;
use common\models\FranchisePackage;
use common\models\LeadsSources;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */
/* @var $form yii\widgets\ActiveForm */


$clients = \common\models\Clients::find()->asArray()->select('id, f, i')->all();
$categories = \common\models\LeadsCategory::find()->asArray()->select('name, link_name')->all();
$clientArray = [];
$categoryArray = [];
foreach ($clients as $item)
    $clientArray[$item['id']] = "#{$item['id']} {$item['f']} {$item['i']}";
foreach ($categories as $item)
    $categoryArray[$item['link_name']] = $item['name'];

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$leadsParams = \common\models\LeadsParams::find()->asArray()->all();
$paramsCategory = [];
if (!empty($leadsParams)) {
    foreach ($leadsParams as $leadsParam) {
        $paramsCategory[$leadsParam['category']][] = $leadsParam;
    }
}
if (!empty($model->params_category)) {
    $paramsCategoryModel = json_decode($model->params_category, true);
}

$params = CustomParams::find()->where(['OR', ['entity' => \common\models\Orders::tableName()], ['entity' => 'any']])->all();
$getnames = [];
foreach ($params as $name)
    $getnames[$name->name] = $name->description;
$jsonGetNames = json_encode($getnames, JSON_UNESCAPED_UNICODE);
$sources = LeadsSources::find()->all();
$existModel = !empty($model->params_special) ? $model->params_special : "{}";

$package = FranchisePackage::find()->asArray()->all();
$package_arr = [];
foreach ($package as $item)
    $package_arr[$item['id']] = $item['name'];

$js = <<<JS
$('form').on('keydown', function(event) {
  if (event.key === "Enter") {
        event.preventDefault();
    }
});
var 
    parsedNames = $jsonGetNames;
parseRegions();
var 
    catInput = $('.changeCategory'),
    bufferArrayParam = [],
    paramSelector = $('.get-select-param'),
    arrayPlacer = $('.arrayPlacement'),
    paramsPlacer = $('.params-block'),
    addParam = $('.addParam'),
    params = $existModel;
$(".chosen-select").chosen({disable_search_threshold: 0});
catInput.on('input', function() {
    var text = $("option:selected", this).text();
    $('.inputNameCategory').val(text);
});
catInput.trigger('input');
function parseRegions() {
    var 
        regions = $('#orders-regions').text(),
        parsedBlock = $('.regions-parsed-block');
    if (regions.length > 0) {
        var json = JSON.parse(regions);
        var html = '';
        for (var i = 0; i < json.length; i++) {
            html += "<div class='remove-region' data-id='"+ i +"'>" + json[i] + "</div>";
        }
        parsedBlock.html(html);
    }
}
$('.addRegion').on('click', function(e) {
    e.preventDefault();
    var 
        input = $('#orders-regions'),
        text = input.text(),
        regions = text.length > 0 ? JSON.parse(text) : null,
        region = $('#findRegionSelect').val();
    if(regions === null || regions[0] === 'Любой') {
        regions = [region];
    } else {
        if(regions.indexOf(region) === -1) 
           regions.push(region);    
    }
    input.text(JSON.stringify(regions));
    parseRegions();
});
$('.regions-parsed-block').on('click', '.remove-region', function() {
    var 
        id = $(this).attr('data-id'),
        input = $('#orders-regions'),
        text = $(this).text();
    if (text !== 'Любой') {
        var 
            json = JSON.parse(input.text());
         json.splice(id, 1);
         if(json.length <= 0)
             json = ['Любой'];
         input.text(JSON.stringify(json));
         parseRegions();
    }
});
$('#orders-category_link').on('input', function() {
    var val = $(this).val();
    $('.paramsCategoryBlock ').hide();
    $('.params-' + val).show();
});
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
    } else if(type === 'lead_params') {
        inp = $('.inputLead_paramsArray');
    } else {
        inp = $('.inputArray');
    }
    if(inp.val().length > 0 && bufferArrayParam.indexOf(inp.val()) === -1) {
        if (type === 'multi_days' || type === 'lead_params') {
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
$this->registerJsFile(Url::to(['/js/getRegionAjax_orders.js']), ['depends' => \yii\web\JqueryAsset::class]);
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
    .regions-parsed-block {
        display: flex; flex-wrap: wrap;
        margin-bottom: 20px;
    }
    .regions-parsed-block div {
        margin: 0 10px 10px 0;
        border: 1px solid #dcedfc;
        border-radius: 5px;
        cursor: pointer;
        background-color: #daffff85;
        padding: 5px 10px;
    }
</style>
<div class="orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-md-8">
            <hr>
            <h3>Статические параметры заказа</h3>
            <?= $form->field($model, 'order_name')->textInput(['maxlength' => true, 'placeholder' => 'Любое название']) ?>

            <?= $form->field($model, 'client')->dropDownList($clientArray, ['class' => 'form-control chosen-select']) ?>

            <?= $form->field($model, 'attached_seller')->dropDownList($data, ['class' => 'form-control chosen-select']) ?>

            <?= $form->field($model, 'package_id')->dropDownList($package_arr, ['class' => 'form-control chosen-select']) ?>

            <?= $form->field($model, 'category_link')->dropDownList($categoryArray, ['class' => 'form-control chosen-select changeCategory']) ?>

            <div style="display: none">
                <?= $form->field($model, 'category_text')->textInput(['maxlength' => true, 'readonly' => true, 'class' => 'form-control inputNameCategory']) ?>
            </div>

            <?= $form->field($model, 'status')->dropDownList(\common\models\Orders::allowedStatuses(), ['class' => 'form-control chosen-select']) ?>

            <?= $form->field($model, 'price')->input('number', ['placeholder' => '500', 'min' => 100, 'value' => $model->price ?? 100]) ?>

            <?= $form->field($model, 'leads_count')->textInput(['placeholder' => '100',]) ?>

            <?= $form->field($model, 'emails')->textInput(['placeholder' => 'Почты, через пробел: artin@gmail.ru vasiliy@mail.com ...',]) ?>

            <?= $form->field($model, 'commentary')->textarea(['rows' => 6, 'placeholder' => 'Пользовательский комментарий', 'style' => 'resize:none']) ?>

            <?= $form->field($model, 'sale')->input('number', ['min' => 0, 'max' => 100, 'step' => 5, 'placeholder' => '10',]) ?>

            <?= $form->field($model, 'waste')->input('number', ['min' => 0, 'max' => 50, 'step' => 1, 'placeholder' => '25', 'value' => !empty($model->waste) ? $model->waste : 25]) ?>

            <?= $form->field($model, 'high_priority_order')->checkbox(['checked' => empty($model->high_priority_order) || $model->high_priority_order === 0 ? false : true]) ?>

            <hr>
            <h3>Динамические параметры заказа</h3>

            <div class="region-block" style="margin-top: 20px" >
                <div style="display: flex; flex-wrap: wrap">
                    <div style="max-width: 280px; width: 100%; margin-right: 10px; margin-bottom: 10px;">
                        <select id="findRegionSelect" type="text" class="chosen-select form-control region-city-ajax-block" >
                            <option value="" selected disabled>Введите город или регион</option>
                        </select>
                    </div>
                    <div style="max-width: 150px; width: 100%; margin-bottom: 10px;">
                        <a href="#" class="btn btn-admin-delete addRegion" data-type="region" style="padding:7px 15px" >Добавить</a>
                    </div>
                </div>
            </div>
            <p><b>Заказ по регионам</b></p>
            <div class="regions-parsed-block">

            </div>

            <div style="display: none">
                <?= $form->field($model, 'regions')->textarea(['rows' => 2, 'style' => 'resize:none', 'readonly' => true, 'value' => $model->regions ?? '["Любой"]']) ?>
            </div>

            <?php if(!empty($paramsCategory)): ?>
                <?php foreach($paramsCategory as $catname => $cat): ?>
                    <?php
                    if (empty($model->category_link)) {
                        $display = $catname === 'dolgi' ? 'display:block;' : 'display:none;';
                    } else {
                        $display = $catname === $model->category_link ? 'display:block;' : 'display:none;';
                    }
                    ?>
                    <div class="paramsCategoryBlock params-<?= $catname ?>" style="margin-bottom: 15px; <?= $display ?>">
                        <?php foreach($cat as $key => $param): ?>
                            <div style="margin-bottom: 5px;"><b><?= $param['description'] ?></b></div>
                            <?php if($param['comparison_type'] === 'interval'): ?>
                                <div style="display: flex; flex-wrap: wrap; margin-bottom: 15px;">
                                    <div style="margin-right: 20px; margin-bottom: 10px">от <input class="form-control" placeholder="0" value="<?= $paramsCategoryModel[$param['name']]['min'] ?>" type="number" min="0" name="categoryParam[<?= $catname ?>][<?= $param['name'] ?>][min]"></div>
                                    <div style="margin-bottom: 10px">до <input class="form-control" placeholder="<?= $param['provider_example'] ?>" type="number" value="<?= $paramsCategoryModel[$param['name']]['max'] ?>" min="0" name="categoryParam[<?= $catname ?>][<?= $param['name'] ?>][max]"></div>
                                </div>
                            <?php else: ?>
                                <?php if(empty($param['cc_vars'])): ?>
                                    <div style="margin-bottom: 25px;">
                                        <input type="text" class="form-control" value="<?= $paramsCategoryModel[$param['name']] ?>" placeholder="<?= $param['provider_example'] ?>" name="categoryParam[<?= $catname ?>][<?= $param['name'] ?>]">
                                    </div>
                                <?php else: ?>
                                    <div style="margin-bottom: 25px;">
                                        <?php $vars = json_decode($param['cc_vars'], 1); ?>
                                        <?php if(!empty($vars)): ?>
                                            <select name="categoryParam[<?= $catname ?>][<?= $param['name'] ?>]" class="form-control">
                                                <option <?= empty($paramsCategoryModel[$param['name']]) ? 'selected' : '' ?> value="">Указать значение</option>
                                                <?php foreach($vars as $vv): ?>
                                                    <option <?= !empty($paramsCategoryModel[$param['name']]) && $paramsCategoryModel[$param['name']] === $vv ? 'selected' : '' ?> value="<?= $vv ?>"><?= $vv ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <hr>
            <h3><span style="color: #d9534f">Специальные параметры</span> заказа</h3>

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
                                    <select id="findRegionSelect2" type="text" class="chosen-select form-control region-city-ajax-block inputRegionArray" >
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
                        <div class="showBlock lead_params-block" style="display: none">
                            <div style="display: flex; flex-wrap: wrap">
                                <div style="max-width: 280px; width: 100%; margin-right: 10px; margin-bottom: 10px;">
                                    <select data-placeholder="Укажите несколько опций" multiple class="chosen-select get-select-lead_params inputLead_paramsArray" name="" id="">
                                        <?php foreach($leadsParams as $item): ?>
                                            <option value="<?= $item['name'] ?>"><?= "{$item['description']}" ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div style="max-width: 150px; width: 100%; margin-bottom: 10px;">
                                    <a href="#" class="btn btn-admin-delete arrayParamAdd" data-type="lead_params">Добавить</a>
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
                <?= $form->field($model, 'params_special')->textarea(['rows' => 6, 'style' => 'resize:none', 'readonly' => true, 'class' => 'form-control object-params']) ?>
            </div>

            <div style="display: none">
                <?= $form->field($model, 'archive')->checkbox(['style' => 'vertical-align:top']) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div style="margin: 40px 0; font-size: 20px;">Справка</div>
            <div class="rbac-info rbac-info-leads" style="max-width: unset">
                <p>Сущность "Заказ" является по своей сути прежней сущностью клиента, но с возможностью привязывать заказы к конкретному профилю (новая сущность Клиента); также добавлена более гибкая настройка параметров и особых свойств заказа. </p>
                <hr>
                <p><b>Внимание:</b> <code>специальные параметры заказа</code> имеют приоритет выше, чем <code>специальные параметры клиента</code>, поэтому при двух разных значениях одного и того же параметра для заказа и клиента - будет учтено значение параметра заказа.</p>
                <p><b>Внимание:</b> <code>почты для отправки лидов</code> - перекрывают настройку отправки почты у клиента. Если указаны почты в заказе - клиентские почты не будут задействованы.</p>
                <hr>
                <p><code>Скидка</code> - указывается %, на который будет уменьшена цена за лид, указанная в поле "Цена за лид", при списывании баланса у клиента. <b>Внимание:</b> скидка от бонусной программы суммируется с указанным значением!</p>
                <p><code>Брак</code> - указывается % лидов, который может быть отбракован в данном заказе. <b>Внимание:</b> отбраковка от бонусной программы суммируется с указанным значением!</p>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>



</div>
