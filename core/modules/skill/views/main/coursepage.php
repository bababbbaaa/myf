<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\helpers\UrlHelper;

$guest = Yii::$app->user->isGuest;

$this->title = $cource->name;

$js = <<<JS
//таймер;
  function getTimeRemaining(endtime) {
    var t = Date.parse(endtime) - Date.parse(new Date());
    var minutes = Math.floor((t / 1000 / 60) % 60);
    var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
    var days = Math.floor(t / (1000 * 60 * 60 * 24));
    return {
      'total': t,
      'days': days,
      'hours': hours,
      'minutes': minutes
    };
  }

  function initializeClock(id, endtime) {
    var clock = document.getElementById(id);
    var daysSpan = clock.querySelector('.days');
    var hoursSpan = clock.querySelector('.hours');
    var minutesSpan = clock.querySelector('.minutes');

    function updateClock() {
      var t = getTimeRemaining(endtime);

      daysSpan.innerHTML = t.days;
      hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
      minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);

      if (t.total <= 0) {
        clearInterval(timeinterval);
      }
    };

    updateClock();
    var timeinterval = setInterval(updateClock, 1000);
  };

  var deadline = $("#countdown").attr("data-time");
  initializeClock('countdown', deadline);

  // Таймер конец
JS;
$this->registerJs($js);
$author = $cource->author;
?>
<main class="main">
    <section class="cp-s1">
        <div class="container">
            <a href="<?= !empty($_GET['back']) ? Url::to([$_GET['back']]) : Url::to(['/skill']) ?>"
               class="cp-s1__nav">
                Вернуться к каталогу
                <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M7.37361 12.5401C6.98309 12.9306 6.34992 12.9306 5.9594 12.5401L0.626065 7.20678C0.235541 6.81626 0.235541 6.18309 0.626065 5.79257L5.9594 0.459234C6.34992 0.0687095 6.98309 0.0687096 7.37361 0.459234C7.76414 0.849758 7.76414 1.48292 7.37361 1.87345L3.74739 5.49967L14.6665 5.49967C15.2188 5.49967 15.6665 5.94739 15.6665 6.49967C15.6665 7.05196 15.2188 7.49967 14.6665 7.49967L3.74739 7.49967L7.37361 11.1259C7.76414 11.5164 7.76414 12.1496 7.37361 12.5401Z"
                          fill="#5C687E"/>
                </svg>
            </a>
            <div class="cp-s1__inner">
                <div class="cp-s1__content">
                    <div class="cp-s1__box">
                        <!--            <span class="cp-s1__info">Включает программу трудоустройства</span>-->
                        <span class="cp-s1__info">Официальный партнер FemidaForce</span>
                    </div>
                    <h1 class="cp-s1__title">
                        <?= $cource->name ?>
                    </h1>

          <p class="cp-s1__text">
            <?= $cource->content_subtitle ?>
          </p>
          <div class="cp-s1__links">
            <?php if ($guest) : ?>
              <a href="<?= Url::to(['/registr']) ?>" class="cp-s1__btn btn">
                Записаться
              </a>
            <?php else : ?>
              <a href="<?= Url::to('https://user.myforce.ru/') ?>" class="cp-s1__btn btn">
                Записаться
              </a>
            <?php endif; ?>

            <a href="#cp-s5" class="cp-s1__link link">
              Посмотреть программу
              <svg width="14" height="16" viewBox="0 0 14 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M13.0406 8.6259C13.4311 9.01643 13.4311 9.64959 13.0406 10.0401L7.70727 15.3734C7.31675 15.764 6.68358 15.764 6.29306 15.3734L0.959723 10.0401C0.569198 9.64959 0.569198 9.01642 0.959723 8.6259C1.35025 8.23538 1.98341 8.23538 2.37394 8.6259L6.00016 12.2521L6.00016 1.33301C6.00016 0.780723 6.44788 0.333008 7.00016 0.333008C7.55245 0.333008 8.00016 0.780723 8.00016 1.33301L8.00016 12.2521L11.6264 8.6259C12.0169 8.23538 12.6501 8.23538 13.0406 8.6259Z" fill="#4135F1" />
              </svg>
            </a>
          </div>
        </div>

        <div class="cp-s1__img">
          <img src="<?= UrlHelper::admin($author->photo) ?>" alt="фото преподователя курса" />

          <div class="cp-s1__post">
            <p class="cp-s1__name">
              <?= $author->name ?>
            </p>

            <p class="cp-s1__position">
              <?= $author->small_description ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="cp-s2">
    <div class="container">
      <div class="cp-s2__inner">
        <div class="cp-s2__content">
          <h2 class="cp-s2__title title">
            О курсе
          </h2>

          <div class="cp-s2__text">
            <p>
              <?= $cource->content_about ?>
            </p>
          </div>
          <div class="cp-s2__nav">
            <?php $tags = explode(';', $cource->content_block_tags) ?>
            <?php foreach ($tags as $k => $v) : ?>
              <?php if (strlen($v) > 0) : ?>
                <span class="cp-s2__item <?= $k === 0 ? 'active' : '' ?>"><?= $v ?></span>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>

        <?php if (!empty($cource->content_block_income)): ?>
            <div class="cp-s2__box">
              <div class="cp-s2__column">
                <span class="cp-s2__price"><?= number_format(strip_tags($cource->content_block_income), 0, ' ', ' ') ?> ₽</span>
                <p class="cp-s2__info"><?= $cource->content_block_description ?></p>
                <!--                        <a href="#" class="cp-s2__link link">-->
                <!--                            Почитать о профессии в блоге-->
                <!--                        </a>-->
              </div>
            </div>
        <?php endif; ?>
      </div>

      <div class="cp-s2__for">
        <h2 class="cp-s2__for-title title">
          Кому подойдет курс
        </h2>
        <div class="cp-s2__for-wrap">
          <?php $forWho = json_decode($cource->content_for_who, true) ?>
          <?php foreach ($forWho as $k => $v) : ?>
            <article class="cp-s2__for-item">
              <div class="cp-s2__for-inner">
                <h3 class="cp-s2__for-article">
                  <?= $v['title'] ?>
                </h3>
                <p class="cp-s2__for-text">
                  <?= $v['text'] ?>
                </p>
              </div>
            </article>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <section class="cp-s3">
    <div class="container">
      <h2 class="cp-s3__title title">
        Чему вы научитесь
      </h2>
      <div class="cp-s3__inner">
        <?php $stady = json_decode($cource->content_what_study, true) ?>

        <?php foreach ($stady as $k => $v) : ?>
          <div class="cp-s3__item">
            <div class="cp-s3__content cp-s3__content--<?= $k ?>">
              <p class="cp-s3__article">
                <?= $v['title'] ?>
              </p>
              <p class="cp-s3__text">
                <?= $v['text'] ?>
              </p>
            </div>
          </div>
        <?php endforeach; ?>

      </div>

      <h2 class="cp-s3__title title">
        Как проходит обучение
      </h2>
      <div class="cp-s3__wrap">
        <div class="cp-s3__wrap-item">
          <div class="cp-s3__wrap-content cp-s3__wrap-content--1">
            <p class="cp-s3__wrap-title">
              Изучаете тему
            </p>
            <p class="cp-s3__wrap-text">
              Практические видео уроки, лекции, материалы
            </p>
          </div>
        </div>

        <div class="cp-s3__wrap-item">
          <div class="cp-s3__wrap-content cp-s3__wrap-content--2">
            <p class="cp-s3__wrap-title">
              Выполняете задания
            </p>
            <p class="cp-s3__wrap-text">
              Тесты и модульные работы с обратной связью от эксперта
            </p>
          </div>
        </div>

        <div class="cp-s3__wrap-item">
          <div class="cp-s3__wrap-content cp-s3__wrap-content--3">
            <p class="cp-s3__wrap-title">
              Работаете с преподавателями
            </p>
            <p class="cp-s3__wrap-text">
              Групповые и личные консультации
            </p>
          </div>
        </div>

        <div class="cp-s3__wrap-item">
          <div class="cp-s3__wrap-content cp-s3__wrap-content--4">
            <p class="cp-s3__wrap-title">
              Выполняете дипломную работу
            </p>
            <p class="cp-s3__wrap-text">
              Итоговая работа станет вашим первым кейсом для портфолио
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php
  $cookieName = "CourseCookie{$cource->id}";
  if (empty($_COOKIE[$cookieName])) {
    $countStudent = rand(100, 200) + $cource->students;
    setcookie($cookieName, $countStudent, time() + 3600 * 24 * 30 * 12 * 10);
  }
  $reviews = $cource->skillReviewsAboutTrainings;
  $countPeople = count($reviews);

  if ($countPeople < 5 && $countPeople != 1) {
    $textPeople = 'человека';
  } else {
    $textPeople = 'человек';
  }
  ?>
  <section class="cp-s4">
    <div class="container">
      <h2 class="cp-s4__title title title--center">
        Курс
        прошли <?= !empty($_COOKIE[$cookieName]) ? $_COOKIE[$cookieName] : $countStudent ?> <?= $textPeople ?>
      </h2>
      <div class="cp-s4__slider">
        <?php foreach ($reviews as $k => $v) : ?>
          <div class="cp-s4__coments coments">
            <div class="coments__inner">
              <div class="coments__nik">
                <div class="coments__avatar">
                  <img src="<?= UrlHelper::admin($v['photo']) ?>" alt="фото" class="coments__img">
                </div>
                <div class="coments__info">
                  <p class="coments__name">
                    <?= $v['name'] ?>
                  </p>
                  <p class="coments__bal">
                    Балл на курсе: <span><?= $v['grade'] ?></span>
                  </p>
                </div>
              </div>

              <p class="coments__text">
                <?= $v['content'] ?>
              </p>

              <time class="coments__data" datetime="2020-11-23">
                <?= date('d.m.Y', strtotime($v['date'])) ?>
              </time>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <article class="cp-s4__authors">
        <div class="cp-s4__inner">
          <div class="cp-s4__avatars">
            <div class="cp-s4__img"><img src="<?= Url::to(['/img/author-1.webp']) ?>" alt="фото автора">
            </div>
            <div class="cp-s4__img"><img src="<?= Url::to(['/img/author-2.webp']) ?>" alt="фото автора">
            </div>
            <div class="cp-s4__img"><img src="<?= Url::to(['/img/author-3.webp']) ?>" alt="фото автора">
            </div>
            <div class="cp-s4__img"><img src="<?= Url::to(['/img/author-4.webp']) ?>" alt="фото автора">
            </div>
            <div class="cp-s4__img"><img src="<?= Url::to(['/img/author-5.webp']) ?>" alt="фото автора">
            </div>
            <div class="cp-s4__img"><img src="<?= Url::to(['/img/author-6.webp']) ?>" alt="фото автора">
            </div>
          </div>

          <div class="cp-s4__content">
            <h2 class="cp-s4__auathor-title title">
              Кто авторы?
            </h2>
            <p class="cp-s4__text">
              В создании курса участвует вся команда SKILL.FORCE: маркетологи, аналитики, директологи,
              таргетологи,
              дизайнеры,
              менеджеры, разработчики. Качественный продукт всегда делается командой!
            </p>
            <?php if ($guest) : ?>
              <a href="<?= Url::to(['/registr']) ?>" class="cp-s4__btn btn btn--blue">
                Записаться на курс
              </a>
            <?php else : ?>
              <a href="<?= Url::to('https://user.myforce.ru/') ?>" class="cp-s4__btn btn btn--blue">
                Записаться на курс
              </a>
            <?php endif; ?>
          </div>
        </div>
      </article>

      <article class="cp-s4__speaker">
        <div class="cp-s4__speaker-wrap">
          <div class="cp-s4__speaker-content">
            <h2 class="cp-s4__speaker-name title">
              <?= $author->name ?>
            </h2>
            <p class="cp-s4__subtitle">
              <?= $author->small_description ?>
            </p>
            <div class="cp-s4__text">
              <?= $author->about ?>
            </div>

            <ul class="cp-s4__list">
              <span>Специализация:</span>
              <?php $specs = json_decode($author->specs, true) ?>
              <?php foreach ($specs as $v) : ?>
                <li class="cp-s4__li"><?= $v ?></li>
              <?php endforeach; ?>
            </ul>
          </div>

          <div class="cp-s4__speaker-too">
            <div class="cp-s4__speaker-img">
              <img src="<?= UrlHelper::admin($author->photo) ?>" alt="фото спикера" />
            </div>
            <a href="<?= Url::to(['teacher', 'link' => $author->link, 'back' => $_GET['link']]) ?>" class="cp-s4__link link">
              Страница автора
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6264 3.95891C11.0169 3.56838 11.6501 3.56838 12.0406 3.95891L17.3739 9.29224C17.7645 9.68277 17.7645 10.3159 17.3739 10.7065L12.0406 16.0398C11.6501 16.4303 11.0169 16.4303 10.6264 16.0398C10.2359 15.6493 10.2359 15.0161 10.6264 14.6256L14.2526 10.9993H3.3335C2.78121 10.9993 2.3335 10.5516 2.3335 9.99935C2.3335 9.44706 2.78121 8.99935 3.3335 8.99935H14.2526L10.6264 5.37312C10.2359 4.9826 10.2359 4.34943 10.6264 3.95891Z" fill="#4135F1" />
              </svg>
            </a>
          </div>
        </div>
      </article>
    </div>
  </section>

  <section id="cp-s5" class="cp-s5">
    <div class="cp-s5__top">
      <div class="container">
        <div class="cp-s5__inner">
          <h2 class="cp-s5__title title">
            Программа курса
          </h2>

          <div class="cp-s5__content">
            <p class="cp-s5__text">
              Вас ждут 6 блоков с разным уровнем сложности, онлайн-лекции и практические задания
            </p>
            <p class="cp-s5__info">
              <span><?= $cource->study_hours ?></span>
              <?php
              if ($cource->study_hours < 2) {
                $countsTime = 'час';
              } elseif ($cource->study_hours < 5) {
                $countsTime = 'часа';
              } else {
                $countsTime = 'часов';
              }
              ?>
              <?= $countsTime ?> обучения
            </p>
            <p class="cp-s5__info">
              <span><?= $cource->lessons_count ?></span>
              <?php
              if ($cource->lessons_count < 2) {
                $countsLesson = 'урок';
              } elseif ($cource->lessons_count < 5) {
                $countsLesson = 'урока';
              } else {
                $countsLesson = 'уроков';
              }
              ?>
              <?= $countsLesson ?>
            </p>
          </div>
        </div>
      </div>
    </div>

    <!--        Получаем параметры блоков       -->
    <?php $block = $cource->skillTrainingsBlocks ?>
    <!--        Получаем параметры блоков       -->

    <!--        Получаем параметры уроков       -->
    <?php $lesson = $cource->skillTrainingsLessons ?>
    <!--        Получаем параметры уроков       -->
    <div class="cp-s5__tabs">
      <?php foreach ($block as $k => $v) : ?>
        <div class="cp-s5__tab">
          <div class="container">
            <h3 class="cp-s5__tab-title">
              <?= $k + 1 ?>. <?= $v['name'] ?>
              <svg width="54" height="54" viewBox="0 0 54 54" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g filter="url(#filter0_d)">
                  <circle cx="27" cy="27" r="15" fill="#D1DDEE" fill-opacity="0.82" />
                  <path d="M21.9434 24.0205C21.6296 23.7067 21.1208 23.7067 20.807 24.0205C20.4932 24.3343 20.4932 24.8431 20.807 25.1569L26.1641 30.5141C26.478 30.8279 26.9867 30.8279 27.3006 30.5141L32.6577 25.1569C32.9715 24.8431 32.9715 24.3343 32.6577 24.0205C32.3439 23.7067 31.8351 23.7067 31.5213 24.0205L26.7324 28.8094L21.9434 24.0205Z" fill="#5C687E" />
                </g>
                <defs>
                  <filter id="filter0_d" x="0" y="0" width="54" height="54" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                    <feFlood flood-opacity="0" result="BackgroundImageFix" />
                    <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" />
                    <feOffset />
                    <feGaussianBlur stdDeviation="6" />
                    <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.04 0" />
                    <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow" />
                    <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow" result="shape" />
                  </filter>
                </defs>
              </svg>

            </h3>
            <div class="cp-s5__tab-content">
              <?= $v['small_description'] ?>
              <ul class="cp-s5__tab-list">
                <?php foreach ($lesson as $key => $value) : ?>
                  <?php if ($value['block_id'] === $v['id']) : ?>
                    <li class="cp-s5__tab-item"><?= $key + 1 ?>. <?= $value['name'] ?></li>
                  <?php endif; ?>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="cp-s5__bootom">
      <div class="container">
        <p class="cp-s5__bootom-text">
          Подробную программу можно посмотреть в личном кабинете
        </p>

        <?php if ($guest) : ?>
          <a href="<?= Url::to(['/registr']) ?>" class="cp-s5__link link">
            Посмотреть программу
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6264 3.95891C11.0169 3.56838 11.6501 3.56838 12.0406 3.95891L17.3739 9.29224C17.7645 9.68277 17.7645 10.3159 17.3739 10.7065L12.0406 16.0398C11.6501 16.4303 11.0169 16.4303 10.6264 16.0398C10.2359 15.6493 10.2359 15.0161 10.6264 14.6256L14.2526 10.9993H3.3335C2.78121 10.9993 2.3335 10.5516 2.3335 9.99935C2.3335 9.44706 2.78121 8.99935 3.3335 8.99935H14.2526L10.6264 5.37312C10.2359 4.9826 10.2359 4.34943 10.6264 3.95891Z" fill="#4135F1" />
            </svg>
          </a>
        <?php else : ?>
          <a href="<?= Url::to('https://user.myforce.ru/') ?>" class="cp-s5__link link">
            Посмотреть программу
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6264 3.95891C11.0169 3.56838 11.6501 3.56838 12.0406 3.95891L17.3739 9.29224C17.7645 9.68277 17.7645 10.3159 17.3739 10.7065L12.0406 16.0398C11.6501 16.4303 11.0169 16.4303 10.6264 16.0398C10.2359 15.6493 10.2359 15.0161 10.6264 14.6256L14.2526 10.9993H3.3335C2.78121 10.9993 2.3335 10.5516 2.3335 9.99935C2.3335 9.44706 2.78121 8.99935 3.3335 8.99935H14.2526L10.6264 5.37312C10.2359 4.9826 10.2359 4.34943 10.6264 3.95891Z" fill="#4135F1" />
            </svg>
          </a>
        <?php endif; ?>
      </div>
    </div>
  </section>

  <?php if ($cource->discount > 0) : ?>
    <section class="cp-s6">
      <div class="container">
        <div class="cp-s6__inner">
          <div class="cp-s6__cards">
            <div class="cp-s6__card">
              <span class="cp-s6__sale">-<?= $cource->discount ?>%</span>
              <p class="cp-s6__info">
                Стоимость обучения
              </p>
              <?php
              $sale = $cource->price * (100 - $cource->discount) / 100;
              ?>
              <p class="cp-s6__old-price"><?= $cource->price ?></p>
              <p class="cp-s6__price"><?= number_format(strip_tags($sale), 0, 0, ' ') ?>
                ₽
              </p>
              <div class="cp-s6__sale-end">
                До конца скидки
                <span id="countdown" class="countdown" data-time="<?= date('Y-m-d', strtotime($cource->discount_expiration_date)) ?>">
                  <span class="countdown-number">
                    <span class="days countdown-time"></span>
                    <span class="countdown-text">д</span>
                  </span>
                  <span class="countdown-number">
                    <span class="hours countdown-time"></span>
                    <span class="countdown-text">ч</span>
                  </span>
                  <span class="countdown-number">
                    <span class="minutes countdown-time"></span>
                    <span class="countdown-text">м</span>
                  </span>
                </span>
              </div>
            </div>
            <div class="cp-s6__img">
              <img src="<?= Url::to(['/img/plan.webp']) ?>" alt="лого банка" />
            </div>
          </div>

          <div class="cp-s6__content">
            <h2 class="cp-s6__title title">
              Условия обучения
            </h2>
            <p class="cp-s6__subtitle">
              <?= $cource->content_terms ?>
            </p>
            <p class="cp-s6__text">
              Для записи на курс пройдите регистрацию в личном кабинете
            </p>
            <?php if ($guest) : ?>
              <a href="<?= Url::to(['/registr']) ?>" class="cp-s6__btn btn btn--arrow-blue">
                Хочу учиться
              </a>
            <?php else : ?>
              <a href="<?= Url::to('https://user.myforce.ru/') ?>" class="cp-s6__btn btn btn--arrow-blue">
                Хочу учиться
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php if (!empty($moreCource)) : ?>
    <section class="cp-s7">
      <div class="container">
        <h2 class="cp-s7__title title">
          Другие курсы <br> от <span>преподавателя</span>
        </h2>
        <div class="cp-s7__inner">
          <?php foreach ($moreCource as $k => $v) : ?>
            <div class="cp-s7__item">
              <div class="cp-s7__img">
                <img src="<?= Url::to([$v['preview_logo']]) ?>" alt="фото курса" />
              </div>
              <p class="cp-s7__text">
                <?= $v['name'] ?>
              </p>
              <a href="<?= Url::to(['coursepage', 'link' => $v['link']]) ?>" class="cp-s7__link link">
                Подробнее о курсе
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6264 3.95891C11.0169 3.56838 11.6501 3.56838 12.0406 3.95891L17.3739 9.29224C17.7645 9.68277 17.7645 10.3159 17.3739 10.7065L12.0406 16.0398C11.6501 16.4303 11.0169 16.4303 10.6264 16.0398C10.2359 15.6493 10.2359 15.0161 10.6264 14.6256L14.2526 10.9993H3.3335C2.78121 10.9993 2.3335 10.5516 2.3335 9.99935C2.3335 9.44706 2.78121 8.99935 3.3335 8.99935H14.2526L10.6264 5.37312C10.2359 4.9826 10.2359 4.34943 10.6264 3.95891Z" fill="#4135F1" />
                </svg>
              </a>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>


</main>