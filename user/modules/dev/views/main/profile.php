<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use user\modules\lead_force\controllers\ClientController;

$this->title = 'Профиль';

if (!empty($client)) {
    $json = json_encode($client, JSON_UNESCAPED_UNICODE);
} else {
    $json = '{}';
}
$js = <<< JS
    $('input[name="fields[jur][address_jur]"]').on('change', function() {
        var addressJur = $('input[name="fields[jur][address_jur]"]').val();
        if($('input[name="fields[jur][address_copy]"]').prop('checked')){
            $('input[name="fields[jur][address_real]"]').val(addressJur).attr('readonly', true);
        }
    });
    $('input[name="fields[jur][address_copy]"]').on('change', function() {
        $('input[name="fields[jur][address_real]"]').prop('readonly', $(this).prop('checked'))
    });
    
    $('.popup__btn1').on('click', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/skill/student/profile-saver',
            data: $('#form1').serialize(),
            dataType: 'JSON',
            type: 'POST',
        }).done(function (response) {
            if (response.status == 'error') {
                var text = '';
                if (response.message !== undefined){
                    text += response.message + '<br>';
                }
                if (response.validation[0].length > 0) {
                    console.log(response.validation[0]);
                    for (var i = 0; i < response.validation[0].length; i++){
                        text += '<br>' + response.validation[0][i];
                    }
                } 
                if (response.validation[1] instanceof Object){
                    var resp = response.validation[1];
                    for (var key in resp) {
                        text += '<br>' + resp[key][0] + '';
                    }
                }
                $('.errors__texts').html(text);
            } else {
                $('.readonly__class').prop('readonly', true);
                $(".prof__add-btn1").hide();
                $(".popup").fadeOut(300);
                $("body").css("overflow", "auto");
                $('input[name="info[fiz][f]"]').val($('input[name="fields[familiya]"]').val());
                $('input[name="info[fiz][i]"]').val($('input[name="fields[imya]"]').val());
                $('input[name="info[fiz][o]"]').val($('input[name="fields[otchestvo]"]').val());
                $('input[name="info[fiz][address]"]').val($('input[name="fields[fiz][address_registration]"]').val());
                $('input[name="info[fiz][email]"]').val($('input[name="fields[email]"]').val());
                $('input[name="info[jur][organization]"]').val($('input[name="fields[jur][companyName]"]').val());
                $('input[name="info[jur][director]"]').val($('input[name="fields[jur][director]"]').val());
                $('input[name="info[jur][jur_address]"]').val($('input[name="fields[jur][address_jur]"]').val());
                $('input[name="info[jur][real_address]"]').val($('input[name="fields[jur][address_real]"]').val());
                



                var item = $(".fields-active");
                var itemDel = item.not(".active");
                itemDel.hide();
                $('#PjaxShow').fadeIn(300);
                $.pjax.reload({container: '#Style'});
                $.pjax.reload({container: '#PjaxShow'});
                location.href = '/dev/profile#item2';
                location.reload();
            }
        });
    });
    
    
    // информация о плательщике физ лицо
    var info = $json,
        address,
        realAddress;
    if (Object.keys(info).length !== 0){
        address = JSON.parse(info['company_info']);
    } else {
        address = '';
    }

    if (address instanceof Object && Object.keys(address)[0] === 'fiz'){
        realAddress = address['fiz']['address'];
    } else {
        realAddress = '';
    }
    $('.checkInformLabel').on('click', function() {
        if($('.checkInform').is(':checked')){
            $('.resetInp').prop('readonly', false).val('');
        } else {
            $('input[name="info[fiz][f]"]').val(info['f']);
            $('input[name="info[fiz][i]"]').val(info['i']);
            $('input[name="info[fiz][o]"]').val(info['o']);
            $('input[name="info[fiz][address]"]').val(realAddress);
            $('input[name="info[fiz][email]"]').val(info['email']);
            $('.resetInp').each(function(i) {
                if($(this).val().length > 0){
                    $(this).prop('readonly', true);
                }
            });
        }
    });
    // информация о плательщике физ лицо
    
    $('.send__pay-fiz').on('click', function(e) {
        e.preventDefault();
        $.ajax({
          url: '/skill/student/info-payment',
          data: $('#form2').serialize(),
          dataType: 'JSON',
          type: 'POST',
        }).done(function(response) {
            if (response.status === 'error') {
                var text = '';
                text += response.message;
                $('.errors__texts2').html(text);
            } else {
                 location.href = '/dev/start-project';
            }
        });
    });
    
    
    $('#item2').on('click', '.add__payments--more',function() {
        $('.show__payments--more').show();
    });
    
    $('#item2').on('click', '.prof__add-btn4', function() {
        $(".popup--w2").fadeIn(300);
        $("body").css("overflow", "hidden");
    });
    
    $('#form4').submit(function(e) {
      e.preventDefault();
      $.ajax({
            url: '/skill/student/propertis',
            data: $('#form4').serialize(),
            dataType: 'JSON',
            type: 'POST',
        }).done(function (response) {
            console.log(response);
        });
    });
    
    /* Табы */
    var yac = location.hash.substring(1);
    if (yac.length == 0){
        $('.prof__nav-li[href="#item1"').addClass('active');
        $('div[id="item1"').addClass('active');
    } else {
        $('.prof__nav-li').removeClass('active');
        $('.prof__nav-li[href="#'+yac+'"').addClass('active');
        $('.prof__item').removeClass('active');
        $('div[id="'+yac+'"').addClass('active');
    }
    
    $('.prof__nav--fix').on('click', '.prof__nav-li', function() {
        $('.prof__nav-li').removeClass('active');
        $(this).addClass('active');
        var targets = $(this).attr('href').substring(1);
        $('.prof__item').removeClass('active');
        $('div[id="'+targets+'"').addClass('active');
    });
    /* Табы */
    
    $(".prof__add-btn3").on("click", function () {
        var tpass = $("input[name='password[now]']").val();
        var npass = $("input[name='password[new]']").val();
        var repass = $("input[name='password[repeat]']").val();
        $.ajax({
            url: 'main/change-pass',
            type: 'POST',
            dataType: 'JSON',
            data: $('#form3').serialize()
        }).done(function (response) {
            if (response.status === 'error'){
                if (tpass.length < 8){
                    $(".popup--err").show();
                    $(".popup__text1").text("Пароль должен содержать не менее 8-ти символов");
                    $("body").css("overflow", "hidden");
                } else if(response.message === false){
                    $(".popup--err2").show();
                    $("body").css("overflow", "hidden");
                } else if ((npass.length < 8)) {
                    $(".popup--err").show();
                    $(".popup__text1").text("Новый пароль должен содержать не менее 8-ти символов");
                    $("body").css("overflow", "hidden");
                } else if (repass !== npass) {
                    $(".popup--err").show();
                    $(".popup__text1").text("Пароли не совпадают");
                    $("body").css("overflow", "hidden");
                }
            } else {
                $(".popup--ok").show();
                $("body").css("overflow", "hidden");
                $("input[name='password[now]']").val('');
                $("input[name='password[new]']").val('');
                $("input[name='password[repeat]']").val('');
            }
        });
    });
JS;
$this->registerJs($js);
$params = [];
foreach ($_GET as $key => $item)
    $params[$key] = htmlspecialchars($item);
?>
<style>
    #PjaxShow {
        margin-bottom: 0 !important;
    }

    .prof__nav--fix {
        padding-bottom: 10px;
    }
</style>

<?php Pjax::begin(['id' => 'Style']) ?>
<?php if (empty($client)) : ?>
    <style>
        #PjaxShow {
            display: none;
        }
    </style>
<?php endif; ?>
<?php Pjax::end() ?>
<section class="rightInfo">
    <div class="cab__wrapp">
        <div class="prof__main">
            <div class="bcr">
                <ul class="bcr__list">
                    <li class="bcr__item">
            <span class="bcr__link">
              Профиль
            </span>
                    </li>

                    <li class="bcr__item">
            <span class="bcr__span">
              Ваши данные
            </span>
                    </li>
                </ul>
            </div>

            <div class="title_row">
                <h1 class="Bal-ttl title-main">Профиль</h1>
                <a href="<?= Url::to(['manualprofile']) ?>">Как заполнить профиль?</a>
            </div>

            <?php if (!ClientController::fullInfo($client)) : ?>
                <div class="mass mass--cab">
                    <div class="mass__content mass__content--cab">
                        <p class="mass__text mass__text--prof">
                            Пожалуйста, заполните ваши данные, чтобы получить доступ к пополнению баланса
                        </p>
                        <span class="mass__close mass__close--cab">
              <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.0732231 10.0585 -0.0732231 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.0732233 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.0732231 0.987437 -0.0732231 1.28033 0.21967L5.28553 4.22487Z"
                      fill="#FFA800"/>
              </svg>
            </span>
                    </div>
                </div>
            <?php else: ?>
                <div class="mass mass--cab">
                    <div class="mass__content mass__content--cab">
                        <p class="mass__text mass__text--prof">
                            Вы можете изменить данные профиля, обратившись в тех поддержку
                        </p>
                    </div>
                </div>
            <?php endif; ?>
            <div class="prof__inner">
                <div class="prof__box">
                    <div class="prof__nav">
                        <div style="padding-bottom: 0;" class="prof__nav--fix">
                            <a href="#item1" class="prof__nav-li active">Ваши данные</a>
                            <?php Pjax::begin(['id' => 'PjaxShow']) ?>
                            <?php if (!empty($client)) : ?>
                                <a style="display: block" href="#item2" class="prof__nav-li">Информация для оплаты</a>
                            <?php endif; ?>
                            <?php Pjax::end() ?>
                            <a href="#item3" class="prof__nav-li">Сменить пароль</a>
                            <a href="#item4" class="prof__nav-li">Уведомления</a>
                        </div>

                    </div>

                    <div class="prof__content">
                        <?= Html::beginForm('', 'post', ['class' => 'sendForms', 'id' => 'form1']) ?>
                        <div id="item1" class="prof__item active">
                            <div class="prof__item-inner">
                                <div class="prof__info">
                                    <h2 class="prof__info-title">
                                        Контактные данные
                                    </h2>
                                    <p class="prof__info-text">
                                        Обязательная информация для просмотра личного кабинета
                                    </p>
                                </div>
                                <label class="prof__label">
                                    <span class="prof__span">Ваша фамилия</span>
                                    <input class="prof__inp1 readonly__class" <?= !empty($client) ? 'readonly' : '' ?>
                                           type="text" name="fields[familiya]" value="<?= $client['f'] ?? '' ?>"
                                           placeholder="Фамилия">
                                </label>
                                <label class="prof__label">
                                    <span class="prof__span">Ваше имя</span>
                                    <input class="prof__inp1 readonly__class" <?= !empty($client) ? 'readonly' : '' ?>
                                           value="<?= $client['i'] ?? '' ?>" type="text" name="fields[imya]"
                                           placeholder="Имя">
                                </label>
                                <label class="prof__label">
                                    <span class="prof__span">Ваше отчество</span>
                                    <input class="prof__inp1 readonly__class" <?= !empty($client) ? 'readonly' : '' ?>
                                           value="<?= $client['o'] ?? '' ?>" type="text" name="fields[otchestvo]"
                                           placeholder="Отчество">
                                </label>
                                <?php if (!empty($model)) : ?>
                                    <label class="prof__label">
                                        <span class="prof__span">Номер телефона</span>
                                        <input style="user-select: none" class="prof__inp1 readonly__class" readonly
                                               type="text" name="fields[phone]" value="<?= $model['username'] ?>"
                                               placeholder="Телефон">
                                    </label>
                                <?php endif; ?>
                                <label class="prof__label">
                                    <span class="prof__span prof__span--rec">Почта</span>
                                    <input class="prof__inp1 readonly__class" <?= !empty($client) ? 'readonly' : '' ?>
                                           value="<?= $client['email'] ?? '' ?>" data-type="rec" type="email"
                                           name="fields[email]" placeholder="email@mail.ru">
                                </label>
                            </div>
                            <?php if (!empty($client['company_info'])) {
                                if (!empty(json_decode($client['company_info'])->jur)) {
                                    $company = json_decode($client['company_info'])->jur;
                                } elseif (!empty(json_decode($client['company_info'])->fiz)) {
                                    $fiz = json_decode($client['company_info'])->fiz;
                                } else {
                                    $company = [];
                                }
                            } ?>
                            <div class="prof__item-tabs">
                                <?php if (!empty($company) || !empty($fiz)) : ?>
                                    <div class="prof__item-nav">
                                        <?php if (!empty($company)) : ?>
                                            <label class="prof__item-nav-li prof__item-nav-li--1 boxe1 active">
                                                <input style="display: none" checked value="jur" id="box1" type="radio"
                                                       name="fields[type]">
                                                Юридическое лицо
                                            </label>
                                        <?php endif; ?>
                                        <?php if (!empty($fiz)) : ?>
                                            <label class="prof__item-nav-li prof__item-nav-li--1 boxe2 active">
                                                <input style="display: none" value="fiz" id="box2" type="radio"
                                                       name="fields[type]">
                                                Физическое лицо
                                            </label>
                                        <?php endif; ?>
                                    </div>
                                <?php else : ?>
                                    <div class="prof__item-nav">
                                        <label class="prof__item-nav-li prof__item-nav-li--1 fields-active boxe1 active">
                                            <input style="display: none" checked value="jur" id="box1" type="radio"
                                                   name="fields[type]">
                                            Юридическое лицо
                                        </label>
                                        <label class="prof__item-nav-li prof__item-nav-li--1 fields-active boxe2">
                                            <input style="display: none" value="fiz" id="box2" type="radio"
                                                   name="fields[type]">
                                            Физическое лицо
                                        </label>
                                    </div>
                                <?php endif; ?>

                                <?php if (!empty($company) || !empty($fiz)) : ?>
                                    <div class="prof__item-content">
                                        <div class="prof__item-box prof__item-box--1 <?= $company ? 'active' : '' ?> box1">
                                            <div class="prof__item-clm">
                                                <div class="prof__item-row">
                                                    <label class="prof__item-label">
                                                        <span class="prof__span prof__span--2 prof__span--rec">Полное название организации</span>
                                                        <input <?= $company ? 'readonly' : '' ?>
                                                                value="<?= $company->companyName ?>"
                                                                class="prof__inp1 readonly__class prof__inp1--w"
                                                                data-type="rec" type="text"
                                                                name="fields[jur][companyName]"
                                                                placeholder="ООО «Компания»">
                                                    </label>
                                                    <label class="prof__item-label">
                                                        <span class="prof__span prof__span--2 prof__span--rec">Юридический адрес</span>
                                                        <input <?= $company ? 'readonly' : '' ?>
                                                                value="<?= $company->address_jur ?>"
                                                                class="prof__inp1 readonly__class prof__inp1--w"
                                                                data-type="rec" type="text"
                                                                name="fields[jur][address_jur]"
                                                                placeholder="Индекс, регион, город, улица, дом">
                                                    </label>
                                                </div>

                                                <div class="prof__item-row">
                                                    <label class="prof__item-label">
                                                        <span class="prof__span prof__span--2 prof__span--rec">Генеральный директор</span>
                                                        <input <?= $company ? 'readonly' : '' ?>
                                                                value="<?= $company->director ?>"
                                                                class="prof__inp1 readonly__class prof__inp1--w"
                                                                type="text" data-type="rec" name="fields[jur][director]"
                                                                placeholder="ФИО по паспорту">
                                                    </label>

                                                    <label class="prof__item-label">
                                                        <span class="prof__span prof__span--2 prof__span--rec">Фактический адрес</span>
                                                        <input <?= $company ? 'readonly' : '' ?>
                                                                value="<?= $company->address_real ?>"
                                                                class="prof__inp1 readonly__class prof__inp1--w prof__inp1--mb"
                                                                type="text" data-type="rec"
                                                                name="fields[jur][address_real]"
                                                                placeholder="Индекс, регион, город, улица, дом">
                                                        <input id="add-copy" class="prof__checkbox-inp" checked
                                                               type="checkbox" name="fields[jur][address_copy]"/>
                                                        <label for="add-copy" class="prof__checkbox">
                                                            Совпадает с юридическим
                                                        </label>
                                                    </label>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="prof__item-box prof__item-box--1 box2 <?= $fiz ? 'active' : '' ?>">
                                            <div class="prof__item-wrap">
                                                <label class="prof__item-label prof__item-label--1">
                          <span class="prof__span readonly__class prof__span--2 prof__span--rec">Адрес регистрации по
                            паспорту</span>
                                                    <input <?= $fiz ? 'readonly' : '' ?> value="<?= $fiz->address ?>"
                                                                                         class="prof__inp1 readonly__class prof__inp1--w"
                                                                                         type="text"
                                                                                         name="fields[fiz][address_registration]"
                                                                                         data-type="rec"
                                                                                         placeholder="Индекс, регион, город, улица, дом">
                                                </label>
                                                <?php if (empty($fiz)) : ?>
                                                    <button type="button" class="prof__add-btn1 btn__form1 btn">
                                                        Сохранить изменения
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="prof__item-content">
                                        <div class="prof__item-box prof__item-box--1 active box1">
                                            <div class="prof__item-clm">
                                                <div class="prof__item-row">
                                                    <label class="prof__item-label">
                                                        <span class="prof__span prof__span--2 prof__span--rec">Полное название организации</span>
                                                        <input class="prof__inp1 readonly__class prof__inp1--w"
                                                               data-type="rec" type="text"
                                                               name="fields[jur][companyName]"
                                                               placeholder="ООО «Компания»">
                                                    </label>
                                                    <label class="prof__item-label">
                                                        <span class="prof__span prof__span--2 prof__span--rec">Юридический адрес</span>
                                                        <input class="prof__inp1 readonly__class prof__inp1--w"
                                                               data-type="rec" type="text"
                                                               name="fields[jur][address_jur]"
                                                               placeholder="Индекс, регион, город, улица, дом">
                                                    </label>
                                                </div>

                                                <div class="prof__item-row">
                                                    <label class="prof__item-label">
                                                        <span class="prof__span prof__span--2 prof__span--rec">Генеральный директор</span>
                                                        <input class="prof__inp1 readonly__class prof__inp1--w"
                                                               type="text" data-type="rec" name="fields[jur][director]"
                                                               placeholder="ФИО по паспорту">
                                                    </label>

                                                    <label class="prof__item-label">
                                                        <span class="prof__span prof__span--2 prof__span--rec">Фактический адрес</span>
                                                        <input class="prof__inp1 readonly__class prof__inp1--w prof__inp1--mb"
                                                               type="text" data-type="rec"
                                                               name="fields[jur][address_real]"
                                                               placeholder="Индекс, регион, город, улица, дом">
                                                        <input id="add-copy" class="prof__checkbox-inp readonly__class"
                                                               checked type="checkbox"
                                                               name="fields[jur][address_copy]"/>
                                                        <label for="add-copy" class="prof__checkbox">
                                                            Совпадает с юридическим
                                                        </label>
                                                    </label>
                                                </div>
                                            </div>
                                            <button type="button" class="prof__add-btn1 btn">
                                                Сохранить изменения
                                            </button>
                                        </div>
                                        <div class="prof__item-box prof__item-box--1 box2">
                                            <div class="prof__item-wrap">
                                                <label class="prof__item-label prof__item-label--1">
                          <span class="prof__span prof__span--2 prof__span--rec">Адрес регистрации по
                            паспорту</span>
                                                    <input class="prof__inp1 readonly__class prof__inp1--w" type="text"
                                                           name="fields[fiz][address_registration]" data-type="rec"
                                                           placeholder="Индекс, регион, город, улица, дом">
                                                </label>

                                                <button type="button" class="prof__add-btn1 btn">
                                                    Сохранить изменения
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?= Html::endForm(); ?>

                        <?= Html::beginForm('', 'post', ['id' => 'form2', 'class' => 'sendForms']) ?>
                        <div id="item2" class="prof__item">
                            <?php Pjax::begin(['id' => 'PjaxCont']) ?>
                            <?php $infoPay = (json_decode($client['requisites'], true)) ?>
                            <?php if (empty($infoPay)) : ?>
                                <div class="prof__mass">
                                    <p class="prof__mass-content">
                                        Вы можете оплачивать заказы как физическое или юридическое лицо. И создать по
                                        одному
                                        плательщику
                                        каждого вида. <span>Выберите, как вы будете оплачивать услуги:</span>
                                    </p>
                                </div>
                                <div class="prof__item-step1">
                                    <div class="prof__item-tabs prof__item-tabs--1">
                                        <div class="prof__item-nav prof__item-nav--1">
                                            <label class="prof__item-nav-li prof__item-nav-li--1 boxe3 active">
                                                <input style="display: none" checked value="jur" id="box3" type="radio"
                                                       name="info[type]">
                                                Юридическое лицо
                                            </label>
                                            <label class="prof__item-nav-li prof__item-nav-li--1 boxe4">
                                                <input style="display: none" value="fiz" id="box4" type="radio"
                                                       name="info[type]">
                                                Физическое лицо
                                            </label>
                                        </div>
                                        <div class="prof__item-content">
                                            <div id="box3" class="prof__item-box prof__item-box--2 box3 active">
                                                <div class="prof__item-inner">
                                                    <div class="prof__info">
                                                        <h2 class="prof__info-title">
                                                            Данные компании
                                                        </h2>
                                                        <p class="prof__info-text">
                                                            Необходимы для оплаты услуг сервиса и пополнения баланса
                                                            (безналичный рассчет)
                                                        </p>
                                                    </div>

                                                    <div class="prof__form">
                                                        <label class="prof__label">
                                                            <span class="prof__span">ИНН</span>
                                                            <input <?= !empty($infoPay['jur']['inn']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['inn'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][inn]"
                                                                    placeholder="10 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">ОГРН(ИП)</span>
                                                            <input <?= !empty($infoPay['jur']['ogrn']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['ogrn'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][ogrn]" placeholder="13 или 15 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">КПП</span>
                                                            <input <?= !empty($infoPay['jur']['kpp']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['kpp'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][kpp]"
                                                                    placeholder="9 цифр">
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="prof__item-inner">
                                                    <div class="prof__info">
                                                        <h2 class="prof__info-title">
                                                            Реквизиты банка
                                                        </h2>
                                                        <p class="prof__info-text">
                                                            Необходимы для оплаты услуг сервиса и пополнения баланса
                                                            (безналичный рассчет)
                                                        </p>
                                                    </div>

                                                    <div class="prof__form">
                                                        <label class="prof__label">
                                                            <span class="prof__span">Название банка</span>
                                                            <input <?= !empty($infoPay['jur']['bank']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['bank'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][bank]"
                                                                    placeholder="Сбербанк России">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">БИК</span>
                                                            <input <?= !empty($infoPay['jur']['bik']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['bik'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][bik]"
                                                                    placeholder="9 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Расчетный счет</span>
                                                            <input <?= !empty($infoPay['jur']['rs']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['rs'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][rs]"
                                                                    placeholder="20 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Корреспондентский счет</span>
                                                            <input <?= !empty($infoPay['jur']['ks']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['ks'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][ks]"
                                                                    placeholder="20 цифр">
                                                        </label>
                                                    </div>
                                                </div>

                                                <button type="button" class="prof__add-btn4 prof__add-btn--1 btn">
                                                    Сохранить изменения
                                                </button>
                                            </div>

                                            <div id="box4" class="prof__item-box prof__item-box--2 box4">
                                                <div class="prof__item-inner">
                                                    <div class="prof__info">
                                                        <h2 class="prof__info-title">
                                                            Данные плательщика
                                                        </h2>
                                                        <p class="prof__info-text prof__info-text--1">
                                                            Необходимы для оплаты услуг сервиса и пополнения баланса
                                                            (оплата картой или через
                                                            виртуальный кошелек)
                                                        </p>

                                                        <input checked id="prof__info-check"
                                                               class="prof__checkbox-inp checkInform" type="checkbox"
                                                               name="info[fiz][address-copy]"/>
                                                        <label for="prof__info-check"
                                                               class="prof__checkbox checkInformLabel">
                                                            Совпадают с контактными данными
                                                        </label>
                                                    </div>

                                                    <?php $addressReal = (json_decode($client['company_info'], true)) ?>
                                                    <div class="prof__form">
                                                        <label class="prof__label">
                                                            <span class="prof__span">Ваша фамилия</span>
                                                            <input <?= $client['f'] ? 'readonly' : '' ?>
                                                                    class="prof__inp1 resetInp" data-value="form5-1"
                                                                    value="<?= $client['f'] ?>" type="text"
                                                                    name="info[fiz][f]" placeholder="Фамилия">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Ваше имя</span>
                                                            <input <?= $client['i'] ? 'readonly' : '' ?>
                                                                    class="prof__inp1 resetInp" data-value="form5-1"
                                                                    value="<?= $client['i'] ?>" type="text"
                                                                    name="info[fiz][i]" placeholder="Имя">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Ваше отчество</span>
                                                            <input <?= $client['o'] ? 'readonly' : '' ?>
                                                                    class="prof__inp1 resetInp" data-value="form5-1"
                                                                    value="<?= $client['o'] ?>" type="text"
                                                                    name="info[fiz][o]" placeholder="Отчество">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Адрес регистрации</span>
                                                            <input <?= $addressReal['fiz']['address'] ? 'readonly' : '' ?>
                                                                    class="prof__inp1 resetInp" data-value="form5-2"
                                                                    value="<?= $addressReal['fiz']['address'] ?>"
                                                                    type="text" name="info[fiz][address]"
                                                                    placeholder="Индекс, регион, город, улица, дом">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Номер телефона</span>
                                                            <input <?= $client[''] ? 'readonly' : '' ?>
                                                                    class="prof__inp1 resetInp" data-value="form5-3"
                                                                    value="" type="tel" name="info[fiz][phone]"
                                                                    placeholder="Телефон">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Почта</span>
                                                            <input <?= $client['email'] ? 'readonly' : '' ?>
                                                                    class="prof__inp1 resetInp" data-value="form5-4"
                                                                    value="<?= $client['email'] ?>" type="email"
                                                                    name="info[fiz][email]" placeholder="email@mail.ru">
                                                        </label>
                                                    </div>
                                                </div>

                                                <button type="button" class="prof__add-btn4 prof__add-btn4--1 btn">
                                                    Сохранить изменения
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif (!empty($infoPay['jur']) && !empty($infoPay['fiz'])) : ?>
                                <div class="prof__item-step3">
                                    <div class="prof__item-tabs">
                                        <div class="prof__item-nav">
                                            <span class="prof__item-nav-li prof__item-nav-li--2 active">Юридическое лицо</span>
                                        </div>

                                        <div class="prof__item-content">
                                            <div id="box6" class="prof__item-box2 prof__item-box2--2 active">
                                                <div class="prof__item-inner">
                                                    <div class="prof__info">
                                                        <h2 class="prof__info-title">
                                                            Данные компании
                                                        </h2>
                                                        <p class="prof__info-text">
                                                            Необходимы для оплаты услуг сервиса и пополнения баланса
                                                            (безналичный
                                                            рассчет)
                                                        </p>
                                                    </div>

                                                    <div class="prof__form">
                                                        <label class="prof__label">
                                                            <span class="prof__span">Полное название организации</span>
                                                            <input <?= !empty($infoPay['jur']['organization']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['organization'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][organization]"
                                                                    placeholder="ООО 'Праватон'">
                                                        </label>

                                                        <label class="prof__label">
                                                            <span class="prof__span">Генеральный директор</span>
                                                            <input <?= !empty($infoPay['jur']['director']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['director'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][director]"
                                                                    placeholder="Иван Иванов">
                                                        </label>

                                                        <label class="prof__label">
                                                            <span class="prof__span">Юридический адрес</span>
                                                            <input <?= !empty($infoPay['jur']['jur_address']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['jur_address'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][jur_address]"
                                                                    placeholder="Юридический адрес">
                                                        </label>

                                                        <label class="prof__label">
                                                            <span class="prof__span">Фактический адрес</span>
                                                            <input <?= !empty($infoPay['jur']['real_address']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['real_address'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][real_address]"
                                                                    placeholder="Фактический адрес">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">ИНН</span>
                                                            <input <?= !empty($infoPay['jur']['inn']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['inn'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][inn]"
                                                                    placeholder="10 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">ОГРН(ИП)</span>
                                                            <input <?= !empty($infoPay['jur']['ogrn']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['ogrn'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][ogrn]" placeholder="13 или 15 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">КПП</span>
                                                            <input <?= !empty($infoPay['jur']['kpp']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['kpp'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][kpp]"
                                                                    placeholder="9 цифр">
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="prof__item-inner">
                                                    <div class="prof__info">
                                                        <h2 class="prof__info-title">
                                                            Реквизиты банка
                                                        </h2>
                                                        <p class="prof__info-text">
                                                            Необходимы для оплаты услуг сервиса и пополнения баланса
                                                            (безналичный
                                                            рассчет)
                                                        </p>
                                                    </div>

                                                    <div class="prof__form">
                                                        <label class="prof__label">
                                                            <span class="prof__span">Название банка</span>
                                                            <input <?= !empty($infoPay['jur']['bank']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['bank'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][bank]"
                                                                    placeholder="Сбербанк России">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">БИК</span>
                                                            <input <?= !empty($infoPay['jur']['bik']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['bik'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][bik]"
                                                                    placeholder="9 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Расчетный счет</span>
                                                            <input <?= !empty($infoPay['jur']['rs']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['rs'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][rs]"
                                                                    placeholder="20 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Корреспондентский счет</span>
                                                            <input <?= !empty($infoPay['jur']['ks']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['ks'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][ks]"
                                                                    placeholder="20 цифр">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="prof__item-step2 show__payments--more">
                                    <div class="prof__item-tabs prof__item-tabs--1">
                                        <div class="prof__item-nav">
                                            <span class="prof__item-nav-li prof__item-nav-li--2 active">Физическое лицо</span>
                                        </div>

                                        <div class="prof__item-content">
                                            <div id="box5" class="prof__item-box2 prof__item-box2--2 active">
                                                <div class="prof__item-inner">
                                                    <div class="prof__info">
                                                        <h2 class="prof__info-title">
                                                            Данные плательщика
                                                        </h2>
                                                        <p class="prof__info-text prof__info-text--1">
                                                            Необходимы для оплаты услуг сервиса и пополнения баланса
                                                            (оплата картой
                                                            или через
                                                            виртуальный кошелек)
                                                        </p>
                                                    </div>

                                                    <div class="prof__form">
                                                        <label class="prof__label">
                                                            <span class="prof__span">Ваша фамилия</span>
                                                            <input <?= !empty($infoPay['fiz']['f']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['f'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-1"
                                                                    type="text" name="info[fiz][f]"
                                                                    placeholder="Фамилия">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Ваше имя</span>
                                                            <input <?= !empty($infoPay['fiz']['i']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['i'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-1"
                                                                    type="text" name="info[fiz][i]" placeholder="Имя">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Ваше отчество</span>
                                                            <input <?= !empty($infoPay['fiz']['o']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['o'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-1"
                                                                    type="text" name="info[fiz][o]"
                                                                    placeholder="Отчество">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Адрес регистрации</span>
                                                            <input <?= !empty($infoPay['fiz']['address']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['address'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-2"
                                                                    type="text" name="info[fiz][address]"
                                                                    placeholder="Индекс, регион, город, улица, дом">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Номер телефона</span>
                                                            <input <?= !empty($infoPay['fiz']['phone']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['phone'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-3"
                                                                    type="tel" name="info[fiz][phone]"
                                                                    placeholder="Телефон">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Почта</span>
                                                            <input <?= !empty($infoPay['fiz']['email']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['email'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-4"
                                                                    type="email" name="info[fiz][email]"
                                                                    placeholder="email@mail.ru">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif (!empty($infoPay['fiz'])) : ?>
                                <div class="prof__item-step2">
                                    <div class="prof__item-tabs prof__item-tabs--1">
                                        <div class="prof__item-nav">
                                            <span class="prof__item-nav-li prof__item-nav-li--2 active">Физическое лицо</span>
                                        </div>

                                        <div class="prof__item-content">
                                            <div id="box5" class="prof__item-box2 prof__item-box2--2 active">
                                                <div class="prof__item-inner">
                                                    <div class="prof__info">
                                                        <h2 class="prof__info-title">
                                                            Данные плательщика
                                                        </h2>
                                                        <p class="prof__info-text prof__info-text--1">
                                                            Необходимы для оплаты услуг сервиса и пополнения баланса
                                                            (оплата картой
                                                            или через
                                                            виртуальный кошелек)
                                                        </p>
                                                    </div>

                                                    <div class="prof__form">
                                                        <label class="prof__label">
                                                            <span class="prof__span">Ваша фамилия</span>
                                                            <input <?= !empty($infoPay['fiz']['f']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['f'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-1"
                                                                    type="text" name="info[fiz][f]"
                                                                    placeholder="Фамилия">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Ваше имя</span>
                                                            <input <?= !empty($infoPay['fiz']['i']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['i'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-1"
                                                                    type="text" name="info[fiz][i]" placeholder="Имя">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Ваше отчество</span>
                                                            <input <?= !empty($infoPay['fiz']['o']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['o'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-1"
                                                                    type="text" name="info[fiz][o]"
                                                                    placeholder="Отчество">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Адрес регистрации</span>
                                                            <input <?= !empty($infoPay['fiz']['address']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['address'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-2"
                                                                    type="text" name="info[fiz][address]"
                                                                    placeholder="Индекс, регион, город, улица, дом">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Номер телефона</span>
                                                            <input <?= !empty($infoPay['fiz']['phone']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['phone'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-3"
                                                                    type="tel" name="info[fiz][phone]"
                                                                    placeholder="Телефон">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Почта</span>
                                                            <input <?= !empty($infoPay['fiz']['email']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['email'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-4"
                                                                    type="email" name="info[fiz][email]"
                                                                    placeholder="email@mail.ru">
                                                        </label>
                                                    </div>
                                                </div>

                                                <button type="button"
                                                        class="prof__add-btn2 prof__add-btn2--1 btn add__payments--more">
                                                    Добавить плательщика
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="display: none" class="prof__item-step3 show__payments--more">
                                    <div class="prof__item-tabs">
                                        <div class="prof__item-nav">
                                            <span class="prof__item-nav-li prof__item-nav-li--2 active">Юридическое лицо</span>
                                            <input value="jur" type="checkbox" checked name="info[type]"
                                                   style="display: none">
                                        </div>

                                        <div class="prof__item-content">
                                            <div id="box6" class="prof__item-box2 prof__item-box2--2 active">
                                                <div class="prof__item-inner">
                                                    <div class="prof__info">
                                                        <h2 class="prof__info-title">
                                                            Данные компании
                                                        </h2>
                                                        <p class="prof__info-text">
                                                            Необходимы для оплаты услуг сервиса и пополнения баланса
                                                            (безналичный
                                                            рассчет)
                                                        </p>
                                                    </div>
                                                    <!-- qweqwe123 -->
                                                    <div class="prof__form">
                                                        <label class="prof__label">
                                                            <span class="prof__span">Полное название организации</span>
                                                            <input <?= !empty($infoPay['jur']['organization']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['organization'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][organization]"
                                                                    placeholder="ООО 'Праватон'">
                                                        </label>

                                                        <label class="prof__label">
                                                            <span class="prof__span">Генеральный директор</span>
                                                            <input <?= !empty($infoPay['jur']['director']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['director'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][director]"
                                                                    placeholder="Иван Иванов">
                                                        </label>

                                                        <label class="prof__label">
                                                            <span class="prof__span">Юридический адрес</span>
                                                            <input <?= !empty($infoPay['jur']['jur_address']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['jur_address'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][jur_address]"
                                                                    placeholder="Юридический адрес">
                                                        </label>

                                                        <label class="prof__label">
                                                            <span class="prof__span">Фактический адрес</span>
                                                            <input <?= !empty($infoPay['jur']['real_address']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['real_address'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][real_address]"
                                                                    placeholder="Фактический адрес">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">ИНН</span>
                                                            <input <?= !empty($infoPay['jur']['inn']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['inn'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][inn]"
                                                                    placeholder="10 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">ОГРН(ИП)</span>
                                                            <input <?= !empty($infoPay['jur']['ogrn']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['ogrn'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][ogrn]" placeholder="13 или 15 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">КПП</span>
                                                            <input <?= !empty($infoPay['jur']['kpp']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['kpp'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][kpp]"
                                                                    placeholder="9 цифр">
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="prof__item-inner">
                                                    <div class="prof__info">
                                                        <h2 class="prof__info-title">
                                                            Реквизиты банка
                                                        </h2>
                                                        <p class="prof__info-text">
                                                            Необходимы для оплаты услуг сервиса и пополнения баланса
                                                            (безналичный
                                                            рассчет)
                                                        </p>
                                                    </div>

                                                    <div class="prof__form">
                                                        <label class="prof__label">
                                                            <span class="prof__span">Название банка</span>
                                                            <input <?= !empty($infoPay['jur']['bank']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['bank'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][bank]"
                                                                    placeholder="Сбербанк России">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">БИК</span>
                                                            <input <?= !empty($infoPay['jur']['bik']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['bik'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][bik]"
                                                                    placeholder="9 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Расчетный счет</span>
                                                            <input <?= !empty($infoPay['jur']['rs']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['rs'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][rs]"
                                                                    placeholder="20 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Корреспондентский счет</span>
                                                            <input <?= !empty($infoPay['jur']['ks']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['ks'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][ks]"
                                                                    placeholder="20 цифр">
                                                        </label>
                                                    </div>
                                                </div>
                                                <button type="button" class="prof__add-btn4 prof__add-btn4--1 btn">
                                                    Сохранить изменения
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php elseif (!empty($infoPay['jur'])) : ?>
                                <div class="prof__item-step3">
                                    <div class="prof__item-tabs">
                                        <div class="prof__item-nav">
                                            <span class="prof__item-nav-li prof__item-nav-li--2 active">Юридическое лицо</span>
                                        </div>

                                        <div class="prof__item-content">
                                            <div id="box6" class="prof__item-box2 prof__item-box2--2 active">
                                                <div class="prof__item-inner">
                                                    <div class="prof__info">
                                                        <h2 class="prof__info-title">
                                                            Данные компании
                                                        </h2>
                                                        <p class="prof__info-text">
                                                            Необходимы для оплаты услуг сервиса и пополнения баланса
                                                            (безналичный
                                                            рассчет)
                                                        </p>
                                                    </div>

                                                    <div class="prof__form">
                                                        <label class="prof__label">
                                                            <span class="prof__span">Полное название организации</span>
                                                            <input <?= !empty($infoPay['jur']['organization']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['organization'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][organization]"
                                                                    placeholder="ООО 'Праватон'">
                                                        </label>

                                                        <label class="prof__label">
                                                            <span class="prof__span">Генеральный директор</span>
                                                            <input <?= !empty($infoPay['jur']['director']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['director'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][director]"
                                                                    placeholder="Иван Иванов">
                                                        </label>

                                                        <label class="prof__label">
                                                            <span class="prof__span">Юридический адрес</span>
                                                            <input <?= !empty($infoPay['jur']['jur_address']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['jur_address'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][jur_address]"
                                                                    placeholder="Юридический адрес">
                                                        </label>

                                                        <label class="prof__label">
                                                            <span class="prof__span">Фактический адрес</span>
                                                            <input <?= !empty($infoPay['jur']['real_address']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['real_address'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][real_address]"
                                                                    placeholder="Фактический адрес">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">ИНН</span>
                                                            <input <?= !empty($infoPay['jur']['inn']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['inn'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][inn]"
                                                                    placeholder="10 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">ОГРН(ИП)</span>
                                                            <input <?= !empty($infoPay['jur']['ogrn']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['ogrn'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][ogrn]" placeholder="13 или 15 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">КПП</span>
                                                            <input <?= !empty($infoPay['jur']['kpp']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['kpp'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][kpp]"
                                                                    placeholder="9 цифр">
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="prof__item-inner">
                                                    <div class="prof__info">
                                                        <h2 class="prof__info-title">
                                                            Реквизиты банка
                                                        </h2>
                                                        <p class="prof__info-text">
                                                            Необходимы для оплаты услуг сервиса и пополнения баланса
                                                            (безналичный
                                                            рассчет)
                                                        </p>
                                                    </div>

                                                    <div class="prof__form">
                                                        <label class="prof__label">
                                                            <span class="prof__span">Название банка</span>
                                                            <input <?= !empty($infoPay['jur']['bank']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['bank'] ?? '' ?>"
                                                                    class="prof__inp1" type="text"
                                                                    name="info[jur][bank]"
                                                                    placeholder="Сбербанк России">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">БИК</span>
                                                            <input <?= !empty($infoPay['jur']['bik']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['bik'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][bik]"
                                                                    placeholder="9 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Расчетный счет</span>
                                                            <input <?= !empty($infoPay['jur']['rs']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['rs'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][rs]"
                                                                    placeholder="20 цифр">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Корреспондентский счет</span>
                                                            <input <?= !empty($infoPay['jur']['ks']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['jur']['ks'] ?? '' ?>"
                                                                    class="prof__inp1" type="text" name="info[jur][ks]"
                                                                    placeholder="20 цифр">
                                                        </label>
                                                    </div>
                                                </div>

                                                <button type="button"
                                                        class="prof__add-btn2 prof__add-btn2--1 btn add__payments--more">
                                                    Добавить плательщика
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div style="display: none" class="prof__item-step2 show__payments--more">
                                    <div class="prof__item-tabs prof__item-tabs--1">
                                        <div class="prof__item-nav">
                                            <span class="prof__item-nav-li prof__item-nav-li--2 active">Физическое лицо</span>
                                            <input value="fiz" type="checkbox" checked name="info[type]"
                                                   style="display: none">
                                        </div>

                                        <div class="prof__item-content">
                                            <div id="box5" class="prof__item-box2 prof__item-box2--2 active">
                                                <div class="prof__item-inner">
                                                    <div class="prof__info">
                                                        <h2 class="prof__info-title">
                                                            Данные плательщика
                                                        </h2>
                                                        <p class="prof__info-text prof__info-text--1">
                                                            Необходимы для оплаты услуг сервиса и пополнения баланса
                                                            (оплата картой
                                                            или через
                                                            виртуальный кошелек)
                                                        </p>
                                                    </div>

                                                    <div class="prof__form">
                                                        <label class="prof__label">
                                                            <span class="prof__span">Ваша фамилия</span>
                                                            <input <?= !empty($infoPay['fiz']['f']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['f'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-1"
                                                                    type="text" name="info[fiz][f]"
                                                                    placeholder="Фамилия">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Ваше имя</span>
                                                            <input <?= !empty($infoPay['fiz']['i']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['i'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-1"
                                                                    type="text" name="info[fiz][i]" placeholder="Имя">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Ваше отчество</span>
                                                            <input <?= !empty($infoPay['fiz']['o']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['o'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-1"
                                                                    type="text" name="info[fiz][o]"
                                                                    placeholder="Отчество">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Адрес регистрации</span>
                                                            <input <?= !empty($infoPay['fiz']['address']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['address'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-2"
                                                                    type="text" name="info[fiz][address]"
                                                                    placeholder="Индекс, регион, город, улица, дом">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Номер телефона</span>
                                                            <input <?= !empty($infoPay['fiz']['phone']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['phone'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-3"
                                                                    type="tel" name="info[fiz][phone]"
                                                                    placeholder="Телефон">
                                                        </label>
                                                        <label class="prof__label">
                                                            <span class="prof__span">Почта</span>
                                                            <input <?= !empty($infoPay['fiz']['email']) ? 'readonly' : '' ?>
                                                                    value="<?= $infoPay['fiz']['email'] ?? '' ?>"
                                                                    class="prof__inp1 resetInp" data-value="form5-4"
                                                                    type="email" name="info[fiz][email]"
                                                                    placeholder="email@mail.ru">
                                                        </label>
                                                    </div>
                                                </div>

                                                <button type="button" class="prof__add-btn4 prof__add-btn4--1 btn">
                                                    Сохранить изменения
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php Pjax::end(); ?>
                        </div>
                        <?= Html::endForm(); ?>

                        <?= Html::beginForm('', 'post', ['id' => 'form3']) ?>
                        <div id="item3" class="prof__item pass">
                            <div class="prof__item-inner prof__item-inner--pass">
                                <div class="prof__form prof__form--pass">
                                    <label class="prof__label">
                                        <span class="prof__span">Текущий пароль</span>
                                        <input class="prof__inp1" type="password" name="password[now]"
                                               placeholder="_____">
                                    </label>

                                    <label class="prof__label">
                                        <span class="prof__span">Новый пароль</span>
                                        <input class="prof__inp1" type="password" name="password[new]"
                                               placeholder="_____">
                                    </label>

                                    <label class="prof__label">
                                        <span class="prof__span">Повторите новый пароль</span>
                                        <input class="prof__inp1" type="password" name="password[repeat]"
                                               placeholder="_____">
                                    </label>

                                    <button type="button" class="prof__add-btn3 btn">
                                        Сменить пароль
                                    </button>
                                </div>
                            </div>
                        </div>
                        <?= Html::endForm(); ?>

                        <?= Html::beginForm('', 'post', ['id' => 'form4']) ?>
                        <div id="item4" class="prof__item">
                            <div class="not">
                                <div class="not__inner">
                                    <div class="not__item">
                                        <?php $prop = (json_decode($propertis['params'], true))['profile']; ?>
                                        <h3 class="not__title">Email-уведомления:</h3>
                                        <input id="not-email-1" <?= $prop['status'] == 1 ? 'checked' : '' ?>
                                               class="not__chek prof__checkbox-inp" value="Окончание средств на балансе"
                                               type="checkbox" name="propertis[balance]"/>
                                        <label for="not-email-1" class="not__chek prof__checkbox">
                                            Окончание средств на балансе
                                        </label>

                                        <input id="not-email-2" <?= $prop['email'] == 1 ? 'checked' : '' ?>
                                               class="not__chek prof__checkbox-inp" value="Новости" type="checkbox"
                                               name="propertis[news]"/>
                                        <label for="not-email-2" class="not__chek prof__checkbox">
                                            Новости
                                        </label>

                                        <input id="not-email-3" <?= $prop['status'] == 1 ? 'checked' : '' ?>
                                               class="not__chek prof__checkbox-inp"
                                               value="Уведомления о проверенных заданиях" type="checkbox"
                                               name="propertis[verified_tasks]"/>
                                        <label for="not-email-3" class="not__chek prof__checkbox">
                                            Уведомления о проверенных заданиях
                                        </label>

                                        <input id="not-email-4" <?= $prop['status'] == 1 ? 'checked' : '' ?>
                                               class="not__chek prof__checkbox-inp"
                                               value="Уведомления о предстоящих вебинарах" type="checkbox"
                                               name="propertis[webinars]"/>
                                        <label for="not-email-4" class="not__chek prof__checkbox">
                                            Уведомления о предстоящих вебинарах
                                        </label>

                                        <input id="not-email-5" <?= $prop['balance'] == 1 ? 'checked' : '' ?>
                                               class="not__chek prof__checkbox-inp"
                                               value="Уведомления о доступе к новым блокам курса" type="checkbox"
                                               name="propertis[course]"/>
                                        <label for="not-email-5" class="not__chek prof__checkbox">
                                            Уведомления о доступе к новым блокам курса
                                        </label>
                                    </div>

                                    <div class="not__item">
                                        <h3 class="not__title">Push-уведомления:</h3>

                                        <input id="not-push-2" <?= $prop['push_status'] == 1 ? 'checked' : '' ?>
                                               class="not__chek prof__checkbox-inp"
                                               value="Уведомления о новых акциях и скидках" type="checkbox"
                                               name="propertis[push_status]"/>
                                        <label for="not-push-2" class="not__chek prof__checkbox">
                                            Уведомления о новых акциях и скидках
                                        </label>

                                        <input id="not-push-3" <?= $prop['new_lead'] == 1 ? 'checked' : '' ?>
                                               class="not__chek prof__checkbox-inp"
                                               value="Уведомления о проверенных заданиях" type="checkbox"
                                               name="propertis[verified_tasks]"/>
                                        <label for="not-push-3" class="not__chek prof__checkbox">
                                            Уведомления о проверенных заданиях
                                        </label>

                                        <input id="not-push-4" <?= $prop['proposition'] == 1 ? 'checked' : '' ?>
                                               class="not__chek prof__checkbox-inp"
                                               value="Уведомления о предстоящих вебинарах" type="checkbox"
                                               name="propertis[webinars]"/>
                                        <label for="not-push-4" class="not__chek prof__checkbox">
                                            Уведомления о предстоящих вебинарах
                                        </label>

                                        <input id="not-push-5" <?= $prop['push_status'] == 1 ? 'checked' : '' ?>
                                               class="not__chek prof__checkbox-inp"
                                               value="Уведомления о доступе к новым блокам курса" type="checkbox"
                                               name="propertis[course]"/>
                                        <label for="not-push-5" class="not__chek prof__checkbox">
                                            Уведомления о доступе к новым блокам курса
                                        </label>
                                    </div>
                                </div>

                                <button type="submit" class="prof__add-btn-push btn save_propertis">
                                    Сохранить изменения
                                </button>
                            </div>
                        </div>
                        <?= Html::endForm(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

    <div class="popup popup--w">
        <div class="popup__ov">
            <div class="popup__body popup__body--w">
                <div class="popup__content popup__content--w">
                    <p class="popup__title">Обратите внимание!</p>
                    <p class="popup__text">
                        Сохраненные данные можно редактировать только через обращение в <a
                                href="<?= Url::to(['backing']) ?>" class="link">тех.поддержку</a>
                    </p>
                    <button type="submit" class="popup__btn btn send__pay-fiz">Продолжить</button>
                    <button class="popup__btn-close btn">Отмена</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>

    <div class="popup popup--w2">
        <div class="popup__ov">
            <div class="popup__body popup__body--w">
                <div class="popup__content popup__content--w">
                    <p class="popup__title">Обратите внимание!</p>
                    <p class="popup__text">
                        Сохраненные данные можно редактировать только через обращение в <a
                                href="<?= Url::to(['backing']) ?>" class="link">тех.поддержку</a>
                    </p>
                    <p class="popup__text errors__texts2" style="color: red"></p>
                    <button type="submit" class="popup__btn-w btn send__pay-fiz">Продолжить</button>
                    <button class="popup__btn-close btn">Отмена</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>

    <div class="popup popup--w3">
        <div class="popup__ov">
            <div class="popup__body popup__body--w">
                <div class="popup__content popup__content--w">
                    <p class="popup__title">Обратите внимание!</p>
                    <p class="popup__text">
                        Сохраненные данные можно редактировать только через обращение в <a
                                href="<?= Url::to(['backing']) ?>" class="link">тех.поддержку</a>
                    </p>
                    <p class="popup__text errors__texts" style="color: red"></p>
                    <button type="submit" class="popup__btn1 btn">Продолжить</button>
                    <button class="popup__btn-close btn">Отмена</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>

    <div class="popup popup--err">
        <div class="popup__ov">
            <div class="popup__body popup__body--err">
                <div class="popup__content popup__content--err">
                    <p class="popup__title">Ошибка!</p>
                    <p class="popup__text1">
                        Пароль должен содержать не менее 8-ти символов
                    </p>
                    <button class="popup__btn popup__btn--err btn">Закрыть</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>

    <div class="popup popup--err2">
        <div class="popup__ov">
            <div class="popup__body popup__body--err2">
                <div class="popup__content popup__content--err">
                    <p class="popup__title">Ошибка!</p>
                    <p class="popup__text">
                        Пароль введен неправильно. Поробуйте еще раз или обратитесь в <a
                                href="<?= Url::to(['backing']) ?>" class="link">тех.поддержку</a>
                    </p>
                    <button class="popup__btn popup__btn--err btn">Закрыть</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>

    <div class="popup popup--ok">
        <div class="popup__ov">
            <div class="popup__body popup__body--ok">
                <div class="popup__content popup__content--ok">
                    <p class="popup__title">Успешно!</p>
                    <p class="popup__text">
                        Изменения успешно сохранены
                    </p>
                    <button class="popup__btn-ok btn">Продолжить</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
