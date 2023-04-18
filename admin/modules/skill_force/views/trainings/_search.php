<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainingsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="skill-trainings-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'link') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'author_id') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'preview_logo') ?>

    <?php // echo $form->field($model, 'content_subtitle') ?>

    <?php // echo $form->field($model, 'content_about') ?>

    <?php // echo $form->field($model, 'content_block_income') ?>

    <?php // echo $form->field($model, 'content_block_description') ?>

    <?php // echo $form->field($model, 'content_block_tags') ?>

    <?php // echo $form->field($model, 'content_for_who') ?>

    <?php // echo $form->field($model, 'content_what_study') ?>

    <?php // echo $form->field($model, 'category_id') ?>

    <?php // echo $form->field($model, 'content_terms') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'discount_expiration_date') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'date_meetup') ?>

    <?php // echo $form->field($model, 'lessons_count') ?>

    <?php // echo $form->field($model, 'study_hours') ?>

    <?php // echo $form->field($model, 'exist_videos') ?>

    <?php // echo $form->field($model, 'exist_bonuses') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
