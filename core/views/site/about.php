<?php


/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'О проекте';
$this->params['breadcrumbs'][] = $this->title;
?>
<article class="article-1">
  <div class="article_content">
    <nav class="breadcrumbs">
      <a href="<?= Url::to(['/']) ?>">Главная</a>
      <img src="<?= Url::to(['img/mainimg/angle right.svg']) ?>" alt="">
      <a>О проекте</a>
    </nav>
    <div class="article-1_section-1">
      <section class="ar-1_sec-1_main-info">
        <h1 class="Main-title">Делаем бизнес доступным для каждого</h1>
        <div class="ar-1_sec-1_main-info-row">
          <div class="ar-1_sec-1_main-info-row-C">
            <p class="ar-1_sec-1_main-info-row-C-t1">
              90 000
            </p>
            <p class="ar-1_sec-1_main-info-row-C-t2">
              постоянных пользователей
            </p>
          </div>
          <div class="ar-1_sec-1_main-info-row-C">
            <p class="ar-1_sec-1_main-info-row-C-t1">
              547
            </p>
            <p class="ar-1_sec-1_main-info-row-C-t2">
              компаний основано на наших франшизах
            </p>
          </div>
          <div class="ar-1_sec-1_main-info-row-C">
            <p class="ar-1_sec-1_main-info-row-C-t1">
              12 938
            </p>
            <p class="ar-1_sec-1_main-info-row-C-t2">
              человек прошли обучение и посетили мероприятия
            </p>
          </div>
        </div>
      </section>
      <aside class="ar-1_sec-1_teleg-info">
        <img src="<?= Url::to(['img/mainimg/telegramm.svg']) ?>" alt="telegramm">
        <p class="ar-1_sec-1_teleg-info-ttl">Больше материалов в Telegram</p>
        <p class="ar-1_sec-1_teleg-info-t2">Никакого спама и рекламы, только лучшее для вашего бизнеса</p>
        <a class="telegrammBTN" href="<?= Url::to('https://t.me/myforce_business') ?>">Подписаться <img src="<?= Url::to(['img/mainimg/Arrow Right.svg']) ?>" alt="arrow"></a>
      </aside>
    </div>
    <div class="article-1_section-2">
      <section class="ar-1_sec-2_main-info">
        <img class="ArrowDown" src="<?= Url::to(['img/mainimg/down arrow.svg']) ?>" alt="">
        <div class="ar-1_sec-2_main-info-cont">
          <img src="<?= Url::to(['img/mainimg/image.png']) ?>" alt="">
          <div class="ar-1_sec-2_main-info-cont-text">
            <h3 class="ar-1_sec-2_main-info-cont-text-t1">Продвигаем свои ценности</h3>
            <p class="ar-1_sec-2_main-info-cont-text-t2">Мы — команда MYFORCE — вдохновлены тем, что нам удаётся менять жизнь сотен тысяч людей и повышать уровень образования в стране. И уверены, что сможем добиться большего, так как у онлайн‑образования огромный потенциал.
              <br>
              <br>
              Мы стремимся к масштабному развитию не только компании, но и каждого человека задействованного в ней, ведь для нас человеческий ресурс стоит выше производственных мощностей. Благодаря безостановочно движению вверх, мы не только даем возможность для переезда или получения зарубежного опыта, но и активно поддерживаем все стремления сотрудников к саморазвитию за счет богатого опыта руководителей из разных стран! Благодаря этому мы успешно ведем бизнес не только в России, но и в СНГ.
            </p>
            <p class="ar-1_sec-2_main-info-cont-text-t3">Мирослав Масальский, основатель MYFORCE</p>
          </div>
        </div>
      </section>
      <?php if (!empty($news)) : ?>
        <aside class="ar-1_sec-2_news-info d-None">
          <p class="ar-1_sec-2_news-info-ttl">Новости</p>
          <?php foreach ($news as $k => $v) : ?>
            <a href="<?= Url::to(['news-page', 'link' => $v['link']]) ?>" class="ar-1_sec-2_news-info-name"><?= $v['title'] ?></a>
            <?php if ($k < (count($news) - 1)) : ?>
              <div class="ar-1_sec-2_news-info-strip"></div>
            <?php endif; ?>
          <?php endforeach; ?>
        </aside>
      <?php endif; ?>

    </div>
    <section class="article-1_section-3">
      <div class="article-1_section-3_info">
        <h3 class="article-1_section-3_info-ttl">Бережно относимся к каждому клиенту</h3>
        <p class="article-1_section-3_info-t2">Мы заботимся о каждом клиенте как о единственном, мы не прекратим
          сотрудничество, пока не решим проблему, не закроем задачу, если что-то сделали не так. Мы — это все
          наши клиенты!</p>
      </div>
      <img src="<?= Url::to(['img/mainimg/Grouppimg.png']) ?>" alt="">
    </section>
  </div>
</article>
<section class="section-separation">
  <div class="section-separation_cont">
    <p class="section-separation_cont-t1">Миссия проекта</p>
    <h3 class="section-separation_cont-t2">Сделать бизнес доступным для всех</h3>
    <p class="section-separation_cont-t3">Наши технологии экономят ваше время, и дальше очень вдохновляющий короткий текст о нас</p>
  </div>
</section>
<article class="article-2">
  <div class="article-2_cont">
    <section class="article-2_section-1">
      <h3 class="article-2_section-1-ttl">История MYFORCE</h3>
      <h4 class="article-2_section-1-t">Шесть лет работы над собой</h4>
      <div class="article-2_section-1-block">
        <p class="article-2_section-1-block-year">2015</p>
        <h4 class="article-2_section-1-block-t1">Начиная с малого</h4>
        <p class="article-2_section-1-block-t2">У нас были только мечты и цели. Мы запустились как маркетинговое
          агентство в юридической сфере</p>
      </div>
      <div class="article-2_section-1-block">
        <p class="article-2_section-1-block-year">2016</p>
        <h4 class="article-2_section-1-block-t1">Первые партнеры</h4>
        <p class="article-2_section-1-block-t2">К нам присоединились первые 4 партнера, с которыми мы до сих пор
          успешно сотрудничаем</p>
      </div>
      <div class="article-2_section-1-block">
        <p class="article-2_section-1-block-year">2017</p>
        <h4 class="article-2_section-1-block-t1">Международный уровень</h4>
        <p class="article-2_section-1-block-t2">Летом мы вышли со своим продуктом в СНГ и страны ближнего
          зарубежья</p>
      </div>
      <div class="article-2_section-1-block">
        <p class="article-2_section-1-block-year">2018</p>
        <h4 class="article-2_section-1-block-t1">Расширение линейки продуктов</h4>
        <p class="article-2_section-1-block-t2">Переломный момент в нашей деятельности. Мы накопили достаточное
          количество знаний и опыта, и готовы делиться с остальными! Мы создаем франшизы, курсы и сервис
          лидогенерации</p>
      </div>
      <div class="article-2_section-1-block">
        <p class="article-2_section-1-block-year">2019</p>
        <h4 class="article-2_section-1-block-t1">Сервис для бизнеса</h4>
        <p class="article-2_section-1-block-t2">Мы вышли на новый уровень ведения бизнеса и решили создать
          единую бизнес-экосистему, которая будет полезна всем, кто хочет открыть и успешно вести свое дело.
          Сила в сотрудничестве и партнерстве!</p>
      </div>
      <div class="article-2_section-1-block">
        <p class="article-2_section-1-block-year">2020</p>
        <h4 class="article-2_section-1-block-t1">Новый бренд</h4>
        <p class="article-2_section-1-block-t2">Ведение цифрового бизнеса — это всегда необходимость
          соответствовать трендам. Мы всегда готовы к изменениям, поэтому запускаем единый проект —
          MYFORCE</p>
      </div>
    </section>
    <section class="article-2_section-2">
      <div class="">
        <h3 class="s2__title">
          Проекты MYFORCE
        </h3>
        <h4 class="s2__subtitle">
          Комплексные решения для вашей компании
        </h4>
        <div class="s2__inner card">
          <article class="card__item">
            <a style="text-decoration: none" href="<?= Url::to(['femida/']) ?>"></a>
            <div class="card__content">
              <p class="card__info">
                франшиза
              </p>

              <h3 class="card__title">
                Быстрый старт
              </h3>

              <p class="card__subtitle">
                Выгодные франшизы для вас
              </p>
            </div>
          </article>

          <article class="card__item card__item--2">
            <a href="<?= Url::to(['lead/']) ?>" style="text-decoration: none"></a>
            <div class="card__content card__content--2">
              <p class="card__info">
                лидогенерация
              </p>

              <h3 class="card__title">
                Готовые клиенты
              </h3>

              <p class="card__subtitle">
                Покупайте горячие заявки онлайн
              </p>
            </div>
          </article>

          <article class="card__item card__item--3">
            <a href="<?= Url::to(['lead/']) ?>" style="text-decoration: none"></a>
            <div class="card__content card__content--3">
              <p class="card__info">
                обучение
              </p>
              <h3 class="card__title card__title--color">
                Курсы сотрудникам
              </h3>
              <p class="card__subtitle card__subtitle--color">
                Совместный рост — залог успеха
              </p>
            </div>
          </article>
        </div>
      </div>
    </section>
  </div>
</article>