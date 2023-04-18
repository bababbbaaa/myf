<?php


/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\helpers\UrlHelper;
use yii\widgets\Pjax;

$this->registerCssFile('https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js');
$this->registerJsFile("@web/js/mainjs/swiper.js");
$this->registerJsFile("@web/js/mainjs/swiper-control.js");
$this->registerJsFile("@web/js/mainjs/swiper-control.js");
$this->registerJsFile("@web/js/mainjs/accordion.js");
$this->registerCssFile("@web/css/maincss/swiper.css");
$js = <<< JS
    $('.sendAdd').on('submit', function(e) {
        e.preventDefault();
        $.pjax.reload({
          container: '#case_add',
          url: "site/index",
          type: "GET",
          data: $('.sendAdd').serialize(),
        });
    });
    $('.blockReferals').on('click', '.refAdd',function(e) {
        var cols = $('input[name="cols"').val();
        e.preventDefault();
        $.pjax.reload({
          container: '#referalContainer',
          url: "/site/index",
          type: "GET",
          data: {cols: cols},
        });
    });

    var swiper = new Swiper(".mySwiper", {
      slidesPerView: 1,
      spaceBetween: 20,
      centeredSlides: true,
      pagination: {
        el: ".swiper-pagination",
        clickable: true,
      },
      breakpoints: {
        768: {
          slidesPerView: 2,
          spaceBetween: 40,
          centeredSlides: true,
        },
        1024: {
          slidesPerView: 3,
          spaceBetween: 50,
          centeredSlides: false,
        },
      },
    });
    
    //Открытие и закрытие на моб версии блока История MYFORCE
    const historyBtn = document.querySelector('.history-myforce__btn');
    const hostoryMore = document.querySelector('.history-myforce__more');
    const hostorySpan = historyBtn.querySelector('span');
    
    historyBtn.addEventListener('click', (e) => {
      e.preventDefault();
      if (hostoryMore.style.display == 'none') {
        hostoryMore.style.display = 'block';
        hostorySpan.textContent = 'Скрыть';
      } else {
        hostoryMore.style.display = 'none';
        hostorySpan.textContent = 'Смотреть еще';
      }
    });
    
    //Открытие и закрытие на моб версии блока информации о компании
    const aboutBtn = document.querySelector('.about__btn');
    const aboutMore = document.querySelector('.about__more');
    const aboutSpan = aboutBtn.querySelector('span');
    
    aboutBtn.addEventListener('click', (e) => {
      e.preventDefault();
      if (aboutMore.style.display == 'none') {
        aboutMore.style.display = 'block';
        aboutSpan.textContent = 'Скрыть';
      } else {
        aboutMore.style.display = 'none';
        aboutSpan.textContent = 'Читать еще';
      }
    });


JS;

$this->registerJs($js);
$this->title = 'Бизнес система для предпринимателей';
?>

<main class="main">
    <section class="promo">
        <div class="container">
            <div class="promo__content">
                <h1 class="promo__title">
                    Экосистема для предпринимателей
                </h1>
                <a href="<?= Url::to(['registr?site=lead']) ?>" class="promo__cta">
                    Регистрация
                </a>
            </div>
        </div>
    </section>

    <section class="s7">
        <div class="container">
            <h3 class="s7__title title">
                Партнеры Myforce
            </h3>

            <p class="s7__subtitle subtitle">
                Восемь лет партнерского опыта и десятки надежных партнеров.
            </p>
            <div class="s7__partners">
                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-1.png']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-2.png']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-3.png']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-4.png']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-5.png']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-6.png']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-7.svg']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-8.svg']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-9.png']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-10.png']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-11.png']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-12.png']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-13.png']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-14.svg']) ?>" alt="лого">
                </div>

                <div class="s7__item">
                    <img src="<?= Url::to(['img/mainimg/s7-15.svg']) ?>" alt="лого">
                </div>
            </div>
    </section>
    <section class="business">
        <div class="container">
            <h2 class="business__title">ДЕЛАЕМ БИЗНЕС ДОСТУПНЫМ ДЛЯ КАЖДОГО</h2>
            <ul class="business__list">
                <li>
                    <span>90.000</span>
                    <p>постоянных</p>
                    <p>пользователей</p>
                </li>
                <li>
                    <span>500 +</span>
                    <p>компаний основано</p>
                    <p>на наших франшизах</p>
                </li>
                <li>
                    <span>13 000 +</span>
                    <p>человек прошли обучение </p>
                    <p>и посетили мероприятия</p>
                </li>
            </ul>
        </div>
    </section>

    <section class="about">
        <div class="container">
            <div class="about__wrapper">
                <div class="about__text">
                    <h3>Продвигаем свои ценности</h3>
                    <p>Мы — <b>команда MYFORCE</b> — вдохновлены тем, что нам удаётся менять жизнь сотен тысяч людей и
                        повышать уровень образования в стране. И уверены, что сможем добиться большего, так как у
                        онлайн‑образования огромный потенциал.</p>
                    <div class="about__more">
                        <p><b>Мы стремимся к масштабному развитию</b> не только компании, но и <b>каждого человека</b>
                            задействованного в ней, ведь для нас человеческий ресурс стоит выше производственных
                            мощностей.
                            Благодаря безостановочно движению вверх, <b>мы</b> не только <b>даём возможность
                                для переезда
                                или получения зарубежного опыта</b>, но и <b>активно поддерживаем все стремления
                                сотрудников</b> к саморазвитию за счёт богатого опыта руководителей из разных стран!
                            Благодаря этому мы <b>успешно ведём бизнес</b> не только в России, но и в СНГ.</p>
                    </div>
                    <button class="about__btn"><span>Читать еще</span> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.43 5.92993L20.5 11.9999L14.43 18.0699" stroke="url(#paint0_linear_402_939)" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M3.5 12H20.33" stroke="url(#paint1_linear_402_939)" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            <defs>
                                <linearGradient id="paint0_linear_402_939" x1="17.465" y1="5.92993" x2="17.465" y2="18.0699" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#DF2C56" />
                                    <stop offset="1" stop-color="#C81F47" />
                                </linearGradient>
                                <linearGradient id="paint1_linear_402_939" x1="11.915" y1="12" x2="11.915" y2="13" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#DF2C56" />
                                    <stop offset="1" stop-color="#C81F47" />
                                </linearGradient>
                            </defs>
                        </svg>
                    </button>
                </div>
                <div class="about__image">
                    <img src="<?= Url::to(['img/mainimg/miroslav.png']) ?>" alt="Основатель MYFORCE">
                    <p>Мирослав Масальский, основатель MYFORCE</p>
                </div>
            </div>
            <h3>Бережно относимся к каждому клиенту</h3>
            <div class="about__clients">
                <img src="<?= Url::to(['img/mainimg/clients.svg']) ?>" alt="Клиенты">
                <p>Мы заботимся о каждом клиенте как о единственном. Мы не прекратим сотрудничество, пока не решим
                    проблему, не закроем задачу, если что-то сделали не так. <b>Мы — это все наши клиенты!</b></p>
            </div>
        </div>
    </section>
    <section class="project-mission">
        <div class="container">
            <p>Миссия проекта</p>
            <h2>Сделать бизнес доступным для всех</h2>
            <p>Наши технологии экономят ваше время, а большой опыт работы гарантируют вам результат.</p>
        </div>
    </section>
    <section class="history-myforce">
        <div class="container">
            <h2 class="history-myforce__title">История MYFORCE</h2>
            <div class="history-myforce__wrap">
                <div class="history-myforce__item">
                    <div class="history-myforce__year">
                        2015
                    </div>
                    <h3 class="history-myforce__subtitle">Начиная с малого</h3>
                    <p class="history-myforce__text">У нас были только мечты и цели. Мы запустились как маркетинговое
                        агентство в юридической сфере.</p>
                </div>
                <div class="history-myforce__item">
                    <div class="history-myforce__year">
                        2016
                    </div>
                    <h3 class="history-myforce__subtitle">Первые партнеры</h3>
                    <p class="history-myforce__text">К нам присоединились первые 4 партнера, с которыми мы до сих пор
                        успешно сотрудничаем.</p>
                </div>
                <div class="history-myforce__item">
                    <div class="history-myforce__year">
                        2017
                    </div>
                    <h3 class="history-myforce__subtitle">Международный уровень</h3>
                    <p class="history-myforce__text">Летом мы вышли со своим продуктом в СНГ и страны ближнего
                        зарубежья.</p>
                </div>
                <div class="history-myforce__more">
                    <div class="history-myforce__item">
                        <div class="history-myforce__year">
                            2018
                        </div>
                        <h3 class="history-myforce__subtitle">Расширение линейки продуктов</h3>
                        <p class="history-myforce__text">Переломный момент в нашей деятельности. Мы накопили достаточное
                            количество знаний и опыта, и готовы делиться с остальными! Мы создаём франшизы, курсы
                            и сервис лидогенерации.</p>
                    </div>
                    <div class="history-myforce__item">
                        <div class="history-myforce__year">
                            2019
                        </div>
                        <h3 class="history-myforce__subtitle">Сервис для бизнеса</h3>
                        <p class="history-myforce__text">Мы вышли на новый уровень ведения бизнеса и решили создать
                            единую бизнес-экосистему, которая будет полезна всем, кто хочет открыть и успешно вести своё
                            дело. Сила в сотрудничестве и партнёрстве!</p>
                    </div>
                    <div class="history-myforce__item">
                        <div class="history-myforce__year">
                            2020
                        </div>
                        <h3 class="history-myforce__subtitle">Новый бренд</h3>
                        <p class="history-myforce__text">Ведение цифрового бизнеса — это всегда необходимость
                            соответствовать трендам. Мы всегда готовы к изменениям, поэтому запускаем единый проект —
                            MYFORCE.</p>
                    </div>
                    <div class="history-myforce__item">
                        <div class="history-myforce__year">
                            2021 - 2022
                        </div>
                        <h3 class="history-myforce__subtitle">Переход на цифровой формат бизнеса</h3>
                        <p class="history-myforce__text">Разработка собственной нейросети для маркетинга и настройки
                            рекламных компаний, выход на рынок IT технологий.</p>
                    </div>
                    <div class="history-myforce__item">
                        <div class="history-myforce__year">
                            2023
                        </div>
                        <h3 class="history-myforce__subtitle">Запуск платформы SKILLFORCE</h3>
                        <p class="history-myforce__text">Инвестиции в обучающие платформы для малого и среднего бизнеса,
                            запуск проекта по поддержке микро бизнеса в России.</p>
                    </div>
                </div>
                <button class="history-myforce__btn"><span>Смотреть еще</span> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.43 5.92993L20.5 11.9999L14.43 18.0699" stroke="url(#paint0_linear_402_939)" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3.5 12H20.33" stroke="url(#paint1_linear_402_939)" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        <defs>
                            <linearGradient id="paint0_linear_402_939" x1="17.465" y1="5.92993" x2="17.465" y2="18.0699" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                            <linearGradient id="paint1_linear_402_939" x1="11.915" y1="12" x2="11.915" y2="13" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                        </defs>
                    </svg>
                </button>
            </div>


        </div>
    </section>

    <?php if (!empty($cases)) : ?>
        <a id="partners"></a>
        <div class="s3">
            <div class="container">
                <h3 class="s3__title title">
                    Наши кейсы
                </h3>

                <p class="s3__subtitle subtitle">
                    Истории успеха наших партнеров
                </p>
                <?php Pjax::begin(['id' => 'case_add', 'enablePushState' => true]) ?>
                <div class="swiper mySwiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($cases as $item) : ?>
                            <div class="swiper-slide">
                                <article class="case__article">
                                    <a href="<?= Url::to(['case', 'link' => $item['link']]) ?>" class="case__links"></a>
                                    <div class="case__inner">
                                        <div class="case__img">

                                            <img src="<?= UrlHelper::admin($item['logo']) ?>" alt="лого" />
                                        </div>
                                        <div class="case__content">

                                            <h2 class="case__heading">
                                                <?= $item['type']  ?>
                                            </h2>
                                            <p class="case__comment">
                                                <?= mb_substr(strip_tags($item['comment']), 0, 200) ?>...
                                            </p>
                                            <p class="case__author">© <?= $item['boss_name'] ?>,
                                                <?= $item['boss_op'] ?> </p>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>


                <?php if ($casesColl > 7 && $casesColl >= $_GET['count']) : ?>
                    <?= Html::beginForm(Url::to(['index']), 'GET', ['class' => 'sendAdd']) ?>
                    <input type="hidden" name="count" value="<?= !empty($_GET['count']) ? $_GET['count'] + 3 : 10 ?>">
                    <button type="submit" class="s3__btn btn-add">Ещё</button>
                    <?= Html::endForm(); ?>
                <?php endif; ?>
                <?php Pjax::end() ?>
            </div>
        </div>
    <?php endif; ?>

    <section class="my-club">
        <div class="container">
            <div class="my-club__wrap">
                <div class="my-club__item">
                    <h2 class="my-club__title">Получите Карту клуба прямо сейчас</h2>
                    <p class="my-club__text">Получите карту СОВЕРШЕННО БЕСПЛАТНО
                        при покупке 350 лидов для вашего бизнеса</p>
                    <button class="my-club__btn showsCard" data-form-name="Получите Карту клуба прямо сейчас">Получить</button>
                </div>
                <div class="my-club__img">
                    <img src="<?= Url::to(['img/mainimg/my-club.svg']) ?>" alt="Получите Карту клуба прямо сейчас">
                </div>
            </div>
        </div>
    </section>

    <section class="services-lead">
        <div class="container">
            <h2 class="services-lead__title">Услуги LEAD.FORCE</h2>
            <p class="services-lead__descr">Качественные лиды для любой отрасли бизнеса.</p>
        </div>

        <div class="services-lead__item">
            <div class="container">
                <div class="services-lead__wrap">
                    <div class="services-lead__img">
                        <img src="<?= Url::to(['img/mainimg/services-lead-1.svg']) ?>" alt="Лиды на банкротство физических лиц">
                    </div>
                    <div class="services-lead__text">
                        <h3>Лиды на банкротство физических лиц</h3>

                            <p>Если вы занимаетесь только банкротством физического лица, и не оказываете услуги финансовой
                                защиты (СЭП, ЗПЗ), то лиды на банкротство физлица с фильтром от 250 000 руб. долга это
                                идеальный для вас вариант. Фильтр от 250 000 руб. сразу предполагает ...<a href="<?= Url::to(['/lead/main/index',  '#' => 'leads-category']) ?>">подробнее  <svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.6325 5.92969L22.2083 11.9997L15.6325 18.0697" stroke="url(#paint0_linear_75_12222)" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M3.79163 12H22.0241" stroke="url(#paint1_linear_75_12222)" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <defs>
                                            <linearGradient id="paint0_linear_75_12222" x1="18.9204" y1="5.92969" x2="18.9204" y2="18.0697" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#DF2C56" />
                                                <stop offset="1" stop-color="#C81F47" />
                                            </linearGradient>
                                            <linearGradient id="paint1_linear_75_12222" x1="12.9079" y1="12" x2="12.9079" y2="13" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#DF2C56" />
                                                <stop offset="1" stop-color="#C81F47" />
                                            </linearGradient>
                                        </defs>
                                    </svg></a></p>

                        <p>от <span>650 руб./лид</span></p>
                    </div>
                </div>
            </div>
        </div>
        <div class="services-lead__item">
            <div class="container">
                <div class="services-lead__wrap">
                    <div class="services-lead__img">
                        <img src="<?= Url::to(['img/mainimg/services-lead-2.svg']) ?>" alt="Лиды от кредитных должников">
                    </div>
                    <div class="services-lead__text">
                        <h3>Лиды от кредитных должников</h3>

                            <p>Занимаетесь банкротством физического лица и хотите увеличить количество лидов в вашем
                                бизнесе? Покупка лидов от кредитных должников на списание долгов — это отличный способ... <a href="<?= Url::to(['/lead/main/index',  '#' => 'leads-category']) ?>">подробнее  <svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M15.6325 5.92969L22.2083 11.9997L15.6325 18.0697" stroke="url(#paint0_linear_75_12222)" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M3.79163 12H22.0241" stroke="url(#paint1_linear_75_12222)" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                        <defs>
                                            <linearGradient id="paint0_linear_75_12222" x1="18.9204" y1="5.92969" x2="18.9204" y2="18.0697" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#DF2C56" />
                                                <stop offset="1" stop-color="#C81F47" />
                                            </linearGradient>
                                            <linearGradient id="paint1_linear_75_12222" x1="12.9079" y1="12" x2="12.9079" y2="13" gradientUnits="userSpaceOnUse">
                                                <stop stop-color="#DF2C56" />
                                                <stop offset="1" stop-color="#C81F47" />
                                            </linearGradient>
                                        </defs>
                                    </svg></a>
                            </p>

                        <p>от <span>350 руб./лид</span></p>
                    </div>
                </div>

            </div>
        </div>
        <!--        <div class="container">-->
        <!--            <a href="--><?php //= Url::to('/lead?filter%5Bcategory%5D%5B%5D=lidy-na-kredit&#TL_sec2')
                                    ?><!--"-->
        <!--                class="s8__top-link services-lead__btn">-->
        <!--                <p>Подробнее</p>-->
        <!--                <svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">-->
        <!--                    <path d="M15.6325 5.92969L22.2083 11.9997L15.6325 18.0697" stroke="url(#paint0_linear_75_12222)"-->
        <!--                        stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />-->
        <!--                    <path d="M3.79163 12H22.0241" stroke="url(#paint1_linear_75_12222)" stroke-width="1.5"-->
        <!--                        stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />-->
        <!--                    <defs>-->
        <!--                        <linearGradient id="paint0_linear_75_12222" x1="18.9204" y1="5.92969" x2="18.9204" y2="18.0697"-->
        <!--                            gradientUnits="userSpaceOnUse">-->
        <!--                            <stop stop-color="#DF2C56" />-->
        <!--                            <stop offset="1" stop-color="#C81F47" />-->
        <!--                        </linearGradient>-->
        <!--                        <linearGradient id="paint1_linear_75_12222" x1="12.9079" y1="12" x2="12.9079" y2="13"-->
        <!--                            gradientUnits="userSpaceOnUse">-->
        <!--                            <stop stop-color="#DF2C56" />-->
        <!--                            <stop offset="1" stop-color="#C81F47" />-->
        <!--                        </linearGradient>-->
        <!--                    </defs>-->
        <!--                </svg>-->
        <!--            </a>-->
        <!--        </div>-->
    </section>

    <section class="services-dev">
        <div class="container">
            <h2 class="services-dev__title">Услуги DEV.FORCE</h2>

            <div class="services-dev__text">
                <p>У нас вы можете заказать разработку продающих <span>landing page</span>,
                    а еще мы <span>подарим вам</span> авторский дизайн лендинга.</p>
                <p><span>Создадим интернет магазин</span> под ключ, установим онлайн кассу, интегрируем с CRM или 1C,
                    оптимизируем карточки, и начнем продвижение в ТОП 10 по СЕО.</p>
                <p><span>Настроим CRM Bitrix24</span>, amoCRM, 1с и прочие, интегрируем ваш бизнес в CRM систему,
                    допишем необходимый функционал, соединим сайт и CRM.</p>
                <p><span>Создадим серию посадочных страниц</span>, интегрируем вебинарные площадки, настроим чат-боты.
                    <span>Разработаем реферальную веб-программу</span>, создадим личные кабинеты, упакуем проект, начнем
                    продвигать в сети.
                    <span>Поможем продвинуть приложение</span> в сети. <span>Реализуем редизайн</span> вашего сайта и
                    много всего другого
                    по доступной цене и быстрыми сроками исполнения!
                </p>
            </div>
            <a href="https://dev-force.ru/services" class="s8__top-link" target="_blank">
                <p>Подробнее</p>
                <svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.6325 5.92969L22.2083 11.9997L15.6325 18.0697" stroke="url(#paint0_linear_75_12222)" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M3.79163 12H22.0241" stroke="url(#paint1_linear_75_12222)" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <defs>
                        <linearGradient id="paint0_linear_75_12222" x1="18.9204" y1="5.92969" x2="18.9204" y2="18.0697" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#DF2C56" />
                            <stop offset="1" stop-color="#C81F47" />
                        </linearGradient>
                        <linearGradient id="paint1_linear_75_12222" x1="12.9079" y1="12" x2="12.9079" y2="13" gradientUnits="userSpaceOnUse">
                            <stop stop-color="#DF2C56" />
                            <stop offset="1" stop-color="#C81F47" />
                        </linearGradient>
                    </defs>
                </svg>
            </a>
        </div>
    </section>

    <section class="baner-femida">
        <div class="container">
            <div class="baner-femida__content">
                <p class="baner-femida__logo">
                    FEMIDA.FORCE
                </p>
                <h2 class="baner-femida__title">
                    Готовый бизнес с нуля
                </h2>
                <p class="baner-femida__text">
                    FEMIDA.FORCE — это бизнес-сообщество, которое позволяет открыть своё дело в различных сферах
                    бизнеса, где мы являемся гарантами конверсии и бизнес-показателей
                </p>
                <a href="<?= Url::to(['/femida']) ?>" class="baner-femida__btn">
                    <span>Перейти на страницу</span>
                </a>
            </div>
        </div>
    </section>

    <section class="affiliate-program">
        <div class="container">
            <h2 class="affiliate-program__title">ПАРТНЕРСКАЯ ПРОГРАММА FORCE.ARBITR</h2>

            <div class="affiliate-program__wrap">
                <div class="affiliate-program__img">
                    <img src="<?= Url::to(['img/affiliate.svg']) ?>" alt="ПАРТНЕРСКАЯ ПРОГРАММА FORCE.ARBITR">
                </div>
                <div class="affiliate-program__block">
                    <p class="affiliate-program__descr">Делегируйте арбитражное управление своих банкротов
                        профессионалам с гарантией на снятие прожиточных минимумов в срок</p>
                    <ul class="affiliate-program__list">
                        <li>
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.0833 24.3626L7.25362 25.5308C6.27051 25.9367 5.77701 27.041 6.13045 28.0441L8.46602 34.6729C8.84685 35.7538 10.0562 36.2942 11.1155 35.8569L11.9964 35.4933C12.9795 35.0874 13.473 33.9831 13.1195 32.98L10.0833 24.3626ZM10.0833 24.3626L11.5326 15.3881C11.7753 13.8853 12.6894 12.5749 14.0159 11.8281L19.5472 8.71429C21.07 7.85701 22.93 7.85701 24.4528 8.71429L29.9841 11.8281C31.3106 12.5749 32.2247 13.8853 32.4674 15.3881L33.9167 24.3626M33.9167 24.3626L36.3156 24.8578C37.4816 25.0985 38.1804 26.2983 37.8145 27.4312L35.4987 34.6014C35.14 35.7118 33.9109 36.2807 32.8323 35.8354L30.25 34.7694M33.9167 24.3626L30.25 34.7694M30.25 34.7694C30.25 34.7694 28.2829 36.5976 25.6667 36.6616C23.6248 36.7115 21.5123 36.4114 20.1667 35.448" stroke="#DF2C56" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <p>Бесплатные консультации и аудит сложных банкротов</p>
                        </li>
                        <li>
                            <svg width="39" height="39" viewBox="0 0 39 39" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M34.125 19.5C34.125 27.5772 27.5772 34.125 19.5 34.125C11.4228 34.125 4.875 27.5772 4.875 19.5C4.875 11.4228 11.4228 4.875 19.5 4.875C22.0708 4.875 24.4867 5.53831 26.5858 6.70312" stroke="#DF2C56" stroke-width="2" stroke-linecap="round" />
                                <path d="M29.25 19.5C29.25 24.8848 24.8848 29.25 19.5 29.25C14.1152 29.25 9.75 24.8848 9.75 19.5C9.75 14.1152 14.1152 9.75 19.5 9.75C21.2139 9.75 22.8245 10.1922 24.2239 10.9688" stroke="#DF2C56" stroke-width="2" stroke-linecap="round" />
                                <path d="M24.2811 20.4522C23.7552 23.0928 21.1882 24.807 18.5477 24.281C15.9072 23.7551 14.193 21.1882 14.7189 18.5477C15.2448 15.9072 17.8117 14.1929 20.4523 14.7189" stroke="#DF2C56" stroke-width="2" stroke-linecap="round" />
                                <path d="M19.5 19.5L30.4688 12.1875M34.125 9.75L30.4688 12.1875M30.4688 12.1875L34.125 13M30.4688 12.1875L30.875 8.9375" stroke="#DF2C56" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p>Гарантия на арбитражное управление — 100% банкротим до конца</p>
                        </li>
                        <li>
                            <svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.5 15.8125V34.5C5.5 36.7091 7.29086 38.5 9.5 38.5H34.5C36.7091 38.5 38.5 36.7091 38.5 34.5V30.7656M5.5 15.8125H36.6667M5.5 15.8125L28.5295 6.87863C30.5193 6.10673 32.7647 7.03298 33.6315 8.9833L36.6667 15.8125M36.6667 15.8125V15.8125C37.6792 15.8125 38.5 16.6333 38.5 17.6458V23.5469M38.5 30.7656V27.1563V23.5469M38.5 30.7656H32.9427C30.9493 30.7656 29.3333 29.1497 29.3333 27.1563V27.1563C29.3333 25.1628 30.9493 23.5469 32.9427 23.5469H38.5" stroke="#DF2C56" stroke-width="2" stroke-linejoin="round" />
                            </svg>

                            <p>Гарантия на цену — никогда не увеличиваем стоимость услуг</p>
                        </li>
                        <li>
                            <svg width="40" height="35" viewBox="0 0 40 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.30439 13.7679L1.94103 10.1103C1.56393 9.92298 1.57306 9.38193 1.95626 9.20744L19.7743 1.09434C19.9059 1.03441 20.057 1.03441 20.1887 1.09434L38.6816 9.51474C38.854 9.59325 38.9672 9.76248 38.974 9.95183L39 10.6741M9.30439 13.7679L19.8257 17.4456C19.9269 17.4809 20.0367 17.4828 20.139 17.451L31.9932 13.7679M9.30439 13.7679V31.2786C9.30439 31.4957 9.44248 31.6871 9.64996 31.751C11.1505 32.2134 17.1985 34 21.0556 34C24.894 34 30.2918 32.2305 31.6653 31.7578C31.8643 31.6893 31.9932 31.5027 31.9932 31.2922V13.7679M31.9932 13.7679L36.6644 11.7054L39 10.6741M39 10.6741V20.2198" stroke="#DF2C56" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                            <p>База знаний из более чем 100 материалов по банкротству и списанию долгов</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <?php if (!empty($newses)) : ?>
        <section class="s8">
            <div class="container">

                <h3 class="s8__title title">
                    СТАТЬИ ДЛЯ БИЗНЕСА
                </h3>




                <div class="s8__inner">
                    <?php foreach ($newses as $k => $v) : ?>
                        <?php $date = date('d.m.Y', strtotime($v['date'])) ?>
                        <?php if ($date == date('d.m.Y')) {
                            $dateStr = 'Сегодня';
                        } elseif ($date == date('d.m.Y', time() - (60 * 60 * 24))) {
                            $dateStr = 'Вчера';
                        } else $dateStr = $date; ?>
                        <article class="s8__item news <?= $k % 7 == 0 ? 's8__item--1' : '' ?>">
                            <h5 class="news__title <?= $k % 7 == 0 ? 'news__title--1' : '' ?>">
                                <?= $v['title'] ?>
                            </h5>
                            <p class="news__text <?= $k % 7 == 0 ? 'news__text--1' : '' ?>">
                                <?php if ($k == 0) : ?>
                                    <?= mb_substr(strip_tags($v['content']), 0, 700) ?>...
                                <?php else : ?>
                                    <?= mb_substr(strip_tags($v['content']), 0, 200) ?>...

                                <?php endif; ?>
                            </p>
                            <p class="news__date <?= $k % 7 == 0 ? "" : '' ?>">
                                <?= $dateStr ?>
                            </p>
                            <a class="news__link--main" href="<?= Url::to(['news-page', 'link' => $v['link']]) ?>"></a>
                        </article>
                    <?php endforeach; ?>
                </div>
                <a href="<?= Url::to(['news']) ?>" class="s8__top-link">
                    <p>Все статьи</p>
                    <svg width="26" height="24" viewBox="0 0 26 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.6325 5.92969L22.2083 11.9997L15.6325 18.0697" stroke="url(#paint0_linear_75_12222)" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        <path d="M3.79163 12H22.0241" stroke="url(#paint1_linear_75_12222)" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        <defs>
                            <linearGradient id="paint0_linear_75_12222" x1="18.9204" y1="5.92969" x2="18.9204" y2="18.0697" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                            <linearGradient id="paint1_linear_75_12222" x1="12.9079" y1="12" x2="12.9079" y2="13" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                        </defs>
                    </svg>
                </a>
            </div>
        </section>
    <?php endif; ?>

    <section class="banner-reg">
        <div class="container">
            <div class="banner-reg__wrap">
                <h2 class="banner-reg__title">
                    Зарегистрируйся сейчас и получи 1 000₽ на баланс
                </h2>
                <p class="banner-reg__descr">
                    Получайте лиды, проходите курсы и настраивайте рекламу в одном кабинете
                </p>
                <a href="<?= Url::to(['registr?site=lead']) ?>" class="banner-reg__link">Регистрация</a>
            </div>
        </div>
    </section>

</main>