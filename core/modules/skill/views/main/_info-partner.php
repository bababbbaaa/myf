<?php use yii\helpers\Url;

if (!empty($partnerInfo)): ?>
<div class="car-s2__part-text">
    <p>
        <span><?= $partnerInfo['name'] ?></span>
        <?= $partnerInfo['content'] ?>
    </p>
</div>
<a href="<?= Url::to(['profession', 'partner' => $partnerInfo['link']]) ?>" data-pjax="0" class="car-s2__part-btn btn btn--blue">
    Посмотреть курсы партнера
</a>
<?php else: ?>
<div class="car-s2__part-text">
    <p>
        Верим в успех каждого! К нам приходят и начинающие специалисты, и руководители крупных
        компаний. Всех
        объединяет одно —
        желание построить карьеру.
    </p>
</div>
<?php endif;?> 
