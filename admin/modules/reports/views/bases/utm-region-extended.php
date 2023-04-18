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
$filter = $_GET['filter'];
$regs = \common\models\DbRegion::find()
    ->select('name_with_type')
    ->asArray()
    ->orderBy('name_with_type')
    ->all();
$provs = Bases::find()
    ->select(['provider'])
    ->groupBy('provider')
    ->asArray()
    ->all();
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
            if ($utmToBase[$item['name']] === 'г Москва' || $utmToBase[$item['name']] === 'Московская обл')
                $regname = "МСК+МО";
            elseif($utmToBase[$item['name']] === 'г Санкт-Петербург' || $utmToBase[$item['name']] === 'Ленинградская обл')
                $regname = "СПБ";
            else
                $regname = $utmToBase[$item['name']];
            if (!empty($statsReg[$regname])) {
                $statsReg[$regname]['utm'][] = $item['name'];
                $statsReg[$regname]['total'] += $nameToStat[$item['name']]['total'];
                $statsReg[$regname]['is1Total'] += $nameToStat[$item['name']]['is1Total'];
                $statsReg[$regname]['isCcTotal'] += $nameToStat[$item['name']]['isCcTotal'];
                $statsReg[$regname]['is250Total'] += $nameToStat[$item['name']]['is250Total'];
            } else {
                $statsReg[$regname] = [
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
$regCc = \yii\helpers\ArrayHelper::map($bd, 'region', 'isCcTotal');
$reg250 = \yii\helpers\ArrayHelper::map($bd, 'region', 'is250Total');
$reg250H = \yii\helpers\ArrayHelper::map($bdh, 'region', 'is250Total');
foreach ($reg250 as $key => $item) {
    if ($key === 'г Москва' || $key === 'Московская обл')
        $regname = "МСК+МО";
    elseif($key === 'г Санкт-Петербург' || $key === 'Ленинградская обл')
        $regname = "СПБ";
    else
        $regname = $key;
    if (!isset($statsReg[$regname]))
        $statsReg[$regname] = [
            'utm' => ['only backdoor'],
            'total' => 0,
            'is1Total' => 0,
            'isCcTotal' => 0,
            'is250Total' => 0,
        ];
}
foreach ($reg250H as $key => $item) {
    if ($key === 'г Москва' || $key === 'Московская обл')
        $regname = "МСК+МО";
    elseif($key === 'г Санкт-Петербург' || $key === 'Ленинградская обл')
        $regname = "СПБ";
    else
        $regname = $key;
    if (!isset($statsReg[$regname]))
        $statsReg[$regname] = [
            'utm' => ['ручной'],
            'total' => 0,
            'is1Total' => 0,
            'isCcTotal' => 0,
            'is250Total' => 0,
        ];
}
$regCc['МСК+МО'] = (!empty($regCc['Московская обл']) ? $regCc['Московская обл'] : 0) + (!empty($regCc['г Москва']) ? $regCc['г Москва'] : 0);
$regCc['СПБ'] = (!empty($regCc['г Санкт-Петербург']) ? $regCc['г Санкт-Петербург'] : 0) + (!empty($regCc['Ленинградская обл']) ? $regCc['Ленинградская обл'] : 0);
$reg250['МСК+МО'] = (!empty($reg250['Московская обл']) ? $reg250['Московская обл'] : 0) + (!empty($reg250['г Москва']) ? $reg250['г Москва'] : 0);
$reg250['СПБ'] = (!empty($reg250['г Санкт-Петербург']) ? $reg250['г Санкт-Петербург'] : 0) + (!empty($reg250['Ленинградская обл']) ? $reg250['Ленинградская обл'] : 0);

$reg250H['МСК+МО'] = (!empty($reg250H['Московская обл']) ? $reg250H['Московская обл'] : 0) + (!empty($reg250H['г Москва']) ? $reg250H['г Москва'] : 0);
$reg250H['СПБ'] = (!empty($reg250H['г Санкт-Петербург']) ? $reg250H['г Санкт-Петербург'] : 0) + (!empty($reg250H['Ленинградская обл']) ? $reg250H['Ленинградская обл'] : 0);
unset($regCc['г Москва']);
unset($regCc['г Санкт-Петербург']);
unset($regCc['Московская обл']);
unset($regCc['Ленинградская обл']);
unset($reg250['г Москва']);
unset($reg250['г Санкт-Петербург']);
unset($reg250['Московская обл']);
unset($reg250['Ленинградская обл']);
unset($reg250H['г Москва']);
unset($reg250H['г Санкт-Петербург']);
unset($reg250H['Московская обл']);
unset($reg250H['Ленинградская обл']);
ksort($statsReg);
//print_r($statsReg);
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=export.xls");
?>
<?php if(!empty($statsReg)): ?>
    <table class="table table-bordered table-responsive table-striped" border="1" cellpadding="5">
        <tr>
            <th style="background-color: gray; color: black">Регион</th>
            <th style="background-color: gray; color: black">Метки</th>
            <th style="background-color: #22806d; color: black">Потрачено на прозвон</th>
            <th style="background-color: #487180; color: black">Потрачено на базы </th>
            <th style="background-color: #69a8b9; color: black">Количество базы</th>
            <th style="background-color: #22806d; color: black">Расход на КЦ</th>
            <th style="background-color: #69a8b9; color: black">Единичек пришло</th>
            <th style="background-color: #487180; color: black">Цена за единичку</th>
            <th style="background-color: #a8a272; color: black">Лидов с прозвона менее 250к</th>
            <th style="background-color: #a8a272; color: black">Лидов с БД менее 250к</th>
            <th style="background-color: #e2de00; color: black">Всего Лидов</th>
            <th style="background-color: #b3c9d9; color: black">Цена Лида с прозвона</th>
            <th style="background-color: #b3c9d9; color: black">Расход БД</th>
            <th style="background-color: #22806d; color: black">Общая цена Лида</th>
            <th style="background-color: #6eab5f; color: black">Целевых лидов с прозвона</th>
            <th style="background-color: #6eab5f; color: black">Целевых лидов с БД</th>
            <th style="background-color: #03f800; color: black">Всего Целевых</th>

            <th style="background-color: #f8a9a9; color: black">Ручной лид</th>

            <th style="background-color: #69a8b9; color: black">Цена целевого (прозвон)</th>
            <th style="background-color: #69a8b9; color: black">Цена целевого (БД)</th>
            <th style="background-color: #b9a944; color: black">Цена целевого с пл. источников</th>
            <th style="background-color: #00afb9; color: black">Общая цена целевого</th>
            <th style="background-color: #004513; color: white">Выгода с 1 лида бл. ручным</th>
            <th style="background-color: #004513; color: white">Прибыль с 1 лида</th>
            <th style="background-color: #490067; color: white">Прибыль со всех лидов</th>
            <th style="background-color: #00bf02; color: #000000">Прибыль со всех Целевых Лидов</th>
            <th style="background-color: #ecf900; color: #000000">Лидов куплено на</th>
            <th style="background-color: #9000b9; color: #ffffff">Конверсии</th>
            <th style="background-color: #b90078; color: black">Контакт/Единичка</th>
        </tr>
        <?php
            $defaultBdPrice = 15;
            if (!empty($_GET['bd_lead_price']))
                $defaultBdPrice = (int)$_GET['bd_lead_price'];
        ?>
        <?php $totalWaste = 0; ?>
        <?php $totalCountNon250 = 0; ?>
        <?php $totalCount250 = 0; ?>
        <?php foreach($statsReg as $key => $item): ?>
            <?php $bd250 = $reg250[$key] ?? 0 ?>
            <?php $bdCC = $regCc[$key] ?? 0; #TODO: лидов с БД Сумма менее 250к  ?>
            <?php
            if ($bdCC < $bd250)
                $bdCC = $bd250;
            ?>
            <?php
            $bd250H = $reg250H[$key] ?? 0;
            ?>
            <?php
                $baseRash = !empty($baseFunds[$key]) ? array_sum($baseFunds[$key]) : 0;
                if (mb_stripos($key, 'МСК') !== false || mb_stripos($key, 'СПБ') !== false)
                    $price = $_GET['msk_price'];
                else
                    $price = $_GET['region_price'];
            ?>
            <tr>
                <td><?= $key ?></td> <?php #todo: регион ?>
                <td><?php #todo: метки ?>
                    <?php $counts = \admin\models\BasesUtm::find()->where(['in', 'name', $item['utm']])->count(); ?>
                    <?php foreach($item['utm'] as $u): ?>
                        <p>
                            <?= $u ?>
                        </p>
                    <?php endforeach; ?>
                </td>
                <td><?php #todo: потрачено на прозвон ?>
                    <?= $rashObz = !empty($obzvonFunds[$key]) ? array_sum($obzvonFunds[$key]) : 0 ?>
                    <?php $totalWaste += $rashObz; ?>
                </td>
                <td><?php #todo: потрачено на базы ?>
                    <?= $baseRash ?>
                </td>
                <td><?= $counts ?></td><?php #todo: количество базы ?>
                <td>
                    <?= $rashKc = ($item['is1Total'] + $bdCC + $bd250H) * $defaultBdPrice ?> <?php #todo: расход кц ?>
                </td>
                <td>
                    <?= $item['is1Total'] ?> <?php #todo: единичек пришло ?>
                </td>
                <?php $cenaIs1 = $item['is1Total'] > 0 ? round(($rashObz)/$item['is1Total'], 2) : 0; ?>
                <td style="background-color: <?= round($price * 0.6, 2) <= $cenaIs1 ? 'red' : 'white' ?>">
                    <?= str_replace('.', ',', $cenaIs1) ?> <?php #todo: цена за единичку ?>
                </td>
                <td>
                    <?= $item['isCcTotal']  ?> <?php #todo: лидов с прозвона Сумма менее 250к ?>
                </td>
                <td>
                    <?= $bdCC ?>
                </td>
                <td>
                    <?= $ttl = $item['total'] + $bdCC + $bd250H ?> <?php #todo: всего лидов ------ ?>
                    <?php $totalCountNon250 += $ttl; ?>
                </td>
                <?php $cenaLida = $item['isCcTotal'] > 0 ? round(($rashKc + $rashObz)/$item['isCcTotal'], 2) : 0  ?>
                <td style="background-color: <?= round($price * 0.6, 2) <= $cenaLida ? 'red' : 'white' ?>">
                    <?= str_replace('.', ',', $cenaLida) ?> <?php #todo: цена лида с прозвона ?>
                </td>
                <td>
                    <?php $rashodBd = $defaultBdPrice * ($bdCC)  ?>
                    <?= str_replace('.', ',', $rashodBd)  ?> <?php #todo: расход БД ?>
                    <?php $totalWaste += $rashodBd; ?>
                </td>
                <?php $obshCenaLida = $ttl > 0 ? round(($rashKc + $rashObz + $baseRash)/$ttl, 2) : 0 ?>
                <td style="background-color: <?= round($price * 0.6, 2) <= $obshCenaLida ? 'red' : 'white' ?>">
                    <?= str_replace('.', ',', $obshCenaLida)  ?> <?php #todo: общая цена лида ?>
                </td>
                <td>
                    <?= $item['is250Total'] ?> <?php #todo: целевых лидов с прозвона ?>
                </td>
                <td>
                    <?= $bd250H; #TODO: целевых лидов с БД  ?>
                    <?php $totalCount250 += $item['is250Total'] + $bd250H; ?>
                </td>
                <td>
                    <?= $total250 =  $item['is250Total'] + $bd250H; ?> <?php #todo: всего целевых ------ ?>
                </td>

                <td><?= $bd250H ?></td> <?php #todo: всего ручных ?>

                <?php $totalCenaProzvon = $item['is250Total'] > 0 ? round(($rashKc + $rashObz + $baseRash)/$item['is250Total'], 2) : 0 ?>
                <td style="background-color: <?= round($price * 0.6, 2) <= $totalCenaProzvon ? 'red' : 'white' ?>">
                    <?= str_replace('.', ',', $totalCenaProzvon)  ?> <?php #todo: цена целевого прозвон ?>
                </td>
                <?php $totalCenaBd = $bd250 > 0 ? round(($rashodBd)/$bd250, 2) : 0 ?>
                <td>
                    <?= str_replace('.', ',', $totalCenaBd)  ?> <?php #todo: цена целевого БД ?>
                </td>
                <?php $totalPriceAtAll = $item['is250Total'] + $bd250 > 0 ? round(($rashObz + $rashKc + $baseRash + $rashodBd)/($item['is250Total'] + $bd250), 2) : $totalCenaProzvon ?>
                <td style="background-color: <?= round($price * 0.6, 2) <= $totalPriceAtAll ? 'red' : 'white' ?>">
                    <?=  str_replace('.', ',', $totalPriceAtAll) ?> <?php #todo: цена целевого с пл. ист ?>
                </td>
                <?php $totalPriceAtAll2 = $total250 > 0 ? round(($rashObz + $rashKc + $baseRash)/($total250), 2) : $totalCenaProzvon ?>
                <td style="background-color: <?= round($price * 0.6, 2) <= $totalPriceAtAll2 ? 'red' : 'white' ?>">
                    <?=  str_replace('.', ',', $totalPriceAtAll2) ?> <?php #todo: общая цена целевого  ?>
                </td>

                <td>
                    <?php  $beta = $totalPriceAtAll - $totalPriceAtAll2 ?>
                    <?=  str_replace('.', ',', $beta) ?> <?php #todo: выгода с 1 лида бл ручным ?>
                </td>
                <td>
                    <?php  $beta2 = $price - $totalPriceAtAll2 ?>
                    <?=  str_replace('.', ',', $beta2) ?> <?php #todo: прибыль с 1 лида ?>
                </td>
                <td>
                    <?php $tetz0 = $beta2 * $ttl ?>
                    <?=  str_replace('.', ',', $tetz0) ?> <?php #todo: прибыль со всех лидов ?>
                </td>
                <td>
                    <?php  $tetz1 = $beta2 * $total250 ?>
                    <?=  str_replace('.', ',', $tetz1) ?> <?php #todo: прибыль со всех целевых ?>
                </td>
                <td>
                    <?php $tetz2 = $price * $ttl ?>
                    <?=  str_replace('.', ',', $tetz2) ?> <?php #todo: лидов куплено на ?>
                </td>

                <td> <?php #todo: конверсии ?>
                    <?php if($counts > 0): ?>
                        <p><b>Из базы в единичку: </b> <?= round($item['is1Total'] / $counts, 4) * 100 ?>%</p>
                        <?php if($item['is1Total'] > 0): ?>
                            <p><b>Из единички в ЛИД: </b> <?= round($item['isCcTotal'] / $item['is1Total'], 4) * 100 ?>%</p>
                        <?php endif; ?>
                        <?php if($item['is250Total'] > 0): ?>
                            <p><b>Конверсия от 250к: </b> <?= round($item['is250Total'] / $counts, 4) * 100 ?>%</p>
                        <?php endif; ?>
                        <?php if($bdCC + $bd250 > 0): ?>
                            <p><b>Конверсия из БД от 250к: </b> <?= round($bd250 / ($bd250 + $bdCC), 4) * 100 ?>%</p>
                        <?php endif; ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td> <?php #todo: контакт/единичка ?>
                    <?php $ctd2 = $item['is1Total'] > 0 ? round($counts / $item['is1Total'], 1) : '-' ?>
                    <?=  str_replace('.', ',', $ctd2) ?>
                </td>
            </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="8"><b>Итого потрачено: <?= $totalWaste ?></b></td>
            <td colspan="7"><b>Итого нецелевых: <?= $totalCountNon250 ?></b></td>
            <td colspan="7"><b>Итого целевых: <?= $totalCount250 ?></b></td>
        </tr>
        <tr>
            <td colspan="22" style="background-color: greenyellow; color: black; text-align: center"><b style="">ВСЕГО ЛИДОВ: <?= $totalCountNon250 + $totalCount250?></b></td>
        </tr>
    </table>
<?php endif; ?>
