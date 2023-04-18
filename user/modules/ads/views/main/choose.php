<?php

use yii\helpers\Url;
use yii\helpers\Html;

$js = <<< JS
//Кнопка "Ещё" в фильтре
$('.specialists_main-filter-group-1 li').each(function(e){
    if(e >= 9){
        $('.input-checkbox-label-more-1').show();
        $(this).addClass('hide');
    }
});
$('.input-checkbox-label-more-1').on('click', function(){
    $('.specialists_main-filter-group-1 li').each(function(e){
        if(e >= 9){
            $('.input-checkbox-label-more-1').hide();
            $(this).removeClass('hide');
        }
    });
});

//Вторая кнопка "Ещё" в фильтре
$('.specialists_main-filter-group-2 li').each(function(e){
    if(e >= 4){
        $('.input-checkbox-label-more-2').show();
        $(this).addClass('hide');
    }
});
$('.input-checkbox-label-more-2').on('click', function(){
    $('.specialists_main-filter-group-2 li').each(function(e){
        if(e >= 4){
            $('.input-checkbox-label-more-2').hide();
            $(this).removeClass('hide');
        }
    });
});
JS;
$this->registerJs($js);

$this->title = 'Выбрать исполнителя';
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
                <span class="bcr__span">
                    Все исполнители
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">Выбрать исполнителя</h1>
        <p class="specialists-all-spec">Всего специалистов: <span>1 376</span></p>
    </div>

    <article class="choose">
        <div class="choose_main">
            <section class="choose_main-search">
                <input form="choose-filter" type="text" inputmode="search" name="search" class="input-t input-search">
                <button class="choose-filter-submit" type="submit" form="choose-filter">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.5 3C17.6421 3 21 6.35786 21 10.5C21 14.6421 17.6421 18 13.5 18C11.699 18 10.0464 17.3652 8.75345 16.3072L4.28033 20.7803C3.98744 21.0732 3.51256 21.0732 3.21967 20.7803C2.92678 20.4874 2.92678 20.0126 3.21967 19.7197L7.69279 15.2465C6.63477 13.9536 6 12.301 6 10.5C6 6.35786 9.35786 3 13.5 3ZM19.5 10.5C19.5 7.18629 16.8137 4.5 13.5 4.5C10.1863 4.5 7.5 7.18629 7.5 10.5C7.5 13.8137 10.1863 16.5 13.5 16.5C16.8137 16.5 19.5 13.8137 19.5 10.5Z" fill="#5B617C"/></svg>
                </button>
            </section>
            <section class="spetialist-card">
                <a href="<?= Url::to(['specialist']) ?>" class="spetialist-card-link"></a>
                <div class="spetialist-card_top">
                    <div class="spetialist-card_top_left">
                        <div class="spetialist-card_top_left-img">
                            <img src="<?= Url::to('/img/afo/manb.svg') ?>" alt="spetialist-avatar">
                        </div>
                        <p class="spetialist-card_top_left-name">Александр Виноградов</p>
                    </div>
                    <div class="spetialist-card_top_right">
                        <p class="spetialist-card_top_right-rating">
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span>5.0</spa>
                        </p>
                        <div class="spetialist-card_top_right-spetial">
                            <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                            <p class="spetialist-card_top_right-spetial-txt">эксперт</p>
                        </div>
                    </div>
                </div>
                <p class="spetialist-card-ttl">Выполнено заказов</p>
                <p class="spetialist-card-num">264</p>
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
                <div class="spetialist-card_bottom">
                    <div class="spetialist-card_bottom_left">
                        <button style="max-width: fit-content;" class="btn--purple" type="button">Предложить заказ</button>
                        <a class="link--purple" href="">Оставить отзыв</a>
                    </div>
                    <p class="spetialist-card_bottom-t">198 отзывов</p>
                </div>
            </section>
            <section class="spetialist-card">
                <a href="<?= Url::to(['specialist']) ?>" class="spetialist-card-link"></a>
                <div class="spetialist-card_top">
                    <div class="spetialist-card_top_left">
                        <div class="spetialist-card_top_left-img">
                            <img src="<?= Url::to('/img/afo/manb.svg') ?>" alt="spetialist-avatar">
                        </div>
                        <p class="spetialist-card_top_left-name">Александр Виноградов</p>
                    </div>
                    <div class="spetialist-card_top_right">
                        <p class="spetialist-card_top_right-rating">
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span>5.0</spa>
                        </p>
                        <div class="spetialist-card_top_right-spetial">
                            <img src="<?= Url::to('/img/afo/best2.svg') ?>" alt="1">
                            <p class="spetialist-card_top_right-spetial-txt">мастер</p>
                        </div>
                    </div>
                </div>
                <p class="spetialist-card-ttl">Выполнено заказов</p>
                <p class="spetialist-card-num">264</p>
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
                <div class="spetialist-card_bottom">
                    <div class="spetialist-card_bottom_left">
                        <button style="max-width: fit-content;" class="btn--purple" type="button">Предложить заказ</button>
                    </div>
                    <p class="spetialist-card_bottom-t">198 отзывов</p>
                </div>
            </section>
            <section class="spetialist-card">
                <a href="<?= Url::to(['specialist']) ?>" class="spetialist-card-link"></a>
                <div class="spetialist-card_top">
                    <div class="spetialist-card_top_left">
                        <div class="spetialist-card_top_left-img">
                            <img src="<?= Url::to('/img/afo/manb.svg') ?>" alt="spetialist-avatar">
                        </div>
                        <p class="spetialist-card_top_left-name">Александр Виноградов</p>
                    </div>
                    <div class="spetialist-card_top_right">
                        <p class="spetialist-card_top_right-rating">
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span>5.0</spa>
                        </p>
                        <div class="spetialist-card_top_right-spetial">
                            <img src="<?= Url::to('/img/afo/best3.svg') ?>" alt="1">
                            <p class="spetialist-card_top_right-spetial-txt">адепт</p>
                        </div>
                    </div>
                </div>
                <p class="spetialist-card-ttl">Выполнено заказов</p>
                <p class="spetialist-card-num">264</p>
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
                <div class="spetialist-card_bottom">
                    <div class="spetialist-card_bottom_left">
                        <button style="max-width: fit-content;" class="btn--purple" type="button">Предложить заказ</button>
                    </div>
                    <p class="spetialist-card_bottom-t">198 отзывов</p>
                </div>
            </section>
            <section class="spetialist-card">
                <a href="<?= Url::to(['specialist']) ?>" class="spetialist-card-link"></a>
                <div class="spetialist-card_top">
                    <div class="spetialist-card_top_left">
                        <div class="spetialist-card_top_left-img">
                            <img src="<?= Url::to('/img/afo/manb.svg') ?>" alt="spetialist-avatar">
                        </div>
                        <p class="spetialist-card_top_left-name">Александр Виноградов</p>
                    </div>
                    <div class="spetialist-card_top_right">
                        <p class="spetialist-card_top_right-rating">
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M8.27569 12.4208L11.4279 14.4179C11.8308 14.6732 12.3311 14.2935 12.2115 13.8232L11.3008 10.2405C11.2752 10.1407 11.2782 10.0357 11.3096 9.9376C11.3409 9.83946 11.3994 9.75218 11.4781 9.68577L14.3049 7.33306C14.6763 7.02392 14.4846 6.40751 14.0074 6.37654L10.3159 6.13696C10.2165 6.12986 10.1211 6.09465 10.0409 6.03545C9.96069 5.97625 9.89896 5.89548 9.86289 5.80255L8.48612 2.33549C8.44869 2.23685 8.38215 2.15194 8.29532 2.09201C8.2085 2.03209 8.1055 2 8 2C7.89451 2 7.79151 2.03209 7.70468 2.09201C7.61786 2.15194 7.55131 2.23685 7.51389 2.33549L6.13712 5.80255C6.10104 5.89548 6.03931 5.97625 5.95912 6.03545C5.87892 6.09465 5.78355 6.12986 5.68412 6.13696L1.99263 6.37654C1.51544 6.40751 1.32373 7.02392 1.69515 7.33306L4.52185 9.68577C4.60063 9.75218 4.65906 9.83946 4.69044 9.9376C4.72181 10.0357 4.72485 10.1407 4.6992 10.2405L3.85459 13.563C3.71111 14.1274 4.31143 14.583 4.79495 14.2767L7.72431 12.4208C7.8067 12.3683 7.90234 12.3405 8 12.3405C8.09767 12.3405 8.1933 12.3683 8.27569 12.4208Z" fill="#2CCD65" stroke="#2CCD65" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span>5.0</spa>
                        </p>
                    </div>
                </div>
                <p class="spetialist-card-ttl">Выполнено заказов</p>
                <p class="spetialist-card-num">264</p>
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
                <div class="spetialist-card_bottom">
                    <div class="spetialist-card_bottom_left">
                        <button style="max-width: fit-content;" class="btn--purple" type="button">Предложить заказ</button>
                    </div>
                    <p class="spetialist-card_bottom-t">198 отзывов</p>
                </div>
            </section>
        </div>
        <section class="choose_filter">
            <?= Html::beginForm('', '', ['class' => 'choose-filter', 'id' => 'choose-filter']) ?>
            <div class="specialists_main-filter_container">
                        <h3 class="specialists_main-filter-title">Выберите специализацию</h3>

                        <ul class="specialists_main-filter-group specialists_main-filter-group-1">
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="specialization[]" value="e-mail маркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">e-mail маркетинг</p>
                                        <p class="input-checkbox-label-count">45</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="specialization[]" value="e-mail маркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">e-mail маркетинг</p>
                                        <p class="input-checkbox-label-count">45</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="specialization[]" value="e-mail маркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">e-mail маркетинг</p>
                                        <p class="input-checkbox-label-count">45</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="specialization[]" value="e-mail маркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">e-mail маркетинг</p>
                                        <p class="input-checkbox-label-count">45</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="specialization[]" value="e-mail маркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">e-mail маркетинг</p>
                                        <p class="input-checkbox-label-count">45</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="specialization[]" value="e-mail маркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">e-mail маркетинг</p>
                                        <p class="input-checkbox-label-count">45</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="specialization[]" value="e-mail маркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">e-mail маркетинг</p>
                                        <p class="input-checkbox-label-count">45</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="specialization[]" value="e-mail маркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">e-mail маркетинг</p>
                                        <p class="input-checkbox-label-count">45</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="specialization[]" value="e-mail маркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">e-mail маркетинг</p>
                                        <p class="input-checkbox-label-count">45</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="specialization[]" value="e-mail маркетинг" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">e-mail маркетинг</p>
                                        <p class="input-checkbox-label-count">45</p>
                                    </div>
                                </label>
                            </li>
                        </ul>
                        <button type="button" class="input-checkbox-label-more input-checkbox-label-more-1">Еще +</button>
                        <div class="specialists_main-filter-line"></div>
                        <label class="input-checkbox-label-sp">
                            <input type="checkbox" name="only-reviews[]" value="Только с отзывами" class="input-hide">
                            <div class="input-checkbox-labelsp-indicator">
                                <div class="input-checkbox-labelsp-indicator-item">
                                    <div class="input-checkbox-labelsp-indicator-item-fill"></div>
                                </div>
                                <p class="input-checkbox-labelsp-text">Только с отзывами</p>
                            </div>
                        </label>
                        <div class="specialists_main-filter-line"></div>
                        <h3 class="specialists_main-filter-title">Площадка</h3>
                        <ul class="specialists_main-filter-group specialists_main-filter-group-2">
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="plane[]" value="Facebook" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">Facebook</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="plane[]" value="Facebook" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">Facebook</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="plane[]" value="Facebook" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">Facebook</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="plane[]" value="Facebook" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">Facebook</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="plane[]" value="Facebook" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">Facebook</p>
                                    </div>
                                </label>
                            </li>
                            <li>
                                <label class="input-checkbox-label">
                                    <input type="checkbox" name="plane[]" value="Facebook" class="input-hide">
                                    <div class="input-checkbox-label-indicator">
                                        <p class="input-checkbox-label-text">Facebook</p>
                                    </div>
                                </label>
                            </li>
                        </ul>
                        <button type="button" class="input-checkbox-label-more input-checkbox-label-more-2">Еще +</button>
                    </div>
            <?= Html::endForm(); ?>
        </section>
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