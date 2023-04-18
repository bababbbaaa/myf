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
if (!empty($stats)) {
  foreach ($stats as $key => $item) {
    $buff1[$log === 1 ? date("d.m", strtotime($item->date_lead)) : strtotime($item->date_lead)] = $item->summ;
  }
  $count = count($stats);
}
if (!empty($stats2)) {
  foreach ($stats2 as $key => $item) {
    $buff2[$log === 1 ? date("d.m", strtotime($item->date_lead)) : strtotime($item->date_lead)] = $item->summ;
  }
  $count2 = count($stats2);
}
if (!empty($stats3)) {
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
  } else
    $currItem2 = 0;
  $budgets2[$key] = $currItem2;
  if (isset($buff3[$item])) {
    $currItem3 = $buff3[$item];
    if (!isset($min) || $item < $min)
      $min = $item;
  } else
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
  .jq-selectbox__select-text {
    width: 60px !important;
    overflow: hidden;
  }

  .disabled {
    color: black !important;
  }

  .selected {
    color: white !important;
    background-color: #08C !important;
  }

  .activeCheck {
    border-color: #08C;
    color: #08C;
  }

  .moderationFilter,
  .finishedFilter {
    max-width: 300px;
  }

  label {
    display: block;
    margin-bottom: 0;
    font-weight: 500;
  }

  .dropdown {
    position: relative;
    transition-duration: 0.3s;
    align-self: flex-start;
  }

  .dropdown a {
    font-weight: normal;
    font-size: 14px;
    line-height: 20px;
    color: #5b617c;
    transition-duration: 0.3s;
    text-decoration: none;
  }

  .dropdown-header {
    font-size: 14px;
    background-color: #fafafa;
    cursor: pointer;
    transition-duration: 0.3s;
  }

  .dropdown-header:hover {
    background-color: #0a73bb;
    color: white;
  }

  .jq-selectbox__dropdown {
    width: fit-content;
  }

  .main-div {
    padding: 40px;
  }

  .header-block1 {
    max-width: 563px;
    font-size: 24px;
    line-height: 28px;
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

  .btn-block:hover,
  .btn-block-active {
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
        <span class="bcr__link">Статистика</span>
      </li>
    </ul>
  </div>
  <div class="title_row">
    <p class="Bal-ttl title-main">Статистика</p>
  </div>
  <nav class="MyOrders_tabs">
    <div class="tab tab1">
      <a href="#1" class="tabsChange"></a>
      <p class="name">Общая</p>
      <div class="string act1"></div>
    </div>
    <div class="tab tab2">
      <a href="#2" class="tabsChange"></a>
      <p class="name">По текущим программам</p>
      <div class="string act2"></div>
    </div>
    <div class="tab tab3">
      <a href="#3" class="tabsChange"></a>
      <p class="name">По завершенным программам</p>
      <div class="string act3"></div>
    </div>
  </nav>

  <section class="OrderCardS OrderPage OrderPage-1">
    <!--        --><? //= Html::beginForm('', 'get', ['class' => 'activeFilter']) 
                    ?>
    <!--        --><? //= Html::endForm(); 
                    ?>
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
    <div class="myprograms_filter">
      <button class="MyOrders_filter-reset" type="reset"></button>
      <select class="MyOrders_filter-select" name="activeFilter[status]" id="">
        <option selected disabled>Статус</option>
        <option class="sendActive" value="<?= Orders::STATUS_PROCESSING ?>">Исполняется</option>
        <option class="sendActive" value="<?= Orders::STATUS_STOPPED ?>">Остановлен</option>
        <option class="sendActive" value="<?= Orders::STATUS_PAUSE ?>">Пауза</option>
      </select>
      <select class="MyOrders_filter-select" name="activeFilter[sphere]" id="">
        <option selected disabled>Сфера</option>
        <?//php foreach ($sphere as $k => $v) : ?>
          <option class="sendActive" value="<?= $v['link_name'] ?>"><?= $v['name'] ?></option>
        <?//php endforeach; ?>
      </select>
      <select class="MyOrders_filter-select" name="activeFilter[format]" id="">
        <option selected disabled>Формат</option>
        <option class="sendActive" value="Формат">Формат</option>
      </select>
      <input class="MyOrders_filter-check" type="checkbox" name="activeFilter[new]" id="MyOrders_filter-check">
      <label class="MyOrders_filter-check-l sendActive <?= !empty($_GET['activeFilter']['new']) ? 'activeCheck' : '' ?>" for="MyOrders_filter-check">Новые</label>
    </div>
    <?= Html::endForm(); ?>
    </div>

      <div class="stat_list">
        <div class="stat_list_card">
          <div class="stat_list_card_top">
            <div class="stat_list_card_top_left">
              <p class="stat_list_card_top_left-type">курс</p>
              <h2 class="stat_list_card_top_left-title">Маркетинг с 0</h2>
            </div>
            <div class="myprogramm_right">
                                <div style="margin-bottom: 0px;" class="myprogramm_right_top">
                                    <div class="myprogramm_right_top_spoiler">
                                        <button class="myprogramm_right_top_spoiler-btn">
                                        Действия
                                        </button>
                                        <ul class="myprogramm_right_top_spoiler_list">
                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--pause">
                                                Пауза
                                                </button>
                                            </li>
                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--stop">
                                                Завершить
                                                </button>
                                            </li>
                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--stop">
                                                Взобновить
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="myprogramm_right_top_right">
                                        <div class="myprogramm_right_top_right-teg"><div class="myprogramm_right_top_right-teg-point"></div> <p class="myprogramm_right_top_right-teg-text">Продажи</p></div>
                                        <p class="myprogramm_right_top_right-date">от 24.04.2021</p>
                                    </div>
                                </div>
                            </div>
          </div>
          <div class="stat_list_card_medle">
            <div class="stat_list_card_medle_left">
              <p class="stat_list_card_medle_left-title">количество активных студентов</p>
              <p class="stat_list_card_medle_left-text">200</p>
              <p class="stat_list_card_medle_left-title">количество активных студентов</p>
              <p class="stat_list_card_medle_left-text">200</p>
            </div>
            <div class="stat_list_card_medle_right">
              Statistic
            </div>
          </div>
          <div class="stat_list_card_bottom">
              <button class="link--purple stat_list_card_bottom-btn">Показать детали </button>
          </div>
          <div class="stat_list_card-detales">
            <p class="stat_list_card-detales-title">Информация о курсе</p>

            <div class="stat_list_card-detales_row">
              <div class="stat_list_card-detales_row-column">
                <p class="stat_list_card-detales_row-column-title">Сфера</p>
                <p class="stat_list_card-detales_row-column-text">Маркетинг</p>
              </div>
              <div class="stat_list_card-detales_row-column">
                <p class="stat_list_card-detales_row-column-title">Сфера</p>
                <p class="stat_list_card-detales_row-column-text">Маркетинг</p>
              </div>
            </div>

            <div class="stat_list_card-detales_row">
              <div class="stat_list_card-detales_row-column">
                <p class="stat_list_card-detales_row-column-title">Сфера</p>
                <p class="stat_list_card-detales_row-column-text">Маркетинг</p>
              </div>
              <div class="stat_list_card-detales_row-column">
                <p class="stat_list_card-detales_row-column-title">Сфера</p>
                <p class="stat_list_card-detales_row-column-text">Маркетинг</p>
              </div>
            </div>

            <p class="courses_item_info-teachers">
              Преподаватели
            </p>
            <div class="courses_item_info_teachers-row">
              <div class="courses_item_info_teachers-row-item">
                <img src="<?= Url::to('../img/skillclient/ico.svg') ?>" alt="teacher">
                  <p class="courses_item_info_teachers-row-item-name">
                    Марина Дьярова
                  </p>
                </div>
              </div>
          </div>
        </div>
      </div>
  </section>

  <section class="OrderCardS OrderPage OrderPage-3">
          <div class="stat_list">
        <div class="stat_list_card">
          <div class="stat_list_card_top">
            <div class="stat_list_card_top_left">
              <p class="stat_list_card_top_left-type">курс</p>
              <h2 class="stat_list_card_top_left-title">Маркетинг с 0</h2>
            </div>
            <div class="myprogramm_right">
                                <div style="margin-bottom: 0px;" class="myprogramm_right_top">
                                    <div class="myprogramm_right_top_spoiler">
                                        <button class="myprogramm_right_top_spoiler-btn">
                                        Действия
                                        </button>
                                        <ul class="myprogramm_right_top_spoiler_list">
                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--pause">
                                                Пауза
                                                </button>
                                            </li>
                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--stop">
                                                Завершить
                                                </button>
                                            </li>
                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--stop">
                                                Взобновить
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="myprogramm_right_top_right">
                                        <div class="myprogramm_right_top_right-teg"><div class="myprogramm_right_top_right-teg-point"></div> <p class="myprogramm_right_top_right-teg-text">Продажи</p></div>
                                        <p class="myprogramm_right_top_right-date">от 24.04.2021</p>
                                    </div>
                                </div>
                            </div>
          </div>
          <div class="stat_list_card_medle">
            <div class="stat_list_card_medle_left">
              <p class="stat_list_card_medle_left-title">количество активных студентов</p>
              <p class="stat_list_card_medle_left-text">200</p>
              <p class="stat_list_card_medle_left-title">количество активных студентов</p>
              <p class="stat_list_card_medle_left-text">200</p>
            </div>
            <div class="stat_list_card_medle_right">
              Statistic
            </div>
          </div>
          <div class="stat_list_card_bottom">
              <button class="link--purple stat_list_card_bottom-btn">Показать детали </button>
          </div>
          <div class="stat_list_card-detales">
            <p class="stat_list_card-detales-title">Информация о курсе</p>

            <div class="stat_list_card-detales_row">
              <div class="stat_list_card-detales_row-column">
                <p class="stat_list_card-detales_row-column-title">Сфера</p>
                <p class="stat_list_card-detales_row-column-text">Маркетинг</p>
              </div>
              <div class="stat_list_card-detales_row-column">
                <p class="stat_list_card-detales_row-column-title">Сфера</p>
                <p class="stat_list_card-detales_row-column-text">Маркетинг</p>
              </div>
            </div>
            
            <div class="stat_list_card-detales_row">
              <div class="stat_list_card-detales_row-column">
                <p class="stat_list_card-detales_row-column-title">Сфера</p>
                <p class="stat_list_card-detales_row-column-text">Маркетинг</p>
              </div>
              <div class="stat_list_card-detales_row-column">
                <p class="stat_list_card-detales_row-column-title">Сфера</p>
                <p class="stat_list_card-detales_row-column-text">Маркетинг</p>
              </div>
            </div>

            <p class="courses_item_info-teachers">
              Преподаватели
            </p>
            <div class="courses_item_info_teachers-row">
              <div class="courses_item_info_teachers-row-item">
                <img src="<?= Url::to('../img/skillclient/ico.svg') ?>" alt="teacher">
                  <p class="courses_item_info_teachers-row-item-name">
                    Марина Дьярова
                  </p>
                </div>
              </div>
          </div>
        </div>
      </div>
  </section>

  <footer class="footer">
        <div class="">
            <a href="<?= Url::to(['manual']) ?>" class="footer__link">
                Руководство пользователя
            </a>
            <a href="<?= Url::to(['support']) ?>" class="footer__link">
                Тех.поддержка
            </a>
        </div>
    </footer>