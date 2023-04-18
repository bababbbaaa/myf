<?php

use common\models\UsersNotice;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;
use common\models\Orders;

$this->title = 'Мои заказы';

$bonus_waste = 0;
if (!empty($bonuses) && !empty($bonuses->additional_waste)) {
    $bonus_waste = $bonuses->additional_waste;
}
$start = new DateTime($firstDay);
$interval = new DateInterval('P1D');
$end = new DateTime($lastDay);
$period = new DatePeriod($start, $interval, $end);
$dates = [];
foreach ($period as $date) {
    $dates[] = $date->format('d.m');
}

$countByDay = [];
if (!empty($leadsAll)) {
    foreach ($leadsAll as $item)
        $countByDay[date("d.m", strtotime($item->date_lead))] = $item->summ;
}


$js = <<< JS
    /* Фильтр активных заказов */
    $('.activeFilter').on('submit', function(e) {
        e.preventDefault();
          $.pjax.reload({
              container: '#activeContainer',
              url: "promotion",
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
    
    /* Фильтр заказов на модерации */
    $('.moderationFilter').on('submit', function(e) {
        e.preventDefault();
          $.pjax.reload({
              container: '#moderationContainer',
              url: "promotion",
              type: "GET",
              data: $('.moderationFilter').serialize(),
           });
    });
    $('.sendModeration').on('click', function() {
        setTimeout(function() {
            $('.moderationFilter').submit();
        },300);
    });
    /* Фильтр заказов на модерации */
    
    /* Фильтр Запуска рекламы */
    $('.finishedFilter').on('submit', function(e) {
        e.preventDefault();
          $.pjax.reload({
              container: '#finishedContainer',
              url: "promotion",
              type: "GET",
              data: $('.finishedFilter').serialize(),
           });
    });
    $('.sendFinished').on('click', function() {
        setTimeout(function() {
            $('.finishedFilter').submit();
        },300);
    });
    /* Фильтр Запуска рекламы */
    
    var hash = location.hash.substring(1);
    $('.MyOrders_filter-reset').on('click', function() {
        location.href = '/lead-force/client/promotion#'+ hash;
    });
    $('.MyOrders_filter-check-l').on('click', function() {
      $(this).toggleClass('activeCheck');
    });
    
    /* Табы */
    if (hash.length === 0){
        $('.tab1').addClass('active');
        $('.OrderPage-1').fadeIn(200);
    } else {
        $('.tab').removeClass('active');
        $('.OrderPage').fadeOut();
        $('.tab' + hash).addClass('active');
        $('.OrderPage-' + hash).fadeIn(200);
    }
    $('.tabsChange').on('click', function() {
        var target = $(this).attr('href').substring(1);
        hash = $(this).attr('href').substring(1);
        $('.OrderPage').fadeOut(200, function() {
            $('.tab').removeClass('active');
            setTimeout(function() {
              $('.tab' + target).addClass('active');
                $('.OrderPage-' + target).fadeIn(200);
            },200)
           
        });
    });
    /* Табы */

    $('.pjaxss').on('click', '.dropdown-header',function() {
        var order = $(this).attr('data-order'),
            dhash = $(this).attr('data-hash');
        $.ajax({
            url: 'change-orders',
            type: 'POST',
            dataType: 'JSON',
            data: {order:order, hash:dhash}
        }).done(function(rsp) {
            if (rsp.status === 'success'){
                $.pjax.reload({container: '#activeContainer'});
            } else {
                $('.popup__text1').text(rsp.message);
                $('.popup').fadeIn(300);
            }
        });
    });
    $('.mass__close').on('click', function(e) {
    var id = $(this).attr('data-id');
        $.ajax({
            url: 'read-notice',
            type: 'POST',
            dataType: 'JSON',
            data: {id:id},
        }).done(function() {
            $.pjax.reload({container: '#noticeContainer',})
        });
    });
    
    $('.OrderPage_StatisticsFilter-Select').on('click', '.sendIdOrder', function(e) {
        var id = $('#orderId').val();
      $.pjax.reload({
            url: 'promotion#3',
            container: '#statistickReload',
            type: 'GET',
            data: {orderId: id},
      })
    });
    
    $('.generalStatistickReload').on('click', function() {
        location.href = 'promotion#3';
    });
    
        // Order start
        $('.MyOrders_filter-check-l').on('click', function() {
      $(this).toggleClass('activeCheck');
    });
            
    $('.MyOrders_filter-reset').on('click', function() {
        location.href = "promotion";
    });
    
    $('.card__btn').on('click', function() {
        var id = $(this).attr('data-id');
        $.ajax({
            url: 'popup-date',
            type: 'POST',
            data: {id:id},
        }).done(function(rsp) {
            $('.popup__body').html(rsp);
            $(".backPopUp").show();
            $("body").css("overflow", "hidden");
        });
    });
    $('.backPopUp').on('click', function(e) {
        if (e.target === this){
            $('.backPopUp').fadeOut(300);
        }
    });
    $('.popup__body').on('click', '.popup__close',function(e) {
        $('.backPopUp').fadeOut(300);
    });
JS;
$css = <<< CSS
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
    #statistickReload{
        width: 100%;
    }
.OrderPage_StatisticsFilter-Select .jq-selectbox__select-text{
width: 100% !important;
}

/* ORDER START */
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
    .card__box *:first-child {
        padding-right: 10px;
    }
    .card__box *:last-child {
        margin-left: auto;
        text-align: right;
    }
    .card__box {
        align-items: flex-start;
    }
    .MyOrders_filter{
        max-width: 300px;
    }
    .popup__order-text *{
        text-align: left !important;
        font-size: 15px;
    }
            .backPopUp{
            z-index: 100;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0, .4);
            display: none;
        }
        .popup__body {
        z-index: 100;
            position: absolute;
            overflow-y: auto;
            left: 50%;
            top: 50%;
            max-width: 600px;
            max-height: 568px;
            width: 100%;
            transform: translate(-50%, -50%);
            padding: 50px;
            background: #ffffff;
            border-radius: 4px;
        }

CSS;

$this->registerJsFile(Url::to(['/js/chart.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerCss($css);
$this->registerCssFile(Url::to(['/css/jquery.timepicker.css']));
$this->registerJsFile(Url::to(['/js/jquery.timepicker.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);

?>
<?php if (!empty($client)): ?>

<?php if ($countOrders === 0): ?>
<section class="rightInfo rightInfo_no-orders">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__link">Продвижение</span>
            </li>

            <li class="bcr__item">
                <span class="bcr__span">Запуск рекламной компании</span>
            </li>
        </ul>
    </div>
    <div class="title_row">
        <p class="Bal-ttl title-main">Продвижение</p>
        <a href="<?= Url::to(['manualauctions']) ?>" class="order__top-link link">Что такое аукцион лидов?</a>
    </div>
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
    <?php if (!empty($dialog)): ?>
        <div class="mass mass--prov">
            <div class="mass__content mass__content--prov">
                <p class="mass__title"><?= $dialog->type ?></p>
                <p class="mass__text"><?= $dialog->text ?></p>
                <button style="color: #a3ccf4;" data-id="<?= $dialog->id ?>" type="button"
                        class="mass__close mass__close--prov">&times;
                </button>
            </div>
        </div>
    <?php endif; ?>
    <section class="rightInfo_no-orders_info">
        <img class="rightInfo_no-orders_info-back" src="<?= Url::to(['/img/rightInfo_no-orders-back.svg']) ?>"
             alt="иконка">
        <h2 class="rightInfo_no-orders_info_title">
            У вас еще нет заказов
        </h2>
        <p class="rightInfo_no-orders_info-text">
            Вы можете создать свой первый заказ прямо сейчас
        </p>
        <a href="<?= Url::to(['order']) ?>" class="Hcont_R_R-AddZ-Block uscp df jcsb aic">
            <img src="<?= Url::to(['/img/plass.svg']) ?>" alt="Плюс">
            <p class="BText Hcont_R_R-AddZ-BTN-t">Добавить заказ</p>
        </a>
    </section>
    <?php else: ?>
    <section class="rightInfo rightInfo_any-orders">
        <div class="bcr">
            <ul class="bcr__list">
                <li class="bcr__item">
            <span class="bcr__link">
                Продвижение
            </span>
                </li>

                <li class="bcr__item">
            <span class="bcr__span">
                Запуск рекламной компании
            </span>
                </li>
            </ul>
        </div>
        <div class="title_row">
            <h1 class="Bal-ttl title-main">Продвижение</h1>
            <a href="<?= Url::to(['manualauctions']) ?>" class="order__top-link link">Как запустить рекламу?</a>
        </div>
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
        <?php if (!empty($dialog)): ?>
            <div class="mass mass--prov">
                <div class="mass__content mass__content--prov">
                    <p class="mass__title">Ваш заказ находится на модерации</p>
                    <?php $prop = json_decode($dialog->properties, true) ?>
                    <p class="mass__text">Категория "<?= $prop['Orders']['category_text'] ?>" по вашему заказу
                        проверяется модератором. Ожидайте
                        <a href="<?= Url::to(['support']) ?>">ответа</a> от тех. поддержки</p>
                    <button style="color: #a3ccf4;" type="button" class="mass__close mass__close--prov">&times;</button>
                </div>
            </div>
        <?php endif; ?>
        <nav class="MyOrders_tabs">
            <div class="tab tab1">
                <a href="#1" class="tabsChange"></a>
                <p class="name">Запуск рекламы</p>
                <div class="string act1"></div>
            </div>
            <div class="tab tab2">
                <a href="#2" class="tabsChange"></a>
                <p class="name">Мои рекламные компании</p>
                <div class="string act2"></div>
            </div>
            <div class="tab tab3">
                <a href="#3" class="tabsChange"></a>
                <p class="name">Архив</p>
                <div class="string act3"></div>
            </div>
        </nav>

        <section class="OrderCardS OrderPage OrderPage-1">
            <div class="order__nav-box">
                <?= Html::beginForm('', 'GET', ['class' => 'finishedFilter']) ?>
                <div class="MyOrders_filter">
                    <button class="MyOrders_filter-reset" type="reset"></button>
                    <select class="MyOrders_filter-select" name="filter[sphere]" id="">
                        <option selected disabled>Сфера</option>
                        <?php foreach ($category as $v): ?>
                            <option class="sendFinished" value="<?= $v['category'] ?>"><?= $v['category'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input class="MyOrders_filter-check" type="checkbox" name="filter[new]" id="MyOrders_filter-check">
                    <label class="MyOrders_filter-check-l sendFinished <?= !empty($_GET['filter']['new']) ? 'activeCheck' : '' ?>"
                           for="MyOrders_filter-check">Новые</label>
                </div>
                <?= Html::endForm(); ?>
            </div>


            <div class="order__cards">
                <?php Pjax::begin(['id' => 'finishedContainer']) ?>
                <?php if (!empty($templates)): ?>
                    <?php foreach ($templates as $item): ?>
                        <div class="order__card card">
                            <div class="card__box">
                                <h2 class="card__title">
                                    <?= $item['name'] ?>
                                </h2>

                                <div class="card__price">
                                    от <?= $item['price'] ?> рублей/лид
                                </div>
                            </div>

                            <div class="card__box">
                                <div class="card__subtitle">
                                    <?= $item['category'] ?>
                                </div>

                                <div class="card__country">
                                    <?php if (!empty($item['regions'])): ?>
                                        <?php $regions = json_decode($item['regions'], 1); ?>
                                        <?php if ($regions !== null): ?>
                                            <?php if (in_array('Любой', $regions)): ?>
                                                Любой регион
                                            <?php else: ?>
                                                <?php foreach ($regions as $k => $r): ?><?php if ($k !== 0): ?>, <?php endif; ?><?= $r ?><?php endforeach; ?><?php endif; ?>
                                        <?php else: ?>
                                            Любой регион
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="card__box">
                                <a href="<?= Url::to(['order-lid', 'template' => $item['link']]) ?>" data-pjax="0"
                                   class="card__link link">Запустить рекламу</a>
                                <button data-id="<?= $item['id'] ?>" data-pjax="0" type="button"
                                        class="card__btn link link--color adLinkClient">Подробнее
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php if (!empty($pages)): ?>
                        <?php echo LinkPager::widget([
                            'pagination' => $pages,
                        ]); ?>
                    <?php endif; ?>
                <?php else: ?>
                    <div>Предложения не найдены</div>
                <?php endif; ?>
                <?php Pjax::end() ?>
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
                    <option class="sendActive" value="<?= Orders::STATUS_MODERATION ?>">Модерация</option>
                </select>
                <?php if (!empty($sphere)): ?>
                    <select class="MyOrders_filter-select" name="activeFilter[sphere]" id="">
                        <option selected disabled>Сфера</option>
                        <?php foreach ($sphere as $k => $v): ?>
                            <option class="sendActive" value="<?= $v['name'] ?>"><?= $v['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php endif; ?>
                <input class="MyOrders_filter-check" type="checkbox" name="activeFilter[new]"
                       id="MyOrders_filter-check">
                <label class="MyOrders_filter-check-l sendActive <?= !empty($_GET['activeFilter']['new']) ? 'activeCheck' : '' ?>"
                       for="MyOrders_filter-check">Новые</label>
            </div>
            <?= Html::endForm(); ?>
            <div class="pjaxss">
                <?php Pjax::begin(['id' => 'activeContainer']) ?>
                <?php if (!empty($activeOrders)): ?>
                    <?php foreach ($activeOrders as $k => $v): ?>
                        <?php if ($v['status'] === 'остановлен'): ?>
                            <div class="OrderCard">
                                <div class="top">
                                    <div class="Lcol">
                                        <div class="L">
                                            <h2 class="OrderNum"><?= !empty($v['order_name']) ? $v['order_name'] : "#{$v['id']} {$v['category_text']}" ?></h2>
                                            <!--                                    <a href="-->
                                            <? //= Url::to(['#']) ?><!--">Статистика</a>-->
                                        </div>
                                        <div class="R">
                                            <div class="topb">
                                                <p>Выполнено:<span
                                                            class="OrderCard-done-percentage"><?= round(($v['leads_get'] * 100) / $v['leads_count'], 2) ?>%</span>
                                                </p>
                                            </div>
                                            <div class="bott">
                                                <div style="width: <?= round(($v['leads_get'] * 100) / $v['leads_count'], 2) ?>px;"
                                                     class="bottfill"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Rcol">
                                        <div class="R">
                                            <div class="order-status <?= $v['status'] === 'остановлен' ? 'Stopped' : '' ?>">
                                                <div class="order__help-status">Этот заказ остановлен администратором!
                                                </div>
                                                <p><?= mb_convert_case($v['status'], MB_CASE_TITLE) ?></p>
                                            </div>
                                            <p class="date">от <?= date('d.m.Y', strtotime($v['date'])) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php $regions = json_decode($v['regions']); ?>
                                <div class="OrderCard_main">
                                    <div class="OrderCard_main_L">
                                        <p class="OrderCard_main_L-t1">стоимость</p>
                                        <p class="OrderCard_main_L-t2"><?= $v['price'] ?> ₽/ лид</p>
                                        <p class="OrderCard_main_L-t1">регион</p>
                                        <p class="OrderCard_main_L-t2"><?php foreach ($regions as $key => $item): ?>
                                                <?= $item ?>;
                                            <?php endforeach; ?></p>
                                        <p class="OrderCard_main_L-t1">сфера</p>
                                        <p class="OrderCard_main_L-t2"><?= $v['category_text'] ?></p>
                                    </div>
                                    <div class="OrderCard_main_R">
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Куплено</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_count'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">отгружено</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_get'] ?>
                                                /<?= $v['leads_count'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">отбраковано</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_waste'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Возможность отбраковки</p>
                                            <p class="OrderCard_main_R-row-t2">до <?= $v['waste'] + $bonus_waste ?>%</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="OrderCard_bottom">
                                    <a class="OrderCard_bottom-L" data-pjax="0"
                                       href="<?= Url::to(['orderpage', 'link' => $v['id']]) ?>">Посмотреть
                                        детали</a>
                                    <a class="OrderCard_bottom-R" data-pjax="0"
                                       href="<?= Url::to(['integration', 'order_id' => $v['id']]) ?>">
                                        <img src="<?= Url::to(['/img/settings.svg']) ?>" alt="Шестеренка">
                                    </a>
                                </div>
                            </div>
                        <?php elseif ($v['status'] === 'исполняется'): ?>
                            <div class="OrderCard">
                                <div class="top">
                                    <div class="Lcol">
                                        <div class="L">
                                            <h2 class="OrderNum"><?= !empty($v['order_name']) ? $v['order_name'] : "#{$v['id']} {$v['category_text']}" ?></h2>
                                            <!--                                    <a href="-->
                                            <? //= Url::to(['#']) ?><!--">Статистика</a>-->
                                        </div>
                                        <div class="R">
                                            <div class="topb">
                                                <p>Выполнено:<span
                                                            class="OrderCard-done-percentage"><?= round(($v['leads_get'] * 100) / $v['leads_count'], 2) ?>%</span>
                                                </p>
                                            </div>
                                            <div class="bott">
                                                <div style="width: <?= round(($v['leads_get'] * 100) / $v['leads_count'], 2) ?>px;"
                                                     class="bottfill"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Rcol">
                                        <div class="dropdown">
                                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Действия <b
                                                        class="caret"></b></a>
                                            <?php
                                            echo Dropdown::widget([
                                                'items' => [
                                                    ['label' => 'Поставить на паузу', 'options' => ['data-order' => $v['id'], 'data-hash' => md5("{$user->id}::{$v['id']}::order-hash")]],
                                                ],
                                            ]);
                                            ?>
                                        </div>
                                        <div class="R">
                                            <div class="order-status <?= $v['status'] === 'исполняется' ? 'Progress' : '' ?>">
                                                <div class="order__help-status">Этот заказ исполняется в данный момент
                                                </div>
                                                <p><?= mb_convert_case($v['status'], MB_CASE_TITLE) ?></p>
                                            </div>
                                            <p class="date">от <?= date('d.m.Y', strtotime($v['date'])) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php $regions = json_decode($v['regions']); ?>
                                <div class="OrderCard_main">
                                    <div class="OrderCard_main_L">
                                        <p class="OrderCard_main_L-t1">стоимость</p>
                                        <p class="OrderCard_main_L-t2"><?= $v['price'] ?> ₽/ лид</p>
                                        <p class="OrderCard_main_L-t1">регион</p>
                                        <p class="OrderCard_main_L-t2"><?php foreach ($regions as $key => $item): ?>
                                                <?= $item ?>;
                                            <?php endforeach; ?></p>
                                        <p class="OrderCard_main_L-t1">сфера</p>
                                        <p class="OrderCard_main_L-t2"><?= $v['category_text'] ?></p>
                                    </div>
                                    <div class="OrderCard_main_R">
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Куплено</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_count'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">отгружено</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_get'] ?>
                                                /<?= $v['leads_count'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">отбраковано</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_waste'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Возможность отбраковки</p>
                                            <p class="OrderCard_main_R-row-t2">до <?= $v['waste'] + $bonus_waste ?>%</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="OrderCard_bottom">
                                    <a class="OrderCard_bottom-L" data-pjax="0"
                                       href="<?= Url::to(['orderpage', 'link' => $v['id']]) ?>">Посмотреть
                                        детали</a>
                                    <a class="OrderCard_bottom-R" data-pjax="0"
                                       href="<?= Url::to(['integration', 'order_id' => $v['id']]) ?>">
                                        <img src="<?= Url::to(['/img/settings.svg']) ?>" alt="Шестеренка">
                                    </a>
                                </div>
                            </div>
                        <?php elseif ($v['status'] === 'пауза'): ?>
                            <div class="OrderCard">
                                <div class="top">
                                    <div class="Lcol">
                                        <div class="L">
                                            <h2 class="OrderNum"><?= !empty($v['order_name']) ? $v['order_name'] : "#{$v['id']} {$v['category_text']}" ?></h2>
                                            <!--                                    <a href="-->
                                            <? //= Url::to(['#']) ?><!--">Статистика</a>-->
                                        </div>
                                        <div class="R">
                                            <div class="topb">
                                                <p>Выполнено:<span
                                                            class="OrderCard-done-percentage"><?= round(($v['leads_get'] * 100) / $v['leads_count'], 2) ?>%</span>
                                                </p>
                                            </div>
                                            <div class="bott">
                                                <div style="width: <?= round(($v['leads_get'] * 100) / $v['leads_count'], 2) ?>px;"
                                                     class="bottfill"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Rcol">
                                        <div class="dropdown">
                                            <a href="#" data-toggle="dropdown" class="dropdown-toggle">Действия <b
                                                        class="caret"></b></a>
                                            <?php
                                            echo Dropdown::widget([
                                                'items' => [
                                                    ['label' => 'Возобновить', 'options' => ['data-order' => $v['id'], 'data-hash' => md5("{$user->id}::{$v['id']}::order-hash")]],
                                                ],
                                            ]);
                                            ?>
                                        </div>
                                        <div class="R">
                                            <div class="order-status <?= $v['status'] === 'пауза' ? 'Pause' : '' ?>">
                                                <div class="order__help-status"></div>
                                                <p><?= mb_convert_case($v['status'], MB_CASE_TITLE) ?></p>
                                            </div>
                                            <p class="date">от <?= date('d.m.Y', strtotime($v['date'])) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php $regions = json_decode($v['regions']); ?>
                                <div class="OrderCard_main">
                                    <div class="OrderCard_main_L">
                                        <p class="OrderCard_main_L-t1">стоимость</p>
                                        <p class="OrderCard_main_L-t2"><?= $v['price'] ?> ₽/ лид</p>
                                        <p class="OrderCard_main_L-t1">регион</p>
                                        <p class="OrderCard_main_L-t2"><?php foreach ($regions as $key => $item): ?>
                                                <?= $item ?>;
                                            <?php endforeach; ?></p>
                                        <p class="OrderCard_main_L-t1">сфера</p>
                                        <p class="OrderCard_main_L-t2"><?= $v['category_text'] ?></p>
                                    </div>
                                    <div class="OrderCard_main_R">
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Куплено</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_count'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">отгружено</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_get'] ?>
                                                /<?= $v['leads_count'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">отбраковано</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_waste'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Возможность отбраковки</p>
                                            <p class="OrderCard_main_R-row-t2">до <?= $v['waste'] + $bonus_waste ?>%</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="OrderCard_bottom">
                                    <a class="OrderCard_bottom-L" data-pjax="0"
                                       href="<?= Url::to(['orderpage', 'link' => $v['id']]) ?>">Посмотреть
                                        детали</a>
                                    <a class="OrderCard_bottom-R" data-pjax="0"
                                       href="<?= Url::to(['integration', 'order_id' => $v['id']]) ?>">
                                        <img src="<?= Url::to(['/img/settings.svg']) ?>" alt="Шестеренка">
                                    </a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="OrderCard">
                                <div class="top">
                                    <div class="Lcol">
                                        <div class="L">
                                            <h2 class="OrderNum"><?= !empty($v['order_name']) ? $v['order_name'] : "#{$v['id']} {$v['category_text']}" ?></h2>
                                            <!--                                    <a href="-->
                                            <? //= Url::to(['#']) ?><!--">Статистика</a>-->
                                        </div>
                                        <div class="R">
                                            <div class="topb">
                                                <p>Выполнено:<span
                                                            class="OrderCard-done-percentage"><?= round(($v['leads_get'] * 100) / $v['leads_count'], 2) ?>%</span>
                                                </p>
                                            </div>
                                            <div class="bott">
                                                <div style="width: <?= round(($v['leads_get'] * 100) / $v['leads_count'], 2) ?>px;"
                                                     class="bottfill"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="Rcol">
                                        <div class="R">
                                            <div class="order-status <?= $v['status'] === 'модерация' ? 'Moderation' : '' ?>">
                                                <div class="order__help-status">Этот заказ остановлен администратором!
                                                </div>
                                                <p><?= mb_convert_case($v['status'], MB_CASE_TITLE) ?></p>
                                            </div>
                                            <p class="date">от <?= date('d.m.Y', strtotime($v['date'])) ?></p>
                                        </div>
                                    </div>
                                </div>
                                <?php $regions = json_decode($v['regions']); ?>
                                <div class="OrderCard_main">
                                    <div class="OrderCard_main_L">
                                        <p class="OrderCard_main_L-t1">стоимость</p>
                                        <p class="OrderCard_main_L-t2"><?= $v['price'] ?> ₽/ лид</p>
                                        <p class="OrderCard_main_L-t1">регион</p>
                                        <p class="OrderCard_main_L-t2"><?php foreach ($regions as $key => $item): ?>
                                                <?= $item ?>;
                                            <?php endforeach; ?></p>
                                        <p class="OrderCard_main_L-t1">сфера</p>
                                        <p class="OrderCard_main_L-t2"><?= $v['category_text'] ?></p>
                                    </div>
                                    <div class="OrderCard_main_R">
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Куплено</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_count'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">отгружено</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_get'] ?>
                                                /<?= $v['leads_count'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">отбраковано</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_waste'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Возможность отбраковки</p>
                                            <p class="OrderCard_main_R-row-t2">до <?= $v['waste'] + $bonus_waste ?>%</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="OrderCard_bottom">
                                    <a style="margin-left: auto;" class="OrderCard_bottom-R" data-pjax="0"
                                       href="<?= Url::to(['integration', 'order_id' => $v['id']]) ?>">
                                        <img src="<?= Url::to(['/img/settings.svg']) ?>" alt="Шестеренка">
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <section class="rightInfo rightInfo_no-orders">
                        <div class="title_row">
                            <p class="Bal-ttl title-main">Активные заказы</p>
                        </div>
                        <section class="rightInfo_no-orders_info">
                            <img class="rightInfo_no-orders_info-back"
                                 src="<?= Url::to(['/img/rightInfo_no-orders-back.svg']) ?>" alt="иконка">
                            <h2 class="rightInfo_no-orders_info_title">
                                Нет заказов
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
                        <option class="sendFinished" value="<?= $v['name'] ?>"><?= $v['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input class="MyOrders_filter-check" type="checkbox" name="finishedFilter[new]"
                       id="MyOrders_filter-check2">
                <label class="MyOrders_filter-check-l sendFinished <?= !empty($_GET['finishedFilter']['new']) ? 'activeCheck' : '' ?>"
                       for="MyOrders_filter-check2">Новые</label>
            </div>
            <?= Html::endForm(); ?>
            <?php Pjax::begin(['id' => 'finishedContainer']) ?>
            <?php if (!empty($finishedOrders)): ?>
                <?php foreach ($finishedOrders as $k => $v): ?>
                    <div class="OrderCard">
                        <div class="top">
                            <div class="Lcol">
                                <div class="L">
                                    <h2 class="OrderNum"><?= !empty($v['order_name']) ? $v['order_name'] : "#{$v['id']} {$v['category_text']}" ?></h2>
                                    <!--                                <a href="-->
                                    <? //= Url::to(['#']) ?><!--">Статистика</a>-->
                                </div>
                                <div class="R">
                                    <div class="topb">
                                        <p>Выполнено:<span
                                                    class="OrderCard-done-percentage"><?= round(($v['leads_get'] * 100) / $v['leads_count'], 2) ?>%</span>
                                        </p>
                                    </div>
                                    <div class="bott">
                                        <div style="width: <?= round(($v['leads_get'] * 100) / $v['leads_count'], 2) ?>px"
                                             class="bottfill"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="Rcol">
                                <div class="R">
                                    <div class="order-status <?= $v['status'] == 'выполнен' ? 'Performed' : '' ?>">
                                        <p><?= mb_convert_case($v['status'], MB_CASE_TITLE) ?></p>
                                    </div>

                                    <!--Индикаторы статуса-->
                                    <!-- <div class="order-status Performed">
                                                                    <p>Выполнен</p>
                                                                </div> -->
                                    <!-- <div class="order-status Moderation">
                                                                    <p>Модерация</p>
                                                                </div> -->
                                    <!-- <div class="order-status Pause">
                                                                    <p>Пауза</p>
                                                                </div> -->
                                    <!-- <div class="order-status Stopped">
                                                                    <p>Остановлен</p>
                                                                </div> -->
                                    <p class="date">от <?= date('d.m.Y', strtotime($v['date'])) ?></p>
                                </div>
                            </div>
                        </div>
                        <?php $regions = json_decode($v['regions']); ?>
                        <div class="OrderCard_main">
                            <div class="OrderCard_main_L">
                                <p class="OrderCard_main_L-t1">стоимость</p>
                                <p class="OrderCard_main_L-t2"><?= $v['price'] ?> ₽/ лид</p>
                                <p class="OrderCard_main_L-t1">регион</p>
                                <p class="OrderCard_main_L-t2"><?php foreach ($regions as $key => $item): ?>
                                        <?= $item ?>;
                                    <?php endforeach; ?></p>
                                <p class="OrderCard_main_L-t1">сфера</p>
                                <p class="OrderCard_main_L-t2"><?= $v['category_text'] ?></p>
                            </div>
                            <div class="OrderCard_main_R">
                                <div class="OrderCard_main_R-row">
                                    <p class="OrderCard_main_R-row-t1">Куплено</p>
                                    <p class="OrderCard_main_R-row-t2"><?= $v['leads_count'] ?></p>
                                </div>
                                <div class="OrderCard_main_R-row">
                                    <p class="OrderCard_main_R-row-t1">отгружено</p>
                                    <p class="OrderCard_main_R-row-t2"><?= $v['leads_get'] ?>
                                        /<?= $v['leads_count'] ?></p>
                                </div>
                                <div class="OrderCard_main_R-row">
                                    <p class="OrderCard_main_R-row-t1">отбраковано</p>
                                    <p class="OrderCard_main_R-row-t2"><?= $v['leads_waste'] ?></p>
                                </div>
                                <div class="OrderCard_main_R-row">
                                    <p class="OrderCard_main_R-row-t1">Возможность отбраковки</p>
                                    <p class="OrderCard_main_R-row-t2">до <?= $v['waste'] + $bonus_waste ?>%</p>
                                </div>
                            </div>
                        </div>
                        <div class="OrderCard_bottom">
                            <a class="OrderCard_bottom-L" data-pjax="0"
                               href="<?= Url::to(['orderpage', 'link' => $v['id']]) ?>">Посмотреть детали</a>
                            <a class="OrderCard_bottom-R" data-pjax="0"
                               href="<?= Url::to(['integration', 'order_id' => $v['id']]) ?>">
                                <img src="<?= Url::to(['/img/settings.svg']) ?>" alt="Шестеренка">
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <section class="rightInfo rightInfo_no-orders">
                    <div class="title_row">
                        <p class="Bal-ttl title-main">Выполненные заказы</p>
                    </div>
                    <section class="rightInfo_no-orders_info">
                        <img class="rightInfo_no-orders_info-back"
                             src="<?= Url::to(['/img/rightInfo_no-orders-back.svg']) ?>" alt="иконка">
                        <h2 class="rightInfo_no-orders_info_title">
                            Нет выполненных заказов
                        </h2>
                        <a href="<?= Url::to(['myorders']) ?>" class="Hcont_R_R-AddZ-Block uscp df jcsb aic">
                            <img src="<?= Url::to(['/img/plass.svg']) ?>" alt="Плюс">
                            <p class="BText Hcont_R_R-AddZ-BTN-t">Назад</p>
                        </a>
                    </section>
                </section>
            <?php endif; ?>
            <?php Pjax::end() ?>
        </section>
        <?php endif; ?>
        <?php else: ?>
        <section class="rightInfo rightInfo_no-orders">

            <div class="bcr">
                <ul class="bcr__list">
                    <li class="bcr__item">
            <span class="bcr__link">
              Мои заказы
            </span>
                    </li>

                    <li class="bcr__item">
            <span class="bcr__span">
              Заполните профиль
            </span>
                    </li>
                </ul>
            </div>
            <div class="title_row">
                <p class="Bal-ttl title-main">Мои заказы</p>
            </div>
            <section class="rightInfo_no-orders_info">
                <img class="rightInfo_no-orders_info-back"
                     src="<?= Url::to(['/img/rightInfo_no-orders-back.svg']) ?>" alt="иконка">
                <h2 class="rightInfo_no-orders_info_title">
                    У вас еще не заполнен профиль
                </h2>
                <p class="rightInfo_no-orders_info-text">
                    Вы можете заполнить его прямо сейчас
                </p>
                <!--Ссылка на страницу "Добавить заказ"-->
                <a href="<?= Url::to(['profile']) ?>" class="Hcont_R_R-AddZ-Block uscp df jcsb aic">
                    <img src="<?= Url::to(['/img/plass.svg']) ?>" alt="Плюс">
                    <p class="BText Hcont_R_R-AddZ-BTN-t">Заполнить профиль</p>
                </a>
            </section>


            <?php endif; ?>

            <div class="popup popup--err">
                <div class="popup__ov">
                    <div class="popup__body popup__body--err">
                        <div class="popup__content popup__content--err">
                            <p class="popup__title">Ошибка!</p>
                            <p class="popup__text1">
                                Пароль должен содержать не менее 8-ти символов
                            </p>
                            <button class="popup__btn popup__btn--err btn">Закрыть</button>
                        </div>
                        <div class="popup__close">
                            <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                        </div>
                    </div>
                </div>
            </div>
            <div class="backPopUp">
                <div class="popup__body">

                </div>
            </div>
        </section>
