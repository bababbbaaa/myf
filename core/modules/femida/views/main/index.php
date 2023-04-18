<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\helpers\UrlHelper;


$this->title = 'Франшиза готовый бизнес с нуля';

$json = json_encode($regions, JSON_UNESCAPED_UNICODE);
$this->registerJsFile("@web/js/mainjs/jquery-3.5.1.min.js");
$this->registerCssFile("@web/css/femida.css");
$this->registerJsFile("@web/js/femida.js");
$this->registerCssFile("@web/css/adaptivefemida.css");
$js = <<<JS

var obj = {$json};
    $('.hovpas').on('click', function() {
        var region = $(this).attr('data-region');
        if($('.hovpas').hasClass('hovpasChecked')){
            $('.hovpas').removeClass('hovpasChecked');
            $(this).addClass('hovpasChecked');
        }else {
            $('.hovpas').removeClass('hovpasChecked');
            $(this).addClass('hovpasChecked');
        }
        $('.popup1').fadeIn(300);
        $('.addressPart').html('');
        for(var i=0; i<obj[region].length; i++){
            $('.addressPart').append('<div class="partners"><span class="nameFirm">'+ obj[region][i].partner_name +' </span><span class="cityFirm">'+ obj[region][i].city +' </span><span class="stritFirm">'+ obj[region][i].address +' </span></div>');
    }
    
});
$('.Nf').on('click', function() {
  $('.filt__form').submit();
});
$('select[name="filters[price]"]').on('input', function() {
    $('.filt__form').submit();
});
$('.filt__form').on('submit', function(e) {
  e.preventDefault();
  
   $.pjax.reload({
      container: '#Pjax_femida',
      url: "femida",
      type: "GET",
      data: $('.filt__form').serialize(),
    });
});

 $('.finMod').on('submit', function (e) {
        $.ajax({
            url: "/site/form",
            type: "POST",
            data: $(".finMod").serialize(),
            beforeSend: function () {
                $('.steps1').fadeOut(300, function () {
                    $('.steps2').fadeIn(300);
                });
            },
        }).done(function () {
        });
        e.preventDefault();
});

$(window).on('click', function(e) {
    if (e.target.className !== 'Nf' && e.target.className !== 'active__button--filter activeNf' && e.target.className !== 'active__button--filter' && e.target.className !== 'filterRadio'){
        $('.change__folter__main').hide(200);
        $('.active__button--filter').removeClass('activeNf');
    }
});

JS;
$this->registerJs($js);
?>
<main class="main">
    <section class="promo femida__promo">
        <div class="container">
            <h1 class="promo__title">Франшиза FEMIDA.FORCE - готовый бизнес с нуля</h1>
            <div class="pow flexAdaptives">
                <button class="promo__cta showsCard" data-form-name="Франшиза FEMIDA.FORCE - готовый бизнес с нуля">Выбрать франшизу</button>
            </div>
        </div>
    </section>
    <section class="cards">
        <div class="container">
            <div class="pow">
                <div class="cardimg">
                    <img src="<?= Url::to(['/img/vector3.svg']) ?>" alt="icon phone">
                    <p>Успешный бизнес
                        от 145 тыс.рублей</p>
                </div>
                <div class="cardimg">
                    <img src="<?= Url::to(['/img/vector2.svg']) ?>" alt="icon display">
                    <p>Клиенты, готовые оплатить в день открытия</p>
                </div>
                <div class="cardimg">
                    <img src="<?= Url::to(['/img/vector1.svg']) ?>" alt="icon people">
                    <p>Технологии бизнеса созданные на опыте с 2015 года
                    </p>
                </div>
                <div class="cardimg">
                    <img src="<?= Url::to(['/img/vector.svg']) ?>" alt="icon calendar">
                    <p>Первый доход
                        через месяц</p>
                </div>
            </div>
        </div>
    </section>
    <section class="about">
        <div class="container">
            <div class="about__wrapper femida__wrapper">
                <div class="about__text">
                    <h3 class="about__title">о Femida.force</h3>
                    <p>Прибыльный и антикризисный бизнес в любой точке России.
                        Запустили <b>более 150 офисов партнёров</b>, которые работают по нашим технологиям и с нашей
                        поддержкой
                        24/7.</p>
                    <p>Мы учим помогать людям изменить их жизнь к лучшему и решить их финансовые проблемы.</p>
                    <p><span>FEMIDA.FORCE</span> — это стабильный и гарантированно окупаемый бизнес в России по оказанию
                        финансовых
                        и юридических услуг</p>

                </div>
                <img src="<?= Url::to(['/img/femida-about.svg']) ?>" alt="illustration">
            </div>
    </section>
    <section class="project-mission femida">
        <div class="container">
            <p>Миссия проекта</p>
            <h2>Доказать, что любой бизнес может работать прибыльно. </h2>
        </div>
    </section>
    <section class="franchise">
        <div class="container">

            <h2 class="franchise__title">Выберите франшизу, подходящую именно вам</h2>

            <div class="type-franchise">
                <div class="franchise-header">
                    <div class="empty"></div>
                    <div class="heading">Партнер</div>
                    <div class="heading">Представитель</div>
                    <div class="heading">Региональный офис</div>
                </div>
                <div class="content">
                    <div class="content-wrap">
                        <div class="accordion franchise-accordion active">
                            <div>
                                <p>Технология бизнеса</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="9" viewBox="0 0 18 9"
                                    fill="none">
                                    <path
                                        d="M16.9201 8.1744L10.4001 1.6544C9.63008 0.884404 8.37008 0.884404 7.60008 1.6544L1.08008 8.1744"
                                        stroke="#000E1A" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span></span><span></span><span></span>
                        </div>
                        <div class="accordion-content franchise-accordion-content">
                            <div class="franchise-row">
                                <p>Документы для исполнения услуг</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Скрипты продаж</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Регламенты отдела продаж</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="content-wrap">
                        <div class="accordion franchise-accordion active">
                            <div>
                                <p>Обучение</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="9" viewBox="0 0 18 9"
                                    fill="none">
                                    <path
                                        d="M16.9201 8.1744L10.4001 1.6544C9.63008 0.884404 8.37008 0.884404 7.60008 1.6544L1.08008 8.1744"
                                        stroke="#000E1A" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span></span><span></span><span></span>
                        </div>
                        <div class="accordion-content franchise-accordion-content">
                            <div class="franchise-row">
                                <p>Технология банкротного бизнеса (курс)</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>МПК</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>МПП</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>МКС</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Оптимизация (фин защита)</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>РОП</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Сохранение имущества</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Внесудебное банкротство</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Аттестация руководителя</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Аттестация персонала</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="content-wrap">
                        <div class="accordion franchise-accordion active">
                            <div>
                                <p>Реклама и лиды</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="9" viewBox="0 0 18 9"
                                    fill="none">
                                    <path
                                        d="M16.9201 8.1744L10.4001 1.6544C9.63008 0.884404 8.37008 0.884404 7.60008 1.6544L1.08008 8.1744"
                                        stroke="#000E1A" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span></span><span></span><span></span>
                        </div>
                        <div class="accordion-content franchise-accordion-content">
                            <div class="franchise-row">
                                <p>Сайт представительства в регионе</p>
                                <span>
                                    Landing page
                                </span>
                                <span>
                                    Корпоративный сайт
                                </span>
                                <span>
                                    Корпоративный сайт с ЛК и блогом
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Рекламная компания в регионе</p>
                                <span>
                                    Яндекс.Директ
                                </span>
                                <span>
                                    Яндекс.Директ+ ВК
                                </span>
                                <span>
                                    Яндекс.Директ+ ВК
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Федеральная реклама</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    Не более 20-30 лидов
                                </span>
                                <span>
                                    Неограничена
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Публикация в каталоге партнеров</p>
                                <span>
                                    Простое размещение
                                </span>
                                <span>
                                    Простое размещение
                                </span>
                                <span>
                                    VIP - размещение
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Лиды по партнерским ценам</p>
                                <span>
                                    Скидка 15%
                                </span>
                                <span>
                                    Скидка 20%
                                </span>
                                <span>
                                    Скидка 25%
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="content-wrap">
                        <div class="accordion franchise-accordion active">
                            <div>
                                <p>Подбор персонала</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="9" viewBox="0 0 18 9"
                                    fill="none">
                                    <path
                                        d="M16.9201 8.1744L10.4001 1.6544C9.63008 0.884404 8.37008 0.884404 7.60008 1.6544L1.08008 8.1744"
                                        stroke="#000E1A" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span></span><span></span><span></span>
                        </div>
                        <div class="accordion-content franchise-accordion-content">

                            <div class="franchise-row">
                                <p>Поиск мпк/мпп/мкс</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Поиск юристов</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Поиск РОП</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="content-wrap">
                        <div class="accordion franchise-accordion active">
                            <div>
                                <p>Сопровождение</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="9" viewBox="0 0 18 9"
                                     fill="none">
                                    <path
                                        d="M16.9201 8.1744L10.4001 1.6544C9.63008 0.884404 8.37008 0.884404 7.60008 1.6544L1.08008 8.1744"
                                        stroke="#000E1A" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span></span><span></span><span></span>
                        </div>
                        <div class="accordion-content franchise-accordion-content">

                            <div class="franchise-row">
                                <p>Юридическое сопровождение</p>
                                <span>
                                    до 50 консультаций
                                </span>
                                <span>
                                    до 150 консультаций
                                </span>
                                <span>
                                    без лимита
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Юридический аутсорсинг</p>
                                <span>
                                    12500 руб. / 1 дело БФЛ
                                </span>
                                <span>
                                    12500 руб. / 1 дело
                                </span>
                                <span>
                                   12500 руб. / 1 дело
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Консультации и ведение дел АУ</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                         fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                   <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                         fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Куратор в центральном офисе</p>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                         fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                   <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                         fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Временный РОП (30 дней)</p>
                                <span>
                                      <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                           fill="none">
                                        <path
                                            d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z"
                                            fill="#ED0F0F" />
                                        <path d="M11.8447 19.2798L19.1556 11.969" stroke="white" stroke-width="1.5"
                                              stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M19.1556 19.2798L11.8447 11.969" stroke="white" stroke-width="1.5"
                                              stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                   <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                        fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="31" height="32" viewBox="0 0 31 32"
                                         fill="none">
                                        <path
                                            d="M11.6247 28.5411H19.3747C25.833 28.5411 28.4163 25.9578 28.4163 19.4994V11.7494C28.4163 5.2911 25.833 2.70776 19.3747 2.70776H11.6247C5.16634 2.70776 2.58301 5.2911 2.58301 11.7494V19.4994C2.58301 25.9578 5.16634 28.5411 11.6247 28.5411Z"
                                            fill="#8663C5" />
                                        <path d="M10.0107 15.6244L13.6662 19.2798L20.9899 11.969" stroke="white"
                                              stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </span>
                            </div>

                        </div>
                    </div>

                    <div class="content-wrap">
                        <div class="accordion franchise-accordion active">
                            <div>
                                <p>Дист. технологии</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="9" viewBox="0 0 18 9"
                                     fill="none">
                                    <path
                                        d="M16.9201 8.1744L10.4001 1.6544C9.63008 0.884404 8.37008 0.884404 7.60008 1.6544L1.08008 8.1744"
                                        stroke="#000E1A" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span></span><span></span><span></span>
                        </div>
                        <div class="accordion-content franchise-accordion-content">

                            <div class="franchise-row">
                                <p>Технология продаж БФЛ в дист.</p>
                                <span>
                                    <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z" fill="#ED0F0F"/>
                                <path d="M11.8447 19.2801L19.1556 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19.1556 19.2801L11.8447 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                                </span>
                                <span>
                                    <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.6247 28.5413H19.3747C25.833 28.5413 28.4163 25.958 28.4163 19.4997V11.7497C28.4163 5.29134 25.833 2.70801 19.3747 2.70801H11.6247C5.16634 2.70801 2.58301 5.29134 2.58301 11.7497V19.4997C2.58301 25.958 5.16634 28.5413 11.6247 28.5413Z" fill="#8663C5"/>
            <path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" fill="#8663C5"/>
            <path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

                                </span>
                                <span>
                                    <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11.6247 28.5413H19.3747C25.833 28.5413 28.4163 25.958 28.4163 19.4997V11.7497C28.4163 5.29134 25.833 2.70801 19.3747 2.70801H11.6247C5.16634 2.70801 2.58301 5.29134 2.58301 11.7497V19.4997C2.58301 25.958 5.16634 28.5413 11.6247 28.5413Z" fill="#8663C5"/>
<path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" fill="#8663C5"/>
<path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>

                                </span>
                            </div>
                            <div class="franchise-row">
                                <p>Обучение персонала продажам в дист.</p>
                                <span>
                                        <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z" fill="#ED0F0F"/>
                                <path d="M11.8447 19.2801L19.1556 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19.1556 19.2801L11.8447 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                </span>
                                <span>
                                        <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z" fill="#ED0F0F"/>
                                <path d="M11.8447 19.2801L19.1556 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19.1556 19.2801L11.8447 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                </span>
                                <span>
                                        <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11.6247 28.5413H19.3747C25.833 28.5413 28.4163 25.958 28.4163 19.4997V11.7497C28.4163 5.29134 25.833 2.70801 19.3747 2.70801H11.6247C5.16634 2.70801 2.58301 5.29134 2.58301 11.7497V19.4997C2.58301 25.958 5.16634 28.5413 11.6247 28.5413Z" fill="#8663C5"/>
<path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" fill="#8663C5"/>
<path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                                </span>
                            </div>

                            <div class="franchise-row">
                                <p>Рекламные мощности для дист. БФЛ</p>
                                <span>
                                        <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z" fill="#ED0F0F"/>
                                <path d="M11.8447 19.2801L19.1556 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19.1556 19.2801L11.8447 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                </span>
                                <span>
                                        <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z" fill="#ED0F0F"/>
                                <path d="M11.8447 19.2801L19.1556 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19.1556 19.2801L11.8447 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                </span>
                                <span>
                                        <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M11.6247 28.5413H19.3747C25.833 28.5413 28.4163 25.958 28.4163 19.4997V11.7497C28.4163 5.29134 25.833 2.70801 19.3747 2.70801H11.6247C5.16634 2.70801 2.58301 5.29134 2.58301 11.7497V19.4997C2.58301 25.958 5.16634 28.5413 11.6247 28.5413Z" fill="#8663C5"/>
<path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" fill="#8663C5"/>
<path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                                </span>
                            </div>

                        </div>
                    </div>

                    <div class="content-wrap">
                        <div class="accordion franchise-accordion active">
                            <div>
                                <p>CRM</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="9" viewBox="0 0 18 9"
                                     fill="none">
                                    <path
                                        d="M16.9201 8.1744L10.4001 1.6544C9.63008 0.884404 8.37008 0.884404 7.60008 1.6544L1.08008 8.1744"
                                        stroke="#000E1A" stroke-width="1.5" stroke-miterlimit="10"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <span></span><span></span><span></span>
                        </div>
                        <div class="accordion-content franchise-accordion-content">

                            <div class="franchise-row">
                                <p>Малый офис</p>
                                <span>
                                    <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.6247 28.5413H19.3747C25.833 28.5413 28.4163 25.958 28.4163 19.4997V11.7497C28.4163 5.29134 25.833 2.70801 19.3747 2.70801H11.6247C5.16634 2.70801 2.58301 5.29134 2.58301 11.7497V19.4997C2.58301 25.958 5.16634 28.5413 11.6247 28.5413Z" fill="#8663C5"/>
            <path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" fill="#8663C5"/>
            <path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

                                </span>
                                <span>
                                    <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z" fill="#ED0F0F"/>
                                <path d="M11.8447 19.2801L19.1556 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19.1556 19.2801L11.8447 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                                </span>

                                <span>
                                  <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z" fill="#ED0F0F"/>
                                <path d="M11.8447 19.2801L19.1556 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19.1556 19.2801L11.8447 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                </span>
                            </div>

                            <div class="franchise-row">
                                <p>Крупный офис</p>
                                <span>
                                  <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z" fill="#ED0F0F"/>
                                <path d="M11.8447 19.2801L19.1556 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19.1556 19.2801L11.8447 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                </span>
                                <span>
                                    <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.6247 28.5413H19.3747C25.833 28.5413 28.4163 25.958 28.4163 19.4997V11.7497C28.4163 5.29134 25.833 2.70801 19.3747 2.70801H11.6247C5.16634 2.70801 2.58301 5.29134 2.58301 11.7497V19.4997C2.58301 25.958 5.16634 28.5413 11.6247 28.5413Z" fill="#8663C5"/>
            <path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" fill="#8663C5"/>
            <path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

                                </span>
                                <span>
                                    <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z" fill="#ED0F0F"/>
                                <path d="M11.8447 19.2801L19.1556 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19.1556 19.2801L11.8447 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                                </span>


                            </div>

                            <div class="franchise-row">
                                <p>Федеральный офис</p>
                                <span>
                                  <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z" fill="#ED0F0F"/>
                                <path d="M11.8447 19.2801L19.1556 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19.1556 19.2801L11.8447 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                </span>

                                <span>
                                    <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.6252 28.5411H19.3752C25.8335 28.5411 28.4168 25.9578 28.4168 19.4994V11.7494C28.4168 5.2911 25.8335 2.70776 19.3752 2.70776H11.6252C5.16683 2.70776 2.5835 5.2911 2.5835 11.7494V19.4994C2.5835 25.9578 5.16683 28.5411 11.6252 28.5411Z" fill="#ED0F0F"/>
                                <path d="M11.8447 19.2801L19.1556 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M19.1556 19.2801L11.8447 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>

                                </span>
                                <span>
                                    <svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11.6247 28.5413H19.3747C25.833 28.5413 28.4163 25.958 28.4163 19.4997V11.7497C28.4163 5.29134 25.833 2.70801 19.3747 2.70801H11.6247C5.16634 2.70801 2.58301 5.29134 2.58301 11.7497V19.4997C2.58301 25.958 5.16634 28.5413 11.6247 28.5413Z" fill="#8663C5"/>
            <path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" fill="#8663C5"/>
            <path d="M10.0107 15.6247L13.6662 19.2801L20.9899 11.9692" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>

                                </span>


                            </div>




                        </div>
                    </div>


                    <div class="content-wrap">
                        <div class="accordion franchise-accordion franchise-accordion__day">
                            <div>
                                <p>ЗАПУСК ОФИСА:</p>
                            </div>
                            <span>
                                15-25 дней
                            </span>
                            <span>
                                30-40 дней
                            </span>
                            <span>
                                30-60 дней
                            </span>
                        </div>
                        <div class="accordion-content franchise-accordion-content">
                        </div>
                    </div>
                    <div class="content-wrap">
                        <div class="accordion franchise-accordion franchise-accordion__cost">
                            <div>
                                <p>СТОИМОСТЬ, РУБ.:</p>
                            </div>
                            <span>145.000</span><span>285.000</span><span>475.000</span>
                        </div>
                        <div class="accordion-content franchise-accordion-content">
                        </div>
                    </div>
                </div>
                <div class="franchise-footer">
                    <div class="empty"></div>
                    <div class="franchise-footer__wrap">
                        <button class="baner-femida__btn showsCard" data-form-name="Франшиза: Партнер">
                            <span>Выбрать</span>
                        </button>
                    </div>
                    <div class="franchise-footer__wrap">
                        <button class="baner-femida__btn showsCard" data-form-name="Франшиза: Представитель">
                            <span>Выбрать</span>
                        </button>
                    </div>
                    <div class="franchise-footer__wrap">
                        <button class="baner-femida__btn showsCard" data-form-name="Франшиза: Региональный офис">
                            <span>Выбрать</span>
                        </button>
                    </div>
                </div>
            </div>
    </section>
    <section class="baner-femida femida">
        <div class="container">
            <div class="baner-femida__content">
                <h2 class="baner-femida__title">
                    Клиенты уже почти у вас!
                </h2>
                <p class="baner-femida__text">
                    После запуска работы мы начинаем активное привлечение целевых клиентов ваш бизнес
                </p>
                <button class="baner-femida__btn showsCard" data-form-name="Клиенты уже почти у вас!">
                    <span>Узнать подробнее</span>
                </button>
            </div>
        </div>
    </section>
    <section class="work-femida">
        <div class="container">
            <h2 class="work-femida__title">Принципы работы FEMIDA.FORCE</h2>
            <div class="work-femida__cards">
                <div class="work-femida__card">

                    <img src="<?= Url::to(['/img/work-femida1.svg']) ?>" alt="1">
                    <p>Помогаем с подбором офиса, набором штата, регистрацией ИП/ООО.</p>
                </div>
                <div class="work-femida__card">
                    <img src="<?= Url::to(['/img/work-femida2.svg']) ?>" alt="2">
                    <p>Проводим обучение персонала и владельца бизнеса</p>
                </div>
                <div class="work-femida__card">
                    <img src="<?= Url::to(['/img/work-femida3.svg']) ?>" alt="3">
                    <p>Передаём готовых на покупку клиентов, помогаем заключать сделки</p>
                </div>
                <div class="work-femida__card">
                    <img src="<?= Url::to(['/img/work-femida4.svg']) ?>" alt="4">
                    <p>Сопровождаем офис, контролируем отдел продаж, сводим отчеты вместе</p>
                </div>
            </div>
        </div>

    </section>
    <section class="GlSec5 closedsPops">
        <div class="container closedsPops">
            <a id="Maps"></a>
            <h5>Карта охвата</h5>
            <p class="p1">Офисы партнеров по всей стране</p>
            <?php require_once('maps.php'); ?>
        </div>
    </section>
    <section class="baner-femida femida2">
        <div class="container">
            <div class="baner-femida__content">
                <h2 class="baner-femida__title">
                    Как выбрать франшизу?
                </h2>
                <p class="baner-femida__text">
                    Оставьте заявку и получите:
                </p>
                <ul class="baner-femida__list">
                    <li>
                        <p>Анализ Вашего региона на возможность открытия офиса</p>
                    </li>
                    <li>
                        <p>Ответы на любые вопросы</p>
                    </li>
                    <li>
                        <p>Персональный подбор франшизы</p>
                    </li>
                    <li>
                        <p>Готовую бизнес-модель для быстрого старта</p>
                    </li>
                </ul>
                <button class="baner-femida__btn showsCard" data-form-name="Как выбрать франшизу?">
                    <span>Подобрать франшизу</span>
                </button>
            </div>
        </div>
    </section>
</main>