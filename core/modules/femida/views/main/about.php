<?php

/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'О проекте FEMIDA.FORCE';
$js = <<<JS
    $('.linkShowPop').on('click', function() {
        $('.backfone1').fadeIn(300);
    });

    $('.popcloseGift, .backfone1').on('click', function(e) {
        if (e.target == this) $('.backfone1').fadeOut(300);
    });
    
  $('.skidkaPop').on('submit', function (e) {
            $.ajax({
                url: "/site/form",
                dataType: 'JSON',
                type: "POST",
                data: $(".skidkaPop").serialize(),
                beforeSend: function () {
                    $('.Pop1St1').fadeOut(300, function () {
                        $('.Pop1St2').fadeIn(300);
                    });
                },
            }).done(function () {
            });
            e.preventDefault();
    });
JS;
$this->registerJs($js);
?>

<section class="AbSec1">
  <div class="container AbSec1__inner">
    <h1>О проекте FEMIDA.FORCE</h1>
    <h2>Готовые решения для старта вашего бизнеса</h2>
  </div>
</section>
<section class="AbSec2">
  <div class="container">
    <h2>Миссия проекта</h2>
    <p><img class="mission__image" src="<?= Url::to(['/img/citata.png']) ?>" alt="Миссия проекта">Доказать, что свой бизнес - не удел избранных, а возможность для каждого</p>
  </div>
</section>
<section class="AbSec3">
  <div class="container">
    <h2>Проект MYFORCE</h2>
    <p>FEMIDA.FORCE является успешным и самым первым дочерним проектом компании MYFORCE</p>
    <div style="background-image: url('<?= Url::to(['/img/yearStep.webp']) ?>')" class="yearStep">
      <div class="yStepText">
        <p class="yStepTextP1"><span>2015</span> Мы открылись!</p>
        <p class="yStepTextP2">Начинали мы как маркетинговое агентство в юридической сфере</p>
      </div>
      <div class="yStepText">
        <p class="yStepTextP1"><span class="spanYears">2016</span> Первые партнеры</p>
        <p class="yStepTextP2">К нам присоединились первые 4 партнера, которое до сих с нами сотрудничают</p>
      </div>
      <div class="yStepText">
        <p class="yStepTextP1"><span>2017</span> Международный уровень</p>
        <p class="yStepTextP2">Летом мы вышли со своим продуктом в СНГ и страны ближнего зарубежья</p>
      </div>
      <div class="yStepText">
        <p class="yStepTextP1"><span class="spanYears">2018</span> Запуск франшизы</p>
        <p class="yStepTextP2">Переломный момент в нашей деятельности. Мы накопили достаточное количество знаний и опыта, и готовы делиться с остальными!</p>
      </div>
      <div class="yStepText">
        <p class="yStepTextP1"><span>2019</span> Сервис для бизнеса</p>
        <p class="yStepTextP2">Мы вышли на новый уровень ведения бизнеса и решили создать единую бизнес-экосистему, которая будет полезна всем, кто хочет открыть и успешно вести свое дело. Сила в сотрудничестве и партнерстве!</p>
      </div>
    </div>
    <div class="AbMore">Больше информации на сайте <a style="cursor: pointer" href="<?= Url::to(['/']) ?>">MYFORCE</a></div>
  </div>
</section>
<section class="AbSec4">
  <div class="container">
    <h3>Ключевые показатели проекта</h3>
    <p>Федеральная компания MYFORCE работает на рынке франчайзинга с 2015 года</p>
    <div class="ResutProject">
      <div class="ResutProject__item">
        <img src="<?= Url::to(['/img/cardOrangeCircle (4).svg']) ?>" alt="">
        <p>Наши технологии экономят ваше время</p>
      </div>
      <div class="ResutProject__item">
        <img src="<?= Url::to(['/img/cardOrangeCircle (3).svg']) ?>" alt="">
        <p>Сотни партнеров по всей России и миллионы довольных клиентов</p>
      </div>
      <div class="ResutProject__item">
        <img src="<?= Url::to(['/img/cardOrangeCircle (2).svg']) ?>" alt="">
        <p>Средний срок окупаемости наших франшиз — 5 месяцев</p>
      </div>
      <div class="ResutProject__item">
        <img src="<?= Url::to(['/img/cardOrangeCircle (1).svg']) ?>" alt="">
        <p>Полное обучение, вам не нужна никакая сторонняя подготовка, кроме нашего сопровождения</p>
      </div>
    </div>
  </div>
</section>

<div class="backfone1">
    <div class="popup2">
        <div class="popcloseGift">&times;</div>
        <div class="Pop1St1">
            <?= Html::beginForm(Url::to(['/site/form']), 'post', ['class' => 'skidkaPop']) ?>
            <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
            <input type="hidden" name="formType" value="Форма на акции">
            <input type="hidden" name="pipeline" value="64">
            <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
            <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
            <input type="hidden" name="service" value="">
            <input type="hidden" name="section" value="Консультация со страницы:<?= $this->title ?>">
            <p class="Pop2">Отправить заявку</p>
            <p class="Pop2P1">Оставьте свои данные для получения подробной консультации</p>
            <input type="text" name="name" placeholder="ФИО" minlength="3" required class="input1">
            <input type="tel" name="phone" placeholder="Телефон" required class="input1">
            <div class="pow">
                <button class="orangeLinkBtn">Получить</button>
                <p style="max-width: 230px" class="confirmForm">Нажимая на кнопку «Получить», я соглашаюсь с условиями обработки персональных данных</p>
            </div>
            <?= Html::endForm() ?>
        </div>
        <div class="Pop1St2 dnone">
            <p class="Pop2">Спасибо за заявку!</p>
            <p class="Pop2P1">Через несколько минут с Вами свяжется специалист по франшизам </p>

        </div>
        <div class="popUp__Imagin">
            <img src="<?= Url::to(['/img/gifts.webp']) ?>" alt="">
        </div>
    </div>
</div>