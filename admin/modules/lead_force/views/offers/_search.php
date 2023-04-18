<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\OffersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="offers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'category') ?>

    <?= $form->field($model, 'regions') ?>

    <?= $form->field($model, 'leads_need') ?>

    <?php // echo $form->field($model, 'leads_confirmed') ?>

    <?php // echo $form->field($model, 'leads_waste') ?>

    <?php // echo $form->field($model, 'leads_total') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'tax') ?>

    <?php // echo $form->field($model, 'total_payed') ?>

    <?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'offer_id') ?>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'offer_token') ?>

    <?php // echo $form->field($model, 'special_params') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
