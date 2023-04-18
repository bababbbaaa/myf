<?php

use user\modules\lead_force\controllers\ProviderController;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = "Офферы";
$regions = [];
foreach ($region as $k => $i){
    $item = json_decode($i['regions'], true);
    foreach ($item as $v){
        $regions[] = $v;
    }
}
$regions = array_unique($regions);

$js =<<< JS
    $('.MyOrders_filter-check-l').on('click', function() {
      $(this).toggleClass('activeCheck');
    });
    
    
    $('.finishedFilter').on('submit', function(e) {
        e.preventDefault();
          $.pjax.reload({
              container: '#finishedContainer',
              url: "order",
              type: "GET",
              data: $('.finishedFilter').serialize(),
           });
    });
    $('.sendFinished').on('click', function() {
        setTimeout(function() {
            $('.finishedFilter').submit();
        },300);
    });
    
    $('.MyOrders_filter-reset').on('click', function() {
        location.href = "order";
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
    $('.backPopUp, .popup__close').on('click', function(e) {
      if (e.target == this) $('.backPopUp').fadeOut(300);
    });
JS;
$this->registerJs($js);

$css =<<< CSS
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
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0, .4);
            display: none;
            z-index: 1000;
        }
        .popup__body {
            position: absolute;
            left: 50%;
            top: 50%;
            max-width: 600px;
            width: 100%;
            transform: translate(-50%, -50%);
            padding: 50px;
            background: #ffffff;
            border-radius: 4px;
        }

CSS;
$this->registerCss($css);
?>

<section class="rightInfo">
    <?php if (empty($clients) || !ProviderController::fullInfo($clients)): ?>
    <section class="rightInfo_no-orders">
        <div class="bcr">
            <ul class="bcr__list">
                <li class="bcr__item">
            <span class="bcr__link">
                        Добавить оффер
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
            <p class="Bal-ttl title-main">Добавить оффер</p>
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
        <?php else: ?>
    <div class="order">
        <div class="bcr">
            <ul class="bcr__list">
                <li class="bcr__item">
          <span class="bcr__link">
            Создать оффер
          </span>
                </li>
            </ul>
        </div>

        <div class="order__top-inner">
            <h1 class="order__title title-main">
                Доступные предложения
            </h1>

            <a href="<?= Url::to(['usermanualmyoffers']) ?>" class="order__top-link link">Как принять оффер в работу?</a>
        </div>

        <div class="order__nav-box">
            <?= Html::beginForm('', 'GET', ['class' => 'finishedFilter', 'style' => 'max-width: 420px;']) ?>
            <div style="max-width: 550px" class="MyOrders_filter">
                <button class="MyOrders_filter-reset" type="reset"></button>
                <select class="MyOrders_filter-select" name="filter[sphere]" id="">
                    <option selected disabled>Сфера</option>
                    <?php foreach ($category as $v): ?>
                        <option class="sendFinished" value="<?= $v['category'] ?>"><?= $v['category'] ?></option>
                    <?php endforeach; ?>
                </select>
                <select class="MyOrders_filter-select" name="filter[region]" id="">
                    <option selected disabled>Регион</option>
                    <?php foreach ($regions as $v): ?>
                        <option class="sendFinished" value="<?= $v ?>"><?= $v ?></option>
                    <?php endforeach; ?>
                </select>
                <input class="MyOrders_filter-check" type="checkbox" name="filter[price]" id="MyOrders_filter-check">
                <label class="MyOrders_filter-check-p sendFinished <?= !empty($_GET['filter']['price']) ? 'activeCheck' : '' ?>" for="MyOrders_filter-check">От 500 ₽</label>
<!--                <input class="MyOrders_filter-check" type="checkbox" name="filter[percent]" id="MyOrders_filter-check1">-->
<!--                <label class="MyOrders_filter-check-p sendFinished --><?//= !empty($_GET['filter']['percent']) ? 'activeCheck' : '' ?><!--" for="MyOrders_filter-check1">От 70%</label>-->
            </div>
            <?= Html::endForm(); ?>

            <a href="<?= Url::to(['order-lid-add']) ?>" class="order__nav-btn btn">Предложить свой оффер</a>
        </div>


        <div class="order__cards">
            <?php Pjax::begin(['id' => 'finishedContainer']) ?>
            <?php if(!empty($templates)): ?>
                <?php foreach($templates as $item): ?>
                <?php if ($item['hot'] == 1): ?>
                    <div style="border: 1px solid #2CCD65;" class="order__card card">
                        <div class="Hot__line">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="20" height="20" rx="4" fill="url(#paint0_linear)"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.7571 3.26714C11.9892 3.361 12.1217 3.60666 12.0726 3.85212L11.1555 8.43747H13.1244C13.3149 8.43747 13.4902 8.5415 13.5815 8.70873C13.6728 8.87595 13.6655 9.07968 13.5625 9.23995L8.87496 16.5316C8.7396 16.7422 8.4736 16.8267 8.24155 16.7328C8.0095 16.6389 7.87704 16.3933 7.92613 16.1478L8.8432 11.5625H6.87435C6.68382 11.5625 6.5085 11.4584 6.41721 11.2912C6.32591 11.124 6.33321 10.9203 6.43624 10.76L11.1237 3.46833C11.2591 3.25777 11.5251 3.17328 11.7571 3.26714ZM7.82834 10.5208H9.47852C9.63455 10.5208 9.78237 10.5908 9.8813 10.7114C9.98023 10.8321 10.0198 10.9908 9.98924 11.1438L9.4875 13.6525L12.1704 9.47914H10.5202C10.3641 9.47914 10.2163 9.40918 10.1174 9.28851C10.0185 9.16784 9.97886 9.00917 10.0095 8.85616L10.5112 6.34747L7.82834 10.5208Z" fill="white"/>
                                <defs>
                                    <linearGradient id="paint0_linear" x1="0.000414508" y1="9.98691" x2="19.9924" y2="9.98691" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#2CCD65"/>
                                        <stop offset="1" stop-color="#2096EC"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                            <p class="Hot__line-p">Горячий оффер</p>
                        </div>
                        <div class="card__box">
                            <h2 class="card__title">
                                <?= $item['name'] ?>
                            </h2>

                            <div class="leadCount__subtitle">
                                Необходимое количество лидов
                            </div>

                        </div>

                        <div class="card__box reserse">
                            <div class="hotOf__subtitle">
                                <?= $item['category'] ?>
                            </div>

                            <div class="card__price">
                                <?= $item['lead_count'] ?> лидов
                            </div>
                        </div>

<!--                        <div class="card__box">-->
<!--                            <a href="--><?//= Url::to(['order-lid', 'template' => $item['link']]) ?><!--" data-pjax="0" class="card__link link">Заказать лиды</a>-->
<!--                            <button data-id="--><?//= $item['id'] ?><!--" data-pjax="0" type="button" class="card__btn link link--color">Подробнее</button>-->
<!--                        </div>-->
                        <div class="card__box reserse">
                            <div class="btn__group-offers">
                                <a href="<?= Url::to(['view-offer', 'id' => $item['id']]) ?>" class="confirm__offers">Принять в работу</a>
                            </div>
                            <div>
                                <div style="padding-right: 0;" class="leadCount__subtitle">Вознаграждение за принятый лид</div>
                                <div class="card__price">
                                    <?= $item['price'] ?>₽/лид
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                        <div style="border: 1px solid #CBD0E8;" class="order__card card">
                            <div class="card__box">
                                <h2 class="card__title">
                                    <?= $item['name'] ?>
                                </h2>

                                <div class="leadCount__subtitle">
                                    Вознаграждение за принятый лид
                                </div>

                            </div>

                            <div class="card__box reserse">
                                <div class="hotOf__subtitle">
                                    <?= $item['category'] ?>
                                </div>

                                <div class="card__price">
                                    <?= $item['price'] ?>₽/лид
                                </div>
                            </div>

                            <!--                        <div class="card__box">-->
                            <!--                            <a href="--><?//= Url::to(['order-lid', 'template' => $item['link']]) ?><!--" data-pjax="0" class="card__link link">Заказать лиды</a>-->
                            <!--                            <button data-id="--><?//= $item['id'] ?><!--" data-pjax="0" type="button" class="card__btn link link--color">Подробнее</button>-->
                            <!--                        </div>-->
                            <div class="card__box reserse">
                                <div class="btn__group-offers">
                                    <a href="<?= Url::to(['view-offer', 'id' => $item['id']]) ?>" class="confirm__offers-nothot">Принять в работу</a>
                                </div>
                                <div>
                                    <div style="padding-right: 0;" class="leadCount__subtitle">процент принятия лида</div>
                                    <div class="card__price">
                                        от 65%
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if(!empty($pages)): ?>
                    <?php echo LinkPager::widget([
                        'pagination' => $pages,
                    ]); ?>
                <?php endif; ?>
            <?php else: ?>
                <div>Предложения не найдены</div>
            <?php endif; ?>
            <?php Pjax::end() ?>
        </div>
    </div>
        <?php endif; ?>

    <div class="backPopUp">
        <div class="popup__body">

        </div>
    </div>
    </section>
</section>