<?php


use admin\models\Bases;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;

$this->title = "Динамическая статистика прозвона";
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/reports/main/index']),
    'label' => 'Статистика'
];
$this->params['breadcrumbs'][] = ['label' => 'Базы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Статистика по меткам', 'url' => ['stats']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
$('.chosen-select').chosen();
$('.change-type').on('change', function() {
    var val = $(this).val();
    $('.show-con').each(function() {
        $(this).hide();
    });
    $('.show-con[data-type="'+ val +'"]').show();
});
JS;
$this->registerJs($js);
$filter = $_GET['filter'];
$regs = \common\models\DbRegion::find()->select('name_with_type')->asArray()->orderBy('name_with_type')->all();
$provs = Bases::find()->select(['provider'])->groupBy('provider')->asArray()->all();
?>
<div class="bases-index">
    <h1>Динамическая статистика</h1>
</div>
<hr>
<?= Html::beginForm(['utm-dynamic'], 'GET') ?>
<div>
    <div>
        <p><b>Тип статистики</b></p>
        <p>
            <select class="form-control change-type" name="type" id="">
                <option <?= empty($_GET['type']) || $_GET['type'] === 'utm' ? 'selected' : '' ?> value="utm">По меткам</option>
                <option <?= !empty($_GET['type']) && $_GET['type'] === 'region' ? 'selected' : '' ?> value="region">По региону</option>
                <option <?= !empty($_GET['type']) && $_GET['type'] === 'provider' ? 'selected' : '' ?> value="provider">По поставщику</option>
            </select>
        </p>
    </div>
    <div style="display: flex; flex-wrap: wrap">
        <div style="margin-right: 10px">
            <p><b>Начиная с даты</b></p>
            <p>
                <?php
                echo DatePicker::widget([
                    'name' => 'filter[date_start]',
                    'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => '01-09-2021'],
                    'value' => $filter['date_start'] ?? '',
                    //'language' => 'ru',
                    'dateFormat' => 'dd-MM-yyyy',
                ]);?>
            </p>
        </div>
        <div style="margin-right: 10px">
            <p><b>Заканчивая датой</b></p>
            <p>
                <?php
                echo DatePicker::widget([
                    'name' => 'filter[date_stop]',
                    'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => '12-09-2021'],
                    'value' => $filter['date_stop'] ?? '',
                    //'language' => 'ru',
                    'dateFormat' => 'dd-MM-yyyy',
                ]);?>
            </p>
        </div>
    </div>
    <div class="show-con" data-type="region" style="display: <?= !empty($_GET['type']) && $_GET['type'] === 'region' ? 'block' : 'none' ?>; margin-bottom: 10px; " >
        <p><b>Регион</b></p>
        <select name="filter[region]" class="form-control chosen-select" id="">
            <?php foreach($regs as $item): ?>
                <option <?= !empty($filter['region']) && $filter['region'] == $item['name_with_type'] ? 'selected' : '' ?> value="<?= $item['name_with_type'] ?>"><?= $item['name_with_type'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="show-con" data-type="provider" style="display: <?= !empty($_GET['type']) && $_GET['type'] === 'provider' ? 'block' : 'none' ?>; margin-bottom: 10px; " >
        <p><b>Поставщик</b></p>
        <select name="filter[provider]" class="form-control chosen-select" id="">
            <?php foreach($provs as $item): ?>
                <option <?= !empty($filter['provider']) && $filter['provider'] == $item['provider'] ? 'selected' : '' ?> value="<?= $item['provider'] ?>"><?= $item['provider'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <p><button type="submit" class="btn btn-admin">Применить</button></p>
</div>
<?= Html::endForm() ?>
<div style="overflow: auto">
    <?php if(!empty($statistics)): ?>
        <table class="table table-bordered">
            <tr style="background-color: #303030; color: whitesmoke">
                <?php foreach($statistics as $item): ?>
                    <td>
                        <p><b>Дата</b>: <?= date('d.m.Y', strtotime($item['date'])) ?></p>
                        <span style="color: yellow"><b>Метка</b>: <?= $item['name'] ?></span>
                    </td>
                <?php endforeach; ?>
                <td>
                    <p><b>Общие показатели</b></p>
                </td>
            </tr>
            <tr>
                <?php
                    $srVal = [
                       'total' => 0,
                       'is1Total' => 0,
                       'isCcTotal' => 0,
                    ];
                ?>
                <?php foreach($statistics as $item): ?>
                    <?php if ($item['total'] == 0) continue; ?>
                    <?php
                        $srVal['total'] += $item['total'];
                        $srVal['is1Total'] += $item['is1Total'];
                        $srVal['isCcTotal'] += $item['isCcTotal'];
                     ?>
                    <td>
                        <table class="table table-bordered" style="width: 300px">
                            <tr>
                                <th>Всего</th>
                                <td><?= $item['total'] ?></td>
                            </tr>
                            <tr>
                                <th>Единичек</th>
                                <td><?= $item['is1Total'] ?></td>
                            </tr>
                            <tr>
                                <th>После КЦ</th>
                                <td><?= $item['isCcTotal'] ?></td>
                            </tr>
                            <tr>
                                <th>Конверсии</th>
                                <td>
                                    <p>В единичку: <?= round($item['is1Total'] / $item['total'], 3) * 100 ?>%</p>
                                    <p>В лиды: <?= round($item['isCcTotal'] / $item['total'], 3) * 100 ?>%</p>
                                    <?php if($item['is1Total'] > 0): ?>
                                        <p>Из единички в лиды: <?= round($item['isCcTotal'] / $item['is1Total'], 3) * 100 ?>%</p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Базы</th>
                                <td>
                                    <?php foreach($item['bases'] as $k): ?>
                                        <?php if($_GET['type'] === 'region' && $filter['region'] !== $k->geo): ?>
                                            <?php continue ?>
                                        <?php endif; ?>
                                        <?php if($_GET['type'] === 'provider' && $filter['provider'] !== $k->provider): ?>
                                            <?php continue ?>
                                        <?php endif; ?>
                                        <p><b><?= $k->name ?></b> / <?= $k->geo ?> / <?= $k->provider ?></p>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                <?php endforeach; ?>
                <td>
                    <table class="table table-bordered" style="width: 300px">
                        <tr>
                            <th>Всего</th>
                            <td><?= $srVal['total'] ?></td>
                        </tr>
                        <tr>
                            <th>Единичек</th>
                            <td><?= $srVal['is1Total'] ?></td>
                        </tr>
                        <tr>
                            <th>После КЦ</th>
                            <td><?= $srVal['isCcTotal'] ?></td>
                        </tr>
                        <tr>
                            <th>Конверсии</th>
                            <td>
                                <p>В единичку: <?= round($srVal['is1Total'] / $srVal['total'], 3) * 100 ?>%</p>
                                <p>В лиды: <?= round($srVal['isCcTotal'] / $srVal['total'], 3) * 100 ?>%</p>
                                <?php if($srVal['is1Total'] > 0): ?>
                                    <p>Из единички в лиды: <?= round($srVal['isCcTotal'] / $srVal['is1Total'], 3) * 100 ?>%</p>
                                <?php endif; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    <?php else: ?>
        <p>Статистика не найдена или пустой фильтр</p>
    <?php endif; ?>
</div>
