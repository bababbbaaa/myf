<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\DevPaymentsAlias */
/* @var $form yii\widgets\ActiveForm */

$users = \common\models\User::find()->asArray()->select('id, username')->all();
$client = [];
foreach ($users as $v)
    $client[$v['id']] = $v['username'];
$projects = \common\models\DevProject::find()->where(['!=', 'status', 'Выполнен'])->asArray()->select('id, name')->all();
$project = [];
foreach ($projects as $v)
    $project[$v['id']] = $v['name'];
$js =<<< JS
    $(".chosen-select").chosen({disable_search_threshold: 0});

JS;
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);

?>

<div class="dev-payments-alias-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->dropDownList($client, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'project_id')->dropDownList($project, ['class' => 'form-control chosen-select']) ?>

    <?= $form->field($model, 'summ')->input('number', ['placeholder' => '4000']) ?>

    <?= $form->field($model, 'status')->dropDownList(['Не оплачено' => 'Не оплачено', 'Оплачено' => 'Оплачено',]) ?>

    <?= $form->field($model, 'when_pay')->widget(DatePicker::classname(), [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => ['class' => 'form-control', 'placeholder' => '2022-03-15'],
    ]) ?>

    <div style="display: none">
        <?= $form->field($model, 'date_pay')->widget(DatePicker::classname(), [
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control', 'placeholder' => '2022-03-15'],
        ]) ?>
    </div>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
