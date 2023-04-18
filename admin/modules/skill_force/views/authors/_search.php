<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainingsAuthorsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="skill-trainings-authors-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'link') ?>

    <?= $form->field($model, 'small_description') ?>

    <?= $form->field($model, 'photo') ?>

    <?php // echo $form->field($model, 'about') ?>

    <?php // echo $form->field($model, 'specs') ?>

    <?php // echo $form->field($model, 'video') ?>

    <?php // echo $form->field($model, 'practice') ?>

    <?php // echo $form->field($model, 'comment_article') ?>

    <?php // echo $form->field($model, 'comment_text') ?>

    <?php // echo $form->field($model, 'date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
