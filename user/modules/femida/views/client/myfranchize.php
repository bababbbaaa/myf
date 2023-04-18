<?php

use yii\helpers\Url;

$this->title = 'Моя франшиза';
?>

<section class="rightInfo">
    <h1 class="techno_title title-main franchize-title">Моя франшиза</h1>
    <?php if (!empty($package)): ?>
        <?php foreach ($package as $k => $v): ?>
            <?php if (!in_array($v['id'], $idOrders)): ?>
                <section class="your-package">
                    <h2 class="your-package-title">Ваш пакет: «<?= $v['name'] ?>»</h2>
                    <p class="your-package-text">Готовый бизнес под ключ в стабильной сфере с высоким гарантированным
                        доходом.</p>
                    <ul class="your-package-list">
                        <li class="your-package-list-item">
                            Ознакомиться со всеми <a href="<?= Url::to(['knowledge']) ?>">доступными документами</a>
                        </li>
                    </ul>
                    <div class="your-package_last-row">
                        <p class="your-package_last-row-text">Для продвижения бизнеса - </p>
                        <a href="<?= Url::to(['order-lid-add', 'f' => $v['name'], 'id' => $v['id']]) ?>"
                           class="your-package_last-row-link">Запустить рекламную компанию</a>
                    </div>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if (!empty($myOrders)): ?>
        <?php foreach ($myOrders as $k => $v): ?>
            <?php if (in_array($v['package_id'], $idOrders)): ?>
                <section class="your-package your-package-have">
                    <h2 class="your-package-title"><?= $v['order_name'] ?></h2>
                    <ul class="your-package-list">
                        <li class="your-package-list-item">
                            Ознакомиться со всеми <a href="<?= Url::to(['knowledge']) ?>">доступными документами</a>
                        </li>
                        <li class="your-package-list-item">
                            Посмотреть <a href="<?= Url::to(['statis']) ?>">статистику по рекламе</a>
                        </li>
                    </ul>
                    <div class="your-package_last-row">
                        <a href="<?= Url::to(['promotion']) ?>" class="your-package_last-row-link">Контроль рекламной
                            компании</a>
                    </div>
                </section>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>


    <section class="getting-clients">
        <div class="getting-clients-container">
            <h2 class="getting-clients-title">Получать клиентов ещё не было так прибыльно, как с бонусами FEMIDA.
                FORCE! </h2>
            <p class="getting-clients-text">Вкладывая средства в продвижение вашей компании, вы получаете не только
                <span>быстрый и качественный</span> поток клиентов, но и приятный кешбек и бонусы от нашей компании
                за каждое пополнение баланса вашего кабинета!</p>
            <div class="getting-clients_lasr-row">
                <a href="<?= Url::to(['balance']) ?>" class="your-package_last-row-link">Пополнить баланс</a>
                <a href="<?= Url::to(['promotion']) ?>" class="getting-clients_lasr-row-link">Запустить рекламную
                    компанию</a>
            </div>
        </div>
    </section>
</section>