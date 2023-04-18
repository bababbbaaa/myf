<?php

use common\models\AdsPerformers;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdsOrders */
/* @var $form yii\widgets\ActiveForm */

$clients = User::find()->asArray()->select('id, username')->where(['is_performers' => -1])->all();
$clientArr = [];
foreach ($clients as $i)
    $clientArr[$i['id']] = $i['username'];

$performers = AdsPerformers::find()->asArray()->select('id, user_id, fio')->all();
$performersArr = [];
foreach ($performers as $i)
    $performersArr[$i['id']] = $i['user_id'] . ": " . $i['fio'];

$spec = \common\models\AdsSpecializations::find()->asArray()->all();
$specArr = [];
foreach ($spec as $i)
    $specArr[$i['name']] = $i['name'];

$platform = \common\models\AdsPlatform::find()->asArray()->all();
$platformArr = [];
foreach ($platform as $i)
    $platformArr[$i['name']] = $i['name'];

if (!empty($model->specialization)){
    $specializaite = $model->specialization;
} else {
    $specializaite = '[]';
}
if (!empty($model->platform)){
    $platform = $model->platform;
} else {
    $platform = '[]';
}

$js =<<< JS
var specializ = JSON.parse('$specializaite'),
    platform = JSON.parse('$platform');
$('#adsorders-specialization').val(specializ);
$('#adsorders-platform').val(platform);
$(".chosen-select").chosen({disable_search_threshold: 0});
JS;

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);
?>

<div class="ads-orders-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true, 'placeholder' => 'Укажите название']) ?>

    <?= $form->field($model, 'specialization')->dropDownList($specArr, ['multiple' => true, 'class' => 'chosen-select']) ?>

    <?= $form->field($model, 'platform')->dropDownList($platformArr, ['multiple' => true, 'class' => 'chosen-select']) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6, 'placeholder' => 'Описание заказа']) ?>

    <?= $form->field($model, 'file')->textInput(['maxlength' => true, 'placeholder' => 'https://docs.google.com/spreadshesets/d/1gNYCsSDCB_4FDFSQq4wAHq73H5sd25wAkGhtnXBAMPahckpeq3123w3E/edit#gid=1735931333618']) ?>

    <?= $form->field($model, 'date_end')->widget(DatePicker::class, [
        'language' => 'ru',
        'dateFormat' => 'yyyy-MM-dd',
        'options' => [
            'placeholder' => '01.02.2021',
            'class' => 'form-control',
            'autocomplete' => 'off'
        ],
    ]);
    ?>

    <?= $form->field($model, 'budjet')->input('number', ['placeholder' => '25500']) ?>

    <?= $form->field($model, 'client_id')->dropDownList($clientArr, ['class' => 'chosen-select']) ?>

    <?= $form->field($model, 'performers_id')->dropDownList($performersArr, ['class' => 'chosen-select']) ?>

    <?= $form->field($model, 'status')->dropDownList(['Поиск исполнителя' => 'Поиск исполнителя', 'Принят в работу' => 'Принят в работу', 'Выполнен' => 'Выполнен', 'Завершен' => 'Завершен', 'Оценка работы' => 'Оценка работы',]) ?>

    <div style="display: none">
        <?= $form->field($model, 'date')->textInput() ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
