<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\User;
use common\models\AuthItem;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\AuthAssignment */
/* @var $form yii\widgets\ActiveForm */

$users = User::find()->orderBy('id desc')->select(['id', 'username'])->all();
$roles = AuthItem::find()->select(['name', 'description', 'type'])->all();
$rArray = [];
$usArray = [];
$groupDef = [
    1 => 'Роль',
    2 => 'Разрешение',
];
foreach ($users as $item)
    $usArray[$item->id] = $item->username;
foreach ($roles as $item)
    $rArray[$groupDef[$item->type]][$item->name] = $item->description;

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5});
JS;

$this->registerJs($js);
?>

<div class="auth-assignment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'item_name')->dropDownList($rArray, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'user_id')->dropDownList($usArray, ['class' => 'form-control chosen-select']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
