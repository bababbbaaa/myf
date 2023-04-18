<?php


use yii\helpers\Html;
use yii\helpers\Url;

$js = <<< JS

// иконка показать пароль
$('.registr__password-control').on('click', function () {
  if ($('#password-input').attr('type') == 'password') {
    $(this).addClass('view');
    $('#password-input').attr('type', 'text');
  } else {
    $(this).removeClass('view');
    $('#password-input').attr('type', 'password');
  }
  return false;
});

//вход и регистрация
var timeoutSms = null;
timeoutClick = null;
$('.btn-registration').on('click', function () {
  var fio = $('#username').val(),
    tel = $('#userphone').val(),
    _Seconds = 60,
    timer,
    pass = false;
  if (timeoutClick === null) {
    timeoutClick = setTimeout(function () {
      $.ajax({
        url: '/site/check-phone-exist',
        type: 'POST',
        data: { phone: tel},
        dataType: 'JSON'
      }).done(function (rsp) {
        console.log(rsp);
        if (rsp.exist) {
          pass = false;
          $('.registr__error').text('Пользователь с таким номером уже существует.').fadeIn(300);
        } else {
          $('.registr__error').text(rsp.message).fadeIn(300);
          pass = true;
        }
        timeoutClick = null;
        if (pass) {
          $('.numertimerinsendcode2').text(_Seconds);
          $('.linkonbackstap').hide();
          clearInterval(timer);
          $('.sendcodeagainnow').fadeOut(100, function () {
            $('.sendcodeagain').fadeIn(100);
          });
          if (fio.length > 2 && tel !== '') {
            $('.R_C_phone').text(tel);
            $('.step4').fadeOut(300, function () {
              $('.step5').fadeIn(300).css("display", "flex");
            });
            timer = setInterval(function () {
              if (_Seconds > 0) {
                $('.numertimerinsendcode').text(--_Seconds);
              } else {
                $('.sendcodeagain').fadeOut(100, function () {
                  $('.sendcodeagainnow').fadeIn(100);
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

$('.btn-registration2').on('click', function () {
  var code = $('input[name="code_r"]').val(),
    errorBlock = $('.message__error');

  if (code.length > 1) {
    $.ajax({
      url: '/site/code-confirm',
      type: 'POST',
      data: { code: code },
      dataType: 'JSON'
    }).done(function (response) {
      if (response.status === 'success') {
        var fio = $('#username').val(),
          tel = $('#userphone').val(),
        email = $('#useremail').val();
        errorBlock.hide();
        $.ajax({
          url: '/site/confirm-signup',
          type: 'POST',
          data: { phone: tel, fio: fio, code: code, client: 1, email: email},
          dataType: 'JSON'
        }).done(function (rsp) {
          if (rsp.status === 'error') {
            $('.message__error').text(rsp.message);
            errorBlock.show();
          } else
            errorBlock.hide();
        });
      } else {
        $('.message__error').text(response.message);
        errorBlock.show();
      }
    });
  }
});

$('.btn-login-user').on('click', function () {
  var phone = $('.registr__input[name="mml"]').val(),
    password = $('.registr__input[name="pass"]').val(),
    err = $('.registr__error');
  if (phone.length < 15 || password.length < 8) {
    err.text('Необходимо указать телефон и пароль');
    err.show(300);
  } else {
    err.hide(300);
    $.ajax({
      url: '/site/popup-login',
      type: 'POST',
      data: { phone: phone, password: password },
      dataType: 'JSON'
    }).done(function (rsp) {
      $('.registr__error').text(rsp.message).fadeIn(300);
    });
  }
});

$('.btn-LIN2').on('click', function () {
  var phone = $('.registr__input[name="phonepb"]').val();
  if (phone.length === 15) {
    $.ajax({
      url: '/site/restore-password',
      type: 'POST',
      data: { phone: phone },
      dataType: 'JSON'
    }).done(function (rsp) {
      if (rsp.status === 'success') {
        $('.step2').fadeOut(1, function () {
          $('.step3').fadeIn(1).css("display", "flex");
        });
        $('.restore-sms-errors').text('');
      } else {
        $('.restore-sms-errors').text(rsp.message);
      }
    });
  }
});

$('.confirm-reset-password-btn').on('click', function () {
  var
    code = $('.registr__input[name="code-2"]').val(),
    phone = $('.registr__input[name="phonepb"]').val();
  if (phone.length === 15 && code.length === 6) {
    $.ajax({
      url: '/site/restore-password-login',
      type: 'POST',
      data: { phone: phone, code: code },
      dataType: 'JSON'
    }).done(function (rsp) {
      if (rsp.status === 'error')
        $('.restore-sms-errors').text(rsp.message);
    });
  }
});

$('.sendcodeagainnow').on('click', function () {
  if (timeoutSms === null) {
    var tel = $('#userphone').val(),
      errorBlock = $('.message__error'),
      rmBlock = $(this);
    $.ajax({
      url: '/site/sms-send',
      type: 'POST',
      data: { phone: tel },
      dataType: 'JSON'
    }).done(function (rsp) {
      if (rsp.status === 'error') {
        $('.message__error').text(rsp.message);
        errorBlock.show();
      } else {
        rmBlock.remove();
        errorBlock.hide();
      }
    });
  }
});

//Переход с регистрации на вход
$('.link-on-popap-log-in').on('click', function () {
  $('.step4').fadeOut(300);
  setTimeout(function () {
    $('.step1').fadeIn(300).css("display", "flex");
  }, 300);
});

//Переход со входа на регистрацию
$('.link-on-popap-reg').on('click', function () {
  $('.step1').fadeOut(300);
  setTimeout(function () {
    $('.step4').fadeIn(300).css("display", "flex");
  }, 300);
});

//Переход на восстановление пароля
$('.LIN-forgpass').on('click', function () {
  $('.step1').fadeOut(300);
  setTimeout(function () {
    $('.step2').fadeIn(300).css("display", "flex");
  }, 300);
});

//Изменение номера телефона
$('.registr__replacetel').on('click', function () {
  $('.step5').fadeOut(200);
  setTimeout(function () {
    $('.step4').fadeIn(200).css("display", "flex");
    $('#userphone').val('');
  }, 300);
});

//Переход с восстановления на вход
$('.registr__btns-link.back').on('click', function () {
  $('.step2').fadeOut(300);
  setTimeout(function () {
    $('.step1').fadeIn(300).css("display", "flex");
  }, 300);
});
JS;

$this->registerJs($js);
$this->title = "Регистрация поставщика лидов";
?>

<section class="registr">
    <div class="container">
        <div class="registr__inner">
            <div class="registr__main">
                <!-- Войдите в аккаунт -->
                <div class="registr__step step1">
                    <?= Html::beginForm('', 'post', ['id' => 'LIN']) ?>
                    <input type="hidden" value="<?= base64_decode($_SERVER['REMOTE_ADDR']) ?>" name="fragment">
                    <?= Html::endForm(); ?>

                    <h1 class="registr__title">
                        Войдите в аккаунт
                    </h1>

                    <p class="registr__subtitle">
                        Введите свои данные
                    </p>

                    <p class="registr__error">
                        Пользователь с таким телефоном не найден
                    </p>

                    <div class="registr__inputs">
                        <label class="registr__label">
                            <input form="LIN" class="registr__input" type="tel" name="mml" id="mml"
                                   placeholder="Телефон" required>
                        </label>

                        <label class="registr__label">
                            <input form="LIN" class="registr__input" id="password-input" type="password" name="pass"
                                   id="pass" placeholder="Пароль" required>
                            <a href="#" class="registr__password-control"></a>
                        </label>

                        <button class="registr__link LIN-forgpass" type="button" aria-label="Восстановление пароля">
                            Забыли пароль?
                        </button>
                    </div>

                    <div class="registr__btns">
                        <div class="registr__btns-box">
                            <p class="registr__btns-text">
                                Нет аккаунта?
                            </p>
                            <button type="button" class="registr__btns-link link-on-popap-reg" aria-label="Регистрация">
                                Зарегистрироваться
                            </button>
                        </div>
                        <button class="registr__btns-btn btn-login-user" type="button" aria-label="Вход" form="LIN">
                            <span>Войти</span>
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M10.8032 4.63666C11.0961 4.34377 11.5709 4.34377 11.8638 4.63666L17.1972 9.97C17.4901 10.2629 17.4901 10.7378 17.1972 11.0307L11.8638 16.364C11.5709 16.6569 11.0961 16.6569 10.8032 16.364C10.5103 16.0711 10.5103 15.5962 10.8032 15.3033L14.8562 11.2503H3.3335C2.91928 11.2503 2.5835 10.9145 2.5835 10.5003C2.5835 10.0861 2.91928 9.75033 3.3335 9.75033H14.8562L10.8032 5.69732C10.5103 5.40443 10.5103 4.92956 10.8032 4.63666Z"
                                      fill="white"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Востановление пароля -->
                <div class="registr__step step2">
                    <?= Html::beginForm('', 'post', ['id' => 'passback']) ?>
                    <input type="hidden" value="<?= base64_decode($_SERVER['REMOTE_ADDR']) ?>" name="fragment">
                    <?= Html::endForm(); ?>

                    <h1 class="registr__title">
                        Восстановление пароля
                    </h1>

                    <p class="registr__subtitle">
                        Введите номер телефона
                    </p>

                    <p class="registr__error restore-sms-errors"></p>

                    <div class="registr__inputs">
                        <label class="registr__label">
                            <input form="passback" class="registr__input" type="tel" name="phonepb" id="phonepb"
                                   placeholder="Телефон" required>
                        </label>
                    </div>

                    <div class="registr__btns">
                        <div class="registr__btns-box">
                            <p class="registr__btns-text">
                                Вспомнили пароль?
                            </p>
                            <button type="button" class="registr__btns-link back" aria-label="Войти">
                                Войти
                            </button>
                        </div>

                        <button class="registr__btns-btn btn-LIN2" type="button" aria-label="Отправить код"
                                form="passback">
                            <span>Отправить код</span>
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M10.8032 4.63666C11.0961 4.34377 11.5709 4.34377 11.8638 4.63666L17.1972 9.97C17.4901 10.2629 17.4901 10.7378 17.1972 11.0307L11.8638 16.364C11.5709 16.6569 11.0961 16.6569 10.8032 16.364C10.5103 16.0711 10.5103 15.5962 10.8032 15.3033L14.8562 11.2503H3.3335C2.91928 11.2503 2.5835 10.9145 2.5835 10.5003C2.5835 10.0861 2.91928 9.75033 3.3335 9.75033H14.8562L10.8032 5.69732C10.5103 5.40443 10.5103 4.92956 10.8032 4.63666Z"
                                      fill="white"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Востановление пароля код -->
                <div class="registr__step step3">
                    <?= Html::beginForm('', 'post', ['id' => 'codereset']) ?>
                    <input type="hidden" value="<?= base64_decode($_SERVER['REMOTE_ADDR']) ?>" name="fragment">
                    <?= Html::endForm(); ?>

                    <h1 class="registr__title">
                        Восстановление пароля
                    </h1>

                    <p class="registr__subtitle">
                        Введите код
                    </p>

                    <p class="registr__error restore-sms-errors"></p>

                    <div class="registr__inputs">
                        <div class="registr__inputs-inner">
                            <label class=" registr__label">
                                <input form="codereset" class="registr__input" type="num" name="code-2" id="code-2"
                                       placeholder="______" required maxlength="6">
                            </label>

                            <div class="registr__sendcode">
                                <p class="registr__sendcode-again">Отправить код повторно через <span
                                            class="registr__sendcode-sec numertimerinsendcode2">59</span>с
                                </p>
                                <p class="registr__sendcode-repit sendcodeagainnow2">Отправить код повторно</p>
                            </div>
                        </div>

                        <p class="registr__inputs-text">
                            Если Вы не получили код в течении 5 минут — напишите нам на почту
                            <a class="registr__link-mail" href=<?= Url::to('mailto:general@myforce.ru') ?>>
                                general@myforce.ru
                            </a>
                        </p>
                    </div>

                    <div class="registr__btns">
                        <button class="registr__btns-btn confirm-reset-password-btn" type="button"
                                aria-label="Перейти в кабинет" form="codereset">
                            <span>Перейти в кабинет</span>
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M10.8032 4.63666C11.0961 4.34377 11.5709 4.34377 11.8638 4.63666L17.1972 9.97C17.4901 10.2629 17.4901 10.7378 17.1972 11.0307L11.8638 16.364C11.5709 16.6569 11.0961 16.6569 10.8032 16.364C10.5103 16.0711 10.5103 15.5962 10.8032 15.3033L14.8562 11.2503H3.3335C2.91928 11.2503 2.5835 10.9145 2.5835 10.5003C2.5835 10.0861 2.91928 9.75033 3.3335 9.75033H14.8562L10.8032 5.69732C10.5103 5.40443 10.5103 4.92956 10.8032 4.63666Z"
                                      fill="white"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Регистрация -->
                <div class="registr__step step4">
                    <?= Html::beginForm('', 'post', ['id' => 'registtraton']) ?>
                    <input type="hidden" value="<?= base64_decode($_SERVER['REMOTE_ADDR']) ?>" name="fragment">
                    <?= Html::endForm(); ?>

                    <h1 class="registr__title">
                        Регистрация
                    </h1>

                    <p class="registr__subtitle">
                        Введите свои данные
                    </p>

                    <p class="registr__error">
                        Пользователь с таким телефоном не найден
                    </p>

                    <div class="registr__inputs">
                        <label class="registr__label">
                            <input class="registr__input" pattern="[A-z,А-я ]*" form="registtraton" id="username"
                                   type="text" name="username" placeholder="ФИО" required>
                        </label>

                        <label class="registr__label">
                            <input form="registtraton" class="registr__input" id="userphone" type="tel" name="phone"
                                   placeholder="Телефон" required>
                        </label>
                        <label class="registr__label">
                            <input form="registtraton" class="registr__input" id="useremail" type="email" name="email"
                                   placeholder="email@mail.ru">
                        </label>
                    </div>

                    <div class="registr__btns">
                        <div class="registr__btns-box">
                            <p class="registr__btns-text">
                                Есть аккаунт?
                            </p>
                            <button type="button" class="registr__btns-link link-on-popap-log-in" aria-label="Войти">
                                Войти
                            </button>
                        </div>
                        <div class="registr__btns-inner">
                            <button class="registr__btns-btn btn-registration" type="button" form="registtraton"
                                    aria-label="Зарегистрироваться">
                                <span>Зарегистрироваться</span>
                                <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M10.8032 4.63666C11.0961 4.34377 11.5709 4.34377 11.8638 4.63666L17.1972 9.97C17.4901 10.2629 17.4901 10.7378 17.1972 11.0307L11.8638 16.364C11.5709 16.6569 11.0961 16.6569 10.8032 16.364C10.5103 16.0711 10.5103 15.5962 10.8032 15.3033L14.8562 11.2503H3.3335C2.91928 11.2503 2.5835 10.9145 2.5835 10.5003C2.5835 10.0861 2.91928 9.75033 3.3335 9.75033H14.8562L10.8032 5.69732C10.5103 5.40443 10.5103 4.92956 10.8032 4.63666Z"
                                          fill="white"/>
                                </svg>
                            </button>
                            <a href=<?= Url::to(['../../policy.pdf']) ?> target="_blank" class="registr__policy">
                                Нажимая «Зарегистрироваться» Вы соглашаетесь, что ознакомлены с условиями использования
                                и политикой конфиденциальности</a>
                        </div>
                    </div>
                </div>
                <!-- Регистрация код -->
                <div class="registr__step step5">
                    <?= Html::beginForm('', 'post', ['id' => 'coderegist']) ?>
                    <input type="hidden" value="<?= base64_decode($_SERVER['REMOTE_ADDR']) ?>" name="fragment">
                    <?= Html::endForm(); ?>

                    <h1 class="registr__title">
                        Регистрация
                    </h1>

                    <p class="registr__subtitle">
                        Введите код, полученный на номер телефон <span class="registr__valuetel  R_C_phone">+7(999) 999-99-99</span>
                        <button type="button" aria-label="изменить номер" class="registr__replacetel linkonbackstap">
                            (изменить)
                        </button>
                    </p>

                    <p class="registr__error">
                        Пользователь с таким телефоном не найден
                    </p>

                    <p class="message__error"></p>

                    <div class="registr__inputs">
                        <div class="registr__inputs-inner">
                            <label class="registr__label" aria-label="Код">
                                <input form="coderegist" class="registr__input" type="text" name="code_r"
                                       placeholder="Код" id="code_r" required>
                            </label>

                            <div class="registr__sendcode">
                                <p class="registr__sendcode-again sendcodeagain">Отправить код повторно через <span
                                            class="registr__sendcode-sec numertimerinsendcode">59</span>с
                                </p>
                                <p class="registr__sendcode-repit sendcodeagainnow">Отправить код повторно</p>
                            </div>
                        </div>

                        <p class="registr__inputs-text">
                            Если Вы не получили код в течении 5 минут — напишите нам на почту
                            <a class="registr__link-mail" href=<?= Url::to('mailto:general@myforce.ru') ?>>
                                general@myforce.ru
                            </a>
                        </p>
                    </div>

                    <div class="registr__btns">
                        <button class="registr__btns-btn btn-registration2" type="button" form="coderegist"
                                aria-label="Зарегистрироваться">
                            <span>Зарегистрироваться</span>
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M10.8032 4.63666C11.0961 4.34377 11.5709 4.34377 11.8638 4.63666L17.1972 9.97C17.4901 10.2629 17.4901 10.7378 17.1972 11.0307L11.8638 16.364C11.5709 16.6569 11.0961 16.6569 10.8032 16.364C10.5103 16.0711 10.5103 15.5962 10.8032 15.3033L14.8562 11.2503H3.3335C2.91928 11.2503 2.5835 10.9145 2.5835 10.5003C2.5835 10.0861 2.91928 9.75033 3.3335 9.75033H14.8562L10.8032 5.69732C10.5103 5.40443 10.5103 4.92956 10.8032 4.63666Z"
                                      fill="white"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            <div class="registr__info">
                <h2 class="registr__info-title">
                    Один кабинет - все инструменты
                </h2>
                <p class="registr__info-subtitle">
                    Единый кабинет для всех сервисов экосистемы <span>MYFORCE</span>
                </p>

                <ul class="registr__info-list">
                    <li class="registr__info-item">
                        <h3 class="registr__info-heading registr__info-heading--blue">
                            dev.force
                        </h3>
                        <p class="registr__info-desc">
                            Разработка мобильных приложений и веб интрефейсов любой сложности!
                        </p>
                    </li>
                    <li class="registr__info-item">
                        <h3 class="registr__info-heading registr__info-heading--liteblue">
                            ADS.FORCE
                        </h3>
                        <p class="registr__info-desc">
                            Маркетологи для эффективной рекламы
                        </p>
                    </li>
                    <li class="registr__info-item">
                        <h3 class="registr__info-heading registr__info-heading--green">
                            LEAD.Force
                        </h3>
                        <p class="registr__info-desc">
                            Клиенты для вашего бизнеса
                        </p>
                    </li>
                    <!--<li class="registr__info-item">
                        <h3 class="registr__info-heading registr__info-heading--purpur">
                            SKILL.Force
                        </h3>
                        <p class="registr__info-desc">
                            Только актуальные курсы и востребованные профессии
                        </p>
                    </li>-->
                    <li class="registr__info-item">
                        <h3 class="registr__info-heading registr__info-heading--yellow">
                            MY.CONTACT
                        </h3>
                        <p class="registr__info-desc">
                            Профессиональные операторы для вашего бизнеса
                        </p>
                    </li>
                    <li class="registr__info-item">
                        <h3 class="registr__info-heading registr__info-heading--darkblue">
                            FORCE.ARBITR
                        </h3>
                        <p class="registr__info-desc">
                            Арбитражное управление и юридическая помощь
                        </p>
                    </li>
                    <li class="registr__info-item">
                        <h3 class="registr__info-heading registr__info-heading--red">
                            FEMIDA.FORCE
                        </h3>
                        <p class="registr__info-desc">
                            Успешные франшизы со стабильным доходом
                        </p>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>