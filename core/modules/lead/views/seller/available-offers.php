<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\helpers\UrlHelper;

$this->title = 'Доступные партнерские офферы';
$js = <<< JS
    
        setTimeout(function() {
        $('#link_reload').attr("href","available-offers?").trigger("click");
    },100)
    $('.filter__form2').on('submit', function(e) {
        $('#link_reload').attr("href","available-offers?" + $(this).serialize()).trigger("click");
        e.preventDefault();
    });

    $('.filter__form').on('submit', function(e) {
        $('#link_reload').attr("href","available-offers?" + $(this).serialize()).trigger("click");
        e.preventDefault();
    });

    $('.reload__filter').on('click', function(e) {
        $('#link_reload').attr("href","available-offers?").trigger("click");
        $('.top_filter').removeClass('active');
        $('.left_filter').removeClass('active');
        e.preventDefault();
    });
    

    $('.filters').on('mouseup', '.top_filter', function() {
        var t = $(this);
        setTimeout(function() {
        if (t.hasClass('active')){
            t.removeClass('active');
        } else {
            t.addClass('active');
        }
        $('.filter__form2').submit();
        }, 300);
    });
    $('.filters').on('mouseup', '.left_filter', function() {
        var t = $(this);
        setTimeout(function() {
        if (t.hasClass('active')){
            t.removeClass('active');
        } else {
            t.addClass('active');
        }
        $('.filter__form').submit();
        }, 300);
    });
    // $('.filter__form').on('submit', function(e) {
    //     $('#link_reload').attr("href","available-offers?" + $(this).serialize()).trigger("click");
    //     e.preventDefault();
    // });
    // $('.reload__filter').on('click', function(e) {
    //     $('#link_reload').attr("href","available-offers?").trigger("click");
    //     e.preventDefault();
    // });
    // $(window).on('click', function (e) {
    //     if (e.target.nodeName !== "LABEL" && e.target.nodeName !== "INPUT" && e.target.nodeName !== "BUTTON" && e.target.nodeName !== "A") {
    //         $(".filters__list").removeClass("filters__list--visable");
    //         if($('.filters__input').not(':checked')){
    //             $(".filters-select > .filters__btn").removeClass('active');
    //         }
    //     }
    // });
    $('.filters__label').on('click', function() {
        setTimeout(function() {
            $('.filter__form').submit();
        }, 300);
    });
JS;
$this->registerJs($js);
$this->registerJsFile(Url::to(['/js/seller-range.js']), ['depends' => [\yii\web\JqueryAsset::className()]]);
$arr = [];
foreach ($region as $k => $v) {
  $json = json_decode($v['regions'], true);
  foreach ($json as $kk => $vv) {
    $arr[] = $vv;
  }
}
$arr = array_unique($arr);
?>
<section class="OF__top top">
  <div class="container">
    <div class="TL_cont-inner TL_cont-inner--2">
      <div class="TL_cont-content">
        <h1 class="TL_h1 TL_h1--tq">Доступные офферы</h1>
        <h2 class="TL_p1">Список офферов постоянно пополняется</h2>
        <button type="button" class="btn-1 TL_sec1__btn showsCons">Начать зарабатывать</button>
      </div>
      <div class="TL_cont__img TL_cont__img--tq">
        <img src="<?= Url::to(['/img/typslid-img3.png']) ?>" alt="картинка офферта" />
      </div>
    </div>
  </div>
</section>

<section class="SL__cards">
  <div class="container">
    <h2 class="SL__cards-title title">
      Выберите категорию и отфильтруйте<br> по региону и цене лида
    </h2>

    <h3 class="SL__cards-subtitle subtitle">
    </h3>

    <div class="TL_sec2-inner">
        <aside class="TL_sec2-aside">
            <?= Html::beginForm(Url::to(['types-of-leads']), 'get', ['class' => 'filter__form']) ?>
            <div class="OF__cards-filters filters">
                <!--                    <input class="sr-only" type="checkbox" name="filter[category]" value="all">-->
                <span style="background: #f16262; color: white" class="filters__btn filters__btn--2 filters__btn--margin reload__filter">Сбросить фильтр</span>
                <?php foreach ($select as $k => $v): ?>
                    <label class="filters__btn filters__btn--2 left_filter">
                        <input class="sr-only" type="checkbox" name="filter[category][]"
                               value="<?= $v['category_link'] ?>">
                        <?= $v['name'] ?>
                    </label>
                <?php endforeach; ?>
            </div>
            <?= Html::endForm(); ?>
        </aside>

        <div class="TL_sec2-content">
            <?= Html::beginForm(Url::to(['types-of-leads']), 'get', ['class' => 'filter__form2']) ?>
            <div class="OF__cards-filters filters filters--flex">
                <label class="filters__btn top_filter">
                    <input class="sr-only" type="checkbox" name="filter[new]" value="new">
                    Новые лиды
                </label>

                <label class="filters__btn top_filter">
                    <input class="sr-only" type="checkbox" name="filter[price]" value="500">
                    Лиды до 500 ₽
                </label>
            </div>
            <?= Html::endForm(); ?>

        <div class="TL_sec2-pjax">
          <!--            pjax     -->
          <?php Pjax::begin([/*"enablePushState" => false, "timeout" => false,*/"id" => 'PjaxCont']); ?>
            <a href="" id="link_reload"></a>
          <div class="TL_container3 sort__find">
            <?php foreach ($leadType as $key => $value) : ?>
              <div class="TL_block1">
                <a class="TL_block1--link" href="<?= Url::to(['lead-offer', 'link' => $value['link']]) ?>"></a>
                <div class="TL_block1_1">
                  <img class="TL_img" src="<?= UrlHelper::admin($value['image']) ?>" alt="<?= $value['name'] ?>">
                  <p class="TL_p3"><?= $value['category'] ?></p>
                </div>
                <div class="TL_p31">
                  <?php $count = count(json_decode($value['regions'])); ?>
                  <?php if ($count == 1) : ?>
                    <?php foreach (json_decode($value['regions']) as $k) : ?>
                      <p class="TL_p3_1"><?= $k ?></p>
                    <?php endforeach; ?>
                  <?php elseif ($count <= 4) : ?>
                    <p class="TL_p3_1"><?= $count ?> города</p>
                  <?php else : ?>
                    <p class="TL_p3_1"><?= $count ?> городов</p>
                  <?php endif; ?>
                  <h4 class="TL_p3_2"><?= $value['name'] ?></h4>
                  <p class="TL_p3_3">от <?= $value['price'] ?> рублей/лид</p>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <?php Pjax::end(); ?>
        </div>

        <div class='SL__tool-form tool-form'>
          <h3 class="tool-form__title">
            Не нашли свою тематику?
          </h3>

          <p class="tool-form__text">
            Свяжитесь с нами и мы обсудим возможности арбитража конкретно по вашему направлению!
          </p>

          <button class="tool-form__btn BLS5CD_BTN" type="button">
            Связаться
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="OF__web">
  <div class="container">
    <div class="OF__web-inner">
      <div class="OF__web-content">
        <h4 class="OF__web-title title">
          Веб-мастеру
        </h4>

        <div class="OF__web-text">
          <p>
            Мы работаем с вебмастерами любого уровня подготовки, к каждому есть индивидуальный подход. Мы поддерживаем
            постоянный
            контакт со всеми веб-мастерами и готовы помочь в любую минуту!
          </p>
          <p>
            Нашей приоритетной задачей является постоянное улучшение CPA-сети, и мы сделаем всё, чтоб вам было
            комфортно работать
            и зарабатывать в LEAD.FORCE
          </p>
        </div>
          <a href="<?= Url::to(["/registr?site=lead"]);?>" class="OF__web-btn btn BLS6CBORID-BTN btnsbmtfc">
              Регистрация в проекте
          </a>
      </div>

      <div class="OF__web-img">
        <img src="<?= Url::to(['/img/of-web.webp']) ?>" alt="web" />
      </div>
    </div>
  </div>
</section>

<section class="OF__info">
  <div class="container">
    <h4 class="OF__info-title title title--center">
      Что вас ждет?
    </h4>
    <p class="OF__info-subtitle subtitle subtitle--center">
      Мы приглашаем вас присоединиться к прогрессивной партнерской сети LEAD.FORCE и начать зарабатывать деньги, уже
      сегодня!
    </p>
    <div class="OF__info-inner">
      <div class="OF__info-item">
        Персональный менеджер, который не оставит без ответа
      </div>

      <div class="OF__info-item">
        Глубокая система аналитики трафика с наглядной статистикой
      </div>

      <div class="OF__info-item">
        Самые быстрые и стабильные выплаты на СРА-рынке
      </div>

      <div class="OF__info-item">
        Выделенный отдел технических специалистов и постоянный саппорт
      </div>

      <div class="OF__info-item">
        Эксклюзивные офферы с премиальными условиями для всех
      </div>

      <div class="OF__info-item">
        Самые высокие отчисления по рынку
      </div>

      <div class="OF__info-item">
        100+ офферов для любого трафика
      </div>

      <div class="OF__info-item">
        Легкая установка пикселей источников трафика (включая Facebook Ads)
      </div>
    </div>
  </div>
</section>

<section class="By__Leads__Sec9">
  <div class="By__Leads__Sec9__content">
    <h3 class="TL_h8v">Рассчитайте свою прибыль</h3>
    <div class="TL_inp8">
      <div class="TL_inp8-content">
        <div class="TL_inputtext flex aic fww">
          <p class="TL_p8">Количество лидов</p>
          <input class="TL_input_text tac number1" type="number" min="100" max="1000" step="100" value="500" id="text">
        </div>
        <input class="TL_input_range" type="range" min="0" max="1000" value="500" step="100" id="slider">

        <div class="TL_p88 flex aic fww">
          <div class="lite__fix">
            <p class="TL_p8">Средний процент конверсии</p>
            <h4 class="TL_h8 TL_h8w number1">75%</h4>
          </div>

          <div class="lite__fix">
            <p class="TL_p8">Средняя стоимость лида</p>
            <h4 class="TL_h8 TL_h8w">150 рублей</h4>
          </div>
        </div>
        <div class="TL_inp9 flex fww">
          <h4 class="TL_h8 TL_h8 total">Ваша прибыль</h4>
          <input class="TL_inp9inp tac" type="text" id="result" disabled>
        </div>
      </div>
      <div class="TL_inp8-form">
        <p class="TL_inp8-form-title">
          Начните зарабатывать уже сегодня!
        </p>
        <div class="TL_inp8-form-inner">
          <?= Html::beginForm(Url::to(['/site/form']), 'post', ['id' => 'form-TL_inp8']) ?>
          <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
          <input type="hidden" name="formType" value="Форма для получения 10 бесплатных лидов">
          <input type="hidden" name="pipeline" value="104">
            <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
            <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
          <input type="hidden" name="service" value="">
          <input type="hidden" name="section" value="Рассчитайте свою прибыль">

          <input class="fcstlt TL_inp8-input" required placeholder="Имя" type="text" name="fio">
          <input type="tel" required="required" class="TL_inp8-input region fcstlt" placeholder="Телефон" name="phone">

            <?php if (Yii::$app->user->isGuest):?>
                <a href="<?= Url::to(["/registr?site=lead"])?>" class="btnsbmtfc">Начать зарабатывать</a>
            <?php else:?>
                <button class="btnsbmtfc" type="submit">Начать зарабатывать</button>
            <?php endif?>
          <?= Html::endForm(); ?>
        </div>
      </div>
    </div>
  </div>
</section>