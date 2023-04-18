<?php

/* @var $this \yii\web\View */

/* @var $content string */

use common\widgets\Alert;
use core\assets\FemidaAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

$guest = Yii::$app->user->isGuest;

if (!empty($_GET['utm_campaign']) && empty($_SESSION['utm_campaign']))
    $_SESSION['utm_campaign'] = $_GET['utm_campaign'];

if (!empty($_GET['utm_source']) && empty($_SESSION['utm_source']))
    $_SESSION['utm_source'] = $_GET['utm_source'];
$js = <<< JS
 $('.giveY1').on('submit', function (e) {
            $.ajax({
                url: "/site/form",
                type: "POST",
                data: $(".giveY1").serialize(),
                beforeSend: function () {
                    $('.tps2').fadeOut(300, function () {
                        $('.tps3').fadeIn(300);
                    });
                },
            }).done(function () {
            });
            e.preventDefault();
    });
    $('.batpodpShowPop').on('click', function() {
        $('.technoback').fadeIn(300);
    });

    $('.technoclose, .technoback').on('click', function(e) {
        if (e.target == this) $('.technoback').fadeOut(300);
    });
    $('.fdc1').mousemove(function() {
      $('.coolHover').css('color', '#7A6BDE');
    });    
    $('.fdc1').mouseleave(function() {
      $('.coolHover').css('color', '#ffffff');
    });
    $('.fdc2').mousemove(function() {
      $('.coolHover1').css('color', '#7A6BDE');
    });    
    $('.fdc2').mouseleave(function() {
      $('.coolHover1').css('color', '#ffffff');
    });
JS;
$this->registerJs($js);
FemidaAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php $this->head() ?>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m, e, t, r, i, k, a) {
            m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(89146044, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/89146044" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrap headTelss">
        <div class="compMenu">
            <div class="header">
                <div class="container">
                    <div class="pow naviget">
                        <menu class="pow rol-8 navg">
                            <a class="log" href="<?= Url::to(['index']) ?>">femida.force</a>
                            <nav class="nav linkgroup">
                                <a href="<?= Url::to(['/']) ?>">MYFORCE</a>
                                <a href="<?= Url::to(['/club']) ?>"> Клуб MYFORCE </a>
                            </nav>
                        </menu>
                        <?php if (!$guest) : ?>
                            <div class="rol-3 butgroop">
                                <?= Html::a('Выход', 'https://myforce.ru/site/logout/', ['class' => 'enter']) ?>
                                <?= Html::a('Кабинет', 'https://user.myforce.ru/femida/', ['class' => 'register']) ?>
                            </div>
                        <?php else : ?>
                            <div class="rol-3 butgroop">
                                <?= Html::a('Войти', '/registr?site=femida', ['class' => 'enter']) ?>
                                <?= Html::a('Регистрация', '/registr?site=femida', ['class' => 'register']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="header1">
                <menu class="container">
                    <nav class="pow navibet">
                        <a class="linnav <?= Yii::$app->controller->action->id == 'index' ? 'linnavActive' : '' ?>" href="<?= Url::to(['index']) ?>">
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4422 3.70064C10.1981 3.45656 9.80238 3.45656 9.5583 3.70064L3.75524 9.50369C3.3682 9.89073 3.16961 10.4276 3.21159 10.9733L3.65962 16.7977C3.68467 17.1234 3.95619 17.3748 4.28278 17.3748H8.12524V14.2498C8.12524 13.2143 8.96471 12.3748 10.0002 12.3748C11.0358 12.3748 11.8752 13.2143 11.8752 14.2498V17.3748H15.7177C16.0443 17.3748 16.3158 17.1234 16.3409 16.7977L16.7889 10.9733C16.8309 10.4276 16.6323 9.89073 16.2452 9.50369L10.4422 3.70064ZM8.67442 2.81675C9.40665 2.08452 10.5938 2.08452 11.3261 2.81675L17.1291 8.61981C17.7742 9.26488 18.1052 10.1596 18.0352 11.0692L17.5872 16.8936C17.512 17.8705 16.6975 18.6248 15.7177 18.6248H11.8752C11.1849 18.6248 10.6252 18.0652 10.6252 17.3748V14.2498C10.6252 13.9046 10.3454 13.6248 10.0002 13.6248C9.65506 13.6248 9.37524 13.9046 9.37524 14.2498V17.3748C9.37524 18.0652 8.8156 18.6248 8.12524 18.6248H4.28278C3.30302 18.6248 2.48845 17.8705 2.4133 16.8936L1.96527 11.0692C1.8953 10.1596 2.22629 9.26488 2.87136 8.61981L8.67442 2.81675Z" fill="#20293A" />
                            </svg>
                            <span>Главная</span>
                        </a>

                        <a class="linnav <?= Yii::$app->controller->action->id == 'franchizes' ? 'linnavActive' : '' ?>" href="<?= Url::to(['franchizes']) ?>">
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.69558 2.31464C9.88951 2.22845 10.1109 2.22845 10.3048 2.31464L17.8048 5.64797C18.0756 5.76835 18.2502 6.03694 18.2502 6.33333C18.2502 6.62972 18.0756 6.89832 17.8048 7.01869L10.3048 10.352C10.1109 10.4382 9.88951 10.4382 9.69558 10.352L2.19558 7.01869C1.92474 6.89832 1.75019 6.62972 1.75019 6.33333C1.75019 6.03694 1.92474 5.76835 2.19558 5.64797L9.69558 2.31464ZM4.34685 6.33333L10.0002 8.84593L15.6535 6.33333L10.0002 3.82074L4.34685 6.33333ZM1.81483 10.1954C1.98306 9.81688 2.42628 9.64641 2.80479 9.81464L10.0002 13.0126L17.1956 9.81464C17.5741 9.64641 18.0173 9.81688 18.1855 10.1954C18.3538 10.5739 18.1833 11.0171 17.8048 11.1854L10.3048 14.5187C10.1109 14.6049 9.88951 14.6049 9.69558 14.5187L2.19558 11.1854C1.81707 11.0171 1.6466 10.5739 1.81483 10.1954ZM2.80479 13.9813C2.42628 13.8131 1.98306 13.9835 1.81483 14.3621C1.6466 14.7406 1.81707 15.1838 2.19558 15.352L9.69558 18.6854C9.88951 18.7715 10.1109 18.7715 10.3048 18.6854L17.8048 15.352C18.1833 15.1838 18.3538 14.7406 18.1855 14.3621C18.0173 13.9835 17.5741 13.8131 17.1956 13.9813L10.0002 17.1793L2.80479 13.9813Z" fill="#20293A" />
                            </svg>
                            <span>Каталог франшиз</span>
                        </a>

                        <a class="linnav <?= Yii::$app->controller->action->id == 'technologies' ? 'linnavActive' : '' ?>" href="<?= Url::to(['technologies']) ?>">
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.69558 2.31464C9.88951 2.22845 10.1109 2.22845 10.3048 2.31464L17.8048 5.64797C18.0756 5.76835 18.2502 6.03694 18.2502 6.33333C18.2502 6.62972 18.0756 6.89832 17.8048 7.01869L10.3048 10.352C10.1109 10.4382 9.88951 10.4382 9.69558 10.352L2.19558 7.01869C1.92474 6.89832 1.75019 6.62972 1.75019 6.33333C1.75019 6.03694 1.92474 5.76835 2.19558 5.64797L9.69558 2.31464ZM4.34685 6.33333L10.0002 8.84593L15.6535 6.33333L10.0002 3.82074L4.34685 6.33333ZM1.81483 10.1954C1.98306 9.81688 2.42628 9.64641 2.80479 9.81464L10.0002 13.0126L17.1956 9.81464C17.5741 9.64641 18.0173 9.81688 18.1855 10.1954C18.3538 10.5739 18.1833 11.0171 17.8048 11.1854L10.3048 14.5187C10.1109 14.6049 9.88951 14.6049 9.69558 14.5187L2.19558 11.1854C1.81707 11.0171 1.6466 10.5739 1.81483 10.1954ZM2.80479 13.9813C2.42628 13.8131 1.98306 13.9835 1.81483 14.3621C1.6466 14.7406 1.81707 15.1838 2.19558 15.352L9.69558 18.6854C9.88951 18.7715 10.1109 18.7715 10.3048 18.6854L17.8048 15.352C18.1833 15.1838 18.3538 14.7406 18.1855 14.3621C18.0173 13.9835 17.5741 13.8131 17.1956 13.9813L10.0002 17.1793L2.80479 13.9813Z" fill="#20293A" />
                            </svg>
                            <span>Каталог технологий</span>
                        </a>

                        <a class="linnav <?= Yii::$app->controller->action->id == 'partnership' ? 'linnavActive' : '' ?>" href="<?= Url::to(['partnership']) ?>">
                            <svg width="20" height="21" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19 15.5V5.5L1 5.5V15.5H19ZM20 5.5V15.5C20 16.0523 19.5523 16.5 19 16.5H1C0.447715 16.5 0 16.0523 0 15.5V5.5C0 4.94772 0.447715 4.5 1 4.5H19C19.5523 4.5 20 4.94772 20 5.5ZM2.66667 7.41659C2.66667 7.27851 2.7786 7.16659 2.91667 7.16659H7.75C7.88807 7.16659 8 7.27851 8 7.41659V13.5833C8 13.7213 7.88807 13.8333 7.75 13.8333H2.91667C2.7786 13.8333 2.66667 13.7213 2.66667 13.5833V7.41659ZM10 9.99992C9.72386 9.99992 9.5 10.2238 9.5 10.4999C9.5 10.7761 9.72386 10.9999 10 10.9999H14C14.2761 10.9999 14.5 10.7761 14.5 10.4999C14.5 10.2238 14.2761 9.99992 14 9.99992H10ZM9.5 13.1666C9.5 12.8904 9.72386 12.6666 10 12.6666H16.6667C16.9428 12.6666 17.1667 12.8904 17.1667 13.1666C17.1667 13.4427 16.9428 13.6666 16.6667 13.6666H10C9.72386 13.6666 9.5 13.4427 9.5 13.1666ZM10 7.33325C9.72386 7.33325 9.5 7.55711 9.5 7.83325C9.5 8.10939 9.72386 8.33325 10 8.33325H15.3333C15.6095 8.33325 15.8333 8.10939 15.8333 7.83325C15.8333 7.55711 15.6095 7.33325 15.3333 7.33325H10Z" fill="#181240" />
                            </svg>
                            <span>Стать партнером</span>
                        </a>

                        <a style="cursor: pointer" class="linnav <?= Yii::$app->controller->action->id == 'about' ? 'linnavActive' : '' ?>" href="<?= Url::to(['about']) ?>">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.4078 2.46967C19.2672 2.32902 19.0764 2.25 18.8775 2.25C18.6786 2.25 18.4878 2.32902 18.3472 2.46967L10.3922 10.4246C10.3099 10.507 10.2479 10.6073 10.211 10.7178L9.15039 13.8998C9.06055 14.1693 9.13069 14.4664 9.33157 14.6673C9.53244 14.8681 9.82957 14.9383 10.0991 14.8484L13.281 13.7878C13.3915 13.751 13.4919 13.6889 13.5742 13.6066L21.5292 5.65165C21.8221 5.35876 21.8221 4.88388 21.5292 4.59099L19.4078 2.46967ZM11.5781 11.3601L18.8775 4.06066L19.9382 5.12132L12.6387 12.4207L11.0478 12.9511L11.5781 11.3601Z" fill="#010101" />
                                <path d="M3 3.75C2.58579 3.75 2.25 4.08579 2.25 4.5L2.25 21C2.25 21.4142 2.58579 21.75 3 21.75H19.5C19.9142 21.75 20.25 21.4142 20.25 21V10.5C20.25 10.0858 19.9142 9.75 19.5 9.75C19.0858 9.75 18.75 10.0858 18.75 10.5V20.25H3.75L3.75 5.25H13.5C13.9142 5.25 14.25 4.91421 14.25 4.5C14.25 4.08579 13.9142 3.75 13.5 3.75H3Z" fill="#010101" />
                            </svg>
                            <span>О проекте</span>
                        </a>
                    </nav>
                </menu>
            </div>
        </div>
        <div class="tel_header">
            <a class="log" href="<?= Url::to(['index']) ?>">femida.force</a>
            <div class="iconBurg">
                <img class="menushow" src="<?= Url::to(['/img/burg.webp']) ?>" alt="Burger Menu">
                <img class="menuclose" src="<?= Url::to(['/img/closeburg.webp']) ?>" alt="Burger Menu">
            </div>
            <nav class="menushows">
                <a href="<?= Url::to(['/']) ?>">MYFORCE</a>
                <a href="<?= Url::to(['/club']) ?>"> Клуб MYFORCE </a>
                <hr>
                <a class="<?= Yii::$app->controller->action->id == 'index' ? 'linkgroupActive' : '' ?>" href="<?= Url::to(['index']) ?>">Главная</a>
                <a class="<?= Yii::$app->controller->action->id == 'about' ? 'linkgroupActive' : '' ?>" href="<?= Url::to(['about']) ?>">О проекте</a>
                <a class="<?= Yii::$app->controller->action->id == 'franchizes' ? 'linkgroupActive' : '' ?>" href="<?= Url::to(['/femida/franchizes']) ?>">Каталог франшиз</a>
                <a class="<?= Yii::$app->controller->action->id == 'technologies' ? 'linkgroupActive' : '' ?>" href="<?= Url::to(['/femida/technologies']) ?>">Каталог технологий</a>
                <a class="<?= Yii::$app->controller->action->id == 'partnership' ? 'linkgroupActive' : '' ?>" href="<?= Url::to(['partnership']) ?>">Стать партнером</a>
                <?php if (!$guest) : ?>
                    <div class="butgroop">
                        <?= Html::a('Выход', 'https://myforce.ru/site/logout/', ['class' => 'enter']) ?>
                        <?= Html::a('Кабинет', 'https://user.myforce.ru/femida/', ['class' => 'register']) ?>
                    </div>
                <?php else : ?>
                    <div class="butgroop">
                        <?= Html::a('Войти', '/registr?site=femida', ['class' => 'enter link-on-popap1']) ?>
                        <?= Html::a('Регистрация', '/registr?site=femida', ['class' => 'register BLS6CBORID-BTN']) ?>
                    </div>
                <?php endif; ?>
            </nav>
        </div>
    </div>

    <div><?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?></div>
    <div><?= Alert::widget() ?></div>
    <div><?= $content ?></div>

    <div class="registerBack">
        <div class="registerPop">
            <div class="popregclose">&times;</div>
            <?= Html::beginForm('', 'post', ['class' => 'registerForm']) ?>
            <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
            <input type="hidden" name="formType" value="Попап регистрации">
            <input type="hidden" name="pipeline" value="">
            <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
            <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
            <input type="hidden" name="service" value="">
            <p class="registerPopP1">Войдите в аккаунт</p>
            <p class="registerPopP2">Введите свои данные</p>
            <input class="input1" required placeholder="Email" name="email" minlength="3" type="email">
            <input class="input1" required placeholder="Пароль" name="password" type="password">
            <?= Html::endForm() ?>
        </div>
    </div>

    <footer>
        <div class="foot1">
            <div class="container">
                <div class="foot1__item">
                    <div class="foot1__item-content">
                        <h3 class="foot1__item-title">
                            Как выбрать франшизу?
                        </h3>
                        <p class="foot1__item-text">
                            Оставьте заявку и получите:
                        </p>
                        <ul class="foot1__item-list">
                            <li class="foot1__item-li">
                                Анализ перспективных сфер бизнеса
                            </li>
                            <li class="foot1__item-li">
                                Консультацию эксперта
                            </li>
                            <li class="foot1__item-li">
                                Персональный подбор франшизы
                            </li>
                            <li class="foot1__item-li">
                                Готовую бизнес-модель для быстрого старта
                            </li>
                        </ul>

                        <p class="foot1__item-subtitle">
                            Компетентная поддержка — лучшая защита от провалов
                        </p>

                        <button type="button" class="foot1__item-btn batpodpShowPop">Подобрать франшизу</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="foot2">
            <div class="container">
                <div class="foottop">
                    <div class="rol-4 telsMals">
                        <div class="pow tells">
                            <img src="<?= Url::to(['/img/phone.svg']) ?>" alt="icon phone">
                            <a class="telmail" href="<?= Url::to(['tel:8 495 118 39 34']) ?>">8 495 118 39 34</a>
                            <p class="telmailp1">Бесплатный звонок для всех городов России</p>
                        </div>
                        <div class="pow mails">
                            <img src="<?= Url::to(['/img/mail.svg']) ?>" alt="mail phone">
                            <a class="telmail" href="<?= Url::to(['mailto:general@myforce.ru']) ?>">general@myforce.ru</a>
                        </div>
                        <?= Html::button('Получить консультацию', ['class' => 'footbtn batpodpShowPop']) ?>
                    </div>
                    <nav class="rol-5 pow classWraps">
                        <div class="rol-5 menus1">
                            <div class="menu1">
                                <p class="coolHover">Меню</p>
                                <div class="fdc fdc1">
                                    <a href="<?= Url::to(['/femida/', '#' => 'catalogFranh']) ?>">Каталог франшиз</a>
                                    <a href="<?= Url::to(['partnership']) ?>">Стать партнером</a>
                                    <a href="<?= Url::to(['/femida/', '#' => 'NewsFranchaize']) ?>">Новости
                                        франчайзинга</a>
                                    <a href="<?= Url::to(['about']) ?>">О проекте</a>
                                </div>
                            </div>
                        </div>
                        <div class="rol-5 menus1">
                            <div class="menu1">
                                <p class="coolHover1">Другие проекты</p>
                                <div class="fdc fdc2">
                                    <a href="<?= Url::to(['/lead']) ?>">Лиды</a>
                                    <!--                                <a href="--><? //= Url::to(['#'])
                                                                                    ?>
                                    <!--">Реклама</a>-->
                                    <!--                                <a href="--><? //= Url::to(['#'])
                                                                                    ?>
                                    <!--">Обучение</a>-->
                                    <!--                                <a href="--><? //= Url::to(['#'])
                                                                                    ?>
                                    <!--">Разработка</a>-->
                                    <!--                                <a href="--><? //= Url::to(['#'])
                                                                                    ?>
                                    <!--">Арбитражное управление</a>-->

                                </div>
                            </div>
                        </div>
                    </nav>
                    <div class="rol-xl-3">
                        <p class="addres">344000, Россия, г. Ростов-на-Дону, пр-т Ворошиловский , д 82/4. оф. 99, 7
                            этаж</p>
                        <p class="inn">ИНН: 6167130086<br>
                            ОГРН: 1156196049415</p>
                    </div>
                </div>
                <div class="footbot pow">
                    <div class="rol-5 textBotFoot">
                        <a target="_blank" href="<?= Url::to(['/policy.pdf']) ?>" class="footbotp1">*отправляя формы на
                            данном сайте, вы даете согласие на обработку персональных
                            данных в соответствии с 152-ФЗ</a><br>
                        <a target="_blank" href="<?= Url::to(['/oferta.pdf?v=16']) ?>" class="footbotp1">Договор публичной
                            оферты</a><br>
                        <a target="_blank" href="<?= Url::to(['/oferta-diarova.pdf?v=16']) ?>" class="footbotp1">Договор
                            оферты</a>
                    </div>
                    <div class="rol-3 links">
                        <a target="_blank" href="<?= Url::to('http://instagram.com/myforce.ru') ?>"><img src="<?= Url::to(['/img/ig-circle.svg']) ?>" alt="instagram icon"></a>
                        <a target="_blank" href="<?= Url::to('https://t.me/myforce_business') ?>"><img src="<?= Url::to(['/img/tg-circle.svg']) ?>" alt="telegram icon"></a>
                        <a style="transform: scale(0.94)" target="_blank" href="<?= Url::to('https://vm.tiktok.com/ZSJtjjbdj/') ?>"><img src="<?= Url::to(['/img/tt-circle.svg']) ?>" alt="tik-tok icon"></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <div class="technoback">
        <div class="technopop tps2">
            <div class="technoclose">&times;</div>
            <div class="giveYsl">
                <p class="giveYslP1">Отправить заявку</p>
                <p class="giveYslP2">Оставьте свои данные для получения подробной консультации</p>
                <?= Html::beginForm('', 'post', ['class' => 'giveY1']) ?>
                <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
                <input type="hidden" name="formType" value="Форма обратной связи">
                <input type="hidden" name="pipeline" value="64">
                <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
                <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
                <input type="hidden" name="service" value="">
                <input class="input1" required placeholder="ФИО" name="name" minlength="3" type="text">
                <input class="input1" required placeholder="Телефон" name="phone" type="tel">
                <div class="pow">
                    <button class="orangeLinkBtn">Получить</button>
                    <p class="confirmForm">Нажимая на кнопку «Получить», я соглашаюсь с условиями обработки
                        персональных данных</p>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
        <div class="technopop tps3 dnone">
            <div class="technoclose">&times;</div>
            <div class="giveYsl">
                <p class="giveYslP1">Спасибо за заявку!</p>
                <p class="giveYslP2">Через несколько минут с Вами свяжется специалист по франшизам </p>
                <div style="text-align: center"><img src="<?= Url::to(['/img/LastRef.webp']) ?>" alt="hand-phone icon">
                </div>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>