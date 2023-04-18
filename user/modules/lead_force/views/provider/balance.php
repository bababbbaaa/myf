<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\helpers\Robokassa;
use yii\jui\DatePicker;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = "Баланс";

$robokassa = new Robokassa(['test' => 1, 'description' => 'Тестовая оплата', 'price' => 500, 'shp' => ['Shp_test' => 1, 'Shp_alpha' => 2]]);
$url = $robokassa->url;

$labels = [];
$budgets = [];

if (!empty($stats)) {
    foreach ($stats as $key => $item) {
        $labels[$key] = date("d.m", strtotime($item['date']));
        $budgets[$key] = $item['budget_after'];
    }
}

$duplicates = array_unique($labels);

$labels = json_encode($labels);
$budgets = json_encode($budgets);
$labelsCount = count(json_decode($labels));
$count = $labelsCount;
$jurPaymentType = false;
if (!empty($client)) {
    $requisites = $client['requisites'];
    $json = json_decode($client['requisites'], 1);
    if ($json !== null) {
        if (!empty($json['jur']))
            $jurPaymentType = true;
    }
}
$dateWeek = date('Y-m-d', time() - 3600*24*7);
$dateWeekNow = date('Y-m-d');

$js = <<<JS
    var payFizStep = 1;
    var payJurStep = 1;
    var yac = location.hash.substring(1),
        line = location.hash.substring(5);
$('.submit-pay-fiz').on('click', function(e) {
    var value = parseFloat($('[name="DonateAmount"]').val()),
        err = [],
        stopClass = 'last-pay',
        errBlock = $('.errors-block');
    e.preventDefault();
    errBlock.html('');
    if (value < 10000 || isNaN(value))
        err.push("Сумма вывода должна быть не менее 10000 рублей");
    if (!$('#check_one_pay').prop('checked'))
        err.push("Необходимо дать согласие на обработку персональных данных");
    if (err.length > 0) {
        for (var i = 0; i < err.length; i++) {
            errBlock.append('<p>'+ err[i] +'</p>');
        }
    } else {
        if ($(this).hasClass(stopClass)) {
            var data = new FormData($('.payFizForm')[0]);
            $.ajax({
                url: "get-provider-docs",
                method: "post",
                processData: false,
                contentType: false,
                data: data,
                beforeSend: function() {
                  $('.submit-pay-fiz').attr('disabled', true).html('<img src="/img/circles.svg" alt="load">').css('background-color', '#898a8a');
                },
                success: function (rspOk) {
                    if (rspOk.status === 'error') {
                        Swal.fire({
                          icon: 'error',
                          title: 'Ошибка',
                          text: rspOk.message,
                        });
                    } else {
                        $('.PopapBack').hide();
                        $('.PopapDBCWrap').remove();
                        $('.type-outcome-block').remove();
                        Swal.fire({
                          icon: 'warning',
                          title: 'Данные на модерации',
                          html: rspOk.message,
                        });
                    }
                    $('.submit-pay-fiz').attr('disabled', false).html('Продолжить').attr('style', '');
                },
                error: function (rspBad) {
                    Swal.fire({
                      icon: 'error',
                      title: 'Ошибка',
                      text: "Возникла ошибка №" + rspBad.status + ". Пожалуйста свяжитесь с тех.поддержкой",
                    }); 
                    $('.submit-pay-fiz').attr('disabled', false).html('Продолжить').attr('style', '');
                }
            });
        } else {
            if (payFizStep === 1) {
                $.ajax({
                    url: 'create-provider-files',
                    data: {value: value, type: $('.typeFiz').val()},
                    dataType: "JSON",
                    type: "POST",
                    beforeSend: function() {
                      $('.submit-pay-fiz').attr('disabled', true).html('<img src="/img/circles.svg" alt="load">').css('background-color', '#898a8a');
                    }
                }).done(function(response) {
                    if (response.status === 'success') {
                        $('.get-fiz-pay-link').attr('href', response.download);
                        $('.linkFileAssign').val(response.id);
                        $('.linkHash').val(response.hash);
                        $('.pop-fiz-step-' + payFizStep++).fadeOut(300, function() {
                            $('.submit-pay-fiz').attr('disabled', false).html('Продолжить').attr('style', '');
                            $('.pop-fiz-step-' + payFizStep).fadeIn(300);
                        });
                    } else {
                        Swal.fire({
                          icon: 'error',
                          title: 'Ошибка',
                          text: response.message,
                        });
                        $('.submit-pay-fiz').attr('disabled', false).html('Продолжить').attr('style', '');
                    }
                });
            } else {
                $('.pop-fiz-step-' + payFizStep++).fadeOut(300, function() {
                    $('.pop-fiz-step-' + payFizStep).fadeIn(300);
                });
            }
        }
    }
});

$('.back-pay-fiz').on('click', function() {
    $('.pop-fiz-step-' + payFizStep--).fadeOut(200, function() {
        $('.pop-fiz-step-' + payFizStep).fadeIn(200);
    });
});


$('.submit-pay-jur').on('click', function(e) {
    var value = parseFloat($('[name="DonateAmount2"]').val()),
        err = [],
        stopClass = 'last-pay',
        errBlock = $('.errors-block');
    e.preventDefault();
    errBlock.html('');
    if (value < 10000 || isNaN(value))
        err.push("Сумма вывода должна быть не менее 10000 рублей");
    if (!$('#check_one_pay2').prop('checked'))
        err.push("Необходимо дать согласие на обработку персональных данных");
    if (err.length > 0) {
        for (var i = 0; i < err.length; i++) {
            errBlock.append('<p>'+ err[i] +'</p>');
        }
    } else {
        if ($(this).hasClass(stopClass)) {
            var data = new FormData($('.payJurForm')[0]);
            $.ajax({
                url: "get-provider-docs",
                method: "post",
                processData: false,
                contentType: false,
                data: data,
                beforeSend: function() {
                  $('.submit-pay-jur').attr('disabled', true).html('<img src="/img/circles.svg" alt="load">').css('background-color', '#898a8a');
                },
                success: function (rspOk) {
                    $('.submit-pay-jur').attr('disabled', false).html('Продолжить').attr('style', '');
                    if (rspOk.status === 'error') {
                        Swal.fire({
                          icon: 'error',
                          title: 'Ошибка',
                          text: rspOk.message,
                        });
                    } else {
                        $('.PopapBack').hide();
                        $('.PopapDBCWrap').remove();
                        $('.type-outcome-block').remove();
                        Swal.fire({
                          icon: 'warning',
                          title: 'Данные на модерации',
                          html: rspOk.message,
                        });
                    }
                },
                error: function (rspBad) {
                    $('.submit-pay-jur').attr('disabled', false).html('Продолжить').attr('style', '');
                    Swal.fire({
                      icon: 'error',
                      title: 'Ошибка',
                      text: "Возникла ошибка №" + rspBad.status + ". Пожалуйста свяжитесь с тех.поддержкой",
                    });
                }
            });
        } else {
            if (payJurStep === 1) {
                $.ajax({
                    url: 'create-provider-files',
                    data: {value: value, type: $('.typeJur').val()},
                    dataType: "JSON",
                    type: "POST",
                    beforeSend: function() {
                      $('.submit-pay-jur').attr('disabled', true).html('<img src="/img/circles.svg" alt="load">').css('background-color', '#898a8a');
                    }
                }).done(function(response) {
                    if (response.status === 'success') {
                        $('.get-jur-pay-link').attr('href', response.download_report);
                        $('.get-jur-pay-link2').attr('href', response.download_outcome);
                        $('.linkFileAssign').val(response.id);
                        $('.linkHash1').val(response.hash[0]);
                        $('.linkHash2').val(response.hash[1]);
                        $('.pop-jur-step-' + payJurStep++).fadeOut(300, function() {
                            $('.submit-pay-jur').attr('disabled', false).html('Продолжить').attr('style', '');
                            $('.pop-jur-step-' + payJurStep).fadeIn(300);
                        });
                    } else {
                        Swal.fire({
                          icon: 'error',
                          title: 'Ошибка',
                          text: response.message,
                        });
                        $('.submit-pay-jur').attr('disabled', false).html('Продолжить').attr('style', '');
                    }
                });
            } else {
                $('.pop-jur-step-' + payJurStep++).fadeOut(300, function() {
                    $('.pop-jur-step-' + payJurStep).fadeIn(300);
                });
            }
        }
    }
});

$('.back-pay-jur').on('click', function() {
    $('.pop-jur-step-' + payJurStep--).fadeOut(200, function() {
        $('.pop-jur-step-' + payJurStep).fadeIn(200);
    });
});

var ctx = document.getElementById('myChart').getContext('2d');
console.log($count);
if ($count >= 2){
    var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: $labels,
        datasets: [{
            label: 'Баланс',
            data: $budgets,
            borderColor: [
                'rgba(255, 99, 132, 1)',
            ],
            cubicInterpolationMode: 'monotone',
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: false
            }
        }
    }
});
} else {
    $('.Page5-Balance_stat-ttl').html('<span style="font-size:14px; color:#9e9e9e; ">Недостаточно данных для отображения статистики.</span>');
}


$('.Balance_chooseP').on('submit', function(e) {
     var pages = location.hash;
    e.preventDefault();
  $.pjax.reload({
      container: '#pjaxContainer',
      url: "balance",
      type: "GET",
      data: $('.Balance_chooseP').serialize(),
    }).done(function() {
      location.hash = pages;
    });
});
$('.reset__btns').on('click', function() {
    var pages = location.hash.substring(1);
    setTimeout(function() {
        location.href = 'balance#' + pages;
    }, 200)
});

$('.Balance_chooseP2').on('submit', function(e) {
     var pages = location.hash.substring(1);
    e.preventDefault();
  $.pjax.reload({
      container: '#countPjax',
      url: "balance",
      type: "GET",
      data: $('.Balance_chooseP2').serialize(),
    }).done(function() {
      location.hash = pages;
    });
});

$('.Balance_chooseP3').on('submit', function(e) {
     var pages = location.hash.substring(1);
    e.preventDefault();
  $.pjax.reload({
      container: '#actsContainer',
      url: "balance",
      type: "GET",
      data: $('.Balance_chooseP3').serialize(),
    }).done(function() {
      location.hash = pages;
    });
});

$('.Balance_chooseP6').on('submit', function(e) {
    var pages = location.hash.substring(1);
    e.preventDefault();
    $.pjax.reload({
      container: '#uplContainer',
      url: "balance",
      type: "GET",
      data: $('.Balance_chooseP6').serialize(),
    }).done(function() {
      location.hash = pages;
    });
});

if(yac.length == 0){
    $('.ChangePage-Item-t[href="#page1"').addClass('CIT-active');
    $('section[id="page1"').addClass('active');
    $('.ChangePage-Item-line1').addClass('CIL-active');
} else {
    $('.ChangePage-Item-t').removeClass('CIT-active');
    $('.ChangePage-Item-t[href="#'+yac+'"').addClass('active');
    $('.ChangePage-Item-line').removeClass('CIL-active');
    $('.ChangePage-Item-line'+line).addClass('CIL-active');
    $('.Page-Balance').removeClass('active');
    $('section[id="'+yac+'"').addClass('active');
}

$('.ChangePage-Item-t').on('click', function() {
    $('.ChangePage-Item-t').removeClass('CIT-active');
    $(this).addClass('CIT-active');
    var targets = $(this).attr('href').substring(1);
    var tar = $(this).attr('href').substring(5);
    $('.ChangePage-Item-line').removeClass('CIL-active');
    $('.ChangePage-Item-line'+tar).addClass('CIL-active');
    $('.Page-Balance').removeClass('active');
    $('section[id="'+targets+'"').addClass('active');
});
$('.uploadForm').on('submit', function(e) {
    e.preventDefault();
    var data = new FormData($('.uploadForm')[0]);
    var pages = location.hash.substring(1);
    $.ajax({
        url: "get-provider-docs",
        method: "post",
        processData: false,
        contentType: false,
        data: data,
        beforeSend: function() {
          $('.submit-pay-jur').attr('disabled', true).html('<img src="/img/circles.svg" alt="load">').css('background-color', '#898a8a');
        },
        success: function (rspOk) {
            $('.submit-pay-jur').attr('disabled', false).html('Продолжить').attr('style', '');
            if (rspOk.status === 'error') {
                Swal.fire({
                  icon: 'error',
                  title: 'Ошибка',
                  text: rspOk.message,
                });
            } else {
                $.pjax.reload({
                  container: '#uplContainer',
                  url: "balance",
                  type: "GET",
                  data: $('.Balance_chooseP6').serialize(),
                }).done(function() {
                    location.hash = pages;
                });
                Swal.fire({
                  icon: 'warning',
                  title: 'Данные на модерации',
                  html: rspOk.message,
                });
            }
        },
        error: function (rspBad) {
            $('.submit-pay-jur').attr('disabled', false).html('Продолжить').attr('style', '');
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: "Возникла ошибка №" + rspBad.status + ". Пожалуйста свяжитесь с тех.поддержкой",
            });
        }
    }).done(function() {
      location.hash = pages;
    });
});
$('.input_file-class').on('change', function() {
    var id = $(this).attr('id');
    $('.flex__inpfile-label[for="'+ id +'"]').text('Загружено').css('color', '#278940');
});
    
JS;
$this->registerJsFile(Url::to(['/js/chart.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);

?>
<style>
    .inner-response-popup-text {
        text-align: justify;
        padding: 0 20px;
        font-size: 14px;
    }

    .inner-response-popup-text p {
        margin-bottom: 10px;
    }

    .errors-block {
        color: red;
        margin-bottom: 10px;
        font-size: 12px;
        text-align: center;
    }

    .pops-unseen {
        display: none;
    }

    .btn-as-link {
        border: none;
        color: black;
        background: transparent;
    }

    .btn-as-link:hover {
        text-decoration: underline;
    }
</style>
<section class="rightInfo">
    <div class="balance">
        <div class="bcr">
            <ul class="bcr__list">
                <li class="bcr__item">
          <span class="bcr__link">
            Баланс
          </span>
                </li>

                <li class="bcr__item">
          <span class="bcr__span">
              Вывод средств
          </span>
                </li>
            </ul>
        </div>

        <div class="title_row">
            <h1 class="Bal-ttl title-main">Баланс</h1>
            <a href="<?= Url::to(['usermanualmain', '#' => 'balance']) ?>">Как вывести средства</a>
        </div>

        <article class="MainInfo">
            <nav class="ChangePageBalance df">
                <div class="ChangePage-Item df jcsb aic">
                    <a href="#page1" class="HText ChangePage-Item-t ChangePage-Item-t1 uscp CIT-active">Вывод
                        средств</a>
                    <div class="ChangePage-Item-line ChangePage-Item-line1 CIL-active"></div>
                </div>
                <div class="ChangePage-Item df jcsb aic">
                    <a href="#page2" class="HText ChangePage-Item-t ChangePage-Item-t2 uscp">История</a>
                    <div class="ChangePage-Item-line ChangePage-Item-line2"></div>
                </div>
                <div class="ChangePage-Item df jcsb aic">
                    <a href="#page3" class="HText ChangePage-Item-t ChangePage-Item-t3 uscp">Счета</a>
                    <div class="ChangePage-Item-line ChangePage-Item-line3"></div>
                </div>
                <div class="ChangePage-Item df jcsb aic">
                    <a href="#page4" class="HText ChangePage-Item-t ChangePage-Item-t4 uscp">Отчеты</a>
                    <div class="ChangePage-Item-line ChangePage-Item-line4"></div>
                </div>
                <div class="ChangePage-Item df jcsb aic">
                    <a href="#page5" class="HText ChangePage-Item-t ChangePage-Item-t5 uscp">Аналитика</a>
                    <div class="ChangePage-Item-line ChangePage-Item-line5"></div>
                </div>
                <div class="ChangePage-Item df jcsb aic">
                    <a href="#page6" class="HText ChangePage-Item-t ChangePage-Item-t6 uscp">Необходимо загрузить</a>
                    <div class="ChangePage-Item-line ChangePage-Item-line6"></div>
                </div>
            </nav>

            <section id="page1" class="Page-Balance Page1-Balance active">
                <div class="Page1-B_info df fdc">
                    <div class="mass mass--cab" style="margin-bottom: 35px">
                        <div class="mass__content mass__content--cab">
                            <p class="mass__text" style="margin-bottom: 0">
                                Для получения средств вам необходимо подписать <b>Счет и Отчет агента</b>. После выбора
                                способа получения и ввода суммы, вы сможете ознакомиться с документами и загрузить
                                подписанные варианты. После этого документы будут проверены модератором в течение 3
                                дней, а средства переведены на указанные реквизиты в течение 7 дней
                            </p>
                            <span class="mass__close">
                            <svg width="11" height="11" viewBox="0 0 11 11" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.0732231 10.0585 -0.0732231 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.0732233 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.0732231 0.987437 -0.0732231 1.28033 0.21967L5.28553 4.22487Z"
                                    fill="#FFA800"/>
                            </svg>
                        </span>
                        </div>
                    </div>
                    <h2 class="Page1-B_info-t">Текущий баланс</h2>
                    <div class="Page1-B_info-balance df aic"
                         style="max-width: unset; padding: 0; margin-bottom: 52px; background: unset">
                        <div style="padding: 24px 28px;   width: auto;   background: #f0f1f8;   border-radius: 12px;    ">
                            <p class="Page1-nubBal">
                                <?= number_format($real_user->budget, 1, ',', ' ') ?><span
                                        class="Page1-numbalval">₽</span>
                            </p>
                        </div>
                    </div>
                    <div class="type-outcome-block">
                        <div class="mass mass--cab" style="margin-bottom: 35px">
                            <div class="mass__content mass__content--cab">
                                <p class="mass__text" style="margin-bottom: 0">При получении средств на банковскую карту
                                    будет удержана комиссия, предусмотренная вашим банком</p>
                                <span class="mass__close">
                            <svg width="11" height="11" viewBox="0 0 11 11" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.0732231 10.0585 -0.0732231 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.0732233 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.0732231 0.987437 -0.0732231 1.28033 0.21967L5.28553 4.22487Z"
                                    fill="#FFA800"/>
                            </svg>
                        </span>
                            </div>
                        </div>
                        <div class="mass mass--cab" style="margin-bottom: 35px">
                            <div class="mass__content mass__content--cab">
                                <p class="mass__text" style="margin-bottom: 0">В данный момент вывод средств доступен только через тех. поддержку или через менеджера проекта.</p>
                                <span class="mass__close">
                            <svg width="11" height="11" viewBox="0 0 11 11" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                              <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.0732231 10.0585 -0.0732231 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.0732233 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.0732231 0.987437 -0.0732231 1.28033 0.21967L5.28553 4.22487Z"
                                    fill="#FFA800"/>
                            </svg>
                        </span>
                            </div>
                        </div>

                        <?php if(false): ?>
                            <h2 class="Page1-B_info-t">Выберите способ получения</h2>
                            <div class="Page1-Donate-choose df aic">
                                <div class="Page1-Donate_BC uscp">
                                    <h3 class="Page1-Donate-t">Банковская карта</h3>
                                </div>
                                <?php if ($jurPaymentType): ?>
                                    <div class="Page1-Donate_CL uscp">
                                        <h3 class="Page1-Donate-t">Оплата на счет</h3>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="PopapBack"></div>
                <div class="PopapDBCWrap">
                    <div class="PopapDBC">
                        <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
                        <div class="PopapDBC-Cont df fdc aic">
                            <?= Html::beginForm('', 'post', [
                                'class' => 'PopapDBC_Form payFizForm',
                                'accept-charset' => 'multipart/form-data',
                            ]) ?>
                            <div class="PopapDBC-Form df fdc pop-fiz-step-1 pops-unseen" style="display: block">
                                <h2 class="PopapDBC-ttl" style="font-size: 32px; line-height: 40px">Получить переводом
                                    на банковскую карту</h2>
                                <p class="PopapDBC-t2 HText">Сумма вывода</p>
                                <input class="InputDonateAmount" required
                                       placeholder="Минимальная сумма вывода 10 000₽" type="number" min="10000"
                                       name="DonateAmount">
                                <div class="CheckboxDonateandlink df aic" style="margin-bottom: 15px">
                                    <input checked class="CheckboxDonate" required type="checkbox" name=""
                                           id="check_one_pay">
                                    <p class="CheckboxDonatelink">Подтверждаю согласие с <a
                                                href="<?= Url::to(['policy']) ?>">условиями обработки данных</a></p>
                                </div>
                                <div class="errors-block"></div>
                                <div style="margin-bottom: 10px; color: #9e9e9e; font-size: 12px; text-align: justify">
                                    Нажимая на кнопку "Продолжить", для вас будут сформированы документы для скачивания,
                                    которые необходимо подписать и загрузить в течение 5 дней. Формирование документов
                                    доступно не чаще, чем 2 раза в месяц
                                </div>
                                <div style="display: flex; align-items: center; flex-direction: column; justify-content: center">
                                    <button class="PopapDBC_Form-BTN BText df jcc aic uscp submit-pay-fiz"
                                            type="submit">Продолжить
                                    </button>
                                    <button class="PopapDBC_Form-Reset BText df jcc aic uscp" type="reset">Отмена
                                    </button>
                                </div>
                            </div>
                            <div class="PopapDBC-Form df fdc pop-fiz-step-2 pops-unseen">
                                <h2 class="PopapDBC-ttl" style="font-size: 32px; line-height: 40px; margin-bottom: 0px">
                                    Подпишите отчет</h2>
                                <div style="font-size: 18px;line-height: 24px; font-weight: 500; color:#2b3048; text-align: center; max-width: 300px; margin: 20px auto;">
                                    Для получения средств вам необходимо подписать Отчет
                                </div>
                                <p class="li__balance-center">1. Скачайте отчет</p>
                                <p class="li__balance-center">2. Подпишите</p>
                                <p class="li__balance-center">3. Загрузите подписанные документы</p>
                                <p class="li__balance-center">4. Получите средства</p>
                                <div style=" text-align: center; margin: 10px auto 15px">
                                    <a href="#" class="get-fiz-pay-link">скачать отчет</a>
                                </div>
                                <div style="display: flex; align-items: center; flex-direction: column; justify-content: center">
                                    <button class="PopapDBC_Form-BTN BText df jcc aic uscp submit-pay-fiz"
                                            type="submit">Продолжить
                                    </button>
                                    <button type="button" class="btn-as-link BText df jcc aic uscp back-pay-fiz">назад
                                    </button>
                                </div>
                            </div>
                            <div class="PopapDBC-Form df fdc pop-fiz-step-3 pops-unseen">
                                <h2 class="PopapDBC-ttl" style="font-size: 32px; line-height: 40px; margin-bottom: 0px">
                                    Загрузите отчет</h2>
                                <div style="font-size: 18px;line-height: 24px; font-weight: 500; color:#2b3048; text-align: center; max-width: 300px; margin: 20px auto;">
                                    Для получения средств вам необходимо:
                                </div>

                                <p class="li__balance-center">1. Загрузите подписанный документ</p>
                                <p class="li__balance-center">2. Ожидайте получения средств</p>
                                <!--                                <div style=" text-align: center; margin: 10px auto 15px">-->
                                <!--                                    <input name="provider_report" accept=".jpeg, .png, .pdf" type="file" class="form-control" placeholder="Загрузить документ">-->
                                <!--                                </div>-->
                                <div class="flex__inpfile">
                                    <input style="display: none" id="input_file1" name="provider_report"
                                           accept=".jpeg, .png, .pdf" type="file" class="form-control input_file-class"
                                           placeholder="Загрузить документ">
                                    <p class="flex__inpfile-p">Отчет</p>
                                    <label for="input_file1" class="flex__inpfile-label">Загрузить</label>
                                </div>

                                <div style="display: flex; align-items: center; flex-direction: column; justify-content: center">
                                    <button class="PopapDBC_Form-BTN BText df jcc aic uscp submit-pay-fiz last-pay"
                                            type="submit">Продолжить
                                    </button>
                                    <button type="button" class="btn-as-link BText df jcc aic uscp back-pay-fiz">назад
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="type" class="typeFiz" value="fiz">
                            <input type="hidden" name="link" class="linkFileAssign" value="">
                            <input type="hidden" name="hash[]" class="linkHash" value="">
                            <?= Html::endForm(); ?>
                        </div>
                    </div>
                    <div class="PopapDCD">
                        <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
                        <div class="PopapDBC-Cont df fdc aic">
                            <?= Html::beginForm('', 'post', [
                                'class' => 'PopapDBC_Form payJurForm',
                                'accept-charset' => 'multipart/form-data',
                            ]) ?>
                            <div class="PopapDBC-Form df fdc pop-jur-step-1 pops-unseen" style="display: block">
                                <h2 class="PopapDBC-ttl" style="font-size: 32px; line-height: 40px">Получить переводом
                                    на банковскую карту</h2>
                                <p class="PopapDBC-t2 HText">Сумма вывода</p>
                                <input class="InputDonateAmount" required
                                       placeholder="Минимальная сумма вывода 10 000₽" type="number" min="10000"
                                       name="DonateAmount2">
                                <div class="CheckboxDonateandlink df aic" style="margin-bottom: 15px">
                                    <input checked class="CheckboxDonate" required type="checkbox" name=""
                                           id="check_one_pay2">
                                    <p class="CheckboxDonatelink">Подтверждаю согласие с <a
                                                href="<?= Url::to(['policy']) ?>">условиями обработки данных</a></p>
                                </div>
                                <div class="errors-block"></div>
                                <div style="margin-bottom: 10px; color: #9e9e9e; font-size: 12px; text-align: justify">
                                    Нажимая на кнопку "Продолжить", для вас будут сформированы документы для скачивания,
                                    которые необходимо подписать и загрузить в течение 5 дней. Формирование документов
                                    доступно не чаще, чем 2 раза в месяц
                                </div>
                                <div style="display: flex; align-items: center; flex-direction: column; justify-content: center">
                                    <button class="PopapDBC_Form-BTN BText df jcc aic uscp submit-pay-jur"
                                            type="submit">Продолжить
                                    </button>
                                    <button class="PopapDBC_Form-Reset BText df jcc aic uscp" type="reset">Отмена
                                    </button>
                                </div>
                            </div>
                            <div class="PopapDBC-Form df fdc pop-jur-step-2 pops-unseen">
                                <h2 class="PopapDBC-ttl" style="font-size: 32px; line-height: 40px; margin-bottom: 0px">
                                    Подпишите отчет и счет</h2>
                                <div style="font-size: 18px;line-height: 24px; font-weight: 500; color:#2b3048; text-align: center; max-width: 300px; margin: 20px auto;">
                                    Для получения средств вам необходимо:
                                </div>
                                <p class="li__balance-center">1. Скачайте отчет и счет</p>
                                <p class="li__balance-center">2. Подпишите</p>
                                <div style=" text-align: center; margin: 10px auto 0">
                                    <a href="#" class="get-jur-pay-link">скачать отчет</a>
                                </div>
                                <div style=" text-align: center; margin: 0 auto 15px">
                                    <a href="#" class="get-jur-pay-link2">скачать счет</a>
                                </div>
                                <div style="display: flex; align-items: center; flex-direction: column; justify-content: center">
                                    <button class="PopapDBC_Form-BTN BText df jcc aic uscp submit-pay-jur"
                                            type="submit">Продолжить
                                    </button>
                                    <button type="button" class="btn-as-link BText df jcc aic uscp back-pay-jur">назад
                                    </button>
                                </div>
                            </div>
                            <div class="PopapDBC-Form df fdc pop-jur-step-3 pops-unseen">
                                <h2 class="PopapDBC-ttl" style="font-size: 32px; line-height: 40px; margin-bottom: 0px">
                                    Загрузите отчет и счет</h2>
                                <div style="font-size: 18px;line-height: 24px; font-weight: 500; color:#2b3048; text-align: center; max-width: 300px; margin: 20px auto;">
                                    Для получения средств вам необходимо:
                                </div>
                                <p class="li__balance-center">1. Загрузите подписанный документ</p>
                                <p class="li__balance-center">2. Ожидайте получения средств</p>
                                <!--                                <div style=" text-align: center; margin: 10px auto 0px">-->
                                <!--                                    <input name="provider_report" accept=".jpeg, .png, .pdf" type="file" class="form-control" placeholder="Загрузить документ">-->
                                <!--                                </div>-->
                                <div class="flex__inpfile">
                                    <input style="display: none" id="input_file2" name="provider_report"
                                           accept=".jpeg, .png, .pdf" type="file" class="form-control input_file-class"
                                           placeholder="Загрузить документ">
                                    <p class="flex__inpfile-p">Отчет</p>
                                    <label for="input_file2" class="flex__inpfile-label">Загрузить</label>
                                </div>
                                <!--                                <div style=" text-align: center; margin: 10px auto 15px">-->
                                <!--                                    <input name="provider_outcome" accept=".jpeg, .png, .pdf" type="file" class="form-control" placeholder="Загрузить документ">-->
                                <!--                                </div>-->
                                <div class="flex__inpfile">
                                    <input style="display: none" id="input_file3" name="provider_outcome"
                                           accept=".jpeg, .png, .pdf" type="file" class="form-control input_file-class"
                                           placeholder="Загрузить документ">
                                    <p class="flex__inpfile-p">Счет</p>
                                    <label for="input_file3" class="flex__inpfile-label">Загрузить</label>
                                </div>
                                <div style="display: flex; align-items: center; flex-direction: column; justify-content: center">
                                    <button class="PopapDBC_Form-BTN BText df jcc aic uscp submit-pay-jur last-pay"
                                            type="submit">Продолжить
                                    </button>
                                    <button type="button" class="btn-as-link BText df jcc aic uscp back-pay-jur">назад
                                    </button>
                                </div>
                            </div>
                            <input type="hidden" name="type" class="typeJur" value="jur">
                            <input type="hidden" name="link" class="linkFileAssign" value="">
                            <input type="hidden" name="hash[]" class="linkHash1" value="">
                            <input type="hidden" name="hash[]" class="linkHash2" value="">
                            <?= Html::endForm(); ?>
                        </div>
                        <div class="PopapDCD2">
                            <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
                            <div class="PopapDBC-Cont df fdc aic">
                                <img class="PopapDCD2img" src="<?= Url::to(['/img/success.svg']) ?>" alt="Галочка">
                                <h2 class="PopapDCD2-ttl">Успешно!</h2>
                                <h3 class="PopapDCD2-subttl">По вашим реквизитам выставленн счет и отправлен вам на
                                    почту</h3>
                                <p class="PopapDCD2_Form-BTN BText df jcc aic uscp">Продолжить</p>
                            </div>
                        </div>
                        <div class="PopapDCD-Error">
                            <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
                            <div class="PopapDBC-Cont df fdc aic">
                                <img class="PopapDCD2img" src="<?= Url::to(['/img/danger.svg']) ?>" alt="Галочка">
                                <h2 class="PopapDCD2-ttl">Заполните профиль</h2>
                                <h3 class="PopapDCD2-subttl">Для оплаты по счету вам необходимо заполнить свои реквизиты
                                    в
                                    профиле</h3>
                                <p class="PopapDCD-Error_Form-BTN BText df jcc aic uscp">Перейти к заполнению</p>
                                <p class="PopapDCD-Error-Reset BText df jcc aic uscp">Отмена</p>
                            </div>
                        </div>
                    </div>
            </section>

            <section id="page2" class="Page-Balance Page2-Balance">
                <div class="Page2-Balance_chooseP df fdc">
                    <h3 class="Page2-Balance_chooseP-ttl">Выбрать период</h3>

                    <?= Html::beginForm('', 'GET', ['class' => 'Balance_chooseP']) ?>
                    <div class="Page2-Balance_chooseP-P df">
                        <div class="df aic">
                            <p class="Page2-Balance_chooseP-P_from-to HText">с</p>
                            <?php echo DatePicker::widget([
                                'name' => 'filters[first]',
                                'value' => $_GET['filters']['first'],
                                'options' => ['class' => 'inpdate', 'placeholder' => $dateWeek],
                                //'language' => 'ru',
                                'dateFormat' => 'yyyy-MM-dd',
                            ]); ?>
                        </div>
                        <div class="df aic ChooseP-gr2">
                            <p class="Page2-Balance_chooseP-P_from-to HText">по</p>
                            <?php echo DatePicker::widget([
                                'name' => 'filters[last]',
                                'value' => $_GET['filters']['last'],
                                'options' => ['class' => 'inpdate2', 'placeholder' => $dateWeekNow],
                                //'language' => 'ru',
                                'dateFormat' => 'yyyy-MM-dd',
                            ]); ?>
                        </div>
                        <button type="submit" class="uscp Page2-Balance_chooseP-BTN df aic jcc">
                            Показать
                        </button>
                        <button type="button" class="reset__btns">&times;</button>

                    </div>
                    <?= Html::endForm(); ?>
                </div>
                <?php Pjax::begin(['id' => 'pjaxContainer']) ?>
                <div class="Page2-Balance_Rows df fdc">
                    <?php if (!empty($balance)): ?>
                        <?php foreach ($balance as $item): ?>
                            <div class="Page2-Balance_Row df jcsb">
                                <div class="Page2-Balance_Row_L df fdc">
                                    <p class="HText Page2-Balance_Row-name"><?= $item['text'] ?></p>
                                    <div class="Page2-Balance_Row-subrow df">
                                        <p class="Page2-Balance_Row-date MText"><?= date("d.m.Y", strtotime($item['date'])) ?></p>
                                        <p class="Page2-Balance_Row-time MText"><?= date("H:i", strtotime($item['date'])) ?></p>
                                    </div>
                                </div>
                                <h2 class="Page2-Balance_Row-money"></h2>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="Page2-Balance_Row df jcsb" style="color: #9e9e9e">Платежи не найдены</div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($pages)): ?>
                    <?php echo LinkPager::widget([
                        'pagination' => $pages,
                    ]); ?>
                <?php endif; ?>
                <?php Pjax::end() ?>
            </section>

            <section id="page3" class="Page-Balance Page3-Balance">
                <div class="Page2-Balance_chooseP df fdc">
                    <h3 class="Page2-Balance_chooseP-ttl">Выбрать период</h3>
                    <?= Html::beginForm('', 'get', ['class' => 'Balance_chooseP2']) ?>
                    <div class="Page2-Balance_chooseP-P df">
                        <div class="df aic">
                            <p class="Page2-Balance_chooseP-P_from-to HText">с</p>
                            <?php echo DatePicker::widget([
                                'name' => 'filt[first]',
                                'value' => $_GET['filt']['first'],
                                'options' => ['class' => 'inpdate', 'placeholder' => $dateWeek],
                                //'language' => 'ru',
                                'dateFormat' => 'yyyy-MM-dd',
                            ]); ?>
                        </div>
                        <div class="df aic ChooseP-gr2">
                            <p class="Page2-Balance_chooseP-P_from-to HText">по</p>
                            <?php echo DatePicker::widget([
                                'name' => 'filt[last]',
                                'value' => $_GET['filt']['last'],
                                'options' => ['class' => 'inpdate2', 'placeholder' => $dateWeekNow],
                                //'language' => 'ru',
                                'dateFormat' => 'yyyy-MM-dd',
                            ]); ?>
                        </div>
                        <button type="submit" class="uscp Page2-Balance_chooseP-BTN2 df aic jcc">
                            Показать
                        </button>
                        <button type="button" class="reset__btns">&times;</button>
                    </div>
                    <?= Html::endForm(); ?>
                </div>
                <div class="Page2-Balance_Rows df fdc">
                    <?php Pjax::begin(['id' => 'countPjax']) ?>
                    <?php if (!empty($bills)): ?>
                        <?php foreach ($bills as $item): ?>
                            <div class="Page2-Balance_Row df jcsb">
                                <div class="Page2-Balance_Row_L df fdc">
                                    <p class="HText Page2-Balance_Row-name2">Счет на вывод средств</p>
                                    <div class="Page2-Balance_Row-subrow df">
                                        <p class="Page2-Balance_Row-date2 MText"><?= date("d.m.Y", strtotime($item['date'])) ?></p>
                                        <p class="Page2-Balance_Row-time2 MText"><?= date("H:i", strtotime($item['date'])) ?></p>
                                    </div>
                                </div>
                                <div class="df fdc Page2-Balance_Row_R">
                                    <h2 class="Page2-Balance_Row-money2"><?= number_format($item['value'], '2', ',', ' ') ?>
                                        руб.</h2>
                                    <a href="<?= Url::to(['get-locale-file', 'id' => $item['id'], 'type' => 'outcome_signed']) ?>"
                                       data-pjax="0" class="HText Page2-Balance_Row-download">Скачать</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="Page2-Balance_Row df jcsb">
                            <div class="Page2-Balance_Row_L df fdc">
                                <p class="HText Page2-Balance_Row-name2">Счета не найдены</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div>
                        <?php if (!empty($pagesBills)): ?>
                            <?php echo LinkPager::widget([
                                'pagination' => $pagesBills,
                            ]); ?>
                        <?php endif; ?>
                    </div>
                    <?php Pjax::end() ?>
                </div>
            </section>

            <section id="page4" class="Page-Balance Page4-Balance">
                <div class="Page2-Balance_chooseP df fdc">
                    <h3 class="Page2-Balance_chooseP-ttl">Выбрать период</h3>
                    <?= Html::beginForm('', 'GET', ['class' => 'Balance_chooseP3']) ?>
                    <div class="Page2-Balance_chooseP-P df">
                        <div class="df aic">
                            <p class="Page2-Balance_chooseP-P_from-to HText">с</p>
                            <?php echo DatePicker::widget([
                                'name' => 'filtAct[first]',
                                'value' => $_GET['filtAct']['first'],
                                'options' => ['class' => 'inpdate', 'placeholder' => $dateWeek],
                                //'language' => 'ru',
                                'dateFormat' => 'yyyy-MM-dd',
                            ]); ?>
                        </div>
                        <div class="df aic ChooseP-gr2">
                            <p class="Page2-Balance_chooseP-P_from-to HText">по</p>
                            <?php echo DatePicker::widget([
                                'name' => 'filtAct[last]',
                                'value' => $_GET['filtAct']['last'],
                                'options' => ['class' => 'inpdate2', 'placeholder' => $dateWeekNow],
                                //'language' => 'ru',
                                'dateFormat' => 'yyyy-MM-dd',
                            ]); ?>
                        </div>
                        <button type="submit" class="uscp Page2-Balance_chooseP-BTN3 df aic jcc">
                            Показать
                        </button>
                        <button type="button" class="reset__btns">&times;</button>
                    </div>
                    <?= Html::endForm(); ?>
                </div>
                <div class="Page2-Balance_Rows df fdc">
                    <?php Pjax::begin(['id' => 'actsContainer']) ?>
                    <?php if (!empty($acts)): ?>
                        <?php foreach ($acts as $item): ?>
                            <div class="Page2-Balance_Row df jcsb">
                                <div class="Page2-Balance_Row_L df fdc">
                                    <p class="HText Page2-Balance_Row-name3">Отчет агента</p>
                                    <div class="Page2-Balance_Row-subrow df">
                                        <p class="Page2-Balance_Row-date3 MText"><?= date("d.m.Y", strtotime($item['date'])) ?></p>
                                        <p class="Page2-Balance_Row-time3 MText"><?= date("H:i", strtotime($item['date'])) ?></p>
                                    </div>
                                </div>
                                <div class="df fdc aic Page2-Balance_Row_R2">
                                    <h2 class="Page2-Balance_Row-money2"><?= number_format($item['value'], '2', ',', ' ') ?>
                                        руб.</h2>
                                    <a style="align-self: end"
                                       href="<?= Url::to(['get-locale-file', 'id' => $item['id'], 'type' => 'report_signed']) ?>"
                                       data-pjax="0" class="HText Page2-Balance_Row-download2">Скачать</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="Page2-Balance_Row df jcsb">
                            <div class="Page2-Balance_Row_L df fdc">
                                <p class="HText Page2-Balance_Row-name2">Отчеты не найдены</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div>
                        <?php if (!empty($pagesActs)): ?>
                            <?php echo LinkPager::widget([
                                'pagination' => $pagesActs,
                            ]); ?>
                        <?php endif; ?>
                    </div>
                    <?php Pjax::end(); ?>
                </div>
            </section>

            <section id="page5" class="Page-Balance Page5-Balance">
                <div class="Page5-Balance_stat">
                    <p class="HText Page5-Balance_stat-ttl" style="color: #9e9e9e; font-size: 14px">Здесь отображается
                        статистика движения средств на балансе
                        личного кабинета за текущий месяц</p>
                    <canvas id="myChart" width="auto" height="200"></canvas>
                </div>
            </section>

            <section id="page6" class="Page-Balance Page6-Balance">
                <div class="Page2-Balance_chooseP df fdc">
                    <h3 class="Page2-Balance_chooseP-ttl">Выбрать период</h3>
                    <?= Html::beginForm('', 'GET', ['class' => 'Balance_chooseP6']) ?>
                    <div class="Page2-Balance_chooseP-P df">
                        <div class="df aic">
                            <p class="Page2-Balance_chooseP-P_from-to HText">с</p>
                            <?php echo DatePicker::widget([
                                'name' => 'filtUpl[first]',
                                'value' => $_GET['filtUpl']['first'],
                                'options' => ['class' => 'inpdate', 'placeholder' => $dateWeek],
                                //'language' => 'ru',
                                'dateFormat' => 'yyyy-MM-dd',
                            ]); ?>
                        </div>
                        <div class="df aic ChooseP-gr2">
                            <p class="Page2-Balance_chooseP-P_from-to HText">по</p>
                            <?php echo DatePicker::widget([
                                'name' => 'filtUpl[last]',
                                'value' => $_GET['filtUpl']['last'],
                                'options' => ['class' => 'inpdate2', 'placeholder' => $dateWeekNow],
                                //'language' => 'ru',
                                'dateFormat' => 'yyyy-MM-dd',
                            ]); ?>
                        </div>
                        <button type="submit" class="uscp Page2-Balance_chooseP-BTN3 df aic jcc">
                            Показать
                        </button>
                        <button type="button" class="reset__btns">&times;</button>
                    </div>
                    <?= Html::endForm(); ?>
                </div>
                <div class="Page2-Balance_Rows df fdc">
                    <?php Pjax::begin(['id' => 'uplContainer']) ?>
                    <?php if (!empty($upl)): ?>
                        <?php foreach ($upl as $item): ?>
                            <div class="df fdc aic Page2-Balance_Row_R2"
                                 style="align-items: flex-end; margin-top: 10px; margin-right: 20px; padding: 10px;  margin-bottom: 0; padding-bottom: 0">
                                <h2 class="Page2-Balance_Row-money2"><?= number_format($item['value'], '2', ',', ' ') ?>
                                    руб.</h2>
                            </div>
                            <?= Html::beginForm('', 'post', [
                            'class' => 'uploadForm',
                            'accept-charset' => 'multipart/form-data',
                        ]) ?>
                            <div class="Page2-Balance_Row df jcsb" style="align-items: flex-start">
                                <div class="Page2-Balance_Row_L df fdc" style="width: 100%">
                                    <?php $typeForm = 'fiz'; ?>
                                    <div class="HText Page2-Balance_Row-name3"
                                         style="display: flex; flex-direction: column;max-width: 300px; width: 100%;">
                                        <div style="display: flex; align-items: center; justify-content: space-between">
                                            <div style="font-weight: 500;font-size: 18px;line-height: 24px;color: #2B3048;">
                                                Отчет агента
                                            </div>
                                            <div>
                                                <a style="align-self: end"
                                                   href="<?= Url::to(['get-locale-file', 'id' => $item['id'], 'type' => 'report']) ?>"
                                                   data-pjax="0" class="HText Page2-Balance_Row-download2">Скачать</a>
                                            </div>
                                        </div>
                                        <!--                                        <div style="margin-left: 20px;">-->
                                        <!--                                            <input name="provider_report" accept=".jpeg, .png, .pdf" type="file"-->
                                        <!--                                                   class="" placeholder="Загрузить документ">-->
                                        <!--                                        </div>-->
                                        <div style="margin: 20px 0;" class="flex__inpfile">
                                            <input style="display: none" id="input_file5" name="provider_report"
                                                   accept=".jpeg, .png, .pdf" type="file"
                                                   class="form-control input_file-class"
                                                   placeholder="Загрузить документ">
                                            <p class="flex__inpfile-p"></p>
                                            <label for="input_file5" class="flex__inpfile-label">Загрузить</label>
                                        </div>
                                    </div>
                                    <div style="border-bottom: 1px solid #f0f1f8; margin-bottom: 20px;"></div>
                                    <?php if ($item['type'] === 'jur'): ?>
                                        <?php $typeForm = 'jur'; ?>
                                        <div class="HText Page2-Balance_Row-name3"
                                             style="display: flex; flex-direction: column;max-width: 300px; width: 100%;">
                                            <div style="display: flex; align-items: center; justify-content: space-between">
                                                <div style="font-weight: 500;font-size: 18px;line-height: 24px;color: #2B3048;">
                                                    Счет
                                                </div>
                                                <div>
                                                    <a style="align-self: end"
                                                       href="<?= Url::to(['get-locale-file', 'id' => $item['id'], 'type' => 'outcome']) ?>"
                                                       data-pjax="0"
                                                       class="HText Page2-Balance_Row-download2">Скачать</a>
                                                </div>
                                            </div>
                                            <!--                                            <div style="margin-left: 20px;">-->
                                            <!--                                                <input name="provider_outcome" accept=".jpeg, .png, .pdf" type="file"-->
                                            <!--                                                       class="form-control" placeholder="Загрузить документ">-->
                                            <!--                                            </div>-->
                                            <div style="margin: 20px 0;" class="flex__inpfile">
                                                <input style="display: none" id="input_file6" name="provider_outcome"
                                                       accept=".jpeg, .png, .pdf" type="file"
                                                       class="form-control input_file-class"
                                                       placeholder="Загрузить документ">
                                                <p class="flex__inpfile-p"></p>
                                                <label for="input_file6" class="flex__inpfile-label">Загрузить</label>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <div style="align-items: center" class="Page2-Balance_Row-subrow df">
                                        <p class="Page2-Balance_Row-date3 MText"><?= date("d.m.Y", strtotime($item['date'])) ?> </p>
                                        <p class="Page2-Balance_Row-time3 MText"><?= date("H:i", strtotime($item['date'])) ?> </p>
                                        <div class="df fdc aic Page2-Balance_Row_R2"
                                             style="align-self: flex-start; margin-left: auto">
                                            <div style="width: 196px">
                                                <button type="submit" class="btn">Загрузить документы</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="DonateAmount" value="<?= $item['value'] ?>">
                            <input type="hidden" name="hashForm" value="<?= md5("{$item['value']}::b5e33") ?>">
                            <input type="hidden" name="type" class="typeJur" value="<?= $typeForm ?>">
                            <input type="hidden" name="link" class="linkFileAssign" value="<?= $item['id'] ?>">
                            <input type="hidden" name="hash[]" class="linkHash1"
                                   value="<?= md5('/lead-force/provider/get-locale-file?type=report&id=' . $item['id'] . "::j43d7io5"); ?>">
                            <input type="hidden" name="hash[]" class="linkHash2"
                                   value="<?= md5('/lead-force/provider/get-locale-file?type=outcome&id=' . $item['id'] . "::j43d7io5"); ?>">
                            <?= Html::endForm() ?>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="Page2-Balance_Row df jcsb">
                            <div class="Page2-Balance_Row_L df fdc">
                                <p class="HText Page2-Balance_Row-name2"
                                   style="font-size: 14px; align-items: center; color: #9e9e9e">Документы, требуемые для
                                    загрузки не найдены</p>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div>
                        <?php if (!empty($pagesUpl)): ?>
                            <?php echo LinkPager::widget([
                                'pagination' => $pagesUpl,
                            ]); ?>
                        <?php endif; ?>
                    </div>
                    <?php Pjax::end(); ?>
                </div>
            </section>
        </article>
    </div>
</section>