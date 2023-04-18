<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Выбор заказов';

$js = <<< JS
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
    
    $('.order__cards').on('click', '.card__btn', function() {
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
    $('.backPopUp').on('click', '.popup__img-close',function(e) {
      if (e.target === this) $('.backPopUp').fadeOut(300);
    });
    
    $('.backPopUp').on('click', function(e) {
      if (e.target === this) $('.backPopUp').fadeOut(300);
    });

JS;
$this->registerJs($js);

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
        z-index: 900;
    }
    .popup__body {
        position: absolute;
        overflow-y: auto;
        z-index: 10000;
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
$this->registerCss($css);
?>

<section class="rightInfo">
    <div class="order">
        <div class="bcr">
            <ul class="bcr__list">
                <li class="bcr__item">
          <span class="bcr__link">
            Создать заказ
          </span>
                </li>
            </ul>
        </div>

        <div class="order__top-inner">
            <h1 class="order__title title-main">
                Доступные предложения
            </h1>

            <a href="<?= Url::to(['usermanualmyorders']) ?>" class="order__top-link link">Как сделать заказ?</a>
        </div>

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

            <a href="<?= Url::to(['order-lid-add']) ?>" class="order__nav-btn btn">Создать заказ</a>
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
                               class="card__link link">Заказать лиды</a>
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
    </div>

    <div class="backPopUp">
        <div class="popup__body">

        </div>
    </div>
</section>