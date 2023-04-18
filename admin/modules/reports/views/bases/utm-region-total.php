<?php


/**
 * @var \admin\models\BasesConversion[] $statistics
 */

use admin\models\Bases;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;

$this->title = "Суммарная статистика по регионам";
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
$('#regAjax').on('submit', function (e) {
    var form = $(this);
    e.preventDefault();
    $.ajax({
        dataType: "JSON",
        type: form.attr('method'),
        data: form.serialize(),
        url: "/reports/bases/make-table"
    }).done(function (response) {
        if(response.error) {
            Swal.fire({
                icon: 'error',
                title: 'Ошибка',
                text: response.message,
                onClose: function(e) {
                    location.reload();
                }
            });
        } else
            Swal.fire({
                icon: 'success',
                title: 'Ok',
                text: response.message,
                onClose: function(e) {
                    location.reload();
                }
            });
    });
});
JS;
$this->registerJs($js);
$filter = $_GET['filter'];
$regs = \common\models\DbRegion::find()->select('name_with_type')->asArray()->orderBy('name_with_type')->all();
$provs = Bases::find()->select(['provider'])->groupBy('provider')->asArray()->all();
$statsReg = [];
if (!empty($statistics)) {
    $arrayUtm = \yii\helpers\ArrayHelper::map($statistics, 'id', 'name');
    $nameToStat = [];
    foreach ($statistics as $item) {
        $nameToStat[$item['name']] = $item;
    }
    $utmsTable = \admin\models\BasesUtm::find()
        ->where(['in', 'name', $arrayUtm])
        ->groupBy('name')
        ->asArray()
        ->all();
    if (!empty($utmsTable)) {
        $baseToName = \yii\helpers\ArrayHelper::map($utmsTable, 'name', 'base_id');
        $nameToBase = array_flip($baseToName);
        $bases = Bases::find()->where(['in', 'id', $baseToName])->asArray()->all();
        $utmToBase = [];
        foreach ($bases as $item) {
            $utmToBase[$nameToBase[$item['id']]] = $item['geo'];
        }
        foreach ($utmsTable as $item) {
            if (!empty($statsReg[$utmToBase[$item['name']]])) {
                $statsReg[$utmToBase[$item['name']]]['total'] += $nameToStat[$item['name']]['total'];
                $statsReg[$utmToBase[$item['name']]]['utm'][] = $item['name'];
                $statsReg[$utmToBase[$item['name']]]['is1Total'] += $nameToStat[$item['name']]['is1Total'];
                $statsReg[$utmToBase[$item['name']]]['isCcTotal'] += $nameToStat[$item['name']]['isCcTotal'];
                $statsReg[$utmToBase[$item['name']]]['is250Total'] += $nameToStat[$item['name']]['is250Total'];
            } else {
                $statsReg[$utmToBase[$item['name']]] = [
                    'utm' => [$item['name']],
                    'total' => $nameToStat[$item['name']]['total'],
                    'is1Total' => $nameToStat[$item['name']]['is1Total'],
                    'isCcTotal' => $nameToStat[$item['name']]['isCcTotal'],
                    'is250Total' => $nameToStat[$item['name']]['is250Total'],
                ];
            }
        }
    }
}
ksort($statsReg);
?>
<div class="bases-index">
    <h1>Суммарная статистика по регионам</h1>
</div>
<hr>
<?= Html::beginForm(['utm-region-total'], 'GET') ?>
<div>
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
    <p><button type="submit" class="btn btn-admin">Применить</button></p>
</div>
<?= Html::endForm() ?>
<hr>
<h3>Подробный отчет</h3>
<?= Html::beginForm(['utm-region-extended'], 'POST', ['id' => 'regAjax'])?>
<?php foreach($_GET as $key => $item): ?>
    <?php if(is_array($item)): ?>
        <?php foreach($item as $k => $v): ?>
            <input type="hidden" name="<?= $key ?>[<?= $k ?>]" value="<?= $v ?>">
        <?php endforeach; ?>
    <?php else: ?>
        <input type="hidden" name="<?= $key ?>" value="<?= $item ?>">
    <?php endif; ?>
<?php endforeach; ?>
<div style="display: flex; flex-wrap: wrap">
    <div style="margin-right: 10px; margin-bottom: 10px">
        <input type="text" class="form-control" placeholder="Цена за кц: 15" name="bd_lead_price">
    </div>
    <div style="margin-right: 10px; margin-bottom: 10px">
        <input type="text" class="form-control" placeholder="Цена за МСК+СПБ: 790" name="msk_price">
    </div>
    <div style="margin-right: 10px; margin-bottom: 10px">
        <input type="text" class="form-control" placeholder="Цена за Регионы: 700" name="region_price">
    </div>
</div>
<button type="submit" class="btn btn-admin-help">Скачать подробный отчет</button>
<?php if (file_exists("/home/master/web/myforce.ru/public_html/admin/web/leads_2_1.csv")): ?>
<div style="padding: 10px"><a href="/leads_2_1.csv" download>ссылка для скачивания</a></div>
<?php endif; ?>
<?= Html::endForm()?>
<hr>
<div style="overflow: auto">
    <?php if(!empty($statsReg)): ?>
        <table class="table table-bordered table-responsive table-striped">
            <tr style="background: #303030; color: whitesmoke">
                <th>Регион</th>
                <th>Метки</th>
                <th>Статистика</th>
                <th>Конверсии</th>
                <th>Расходы</th>
            </tr>
            <?php foreach($statsReg as $key => $item): ?>
                <tr>
                    <td><?= $key ?></td>
                    <td>
                        <?php foreach($item['utm'] as $u): ?>
                            <p><?= $u ?></p>
                        <?php endforeach; ?>
                    </td>
                    <td>
                        <p><b>Всего:</b> <?= $item['total'] ?></p>
                        <p><b>Новых с обзвона:</b> <?= $item['is1Total'] ?></p>
                        <p><b>Сумма менее 250к:</b> <?= $item['isCcTotal'] ?></p>
                        <p><b>Сумма от 250к:</b> <?= $item['is250Total'] ?></p>
                    </td>
                    <td>
                        <?php if($item['total'] > 0): ?>
                            <p><b>Новых с обзвона: </b> <?= round($item['is1Total'] / $item['total'], 4) * 100 ?>%</p>
                            <p><b>Сумма менее 250к: </b> <?= round($item['isCcTotal'] / $item['total'], 4) * 100 ?>%</p>
                            <?php if($item['is1Total'] > 0): ?>
                                <p><b>Из единички в ЛИД: </b> <?= round($item['isCcTotal'] / $item['is1Total'], 4) * 100 ?>%</p>
                            <?php endif; ?>
                            <?php if($item['is250Total'] > 0): ?>
                                <p><b>Конверсия от 250к: </b> <?= round($item['is250Total'] / $item['total'], 4) * 100 ?>%</p>
                            <?php endif; ?>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <p><b>Базы:</b> <?= !empty($baseFunds[$key]) ? array_sum($baseFunds[$key]) : 0 ?> руб.</p>
                        <p><b>Обзвон:</b> <?= !empty($obzvonFunds[$key]) ? array_sum($obzvonFunds[$key]) : 0 ?> руб.</p>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Статистика не найдена или пустой фильтр</p>
    <?php endif; ?>
</div>
