<?php

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Каталог франшиз';

?>
<section class="rightInfo">
    <div class="catalog">
        <div class="title_row">
            <h1 class="Bal-ttl title-main">Каталог франшиз</h1>
        </div>
        <?php if (!empty($franchizes)): ?>
            <div class="catalog__cards">
                <?php foreach ($franchizes as $k => $v): ?>
                    <?php $render = json_decode($v['render_data'], true) ?>
                    <article class="catalog__cards-item">
                        <a href="<?= Url::to(['catalogpage', 'link' => $v['link']]) ?>" class="catalog__cards-links"></a>
                        <h3 class="catalog__cards-title">
                            <?= $v['name'] ?>
                        </h3>
                        <p class="catalog__cards-subtitle">
                            <?= $v['category'] ?>
                        </p>
                        <p class="catalog__cards-text">
                            <?= $render['first_section']['small_article'] ?>
                        </p>
                        <div class="catalog__cards-bottom">
                            <div class="catalog__cards-price">
                                Стоимость от <span
                                        class="catalog__cards-summ"><?= number_format($v->getPrice(), 0, 0, ' ') ?></span>p.
                            </div>
                            <div class="catalog__cards-btns">
                                <a href="<?= Url::to(['catalogpage', 'link' => $v['link'], '#' => 'package']) ?>"
                                   type="button" class="catalog__cards-btn byFranchize">Купить франшизу</a>
                            </div>
                            <a href="<?= Url::to(['support']) ?>" class="catalog__cards-link">Получить консультацию
                                менеджера</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <h3 class="catalog__box-title">
                Купленны все франшизы
            </h3>
        <?php endif; ?>


        <div class="catalog__box">
            <div class="catalog__content">
                <h2 class="catalog__box-title">
                    Приумножте свой капитал, вложив его в правильный бизнес!
                </h2>
                <div class="catalog__box-text">
                    <p>Мы предлагаем ииновационные, современные и прибыльные направления бизнеса.</p>
                    <p>
                        Наши пакеты франшиз обеспечат вам стабильность и успех на рынке по всей РФ и СНГ, в самых разных
                        напрвлениях работы.
                    </p>
                </div>
            </div>
        </div>

    </div>

    <div class="popup popup--ok catalogpage__popup">
        <div class="popup__ov">
            <div class="popup__body popup__body--ok">
                <div class="popup__content popup__content--ok">
                    <p class="popup__title">Вы уверены что хотите купить эту франшизу?</p>
                    <div style="display: flex">
                        <button class="popup__btn-ok1 btn">Уверен</button>
                        <button style="background-color: #fb593b" class="popup__btn-ok btn">Выйти</button>
                    </div>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
</section>