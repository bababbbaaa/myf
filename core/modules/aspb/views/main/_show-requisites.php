<h3 style="color: black">Реквизиты</h3>
<div class="banks-popup-row">
    <?php if (!empty($popupdata->requisites) && $popupdata->requisites !== '[]'): ?>
        <?php foreach (json_decode($popupdata->requisites, 1) as $k => $v): ?>
            <?php $arr = json_decode($v, 1) ?>
            <div class="banks-popup-row-item">
                <p><?= $arr['count'] ?></p>
                <p><?= $arr['bic'] ?></p>
                <p><?= $arr['bank'] ?></p>
                <p><?= $arr['fio'] ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: black">Информация о реквизитах отсутствует</p>
    <?php endif; ?>
</div>