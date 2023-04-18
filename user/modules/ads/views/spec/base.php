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

$this->title = 'База знаний';
?>

<section class="rightInfo sp">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__span">
                    База знаний
                </span>
            </li>
        </ul>
    </div>

    <div class="title_row">
        <h1 class="Bal-ttl title-main">База знаний</h1>
        <p class="specialists-all-spec">Всего статей: <span>1 376</span></p>
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
                <a href="<?= Url::to(['article']) ?>" class="spetialist-card-link"></a>
                <h2 class="article-name">Рынок рекламы</h2>
                <p class="article-text">В понятии экономики рынок рекламы подразумевает изучение спроса и предложения на услуги продвижения бренда, товара. Это отдельный сегмент экономики, в рамках которого взаимодействуют PR-компании, производители и потребители.</p>
                <div class="spetialist-card_bottom">
                   <p class="article-date">12.02.2022</p>
                   <p class="link--purple article-l-t">Читать статью <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.125 10H16.875" stroke="#EB38D2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.25 4.375L16.875 10L11.25 15.625" stroke="#EB38D2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></p>
                </div>
            </section>
            <section class="spetialist-card">
                <a href="<?= Url::to(['article']) ?>" class="spetialist-card-link"></a>
                <div class="article_top">
                    <iframe src="https://www.youtube.com/embed/Vv5C8OXMevI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    <div>
                        <h2 class="article-name">Рынок рекламы</h2>
                        <p class="article-text">В понятии экономики рынок рекламы подразумевает изучение спроса и предложения на услуги продвижения бренда, товара. Это отдельный сегмент экономики, в рамках которого взаимодействуют PR-компании, производители и потребители.</p>
                    </div>
                </div>
                <div class="spetialist-card_bottom">
                   <p class="article-date">12.02.2022</p>
                   <p class="link--purple article-l-t">Читать статью <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.125 10H16.875" stroke="#EB38D2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M11.25 4.375L16.875 10L11.25 15.625" stroke="#EB38D2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg></p>
                </div>
            </section>
            <section class="spetialist-card">
                <p class="article-set-ttl">Подборки статей</p>
                <div class="article-set">
                    <div class="article-set-item">
                        <a href="<?= Url::to(['baseset']) ?>" class="spetialist-card-link"></a>
                        <img class="article-set-image" src="<?= Url::to('/img/afo/bb.svg') ?>" alt="Рынок рекламы">
                        <p class="article-set-irem-ttl">Рынок рекламы</p>
                    </div>
                    <div class="article-set-item">
                        <a href="<?= Url::to(['baseset']) ?>" class="spetialist-card-link"></a>
                        <img class="article-set-image" src="<?= Url::to('/img/afo/bb.svg') ?>" alt="Рынок рекламы">
                        <p class="article-set-irem-ttl">Рынок рекламы</p>
                    </div>
                    <div class="article-set-item">
                        <a href="<?= Url::to(['baseset']) ?>" class="spetialist-card-link"></a>
                        <img class="article-set-image" src="<?= Url::to('/img/afo/bb.svg') ?>" alt="Рынок рекламы">
                        <p class="article-set-irem-ttl">Рынок рекламы</p>
                    </div>
                    <div class="article-set-item">
                        <a href="<?= Url::to(['baseset']) ?>" class="spetialist-card-link"></a>
                        <img class="article-set-image" src="<?= Url::to('/img/afo/bb.svg') ?>" alt="Рынок рекламы">
                        <p class="article-set-irem-ttl">Рынок рекламы</p>
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
                        <label class="input-checkbox-label-sp">
                            <input type="checkbox" name="only-reviews[]" value="Только с видео" class="input-hide">
                            <div class="input-checkbox-labelsp-indicator">
                                <div class="input-checkbox-labelsp-indicator-item">
                                    <div class="input-checkbox-labelsp-indicator-item-fill"></div>
                                </div>
                                <p class="input-checkbox-labelsp-text">Только с видео</p>
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