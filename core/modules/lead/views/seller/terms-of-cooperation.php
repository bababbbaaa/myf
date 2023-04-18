<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Условия сотрудничества';
$this->registerJsFile(Url::to(['/js/seller-range.js']), ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<body>
  <section class="CN__top top">
    <div class="container">
      <h1 class="CN__top-title top-title">
        Условия сотрудничества
      </h1>

      <h2 class="CN__top-subtitle top-subtitle">
        Давайте зарабатывать вместе
      </h2>
    </div>
  </section>

  <section class="CN__plus">
    <div class="container">
      <h3 class="CN__plus-title title title--center">
        Наши преимущества
      </h3>

      <p class="CN__plus-subtitle subtitle subtitle--center">
        Монетизируйте свой трафик уже сегодня
      </p>

      <div class="CN__plus-inner">
        <div class="CN__plus-item">
          <p class="CN__plus-text">
            Прямой рекламодатель
          </p>
        </div>

        <div class="CN__plus-item CN__plus-item--speed">
          <p class="CN__plus-text">
            Быстрые выплаты
          </p>
        </div>

        <div class="CN__plus-item CN__plus-item--apruv">
          <p class="CN__plus-text">
            Стабильный апрув
          </p>
        </div>

        <div class="CN__plus-item CN__plus-item--api">
          <p class="CN__plus-text">
            Готовое <br> API
          </p>
        </div>

        <div class="CN__plus-item CN__plus-item--cmr">
          <p class="CN__plus-text">
            Специальная CRM-cистема
          </p>
        </div>

        <div class="CN__plus-item CN__plus-item--center">
          <p class="CN__plus-text">
            Собственный колл-центр
          </p>
        </div>

        <div class="CN__plus-item CN__plus-item--meneger">
          <p class="CN__plus-text">
            Персональный менеджер
          </p>
        </div>

        <div class="CN__plus-item CN__plus-item--geo">
          <p class="CN__plus-text">
            Топовые <br> гео
          </p>
        </div>
      </div>
    </div>
  </section>

  <section class="CN__order">
    <div class="container">
      <h3 class="CN__order-title title">
        В вашем распоряжении
      </h3>

      <div class="CN__order-inner">
        <article class="CN__order-item">
          <h4 class="CN__order-article">
            Обширный функционал
          </h4>

          <p class="CN__order-text">
            Максимизируйте эффективность вашей работы с помощью полезных инструментов
          </p>
        </article>

        <article class="CN__order-item">
          <h4 class="CN__order-article">
            Прямой рекламодатель
          </h4>

          <p class="CN__order-text">
            Работайте с авторскими товарами, которые мы разрабатываем для вас
          </p>
        </article>

        <article class="CN__order-item">
          <h4 class="CN__order-article">
            Детальная аналитика
          </h4>

          <p class="CN__order-text">
            Получайте всю информацию о ходе ваших кампаний и повышайте их доходность
          </p>
        </article>
      </div>
    </div>
  </section>

  <section class="CN__cards">
    <div class="container">
      <div class="CN__cards-inner">
        <article class="CN__cards-box">
          <h3 class="CN__cards-title title">
            Веб-мастеру
          </h3>

          <ul class="CN__cards-list">
            <li class="CN__cards-item">
              Эксклюзивные офферы
            </li>

            <li class="CN__cards-item">
              Выплаты без задержек
            </li>

            <li class="CN__cards-item">
              Служба поддержки 24/7
            </li>
          </ul>

          <button class="CN__cards-btn btn showsCons">
            У меня есть трафик
          </button>
        </article>

        <article class="CN__cards-box">
          <h3 class="CN__cards-title title">
            Рекламодателю
          </h3>

          <ul class="CN__cards-list">
            <li class="CN__cards-item CN__cards-item--arrow">
              Помощь в запуске
            </li>

            <li class="CN__cards-item  CN__cards-item--arrow">
              Большой выбор видов лидов
            </li>

            <li class="CN__cards-item  CN__cards-item--arrow">
              Современная аналитика
            </li>
          </ul>

          <button class="CN__cards-btn btn btn--blue showsCons">
            Мне нужен трафик
          </button>
        </article>
      </div>
    </div>
  </section>

  <section class="CN__cpa">
    <div class="container">
      <div class="CN__cpa-inner">
        <div class="CN__cpa-content">
          <h2 class="CN__cpa-title title">
            В двух словах о LEAD.FORCE
          </h2>

          <p class="CN__text">
            <span>LEAD.FORCE</span> — это CPA сеть, созданная командой профессионалов. Благодаря большому опыту в сфере
            партнерского маркетинга,
            нам удалось разработать современную платформу, которая объединяет интересы веб-мастеров и рекламодателей
          </p>

            <a href="<?= Url::to(["/registr?site=lead"]);?>" class="CN__cpa-btn btn BLS6CBORID-BTN btnsbmtfc">
                Регистрация в проекте
            </a>
        </div>

        <div class="CN__cpa-img">
          <img src="<?= Url::to(['/img/cpa.webp']) ?>" alt="cpa" />
        </div>
      </div>
    </div>
  </section>

  <section class="By__Leads__Sec9">
    <div class="By__Leads__Sec9__content">
      <h3 class="TL_h8v">Рассчитайте свою прибыль<br> и закажите лиды прямо сейчас!</h3>
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
              <h4 class="TL_h8 TL_h8w number1">9,5%</h4>
            </div>

            <div class="lite__fix">
              <p class="TL_p8">Средняя стоимость лида</p>
              <h4 class="TL_h8 TL_h8w">500 рублей</h4>
            </div>
          </div>
          <div class="TL_inp9 flex fww">
            <h4 class="TL_h8 TL_h8 total">Ваша прибыль</h4>
            <input class="TL_inp9inp tac" type="text" id="result" disabled>
          </div>
        </div>
        <div class="TL_inp8-form">
          <p class="TL_inp8-form-title">
            Закажите лиды прямой сейчас!
          </p>
          <div class="TL_inp8-form-inner">
            <?= Html::beginForm(Url::to(['/site/form']), 'post', ['id' => 'form-TL_inp8']) ?>
            <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
            <input type="hidden" name="formType" value="Форма для получения 10 бесплатных лидов">
            <input type="hidden" name="pipeline" value="104">
              <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
              <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
            <input type="hidden" name="service" value="">
            <input type="hidden" name="section" value="Рассчитайте свою прибыль и закажите лиды прямо сейчас!">

            <input class="fcstlt TL_inp8-input" required placeholder="Сфера бизнеса" type="text" name="comments[sphere]" id="sphere2">
            <input type="text" required="required" class="TL_inp8-input region fcstlt" placeholder="Ваш регион" name="region" id="region2">
            <input class="fcstlt TL_inp8-input" required pattern="[0-9]*" placeholder="Количество лидов в день" type="text" name="comments[lead_day]" id="lids2">
              <?php if (Yii::$app->user->isGuest):?>
                  <a href="<?= Url::to(["/registr?site=lead"])?>" class="btnsbmtfc">Получить</a>
              <?php else:?>
                  <button class="btnsbmtfc" type="submit">Получить</button>
              <?php endif?>
            <?= Html::endForm(); ?>
          </div>
        </div>
      </div>
    </div>
  </section>