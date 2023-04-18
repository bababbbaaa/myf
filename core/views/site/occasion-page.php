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
                <a class="article__nav-link sale__nav-link" href="<?= Url::to(['site/events','filters[type]'=>"events"])?>">События</a>
                <img src="<?= Url::to(['img/mainimg/angle right.svg']) ?>" alt="arrow">
                <a class="article__nav-link sale__nav-link_active sale_color_purple"><?= $event->name?></a>
            </nav>
            <div class="article__header sale__header">
                <div class="info article__info sale__info">
                    <h1 class="article__name sale__name"><?= $event->name?></h1>
                    <p class="article__header-text sale__header-text"><?= $event->preview_text?></p>
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
                       <?= $event->main_page_text ?>
                    </p>
                    <a class="btn--red btn article__button sale__button occasion__button"  href="<?= Url::to(['site/event-form','title' => $event->title])?>">Узнать подробнее</a>
                </div>
            </div>
        </div>
    </section>
    <section class="article-offer occasion-offer">
    <div class="article_content">
        <h2 class="article-offer__title">Рекомендуемые события</h2>
        <div class="activity__wrap">
            <div class="activity__column">
                <?php foreach ($events as $event):?>
                    <article class="events__item" style="background-image: url(<?= $event["img"]?>);">
                        <a href="<?= Url::to(['site/occasion-page','link'=>$event["link"]]) ?>" class="events__item-links"></a>
                        <h3 class="events__item-title">
                            <?= $event["name"]?>
                        </h3>
                        <p class="events__item-text">
                            <?= $event["preview_text"]?>
                        </p>
                        <a href="<?= Url::to(['site/occasion-page','link'=>$event["link"]]) ?>" class="events__item-link">
                            <span>Подробнее</span>
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.803 4.63666C11.0959 4.34377 11.5708 4.34377 11.8637 4.63666L17.197 9.97C17.4899 10.2629 17.4899 10.7378 17.197 11.0307L11.8637 16.364C11.5708 16.6569 11.0959 16.6569 10.803 16.364C10.5102 16.0711 10.5102 15.5962 10.803 15.3033L14.856 11.2503H3.33337C2.91916 11.2503 2.58337 10.9145 2.58337 10.5003C2.58337 10.0861 2.91916 9.75033 3.33337 9.75033H14.856L10.803 5.69732C10.5102 5.40443 10.5102 4.92956 10.803 4.63666Z" fill="#E44E2B" />
                            </svg>
                        </a>
                    </article>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    </section>