<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainingsBlocks */
/* @var $form yii\widgets\ActiveForm */

$trainings = \common\models\SkillTrainings::find()->select(['name', 'id'])->asArray()->all();

$traArr = [];

if(!empty($trainings)) {
    foreach ($trainings as $item)
        $traArr[$item['id']] = $item['name'];
}
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5});
JS;

$this->registerJs($js);

?>

<div class="skill-trainings-blocks-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Введение', 'id' => 'textToLink']) ?>

    <?= $form->field($model, 'block_link')->textInput(['maxlength' => true, 'placeholder' => 'vvedenie', 'id' => 'linkText']) ?>

    <?= $form->field($model, 'sort_order')->input('number', ['placeholder' => '1']) ?>

    <?= $form->field($model, 'training_id')->dropDownList($traArr, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'small_description')->textInput(['maxlength' => true, 'placeholder' => 'Вы узнаете, как создавать рекламные объявления в популярных социальных сетях для конкретной аудитории.']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
