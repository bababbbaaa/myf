<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SkillReviewsVideo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="skill-reviews-video-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Новая жизнь со SKILL.FORCE']) ?>

    <?= $form->field($model, 'small_description')->textInput(['maxlength' => true, 'placeholder' => 'Пройдя курс «Таргетолог с нуля» Кирилл Супрунов начал свою карьеру как директолог в MyForce. Посмотрите его видео-отзыв']) ?>

    <?= $form->field($model, 'video')->textInput(['maxlength' => true, 'placeholder' => 'https://www.youtube.com/watch?v=9bZkp7q19f0&ab_channel=officialpsy']) ?>

    <?= $form->field($model, 'date')->widget(\yii\jui\DatePicker::classname(), ['options' => ['class' => 'form-control', 'placeholder' => date("Y-m-d", time() + 2*3600*24)], 'dateFormat' => 'yyyy-MM-dd']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
