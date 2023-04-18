<?php

use yii\helpers\Url;
use yii\helpers\Html;
use common\models\helpers\UrlHelper;

$this->title = 'Купить лиды для бизнеса';
$categoriFind = [];
if (!empty($category) && !empty($leads)) {
    foreach ($category as $key => $item) {
        $index = 0;
        $categoriFind[$item['name']] = [];
        foreach ($leads as $k => $i) {
            if ($index == 4) break;
            if ($i['category'] === $item['name']) {
                $categoriFind[$item['name']][] = $i;
                $index++;
            }
        }
    }
}
$js = <<< JS
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
JS;
$this->registerJs($js);
$this->registerJsFile(Url::to(['/js/jquery.formstyler.min.js']), ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Url::to(['/css/jquery.formstyler.css']));
$this->registerCssFile(Url::to(['/css/jquery.formstyler.theme.css']));
$this->registerJsFile(Url::to(['/js/leads-range.js']), ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile('@web/css/lead.css');
?>

<body>
<section class="By__Leads__Sec1">
    <div class="By__Leads__Sec1__content">
        <div class="By__Leads__Sec1-img"></div>
        <div class="By__Leads__Sec1-rblock">
            <h1 class="tt1">Целевые клиенты для бизнеса</h1>
            <p class="stt1">Заполните форму и мы рассчитаем стоимость лида для вашего бизнеса</p>
            <a class="btn-1 showsCons">Заполнить</a>
        </div>
    </div>
</section>

<section class="By__Leads__Sec2">
    <div class="By__Leads__Sec2__content">
        <div class="By__Leads__Sec2-blockinfo">
            <h2 class="ttl">Популярные вопросы о лидах</h2>
            <div class="asks">
                <div class="b">
                    <h3 class="t1">Что такое «лид»?</h3>
                    <p class="t2">Лид это потенциальный клиент, который проявил первоначальный интерес к вашей услуге
                        и обратился в вашу компанию с целью первичной консультации</p>
                </div>
                <div class="b">
                    <h3 class="t1">Откуда берутся лиды?</h3>
                    <p class="t2">С наших сайтов. Все наши заявки мы генерируем самостоятельно, мы не покупаем
                        и не перепродаем их</p>
                </div>
                <div class="b">
                    <h3 class="t1">Гарантия на лиды</h3>
                    <p class="t2">Мы тщательно следим за качеством заявок, и для вашего удобства мы делаем
                        автовозврат 25% лидов, если они вас не устраивают</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="By__Leads__Sec3">
    <div class="By__Leads__Sec3__content">
        <div class="By__Leads__Sec3-lt">
            <h3 class="upt">Получите до 10 бесплатных лидов* прямо сейчас</h3>
            <p class="downt">Зарегистрируйтесь в личном кабинете</p>
        </div>
        <div class="By__Leads__Sec3-rt">
            <?= Html::beginForm(Url::to(['/site/form']), 'post', ['id' => 'form-code']) ?>
            <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
            <input type="hidden" name="formType" value="Форма для получения 10 бесплатных лидов">
            <input type="hidden" name="pipeline" value="104">
            <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
            <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
            <input type="hidden" name="service" value="">
            <input type="hidden" name="section" value="Получите до 10 бесплатных лидов* прямо сейчас">
            <div class="form-code">
                <div class="bfl">
                    <input type="text" required="required" class="region fcstlt" placeholder="Регион" name="region"
                           id="region">
                    <input class="fcstlt" required pattern="[0-9]*" placeholder="Количество лидов в день" type="text"
                           name="comments[lead_day]" id="lids">
                </div>
                <div class="bfr">
                    <input class="fcstlt" required placeholder="Сфера бизнеса" type="text" name="comments[sphere]"
                           id="sphere">
                    <button class="btnsbmtfc" type="submit">Получить</button>
                </div>
            </div>
            <?= Html::endForm(); ?>
        </div>
    </div>
</section>

<section class="By__Leads__Sec4">
    <div class="By__Leads__Sec4__inner2">
        <div class="By__Leads__Sec4__inner2-white">
            <div class="By__Leads__Sec4__content">
                <div class="B_L_S4_C_B1">
                    <h3 class="B_L_S4_C_B1-t1">Основное направление</h3>
                    <p class="B_L_S4_C_B1-t2">
                        Направления бизнеса, для которых у нас гарантированно есть большой объём
                        горячих
                        лидов
                    </p>
                </div>
    <?php $i = 0;foreach ($categoriFind as $key => $item) : ?>
        <?php if (!empty($item)) : ?>
                <div class="B_L_S4_C_B2">
                    <p class="B_L_S4_C_B-ttl"><?= $key ?></p>
                    <div class="B_L_S4_C_B2-obolochka">
                        <?php foreach ($item as $k => $v) : ?>
                            <div class="B_L_S4_C_B-card">
                                <a class="linkCards" href="<?= Url::to(['lead-plan', 'link' => $v['link']]) ?>"></a>
                                <div class="B_L_S4_C_B-card_container">
                                    <div class="B_L_S4_C_B-card-topB">
                                        <img src="<?= UrlHelper::admin($v['image']) ?>">
                                        <h5><?= $v['name'] ?></h5>
                                    </div>
                                    <p class="B_L_S4_C_B-card-rub">от <?= $v['price'] ?> рублей/лид</p>
                                </div>
                                <p class="B_L_S4_C_B-card-order">Заказать</p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
        <?php endif; ?>
        <?php if($i == 1):?>
            </div>
        </div>
        <div class="By__Leads__Sec4__inner2-blue">
            <div class="By__Leads__Sec4__content">
        <?php endif;?>
        <?php $i++?>
    <?php endforeach; ?>
                <div class="B_L_S4_C_B5">
                    <a href="<?= Url::to(['/lead/types-of-leads']) ?>" class="B_L_S4_C_B5-btn1">Смотреть все виды
                        лидов</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="By__Leads__Sec5">
    <div class="By__Leads__Sec5__content">
        <div class="By__Leads__Sec5__content-Topttl">
            <h4 class="BLSCTtext1">Описание работы</h4>
            <h3 class="BLSCTtext2">Как вы будете получать лиды</h3>
        </div>
        <div class="By__Leads__Sec5__content-MC1">
            <div class="BLSCMCCard">
                <img src="<?= Url::to(['/img/S5C1.svg']) ?>">
                <p class="BLSCMCCard-text">Вы регистрируйтесь в личном кабинете</p>
            </div>
            <div class="By__Leads__Sec5__content-ArrowR">
                <img src="<?= Url::to(['/img/S5Ar1R.svg']) ?>">
            </div>
            <div class="By__Leads__Sec5__content-ArrowDown1">
                <img src="<?= Url::to(['/img/S5Ar2D.svg']) ?>">
            </div>
            <div class="BLSCMCCard">
                <img src="<?= Url::to(['/img/S5C2.svg']) ?>">
                <p class="BLSCMCCard-text">Пополняете баланс личного кабинета</p>
            </div>
        </div>
        <div class="By__Leads__Sec5__content-ArrowDown2">
            <img src="<?= Url::to(['/img/S5Ar2D.svg']) ?>">
        </div>
        <div class="By__Leads__Sec5__content-MC2">
            <div class="BLSCMCCard">
                <img src="<?= Url::to(['/img/S5C4.svg']) ?>">
                <p class="BLSCMCCard-text">Мы настраиваем рекламу вашего бизнеса</p>
            </div>
            <div class="By__Leads__Sec5__content-ArrowR">
                <img src="<?= Url::to(['/img/S5Ar3L.svg']) ?>">
            </div>
            <div class="By__Leads__Sec5__content-ArrowDown3">
                <img src="<?= Url::to(['/img/S5Ar2D.svg']) ?>">
            </div>
            <div class="BLSCMCCard">
                <img src="<?= Url::to(['/img/S5C3.svg']) ?>">
                <p class="BLSCMCCard-text">Получаете заявки от клиентов прямо в интерфейсе кабинета</p>
            </div>
        </div>
        <div class="By__Leads__Sec5__content-Medttl">
            <h4 class="BLSCTtext1">Наши гарантии</h4>
            <p class="BLSCTtext2">Мы в ответе за качество</p>
        </div>
        <div class="By__Leads__Sec5__content-ColCarDown">
            <div class="BLS5CCCD__Card">
                <div class="BLS5CCCD__Card-back"></div>
                <div class="BLS5CCCD__Card-info">
                    <img src="<?= Url::to(['/img/BLSCCCD1.svg']) ?>">
                    <h5 class="BLS5CCCD__Card-text-1">Количество не влияет на качество</h5>
                    <p class="BLS5CCCD__Card-text-2">Вы заказываете столько лидов, сколько вам нужно. Качество
                        мы гарантируем — за нами только целевые лиды</p>
                </div>
            </div>
            <div class="BLS5CCCD__Card">
                <div class="BLS5CCCD__Card-back"></div>
                <div class="BLS5CCCD__Card-info">
                    <img src="<?= Url::to(['/img/BLSCCCD2.svg']) ?>">
                    <h5 class="BLS5CCCD__Card-text-1">Вы покупаете здесь и сейчас</h5>
                    <p class="BLS5CCCD__Card-text-2">Вам не придется тратить месяцы на поиск клиентов, мы сделаем это
                        за вас в максимально короткие сроки</p>
                </div>
            </div>
            <div class="BLS5CCCD__Card">
                <div class="BLS5CCCD__Card-back"></div>
                <div class="BLS5CCCD__Card-info">
                    <img src="<?= Url::to(['/img/BLSCCCD3.svg']) ?>">
                    <h5 class="BLS5CCCD__Card-text-1">Ваш план продаж в наших руках</h5>
                    <p class="BLS5CCCD__Card-text-2">Загрузим ваших менеджеров по продажам теплыми звонками, встречами
                        и сделками</p>
                </div>
            </div>
        </div>
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
                <p class="BLS5CDText-1">Получите консультацию от специалиста по лидогенерации</p>
                <p class="BLS5CDText-2">
                    Свяжитесь с нами и мы обсудим возможности лидогенерации конкретно по вашему
                    направлению!
                </p>
                <div class="Sec5-inputs">
                    <input class="Sec5-input fcstlt" type="text" name="fio" placeholder="Имя" required>
                    <input class="Sec5-input fcstlt" type="tel" name="phone" placeholder="Телефон" required>
                </div>
                <button type="sabmit" class="btn-1">Получить консультацию</button>
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
</section>

<section class="By__Leads__Sec6">
    <div class="By__Leads__Sec6__content">
        <div class="BLS6C__blockOFslide">
            <div class="BLS6C__title">
                <h3 class="BLS6C__t1">В каком виде вы получаете лиды</h3>
                <p class="BLS6C__t2">Заявки приходят вам в личный кабиент и на почту</p>
            </div>
            <div class="BLS6C__Slide">
                <div class="BLS6C__Slide__center">
                    <div>
                        <div class="slide">
                            <p class="slide_titdate">24.01.2020 — 12:20</p>
                            <div class="slide_COLUMNS">
                                <div class="slide_L-column">
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">ID</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Источник</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">ФИО</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Телефон</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Почта</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Сфера</p>
                                    </div>
                                    <div class="slide_L-column-blocki">
                                    </div>
                                </div>
                                <div class="slide_R-column">
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">1983732</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">Лид от lead.force</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">Петров Сергей</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">89388490285</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">petrov@mail.ru</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">Диспансеризация</p>
                                    </div>
                                    <div class="slide_R-column-blocki">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="slide">
                            <p class="slide_titdate">18.01.2020 — 13:34</p>
                            <div class="slide_COLUMNS">
                                <div class="slide_L-column">
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">ID</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Источник</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">ФИО</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Телефон</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Почта</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Сумма долга</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Сфера</p>
                                    </div>
                                </div>
                                <div class="slide_R-column">
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">29843</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">Лид от lead.force</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">Иванов Иван Иванович</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">88008008080</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">ivanov@mail.ru</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">1000000</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">Банкротство</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="slide">
                            <p class="slide_titdate">30.01.2020 — 03:27</p>
                            <div class="slide_COLUMNS">
                                <div class="slide_L-column">
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">ID</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Источник</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">ФИО</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Телефон</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Почта</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Сумма долга</p>
                                    </div>
                                    <div class="slide_L-column-block">
                                        <p class="SLCB_text">Сфера</p>
                                    </div>
                                </div>
                                <div class="slide_R-column">
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">8930-2</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">Лид от lead.force</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">Генин Кирилл</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">89850983984</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">genin@mail.ru</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">500 000</p>
                                    </div>
                                    <div class="slide_R-column-block">
                                        <p class="SRCB_text">Чарджбек</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="BLS6C__title__underslider">
                <p class="BLS6C-tu-t1">Зарегистрируйтесь в личном кабинете и получите до 10 бесплатных лидов* прямо
                    сейчас</p>
                <p class="BLS6C-tu-t2">Регистрация займет 3 минуты</p>
                <a href="<?= Url::to(['/registr?site=lead']) ?>" class="BLS6C-tu-btnreg btnsbmtfc">Зарегистрироваться</a>
            </div>
        </div>
    </div>
</section>

<section class="By__Leads__Sec7">
    <div class="By__Leads__Sec7__content">
        <h3 class="Sec7__title">
            Станьте участником бонусной программы MYFORCE
        </h3>
        <p class="Sec7__subtitle">
            Лиды, курсы, скрипты и кэшбек баллами всех сервисов по одной карте
        </p>

        <div class="Sec7__box">
            <div class="Sec7__box-inner">
                <div class="Sec7__item">
                    <p class="Sec7__item-title">
                        Кэшбек за каждую покупку
                    </p>
                    <p class="Sec7__item-text">
                        Получайте еще больше лидов за те же деньги!
                    </p>
                </div>

                <div class="Sec7__item Sec7__item--1">
                    <p class="Sec7__item-title">
                        Бесплатные курсы и скрипты
                    </p>
                    <p class="Sec7__item-text">
                        Получайте скрипты продаж и курсы для менеджеров и оптимизируйте свой бизнес
                    </p>
                </div>

                <div class="Sec7__item Sec7__item--2">
                    <p class="Sec7__item-title">
                        Для всех сервисов MYFORCE
                    </p>
                    <p class="Sec7__item-text">
                        Бонусная программа едина для всей экосистемы MYFORCE. Накопленные баллы вы можете потратить на
                        курсы, услуги для бизнеса и много другое
                    </p>
                </div>

                <div class="Sec7__item Sec7__item--3">
                    <p class="Sec7__item-title">
                        Дополнительная отбраковка
                    </p>
                    <p class="Sec7__item-text">
                        Всем держателям карт доступна дополнительная отбраковка по любым направлениям бизнеса
                    </p>
                </div>
            </div>
            <a href="<?= Url::to(['/club']) ?>" class="Sec7__btn Sec7__box-btn">Узнать подробнее</a>
        </div>

        <div class="Sec7__card">
            <div class="Sec7__card-img">
                <img src="<?= Url::to(['/img/s7-card.png']) ?>" alt="photo cards">
            </div>

            <div class="Sec7__card-content">
                <h3 class="Sec7__card-title">
                    Получите Карту клуба прямо сейчас
                </h3>
                <p class="Sec7__card-text">
                    Получите карту СОВЕРШЕННО БЕСПЛАТНО <br>при покупке 350 лидов для<br> вашего бизнеса
                </p>

                <button type="button" class="Sec7__card-btn Sec7__btn showsCard">Получить карту Клуба</button>
            </div>
        </div>
    </div>
</section>

<section class="By__Leads__Sec8">
    <div class="By__Leads__Sec8__content">
        <div class="BLS6C__blockOFlids">
            <div class="BLS6CBOL__Card">
                <div class="BLS6CBOLC_row">
                    <div class="BLS6CBOLLeftC">
                        <div class="BLS6CBOLLC__text1">
                            <p class="BLS6CBOLLC__ltext-1">Чарджбек</p>
                            <p class="BLS6CBOLLC__rtext-1">11.01.2020 12:45</p>
                        </div>
                        <div class="BLS6CBOLLC__text2">
                            <p class="BLS6CBOLLC__ltext-2">8-904-837-****</p>
                            <p class="BLS6CBOLLC__rtext-2">350₽</p>
                        </div>
                        <p class="BLS6CBOLLC__ltext-3">Комментарий: нет</p>
                    </div>
                    <p class="BLS6CBOLRightBTN">купить</p>
                </div>
                <div class="BLS6CBOLC_row">
                    <div class="BLS6CBOLLeftC">
                        <div class="BLS6CBOLLC__text1">
                            <p class="BLS6CBOLLC__ltext-1">Банкротство</p>
                            <p class="BLS6CBOLLC__rtext-1">13.01.2020 12:00</p>
                        </div>
                        <div class="BLS6CBOLLC__text2">
                            <p class="BLS6CBOLLC__ltext-2">8-904-837-****</p>
                            <p class="BLS6CBOLLC__rtext-2">150₽</p>
                        </div>
                        <p class="BLS6CBOLLC__ltext-3">Комментарий: 300 тыс долга</p>
                    </div>
                    <p class="BLS6CBOLRightBTN">купить</p>
                </div>
                <div class="BLS6CBOLC_row">
                    <div class="BLS6CBOLLeftC">
                        <div class="BLS6CBOLLC__text1">
                            <p class="BLS6CBOLLC__ltext-1">Стоматология</p>
                            <p class="BLS6CBOLLC__rtext-1">12.01.2020 12:44</p>
                        </div>
                        <div class="BLS6CBOLLC__text2">
                            <p class="BLS6CBOLLC__ltext-2">8-904-837-****</p>
                            <p class="BLS6CBOLLC__rtext-2">490₽</p>
                        </div>
                        <p class="BLS6CBOLLC__ltext-3">Комментарий: нет</p>
                    </div>
                    <p class="BLS6CBOLRightBTN">купить</p>
                </div>
            </div>
            <div class="BLS6CBOR__Info">
                <div class="BLS6CBOR__Info_Up">
                    <h3 class="BLS6CBORIU-t1">Аукцион лидов</h3>
                    <p class="BLS6CBORIU-t2">Платите за эксклюзивного и качественного клиента сколько считаете
                        нужным</p>
                    <p class="BLS6CBORIU-t3">Если вам необходимо небольшое количество лидов, то вам больше не нужно
                        переплачивать и свой объем вы заберете по минимальной цене</p>
                </div>
                <div class="BLS6CBOR__Info_Med">
                    <p class="BLS6CBORIM-t1">Пройдите регистрацию в личном кабинете</p>
                    <p class="BLS6CBORIM-t2">Пополните баланс</p>
                    <p class="BLS6CBORIM-t3">Выберите лид, подходящий вашему запросу</p>
                    <p class="BLS6CBORIM-t4">Купите лид и заработайте на нем!</p>
                </div>
                <div class="BLS6CBOR__Info_Dw">
                    <a href="<?= Url::to(['/registr?site=lead']) ?>" class="BLS6CBORID-BTN btnsbmtfc">Попробовать</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="By__Leads__Sec9">
    <div class="By__Leads__Sec9__content">
        <h3 class="TL_h8v">Рассчитайте свою прибыль<br> и закажите лиды прямо сейчас!</h3>
        <div class="TL_inp8">
            <div class="TL_inp8-content">
                <div class="TL_inputtext flex aic fww">
                    <p class="TL_p8">Количество лидов</p>
                    <input class="TL_input_text tac number1" type="number" min="100" max="1000" step="100" value="500"
                           id="text">
                </div>
                <input class="TL_input_range" type="range" min="0" max="1000" value="500" step="100" id="slider">

                <div class="TL_p88 flex aic fww">
                    <div class="lite__fix">
                        <p class="TL_p8">Средний процент конверсии</p>
                        <h4 class="TL_h8 TL_h8w number1">9,5%</h4>
                    </div>

                    <div class="lite__fix">
                        <p class="TL_p8">Средняя стоимость лида</p>
                        <h4 class="TL_h8 TL_h8w">500 рублей</h4>
                    </div>
                </div>
                <div class="TL_inp9 flex fww">
                    <h4 class="TL_h8 TL_h8 total">Ваша прибыль</h4>
                    <input class="TL_inp9inp tac" type="text" id="result" disabled>
                </div>
            </div>
            <div class="TL_inp8-form">
                <p class="TL_inp8-form-title">
                    Закажите лиды прямой сейчас!
                </p>
                <div class="TL_inp8-form-inner">
                    <?= Html::beginForm(Url::to(['/site/form']), 'post', ['id' => 'form-TL_inp8']) ?>
                    <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
                    <input type="hidden" name="formType" value="Форма для получения 10 бесплатных лидов">
                    <input type="hidden" name="pipeline" value="104">
                    <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
                    <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
                    <input type="hidden" name="service" value="">
                    <input type="hidden" name="section" value="Рассчитайте свою прибыль и закажите лиды прямо сейчас">

                    <input class="fcstlt TL_inp8-input" required placeholder="Сфера бизнеса" type="text"
                           name="comments[sphere]" id="sphere2">
                    <input type="text" required="required" class="TL_inp8-input region fcstlt" placeholder="Ваш регион"
                           name="region" id="region2">
                    <input class="fcstlt TL_inp8-input" required pattern="[0-9]*" placeholder="Количество лидов в день"
                           type="text" name="comments[lead_day]" id="lids2">
                    <?php if (Yii::$app->user->isGuest):?>
                        <a href="<?= Url::to(["/registr?site=lead"])?>" class="btnsbmtfc">Получить</a>
                    <?php else:?>
                        <button class="btnsbmtfc" type="submit">Получить</button>
                    <?php endif?>

                    <?= Html::endForm(); ?>
                </div>
            </div>
        </div>

        <p class="BLS6C__description">
            * - бонус начисляется только при первом пополнение личного кабинета в размере 1000 баллов от 5000 рублей
            пополнения
        </p>
    </div>
</section>