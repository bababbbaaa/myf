<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Map */
/* @var $form yii\widgets\ActiveForm */

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5});
JS;
$this->registerJs($js);
$regions = [
        'central' => 'Центральный',
        'southern' => 'Южный',
        'northwestern' => 'Северозападный',
        'fareastern' => 'Дальневосточный',
        'siberian' => 'Сибирский',
        'urals' => 'Уральский',
        'volga' => 'Волга',
];
?>

<div class="map-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'partner_name')->textInput(['maxlength' => true, 'placeholder' => 'ООО "ФЭС"']) ?>

    <?= $form->field($model, 'city')->textInput(['maxlength' => true, 'placeholder' => 'г. Москва']) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => true, 'placeholder' => 'ул. Арбат, д. 14, оф. 15']) ?>

    <?= $form->field($model, 'region')->dropDownList($regions, ['class' => 'from-control chosen-select']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
