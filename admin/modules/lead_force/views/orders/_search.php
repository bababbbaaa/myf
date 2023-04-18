<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OrdersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="orders-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'order_name') ?>

    <?= $form->field($model, 'client') ?>

    <?= $form->field($model, 'category_link') ?>

    <?= $form->field($model, 'category_text') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'leads_count') ?>

    <?php // echo $form->field($model, 'leads_get') ?>

    <?php // echo $form->field($model, 'regions') ?>

    <?php // echo $form->field($model, 'params_category') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'date_end') ?>

    <?php // echo $form->field($model, 'commentary') ?>

    <?php // echo $form->field($model, 'params_special') ?>

    <?php // echo $form->field($model, 'leads_waste') ?>

    <?php // echo $form->field($model, 'sale') ?>

    <?php // echo $form->field($model, 'archive') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
