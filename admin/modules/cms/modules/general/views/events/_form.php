<?php

use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Events */
/* @var $form yii\widgets\ActiveForm */

$css =<<< CSS
.ui-datepicker{
    z-index: 2 !important;
}
CSS;
$this->registerCss($css);
?>

<div class="events-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'id' => 'textToLink', 'placeholder' => 'Первая конференция по банкротству физ.лиц']) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'id' => 'linkText', 'placeholder' => 'pervaya-konferenciya-po-bankrotstvu-fiz-lic']) ?>

    <?= $form->field($model, 'type')->dropDownList(['Мероприятие' => 'Мероприятие', 'Событие' => 'События', 'Акция' => 'Акция']) ?>

    <?= $form->field($model, 'price')->input('number', ['placeholder' => '2000']) ?>

    <?= $form->field($model, 'main_page')->dropDownList([0 => 'нет', 1 => 'да']) ?>

    <?= $form->field($model, 'main_page_text')->textInput(['maxlength' => true, 'placeholder' => 'Опытные юристы, топ-менеджеры и маркетологи обсудят проблемы и перспективы БФЛ — от привлечения клиентов до автоматизации процессов']) ?>

    <?= $form->field($model, 'event_date')->widget(\yii\jui\DatePicker::classname(), ['options' => ['class' => 'form-control', 'placeholder' => date("d.m.Y", time() + 2*3600*24)], 'dateFormat' => 'yyyy-MM-dd']) ?>

    <?= $form->field($model, 'event_city')->textInput(['maxlength' => true, 'placeholder' => 'г. Москва']) ?>

    <?= $form->field($model, 'preview_text')->textInput(['placeholder' => 'Вы узнаете, с чего начать планирование бизнеса, как выбрать рабочую бизнес-идею и эффективно распределить роли в команде']) ?>

    <?= $form->field($model, 'active')->dropDownList([1 => 'да', 0 => 'нет',]) ?>

    <?= $form->field($model, 'img')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Изображение'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'event_finish_date')->widget(\yii\jui\DatePicker::classname(), ['options' => ['class' => 'form-control', 'placeholder' => date("d.m.Y", time() + 2*3600*24)], 'dateFormat' => 'yyyy-MM-dd']) ?>

    <?= $form->field($model, 'category')->dropDownList(['Мероприятие', 'Событие', 'Акция']) ?>

    <?= $form->field($model, 'poster')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'path' => 'image', // будет открыта папка из настроек контроллера с добавлением указанной под деритории
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Постер'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'text_color')->textInput(['maxlength' => true, 'placeholder' => '#ffffff/red/rgb(151,235,243)']) ?>

    <?= $form->field($model, 'main_page_text_header')->textInput(['maxlength' => true, 'placeholder' => 'Об акции']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Первая конференция по банкротству физ.лиц']) ?>

    <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Опытные юристы, топ-менеджеры и маркетологи обсудят проблемы и перспективы БФЛ — от привлечения клиентов до автоматизации процессов']) ?>

    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true, 'placeholder' => 'БФЛ, банкротство, бизнес, майфорс']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
