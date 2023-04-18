<?php

use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use common\models\LeadsSentReport;


$this->title = "Страница оффера";

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

$bonus_waste = 0;
if (!empty($bonuses) && !empty($bonuses->additional_waste)) {
    $bonus_waste = $bonuses->additional_waste;
}
switch ($order['status']) {
    case 'выполнен':
        $class = 'Performed';
        break;
    case 'исполняется':
        $class = 'Progress';
        break;
    case 'пауза':
        $class = 'Pause';
        break;
    case 'остановлен':
        $class = 'Stopped';
        break;
}
$regions = json_decode($order['regions']);

$params = json_decode($order['params_special'], true);
$orderId = json_encode($order['id']);
$js = <<< JS

    var link = $orderId;

        $('.dropdown-header').on('click', function() {
        var order = $(this).attr('data-order'),
            dhash = $(this).attr('data-hash');
        $.ajax({
            url: 'change-orders',
            type: 'POST',
            dataType: 'JSON',
            data: {order:order, hash:dhash}
        }).done(function(rsp) {
            if (rsp.status === 'success'){
                location.reload();
            } else {
                $('.rsp-ajax-text').text(rsp.message);
                $('.popup--auct-err').fadeIn(300);
            }
        });
    });
        
        $('.copy__info').on('click', function() {
          $(this).select();
        });
JS;
$css = <<< CSS
    .dropdown{
        margin-right: 24px;
        position: relative;
        transition-duration: 0.3s;
        align-self: flex-start;
    }
    .dropdown a{
        font-weight: normal;
        font-size: 14px;
        line-height: 20px;
        color: #5b617c;
        transition-duration: 0.3s;
        text-decoration: none;
    }
    .dropdown-header{
        font-size: 14px;
        background-color: #fafafa;
        cursor: pointer;
        transition-duration: 0.3s;
    }
    .dropdown-header:hover{
        background-color: #0a73bb;
        color: white;
    }
CSS;

$this->registerCss($css);
$this->registerJs($js);
$this->registerCssFile(Url::to(['/css/jquery.timepicker.css']));
$this->registerJsFile(Url::to(['/js/jquery.timepicker.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJsFile(Url::to(['/js/chart.js']), ['depends' => \yii\web\JqueryAsset::class]);

?>
<section class="rightInfo">

    <nav class="BredCramsonBalance df aic">
        <a href="<?= Url::to(['myorders']) ?>" class="BRChome uscp MText">Мои офферы</a>
        <img src="<?= Url::to(['/img/ArrRightBRC.png']) ?>" alt="Стрелка справа">
        <a href="<?= Url::to(['myorders']) ?>" class="BRChome uscp MText">Активные офферы</a>
        <img src="<?= Url::to(['/img/ArrRightBRC.png']) ?>" alt="Стрелка справа">
        <p class="BRCpagenow MText"><?= $order['name'] ?></p>
    </nav>
    <div class="order-page_title-row">
        <h1 class="Bal-ttl"><?= $order['name'] ?></h1>
        <div class="order-status <?= $class ?>">
            <p><?= $order['status'] ?></p>
        </div>
        <!--Индикаторы статуса-->
        <!-- <div class="order-status Performed">
                                <p>Выполнен</p>
                            </div> -->
        <!-- <div class="order-status Progress">
                                <p>Исполняется</p>
                            </div> -->
        <!-- <div class="order-status Pause">
                                <p>Пауза</p>
                            </div> -->
        <!-- <div class="order-status Stopped">
                                <p>Остановлен</p>
                            </div> -->
    </div>
    <section class="order-page_info-cards">
        <div class="order-page_info-cards_left">
            <div class="order-page_info-card-1">
                <div class="order-page_info-card-1_top">
                    <div class="order-page_info-card-1_top_left">
                        <h2 class="order-page_info-card-1_top-title">
                            Информация об оффере
                        </h2>
                        <p class="order-page_info-card-1_top-date">
                            от <?= date('d.m.Y', strtotime($order['date'])) ?>
                        </p>
                    </div>
                    <div class="order-page_info-card-1_actions">
                        <?php if ($order['status'] == 'исполняется'): ?>
                            <div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Действия <b
                                            class="caret"></b></a>
                                <?php
                                echo Dropdown::widget([
                                    'items' => [
                                        ['label' => 'Поставить на паузу', 'options' => ['data-order' => $order['id'], 'data-hash' => md5("{$user['id']}::{$order['id']}::order-hash")]],
                                    ],
                                ]);
                                ?>
                            </div>
                        <?php elseif ($order['status'] == 'пауза'): ?>
                            <div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Действия <b
                                            class="caret"></b></a>
                                <?php
                                echo Dropdown::widget([
                                    'items' => [
                                        ['label' => 'Возобновить', 'options' => ['data-order' => $order['id'], 'data-hash' => md5("{$user['id']}::{$order['id']}::order-hash")]],
                                    ],
                                ]);
                                ?>
                            </div>
                        <?php else: ?>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="order-page_info-card-1_main">
                    <div class="order-page_info-card-1_main_left">
                        <div class="order-page_info-card-1_main_left-group">
                            <p class="order-page_info-card-1_main_left-group-t1">
                                Сфера
                            </p>
                            <p class="order-page_info-card-1_main_left-group-t2">
                                <?= $category['name'] ?>
                            </p>
                        </div>
                        <div class="order-page_info-card-1_main_left-group">
                            <p class="order-page_info-card-1_main_left-group-t1">
                                Вознаграждение за принятый лид
                            </p>
                            <p class="order-page_info-card-1_main_left-group-t2">
                                <?= $order['price'] ?>₽/лид
                            </p>
                        </div>
                    </div>
                    <div class="order-page_info-card-1_main_right">
                        <div class="order-page_info-card-1_main_left-group">
                            <p class="order-page_info-card-1_main_left-group-t1">
                                регион
                            </p>
                            <p class="order-page_info-card-1_main_left-group-t2">
                                <?php $cReg = count($regions) ?>
                                <?php foreach ($regions as $k => $v): ?>
                                    <?php if ($k + 1 === $cReg): ?>
                                        <?= $v ?>
                                    <?php else: ?>
                                        <?= $v ?>;
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </p>
                        </div>
                        <?php if ($order['leads_total'] > 0): ?>
                            <div class="order-page_info-card-1_main_left-group">
                                <p class="order-page_info-card-1_main_left-group-t1">
                                    процент принятия лида
                                </p>
                                <p class="order-page_info-card-1_main_left-group-t2">
                                    от <?= round($order['leads_confirmed'] * 100 / $order['leads_total']) ?>%
                                </p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="order-page_info-cardos">
                <h2 class="order-page_info-card-1_top-title">
                    Параметры оффера
                </h2>

                <div>
                    <p class="order-page_info-card-1_main_left-group-t1">Токен оффера</p>
                    <input style="max-width: 375px; width: 100%; letter-spacing: 0.1em" class="offer__input copy__info"
                           type="text" readonly
                           value="<?= $order['offer_token'] ?>">
                </div>
                <div style="margin-top: 15px;">
                    <p class="order-page_info-card-1_main_left-group-t1">Тип оффера</p>
                    <input style="max-width: 375px; width: 100%; letter-spacing: 0.1em" class="offer__input copy__info"
                           type="text" readonly
                           value="<?= $order['category'] ?>">
                </div>

                <?php if (!empty($parameters)): ?>
                    <h3 style="font-size: 18px; margin-top: 20px;" class="order-page_info-card-1_top-title">
                        Дополнительные параметры
                    </h3>
                    <?php foreach ($parameters as $k => $v): ?>
                        <div class="block__offers-info">
                            <div class="info__about--offers">
                                <div class="column__offers--info">
                                    <p class="order-page_info-card-1_main_left-group-t1">Описание поля</p>
                                    <p class="order-page_info-card-1_main_left-group-t21"><?= $v['description'] ?></p>
                                </div>
                                <div class="column__offers--info">
                                    <p class="order-page_info-card-1_main_left-group-t1">Ключ поля</p>
                                    <p class="order-page_info-card-1_main_left-group-t21"><?= $v['name'] ?></p>
                                </div>
                            </div>
                            <div class="info__about--offers">
                                <div class="column__offers--info">
                                    <p class="order-page_info-card-1_main_left-group-t1">Тип поля</p>
                                    <p class="order-page_info-card-1_main_left-group-t21"><?= $v['type'] == 'number' ? 'Число' : 'Строка' ?></p>
                                </div>
                                <div class="column__offers--info">
                                    <p class="order-page_info-card-1_main_left-group-t1">Пример</p>
                                    <p class="order-page_info-card-1_main_left-group-t21"><?= $v['provider_example'] ?></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <article style="width: 100%" class="cab__item3 item">
                <h2 class="item__title">
                    Статистика
                </h2>
                <?php $this->registerJs($newJs); ?>
                <?php if ($count < 2): ?>
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
        </div>
        <div class="order-page_info-cards_right">
            <h2 class="order-page_info-cards_right-title">
                Подробности
            </h2>
            <p class="order-page_info-cards_right-t3">
                Выполнение оффера
            </p>
            <div class="more__info">
                <div class="more__info-block">
                    <p class="more__info-title">Требуемый объем</p>
                    <p class="more__info-value"><?= $order['leads_need'] ?></p>
                </div>
                <div class="more__info-block">
                    <p class="more__info-title">Поставлено партнерам</p>
                    <p class="more__info-value"><?= $order['leads_confirmed'] ?></p>
                </div>
                <div class="more__info-block">
                    <p class="more__info-title">Непринятые лиды</p>
                    <p class="more__info-value"><?= $order['leads_waste'] ?></p>
                </div>
                <div class="more__info-block">
                    <p class="more__info-title">Получено средств</p>
                    <p class="more__info-value"><?= number_format($order['total_payed'], 0, 0, ' ') ?>₽</p>
                </div>
            </div>
            <p class="order-page_info-cards_right-t3">
                Статистика оффера
            </p>
            <div class="order-page_info-cards_right_process">
                <div class="order-page_info-cards_right_process_top">
                    <div class="order-page_info-cards_right_process">
                        <p>Отгружено лидов:<span
                                    class="order-page_info-cards_right_process-percentage"><?= round(($order['leads_confirmed'] * 100) / $order['leads_need'], 2) ?>%</span>
                        </p>
                    </div>
                    <div class="order-page_info-cards_right_process-bott">
                        <div style="width: <?= round(($order['leads_confirmed'] * 100) / $order['leads_need'], 2) ?>%"
                             class="order-page_info-cards_right_process-bottfill"></div>
                    </div>
                </div>
                <div class="order-page_info-cards_right_process_top">
                    <?php if ($order['leads_total'] > 0): ?>
                        <div class="order-page_info-cards_right_process">
                            <p>Отбраковано лидов:<span
                                        class="order-page_info-cards_right_process-percentage"><?= round(($order['leads_waste'] * 100) / ($order['leads_total']), 2) ?>%</span>
                            </p>
                        </div>
                    <div class="order-page_info-cards_right_process-bott">
                        <div style="width: <?= round(($order['leads_waste'] * 100) / ($order['leads_total']), 2) ?>%;"
                             class="order-page_info-cards_right_process-bottfill order-page_info-cards_right_process-bottfill2"></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
    <div class="order-page_lead_popap_back"></div>
    <div class="order-page_lead_popap-wrap">

    </div>
    <div class="popup popup--auct-err">
        <div class="popup__ov">
            <div class="popup__body popup__body--w">
                <div class="popup__content popup__content--err">
                    <p class="popup__title rsp-ajax-title">
                        Ошибка
                    </p>
                    <p class="popup__text rsp-ajax-text">

                    </p>
                    <button class="popup__btn-close btn">Закрыть</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img//close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>

    <div class="popup popup--auct">
        <div class="popup__ov">
            <div class="popup__body popup__body--ok">
                <div class="popup__content popup__content--ok">
                    <p class="popup__title">Успех!</p>
                    <p class="popup__text"></p>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img//close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
</section>