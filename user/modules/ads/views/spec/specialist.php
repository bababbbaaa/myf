<?php

use yii\helpers\Url;
use yii\helpers\Html;

$js = <<< JS
    $('.specialist-main_card_list-item--btn').on('click', function(){
        $('.popups-back').fadeIn(300);
        $('.popup-case').fadeIn(300);
    });

    $('.popups-back, .popup-close, .popup-order-close').on('click', function(){
        $('.popups-back').fadeOut(300);
        $('.popup').fadeOut(300);
    });

    $('.specialist_card--btn').on('click', function(){
        $('.popups-back').fadeIn(300);
        $('.popup-order').fadeIn(300);
    });

    $('.specialist-main_tabs-wrapper--btn').on('click', function(){
        $('.specialist-main_tabs-wrapper--btn').removeClass('active');
        $(this).addClass('active');

        if($(this).hasClass('specialist-main_tabs-wrapper--btn-1')){
            $('.specialist-main-tab-2').hide(0, function(){
                $('.specialist-main-tab-1').show(0);
            });
        }else if($(this).hasClass('specialist-main_tabs-wrapper--btn-2')){
            $('.specialist-main-tab-1').hide(0, function(){
                $('.specialist-main-tab-2').show(0);
            });
        }
    });
JS;
$this->registerJs($js);

$this->title = 'Святослав Василевский';
?>

<section class="rightInfo sp">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__link">
                    Выбрать исполнителя
                </span>
            </li>
            <li class="bcr__item">
                <a class="bcr__link" href="<?= Url::to(['choose']) ?>">Все исполнители</a>
            </li>
            <li class="bcr__item">
                <span class="bcr__span">
                    Святослав Василевский
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">Святослав Василевский</h1>
    </div>

    <article class="choose">
        <div class="choose_main">
            <section class="specialist-main_card">
                <h2 class="specialist-main_card-ttl">обо мне</h2>
                <p class="specialist-main_card-text">Я просто люблю то, что делаю <br> Внимателен к деталям, очень люблю анализировать информацию и делать выводы. <br><br> В рамках работы оцениваю все ситуации исходя из сухой статистики — цифры не врут. <br><br> С моими работами можно ознакомиться по ссылке <a target="_blank" href="">www.pabota.ru</a></p>
            </section>
            <section class="specialist-main_card">
                <h2 class="specialist-main_card-ttl">портфолио</h2>
                <ul class="specialist-main_card_list">
                    <li class="specialist-main_card_list-item">
                        <div class="specialist-main_card_list-item-image">
                            <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                        </div>
                        <h3 class="specialist-main_card_list-item-ttl">Реклама youtube-канала «Про книги»</h3>
                        <button class="specialist-main_card_list-item--btn"></button>
                    </li>
                </ul>
                <button style="text-decoration: none;" class="link--purple">Открыть еще +</button>
            </section>

            <div class="specialist-main_tabs-wrapper">
                <section class="specialist-main_tabs-wrapper-btns">
                    <button class="specialist-main_tabs-wrapper--btn specialist-main_tabs-wrapper--btn-1 active">Выполненные заказы <span>65</span></button>
                    <button class="specialist-main_tabs-wrapper--btn specialist-main_tabs-wrapper--btn-2">Отзывы <span>45</span></button>
                </section>

                <section class="specialist-main-tab specialist-main-tab-1">
                    <div class="specialist-main-tab_container">
                        <ul class="specialist-main-tab_orders">
                            <li class="specialist-main-tab_orders-item">
                                <p class="specialist-main-tab_orders-item-top">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.1875 3C3.08395 3 3 3.08395 3 3.1875V9.5625C3 9.66605 3.08395 9.75 3.1875 9.75H9.5625C9.66605 9.75 9.75 9.66605 9.75 9.5625V3.1875C9.75 3.08395 9.66605 3 9.5625 3H3.1875ZM1.5 3.1875C1.5 2.25552 2.25552 1.5 3.1875 1.5H9.5625C10.4945 1.5 11.25 2.25552 11.25 3.1875V9.5625C11.25 10.4945 10.4945 11.25 9.5625 11.25H3.1875C2.25552 11.25 1.5 10.4945 1.5 9.5625V3.1875ZM14.4375 3C14.3339 3 14.25 3.08395 14.25 3.1875V9.5625C14.25 9.66605 14.3339 9.75 14.4375 9.75H20.8125C20.9161 9.75 21 9.66605 21 9.5625V3.1875C21 3.08395 20.9161 3 20.8125 3H14.4375ZM12.75 3.1875C12.75 2.25552 13.5055 1.5 14.4375 1.5H20.8125C21.7445 1.5 22.5 2.25552 22.5 3.1875V9.5625C22.5 10.4945 21.7445 11.25 20.8125 11.25H14.4375C13.5055 11.25 12.75 10.4945 12.75 9.5625V3.1875ZM3.1875 14.25C3.08395 14.25 3 14.3339 3 14.4375V20.8125C3 20.9161 3.08395 21 3.1875 21H9.5625C9.66605 21 9.75 20.9161 9.75 20.8125V14.4375C9.75 14.3339 9.66605 14.25 9.5625 14.25H3.1875ZM1.5 14.4375C1.5 13.5055 2.25552 12.75 3.1875 12.75H9.5625C10.4945 12.75 11.25 13.5055 11.25 14.4375V20.8125C11.25 21.7445 10.4945 22.5 9.5625 22.5H3.1875C2.25552 22.5 1.5 21.7445 1.5 20.8125V14.4375ZM14.4375 14.25C14.3339 14.25 14.25 14.3339 14.25 14.4375V20.8125C14.25 20.9161 14.3339 21 14.4375 21H20.8125C20.9161 21 21 20.9161 21 20.8125V14.4375C21 14.3339 20.9161 14.25 20.8125 14.25H14.4375ZM12.75 14.4375C12.75 13.5055 13.5055 12.75 14.4375 12.75H20.8125C21.7445 12.75 22.5 13.5055 22.5 14.4375V20.8125C22.5 21.7445 21.7445 22.5 20.8125 22.5H14.4375C13.5055 22.5 12.75 21.7445 12.75 20.8125V14.4375Z" fill="#373737"/></svg>
                                    
                                    Реклама youtube-канала «Про книги»
                                </p>
                                <div class="specialist-main-tab_orders-item_main">
                                    <p class="specialist-main-tab_orders-item_main-text">Нужно проработать маркетинговую стратегию продвижения канала, настроить рекламу в Instagram, Telegram, Youtube. </p>
                                    <div class="specialist-main-tab_orders-item_main-group">
                                        <p class="specialist-main-tab_orders-item_main-group-title">заказчик</p>
                                        <div class="specialist-main-tab_orders-item_main-group-g">
                                            <div class="specialist-main-tab_orders-item_main-group-g-img">
                                                <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                                            </div>
                                            <p class="specialist-main-tab_orders-item_main-group-g-name">Иван Фёдеров</p>
                                        </div>
                                    </div>
                                    <div class="specialist-main-tab_orders-item_main-group">
                                        <p class="specialist-main-tab_orders-item_main-group-title">выполненная услуга</p>
                                        <ul class="specialist-main-tab_orders-item_main-group-ul">
                                            <li>#Facebook</li>
                                            <li>#Telegram</li>
                                            <li>#маркетинговые стратегии</li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                            <li class="specialist-main-tab_orders-item">
                                <p class="specialist-main-tab_orders-item-top">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M3.1875 3C3.08395 3 3 3.08395 3 3.1875V9.5625C3 9.66605 3.08395 9.75 3.1875 9.75H9.5625C9.66605 9.75 9.75 9.66605 9.75 9.5625V3.1875C9.75 3.08395 9.66605 3 9.5625 3H3.1875ZM1.5 3.1875C1.5 2.25552 2.25552 1.5 3.1875 1.5H9.5625C10.4945 1.5 11.25 2.25552 11.25 3.1875V9.5625C11.25 10.4945 10.4945 11.25 9.5625 11.25H3.1875C2.25552 11.25 1.5 10.4945 1.5 9.5625V3.1875ZM14.4375 3C14.3339 3 14.25 3.08395 14.25 3.1875V9.5625C14.25 9.66605 14.3339 9.75 14.4375 9.75H20.8125C20.9161 9.75 21 9.66605 21 9.5625V3.1875C21 3.08395 20.9161 3 20.8125 3H14.4375ZM12.75 3.1875C12.75 2.25552 13.5055 1.5 14.4375 1.5H20.8125C21.7445 1.5 22.5 2.25552 22.5 3.1875V9.5625C22.5 10.4945 21.7445 11.25 20.8125 11.25H14.4375C13.5055 11.25 12.75 10.4945 12.75 9.5625V3.1875ZM3.1875 14.25C3.08395 14.25 3 14.3339 3 14.4375V20.8125C3 20.9161 3.08395 21 3.1875 21H9.5625C9.66605 21 9.75 20.9161 9.75 20.8125V14.4375C9.75 14.3339 9.66605 14.25 9.5625 14.25H3.1875ZM1.5 14.4375C1.5 13.5055 2.25552 12.75 3.1875 12.75H9.5625C10.4945 12.75 11.25 13.5055 11.25 14.4375V20.8125C11.25 21.7445 10.4945 22.5 9.5625 22.5H3.1875C2.25552 22.5 1.5 21.7445 1.5 20.8125V14.4375ZM14.4375 14.25C14.3339 14.25 14.25 14.3339 14.25 14.4375V20.8125C14.25 20.9161 14.3339 21 14.4375 21H20.8125C20.9161 21 21 20.9161 21 20.8125V14.4375C21 14.3339 20.9161 14.25 20.8125 14.25H14.4375ZM12.75 14.4375C12.75 13.5055 13.5055 12.75 14.4375 12.75H20.8125C21.7445 12.75 22.5 13.5055 22.5 14.4375V20.8125C22.5 21.7445 21.7445 22.5 20.8125 22.5H14.4375C13.5055 22.5 12.75 21.7445 12.75 20.8125V14.4375Z" fill="#373737"/></svg>
                                    
                                    Реклама youtube-канала «Про книги»
                                </p>
                                <div class="specialist-main-tab_orders-item_main">
                                    <p class="specialist-main-tab_orders-item_main-text">Нужно проработать маркетинговую стратегию продвижения канала, настроить рекламу в Instagram, Telegram, Youtube. </p>
                                    <div class="specialist-main-tab_orders-item_main-group">
                                        <p class="specialist-main-tab_orders-item_main-group-title">заказчик</p>
                                        <div class="specialist-main-tab_orders-item_main-group-g">
                                            <div class="specialist-main-tab_orders-item_main-group-g-img">
                                                <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                                            </div>
                                            <p class="specialist-main-tab_orders-item_main-group-g-name">Иван Фёдеров</p>
                                        </div>
                                    </div>
                                    <div class="specialist-main-tab_orders-item_main-group">
                                        <p class="specialist-main-tab_orders-item_main-group-title">выполненная услуга</p>
                                        <ul class="specialist-main-tab_orders-item_main-group-ul">
                                            <li>#Facebook</li>
                                            <li>#Telegram</li>
                                            <li>#маркетинговые стратегии</li>
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <button style="text-decoration: none;" class="link--purple">Открыть еще +</button>
                    </div>
                </section>

                <section class="specialist-main-tab specialist-main-tab-2">
                    <div class="specialist-main-tab_container">
                        <ul class="specialist-main-tab_orders">
                            <li class="specialist-main-tab_orders-item">
                                <div class="specialist-main-tab_orders-item_top specialist-main-tab_rew-item_top">
                                    <div class="specialist-main-tab_orders-item_main-group-g">
                                        <div class="specialist-main-tab_orders-item_main-group-g-img">
                                            <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                                        </div>
                                        <p class="specialist-main-tab_orders-item_main-group-g-name">Иван Фёдеров</p>
                                    </div>
                                    <p class="specialist-main-tab_orders-item_top-date">22.01.2022</p>
                                </div>
                                <p class="specialist-main-tab_rew-item-text">Заказал SEO продвижение сайта. За первую неделю пришло более 1 000 подписчиков. Буду сотрудничать в будущем</p>
                                <div class="specialist-main-tab_rew-item_bottom">
                                    <div class="specialist-main-tab_rew-item_bottom-left">
                                        <p class="specialist-main-tab_rew-item_bottom-ttl">выполненная услуга</p>
                                        <ul class="specialist-main-tab_orders-item_main-group-ul">
                                            <li>#Facebook</li>
                                            <li>#Telegram</li>
                                            <li>#маркетинговые стратегии</li>
                                        </ul>
                                    </div>
                                    <div class="specialist-main-tab_rew-item_bottom-right">
                                        <p class="specialist-main-tab_rew-item_bottom-ttl">оценка</p>
                                        <p class="specialist-main-tab_rew-item_bottom-rat">4.9</p>
                                    </div>
                                </div>
                            </li>
                            <li class="specialist-main-tab_orders-item">
                                <div class="specialist-main-tab_orders-item_top specialist-main-tab_rew-item_top">
                                    <div class="specialist-main-tab_orders-item_main-group-g">
                                        <div class="specialist-main-tab_orders-item_main-group-g-img">
                                            <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                                        </div>
                                        <p class="specialist-main-tab_orders-item_main-group-g-name">Иван Фёдеров</p>
                                    </div>
                                    <p class="specialist-main-tab_orders-item_top-date">22.01.2022</p>
                                </div>
                                <p class="specialist-main-tab_rew-item-text">Заказал SEO продвижение сайта. За первую неделю пришло более 1 000 подписчиков. Буду сотрудничать в будущем</p>
                                <div class="specialist-main-tab_rew-item_bottom">
                                    <div class="specialist-main-tab_rew-item_bottom-left">
                                        <p class="specialist-main-tab_rew-item_bottom-ttl">выполненная услуга</p>
                                        <ul class="specialist-main-tab_orders-item_main-group-ul">
                                            <li>#Facebook</li>
                                            <li>#Telegram</li>
                                            <li>#маркетинговые стратегии</li>
                                        </ul>
                                    </div>
                                    <div class="specialist-main-tab_rew-item_bottom-right">
                                        <p class="specialist-main-tab_rew-item_bottom-ttl">оценка</p>
                                        <p class="specialist-main-tab_rew-item_bottom-rat">4.9</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <button style="text-decoration: none;" class="link--purple">Открыть еще +</button>
                    </div>
                </section>
            </div>
        </div>
        <div class="specialist_right">
            <section class="specialist_card">
                <div class="specialist_card_top">
                    <div class="specialist_card_top-image">
                        <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                    </div>
                    <div class="specialist_card_top_right">
                        <div class="specialist_card_top_right-top">
                            <p class="spetialist-card_top_right-rating">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <span>5.0</spa>
                            </p>
                            <div class="spetialist-card_top_right-spetial">
                                <img src="<?= Url::to('/img/afo/best3.svg') ?>" alt="1">
                                <p class="spetialist-card_top_right-spetial-txt">адепт</p>
                            </div>
                        </div>
                        <div class="specialist_card_top_right_btn">
                            <p class="specialist_card_top_right_btn-t">зарегистрирован</p>
                            <p class="specialist_card_top_right_btn-date">12.01.2022</p>
                        </div>
                    </div>
                </div>
                <p class="specialist_card-name">Святослав Василевский</p>
                <p class="specialist_card-ttl">специализации</p>
                <ul class="spetialist-card_tags">
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
                <p class="specialist_card-ttl">Статистика заказов</p>
                <div class="specialist_card-group">
                    <div class="specialist_card-group-item">
                        <p class="specialist_card-group-item-t">Всего</p>
                        <p class="specialist_card-group-item-t">6</p>
                    </div>
                    <div class="specialist_card-group-item">
                        <p class="specialist_card-group-item-t">В работе</p>
                        <p class="specialist_card-group-item-t">2</p>
                    </div>
                    <div class="specialist_card-group-item">
                        <p class="specialist_card-group-item-t">Завершенные</p>
                        <p class="specialist_card-group-item-t">4</p>
                    </div>
                </div>
                <button class="btn--purple specialist_card--btn">Предложить заказ</button>
                <button class="specialist_card--btn-massage">Написать исполнителю</button>
            </section>

            <section class="specialist_card order">
                <p class="specialist_card-ttl">отклик на ваш заказ</p>
                <div class="specialist_card-g">
                    <p class="specialist_card-g-ttl">Предложенный дедлайн</p>
                    <p class="specialist_card-g-t">15.04.2022</p>
                </div>
                <div class="specialist_card-g specialist_card-g-l">
                    <p class="specialist_card-g-ttl">Предложенный бюджет</p>
                    <p class="specialist_card-g-t">15 000₽</p>
                </div>
                <button class="btn--pink-white">Одобрить исполнителя</button>
            </section>

            <section class="specialist_card order confirm">
                <p class="specialist_card-ttl">Взаимодействие</p>
                <div class="specialist_card-confirm-top">
                    <p class="specialist_card-g-ttl">Текущий этап</p>
                    <p class="specialist_card-g-status">в работе</p>
                </div>
                <div class="specialist_card-g">
                    <p class="specialist_card-g-ttl">Дата завершения</p>
                    <p class="specialist_card-g-t">15.04.2022</p>
                </div>
                <div class="specialist_card-g specialist_card-g-l">
                    <p class="specialist_card-g-ttl">Бюджет</p>
                    <p class="specialist_card-g-t">15 000₽</p>
                </div>
                <button class="btn--pink-white">Подробнее о заказе</button>
            </section>
        </div>
    </article>

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

<div class="popups-back"></div>
<section class="popup popup-case">
    <div class="popup-case-wrapper">
        <button class="popup-close"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.2855 11.2249L16.2907 7.21967C16.5836 6.92678 17.0585 6.92678 17.3514 7.21967C17.6443 7.51256 17.6443 7.98744 17.3514 8.28033L13.3462 12.2855L17.3514 16.2907C17.6443 16.5836 17.6443 17.0585 17.3514 17.3514C17.0585 17.6443 16.5836 17.6443 16.2907 17.3514L12.2855 13.3462L8.28033 17.3514C7.98744 17.6443 7.51256 17.6443 7.21967 17.3514C6.92678 17.0585 6.92678 16.5836 7.21967 16.2907L11.2249 12.2855L7.21967 8.28033C6.92678 7.98744 6.92678 7.51256 7.21967 7.21967C7.51256 6.92678 7.98744 6.92678 8.28033 7.21967L12.2855 11.2249Z" fill="#9BA0B7"/></svg></button>

        <p class="popup-case-name">Реклама youtube-канала «Про книги»</p>
        <p class="specialist_card-ttl">о проекте</p>
        <p class="popup-case-text">Нужно проработать маркетинговую стратегию продвижения канала, настроить рекламу в Instagram, Telegram, Youtube.</p>
        <p class="specialist_card-ttl">Длительность</p>
        <p class="popup-case-text">с 12.04.2020 по 20.06.2020</p>
        <p class="specialist_card-ttl">Результаты</p>
        <p class="popup-case-text">Повысилась активность в соц.сетях. Увеличилась конверсия с 3% до 12%, число подписчиков увеличилось с 16 076 до 120 987 человек.</p>
        <p class="specialist_card-ttl">материалы</p>
        <ul class="specialist_card-materials">
            <li class="specialist_card-materials-item">
                <a href="" target="_blank" class="specialist_card-materials-item-link"></a>
                <svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg"><rect width="60" height="60" rx="2" fill="#CBD0E8"/><path fill-rule="evenodd" clip-rule="evenodd" d="M23.0127 18.4261C22.701 18.8189 22.5 19.4179 22.5 20.1562V28.5938C22.5 28.761 22.5607 28.8645 22.6365 28.9341C22.7239 29.0145 22.8478 29.0625 22.9688 29.0625H22.9749L22.9811 29.0626C23.0413 29.0634 23.101 29.0521 23.1567 29.0294C23.2125 29.0068 23.2631 28.9732 23.3056 28.9306C23.3482 28.8881 23.3818 28.8375 23.4044 28.7817C23.4271 28.726 23.4384 28.6663 23.4376 28.6061L23.4375 28.5999V19.6875C23.4375 19.1697 23.8572 18.75 24.375 18.75C24.8928 18.75 25.3125 19.1697 25.3125 19.6875V28.5884C25.3156 28.8965 25.2575 29.2023 25.1414 29.4878C25.0245 29.7755 24.8511 30.0369 24.6315 30.2565C24.4119 30.4761 24.1505 30.6495 23.8628 30.7664C23.577 30.8826 23.271 30.9407 22.9625 30.9375C21.8192 30.9343 20.625 30.0545 20.625 28.5938V20.1562C20.625 19.1022 20.9094 18.0605 21.5436 17.2609C22.1975 16.4366 23.173 15.9375 24.375 15.9375C25.5688 15.9375 26.5445 16.4211 27.202 17.2375C27.347 17.4175 27.4737 17.6101 27.583 17.8125H31.0988C31.8444 17.8126 32.5595 18.1088 33.0869 18.636L33.0869 18.6361L41.364 26.9131C41.8912 27.4405 42.1874 28.1556 42.1875 28.9012V40.3125C42.1875 41.3071 41.7924 42.2609 41.0892 42.9642C40.3859 43.6674 39.4321 44.0625 38.4375 44.0625H26.25C25.2554 44.0625 24.3016 43.6674 23.5983 42.9642C22.8951 42.2609 22.5 41.3071 22.5 40.3125V33.7312C19.57 33.4937 17.8125 31.0319 17.8125 28.2498V23.4375C17.8125 22.9197 18.2322 22.5 18.75 22.5C19.2678 22.5 19.6875 22.9197 19.6875 23.4375V28.2498C19.6875 30.3626 21.0018 31.875 22.9688 31.875C24.9357 31.875 26.25 30.3621 26.25 28.2498V20.1199C26.25 19.3824 26.0493 18.7956 25.7417 18.4136C25.4533 18.0555 25.0228 17.8125 24.375 17.8125C23.7354 17.8125 23.3047 18.0579 23.0127 18.4261ZM24.375 33.5709V40.3125C24.375 40.8098 24.5725 41.2867 24.9242 41.6383C25.2758 41.99 25.7527 42.1875 26.25 42.1875H38.4375C38.9348 42.1875 39.4117 41.99 39.7633 41.6383C40.115 41.2867 40.3125 40.8098 40.3125 40.3125V29.0625H33.75C33.0041 29.0625 32.2887 28.7662 31.7613 28.2387C31.2338 27.7113 30.9375 26.9959 30.9375 26.25V19.6875H28.1087C28.1196 19.8309 28.125 19.9752 28.125 20.1199V28.2498C28.125 30.7205 26.7384 32.9393 24.375 33.5709ZM32.8125 21.0133L38.9867 27.1875H33.75C33.5014 27.1875 33.2629 27.0887 33.0871 26.9129C32.9113 26.7371 32.8125 26.4986 32.8125 26.25V21.0133Z" fill="#5B617C"/></svg>
                <p class="specialist_card-materials-item-text">Диаграмма роста подписчиков</p>
           </li>
       </ul>
    </div>
</section>

<section class="popup popup-order">
    <div class="popup-case-wrapper">
        <button class="popup-close"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.2855 11.2249L16.2907 7.21967C16.5836 6.92678 17.0585 6.92678 17.3514 7.21967C17.6443 7.51256 17.6443 7.98744 17.3514 8.28033L13.3462 12.2855L17.3514 16.2907C17.6443 16.5836 17.6443 17.0585 17.3514 17.3514C17.0585 17.6443 16.5836 17.6443 16.2907 17.3514L12.2855 13.3462L8.28033 17.3514C7.98744 17.6443 7.51256 17.6443 7.21967 17.3514C6.92678 17.0585 6.92678 16.5836 7.21967 16.2907L11.2249 12.2855L7.21967 8.28033C6.92678 7.98744 6.92678 7.51256 7.21967 7.21967C7.51256 6.92678 7.98744 6.92678 8.28033 7.21967L12.2855 11.2249Z" fill="#9BA0B7"/></svg></button>

        <p style="margin-bottom: 12px;" class="popup-case-name">Предложите заказ исполнителю</p>
        <p class="popup-order-name-text">Вы можете выбрать заказ из уже сформированных вами или сформировать новую заявку</p>
        <div class="popup-order-item">
            <p class="popup-order-ttl">Реклама youtube-канала «Про книги»</p>
            <p style="margin-bottom: 20px;" class="popup-order-name-text">Нужно проработать маркетинговую стратегию продвижения канала, настроить рекламу в Instagram, Telegram, Youtube. </p>
            <div class="popup-order-list">
                <div class="popup-order-list-item">
                    <p class="popup-order-list-item-ttl">Крайний срок</p>
                    <p class="popup-order-list-item-t">15.04.2022</p>
                </div>
                <div class="popup-order-list-item">
                    <p class="popup-order-list-item-ttl">бюджет</p>
                    <p class="popup-order-list-item-t">15 000₽</p>
                </div>
            </div>
            <div class="spetialist-card_bottom">
                <div class="spetialist-card_bottom_left">
                    <button style="max-width: fit-content;" class="btn--pink-white" type="button">Предложить заказ</button>
                    <a class="link--purple" href="">Подробнее</a>
                </div>
                <p class="spetialist-card_bottom-t">опубликован <span>6.01.2022</span></p>
            </div>
        </div>
        <div class="popup-order-line"></div>
        <div class="popup-order-item">
            <p class="popup-order-ttl">Реклама youtube-канала «Про книги»</p>
            <p style="margin-bottom: 20px;" class="popup-order-name-text">Нужно проработать маркетинговую стратегию продвижения канала, настроить рекламу в Instagram, Telegram, Youtube. </p>
            <div class="popup-order-list">
                <div class="popup-order-list-item">
                    <p class="popup-order-list-item-ttl">Крайний срок</p>
                    <p class="popup-order-list-item-t">15.04.2022</p>
                </div>
                <div class="popup-order-list-item">
                    <p class="popup-order-list-item-ttl">бюджет</p>
                    <p class="popup-order-list-item-t">15 000₽</p>
                </div>
            </div>
            <div class="spetialist-card_bottom">
                <div class="spetialist-card_bottom_left">
                    <button style="max-width: fit-content;" class="btn--pink-white" type="button">Предложить заказ</button>
                    <a class="link--purple" href="">Подробнее</a>
                </div>
                <p class="spetialist-card_bottom-t">опубликован <span>6.01.2022</span></p>
            </div>
        </div>
        <div class="popup-order-line"></div>
        <div class="spetialist-card_bottom">
            <div class="spetialist-card_bottom_left">
                <button style="max-width: fit-content;" class="btn--purple" type="button">Создать заказ для исполнителя</button>
                <button class="popup-order-close link--grey">Отмена</button>
            </div>
        </div>
    </div>
</section>

<div class="PopapDBCWrap">
    <div class="PopapDCD-Error">
        <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
        <div class="PopapDBC-Cont df fdc aic">
            <img class="PopapDCD2img" src="<?= Url::to(['/img/danger.svg']) ?>" alt="Галочка">
            <h2 class="PopapDCD2-ttl">Заполните профиль</h2>
            <h3 class="PopapDCD2-subttl">Для связи с исполнителем необходимо заполнить профиль</h3>
            <p class="btn--purple PopapDCD-Error_Form-BTN BText df jcc aic uscp">Заполнить профиль</p>
            <p class="PopapDCD-Error-Reset BText df jcc aic uscp">Отмена</p>
        </div>
    </div>

    <div class="PopapDCD-Error PopapDCD-Error2">
        <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
        <div class="PopapDBC-Cont df fdc aic">
            <img class="PopapDCD2img" src="<?= Url::to(['/img/danger.svg']) ?>" alt="Галочка">
            <h2 class="PopapDCD2-ttl">Заполните профиль</h2>
            <h3 class="PopapDCD2-subttl">Для предложения заказа исполнителю необходимо заполнить данные вашего профиля</h3>
            <p class="btn--purple PopapDCD-Error_Form-BTN BText df jcc aic uscp">Заполнить профиль</p>
            <p class="PopapDCD-Error-Reset BText df jcc aic uscp">Отмена</p>
        </div>
    </div>

    <div class="PopapDCD2">
        <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
        <div class="PopapDBC-Cont df fdc aic">
            <img class="PopapDCD2img" src="<?= Url::to(['/img/success.svg']) ?>" alt="Галочка">
            <h2 class="PopapDCD2-ttl">Заказ отправлена!</h2>
            <h3 class="PopapDCD2-subttl">Ожидайте ответ исполнителя на странице заказа</h3>
            <p class="btn--purple PopapDCD2_Form-BTN BText df jcc aic uscp">Продолжить</p>
        </div>
    </div>
</div>