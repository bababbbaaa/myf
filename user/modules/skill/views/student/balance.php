<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\helpers\Robokassa;
use yii\jui\DatePicker;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Мой баланс';

$robokassa = new Robokassa(['test' => 1, 'description' => 'Тестовая оплата', 'price' => 500, 'shp' => ['Shp_test' => 1, 'Shp_alpha' => 2]]);
$url = $robokassa->url;

$userHash = md5(Robokassa::PASSWORD_MAIN_1 . "::{$user->id}");

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

$js = <<<JS
    var yac = location.hash.substring(1),
        line = location.hash.substring(5);
$('.submit-pay-fiz').on('click', function(e) {
    var value = parseFloat($('.in01').val()),
        hash = "$userHash",
        err = [],
        errBlock = $('.errors-block');
    e.preventDefault();
    errBlock.html('');
    if (value < 1 || isNaN(value))
        err.push("Сумма платежа должна быть не менее 5000 рублей");
    if (!$('#check_one_pay').prop('checked'))
        err.push("Необходимо дать согласие на обработку персональных данных");
    if (err.length > 0) {
        for (var i = 0; i < err.length; i++) {
            errBlock.append('<p>'+ err[i] +'</p>');
        }
    } else {
        $.ajax({
            data: {value: value, hash: hash},
            dataType: "JSON",
            type: "POST",
            url: "create-balance-link"
        }).done(function(response) {
            if(response.status === 'success') {
                location.href = response.url;
                //console.log(response.url);
            }
            else
                errBlock.append('<p>'+ response.message +'</p>');
        });
    }
});

$('.submit-pay-jur').on('click', function(e) {
    var value = parseFloat($('.InputDonateAmount2').val()),
        hash = "$userHash",
        err = [],
        errBlock = $('.errors-block');
    e.preventDefault();
    errBlock.html('');
    if (value < 5000 || isNaN(value))
        err.push("Сумма платежа должна быть не менее 5000 рублей");
    if (!$('#check_one_pay2').prop('checked'))
        err.push("Необходимо дать согласие на обработку персональных данных");
    if (err.length > 0) {
        for (var i = 0; i < err.length; i++) {
            errBlock.append('<p>'+ err[i] +'</p>');
        }
    } else {
        $.ajax({
            data: {value: value, hash: hash},
            dataType: "JSON",
            type: "POST",
            url: "create-bill",
            beforeSend: function() {
              $('.submit-pay-jur').attr('disabled', true).html('<img src="/img/circles.svg" alt="load">').css('background-color', '#898a8a');
            }
        }).done(function(response) {
            if(response.status === 'success') {
                location.href = "/lead-force/client/get-locale-file?type=bill&id=" + response.__object;
                $('.PopapBack').fadeOut(300);
                $('.PopapDBCWrap').fadeOut(300);
                $('.PopapDCD').fadeOut(300);
                $('.PopapDCD2').fadeOut(300);
                $('.ChangePage-Item-t').removeClass('CIT-active');
                $('.ChangePage-Item-line').removeClass('CIL-active');
                $('.Page-Balance').removeClass('active');
                $('.ChangePage-Item-t3').addClass('CIT-active');
                $('.ChangePage-Item-line3').addClass('CIL-active');
                $('.submit-pay-jur').attr('disabled', false).text('Продолжить').css('background-color', '#007fea');
                $('section[id="page3"').addClass('active');
                $.pjax.reload({container: '#countPjax',});
            }
            else
                errBlock.append('<p>'+ response.message +'</p>');
            $('.submit-pay-jur').attr('disabled', false).text('Продолжить').css('background-color', '#007fea');
        });
    }
});

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

    if(yac.length == 0){
        $('.ChangePage-Item-t[href="#page1"').addClass('CIT-active')
        $('section[id="page1"').addClass('active')
        $('.ChangePage-Item-line1').addClass('CIL-active')
    } else {
        $('.ChangePage-Item-t').removeClass('CIT-active');
        $('.ChangePage-Item-t[href="#'+yac+'"').addClass('active');
        $('.ChangePage-Item-line').removeClass('CIL-active')
        $('.ChangePage-Item-line'+line).addClass('CIL-active')
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
JS;
$this->registerJsFile(Url::to(['/js/chart.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);

?>
<style>
    .errors-block {
        color: red;
        margin-bottom: 10px;
        font-size: 12px;
        text-align: center;
    }
</style>
<?php
$dateNow = date('Y-m-d');
$dateLate = date('Y-m-d', time() - 3600 * 24 * 7);
?>
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
            Пополнение баланса
          </span>
                </li>
            </ul>
        </div>

        <div class="title_row">
            <h1 class="Bal-ttl title-main">Баланс</h1>
            <a href="<?= Url::to(['manualbalance']) ?>">Как пополнить баланс?</a>
        </div>

        <article class="MainInfo">
            <nav class="ChangePageBalance df">
                <div class="ChangePage-Item df jcsb aic">
                    <a href="#page1" class="HText ChangePage-Item-t ChangePage-Item-t1 uscp CIT-active">Пополнение баланса</a>
                    <div class="ChangePage-Item-line ChangePage-Item-line1 CIL-active"></div>
                </div>
                <div class="ChangePage-Item df jcsb aic">
                    <a href="#page2" class="HText ChangePage-Item-t ChangePage-Item-t2 uscp">История платежей</a>
                    <div class="ChangePage-Item-line ChangePage-Item-line2"></div>
                </div>
            </nav>

            <section id="page1" class="Page-Balance Page1-Balance active">
                <div class="Page1-B_info df fdc">
                    <h2 class="Page1-B_info-t">Текущий баланс</h2>
                    <div class="Page1-B_info-balance df aic" style="max-width: unset; padding: 0; margin-bottom: 52px; background: unset">
                        <div style="padding: 24px 28px;   width: auto;   background: #f0f1f8;   border-radius: 12px;    ">
                            <p class="Page1-nubBal">
                                <?= number_format($real_user->budget, 1, ',', ' ') ?><span class="Page1-numbalval">₽</span>
                            </p>
                        </div>
                    </div>
                    <h2 class="Page1-B_info-t">Выберите способ пополнения</h2>
                    <div class="Page1-Donate-choose df aic">
                        <div class="Page1-Donate_BC uscp">
                            <h3 class="Page1-Donate-t">Банковская карта</h3>
                        </div>
                        <?php if ($jurPaymentType) : ?>
                            <div class="Page1-Donate_CL uscp">
                                <h3 class="Page1-Donate-t">Счет на оплату</h3>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h2 style="margin-top: 30px; margin-bottom: 15px" class="Page1-B_info-t">Пополнить в кредит</h2>
                    <div style="display: flex; flex-direction: column; gap: 20px" class="">
                        <?= Html::beginForm('/site/credit-payment-send', 'post', ['class' => '']) ?>
                        <input style="max-width: 400px" name="price" id="priceCheck" class="InputDonateAmount" placeholder="Укажите сумму пополнения"
                               type="number">
                        <button style="display: none" id="priceBtn" class="btn--blue">Пополнить в кредит</button>
                        <?= Html::endForm(); ?>
                        <script>
                            var input = document.querySelector('#priceCheck'),
                                btn = document.querySelector('#priceBtn');
                            input.addEventListener('input', function () {
                                if (this.value > 0){
                                    btn.style.display =  'block'
                                } else {
                                    btn.style.display =  'none'
                                }
                            })
                        </script>
                    </div>
                </div>
                <div class="PopapBack"></div>
                <div class="PopapDBCWrap">
                    <div class="PopapDBC">
                        <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
                        <div class="PopapDBC-Cont df fdc aic">
                            <h2 class="PopapDBC-ttl">Пополнить с банковской карты</h2>
                            <?= Html::beginForm('', 'post', ['class' => 'PopapDBC_Form']) ?>
                            <div class="PopapDBC-Form df fdc">
                                <p class="PopapDBC-t2 HText">Сумма</p>
                                <input class="InputDonateAmount in01" required placeholder="Минимальная сумма пополнения 5 000₽" type="number" min="5000" name="DonateAmount" id="">
                                <div class="CheckboxDonateandlink df aic">
                                    <input checked class="CheckboxDonate" required type="checkbox" name="" id="check_one_pay">
                                    <p class="CheckboxDonatelink">Подтверждаю согласие с <a href="<?= Url::to(['policy']) ?>">условиями обработки данных</a></p>
                                </div>
                                <div class="errors-block"></div>
                                <button style="max-width: 100%" class="PopapDBC_Form-BTN BText df jcc aic uscp submit-pay-fiz" type="submit">Продолжить
                                </button>
                                <button class="PopapDBC_Form-Reset BText df jcc aic uscp" type="reset">Отмена</button>
                            </div>
                            <?= Html::endForm(); ?>
                        </div>
                    </div>
                    <div class="PopapDCD">
                        <img class="PopapExidIcon uscp" src="<?= Url::to(['/img/delete.png']) ?>" alt="Крестик">
                        <div class="PopapDBC-Cont df fdc aic">
                            <h2 class="PopapDCD-ttl">Счет на оплату</h2>
                            <h3 class="PopapDCD-subttl">На ваши реквизиты будет выставлен счет</h3>
                            <?= Html::beginForm('', 'post', ['class' => 'PopapDCD_Form']) ?>
                            <div class="PopapDBC-Form df fdc">
                                <p class="PopapDBC-t2 HText">Сумма</p>
                                <input class="InputDonateAmount2" required placeholder="Минимальная сумма пополнения 5 000₽" type="number" min="5000" name="DonateAmount" id="">
                                <div class="CheckboxDonateandlink df aic">
                                    <input checked class="CheckboxDonate" required type="checkbox" name="" id="check_one_pay2">
                                    <p class="CheckboxDonatelink">Подтверждаю согласие с <a href="<?= Url::to(['policy']) ?>">условиями
                                            обработки данных</a></p>
                                </div>
                                <div class="errors-block"></div>
                                <button class="PopapDBC_Form-BTN BText df jcc aic uscp submit-pay-jur" type="submit">Продолжить
                                </button>
                                <button class="PopapDBC_Form-Reset BText df jcc aic uscp" type="reset">Отмена</button>
                            </div>
                            <?= Html::endForm(); ?>
                        </div>
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
                            <h3 class="PopapDCD2-subttl">Для оплаты по счету вам необходимо заполнить свои реквизиты в
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
                                'name'  => 'filters[first]',
                                'value' => $_GET['filters']['first'],
                                'options' => ['class' => 'inpdate', 'placeholder' => $dateLate],
                                //'language' => 'ru',
                                'dateFormat' => 'yyyy-MM-dd',
                            ]); ?>
                        </div>
                        <div class="df aic ChooseP-gr2">
                            <p class="Page2-Balance_chooseP-P_from-to HText">по</p>
                            <?php echo DatePicker::widget([
                                'name'  => 'filters[last]',
                                'value'  => $_GET['filters']['last'],
                                'options' => ['class' => 'inpdate2', 'placeholder' => $dateNow],
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
                    <?php if (!empty($balance)) : ?>
                        <?php foreach ($balance as $item) : ?>
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
                    <?php else : ?>
                        <div class="Page2-Balance_Row df jcsb" style="color: #9e9e9e">Платежи не найдены</div>
                    <?php endif; ?>
                </div>
                <?php if (!empty($pages)) : ?>
                    <?php echo LinkPager::widget([
                        'pagination' => $pages,
                    ]); ?>
                <?php endif; ?>
                <?php Pjax::end() ?>
        </article>
    </div>
</section>