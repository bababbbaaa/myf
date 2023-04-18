<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\Franchise;

/* @var $this yii\web\View */
/* @var $model common\models\FranchiseReviews */
/* @var $form yii\widgets\ActiveForm */

$franchise = Franchise::find()->orderBy('id desc')->all();
$array = [];
if (!empty($franchise)) {
    foreach ($franchise as $item) {
        $array[$item->id] = $item->name;
    }
}

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5});
JS;

$this->registerJs($js);

?>

<div class="franchise-reviews-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'franchise_id')->dropDownList($array, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'rating')->input('number', ['placeholder' => '100', 'max' => 100, 'min' => 0, 'step' => 5]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true, 'placeholder' => 'Василий Артин, группа компаний «ФЭС»']) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6, 'style' => 'resize:none', 'placeholder' => 'До покупки франшизы работал маркетологом, всегда хотелось и зарабатывать больше и попробовать себя в бизнесе. Пробовать самостоятельно было страшно, так как опыта не было совсем (всегда в найме работал). Решил, что лучшее время для чего-то нового — это кризис. Поискал уже готовые франшизы, франшиза Фемиды показалась наиболее проработанной. Ну и решил рискнуть.']) ?>

    <?= $form->field($model, 'is_active')->dropDownList([1 => 'Активен', 0 => "Неактивен"]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
