<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\AuthRule;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItem */
/* @var $form yii\widgets\ActiveForm */

$rules = AuthRule::find()->orderBy('updated_at desc')->select(['name'])->all();
$rArr = [
        null => 'Без привязки к правилу'
];
foreach ($rules as $item)
    $rArr[$item->name] = $item->name;
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$js = <<<JS
$(".chosen-select")
    .chosen({disable_search_threshold: 5});
JS;
$this->registerJs($js);

?>

<div class="auth-item-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'postCreator']) ?>

    <?= $form->field($model, 'type')->dropDownList([1 => 'Роль', 2 => 'Разрешение']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 2, 'style' => 'resize:none', 'placeholder' => 'Доступ к созданию записей блога']) ?>

    <?php echo $form->field($model, 'rule_name')->dropDownList($rArr, ['class' => 'form-control chosen-select']) ?>

    <?php //echo $form->field($model, 'data')->textInput() ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
