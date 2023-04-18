<?php

use yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = $this->title;
$js = <<<JS
var timeout = null;
$('.save-product-summ').on('input', function (e) {
    var id = $(this).attr('data-save');
    var value = $(this).val();
    if (timeout !== null)
        clearTimeout(timeout);
    timeout = setTimeout(function () {
        $.ajax({
            data: {id: id, value: value},
            type: "POST",
            dataType: "JSON",
            url: "/lead-force/leads/ltv-save"
        }).done(function (rsp) {
            if (!rsp.status)
                alert(rsp.message);
        });
    }, 300);
});
$('.project-add').on('click', function (e) {
    var client = $(this).attr('data-client');
    e.preventDefault();
    $.ajax({
        url: "/lead-force/leads/ltv-add-form",
        dataType: "HTML",
        data: {id: client}
    }).done(function (response) {
        $('.project-placer-form').html(response);
    });
});
var objDiv = document.getElementsByClassName("scroll-table-block");
for (var elem in objDiv)
    objDiv[elem].scrollLeft = objDiv[elem].scrollWidth;
JS;
$this->registerJs($js);
?>

<h1><?= Html::encode($this->title) ?></h1>

<div>
    <?php if (!empty($clients)): ?>
        <h4>Мои клиенты</h4>
        <hr>
        <?php foreach($clients as $key => $val): ?>
            <?php $ltv = 0; ?>
            <?php $totalsumm = 0; ?>
            <?php $totalprodaj = 0; ?>
            <?php $dates0 = [] ?>
            <div class="client-flex-block">
                <div style="margin-bottom: 10px"><b><?= "{$val['f']} {$val['i']} {$val['o']}" ?></b></div>
                <div style="margin-bottom: 10px; overflow: auto" class="scroll-table-block">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <?php foreach($dates[$val['id']] as $in => $dex): ?>
                                    <th style="width: 250px"><?= date("m.Y", strtotime($dex)) ?></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <?php foreach($dates[$val['id']] as $d): ?>
                                    <td style="width: 250px">
                                        <?php if (isset($productsAssign[$val['id']][$d])): ?>
                                            <?php $k01 = 0; ?>
                                            <?php foreach($productsAssign[$val['id']][$d] as $pk => $pval): ?>
                                            <?php $totalsumm += $pval['summ']; ?>
                                            <?php $totalprodaj++; ?>
                                                <?php $k01++; ?>
                                                <?php if($k01 > 1) echo  "<hr>"?>
                                                <p style="width: 250px"><b>Продукт:</b> <?= $pval['name'] ?></p>
                                                <p style="width: 250px"><b>Сумма:</b> <?= $pval['summ'] ?> руб.</p>
                                                <p style="width: 250px"><b>Дата оплаты:</b> <?= $pval['date'] ?></p>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php $msc = !empty($productsAssign[$val['id']]) ? count(array_unique(array_keys($productsAssign[$val['id']]))) : 0; ?>
                            <?php $countTotalMnth = count(array_keys($dates[$val['id']])); ?>
                        <tr><td colspan=""><b>LTV</b>: <?= number_format(round(($totalsumm/count($dates[$val['id']])) * ($totalprodaj/count($dates[$val['id']])) * ($msc/$countTotalMnth), 2), 2, ',', ' ') ?></td></tr>
                        </tbody>
                    </table>
                    <?php if (false): ?>
                        <?php if (isset($productsAssign[$val['id']])): ?>
                            <?php $countProducts = count($productsAssign[$val['id']]) ?>
                            <?php foreach($productsAssign[$val['id']] as $k => $v): ?>
                                <?php
                                //(средняя стоимость продажи * среднее число продаж в месяц * среднее время сотрудничества с клиентом в месяцах)
                                if ($v['summ'] > 0) {
                                    $totalsumm += (float)$v['summ'];
                                    $totalprodaj++;
                                    $dates0[] = date("Y-m", strtotime($v['date']));
                                }
                                ?>
                                <div style="display: flex; gap: 10px; flex-direction: row; margin-bottom: 10px">
                                    <div style="max-width: 33%; min-width: 150px; width: 100%">
                                        <div><b>Продукт</b></div>
                                        <div><input type="text" readonly class="form-control" value="<?= $v['name'] ?>"></div>
                                    </div>
                                    <div style="max-width: 33%; min-width: 150px; width: 100%">
                                        <div><b>Дата</b></div>
                                        <div><input type="text" readonly class="form-control" value="<?= $v['date'] ?>"></div>
                                    </div>
                                    <div style="max-width: 33%; min-width: 150px; width: 100%">
                                        <div><b>Сумма</b></div>
                                        <div><input type="number" placeholder="Например - 45000" min="0" class="form-control save-product-summ" data-save="<?= $v['id'] ?>" value="<?= $v['summ'] ?>"></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <?php $z = count(array_unique($dates0)); ?>
                            <div style="background: #303030; color: whitesmoke; padding: 10px; font-weight: 700; ">LTV: <?= number_format(round(($totalsumm/$countProducts) * ($totalprodaj/$z) * ($z), 2), 2, ',', ' ') ?></div>
                        <?php else: ?>
                            <div>У данного клиента нет проданных продуктов</div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="project-placer-form"></div>
                <a href="#" class="project-add" data-client="<?= $val['id'] ?>">Добавить продукт +</a>
            </div>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <div>У вас еще нет клиентов</div>
    <?php endif; ?>
</div>