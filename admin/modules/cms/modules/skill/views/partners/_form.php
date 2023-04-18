<?php

use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SkillPartners */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="skill-partners-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'id' => 'textToLink', 'placeholder' => 'FemidaForce']) ?>

    <?= $form->field($model, 'link')->textInput(['maxlength' => true, 'id' => 'linkText', 'placeholder' => 'femidaforce']) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'placeholder' => 'ФЭС — каждый день все эти юристы помогают гражданам избавляться от долгов и начинать новую финансовую жизнь без долгов. Мы гордимся своими сотрудниками, и с радостью возьмем вас в свою команду!']) ?>

    <?= $form->field($model, 'photo')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Фото или логотип'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => false       // возможность выбора нескольких файлов
    ]); ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
