<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Cases */
/* @var $form yii\widgets\ActiveForm */

$jsonInput = !empty($model->input) ? $model->input : "[]";
$jsonResult = !empty($model->result) ? $model->result : "[]";
$jsonFromTo = !empty($model->from_to) ? $model->from_to : "[]";

$js = <<<JS
var
    inputObj = $jsonInput,
    resultObj = $jsonResult,
    fromtToObj = $jsonFromTo;

if(inputObj.length > 0)
    renderByType('input', inputObj);
if(resultObj.length > 0)
    renderByType('result', resultObj);
if(fromtToObj.length > 0)
    renderByType('from_to', fromtToObj);

$('.add-to-blocks').on('click', function() {
    var 
        type = $(this).attr('data-type'),
        input = null,
        input2 = null,
        val = null,
        val2 = null;
    if (type === 'input') {
        input = $('.addDynamic[data-type="'+ type +'"]');
        val = input.val();
        if(val.length > 0 && inputObj.indexOf(val) === -1) 
            inputObj.push(val);
        renderByType(type, inputObj);
        input.val('');
    } else if(type === 'result') {
        input = $('.addDynamic[data-type="'+ type +'"]');
        val = input.val();
        if(val.length > 0 && resultObj.indexOf(val) === -1) 
            resultObj.push(val);
        renderByType(type, resultObj);
        input.val('');
    } else {
        input = $('.addDynamic[data-type="'+ type +'"][data-select="1"]');
        input2 = $('.addDynamic[data-type="'+ type +'"][data-select="2"]');
        val = input.val();
        val2 = input2.val();
        if(val.length > 0 && val2.length > 0) 
            fromtToObj.push({Было: val, Стало: val2});
        renderByType(type, fromtToObj);
        input.val('');
        input2.val('');
    }
});
function renderByType(type, obj) {
    var 
        blocks = $('.blocks[data-type="'+ type +'"]'),
        html = '';
    if(obj.length > 0) {
        if (type === 'input')
            html = '<div style="margin-bottom:10px; text-decoration:underline">Указанные исходные данные</div>';
        else if(type === 'result')
            html = '<div style="margin-bottom:10px; text-decoration:underline">Указанные результаты</div>';
        else
            html = '<div style="margin-bottom:10px; text-decoration:underline">Указанные пункты Было-Стало</div>';
    }
    html += '<div class="block-flex-display">';
    for (var i = 0; i < obj.length; i++) {
        if (type === 'from_to') 
            html += "<div class='block-click-remove' data-id='"+ i +"' data-type='"+ type +"'>"+ JSON.stringify(obj[i]) +"</div>";
        else 
            html += "<div class='block-click-remove' data-id='"+ i +"' data-type='"+ type +"'>"+ obj[i] +"</div>";
    }
    html += "</div>";
    blocks.html(html);
    $('.hiddenDynamic[data-type="'+ type +'"]').text(JSON.stringify(obj));
}
$('.blocks').on('click', '.block-click-remove', function() {
    var 
        type = $(this).attr('data-type'),
        id = $(this).attr('data-id');
    $(this).remove();
    if (type === 'input') {
        inputObj.splice(id, 1);
        renderByType(type, inputObj);
    } else if(type === 'result') {
        resultObj.splice(id, 1);
        renderByType(type, resultObj);
    } else {
        fromtToObj.splice(id, 1);
        renderByType(type, fromtToObj);
    }
});
JS;

$this->registerJs($js);
?>

<style>
    .block-flex-display {
        display: flex;
        flex-wrap: wrap;
    }
    .block-flex-display > div {
        margin: 0 10px 10px 0;
        padding: 10px;
        background-color: #fafafa;
        border-radius: 6px;
        border: 1px solid gainsboro;
        cursor: pointer;
    }
</style>

<div class="cases-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'id' => 'textToLink', 'placeholder' => 'ООО Праватон']) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'id' => 'linkText', 'placeholder' => 'pravaton']) ?>

    <?= $form->field($model, 'type')->textInput(['maxlength' => true, 'placeholder' => 'Индивидуальная система лидогенерации']) ?>

    <?= $form->field($model, 'logo')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Логотип компании'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => false       // возможность выбора нескольких файлов
    ]); ?>

    <hr>

    <?= $form->field($model, 'boss_name')->textInput(['maxlength' => true, 'placeholder' => 'Виталий Иванов']) ?>

    <?= $form->field($model, 'boss_op')->textInput(['maxlength' => true, 'placeholder' => 'генеральный директор ООО ПРАВАТОН']) ?>

    <?= $form->field($model, 'boss_img')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Фото представителя'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6, 'placeholder' => 'После консультации и составления технического задания был проведен анализ бизнес-процессов и выявленны слабые стороны.', 'style' => 'resize:none']) ?>

    <hr>

    <?= $form->field($model, 'small_description')->textInput(['maxlength' => true, 'placeholder' => 'Настроили 6 воронок (Продажа в офисе, Продажа дистанционная, Исполнения БФЛ, Исполнение Снижение ежемесячных платежей, Контроль оплат БФЛ, Контроль оплат Снижение ежемесячных платежей)']) ?>

    <?=
    $form->field($model, 'big_description')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder'),
    ]);
    ?>

    <div style="margin-bottom: 15px">
        <p><b>Добавить исходные данные</b></p>
        <div style="display: flex; flex-wrap: wrap">
            <div style="margin-right: 10px; margin-bottom: 10px; max-width: 700px; width: 100%;">
                <input type="text" placeholder="Все клиенты приглашались в офис просто для анализа возможности банкротства" class="form-control addDynamic" data-type="input">
            </div>
            <div>
                <div class="btn btn-admin-help add-to-blocks" data-type="input">Добавить</div>
            </div>
        </div>
        <div class="blocks" data-type="input">

        </div>
    </div>

    <div style="margin-bottom: 15px">
        <p><b>Добавить результаты</b></p>
        <div style="display: flex; flex-wrap: wrap">
            <div style="margin-right: 10px; margin-bottom: 10px; max-width: 700px; width: 100%;">
                <input type="text" placeholder="Возможность проводить анкетирование удаленно" class="form-control addDynamic" data-type="result">
            </div>
            <div>
                <div class="btn btn-admin-help add-to-blocks" data-type="result">Добавить</div>
            </div>
        </div>
        <div class="blocks" data-type="result">

        </div>
    </div>

    <div style="margin-bottom: 15px">
        <p><b>Добавить пункты "Было - Стало"</b></p>
        <div style="display: flex; flex-wrap: wrap">
            <div style="margin-right: 10px; margin-bottom: 10px; max-width: 350px; width: 100%;">
                <input type="text" placeholder="Юрист заполнял 10-14 анкет в неделю" class="form-control addDynamic" data-type="from_to" data-select="1">
            </div>
            <div style="margin-right: 10px; margin-bottom: 10px; max-width: 350px; width: 100%;">
                <input type="text" placeholder="60 анкет в неделю" class="form-control addDynamic" data-type="from_to" data-select="2">
            </div>
            <div>
                <div class="btn btn-admin-help add-to-blocks" data-type="from_to">Добавить</div>
            </div>
        </div>
        <div class="blocks" data-type="from_to">

        </div>
    </div>

    <div style="display: none">
        <?= $form->field($model, 'input')->textarea(['rows' => 6, 'class' => 'form-control hiddenDynamic', 'data-type' => 'input']) ?>

        <?= $form->field($model, 'result')->textarea(['rows' => 6, 'class' => 'form-control hiddenDynamic', 'data-type' => 'result']) ?>

        <?= $form->field($model, 'from_to')->textarea(['rows' => 6, 'class' => 'form-control hiddenDynamic', 'data-type' => 'from_to']) ?>
    </div>

    <hr>

    <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true, 'placeholder' => 'банкротство, femidaforce, франшиза']) ?>

    <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true, 'placeholder' => 'Starbucks и другие американские франшизы, сильно пострадавшие от ковида']) ?>

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

    <?= $form->field($model, 'active')->dropDownList([1 => 'да', 0 => 'нет']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
