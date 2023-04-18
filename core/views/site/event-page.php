<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = $event->name;


?>
<section class="article-1 article-1--ceys event__article">
    <div class="article_content">
        <nav class="breadcrumbs">
            <a class="article__nav-link event__nav-link" href="<?= Url::to(['/']) ?>">Главная</a>
            <img src="<?= Url::to(['img/mainimg/angle right.svg']) ?>" alt="arrow">
            <a class="article__nav-link event__nav-link" href="<?= Url::to(['site/events']) ?>">Мероприятия</a>
            <img src="<?= Url::to(['img/mainimg/angle right.svg']) ?>" alt="arrow">
            <a class="article__nav-link event__nav-link_active"><?= $event->name ?></a>
        </nav>
        <div class="article__header">
            <div class="info article__info event__info">
                <?php if (!empty($event->category)): ?>
                    <p class="article__category event__category"><?= $event->category ?></p>
                <?php endif; ?>
                <h1 class="article__name event__name event_color_white"><?= $event->name ?></h1>
                <div class="activity__item-box">
                    <?php if (!empty($event->event_finish_date)): ?>
                        <span class="activity__item-span article__date article__place event__place event_color_white event__date">
                              <?php
                              $startDate = $event->event_date;
                              $finishDate = $event->event_finish_date;
                              if (date("m", strtotime($startDate)) === date("m", strtotime($finishDate))) {
                                  echo rdate("d", strtotime($startDate), 1);
                              } else {
                                  echo rdate("d f", strtotime($startDate), 1);
                              }
                              echo " - ";
                              echo rdate("d f", strtotime($finishDate), 1);
                              ?>
                          </span>
                    <?php endif; ?>
                    <span class="
                         activity__item-span
                         activity__item-span--city
                         article__city
                         article__place
                         event__place
                         event_color_white
                         event__city
                    ">г. <?= $event->event_city ?></span>
                </div>
                <a class="btn--red btn article__button"
                   href="<?= Url::to(['site/event-form', 'title' => $event->title]) ?>">Принять участие</a>
            </div>
            <div class="timer article__timer event__timer event_color_white">
                <?php if (!empty($event["event_finish_date"])): ?>
                    <?php $time = date_diff(new DateTime($event["event_finish_date"]), new DateTime()); ?>
                <?php endif; ?>
                <p class="timer__title">До начала мероприятия</p>
                <div class="timer__time">
                    <div class="days timer__days">
                        <span class="timer__value days__value"><?= $time->days ?></span>
                        <span class="timer__subtitle days__subtitle">
                                 <?php
                                 switch ($time->days) {
                                     case 1:
                                         echo "день";
                                         break;
                                     case 2;
                                     case 3;
                                     case 4:
                                         echo "дня";
                                         break;
                                     default:
                                         echo "дней";
                                         break;
                                 }
                                 ?>
                            </span>
                    </div>
                    <div class="timer__value timer__separation">:</div>
                    <div class="hours timer__hours">
                        <span class="timer__value hours__value"><?= $time->h ?></span>
                        <span class="timer__subtitle hours__subtitle">
                                 <?php
                                 switch ($time->h) {
                                     case 1:
                                         echo "час";
                                         break;
                                     case 2;
                                     case 3;
                                     case 4:
                                         echo "часа";
                                         break;
                                     default:
                                         echo "часов";
                                         break;
                                 }
                                 ?>
                            </span>
                    </div>
                    <div class="timer__value timer__separation">:</div>
                    <div class="minute timer__minute">
                        <span class="timer__value minute__value"><?= $time->i ?></span>
                        <span class="timer__subtitle minute__subtitle">
                                <?php
                                switch ($time->i) {
                                    case 1:
                                        echo "минута";
                                        break;
                                    case 2;
                                    case 3;
                                    case 4:
                                        echo "минуты";
                                        break;
                                    default:
                                        echo "минут";
                                        break;
                                }
                                ?>
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($event->main_page_text)): ?>
    <section class="article-description">
        <div class="article_content article-description_content">
            <div class="article-description__info">
                <div class="article-description__main">
                    <h2 class="article-description__title">
                        <?= $event->main_page_text_header ?>
                    </h2>
                    <p class="article-description__text">
                        <?= $event->main_page_text ?>
                    </p>
                </div>
                <?php if (!empty($event->price)): ?>
                    <div class="price article-description__price">
                        <p class="price__subtitle">Стоимость участия</p>
                        <div class="price__value"><?= number_format((int)$event->price, 0, ' ', ' ') ?> ₽</div>
                    </div>
                <?php endif; ?>

            </div>
            <?php if (!empty($event->poster)): ?>
                <div class="article-description__img">
                    <img src="<?= $event->poster ?>" alt="">
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
<section class="article-main">
    <div class="article_content article-main_content">
        <p class="event-main__title">Организатор</p>
        <h2 class="event-main__company">FEMIDA.FORCE</h2>
        <p class="event-main__subtitle">Крупнейшее сообщество экспертов по банкротству. За время работы помогли
            сотням </p>
        <div class="event-main__container">
            <p class="event-main__title speakers-title">Спикеры</p>
            <div class="event-main__speakers">
                <div class="event-main__speaker speaker">
                    <img class="speaker__img" src="<?= Url::to(['/img/event-pages/speaker1.png']) ?>" alt="">
                    <h3 class="speaker__name">Мирослав Масальский</h3>
                    <ul class="speaker__achievements">
                        <li class="speaker__achievements-item">Основатель MYFORCE</li>
                        <li class="speaker__achievements-item">Практик с 12-летним опытом</li>
                        <li class="speaker__achievements-item">Эксперт в области запуска и масштабирования бизнеса</li>
                        <li class="speaker__achievements-item">Член Банкротного клуба</li>
                    </ul>
                </div>
                <div class="event-main__speaker">
                    <img class="speaker__img" src="<?= Url::to(['/img/event-pages/speaker2.png']) ?>" alt="">
                    <h3 class="speaker__name">Анжелика Попова </h3>
                    <ul class="speaker__achievements">
                        <li class="speaker__achievements-item">Эксперт в области банкротства</li>
                        <li class="speaker__achievements-item">Спикер юридических курсов</li>
                        <li class="speaker__achievements-item">Приняла участие в сопровождении более 800 процедур
                            банкротства
                        </li>
                        <li class="speaker__achievements-item">Руководитель юридического департамента</li>
                    </ul>
                </div>
                <div class="event-main__speaker">
                    <img class="speaker__img" src="<?= Url::to(['/img/event-pages/speaker3.png']) ?>" alt="">
                    <h3 class="speaker__name">Василий Артин</h3>
                    <ul class="speaker__achievements">
                        <li class="speaker__achievements-item">Автор и преподаватель курсов по БФЛ</li>
                        <li class="speaker__achievements-item">Член совета СРО «Гарантия»</li>
                        <li class="speaker__achievements-item">Владелец компании АСПБ</li>
                        <li class="speaker__achievements-item">Владелец сети офисов по продаже банкротства «ФЭС»</li>
                        <li class="speaker__achievements-item">Кандидат юридических наук</li>
                    </ul>
                </div>
                <div class="event-main__speaker">
                    <img class="speaker__img" src="<?= Url::to(['/img/event-pages/speaker4.png']) ?>" alt="">
                    <h3 class="speaker__name">Марина Дьярова</h3>
                    <ul class="speaker__achievements">
                        <li class="speaker__achievements-item">Автор эффективных методологий преподавания</li>
                        <li class="speaker__achievements-item">Автор и преподаватель курсов по БФЛ</li>
                    </ul>
                </div>
            </div>
        </div>
        <a class="btn--red btn article__button event-main__button"
           href="<?= Url::to(['site/event-form', 'title' => $event->title]) ?>">Принять участие</a>
    </div>
</section>
<section class="article-offer">
    <div class="article_content">
        <h2 class="article-offer__title">Самые ожидаемые мероприятия </h2>
        <div class="activity__wrap">
            <div class="activity__column">
                <?php foreach ($events as $event): ?>
                    <article class="activity__item event-offer__item">
                        <a href="<?= Url::to(['site/event-page', 'id' => $event['id']]) ?>"
                           class="activity__item-links"></a>
                        <?php if (!empty($event["img"])): ?>
                            <div class="activity__item-img">
                                <img src="<?= Url::to([$event["img"]]) ?>" alt="изображение мероприятия"/>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($event["category"])): ?>
                            <p class="activity__item-groop">
                                <?= $event["category"] ?>
                            </p>
                        <?php endif; ?>

                        <div class="activity__item-content">
                            <h3 class="activity__item-title">
                                <?= $event["name"] ?>
                            </h3>
                            <p class="activity__item-text">
                                <?= $event["preview_text"] ?>
                            </p>
                        </div>
                        <div class="activity__item-add">
                            <div class="activity__item-box">
                                <?php if (!empty($event['event_finish_date'])): ?>
                                    <span class="activity__item-span">
                                              <?php
                                              $startDate = $event["event_date"];
                                              $finishDate = $event["event_finish_date"];
                                              if (date("m", strtotime($startDate)) === date("m", strtotime($finishDate))) {
                                                  echo rdate("d", strtotime($startDate), 1);
                                              } else {
                                                  echo rdate("d f", strtotime($startDate), 1);
                                              }
                                              echo " - ";
                                              echo rdate("d f", strtotime($finishDate), 1);
                                              ?>
                                          </span>
                                <?php endif; ?>
                                <span class="activity__item-span activity__item-span--city">г. <?= $event["event_city"] ?></span>
                            </div>
                            <a href="<?= Url::to(['site/event-page', 'id' => $event['id']]) ?>"
                               class="activity__item-link">
                                <span>Подробнее</span>
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M10.803 4.63666C11.0959 4.34377 11.5708 4.34377 11.8637 4.63666L17.197 9.97C17.4899 10.2629 17.4899 10.7378 17.197 11.0307L11.8637 16.364C11.5708 16.6569 11.0959 16.6569 10.803 16.364C10.5102 16.0711 10.5102 15.5962 10.803 15.3033L14.856 11.2503H3.33337C2.91916 11.2503 2.58337 10.9145 2.58337 10.5003C2.58337 10.0861 2.91916 9.75033 3.33337 9.75033H14.856L10.803 5.69732C10.5102 5.40443 10.5102 4.92956 10.803 4.63666Z"
                                          fill="#E44E2B"/>
                                </svg>
                            </a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>