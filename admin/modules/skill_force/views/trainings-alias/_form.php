<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainingsAlias */
/* @var $form yii\widgets\ActiveForm */

$users = \common\models\UserModel::find()->where(['status' => 10])->asArray()->select(['username', 'email', 'id'])->all();
$uar = [];
if (!empty($users)) {
    foreach ($users as $item) {
        $uar[$item['id']] = "{$item['username']}";
        if (!empty($item['email']))
            $uar[$item['id']] .= ", {$item['email']}";
    }
}

$crs = \common\models\SkillTrainings::find()->select(['name', 'id'])->asArray()->all();
if (!empty($crs))
    $crs = \yii\helpers\ArrayHelper::map($crs, 'id', 'name');
else
    $crs = [];
$js = <<<JS
$('.chosen-select').chosen();
JS;

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);
?>

<div class="skill-trainings-alias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList($uar, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'course_id')->dropDownList($crs, ['class' => 'form-control chosen-select']) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
