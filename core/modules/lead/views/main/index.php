<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\helpers\UrlHelper;

$regions = \common\models\DbRegion::find()->asArray()->select(['name_with_type'])->orderBy('name_with_type asc')->all();

// Example PHP array
$arr = json_encode($niche, JSON_UNESCAPED_UNICODE);

$js = <<<JS
      let arrTags;
      var step = 1,
        time;
$(".chosen-select").chosen({disable_search_threshold: 0});


    $('.next_quiz-btn').on("click", function() {
      if( arrTags != undefined && step == 1){
          $('.step1').fadeOut(300, function() {
            $('.step2').fadeIn(300);
            step++;
          });
      } else if(step == 2 && $('input[name="region"]').val() !== ''){
          $('.step2').fadeOut(300, function() {
            $('.step3').fadeIn(300);
            step++;
          });
      } else if(step == 3 && $('input[name="comments[lead_day]"]').is(":checked")){
          $('.step3').fadeOut(300, function() {
            $('.step4').fadeIn(300);
            step++;
          });
        }
      });
      
    $('.send__code').on('mouseup', function() {
        var timeoutSms = null;
        timeoutClick = null;
        $('.send__code').on('click', function () {
          var fio = $('.fio__register').val(),
            tel = $('.phone__register').val(),
            _Seconds = 60,
            timer,
            pass = false;
          if (timeoutClick === null) {
            timeoutClick = setTimeout(function () {
              $.ajax({
                url: '/site/check-phone-exist',
                type: 'POST',
                data: { phone: tel },
                dataType: 'JSON'
              }).done(function (rsp) {
                console.log(rsp);
                if (rsp.exist) {
                  pass = false;
                  $('.BuyLeads__error').text('Пользователь с таким номером уже существует.').fadeIn(300);
                } else {
                  $('.BuyLeads__error').text(rsp.message).fadeIn(300);
                  pass = true;
                }
                timeoutClick = null;
                if (pass) {
              _Seconds = 60;
                  $('.numertimerinsendcode2').text(_Seconds);
                  $('.linkonbackstap').hide();
                  clearInterval(timer);
                  $('.sendcodeagainnow').fadeOut(100, function () {
                    $('.sendcodeagain').fadeIn(100);
                  });
                  if (fio.length > 2 && tel !== '') {
                    $('.number__inner').text(tel);
                    $('.BuyLeads__error').fadeOut(1);
                    $('.step4').fadeOut(300, function () {
                      $('.step7').fadeIn(300);
                    });
                    timer = setInterval(function () {
                      if (_Seconds > 0) {
                        $('.numertimerinsendcode2').text(--_Seconds);
                      } else {
                        $('.codereset').fadeOut(100, function () {
                          $('.sendcodeagainnow2').fadeIn(100);
                          $('.linkonbackstap').show();
                        });
                        clearInterval(timer);
                      }
                    }, 1000);
        
                    if (timeoutSms === null) {
                      $.ajax({
                        url: '/site/sms-send',
                        type: 'POST',
                        data: { phone: tel },
                        dataType: 'JSON'
        
                      }).done(function (response) {
                        $('.registr__error').fadeOut(1);
                        console.log(response);
                      });
                    }
                    timeoutSms = setTimeout(function () {
                      timeoutSms = null;
                    }, 60000);
                  }
                }
              });
            }, 1000);
          }
        });
    });
    
    $('.sendcodeagainnow2').on('click', function() {
        var tel = $('.phone__register').val(),
                _Seconds = 60,
                timer;
      $.ajax({
        url: '/site/sms-send',
        type: 'POST',
        data: { phone: tel },
        dataType: 'JSON'
      }).done(function() {
          $('.numertimerinsendcode2').text(_Seconds);
          $('.linkonbackstap').hide();
          clearInterval(timer);
          $('.sendcodeagainnow2').fadeOut(100, function () {
            $('.codereset').fadeIn(100);
          });
              timer = setInterval(function () {
              if (_Seconds > 0) {
                $('.numertimerinsendcode2').text(--_Seconds);
              } else {
                $('.codereset').fadeOut(100, function () {
                  $('.sendcodeagainnow2').fadeIn(100);
                  $('.linkonbackstap').show();
                });
                clearInterval(timer);
              }
                }, 1000);
      });
    });

    $('.code__confirmed').on('click', function () {
      var code = $('.code__input').val(),
        errorBlock = $('.BuyLeads__error');
      if (code.length > 1) {
        $.ajax({
          url: '/site/code-confirm',
          type: 'POST',
          data: { code: code },
          dataType: 'JSON'
        }).done(function (response) {
          if (response.status === 'success') {
            var fio = $('.fio__register').val(),
                tel = $('.phone__register').val();
            errorBlock.hide();
            $.ajax({
              url: '/site/confirm-signup',
              type: 'POST',
              data: { phone: tel, fio: fio, code: code },
              dataType: 'JSON'
            }).done(function (rsp) {
              if (rsp.status === 'error') {
                $('.BuyLeads__error').text(rsp.message);
                errorBlock.show();
              } else
                errorBlock.hide();
            });
          } else {
            $('.BuyLeads__error').text(response.message);
            errorBlock.show();
          }
        });
      }
    });
    
    $('.form__info-link').on('click', function() {
        $('.step7').fadeOut(300, function () {
                $('.step4').fadeIn(300);
                _Seconds = 59;
                clearInterval(time);
            });
    });
       
     $('.filters__btn--select').on('click', function() {
         $(this).next().slideToggle();
     });
       
     $(window).on('click', function (e) {
        if (e.target.nodeName !== "LABEL" && e.target.nodeName !== "INPUT" && e.target.nodeName !== "BUTTON" && e.target.nodeName !== "A") {
            $(".filters__list").removeClass("filters__list--visable");
            if($('.filters__input').not(':checked')){
                $('.filters__btn--select').next().slideUp();
            }
        }
    });
     
     
     $('.filters__label').on('click', function() {
       var name = $(this).attr('data-name');
       $('.inner__text').text(name);
     });


    
     $('select').styler({
        selectPlaceholder: "Ваш регион",
    });

$('#Sec5-form').on('submit', function(e) {
    var form = this;
    e.preventDefault();
    $.ajax({
        url: "/site/form",
        method: "POST",
        dataType: 'JSON',
        data: $("#Sec5-form").serialize(),
        beforeSend: function () {
            form.reset();
            $(".Sec5-step1").fadeOut(300, function () {
              $(".Sec5-step2").fadeIn(300);
            });
        }
    });
});

$('#form-code').on('submit', function(e) {
    var form = this;
    e.preventDefault();
    $.ajax({
        url: "/site/form",
        method: "POST",
        dataType: 'JSON',
        data: $("#form-code").serialize(),
        beforeSend: function () {
            form.reset();
            $('.By__Leads__popap__consult__contant').fadeOut(1, function() {
                $('.By__Leads__popap__consult__contant-2').fadeIn(1)
            });
            $('.By__Leads__Background__Popap, .By__Leads__popap__consult__contant-margin').fadeIn(300)
        }
    });
});


    
    let filter__form_desctop = $('.filter__form.desctop');
    let filter__form2_desctop = $('.filter__form2.desctop');
    let filter__form_mobile = $('.filter__form.mobile');
    let filter__form2_mobile = $('.filter__form2.mobile');
    
    function getFinalFilterUrlDesctop(){
        let final_url_form = 'lead?';
        let url = filter__form_desctop.serialize() + '&' +filter__form2_desctop.serialize();
        
         if(url == '&'){
            final_url_form = '/lead?';
        }
         
         
        final_url_form += url;
      
        $('#link_reload').attr("href",final_url_form).trigger("click");
        
        
    }
        function getFinalFilterUrlMobile(){
        let final_url_form = 'lead?';
        let url = filter__form_mobile.serialize() + '&' + filter__form2_mobile.serialize();
        
         if(url == '&'){
            final_url_form += '/lead?';
        }
         
         
        final_url_form += url;
      
        $('#link_reload').attr("href",final_url_form).trigger("click");
        
        
    }
    // filter%5Bnew%5D=new&filter%5Bprice%5D=500&filter%5Bnew%5D=new&filter%5Bprice%5D=500
    // 

  /*setTimeout(function() {
        $('#link_reload').attr("href","lead?").trigger("click");
    },100);*/
  
    filter__form2_desctop.on('change', function(e) {
        e.preventDefault();
        getFinalFilterUrlDesctop();
        //$('#link_reload').attr("href","lead?" + $(this).serialize()).trigger("click");
        
    });

    filter__form_desctop.on('change', function(e) {
        //$('#link_reload').attr("href","lead?" + $(this).serialize()).trigger("click");
        e.preventDefault();
        getFinalFilterUrlDesctop();
    });
    
        filter__form2_mobile.on('change', function(e) {
        e.preventDefault();
       getFinalFilterUrlMobile();
        //$('#link_reload').attr("href","lead?" + $(this).serialize()).trigger("click");
        
    });

    filter__form_mobile.on('change', function(e) {
        //$('#link_reload').attr("href","lead?" + $(this).serialize()).trigger("click");
        e.preventDefault();
        getFinalFilterUrlMobile();
    });

    $('.reload__filter').on('click', function(e) {
        $('#link_reload').attr("href","lead?").trigger("click");
        $('.top_filter').removeClass('active');
        $('.left_filter').removeClass('active');
        e.preventDefault();
    });
    

    $('.filters').on('mouseup', '.top_filter', function() {
        var t = $(this);
        setTimeout(function() {
        if (t.hasClass('active')){
            t.removeClass('active');
        } else {
            t.addClass('active');
        }
        //$('.filter__form2').submit();
        }, 300);
    });
    $('.filters').on('mouseup', '.left_filter', function() {
        var t = $(this);
        setTimeout(function() {
        if (t.hasClass('active')){
            t.removeClass('active');
        } else {
            t.addClass('active');
        }
        //$('.filter__form').submit();
        }, 300);
    });
    
    
        let  swiper = new Swiper(".slider_mobile", {
       slidesPerView: 1,
       spaceBetween: 40,
        centeredSlides: true,
      pagination: {
        el: ".slider_mobile__pag",
        clickable: true,
      },
    });

    const modalCat = document.querySelectorAll(".modal-filter__btn button");
    const modalList = document.querySelector(".modal-filter__list");
    const modalForm = document.querySelectorAll('.filter__form2');
    const modalClose = document.querySelector(".modal-filter__close");
    const modalFilter= document.querySelector(".modal-filter");
    const filterBlock= document.querySelector(".filter-block");

    modalCat.forEach((item, i) => {
        item.addEventListener('click', () => {
        if (i == 0) {
            modalCat[i].classList.toggle('modal-btn__active');
            modalList.classList.toggle('modal-filter__db');
        } else if (i == 1) {
            modalCat[i].classList.toggle('modal-btn__active');
            modalForm[1].classList.toggle('filter__form2__df');
        }
    });
    });

    filterBlock.addEventListener('click', () => {
        modalFilter.classList.add("modal-filter__active");
    });

    modalClose.addEventListener('click', () => {
        modalFilter.classList.remove("modal-filter__active");
    });
    
    /**
    * Получаем массив из PHP и выводим его через библиотеку Tagify
* @type {any}
*/
    let myArray = $arr;
    let tagifyArr = [];
    myArray.forEach((my) => {
        tagifyArr.push(my['name']);
    });
    

    
    /**
    * Поле ввода для Тегов
    * 
* @type {Element}
*/
let input = document.querySelector('#commentsLeads');
/*
let tagify = new Tagify(input, {
  whitelist: tagifyArr,
  delimiters: " ,",
  dropdown: {
    position: "manual",
    maxItems: Infinity,
    enabled: true,
    classname: "customSuggestionsList"
  },
  templates: {
    dropdownItemNoMatch() {
      return `<div class='tagify__dropdown__item'>Не найдено</div>`;
    }
  },
  enforceWhitelist: true
});

let isOpen = false; // флаг, который указывает, открыт ли список тегов в данный момент



tagify.on("dropdown:show", onSuggestionsListUpdate)
      .on("dropdown:hide", onSuggestionsListHide)
      .on('dropdown:scroll', onDropdownScroll);

function onSuggestionsListUpdate({ detail:suggestionsElm }){
  suggestionsElm;  
}

function onSuggestionsListHide(){
  isOpen = false; // обновляем флаг, чтобы указать, что список тегов был закрыт
}

function onDropdownScroll(e){
  e.detail;
}

function closeSuggestionsList() {
  tagify.dropdown.hide(); // закрыть список тегов, если он уже открыт
  isOpen = false;
}

tagify.on("change", function(e){
  let selectedTags = tagify.value.map(tag => tag.value);
  let tagsArr = selectedTags.join(', ');
  arrTags = tagsArr;
});

function renderSuggestionsList(){
  tagify.dropdown.show();
  tagify.DOM.scope.parentNode.appendChild(tagify.DOM.dropdown);
}

tagify.DOM.input.addEventListener('focus', renderSuggestionsList);*/




    
   /* let stepOne = document.querySelector('.step1');
    
    stepOne.style.display = 'flex';*/

/**
* Скролл с библиотекой Scrole Bar
*/
//     Array.prototype.forEach.call(
//   document.querySelectorAll('.scroll-bar'),
//   (el) => new SimpleBar(el)
// );

    

JS;

$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJsFile(Url::to(['/js/leadjs/getRegionAjax.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJsFile('https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js');
$this->registerJsFile('@web/js/tagify.min.js');
$this->registerJsFile('https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js');

$this->registerJs($js);

$this->title = 'LEAD.FORCE — место, где продают и покупают заявки от клиентов';
$this->registerCssFile("https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css");
$this->registerCssFile("https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css");;
$this->registerCssFile('@web/css/lead.css');
$this->registerCssFile('@web/css/adaptivlead.css');
$this->registerCssFile(Url::to(['@web/css/chosen.min.css']));
$this->registerCssFile('@web/css/maincss/tagify.css');
$this->registerCssFile('https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css');

$arr = [];
foreach ($region as $k => $v) {
    $json = json_decode($v['regions'], true);
    foreach ($json as $kk => $vv) {
        $arr[] = $vv;
    }
}
$arr = array_unique($arr);
$categoriFind = [];
if (!empty($category) && !empty($leadType)) {
    foreach ($category as $key => $item) {
        $categoriFind[$item['name']] = [];
        foreach ($leadType as $k => $i) {
            if ($i['category'] === $item['name']) {
                $categoriFind[$item['name']][] = $i;
            }
        }
    }
}
?>



<section class="lead__promo">
    <div class="container container__hr">
        <div class="lead__wrap ">
            <h1>LEAD.FORCE — место, где находят целевых клиентов</h1>
            <div class="Index__btn__group">
                <button class="lead__btn showsCard" data-form-name="LEAD.FORCE — место, где находят целевых клиентов">Купить заявки</button>
            </div>
        </div>
    </div>
</section>
<section class="lead-about">
    <div class="container">

        <div class="lead-about__wrap">
            <div class="lead-about__text">
                <h2>Что такое LEAD.FORCE?</h2>
                <p>
                    <span>LEAD.FORCE</span> — это крупнейшая на территории РФ торговая площадка, где вы можете найти
                    клиентов под любой запрос и на выгодных условиях. Покупая у нас, вы приобретаете только
                    преимущественно целевой трафик.
                </p>
                <p>
                    <span>LEAD.FORCE</span> является гарантом удобств и качества лидов, приобретённых в вашем оффере.
                    Для максимального комфорта мы разработали единый личный кабинет и штат технической поддержки,
                    где вы можете обсуждать вопросы по заказу, а также выделим для вас персонального менеджера
                    по сопровождению вашего заказа
                </p>
            </div>
            <img src="<?= Url::to('../img/mainimg/about-lead.svg') ?>" alt="Что такое LEAD.FORCE?">
        </div>
    </div>
</section>
<section class="lead-buy">
    <div class="container">

        <h2 class="lead-buy__title">С нами просто купить и получать лиды</h2>
        <div class="lead-buy__wrap">
            <div class="lead-buy__item">
                <div class="lead-buy__img">
                    <img src="<?= Url::to('img/mainimg/lead-buy-1.svg') ?>" alt="">
                </div>
                <div class="lead-buy__text">
                    <p><span>Как мы работаем?</span></p>
                    <p>Мы создаем сайты, настраиваем рекламу, контролируем и анализируем результаты каждого этапа. Вы —
                        получаете свежих и горячих клиентов!</p>
                </div>
            </div>
            <div class="lead-buy__item">
                <div class="lead-buy__img">
                    <img src="<?= Url::to('img/mainimg/lead-buy-2.svg') ?>" alt="">
                </div>
                <div class="lead-buy__text">
                    <p><span>Почему с нами удобно?</span></p>
                    <p>Весь функционал покупки и продажи лидов доступен в удобном личном кабинете. Делайте заказы в пару
                        кликов!</p>
                </div>
            </div>
            <div class="lead-buy__item">
                <div class="lead-buy__img">
                    <img src="<?= Url::to('img/mainimg/lead-buy-3.svg') ?>" alt="">
                </div>
                <div class="lead-buy__text">
                    <p><span>С чего начать?</span></p>
                    <p>Начните с регистрации в личном кабинете. Понятный интерфейс не даст вам запутаться в оформлении
                        заказа.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="lead-baner">
    <div class="container">
        <div class="lead-baner__wrap">
            <h2 class="lead-baner__title">Хотите получить больше заинтересованных клиентов?</h2>
            <p class="led-baner__text">Приведем качественные лиды по индивидуальным запросам</p>
            <a href="<?= Url::to('site/registr') ?>" class="lead-baner__btn">Подробнее</a>
        </div>
    </div>
</section>
<section class="TL_sec2" id="TL_sec2">
    <div class="container">
        <div class="TL_cont" id="leads-category">
            <h2 class="TL_sec2-title">
                Виды лидов
            </h2>
            <p class="TL_sec2-subtitle">Выберите сферу вашего бизнеса</p>
            <div class="filter-block">
                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.52033 7.7583H18.4687C19.2153 7.7583 19.822 8.36497 19.822 9.11163V10.605C19.822 11.1533 19.4837 11.83 19.1453 12.1683L16.2287 14.7466C15.8203 15.085 15.552 15.7616 15.552 16.31V19.2266C15.552 19.635 15.2837 20.1716 14.9453 20.3816L14.0003 20.9766C13.1137 21.525 11.9003 20.9066 11.9003 19.8216V16.2283C11.9003 15.75 11.632 15.1433 11.352 14.805L8.77366 12.0866C8.43533 11.76 8.16699 11.1416 8.16699 10.7333V9.18163C8.16699 8.36497 8.77366 7.7583 9.52033 7.7583Z" stroke="#DF2C56" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M10.4997 25.6667H17.4997C23.333 25.6667 25.6663 23.3334 25.6663 17.5V10.5C25.6663 4.66671 23.333 2.33337 17.4997 2.33337H10.4997C4.66634 2.33337 2.33301 4.66671 2.33301 10.5V17.5C2.33301 23.3334 4.66634 25.6667 10.4997 25.6667Z" stroke="#DF2C56" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                Фильтр
            </div>
            <div class="TL_sec2-inner">
                <aside class="TL_sec2-aside">
                    <h4 class="TL_sec2__Text">Категории</h4>
                    <?= Html::beginForm(Url::to(['index']), 'get', ['class' => 'filter__form desctop']) ?>
                    <div class="filters__wrap OF__cards-filters filters">
                        <!--                    <input class="sr-only" type="checkbox" name="filter[category]" value="all">-->
                        <span style="background: #f16262; color: white" class="filters__btn filters__btn--2 filters__btn--margin reload__filter">Сбросить
                            фильтр</span>
                        <?php foreach ($category as $k => $v) : ?>
                            <?php if (empty($v['templates'])) continue; ?>
                            <label class="filters__btn filters__btn--2 left_filter">
                                <input class="sr-only" type="checkbox" name="filter[category][]" value="<?= $v['link_name'] ?>">
                                <?= $v['name'] ?>
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <?= Html::endForm(); ?>
                </aside>

                <div class="TL_sec2-content">
                    <?= Html::beginForm(Url::to(['index']), 'get', ['class' => 'filter__form2 desctop']) ?>
                    <div class="OF__cards-filters filters filters--flex  filters__Wrap">
                        <p>Сортировать по:</p>
                        <label class="filters__btn top_filter">
                            <input class="sr-only" type="checkbox" name="filter[new]" value="new">
                            Новые лиды
                        </label>

                        <label class="filters__btn top_filter">
                            <input class="sr-only" type="checkbox" name="filter[price]" value="500">
                            Лиды до 500 ₽
                        </label>
                    </div>
                    <?= Html::endForm(); ?>

                    <div class="TL_sec2-pjax">
                        <!--            pjax     -->
                        <?php Pjax::begin(["id" => 'PjaxCont']); ?>
                        <a href="" id="link_reload"></a>
                        <div class="pjax-inner-wrapper">
                            <?php foreach ($categoriFind as $k => $v) : ?>
                                <?php if (!empty($v)) : ?>
                                    <div class="z019">
                                        <h3 class="Head__sort--find"><?= $k ?></h3>
                                        <div class="TL_container3 sort__find flex fww">
                                            <?php foreach ($v as $key => $value) : ?>
                                                <div class="TL_block1">
                                                    <a class="TL_block1--link" href="<?= Url::to(['lead-plan', 'link' => $value['link']]) ?>"></a>
                                                    <div class="TL_block1_1">

                                                        <p class="TL_p3"><?= $value['category'] ?></p>
                                                    </div>
                                                    <div class="TL_p31">
                                                        <?php $count = count(json_decode($value['regions'])); ?>
                                                        <?php if ($count == 1) : ?>

                                                        <?php elseif ($count <= 4) : ?>
                                                            <p class="TL_p3_1"><?= $count ?> города</p>
                                                        <?php else : ?>
                                                            <p class="TL_p3_1"><?= $count ?> городов</p>
                                                        <?php endif; ?>
                                                        <h3 class="TL_p3_2"><?= $value['name'] ?><img class="TL_img" src="<?= UrlHelper::admin($value['image']) ?>" alt="мешок с $"></h3>
                                                        <p class="TL_p3_3">от <?= $value['price'] ?> рублей/лид</p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <?php Pjax::end(); ?>
                    </div>

                    <div class="Tl_sec2_mobile">


                        <div class=" swiper slider_mobile">

                            <div class="swiper-wrapper">
                                <a href="" id="link_reload"></a>
                                <?php foreach ($categoriFind as $k => $v) : ?>
                                    <?php if (!empty($v)) : ?>

                                        <?php foreach ($v as $key => $value) : ?>

                                            <div class="swiper-slide">
                                                <?php Pjax::begin(["id" => 'PjaxCont']); ?>

                                                <div class="TL_container3 sort__find flex fww">
                                                    <div class="TL_block1">
                                                        <a class="TL_block1--link" href="<?= Url::to(['lead-plan', 'link' => $value['link']]) ?>"></a>
                                                        <div class="TL_block1_1">

                                                            <p class="TL_p3"><?= $value['category'] ?></p>
                                                        </div>
                                                        <div class="TL_p31">
                                                            <?php $count = count(json_decode($value['regions'])); ?>
                                                            <?php if ($count == 1) : ?>

                                                            <?php elseif ($count <= 4) : ?>
                                                                <p class="TL_p3_1"><?= $count ?> города</p>
                                                            <?php else : ?>
                                                                <p class="TL_p3_1"><?= $count ?> городов</p>
                                                            <?php endif; ?>
                                                            <h3 class="TL_p3_2"><?= $value['name'] ?><img class="TL_img" src="<?= UrlHelper::admin($value['image']) ?>" alt="мешок с $">
                                                            </h3>
                                                            <p class="TL_p3_3">от <?= $value['price'] ?> рублей/лид</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php Pjax::end(); ?>
                                            </div>

                                        <?php endforeach; ?>

                                    <?php endif; ?>
                                <?php endforeach; ?>


                            </div>

                            <div class="slider_mobile__pag"></div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--<div class="BL">
    <div class="container">
      <div class="BL__WRAP">
          <div class="BL__IMG">
              <h2 class="form__title top-title">
                  Купить лиды
              </h2>
              <img src="<?/*= URL::to('../img/mainimg/buy-leads.jpg')*/ ?>">
          </div>

          <?/*= Html::beginForm('', 'post', ['class' => 'BL__form form', 'id' => 'buyLeads']) */ ?>
          <input type="hidden" name="URL" value="<?/*= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] */ ?>">
          <input type="hidden" name="formType" value="Форма покупки лидов" id="formType">
          <input type="hidden" name="pipeline" value="104">
          <input type="hidden" name="utm_source" value="<?/*= $_SESSION['utm_source'] */ ?>">
          <input type="hidden" name="utm_campaign" value="<?/*= $_SESSION['utm_campaign'] */ ?>">
          <input type="hidden" name="service" value="">
          <div class="form__step step1 step6">
              <div class="form__content">

                  <p class="form__subtitle top-subtitle">
                      Пройдите регистрацию в личном кабинете для получения доступа к покупке лидов
                  </p>

                  <div class="form__info">Укажите Вашу деятельность</div>

                  <div class="form-filters-select filters-select">

                      <input name='comments[niche]' placeholder='Выберите нишу' id="commentsLeads">

                  </div>
              </div>

              <button class="form__btn btn next_quiz-btn" type="button">Далее</button>
          </div>

          <div style="display: none" class="form__step step2">
              <div class="form__content">

                  <p class="form__subtitle top-subtitle">
                      Пройдите регистрацию в личном кабинете для получения доступа к покупке лидов
                  </p>

                  <div class="form__info">Лиды из какого региона вы хотите купить?</div>

                  <div class="form-filters-select filters-select filters-select-bottom">
                      <select class="inp1 chosen-select partRegion" name="region" id="">
                          <option value="Россия">Россия</option>
                          <?php /*foreach ($regions as $k => $v) : */ ?>
                              <option value="<?/*= $v['name_with_type'] */ ?>"><?/*= $v['name_with_type'] */ ?></option>
                          <?php /*endforeach; */ ?>
                      </select>
                  </div>
              </div>

              <button class="form__btn btn next_quiz-btn" type="button">Далее</button>
          </div>

          <div style="display: none" class="form__step step3">
              <div class="form__content">

                  <p class="form__subtitle top-subtitle">
                      Пройдите регистрацию в личном кабинете для получения доступа к покупке лидов
                  </p>

                  <div class="form__info">Какой объем лидов вам комфортно обрабатывать за месяц?</div>


                  <input id="in10" type="radio" checked name="comments[lead_day]" value="до 50 шт" class="form__radio" />
                  <label for="in10" class="form__label-radio">до 50 шт</label>

                  <input id="in11" type="radio" name="comments[lead_day]" value="от 50 шт до 100 шт"
                         class="form__radio" />
                  <label for="in11" class="form__label-radio">от 50 шт до 100 шт</label>

                  <input id="in12" type="radio" name="comments[lead_day]" value="более 100 шт" class="form__radio" />
                  <label for="in12" class="form__label-radio">более 100 шт</label>
              </div>

              <a href="<?/*= Url::to(['/registr?site=lead']) */ ?>" class="form__btn btn next_quiz-btn">Далее</a>
          </div>

          <div style="display: none" class="form__step step4">
              <div class="form__content">
                  <h2 class="form__title top-title">
                      Купить лиды
                  </h2>

                  <input name="comments[niche]" placeholder="Add a niche" class="tagify__input" />
                  <p class="form__subtitle top-subtitle">
                      Пройдите регистрацию в личном кабинете для получения доступа к покупке лидов
                  </p>
                  <div class="BuyLeads__error">Введите Имя и Телефон</div>
                  <div class="form__info">Укажите ФИО и телефон для регистрации в проекте</div>
                  <input id="in13" type="text" name="name" required placeholder="ФИО"
                         class="form__input-text fio__register" />
                  <input id="in14" type="tel" name="phone" required placeholder="Телефон"
                         class="form__input-text phone__register" />
              </div>

              <button class="form__btn btn send__code" type="button">Далее</button>
          </div>

          <div style="display: none" class="form__step step7">
              <div class="form__content">
                  <h2 class="form__title top-title">
                      Купить лиды
                  </h2>
                  <p class="form__subtitle top-subtitle">
                      Пройдите регистрацию в личном кабинете для получения доступа к покупке лидов
                  </p>

                  <div class="form__info">Введите код, полученный на номер телефона <span class="number__inner"></span> <a
                              style="cursor: pointer" class="form__info-link linkonbackstap">(изменить)</a>
                  </div>

                  <div class="BuyLeads__error"></div>

                  <div class="LIN_C_medle_С">
                      <input form="codereset" class="LIN2_F_U_P_C code__input" required placeholder="Код" type="text"
                             name="code" id="code-22">
                      <div class="codereseter">
                          <p class="codereset">Отправить код повторно через <span class="numertimerinsendcode2">59</span>с
                          </p>
                          <p class="sendcodeagainnow2">Отправить код повторно</p>
                      </div>
                  </div>

                  <div class="form__close">
                      Если Вы не получили код в течении 5 минут <br>— напишите нам на почту <a href="#"
                                                                                               class="form__close-link">general@myforce.ru</a>
                  </div>
              </div>

              <button class="form__btn form__btn--end btn code__confirmed" type="button">Завершить регистрацию</button>
          </div>
          <?/*= Html::endForm(); */ ?>
      </div>


    </div>
</div>-->
<section class="lead-guarantee" style="padding-top: 10px">
    <div class="container">
        <h2 class="lead-guarantee__title">Гарантии качества лидов</h2>
        <p class="lead-guarantee__text">Три главных отличия наших лидов от других:</p>

        <div class="lead-guarantee__wrap">
            <div class="lead-guarantee__item">
                <div class="lead-guarantee__logo">
                    <svg width="117" height="100" viewBox="0 0 117 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24.5288 23.6145C30.3405 14.2597 39.0782 7.0854 49.3853 3.20555C59.6923 -0.674321 70.992 -1.04266 81.5298 2.15771C92.0677 5.35808 101.254 11.9481 107.663 20.9045C114.071 29.861 117.344 40.6828 116.971 51.6896C116.599 62.6964 112.604 73.2724 105.605 81.7755C98.6056 90.2787 88.9951 96.2332 78.2651 98.7144C67.5352 101.196 56.2862 100.065 46.2648 95.4978C36.2433 90.9306 28.0101 83.1825 22.8436 73.4565L27.9494 70.7442C32.5186 79.3456 39.7998 86.1977 48.6624 90.2368C57.5251 94.2759 67.4733 95.2759 76.9625 93.0815C86.4518 90.8871 94.951 85.6212 101.141 78.1013C107.33 70.5814 110.864 61.2283 111.193 51.4942C111.522 41.7601 108.628 32.1897 102.961 24.2689C97.2932 16.3481 89.1691 10.5201 79.8497 7.68979C70.5304 4.85948 60.5373 5.18523 51.4221 8.61646C42.3068 12.0477 34.5795 18.3924 29.4398 26.6655L24.5288 23.6145Z" fill="#DF2C56" />
                        <path d="M15.364 64.46C13.156 64.46 11.2547 64.1533 9.66 63.54C8.096 62.896 6.79267 62.022 5.75 60.918C4.738 59.7833 3.97133 58.48 3.45 57.008C2.95933 55.5053 2.668 53.9107 2.576 52.224C2.54533 51.396 2.51467 50.476 2.484 49.464C2.484 48.4213 2.484 47.3787 2.484 46.336C2.51467 45.2933 2.54533 44.3427 2.576 43.484C2.63733 41.7973 2.92867 40.218 3.45 38.746C4.002 37.274 4.79933 35.986 5.842 34.882C6.88467 33.778 8.188 32.9193 9.752 32.306C11.3467 31.662 13.2173 31.34 15.364 31.34C17.5107 31.34 19.366 31.662 20.93 32.306C22.494 32.9193 23.7973 33.778 24.84 34.882C25.8827 35.986 26.6647 37.274 27.186 38.746C27.738 40.218 28.06 41.7973 28.152 43.484C28.1827 44.3427 28.198 45.2933 28.198 46.336C28.2287 47.3787 28.2287 48.4213 28.198 49.464C28.198 50.476 28.1827 51.396 28.152 52.224C28.06 53.9107 27.7533 55.5053 27.232 57.008C26.7107 58.48 25.9287 59.7833 24.886 60.918C23.874 62.022 22.5707 62.896 20.976 63.54C19.412 64.1533 17.5413 64.46 15.364 64.46ZM15.364 58.48C17.1427 58.48 18.446 57.8973 19.274 56.732C20.102 55.5667 20.5467 53.9873 20.608 51.994C20.6387 51.1047 20.654 50.1847 20.654 49.234C20.6847 48.2833 20.6847 47.3327 20.654 46.382C20.654 45.4313 20.6387 44.542 20.608 43.714C20.5467 41.8127 20.102 40.264 19.274 39.068C18.446 37.872 17.1427 37.2587 15.364 37.228C13.5547 37.2587 12.236 37.872 11.408 39.068C10.6107 40.264 10.1813 41.8127 10.12 43.714C10.0893 44.542 10.0587 45.4313 10.028 46.382C10.028 47.3327 10.028 48.2833 10.028 49.234C10.0587 50.1847 10.0893 51.1047 10.12 51.994C10.1813 53.9873 10.626 55.5667 11.454 56.732C12.282 57.8973 13.5853 58.48 15.364 58.48ZM43.4686 64C43.1619 64 42.8859 63.8927 42.6406 63.678C42.4259 63.4633 42.3186 63.1873 42.3186 62.85V39.988L35.6946 45.094C35.4186 45.3087 35.1272 45.3853 34.8206 45.324C34.5446 45.2627 34.2992 45.094 34.0846 44.818L31.7846 41.828C31.6006 41.552 31.5239 41.2607 31.5546 40.954C31.6159 40.6473 31.7846 40.402 32.0606 40.218L42.5486 32.122C42.7326 31.9993 42.9012 31.9227 43.0546 31.892C43.2386 31.8307 43.4379 31.8 43.6526 31.8H48.5286C48.8352 31.8 49.0959 31.9073 49.3106 32.122C49.5252 32.3367 49.6326 32.6127 49.6326 32.95V62.85C49.6326 63.1873 49.5252 63.4633 49.3106 63.678C49.0959 63.8927 48.8352 64 48.5286 64H43.4686Z" fill="url(#paint0_linear_248_10376)" />
                        <defs>
                            <linearGradient id="paint0_linear_248_10376" x1="31" y1="24" x2="31" y2="72" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                        </defs>
                    </svg>
                    <p class="lead-guarantee__mobile"><span>Точная верификация клиента</span></p>
                </div>
                <div class="lead-guarantee__items">
                    <p class="lead-guarantee__none"><span>Точная верификация клиента</span></p>
                    <p>Любой пришедший лид по вашему заказу проходит обязательную проверку специалистом call-центра где
                        уточняются все необходимые данные клиента, которые нужны вам для заключения сделки.</p>
                </div>


            </div>
            <svg width="2" height="58" viewBox="0 0 2 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line x1="1" y1="4.37114e-08" x2="0.999997" y2="58" stroke="#DF2C56" stroke-width="2" stroke-dasharray="8 8" />
            </svg>

            <div class="lead-guarantee__item">
                <div class="lead-guarantee__logo">
                    <svg width="117" height="100" viewBox="0 0 117 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24.5288 23.6145C30.3405 14.2597 39.0782 7.0854 49.3853 3.20555C59.6923 -0.674321 70.992 -1.04266 81.5298 2.15771C92.0677 5.35808 101.254 11.9481 107.663 20.9045C114.071 29.861 117.344 40.6828 116.971 51.6896C116.599 62.6964 112.604 73.2724 105.605 81.7755C98.6056 90.2787 88.9951 96.2332 78.2651 98.7144C67.5352 101.196 56.2862 100.065 46.2648 95.4978C36.2433 90.9306 28.0101 83.1825 22.8436 73.4565L27.9494 70.7442C32.5186 79.3456 39.7998 86.1977 48.6624 90.2368C57.5251 94.2759 67.4733 95.2759 76.9625 93.0815C86.4518 90.8871 94.951 85.6212 101.141 78.1013C107.33 70.5814 110.864 61.2283 111.193 51.4942C111.522 41.7601 108.628 32.1897 102.961 24.2689C97.2932 16.3481 89.1691 10.5201 79.8497 7.68979C70.5304 4.85948 60.5373 5.18523 51.4221 8.61646C42.3068 12.0477 34.5795 18.3924 29.4398 26.6655L24.5288 23.6145Z" fill="#DF2C56" />
                        <path d="M15.364 64.46C13.156 64.46 11.2547 64.1533 9.66 63.54C8.096 62.896 6.79267 62.022 5.75 60.918C4.738 59.7833 3.97133 58.48 3.45 57.008C2.95933 55.5053 2.668 53.9107 2.576 52.224C2.54533 51.396 2.51467 50.476 2.484 49.464C2.484 48.4213 2.484 47.3787 2.484 46.336C2.51467 45.2933 2.54533 44.3427 2.576 43.484C2.63733 41.7973 2.92867 40.218 3.45 38.746C4.002 37.274 4.79933 35.986 5.842 34.882C6.88467 33.778 8.188 32.9193 9.752 32.306C11.3467 31.662 13.2173 31.34 15.364 31.34C17.5107 31.34 19.366 31.662 20.93 32.306C22.494 32.9193 23.7973 33.778 24.84 34.882C25.8827 35.986 26.6647 37.274 27.186 38.746C27.738 40.218 28.06 41.7973 28.152 43.484C28.1827 44.3427 28.198 45.2933 28.198 46.336C28.2287 47.3787 28.2287 48.4213 28.198 49.464C28.198 50.476 28.1827 51.396 28.152 52.224C28.06 53.9107 27.7533 55.5053 27.232 57.008C26.7107 58.48 25.9287 59.7833 24.886 60.918C23.874 62.022 22.5707 62.896 20.976 63.54C19.412 64.1533 17.5413 64.46 15.364 64.46ZM15.364 58.48C17.1427 58.48 18.446 57.8973 19.274 56.732C20.102 55.5667 20.5467 53.9873 20.608 51.994C20.6387 51.1047 20.654 50.1847 20.654 49.234C20.6847 48.2833 20.6847 47.3327 20.654 46.382C20.654 45.4313 20.6387 44.542 20.608 43.714C20.5467 41.8127 20.102 40.264 19.274 39.068C18.446 37.872 17.1427 37.2587 15.364 37.228C13.5547 37.2587 12.236 37.872 11.408 39.068C10.6107 40.264 10.1813 41.8127 10.12 43.714C10.0893 44.542 10.0587 45.4313 10.028 46.382C10.028 47.3327 10.028 48.2833 10.028 49.234C10.0587 50.1847 10.0893 51.1047 10.12 51.994C10.1813 53.9873 10.626 55.5667 11.454 56.732C12.282 57.8973 13.5853 58.48 15.364 58.48ZM33.8546 64C33.5172 64 33.2412 63.8927 33.0266 63.678C32.8119 63.4633 32.7046 63.1873 32.7046 62.85V60.09C32.7046 59.8447 32.7659 59.5227 32.8886 59.124C33.0419 58.6947 33.3639 58.2807 33.8546 57.882L39.9266 51.856C42.1652 50.1387 43.9746 48.682 45.3546 47.486C46.7652 46.29 47.8079 45.2013 48.4826 44.22C49.1572 43.2387 49.4946 42.288 49.4946 41.368C49.4946 40.172 49.1572 39.1907 48.4826 38.424C47.8386 37.6267 46.7806 37.228 45.3086 37.228C44.3272 37.228 43.4992 37.4427 42.8246 37.872C42.1806 38.2707 41.6746 38.8073 41.3066 39.482C40.9386 40.1567 40.6932 40.8927 40.5706 41.69C40.4786 42.0887 40.2792 42.3647 39.9726 42.518C39.6966 42.6713 39.4052 42.748 39.0986 42.748H34.2226C33.9159 42.748 33.6706 42.656 33.4866 42.472C33.3026 42.2573 33.2106 42.0273 33.2106 41.782C33.2412 40.3713 33.5326 39.0373 34.0846 37.78C34.6672 36.5227 35.4799 35.4033 36.5226 34.422C37.5652 33.4407 38.8226 32.674 40.2946 32.122C41.7666 31.5393 43.4379 31.248 45.3086 31.248C47.8846 31.248 50.0466 31.6773 51.7946 32.536C53.5426 33.364 54.8612 34.514 55.7506 35.986C56.6399 37.458 57.0846 39.16 57.0846 41.092C57.0846 42.564 56.7779 43.9287 56.1646 45.186C55.5819 46.4433 54.7232 47.6547 53.5886 48.82C52.4539 49.9547 51.1046 51.1353 49.5406 52.362L44.1126 57.79H56.6246C56.9619 57.79 57.2379 57.8973 57.4526 58.112C57.6672 58.3267 57.7746 58.6027 57.7746 58.94V62.85C57.7746 63.1873 57.6672 63.4633 57.4526 63.678C57.2379 63.8927 56.9619 64 56.6246 64H33.8546Z" fill="url(#paint0_linear_248_10377)" />
                        <defs>
                            <linearGradient id="paint0_linear_248_10377" x1="31" y1="24" x2="31" y2="72" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                        </defs>
                    </svg>

                    <p class="lead-guarantee__mobile"><span>Возврат за нецелевой трафик</span></p>
                </div>
                <div class="lead-guarantee__items">
                    <p class="lead-guarantee__none"><span>Возврат за нецелевой трафик</span></p>
                    <p>Некорректные лиды мы заменяем вам бесплатно, отбраковка по умолчанию включена в каждый пакет
                        и составляет 25% замены от всего заказа.</p>
                </div>


            </div>
            <svg width="2" height="58" viewBox="0 0 2 58" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line x1="1" y1="4.37114e-08" x2="0.999997" y2="58" stroke="#DF2C56" stroke-width="2" stroke-dasharray="8 8" />
            </svg>

            <div class="lead-guarantee__item">
                <div class="lead-guarantee__logo">
                    <svg width="117" height="100" viewBox="0 0 117 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M24.5288 23.6145C30.3405 14.2597 39.0782 7.0854 49.3853 3.20555C59.6923 -0.674321 70.992 -1.04266 81.5298 2.15771C92.0677 5.35808 101.254 11.9481 107.663 20.9045C114.071 29.861 117.344 40.6828 116.971 51.6896C116.599 62.6964 112.604 73.2724 105.605 81.7755C98.6056 90.2787 88.9951 96.2332 78.2651 98.7144C67.5352 101.196 56.2862 100.065 46.2648 95.4978C36.2433 90.9306 28.0101 83.1825 22.8436 73.4565L27.9494 70.7442C32.5186 79.3456 39.7998 86.1977 48.6624 90.2368C57.5251 94.2759 67.4733 95.2759 76.9625 93.0815C86.4518 90.8871 94.951 85.6212 101.141 78.1013C107.33 70.5814 110.864 61.2283 111.193 51.4942C111.522 41.7601 108.628 32.1897 102.961 24.2689C97.2932 16.3481 89.1691 10.5201 79.8497 7.68979C70.5304 4.85948 60.5373 5.18523 51.4221 8.61646C42.3068 12.0477 34.5795 18.3924 29.4398 26.6655L24.5288 23.6145Z" fill="#DF2C56" />
                        <path d="M15.364 64.46C13.156 64.46 11.2547 64.1533 9.66 63.54C8.096 62.896 6.79267 62.022 5.75 60.918C4.738 59.7833 3.97133 58.48 3.45 57.008C2.95933 55.5053 2.668 53.9107 2.576 52.224C2.54533 51.396 2.51467 50.476 2.484 49.464C2.484 48.4213 2.484 47.3787 2.484 46.336C2.51467 45.2933 2.54533 44.3427 2.576 43.484C2.63733 41.7973 2.92867 40.218 3.45 38.746C4.002 37.274 4.79933 35.986 5.842 34.882C6.88467 33.778 8.188 32.9193 9.752 32.306C11.3467 31.662 13.2173 31.34 15.364 31.34C17.5107 31.34 19.366 31.662 20.93 32.306C22.494 32.9193 23.7973 33.778 24.84 34.882C25.8827 35.986 26.6647 37.274 27.186 38.746C27.738 40.218 28.06 41.7973 28.152 43.484C28.1827 44.3427 28.198 45.2933 28.198 46.336C28.2287 47.3787 28.2287 48.4213 28.198 49.464C28.198 50.476 28.1827 51.396 28.152 52.224C28.06 53.9107 27.7533 55.5053 27.232 57.008C26.7107 58.48 25.9287 59.7833 24.886 60.918C23.874 62.022 22.5707 62.896 20.976 63.54C19.412 64.1533 17.5413 64.46 15.364 64.46ZM15.364 58.48C17.1427 58.48 18.446 57.8973 19.274 56.732C20.102 55.5667 20.5467 53.9873 20.608 51.994C20.6387 51.1047 20.654 50.1847 20.654 49.234C20.6847 48.2833 20.6847 47.3327 20.654 46.382C20.654 45.4313 20.6387 44.542 20.608 43.714C20.5467 41.8127 20.102 40.264 19.274 39.068C18.446 37.872 17.1427 37.2587 15.364 37.228C13.5547 37.2587 12.236 37.872 11.408 39.068C10.6107 40.264 10.1813 41.8127 10.12 43.714C10.0893 44.542 10.0587 45.4313 10.028 46.382C10.028 47.3327 10.028 48.2833 10.028 49.234C10.0587 50.1847 10.0893 51.1047 10.12 51.994C10.1813 53.9873 10.626 55.5667 11.454 56.732C12.282 57.8973 13.5853 58.48 15.364 58.48ZM45.3546 64.46C43.0852 64.46 41.1379 64.184 39.5126 63.632C37.8872 63.08 36.5532 62.3747 35.5106 61.516C34.4679 60.6573 33.6859 59.722 33.1646 58.71C32.6432 57.6673 32.3672 56.6707 32.3366 55.72C32.3366 55.444 32.4286 55.214 32.6126 55.03C32.7966 54.846 33.0266 54.754 33.3026 54.754H38.3626C38.6999 54.754 38.9759 54.8307 39.1906 54.984C39.4052 55.1067 39.6046 55.3367 39.7886 55.674C40.0339 56.3793 40.4326 56.9467 40.9846 57.376C41.5366 57.8053 42.1806 58.112 42.9166 58.296C43.6832 58.4493 44.4959 58.526 45.3546 58.526C47.0719 58.526 48.4212 58.1273 49.4026 57.33C50.3839 56.5327 50.8746 55.4133 50.8746 53.972C50.8746 52.5 50.4146 51.442 49.4946 50.798C48.5746 50.154 47.2712 49.832 45.5846 49.832H40.6626C40.3559 49.832 40.0952 49.7247 39.8806 49.51C39.6659 49.2953 39.5586 49.0347 39.5586 48.728V46.474C39.5586 46.106 39.6199 45.7993 39.7426 45.554C39.8959 45.3087 40.0492 45.1247 40.2026 45.002L48.1146 37.734H35.1426C34.8052 37.734 34.5292 37.6267 34.3146 37.412C34.0999 37.1973 33.9926 36.9367 33.9926 36.63V32.95C33.9926 32.6127 34.0999 32.3367 34.3146 32.122C34.5292 31.9073 34.8052 31.8 35.1426 31.8H55.5666C55.9039 31.8 56.1799 31.9073 56.3946 32.122C56.6092 32.3367 56.7166 32.6127 56.7166 32.95V36.262C56.7166 36.5993 56.6552 36.8907 56.5326 37.136C56.4099 37.3507 56.2566 37.5193 56.0726 37.642L48.5746 45.048L49.0346 45.094C50.8439 45.278 52.4539 45.7227 53.8646 46.428C55.2752 47.1333 56.3792 48.1453 57.1766 49.464C58.0046 50.752 58.4186 52.3927 58.4186 54.386C58.4186 56.4713 57.8512 58.2653 56.7166 59.768C55.5819 61.2707 54.0332 62.436 52.0706 63.264C50.1079 64.0613 47.8692 64.46 45.3546 64.46Z" fill="url(#paint0_linear_248_10380)" />
                        <defs>
                            <linearGradient id="paint0_linear_248_10380" x1="31" y1="24" x2="31" y2="72" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#DF2C56" />
                                <stop offset="1" stop-color="#C81F47" />
                            </linearGradient>
                        </defs>
                    </svg>

                    <p class="lead-guarantee__mobile"><span>Честная оплата</span></p>
                </div>
                <div class="lead-guarantee__items">
                    <p class="lead-guarantee__none"><span>Честная оплата</span></p>
                    <p>Мы не настраиваем рекламу ради рекламы , мы выбираем только проверенные источники для получения
                        целевого трафика.</p>
                </div>


            </div>
        </div>
    </div>
</section>

<section class="lead-baner-two">
    <div class="container">
        <div class="lead-baner-two__wrap">
            <div class="By__Leads__Sec5__content-Ddttl">
                <?= Html::beginForm('', 'post', ['id' => 'Sec5-form']) ?>
                <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
                <input type="hidden" name="formType" value="">
                <input type="hidden" name="pipeline" value="104">
                <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
                <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
                <input type="hidden" name="service" value="">
                <input type="hidden" name="section" value="Описание работы">
                <div class="Sec5-step1">
                    <p class="BLS5CDText-1">Вы платите за целевые лиды</p>
                    <p class="BLS5CDText-2">
                        В отличие от предложений на рынке, берём комиссию только за качественные целевые лиды:
                        мы обсуждаем с вами критерии и фиксируем их до начала работы, а не постфактум, когда бюджет
                        потрачен
                    </p>
                    <div class="Sec5-inputs">
                        <input class="Sec5-input fcstlt" type="text" name="fio" placeholder="Имя" required>
                        <input class="Sec5-input fcstlt" type="tel" name="phone" placeholder="Телефон" required>
                    </div>
                    <button type="sabmit" class="btn-1">Подробнее</button>
                </div>
                <div class="Sec5-step2">
                    <p class="BLS5CDText-1">Благодарим за заявку!</p>
                    <p class="BLS5CDText-2">
                        Наш менеждер проконсультирует вас в ближайшее время
                    </p>
                </div>
                <?= Html::endForm(); ?>
            </div>
        </div>
    </div>
</section>


<div class="modal-filter">
    <div class="modal-filter__block">
        <div class="modal-filter__btn">
            <button>Категории <svg width="18" height="9" viewBox="0 0 18 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.07006 0.949984L7.57442 7.46998C8.34257 8.23998 9.59955 8.23998 10.3677 7.46998L16.8721 0.949985" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
            <span class="filters__btn filters__btn--2 filters__btn--margin reload__filter">Сбросить фильтр</span>
        </div>
        <?= Html::beginForm(Url::to(['index']), 'get', ['class' => 'filter__form mobile']) ?>



        <ul class="modal-filter__list">
            <?php foreach ($category as $k => $v) : ?>
                <li>
                    <label class="filters__btn filters__btn--2 left_filter">
                        <input class="sr-only" type="checkbox" name="filter[category][]" value="<?= $v['link_name'] ?>">
                        <?= $v['name'] ?>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
        <?= Html::endForm(); ?>

        <div class="modal-filter__btn">
            <button>Сортировать по: <svg width="18" height="9" viewBox="0 0 18 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.07006 0.949984L7.57442 7.46998C8.34257 8.23998 9.59955 8.23998 10.3677 7.46998L16.8721 0.949985" stroke="white" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </button>
        </div>


        <?= Html::beginForm(Url::to(['index']), 'get', ['class' => 'filter__form2 mobile']) ?>
        <div class="OF__cards-filters filters filters--flex  filters__Wrap">
            <label class="filters__btn top_filter">
                <input class="sr-only" type="checkbox" name="filter[new]" value="new">
                Новые лиды
            </label>

            <label class="filters__btn top_filter">
                <input class="sr-only" type="checkbox" name="filter[price]" value="500">
                Лиды до 500 ₽
            </label>
        </div>
        <?= Html::endForm(); ?>

        <button class="modal__btn" onclick="location.reload(); return false;"> Применить</button>

        <svg class="modal-filter__close" width="23" height="23" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.39945 21.7082L21.6012 1.29161" stroke="white" stroke-width="2" stroke-linecap="round" />
            <path d="M1.39941 1.29163L21.6012 21.7083" stroke="white" stroke-width="2" stroke-linecap="round" />
        </svg>
    </div>
</div>