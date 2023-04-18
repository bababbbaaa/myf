<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CasesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cases-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'link') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'type') ?>

    <?= $form->field($model, 'logo') ?>

    <?php // echo $form->field($model, 'boss_img') ?>

    <?php // echo $form->field($model, 'small_description') ?>

    <?php // echo $form->field($model, 'input') ?>

    <?php // echo $form->field($model, 'result') ?>

    <?php // echo $form->field($model, 'from_to') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'boss_name') ?>

    <?php // echo $form->field($model, 'boss_op') ?>

    <?php // echo $form->field($model, 'big_description') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'active') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
