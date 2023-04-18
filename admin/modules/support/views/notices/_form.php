<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\UsersNotice */
/* @var $form yii\widgets\ActiveForm */


$users = \common\models\User::find()->asArray()->select(['id', 'username', 'email'])->all();

$usArr = [];

if (!empty($users))  {
    foreach ($users as $item) {
        if (!empty($item['email']))
            $usArr[$item['id']] = "{$item['username']} {$item['email']}";
        else
            $usArr[$item['id']] = "{$item['username']}";
    }
}

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5});
JS;

$this->registerJs($js);

?>

<div class="users-notice-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList($usArr, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'type')->dropDownList($model->adminTypesSelect) ?>

    <?= $form->field($model, 'text')->textInput(['maxlength' => true, 'placeholder' => 'Необходимо пополнить баланс для продолжения выгрузки по заказам']) ?>

    <?= $form->field($model, 'active')->dropDownList([1 => 'да', 0 => 'нет']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
