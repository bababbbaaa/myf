<?php

use common\models\UsersNotice;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\Orders;


$this->title = "Мои офферы";

$bonus_waste = 0;
if (!empty($bonuses) && !empty($bonuses->additional_waste)){
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
              url: "myorders",
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
              url: "myorders",
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
    
    /* Фильтр архива */
    $('.finishedFilter').on('submit', function(e) {
        e.preventDefault();
          $.pjax.reload({
              container: '#finishedContainer',
              url: "myorders",
              type: "GET",
              data: $('.finishedFilter').serialize(),
           });
    });
    $('.sendFinished').on('click', function() {
        setTimeout(function() {
            $('.finishedFilter').submit();
        },300);
    });
    /* Фильтр архива */
    
    var hash = location.hash.substring(1);
    $('.MyOrders_filter-reset').on('click', function() {
        location.href = '/lead-force/provider/myorders#'+ hash;
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
        $.pjax.reload({container: '#noticeContainer',});
    });
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

CSS;

$this->registerJsFile(Url::to(['/js/chart.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerCss($css);
$this->registerCssFile(Url::to(['/css/jquery.timepicker.css']));
$this->registerJsFile(Url::to(['/js/jquery.timepicker.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);
if (!empty($countByDay)) {
    $counts = [];
    foreach ($dates as $item) {
        if (!empty($countByDay[$item]))
            $counts[] = (int)$countByDay[$item];
        else
            $counts[] = 0;
    }
    $counts = json_encode($counts);
    $dates = json_encode($dates);
    $js2 = <<<JS
var ctx = document.getElementById('myChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: $dates,
        datasets: [{
            label: 'Лиды по дням',
            data: $counts,
            borderColor: [
                '#2ccd65',
            ],
            backgroundColor: [
                '#2ccd65',
            ],
            cubicInterpolationMode: 'monotone',
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                max: Math.max.apply(null, $counts) + 1
            }
        }
    }
});
JS;
    $this->registerJs($js2);
}
?>
<?php if (!empty($client)): ?>
<?php if ($countOrders === 0): ?>
<section class="rightInfo rightInfo_no-orders">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__link">Мои офферы</span>
            </li>

            <li class="bcr__item">
                <span class="bcr__span">Добавить оффер</span>
            </li>
        </ul>
    </div>
    <div class="title_row">
        <p class="Bal-ttl title-main">Мои офферы</p>
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
                <button style="color: #a3ccf4;" data-id="<?= $dialog->id ?>" type="button" class="mass__close mass__close--prov">&times;</button>
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
              Мои офферы
            </span>
                </li>

                <li class="bcr__item">
            <span class="bcr__span">
              Добавить оффер
            </span>
                </li>
            </ul>
        </div>
        <div class="title_row">
            <h1 class="Bal-ttl title-main">Мои офферы</h1>
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
                    <p class="mass__title">Ваш оффер находится на модерации</p>
                    <?php $prop = json_decode($dialog->properties, true) ?>
                    <p class="mass__text">Категория "<?= $prop['Orders']['category_text'] ?>" по вашему заказу проверяется модератором. Ожидайте
                        <a href="<?= Url::to(['support']) ?>">ответа</a> от тех. поддержки</p>
                    <button style="color: #a3ccf4;" type="button" class="mass__close mass__close--prov">&times;</button>
                </div>
            </div>
        <?php endif; ?>
        <nav class="MyOrders_tabs">
            <div class="tab tab1">
                <a href="#1" class="tabsChange"></a>
                <p class="name">В работе</p>
                <div class="string act1"></div>
            </div>
            <div class="tab tab2">
                <a href="#2" class="tabsChange"></a>
                <p class="name">На модерации</p>
                <div class="string act2"></div>
            </div>
            <div class="tab tab3">
                <a href="#3" class="tabsChange"></a>
                <p class="name">Завершенные</p>
                <div class="string act3"></div>
            </div>
<!--            <div class="tab tab4">-->
<!--                <a href="#4" class="tabsChange"></a>-->
<!--                <p class="name">Все</p>-->
<!--                <div class="string act4"></div>-->
<!--            </div>-->
        </nav>

        <section class="OrderCardS OrderPage OrderPage-1">
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
                <?php Pjax::begin(['id' => 'activeContainer']) ?>
                <?php if (!empty($activeOrders)): ?>
                    <?php foreach ($activeOrders as $k => $v): ?>
                        <?php if ($v['status'] === 'остановлен'): ?>
                            <div class="OrderCard">
                                <div class="top">
                                    <div class="Lcol">
                                        <div class="L">
                                            <h2 class="OrderNum"><?= $v['name'] ?></h2>
                                            <!--                                    <a href="-->
                                            <? //= Url::to(['#']) ?><!--">Статистика</a>-->
                                        </div>
                                        <?php if ($v['leads_need'] > 0): ?>
                                            <div class="R">
                                                <div class="topb">
                                                    <p>Выполнено:<span
                                                                class="OrderCard-done-percentage"><?= round(($v['leads_confirmed'] * 100) / $v['leads_need'], 2) ?>%</span>
                                                    </p>
                                                </div>
                                                <div class="bott">
                                                    <div style="width: <?= round(($v['leads_confirmed'] * 100) / $v['leads_need'], 2) ?>%;" class="bottfill"></div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="Rcol">
                                        <div class="R">
                                            <div class="order-status <?= $v['status'] === 'остановлен' ? 'Stopped' : '' ?>">
                                                <div class="order__help-status">Этот оффер остановлен администратором!</div>
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
                                            <p class="OrderCard_main_R-row-t1">Требуемый объем</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_need'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Поставлено партнерам</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_confirmed'] ?>
                                                /<?= $v['leads_need'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Непринятые лиды</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_waste'] ?></p>
                                        </div>
                                        <?php if ($v['leads_total'] > 0): ?>
                                            <div class="OrderCard_main_R-row">
                                                <p class="OrderCard_main_R-row-t1">Процент принятия лида</p>
                                                <p class="OrderCard_main_R-row-t2">от <?= round($v['leads_confirmed'] * 100 / $v['leads_total']) ?>%</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="OrderCard_bottom">
                                    <a class="OrderCard_bottom-L" data-pjax="0" href="<?= Url::to(['orderpage', 'link' => $v['id']]) ?>">Посмотреть
                                        детали</a>
                                </div>
                            </div>
                        <?php elseif ($v['status'] === 'исполняется'): ?>
                            <div class="OrderCard">
                                <div class="top">
                                    <div class="Lcol">
                                        <div class="L">
                                            <h2 class="OrderNum"><?= $v['name'] ?></h2>
                                            <!--                                    <a href="-->
                                            <? //= Url::to(['#']) ?><!--">Статистика</a>-->
                                        </div>
                                        <?php if ($v['leads_need'] > 0): ?>
                                            <div class="R">
                                                <div class="topb">
                                                    <p>Выполнено:<span
                                                                class="OrderCard-done-percentage"><?= round(($v['leads_confirmed'] * 100) / $v['leads_need'], 2) ?>%</span>
                                                    </p>
                                                </div>
                                                <div class="bott">
                                                    <div style="width: <?= round(($v['leads_confirmed'] * 100) / $v['leads_need'], 2) ?>%;" class="bottfill"></div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="Rcol">
                                        <div class="R">
                                            <div class="order-status <?= $v['status'] === 'исполняется' ? 'Progress' : '' ?>">
                                                <div class="order__help-status">Этот оффер исполняется в данный момент</div>
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
                                        <p class="OrderCard_main_L-t2"><?= $activeOrdersCategory['name'] ?></p>
                                    </div>
                                    <div class="OrderCard_main_R">
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Требуемый объем</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_need'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Поставлено партнерам</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_confirmed'] ?>
                                                /<?= $v['leads_need'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Непринятые лиды</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_waste'] ?></p>
                                        </div>
                                        <?php if ($v['leads_total'] > 0): ?>
                                            <div class="OrderCard_main_R-row">
                                                <p class="OrderCard_main_R-row-t1">Процент принятия лида</p>
                                                <p class="OrderCard_main_R-row-t2">от <?= round($v['leads_confirmed'] * 100 / $v['leads_total']) ?>%</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="OrderCard_bottom">
                                    <a class="OrderCard_bottom-L" data-pjax="0" href="<?= Url::to(['orderpage', 'link' => $v['id']]) ?>">Посмотреть
                                        детали</a>
                                </div>
                            </div>
                        <?php elseif ($v['status'] === 'пауза'): ?>
                            <div class="OrderCard">
                                <div class="top">
                                    <div class="Lcol">
                                        <div class="L">
                                            <h2 class="OrderNum"><?= $v['name'] ?></h2>
                                            <!--                                    <a href="-->
                                            <? //= Url::to(['#']) ?><!--">Статистика</a>-->
                                        </div>
                                        <?php if ($v['leads_need'] > 0): ?>
                                            <div class="R">
                                                <div class="topb">
                                                    <p>Выполнено:<span
                                                                class="OrderCard-done-percentage"><?= round(($v['leads_confirmed'] * 100) / $v['leads_need'], 2) ?>%</span>
                                                    </p>
                                                </div>
                                                <div class="bott">
                                                    <div style="width: <?= round(($v['leads_confirmed'] * 100) / $v['leads_need'], 2) ?>%;" class="bottfill"></div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="Rcol">
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
                                            <p class="OrderCard_main_R-row-t1">Требуемый объем</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_need'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Поставлено партнерам</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_confirmed'] ?>
                                                /<?= $v['leads_need'] ?></p>
                                        </div>
                                        <div class="OrderCard_main_R-row">
                                            <p class="OrderCard_main_R-row-t1">Непринятые лиды</p>
                                            <p class="OrderCard_main_R-row-t2"><?= $v['leads_waste'] ?></p>
                                        </div>
                                        <?php if ($v['leads_total'] > 0): ?>
                                            <div class="OrderCard_main_R-row">
                                                <p class="OrderCard_main_R-row-t1">Процент принятия лида</p>
                                                <p class="OrderCard_main_R-row-t2">от <?= round($v['leads_confirmed'] * 100 / $v['leads_total']) ?>%</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="OrderCard_bottom">
                                    <a class="OrderCard_bottom-L" data-pjax="0" href="<?= Url::to(['orderpage', 'link' => $v['id']]) ?>">Посмотреть
                                        детали</a>
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

        <section class="OrderCardS OrderPage OrderPage-2">
            <?= Html::beginForm('', 'get', ['class' => 'moderationFilter']) ?>
            <div class="MyOrders_filter">
                <button class="MyOrders_filter-reset" type="reset"></button>
                <select class="MyOrders_filter-select" name="moderationFilter[sphere]" id="">
                    <option selected disabled>Сфера</option>
                    <?php foreach ($sphere as $k => $v): ?>
                        <option class="sendModeration" value="<?= $v['link_name'] ?>"><?= $v['name'] ?></option>
                    <?php endforeach; ?>
                </select>
                <input class="MyOrders_filter-check" type="checkbox" name="moderationFilter[new]"
                       id="MyOrders_filter-check1">
                <label class="MyOrders_filter-check-l sendModeration <?= !empty($_GET['moderationFilter']['new']) ? 'activeCheck' : '' ?>" for="MyOrders_filter-check1">Новые</label>
            </div>
            <?= Html::endForm(); ?>
            <?php Pjax::begin(['id' => 'moderationContainer']) ?>
            <?php if (!empty($moderationOrders)): ?>
                <?php foreach ($moderationOrders as $k => $v): ?>
                    <div class="OrderCard">
                        <div class="top">
                            <div class="Lcol">
                                <div class="L">
                                    <h2 class="OrderNum"><?= $v['name'] ?></h2>
                                    <!--                            <a href="-->
                                    <? //= Url::to(['#']) ?><!--">Статистика</a>-->
                                </div>
                            </div>
                            <div class="Rcol">
                                <div class="R">
                                    <div class="order-status <?= $v['status'] == 'модерация' ? 'Moderation' : '' ?>">
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
                                    <p class="OrderCard_main_R-row-t1">Требуемый объем</p>
                                    <p class="OrderCard_main_R-row-t2"><?= $v['leads_need'] ?></p>
                                </div>
                                <div class="OrderCard_main_R-row">
                                    <p class="OrderCard_main_R-row-t1">Поставлено партнерам</p>
                                    <p class="OrderCard_main_R-row-t2"><?= $v['leads_confirmed'] ?>
                                        /<?= $v['leads_need'] ?></p>
                                </div>
                                <div class="OrderCard_main_R-row">
                                    <p class="OrderCard_main_R-row-t1">Непринятые лиды</p>
                                    <p class="OrderCard_main_R-row-t2"><?= $v['leads_waste'] ?></p>
                                </div>
                                <?php if ($v['leads_total'] > 0): ?>
                                    <div class="OrderCard_main_R-row">
                                        <p class="OrderCard_main_R-row-t1">Процент принятия лида</p>
                                        <p class="OrderCard_main_R-row-t2">от <?= round($v['leads_confirmed'] * 100 / $v['leads_total']) ?>%</p>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="OrderCard_bottom">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <section class="rightInfo rightInfo_no-orders">
                    <div class="title_row">
                        <p class="Bal-ttl title-main">Офферы на модерации</p>
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
            <?php Pjax::end() ?>
        </section>

<!--        <section class="OrderPage OrderPage-3">-->
<!--            <div class="OrderCard StatisticsCard">-->
<!--                <h2 class="StatisticsCard_title">-->
<!--                    Статистика-->
<!--                </h2>-->
<!--                <p class="StatisticsCard_undertitle">-->
<!--                    Выберите в каком виде вам показать статистику-->
<!--                </p>-->
<!--                --><?//= Html::beginForm('', 'get', ['class' => 'OrderPage_StatisticsFilter']) ?>
<!---->
<!--                <div class="OrderPage_StatisticsFilter_top">-->
<!--                    <label class="OrderPage_StatisticsFilter_top-label">-->
<!--                        <input checked class="OrderPage_StatisticsFilter_top-input" type="radio" name="type"-->
<!--                               value="Общая" id="radio1">-->
<!--                        Общая-->
<!--                    </label>-->
<!--                    <label class="OrderPage_StatisticsFilter_top-label">-->
<!--                        <input class="OrderPage_StatisticsFilter_top-input" type="radio" name="type" value="По заказу"-->
<!--                               id="radio2">-->
<!--                        По заказу-->
<!--                    </label>-->
<!--                </div>-->
<!--                <div class="OrderPage_StatisticsFilter_bottom">-->
<!--                    <p class="OrderPage_StatisticsFilter_bottom-name">-->
<!--                        Выберите заказ-->
<!--                    </p>-->
<!--                    <select class="OrderPage_StatisticsFilter-Select" name="order" id="">-->
<!--                        <option value="заказ1">заказ1</option>-->
<!--                        <option value="заказ2">заказ2</option>-->
<!--                    </select>-->
<!--                </div>-->
<!--                --><?//= Html::endForm(); ?>
<!--                <div class="Statistics" style="width: 100%">-->
<!--                    <canvas id="myChart" width="auto" height="200"></canvas>-->
<!--                </div>-->
<!--            </div>-->
<!--        </section>-->

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
                <input class="MyOrders_filter-check" type="checkbox" name="finishedFilter[new]" id="MyOrders_filter-check2">
                <label class="MyOrders_filter-check-l sendFinished <?= !empty($_GET['finishedFilter']['new']) ? 'activeCheck' : '' ?>" for="MyOrders_filter-check2">Новые</label>
            </div>
            <?= Html::endForm(); ?>
            <?php Pjax::begin(['id' => 'finishedContainer']) ?>
            <?php if (!empty($finishedOrders)): ?>
                <?php foreach ($finishedOrders as $k => $v): ?>
                    <div class="OrderCard">
                        <div class="top">
                            <div class="Lcol">
                                <div class="L">
                                    <h2 class="OrderNum"><?= $v['name'] ?></h2>
                                    <!--                                <a href="-->
                                    <? //= Url::to(['#']) ?><!--">Статистика</a>-->
                                </div>
                                <?php if ($v['leads_need'] > 0): ?>
                                    <div class="R">
                                        <div class="topb">
                                            <p>Выполнено:<span
                                                        class="OrderCard-done-percentage"><?= round(($v['leads_confirmed'] * 100) / $v['leads_need'], 2) ?>%</span>
                                            </p>
                                        </div>
                                        <div class="bott">
                                            <div style="width: <?= round(($v['leads_confirmed'] * 100) / $v['leads_need'], 2) ?>%"
                                                 class="bottfill"></div>
                                        </div>
                                    </div>
                                <?php endif; ?>
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
                                    <p class="OrderCard_main_R-row-t1">Требуемый объем</p>
                                    <p class="OrderCard_main_R-row-t2"><?= $v['leads_need'] ?></p>
                                </div>
                                <div class="OrderCard_main_R-row">
                                    <p class="OrderCard_main_R-row-t1">Поставлено партнерам</p>
                                    <p class="OrderCard_main_R-row-t2"><?= $v['leads_confirmed'] ?>
                                        /<?= $v['leads_need'] ?></p>
                                </div>
                                <div class="OrderCard_main_R-row">
                                    <p class="OrderCard_main_R-row-t1">Непринятые лиды</p>
                                    <p class="OrderCard_main_R-row-t2"><?= $v['leads_waste'] ?></p>
                                </div>
                                <?php if ($v['leads_total'] > 0): ?>
                                    <div class="OrderCard_main_R-row">
                                        <p class="OrderCard_main_R-row-t1">Процент принятия лида</p>
                                        <p class="OrderCard_main_R-row-t2">от <?= round($v['leads_confirmed'] * 100 / $v['leads_total']) ?>%</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="OrderCard_bottom">
                            <a class="OrderCard_bottom-L" data-pjax="0" href="<?= Url::to(['orderpage', 'link' => $v['id']]) ?>">Посмотреть детали</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <section class="rightInfo rightInfo_no-orders">
                    <div class="title_row">
                        <p class="Bal-ttl title-main">Выполненные офферы</p>
                    </div>
                    <section class="rightInfo_no-orders_info">
                        <img class="rightInfo_no-orders_info-back"
                             src="<?= Url::to(['/img/rightInfo_no-orders-back.svg']) ?>" alt="иконка">
                        <h2 class="rightInfo_no-orders_info_title">
                            Нет выполненных офферов
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
              Мои офферы
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
                    <p class="Bal-ttl title-main">Мои офферы</p>
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
                    <a href="<?= Url::to(['prof#item1']) ?>" class="Hcont_R_R-AddZ-Block uscp df jcsb aic">
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


</section>