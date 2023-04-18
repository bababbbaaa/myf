<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\helpers\UrlHelper;


$this->title = 'Онлайн-обучение востребованным навыкам';
$guest = Yii::$app->user->isGuest;
$js = <<<JS
var windowWidth = $(window).width();
if (windowWidth <= 480) {
  $(".he-s4__item").css('background-image','none');
}
JS;
$this->registerJs($js);
?>
<main class="main">
  <section class="he-s1">
    <div class="container">
      <div class="he-s1__inner">
        <h1 class="he-s1__title">
          Онлайн-обучение востребованным навыкам
        </h1>
        <a href="<?= Url::to(['profession']) ?>" class="he-s1__btn btn btn--arrow-blue">
          Подобрать курс
        </a>
      </div>
    </div>
  </section>

  <section class="he-s2">
    <div class="container">
      <h2 class="he-s2__title title">
        Чему можно научиться в SKILL.FORCE
      </h2>
      <p class="he-s2__subtitle">
        Научитесь новому. Смените профессию. Найдите свое призвание.
      </p>
      <div class="he-s2__inner">
        <?php foreach ($category as $k => $v) : ?>
          <?php if ($v->skillTrainingsCount > 0) : ?>
            <a href="<?= Url::to(['profession', 'direction' => $v['id']]) ?>" class="he-s2__item-link">
              <div class="he-s2__item">
                <div class="he-s2__item-content he-s2__item-content--<?= $k + 1 ?>">
                  <p class="he-s2__item-title">
                    <?= $v->name ?>
                  </p>
                  <p class="he-s2__item-text">
                    <?php if ($v->skillTrainingsCount == 1) : ?>
                      <?= $v->skillTrainingsCount ?> курс
                    <?php elseif ($v->skillTrainingsCount == 0) : ?>
                      Нет курсов
                    <?php elseif ($v->skillTrainingsCount < 5) : ?>
                      <?= $v->skillTrainingsCount ?> курса
                    <?php else : ?>
                      <?= $v->skillTrainingsCount ?> курсов
                    <?php endif; ?>
                  </p>
                </div>
              </div>
            </a>
          <?php endif; ?>
        <?php endforeach; ?>

        <div class="he-s2__span">
          <div class="he-s2__span-content">
            <h3 class="he-s2__span-title">
              Не знаете какой выбрать?
            </h3>
            <p class="he-s2__span-subtitle">
              Пройдите тест и узнайте, какая профессия вам подходит
            </p>
            <a href="<?= Url::to(['test']) ?>" class="he-s2__span-btn btn btn--arrow">
              Пройти тест
            </a>
          </div>
        </div>
      </div>

    </div>
  </section>

  <div class="he-s3">
    <div class="container">
      <div class="he-s3__inner">
        <div class="he-s3__content">
          <h2 class="he-s3__title title">
            Прокачайтесь за 1 день
          </h2>
          <a href="<?= Url::to(['intensive']) ?>" class="he-s3__btn btn btn--y btn--arrow-y">
            Узнать больше
          </a>
        </div>
        <ul class="he-s3__list">
          <li class="he-s3__item">Интенсивы</li>
          <li class="he-s3__item">Вебинары</li>
          <li class="he-s3__item">Лекции в записи</li>
        </ul>
      </div>
    </div>
  </div>

  <?php if (!empty($courses)) : ?>
    <section class="he-s4">
      <div class="container">
        <div class="he-s4__top">
          <div class="he-s4__content">
            <h2 class="he-s4__title title">
              Популярные курсы
            </h2>
            <p class="he-s4__subtitle">
              Выбор сотен людей, которые уже нашли свое призвание
            </p>
          </div>
          <a href="<?= Url::to(['profession']) ?>" class="he-s4__link link">
            Все курсы
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6264 3.95891C11.0169 3.56838 11.6501 3.56838 12.0406 3.95891L17.3739 9.29224C17.7645 9.68277 17.7645 10.3159 17.3739 10.7065L12.0406 16.0398C11.6501 16.4303 11.0169 16.4303 10.6264 16.0398C10.2359 15.6493 10.2359 15.0161 10.6264 14.6256L14.2526 10.9993H3.3335C2.78121 10.9993 2.3335 10.5516 2.3335 9.99935C2.3335 9.44706 2.78121 8.99935 3.3335 8.99935H14.2526L10.6264 5.37312C10.2359 4.9826 10.2359 4.34943 10.6264 3.95891Z" fill="#4135F1" />
            </svg>
          </a>
        </div>

        <div class="he-s4__inner">
          <?php foreach ($courses as $k => $v) : ?>
            <?php if ($k == 0) : ?>
              <a href="<?= Url::to(['coursepage', 'link' => $v['link']]) ?>" class="he-s4__item-link">
                <div class="he-s4__item he-s4__item--1">
                  <div class="he-s4__item-img">
                    <img src="<?= UrlHelper::admin($v['preview_logo']) ?>" alt="logo" />
                  </div>
                  <div class="he-s4__content he-s4__content--1">
                    <span class="he-s4__info he-s4__info--w">
                      <?= $v['type'] ?>

                    </span>
                    <h3 class="he-s4__item-title">
                      <?= $v['name'] ?>
                    </h3>
                    <span class="he-s4__num he-s4__num--w">
                      <?php if ($v['lessons_count'] == 1) : ?>
                        <?= $v['lessons_count'] ?> урок
                      <?php elseif ($v['lessons_count'] < 5) : ?>
                        <?= $v['lessons_count'] ?> урока
                      <?php else : ?>
                        <?= $v['lessons_count'] ?> уроков
                      <?php endif; ?>

                    </span>
                  </div>
                </div>
              </a>
            <?php elseif ($k == 1) : ?>
              <a href="<?= Url::to(['coursepage', 'link' => $v['link']]) ?>" class="he-s4__item-link">
                <div class="he-s4__item he-s4__item--2">
                  <div class="he-s4__item-img">
                    <img src="<?= UrlHelper::admin($v['preview_logo']) ?>" alt="logo" />
                  </div>
                  <div class="he-s4__content he-s4__content--2">
                    <span class="he-s4__info">
                      <?= $v['type'] ?>
                    </span>
                    <h3 class="he-s4__item-title">
                      <?= $v['name'] ?>
                    </h3>
                    <span class="he-s4__num">
                      <?php if ($v['lessons_count'] == 1) : ?>
                        <?= $v['lessons_count'] ?> урок
                      <?php elseif ($v['lessons_count'] < 5) : ?>
                        <?= $v['lessons_count'] ?> урока
                      <?php else : ?>
                        <?= $v['lessons_count'] ?> уроков
                      <?php endif; ?>
                    </span>
                  </div>
                </div>
              </a>
            <?php elseif ($k == 2) : ?>
              <a href="<?= Url::to(['coursepage', 'link' => $v['link']]) ?>" class="he-s4__item-link">
                <div class="he-s4__item he-s4__item--3">
                  <div class="he-s4__item-img">
                    <img src="<?= UrlHelper::admin($v['preview_logo']) ?>" alt="logo" />
                  </div>
                  <div class="he-s4__content he-s4__content--3">
                    <span class="he-s4__info">
                      <?= $v['type'] ?>
                    </span>
                    <h3 class="he-s4__item-title">
                      <?= $v['name'] ?>
                    </h3>
                    <span class="he-s4__num">
                      <?php if ($v['lessons_count'] == 1) : ?>
                        <?= $v['lessons_count'] ?> урок
                      <?php elseif ($v['lessons_count'] < 5) : ?>
                        <?= $v['lessons_count'] ?> урока
                      <?php else : ?>
                        <?= $v['lessons_count'] ?> уроков
                      <?php endif; ?>
                    </span>
                  </div>
                </div>
              </a>
            <?php elseif ($k == 3) : ?>
              <a href="<?= Url::to(['coursepage', 'link' => $v['link']]) ?>" class="he-s4__item-link">
                <div class="he-s4__item he-s4__item--4">
                  <div class="he-s4__item-img">
                    <img src="<?= UrlHelper::admin($v['preview_logo']) ?>" alt="logo" />
                  </div>
                  <div class="he-s4__content he-s4__content--4">
                    <span class="he-s4__info he-s4__info--w">
                      <?= $v['type'] ?>
                    </span>
                    <h3 class="he-s4__item-title">
                      <?= $v['name'] ?>
                    </h3>
                    <span class="he-s4__num he-s4__num--w">
                      <?php if ($v['lessons_count'] == 1) : ?>
                        <?= $v['lessons_count'] ?> урок
                      <?php elseif ($v['lessons_count'] < 5) : ?>
                        <?= $v['lessons_count'] ?> урока
                      <?php else : ?>
                        <?= $v['lessons_count'] ?> уроков
                      <?php endif; ?>
                    </span>
                  </div>
                </div>
              </a>
            <?php endif; ?>
          <?php endforeach; ?>


        </div>
      </div>
    </section>
  <?php endif; ?>

  <div class="he-s5">
    <div class="container">
      <div class="he-s5__inner">
        <div class="he-s5__content">
          <p class="he-s5__title">
            SKILL.FORCE сделает вашу жизнь ярче
          </p>
          <p class="he-s5__text">
            Узнавайте больше и меняйте свою жизнь уже сегодня! Откройте для себя личный кабинет SKILL.FORCE
          </p>
        </div>
        <?php if ($guest) : ?>
          <a href="<?= Url::to(['/registr']) ?>" class="he-s5__btn btn btn--arrow-blue">
            Зарегистрироваться
          </a>
        <?php else : ?>
          <a href="<?= Url::to('https://user.myforce.ru/') ?>" class="he-s5__btn btn btn--arrow-blue">
            Войти в кабинет
          </a>
        <?php endif; ?>

      </div>
    </div>
  </div>

  <section class="he-s6">
    <div class="container">
      <?php if (!empty($bflCourses)) : ?>
        <h2 class="he-s6__title title">
          Онлайн-профессия за 30 дней
        </h2>
        <p class="he-s6__subtitle">
          Если вы хотите получить новую профессию, обратите внимание на наши обширные курсы, на которых
          обучение
          идет с
          нуля
        </p>
        <div class="he-s6__inner">
          <?php foreach ($bflCourses as $k => $v) : ?>
            <div class="he-s6__item">
              <a href="<?= Url::to(['coursepage', 'link' => $v['link']]) ?>" class="he-s6__link link">
                Подробнее о курсе
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6264 3.95891C11.0169 3.56838 11.6501 3.56838 12.0406 3.95891L17.3739 9.29224C17.7645 9.68277 17.7645 10.3159 17.3739 10.7065L12.0406 16.0398C11.6501 16.4303 11.0169 16.4303 10.6264 16.0398C10.2359 15.6493 10.2359 15.0161 10.6264 14.6256L14.2526 10.9993H3.3335C2.78121 10.9993 2.3335 10.5516 2.3335 9.99935C2.3335 9.44706 2.78121 8.99935 3.3335 8.99935H14.2526L10.6264 5.37312C10.2359 4.9826 10.2359 4.34943 10.6264 3.95891Z" fill="#4135F1" />
                </svg>
              </a>
              <div class="he-s6__img">
                <img src="<?= UrlHelper::admin($v['preview_logo']) ?>" alt="logo" />
              </div>
              <div class="he-s6__info">
                <span class="he-s6__teg teg-i"><?= $v['type'] ?></span>
                <?php $tags = explode(';', $v['tags']) ?>
                <?php foreach ($tags as $key => $value) : ?>
                  <?php if (strlen($value) > 0) : ?>
                    <span class="he-s6__teg <?= $key % 2 == 0 ? 'teg-b' : 'teg-s' ?>"><?= $value ?></span>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
              <h3 class="he-s6__item-title">
                <?= $v['name'] ?>
              </h3>
              <p class="he-s6__time">
                Старт <?= date('d.m.Y', strtotime($v['date_meetup'])) ?>
              </p>

              <?php if ($guest) : ?>
                <a href="<?= Url::to(['/registr']) ?>" class="he-s6__btn btn btn--blue">
                  Записаться
                </a>
              <?php else : ?>
                <a href="<?= Url::to('https://user.myforce.ru/') ?>" class="he-s6__btn btn btn--blue">
                  Войти
                </a>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <div class="he-s6__prof">
        <div class="he-s6__prof-content">
          <h2 class="he-s6__title title">
            Не можете выбрать курс?
          </h2>
          <p class="he-s6__prof-subtitle">
            Пройдите тест и узнайте профессию, которая вам подходит
          </p>
          <a href="<?= Url::to(['test']) ?>" class="he-s6__prof-btn btn btn--y btn--arrow-y">
            Пройти тест
          </a>
        </div>
      </div>
    </div>
  </section>

  <section class="he-s7">
    <div class="container">
      <h2 class="he-s7__title title">
        Преимущества учебы в SKILL.FORCE
      </h2>
      <p class="he-s7__subtitle">
        Наши знания по-настоящему полезны
      </p>
      <div class="he-s7__inner">
        <div class="he-s7__item">
          <span class="he-s7__num">
            30+
          </span>
          <p class="he-s7__text">
            качественных исследований проводится ежегодно. На их основе мы сознаем свои курсы
          </p>
        </div>

        <div class="he-s7__item">
          <span class="he-s7__num">
            12 938
          </span>
          <p class="he-s7__text">
            получили востребованные профессии и навыки и уже строят свою карьеру
          </p>
        </div>

        <div class="he-s7__item">
          <span class="he-s7__num">
            100%
          </span>
          <p class="he-s7__text">
            студентов с курсов с гарантированным трудоустройством работают по профессии
          </p>
        </div>

        <div class="he-s7__item">
          <span class="he-s7__num">
            70%
          </span>
          <p class="he-s7__text">
            занятий проходят в формате вебинара, вы можете общаться с преподавателем онлайн
          </p>
        </div>
      </div>

      <div class="he-s7__wrap">
        <div class="he-s7__box">
          <h4 class="he-s7__box-title">
            Постоянное сопровождение
          </h4>
          <p class="he-s7__box-text">
            С каждым участником курса лично общается куратор, также ведется живое общение со спикерами
            и студентами
            в мессенджерах
          </p>
        </div>
        <div class="he-s7__box2">
          <div class="he-s7__box-item">
            <h4 class="he-s7__box-title">
              Актуальная практика
            </h4>
            <p class="he-s7__box-text">
              Каждый урок закрепляется с помощью практического задания, которое напрямую связано с вашей
              будущей
              работой.
            </p>
          </div>

          <div class="he-s7__box-item">
            <p class="he-s7__box-info">
              Все <b>наши преподаватели</b> — практики в своем деле, каждый из них напрямую занимается
              делом, которое
              преподает.
            </p>
          </div>
        </div>
      </div>
      <div class="he-s7__links">
        <a href="<?= Url::to(['about']) ?>" class="he-s7__link link">
          О проекте
          <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6264 3.95891C11.0169 3.56838 11.6501 3.56838 12.0406 3.95891L17.3739 9.29224C17.7645 9.68277 17.7645 10.3159 17.3739 10.7065L12.0406 16.0398C11.6501 16.4303 11.0169 16.4303 10.6264 16.0398C10.2359 15.6493 10.2359 15.0161 10.6264 14.6256L14.2526 10.9993H3.3335C2.78121 10.9993 2.3335 10.5516 2.3335 9.99935C2.3335 9.44706 2.78121 8.99935 3.3335 8.99935H14.2526L10.6264 5.37312C10.2359 4.9826 10.2359 4.34943 10.6264 3.95891Z" fill="#4135F1" />
          </svg>
        </a>
      </div>
    </div>
  </section>

  <?php if (!empty($garantCources)) : ?>
    <section class="car-s4 he-s8">
      <div class="container">
        <h2 class="car-s4__title title">
          Курсы с гарантированным трудоустройством
        </h2>
        <p class="car-s4__subtitle">
          Мы поможем вам найти работу еще во время обучения
        </p>

        <div class="car-s4__inner">
          <?php foreach ($garantCources as $k => $v) : ?>
            <?php
            $lessons_count = $v['lessons_count'];
            $tags = explode(';', $v['tags']);
            ?>
            <div class="car-s4__item">
              <div class="car-s4__item-top">
                <span class="car-s4__prof">
                  Профессия
                </span>
                <span class="car-s4__time">
                  <?php if ($lessons_count == 1) : ?>
                    <?= $lessons_count ?> час
                  <?php elseif ($lessons_count < 5) : ?>
                    <?= $lessons_count ?> часа
                  <?php else : ?>
                    <?= $lessons_count ?> часов
                  <?php endif; ?>
                </span>
              </div>

              <h3 class="car-s4__item-title">
                <?= $v['name'] ?>
              </h3>
              <p class="car-s4__item-text">
                <?= $v['content_block_description'] ?>
              </p>

              <div class="car-s4__nav">
                <?php foreach ($tags as $key => $value) : ?>
                  <span class="car-s4__info <?= $key % 2 == 0 ? 'market' : '' ?>"><?= $value ?></span>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php if (!empty($videoReviews)) : ?>
    <section class="he-s9">
      <div class="container">
        <div class="he-s9__slider">
          <div class="he-s9__slider-item">
            <?php foreach ($videoReviews

              as $k => $v) : ?>
              <div class="he-s9__slider-inner">
                <div class="he-s9__slider-video">
                  <?php parse_str($newLink = parse_url($v['video'], PHP_URL_QUERY), $link); ?>
                  <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $link['v'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
                <div class="he-s9__slider-content">
                  <p class="he-s9__slider-title title">
                    <?= $v['title'] ?>
                  </p>
                  <p class="he-s9__slider-text">
                    <?= $v['small_description'] ?>
                  </p>
                </div>
              </div>
          </div>
        <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <?php if (!empty($authors)) : ?>
    <section class="he-s10">
      <div class="container">
        <h2 class="he-s10__title title">
          Сильная команда
        </h2>
        <p class="he-s10__subtitle">
          Наши лучшие преподаватели, которые помогут вам сделать первые шаги в вашей карьере
        </p>

        <div class="he-s10__inner">
          <?php foreach ($authors as $k => $v) : ?>
            <a href="<?= Url::to(['teacher', 'link' => $v['link']]) ?>" class="he-s10__item-link">
              <div class="he-s10__item">
                <div class="he-s10__img">
                  <img src="<?= UrlHelper::admin($v['photo']) ?>" alt="фото" />
                </div>
                <p class="he-s10__name">
                  <?= $v['name'] ?>
                </p>
                <p class="he-s10__info">
                  <?= $v['small_description'] ?>
                </p>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
  <?php endif; ?>

  <section class="he-s11__teacher">
    <div class="container">
      <div class="he-s11__teacher-inner">
        <div class="he-s11__teacher-img">
          <img src="<?= Url::to(['/img/he-s10-img.webp']) ?>" alt="фото" />
        </div>
        <div class="he-s11__teacher-content">
          <h2 class="he-s11__teacher-title title">
            Станьте преподавателем
          </h2>
          <p class="he-s11__teacher-text">
            Лучшие спикеры уже присоединились в SKILL.FORCE. Мы предоставляем удобные инструменты для
            проведения
            курсов. Делайте то,
            что вы любите со SKILL.FORCE!
          </p>
          <?php if ($guest) : ?>
            <a href="<?= Url::to(['/registr']) ?>" class="he-s11__btn btn btn--blue">
              Присоединиться к проекту
            </a>
          <?php else : ?>
            <a href="<?= Url::to('https://user.myforce.ru/') ?>" class="he-s11__btn btn btn--blue">
              Войти в кабинет
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>

</main>