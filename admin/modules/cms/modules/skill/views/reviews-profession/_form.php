<?php

use mihaildev\elfinder\InputFile;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SkillReviewsProfession */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="skill-reviews-profession-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Кирилл Супрунов']) ?>

    <?= $form->field($model, 'whois')->textInput(['maxlength' => true, 'placeholder' => 'Пекарь']) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'placeholder' => 'Теперь я маркетолог в крупной компании. Каждый день занимаюсь любимым делом!']) ?>

    <?= $form->field($model, 'photo')->widget(InputFile::className(), [
        'language'      => 'ru',
        'controller'    => 'elfinder', // вставляем название контроллера, по умолчанию равен elfinder
        'filter'        => 'image',    // фильтр файлов, можно задать массив фильтров https://github.com/Studio-42/elFinder/wiki/Client-configuration-options#wiki-onlyMimes
        'template'      => '<div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
        'options'       => ['class' => 'form-control', 'placeholder' => 'Фото'],
        'buttonOptions' => ['class' => 'btn btn-admin', 'style' => 'padding: 6px 15px'],
        'buttonName' => 'Выбрать',
        'multiple'      => false       // возможность выбора нескольких файлов
    ]); ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), ['options' => ['class' => 'form-control', 'placeholder' => date("Y-m-d", time() + 2*3600*24)], 'dateFormat' => 'yyyy-MM-dd']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
