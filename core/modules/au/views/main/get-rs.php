<?php
$json = !empty($json) ? json_decode($json, 1) : null;
?>
<hr>
<div>
    <div style="margin-bottom: 10px">
        <p><b>Расчетный счет</b></p>
        <p><input value="<?= !empty($json) ? $json[$bank]['rs'][$c]['Расчетный счет счета'] : '' ?>" type="text" class="form-control bankall-input" name="bankall[<?= $bank ?>][rs][<?= $c ?>][Расчетный счет счета]" placeholder="76345234234"></p>
    </div>
    <div style="margin-bottom: 10px">
        <p><b>Карта счета</b></p>
        <p><input value="<?= !empty($json) ? $json[$bank]['rs'][$c]['Карта счета'] : '' ?>" type="text" class="form-control bankall-input" name="bankall[<?= $bank ?>][rs][<?= $c ?>][Карта счета]" placeholder="73478343456352"></p>
    </div>
    <div style="margin-bottom: 10px">
        <p><b>Корс. счет счета</b></p>
        <p><input value="<?= !empty($json) ? $json[$bank]['rs'][$c]['Корс. счет счета'] : '' ?>" type="text" class="form-control bankall-input" name="bankall[<?= $bank ?>][rs][<?= $c ?>][Корс. счет счета]" placeholder="86754654"></p>
    </div>
    <div style="margin-bottom: 10px">
        <p><b>ФИО клиента</b></p>
        <p><input value="<?= !empty($json) ? $json[$bank]['rs'][$c]['ФИО'] : '' ?>" type="text" class="form-control bankall-input" name="bankall[<?= $bank ?>][rs][<?= $c ?>][ФИО]" placeholder="Иванов Иван"></p>
    </div>
</div>
