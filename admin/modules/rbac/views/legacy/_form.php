<?php

use common\models\AuthItem;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItemChild */
/* @var $form yii\widgets\ActiveForm */

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5});
JS;
$roles = AuthItem::find()->select(['name', 'description', 'type'])->all();
$rArray = [];
$groupDef = [
    1 => 'Роль',
    2 => 'Разрешение',
];
foreach ($roles as $item)
    $rArray[$groupDef[$item->type]][$item->name] = $item->description;
$this->registerJs($js);
?>

<div class="auth-item-child-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'parent')->dropDownList($rArray, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'child')->dropDownList($rArray, ['class' => 'form-control chosen-select']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
