<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "За период";
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
JS;
$this->registerJs($js);
$filter = $_GET['filter'];
?>
<div class="bases-index">
    <h1>Статистика за период</h1>
</div>
<hr>
<?= Html::beginForm(['utm-stats'], 'GET') ?>
<div>
    <?php if(!empty($utms)): ?>
        <p><b>Выбрать метки</b></p>
        <p style="max-width: 400px">
            <select style="" data-placeholder="Выбрать несколько меток" class="chosen-select" multiple name="filter[utm][]" id="">
                <?php foreach($utms as $item): ?>
                    <option <?= !empty($filter['utm']) && in_array($item['name'], $filter['utm']) ? 'selected' : '' ?> value="<?= $item['name'] ?>"><?= $item['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </p>
    <p><button type="submit" class="btn btn-admin">Применить</button></p>
    <?php endif; ?>
</div>
<?= Html::endForm() ?>
<div style="overflow: auto">
    <?php if(!empty($statistics)): ?>
        <table class="table table-bordered">
            <tr style="background-color: #303030; color: whitesmoke">
                <?php foreach($statistics as $item): ?>
                    <td>
                        <p><b>Дата</b>: <?= date('d.m.Y H:i', strtotime($item['date'])) ?></p>
                        <span style="color: yellow"><b>Метка</b>: <?= $item['name'] ?></span>
                    </td>
                <?php endforeach; ?>
            </tr>
            <tr>
                <?php foreach($statistics as $item): ?>
                    <?php if ($item['total'] == 0) continue; ?>
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
                                        <p><b><?= $k->name ?></b> / <?= $k->geo ?> / <?= $k->provider ?></p>
                                    <?php endforeach; ?>
                                </td>
                            </tr>
                        </table>
                    </td>
                <?php endforeach; ?>
            </tr>
        </table>
    <?php endif; ?>
</div>
