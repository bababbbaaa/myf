<?php

use common\models\UsersNotice;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\Orders;

$this->title = 'Статистика';

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
    
    $('.OrderPage_StatisticsFilter-Select').on('click', '.sendIdOrder', function(e) {
        var id = $('#orderId').val();
      $.pjax.reload({
            url: 'statis',
            container: '#statistickReload',
            type: 'GET',
            data: {orderId: id},
      })
    });
    
    $('.generalStatistickReload').on('click', function() {
        location.href = 'statis';
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
CSS;

$this->registerJsFile(Url::to(['/js/chart.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerCss($css);
$this->registerCssFile(Url::to(['/css/jquery.timepicker.css']));
$this->registerJsFile(Url::to(['/js/jquery.timepicker.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);

?>

<?php if (!empty($client)): ?>
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
              Добавить заказ
            </span>
            </li>
        </ul>
    </div>
    <div class="title_row">
        <h1 class="Bal-ttl title-main">Мои заказы</h1>
    </div>

    <section style="display: block" class="OrderPage OrderPage-3">
        <div class="OrderCard StatisticsCard">
            <h2 class="StatisticsCard_title">
                Статистика
            </h2>
            <p class="StatisticsCard_undertitle">
                Выберите в каком виде вам показать статистику
            </p>
            <?= Html::beginForm('', 'get', ['class' => 'OrderPage_StatisticsFilter']) ?>
            <div class="OrderPage_StatisticsFilter_top">
                <label class="OrderPage_StatisticsFilter_top-label">
                    <input checked class="OrderPage_StatisticsFilter_top-input generalStatistickReload" type="radio"
                           name="type"
                           value="Общая" id="radio1">
                    Общая
                </label>
                <label class="OrderPage_StatisticsFilter_top-label">
                    <input class="OrderPage_StatisticsFilter_top-input" type="radio" name="type" value="По заказу"
                           id="radio2">
                    По заказу
                </label>
            </div>
            <?php if (!empty($countOrdersId)): ?>
                <div class="OrderPage_StatisticsFilter_bottom">
                    <p class="OrderPage_StatisticsFilter_bottom-name">
                        Выберите заказ
                    </p>
                    <select class="OrderPage_StatisticsFilter-Select" name="orderId" id="orderId">
                        <?php foreach ($countOrdersId as $k => $v): ?>
                            <option class="sendIdOrder" <?= $_GET['orderId'] == $v['id'] ? 'selected' : '' ?>
                                    value="<?= $v['id'] ?>"><?= !empty($v['order_name']) ? $v['order_name'] : "Заказ № {$v['id']} {$v['category_text']}" ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            <?php endif; ?>
            <?= Html::endForm(); ?>
            <?php Pjax::begin(['id' => 'statistickReload']) ?>
            <?php if (!empty($countByDay)) {
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
            } ?>
            <div class="Statistics" style="width: 100%">
                <canvas id="myChart" width="auto" height="200"></canvas>
            </div>
            <?php Pjax::end() ?>
        </div>
    </section>
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


</section>