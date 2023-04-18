<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Leads */
/* @var $form yii\widgets\ActiveForm */

$types = \common\models\LeadsCategory::find()->select(['name', 'link_name'])->all();

$dbReg = \common\models\DbRegion::find()->select('name_with_type')->asArray()->all();
$regArr = [];
if (!empty($dbReg)) {
    foreach ($dbReg as $item)
        $regArr[$item['name_with_type']] = $item['name_with_type'];
}

asort($regArr);

$dbc = \common\models\DbCity::find()->select('city')->asArray()->all();
$cArr = [null => 'не указан'];
if (!empty($dbc)) {
    foreach ($dbc as $item)
        $cArr[$item['city']] = $item['city'];
}

asort($cArr);

$tArray = [];
foreach ($types as $item)
    $tArray[$item->link_name] = $item->name;

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5, allow_single_deselect:true });
JS;
$this->registerJs($js);

$categoryParams = \common\models\LeadsParams::find()->where(['category' => $model->type])->asArray()->all();
?>

<div class="leads-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ip')->textInput(['readonly' => true, 'value' => empty($model->id) ? '127.0.0.1' : $model->ip]) ?>

    <?= $form->field($model, 'source')->textInput(['readonly' => true, 'value' => empty($model->source) ? 'Ручной' : $model->source]) ?>

    <?= $form->field($model, 'type')->dropDownList($tArray, ['class' => 'from-control chosen-select']) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Василий Артин']) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'placeholder' => 'vasiliy@artin.com']) ?>

    <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => '+79188916600']) ?>

    <?= $form->field($model, 'region')->dropDownList($regArr, ['class' => 'from-control chosen-select']) ?>

    <?= $form->field($model, 'city')->dropDownList($cArr, ['class' => 'from-control chosen-select', 'data-placeholder' => 'Указать город, если есть']) ?>

    <?= $form->field($model, 'comments')->textarea(['rows' => 6, 'placeholder' => 'Хочет полностью списать долги']) ?>


    <?php if(!empty($categoryParams)): ?>
        <?php $params = $model->params; ?>
        <h3>Категориальные параметры</h3>
        <?php foreach($categoryParams as $item): ?>
        <div style="margin-bottom: 10px">
            <p><b><?= $item['description'] ?></b></p>
            <div>
                <?php if(!empty($item['cc_vars'])): ?>
                    <?php $cc = json_decode($item['cc_vars'], 1); ?>
                    <select class="form-control" name="SpecialParams[<?= $item['name'] ?>]" id="">
                        <option <?= empty($params[$item['name']]) ? 'selected' : '' ?> value="">выбрать...</option>
                        <?php foreach($cc as $k): ?>
                            <option <?= !empty($params[$item['name']]) && $params[$item['name']] == $k  ? 'selected' : '' ?> value="<?= $k ?>"><?= $k ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else: ?>
                    <input class="form-control" type="<?= $item['type'] === 'string' ? 'text' : 'number' ?>" name="SpecialParams[<?= $item['name'] ?>]" value="<?= !empty($params[$item['name']]) ? $params[$item['name']] : '' ?>">
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
