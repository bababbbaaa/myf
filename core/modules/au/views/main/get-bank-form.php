<?php
$json = !empty($json) ? json_decode($json, 1) : null;
?>
<hr>
<div style="margin-bottom: 40px">
    <div style="margin-bottom: 10px">
        <p><b>Название</b></p>
        <p><input value="<?= !empty($json) ? $json[$c]['Название'] : '' ?>" type="text" class="form-control bankall-input" name="bankall[<?= $c ?>][Название]" placeholder="АО Сбербанк"></p>
    </div>
    <div style="margin-bottom: 10px">
        <p><b>БИК</b></p>
        <p><input type="text" value="<?= !empty($json) ? $json[$c]['БИК'] : '' ?>" class="form-control bankall-input" name="bankall[<?= $c ?>][БИК]" placeholder="86754654"></p>
    </div>
    <div>
        <div class="rs-placer" data-place="<?= $c ?>">

        </div>
        <div class="btn addRS" data-bank="<?= $c ?>" style="background: #1b3f5f; cursor: pointer; font-size: 14px; padding: 7px 15px; height: unset; width: unset; max-width: 150px; box-shadow: unset; border-radius: 0">
            Добавить РС
        </div>
    </div>
</div>
