<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\helpers\UrlHelper;

$this->title = 'Начните зарабатывать на арбитраже трафика';
$js = <<< JS

        setTimeout(function() {
        $('#link_reload').attr("href","/lead/seller?").trigger("click");
    },100)
    $('.filter__form2').on('submit', function(e) {
        $('#link_reload').attr("href","/lead/seller?" + $(this).serialize()).trigger("click");
        e.preventDefault();
    });

    $('.filter__form').on('submit', function(e) {
        $('#link_reload').attr("href","/lead/seller?" + $(this).serialize()).trigger("click");
        e.preventDefault();
    });

    $('.reload__filter').on('click', function(e) {
        $('#link_reload').attr("href","/lead/seller?").trigger("click");
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
<section class="SL__top">
  <div class="container">
    <div class="SL__top-inner">
      <div class="SL__top-img">
        <img src="<?= Url::to(['/img/sl-top.webp']) ?>" alt="илюстраця" />
      </div>

      <div class="SL__top-content">
        <h1 class="SL__top-title top-title">
          Начните зарабатывать на арбитраже трафика
        </h1>

        <p class="SL__top-subtitle top-subtitle">
          Продавайте лиды на своих условиях
        </p>
        <a href="<?= Url::to(["/registr-provider?site=lead"]);?>" class=" SL__top-btn btn BLS6C-tu-bts btnsbmtfc">
            Зарегистрироваться
        </a>
      </div>
    </div>

    <div class="SL__top-box">
      <div class="SL__top-item">
        <p class="SL__top-text">
          С нами сотрудничают <span>485</span> рекламодателей
        </p>
      </div>

      <div class="SL__top-item">
        <p class="SL__top-text">
          Вчера один веб-мастер заработал <span>36 744</span> ₽
        </p>
      </div>

      <div class="SL__top-item item1">
        <p class="SL__top-text">
          В прошлом месяце веб-мастер заработал <span>509 900</span> ₽ на Ютубе
        </p>
      </div>
    </div>

  </div>
</section>

<section class="SL__cards">
  <div class="container">
    <h2 class="SL__cards-title title">
      Партнёрская сеть с авторскими офферами в сфере услуг
    </h2>

    <h3 class="SL__cards-subtitle subtitle">
      Широкий выбор актуальных офферов
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

<section class="SL__about">
  <div class="container">
    <h3 class="SL__about-title title">
      Почему выбирают нас?
    </h3>

    <p class="SL__about-subtitle subtitle">
      Абсолютно «прозрачные» эксклюзивные офферы по актуальным тематикам
    </p>
    <div class="SL__about-inner">
      <div class="SL__about-content">
        <div class="SL__about-cards">
          <div class="SL__about-card">
            <p class="SL__about-text SL__about-text--stabl">
              Стабильные еженедельные выплаты
            </p>
          </div>

          <div class="SL__about-card">
            <p class="SL__about-text SL__about-text--bonus">
              Система бонусов и премирования для лучших
            </p>
          </div>

          <div class="SL__about-card">
            <p class="SL__about-text SL__about-text--support">
              Оперативная техподдержка
            </p>
          </div>

          <div class="SL__about-card">
            <p class="SL__about-text SL__about-text--call">
              Собственный адаптивный call-центр 24/7
            </p>
          </div>

          <div class="SL__about-card">
            <p class="SL__about-text SL__about-text--account">
              Удобный интерфейс личного кабинета
            </p>
          </div>

          <div class="SL__about-card">
            <p class="SL__about-text SL__about-text--start">
              Легкий старт и высокий апрув
            </p>
          </div>
        </div>
      </div>

      <ul class="SL__about-list">
        <li class="SL__about-item">
          Личный менеджер станет как родной
        </li>

        <li class="SL__about-item">
          Учёт оформленных лидов
        </li>

        <li class="SL__about-item">
          Реферальная программа
        </li>

        <li class="SL__about-item">
          Подробная статистика по заявкам и источникам
        </li>

        <li class="SL__about-item">
          Нет ограничений по источникам трафика
        </li>
      </ul>
    </div>
  </div>
</section>

<section class="SL__suitable">
  <div class="container">
    <div class="SL__suitable-wrap">
      <div class="SL__suitable-content">
        <h3 class="SL__suitable-title title">
          Для кого подходит?
        </h3>

        <p class="SL__suitable-text">
          Зарабатывать с LEAD.FORCE может каждый. Для этого необязательно иметь раскрученный сайт или быть
          топовым
          блогером —
          рекомендуйте товары друзьям в Telegram, размещайте ссылки на странице Вконтакте или попробуйте себя
          в контекстной
          рекламе.
        </p>
      </div>

      <div class="SL__suitable-inner">
        <p class="SL__suitable-info">
          Веб-мастера LEAD.FORCE — это:
        </p>

        <div class="SL__suitable-box">
          <div class="SL__suitable-item">
            <p class="SL__suitable-plus SL__suitable-plus--site">
              Владельцы сайтов, сервисов сравнения цен, партнерских магазинов
            </p>
          </div>

          <div class="SL__suitable-item">
            <p class="SL__suitable-plus SL__suitable-plus--advertising">
              Арбитражники, которые занимаются контекстной и таргетированной рекламой
            </p>
          </div>

          <div class="SL__suitable-item">
            <p class="SL__suitable-plus SL__suitable-plus--blog">
              Начинающие и опытные блогеры и видеоблогеры
            </p>
          </div>

          <div class="SL__suitable-item">
            <p class="SL__suitable-plus SL__suitable-plus--social">
              Пользователи и владельцы групп в соцсетях, каналов в мессенджерах
            </p>
          </div>

          <div class="SL__suitable-item">
            <p class="SL__suitable-plus SL__suitable-plus--cashback">
              Кэшбэк-сервисы и программы лояльности
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="SL__partners">
      <h3 class="SL__partners-title title title--center">
        Топ партнеров
      </h3>

      <div class="SL__partners-inner">
        <div class="SL__partners-item">
          <span class="SL__partners-num">1</span>
          <span class="SL__partners-name">Веб-мастер</span>
          <span class="SL__partners-money">1 759 590 ₽</span>
        </div>

        <div class="SL__partners-item">
          <span class="SL__partners-num">2</span>
          <span class="SL__partners-name">Веб-мастер</span>
          <span class="SL__partners-money">1 283 880 ₽</span>
        </div>

        <div class="SL__partners-item">
          <span class="SL__partners-num">3</span>
          <span class="SL__partners-name">Веб-мастер</span>
          <span class="SL__partners-money">1 030 700 ₽</span>
        </div>

        <div class="SL__partners-item">
          <span class="SL__partners-num">4</span>
          <span class="SL__partners-name">Веб-мастер</span>
          <span class="SL__partners-money">980 992 ₽</span>
        </div>

        <div class="SL__partners-item">
          <span class="SL__partners-num">5</span>
          <span class="SL__partners-name">Веб-мастер</span>
          <span class="SL__partners-money">893 009 ₽</span>
        </div>

        <div class="SL__partners-item">
          <span class="SL__partners-num">6</span>
          <span class="SL__partners-name">Веб-мастер</span>
          <span class="SL__partners-money">720 838 ₽</span>
        </div>

        <div class="SL__partners-item">
          <span class="SL__partners-num">7</span>
          <span class="SL__partners-name">Веб-мастер</span>
          <span class="SL__partners-money">604 700 ₽</span>
        </div>

        <div class="SL__partners-item">
          <span class="SL__partners-num">8</span>
          <span class="SL__partners-name">Веб-мастер</span>
          <span class="SL__partners-money">548 903 ₽</span>
        </div>

        <div class="SL__partners-item">
          <span class="SL__partners-num">9</span>
          <span class="SL__partners-name">Веб-мастер</span>
          <span class="SL__partners-money">473 093 ₽</span>
        </div>

        <div class="SL__partners-item">
          <span class="SL__partners-num">10</span>
          <span class="SL__partners-name">Веб-мастер</span>
          <span class="SL__partners-money">398 748 ₽</span>
        </div>
      </div>

      <button class="SL__partners-btn btn btn--blue BLS6C-tu-bts showsCons">
        Стать партнером
      </button>
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
                <a href="<?= Url::to(["/registr-provider?site=lead"])?>" class="btnsbmtfc">Начать зарабатывать</a>
            <?php else:?>
                <button class="btnsbmtfc" type="submit">Начать зарабатывать</button>
            <?php endif?>
          <?= Html::endForm(); ?>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="SL__start">
  <h3 class="SL__start-title title">
    Начинаем лить трафик?
  </h3>
    <a href="<?= Url::to(["/registr-provider?site=lead"]);?>" class="SL__start-btn btn BLS6C-tu-bts btnsbmtfc">
        Зарегистрироваться
    </a>
</section>

<section class="SL__traffic">
  <div class="container">
    <div class="SL__traffic-content">
      <p class="SL__traffic-info">
        онлайн-курс
      </p>

      <h2 class="SL__traffic-title title">
        Хотите научиться лить трафик?
      </h2>

      <p class="SL__traffic-subtitle subtitle">
        Научиться арбитражу трафика, привлекать покупателей, составлять рекламные креативы и зарабатывать
        на этом
      </p>

      <button type="button" class="SL__traffic-btn btn showsCons">
        Подробнее о курсе
      </button>
    </div>
  </div>
</section>