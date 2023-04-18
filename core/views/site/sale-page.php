<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\widgets\Pjax;

$this->title = $event->name;


?>
    <section class="article-1 article-1--ceys sale__article">
        <div class="article_content">
            <nav class="breadcrumbs">
                <a class="article__nav-link sale__nav-link" href="<?= Url::to(['/']) ?>">Главная</a>
                <img src="<?= Url::to(['img/mainimg/angle right.svg']) ?>" alt="arrow">
                <a class="article__nav-link sale__nav-link" href="<?= Url::to(['site/events','filters[type]'=>"sale"])?>">Акции</a>
                <img src="<?= Url::to(['img/mainimg/angle right.svg']) ?>" alt="arrow">
                <a class="article__nav-link sale__nav-link_active sale_color_purple"><?= $event->name?></a>
            </nav>
            <div class="article__header sale__header">
                <div class="info article__info sale__info">
                    <h1 class="article__name sale__name"><?= $event->name?></h1>
                    <p class="article__header-text sale__header-text"><?= $event->preview_text?></p>
                </div>
                <div class="timer article__timer sale__timer sale_color_purple">
                    <?php if (!empty($event->event_finish_date)): ?>
                        <?php $time = date_diff(new DateTime($event->event_finish_date), new DateTime());?>
                    <?php endif; ?>
                    <p class="timer__title">До начала мероприятия</p>
                    <div class="timer__time">
                        <div class="days timer__days">
                            <span class="timer__value days__value"><?= $time->days?></span>
                            <span class="timer__subtitle days__subtitle">
                                 <?php
                                 switch ($time->days){
                                     case 1:
                                         echo "день";
                                         break;
                                     case 2; case 3;case 4:
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
                            <span class="timer__value hours__value"><?= $time->h?></span>
                            <span class="timer__subtitle hours__subtitle">
                                 <?php
                                 switch ($time->h){
                                     case 1:
                                         echo "час";
                                         break;
                                     case 2; case 3;case 4:
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
                            <span class="timer__value minute__value"><?= $time->i?></span>
                            <span class="timer__subtitle minute__subtitle">
                                <?php
                                switch ($time->i){
                                    case 1:
                                        echo "минута";
                                        break;
                                    case 2; case 3;case 4:
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
    <section class="article-description sale-description">
        <div class="article_content article-description_content">

            <div class="article-description__info sale-description__info" style="background: url(<?= $event->poster?>) center/cover no-repeat">
                <div class="article-description__main">
                    <h2 class="article-description__title">
                        <?= $event->main_page_text_header ?>
                    </h2>
                    <p class="article-description__text">
                        <?= $event->main_page_text?>
                    </p>
                    <a class="btn--red btn article__button sale__button"  href="<?= Url::to(['site/event-form','title' => $event->title])?>">Воспользоваться акцией</a>
                </div>
            </div>
        </div>
    </section>
    <section class="article-main">
        <div class="article_content article-main_content">
            <div class="sale-main__header">
                <div class="sale-main__header-main">
                    <h2 class="sale-main__header-title">Популярные курсы</h2>
                    <h3 class="sale-main__header-subtitle">Выбор сотен людей, которые уже нашли свое призвание</h3>
                </div>
                <a href="<?= Url::to(['events']) ?>" class="events__link sale-main__header-link">
                    <span>Все курсы</span>
                    <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.803 4.63666C11.0959 4.34377 11.5708 4.34377 11.8637 4.63666L17.197 9.97C17.4899 10.2629 17.4899 10.7378 17.197 11.0307L11.8637 16.364C11.5708 16.6569 11.0959 16.6569 10.803 16.364C10.5101 16.0711 10.5101 15.5962 10.803 15.3033L14.856 11.2503H3.33334C2.91912 11.2503 2.58334 10.9145 2.58334 10.5003C2.58334 10.0861 2.91912 9.75033 3.33334 9.75033H14.856L10.803 5.69732C10.5101 5.40443 10.5101 4.92956 10.803 4.63666Z" fill="#43419E" />
                    </svg>
                </a>
            </div>
            <div class="sale-main__curses">
                <?php foreach ($courses as $course):?>
                    <div class="sale-main__curses-item">
                        <div class="curses-item-main">
                            <p class="curses-item-title"><?= $course->type ?></p>
                            <h4 class="curses-item-header"><?= $course->name ?></h4>
                            <p class="curses-item-lesson">
                                <?= $course->lessons_count?> уроков
                            </p>
                        </div>
                        <div class="curses-item-icon">
                            <img class="curses-item-img" src="<?= \common\models\helpers\UrlHelper::admin([$course->preview_logo])?>" alt="">
                        </div>
                    </div>
                <?php endforeach;?>
            </div>

            <a class="btn--red btn article__button event-main__button"  href="<?= Url::to(['site/event-form','title' => $event->title])?>">Воспользоваться акцией</a>
        </div>
    </section>
    <section class="article-offer">
    <div class="article_content">
        <h2 class="article-offer__title">Рекомендуемые предложения</h2>
        <div class="activity__wrap">
            <div class="activity__column">
                <?php foreach ($events as $event):?>
                    <article class="s2__item" style="background-image: url(<?= $event["img"]?>)">
                        <a href="<?= Url::to(['site/sale-page',"link"=>$event["link"]]) ?>" class="s2__item-link"></a>
                        <div class="s2__item-content">
                            <div class="s2__item-inner">
                                  <span class="s2__item-stock">
                                    до окончания
                                      <?php if (!empty($event["event_finish_date"])): ?>
                                          <span class="s2__item-day">
                                              <?php $days = date_diff(new DateTime($event["event_finish_date"]), new DateTime())->days?>
                                              <?= $days?>
                                          </span>
                                      <?php endif; ?>
                                            <?php
                                            switch ($days){
                                                case 1:
                                                    echo "день";
                                                    break;
                                                case 2; case 3;case 4:
                                                echo "дня";
                                                break;
                                                default:
                                                    echo "дней";
                                                    break;
                                            }
                                            ?>
                                    <?php if (!empty($event["event_finish_date"])): ?>
                                          <span class="s2__item-hour">
                                               <?php $hours = date_diff(new DateTime($event["event_finish_date"]), new DateTime())->h?>
                                               <?= date_diff(new DateTime($event["event_finish_date"]), new DateTime())->h?>
                                          </span>
                                    <?php endif; ?>
                                           <?php
                                           switch ($hours){
                                               case 1:
                                                   echo "час";
                                                   break;
                                               case 2; case 3;case 4:
                                               echo "часа";
                                               break;
                                               default:
                                                   echo "часов";
                                                   break;
                                           }
                                           ?>
                                  </span>
                            </div>
                            <div class="s2__item-box">
                                <?php $text_color = json_decode($event["text_color"])?>
                                <h3 class="s2__item-title" style="color: <?=$text_color->header?>">
                                    <?= $event["name"]?>
                                </h3>
                                <p class="s2__item-subtitle"  style="color: <?=$text_color->body?>">
                                    <?= $event["preview_text"] ?>
                                </p>
                            </div>
                            <div class="s2__item-btn">
                                <a href="<?= Url::to(['site/sale-page',"link"=>$event["link"]]) ?>">Подробнее</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    </section>