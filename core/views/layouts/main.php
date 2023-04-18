<?php


/* @var $this \yii\web\View */

/* @var $content string */

use common\models\LeadsCategory;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use core\assets\AppAsset;
use common\widgets\Alert;
use yii\helpers\Url;
use common\models\Cases;
use common\models\helpers\UrlHelper;

$case = Cases::find()->orderBy('id desc')->asArray()->select(['link', 'logo'])->all();
$guest = Yii::$app->user->isGuest;
if (!empty($_GET['utm_campaign']) && empty($_SESSION['utm_campaign']))
  $_SESSION['utm_campaign'] = $_GET['utm_campaign'];

if (!empty($_GET['utm_source']) && empty($_SESSION['utm_source']))
  $_SESSION['utm_source'] = $_GET['utm_source'];

$js = <<< JS

JS;
$this->registerJs($js);


AppAsset::register($this);
$category = LeadsCategory::find()->with('templates')->asArray()->orderBy('id asc')->all();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Rubik:ital,wght@1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <meta name="yandex-verification" content="a8d5131a3fb7ebb2" />
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
    (function(m, e, t, r, i, k, a) {
        m[i] = m[i] || function() {
            (m[i].a = m[i].a || []).push(arguments)
        };
        m[i].l = 1 * new Date();
        k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(
            k, a)
    })
    (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

    ym(87178712, "init", {
        clickmap: true,
        trackLinks: true,
        accurateTrackBounce: true,
        webvisor: true
    });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/87178712" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
</head>

<body>
    <?php $this->beginBody() ?>

    <header class="header">
        <div class="header_top">
            <div class="header_cont">
                <div class="Logo">
                    <a href="<?= Url::to(['/']) ?>">
                        <img src="<?= Url::to(['/img/mainimg/logo.svg']) ?>" alt="logo">
                    </a>

                </div>
                <nav class="header__nav">
                    <a href="<?= Url::to(['/femida/']) ?>" class="drop-menu-site-name">Франшиза</a>
                    <a href="<?= Url::to(['/lead/']) ?>" class="drop-menu-site-name">Лидогенерация</a>
                    <a href="<?= Url::to(['/lidy-na-bankrotstvo']) ?>" class="drop-menu-site-name">Лиды на банкротство</a>
                    <a href="<?= Url::to(['/arbitraj']) ?>" class="drop-menu-site-name">Арбитраж</a>
                </nav>
                <div class="burger BTN-burger">
                    <span class="burger-strip"></span>
                    <span class="burger-strip"></span>
                    <span class="burger-strip"></span>
                </div>
            </div>
        </div>
    </header>
    <div class="Burger-menu">
        <menu class="Burger-menu-cont">
            <?php if (!$guest) : ?>
            <div class="Burger-control">
                <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                    <path
                        d="M34.2548 13.9426V25.0575C34.2548 26.8775 33.2798 28.5676 31.7035 29.4938L22.051 35.0676C20.4748 35.9776 18.5248 35.9776 16.9323 35.0676L7.27977 29.4938C5.70352 28.5838 4.72852 26.8938 4.72852 25.0575V13.9426C4.72852 12.1226 5.70352 10.4325 7.27977 9.50624L16.9323 3.9325C18.5085 3.0225 20.4585 3.0225 22.051 3.9325L31.7035 9.50624C33.2798 10.4325 34.2548 12.1063 34.2548 13.9426Z"
                        stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M19.4999 17.875C21.591 17.875 23.2861 16.1798 23.2861 14.0887C23.2861 11.9976 21.591 10.3026 19.4999 10.3026C17.4088 10.3026 15.7136 11.9976 15.7136 14.0887C15.7136 16.1798 17.4088 17.875 19.4999 17.875Z"
                        stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M26 27.0724C26 24.1474 23.0913 21.775 19.5 21.775C15.9087 21.775 13 24.1474 13 27.0724"
                        stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <a style="color: white; text-decoration: none" class="EnterLk"
                    href="https://myforce.ru/site/logout/">Выход</a>
                <a style="color: white; text-decoration: none" class="Registration"
                    href="https://user.myforce.ru/lead-force/">Кабинет</a>
            </div>
            <?php else : ?>
            <div class="Burger-control">
                <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                    <path
                        d="M34.2548 13.9426V25.0575C34.2548 26.8775 33.2798 28.5676 31.7035 29.4938L22.051 35.0676C20.4748 35.9776 18.5248 35.9776 16.9323 35.0676L7.27977 29.4938C5.70352 28.5838 4.72852 26.8938 4.72852 25.0575V13.9426C4.72852 12.1226 5.70352 10.4325 7.27977 9.50624L16.9323 3.9325C18.5085 3.0225 20.4585 3.0225 22.051 3.9325L31.7035 9.50624C33.2798 10.4325 34.2548 12.1063 34.2548 13.9426Z"
                        stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path
                        d="M19.4999 17.875C21.591 17.875 23.2861 16.1798 23.2861 14.0887C23.2861 11.9976 21.591 10.3026 19.4999 10.3026C17.4088 10.3026 15.7136 11.9976 15.7136 14.0887C15.7136 16.1798 17.4088 17.875 19.4999 17.875Z"
                        stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M26 27.0724C26 24.1474 23.0913 21.775 19.5 21.775C15.9087 21.775 13 24.1474 13 27.0724"
                        stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <a href="<?= Url::to(['/registr?site=lead']) ?>" class="EnterLk enters__lk">
                    <p>Войти</p>
                </a>
                <a href="<?= Url::to(['/registr?site=lead']) ?>" class="Registration">
                    <p>Регистрация</p>
                </a>
            </div>
            <?php endif; ?>
            <a href="<?= Url::to(['/femida/']) ?>">Франшиза по банкротству</a>
            <div class="accordion">
                <p>Лидогенерация</p>
                <div>
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M26.375 11.0938L15.875 21.625C15.75 21.75 15.6146 21.8383 15.4688 21.89C15.3229 21.9425 15.1667 21.9688 15 21.9688C14.8333 21.9688 14.6771 21.9425 14.5313 21.89C14.3854 21.8383 14.25 21.75 14.125 21.625L3.59375 11.0938C3.30208 10.8021 3.15625 10.4375 3.15625 10C3.15625 9.5625 3.3125 9.1875 3.625 8.875C3.9375 8.5625 4.30208 8.40625 4.71875 8.40625C5.13542 8.40625 5.5 8.5625 5.8125 8.875L15 18.0625L24.1875 8.875C24.4792 8.58334 24.8383 8.4375 25.265 8.4375C25.6925 8.4375 26.0625 8.59375 26.375 8.90625C26.6875 9.21875 26.8438 9.58334 26.8438 10C26.8438 10.4167 26.6875 10.7813 26.375 11.0938Z"
                            fill="#ffffff"></path>
                    </svg>
                </div>
            </div>
            <div class="accordion-content">
                <?php if (!empty($category)): ?>
                    <?php foreach($category as $key => $val): ?>
                        <?php if(empty($val['templates'])) continue; ?>
                        <a href="<?= Url::to(['/lead?filter%5Bcategory%5D%5B%5D=' . $val['link_name'], '#' => 'TL_sec2']) ?>"><?= $val['name'] ?></a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <a href="<?= Url::to(['/lead/traffic-quality']) ?>">Качество трафика</a>
                <?php endif; ?>
            </div>
            <a href="<?= Url::to(['/lidy-na-bankrotstvo']) ?>" class="drop-menu-site-name">Лиды на банкротство</a>
            <a href="<?= Url::to(['/arbitraj']) ?>">Арбитраж</a>
            <a href="<?= Url::to(['/news']) ?>">Статьи для бизнеса</a>
        </menu>
    </div>

    <?= Breadcrumbs::widget([
    'links' => isset($this->params['/breadcrumbs']) ? $this->params['breadcrumbs'] : [],
  ]) ?>
    <?= Alert::widget() ?>
    <?= $content ?>

    <?php if (Yii::$app->controller->action->id == 'events') : ?>
    <section class="baner-registr baner-registr--background">
        <div class="container">
            <div class="baner-registr__inner">
                <div class="baner-registr__content">
                    <h4 class="baner-registr__title">
                        Зарегистрируйся сейчас и получи 1  000  ₽ на баланс
                    </h4>
                    <p class="baner-registr__text">
                        Получайте лиды, проходите курсы и настраивайте рекламу в одном кабинете
                    </p>
                    <a href="<?= Url::to(['/registr?site=lead']) ?>" class="baner-registr__btn">Регистрация</a>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>


    <footer class="footer">
        <div class="container">
            <div class="footer__wrap">
                <div class="footer__item">
                    <h2 class="footer__title">Все, что нужно для вашего бизнеса</h2>
                    <div class="footer__block">
                        <ul class="footer__nav">
                            <li class="footer__nav_link">
                                <a href="<?= Url::to(['/femida/']) ?>">FEMIDA.FORCE</a>
                            </li>
                            <li class="footer__nav_link">
                                <a href="<?= Url::to(['/lidy-na-bankrotstvo']) ?>">Лиды на банкротство</a>
                            </li>
                            <li class="footer__nav_link">
                                <a href="<?= Url::to(['/arbitraj']) ?>">FORCE. ARBITR</a>
                            </li>
                            <li class="footer__nav_link">
                                <a href="<?= Url::to(['/news']) ?>">Статьи для бизнеса</a>
                            </li>
                        </ul>
                        <ul class="footer__nav footer__nav_g15">
                            <li class="footer__nav_link">
                                <a href="<?= Url::to(['/lead/']) ?>">LEAD.FORCE</a>
                            </li>
                            <li>
                                <a href="<?= Url::to(['/lead/traffic-quality']) ?>">Качество трафика</a>
                            </li>
                            <?php if (!empty($category)): ?>
                                <?php foreach($category as $key => $val): ?>
                                    <?php if(empty($val['templates'])) continue; ?>
                                    <li>
                                        <a href="<?= Url::to(['/lead?filter%5Bcategory%5D%5B%5D=' . $val['link_name'], '#' => 'TL_sec2']) ?>"><?= $val['name'] ?></a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="footer__item">
                    <h2 class="footer__title footer__title_right">Контакты</h2>
                    <ul class="footer__nav footer__nav_contacts">
                        <li class="footer__nav_link footer__nav_link_fz20">
                            <a href="<?= Url::to('tel:+79666663924') ?>">+7 495 118 3934</a>
                        </li>
                        <li class="footer__nav_link footer__nav_link_fz20">
                            <a href="<?= Url::to('mailto:general@myforce.ru') ?>">general@myforce.ru</a>
                        </li>
                        <li>
                            <address>344038 г.Ростов-на-Дону, Ворошиловский проспект 82/4, офис 99</address>
                        </li>
                        <li>
                            <p>ИНН: 6167130086</p>
                            <p>ОГРН: 1156196049415</p>
                        </li>

                        <li>
                            <a href="<?= Url::to(['/policy.pdf']) ?>">Политика конфиденциальности</a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/policy.pdf']) ?>">Согласие на обработку данных</a>
                        </li>
                        <li>
                            <a href="<?=  Url::to(['/oferta.pdf?v=16']) ?>">Договор публичной оферты</a>
                        </li>
                        <li>
                            <a href="<?= Url::to(['/oferta-diarova.pdf?v=16']) ?>">Договор оферты</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>




    <!-- Регистрация -->
    <div style="<?= !empty($_GET['registration']) ? "display:block;" : '' ?>" class="By__Leads__Background__Popap">
    </div>
    <div style="<?= !empty($_GET['registration']) ? "display:block;" : '' ?>"
        class="By__Leads__popap__registr__contant-margin">
        <div class="By__Leads__popap__registr">
            <img src="<?= Url::to(['/img/mainimg/close.png']) ?>" class="Popap_reg_on_leads_page">
            <?= Html::beginForm('', 'post', ['id' => 'registtraton']) ?>
            <input type="hidden" value="<?= base64_decode($_SERVER['REMOTE_ADDR']) ?>" name="fragment">
            <?= Html::endForm(); ?>
            <div class="By__Leads__popap__registr__contant">
                <div class="R_C_up">
                    <p class="R_C_up-ttl">Регистрация</p>
                    <p class="R_C_up-sttl">Введите свои данные</p>
                </div>
                <div class="R_C_medle">
                    <div class="LIN_C_medle-error">
                        Пользователь с таким телефоном не найден
                    </div>
                    <input class="R_F_U_P" pattern="[A-z,А-я ]*" required placeholder="ФИО" form="registtraton"
                        type="text" name="username_r" id="username_r">
                    <input class="R_F_U_P" required placeholder="Телефон" form="registtraton" type="tel" name="phone"
                        id="phone_r">
                </div>
                <div class="error-block-before-sms" style="color: red;">

                </div>
                <div class="R_C_down">
                    <div class="R_C_down__Left">
                        <p class="text">Есть аккаунт?</p>
                        <p class="link-on-popap-log-in">Войти</p>
                    </div>
                    <div class="R_C_down__Right">
                        <button form="registtraton" class="btn-registration" type="button">Зарегистрироваться</button>
                        <p class="info">Нажимая «Зарегистрироваться» Вы соглашаетесь, что ознакомлены с <a
                                href="#">условиями
                                использования</a> и <a href="#">политикой конфиденциальности</a></p>
                    </div>
                </div>
            </div>
            <div class="By__Leads__popap__registr__contant-2">
                <?= Html::beginForm('', 'post', ['id' => 'coderegist']) ?>
                <input type="hidden" value="<?= base64_decode($_SERVER['REMOTE_ADDR']) ?>" name="fragment">
                <?= Html::endForm(); ?>
                <div class="R_C_up">
                    <p class="R_C_up-ttl">Регистрация</p>
                    <p class="R_C_up-sttl">Введите код, полученный на номер телефон <br><span class="R_C_phone"> +7(999)
                            999-99-99</span><span class="linkonbackstap"> (изменить)</span></p>
                </div>
                <div class="R_C_medle_С Wrapper__fix">
                    <div class="LIN_C_medle-error">
                        Пользователь с таким телефоном не найден
                    </div>
                    <input form="coderegist" class="R_F_U_P_C" required placeholder="Код" type="text" name="code_r"
                        id="code_r">
                    <div class="sendcoder">
                        <p class="sendcodeagain">Отправить код повторно через <span
                                class="numertimerinsendcode">59</span>с
                        </p>
                        <p class="sendcodeagainnow">Отправить код повторно</p>
                    </div>
                </div>
                <div class="message__error"></div>
                <div class="R_C_down2">
                    <div class="R_C_down__Left2">
                        <p class="text">Если Вы не получили код в течении 5 минут — напишите нам на почту <a
                                href="mailto:general@myforce.ru" class="mailforhelpregist">general@myforce.ru</a></p>
                    </div>
                    <div class="R_C_down__Right2">
                        <button form="coderegist" class="btn-registration2" type="button">Перейти в кабинет</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="By__Leads__popap__LIN__contant-margin">
        <div class="By__Leads__popap__LIN">
            <img src="<?= Url::to(['/img/mainimg/close.png']) ?>" class="Popap_reg_on_leads_page">

            <?= Html::beginForm('', 'post', ['id' => 'LIN']) ?>
            <input type="hidden" value="<?= base64_decode($_SERVER['REMOTE_ADDR']) ?>" name="fragment">
            <?= Html::endForm(); ?>

            <div class="By__Leads__popap__LIN__contant">
                <div class="LIN_C_up">
                    <p class="LIN_C_up-ttl">Войдите в аккаунт</p>
                    <p class="LIN_C_up-sttl">Введите свои данные</p>
                </div>
                <div class="LIN_C_medle">
                    <div class="LIN_C_medle-error">
                        Пользователь с таким телефоном не найден
                    </div>
                    <input class="LIN_F_U_P" required placeholder="Телефон" form="LIN" type="tel" name="mml" id="mml">
                    <input class="LIN_F_U_P" required placeholder="Пароль" form="LIN" type="password" name="pass"
                        id="pass">
                    <p class="LIN-forgpass">Забыли пароль?</p>
                </div>
                <div class="LIN_C_down">
                    <div class="LIN_C_down__Left">
                        <p class="text">Нет аккаунта?</p>
                        <p class="link-on-popap-reg">Зарегистрироваться</p>
                    </div>
                    <div class="LIN_C_down__Right">
                        <button form="LIN" class="btn-LIN btn-login-user" type="button">Войти</button>
                    </div>
                </div>
            </div>

            <div class="By__Leads__popap__LIN__contant-2">
                <?= Html::beginForm('', 'post', ['id' => 'passback']) ?>
                <input type="hidden" value="<?= base64_decode($_SERVER['REMOTE_ADDR']) ?>" name="fragment">
                <?= Html::endForm(); ?>
                <div class="LIN_C_up">
                    <p class="LIN_C_up-ttl">Восстановление пароля</p>
                    <p class="LIN_C_up-sttl">Введите номер телефона</p>
                </div>
                <div class="LIN_C_medle_С">
                    <div>
                        <div><input form="passback" class="LIN_F_U_P_C" required placeholder="Телефон" type="tel"
                                name="phonepb" id="phonepb"></div>
                        <div class="restore-sms-errors" style="color: red; margin-top: 5px"></div>
                    </div>
                </div>
                <div class="LIN_C_down2">
                    <div class="LIN_C_down__Left2">
                        <p class="text">Вспомнили пароль?</p>
                        <p class="back">Войти</p>
                    </div>
                    <div class="LIN_C_down__Right2">
                        <button form="passback" class="btn-LIN2" type="button">Отправить код</button>
                    </div>
                </div>
            </div>

            <div class="By__Leads__popap__LIN__contant-3">
                <?= Html::beginForm('', 'post', ['id' => 'codereset']) ?>
                <input type="hidden" value="<?= base64_decode($_SERVER['REMOTE_ADDR']) ?>" name="fragment">
                <?= Html::endForm(); ?>
                <div class="LIN_C_up">
                    <p class="LIN_C_up-ttl">Восстановление пароля</p>
                    <p class="LIN_C_up-sttl">Введите код</p>
                </div>
                <div class="LIN_C_medle_С">
                    <div>
                        <div>
                            <input form="codereset" class="LIN2_F_U_P_C" style="letter-spacing: 6px" maxlength="6"
                                required placeholder="______" type="text" name="code-2" id="code-2">
                        </div>
                        <div class="restore-sms-errors" style="color: red; margin-top: 5px"></div>
                    </div>
                    <div class="codereseter" style="display: none">
                        <p class="codereset">Отправить код повторно через <span class="numertimerinsendcode2"></span>с
                        </p>
                        <p class="sendcodeagainnow2">Отправить код повторно</p>
                    </div>
                </div>
                <div class="LIN_C_down3">
                    <div class="LIN_C_down__Left3">
                        <p class="text">Если Вы не получили код в течении 5 минут — напишите нам на почту <a
                                href="mailto:general@myforce.ru" class="mailforhelpregist">general@myforce.ru</a></p>
                    </div>
                    <div class="LIN_C_down__Right3">
                        <button form="coderegist" class="btn-LIN confirm-reset-password-btn" type="button">Перейти в
                            кабинет</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Регистрация   -->
    <div class="By__Leads__popap__consult__contant-margin">
        <div class="By__Leads__popap__consult">
            <img src="<?= Url::to(['/img/Exid.svg']) ?>" class="Popap_reg_on_leads_page">
            <?= Html::beginForm('', 'post', ['id' => 'consultation']) ?>
            <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
            <input type="hidden" name="formType" value="Форма обратной связи">
            <input type="hidden" name="pipeline" value="104">
            <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
            <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
            <input type="hidden" name="service" value="">
            <input type="hidden" name="section" value="Консультация со страницы:<?= $this->title ?>">
            <div class="By__Leads__popap__consult__contant">
                <div class="C_C_up">
                    <p class="C_C_up-ttl">Отправить заявку</p>
                    <p class="C_C_up-sttl">Оставьте свои данные для получения подробной консультации</p>
                </div>
                <div class="C_C_medle">

                    <input class="C_F_U_P" pattern="[A-z,А-я ]*" required placeholder="ФИО" form="consultation"
                        type="text" name="name" id="username_C">
                    <input class="C_F_U_P" required placeholder="Телефон" form="consultation" type="tel" name="phone"
                        id="phone_C">
                </div>
                <div class="C_C_down">
                    <button form="consultation" class="btn" type="submit">Отправить</button>
                    <p class="info">Нажимая на кнопку «Отправить», я соглашаюсь с условиями обработки персональных
                        данных</p>
                </div>
            </div>
            <div class="By__Leads__popap__consult__contant-2">
                <div class="C_C_up">
                    <p class="C_C_up-ttl">Спасибо за заявку!</p>
                    <p class="C_C_up-sttl">Через несколько минут с Вами свяжется наш специалист</p>
                </div>
                <div class="C_C_D">
                    <img src="<?= Url::to(['/img/mainimg/s2-item1.png']) ?>">
                </div>
            </div>
            <?= Html::endForm(); ?>
        </div>
    </div>

    <div class="By__Leads__popap__card__contant-margin">
        <div class="By__Leads__popap__card">
            <img src="<?= Url::to(['/img/icon/Exit.svg']) ?>" class="Popap_reg_on_leads_page">
            <?= Html::beginForm('', 'post', ['id' => 'card']) ?>
            <input type="hidden" name="URL" value="<?= Url::current([], true) ?>">
            <input type="hidden" name="formType" value="" id="formType">
            <input type="hidden" name="pipeline" value="104">
            <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
            <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
            <input type="hidden" name="service" value="">
            <div class="By__Leads__popap__card__contant">
                <div class="C_C_up">
                    <p class="C_C_up-ttl">Отправить заявку</p>
                    <p class="C_C_up-sttl">Оставьте свои данные для получения подробной консультации.</p>
                </div>
                <div class="C_C_medle">

                    <input class="C_F_U_P" pattern="[A-z,А-я ]*" required placeholder="ФИО" form="card" type="text"
                        name="name" id="username_Ca">
                    <input class="C_F_U_P" required placeholder="Телефон" form="card" type="text" name="phone"
                        id="phone_Ca">
                </div>
                <div class="C_C_down C_C_down--column">
                    <button form="card" class="btn-card" type="submit">Отправить</button>
                    <a href="<?= Url::to(['/policy.pdf']) ?>" target="_blank">Нажимая на кнопку «Отправить», я
                        соглашаюсь с условиями обработки персональных данных</a>

                </div>
            </div>
            <div class="By__Leads__popap__card__contant-2">
                <div class="C_C_up">
                    <div class="C_C_up__wrap">
                        <img src="<?= Url::to(['/img/thanks-popup.svg']) ?>" alt="Спасибо!">

                        <p class="C_C_up-ttl">Спасибо!</p>
                        <p class="C_C_up-sttl text-al-cent">Ваша заявка принята. В ближайшее время с вами свяжутся для
                            дальнейшей консультации.</p>

                        <button class="btn-card Popap_reg_on_leads_page btn-modal-prev" >Вернуться назад</button>
                    </div>
                </div>

            </div>


            <?= Html::endForm(); ?>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>