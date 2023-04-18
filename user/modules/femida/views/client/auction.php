<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Аукцион';

$catArray = [];
if (!empty($category)) {
  foreach ($category as $item)
    $catArray[$item['link_name']] = $item['name'];
}

$paramArray = [];
if (!empty($params)) {
  foreach ($params as $item)
    $paramArray[$item['category']][] = [
      'name' => $item['name'],
      'type' => $item['type'],
      'description' => $item['description'],
    ];
}

function formatPhone($phone)
{
  return "{$phone[0]} ({$phone[1]}{$phone[2]}{$phone[3]}) {$phone[4]}{$phone[5]}X-XX-XX";
}

$js = <<<JS
$('.auction__cards').on('click', '.buy-lead-link', function() {
    var id = $(this).attr('data-id'),
        elem = $(this),
        hash = $(this).attr('data-hash');
    $.ajax({
        data: {hash: hash, id: id},
        url: 'auction-buy-lead',
        dataType: "JSON",
        type: "POST",
        beforeSend: function() {
            $('.preloader-ajax-forms').fadeIn(100);
        }
    }).done(function(response) {
        elem.remove();
        $('.preloader-ajax-forms').fadeOut(100);
        if (response.status === 'success') {
            $('.Form_leads_filter').submit();
            $(".popup--auct").fadeIn();
            $("body").css("overflow", "hidden");
        } else {
            $('.rsp-ajax-title').text(response.title);
            $('.rsp-ajax-text').html(response.message);
            $(".popup--auct-err").fadeIn();
            $("body").css("overflow", "hidden");
        }
    });
});

$('.aucFilt').on('click', function() {
    setTimeout(function() {
        $('.aucForm').submit();
    }, 200);
});

$('.resetAuc').on('click', function() {
  location.href = 'auction';
});

$('.MyOrders_filter-check-l').on('click', function() {
  $(this).toggleClass('activeCheck');
});

$('.aucForm').on('submit', function(e) {
    e.preventDefault();
    $.pjax.reload({
        container: '#aucContainer',
        url: 'auction',
        type: 'GET',
        data: $('.aucForm').serialize(),
    }).done(function() {});
});

var tab = location.hash.substring(4);
    if (tab.length === 0){
        $('.tab1').addClass('active');
        $('.order-page_leads-tab').fadeIn(200);
    } else {
        $('.tab').removeClass('active');
        $('.tab' + tab).addClass('active');
        $('.auction__content-item').fadeOut(1, function() {
            $('.auction__content-item--' + tab).fadeIn(200);
        });
    }
    $('.tabChangeLnk').on('click', function() {
        var tabs = $(this).attr('href').substring(4);
        $('.tab').removeClass('active');
        $('.auction__content-item').fadeOut(1, function() {
            $('.tab' + tabs).addClass('active');
            $('.auction__content-item--' + tabs).fadeIn(1);
        });
    });
    $('.auction__lid').on('click', function() {
        var id = $(this).children('a').attr('data-id');
        $.ajax({
            url: 'popup-auc-date',
            type: 'POST',
            data: {id:id},
        }).done(function(rsp) {
            $('.order-page_lead_popap-wrap').html(rsp).fadeIn(300);
            $('.order-page_lead_popap_back').fadeIn(300);
        });
    });
    
    $('.Form_leads_filter').on('submit', function(e) {
        e.preventDefault();
        $.pjax.reload({
            container: '#byContainer',
            url: 'auction' + location.hash,
            type: 'GET',
            data: $('.Form_leads_filter').serialize()
        }).done(function() {
          
        });
    });
      $('.order-page_lead_popap-wrap').on('click', '.order-page_lead_popap-close', function() {
        $('.order-page_lead_popap_back').fadeOut(300);
        $('.order-page_lead_popap-wrap').fadeOut(300);
    });
JS;
$css = <<< CSS
    .MyOrders_filter {
        max-width: 300px;
    }
    .jq-selectbox__select-text{
        max-width: 60px;
        overflow: hidden;
    }
    .activeCheck{
        border-color: #08C;
        color: #08C;
    }
    .tab{
        position: relative;
    }
    .tab a{
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
    }
CSS;
$this->registerCss($css);
$this->registerJs($js);
?>


<section class="rightInfo">
  <div class="order">
    <div class="bcr">
      <ul class="bcr__list">
        <li class="bcr__item">
          <span class="bcr__link">
            Аукцион лидов
          </span>
        </li>
        <li class="bcr__item">
          <span class="bcr__span">
            Все лиды
          </span>
        </li>
      </ul>
    </div>

    <div class="order__top-inner">
      <h1 class="order__title title-main">
        Аукцион лидов
      </h1>

      <a href="<?= Url::to(['manualauctions']) ?>" class="order__top-link link">Что такое аукцион лидов?</a>
    </div>

    <nav class="MyOrders_tabs auction__tabs">
      <div class="tab tab1 active">
        <a class="tabChangeLnk" data-pjax="0" href="#tab1"></a>
        <p class="name">Все лиды</p>
        <div class="string"></div>
      </div>
      <div class="tab tab2">
        <a class="tabChangeLnk" data-pjax="0" href="#tab2"></a>
        <p class="name">Купленные лиды</p>
        <div class="string"></div>
      </div>
    </nav>

    <div class="auction__content">
      <div class="auction__content-item auction__content-item--1 active">

        <?= Html::beginForm('', 'GET', ['class' => 'aucForm']) ?>
        <div class="MyOrders_filter">
          <button class="MyOrders_filter-reset resetAuc" type="reset"></button>
          <select class="MyOrders_filter-select" name="filter[sphere]" id="">
            <option selected disabled>Сфера</option>
            <?php foreach ($catArray as $k => $v) : ?>
              <option class="aucFilt" value="<?= $k ?>"><?= $v ?></option>
            <?php endforeach; ?>
          </select>
          <input class="MyOrders_filter-check" type="checkbox" name="filter[new]" id="MyOrders_filter-check">
          <label class="MyOrders_filter-check-l aucFilt <?= !empty($_GET['filter']['new']) ? 'activeCheck' : '' ?>" for="MyOrders_filter-check" style="font-size: 14px">Новые</label>
        </div>
        <?= Html::endForm(); ?>

        <div class="auction__cards">
          <?php Pjax::begin(['id' => 'aucContainer']) ?>
          <?php if (!empty($leads)) : ?>
            <?php foreach ($leads as $item) : ?>
              <div class="auction__card card-a">
                <div class="card-a__top">
                  <div class="card-a__top-item">
                    <p class="card-a__title">
                      <?= $catArray[$item['type']] ?>
                    </p>
                    <p class="card-a__subtitle">
                      <?= $item['region'] ?>
                    </p>
                  </div>

                  <div class="card-a__top-item card-a__top-item--2">
                    <p class="card-a__price">
                      <?= $item['auction_price'] ?> рублей
                    </p>

                    <button type="button" class="card-a__link link buy-lead-link" data-id="<?= $item['id'] ?>" data-hash="<?= md5("{$item['id']}::auc-09_buy") ?>">Купить лид
                    </button>
                  </div>
                </div>

                <div class="card-a__content">
                  <div class="card-a__content-box">
                    <p class="card-a__content-title">
                      телефон
                    </p>

                    <p class="card-a__content-text">
                      <?= formatPhone($item['phone']); ?>
                    </p>
                  </div>
                  <?php $orderParams = json_decode($item['params'], true); ?>
                  <?php if ($orderParams !== null) : ?>
                    <?php if (!empty($paramArray[$item['type']])) : ?>
                      <?php $categoryParamsArr = $paramArray[$item['type']]; ?>
                      <?php foreach ($categoryParamsArr as $pVal) : ?>
                        <?php if (!empty($orderParams[$pVal['name']])) : ?>
                          <div class="card-a__content-box">
                            <p class="card-a__content-title">
                              <?= $pVal['description'] ?>
                            </p>

                            <p class="card-a__content-text">
                              <?php if ($pVal['type'] === 'number') : ?>
                                <?= number_format($orderParams[$pVal['name']], 0, '', ' ') ?>
                              <?php else : ?>
                                <?= $orderParams[$pVal['name']] ?>
                              <?php endif; ?>
                            </p>
                          </div>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  <?php endif; ?>

                  <?php if (!empty($item['comments'])) : ?>
                    <p class="card-a__content-title">
                      комментарий
                    </p>
                    <p class="card-a__content-text card-a__content-text--com">
                      <?= strip_tags($item['comments'], "<br>") ?>
                    </p>
                  <?php endif; ?>

                  <div class="card-a__content-date">
                    <?= date("d.m.Y H:i", strtotime($item['date_income'])) ?>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else : ?>
            <div style="font-size: 14px; color: #9ba0b7">В данный момент в аукционе нет лидов.</div>
          <?php endif; ?>
          <?php if (!empty($pages)) : ?>
            <?php echo LinkPager::widget([
              'pagination' => $pages,
            ]); ?>
          <?php endif; ?>
          <?php Pjax::end() ?>
        </div>

      </div>

      <div class="auction__content-item auction__content-item--2">
        <div class="auction__lids">
          <div class="auction__lids-nav">
            <?= Html::beginForm('', 'get', ['class' => 'Form_leads_filter']) ?>
            <div class="order-page_leads_filter adAucFilt">
              <input placeholder="Ключевое слово" autocomplete="off" value="<?= $_GET['filtersBy']['word'] ?>" class="InputSearch adFiltAudDate" type="text" name="filtersBy[word]">
              <p class="order-page_leads_filter-t">
                Выбрать период
              </p>
              <p class="order-page_leads_filter-t">с</p>
              <?php echo DatePicker::widget([
                'name' => 'filtersBy[first]',
                //                            'value' => Html::encode($_GET['filters']['first']),
                'options' => ['autocomplete' => 'off', 'class' => 'inpdate adFiltAudDate', 'placeholder' => date('Y-m-d', time() - 3600 * 7 * 24)],
                //'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd',
              ]); ?>
              <p class="order-page_leads_filter-t">по</p>
              <?php echo DatePicker::widget([
                'name' => 'filtersBy[last]',
                //                            'value' => Html::encode($_GET['filters']['last']),
                'options' => ['autocomplete' => 'off', 'class' => 'inpdate2 adFiltAudDate', 'placeholder' => date('Y-m-d')],
                //'language' => 'ru',
                'dateFormat' => 'yyyy-MM-dd',
              ]); ?>
              <button style="font-size: 14px" type="submit" class="uscp Page2-Balance_chooseP-BTN df aic jcc order-page_leads_filterBTN">
                Показать
              </button>
            </div>
            <?= Html::endForm(); ?>
          </div>

          <?php if (!empty($reps)) : ?>
            <div class="auction__lids-inner">
              <div class="auction__lids-top">
                <!--                                <span class="auction__check"></span>-->
                <span class="auction__info auction__info--1">ID</span>
                <span class="auction__info auction__info--2">фио</span>
                <span class="auction__info auction__info--3">телефон</span>
                <span class="auction__info auction__info--5">дата</span>
                <span class="auction__info-link link">Подробнее</span>
              </div>
              <?php Pjax::begin(['id' => 'byContainer']) ?>
              <?php foreach ($reps as $item) : ?>
                <?php if (!empty($wordfilter)) : ?>
                  <?php $item->filters = $wordfilter; ?>
                  <?php if (!empty($item->filteredLeads)) : ?>
                    <div class="auction__lid">
                      <!--                                    <span class="auction__check"></span>-->
                      <span class="auction__info auction__info--1"><?= $item->filteredLeads->id ?></span>
                      <span class="auction__info auction__info--2"><?= !empty($item->filteredLeads->name) ? $item->filteredLeads->name : "<span style='color: #9e9e9e'>Без имени</span>" ?></span>
                      <span class="auction__info auction__info--3"><?= $item->filteredLeads->phone ?></span>
                      <span class="auction__info auction__info--5"><?= date('d.m.Y H:i', strtotime($item->date)) ?></span>
                      <a class="auction__info-link link" data-id="<?= $item->id ?>">Подробнее</a>
                    </div>
                  <?php endif; ?>
                <?php else : ?>
                  <div class="auction__lid">
                    <!--                                    <span class="auction__check"></span>-->
                    <span class="auction__info auction__info--1"><?= $item->lead->id ?></span>
                    <span class="auction__info auction__info--2"><?= !empty($item->lead->name) ? $item->lead->name : "<span style='color: #9e9e9e'>Без имени</span>" ?></span>
                    <span class="auction__info auction__info--3"><?= $item->lead->phone ?></span>
                    <span class="auction__info auction__info--5"><?= date('d.m.Y H:i', strtotime($item->date)) ?></span>
                    <a class="auction__info-link link" data-id="<?= $item->id ?>">Подробнее</a>
                  </div>
                <?php endif; ?>
              <?php endforeach; ?>
              <?php Pjax::end() ?>
            </div>
          <?php else : ?>
            <div style="font-size: 14px; color: #9ba0b7">Не найдены купленные на аукционе лиды</div>
          <?php endif; ?>

        </div>
        <?php if (!empty($pages2)) : ?>
          <?php echo LinkPager::widget([
            'pagination' => $pages2,
          ]); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="popup popup--auct">
    <div class="popup__ov">
      <div class="popup__body popup__body--ok">
        <div class="popup__content popup__content--ok">
          <p class="popup__title">Лид куплен!</p>
          <p class="popup__text">
            Лид добален в таблицу
          </p>
          <button class="popup__btn-lid btn">Перейти к купленным лидам</button>
        </div>
        <div class="popup__close">
          <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
        </div>
      </div>
    </div>
  </div>

  <div class="popup popup--auct-err">
    <div class="popup__ov">
      <div class="popup__body popup__body--w">
        <div class="popup__content popup__content--err">
          <p class="popup__title rsp-ajax-title">

          </p>
          <p class="popup__text rsp-ajax-text">

          </p>
          <button class="popup__btn-close btn">Закрыть</button>
        </div>
        <div class="popup__close">
          <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
        </div>
      </div>
    </div>
  </div>

  <div class="order-page_lead_popap_back"></div>
  <div class="order-page_lead_popap-wrap">

  </div>
</section>