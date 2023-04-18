<?php

use common\models\UsersNotice;
use yii\helpers\Url;
use user\modules\lead_force\controllers\ProviderController;

$this->title = "Главная";

$log = 1;
$labels = [];

if (!empty($date)) {
    foreach ($date as $item) {
        $labels[] = $log === 1 ? $item->format('d.m') : strtotime($item->format('d.m.Y H:i:s'));
    }
} else
    $date = [];


$leadCats = \common\models\LeadsCategory::find()->select(['link_name', 'name'])->asArray()->all();
$catArray = [];
foreach ($leadCats as $item)
    $catArray[$item['link_name']] = $item['name'];


##общая
$max = max($labels);
$count = 0;
$budgets = [];
$buff1 = [];
$count2 = 0;
$budgets2 = [];
$budgets3 = [];
$buff2 = [];
$buff3 = [];
if(!empty($stats)) {
    foreach ($stats as $key => $item) {
        $buff1[$log === 1 ? date("d.m", strtotime($item->date_lead)) : strtotime($item->date_lead)] = $item->summ;
    }
    $count = count($stats);
}
if(!empty($stats2)) {
    foreach ($stats2 as $key => $item) {
        $buff2[$log === 1 ? date("d.m", strtotime($item->date_lead)) : strtotime($item->date_lead)] = $item->summ;
    }
    $count2 = count($stats2);
}
if(!empty($stats3)) {
    foreach ($stats3 as $key => $item) {
        $buff3[$log === 1 ? date("d.m", strtotime($item->date_lead)) : strtotime($item->date_lead)] = $item->summ;
    }
    $count2 = count($stats3);
}
foreach ($labels as $key => $item) {
    if (isset($buff1[$item])) {
        $currItem = $buff1[$item];
        if (!isset($min) || $item < $min)
            $min = $item;
    } else
        $currItem = 0;
    $budgets[$key] = $currItem;
    if (isset($buff2[$item])) {
        $currItem2 = $buff2[$item];
        if (!isset($min) || $item < $min)
            $min = $item;
    }
    else
        $currItem2 = 0;
    $budgets2[$key] = $currItem2;
    if (isset($buff3[$item])) {
        $currItem3 = $buff3[$item];
        if (!isset($min) || $item < $min)
            $min = $item;
    }
    else
        $currItem3 = 0;
    $budgets3[$key] = $currItem3;
}
$labels = json_encode($labels);
$budgets = json_encode($budgets);
$budgets2 = json_encode($budgets2);
$budgets3 = json_encode($budgets3);
##общая

$newJs = <<<JS
var ctx = document.getElementById('myChart').getContext('2d');
if ($count >= 2){
    var Obj = {
        type: 'line',
        data: {
            labels: $labels,
            datasets: [
                {
                    label: 'Всего лидов',
                    data: $budgets,
                    borderColor: ['#FFA800',],
                    backgroundColor: ['#FFA800'],
                    cubicInterpolationMode: 'monotone',
                },
                {
                    label: 'Брак',
                    data: $budgets3,
                    borderColor: ['#FF6359',],
                    backgroundColor: ['#FF6359'],
                    cubicInterpolationMode: 'monotone',
                    fill: true,
                },
                {
                    label: 'Подтвержденных',
                    data: $budgets2,
                    borderColor: ['#92E3A9',],
                    backgroundColor: ['#92E3A9'],
                    cubicInterpolationMode: 'monotone',
                    fill: true,
                },
               
            ]
        },
        options: {
            responsive: true,
            interaction: {
              intersect: false,
              axis: 'x'
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    },
                },
                x: {
                }
            }
        }
    };
    if ('$log' !== '1') {
        const footer = (tooltipItems) => {
            var sum;
            var dt;
            var dm;
            tooltipItems.forEach(function(tooltipItem) {
                sum = (new Date(tooltipItem.parsed.x * 1000));
                dt = sum.getDate();
                dm = sum.getMonth() + 1;
            });
            if (dt <= 9)
                dt = "0" + dt;
            if (dm <= 9)
                dm = "0" + dm;
            return "Дата: " + dt + "." + dm + "." + sum.getFullYear();
        };
        Obj.options.scales.x.type = 'logarithmic';
        Obj.options.scales.x.min = parseInt('$min') - 3600 * 24;
        Obj.options.scales.x.max = parseInt('$max');
        Obj.options.plugins = {};
        Obj.options.plugins.tooltip = {};
        Obj.options.plugins.tooltip.callbacks = {footer: footer};
        Obj.options.interaction = {
          intersect: false,
          mode: 'index',
        };
    }
    var myChart = new Chart(ctx, Obj);
}
JS;


$jss =<<< JS
$('.mass__close').on('click', function(e) {
    var id = $(this).attr('data-id');
    $.ajax({
        url: 'read-notice',
        type: 'POST',
        dataType: 'JSON',
        data: {id:id},
    }).done(function() {
        $.pjax.reload({container: '#noticeContainer',});
    });
});
JS;
$this->registerJsFile(Url::to(['/js/chart.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($jss);
?>
<section class="rightInfo">
    <div class="cab__wrapp">
        <div class="cab__main">
            <?php if (!ProviderController::fullInfo($client)): ?>
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
                            <button style="color: #a3ccf4;" data-id="<?= $v->id ?>" type="button" class="mass__close mass__close--prov">&times;</button>
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
                            <button style="color: #FFA800" data-id="<?= $v->id ?>" type="button" class="mass__close mass__close--zak">&times;</button>
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
                        <?php if (!ProviderController::fullInfo($client)): ?>
                            <button class="item__btn link">Снять</button>
                        <?php else: ?>
                            <a class="link" href="<?= Url::to(['balance']) ?>">Снять</a>
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
                    <?php if($count < 2): ?>
                    <!-- Блок пустой -->
                    <div class="item__content2 item__content--stat">
                        <p class="item__info">
                            Сюда мы будем выводить вашу статистику личного кабинета за прошедшую неделю
                        </p>
                    </div>
                    <!-- / Блок пустой / -->
                    <?php else: ?>
                        <?php $this->registerJs($newJs); ?>
                    <!-- Блок заполненный -->
                        <canvas id="myChart" width="auto" height="200"></canvas>
                    <!-- / Блок заполненный / -->
                    <?php endif; ?>
                </article>
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