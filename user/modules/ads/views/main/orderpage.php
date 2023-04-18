<?php

use yii\helpers\Url;
use yii\helpers\Html;

$js = <<< JS
    var Stap = 1;
    $('.order-stage--btn-right').on('click', function(){
        Stap++;
        Staps();
    });
    $('.order-stage--btn-left').on('click', function(){
        Stap--;
        Staps();
    });

    function Staps(){
        switch(Stap){
            case 1:
                $('.order-stage-btns-indicator').removeClass('active');
                $('.order-stage-btns-indicator-1').addClass('active');
                $('.order-stage-tab').hide();
                $('.order-stage-tab-1').show();
                $('.order-stage--btn-left').attr('disabled', true);
                break;
            case 2:
                $('.order-stage-btns-indicator').removeClass('active');
                $('.order-stage-btns-indicator-2').addClass('active');
                $('.order-stage-tab').hide();
                $('.order-stage-tab-2').show();
                $('.order-stage--btn-left').attr('disabled', false);
                break;
            case 3:
                $('.order-stage-btns-indicator').removeClass('active');
                $('.order-stage-btns-indicator-3').addClass('active');
                $('.order-stage-tab').hide();
                $('.order-stage-tab-3').show();
                break;
            case 4:
                $('.order-stage-btns-indicator').removeClass('active');
                $('.order-stage-btns-indicator-4').addClass('active');
                $('.order-stage-tab').hide();
                $('.order-stage-tab-4').show();
                $('.order-stage--btn-right').attr('disabled', false);
                break;
            case 5:
                $('.order-stage-btns-indicator').removeClass('active');
                $('.order-stage-btns-indicator-5').addClass('active');
                $('.order-stage-tab').hide();
                $('.order-stage-tab-5').show();
                $('.order-stage--btn-right').attr('disabled', true);
                break;
        }
    }

    $('.btn-order-stage-tab-2').on('click', function(){
        $('.stop-form_group, .stop-form-btn-cancel').show();
        setTimeout(() => {
            $(this).attr('type', 'submit');
        }, 1);
    });

    $('.stop-form-btn-cancel').on('click', function(){
        $('.stop-form_group, .stop-form-btn-cancel').hide();
        $('.stop-form textarea').val('');
        setTimeout(() => {
            $(this).attr('type', 'button');
        }, 1);
    });

    $('.stop-form').on('submit', function (e) {
        $.ajax({
            url: "scripts/",
            method: "POST",
            data: $(this).serialize(),
            beforeSend: function (){
            },
        });
        e.preventDefault();
    });

    $('.rating-form_rating-item-label').mouseenter(function(){
        var num = $(this).find('input').val() - 1;
        $('.rating-form_rating-item-label').each(function(e){
            if(e < num){
                $(this).addClass('hover');
            }else{
                $(this).removeClass('hover');
            }
        });
    });
    $('.rating-form_rating-item-label').mouseleave(function(){
        $('.rating-form_rating-item-label').each(function(e){
            $(this).removeClass('hover');
        });
    });
    $('.rating-form_rating-item-label input').on('change', function(){
        if($(this).is(':checked')){
            var num = $(this).val() - 1;
            $('.rating-form_rating-item-label').each(function(e){
                if(e < num){
                    $(this).addClass('selected');
                }else{
                    $(this).removeClass('selected');
                }
            });
        }
    });

    $('.rating-form').on('submit', function (e) {
        $.ajax({
            url: "scripts/",
            method: "POST",
            data: $(this).serialize(),
            beforeSend: function (){
            },
        });
        e.preventDefault();
    });

    $('.popups-back, .popup-close, .popup-cancel').on('click', function(){
        $('.popups-back').fadeOut(300);
        $('.popup').fadeOut(300);
        $('.popup-2').fadeOut(300);
    });

    $('.change-order--btn').on('click', function(){
        $('.popups-back').fadeIn(300);
        $('.popup-order-change').fadeIn(300);
    });

    $('.popup-spec-canc--btn').on('click', function(){
        $('.popups-back').fadeIn(300);
        $('.popup-spec-canc').fadeIn(300);
    });

    $('.popup-spec-pay--btn').on('click', function(){
        $('.pop-pay-1').hide();
        $('.pop-pay-2').show();
    });
JS;
$this->registerJs($js);

$this->title = 'Youtube-канал «Про книги»';
?>

<section class="rightInfo sp">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__link">
                    Мои заказы
                </span>
            </li>
            <li class="bcr__item">
                <a href="<?= Url::to(['myorders']) ?>" class="bcr__link">
                    Поиск исполнителя
                </a>
            </li>
            <li class="bcr__item">
                <span class="bcr__span">
                    Youtube-канал «Про книги»
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">Youtube-канал «Про книги»</h1>
        <p class="myorders-section_card-last-text">опубликован: <span>6.01.2022</span></p>
    </div>

    <article class="choose">
        <div class="choose_main">
            <section class="myorders-section myorders-section-1">
                <div class="myorders-section_container">
                    <div class="myorders-section_card">
                        <p style="margin-bottom: 20px;" class="spetialist-card-ttl">описание проекта</p>
                        <p class="myorders-section_card-text">Нужно проработать маркетинговую стратегию продвижения канала, настроить рекламу в Instagram, Telegram, Youtube. </p>
                        <div class="myorders-section_card-group">
                            <div class="myorders-section_card-group-item">
                                <p class="myorders-section_card-group-item-ttl">Крайний срок</p>
                                <p class="myorders-section_card-group-item-text">15.04.2022</p>
                            </div>
                            <div class="myorders-section_card-group-item">
                                <p class="myorders-section_card-group-item-ttl">бюджет</p>
                                <p class="myorders-section_card-group-item-text">15 000₽</p>
                            </div>
                        </div>
                        <div class="myorders-section_card-last">
                            <button class="change-order--btn">Редактировать заказ<svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M14.2235 4.76729C14.3894 4.7672 14.5485 4.83305 14.6658 4.95035L15.5494 5.83394C15.6667 5.95124 15.7325 6.11035 15.7324 6.27624C15.7323 6.44212 15.6663 6.60116 15.5489 6.71832L4.69888 17.5437C4.65282 17.5897 4.59987 17.6281 4.54193 17.6578L2.78451 18.5562C2.54316 18.6796 2.24978 18.6333 2.0581 18.4417C1.86641 18.25 1.82013 17.9566 1.9435 17.7153L2.84193 15.9575C2.87155 15.8995 2.91005 15.8465 2.95602 15.8004L13.7814 4.95084C13.8986 4.83341 14.0576 4.76738 14.2235 4.76729Z" fill="#EB38D2"/><path fill-rule="evenodd" clip-rule="evenodd" d="M15.9914 2.74083C16.2258 2.50658 16.5436 2.375 16.875 2.375C17.2064 2.375 17.5242 2.50658 17.7586 2.74083L17.7589 2.74112C17.9931 2.97551 18.1247 3.29333 18.1247 3.62471C18.1247 3.95609 17.9931 4.27391 17.7589 4.5083L16.8753 5.39234C16.758 5.50961 16.599 5.57549 16.4332 5.57549C16.2674 5.57549 16.1084 5.50961 15.9912 5.39234L15.1076 4.50835C14.8636 4.26426 14.8636 3.8686 15.1077 3.62457L15.9913 2.74097L15.9914 2.74083Z" fill="#EB38D2"/></svg></button>
                        </div>
                    </div>

                    <div class="myorders-section_card">
                        <p style="margin-bottom: 20px;" class="spetialist-card-ttl">Отклики исполнителей</p>

                        <div class="myorders-section_card-item">
                            <div class="myorders-section_card-group-isp">
                                <div class="specialist-main-tab_orders-item_main-group-g">
                                    <div class="specialist-main-tab_orders-item_main-group-g-img">
                                        <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                                    </div>
                                    <p class="specialist-main-tab_orders-item_main-group-g-name">Иван Фёдеров</p>
                                </div>
                                <p class="spetialist-card_top_right-rating">
                                    <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <span>5.0</spa>
                                </p>
                            </div>
                            <div class="myorders-section_card-group">
                                <div class="myorders-section_card-group-item">
                                    <p class="myorders-section_card-group-item-ttl2">Предложенный дедлайн</p>
                                    <p class="myorders-section_card-group-item-text">15.04.2022</p>
                                </div>
                                <div class="myorders-section_card-group-item">
                                    <p class="myorders-section_card-group-item-ttl2">Предложенный дедлайн</p>
                                    <p class="myorders-section_card-group-item-text">15 000₽</p>
                                </div>
                            </div>
                            <div class="myorders-section_card-last-btns">
                                <button style="max-width: fit-content;" class="btn--pink-white">Одобрить исполнителя</button>
                                <button style="text-decoration: none;" class="link--purple popup-spec-canc--btn">Отклонить</button>
                            </div>
                        </div>
                        <div class="specialistorder-line"></div>
                        <div class="myorders-section_card-item">
                            <div class="myorders-section_card-group-isp">
                                <div class="specialist-main-tab_orders-item_main-group-g">
                                    <div class="specialist-main-tab_orders-item_main-group-g-img">
                                        <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                                    </div>
                                    <p class="specialist-main-tab_orders-item_main-group-g-name">Иван Фёдеров</p>
                                </div>
                                <p class="spetialist-card_top_right-rating">
                                    <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <span>5.0</spa>
                                </p>
                            </div>
                            <div class="myorders-section_card-group myorders-section_card-group-item">
                                <p class="myorders-section_card-group-item-ttl2">Комментарий исполнителя</p>
                                <p class="myorders-section_card-group-item-text">На моей странице вы можете ознакомиться с портфолио. Специализируюс на таких заказах.</p>
                            </div>
                            <div class="myorders-section_card-group">
                                <div class="myorders-section_card-group-item">
                                    <p class="myorders-section_card-group-item-ttl2">Предложенный дедлайн</p>
                                    <p class="myorders-section_card-group-item-text">15.04.2022</p>
                                </div>
                                <div class="myorders-section_card-group-item">
                                    <p class="myorders-section_card-group-item-ttl2">Предложенный дедлайн</p>
                                    <p class="myorders-section_card-group-item-text">15 000₽</p>
                                </div>
                            </div>
                            <div class="myorders-section_card-last-btns">
                                <button style="max-width: fit-content;" class="btn--pink-white">Одобрить исполнителя</button>
                                <button style="text-decoration: none;" class="link--purple">Отклонить</button>
                            </div>
                        </div>

                        <button style="display: block; margin: 20px 0px 0px;" type="button" class="input-checkbox-label-more">Еще +</button>
                    </div>

                    <div class="myorders-section_card">
                        <div class="myorders-section_card-item">
                            <p style="margin-bottom: 20px;" class="spetialist-card-ttl">Отклики исполнителей</p>
                            <div class="myorders-section_card-group-isp">
                                <div class="specialist-main-tab_orders-item_main-group-g">
                                    <div class="specialist-main-tab_orders-item_main-group-g-img">
                                        <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                                    </div>
                                    <p class="specialist-main-tab_orders-item_main-group-g-name">Иван Фёдеров</p>
                                </div>
                                <p class="spetialist-card_top_right-rating">
                                    <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <span>5.0</spa>
                                </p>
                            </div>
                            <div class="order-card-text">
                                <p class="myorders-section_card-group-item-text">На моей странице вы можете ознакомиться с портфолио. Специализируюс на таких заказах.</p>
                                <p class="myorders-section_card-group-item-text">Оплатите заказ и начните работу с исполнителем</p>
                            </div>
                            <button style="max-width: fit-content;" class="btn--pink-white">Оплатить заказ</button>
                        </div>
                    </div>
                </div>
            </section>

            <div class="order-stage-tabs">
                <section class="order-stage-tab order-stage-tab-1">
                    <div class="order-stage-tab_container">
                        <p class="order-stage-tab-name">Текущий этап</p>
                        <h3 class="order-stage-tab-stage">Поиск исполнителя</h3>
                        <p class="order-stage-tab-text">Вы можете выбрать исполнителя из тех, кто уже отлкикнулся на ваш заказ или предложить заказ любому исполнителю из каталога <br> <br><span>ВАЖНО!</span> После подтверждения исполнителя вам нужно оплатить заказ. Проверьте, наличие указанной вами суммы на балансе.</p>
                        <p class="order-stage-tab-text-done">
                            завершен: <span>12.01.2022</span>
                        </p>
                    </div>
                </section>
                <section class="order-stage-tab order-stage-tab-2">
                    <div class="order-stage-tab_container">
                        <p class="order-stage-tab-name green">Текущий этап</p>
                        <h3 class="order-stage-tab-stage">В работе</h3>
                        <p class="order-stage-tab-text">Вы можете выбрать исполнителя из тех, кто уже отлкикнулся на ваш заказ или предложить заказ любому исполнителю из каталога</p>
                        <?= Html::beginForm('', '', ['class' => 'stop-form']) ?>
                            <div class="stop-form_group">
                                <p class="stop-form_group-text">Подробно опишите причину пристановления выполнения заказа</p>
                                <textarea required style="margin-bottom: 0px; min-height: 118px" class="input-t input-textarea" placeholder="Введите текст" name="text"></textarea>
                            </div>

                            <div class="stop-form-btns">
                                <button type="button" class="btn-order-stage-tab-2">Остановить выполнение <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.875 10C1.875 5.5142 5.5142 1.875 10 1.875C14.4858 1.875 18.125 5.5142 18.125 10C18.125 14.4858 14.4858 18.125 10 18.125C5.5142 18.125 1.875 14.4858 1.875 10ZM10 3.125C6.20455 3.125 3.125 6.20455 3.125 10C3.125 13.7954 6.20455 16.875 10 16.875C13.7954 16.875 16.875 13.7954 16.875 10C16.875 6.20455 13.7954 3.125 10 3.125Z" fill="#EB38D2"/><path fill-rule="evenodd" clip-rule="evenodd" d="M8.125 6.875C8.47018 6.875 8.75 7.15482 8.75 7.5V12.5C8.75 12.8452 8.47018 13.125 8.125 13.125C7.77982 13.125 7.5 12.8452 7.5 12.5V7.5C7.5 7.15482 7.77982 6.875 8.125 6.875Z" fill="#EB38D2"/><path fill-rule="evenodd" clip-rule="evenodd" d="M11.875 6.875C12.2202 6.875 12.5 7.15482 12.5 7.5V12.5C12.5 12.8452 12.2202 13.125 11.875 13.125C11.5298 13.125 11.25 12.8452 11.25 12.5V7.5C11.25 7.15482 11.5298 6.875 11.875 6.875Z" fill="#EB38D2"/></svg></button>
                                <button style="text-decoration: none;" class="stop-form-btn-cancel link--purple">Отмена</button>
                            </div>
                        <?= Html::endForm(); ?>
                    </div>
                </section>
                <section class="order-stage-tab order-stage-tab-3">
                    <div class="order-stage-tab_container">
                        <p class="order-stage-tab-name green">Текущий этап</p>
                        <h3 class="order-stage-tab-stage">Остановлен</h3>
                        <p class="order-stage-tab-text">Выполнение заказа приостановлено по вашей инициативе</p>
                        <div class="reasons-text">
                            <p class="reasons-text-ttl">Причина:</p>
                            <p class="reasons-text-t">Хочу приостановить работу, т.к. проект нужно решить проблемы с регистрацией в сервисах</p>
                            <button type="button" class="btn-cont">Возобновить выполнение <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M1.875 10C1.875 5.5142 5.5142 1.875 10 1.875C14.4858 1.875 18.125 5.5142 18.125 10C18.125 14.4858 14.4858 18.125 10 18.125C5.5142 18.125 1.875 14.4858 1.875 10ZM10 3.125C6.20455 3.125 3.125 6.20455 3.125 10C3.125 13.7954 6.20455 16.875 10 16.875C13.7954 16.875 16.875 13.7954 16.875 10C16.875 6.20455 13.7954 3.125 10 3.125Z" fill="#EB38D2"/><path d="M8.45 13.0641L12.9207 10.3633C12.983 10.3253 13.0345 10.272 13.0703 10.2083C13.106 10.1447 13.1248 10.073 13.1248 10C13.1248 9.92703 13.106 9.85528 13.0703 9.79166C13.0345 9.72804 12.983 9.67468 12.9207 9.63672L8.45 6.93594C8.38592 6.89755 8.31278 6.87689 8.23808 6.87609C8.16338 6.8753 8.08982 6.89439 8.02493 6.9314C7.96004 6.96842 7.90617 7.02203 7.86884 7.08673C7.83151 7.15144 7.81207 7.22491 7.8125 7.29961V12.7004C7.81207 12.7751 7.83151 12.8486 7.86884 12.9133C7.90617 12.978 7.96004 13.0316 8.02493 13.0686C8.08982 13.1056 8.16338 13.1247 8.23808 13.1239C8.31278 13.1231 8.38592 13.1025 8.45 13.0641Z" fill="#EB38D2"/></svg></button>
                        </div>
                    </div>
                </section>
                <section class="order-stage-tab order-stage-tab-4">
                    <div class="order-stage-tab_container">
                        <p class="order-stage-tab-name green">Текущий этап</p>
                        <h3 class="order-stage-tab-stage">Завершен</h3>
                        <p class="order-stage-tab-text">Исполнитель выполнил заказ. Вы можете подтвердить завершение или вернуть заказ в работу</p>
                        <div class="stop-form-btns disabled">
                            <button style="max-width: fit-content; gap: 8px" type="button" class="btn--purple">Подтвердить выполнение заказа <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1533_10382)"><path d="M10 18.75C7.67936 18.75 5.45376 17.8281 3.81282 16.1872C2.17187 14.5462 1.25 12.3206 1.25 10C1.25 7.67936 2.17187 5.45376 3.81282 3.81282C5.45376 2.17187 7.67936 1.25 10 1.25C12.3206 1.25 14.5462 2.17187 16.1872 3.81282C17.8281 5.45376 18.75 7.67936 18.75 10C18.75 12.3206 17.8281 14.5462 16.1872 16.1872C14.5462 17.8281 12.3206 18.75 10 18.75ZM10 20C12.6522 20 15.1957 18.9464 17.0711 17.0711C18.9464 15.1957 20 12.6522 20 10C20 7.34784 18.9464 4.8043 17.0711 2.92893C15.1957 1.05357 12.6522 0 10 0C7.34784 0 4.8043 1.05357 2.92893 2.92893C1.05357 4.8043 0 7.34784 0 10C0 12.6522 1.05357 15.1957 2.92893 17.0711C4.8043 18.9464 7.34784 20 10 20Z" fill="white"/><path d="M13.5591 6.1047C13.5502 6.11333 13.5419 6.12251 13.5341 6.1322L9.19286 11.6634L6.57661 9.04595C6.3989 8.88035 6.16384 8.79019 5.92096 8.79448C5.67808 8.79876 5.44635 8.89715 5.27459 9.06892C5.10282 9.24069 5.00443 9.47242 5.00015 9.71529C4.99586 9.95817 5.08601 10.1932 5.25161 10.3709L8.55911 13.6797C8.64822 13.7686 8.75432 13.8387 8.87109 13.8858C8.98787 13.9328 9.11292 13.9559 9.2388 13.9535C9.36467 13.9512 9.48878 13.9235 9.60373 13.8722C9.71869 13.8208 9.82212 13.7469 9.90786 13.6547L14.8979 7.4172C15.0678 7.23886 15.1607 7.00082 15.1565 6.75453C15.1523 6.50825 15.0513 6.27351 14.8754 6.10106C14.6995 5.92862 14.4628 5.83233 14.2165 5.83301C13.9702 5.83369 13.7341 5.93129 13.5591 6.1047Z" fill="white"/></g><defs><clipPath id="clip0_1533_10382"><rect width="20" height="20" fill="white"/></clipPath></defs></svg></button>
                            <button style="text-decoration: none;" class="link--purple">Вернуть заказ в работу</button>
                        </div>
                        <!-- Если есть дата завершения(сейчас внизу), то добавь div-у выше класс disabled, иначе - удали -->
                        <p class="order-stage-tab-text-done">
                            завершен: <span>12.01.2022</span>
                        </p>
                    </div>
                </section>
                <section class="order-stage-tab order-stage-tab-5">
                    <div class="order-stage-tab_container">
                        <p class="order-stage-tab-name green">Текущий этап</p>
                        <h3 class="order-stage-tab-stage">Выполнен</h3>
                        <?= Html::beginForm('', '', ['class' => 'rating-form']) ?>
                            <div class="stop-form_group">
                                <p class="stop-form_group-text">Ваш заказ выполнен. Оставьте отзыв о работе с исполнителем</p>
                                <textarea required style="margin-bottom: 0px; min-height: 118px" class="input-t input-textarea" placeholder="Введите текст" name="text"></textarea>
                            </div>
                            <p class="rating-form-ttl">Оцените работу исполнителя</p>
                            <ul class="rating-form_rating">
                                <li class="rating-form_rating-item">
                                    <label class="rating-form_rating-item-label">
                                        <input type="radio" name="rating" value="1" class="input-hide">
                                        <div class="rating-form_rating-item-star">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.4135 17.8812L17.1419 20.8769C17.7463 21.2598 18.4967 20.6903 18.3173 19.9847L16.9512 14.6108C16.9127 14.4611 16.9173 14.3036 16.9643 14.1564C17.0114 14.0092 17.0991 13.8783 17.2172 13.7787L21.4573 10.2496C22.0144 9.78588 21.7269 8.86126 21.0111 8.81481L15.4738 8.45544C15.3247 8.44479 15.1816 8.39198 15.0613 8.30317C14.941 8.21437 14.8484 8.09321 14.7943 7.95382L12.7292 2.75323C12.673 2.60528 12.5732 2.4779 12.443 2.38802C12.3127 2.29814 12.1582 2.25 12 2.25C11.8418 2.25 11.6873 2.29814 11.557 2.38802C11.4268 2.4779 11.327 2.60528 11.2708 2.75323L9.20568 7.95382C9.15157 8.09321 9.05897 8.21437 8.93868 8.30317C8.81838 8.39198 8.67533 8.44479 8.52618 8.45544L2.98894 8.81481C2.27315 8.86126 1.9856 9.78588 2.54272 10.2496L6.78278 13.7787C6.90095 13.8783 6.9886 14.0092 7.03566 14.1564C7.08272 14.3036 7.08727 14.4611 7.0488 14.6108L5.78188 19.5945C5.56667 20.4412 6.46715 21.1246 7.19243 20.6651L11.5865 17.8812C11.71 17.8025 11.8535 17.7607 12 17.7607C12.1465 17.7607 12.29 17.8025 12.4135 17.8812V17.8812Z" stroke="#5B617C" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                    </label>
                                </li>
                                <li class="rating-form_rating-item">
                                    <label class="rating-form_rating-item-label">
                                        <input type="radio" name="rating" value="2" class="input-hide">
                                        <div class="rating-form_rating-item-star">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.4135 17.8812L17.1419 20.8769C17.7463 21.2598 18.4967 20.6903 18.3173 19.9847L16.9512 14.6108C16.9127 14.4611 16.9173 14.3036 16.9643 14.1564C17.0114 14.0092 17.0991 13.8783 17.2172 13.7787L21.4573 10.2496C22.0144 9.78588 21.7269 8.86126 21.0111 8.81481L15.4738 8.45544C15.3247 8.44479 15.1816 8.39198 15.0613 8.30317C14.941 8.21437 14.8484 8.09321 14.7943 7.95382L12.7292 2.75323C12.673 2.60528 12.5732 2.4779 12.443 2.38802C12.3127 2.29814 12.1582 2.25 12 2.25C11.8418 2.25 11.6873 2.29814 11.557 2.38802C11.4268 2.4779 11.327 2.60528 11.2708 2.75323L9.20568 7.95382C9.15157 8.09321 9.05897 8.21437 8.93868 8.30317C8.81838 8.39198 8.67533 8.44479 8.52618 8.45544L2.98894 8.81481C2.27315 8.86126 1.9856 9.78588 2.54272 10.2496L6.78278 13.7787C6.90095 13.8783 6.9886 14.0092 7.03566 14.1564C7.08272 14.3036 7.08727 14.4611 7.0488 14.6108L5.78188 19.5945C5.56667 20.4412 6.46715 21.1246 7.19243 20.6651L11.5865 17.8812C11.71 17.8025 11.8535 17.7607 12 17.7607C12.1465 17.7607 12.29 17.8025 12.4135 17.8812V17.8812Z" stroke="#5B617C" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                    </label>
                                </li>
                                <li class="rating-form_rating-item">
                                    <label class="rating-form_rating-item-label">
                                        <input type="radio" name="rating" value="3" class="input-hide">
                                        <div class="rating-form_rating-item-star">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.4135 17.8812L17.1419 20.8769C17.7463 21.2598 18.4967 20.6903 18.3173 19.9847L16.9512 14.6108C16.9127 14.4611 16.9173 14.3036 16.9643 14.1564C17.0114 14.0092 17.0991 13.8783 17.2172 13.7787L21.4573 10.2496C22.0144 9.78588 21.7269 8.86126 21.0111 8.81481L15.4738 8.45544C15.3247 8.44479 15.1816 8.39198 15.0613 8.30317C14.941 8.21437 14.8484 8.09321 14.7943 7.95382L12.7292 2.75323C12.673 2.60528 12.5732 2.4779 12.443 2.38802C12.3127 2.29814 12.1582 2.25 12 2.25C11.8418 2.25 11.6873 2.29814 11.557 2.38802C11.4268 2.4779 11.327 2.60528 11.2708 2.75323L9.20568 7.95382C9.15157 8.09321 9.05897 8.21437 8.93868 8.30317C8.81838 8.39198 8.67533 8.44479 8.52618 8.45544L2.98894 8.81481C2.27315 8.86126 1.9856 9.78588 2.54272 10.2496L6.78278 13.7787C6.90095 13.8783 6.9886 14.0092 7.03566 14.1564C7.08272 14.3036 7.08727 14.4611 7.0488 14.6108L5.78188 19.5945C5.56667 20.4412 6.46715 21.1246 7.19243 20.6651L11.5865 17.8812C11.71 17.8025 11.8535 17.7607 12 17.7607C12.1465 17.7607 12.29 17.8025 12.4135 17.8812V17.8812Z" stroke="#5B617C" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                    </label>
                                </li>
                                <li class="rating-form_rating-item">
                                    <label class="rating-form_rating-item-label">
                                        <input type="radio" name="rating" value="4" class="input-hide">
                                        <div class="rating-form_rating-item-star">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.4135 17.8812L17.1419 20.8769C17.7463 21.2598 18.4967 20.6903 18.3173 19.9847L16.9512 14.6108C16.9127 14.4611 16.9173 14.3036 16.9643 14.1564C17.0114 14.0092 17.0991 13.8783 17.2172 13.7787L21.4573 10.2496C22.0144 9.78588 21.7269 8.86126 21.0111 8.81481L15.4738 8.45544C15.3247 8.44479 15.1816 8.39198 15.0613 8.30317C14.941 8.21437 14.8484 8.09321 14.7943 7.95382L12.7292 2.75323C12.673 2.60528 12.5732 2.4779 12.443 2.38802C12.3127 2.29814 12.1582 2.25 12 2.25C11.8418 2.25 11.6873 2.29814 11.557 2.38802C11.4268 2.4779 11.327 2.60528 11.2708 2.75323L9.20568 7.95382C9.15157 8.09321 9.05897 8.21437 8.93868 8.30317C8.81838 8.39198 8.67533 8.44479 8.52618 8.45544L2.98894 8.81481C2.27315 8.86126 1.9856 9.78588 2.54272 10.2496L6.78278 13.7787C6.90095 13.8783 6.9886 14.0092 7.03566 14.1564C7.08272 14.3036 7.08727 14.4611 7.0488 14.6108L5.78188 19.5945C5.56667 20.4412 6.46715 21.1246 7.19243 20.6651L11.5865 17.8812C11.71 17.8025 11.8535 17.7607 12 17.7607C12.1465 17.7607 12.29 17.8025 12.4135 17.8812V17.8812Z" stroke="#5B617C" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                    </label>
                                </li>
                                <li class="rating-form_rating-item">
                                    <label class="rating-form_rating-item-label">
                                        <input type="radio" name="rating" value="5" class="input-hide">
                                        <div class="rating-form_rating-item-star">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.4135 17.8812L17.1419 20.8769C17.7463 21.2598 18.4967 20.6903 18.3173 19.9847L16.9512 14.6108C16.9127 14.4611 16.9173 14.3036 16.9643 14.1564C17.0114 14.0092 17.0991 13.8783 17.2172 13.7787L21.4573 10.2496C22.0144 9.78588 21.7269 8.86126 21.0111 8.81481L15.4738 8.45544C15.3247 8.44479 15.1816 8.39198 15.0613 8.30317C14.941 8.21437 14.8484 8.09321 14.7943 7.95382L12.7292 2.75323C12.673 2.60528 12.5732 2.4779 12.443 2.38802C12.3127 2.29814 12.1582 2.25 12 2.25C11.8418 2.25 11.6873 2.29814 11.557 2.38802C11.4268 2.4779 11.327 2.60528 11.2708 2.75323L9.20568 7.95382C9.15157 8.09321 9.05897 8.21437 8.93868 8.30317C8.81838 8.39198 8.67533 8.44479 8.52618 8.45544L2.98894 8.81481C2.27315 8.86126 1.9856 9.78588 2.54272 10.2496L6.78278 13.7787C6.90095 13.8783 6.9886 14.0092 7.03566 14.1564C7.08272 14.3036 7.08727 14.4611 7.0488 14.6108L5.78188 19.5945C5.56667 20.4412 6.46715 21.1246 7.19243 20.6651L11.5865 17.8812C11.71 17.8025 11.8535 17.7607 12 17.7607C12.1465 17.7607 12.29 17.8025 12.4135 17.8812V17.8812Z" stroke="#5B617C" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </div>
                                    </label>
                                </li>
                            </ul>

                            <button style="max-width: fit-content; gap: 8px" type="submit" class="btn--purple">Оставить отзыв<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1533_10382)"><path d="M10 18.75C7.67936 18.75 5.45376 17.8281 3.81282 16.1872C2.17187 14.5462 1.25 12.3206 1.25 10C1.25 7.67936 2.17187 5.45376 3.81282 3.81282C5.45376 2.17187 7.67936 1.25 10 1.25C12.3206 1.25 14.5462 2.17187 16.1872 3.81282C17.8281 5.45376 18.75 7.67936 18.75 10C18.75 12.3206 17.8281 14.5462 16.1872 16.1872C14.5462 17.8281 12.3206 18.75 10 18.75ZM10 20C12.6522 20 15.1957 18.9464 17.0711 17.0711C18.9464 15.1957 20 12.6522 20 10C20 7.34784 18.9464 4.8043 17.0711 2.92893C15.1957 1.05357 12.6522 0 10 0C7.34784 0 4.8043 1.05357 2.92893 2.92893C1.05357 4.8043 0 7.34784 0 10C0 12.6522 1.05357 15.1957 2.92893 17.0711C4.8043 18.9464 7.34784 20 10 20Z" fill="white"/><path d="M13.5591 6.1047C13.5502 6.11333 13.5419 6.12251 13.5341 6.1322L9.19286 11.6634L6.57661 9.04595C6.3989 8.88035 6.16384 8.79019 5.92096 8.79448C5.67808 8.79876 5.44635 8.89715 5.27459 9.06892C5.10282 9.24069 5.00443 9.47242 5.00015 9.71529C4.99586 9.95817 5.08601 10.1932 5.25161 10.3709L8.55911 13.6797C8.64822 13.7686 8.75432 13.8387 8.87109 13.8858C8.98787 13.9328 9.11292 13.9559 9.2388 13.9535C9.36467 13.9512 9.48878 13.9235 9.60373 13.8722C9.71869 13.8208 9.82212 13.7469 9.90786 13.6547L14.8979 7.4172C15.0678 7.23886 15.1607 7.00082 15.1565 6.75453C15.1523 6.50825 15.0513 6.27351 14.8754 6.10106C14.6995 5.92862 14.4628 5.83233 14.2165 5.83301C13.9702 5.83369 13.7341 5.93129 13.5591 6.1047Z" fill="white"/></g><defs><clipPath id="clip0_1533_10382"><rect width="20" height="20" fill="white"/></clipPath></defs></svg></button>
                        <?= Html::endForm(); ?>

                        <p class="order-stage-tab-name">Завершенный этап</p>
                        <h3 class="order-stage-tab-stage">Выполнен</h3>
                        <p class="order-stage-tab-last-text">Заказал стратегию и продвижение в Instragram. За первую неделю пришло более 1 000 подписчиков. Буду продолжать сотружничать <br> <br> Заказал стратегию и продвижение в Instragram. За первую неделю пришло более 1 000 подписчиков. Буду продолжать сотружничать</p>
                        <div class="order-stage-tab-last-group">
                            <p class="order-stage-tab-last-group-text">Оценка работы исполнителя</p>
                            <p class="spetialist-card_top_right-rating">
                                <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <span>5.0</spa>
                            </p>
                        </div>
                        <p class="order-stage-tab-text-done">
                            завершен: <span>12.01.2022</span>
                        </p>
                    </div>
                </section>

                <div class="order-stage-btns">
                    <button disabled class="order-stage--btn order-stage--btn-left">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><circle r="13.5" transform="matrix(-1 0 0 1 14 14)" stroke="#D7E3E4"/><path d="M18.6758 14.4375H8.44922" stroke="#D7E3E4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M12.6328 10.2539L8.44922 14.4375L12.6328 18.6211" stroke="#D7E3E4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                    <div class="order-stage-btns-indicators">
                        <div class="order-stage-btns-indicator order-stage-btns-indicator-1 active"></div>
                        <div class="order-stage-btns-indicator order-stage-btns-indicator-2"></div>
                        <div class="order-stage-btns-indicator order-stage-btns-indicator-3"></div>
                        <div class="order-stage-btns-indicator order-stage-btns-indicator-4"></div>
                        <div class="order-stage-btns-indicator order-stage-btns-indicator-5"></div>
                    </div>
                    <button class="order-stage--btn order-stage--btn-right">
                        <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="14" cy="14" r="13.5" stroke="#D7E3E4"/><path d="M9.32422 14.4375H19.5508" stroke="#D7E3E4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M15.3672 10.2539L19.5508 14.4375L15.3672 18.6211" stroke="#D7E3E4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="specialist_right">
            <section class="specialist_card">
                <p class="specialist_card-ttl">Прогресс</p>
                <p class="order-stage-t"><span>1/5</span> этапов</p>
                <div class="order-stage-line">
                    <div class="order-stage-line-fill"></div>
                </div>
            </section>

            <section class="specialist_card">
                <p class="specialist_card-ttl">исполнитель</p>
                <img class="specialist_card-image" src="<?= Url::to('/img/afo/orst-1.svg') ?>" alt="Здесь будет отображен выбранный вами исполнитель">
                <p class="order-stage-t order-stage-t-center">Здесь будет отображен выбранный вами исполнитель</p>

                <div class="specialist_card_top">
                    <div class="specialist_card_top-image">
                        <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                    </div>
                </div>
                <p style="margin-bottom: 16px;" class="specialist_card-name">Святослав Василевский</p>
                <div style="margin-bottom: 28px;" class="specialist_card_top_right-top">
                    <p class="spetialist-card_top_right-rating">
                        <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>5.0</spa>
                    </p>
                    <div class="spetialist-card_top_right-spetial">
                        <img src="<?= Url::to('/img/afo/best3.svg') ?>" alt="1">
                        <p class="spetialist-card_top_right-spetial-txt">адепт</p>
                    </div>
                </div>
                <p class="specialist_card-ttl">специализации</p>
                <ul class="spetialist-card_tags">
                    <li>#поисковые системы</li>
                    <li>#e-mail маркетинг</li>
                    <li>#Facebook</li>
                </ul>
                <a href="" style="text-decoration: none;" class="link--purple">Смотреть профиль</a>
            </section>

            <section class="specialist_card">
                <p class="specialist_card-ttl">Отзыв исполнителя</p>
                <img class="specialist_card-image" src="<?= Url::to('/img/afo/orst-2.svg') ?>" alt="Здесь будет отображен выбранный вами исполнитель">
                <p class="order-stage-t order-stage-t-center">Здесь будет отображен отзыв  исполнителя</p>

                <p class="ordp-rew">Понравилось взаимодействие. Заказчик адекватный. Никаких проблем не возникало</p>
                <p class="ordp-date">2.02.2022</p>
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
<section class="popup popup-order-change popup-2">
    <div class="popup-wrapper">
        <button class="popup-close"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.2855 11.2249L16.2907 7.21967C16.5836 6.92678 17.0585 6.92678 17.3514 7.21967C17.6443 7.51256 17.6443 7.98744 17.3514 8.28033L13.3462 12.2855L17.3514 16.2907C17.6443 16.5836 17.6443 17.0585 17.3514 17.3514C17.0585 17.6443 16.5836 17.6443 16.2907 17.3514L12.2855 13.3462L8.28033 17.3514C7.98744 17.6443 7.51256 17.6443 7.21967 17.3514C6.92678 17.0585 6.92678 16.5836 7.21967 16.2907L11.2249 12.2855L7.21967 8.28033C6.92678 7.98744 6.92678 7.51256 7.21967 7.21967C7.51256 6.92678 7.98744 6.92678 8.28033 7.21967L12.2855 11.2249Z" fill="#9BA0B7"/></svg></button>

        <svg style="margin-bottom: 20px; width: 120px; height: 120px;" width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M51.3397 15C55.1888 8.33333 64.8112 8.33333 68.6603 15L103.301 75C107.15 81.6667 102.339 90 94.641 90H25.359C17.661 90 12.8497 81.6667 16.6987 75L51.3397 15Z" fill="#FFA800"/><path d="M56.5356 18.1426C58.0752 15.4759 61.9242 15.4759 63.4638 18.1426L97.9811 77.9283C99.5207 80.595 97.5962 83.9283 94.517 83.9283H25.4824C22.4032 83.9283 20.4787 80.595 22.0183 77.9283L56.5356 18.1426Z" fill="white"/><path d="M64.4974 41.4287L63.5825 62.3762H56.9499L56.035 41.4287H64.4974ZM60.3806 73.5716C59.0083 73.5716 57.88 73.1926 56.9956 72.4345C56.1418 71.6474 55.7148 70.6853 55.7148 69.5482C55.7148 68.3821 56.1418 67.4054 56.9956 66.6182C57.88 65.831 59.0083 65.4375 60.3806 65.4375C61.7224 65.4375 62.8202 65.831 63.674 66.6182C64.5584 67.4054 65.0006 68.3821 65.0006 69.5482C65.0006 70.6853 64.5584 71.6474 63.674 72.4345C62.8202 73.1926 61.7224 73.5716 60.3806 73.5716Z" fill="#FFA800"/></svg>

        <p style="margin-bottom: 12px;" class="popup-case-name">Редактирование заказа</p>
        <p class="popup-order-name-text">После редактирования заказа, все отклики, полученные ранее, будут удалены. Продолжить редактирование заказа?</p> 
        <button style="max-width: fit-content; margin-bottom: 18px;" class="btn--purple" type="button">Продолжить</button>
        <button class="popup-cancel link--grey">Отмена</button>
    </div>
</section>

<section class="popup popup-spec-canc popup-2">
    <div class="popup-wrapper">
        <button class="popup-close"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.2855 11.2249L16.2907 7.21967C16.5836 6.92678 17.0585 6.92678 17.3514 7.21967C17.6443 7.51256 17.6443 7.98744 17.3514 8.28033L13.3462 12.2855L17.3514 16.2907C17.6443 16.5836 17.6443 17.0585 17.3514 17.3514C17.0585 17.6443 16.5836 17.6443 16.2907 17.3514L12.2855 13.3462L8.28033 17.3514C7.98744 17.6443 7.51256 17.6443 7.21967 17.3514C6.92678 17.0585 6.92678 16.5836 7.21967 16.2907L11.2249 12.2855L7.21967 8.28033C6.92678 7.98744 6.92678 7.51256 7.21967 7.21967C7.51256 6.92678 7.98744 6.92678 8.28033 7.21967L12.2855 11.2249Z" fill="#9BA0B7"/></svg></button>

        <svg style="margin-bottom: 20px; width: 120px; height: 120px;" width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M51.3397 15C55.1888 8.33333 64.8112 8.33333 68.6603 15L103.301 75C107.15 81.6667 102.339 90 94.641 90H25.359C17.661 90 12.8497 81.6667 16.6987 75L51.3397 15Z" fill="#FFA800"/><path d="M56.5356 18.1426C58.0752 15.4759 61.9242 15.4759 63.4638 18.1426L97.9811 77.9283C99.5207 80.595 97.5962 83.9283 94.517 83.9283H25.4824C22.4032 83.9283 20.4787 80.595 22.0183 77.9283L56.5356 18.1426Z" fill="white"/><path d="M64.4974 41.4287L63.5825 62.3762H56.9499L56.035 41.4287H64.4974ZM60.3806 73.5716C59.0083 73.5716 57.88 73.1926 56.9956 72.4345C56.1418 71.6474 55.7148 70.6853 55.7148 69.5482C55.7148 68.3821 56.1418 67.4054 56.9956 66.6182C57.88 65.831 59.0083 65.4375 60.3806 65.4375C61.7224 65.4375 62.8202 65.831 63.674 66.6182C64.5584 67.4054 65.0006 68.3821 65.0006 69.5482C65.0006 70.6853 64.5584 71.6474 63.674 72.4345C62.8202 73.1926 61.7224 73.5716 60.3806 73.5716Z" fill="#FFA800"/></svg>

        <p style="margin-bottom: 12px;" class="popup-case-name">Отклонить исполнителя?</p>
        <p class="popup-order-name-text">Отклонить отклик Ивана Фёдорова?</p> 
        <button style="max-width: fit-content; margin-bottom: 18px;" class="btn--purple" type="button">Да, отклонить</button>
        <button class="popup-cancel link--grey">Отмена</button>
    </div>
</section>

<section class="popup popup-spec-conf popup-2">
    <div class="popup-wrapper">
        <button class="popup-close"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.2855 11.2249L16.2907 7.21967C16.5836 6.92678 17.0585 6.92678 17.3514 7.21967C17.6443 7.51256 17.6443 7.98744 17.3514 8.28033L13.3462 12.2855L17.3514 16.2907C17.6443 16.5836 17.6443 17.0585 17.3514 17.3514C17.0585 17.6443 16.5836 17.6443 16.2907 17.3514L12.2855 13.3462L8.28033 17.3514C7.98744 17.6443 7.51256 17.6443 7.21967 17.3514C6.92678 17.0585 6.92678 16.5836 7.21967 16.2907L11.2249 12.2855L7.21967 8.28033C6.92678 7.98744 6.92678 7.51256 7.21967 7.21967C7.51256 6.92678 7.98744 6.92678 8.28033 7.21967L12.2855 11.2249Z" fill="#9BA0B7"/></svg></button>

        <svg style="margin-bottom: 20px; width: 120px; height: 120px;" width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="60" cy="60" r="43" fill="#92E3A9"/><circle cx="60" cy="60" r="36" fill="white"/><path d="M44.2578 59.0245C43.1667 57.7776 41.2714 57.6512 40.0245 58.7423C38.7776 59.8333 38.6513 61.7286 39.7423 62.9755L50.2423 74.9755C51.4075 76.3071 53.4661 76.3463 54.6811 75.0599L80.181 48.0599C81.3187 46.8553 81.2644 44.9566 80.0599 43.819C78.8553 42.6813 76.9566 42.7356 75.819 43.9401L52.5848 68.5411L44.2578 59.0245Z" fill="#92E3A9"/></svg>

        <p style="margin-bottom: 12px;" class="popup-case-name">Подтвердить исполнителя?</p>
        <p style="margin-bottom: 20px;" class="popup-order-name-text">Условия сотрудничества</p>
        <div class="myorders-section_card-group myorders-section_card-group-popup">
            <div class="myorders-section_card-group-item">
                <p class="myorders-section_card-group-item-ttl2">Дедлайн</p>
                <p class="myorders-section_card-group-item-text">15.04.2022</p>
            </div>
            <div class="myorders-section_card-group-item">
                <p class="myorders-section_card-group-item-ttl2">Бюджет</p>
                <p class="myorders-section_card-group-item-text">15 000₽</p>
            </div>
        </div>

        <button style="max-width: fit-content; margin-bottom: 18px;" class="btn--purple" type="button">Продолжить</button>
        <button class="popup-cancel link--grey">Отмена</button>
    </div>
</section>

<section class="popup popup-spec-pay popup-2">
    <div class="popup-wrapper">
        <button class="popup-close"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.2855 11.2249L16.2907 7.21967C16.5836 6.92678 17.0585 6.92678 17.3514 7.21967C17.6443 7.51256 17.6443 7.98744 17.3514 8.28033L13.3462 12.2855L17.3514 16.2907C17.6443 16.5836 17.6443 17.0585 17.3514 17.3514C17.0585 17.6443 16.5836 17.6443 16.2907 17.3514L12.2855 13.3462L8.28033 17.3514C7.98744 17.6443 7.51256 17.6443 7.21967 17.3514C6.92678 17.0585 6.92678 16.5836 7.21967 16.2907L11.2249 12.2855L7.21967 8.28033C6.92678 7.98744 6.92678 7.51256 7.21967 7.21967C7.51256 6.92678 7.98744 6.92678 8.28033 7.21967L12.2855 11.2249Z" fill="#9BA0B7"/></svg></button>

        <div class="pop-pay pop-pay-1">
            <div class="pop-pay-container">
                <p style="margin-bottom: 12px;" class="popup-case-name">Оплатить заказ</p>
                <p style="margin-bottom: 12px;" class="popup-order-name-text">Комиссия сервиса составляет - 10% от указанного бюджета заказа. Комиссию необходимо оплатить перед началом выполнения заказа</p>
                <p style="margin-bottom: 12px;" class="popup-order-name-text">Средства будут переведены на счет исполнителя сразу после оплаты, но вывести средства исполнитель сможет только после подтверждения вами выполнения заказа.</p>
                <p style="margin-bottom: 44px;" class="popup-order-name-text">В случае невыполнения заказа исполнителем, средства будут возвращены на ваш баланс</p>
        
                <button style="max-width: fit-content; margin-bottom: 18px;" class="btn--purple popup-spec-pay--btn" type="button">Продолжить</button>
                <button class="popup-cancel link--grey">Отмена</button>
            </div>
        </div>

        <div class="pop-pay pop-pay-2">
            <div class="pop-pay-container">
                <p style="margin-bottom: 12px;" class="popup-case-name">Оплатить заказ</p>
                <p style="margin-bottom: 40px;" class="popup-order-name-text">Оплата заказа - 15 000₽ <br> Комиссия сервиса (10%) - 1 500₽</p>
                <?= Html::beginForm('', 'post', ['class' => 'PopapDBC_Form']) ?>
                    <div class="PopapDBC-Form df fdc">
                        <p style="align-self: start;" class="PopapDBC-t2 HText">Сумма оплаты </p>
                        <input class="InputDonateAmount" required placeholder="16 500₽" type="number" name="DonateAmount" id="">
                        <div class="CheckboxDonateandlink df aic">
                            <input checked class="CheckboxDonate" required type="checkbox" name="" id="check_one_pay">
                            <p class="CheckboxDonatelink">Согласен с условиями <a href="<?= Url::to(['']) ?>">договора оферты</a></p>
                        </div>
                        <div class="errors-block"></div>
                        <button style="align-self: center; max-width: fit-content; margin-bottom: 18px;" class="btn--purple" type="submit">Оплатить заказ</button>
                    </div>
                <?= Html::endForm(); ?>
            </div>
        </div>
    </div>
</section>

<section class="popup popup-pay-error popup-2">
    <div class="popup-wrapper">
        <button class="popup-close"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.2855 11.2249L16.2907 7.21967C16.5836 6.92678 17.0585 6.92678 17.3514 7.21967C17.6443 7.51256 17.6443 7.98744 17.3514 8.28033L13.3462 12.2855L17.3514 16.2907C17.6443 16.5836 17.6443 17.0585 17.3514 17.3514C17.0585 17.6443 16.5836 17.6443 16.2907 17.3514L12.2855 13.3462L8.28033 17.3514C7.98744 17.6443 7.51256 17.6443 7.21967 17.3514C6.92678 17.0585 6.92678 16.5836 7.21967 16.2907L11.2249 12.2855L7.21967 8.28033C6.92678 7.98744 6.92678 7.51256 7.21967 7.21967C7.51256 6.92678 7.98744 6.92678 8.28033 7.21967L12.2855 11.2249Z" fill="#9BA0B7"/></svg></button>

        <svg style="margin-bottom: 20px; width: 120px; height: 120px;" width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="60" cy="60" r="43" fill="#FF6359"/><circle cx="60" cy="60" r="36" fill="white"/><path fill-rule="evenodd" clip-rule="evenodd" d="M59.7146 56.0457L73.5706 42.1896C74.5839 41.1764 76.2267 41.1764 77.24 42.1896C78.2532 43.2029 78.2532 44.8457 77.24 45.8589L63.3839 59.715L77.2404 73.5715C78.2537 74.5847 78.2537 76.2275 77.2404 77.2408C76.2272 78.254 74.5844 78.254 73.5711 77.2408L59.7146 63.3843L45.8589 77.24C44.8457 78.2532 43.2029 78.2532 42.1896 77.24C41.1764 76.2267 41.1764 74.5839 42.1896 73.5706L56.0453 59.715L42.1901 45.8598C41.1768 44.8465 41.1768 43.2037 42.1901 42.1905C43.2034 41.1772 44.8462 41.1772 45.8594 42.1905L59.7146 56.0457Z" fill="#FF6359"/></svg>

        <p style="margin-bottom: 12px;" class="popup-case-name">Недостаточно средств!</p>
        <p style="margin-bottom: 44px;" class="popup-order-name-text">Пополните баланс личного кабинета для оплаты</p>

        <button style="max-width: fit-content; margin-bottom: 18px;" class="btn--purple" type="button">Перейти в балансу</button>
        <button class="popup-cancel link--grey">Отмена</button>
    </div>
</section>

<section class="popup popup-pay-done popup-2">
    <div class="popup-wrapper">
        <button class="popup-close"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.2855 11.2249L16.2907 7.21967C16.5836 6.92678 17.0585 6.92678 17.3514 7.21967C17.6443 7.51256 17.6443 7.98744 17.3514 8.28033L13.3462 12.2855L17.3514 16.2907C17.6443 16.5836 17.6443 17.0585 17.3514 17.3514C17.0585 17.6443 16.5836 17.6443 16.2907 17.3514L12.2855 13.3462L8.28033 17.3514C7.98744 17.6443 7.51256 17.6443 7.21967 17.3514C6.92678 17.0585 6.92678 16.5836 7.21967 16.2907L11.2249 12.2855L7.21967 8.28033C6.92678 7.98744 6.92678 7.51256 7.21967 7.21967C7.51256 6.92678 7.98744 6.92678 8.28033 7.21967L12.2855 11.2249Z" fill="#9BA0B7"/></svg></button>

        <svg style="margin-bottom: 20px; width: 120px; height: 120px;" width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="60" cy="60" r="43" fill="#92E3A9"/><circle cx="60" cy="60" r="36" fill="white"/><path d="M44.2578 59.0245C43.1667 57.7776 41.2714 57.6512 40.0245 58.7423C38.7776 59.8333 38.6513 61.7286 39.7423 62.9755L50.2423 74.9755C51.4075 76.3071 53.4661 76.3463 54.6811 75.0599L80.181 48.0599C81.3187 46.8553 81.2644 44.9566 80.0599 43.819C78.8553 42.6813 76.9566 42.7356 75.819 43.9401L52.5848 68.5411L44.2578 59.0245Z" fill="#92E3A9"/></svg>

        <p style="margin-bottom: 12px;" class="popup-case-name">Заказ оплачен!</p>
        <p style="margin-bottom: 44px;" class="popup-order-name-text">Статус заказа изменен. Текущий статус заказа «В работе»</p>

        <button style="max-width: fit-content;" class="btn--purple" type="button">Перейти к купленным лидам</button>
    </div>
</section>

<section class="popup popup-order-remove popup-2">
    <div class="popup-wrapper">
        <button class="popup-close"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.2855 11.2249L16.2907 7.21967C16.5836 6.92678 17.0585 6.92678 17.3514 7.21967C17.6443 7.51256 17.6443 7.98744 17.3514 8.28033L13.3462 12.2855L17.3514 16.2907C17.6443 16.5836 17.6443 17.0585 17.3514 17.3514C17.0585 17.6443 16.5836 17.6443 16.2907 17.3514L12.2855 13.3462L8.28033 17.3514C7.98744 17.6443 7.51256 17.6443 7.21967 17.3514C6.92678 17.0585 6.92678 16.5836 7.21967 16.2907L11.2249 12.2855L7.21967 8.28033C6.92678 7.98744 6.92678 7.51256 7.21967 7.21967C7.51256 6.92678 7.98744 6.92678 8.28033 7.21967L12.2855 11.2249Z" fill="#9BA0B7"/></svg></button>

        <svg style="margin-bottom: 20px; width: 120px; height: 120px;" width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M51.3397 15C55.1888 8.33333 64.8112 8.33333 68.6603 15L103.301 75C107.15 81.6667 102.339 90 94.641 90H25.359C17.661 90 12.8497 81.6667 16.6987 75L51.3397 15Z" fill="#FFA800"/><path d="M56.5356 18.1426C58.0752 15.4759 61.9242 15.4759 63.4638 18.1426L97.9811 77.9283C99.5207 80.595 97.5962 83.9283 94.517 83.9283H25.4824C22.4032 83.9283 20.4787 80.595 22.0183 77.9283L56.5356 18.1426Z" fill="white"/><path d="M64.4974 41.4287L63.5825 62.3762H56.9499L56.035 41.4287H64.4974ZM60.3806 73.5716C59.0083 73.5716 57.88 73.1926 56.9956 72.4345C56.1418 71.6474 55.7148 70.6853 55.7148 69.5482C55.7148 68.3821 56.1418 67.4054 56.9956 66.6182C57.88 65.831 59.0083 65.4375 60.3806 65.4375C61.7224 65.4375 62.8202 65.831 63.674 66.6182C64.5584 67.4054 65.0006 68.3821 65.0006 69.5482C65.0006 70.6853 64.5584 71.6474 63.674 72.4345C62.8202 73.1926 61.7224 73.5716 60.3806 73.5716Z" fill="#FFA800"/></svg>

        <p style="margin-bottom: 12px;" class="popup-case-name">Удаление заказа</p>
        <p class="popup-order-name-text">Вы действительно хотите удалить заказ?</p> 
        <button style="max-width: fit-content; margin-bottom: 18px;" class="btn--purple" type="button">Да, продолжить</button>
        <button class="popup-cancel link--grey">Отмена</button>
    </div>
</section>