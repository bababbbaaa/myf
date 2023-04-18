<?php

use yii\helpers\Url;
use yii\jui\DatePicker;
use common\models\LeadsCategory;

$this->title = 'Статистика по лидам';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/reports/main/index']),
    'label' => 'Статистика'
];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Url::to(['/js/chart.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
$('.chosen-select').chosen();
JS;
$this->registerJs($js);

$cats = LeadsCategory::find()->select(['name', 'link_name'])->asArray()->all();
$sources = \common\models\LeadsSources::find()->asArray()->all();
?>
<style>
    .flex-block {
        display: flex;
        flex-wrap: wrap;
    }
    .flex-block > div {
        margin-right: 10px;
        margin-bottom: 10px;
    }
</style>
<hr>

<div>
    <?= \yii\helpers\Html::beginForm('leads', 'GET') ?>
    <h3>Фильтры</h3>
    <div class="flex-block">
        <div>
            <?php
            echo DatePicker::widget([
                'name' => 'date_start',
                'attribute' => 'dateStartFilter',
                'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => date("Y-m-d", time() - 24 * 7 * 3600)],
                'value' => $_GET['date_start'],
                //'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd',
            ]);?>
        </div>
        <div>
            <?php
            echo DatePicker::widget([
                'name' => 'date_stop',
                'attribute' => 'dateStartFilter',
                'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => date("Y-m-d")],
                'value' => $_GET['date_stop'],
                //'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd',
            ]);?>
        </div>
        <div>
            <button type="submit" class="btn btn-admin">Применить</button>
        </div>
    </div>
    <div class="flex-block">
        <div style="max-width: 200px; width: 100%">
            <select name="area" class="form-control chosen-select">
                <option value="" <?= empty($_GET['area']) ? 'selected' : ''; ?>>Любая сфера</option>
                <?php if(!empty($cats)): ?>
                    <?php foreach($cats as $item): ?>
                        <option <?= !empty($_GET['area']) && $_GET['area'] === $item['link_name'] ? 'selected' : ''; ?> value="<?= $item['link_name'] ?>" ><?= $item['name'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div style="max-width: 200px; width: 100%">
            <input type="text" class="form-control" placeholder="спишемдолг" value="<?= $_GET['source'] ?? '' ?>" name="source">
        </div>
    </div>
    <?= \yii\helpers\Html::endForm() ?>
    <div style="display: block;">
        <div style="max-width: 100%; width: 100%; margin-right: 20px">
            <h3>Поступление лидов по дням</h3>
            <div>
                <?= $this->render('graphs/_lead_by_day', ['range' => $range, 'leads' => $leads]); ?>
            </div>
        </div>
    </div>
</div>

