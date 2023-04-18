<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\helpers\UrlHelper;

$this->title = $article['name'];
$regions = json_decode($article['regions']);
$advantage = json_decode($article['advantages']);
$number = count($regions);
$this->registerJsFile(Url::to(['/js/leads-range.js']), ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/css/lead.css');

$css =<<< CSS
    .header {
        background: #000E1A;
        border-bottom: none;
    }

    .header__active {
        animation-name: none;
    }
CSS;

$js = <<<JS
const ul = document.querySelectorAll('.main__desc__popup__p3 ul');
const ulLi = document.querySelectorAll('.main__desc__popup__p3 ul li');
const ol = document.querySelectorAll('.main__desc__popup__p3 ol');
const olLi = document.querySelectorAll(`.main__desc__popup__p3 ol li`);


let addClickBtn = function  (selector, liSelector) {
    const ul = selector;
    const li = liSelector;
    let btn = document.createElement("a");
    let btnCLick;
    
    for (let i = 4; i < li.length; i++) {
          li[i].style.display = "none";
    }
    
    
    ul.forEach(i => {
        btn.classList.add('leads__btn_li');
        btn.textContent = "Еще";
        i.append(btn);
        btnCLick = document.querySelectorAll(".leads__btn_li");
    
});

    for (let i = 0; i < btnCLick.length; i++) {
        btnCLick[i].addEventListener('click', function () {
              for (let i = 4; i < li.length; i++) {
                li[i].style.display = "block";
                 }
              
              this.style.display = 'none';
        })
    }
}

    if (window.innerWidth <= 760) {
        addClickBtn(ul, ulLi);
    }
    

JS;

$this->registerCss($css);
$this->registerJS($js);
?>
?>

<section style="min-height: calc(100vh - 480px)" class="section__lead">
    <div class="container">
        <div class="flexed__main">
            <div class="main__desc__popup">
                <nav class="breadcrumbs">
                    <a href="<?= Url::to(['/']) ?>">Главная</a>
                    <img src="<?= Url::to(['/img/mainimg/breadcrumbs.svg']) ?>" alt="разделитель">
                    <a href="<?= Url::to(['/lead']) ?>">Лиды для юристов</a>
                    <img src="<?= Url::to(['/img/mainimg/breadcrumbs.svg']) ?>" alt="разделитель">
                    <a><?= $article['name'] ?></a>
                </nav>
                <h1 class="main__desc__popup__p2"><?= $article['name'] ?></h1>


                <div class="flexed__inner">
                    <div class="line__for__block">
                        <?php foreach ($advantage as $k => $v) : ?>
                        <div class="line__arrow__popup">
                            <img src="<?= Url::to(['/img/check-lead.svg']) ?>" alt="check">
                            <p class="advantage__pop__p"><?= $v ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="gray__pop__desc__fone">
                        <div class="lead-main__price">
                            <p><span>Цена лида</span></p>
                            <p>От <span class="price__pop__p"><?= $article['price'] ?> рублей</span> за принятый лид</p>
                        </div>
                        <div class="lead-main__region">
                            <?php if ($number == 1) : ?>
                            <p><span>Регион поставки</span></p>
                            <?php else : ?>
                            <p><span>Регионы</span></p>
                            <?php endif; ?>
                            <?php foreach ($regions as $key => $item) : ?>
                            <span class="regions__pop__p"><?= $item ?></span>
                            <?php endforeach; ?>
                        </div>

                        <div class="Index__btn__group">
                            <button class="lead__btn showsCard" data-form-name="<?= $article['name'] ?>">Купить лиды</button>
                        </div>
                    </div>
                </div>
                <div class="main__desc__popup__p3"><?= $article['description'] ?></div>


            </div>

        </div>
</section>
<section class="lead-baner-two">
    <div class="container">
        <div class="lead-baner-two__wrap">
            <div class="By__Leads__Sec5__content-Ddttl">
                <form id="Sec5-form" action="/lead" method="post">
                    <input type="hidden" name="_csrf-core"
                        value="M41AG9-sbelKUcx8ZCclAR27bAL2Z15gSN66kz40t5p9zwQtsZ8nmSEGq01JZH1RdNwqN84WKDERl43lWFzF1w==">
                    <input type="hidden" name="URL" value="myforce/lead">
                    <input type="hidden" name="formType" value="">
                    <input type="hidden" name="pipeline" value="104">
                    <input type="hidden" name="utm_source" value="">
                    <input type="hidden" name="utm_campaign" value="">
                    <input type="hidden" name="service" value="">
                    <input type="hidden" name="section" value="Описание работы">
                    <div class="Sec5-step1">
                        <p class="BLS5CDText-1">Вы платите за целевые лиды</p>
                        <p class="BLS5CDText-2">
                            В&nbsp;отличие от&nbsp;предложений на&nbsp;рынке, берём комиссию только за&nbsp;качественные
                            целевые лиды:
                            мы&nbsp;обсуждаем с&nbsp;вами критерии и&nbsp;фиксируем их&nbsp;до&nbsp;начала работы,
                            а&nbsp;не&nbsp;постфактум, когда бюджет
                            потрачен
                        </p>
                        <div class="Sec5-inputs">
                            <input class="Sec5-input fcstlt" type="text" name="fio" placeholder="Имя" required="">
                            <input class="Sec5-input fcstlt" type="tel" name="phone" placeholder="Телефон" required="">
                        </div>
                        <button type="sabmit" class="btn-1">Подробнее</button>
                    </div>
                    <div class="Sec5-step2">
                        <p class="BLS5CDText-1">Благодарим за заявку!</p>
                        <p class="BLS5CDText-2">
                            Наш менеждер проконсультирует вас в ближайшее время
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="By__Leads__Sec9">
    <div class="container">
        <div class="By__Leads__Sec9__content">
            <h3 class="TL_h8v">Рассчитайте свою прибыль и закажите лиды прямо сейчас!</h3>
            <div class="TL_inp8">
                <div class="TL_inp8-content">
                    <div class="TL_inputtext flex aic fww">
                        <p class="TL_p8">Количество лидов</p>
                        <input class="TL_input_text tac number1" type="number" min="100" max="1000" step="100"
                            value="500" id="text">
                    </div>
                    <div class="Tl__wrapp">
                        <input class="TL_input_range" type="range" min="0" max="1000" value="500" step="100"
                            id="slider">
                        <span></span>
                    </div>

                    <div class="TL_p88 flex aic fww">
                        <div class="lite__fix">
                            <p class="TL_p8">Средний процент конверсии</p>
                            <h4 class="TL_h8 TL_h8w number1">9,5%</h4>
                        </div>

                        <div class="lite__fix">
                            <p class="TL_p8">Средняя стоимость лида</p>
                            <h4 class="TL_h8 TL_h8w">500 рублей</h4>
                        </div>
                    </div>
                    <div class="TL_inp9 flex fww">
                        <h4 class="TL_h8 TL_h8 total">Ваша прибыль</h4>
                        <input class="TL_inp9inp tac" type="text" id="result" disabled="">
                    </div>
                </div>
                <div class="Tl9__wrapp">
                    <div class="TL_inp8-form">
                        <p class="TL_inp8-form-title">
                            Закажите лиды прямой сейчас!
                        </p>
                        <div class="TL_inp8-form-inner">
                            <form id="form-TL_inp8" action="/site/form" method="post">
                                <input type="hidden" name="_csrf-core"
                                    value="MfjTE3WtVoY4K0CAtgc6C89s-2wx5veTH--UgML6N1J_upclG54c9lN8J7GbRGJbpgu9WQmXgcJGpqP2pJJFHw==">
                                <input type="hidden" name="URL" value="myforce/lead/traffic-quality">
                                <input type="hidden" name="formType" value="Форма для получения 10 бесплатных лидов">
                                <input type="hidden" name="pipeline" value="104">
                                <input type="hidden" name="service" value="">
                                <input type="hidden" name="section"
                                    value="Рассчитайте свою прибыль и закажите лиды прямо сейчас!">
                                <input type="hidden" name="utm_source" value="">
                                <input type="hidden" name="utm_campaign" value="">

                                <input class="TL_inp8-input" required="" placeholder="Сфера бизнеса" type="text"
                                    name="comments[sphere]" id="sphere2">
                                <input type="text" required="required" class="TL_inp8-input region"
                                    placeholder="Ваш регион" name="region" id="region2">
                                <input class="TL_inp8-input" required="" pattern="[0-9]*"
                                    placeholder="Количество лидов в день" type="text" name="comments[lead_day]"
                                    id="lids2">
                                <a href="/registr?site=lead" class="btnsbmtfc">Получить</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>