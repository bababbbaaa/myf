<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\bootstrap\Alert;

/**
 * @var $this \yii\web\View
 */

$this->title = 'Выгрузка лидов по фильтрам из БД';
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
if (!Yii::$app->getUser()->can('exporter')) {
    $this->params['breadcrumbs'][] = ['label' => 'Таблица лидов', 'url' => ['/lead-force/leads/index']];
}
$this->params['breadcrumbs'][] = $this->title;


$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$jss = <<<JS
$('.chosen-select').chosen();
$('.reloadRegionSelect').on('click', function() {
    $('#findRegionSelect').html("<option value disabled selected>Введите город или регион</option>").trigger('chosen:updated');
});
JS;
$this->registerJsFile(Url::to(['/js/getRegionAjax.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($jss);


$responseXls = Yii::$app->session->getFlash('emptyResponse');
$bdSources = \common\models\LeadsBackdoor::find()->select('source')->groupBy('source')->asArray()->all();
?>
<style>
    .chosen-single {
        border-radius: 0 !important;
    }
</style>
<div>
    <?php if(!empty($responseXls)): ?>
    <?php echo Alert::widget([
            'options' => [
                'class' => 'alert-warning',
            ],
            'body' => $responseXls,
        ]); ?>
    <?php endif; ?>
    <h1>Задать параметры выборки</h1>
    <?= Html::beginForm(Url::to(['use-lead-export-filter-bd']), 'POST', ['id' => 'useFormFilter']) ?>
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-4" style="margin-bottom: 10px;">
            <p><b>Начиная с даты</b></p>
            <div>
                <?php
                echo DatePicker::widget([
                    'name' => 'filter[dateStart]',
                    'attribute' => 'dateStartFilter',
                    'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => date("Y-m-d", time() - 24*3600)],
                    'value' => '',
                    //'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd 00:00:00',
                ]);?>
            </div>
        </div>
        <div class="col-md-4" style="margin-bottom: 10px;">
            <p><b>Заканчивая датой</b></p>
            <div>
                <?php
                echo DatePicker::widget([
                    'name' => 'filter[dateStop]',
                    'attribute' => 'dateStopFilter',
                    'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => date("Y-m-d")],
                    'value' => '',
                    //'language' => 'ru',
                    'dateFormat' => 'yyyy-MM-dd 23:59:59',
                ]);?>
            </div>
        </div>
    </div>
    <div class="row region-block" style="margin-top: 15px;">
        <div class="col-md-6" style="margin-bottom: 10px">
            <p><b>Регион или город</b></p>
            <div>
                <select name="filter[region]" id="findRegionSelect" type="text" class="chosen-select form-control region-city-ajax-block inputRegionArray" >
                    <option  value="" selected disabled>Введите город или регион</option>
                </select>
            </div>
        </div>
        <div class="col-md-2" style="margin-bottom: 10px">
            <p style="height: 22px;"> </p>
            <div class="btn btn-admin-help reloadRegionSelect">Сбросить</div>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-4" style="margin-bottom: 10px">
            <p><b>Источник Бекдора</b></p>
            <div>
                <select name="filter[source]" id="" class="chosen-select form-control selectChangeClient">
                    <option value="">не указан</option>
                    <?php if (!empty($bdSources)): ?>
                        <?php foreach($bdSources as $key => $val): ?>
                            <option value="<?= $val['source'] ?>"><?= $val['source'] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
    </div>
    <div style="margin-top: 20px; display: flex; ">
        <div style="margin-right: 20px">
            <?= Html::submitButton('Выгрузить', ['class' => 'btn btn-admin']) ?>
        </div>
        <div>
            <div onclick="return location.reload()" class="btn btn-admin-delete">Сбросить фильтр</div>
        </div>
    </div>
    <?= Html::endForm() ?>
</div>
