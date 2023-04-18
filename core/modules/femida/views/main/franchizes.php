<?php


/* @var $this yii\web\View */

use common\models\helpers\UrlHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\Pjax;

$json = json_encode($popupdata, JSON_UNESCAPED_UNICODE);
$this->title = 'Франшизы FEMIDA.FORCE';

$js = <<<JS
var obj = $json;
    
    $('.HovPopup').on('click', function() {
        var item = $(this).attr('data-click'),
            listItem = '',
            popup = JSON.parse(obj[item].popup_data);
        $('.nameTechno').html(obj[item].name);
        $('.abTechno').html(obj[item].subtitle);
        $('.technoBottom').html(obj[item].preview);
        for (var i = 0; i<popup.popup.advantage.length; i++){
            listItem += '<div class="technoLi">';
            listItem += '<img src="../../img/Flame.svg" alt="flame icon">';
            listItem += ' <p class="textLi">'+ popup.popup.advantage[i] +'</p> </div>';
        }
        $('.technoList').html(listItem);
        $('.technoback1').fadeIn(300);
    });
    $('.technoclose, .technoback1').on('click', function(e) {
        if (e.target == this) $('.technoback1').fadeOut(300);
    });
    
    $('.tps1b1').on('click', function() {
        $('.tps1').fadeOut(300, function() {
            $('.tps2').fadeIn(300);
        });
    });

     $('.giveY').on('submit', function (e) {
            $.ajax({
                url: "/site/form",
                type: "POST",
                data: $(".giveY").serialize(),
                beforeSend: function () {
                    $('.tps2').fadeOut(300, function () {
                        $('.tps3').fadeIn(300);
                    });
                },
            }).done(function () {
            });
            e.preventDefault();
    });
     $('.finMod').on('submit', function (e) {
            $.ajax({
                url: "/site/form",
                type: "POST",
                data: $(".finMod").serialize(),
                beforeSend: function () {
                    $('.steps1').fadeOut(300, function () {
                        $('.steps2').fadeIn(300);
                    });
                },
            }).done(function () {
            });
            e.preventDefault();
    });
     $('.Nf').on('click', function() {
  $('.filt__form').submit();
});
$('select[name="filters[price]"]').on('input', function() {
    $('.filt__form').submit();
});
$('.filt__form').on('submit', function(e) {
  e.preventDefault();
  
   $.pjax.reload({
      container: '#Pjax_femida',
      url: "franchizes",
      type: "GET",
      data: $('.filt__form').serialize(),
    });
});

$(window).on('click', function(e) {
    if (e.target.className !== 'Nf' && e.target.className !== 'active__button--filter activeNf' && e.target.className !== 'active__button--filter' && e.target.className !== 'filterRadio'){
        $('.change__folter__main').hide(200);
        $('.active__button--filter').removeClass('activeNf');
    }
});
JS;
$this->registerJs($js);
?>

<div class="technoback1">
  <div class="technopop tps1">
    <div class="technoclose">&times;</div>
    <div class="technotext">
      <p class="nameTechno"></p>
      <p class="abTechno"></p>
      <div class="technoList">

      </div>
      <p class="technoBottom"></p>
    </div>
    <div class="pow">
      <button type="button" class="orangeLinkBtn tps1b1">Получить</button>
      <p class="confirmForm">Нажимая на кнопку «Получить», я соглашаюсь с условиями обработки персональных
        данных</p>
    </div>
  </div>
  <div class="technopop tps2 dnone">
    <div class="technoclose">&times;</div>
    <div class="giveYsl">
      <p class="giveYslP1">Получить услугу</p>
      <p class="giveYslP2">Оставьте свои данные для получения подробной консультации по услуге</p>
      <?= Html::beginForm('', 'post', ['class' => 'giveY']) ?>
      <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
      <input type="hidden" name="formType" value="Получить услугу">
      <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
      <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
      <input type="hidden" name="pipeline" value="64">
      <input type="hidden" name="service" value="">
      <input class="input1" required placeholder="ФИО" name="name" minlength="3" type="text">
      <input class="input1" required placeholder="Телефон" name="phone" type="tel">
      <div class="pow">
        <button class="orangeLinkBtn">Получить</button>
        <p class="confirmForm">Нажимая на кнопку «Получить», я соглашаюсь с условиями обработки персональных
          данных</p>
      </div>
      <?= Html::endForm() ?>
    </div>
  </div>
  <div class="technopop tps3 dnone">
    <div class="technoclose">&times;</div>
    <div class="giveYsl">
      <p class="giveYslP1">Получить услугу</p>
      <p class="giveYslP2">Оставьте свои данные для получения подробной консультации по услуге</p>
      <div style="text-align: center"><img src="<?= Url::to(['/img/LastRef.webp']) ?>" alt="рука с телефоном">
      </div>
    </div>
  </div>
</div>

<section class="CatSec1">
  <div class="container">
    <h2 class="CatH2">Каталог франшиз</h2>
    <h2 class="CatSec1P1">Выберите франшизу из каталога</h2>
    <?= Html::beginForm('franchizes', 'get', ['class' => 'filt__form']) ?>
    <div class="pow SelectCateg">
      <div class="navFransh">
        <div class="content__change--filter">
          <button type="button" class="active__button--filter">Выбор категории</button>
          <div style="display: none" class="change__folter__main">
            <?php foreach ($categoryFilter as $key => $item) : ?>
              <label class="Nf">
                <input name="filters[category][]" value="<?= $item['category'] ?>" type="checkbox" class="filterRadio">
                <?= $item['category'] ?>
              </label>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <div class="pow investVal">
        <p>Объем инвестиций</p>
        <select class="investOpt" name="filters[price]">
          <option selected value="Any">Любой</option>
          <option value="90000">до 100 000 ₽</option>
          <option value="300000">от 100 000 до 500 000 ₽</option>
          <option value="500000">от 500 000 ₽</option>
        </select>
      </div>
    </div>
    <?= Html::endForm(); ?>
    <?php Pjax::begin(['id' => 'Pjax_femida']); ?>
    <div class="Franchaizes">
      <?php if (!empty($franchaiz)) : ?>
        <?php foreach ($franchaiz as $item) : ?>
          <div onclick="location.href = '<?= Url::to(['franchize', 'link' => $item->link]) ?>'" class="FranchaizCard">
            <p><?= $item->name ?></p>
            <p><?= $item->category ?></p>
            <p>от <?= number_format($item->price, 0, ' ', ' '); ?> рублей</p>
            <img class="coolStory" src="<?= UrlHelper::admin($item->vendor) ?>" alt="logo franchaiz">
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <?php Pjax::end(); ?>
    <div class="addFranch">
      <a style="cursor: pointer" class="btn-batpodpShowPop batpodpShowPop">
        <span>Добавить свою франшизу</span>
        <img src="<?= Url::to(['/img/Plus.svg']) ?>" alt="icon plus">
      </a>
    </div>
    <div class="BSec3Know">
      <h3>Получите консультацию от специалиста</h3>
      <p style="max-width: 258px">Задайте все возникшие вопросы специалисту по франшизам</p>
      <a class="batpodp batpodpShowPop">Записаться</a>
    </div>
  </div>
</section>

<section class="CatSec2">
  <div class="container">
    <h2>Преимущества готовой франшизы</h2>
    <p class="FSec8P1">Главное достоинство франчайзинга — проверенная схема бизнеса и опыт франчайзера</p>
    <div class="pow preimFranGots">
      <div class="rol-3 preimFranGot">
        <img src="<?= Url::to(['/img/circle.webp']) ?>" alt="icon setting">
        <p>Гарантии конверсии и бизнес-показатели</p>
      </div>
      <div class="rol-3 preimFranGot">
        <img src="<?= Url::to(['/img/circle1.webp']) ?>" alt="icon cool">
        <p>Проверенные бизнесы с высокой маржей</p>
      </div>
      <div class="rol-3 preimFranGot">
        <img src="<?= Url::to(['/img/circle2.webp']) ?>" alt="icon diagram">
        <p>Полное обучение и сопровождение до выхода на точку окупаемости</p>
      </div>
      <div class="rol-3 preimFranGot">
        <img src="<?= Url::to(['/img/circle3.webp']) ?>" alt="icon list setting">
        <p>Собственные сервисы и технологии для бизнеса</p>
      </div>
    </div>
    <div class="naborFemidu">
      <h4>FEMIDA.FORCE</h4>
      <p>это команда профессиональных бизнес-тренеров, предпринимателей, инвесторов, и наставников (коучей),
        которая запустит Ваш бизнес с нуля, создаст нужную инфраструктуру, и доведет до эффективных
        бизнес-показателей</p>
    </div>
    <div class="polzStati">
      <h3>Полезные статьи</h3>
      <p class="FSec8P1">Подборка актуальной информации о франчайзинге</p>
      <div class="pow popularАrticlesCards1">
        <article><a href="<?= Url::to('vidu-franchizy') ?>" class="rol-3 popularАrticlesCard">
            <img src="<?= Url::to(['/img/Rectangle 46-1.webp']) ?>" alt="icon article">
            <h5 class="cardTextP1">Виды франшиз: классификация по характеру взаимоотношений</h5>
            <p class="cardTextP2">Статья по франчайзингу</p>
          </a></article>
        <article><a href="<?= Url::to('chto-takoe-franchaizing') ?>" class="rol-3 popularАrticlesCard">
            <img src="<?= Url::to(['/img/Rectangle 46-2.webp']) ?>" alt="icon article">
            <h5 class="cardTextP1">Что такое франчайзинг: нормы и законы</h5>
            <p class="cardTextP2">Статья по франчайзингу</p>
          </a></article>
        <article><a href="<?= Url::to(['kak-covid-povliyal-na-rasklad-sil']) ?>" class="rol-3 popularАrticlesCard">
            <img src="<?= Url::to(['/img/Rectangle 46.webp']) ?>" alt="icon article">
            <h5 class="cardTextP1">Как COVID-19 повлиял на расклад сил на страховом рынке</h5>
            <p class="cardTextP2">Статья по франчайзингу</p>
          </a></article>
        <article><a href="<?= Url::to('kak-kupit-franchizy') ?>" class="rol-3 popularАrticlesCard">
            <img src="<?= Url::to(['/img/Rectangle 45.webp']) ?>" alt="icon article">
            <h5 class="cardTextP1">Как купить франшизу: пошаговая инструкция, чтобы не потерять деньги</h5>
            <p class="cardTextP2">Статья по франчайзингу</p>
          </a></article>
      </div>
    </div>
  </div>
</section>

<section class="CatSec3">
  <div style="background-image: url('<?= Url::to(['/img/Group 120.webp']) ?>')" class="container">
    <?= Html::beginForm('', 'post', ['class' => 'finMod']) ?>
    <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
    <input type="hidden" name="formType" value="Получите финансовую модель бизнеса">
    <input type="hidden" name="pipeline" value="64">
      <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
      <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
    <input type="hidden" name="service" value="">
    <h4 class="finModP1">Получите финансовую модель бизнеса</h4>
    <div class="steps1">
      <p class="steps1P1">Зарегистрируйтесь в личном кабинете FEMIDA.FORCE и получите фин.модель </p>
      <input class="input1" required placeholder="ФИО" name="name" minlength="3" type="text">
      <input class="input1" required placeholder="Телефон" name="phone" type="tel">
      <div class="bottomForm">
        <button class="orangeLinkBtn">
          <span>Далее</span>
          <img src="<?= Url::to(['/img/whiteShape.svg']) ?>" alt="arrow">
        </button>
        <p class="bottomFormP1">Я соглашаюсь с условиями обработки персональных данных</p>
      </div>
    </div>
    <div class="steps2">
      <p class="BSec1StepP3">Введите код, полученный на номер телефон +7(999) 999-99-99 (<span class="changes">изменить</span>)
      </p>
      <div class="pow codeGive">
        <input type="text" placeholder="Код" name="code" class="inp1 rol-6">
        <a class="rol-4" href="<?= Url::to(['#']) ?>">Отправить код повторно через 59</script></a>
      </div>
      <p class="BSec1StepP4">Если Вы не получили код в течении 5 минут — напишите нам на почту <a href="<?= Url::to(['mailto:general@myforce.ru']) ?>">general@myforce.ru</a></p>
      <button class="orangeLinkBtn">
        <span>Перейти в кабинет</span>
        <img src="<?= Url::to(['/img/whiteShape.svg']) ?>" alt="arrow">
      </button>
    </div>
  </div>
  <?= Html::endForm() ?>
  </div>
</section>