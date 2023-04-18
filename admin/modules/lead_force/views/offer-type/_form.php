<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LeadTypes */
/* @var $form yii\widgets\ActiveForm */


$leadsCategory = \common\models\LeadsCategory::find()->asArray()->all();

$catArray = [];
$arrCat = [];
if (!empty($leadsCategory)) {
    foreach ($leadsCategory as $item) {
        $catArray[$item['name']] = $item['name'];
        $arrCat[$item['name']] = $item['link_name'];
    }
}

if (!empty($model->params)) {
    $jsonParams = json_decode($model->params, 1);
    $geo = $jsonParams['geo'] ?? null;
}

$advs = !empty($model->advantages) ? $model->advantages : '[]';

$json = json_encode($arrCat, JSON_UNESCAPED_UNICODE);

$js = <<<JS
var 
    obj = $json,
    regText = $('#leadtypes-regions'),
    advBlock = $('.advantages-block'),
    advInp = $('.adv-inp'),
    addAdv = $('.add-adv'),
    regionsParseBlock = $('.regions-parse-block'),
    advantages = $advs,
    regions = JSON.parse(regText.val());
$(".chosen-select").chosen({disable_search_threshold: 0});
$('.changeCatName').on('input', function() {
    var val = $(this).val();
    if (obj[val] !== undefined) {
        console.log(obj[val]);
        $('.align-to-area').hide();
        if (obj[val] === 'chardjbek' || obj[val] === 'dolgi')
            $('.align-to-area[data-type="'+ obj[val] +'"]').show();
        else
            $('.align-to-area[data-type="dolgi"]').show();
        $('.changeCatNameThis').val(obj[val]);
    }
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
function parseAdvs() {
    var html = '<div class="click-flex">';
    for (var i = 0; i < advantages.length; i++) {
        html += "<div class='advs-block-click' data-id='"+ i +"'>";
            html += advantages[i];
        html += "</div>";
    }
    html += '</div>';
    advBlock.html(html);
    $('#leadtypes-advantages').val(JSON.stringify(advantages));
}
parseAdvs();
addAdv.on('click', function() {
    if (advInp.val().length > 0 && advantages.indexOf(advInp.val()) === -1)
        advantages.push(advInp.val());
    parseAdvs();
});
advBlock.on('click', '.advs-block-click', function() {
    var
        index = $(this).attr('data-id');
    advantages.splice(index, 1);
    advantages.sort();
    parseAdvs();
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

<div class="lead-types-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Лиды на ЧБ', 'id' => 'textToLink']) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'placeholder' => 'lidy-na-chargeback', 'id' => 'linkText']) ?>

    <?= $form->field($model, 'category')->dropDownList($catArray, ['class' => 'form-control chosen-select changeCatName']) ?>

    <div style="display: none">
        <?= $form->field($model, 'category_link')->textInput(['maxlength' => true, 'class' => 'changeCatNameThis', 'value' => empty($model->category_link) ? $catArray[array_key_first($catArray)] : $model->category_link]) ?>
    </div>

    <?= $form->field($model, 'price')->input('number', ['placeholder' => '139']) ?>

    <?= $form->field($model, 'lead_count')->input('number', ['placeholder' => '1024']) ?>

    <?=
    $form->field($model, 'description')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder'),
    ]);
    ?>

    <?php

    echo $form->field($model, 'image')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Иконка оффера'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => false       // возможность выбора нескольких файлов
    ]);

    ?>

    <div style="display: <?= empty($model->category_link) || $model->category_link === 'dolgi' ? 'block' : 'none' ?>" class="align-to-area" data-type="dolgi">
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

    <div class="align-to-area " data-type="chardjbek" style="margin-bottom: 20px; display: <?= !empty($model->category_link) && $model->category_link === 'chardjbek' ? 'block' : 'none' ?>">
        <p><b>Регионы ЧБ</b></p>
        <p>
            <?php $cregs = \common\models\LeadTypes::chargebackRegions() ?>
            <select class="form-control chosen-select" name="LeadTypes[geo]" id="">
                <?php foreach($cregs as $item): ?>
                    <option value="<?= $item ?>" <?= $item === $geo ? 'selected' : '' ?>><?= $item  ?></option>
                <?php endforeach; ?>
            </select>
        </p>
    </div>

    <div style="margin: 10px 0">
        <p><b>Особенности</b></p>
        <div style="display: flex; flex-wrap: wrap">
            <div style="margin-right: 10px; margin-bottom: 10px; max-width: 300px; width: 100%;">
                <input type="text" class="form-control adv-inp" placeholder="Клиенты из любого региона России">
            </div>
            <div style="margin-right: 10px; margin-bottom: 10px">
                <div class="btn btn-admin-help add-adv">Добавить</div>
            </div>
        </div>
    </div>
    <div class="advantages-block">

    </div>
   <div style="display: none">
       <?= $form->field($model, 'advantages')->textarea(['rows' => 6]) ?>
   </div>
    <hr>
    <?= $form->field($model, 'hot')->dropDownList([0 => 'нет', 1 => 'да',]) ?>
    <?= $form->field($model, 'active')->dropDownList([ 1 => 'да', 0 => 'нет',]) ?>

    <?= $form->field($model, 'og_title')->textInput(['maxlength' => true, 'placeholder' => 'Синие тарелки красивые, но коричневые прослужат дольше']) ?>

    <?= $form->field($model, 'og_description')->textInput(['maxlength' => true, 'placeholder' => 'Описание для сниппета, текст под названием страницы, не более 127 символов']) ?>

    <?= $form->field($model, 'og_image')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Картинка для соц.сети'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true, 'placeholder' => 'Лиды на услуги банкротства физических лиц для юристов']) ?>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true, 'placeholder' => 'лиды на банкротство, лиды на бфл, клиенты для юриста']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <h4 style="margin: 40px 0">Справка</h4>
    <div class="rbac-info rbac-info-leads" style="max-width: unset">
        <p><code>Название</code> - то название, которое будет видно пользователям при выборе оффера на лендинге или в ЛК</p>
        <p><code>Категория</code> - категория требуемых лидов</p>
        <p><code>Цена</code> - стандартная цена за подтвержденный лид, которая будет выплачена поставщику, без учета налога</p>
        <p><code>Описание</code> - любое текстовое описание оффера</p>
        <p><code>Регионы</code> - на какие регионы нужны лиды. Если ничего не указано - будет установлен "Любой регион", иначе - после выбора регионов необходимо удалить "Любой" из перечня</p>
        <p><code>Особенности</code> - короткие текстовые тезисы, для описания необходимого формата лидов. Данные параметры ни на что не влияют и нужны только для отображения оффера</p>
        <p><code>Горячий оффер</code> - указать, располагается ли данный оффер в ЛК в разделе "Горячие офферы" или нет</p>
        <p><code>Активность оффера</code> - указать, является ли данный оффер публичным для ЛК и лендинга</p>

    </div>

</div>
