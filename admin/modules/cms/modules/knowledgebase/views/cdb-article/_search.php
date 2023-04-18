<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CdbArticleSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cdb-article-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'category_id') ?>

    <?= $form->field($model, 'subcategory_id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'text') ?>

    <?php // echo $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'img') ?>

    <?php // echo $form->field($model, 'minimum_status') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'author') ?>

    <?php // echo $form->field($model, 'tags') ?>

    <?php // echo $form->field($model, 'views') ?>

    <?php // echo $form->field($model, 'likes') ?>

    <?php // echo $form->field($model, 'downloads') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
