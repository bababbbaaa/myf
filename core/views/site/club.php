<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Клуб MYFORCE";
?>

<section class="club-top">
  <div class="container">
    <h1 class="club-top__title">
      Клуб MYFORCE
    </h1>
    <h2 class="club-top__subtitle">
      Покупай больше, трать меньше вместе с MYFORCE!

    </h2>

    <div class="club-top__text">
      <p>Получай за каждую покупку <b>бонусный кэшбек</b> и обменивай его на приятные <b>скидки</b>.</p>
      <p>Бонусная карта, скидки и другие подарки доступны уже после первой покупки.</p>
    </div>

    <p class="club-top__subbtn">
      Успей принять участие и получить свой премиум статус!
    </p>
    <a href="<?= Url::to(['registr?site=lead']) ?>" class="club-top__btn btn">Получить Бонусную карту</a>
  </div>
</section>

<section class="club-plus">
  <div class="container">
    <h2 class="club-plus__title">
      Преимущества Клуба MYFORCE
    </h2>

    <div class="club-plus__inner">
      <div class="club-plus__item">
        <p class="club-plus__item-title">
          Преимиум
        </p>
        <span class="club-plus__item-subtitle">
          статус
        </span>
        <p class="club-plus__item-text">
          Премиум статус партнера - право пользоваться вечной скидкой на любые услуги
        </p>
      </div>

      <div class="club-plus__item">
        <p class="club-plus__item-title">
          Участие
        </p>
        <span class="club-plus__item-subtitle">
          в закрытых конференциях
        </span>
        <p class="club-plus__item-text">
          Получайте эксклюзивную информацию, а также новые профессиональные связи
        </p>
      </div>

      <div class="club-plus__item">
        <p class="club-plus__item-title">
          Скидка
        </p>
        <span class="club-plus__item-subtitle">
          на все продукты
        </span>
        <p class="club-plus__item-text">
          Копите баллы и получайте скидки на продукты любого сервиса MYFORCE
        </p>
      </div>

      <div class="club-plus__item">
        <p class="club-plus__item-title">
          Бонусы
        </p>
        <span class="club-plus__item-subtitle">
          увеличиваются
        </span>
        <p class="club-plus__item-text">
          Преимущества соразмерны количеству принадлежащих вам бонусов
        </p>
      </div>

      <div class="club-plus__item-big">
        <div class="club-plus__item-bigtext">
          <p>Каждый пользователь сервисов MYFORCE после регистарции автоматически становится участником бонусной программы, <b>+1000 р на баланс</b> при регистрации, которые вы сразу можете потратить на услуги и продукты.</p>
          <p>Вы можете получать бонусы за покупку различных услуг, а также стать участником Клуба MYFORCE и получить еще больше привилегий</p>
        </div>
      </div>

      <div class="club-plus__item-big">
        <div class="club-plus__item-bigtext">
          <p>Бонусы и бонусная программа доступна всем зарегистрированным пользователям.</p>
          <p><b>А с картой клуба вам доступно еще больше</b>, не только бонусы, но и баллы, которые вы можете накапливать на покупках услуг и тратить на все, что захотите</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="club-bonus">
  <div class="container">
    <h2 class="club-bonus__title">
      Бонусы сотрудничества с MYFORCE
    </h2>

    <div class="club-bonus__box">
      <div class="club-bonus__box-content">
        <ul class="club-bonus__box-list">
          <li class="club-bonus__box-item"><b>Кэшбэк</b>, который можно использовать как скидку</li>
          <li class="club-bonus__box-item"><b>Бонус — скрипт продаж</b> для эффективной работы</li>
          <li class="club-bonus__box-item"><b>Бесплатный доступ к курсу</b> продаж</li>
          <li class="club-bonus__box-item"><b>Автоинформирование</b> в телеграмм о новом лиде</li>
          <li class="club-bonus__box-item"><b>Персональный маркетолог</b> на ваш проект (консультации 24/7)</li>
          <li class="club-bonus__box-item"><b>Скидки на все наши услуги!</b></li>
        </ul>

        <a href=<?= Url::to(['registr?site=lead']) ?> class="club-bonus__box-btn btn">Получить Бонусную карту</a>
      </div>
    </div>
  </div>
</section>

<section class="club-card">
  <div class="container">
    <h2 class="club-card__title">
      Способ получения бонусной карты
    </h2>

    <div class="club-card__inner">
      <div class="club-card__item">
        <div class="club-card__item-content">
          <p class="club-card__item-title">
            Покупка <br> бонусной карты
          </p>
          <ul class="club-card__item-list">
            <li class="club-card__item-li">
              Регистрируйтесь на сайте и покупайте карту, а также получите 1000 рублей на баланс
            </li>
            <li class="club-card__item-li">
              Свяжитесь с менеджером и оформите карту удобным вам способом
            </li>
          </ul>
        </div>
      </div>

      <div class="club-card__item">
        <div class="club-card__item-content club-card__item-content--img1">
          <p class="club-card__item-title">
            Получение <br>бонусов
          </p>
          <ul class="club-card__item-list">
            <li class="club-card__item-li">
              Покупайте продукты сервисов майфорс
            </li>
            <li class="club-card__item-li">
              Участвуйте в мероприятиях и копите баллы
            </li>
          </ul>
        </div>
      </div>

      <div class="club-card__item">
        <div class="club-card__item-content club-card__item-content--img2">
          <p class="club-card__item-title">
            Использование <br>всех преимуществ
          </p>
          <ul class="club-card__item-list">
            <li class="club-card__item-li">
              Получайте любые услуги майфорс со скидкой до 50%
            </li>
            <li class="club-card__item-li">
              Пользуйтесть привилегиями партнера премиум статуса
            </li>
          </ul>
        </div>
      </div>
    </div>

    <a href="<?= Url::to(['registr?site=lead']) ?>" class="club-card__btn btn">Купить Бонусную карту</a>
  </div>
</section>

<section class="club-servese">
  <div class="container">
    <h2 class="club-servese__title">
      Наши сервисы и ваши бонусы
    </h2>

    <div class="club-servese__inner card">
      <article class="card__item card__item--pading">
        <a style="text-decoration: none" href="<?= Url::to(['femida/']) ?>"> </a>
        <div class="card__content">
          <div class="card__top">
            <h3 class="card__title  card__title--color">
              Франшиза
            </h3>

            <p class="card__subtitle  card__subtitle--color">
              FEMIDA.FORCE
            </p>
          </div>

          <p class="card__text">
            На проекте FEMIDA.FORCE мы предлагаем взаимовыгодное сотрудничество. Даже без опыта, с нуля вы сможете выстроить современный прибыльный бизнес с нашими юристами на аутсорсинге:
          </p>

          <ul class="card__list">
            <li class="card__list-item">
              Рассказываем, как правильно начать строить бизнес
            </li>
            <li class="card__list-item">
              Раскрываем секреты посторения бизнеса, которые вы нигде не найдете
            </li>
            <li class="card__list-item">
              Выгодные условия и множество преимуществ
            </li><!--
            <li class="card__list-item">
              Обучаем вас и ваших сотрудников на платформе SKILL.FORCE со скидками
            </li>-->
          </ul>
        </div>
      </article>

      <article class="card__item card__item--pading card__item--2">
        <a href="<?= Url::to(['lead/']) ?>" style="text-decoration: none"></a>
        <div class="card__content card__content--2">
          <div class="card__top">
            <h3 class="card__title  card__title--color">
              Для вашего <br>бизнеса
            </h3>

            <p class="card__subtitle  card__subtitle--color">
              ADS.FORCE
            </p>
          </div>

          <p class="card__text">
            Мы предлагаем широкий спектр услуг, который будет полезен для вашего бизнеса:
          </p>

          <ul class="card__list">
            <li class="card__list-item">
              Современный дизайн личных и корпоративных сайтов
            </li>
            <li class="card__list-item">
              Маркетологи и эффективная реклама
            </li>
            <li class="card__list-item">
              Создание и продвижение ваших соц. сетей
            </li>
            <li class="card__list-item">
              Услуги юристов, полное ведение клиента
            </li>
            <li class="card__list-item">
              Автоматизация бизнес-процессов
            </li>
            <li class="card__list-item">
              Воронки найма грамотных специалистов
            </li>
          </ul>
        </div>
      </article>

      <!--<article class="card__item card__item--pading card__item--3">
        <a href="<?/*= Url::to(['lead/']) */?>" style="text-decoration: none"></a>
        <div class="card__content card__content--3">
          <div class="card__top">
            <h3 class="card__title card__title--color">
              Обучение
            </h3>

            <p class="card__subtitle card__subtitle--color">
              SKILL.FORCE
            </p>
          </div>

          <p class="card__text">
            На нашем проекте SKILL.FORCE мы проводим эффективное современное обучение:
          </p>

          <ul class="card__list card__list--color">
            <li class="card__list-item card__list-item--white">
              Обучение от одного до команды менеджеров
            </li>
            <li class="card__list-item card__list-item--white">
              Эффективные технологии продажи и отработки возражений
            </li>
            <li class="card__list-item card__list-item--white">
              На практике отработка теории
            </li>
            <li class="card__list-item card__list-item--white">
              Обучение предпринимателей выстраивать прибыльный бизнес
            </li>
            <li class="card__list-item card__list-item--white">
              Грамотные методики отбора персонала
            </li>
          </ul>
        </div>
      </article>-->
    </div>
  </div>
</section>

<section class="club-ask">
  <div class="container">
    <h2 class="club-ask__title">
      Отвечаем на частые вопросы
    </h2>

    <div class="club-ask__inner">
      <div class="club-ask__content">
        <div class="club-ask__item">
          <p class="club-ask__query">
            Можно ли вернуть средства за бонусную карту?
          </p>
          <p class="club-ask__answer">
            Нет, эти средства не возвратные, но вы можете использовать бонусную карту преимуществом при сотрудничестве с нашей компанией по любым направлениям.
          </p>
        </div>

        <div class="club-ask__item">
          <p class="club-ask__query">
            Сгорают ли бонусы?
          </p>
          <p class="club-ask__answer">
            Бонусы несгораемые. Даже если по каким-то обстоятельствам вы вынуждены приостановить сотрудничество, ваши бонусы не сгорят за время паузы и мы продолжим наше сотрудничество
          </p>
        </div>

        <div class="club-ask__item">
          <p class="club-ask__query">
            На все категории услуг действуют бонусы?
          </p>
          <p class="club-ask__answer">
            Да, вы можете использовать свои бонусы как скидку на любые направления работы и продукты нашей компании, так же добавлять дополнительные проценты к отбраковке пакета лидов и запросить доступ курсу одному специалисту вашей компании.
          </p>
        </div>

        <div class="club-ask__item">
          <p class="club-ask__query">
            Можно ли заплатить бонусами 100% услуги?
          </p>
          <p class="club-ask__answer">
            Нет, оплатить бонусами вы можете только до 50% услуги.
          </p>
        </div>

        <div class="club-ask__item">
          <p class="club-ask__query">
            На сколько дается личный маркетолог?
          </p>
          <p class="club-ask__answer">
            Личный маркетолог общается с вами только пока действует ваш заказ
          </p>
        </div>

        <div class="club-ask__item">
          <p class="club-ask__query">
            На сколько мне дается доступ к скриптам?
          </p>
          <p class="club-ask__answer">
            Доступ к скртипам дается пожиненно
          </p>
        </div>

        <div class="club-ask__item">
          <p class="club-ask__query">
            На сколько мне дается доступ к курсу?
          </p>
          <p class="club-ask__answer">
            Доступ к курсу дается пожизненно
          </p>
        </div>

        <div class="club-ask__item">
          <p class="club-ask__query">
            Можно ли получить бонусную карту бесплатно?
          </p>
          <p class="club-ask__answer">
            Можно в двух случаях - при приобритении пакета лидов от 350шт, а так же в случае редкой промо-акции для постоянных клиентов
          </p>
        </div>

        <div class="club-ask__item">
          <p class="club-ask__query">
            Что такое «Автоинформирование о поступающих лидах»?
          </p>
          <p class="club-ask__answer">
            Автоиноформирования - это уведомления о новых поступающих заявках через индивидуальный телеграмм-бот на номер телефона, который вы самостоятельно указываете и можете менять
          </p>
        </div>

        <div class="club-ask__item">
          <p class="club-ask__query">
            Есть ли ограничение по количеству накапливаемых бонусов?
          </p>
          <p class="club-ask__answer">
            Нет, у вас не будет ограничений в накапливании бонусов, есть ограничение только на их максимально единовременное использование
          </p>
        </div>
      </div>
      <aside class="club-ask__aside">
        <div class="ar-1_sec-1_teleg-info">
          <img src="<?= Url::to(['img/mainimg/telegramm.svg']) ?>" alt="telegramm">
          <p class="ar-1_sec-1_teleg-info-ttl">Больше материалов в Telegram</p>
          <p class="ar-1_sec-1_teleg-info-t2">Никакого спама и рекламы, только лучшее для вашего бизнеса</p>
          <a class="telegrammBTN" href="<?= Url::to('https://t.me/myforce_business') ?>">Подписаться <img src="<?= Url::to(['img/mainimg/Arrow Right.svg']) ?>" alt="arrow"></a>
        </div>
      </aside>
    </div>
  </div>
</section>

<section class="club-form">
  <div class="container">
    <?= Html::beginForm('', 'post', ['class' => 'club-forms', 'id' => '']); ?>
      <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
      <input type="hidden" name="formType" value="Форма консультации">
      <input type="hidden" name="pipeline" value="104">
      <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
      <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
      <input type="hidden" name="service" value="">
      <input type="hidden" name="section" value="Остались вопросы?">
    <div class="club-form__inner club-form__innner--step1">
      <div class="club-form__content">
        <h2 class="club-form__title">
          Остались вопросы?
        </h2>
        <p class="club-form__subtitle">
          Вы можете оставить заявку и наш менеджер обязательно перезвонит вам.
        </p>
      </div>

      <div class="club-form__inputs">
        <label class="club-form__label">
          <span class="club-form__text">Ваше имя:</span>
          <input type="text" name="fio" class="club-form__input" required />
        </label>

        <label class="club-form__label">
          <span class="club-form__text">Номер телефона:</span>
          <input type="tel" name="phone" class="club-form__input" required />
        </label>

        <button type="sabmit" class="club-form__btn btn">Перезвоните мне</button>
      </div>
    </div>

    <div class="club-form__inner club-form__innner--step2">
      <div class="club-form__content">
        <h2 class="club-form__title">
          Благодарим за заявку!
        </h2>
        <p class="club-form__subtitle">
          Ожидайте звонка менеджера в течение 3 минут
        </p>
      </div>
    </div>
    <?= Html::endForm(); ?>
  </div>
</section>