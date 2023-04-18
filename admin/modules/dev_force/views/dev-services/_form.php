<?php

use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DevServices */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dev-services-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'image')->widget(InputFile::className(), [
        'language' => 'ru',
        'controller' => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter' => '',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'name' => 'material__file',
        'value' => '',
        'template' => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options' => ['class' => 'form-control material__file', 'placeholder' => 'Логотип услуги'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
    ]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Заголовок услуги']) ?>

    <?= $form->field($model, 'subtitle')->textInput(['maxlength' => true, 'placeholder' => 'Подзаголовок услуги']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
