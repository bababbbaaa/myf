<?php
/* @var $this yii\web\View */

use yii\helpers\Url;


$this->title = $news['title'];

$js = <<<JS

JS;
$this->registerJs($js);

?>
<main class="main">
  <section class="one-s1">
    <div class="container">
      <div class="one-s1__top">
        <a href="<?= Url::to(['blog']) ?>" class="cp-s1__nav">
          Вернуться к каталогу
          <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.37361 12.5401C6.98309 12.9306 6.34992 12.9306 5.9594 12.5401L0.626065 7.20678C0.235541 6.81626 0.235541 6.18309 0.626065 5.79257L5.9594 0.459234C6.34992 0.0687095 6.98309 0.0687096 7.37361 0.459234C7.76414 0.849758 7.76414 1.48292 7.37361 1.87345L3.74739 5.49967L14.6665 5.49967C15.2188 5.49967 15.6665 5.94739 15.6665 6.49967C15.6665 7.05196 15.2188 7.49967 14.6665 7.49967L3.74739 7.49967L7.37361 11.1259C7.76414 11.5164 7.76414 12.1496 7.37361 12.5401Z" fill="#5C687E" />
          </svg>
        </a>
        <div class="one-s1__box">
          <time data-time="02-04-2021" class="bg-s2__naw-time one__naw-time"><?= date('d.m.Y', strtotime($news['date'])) ?></time>
        </div>
      </div>

      <div class="one-s1__body">
        <?php if (!empty($moreNews)) : ?>
          <div class="one-s1__sidebar">
            <p class="one-s1__sidebar-info">
              Популярные статьи
            </p>

            <ul class="one-s1__list">

              <?php foreach ($moreNews as $k => $v) : ?>
                <li class="one-s1__item">
                  <a href="<?= Url::to(['link' => $v['link']]) ?>" class="one-s1__sidebar-link"><?= $v['title'] ?></a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <article class="one-s1__main">
          <div class="one-s1__main-img">
            <img src="<?= \common\models\helpers\UrlHelper::admin($news['og_image']) ?>" alt="фото статьи" class="one-s1__img">
          </div>
          <h1 class="one-s1__title"><?= $news['title'] ?></h1>
          <div class="one-s1__text">
            <?= $news['content'] ?>
          </div>
        </article>
      </div>
    </div>
  </section>


  <?php if (!empty($course)) : ?>
    <section class="cp-s7">
      <div class="container">
        <h2 class="cp-s7__title title">
          Наши курсы
        </h2>
        <div class="cp-s7__inner">
          <?php foreach ($course as $k => $v) : ?>
            <div class="cp-s7__item">
              <div class="cp-s7__img">
                <img src="<?= \common\models\helpers\UrlHelper::admin($v['preview_logo']) ?>" alt="фото курса" />
              </div>
              <p class="cp-s7__text"><?= $v['name'] ?></p>
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

  <div class="S3">
    <div class="container">
      <div class="S3C">
        <p class="S3C-t1">Больше о новых курсах и акциях на нашем канале</p>
        <div class="S3C__inner">
          <img src="<?= Url::to(['/img/tg-circle.svg']) ?>">
          <a href="<?= Url::to('https://t.me/myforce_business') ?>" class="uscp S3C-telegramm">
            <p>Подписаться</p>
            <img src="<?= Url::to(['/img/ArrowRightteleg.svg']) ?>">
          </a>
        </div>
      </div>
    </div>
  </div>

</main> 