<?php

use common\models\RenderProcessor;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Technologies */
/* @var $form yii\widgets\ActiveForm */

$json = null;
if (!empty($model->popup_data))
    $json = json_decode($model->popup_data, JSON_UNESCAPED_UNICODE);

$jsons = null;
if (!empty($model->first_section_advantage)){
    $jsons = json_decode($model->first_section_advantage, JSON_UNESCAPED_UNICODE);
    $first = json_encode($jsons['advantage'], JSON_UNESCAPED_UNICODE);
} else {
    $first = '[]';
}

$jsonss = null;
if (!empty($model->second_section_advantage)){
    $jsonss = json_decode($model->second_section_advantage, JSON_UNESCAPED_UNICODE);
    $second = json_encode($jsonss['advantage'], JSON_UNESCAPED_UNICODE);
} else {
    $second = '[]';
}

$cats = \common\models\Franchise::find()->select(['category'])->distinct()->asArray()->all();

$catArr = [];
if (!empty($cats)) {
    foreach ($cats as $item)
        $catArr[$item['category']] = $item['category'];
}

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5});
JS;
$this->registerJs($js);

?>

<div class="technologies-form">

    <?php $form = ActiveForm::begin(); ?>

    <hr>

    <h3>Общая информация</h3>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Финансовая защита']) ?>

    <?= $form->field($model, 'category')->dropDownList($catArr, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'is_active')->dropDownList([1 => 'Активна', 0 => "Неактивна"]) ?>

    <?= $form->field($model, 'preview')->textInput(['maxlength' => true, 'placeholder' => 'Для клиентов, которые не подходят под банкротство у нас предусмотрен комплекс услуг по правовой финансовой защите']) ?>

    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true, 'placeholder' => 'Комплекс услуг по правовой финансовой защите для тех, кому не подходит банкротство']) ?>

    <hr>

    <h3>POPUP</h3>

    <div>
        <?= RenderProcessor::renderDynamicObjectInput(
            'Преимущества',
            'popup',
            'advantage',
            'input',
            'Полный аутсорсинг юридических услуг — вам нужно только продавать!',
            '[]',
            $json['popup']['advantage'] ?? '',
            !empty($json['popup']['advantage']) ? count($json['popup']['advantage']) : false,
                true
        ); ?>
    </div>
    <div style="margin-top: 10px">
        <div class="btn btn-admin-help append-btn" data-append-param="popup" data-append-key="advantage" data-append-block=".append-popup">Добавить еще</div>
    </div>

    <div class="row" style="margin-top: 20px">
        <div class="col-lg-12 pdb10">
            <?= RenderProcessor::renderDynamicObjectInput(
                'Мелкий текст',
                'popup',
                'text',
                'text',
                'Работаем с суммой долга от 150 000. Увеличивайте сегмент целевых клиентов в бизнесе по банкротству за счёт введения дополнительной услуги',
                '',
                $json['popup']['text'] ?? ''
            ); ?>
        </div>
    </div>

    <hr>

    <?= $form->field($model, 'popup_data')->textarea(['rows' => 6, 'placeholder' => 'json', 'readonly' => true, 'style' => 'resize:none;', 'class' => 'composed-object form-control']) ?>

    <?= $form->field($model, 'essence')->textarea(['style'=>'resize:none', 'placeholder' => 'Это альтернативная услуга вместо банкротства, позволяющая повысить конверсию в договор с лида с 8% до 15% за счет продажи новых услуг той же категории клиентов и рост маржи бизнеса по БФЛ с 38% до 60% благодаря увеличения продажи услуг по тем же лидам!
Вы сможете продавать ЗПЗ (СЭП, ФЗ) тем, кому не подходит банкротств, разные услуги одной и той же базе лидов и расширите маржу бизнеса без увеличения рекламных расходов.', 'rows' => 7]) ?>



    <?= $form->field($model, 'first_image')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Первая иллюстрация'],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'multiple'      => false       // возможность выбора нескольких файлов
    ]);
    ?>

    <?= $form->field($model, 'second_image')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Вторая иллюстрация'],
        'buttonOptions' => ['class' => 'btn btn-default'],
        'multiple'      => false       // возможность выбора нескольких файлов
    ]);
    ?>

    <?= $form->field($model, 'important')->textarea(['style'=>'resize:none', 'placeholder' => 'Мы не работаем в рамках юридической «чернухи». Все методы и схемы законны и построены на процессах приобщения к будущим банкротам действующего законодательства с использованием правовых норм! Если какая-либо информация в данной технологии, на ваш взгляд, будет «призывать» к нарушению законодательства, это будет лишь ваше субъективное мнение и оценочное суждение вызванное неправильным восприятием трактовки информации. Мы не призываем к нарушению законодательства в любом виде, вся информация в технологии повествуется исключительно в ознакомительных целях для понимания юристов о том, что «можно», а что «нельзя».', 'rows' => 7]) ?>

    <?php
    $jss =<<< JS
    $('.appends-btn').on('click', function () {
        var block = $(this).attr('data-append-block');
        $(block).append('<div><input style="margin-top: 10px" class="first__change-adv advantage__first form-control" type="text"  placeholder="Укажите значение для пункта списка"></div>');
    });
    $('.appendss-btn').on('click', function () {
        var
            block = $(this).attr('data-append-block'),
            param = $(this).attr('data-append-param'),
            key = $(this).attr('data-append-key');
        $(block).append('<div><input style="margin-top: 10px" class="second__change-adv advantage__second form-control" type="text" placeholder="Укажите значение для пункта списка"></div>');
    });
    $('.save__first-section').on('click', function() {
        var  title = $('#title-1').val(),
             obj = {},
             arrs = [],
             arr = $('.first__change-adv');
        
        obj.title = title;
        arr.each(function() {
            arrs.push($(this).val());
        })
        obj.advantage = arrs;
        obj = JSON.stringify(obj);
        $('.first__section-json').text(obj);
    });
    $('.save__second-section').on('click', function() {
        var  title = $('#title-2').val(),
             obj = {},
             arrs = [],
             arr = $('.second__change-adv');
        
        obj.title = title;
        arr.each(function() {
            arrs.push($(this).val());
        })
        obj.advantage = arrs;
        obj = JSON.stringify(obj);
        $('.second__section-json').text(obj);
    });

    function renderFirst() {
        var first = JSON.parse('$first');
        console.log(first);
        for (var i = 0; i < first.length; i++){
            $('.advantage__block-1').append('<div><input value="'+ first[i] +'" style="margin-top: 10px" class="first__change-adv advantage__first form-control" type="text" placeholder="Укажите значение для пункта списка"></div>');
        }
    }
    renderFirst();
    function renderSecond() {
        var second = JSON.parse('$second');
        for (var i = 0; i < second.length; i++){
            $('.advantage__block-2').append('<div><input value="'+ second[i] +'" style="margin-top: 10px" class="second__change-adv advantage__second form-control" type="text" placeholder="Укажите значение для пункта списка"></div>');
        }
    }
    renderSecond();
JS;
$this->registerJs($jss);
    ?>
    <div class="render__content">
        <div class="first-content__block form-group">
            <label for="title-1" class="control-label">Заголовок первой секции</label>
            <input value="<?= !empty($jsons['title']) ? $jsons['title'] : '' ?>" style="margin-bottom: 10px;" class="first__change-title form-control" id="title-1" type="text" name="title-1" placeholder="Чем занимается менеджер клиентского сервиса?">
            <div class="advantage__block-1">
                <h5>Преимущества первой секции</h5>
            </div>
            <div style="margin-top: 10px">
                <div class="btn btn-admin-help appends-btn" data-append-block=".advantage__block-1">Добавить еще</div>
            </div>
            <div style="margin-top: 10px">
                <button style="margin-bottom: 10px;" type="button" class="save__first-section btn btn-success"> Сохранить</button>
            </div>
            <?= $form->field($model, 'first_section_advantage')->textarea(['rows' => 6, 'placeholder' => 'json', 'readonly' => true, 'style' => 'resize:none;', 'class' => 'form-control first__section-json']) ?>
        </div>
        <div class="second-content__block form-group">
            <label for="title-1" class="control-label">Заголовок второй секции</label>
            <input value="<?= !empty($jsonss['title']) ? $jsonss['title'] : '' ?>" style="margin-bottom: 10px;" class="first__change-title form-control" id="title-2" type="text" name="title-1" placeholder="Чем занимается менеджер клиентского сервиса?">
            <div class="advantage__block-2">
                <h5>Преимущества второй секции</h5>
            </div>

            <div style="margin-top: 10px">
                <div class="btn btn-admin-help appendss-btn" data-append-block=".advantage__block-2">Добавить еще</div>
            </div>
            <div style="margin-top: 10px">
                <button style="margin-bottom: 10px;" type="button" class="save__second-section btn btn-success"> Сохранить</button>
            </div>
            <?= $form->field($model, 'second_section_advantage')->textarea(['rows' => 6, 'placeholder' => 'json', 'readonly' => true, 'style' => 'resize:none;', 'class' => 'form-control second__section-json']) ?>
        </div>
    </div>

    <?= $form->field($model, 'price')->input('number', ['placeholder' => '2000']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
