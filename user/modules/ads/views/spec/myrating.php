<?php

use yii\helpers\Url;
use yii\helpers\Html;

$js = <<< JS

$('.rating_tabs-text-btn').on('click', function(){
    $(this).toggleClass('text');
    $(this).prev().toggleClass('all');
    if($(this).hasClass('text')){
        $(this).text('Скрыть');
    }else{
        $(this).text('Читать полностью');
    }
});

$('.rating--btn-tab, .rating_top-right_group-item-num').on('click', function(){
    if($(this).hasClass('rating--btn-tab-0')){
        $('.rating_tabs').fadeOut(0);
        $('.rating-tab-0').fadeIn(0);
        $('.rating--btn-tab').removeClass('active');
        $('.rating--btn-tab-0').addClass('active');
    }else if($(this).hasClass('rating--btn-tab-1')){
        $('.rating_tabs').fadeOut(0);
        $('.rating-tab-1').fadeIn(0);
        $('.rating--btn-tab').removeClass('active');
        $('.rating--btn-tab-1').addClass('active');
    }else if($(this).hasClass('rating--btn-tab-2')){
        $('.rating_tabs').fadeOut(0);
        $('.rating-tab-2').fadeIn(0);
        $('.rating--btn-tab').removeClass('active');
        $('.rating--btn-tab-2').addClass('active');
    }else if($(this).hasClass('rating--btn-tab-3')){
        $('.rating_tabs').fadeOut(0);
        $('.rating-tab-3').fadeIn(0);
        $('.rating--btn-tab').removeClass('active');
        $('.rating--btn-tab-3').addClass('active');
    }else if($(this).hasClass('rating--btn-tab-4')){
        $('.rating_tabs').fadeOut(0);
        $('.rating-tab-4').fadeIn(0);
        $('.rating--btn-tab').removeClass('active');
        $('.rating--btn-tab-4').addClass('active');
    }else if($(this).hasClass('rating--btn-tab-5')){
        $('.rating_tabs').fadeOut(0);
        $('.rating-tab-5').fadeIn(0);
        $('.rating--btn-tab').removeClass('active');
        $('.rating--btn-tab-5').addClass('active');
    }
});

$('.rating_top-right_group-item-num').on('click', function(){
    var offset = $('.scrollTo').offset();
    var scroll = offset.top - 60;
    $('body,html').animate({scrollTop: scroll}, 500);
});

JS;
$this->registerJs($js);

$this->title = 'Мой рейтинг';
?>

<section class="rightInfo sp">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__span">
                    Мой рейтинг
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">Мой рейтинг</h1>
    </div>

    <div style="max-width: 100%; margin-bottom: 40px;" class="choose_main">
        <section class="spetialist-card">
            <p class="article-set-ttl">Ваша средняя оценка взаимодействия</p>
            <div class="rating_top">
                <div class="rating_top-left">
                    <div class="rating-indicator" style="background-image: conic-gradient(#EB38D2 220deg, transparent 0deg);">
                        <div class="rating-indicator-text">
                            3.5
                        </div>
                    </div>
                    <p class="rating_top-left-ttl">Почему это важно?</p>
                    <p class="rating_top-left-text">Исполнитель видит вашу средюю оценку за завершенные заказы. Это может повлиять на его решение о вашем взаимодействии</p>
                </div>
                <div class="rating_top-right">
                    <p class="rating_top-right-ttl">Статистика оценок</p>
                    <ul class="rating_top-right_group">
                        <li class="rating_top-right_group-item">
                            <p class="rating_top-right_group-item-text">5 звезд</p>
                            <div class="rating_top-right_group-item-line">
                                <div class="rating_top-right_group-item-line-fill red"></div>
                            </div>
                            <button class="rating_top-right_group-item-num rating--btn-tab-1">2</button>
                        </li>
                        <li class="rating_top-right_group-item">
                            <p class="rating_top-right_group-item-text">4 звезды</p>
                            <div class="rating_top-right_group-item-line">
                                <div class="rating_top-right_group-item-line-fill green"></div>
                            </div>
                            <button class="rating_top-right_group-item-num rating--btn-tab-2">8</button>
                        </li>
                        <li class="rating_top-right_group-item">
                            <p class="rating_top-right_group-item-text">3 звезды</p>
                            <div class="rating_top-right_group-item-line">
                                <div class="rating_top-right_group-item-line-fill purple"></div>
                            </div>
                            <button class="rating_top-right_group-item-num rating--btn-tab-3">12</button>
                        </li>
                        <li class="rating_top-right_group-item">
                            <p class="rating_top-right_group-item-text">2 звезды</p>
                            <div class="rating_top-right_group-item-line">
                                <div class="rating_top-right_group-item-line-fill skyblue"></div>
                            </div>
                            <button class="rating_top-right_group-item-num rating--btn-tab-4">1</button>
                        </li>
                        <li class="rating_top-right_group-item">
                            <p class="rating_top-right_group-item-text">1 звезда</p>
                            <div class="rating_top-right_group-item-line">
                                <div class="rating_top-right_group-item-line-fill orange"></div>
                            </div>
                            <button class="rating_top-right_group-item-num rating--btn-tab-5">1</button>
                        </li>
                    </ul>
                    <p class="rating_top-right-text">Всего оценок: <span>10</span></p>
                    <div style="margin: 28px 0px;" class="specialists_main-filter-line"></div>
                    <p class="rating_top-right-ttl">Статистика заказов</p>
                    <ul class="rating_top-right_group">
                        <li class="rating_top-right_group-item">
                            <p class="rating_top-right_group-item-text">оцененные</p>
                            <div class="rating_top-right_group-item-line">
                                <div class="rating_top-right_group-item-line-fill pink"></div>
                            </div>
                            <button class="rating_top-right_group-item-num rating--btn-tab-1">10</button>
                        </li>
                        <li class="rating_top-right_group-item">
                            <p class="rating_top-right_group-item-text">без оценки</p>
                            <div class="rating_top-right_group-item-line">
                                <div class="rating_top-right_group-item-line-fill blue"></div>
                            </div>
                            <button class="rating_top-right_group-item-num rating--btn-tab-0">8</button>
                        </li>
                    </ul>
                    <p class="rating_top-right-text">Всего заказов: <span>10</span></p>
                </div>
            </div>
        </section>

        <section class="spetialist-card scrollTo">
            <p class="article-set-ttl">Мои заказы</p>
            <div class="rating_tabs-btns">
                <button class="rating--btn-tab rating--btn-tab-0">без оценки</button>
                <button class="rating--btn-tab rating--btn-tab-1 active"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 11.9208L11.4279 13.9179C11.8308 14.1732 12.3311 13.7935 12.2115 13.3232L11.3008 9.74052C11.2752 9.64073 11.2782 9.53573 11.3096 9.4376C11.3409 9.33946 11.3994 9.25218 11.4781 9.18577L14.3049 6.83306C14.6763 6.52392 14.4846 5.90751 14.0074 5.87654L10.3159 5.63696C10.2165 5.62986 10.1211 5.59465 10.0409 5.53545C9.96069 5.47625 9.89896 5.39548 9.86289 5.30255L8.48612 1.83549C8.44869 1.73685 8.38215 1.65194 8.29532 1.59201C8.2085 1.53209 8.1055 1.5 8 1.5C7.89451 1.5 7.79151 1.53209 7.70468 1.59201C7.61786 1.65194 7.55131 1.73685 7.51389 1.83549L6.13712 5.30255C6.10104 5.39548 6.03931 5.47625 5.95912 5.53545C5.87892 5.59465 5.78355 5.62986 5.68412 5.63696L1.99263 5.87654C1.51544 5.90751 1.32373 6.52392 1.69515 6.83306L4.52185 9.18577C4.60063 9.25218 4.65906 9.33946 4.69044 9.4376C4.72181 9.53573 4.72485 9.64073 4.6992 9.74052L3.85459 13.063C3.71111 13.6274 4.31143 14.083 4.79495 13.7767L7.72431 11.9208C7.8067 11.8683 7.90234 11.8405 8 11.8405C8.09767 11.8405 8.1933 11.8683 8.27569 11.9208Z" fill="#5B617C" stroke="#5B617C" stroke-linecap="round" stroke-linejoin="round"/></svg>5</button>
                <button class="rating--btn-tab rating--btn-tab-2"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 11.9208L11.4279 13.9179C11.8308 14.1732 12.3311 13.7935 12.2115 13.3232L11.3008 9.74052C11.2752 9.64073 11.2782 9.53573 11.3096 9.4376C11.3409 9.33946 11.3994 9.25218 11.4781 9.18577L14.3049 6.83306C14.6763 6.52392 14.4846 5.90751 14.0074 5.87654L10.3159 5.63696C10.2165 5.62986 10.1211 5.59465 10.0409 5.53545C9.96069 5.47625 9.89896 5.39548 9.86289 5.30255L8.48612 1.83549C8.44869 1.73685 8.38215 1.65194 8.29532 1.59201C8.2085 1.53209 8.1055 1.5 8 1.5C7.89451 1.5 7.79151 1.53209 7.70468 1.59201C7.61786 1.65194 7.55131 1.73685 7.51389 1.83549L6.13712 5.30255C6.10104 5.39548 6.03931 5.47625 5.95912 5.53545C5.87892 5.59465 5.78355 5.62986 5.68412 5.63696L1.99263 5.87654C1.51544 5.90751 1.32373 6.52392 1.69515 6.83306L4.52185 9.18577C4.60063 9.25218 4.65906 9.33946 4.69044 9.4376C4.72181 9.53573 4.72485 9.64073 4.6992 9.74052L3.85459 13.063C3.71111 13.6274 4.31143 14.083 4.79495 13.7767L7.72431 11.9208C7.8067 11.8683 7.90234 11.8405 8 11.8405C8.09767 11.8405 8.1933 11.8683 8.27569 11.9208Z" fill="#5B617C" stroke="#5B617C" stroke-linecap="round" stroke-linejoin="round"/></svg>4</button>
                <button class="rating--btn-tab rating--btn-tab-3"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 11.9208L11.4279 13.9179C11.8308 14.1732 12.3311 13.7935 12.2115 13.3232L11.3008 9.74052C11.2752 9.64073 11.2782 9.53573 11.3096 9.4376C11.3409 9.33946 11.3994 9.25218 11.4781 9.18577L14.3049 6.83306C14.6763 6.52392 14.4846 5.90751 14.0074 5.87654L10.3159 5.63696C10.2165 5.62986 10.1211 5.59465 10.0409 5.53545C9.96069 5.47625 9.89896 5.39548 9.86289 5.30255L8.48612 1.83549C8.44869 1.73685 8.38215 1.65194 8.29532 1.59201C8.2085 1.53209 8.1055 1.5 8 1.5C7.89451 1.5 7.79151 1.53209 7.70468 1.59201C7.61786 1.65194 7.55131 1.73685 7.51389 1.83549L6.13712 5.30255C6.10104 5.39548 6.03931 5.47625 5.95912 5.53545C5.87892 5.59465 5.78355 5.62986 5.68412 5.63696L1.99263 5.87654C1.51544 5.90751 1.32373 6.52392 1.69515 6.83306L4.52185 9.18577C4.60063 9.25218 4.65906 9.33946 4.69044 9.4376C4.72181 9.53573 4.72485 9.64073 4.6992 9.74052L3.85459 13.063C3.71111 13.6274 4.31143 14.083 4.79495 13.7767L7.72431 11.9208C7.8067 11.8683 7.90234 11.8405 8 11.8405C8.09767 11.8405 8.1933 11.8683 8.27569 11.9208Z" fill="#5B617C" stroke="#5B617C" stroke-linecap="round" stroke-linejoin="round"/></svg>3</button>
                <button class="rating--btn-tab rating--btn-tab-4"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 11.9208L11.4279 13.9179C11.8308 14.1732 12.3311 13.7935 12.2115 13.3232L11.3008 9.74052C11.2752 9.64073 11.2782 9.53573 11.3096 9.4376C11.3409 9.33946 11.3994 9.25218 11.4781 9.18577L14.3049 6.83306C14.6763 6.52392 14.4846 5.90751 14.0074 5.87654L10.3159 5.63696C10.2165 5.62986 10.1211 5.59465 10.0409 5.53545C9.96069 5.47625 9.89896 5.39548 9.86289 5.30255L8.48612 1.83549C8.44869 1.73685 8.38215 1.65194 8.29532 1.59201C8.2085 1.53209 8.1055 1.5 8 1.5C7.89451 1.5 7.79151 1.53209 7.70468 1.59201C7.61786 1.65194 7.55131 1.73685 7.51389 1.83549L6.13712 5.30255C6.10104 5.39548 6.03931 5.47625 5.95912 5.53545C5.87892 5.59465 5.78355 5.62986 5.68412 5.63696L1.99263 5.87654C1.51544 5.90751 1.32373 6.52392 1.69515 6.83306L4.52185 9.18577C4.60063 9.25218 4.65906 9.33946 4.69044 9.4376C4.72181 9.53573 4.72485 9.64073 4.6992 9.74052L3.85459 13.063C3.71111 13.6274 4.31143 14.083 4.79495 13.7767L7.72431 11.9208C7.8067 11.8683 7.90234 11.8405 8 11.8405C8.09767 11.8405 8.1933 11.8683 8.27569 11.9208Z" fill="#5B617C" stroke="#5B617C" stroke-linecap="round" stroke-linejoin="round"/></svg>2</button>
                <button class="rating--btn-tab rating--btn-tab-5"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 11.9208L11.4279 13.9179C11.8308 14.1732 12.3311 13.7935 12.2115 13.3232L11.3008 9.74052C11.2752 9.64073 11.2782 9.53573 11.3096 9.4376C11.3409 9.33946 11.3994 9.25218 11.4781 9.18577L14.3049 6.83306C14.6763 6.52392 14.4846 5.90751 14.0074 5.87654L10.3159 5.63696C10.2165 5.62986 10.1211 5.59465 10.0409 5.53545C9.96069 5.47625 9.89896 5.39548 9.86289 5.30255L8.48612 1.83549C8.44869 1.73685 8.38215 1.65194 8.29532 1.59201C8.2085 1.53209 8.1055 1.5 8 1.5C7.89451 1.5 7.79151 1.53209 7.70468 1.59201C7.61786 1.65194 7.55131 1.73685 7.51389 1.83549L6.13712 5.30255C6.10104 5.39548 6.03931 5.47625 5.95912 5.53545C5.87892 5.59465 5.78355 5.62986 5.68412 5.63696L1.99263 5.87654C1.51544 5.90751 1.32373 6.52392 1.69515 6.83306L4.52185 9.18577C4.60063 9.25218 4.65906 9.33946 4.69044 9.4376C4.72181 9.53573 4.72485 9.64073 4.6992 9.74052L3.85459 13.063C3.71111 13.6274 4.31143 14.083 4.79495 13.7767L7.72431 11.9208C7.8067 11.8683 7.90234 11.8405 8 11.8405C8.09767 11.8405 8.1933 11.8683 8.27569 11.9208Z" fill="#5B617C" stroke="#5B617C" stroke-linecap="round" stroke-linejoin="round"/></svg>1</button>
            </div>

            <div class="rating_tabs_wrapper">
                <section class="rating_tabs rating-tab-0">
                    <div class="rating-tab_container">
                        <section class="rating-tab-item">
                            <div class="rating-tab-item_top">
                                <div class="rating-tab-item_top_left">
                                    <div class="rating-tab-item_top_left-image">
                                        <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                    </div>
                                    <p class="rating-tab-item_top_left-name">Константин Александров</p>
                                </div>
                                <p class="rating-tab-item_top-date">22.01.2022</p>
                            </div>
                            <h2 class="rating-tab-item-title">Реклама youtube-канала «Про книги»</h2>
                            <p class="rating_tabs-tt">отзыв исполнителя</p>
                            <p class="rating_tabs-text">Очень ответственный заказчик! Все договоренности и условия работы через сервис соблюдала! Кроме этого всегда на связи и предоставляла всю необходимую информацию, спорные вопросы обсуждали. В общем доволен сотрудничеством и всем рекомендую! Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem iusto esse similique explicabo saepe sapiente veritatis rerum architecto suscipit eligendi, ipsam voluptates culpa, adipisci veniam quaerat distinctio est praesentium? Aut. Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe ratione obcaecati et? Deleniti repellendus cupiditate necessitatibus dolorem sed labore expedita voluptates ab quam tempore corrupti nisi sapiente voluptatibus, minima numquam?</p>
                            <button class="rating_tabs-text-btn">Читать полностью</button>
                            <p class="rating_tabs-tt">выполненная услуга</p>
                            <div class="rating_tabs-group">
                                <ul style="max-width: 420px; margin: 0px;" class="spetialist-card_tags">
                                    <li>#поисковые системы</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Telegram</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                </ul>
                                <div class="rating_tabs-group-right">
                                    <p class="rating_tabs-tt">оценка</p>
                                    <p class="rating_tabs-group-right-rat">4.9</p>
                                </div>
                            </div>
                            <a class="link--purple" style="text-decoration: none;" href="<?= Url::to(['orderpage']) ?>">Подробнее о заказе</a>
                        </section>
                    </div>
                </section>
    
                <section class="rating_tabs rating-tab-1">
                    <div class="rating-tab_container">
                        <section class="rating-tab-item">
                            <div class="rating-tab-item_top">
                                <div class="rating-tab-item_top_left">
                                    <div class="rating-tab-item_top_left-image">
                                        <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                    </div>
                                    <p class="rating-tab-item_top_left-name">Константин Александров</p>
                                </div>
                                <p class="rating-tab-item_top-date">22.01.2022</p>
                            </div>
                            <h2 class="rating-tab-item-title">Реклама youtube-канала «Про книги»</h2>
                            <p class="rating_tabs-tt">отзыв исполнителя</p>
                            <p class="rating_tabs-text">Очень ответственный заказчик! Все договоренности и условия работы через сервис соблюдала! Кроме этого всегда на связи и предоставляла всю необходимую информацию, спорные вопросы обсуждали. В общем доволен сотрудничеством и всем рекомендую! Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem iusto esse similique explicabo saepe sapiente veritatis rerum architecto suscipit eligendi, ipsam voluptates culpa, adipisci veniam quaerat distinctio est praesentium? Aut. Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe ratione obcaecati et? Deleniti repellendus cupiditate necessitatibus dolorem sed labore expedita voluptates ab quam tempore corrupti nisi sapiente voluptatibus, minima numquam?</p>
                            <button class="rating_tabs-text-btn">Читать полностью</button>
                            <p class="rating_tabs-tt">выполненная услуга</p>
                            <div class="rating_tabs-group">
                                <ul style="max-width: 420px; margin: 0px;" class="spetialist-card_tags">
                                    <li>#поисковые системы</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Telegram</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                </ul>
                                <div class="rating_tabs-group-right">
                                    <p class="rating_tabs-tt">оценка</p>
                                    <p class="rating_tabs-group-right-rat">4.9</p>
                                </div>
                            </div>
                            <a class="link--purple" style="text-decoration: none;" href="<?= Url::to(['orderpage']) ?>">Подробнее о заказе</a>
                        </section>
                        <section class="rating-tab-item">
                            <div class="rating-tab-item_top">
                                <div class="rating-tab-item_top_left">
                                    <div class="rating-tab-item_top_left-image">
                                        <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                    </div>
                                    <p class="rating-tab-item_top_left-name">Константин Александров</p>
                                </div>
                                <p class="rating-tab-item_top-date">22.01.2022</p>
                            </div>
                            <h2 class="rating-tab-item-title">Реклама youtube-канала «Про книги»</h2>
                            <p class="rating_tabs-tt">отзыв исполнителя</p>
                            <p class="rating_tabs-text">Очень ответственный заказчик! Все договоренности и условия работы через сервис соблюдала! Кроме этого всегда на связи и предоставляла всю необходимую информацию, спорные вопросы обсуждали. В общем доволен сотрудничеством и всем рекомендую! Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem iusto esse similique explicabo saepe sapiente veritatis rerum architecto suscipit eligendi, ipsam voluptates culpa, adipisci veniam quaerat distinctio est praesentium? Aut. Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe ratione obcaecati et? Deleniti repellendus cupiditate necessitatibus dolorem sed labore expedita voluptates ab quam tempore corrupti nisi sapiente voluptatibus, minima numquam?</p>
                            <button class="rating_tabs-text-btn">Читать полностью</button>
                            <p class="rating_tabs-tt">выполненная услуга</p>
                            <div class="rating_tabs-group">
                                <ul style="max-width: 420px; margin: 0px;" class="spetialist-card_tags">
                                    <li>#поисковые системы</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Telegram</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                </ul>
                                <div class="rating_tabs-group-right">
                                    <p class="rating_tabs-tt">оценка</p>
                                    <p class="rating_tabs-group-right-rat">4.9</p>
                                </div>
                            </div>
                            <a class="link--purple" style="text-decoration: none;" href="<?= Url::to(['orderpage']) ?>">Подробнее о заказе</a>
                        </section>
                        <section class="rating-tab-item">
                            <div class="rating-tab-item_top">
                                <div class="rating-tab-item_top_left">
                                    <div class="rating-tab-item_top_left-image">
                                        <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                    </div>
                                    <p class="rating-tab-item_top_left-name">Константин Александров</p>
                                </div>
                                <p class="rating-tab-item_top-date">22.01.2022</p>
                            </div>
                            <h2 class="rating-tab-item-title">Реклама youtube-канала «Про книги»</h2>
                            <p class="rating_tabs-tt">отзыв исполнителя</p>
                            <p class="rating_tabs-text">Очень ответственный заказчик! Все договоренности и условия работы через сервис соблюдала! Кроме этого всегда на связи и предоставляла всю необходимую информацию, спорные вопросы обсуждали. В общем доволен сотрудничеством и всем рекомендую! Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem iusto esse similique explicabo saepe sapiente veritatis rerum architecto suscipit eligendi, ipsam voluptates culpa, adipisci veniam quaerat distinctio est praesentium? Aut. Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe ratione obcaecati et? Deleniti repellendus cupiditate necessitatibus dolorem sed labore expedita voluptates ab quam tempore corrupti nisi sapiente voluptatibus, minima numquam?</p>
                            <button class="rating_tabs-text-btn">Читать полностью</button>
                            <p class="rating_tabs-tt">выполненная услуга</p>
                            <div class="rating_tabs-group">
                                <ul style="max-width: 420px; margin: 0px;" class="spetialist-card_tags">
                                    <li>#поисковые системы</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Telegram</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                </ul>
                                <div class="rating_tabs-group-right">
                                    <p class="rating_tabs-tt">оценка</p>
                                    <p class="rating_tabs-group-right-rat">4.9</p>
                                </div>
                            </div>
                            <a class="link--purple" style="text-decoration: none;" href="<?= Url::to(['orderpage']) ?>">Подробнее о заказе</a>
                        </section>
                    </div>
                </section>
    
                <section class="rating_tabs rating-tab-2">
                    <div class="rating-tab_container">
                        <section class="rating-tab-item">
                            <div class="rating-tab-item_top">
                                <div class="rating-tab-item_top_left">
                                    <div class="rating-tab-item_top_left-image">
                                        <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                    </div>
                                    <p class="rating-tab-item_top_left-name">Константин Александров</p>
                                </div>
                                <p class="rating-tab-item_top-date">22.01.2022</p>
                            </div>
                            <h2 class="rating-tab-item-title">Реклама youtube-канала «Про книги»</h2>
                            <p class="rating_tabs-tt">отзыв исполнителя</p>
                            <p class="rating_tabs-text">Очень ответственный заказчик! Все договоренности и условия работы через сервис соблюдала! Кроме этого всегда на связи и предоставляла всю необходимую информацию, спорные вопросы обсуждали. В общем доволен сотрудничеством и всем рекомендую! Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem iusto esse similique explicabo saepe sapiente veritatis rerum architecto suscipit eligendi, ipsam voluptates culpa, adipisci veniam quaerat distinctio est praesentium? Aut. Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe ratione obcaecati et? Deleniti repellendus cupiditate necessitatibus dolorem sed labore expedita voluptates ab quam tempore corrupti nisi sapiente voluptatibus, minima numquam?</p>
                            <button class="rating_tabs-text-btn">Читать полностью</button>
                            <p class="rating_tabs-tt">выполненная услуга</p>
                            <div class="rating_tabs-group">
                                <ul style="max-width: 420px; margin: 0px;" class="spetialist-card_tags">
                                    <li>#поисковые системы</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Telegram</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                </ul>
                                <div class="rating_tabs-group-right">
                                    <p class="rating_tabs-tt">оценка</p>
                                    <p class="rating_tabs-group-right-rat">4.9</p>
                                </div>
                            </div>
                            <a class="link--purple" style="text-decoration: none;" href="<?= Url::to(['orderpage']) ?>">Подробнее о заказе</a>
                        </section>
                    </div>
                </section>
    
                <section class="rating_tabs rating-tab-3">
                    <div class="rating-tab_container">
                        <section class="rating-tab-item">
                            <div class="rating-tab-item_top">
                                <div class="rating-tab-item_top_left">
                                    <div class="rating-tab-item_top_left-image">
                                        <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                    </div>
                                    <p class="rating-tab-item_top_left-name">Константин Александров</p>
                                </div>
                                <p class="rating-tab-item_top-date">22.01.2022</p>
                            </div>
                            <h2 class="rating-tab-item-title">Реклама youtube-канала «Про книги»</h2>
                            <p class="rating_tabs-tt">отзыв исполнителя</p>
                            <p class="rating_tabs-text">Очень ответственный заказчик! Все договоренности и условия работы через сервис соблюдала! Кроме этого всегда на связи и предоставляла всю необходимую информацию, спорные вопросы обсуждали. В общем доволен сотрудничеством и всем рекомендую! Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem iusto esse similique explicabo saepe sapiente veritatis rerum architecto suscipit eligendi, ipsam voluptates culpa, adipisci veniam quaerat distinctio est praesentium? Aut. Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe ratione obcaecati et? Deleniti repellendus cupiditate necessitatibus dolorem sed labore expedita voluptates ab quam tempore corrupti nisi sapiente voluptatibus, minima numquam?</p>
                            <button class="rating_tabs-text-btn">Читать полностью</button>
                            <p class="rating_tabs-tt">выполненная услуга</p>
                            <div class="rating_tabs-group">
                                <ul style="max-width: 420px; margin: 0px;" class="spetialist-card_tags">
                                    <li>#поисковые системы</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Telegram</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                </ul>
                                <div class="rating_tabs-group-right">
                                    <p class="rating_tabs-tt">оценка</p>
                                    <p class="rating_tabs-group-right-rat">4.9</p>
                                </div>
                            </div>
                            <a class="link--purple" style="text-decoration: none;" href="<?= Url::to(['orderpage']) ?>">Подробнее о заказе</a>
                        </section>
                    </div>
                </section>
    
                <section class="rating_tabs rating-tab-4">
                    <div class="rating-tab_container">
                        <section class="rating-tab-item">
                            <div class="rating-tab-item_top">
                                <div class="rating-tab-item_top_left">
                                    <div class="rating-tab-item_top_left-image">
                                        <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                    </div>
                                    <p class="rating-tab-item_top_left-name">Константин Александров</p>
                                </div>
                                <p class="rating-tab-item_top-date">22.01.2022</p>
                            </div>
                            <h2 class="rating-tab-item-title">Реклама youtube-канала «Про книги»</h2>
                            <p class="rating_tabs-tt">отзыв исполнителя</p>
                            <p class="rating_tabs-text">Очень ответственный заказчик! Все договоренности и условия работы через сервис соблюдала! Кроме этого всегда на связи и предоставляла всю необходимую информацию, спорные вопросы обсуждали. В общем доволен сотрудничеством и всем рекомендую! Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem iusto esse similique explicabo saepe sapiente veritatis rerum architecto suscipit eligendi, ipsam voluptates culpa, adipisci veniam quaerat distinctio est praesentium? Aut. Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe ratione obcaecati et? Deleniti repellendus cupiditate necessitatibus dolorem sed labore expedita voluptates ab quam tempore corrupti nisi sapiente voluptatibus, minima numquam?</p>
                            <button class="rating_tabs-text-btn">Читать полностью</button>
                            <p class="rating_tabs-tt">выполненная услуга</p>
                            <div class="rating_tabs-group">
                                <ul style="max-width: 420px; margin: 0px;" class="spetialist-card_tags">
                                    <li>#поисковые системы</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Telegram</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                </ul>
                                <div class="rating_tabs-group-right">
                                    <p class="rating_tabs-tt">оценка</p>
                                    <p class="rating_tabs-group-right-rat">4.9</p>
                                </div>
                            </div>
                            <a class="link--purple" style="text-decoration: none;" href="<?= Url::to(['orderpage']) ?>">Подробнее о заказе</a>
                        </section>
                    </div>
                </section>
    
                <section class="rating_tabs rating-tab-5">
                    <div class="rating-tab_container">
                        <section class="rating-tab-item">
                            <div class="rating-tab-item_top">
                                <div class="rating-tab-item_top_left">
                                    <div class="rating-tab-item_top_left-image">
                                        <img src="<?= Url::to(['/img/afo/best1.svg']) ?>" alt="Константин Александров">
                                    </div>
                                    <p class="rating-tab-item_top_left-name">Константин Александров</p>
                                </div>
                                <p class="rating-tab-item_top-date">22.01.2022</p>
                            </div>
                            <h2 class="rating-tab-item-title">Реклама youtube-канала «Про книги»</h2>
                            <p class="rating_tabs-tt">отзыв исполнителя</p>
                            <p class="rating_tabs-text">Очень ответственный заказчик! Все договоренности и условия работы через сервис соблюдала! Кроме этого всегда на связи и предоставляла всю необходимую информацию, спорные вопросы обсуждали. В общем доволен сотрудничеством и всем рекомендую! Lorem ipsum dolor sit amet consectetur adipisicing elit. Exercitationem iusto esse similique explicabo saepe sapiente veritatis rerum architecto suscipit eligendi, ipsam voluptates culpa, adipisci veniam quaerat distinctio est praesentium? Aut. Lorem ipsum dolor sit amet consectetur adipisicing elit. Saepe ratione obcaecati et? Deleniti repellendus cupiditate necessitatibus dolorem sed labore expedita voluptates ab quam tempore corrupti nisi sapiente voluptatibus, minima numquam?</p>
                            <button class="rating_tabs-text-btn">Читать полностью</button>
                            <p class="rating_tabs-tt">выполненная услуга</p>
                            <div class="rating_tabs-group">
                                <ul style="max-width: 420px; margin: 0px;" class="spetialist-card_tags">
                                    <li>#поисковые системы</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Telegram</li>
                                    <li>#SEO-оптимизация</li>
                                    <li>#e-mail маркетинг</li>
                                    <li>#Facebook</li>
                                </ul>
                                <div class="rating_tabs-group-right">
                                    <p class="rating_tabs-tt">оценка</p>
                                    <p class="rating_tabs-group-right-rat">4.9</p>
                                </div>
                            </div>
                            <a class="link--purple" style="text-decoration: none;" href="<?= Url::to(['orderpage']) ?>">Подробнее о заказе</a>
                        </section>
                    </div>
                </section>
            </div>
        </section>
    </div>

    <footer class="footer">
        <div class="container container--body">
            <a href="<?= Url::to(['manual']) ?>" class="footer__link">
                Руководство пользователя
            </a>
            <a href="<?= Url::to(['support']) ?>" class="footer__link">
                Тех.поддержка
            </a>
        </div>
    </footer>
</section>