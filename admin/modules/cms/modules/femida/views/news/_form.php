<?php

use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tag')->dropDownList(\common\models\News::$tags) ?>

    <?= $form->field($model, 'search_tag')->textInput(['maxlength' => true, 'placeholder' => 'Разработка, дизайн, анализ, проектирование']) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Синие тарелки красивые, но коричневые прослужат дольше', 'id' => 'textToLink']) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'placeholder' => 'sinie-tarelki-krasivye-no-korichnevye-proslujat-dolshe', 'id' => 'linkText']) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true, 'placeholder' => 'Олег']) ?>

    <?= $form->field($model, 'source')->textInput(['maxlength' => true, 'placeholder' => 'ТАСС']) ?>

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

    <?=
    $form->field($model, 'content')->widget(CKEditor::className(), [
        'editorOptions' => ElFinder::ckeditorOptions('elfinder'),
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
