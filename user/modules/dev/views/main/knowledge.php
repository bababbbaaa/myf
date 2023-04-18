<?php

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'База знаний';
$js = <<< JS
$('.know__popular-link--close').click(function(e){
  e.preventDefault();
});
$(".know-exclusive_list-item-link").on("click", function (){
  $(".know__popup").show();
});
$('.know__search-inner').on('click', '.know__search-btn', function(e) {
    $('.know__search').submit();
});
JS;
$this->registerJs($js);

?>
<section class="rightInfo">
    <div class="know">
        <section class="know_top-card">
            <div class="know_top-card-image">
                <img src="<?= Url::to(['../img/know/know-top-1.png']) ?>" alt="dots">

                <div class="know_top-card-group">
                    <div class="know_top-card-group-item">
                        <svg width="85" height="94" viewBox="0 0 85 94" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M42.5647 93.1278L0.417969 70.0346V23.8481L42.5647 0.754883L84.7114 23.8481V70.0346L42.5647 93.1278ZM0.79596 69.8556L42.5647 92.7698L84.3334 69.8556V24.0271L42.5647 1.29194L0.79596 24.2062V69.8556Z" fill="url(#paint0_linear_436_393)"/><defs><linearGradient id="paint0_linear_436_393" x1="437.659" y1="624.817" x2="40.6079" y2="-22.4101" gradientUnits="userSpaceOnUse"><stop stop-color="#52BBE8"/><stop offset="0.196" stop-color="#69C3EB"/><stop offset="0.6037" stop-color="#A3D8F1"/><stop offset="1" stop-color="#E1EFF8"/></linearGradient></defs></svg>
                    </div>
                    <div class="know_top-card-group-item">
                        <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.2" d="M9.65803 4.7342C9.65803 2.73242 7.72075 0.897461 5.20231 0.897461C2.68386 0.897461 0.746582 2.56561 0.746582 4.7342C0.746582 6.73597 2.68386 8.57093 5.20231 8.57093C7.72075 8.57093 9.65803 6.73597 9.65803 4.7342Z" fill="url(#paint0_linear_436_388)"/><defs><linearGradient id="paint0_linear_436_388" x1="414.882" y1="549.179" x2="-16.1009" y2="-223.613" gradientUnits="userSpaceOnUse"><stop stop-color="#52BBE8"/><stop offset="0.196" stop-color="#69C3EB"/><stop offset="0.6037" stop-color="#A3D8F1"/><stop offset="1" stop-color="#E1EFF8"/></linearGradient></defs></svg>
                    </div>
                    <div class="know_top-card-group-item">
                        <svg width="7" height="7" viewBox="0 0 7 7" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.2" d="M3.68294 6.80431C5.47263 6.80431 6.92343 5.43009 6.92343 3.73492C6.92343 2.03974 5.47263 0.665527 3.68294 0.665527C1.89324 0.665527 0.442383 2.03974 0.442383 3.73492C0.442383 5.43009 1.89324 6.80431 3.68294 6.80431Z" fill="url(#paint0_linear_436_391)"/><defs><linearGradient id="paint0_linear_436_391" x1="376.161" y1="548.31" x2="-112.613" y2="-248.432" gradientUnits="userSpaceOnUse"><stop stop-color="#52BBE8"/><stop offset="0.196" stop-color="#69C3EB"/><stop offset="0.6037" stop-color="#A3D8F1"/><stop offset="1" stop-color="#E1EFF8"/></linearGradient></defs></svg>
                    </div>
                    <div class="know_top-card-group-item">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.2" d="M6.0891 11.1227C8.99735 11.1227 11.355 8.71787 11.355 5.75131C11.355 2.78476 8.99735 0.379883 6.0891 0.379883C3.18084 0.379883 0.823242 2.78476 0.823242 5.75131C0.823242 8.71787 3.18084 11.1227 6.0891 11.1227Z" fill="url(#paint0_linear_436_387)"/><defs><linearGradient id="paint0_linear_436_387" x1="334.944" y1="523.58" x2="-182.434" y2="-259.549" gradientUnits="userSpaceOnUse"><stop stop-color="#52BBE8"/><stop offset="0.196" stop-color="#69C3EB"/><stop offset="0.6037" stop-color="#A3D8F1"/><stop offset="1" stop-color="#E1EFF8"/></linearGradient></defs></svg>
                    </div>
                    <div class="know_top-card-group-item">
                        <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.2" d="M0.860352 6.14292C0.860352 9.18673 3.31775 11.5143 6.53127 11.5143C9.74479 11.5143 12.2022 9.18673 12.2022 6.14292C12.2022 3.0991 9.74479 0.771484 6.53127 0.771484C3.31775 0.771484 0.860352 3.0991 0.860352 6.14292Z" fill="url(#paint0_linear_436_392)"/><defs><linearGradient id="paint0_linear_436_392" x1="320.086" y1="464.724" x2="-164.613" y2="-325.375" gradientUnits="userSpaceOnUse"><stop stop-color="#52BBE8"/><stop offset="0.196" stop-color="#69C3EB"/><stop offset="0.6037" stop-color="#A3D8F1"/><stop offset="1" stop-color="#E1EFF8"/></linearGradient></defs></svg>
                    </div>
                    <div class="know_top-card-group-item">
                        <svg width="10" height="9" viewBox="0 0 10 9" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.2" d="M5.12659 0.555176C2.71309 0.555176 0.670898 2.48953 0.670898 4.77559C0.670898 7.06164 2.71309 8.996 5.12659 8.996C7.5401 8.996 9.58235 7.06164 9.58235 4.77559C9.58235 2.48953 7.5401 0.555176 5.12659 0.555176Z" fill="url(#paint0_linear_436_386)"/><defs><linearGradient id="paint0_linear_436_386" x1="286.543" y1="416.412" x2="-189.503" y2="-359.583" gradientUnits="userSpaceOnUse"><stop stop-color="#52BBE8"/><stop offset="0.196" stop-color="#69C3EB"/><stop offset="0.6037" stop-color="#A3D8F1"/><stop offset="1" stop-color="#E1EFF8"/></linearGradient></defs></svg>
                    </div>
                    <div class="know_top-card-group-item">
                        <svg width="7" height="8" viewBox="0 0 7 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.2" d="M3.5696 7.62048C5.35929 7.62048 6.81015 6.07449 6.81015 4.16741C6.81015 2.26034 5.35929 0.714355 3.5696 0.714355C1.77991 0.714355 0.329102 2.26034 0.329102 4.16741C0.329102 6.07449 1.77991 7.62048 3.5696 7.62048Z" fill="url(#paint0_linear_436_394)"/><defs><linearGradient id="paint0_linear_436_394" x1="249.216" y1="408.239" x2="-295.463" y2="-380.982" gradientUnits="userSpaceOnUse"><stop stop-color="#52BBE8"/><stop offset="0.196" stop-color="#69C3EB"/><stop offset="0.6037" stop-color="#A3D8F1"/><stop offset="1" stop-color="#E1EFF8"/></linearGradient></defs></svg>
                    </div>
                    <div class="know_top-card-group-item">
                        <svg width="9" height="8" viewBox="0 0 9 8" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.2" d="M4.5697 7.6366C6.80682 7.6366 8.62036 6.09061 8.62036 4.18353C8.62036 2.27646 6.80682 0.730469 4.5697 0.730469C2.33258 0.730469 0.519043 2.27646 0.519043 4.18353C0.519043 6.09061 2.33258 7.6366 4.5697 7.6366Z" fill="url(#paint0_linear_436_390)"/><defs><linearGradient id="paint0_linear_436_390" x1="251.964" y1="329.788" x2="-191.733" y2="-473.839" gradientUnits="userSpaceOnUse"><stop stop-color="#52BBE8"/><stop offset="0.196" stop-color="#69C3EB"/><stop offset="0.6037" stop-color="#A3D8F1"/><stop offset="1" stop-color="#E1EFF8"/></linearGradient></defs></svg>
                    </div>
                    <div class="know_top-card-group-item">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.2" d="M7.60857 14.0984C11.6354 14.0984 14.8997 11.0064 14.8997 7.19226C14.8997 3.37811 11.6354 0.286133 7.60857 0.286133C3.58174 0.286133 0.317383 3.37811 0.317383 7.19226C0.317383 11.0064 3.58174 14.0984 7.60857 14.0984Z" fill="url(#paint0_linear_436_385)"/><defs><linearGradient id="paint0_linear_436_385" x1="212.949" y1="307.316" x2="-279.039" y2="-494.666" gradientUnits="userSpaceOnUse"><stop stop-color="#52BBE8"/><stop offset="0.196" stop-color="#69C3EB"/><stop offset="0.6037" stop-color="#A3D8F1"/><stop offset="1" stop-color="#E1EFF8"/></linearGradient></defs></svg>
                    </div>
                </div>
            </div>

            <h1 class="know_top-card-title">База знаний</h1>
            <p class="know_top-card-text">
                База знаний FEMIDA. FORCE — это электронная библиотека на юридическую тематику. Мы рады делиться с вами
                знаниями, которые копили долгие годы.
            </p>
    
            <?= Html::beginForm(Url::to(['article-search']), 'get', ['class' => 'know__search']) ?>
            <label class="know__search-label">
                <div class="know__search-inner">
                    <input class="know__search-input" type="search" name="word" placeholder="Введите ваш запрос">
                    <button class="know__search-btn" type="submit" value="Найти">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M5.4202 10.216C2.73228 10.216 0.553285 8.00362 0.553285 5.27451C0.553285 2.54539 2.73228 0.333008 5.4202 0.333008C8.10812 0.333008 10.2871 2.54539 10.2871 5.27451C10.2871 6.41766 9.9048 7.47015 9.26291 8.30735L13.8456 13.5419C14.0931 13.8246 14.0931 14.2829 13.8456 14.5656C13.5982 14.8483 13.1969 14.8483 12.9494 14.5656L8.30195 9.25705C7.49521 9.85985 6.49867 10.216 5.4202 10.216ZM5.42064 8.69559C7.28151 8.69559 8.79004 7.16394 8.79004 5.27455C8.79004 3.38517 7.28151 1.85352 5.42064 1.85352C3.55977 1.85352 2.05124 3.38517 2.05124 5.27455C2.05124 7.16394 3.55977 8.69559 5.42064 8.69559Z" fill="#0052CC"/></svg>
                    </button>
                </div>
            </label>
            <?= Html::endForm() ?>
        </section>

        <div class="know_container">
            <section class="know__popular">
                <h3 class="know__popular-title">
                    Популярные статьи
                </h3>

                <ul class="know__popular-list">
                    <?php foreach ($popularArticle as $k => $v): ?>
                        <li class="know__popular-item">
                            <a href="<?= Url::to(['knowledgepage', 'link' => $v['link']]) ?>" class="know__popular-link"></a>

                            <p class="know__popular-item-title"><?= $v['title'] ?></p>

                            <div class="know__popular-item-bottom">
                                <div class="know__popular-add">
                                    <span class="know__popular-eye eye">
                                        <?= $v['views'] ?>
                                    </span>
                                </div>
                                <div class="know__popular-item-bottom-btn">
                                    <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg"><path opacity="0.949" fill-rule="evenodd" clip-rule="evenodd" d="M0.841797 0.744101C1.01654 0.733996 1.18579 0.759386 1.34961 0.820273C3.18434 2.40099 5.00398 4.0006 6.80859 5.6191C6.91016 5.8561 6.91016 6.09304 6.80859 6.33004C5.03973 7.89578 3.27082 9.46157 1.50195 11.0273C0.895168 11.361 0.505879 11.1917 0.333984 10.5195C0.356023 10.3857 0.398324 10.2588 0.460938 10.1386C2.02043 8.73971 3.58622 7.35171 5.1582 5.97457C3.58622 4.59743 2.02043 3.20943 0.460938 1.81051C0.250754 1.33215 0.377707 0.976679 0.841797 0.744101Z" fill="#43419E"/></svg>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </section>
<!--            <section class="know-exclusive">-->
<!--                <h2 class="know-exclusive-titlle">Эксклюзивная документация</h2>-->
<!--                <ul class="know-exclusive_list">-->
<!--                    <li class="know-exclusive_list-item">-->
<!--                        <p class="know-exclusive_list-item-title">Договор займа с процентами</p>-->
<!--                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>-->
<!--                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>-->
<!--                        <div class="know__popular-add">-->
<!--                            <span class="know__popular-eye eye">-->
<!--                                3560-->
<!--                            </span>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li class="know-exclusive_list-item">-->
<!--                        <p class="know-exclusive_list-item-title">Мировое соглашение</p>-->
<!--                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>-->
<!--                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>-->
<!--                        <div class="know__popular-add">-->
<!--                            <span class="know__popular-eye eye">-->
<!--                                3560-->
<!--                            </span>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li class="know-exclusive_list-item">-->
<!--                        <p class="know-exclusive_list-item-title">Договор об отступном</p>-->
<!--                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>-->
<!--                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>-->
<!--                        <div class="know__popular-add">-->
<!--                            <span class="know__popular-eye eye">-->
<!--                                3560-->
<!--                            </span>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li class="know-exclusive_list-item">-->
<!--                        <p class="know-exclusive_list-item-title">Заявление об утверждении мирового соглашения</p>-->
<!--                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>-->
<!--                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>-->
<!--                        <div class="know__popular-add">-->
<!--                            <span class="know__popular-eye eye">-->
<!--                                3560-->
<!--                            </span>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li class="know-exclusive_list-item">-->
<!--                        <p class="know-exclusive_list-item-title">Договор об отступном</p>-->
<!--                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>-->
<!--                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>-->
<!--                        <div class="know__popular-add">-->
<!--                            <span class="know__popular-eye eye">-->
<!--                                3560-->
<!--                            </span>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li class="know-exclusive_list-item">-->
<!--                        <p class="know-exclusive_list-item-title">Договор об отступном</p>-->
<!--                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>-->
<!--                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>-->
<!--                        <div class="know__popular-add">-->
<!--                            <span class="know__popular-eye eye">-->
<!--                                3560-->
<!--                            </span>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li class="know-exclusive_list-item">-->
<!--                        <p class="know-exclusive_list-item-title">Заявление об утверждении мирового соглашения</p>-->
<!--                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>-->
<!--                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>-->
<!--                        <div class="know__popular-add">-->
<!--                            <span class="know__popular-eye eye">-->
<!--                                3560-->
<!--                            </span>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                    <li class="know-exclusive_list-item">-->
<!--                        <p class="know-exclusive_list-item-title">Договор об отступном</p>-->
<!--                        <p class="know-exclusive_list-item-text">Данный документ является образцом договора займа с процентами</p>-->
<!--                        <p class="know-exclusive_list-item-link">Получить доступ <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M20.7071 8.7071C21.0976 8.31658 21.0976 7.68342 20.7071 7.29289L14.3431 0.928931C13.9526 0.538407 13.3195 0.538407 12.9289 0.928931C12.5384 1.31946 12.5384 1.95262 12.9289 2.34314L18.5858 8L12.9289 13.6569C12.5384 14.0474 12.5384 14.6805 12.9289 15.0711C13.3195 15.4616 13.9526 15.4616 14.3431 15.0711L20.7071 8.7071ZM8.74228e-08 9L20 9L20 7L-8.74228e-08 7L8.74228e-08 9Z" fill="#43419E"/></svg></p>-->
<!--                        <div class="know__popular-add">-->
<!--                            <span class="know__popular-eye eye">-->
<!--                                3560-->
<!--                            </span>-->
<!--                        </div>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </section>-->

            <section class="know-articles">
                <h2 class="know__title">Каталог статей</h2>
                    <ul class="know__catalog-wrapp">
                        <?php foreach ($category as $k => $v): ?>
                            <li class="know__catalog-item">
                                <div class="know__catalog-item-back-1"></div>
                                <h3 class="know__catalog-title">
                                    <a href="<?= Url::to(['knowledgecat', 'link' => $v['link']]) ?>"
                                       class="know__catalog-link">
                                        <?= $v['name'] ?>
                                    </a>
                                </h3>
                                <ul class="know__catalog-list">
                                    <?php foreach ($subcategory as $key => $value): ?>
                                        <?php if ($value['category_id'] == $v['id']): ?>
                                            <li class="know__catalog-li">
                                                <a href="<?= Url::to(['knowledgearticle', 'link' => $value['link']]) ?>"
                                                   class="know__catalog-a">
                                                    <?php include('article-knowledge.php') ?>
                                                    <span><?= $value['name'] ?></span>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php endforeach; ?>
                    </ul>
            </section>
        </div>
    </div>

    <div class="popup popup--ok know__popup">
        <div class="popup__ov">
            <div class="popup__body popup__body--ok know__popup-bb">
                <div class="popup__content popup__content--ok">
                    <p class="popup__text" 
                    style="
                        font-weight: 400;
                        font-size: 24px;
                        line-height: 140%;
                        color: #2B3048;
                    " >Купите технологию «Сохранение имущества» и получите доступ к эксклюзивным документам</p>
                    <a href="<?= Url::to(['/femida/client/technology/8']) ?>" class="popup__btn-ok btn" style="
                        font-weight: 400;
                        font-size: 16px;
                        line-height: 20px;
                        color: #FFFFFF;
                        background: #4B49A2;
                        border-radius: 8px;
                        padding: 10px 20px;
                    ">Перейти к технологии</a>
                    <button class="popup__btn-close btn">Отмена</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
</section>