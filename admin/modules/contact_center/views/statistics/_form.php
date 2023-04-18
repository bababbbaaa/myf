<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CcLeads */
/* @var $form yii\widgets\ActiveForm */

#TODO: статистика и утилити для модера

$ccUsers = [];
$cc = \common\models\AuthAssignment::find()->where(['item_name' => 'cc'])->asArray()->select(['item_name', 'user_id'])->all();
if (!empty($cc)) {
    foreach ($cc as $item)
        $ccUsers[] = $item['user_id'];
}

$usArr = [null => 'Не указан'];
$usersRender = \common\models\UserModel::find()->where(['in', 'id', $ccUsers])->select(['inner_name', 'id'])->asArray()->all();
if (!empty($usersRender)) {
    foreach ($usersRender as $item) {
        $usArr[$item['id']] = $item['inner_name'];
    }
}

$cats = \common\models\LeadsCategory::find()->select(['name', 'link_name'])->asArray()->all();

$cc1 = [];

if (!empty($cats)) {
    foreach ($cats as $item)
        $cc1[$item['link_name']] = $item['name'];
}
?>



<div class="cc-leads-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php if(empty($model->id)): ?>
        <?= $form->field($model, 'category')->dropDownList($cc1) ?>
        <?= $form->field($model, 'phone')->textInput(['placeholder' => '89188916605', 'maxlength'=>11]) ?>
        <?= $form->field($model, 'source')->textInput(['placeholder' => 'База №1']) ?>
        <?= $form->field($model, 'utm_source')->textInput(['placeholder' => 'MSK']) ?>
    <?php endif; ?>

    <?= $form->field($model, 'assigned_to')->dropDownList($usArr) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
