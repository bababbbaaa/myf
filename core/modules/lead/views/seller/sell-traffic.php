<?php

use yii\helpers\Url;
use yii\helpers\Html;

$regions = \common\models\DbRegion::find()->asArray()->select(['name_with_type'])->orderBy('name_with_type asc')->all();
$js = <<< JS
$(".chosen-select").chosen({disable_search_threshold: 0});

    // Selltrafick
    var next_step = 1,
        time;
    $('.next__form__btnSell').on('click', function () {
        if ($('input[name="comments[category]"]').is(':checked') && next_step == 1){
            $('.step' + next_step++).fadeOut(300, function () {
                $('.step' + next_step).fadeIn(300);
            });
        } else if($('input[name="region"]').val() !== '' && next_step == 2){
            $('.step' + next_step++).fadeOut(300, function () {
                $('.step' + next_step).fadeIn(300);
            });
        } else if($('input[name="lead in day"]').is(':checked') && next_step == 3){
            $('.step' + next_step++).fadeOut(300, function () {
                $('.step' + next_step).fadeIn(300);
            });
        } else if($('input[name="name-of"]').val() !== '' && $('input[name="stoim"]').val() !== '' && next_step == 6) {
            $('.step' + next_step++).fadeOut(300, function () {
                $('.step' + next_step).fadeIn(300);
            });
        } else if($('textarea[name="offer-desc"]').val() !== '' && next_step == 7){
            $('.step' + next_step++).fadeOut(300, function () {
                next_step = 2;
                $('.step' + next_step).fadeIn(300);
            });
        }
        console.log(next_step);
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
                      $('.step5').fadeIn(300);
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
        $('.step5').fadeOut(300, function () {
                $('.step4').fadeIn(300);
                _Seconds = 59;
                clearInterval(time);
            });
    });
    var fade_offer = true;
    $('input[name="comments[offer]"]').on('click', function () {
        if(fade_offer == true){
            $('.step1').fadeOut(300, function () {
                $('.step6').fadeIn(300);
            });
            fade_offer = false;
            $('input[name="comments[offer]"]').prop('checked', false);
        }
        next_step = 6;
    });
    $('input[name="offers"]').on('click', function () {
        if(fade_offer == false){
            $('.step6').fadeOut(300, function () {
                $('.step1').fadeIn(300);
            });
            $('input[name="offers"]').prop('checked', true);
            fade_offer = true;
        }
        next_step = 1;
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
JS;
$this->title = 'Продать трафик';
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJsFile(Url::to(['/js/leadjs/getRegionAjax.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);
?>

<body>
    <div class="SQ">
        <div class="container">
            <?= Html::beginForm('', 'post', ['class' => 'SQ__form form', 'id' => 'sellTraffic']) ?>
            <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
            <input type="hidden" name="formType" value="Форма продажи трафика">
            <input type="hidden" name="pipeline" value="104">
            <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
            <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
            <input type="hidden" name="service" value="">
            <input type="hidden" name="section" value="Продать трафик">
            <div class="form__step step1">
                <div class="form__content">
                    <h2 class="form__title top-title">
                        Продать трафик
                    </h2>
                    <p class="form__subtitle top-subtitle">
                        Пройдите регистрацию в личном кабинете для получения доступа к продаже трафика
                    </p>

                    <div class="form__info">Выберите офер из предложенных или укажите свой</div>

                    <div class="form-filters-select filters-select">
                        <button type="button" class="filters__btn form__filters-btn filters__btn--select">Выберете оффер
                        </button>
                        <ul class="filters__list">
                            <?php foreach ($offers as $key => $item) : ?>
                                <li class="filters__item">
                                    <input id="<?= $item['category'] ?>" type="checkbox" name="comments[category]" value="<?= $item['category'] ?>" class="filters__input" />
                                    <label for="<?= $item['category'] ?>" class="filters__label">
                                        <?= $item['category'] ?>
                                    </label>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <input id="in9" type="checkbox" name="comments[offer]" class="form__input" />
                    <label for="in9" class="form__label">Свой оффер</label>
                </div>

                <button class="form__btn btn next__form__btnSell" type="button">Далее</button>
            </div>

            <div style="display: none" class="form__step step2">
                <div class="form__content">
                    <h2 class="form__title top-title">
                        Продать трафик
                    </h2>
                    <p class="form__subtitle top-subtitle">
                        Пройдите регистрацию в личном кабинете для получения доступа к продаже трафика
                    </p>

                    <div class="form__info">Лиды из какого региона вы хотите продать?</div>

                    <div class="form-filters-select filters-select">
                        <select class="inp1 chosen-select partRegion" name="region" id="">
                            <option value="Россия" selected>Россия</option>
                            <?php foreach ($regions as $k => $v) : ?>
                                <option value="<?= $v['name_with_type'] ?>"><?= $v['name_with_type'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>
                <button class="form__btn btn next__form__btnSell" type="button">Далее</button>
            </div>

            <div style="display: none" class="form__step step3">
                <div class="form__content">
                    <h2 class="form__title top-title">
                        Продать трафик
                    </h2>
                    <p class="form__subtitle top-subtitle">
                        Пройдите регистрацию в личном кабинете для получения доступа к продаже трафика
                    </p>

                    <div class="form__info">Какой объем лидов вам комфортно поставлять в месяц?</div>


                    <input id="in10" type="radio" checked name="lead in day" value="одо 10 шт" class="form__radio" />
                    <label for="in10" class="form__label-radio">до 10 шт</label>

                    <input id="in11" type="radio" name="lead in day" value="от 10 шт до 50 шт" class="form__radio" />
                    <label for="in11" class="form__label-radio">от 10 шт до 50 шт</label>

                    <input id="in12" type="radio" name="lead in day" value="более 50 шт" class="form__radio" />
                    <label for="in12" class="form__label-radio">более 50 шт</label>
                </div>

                <a href="<?= Url::to(['/registr?site=lead']) ?>" class="form__btn btn next_quiz-btn">Далее</a>
            </div>

            <div style="display: none" class="form__step step4">
                <div class="form__content">
                    <h2 class="form__title top-title">
                        Продать трафик
                    </h2>
                    <p class="form__subtitle top-subtitle">
                        Пройдите регистрацию в личном кабинете для получения доступа к продаже трафика
                    </p>
                    <div class="BuyLeads__error">Введите Имя и Телефон</div>
                    <div class="form__info">Укажите ФИО и телефон для регистрации в проекте</div>


                    <input id="in13" type="text" name="name" placeholder="ФИО" class="form__input-text quiz__form__fio fio__register" />

                    <input id="in130" type="tel" name="phone" placeholder="Телефон" class="form__input-text quiz__form__phone phone__register" />
                </div>

                <button class="form__btn btn next__form__btnSell send__code" type="button">Далее</button>
            </div>

            <div style="display: none" class="form__step step6">
                <div class="form__content">
                    <h2 class="form__title top-title">
                        Продать трафик
                    </h2>
                    <p class="form__subtitle top-subtitle">
                        Пройдите регистрацию в личном кабинете для получения доступа к продаже трафика
                    </p>

                    <div class="form__info">Выберите офер из предложенных или укажите свой</div>

                    <input id="in14" type="checkbox" checked name="offers" class="form__input" />
                    <label for="in14" class="form__label">Свой оффер</label>

                    <input id="in15" type="text" name="name-of" placeholder="Введите название оффера" class="form__input-text" />

                    <input id="in160" type="number" min="100" step="100" name="stoim" placeholder="Укажите стоимость лида" class="form__input-text" />
                </div>

                <button class="form__btn btn next__form__btnSell" type="button">Далее</button>
            </div>

            <div style="display: none" class="form__step step7">
                <div class="form__content">
                    <h2 class="form__title top-title">
                        Продать трафик
                    </h2>
                    <p class="form__subtitle top-subtitle">
                        Пройдите регистрацию в личном кабинете для получения доступа к продаже трафика
                    </p>

                    <div class="form__info">Введите небольшое описание вашего оффера</div>


                    <textarea id="in16" type="text" name="offer-desc" placeholder="Введите описание" class="form__input-textarea"></textarea>
                </div>

                <button class="form__btn btn next__form__btnSell" type="button">Далее</button>
            </div>

            <div style="display: none" class="form__step step5">
                <div class="form__content">
                    <h2 class="form__title top-title">
                        Купить лиды
                    </h2>
                    <p class="form__subtitle top-subtitle">
                        Пройдите регистрацию в личном кабинете для получения доступа к покупке лидов
                    </p>

                    <div class="form__info">Введите код, полученный на номер телефона <span class="number__inner"></span> <a style="cursor: pointer" class="form__info-link linkonbackstap">(изменить)</a>
                    </div>

                    <div class="BuyLeads__error"></div>
                    <div class="LIN_C_medle_С">
                        <input form="codereset" class="LIN2_F_U_P_C code__input" required placeholder="Код" type="text" name="code-2" id="code-22">
                        <div class="codereseter">
                            <p class="codereset">Отправить код повторно через <span class="numertimerinsendcode2">59</span>с
                            </p>
                            <p class="sendcodeagainnow2">Отправить код повторно</p>
                        </div>
                    </div>

                    <div class="form__close">
                        Если Вы не получили код в течении 5 минут <br>— напишите нам на почту <a href="#" class="form__close-link">general@myforce.ru</a>
                    </div>
                </div>

                <button class="form__btn form__btn--end btn code__confirmed" type="button">Завершить регистрацию</button>
            </div>
            <?= Html::endForm(); ?>

            <section class="OF__info">
                <h2 class="OF__info-title title title--center">
                    Что вас ждет?
                </h2>
                <p class="OF__info-subtitle subtitle subtitle--center">
                    Мы приглашаем вас присоединиться к прогрессивной партнерской сети LEAD.FORCE и начать зарабатывать
                    деньги, уже
                    сегодня!
                </p>
                <div class="OF__info-inner">
                    <div class="OF__info-item OF__info-item--w">
                        Персональный менеджер, который не оставит без ответа
                    </div>

                    <div class="OF__info-item OF__info-item--w">
                        Глубокая система аналитики трафика с наглядной статистикой
                    </div>

                    <div class="OF__info-item OF__info-item--w">
                        Самые быстрые и стабильные выплаты на СРА-рынке
                    </div>

                    <div class="OF__info-item OF__info-item--w">
                        Выделенный отдел технических специалистов и постоянный саппорт
                    </div>

                    <div class="OF__info-item OF__info-item--w">
                        Эксклюзивные офферы с премиальными условиями для всех
                    </div>

                    <div class="OF__info-item OF__info-item--w">
                        Самые высокие отчисления по рынку
                    </div>

                    <div class="OF__info-item OF__info-item--w">
                        100+ офферов для любого трафика
                    </div>

                    <div class="OF__info-item OF__info-item--w">
                        Легкая установка пикселей источников трафика (включая Facebook Ads)
                    </div>
                </div>
            </section>
        </div>
    </div>