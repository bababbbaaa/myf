<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Купить лиды';
$regions = \common\models\DbRegion::find()->asArray()->select(['name_with_type'])->orderBy('name_with_type asc')->all();
$js = <<< JS
        var step = 1,
        time;
$(".chosen-select").chosen({disable_search_threshold: 0});


    $('.next_quiz-btn').on("click", function() {
      if($('input[name="comments[niche]"]').is(":checked") && step == 1){
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


    
JS;
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJsFile(Url::to(['/js/leadjs/getRegionAjax.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);

$this->registerCssFile('@web/css/lead.css');
?>
<div class="BL">
  <div class="container">
    <?= Html::beginForm('', 'post', ['class' => 'BL__form form', 'id' => 'buyLeads']) ?>
    <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
    <input type="hidden" name="formType" value="Форма покупки лидов">
    <input type="hidden" name="pipeline" value="104">
    <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
    <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
    <input type="hidden" name="service" value="">
    <div class="form__step step1">
      <div class="form__content">
        <h1 class="form__title top-title">
          Купить лиды
        </h1>
        <p class="form__subtitle top-subtitle">
          Пройдите регистрацию в личном кабинете для получения доступа к покупке лидов
        </p>

        <div class="form__info">Из какой ниши вам нужны лиды?</div>

        <div class="form-filters-select filters-select">
          <button type="button" class="filters__btn inner__text form__filters-btn filters__btn--select">Выберете нишу
          </button>
          <ul class="filters__list">
            <?php foreach ($niche as $key => $item) : ?>
              <li class="filters__item">
                <input id="<?= $item['name'] ?>" type="checkbox" name="comments[niche]" value="<?= $item['name'] ?>" class="filters__input" />
                <label for="<?= $item['name'] ?>" class="filters__label" data-name="<?= $item['name'] ?>">
                  <?= $item['name'] ?>
                </label>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <button class="form__btn btn next_quiz-btn" type="button">Далее</button>
    </div>

    <div style="display: none" class="form__step step2">
      <div class="form__content">
        <h2 class="form__title top-title">
          Купить лиды
        </h2>
        <p class="form__subtitle top-subtitle">
          Пройдите регистрацию в личном кабинете для получения доступа к покупке лидов
        </p>

        <div class="form__info">Лиды из какого региона вы хотите купить?</div>

        <div class="form-filters-select filters-select">
          <select class="inp1 chosen-select partRegion" name="region" id="">
            <option value="Россия">Россия</option>
            <?php foreach ($regions as $k => $v) : ?>
              <option value="<?= $v['name_with_type'] ?>"><?= $v['name_with_type'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <button class="form__btn btn next_quiz-btn" type="button">Далее</button>
    </div>

    <div style="display: none" class="form__step step3">
      <div class="form__content">
        <h2 class="form__title top-title">
          Купить лиды
        </h2>
        <p class="form__subtitle top-subtitle">
          Пройдите регистрацию в личном кабинете для получения доступа к покупке лидов
        </p>

        <div class="form__info">Какой объем лидов вам комфортно обрабатывать за месяц?</div>


        <input id="in10" type="radio" checked name="comments[lead_day]" value="до 50 шт" class="form__radio" />
        <label for="in10" class="form__label-radio">до 50 шт</label>

        <input id="in11" type="radio" name="comments[lead_day]" value="от 50 шт до 100 шт" class="form__radio" />
        <label for="in11" class="form__label-radio">от 50 шт до 100 шт</label>

        <input id="in12" type="radio" name="comments[lead_day]" value="более 100 шт" class="form__radio" />
        <label for="in12" class="form__label-radio">более 100 шт</label>
      </div>

      <a href="<?= Url::to(['/registr?site=lead']) ?>" class="form__btn btn next_quiz-btn">Далее</a>
    </div>

    <div style="display: none" class="form__step step4">
      <div class="form__content">
        <h2 class="form__title top-title">
          Купить лиды
        </h2>
        <p class="form__subtitle top-subtitle">
          Пройдите регистрацию в личном кабинете для получения доступа к покупке лидов
        </p>
        <div class="BuyLeads__error">Введите Имя и Телефон</div>
        <div class="form__info">Укажите ФИО и телефон для регистрации в проекте</div>
        <input id="in13" type="text" name="name" required placeholder="ФИО" class="form__input-text fio__register" />
        <input id="in14" type="tel" name="phone" required placeholder="Телефон" class="form__input-text phone__register" />
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

        <div class="form__info">Введите код, полученный на номер телефона <span class="number__inner"></span> <a style="cursor: pointer" class="form__info-link linkonbackstap">(изменить)</a>
        </div>

        <div class="BuyLeads__error"></div>

        <div class="LIN_C_medle_С">
          <input form="codereset" class="LIN2_F_U_P_C code__input" required placeholder="Код" type="text" name="code" id="code-22">
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

    <section class="BL__assurance">
      <h2 class="BL__assurance-title title">
        Гарантии качества лидов
      </h2>
      <p class="BL__assurance-subtitle subtitle">
        Три главных отличия наших лидов от других
      </p>
      <div class="BL__assurance-inner">
        <div class="BL__assurance-item">
          <div class="BL__assurance-content">
            <p class="BL__assurance-info">
              Ручная модерация
            </p>
            <p class="BL__assurance-text">
              Вы можете заказать дополнительный пакет, в котором каждое входящее обращение в нашу систему
              тщательно обрабатывается
              и фильтруется нашим call-центром по высшим стандартам качества
            </p>
          </div>
        </div>

        <div class="BL__assurance-item">
          <div class="BL__assurance-content BL__assurance-content--2">
            <p class="BL__assurance-info">
              Полная отбраковка
            </p>
            <p class="BL__assurance-text">
              Вы не платите за некорректные номера; за неподтвержденные заявки; за недозвоны.
              Некачественные лиды проходят процесс
              отбраковки и бесплатно заменяются на полноценные заявки
            </p>
          </div>
        </div>

        <div class="BL__assurance-item">
          <div class="BL__assurance-content BL__assurance-content--3">
            <p class="BL__assurance-info">
              Честная оплата
            </p>
            <p class="BL__assurance-text">
              Вы оплачиваете только валидные и целевые заявки, которые заинтересованы в вашей услуге. Тем
              самым вы получаете «живых»
              клиентов и легко увеличиваете свою прибыль
            </p>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>