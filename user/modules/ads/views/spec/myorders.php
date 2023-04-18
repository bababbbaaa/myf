<?php

use yii\helpers\Url;
use yii\helpers\Html;

$js = <<< JS
    $('.myorders-btn').on('click', function(){
        $('.myorders-btn').removeClass('active');
        $(this).addClass('active');

        if($(this).hasClass('myorders-btn-1')){
            $('.myorders-section').hide(0, function(){
                $('.myorders-section-1').show(0);
            });
        }else if($(this).hasClass('myorders-btn-2')){
            $('.myorders-section').hide(0, function(){
                $('.myorders-section-2').show(0);
            });
        }else if($(this).hasClass('myorders-btn-3')){
            $('.myorders-section').hide(0, function(){
                $('.myorders-section-3').show(0);
            });
        }
    });

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

$this->title = 'Мои заказы';
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
                <span class="bcr__span">
                    Поиск исполнителя
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">Мои заказы</h1>
    </div>

    <div class="myorders-btns">
        <button class="myorders-btn myorders-btn-1 active">Поиск исполнителя</button>
        <button class="myorders-btn myorders-btn-2">Активные</button>
        <button class="myorders-btn myorders-btn-3">Архив</button>
    </div>

    <article class="choose">
        <div class="choose_main">
            <section class="choose_main-search">
                <input form="choose-filter" type="text" inputmode="search" name="search" class="input-t input-search">
                <button class="choose-filter-submit" type="submit" form="choose-filter">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M13.5 3C17.6421 3 21 6.35786 21 10.5C21 14.6421 17.6421 18 13.5 18C11.699 18 10.0464 17.3652 8.75345 16.3072L4.28033 20.7803C3.98744 21.0732 3.51256 21.0732 3.21967 20.7803C2.92678 20.4874 2.92678 20.0126 3.21967 19.7197L7.69279 15.2465C6.63477 13.9536 6 12.301 6 10.5C6 6.35786 9.35786 3 13.5 3ZM19.5 10.5C19.5 7.18629 16.8137 4.5 13.5 4.5C10.1863 4.5 7.5 7.18629 7.5 10.5C7.5 13.8137 10.1863 16.5 13.5 16.5C16.8137 16.5 19.5 13.8137 19.5 10.5Z" fill="#5B617C"/></svg>
                </button>
            </section>

            <section class="myorders-section myorders-section-1">
                <div class="myorders-section_container">
                    <div class="myorders-section_card">
                        <div class="myorders-section_card-idc">
                            <div class="myorders-section_card-idc-point"></div>
                            <span>поиск исполнителя</span>
                        </div>
                        <h2 class="myorders-section_card-ttl">Реклама youtube-канала «Про книги»</h2>
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
                            <a href="" style="max-width: fit-content;" class="btn--pink-white">Подробнее о заказе</a>
                            <p class="myorders-section_card-last-text">опубликован: <span>6.01.2022</span></p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="myorders-section myorders-section-2">
                <div class="myorders-section_container">
                    <div class="myorders-section_card">
                        <div class="myorders-section_card-idc green">
                            <div class="myorders-section_card-idc-point"></div>
                            <span>в работе</span>
                        </div>
                        <h2 class="myorders-section_card-ttl">Реклама youtube-канала «Про книги»</h2>
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
                            <div class="myorders-section_card-group-item">
                                <p class="myorders-section_card-group-item-ttl">текущий этап</p>
                                <p class="myorders-section_card-group-item-text">Выполнение</p>
                            </div>
                        </div>
                        <div class="myorders-section_card-group-isp">
                            <p class="myorders-section_card-group-isp-text">исполнитель</p>
                            <div class="specialist-main-tab_orders-item_main-group-g">
                                <div class="specialist-main-tab_orders-item_main-group-g-img">
                                    <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                                </div>
                                <p class="specialist-main-tab_orders-item_main-group-g-name">Иван Фёдеров</p>
                            </div>
                        </div>
                        <div class="myorders-section_card-last">
                            <a href="" style="max-width: fit-content;" class="btn--pink-white">Подробнее о заказе</a>
                            <p class="myorders-section_card-last-text">опубликован: <span>6.01.2022</span></p>
                        </div>
                    </div>

                    <div class="myorders-section_card">
                        <div class="myorders-section_card-idc blue">
                            <div class="myorders-section_card-idc-point"></div>
                            <span>в работе</span>
                        </div>
                        <h2 class="myorders-section_card-ttl">Реклама youtube-канала «Про книги»</h2>
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
                            <div class="myorders-section_card-group-item">
                                <p class="myorders-section_card-group-item-ttl">текущий этап</p>
                                <p class="myorders-section_card-group-item-text">Ожидает подтверждения</p>
                            </div>
                        </div>
                        <div class="myorders-section_card-group-isp">
                            <p class="myorders-section_card-group-isp-text">исполнитель</p>
                            <div class="specialist-main-tab_orders-item_main-group-g">
                                <div class="specialist-main-tab_orders-item_main-group-g-img">
                                    <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                                </div>
                                <p class="specialist-main-tab_orders-item_main-group-g-name">Иван Фёдеров</p>
                            </div>
                        </div>
                        <div class="myorders-section_card-last">
                            <a href="" style="max-width: fit-content;" class="btn--pink-white">Подробнее о заказе</a>
                            <p class="myorders-section_card-last-text">опубликован: <span>6.01.2022</span></p>
                        </div>
                    </div>

                    <div class="myorders-section_card">
                        <div class="myorders-section_card-idc red">
                            <div class="myorders-section_card-idc-point"></div>
                            <span>в работе</span>
                        </div>
                        <h2 class="myorders-section_card-ttl">Реклама youtube-канала «Про книги»</h2>
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
                            <div class="myorders-section_card-group-item">
                                <p class="myorders-section_card-group-item-ttl">текущий этап</p>
                                <p class="myorders-section_card-group-item-text">Выполнение</p>
                            </div>
                        </div>
                        <div class="myorders-section_card-group-isp">
                            <p class="myorders-section_card-group-isp-text">исполнитель</p>
                            <div class="specialist-main-tab_orders-item_main-group-g">
                                <div class="specialist-main-tab_orders-item_main-group-g-img">
                                    <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                                </div>
                                <p class="specialist-main-tab_orders-item_main-group-g-name">Иван Фёдеров</p>
                            </div>
                        </div>
                        <div class="myorders-section_card-last">
                            <a href="" style="max-width: fit-content;" class="btn--pink-white">Подробнее о заказе</a>
                            <p class="myorders-section_card-last-text">опубликован: <span>6.01.2022</span></p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="myorders-section myorders-section-3">
                <div class="myorders-section_container">
                    <div class="myorders-section_card">
                        <div class="myorders-section_card-idc gray">
                            <div class="myorders-section_card-idc-point"></div>
                            <span>выполнен</span>
                        </div>
                        <h2 class="myorders-section_card-ttl">Реклама youtube-канала «Про книги»</h2>
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
                        <div class="myorders-section_card-group-isp">
                            <p class="myorders-section_card-group-isp-text">исполнитель</p>
                            <div class="specialist-main-tab_orders-item_main-group-g">
                                <div class="specialist-main-tab_orders-item_main-group-g-img">
                                    <img src="<?= Url::to('/img/afo/best1.svg') ?>" alt="1">
                                </div>
                                <p class="specialist-main-tab_orders-item_main-group-g-name">Иван Фёдеров</p>
                            </div>
                        </div>
                        <div class="myorders-section_card-last">
                            <div class="myorders-section_card-last-btns">
                                <a href="" style="max-width: fit-content;" class="btn--purple">Подробнее о заказе</a>
                                <a href="" style="text-decoration: none;" class="link--purple">Оставить отзыв</a>
                            </div>
                            <p class="myorders-section_card-last-text">опубликован: <span>6.01.2022</span></p>
                        </div>
                    </div>
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