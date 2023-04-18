<?php

use yii\helpers\Url;

?>

<?php if (!empty($popupdata)): ?>
<!--    --><?php //print_r($popupdata) ?>
    <div class="popup__order">
        <p class="popup__order-subtitle">
            <?= $popupdata['category'] ?>
        </p>
        <h2 class="popup__order-title">
            <?= $popupdata['name'] ?>
        </h2>
        <div class="popup__order-text">
            <?= mb_substr($popupdata['description'], 0, 400) ?>...<a target="_blank" href="https://myforce.ru/lead/lead-plan/<?= $popupdata['link'] ?>"> читать далее</a>
        </div>
        <ul class="popup__order-list">

            <?php if (!empty($popupdata['advantages'])): ?>
                <?php $adva = json_decode($popupdata['advantages'], true) ?>
                <?php foreach ($adva as $v): ?>
                <li class="popup__order-item"><?= $v ?></li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>

        <div class="popup__order-box">
            <p class="popup__order-box-title">Регион</p>
            <?php if (!empty($popupdata['regions'])): ?>
                <?php $region = json_decode($popupdata['regions']) ?>
                <?php foreach ($region as $v): ?>
                    <p class="popup__order-box-text"><?= $v ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="popup__order-box">
            <p class="popup__order-box-title">Стоимость лида</p>
            <p class="popup__order-box-text">От <?= $popupdata['price'] ?> рублей за принятый лид</p>
        </div>

        <a href="<?= Url::to(['order-lid', 'template' => $popupdata['link']]) ?>" class="popup__order-link btn">Заказать лиды</a>
    </div>
    <div class="popup__close">
        <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
    </div>
<?php else: ?>
    <p class="popup__order-subtitle">
        Данные не найдены
    </p>
<?php endif; ?>
