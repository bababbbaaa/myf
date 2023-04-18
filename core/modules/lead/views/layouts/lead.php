<?php

/* @var $this \yii\web\View */

/* @var $content string */

use common\models\News;
use common\widgets\Alert;
use core\assets\LeadAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;

if (!empty($_GET['utm_campaign']) && empty($_SESSION['utm_campaign']))
    $_SESSION['utm_campaign'] = $_GET['utm_campaign'];

if (!empty($_GET['utm_source']) && empty($_SESSION['utm_source']))
    $_SESSION['utm_source'] = $_GET['utm_source'];

$news = News::find()->asArray()->orderBy('id desc')->where(['OR', ['tag' => 'маркетинг'], ['tag' => 'общие']])->limit(5)->all();
$guest = Yii::$app->user->isGuest;
LeadAsset::register($this);
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
</head>

<body>
    <?php $this->beginBody() ?>

    <header class="wrap headTelss">
        <menu class="compMenu">
            <div class="header">
                <div class="container">
                    <div class="pow naviget">
                        <div class="pow rol-7 navg">
                            <a class="log" href="<?= Url::to(['index']) ?>">lead.force</a>
                            <nav class="nav pow linkgroup">
                                <a href="<?= Url::to(['/']) ?>">MYFORCE</a>
                                <a href="<?= Url::to(['/club']) ?>"> Клуб MYFORCE </a>
                                <a href="<?= Url::to(['about-leads']) ?>">Клиентам</a>
                                <a href="<?= Url::to(['seller/index']) ?>">Партнерам</a>
                            </nav>
                        </div>
                        <?php if (!$guest) : ?>
                            <div class="rol-3 butgroop">
                                <?= Html::a('Выход', 'https://myforce.ru/site/logout/', ['class' => 'enter']) ?>
                                <?= Html::a('Кабинет', 'https://user.myforce.ru/lead-force/', ['class' => 'register BLS6CBORID-BTN1']) ?>
                            </div>
                        <?php else : ?>
                            <div class="rol-3 butgroop">
                                <?= Html::a('Войти', '/registr?site=lead', ['class' => 'enter']) ?>
                                <?= Html::a('Регистрация', '/registr?site=lead', ['class' => 'register BLS6CBORID-BTN1']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="header1">
                <div class="container">
                    <nav class="pow navibet">
                        <a class="linnav <?= Yii::$app->controller->action->id == 'about-leads' ? 'linnavActive' : '' ?>" href="<?= Url::to(['about-leads']) ?>">
                            <img src="<?= Url::to(['/img/menuHome.svg']) ?>" alt="menu icon">
                            <span>Главная</span>
                        </a>
                        <a class="linnav <?= Yii::$app->controller->action->id == 'types-of-leads' ? 'linnavActive' : '' ?>" href="<?= Url::to(['types-of-leads']) ?>">
                            <img src="<?= Url::to(['/img/menuVidu.svg']) ?>" alt="menu icon">
                            <span>Виды лидов</span>
                        </a>
                        <a class="linnav <?= Yii::$app->controller->action->id == 'traffic-quality' ? 'linnavActive' : '' ?>" href="<?= Url::to(['traffic-quality']) ?>">
                            <img src="<?= Url::to(['/img/menuTraffic.svg']) ?>" alt="menu icon">
                            <span>Качество трафика</span>
                        </a>
                        <a class="linnav <?= Yii::$app->controller->action->id == 'buy-leads' ? 'linnavActive' : '' ?>" href="<?= Url::to(['buy-leads']) ?>">
                            <img src="<?= Url::to(['/img/menuKypit.svg']) ?>" alt="menu icon">
                            <span>Купить лиды</span>
                        </a>
                        <a class="linnav <?= Yii::$app->controller->action->id == 'lead-auction' ? 'linnavActive' : '' ?>" href="<?= Url::to(['lead-auction']) ?>">
                            <img src="<?= Url::to(['/img/menuAuck.svg']) ?>" alt="menu icon">
                            <span>Аукцион лидов</span>
                        </a>
                        <a class="linnav" href="<?= Url::to(['/lead/seller']) ?>">
                            <img src="<?= Url::to(['/img/menuVebmast.svg']) ?>" alt="menu icon">
                            <span>Вы web-мастер?</span>
                        </a>
                    </nav>
                </div>
            </div>
        </menu>
        <menu class="tel_header">
            <a class="log" href="<?= Url::to(['index']) ?>">lead.force</a>
            <div class="iconBurg">
                <img class="menushow" src="<?= Url::to(['/img/burg.webp']) ?>" alt="Burger Menu">
                <img class="menuclose" src="<?= Url::to(['/img/closeburg.webp']) ?>" alt="Burger Menu">
            </div>
            <nav class="menushows">
                <a href="<?= Url::to(['/']) ?>">MYFORCE</a>
                <a href="<?= Url::to(['/club']) ?>"> Клуб MYFORCE </a>
                <a href="<?= Url::to(['index']) ?>">Клиентам</a>
                <a href="<?= Url::to(['seller/index']) ?>">Партнерам</a>
                <a class="<?= Yii::$app->controller->action->id == 'about-leads' ? 'linnavActive' : '' ?>" href="<?= Url::to(['about-leads']) ?>">Главная</a>
                <a class="<?= Yii::$app->controller->action->id == 'types-of-leads' ? 'linnavActive' : '' ?>" href="<?= Url::to(['types-of-leads']) ?>">Виды лидов</a>
                <a class="<?= Yii::$app->controller->action->id == 'traffic-quality' ? 'linnavActive' : '' ?>" href="<?= Url::to(['traffic-quality']) ?>">Качество трафика</a>
                <a class="<?= Yii::$app->controller->action->id == 'buy-leads' ? 'linnavActive' : '' ?>" href="<?= Url::to(['buy-leads']) ?>">Купить лиды</a>
                <a class="<?= Yii::$app->controller->action->id == 'lead-auction' ? 'linnavActive' : '' ?>" href="<?= Url::to(['lead-auction']) ?>">Аукцион лидов</a>
                <a href="<?= Url::to(['/lead/seller']) ?>">Вы web-мастер?</a>
                <?php if (!$guest) : ?>
                    <div class="butgroop">
                        <?= Html::a('Выход', 'https://myforce.ru/site/logout/', ['class' => 'enter']) ?>
                        <?= Html::a('Кабинет', 'https://user.myforce.ru/lead-force/', ['class' => 'register BLS6CBORID-BTN1']) ?>
                    </div>
                <?php else : ?>
                    <div class="butgroop">
                        <?= Html::a('Войти', '/registr?site=lead', ['class' => 'enter']) ?>
                        <?= Html::a('Регистрация', '/registr?site=lead', ['class' => 'register BLS6CBORID-BTN1']) ?>
                    </div>
                <?php endif; ?>
            </nav>
        </menu>
    </header>


    <div><?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?></div>
    <div><?= Alert::widget() ?></div>
    <div style="min-height: calc(100vh - 550px)"><?= $content ?></div>

    <footer>
        <!--    --><?php //if(Yii::$app->controller->action->id !== 'news'):
                    ?>
        <!--    <div style="background-color: #fafafa" >-->
        <!--        <div class="container">-->
        <!--            <div class="NavsNews">-->
        <!--                <h4>Последние новости</h4>-->
        <!--                <div style="display:flex; flex-wrap: wrap">-->
        <!--                    --><?php //foreach ($news as $key => $item):
                                    ?>
        <!--                        <article style="margin-right: 20px; max-width: 200px; width: 100%">-->
        <!--                            <a class="linkTelega" href="-->
        <? //= Url::to(['news', 'link' => $item['link']])
        ?>
        <!--">-->
        <!--                                <p style="color: black; font-size: 20px; font-weight: 500">-->
        <? //= $item['title']
        ?>
        <!-- </p>-->
        <!--                                <p class="prev__text__news">-->
        <? //= mb_substr(strip_tags($item['content']), 0, 100)
        ?>
        <!--...</p>-->
        <!--                                <span class="read__more">Читать</span>-->
        <!--                            </a>-->
        <!--                        </article>-->
        <!--                    --><?php //endforeach;
                                    ?>
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--    --><?php //endif;
                    ?>
        <div class="foot2">
            <div class="container">
                <div class="foottop pow">
                    <div class="rol-4 telsMals">
                        <div class="pow tells">
                            <img src="<?= Url::to(['/img/phone1.svg']) ?>" alt="icon phone">
                            <a class="telmail" href="<?= Url::to(['tel:8 495 118 39 34']) ?>">8 495 118 39 34</a>
                            <p class="telmailp1">Бесплатный звонок для всех городов России</p>
                        </div>
                        <div class="pow mails">
                            <img src="<?= Url::to(['/img/mail1.svg']) ?>" alt="icon mail">
                            <a class="telmail" href="<?= Url::to(['mailto:general@myforce.ru']) ?>">general@myforce.ru</a>
                        </div>
                        <?= Html::button('Получить консультацию', ['class' => 'footbtn showsCons']) ?>
                    </div>
                    <menu class="rol-8 pow classWraps">
                        <div class="rol-4 menus1">
                            <div class="menu1">
                                <nav class="fdc">
                                    <h4>Клиентам</h4>
                                    <a href="<?= Url::to(['types-of-leads']) ?>">Виды лидов</a>
                                    <a href="<?= Url::to(['traffic-quality']) ?>">Качество трафика</a>
                                    <a href="<?= Url::to(['buy-leads']) ?>">Купить лиды</a>
                                    <a href="<?= Url::to(['lead-auction']) ?>">Аукцион лидов</a>
                                    <a href="<?= Url::to(['/lead/seller']) ?>">Вы web-мастер?</a>
                                </nav>
                            </div>
                        </div>
                        <div class="rol-4 menus1">
                            <div class="menu1">
                                <nav class="fdc">
                                    <h4>Партнерам</h4>
                                    <a href="<?= Url::to(['seller/available-offers']) ?>">Офферы</a>
                                    <a href="<?= Url::to(['seller/terms-of-cooperation']) ?>">Условия</a>
                                    <a href="<?= Url::to(['seller/sell-traffic']) ?>">Продать трафик</a>
                                    <a href="<?= Url::to(['/lead']) ?>">Вам нужны лиды?</a>
                                </nav>
                            </div>
                        </div>
                        <div class="rol-4 menus1">
                            <div class="menu1">
                                <nav class="fdc">
                                    <h4>Другие проекты</h4>
                                    <a href="<?= Url::to(['/femida']) ?>">Франшизы</a>
                                    <!--                                <a href="-->
                                    <? //= Url::to(['#'])
                                    ?>
                                    <!--">Реклама</a>-->
                                    <!--                                <a href="-->
                                    <? //= Url::to(['#'])
                                    ?>
                                    <!--">Обучение</a>-->
                                    <!--                                <a href="-->
                                    <? //= Url::to(['#'])
                                    ?>
                                    <!--">Разработка</a>-->
                                    <!--                                <a href="-->
                                    <? //= Url::to(['#'])
                                    ?>
                                    <!--">Арбитражное управление</a>-->

                                </nav>
                            </div>
                        </div>
                    </menu>
                </div>
                <div class="footbot pow">
                    <div class="rol-5 textBotFoot">
                        <a target="_blank" href="<?= Url::to(['/policy.pdf']) ?>" class="footbotp1">*отправляя формы на
                            данном сайте, вы даете согласие на обработку персональных
                            данных в соответствии с 152-ФЗ</a><br>
                        <a style="margin-top: 10px;" target="_blank" href="<?= Url::to(['/oferta.pdf?v=16']) ?>" class="footbotp1">Договор публичной оферты</a><br>
                        <a style="margin-top: 10px;" target="_blank" href="<?= Url::to(['/oferta-diarova.pdf?v=16']) ?>" class="footbotp1">Договор оферты</a>
                        <div class="infoAddr">
                            <p class="addres align-left">344000, Россия, г. Ростов-на-Дону, пр-т Ворошиловский , д 82/4.
                                оф. 99, 7 этаж</p>
                            <p class="inn align-left">ИНН: 6167130086<br>
                                ОГРН: 1156196049415</p>
                        </div>
                    </div>
                    <div class="rol-3 links">
                        <a target="_blank" href="<?= Url::to('http://instagram.com/myforce.ru') ?>"><img src="<?= Url::to(['/img/ig-circle.svg']) ?>" alt="icon instagramm"></a>
                        <a target="_blank" href="<?= Url::to('https://t.me/myforce_business') ?>"><img src="<?= Url::to(['/img/tg-circle.svg']) ?>" alt="icon telegram"></a>
                        <a target="_blank" href="<?= Url::to('https://vm.tiktok.com/ZSJtjjbdj/') ?>"><img src="<?= Url::to(['/img/tt-circle.svg']) ?>" alt="icon TikTok"></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <div class="By__Leads__Background__Popap"></div>
    <div class="By__Leads__popap__consult__contant-margin">
        <div class="By__Leads__popap__consult">
            <img src="<?= Url::to(['/img/Exid.svg']) ?>" class="Popap_reg_on_leads_page">
            <?= Html::beginForm('', 'post', ['id' => 'consultation']) ?>
            <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
            <input type="hidden" name="formType" value="Попап консультации">
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
                    <input class="C_F_U_P" pattern="[A-z,А-я ]*" required placeholder="ФИО" form="consultation" type="text" name="name" id="username_C">
                    <input class="C_F_U_P" required placeholder="Телефон" form="consultation" type="text" name="phone" id="phone_C">
                </div>
                <div class="C_C_down">
                    <button form="consultation" class="btn-consultation" type="submit">Отправить</button>
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
                    <img src="<?= Url::to(['/img/PopOnConsult.svg']) ?>">
                </div>
            </div>
            <?= Html::endForm(); ?>
        </div>
    </div>

    <div class="By__Leads__popap__card__contant-margin">
        <div class="By__Leads__popap__card">
            <img src="<?= Url::to(['/img/Exid.svg']) ?>" class="Popap_reg_on_leads_page">
            <?= Html::beginForm('', 'post', ['id' => 'card']) ?>
            <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
            <input type="hidden" name="formType" value="Попап консультации">
            <input type="hidden" name="pipeline" value="104">
            <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
            <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
            <input type="hidden" name="service" value="">
            <div class="By__Leads__popap__card__contant">
                <div class="C_C_up">
                    <p class="C_C_up-ttl">Получить карту Клуба</p>
                    <p class="C_C_up-sttl">Оставьте свои данные для получения статуса участника</p>
                </div>
                <div class="C_C_medle">
                    <input class="C_F_U_P" pattern="[A-z,А-я ]*" required placeholder="ФИО" form="card" type="text" name="name" id="username_Ca">
                    <input class="C_F_U_P" required placeholder="Телефон" form="card" type="text" name="phone" id="phone_Ca">
                </div>
                <div class="C_C_down C_C_down--column">
                    <button form="card" class="btn-card" type="submit">Получить карту Клуба</button>
                    <p class="info">Нажимая на кнопку «Получить карту Клуба», я соглашаюсь с условиями обработки
                        персональных
                        данных</p>
                </div>
            </div>
            <div class="By__Leads__popap__card__contant-2">
                <div class="C_C_up">
                    <p class="C_C_up-ttl">Спасибо за заявку!</p>
                    <p class="C_C_up-sttl">Через несколько минут с Вами свяжется наш специалист</p>
                </div>
                <div class="C_C_D">
                    <img src="<?= Url::to(['/img/PopOnCard.svg']) ?>">
                </div>
            </div>
            <?= Html::endForm(); ?>
        </div>
    </div>
    <div class="By__Leads__popap__form__contant-margin">
        <div class="By__Leads__popap__consult">
            <div class="C_C_up">
                <p class="C_C_up-ttl">Спасибо за заявку!</p>
                <p class="C_C_up-sttl">Через несколько минут с Вами свяжется наш специалист</p>
            </div>
            <div class="C_C_D">
                <img src="<?= Url::to(['/img/PopOnConsult.svg']) ?>">
            </div>
        </div>
    </div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>