<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DevCasesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dev-cases-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'logo') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'description_works') ?>

    <?= $form->field($model, 'fone_img') ?>

    <?php // echo $form->field($model, 'client') ?>

    <?php // echo $form->field($model, 'services') ?>

    <?php // echo $form->field($model, 'site') ?>

    <?php // echo $form->field($model, 'project_objective') ?>

    <?php // echo $form->field($model, 'results') ?>

    <?php // echo $form->field($model, 'done_big_image') ?>

    <?php // echo $form->field($model, 'done_description') ?>

    <?php // echo $form->field($model, 'done_small_image') ?>

    <?php // echo $form->field($model, 'done_small_image_description') ?>

    <?php // echo $form->field($model, 'functionality_lk_text') ?>

    <?php // echo $form->field($model, 'functionality_lk_image') ?>

    <?php // echo $form->field($model, 'site_screenshots') ?>

    <?php // echo $form->field($model, 'integrations') ?>

    <?php // echo $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'date') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
