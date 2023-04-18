<?php

use common\models\Leads;
use common\models\LeadsSentReport;
use common\models\OffersAlias;
use common\models\Orders;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = "Статистика";

$log = $_GET['interval'] > 30 ? 'logarithmic' : 1;
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
$max = !empty($labels) ? max($labels) : null;
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
$js = <<< JS
    /* Фильтр активных заказов */
    $('.activeFilter').on('submit', function(e) {
        e.preventDefault();
          $.pjax.reload({
              container: '#activeContainers',
              url: "statistics",
              type: "GET",
              data: $('.activeFilter').serialize(),
           });
    });
    $('.sendActive').on('click', function() {
        setTimeout(function() {
            $('.activeFilter').submit();
        },300);
    });
    /* Фильтр активных заказов */
    
    /* Фильтр архива */
    $('.finishedFilter').on('submit', function(e) {
        e.preventDefault();
          $.pjax.reload({
              container: '#finishedContainer',
              url: "statistics",
              type: "GET",
              data: $('.finishedFilter').serialize(),
           });
    });
    $('.sendFinished').on('click', function(e) {
        console.log(e.target);
        setTimeout(function() {
            $('.finishedFilter').submit();
        },300);
    });
    /* Фильтр архива */
    
    var hash = location.hash.substring(1);
    $('.MyOrders_filter-reset').on('click', function() {
        location.href = '/lead-force/provider/statistics#'+ hash;
    });
    $('.MyOrders_filter-check-l').on('click', function() {
      $(this).toggleClass('activeCheck');
    });
    
    /* Табы */
    if (hash.length === 0){
        $('.tab1').addClass('active');
        $('.OrderPage-1').fadeIn(1);
    } else {
        $('.tab').removeClass('active');
        $('.OrderPage').fadeOut();
        $('.tab' + hash).addClass('active');
        $('.OrderPage-' + hash).fadeIn(1);
    }
    $('.tabsChange').on('click', function() {
        var target = $(this).attr('href').substring(1);
        hash = $(this).attr('href').substring(1);
        $('.OrderPage').fadeOut(1, function() {
            $('.tab').removeClass('active');
            $('.tab' + target).addClass('active');
            $('.OrderPage-' + target).fadeIn(1);
        });
    });
    /* Табы */

    // $('.pjaxss').on('click', '.dropdown-header',function() {
    //     var order = $(this).attr('data-order'),
    //         dhash = $(this).attr('data-hash');
    //     $.ajax({
    //         url: 'change-orders',
    //         type: 'POST',
    //         dataType: 'JSON',
    //         data: {order:order, hash:dhash}
    //     }).done(function(rsp) {
    //         if (rsp.status === 'success'){
    //             $.pjax.reload({container: '#activeContainer'});
    //         } else {
    //             $('.popup__text1').text(rsp.message);
    //             $('.popup').fadeIn(300);
    //         }
    //     });
    // });
    $('.OrderPage-1').on('click', '.invis-rad', function() {
      var val = $(this).val();
        $('.btn-block').each(function() {
            $(this).removeClass('btn-block-active')
        });
        $('.btn-block[data-type="'+ val +'"]').addClass('btn-block-active');
        $('a[data-click="'+ val +'"]').trigger('click');
    });
    $('.OrderPage').on('click', '.click-toggle', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        $('.open-toggle[data-id="'+ id +'"]').slideToggle(200);
    });
JS;
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

$this->registerJsFile(Url::to(['/js/chart.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);


?>
<style>
    .jq-selectbox__select-text{
        width: 60px !important;
        overflow: hidden;
    }
    .disabled{
        color: black !important;
    }
    .selected{
        color: white !important;
        background-color: #08C !important;
    }
    .activeCheck{
        border-color: #08C;
        color: #08C;
    }
    .moderationFilter, .finishedFilter{
        max-width: 300px;
    }
    label {
        display: block;
        margin-bottom: 0;
        font-weight: 500;
    }
    .dropdown{
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
    .jq-selectbox__dropdown{
        width: fit-content;
    }
    .main-div {
        padding: 40px;
    }
    .header-block1 {
        max-width: 563px;font-size: 24px;line-height: 28px;
    }
    .btn-block {
        border: 1px solid #CBD0E8;
        box-sizing: border-box;
        border-radius: 8px;
        flex: none;
        order: 0;
        flex-grow: 0;
        margin-right: 16px;
        margin-top: 25px;
        padding: 8px 60px;
        cursor: pointer;
        transition-property: background, color;
        transition-duration: 0.33s;
        position: relative;
    }
    .btn-block:hover, .btn-block-active {
        color: #007FEA;
        background: #CCE8FF;
    }
    .invis-rad {
        position: absolute;
        top: 0;
        left: 0;
        margin: 0;
        height: 100%;
        width: 100%;
        appearance: none;
        cursor: pointer;
    }
    .open-toggle {
        padding: 20px 0;
    }
</style>
<section class="rightInfo rightInfo_no-orders">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__link">Мои заказы</span>
            </li>

            <li class="bcr__item">
                <span class="bcr__span">Добавить заказ</span>
            </li>
        </ul>
    </div>
    <div class="title_row">
        <p class="Bal-ttl title-main">Мои заказы</p>
    </div>
    <nav class="MyOrders_tabs">
        <div class="tab tab1">
            <a href="#1" class="tabsChange"></a>
            <p class="name">Общая</p>
            <div class="string act1"></div>
        </div>
        <div class="tab tab2">
            <a href="#2" class="tabsChange"></a>
            <p class="name">Текущие офферы</p>
            <div class="string act2"></div>
        </div>
        <div class="tab tab3">
            <a href="#3" class="tabsChange"></a>
            <p class="name">Завершенные офферы</p>
            <div class="string act3"></div>
        </div>
    </nav>

    <section class="OrderCardS OrderPage OrderPage-1">
<!--        --><?//= Html::beginForm('', 'get', ['class' => 'activeFilter']) ?>
<!--        --><?//= Html::endForm(); ?>
        <div class="pjaxss">
            <?php Pjax::begin(['id' => 'activeContainer']) ?>
            <?php $this->registerJs($newJs); ?>
            <article class="MainInfo">
                <div class="main-div">
                    <div class="header-block1">Выберите период, за который хотите ознакомиться со статистикой</div>
                    <div style="display: flex">
                        <div class="btn-block <?= empty($_GET['interval']) || $_GET['interval'] == 7 ? 'btn-block-active' : '' ?>" data-type="Неделя">Неделя <input type="radio" name="statistics-check" value="Неделя" class="invis-rad"></div>
                        <a data-click="Неделя" style="display: none" href="<?= Url::to(['provider/statistics', 'interval' => 7, '#' => 1]) ?>">123</a>
                        <div class="btn-block <?= !empty($_GET['interval']) && $_GET['interval'] == 30 ? 'btn-block-active' : '' ?>" data-type="Месяц">Месяц <input type="radio" name="statistics-check" value="Месяц" class="invis-rad"></div>
                        <a data-click="Месяц" style="display: none" href="<?= Url::to(['provider/statistics', 'interval' => 30, '#' => 1]) ?>">123</a>
                        <div class="btn-block <?= !empty($_GET['interval']) && $_GET['interval'] > 30 ? 'btn-block-active' : '' ?>" data-type="Год">Год <input type="radio" name="statistics-check" value="Год" class="invis-rad"></div>
                        <a data-click="Год" style="display: none" href="<?= Url::to(['provider/statistics', 'interval' => 365, '#' => 1]) ?>">123</a>
                    </div>
                    <div style="margin-top: 20px; position: relative; max-width: 80vw">
                        <canvas id="myChart" width="auto" height="200"></canvas>
                    </div>
                </div>
            </article>
            <?php Pjax::end(); ?>
        </div>
    </section>

    <section class="OrderCardS OrderPage OrderPage-2">
        <?= Html::beginForm('', 'get', ['class' => 'activeFilter']) ?>
        <div class="MyOrders_filter">
            <button class="MyOrders_filter-reset" type="reset"></button>
            <select class="MyOrders_filter-select" name="activeFilter[status]" id="">
                <option selected disabled>Статус</option>
                <option class="sendActive" value="<?= Orders::STATUS_PROCESSING ?>">Исполняется</option>
                <option class="sendActive" value="<?= Orders::STATUS_STOPPED ?>">Остановлен</option>
                <option class="sendActive" value="<?= Orders::STATUS_PAUSE ?>">Пауза</option>
            </select>
            <select class="MyOrders_filter-select" name="activeFilter[sphere]" id="">
                <option selected disabled>Сфера</option>
                <?php foreach ($sphere as $k => $v): ?>
                    <option class="sendActive" value="<?= $v['link_name'] ?>"><?= $v['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <input class="MyOrders_filter-check" type="checkbox" name="activeFilter[new]"
                   id="MyOrders_filter-check">
            <label class="MyOrders_filter-check-l sendActive <?= !empty($_GET['activeFilter']['new']) ? 'activeCheck' : '' ?>" for="MyOrders_filter-check">Новые</label>
        </div>
        <?= Html::endForm(); ?>
        <div class="pjaxss">
            <?php Pjax::begin(['id' => 'activeContainers']) ?>
            <?php if (!empty($activeOrders)): ?>
                <?php foreach ($activeOrders as $k => $v): ?>
                    <?php if ($v['status'] === 'остановлен' || $v['status'] === 'исполняется' || $v['status'] === 'пауза'): ?>
                        <div class="OrderCard">
                            <div class="top">
                                <div class="Lcol">
                                    <div class="L">
                                        <h2 class="OrderNum"><?= $v['name'] ?></h2>
                                        <!--                                    <a href="-->
                                        <? //= Url::to(['#']) ?><!--">Статистика</a>-->
                                    </div>
                                    <div class="R">
                                        <div class="topb">
                                            <p>Выполнено:<span
                                                        class="OrderCard-done-percentage"><?= round(($v['leads_confirmed'] * 100) / $v['leads_need'], 2) ?>%</span>
                                            </p>
                                        </div>
                                        <div class="bott">
                                            <div style="width: <?= $v['leads_need'] > 0 ? round(($v['leads_total'] * 100) / $v['leads_need'], 2) : 0 ?>px;" class="bottfill"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Rcol">
                                    <div class="R">
                                        <?php

                                            switch ($v['status']) {
                                                case 'остановлен':
                                                    $text = 'Этот оффер остановлен администратором!';
                                                    $class = 'Stopped';
                                                    break;
                                                case 'пауза':
                                                    $text = 'Этот оффер на паузе в данный момент';
                                                    $class = 'Pause';
                                                    break;
                                                case 'исполняется':
                                                    $text = 'Этот оффер исполняется в данный момент';
                                                    $class = 'Progress';
                                                    break;
                                            }

                                        ?>
                                        <div class="order-status <?= $class ?>">
                                            <div class="order__help-status"><?= $text ?></div>
                                            <p><?= mb_convert_case($v['status'], MB_CASE_TITLE) ?></p>
                                        </div>
                                        <p class="date">от <?= date('d.m.Y', strtotime($v['date'])) ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php $regions = json_decode($v['regions']); ?>
                            <div class="OrderCard_main">
                                <div class="OrderCard_main_L">
                                    <p class="OrderCard_main_L-t1">Требуемый объем</p>
                                    <p class="OrderCard_main_L-t2"><?= $v['leads_need'] ?> шт.</p>
                                    <p class="OrderCard_main_L-t1">Поставлено всего</p>
                                    <p class="OrderCard_main_L-t2"><?= $v['leads_total'] ?> шт.</p>
                                    <p class="OrderCard_main_L-t1">брак</p>
                                    <p class="OrderCard_main_L-t2"><?= $v['leads_waste'] ?> шт.</p>
                                    <p class="OrderCard_main_L-t1">получено средств</p>
                                    <p class="OrderCard_main_L-t2"><?= number_format($v['total_payed'], 0, '', ' ') ?> руб.</p>
                                </div>
                                <div class="OrderCard_main_R">
                                    <?php $regions = json_decode($v['regions']); ?>
                                    <?php
                                    $firstDay = date("Y-m-d 00:00:00", time() - 3600 * 24 * 7);
                                    $lastDay = date('Y-m-d 23:59:59');
                                    $start = new DateTime($firstDay);
                                    $interval = new DateInterval('P1D');
                                    $end = new DateTime($lastDay);
                                    $period = new DatePeriod($start, $interval, $end);
                                    ##общая стата
                                    $stats = OffersAlias::find() # это все лиды
                                    ->select('DATE(`date`) as `date_lead`, count(1) as `summ`')
                                        ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
                                        ->andWhere(['provider_id' => $provider->id])
                                        ->andWhere(['offer_id' => $v['id']])
                                        ->groupBy('date_lead')
                                        ->all();
                                    $stats2 = LeadsSentReport::find() # это подтвержденные лиды
                                    ->select('DATE(`date`) as `date_lead`, count(1) as `summ`, status')
                                        ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
                                        ->andWhere(['provider_id' => $provider->id])
                                        ->andWhere(['offer_id' => $v['id']])
                                        ->andWhere(['status' => Leads::STATUS_CONFIRMED])
                                        ->groupBy('date_lead')
                                        ->all();
                                    $stats3 = LeadsSentReport::find() # это брак
                                    ->select('DATE(`date`) as `date_lead`, count(1) as `summ`, status')
                                        ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
                                        ->andWhere(['provider_id' => $provider->id])
                                        ->andWhere(['offer_id' => $v['id']])
                                        ->andWhere(['AND', ['status' => Leads::STATUS_WASTE], ['status_confirmed' => 1]])
                                        ->groupBy('date_lead')
                                        ->all();
                                    $count = 0;
                                    $budgets = [];
                                    $buff1 = [];
                                    $count2 = 0;
                                    $budgets2 = [];
                                    $budgets3 = [];
                                    $buff2 = [];
                                    $buff3 = [];
                                    $labels = [];
                                    if (!empty($period)) {
                                        foreach ($period as $item) {
                                            $labels[] = $item->format('d.m');
                                        }
                                    } else
                                        $date = [];
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


                                    $idParam = $v['id'];
                                    $jsDynamic = <<<JS
var ctx = document.getElementsByClassName('pjax-chart-$idParam')[0].getContext('2d');
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
                borderDash: [5, 5],
            },
            {
                label: 'Брак',
                data: $budgets3,
                borderColor: ['#FF6359',],
                backgroundColor: ['#FF6359'],
                cubicInterpolationMode: 'monotone',
                fill: true
            },
            {
                label: 'Подтвержденных',
                data: $budgets2,
                borderColor: ['#92E3A9',],
                backgroundColor: ['#92E3A9'],
                cubicInterpolationMode: 'monotone',
                fill: true
            },
           
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                },
            },
            x: {
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Выборка за 7 дней',
              }
        }
    }
};
var myChart = new Chart(ctx, Obj);
JS;
                                    $this->registerJs($jsDynamic);
                                    ?>
                                    <div class="OrderCard_main" style="border-bottom: 0">
                                        <canvas class="pjax-chart-<?= $v['id'] ?>" width="auto" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="OrderCard_bottom" style="display: block">
                                <div>
                                    <a class="OrderCard_bottom-L click-toggle" data-pjax="0" href="#" data-id="<?= $v['id'] ?>">детали</a>
                                </div>
                                <div class="open-toggle" data-id="<?= $v['id'] ?>" style="display: none">
                                    <div style="margin-bottom: 25px">Информация об оффере</div>
                                    <div style="display: flex; flex-wrap: wrap; font-size: 16px;">
                                        <div style="margin-right: 30px">
                                            <?php if(isset($catArray[$v['category']])): ?>
                                                <p class="OrderCard_main_L-t1">сфера</p>
                                                <p class="OrderCard_main_L-t2"><?= $catArray[$v['category']] ?></p>
                                            <?php endif; ?>
                                            <p class="OrderCard_main_L-t1">осталось поставить</p>
                                            <p class="OrderCard_main_L-t2"><?= $v['leads_need'] - $v['leads_confirmed'] ?> шт.</p>
                                        </div>
                                        <div style="margin-right: 10px">
                                            <?php $regs = json_decode($v['regions'], 1); ?>
                                            <?php if(!empty($regs)): ?>
                                                <p class="OrderCard_main_L-t1">регионы</p>
                                                <p class="OrderCard_main_L-t2">
                                                    <?= implode('<br>', $regs) ?>
                                                    <?php if($v['category'] === 'chardjbek' && !empty(($param = json_decode($v['special_params'], 1))) && !empty($param['geo'])): ?>
                                                        <br><?= $param['geo'] ?>
                                                    <?php endif; ?>
                                                </p>

                                            <?php endif; ?>
                                            <p class="OrderCard_main_L-t1">цена лида</p>
                                            <p class="OrderCard_main_L-t2"><?= $v['price'] ?> руб.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <section class="rightInfo rightInfo_no-orders">
                    <div class="title_row">
                        <p class="Bal-ttl title-main">Активные офферы</p>
                    </div>
                    <section class="rightInfo_no-orders_info">
                        <img class="rightInfo_no-orders_info-back"
                             src="<?= Url::to(['/img/rightInfo_no-orders-back.svg']) ?>" alt="иконка">
                        <h2 class="rightInfo_no-orders_info_title">
                            Нет офферов
                        </h2>
                        <a href="<?= Url::to(['myorders']) ?>" class="Hcont_R_R-AddZ-Block uscp df jcsb aic">
                            <img src="<?= Url::to(['/img/plass.svg']) ?>" alt="Плюс">
                            <p class="BText Hcont_R_R-AddZ-BTN-t">Назад</p>
                        </a>
                    </section>
                </section>
            <?php endif; ?>
            <?php Pjax::end(); ?>
        </div>
    </section>


    <section class="OrderCardS OrderPage OrderPage-3">
        <?= Html::beginForm('', 'get', ['class' => 'finishedFilter']) ?>
        <div class="MyOrders_filter">
            <button class="MyOrders_filter-reset" type="reset"></button>
            <select class="MyOrders_filter-select" name="finishedFilter[sphere]" id="">
                <option selected disabled>Сфера</option>
                <?php foreach ($sphere as $k => $v): ?>
                    <option class="sendFinished" value="<?= $v['link_name'] ?>"><?= $v['name'] ?></option>
                <?php endforeach; ?>
            </select>
            <input class="MyOrders_filter-check" type="checkbox" name="finishedFilter[new]"
                   id="MyOrders_filter-checks">
            <label class="MyOrders_filter-check-l sendFinished <?= !empty($_GET['finishedFilter']['new']) ? 'activeCheck' : '' ?>" for="MyOrders_filter-checks">Новые</label>
        </div>
        <?= Html::endForm(); ?>
        <div class="pjaxss">
            <?php Pjax::begin(['id' => 'finishedContainer']) ?>
            <?php if (!empty($activeOrders2)): ?>
                <?php foreach ($activeOrders2 as $k => $v): ?>
                    <?php if ($v['status'] === 'выполнен'): ?>
                        <div class="OrderCard">
                            <div class="top">
                                <div class="Lcol">
                                    <div class="L">
                                        <h2 class="OrderNum"><?= $v['name'] ?></h2>
                                        <!--                                    <a href="-->
                                        <? //= Url::to(['#']) ?><!--">Статистика</a>-->
                                    </div>
                                    <div class="R">
                                        <div class="topb">
                                            <p>Выполнено:<span
                                                        class="OrderCard-done-percentage"><?= $v['leads_need'] > 0 ? round(($v['leads_total'] * 100) / $v['leads_need'], 2) : 0 ?>%</span>
                                            </p>
                                        </div>
                                        <div class="bott">
                                            <div style="width: <?= $v['leads_need'] > 0 ? round(($v['leads_total'] * 100) / $v['leads_need'], 2) : 0 ?>px;" class="bottfill"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="Rcol">
                                    <div class="R">
                                        <?php

                                        switch ($v['status']) {
                                            case 'выполнен':
                                                $text = 'Оффер выполнен';
                                                $class = 'Performed';
                                                break;
                                        }

                                        ?>
                                        <div class="order-status <?= $class ?>">
                                            <div class="order__help-status"><?= $text ?></div>
                                            <p><?= mb_convert_case($v['status'], MB_CASE_TITLE) ?></p>
                                        </div>
                                        <p class="date">от <?= date('d.m.Y', strtotime($v['date'])) ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php $regions = json_decode($v['regions']); ?>
                            <div class="OrderCard_main">
                                <div class="OrderCard_main_L">
                                    <p class="OrderCard_main_L-t1">Требуемый объем</p>
                                    <p class="OrderCard_main_L-t2"><?= $v['leads_need'] ?> шт.</p>
                                    <p class="OrderCard_main_L-t1">Поставлено всего</p>
                                    <p class="OrderCard_main_L-t2"><?= $v['leads_total'] ?> шт.</p>
                                    <p class="OrderCard_main_L-t1">брак</p>
                                    <p class="OrderCard_main_L-t2"><?= $v['leads_waste'] ?> шт.</p>
                                    <p class="OrderCard_main_L-t1">получено средств</p>
                                    <p class="OrderCard_main_L-t2"><?= number_format($v['total_payed'], 0, '', ' ') ?> руб.</p>
                                </div>
                                <div class="OrderCard_main_R">
                                    <?php $regions = json_decode($v['regions']); ?>
                                    <?php
                                    $firstDay = date("Y-m-d 00:00:00", time() - 3600 * 24 * 7);
                                    $lastDay = date('Y-m-d 23:59:59');
                                    $start = new DateTime($firstDay);
                                    $interval = new DateInterval('P1D');
                                    $end = new DateTime($lastDay);
                                    $period = new DatePeriod($start, $interval, $end);
                                    ##общая стата
                                    $stats = OffersAlias::find() # это все лиды
                                    ->select('DATE(`date`) as `date_lead`, count(1) as `summ`')
                                        ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
                                        ->andWhere(['provider_id' => $provider->id])
                                        ->andWhere(['offer_id' => $v['id']])
                                        ->groupBy('date_lead')
                                        ->all();
                                    $stats2 = LeadsSentReport::find() # это подтвержденные лиды
                                    ->select('DATE(`date`) as `date_lead`, count(1) as `summ`, status')
                                        ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
                                        ->andWhere(['provider_id' => $provider->id])
                                        ->andWhere(['offer_id' => $v['id']])
                                        ->andWhere(['status' => Leads::STATUS_CONFIRMED])
                                        ->groupBy('date_lead')
                                        ->all();
                                    $stats3 = LeadsSentReport::find() # это брак
                                    ->select('DATE(`date`) as `date_lead`, count(1) as `summ`, status')
                                        ->where(['AND', ['>=', 'date', $firstDay], ['<=', 'date', $lastDay]])
                                        ->andWhere(['provider_id' => $provider->id])
                                        ->andWhere(['offer_id' => $v['id']])
                                        ->andWhere(['AND', ['status' => Leads::STATUS_WASTE], ['status_confirmed' => 1]])
                                        ->groupBy('date_lead')
                                        ->all();
                                    $count = 0;
                                    $budgets = [];
                                    $buff1 = [];
                                    $count2 = 0;
                                    $budgets2 = [];
                                    $budgets3 = [];
                                    $buff2 = [];
                                    $buff3 = [];
                                    $labels = [];
                                    if (!empty($period)) {
                                        foreach ($period as $item) {
                                            $labels[] = $item->format('d.m');
                                        }
                                    } else
                                        $date = [];
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


                                    $idParam = $v['id'];
                                    $jsDynamic = <<<JS
var ctx = document.getElementsByClassName('pjax-chart-$idParam')[0].getContext('2d');
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
                borderDash: [5, 5],
            },
            {
                label: 'Брак',
                data: $budgets3,
                borderColor: ['#FF6359',],
                backgroundColor: ['#FF6359'],
                cubicInterpolationMode: 'monotone',
                fill: true
            },
            {
                label: 'Подтвержденных',
                data: $budgets2,
                borderColor: ['#92E3A9',],
                backgroundColor: ['#92E3A9'],
                cubicInterpolationMode: 'monotone',
                fill: true
            },
           
        ]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                },
            },
            x: {
            }
        },
        plugins: {
            title: {
                display: true,
                text: 'Выборка за 7 дней',
              }
        }
    }
};
var myChart = new Chart(ctx, Obj);
JS;
                                    $this->registerJs($jsDynamic);
                                    ?>
                                    <div class="OrderCard_main" style="border-bottom: 0">
                                        <canvas class="pjax-chart-<?= $v['id'] ?>" width="auto" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="OrderCard_bottom" style="display: block">
                                <div>
                                    <a class="OrderCard_bottom-L click-toggle" data-pjax="0" href="#" data-id="<?= $v['id'] ?>">детали</a>
                                </div>
                                <div class="open-toggle" data-id="<?= $v['id'] ?>" style="display: none">
                                    <div style="margin-bottom: 25px">Информация об оффере</div>
                                    <div style="display: flex; flex-wrap: wrap; font-size: 16px;">
                                        <div style="margin-right: 30px">
                                            <?php if(isset($catArray[$v['category']])): ?>
                                                <p class="OrderCard_main_L-t1">сфера</p>
                                                <p class="OrderCard_main_L-t2"><?= $catArray[$v['category']] ?></p>
                                            <?php endif; ?>
                                            <p class="OrderCard_main_L-t1">осталось поставить</p>
                                            <p class="OrderCard_main_L-t2"><?= $v['leads_need'] - $v['leads_total'] ?> шт.</p>
                                        </div>
                                        <div style="margin-right: 10px">
                                            <?php $regs = json_decode($v['regions'], 1); ?>
                                            <?php if(!empty($regs)): ?>
                                                <p class="OrderCard_main_L-t1">регионы</p>
                                                <p class="OrderCard_main_L-t2">
                                                    <?= implode('<br>', $regs) ?>
                                                    <?php if($v['category'] === 'chardjbek' && !empty(($param = json_decode($v['special_params'], 1))) && !empty($param['geo'])): ?>
                                                        <br><?= $param['geo'] ?>
                                                    <?php endif; ?>
                                                </p>

                                            <?php endif; ?>
                                            <p class="OrderCard_main_L-t1">цена лида</p>
                                            <p class="OrderCard_main_L-t2"><?= $v['price'] ?> руб.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <section class="rightInfo rightInfo_no-orders">
                    <div class="title_row">
                        <p class="Bal-ttl title-main">Завершенные офферы</p>
                    </div>
                    <section class="rightInfo_no-orders_info">
                        <img class="rightInfo_no-orders_info-back"
                             src="<?= Url::to(['/img/rightInfo_no-orders-back.svg']) ?>" alt="иконка">
                        <h2 class="rightInfo_no-orders_info_title">
                            Выполненные офферы не найдены
                        </h2>
                    </section>
                </section>
            <?php endif; ?>
            <?php Pjax::end(); ?>
        </div>
    </section>
</section>