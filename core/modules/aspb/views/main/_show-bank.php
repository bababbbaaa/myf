<h3 style="color: black">Банки</h3>
<div class="banks-popup-row">
    <?php if (!empty($popupdata->banks) && $popupdata->banks !== '[]'): ?>
        <?php foreach (json_decode($popupdata->banks, 1) as $k => $v): ?>
            <?php $arr = json_decode($v, 1) ?>
            <div class="banks-popup-row-item">
                <p><?= $arr['count'] ?></p>
                <p><?= $arr['bic'] ?></p>
                <p><?= $arr['bank'] ?></p>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p style="color: black">Информация о банках отсутствует</p>
    <?php endif; ?>
</div>