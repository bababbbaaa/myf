<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Offers */
/* @var $form yii\widgets\ActiveForm */


$category = \common\models\LeadsCategory::find()->asArray()->all();
$cArr = [];
$arrCat = [];
foreach ($category as $item)  {
    $cArr[$item['link_name']] = $item['name'];
    $arrCat[$item['name']] = $item['link_name'];
}

$offers = \common\models\LeadTypes::find()->asArray()->all();
$jsArr = [];

foreach ($offers as $item)
    $jsArr[$item['id']] = $item;
$jsonArr = json_encode($jsArr, JSON_UNESCAPED_UNICODE);

$ofArr = [
        null => 'Нет'
];

foreach ($offers as $item)
    $ofArr[$item['id']] = $item['name'];


if (!empty($model->special_params)) {
    $jsonParams = json_decode($model->special_params, 1);
    $geo = $jsonParams['geo'] ?? null;
}


$json = json_encode($arrCat, JSON_UNESCAPED_UNICODE);


$js = <<<JS
var 
    regText = $('#offers-regions'),
    regionsParseBlock = $('.regions-parse-block'),
    jsArr = $jsonArr,
    regions = JSON.parse(regText.val());
$(".chosen-select").chosen({disable_search_threshold: 0});
$('#offers-category').on('input', function() {
    var val = $(this).val();
    $('.align-to-area').hide();
    if (val === 'chardjbek' || val === 'dolgi')
        $('.align-to-area[data-type="'+ val +'"]').show();
    else
        $('.align-to-area[data-type="dolgi"]').show();
});
$('.arrayParamAdd').on('click', function(e) {
    e.preventDefault();
    var 
        inp =  $('.inputRegionArray');
    if(inp.val().length > 0 && regions.indexOf(inp.val()) === -1)
        regions.push(inp.val()); 
    parseRegText();
});
regionsParseBlock.on('click', '.regions-block-click', function() {
    var
        index = $(this).attr('data-id');
    regions.splice(index, 1);
    regions.sort();
    if (regions.length <= 0)
        regions.push('Любой');
    parseRegText();
});
function parseRegText() {
    var html = '<div class="click-flex">';
    for (var i = 0; i < regions.length; i++) {
        html += "<div class='regions-block-click' data-id='"+ i +"'>";
            html += regions[i];
        html += "</div>";
    }
    html += '</div>';
    regionsParseBlock.html(html);
    regText.val(JSON.stringify(regions));
}
parseRegText();
$('#offers-offer_id').on('input', function() {
    var val = $(this).val();
    if (val.length > 0) {
        if (jsArr[val] !== undefined) {
            $('#offers-name').val(jsArr[val].name);
            $('#offers-category').val(jsArr[val].category_link);
            $('#offers-price').val(jsArr[val].price);
            $('#offers-leads_need').val(jsArr[val].lead_count);
            regions = JSON.parse(jsArr[val].regions);
            $('#offers-regions').text(JSON.stringify(regions));
            parseRegText();
            $('#offers-special_params').text(jsArr[val].params);
            $('.align-to-area').hide();
            if (jsArr[val].category_link === 'chardjbek' || jsArr[val].category_link === 'dolgi')
                $('.align-to-area[data-type="'+ jsArr[val].category_link +'"]').show();
            else
                $('.align-to-area[data-type="dolgi"]').show();
            if (jsArr[val].category_link === 'chardjbek') {
                var jss = JSON.parse(jsArr[val].params);
                $('select[name="Offers[geo]"]').val(jss.geo).trigger('chosen:updated');
            }
        }
    }
});
JS;
$this->registerJsFile(Url::to(['/js/getRegionAjax.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);


?>

<style>
    .click-flex {
        display: flex;
        flex-wrap: wrap;
    }
    .regions-block-click, .advs-block-click {
        border-radius: 5px;
        background-color: #2b569a;
        color: white;
        padding: 3px 10px;
        cursor: pointer;
        text-align: center;
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>

<div class="offers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'offer_id')->dropDownList($ofArr) ?>

    <?= $form->field($model, 'user_id')->input('number', ['placeholder' => 'Указать ID, например, - 15', 'min' => '1']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Кредитные лиды, МСК']) ?>

    <?= $form->field($model, 'category')->dropDownList($cArr) ?>

    <?= $form->field($model, 'leads_need')->input('number', ['placeholder' => '500', 'min' => '10']) ?>

    <?= $form->field($model, 'price')->input('number', ['placeholder' => '139', 'min' => '100']) ?>

    <?= $form->field($model, 'tax')->input('number', ['placeholder' => '10', 'min' => '0']) ?>

    <div style="display: <?= empty($model->category) || $model->category === 'dolgi' ? 'block' : 'none' ?>" class="align-to-area" data-type="dolgi">
        <div class="showBlock region-block" >
            <p><b>Регионы</b></p>
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

        <div style="margin: 10px 0;" class="regions-parse-block">

        </div>

        <div style="display: none">
            <?= $form->field($model, 'regions')->textarea(['rows' => 6, 'readonly' => true, 'value' => empty($model->regions) ? '["Любой"]' : $model->regions]) ?>
        </div>
    </div>

    <div class="align-to-area " data-type="chardjbek" style="margin-bottom: 20px; display: <?= !empty($model->category) && $model->category === 'chardjbek' ? 'block' : 'none' ?>">
        <p><b>Регионы ЧБ</b></p>
        <p>
            <?php $cregs = \common\models\LeadTypes::chargebackRegions() ?>
            <select class="form-control chosen-select" name="Offers[geo]" id="">
                <?php foreach($cregs as $item): ?>
                    <option value="<?= $item ?>" <?= $item === $geo ? 'selected' : '' ?>><?= $item  ?></option>
                <?php endforeach; ?>
            </select>
        </p>
    </div>

    <div style="display: none">
        <?= $form->field($model, 'special_params')->textarea(['rows' => 6]) ?>
    </div>

    <?= $form->field($model, 'status')->dropDownList([
            'модерация' => 'модерация',
            'исполняется' => 'исполняется',
            'остановлен' => 'остановлен',
            'пауза' => 'пауза',
            'выполнен' => 'выполнен',
    ]) ?>

    <hr>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <h4 style="margin: 40px 0">Справка</h4>
    <div class="rbac-info rbac-info-leads" style="max-width: unset">
        <p><code>Оффер-шаблон</code> - оффер, который будет использован в качестве шаблона. Можно оставить пустым и сделать уникальный оффер, при необходимости</p>
        <p><code>ID пользователя</code> - ID зарегистрированного пользователя, для которого создается оффер</p>
        <p><code>Название</code> - то название, которое будет видно пользователям при выборе оффера на лендинге или в ЛК</p>
        <p><code>Категория</code> - категория требуемых лидов</p>
        <p><code>Нужно лидов</code> - сколько лидов нужно по данному конкретному офферу (сколько лидов на данный оффер должен налить поставщик)</p>
        <p><code>Цена</code> - стандартная цена за подтвержденный лид, которая будет выплачена поставщику, без учета налога</p>
        <p><code>Налог</code> - налог на вывод средств, %. Указанный процент будет вычитаться из общей выводимой суммы</p>
        <p><code>Регионы</code> - на какие регионы нужны лиды. Если ничего не указано - будет установлен "Любой регион", иначе - после выбора регионов необходимо удалить "Любой" из перечня</p>

    </div>


</div>
