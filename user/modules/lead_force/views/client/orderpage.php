<?php

use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use common\models\LeadsSentReport;

$this->title = 'Просмотр заказа';

$bonus_waste = 0;
if (!empty($bonuses) && !empty($bonuses->additional_waste)){
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

    $('.order-page_leads-tab').on('click', function() {
        var tab = $(this).attr('data-tab');
        $('input[name="tab"]').val(tab);
        $.pjax.reload({
              container: '#allContainer',
              url: "orderpage",
              type: "GET",
              data: {link:link,tab:tab},
           }).done(function() {
                $('.leads_filter_checkbox').styler({});
           });
    });
    $('.Form_leads_filter').on('submit', function(e) {
        var data = $('.Form_leads_filter').serializeArray();
        e.preventDefault();
        $.pjax.reload({
            data: data,
            container: '#allContainer',
            type: 'GET',
            url: "orderpage",
        }).done(function() {
            $('.leads_filter_checkbox').styler({});
        });
    })
    
    $('.order-page_info-cards_right-day').on('click', function() {
        var dayNumber = $(this).attr('data-day');
            toggl = $(this);
        $.ajax({
            url: 'change-day',
            type: 'POST',
            data: {day:dayNumber, link:link},
        }).done(function(rsp) {
            if (rsp.status == 'success'){
                toggl.toggleClass('order-page_info-cards_right-day-active');
            } else {
                $('.rsp-ajax-text').text(rsp.message);
                $('.popup--auct-err').fadeIn(300);
            }
        });
    });
    
    $('.time_change').on('click', function() {
      var start = parseInt($('.start__time').val().replace(/^0+/, '').slice(0, -3)),
          end = parseInt($('.end__time').val().replace(/^0+/, '').slice(0, -3));
      $.ajax({
        url: 'change-time',
        type: 'POST',
        data: {start:start, end:end, link:link},
      }).done(function(resp) {
        if(resp.status == 'success'){
            $('.popup__text').text(resp.message)
            $('.popup--auct').fadeIn(300);
        } else {
            $('.rsp-ajax-text').text(resp.message);
            $('.popup--auct-err').fadeIn(300);
        }
      })
    });
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
    $('.timepick').timepicker({ 'timeFormat': 'H:i', 'step': 60 });
    
    $('.order-page_leads_filter_BTN-submit').on('click', function() {
        $.ajax({
            url: 'confirm-lead?link=' + link,
            dataType: 'JSON',
            type: 'POST',
            data: $('.select__lead').serialize(),
        }).done(function(rsp) {
            if (rsp.status == 'success'){
                location.reload();
            } else {
                $('.rsp-ajax-text').text(rsp.message);
                $('.popup--auct-err').fadeIn(300);
            }
        });
    });    
    $('.order-page_lead_popap-wrap').on('click', '.confLead',function() {
        var id = $(this).attr('data-id');
        console.log(id);
        $.ajax({
            url: 'confirm-lead?link=' + link,
            dataType: 'JSON',
            type: 'POST',
            data: {id:id},
        }).done(function(rsp) {
            if (rsp.status == 'success'){
                location.reload();
            } else {
                $('.rsp-ajax-text').text(rsp.message);
                $('.popup--auct-err').fadeIn(300);
            }
        });
    });
    
    $('select[name="cause"]').on('change', function() {
      if ($('.leads__Waste__why option:selected').val() === 'Свой'){
            $('input[name="сauseInfo"]').fadeIn(300);
        } else {
            $('input[name="сauseInfo"]').fadeOut(300);
        }
    });
   
    $('.Popap-order-BTN').on('click', function () {
        if ($('.leads__Waste__why option:selected').val() === 'Свой'){
            var why = $('input[name="сauseInfo"]').val();
        } else {
            why = $('.leads__Waste__why option:selected').val()
        }
        var id = $('.wasteLead').attr('data-id'),
            arr = $('.select__lead').serializeArray();
        if (id !== undefined){
            arr.push({name: 'id', value: [id]});
        }
        arr.push({name: 'why', value: why});
        $.ajax({
            url: 'waste-lead?link=' + link,
            dataType: 'JSON',
            type: 'POST',
            data: arr,
        }).done(function(rsp) {
            if (rsp.status == 'success'){
                $('.Popap-go-brak1').fadeOut(300, function() {
                    $('.Popap-go-brak2').fadeIn(300, function() {
                        $('.Popap-go-brak2').fadeOut(300);
                        $('.PopapBack').fadeOut(300);
                        $('.order-page_leads_filter_BTN-go-brak').fadeOut(300);
                    });
                });
                $.pjax.reload({
                    container: '#allContainer'
                }).done(function() {
                    $('.leads_filter_checkbox').styler({});
                })
            } else {
                $('.rsp-ajax-text').text(rsp.message);
                $('.popup--auct-err').fadeIn(300);
            }
        });
    });
    
    $('.select__lead, .leads_filter_maincheckbox').on('change', function() {
        var count = $('.select__lead:checked').length;
        $('.count__check').text(count)
    });
    
    $('.order-page_leads_tab').on('click', '.order-page_leads_link', function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url: 'popup-lead-date?link=' + link,
            type: 'POST',
            data: {id:id},
        }).done(function(rsp) {
            $('.order-page_lead_popap-wrap').html(rsp).fadeIn(300);
            $('.order-page_lead_popap_back').fadeIn(300);
        });
    });
    $('.order-page_lead_popap-wrap').on('click', '.order-page_leads_filter_BTN-go-brak', function() {
       $('.PopapBack').fadeIn(300);
       $('.Popap-go-brak, .Popap-go-brak1-1').fadeIn(300);
    });

    $('.order-page_lead_popap-wrap').on('click', '.order-page_lead_popap-close', function() {
        $('.order-page_lead_popap_back').fadeOut(300);
        $('.order-page_lead_popap-wrap').fadeOut(300);
    });
    
    
JS;
$css = <<< CSS
    .dropdown{
        position: relative;
        transition-duration: 0.3s;
        align-self: flex-start;
        /*width: 80px;*/
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

?>
<section class="rightInfo">

    <nav class="BredCramsonBalance df aic">
        <a href="<?= Url::to(['myorders']) ?>" class="BRChome uscp MText">Мои заказы</a>
        <img src="<?= Url::to(['/img/ArrRightBRC.png']) ?>" alt="Стрелка справа">
        <a href="<?= Url::to(['myorders']) ?>" class="BRChome uscp MText">Активные заказы</a>
        <img src="<?= Url::to(['/img/ArrRightBRC.png']) ?>" alt="Стрелка справа">
        <p class="BRCpagenow MText"><?= $order['order_name'] ?></p>
    </nav>
    <div class="order-page_title-row">
        <h1 class="Bal-ttl"><?= $order['order_name'] ?></h1>
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
    <?php if ($order['price'] > $user['budget']): ?>
        <section class="order-page_alert-zero-balance">
            <img src="<?= Url::to(['/img/bell-yellow.svg']) ?>" alt="icon" class="order-page_alert-zero-balance-img">
            <div class="order-page_alert-zero-balance_info">
                <h3 class="order-page_alert-zero-balance_info-title">Недостаточно средств на балансе</h3>
                <p class="order-page_alert-zero-balance_info-text">Ваш заказ №1 начнет исполняться после того, как вы
                    пополните баланс</p>
                <a href="<?= Url::to(['balance']) ?>" class="order-page_alert-zero-balance_info-BTN">
                    Перейти к оплате
                </a>
            </div>
            <img src="<?= Url::to(['/img/delete.png']) ?>" alt="close" class="order-page_alert-zero-balance-close">
        </section>
    <?php endif; ?>
    <section class="order-page_info-cards">
        <div class="order-page_info-cards_left">
            <div class="order-page_info-card-1">
                <div class="order-page_info-card-1_top">
                    <div class="order-page_info-card-1_top_left">
                        <h2 class="order-page_info-card-1_top-title">
                            Информация о заказе
                        </h2>
                        <p class="order-page_info-card-1_top-date">
                            от <?= date('d.m.Y', strtotime($order['date'])) ?>
                        </p>
                    </div>
                    <div class="order-page_info-card-1_actions">
                        <?php if ($order['status'] == 'исполняется'): ?>
                            <!--<div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Действия <b
                                            class="caret"></b></a>
                                <?php
/*                                echo Dropdown::widget([
                                    'items' => [
                                        ['label' => 'Поставить на паузу', 'options' => ['data-order' => $order['id'], 'data-hash' => md5("{$user['id']}::{$order['id']}::order-hash")]],
                                    ],
                                ]);
                                */?>
                            </div>-->
                        <?php elseif ($order['status'] == 'пауза'): ?>
                            <!--<div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">Действия <b
                                            class="caret"></b></a>
                                <?php
/*                                echo Dropdown::widget([
                                    'items' => [
                                        ['label' => 'Возобновить', 'options' => ['data-order' => $order['id'], 'data-hash' => md5("{$user['id']}::{$order['id']}::order-hash")]],
                                    ],
                                ]);
                                */?>
                            </div>-->
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
                                <?= $order['category_text'] ?>
                            </p>
                        </div>
                        <div class="order-page_info-card-1_main_left-group">
                            <p class="order-page_info-card-1_main_left-group-t1">
                                стоимость
                            </p>
                            <p class="order-page_info-card-1_main_left-group-t2">
                                <?= $order['price'] ?>₽/лид
                            </p>
                        </div>
                        <div class="order-page_info-card-1_main_left-group">
                            <p class="order-page_info-card-1_main_left-group-t1">
                                почта
                            </p>
                            <p class="order-page_info-card-1_main_left-group-t2">
                                <?= $order['emails'] ?>
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
                        <div class="order-page_info-card-1_main_left-group">
                            <p class="order-page_info-card-1_main_left-group-t1">
                                отбраковка
                            </p>
                            <p class="order-page_info-card-1_main_left-group-t2">
                                до <?= $order['waste'] + $bonus_waste ?>%
                            </p>
                        </div>
                        <div class="order-page_info-card-1_main_left-group">
                            <p class="order-page_info-card-1_main_left-group-t1">
                                интеграция <a href="<?= Url::to(['integration', 'order_id' => $order['id']]) ?>">(настроить)</a>
                            </p>
                            <p class="order-page_info-card-1_main_left-group-t2">
                                Настроена
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="order-page_info-card-2">
                <div class="order-page_info-card-2_top">
                    <h2 class="order-page_info-card-2_top-title">
                        Информация об отгрузке
                    </h2>
                </div>
                <div class="order-page_info-card-2_row">
                    <p class="order-page_info-card-2_row-left">
                        Всего лидов
                    </p>
                    <p class="order-page_info-card-2_row-right">
                        <?= $order['leads_count'] ?>
                    </p>
                </div>
                <div class="order-page_info-card-2_row">
                    <p class="order-page_info-card-2_row-left">
                        отгружено
                    </p>
                    <p class="order-page_info-card-2_row-right">
                        <?= $order['leads_get'] ?>/<?= $order['leads_count'] ?>
                    </p>
                </div>
                <div class="order-page_info-card-2_row">
                    <p class="order-page_info-card-2_row-left">
                        отбракованно
                    </p>
                    <p class="order-page_info-card-2_row-right">
                        <?= $order['leads_waste'] ?>
                    </p>
                </div>
                <div class="order-page_info-card-2_row">
                    <p class="order-page_info-card-2_row-left">
                        потрачено средств
                    </p>
                    <p class="order-page_info-card-2_row-right">
                        <?= number_format($order['leads_get'] * $order['price'], 0, '', ' ') ?>₽
                    </p>
                </div>
            </div>
        </div>
        <div class="order-page_info-cards_right">
            <h2 class="order-page_info-cards_right-title">
                Подробности
            </h2>

            <?php if (false): ?>
                <p class="order-page_info-cards_right-t1">
                    Время отгрузки
                </p>
                <div class="order-page_info-cards_right-week">
                    <?php $days = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'] ?>
                    <?php foreach ($days as $k => $v): ?>
                        <?php $class = ''; ?>
                        <?php if (!empty($params['days_of_week_leadgain'])): ?>
                            <?php if (in_array($k + 1, $params['days_of_week_leadgain'])): ?>
                                <?php $class = 'order-page_info-cards_right-day-active'; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                        <div data-day="<?= $k + 1 ?>"
                             class="order-page_info-cards_right-day <?= $class ?>">
                            <?= $v ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="order-page_info-cards_right_time">
                    <p class="order-page_info-cards_right_time-t1">с</p>
                    <input type="text" name="time_start" value="<?= $params['start_time_leadgain'] ?>"
                           class="timepick start__time">
                    <p class="order-page_info-cards_right_time-t2"></p>
                    <p class="order-page_info-cards_right_time-t1">до</p>
                    <input type="text" name="time_end" value="<?= $params['end_time_leadgain'] ?>"
                           class="timepick end__time">
                </div>

                <button class="order-page_info-cards_right_time_cgange time_change">Изменить</button>
            <?php endif; ?>
            <p class="order-page_info-cards_right-t3">
                Выполнение заказа
            </p>
            <div class="order-page_info-cards_right_process">
                <div class="order-page_info-cards_right_process_top">
                    <div class="order-page_info-cards_right_process">
                        <p>Отгружено лидов:<span
                                    class="order-page_info-cards_right_process-percentage">
                                <?= $order['leads_get'] > 0 && $order['leads_count'] + $order['leads_waste'] > 0
                                    ? round(100 * $order['leads_waste'] / ($order['leads_count'] + $order['leads_waste']), 0) : 0?>
                                %</span>
                        </p>
                    </div>
                    <div class="order-page_info-cards_right_process-bott">
                        <div style="width: <?= round(($order['leads_get'] * 100) / $order['leads_count'], 2) ?>px"
                             class="order-page_info-cards_right_process-bottfill"></div>
                    </div>
                </div>
                <div class="order-page_info-cards_right_process_top">
                    <div class="order-page_info-cards_right_process">
                        <p>Отбраковано лидов:<span
                                    class="order-page_info-cards_right_process-percentage"><?= round(($order['leads_waste'] * 100) / ($order['leads_count'] - $order['leads_waste']), 2) ?>%</span>
                        </p>
                    </div>
                    <div class="order-page_info-cards_right_process-bott">
                        <div style="width: <?= $order['waste'] + $bonus_waste > 0 ? round(100 / ($order['waste'] + $bonus_waste), 0) : 2 ?>%;"
                             class="order-page_info-cards_right_process-bottfill order-page_info-cards_right_process-bottfill2"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if (empty($contLead)): ?>
        <section class="order-page_info-error">
            <img src="<?= Url::to(['/img/rightInfo_no-orders-back.svg']) ?>" alt="icon">
            <h2 class="order-page_info-error_title">
                Здесь будут ваши лиды
            </h2>
            <p class="order-page_info-error-text">
                Здесь будет список всех ваших лидов, вы сможете их подтверждать и отбраковывать
            </p>
        </section>
    <?php else: ?>

        <section class="order-page_leads_wrapp">
            <div class="order-page_leads-tabs">
                <div data-tab="all"
                     class="order-page_leads-tab <?= empty($_GET['tab']) ? 'active' : '' ?> <?= $_GET['tab'] == 'all' ? 'active' : '' ?>"
                     id="order-page_leads-tab1">
                    <p class="order-page_leads-tab-t1">Все лиды</p>
                    <p class="order-page_leads-tab-t2"><?= $allLead ?></p>
                </div>
                <div data-tab="send" class="order-page_leads-tab <?= $_GET['tab'] == 'send' ? 'active' : '' ?>"
                     id="order-page_leads-tab2">
                    <p class="order-page_leads-tab-t1">Новые лиды</p>
                    <p class="order-page_leads-tab-t2">+<?= $newLead ?></p>
                </div>
                <div data-tab="moderation"
                     class="order-page_leads-tab <?= $_GET['tab'] == 'moderation' ? 'active' : '' ?>"
                     id="order-page_leads-tab3">
                    <p class="order-page_leads-tab-t1">Отправлено в брак</p>
                </div>
                <div data-tab="waste" class="order-page_leads-tab <?= $_GET['tab'] == 'waste' ? 'active' : '' ?>"
                     id="order-page_leads-tab4">
                    <p class="order-page_leads-tab-t1">Брак</p>
                    <p class="order-page_leads-tab-t2">+<?= $wasteLead ?></p>
                </div>
            </div>
            <div class="order-page_leads">
                <div class="order-page_leads_tab order-page_leads_tab1">

                    <?= Html::beginForm('', 'get', ['class' => 'Form_leads_filter']) ?>
                    <input type="hidden" name="tab" value="<?= Html::encode($_GET['tab']) ?>">
                    <div class="order-page_leads_filter adaptiveFilter_lead">
                        <input placeholder="Ключевое слово" autocomplete="off" class="InputSearch adInpSearch" type="text"
                               name="filters[word]">
                        <p class="order-page_leads_filter-t">
                            Выбрать период
                        </p>
                        <p class="order-page_leads_filter-t">с</p>
                        <?php echo DatePicker::widget([
                            'name' => 'filters[first]',
//                            'value' => Html::encode($_GET['filters']['first']),
                            'options' => ['class' => 'inpdate adDatefilter', 'placeholder' => date('Y-m-d', time() - 3600 * 7 * 24)],
                            //'language' => 'ru',
                            'dateFormat' => 'yyyy-MM-dd',
                        ]); ?>
                        <p class="order-page_leads_filter-t">по</p>
                        <?php echo DatePicker::widget([
                            'name' => 'filters[last]',
//                            'value' => Html::encode($_GET['filters']['last']),
                            'options' => ['class' => 'inpdate2 adDatefilter', 'placeholder' => date('Y-m-d')],
                            //'language' => 'ru',
                            'dateFormat' => 'yyyy-MM-dd',
                        ]); ?>
                        <button type="submit"
                                class="uscp Page2-Balance_chooseP-BTN df aic jcc order-page_leads_filterBTN adFiltersBtn">Показать
                        </button>
                    </div>
                    <div class="order-page_leads_filter_BTNs">
                        <div class="order-page_leads_filter_BTNs_content">
                            <div class="order-page_leads_filter_BTN-submit">
                                Подтвердить
                            </div>
                            <div class="order-page_leads_filter_BTN-go-brak">
                                Отправить в брак
                            </div>
                            <p class="order-page_leads_filter_BTNs-t">Выбрано: <span class="count__check">0</span></p>
                        </div>
                    </div>
                    <?= Html::endForm(); ?>
                    <div class="order-page_leads_names">
                        <input class="leads_filter_checkbox leads_filter_maincheckbox" type="checkbox" name="choose">
                        <p class="order-page_leads_names-t order-page_leads_names-t1">ID</p>
                        <p class="order-page_leads_names-t order-page_leads_names-t2">фио</p>
                        <p class="order-page_leads_names-t order-page_leads_names-t3">телефон</p>
                        <p class="order-page_leads_names-t order-page_leads_names-t4">статус</p>
                        <p class="order-page_leads_names-t order-page_leads_names-t5">дата</p>
                    </div>
                    <?php Pjax::begin(['id' => 'allContainer']) ?>
                    <?php foreach ($leads as $k => $v): ?>
                        <?php if (!empty($wordfilter)): ?>
                        <?php print_r($wordfilter) ?>
                            <?php $v->filters = $wordfilter; ?>
                            <?php if (!empty($v->filteredLeads)): ?>
                                <div class="order-page_leads_tab_row">
                                    <?php if ($v->status == \common\models\Leads::STATUS_SENT): ?>
                                        <input class="leads_filter_checkbox select__lead" type="checkbox" name="id[]"
                                               value="<?= $v->filteredLeads->id ?>">
                                    <?php else: ?>
                                        <div style="width: 20px; padding: 9px;"></div>
                                    <?php endif; ?>
                                    <p class="order-page_leads_name-1"><?= $v->filteredLeads->id ?></p>
                                    <p class="order-page_leads_name-2"><?= !empty($v->filteredLeads->name) ? $v->filteredLeads->name : 'Без имени' ?></p>
                                    <p class="order-page_leads_name-3"><?= $v->filteredLeads->phone ?></p>
                                    <?php
                                    switch ($v->status) {
                                        case 'подтвержден':
                                            $class = 'order-page_leads_name_status-submit';
                                            $statusLead = 'Подтвержден';
                                            break;
                                        case 'брак':
                                            if ($v->status_confirmed === 0) {
                                                $class = 'order-page_leads_name_status-moderation';
                                                $statusLead = 'Модерация';
                                            } else {
                                                $class = 'order-page_leads_name_status-brak';
                                                $statusLead = 'Брак';
                                            }
                                            break;
                                        case 'отправлен':
                                            $class = '';
                                            $statusLead = 'Новый';
                                            break;
                                    }
                                    ?>

                                    <p class="order-page_leads_name-4 <?= $class ?>"><?= $statusLead ?></p>
                                    <p class="order-page_leads_name-5"><?= date('d.m.Y', strtotime($v->date)) ?></p>
                                    <div data-id="<?= $v->filteredLeads->id ?>" data-pjax="0"
                                         class="order-page_leads_link">
                                        <img src="<?= Url::to(['/img/readmore.svg']) ?>" alt="icon">
                                        Подробнее
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <div class="order-page_leads_tab_row">
                                <?php if ($v->status == \common\models\Leads::STATUS_SENT): ?>
                                    <input class="leads_filter_checkbox select__lead" type="checkbox" name="id[]"
                                           value="<?= $v->lead->id ?>">
                                <?php else: ?>
                                    <div style="width: 20px; padding: 9px;"></div>
                                <?php endif; ?>
                                <p class="order-page_leads_name-1"><?= $v->lead->id ?></p>
                                <p class="order-page_leads_name-2"><?= !empty($v->lead->name) ? $v->lead->name : 'Без имени' ?></p>
                                <p class="order-page_leads_name-3"><?= $v->lead->phone ?></p>
                                <?php
                                switch ($v->status) {
                                    case 'подтвержден':
                                        $class = 'order-page_leads_name_status-submit';
                                        $statusLead = 'Подтвержден';
                                        break;
                                    case 'брак':
                                        if ($v->status_confirmed === 0) {
                                            $class = 'order-page_leads_name_status-moderation';
                                            $statusLead = 'Модерация';
                                        } else {
                                            $class = 'order-page_leads_name_status-brak';
                                            $statusLead = 'Брак';
                                        }
                                        break;
                                    case 'отправлен':
                                        $class = '';
                                        $statusLead = 'Новый';
                                        break;
                                }
                                ?>

                                <p class="order-page_leads_name-4 <?= $class ?>"><?= $statusLead ?></p>
                                <p class="order-page_leads_name-5"><?= date('d.m.Y', strtotime($v->date)) ?></p>
                                <div data-id="<?= $v->id ?>" data-pjax="0" class="order-page_leads_link">
                                    <img src="<?= Url::to(['/img/readmore.svg']) ?>" alt="icon">
                                    Подробнее
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php echo LinkPager::widget([
                        'pagination' => $pages,
                    ]); ?>
                    <?php Pjax::end() ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    <div class="order-page_lead_popap_back"></div>
    <div class="order-page_lead_popap-wrap">

    </div>
    <div class="PopapBack"></div>
    <div class="PopapDBCWrap Popap-go-brak">
        <div class="PopapDBC Popap-go-brak1 Popap-go-brak1-1">
            <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
            <div class="PopapDBC-Cont df fdc aic">
                <h2 class="Popap-go-brak-ttl">Отправить в брак</h2>
                <div class="PopapDBC-Form df fdc">
                    <p class="PopapDBC-t2 HText">Выберите причину отбраковки</p>
                    <select class="PopapSelect leads__Waste__why" name="cause" id="">
                        <option value="<?= LeadsSentReport::REASON_DUPLICATE ?>"><?= LeadsSentReport::REASON_DUPLICATE ?></option>
                        <option value="<?= LeadsSentReport::REASON_NOT_LEAD ?>"><?= LeadsSentReport::REASON_NOT_LEAD ?></option>
                        <option value="<?= LeadsSentReport::REASON_WRONG_PHONE ?>"><?= LeadsSentReport::REASON_WRONG_PHONE ?></option>
                        <option value="<?= LeadsSentReport::REASON_WRONG_REGION ?>"><?= LeadsSentReport::REASON_WRONG_REGION ?></option>
                        <option value="Свой">Свой вариант</option>
                    </select>
                    <input style="margin: 10px 0; display: none" name="сauseInfo" placeholder="Причина брака" type="text" maxlength="20" class="order-lid__input">
                    <button class="Popap-order-BTN PopapDBC_Form-BTN BText df jcc aic uscp" type="submit">Продолжить
                    </button>
                    <button class="PopapDBC_Form-Reset BText df jcc aic uscp" type="reset">Отмена</button>
                </div>
            </div>
        </div>
        <div class="PopapDCD2 Popap-go-brak2">
            <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
            <div class="PopapDBC-Cont df fdc aic">
                <img class="PopapDCD2img" src="<?= Url::to(['/img/success.svg']) ?>" alt="Галочка">
                <h2 class="PopapDCD2-ttl">Успешно!</h2>
                <h3 class="PopapDCD2-subttl">Отправлено в брак, ожидайте подтверждения от модератора</h3>
                <p class="PopapDCD2_Form-BTN BText df jcc aic uscp">Продолжить</p>
            </div>
        </div>
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