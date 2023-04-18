<?php

use common\models\UsersNotice;
use yii\helpers\Url;
use user\modules\lead_force\controllers\ClientController;

$labels = [];
$budgets = [];

if (!empty($budget)) {
    foreach ($budget as $item) {
        $labels[] = date("d.m", strtotime($item['date']));
        $budgets[] = $item['budget_after'];
    }
}
$labels = json_encode($labels);
$budgets = json_encode($budgets);
$count = count(json_decode($labels));
if (!empty($budget) && $count > 2) {
    $js = <<< JS
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: $labels,
        datasets: [{
            label: 'Баланс',
            data: $budgets,
            borderColor: [
                'rgba(255, 99, 132, 1)',
            ],
            cubicInterpolationMode: 'monotone',
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});

$('.mass__close').on('click', function(e) {
    console.log(e.target);
    var id = $(this).attr('data-id');
    console.log(id);
    $.ajax({
        url: 'client/read-notice',
        type: 'POST',
        dataType: 'JSON',
        data: {id:id},
    }).done(function() {
        $.pjax.reload({container: '#noticeContainer',})
    });
});
JS;
    $this->registerJsFile(Url::to(['/js/chart.js']), ['depends' => \yii\web\JqueryAsset::class]);
    $this->registerJs($js);
}
$this->title = 'Главная';
?>
<section class="rightInfo">
    <div class="cab__wrapp">
        <div class="cab__main">
            <?php if (!ClientController::fullInfo($client)): ?>
                <div class="mass mass--cab">
                    <div class="mass__content mass__content--cab">
                        <p class="mass__text">
                            Пожалуйста, заполните данные профиля, чтобы получить доступ к пополнению баланса
                        </p>
                        <a href="<?= Url::to(['prof']) ?>" class="mass__link btn">
                            Перейти в профиль
                        </a>
                        <span class="mass__close">
            <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.0732231 10.0585 -0.0732231 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.0732233 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.0732231 0.987437 -0.0732231 1.28033 0.21967L5.28553 4.22487Z"
                    fill="#FFA800"/>
            </svg>
          </span>
                    </div>
                </div>
            <?php endif; ?>
            <?php foreach ($notice as $k => $v): ?>
                <?php if ($v->type !== UsersNotice::TYPE_MAINPAGE_MODERATION_SUCCESS): ?>
                    <div class="mass mass--prov">
                        <div class="mass__content mass__content--prov">
                            <p class="mass__title"><?= $v->type ?></p>
                            <p class="mass__text"><?= $v->text ?></p>
                            <button style="color: #a3ccf4;" data-id="<?= $v->id ?>" type="button"
                                    class="mass__close mass__close--prov">&times;
                            </button>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="mass mass--zak">
                        <div class="mass__content mass__content--zak">
                            <p class="mass__title"><?= $v->type ?></p>
                            <p class="mass__text"><?= $v->text ?></p>
                            <a href="<?= Url::to(['order']) ?>" class="mass__link btn">
                                Перейти в заказ
                            </a>
                            <button style="color: #FFA800" data-id="<?= $v->id ?>" type="button"
                                    class="mass__close mass__close--zak">&times;
                            </button>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>


            <div class="cab__box">
                <article class="cab__item1 item">
                    <div class="item__content item__content--bal">
                        <h2 class="item__title">
                            Баланс
                        </h2>
                        <span class="item__summ"><?= number_format($user_info['budget'], 2, ',', ' ') ?></span>
                        <?php if (!ClientController::fullInfo($client)): ?>
                            <button class="item__btn link">Пополнить</button>
                        <?php else: ?>
                            <a class="link" href="<?= Url::to(['balance']) ?>">Пополнить</a>
                        <?php endif; ?>
                    </div>
                </article>
                <article class="cab__item2 item">
                    <h2 class="item__title">
                        Последние транзакции
                    </h2>
                    <?php if (empty($budget_log)): ?>
                        <!-- Блок пустой -->
                        <div class="item__content2 item__content--tran">
                            <p class="item__info">
                                Здесь будут отображаться движения средств на балансе личного кабинета
                            </p>
                        </div>
                        <!-- / Блок пустой / -->
                    <?php else: ?>
                        <!-- Блок заполненный -->
                        <div class="item__content">
                            <?php foreach ($budget_log as $k => $v): ?>
                                <div class="item__li">
                                    <div class="item__li-inner">
                                        <div class="item__li-box">
                                            <p class="item__li-text"><?= $v['text'] ?></p>
                                            <span class="item__li-info"><?= date('d.m.Y', strtotime($v['date'])) ?></span>
                                            <span class="item__li-info"><?= date('h:i', strtotime($v['date'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                        <a href="<?= Url::to(['balance#page2']) ?>" class="item__link link">
                            Посмотреть все транзакции
                        </a>
                        <!-- / Блок заполненный / -->
                    <?php endif; ?>
                </article>
                <article class="cab__item3 item">
                    <h2 class="item__title">
                        Статистика
                    </h2>
                    <?php if (empty($budget) || $count <= 2): ?>
                        <!-- Блок пустой -->
                        <div class="item__content2 item__content--stat">
                            <p class="item__info">
                                Сюда мы будем выводить вашу статистику личного кабинета за прошедшую неделю
                            </p>
                        </div>
                        <!-- / Блок пустой / -->
                    <?php else: ?>
                        <!-- Блок заполненный -->
                        <canvas id="myChart" width="auto" height="200"></canvas>
                        <!-- / Блок заполненный / -->
                    <?php endif; ?>
                </article>
                <?php if (!empty($bonuses)): ?>
                    <?php if ($bonuses['card'] == 0): ?>
                        <article class="bonuses__index">
                            <div class="bonuses__index-info">
                                <h3 class="bonuses__info-title">Мои бонусы</h3>
                                <p class="bonuses__info-subtitle">Вам доступен кэшбек на следующие заказы</p>
                                <p class="bonuses__info-score"><?= $bonuses['cashback'] ?>%</p>
                                <a class="bonuses__info-link" href="">Подробнее о бонусной программе</a>
                            </div>
                            <div class="bonuses__index-img">
                                <img src="<?= Url::to(['/img/bonuses-index.png']) ?>" alt="">
                            </div>
                        </article>
                    <?php else: ?>
                        <?php if ($bonuses['bonus_points'] > 0): ?>
                            <article class="bonuses__index">
                                <div class="bonuses__index-info">
                                    <h3 class="bonuses__info-title">Карта участника Клуба <b>MYFORCE</b></h3>
                                    <p class="bonuses__info-subtitle">Оплачивайте баллами до 50% от всех услуг
                                        компании</p>
                                    <p class="bonuses__info-score"><?= number_format($bonuses['bonus_points'], 0, 0, ' ') ?>
                                        <span>баллов</span></p>
                                    <a class="bonuses__info-link" href="">Подробнее о карте Клуба MYFORCE</a>
                                </div>
                                <div class="bonuses__index-img">
                                    <img src="<?= Url::to(['/img/bonuses-index.png']) ?>" alt="">
                                </div>
                            </article>
                        <?php else: ?>
                            <article class="bonuses__index">
                                <div class="bonuses__index-info">
                                    <h3 class="bonuses__info-title">Мои бонусы</h3>
                                    <p class="bonuses__info-subtitle">Вам доступен кэшбек на следующие заказы</p>
                                    <p class="bonuses__info-score"><?= $bonuses['cashback'] ?>%</p>
                                    <a class="bonuses__info-link" href="">Подробнее о бонусной программе</a>
                                </div>
                                <div class="bonuses__index-img">
                                    <img src="<?= Url::to(['/img/bonuses-index.png']) ?>" alt="">
                                </div>
                            </article>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <div class="popup">
        <div class="popup__ov">
            <div class="popup__body">
                <div class="popup__content-1">
                    <div class="popup__text">
                        <p>Заполните данные профиля для получения доступа к пополнению баланса</p>
                        <a href="<?= Url::to(['prof']) ?>" class="link popup__link">
                            Перейти к заполнению
                        </a>
                    </div>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
</section>
