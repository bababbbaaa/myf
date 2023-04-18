<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;
use common\models\helpers\UrlHelper;

$this->title = $franch['name'];
$jsons = json_encode($popupdata, JSON_UNESCAPED_UNICODE);
$json = json_encode($region, JSON_UNESCAPED_UNICODE);
$jfranch = json_decode($franch->render_data);
$videoLink = !empty($videoshow) ? json_encode($videoshow, JSON_UNESCAPED_UNICODE) : '{}';
$guest = Yii::$app->user->isGuest;

$js = <<<JS

var cas = $videoLink;
    $('.showVideoRews').on('click', function () {
        var i = $(this).attr('data-id');
           $('#videoId').attr('src', cas[i]); 
        // $('.RenderVideo').html('')
        $('.backRevs').fadeIn(300);
    });
    $('.closeRevs, .backRevs').on('click', function (e) {
        if(e.target == this) $('.backRevs').fadeOut(300);
    });

var obj = {$json};
$('.hovpas').on('click', function() {
    var region = $(this).attr('data-region');
    if($('.hovpas').hasClass('hovpasChecked')){
        $('.hovpas').removeClass('hovpasChecked');
        $(this).addClass('hovpasChecked');
    }else {
        $('.hovpas').removeClass('hovpasChecked');
        $(this).addClass('hovpasChecked');
    }
    $('.popup1').fadeIn(300);
    $('.addressPart').html('');
    for(var i=0; i<obj[region].length; i++){
        $('.addressPart').append('<div class="partners"><span class="nameFirm">'+ obj[region][i].partner_name +' </span><span class="cityFirm">'+ obj[region][i].city +' </span><span class="stritFirm">'+ obj[region][i].address +' </span></div>');
    }
});

    $('.slider').slick({
        slidesToShow: 2,
        slidesToScroll: 2,
        autoplay: true,
        autoplaySpeed: 10000,
        responsive: [
        {
          breakpoint: 800,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          }
        },
      ]
    });

    $('.batpodpShowPop').on('click', function() {
        $('.technoback').fadeIn(300);
    });

    $('.technoclose, .technoback').on('click', function(e) {
        if (e.target == this) $('.technoback').fadeOut(300);
    });


 
     $('.showPopFin').on('click', function() {
        $('.pakageback').fadeIn(300);
    });

    $('.popclosedPack, .pakageback').on('click', function(e) {
        if (e.target == this) $('.pakageback').fadeOut(300);
    });
 
 $('.finMod2').on('submit', function (e) {
     $.ajax({
               url: "/site/form",
               type: "POST",
               data: $(".finMod2").serialize(),
               beforeSend: function () {
                   $('.steps1').fadeOut(300, function () {
                       $('.steps2').fadeIn(300);
                   });},
           }).done(function () {
           });
     e.preventDefault();
    });
 
 var objs = $jsons;
    
    $('.HovPopup').on('click', function() {
        console.log('ok');
        var item = $(this).attr('data-click'),
            listItem = '',
            popup = JSON.parse(objs[item].popup_data);
        $('.nameTechno').html(objs[item].name);
        $('.abTechno').html(objs[item].subtitle);
        $('.technoBottom').html(objs[item].preview);
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
JS;
$this->registerJs($js);
$this->registerJsFile(Url::to(['/js/slick.min.js']), ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerCssFile(Url::to(['/css/slick.css']));
$this->registerCssFile(Url::to(['/css/slick-theme.css']));
?>

<section class="FSec1">
  <div class="container">
    <div class="franchize__image--first">
      <div class="img__container" style="background-image: url('<?= UrlHelper::admin($jfranch->first_section->img) ?>')">
      </div>
      <div class="FSec1Head">
        <h2><?= $jfranch->first_section->small_article ?></h2>
        <h1><?= $jfranch->first_section->big_article ?></h1>
        <p><?= $jfranch->first_section->vendor ?></p>
        <div class="pow Fsec1Inform">
          <div class="rol-6">
            <p>Размер инвестиций</p>
            <p><?= $jfranch->first_section->price ?></p>
          </div>
          <div class="rol-6">
            <p>Срок окупаемости</p>
            <p><?= $jfranch->first_section->feedback ?></p>
          </div>
        </div>
        <button class="batpodp batpodpShowPop">Открыть бизнес</button>
      </div>
    </div>
  </div>
</section>

<section class="FSec2">
  <div class="container">
    <div class="franchize__image--first">
      <div class="FSec2S1">
        <h2><?= $jfranch->second_section->article ?></h2>
        <div class="FSec2S1textInfo"><?= $jfranch->second_section->text ?></div>
        <div class="franchizeInfo">
          <div class="franchizeInfoCard">
            <p>Собственных офисов</p>
            <p><?= $jfranch->second_section->office ?></p>
          </div>
          <div class="franchizeInfoCard">
            <p>Франшизных офисов</p>
            <p><?= $jfranch->second_section->office_franchise ?></p>
          </div>
          <div class="franchizeInfoCard">
            <p>Год основания франшизы</p>
            <p><?= $jfranch->second_section->year ?></p>
          </div>
        </div>
      </div>
      <div class="img__container" style="background-image: url('<?= UrlHelper::admin($jfranch->second_section->img) ?>')">
      </div>
    </div>
  </div>
</section>

<section class="FSec3">
  <div class="container">
    <h3><?= $jfranch->third_section->article ?></h3>
    <p class="FSec3P1"><?= nl2br($jfranch->third_section->text) ?></p>
    <div class="FSec3Preim">
      <?php foreach ($jfranch->third_section->advantage as $item) : ?>
        <div class="PreimFranch">
          <img src="<?= Url::to(['/img/Flame.svg']) ?>" alt="flame icon">
          <p><?= $item ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="FSec4">
  <div class="container">
    <h3><?= $jfranch->fourth_section->article ?></h3>
    <p class="FSec4P1"><?= $jfranch->fourth_section->text ?></p>
    <div class="pow FPacks">
      <?php foreach ($package as $item) : ?>
        <div class="rol-4 FPackage">
          <div class="FPackageHead">
            <p class="FPackageHeadP1">пакет</p>
            <h5 class="FPackageHeadP2"><?= $item->name ?></h5>
            <div class="PackValues">
              <div class="PackValue">
                <?= $item->package_content ?>
              </div>
            </div>
          </div>
          <div class="FPackageFooter">
            <p class="FPackageFooterP1"><?= number_format($item->price,  0, ' ', ' '); ?> ₽</p>
            <p class="FPackageFooterP2">узнайте больше о пакете</p>
            <button type="button" class="batpodp showPopFin">Получить фин.модель</button>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="FSec5">
  <div class="container">
    <h3><?= $jfranch->fifth_section->article ?></h3>
    <p class="FSec5P1"><?= $jfranch->fifth_section->text ?></p>
    <div class="franchize__image--first">

      <div class="StepedWork">
        <?php foreach ($jfranch->fifth_section->stage as $item) : ?>
          <div class="StepsWork">
            <div class="redNubmer"></div>
            <p class="StepsWorkP1"><?= $item ?></p>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="img__container1" style="background-image: url('<?= UrlHelper::admin($jfranch->fifth_section->img) ?>')">
      </div>
    </div>
  </div>
</section>

<section class="FSec6">
  <div style="background-image: url('<?= Url::to(['/img/LoginRegister.webp']) ?>')" class="container">
    <h4>Ваш личный кабинет MYFORCE</h4>
    <p class="FSec6P1">Единая платформа для вашего бизнеса</p>
    <div class="LcS6">
      <div class="FS6Lc">
        <img src="<?= Url::to(['/img/Flame.svg']) ?>" alt="flame icon">
        <p>Аукционы лидов, скидки, базы знаний. Не переплачивайте за возможности, которыми не пользуетесь</p>
      </div>
      <div class="FS6Lc">
        <img src="<?= Url::to(['/img/Flame.svg']) ?>" alt="flame icon">
        <p>Онлайн с любого устройства. Доступ к партнерской документации</p>
      </div>
      <div class="FS6Lc">
        <img src="<?= Url::to(['/img/Flame.svg']) ?>" alt="flame icon">
        <p>Управление сделками. Системный контроль качества заявок и работы менеджеров</p>
      </div>
      <div class="LcMt">
        <?php if (!$guest) : ?>
          <a href="https://user.myforce.ru/" class="orangeLink">
            <span>Кабинет</span>
            <img src="<?= Url::to(['/img/whiteShape.svg']) ?>" alt="arrow">
          </a>
        <?php else : ?>
          <a class="orangeLink BLS6CBORID-BTN">
            <span>Регистрация</span>
            <img src="<?= Url::to(['/img/whiteShape.svg']) ?>" alt="arrow">
          </a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($cases)) : ?>
  <section class="FSec7">
    <div class="container">
      <h4>Кейсы и отзывы наших партнеров</h4>
      <p class="FSec7P1">Лучше любой рекламы</p>
      <div class="videoCases">
        <?php foreach ($cases as $key => $item) : ?>
          <article class="videoCase">
            <div class="case__image">
              <img src="<?= UrlHelper::admin($item['img']) ?>" alt="image partner">
            </div>
            <div class="VideoBody">
              <p><?= $item['name'] ?></p>
              <p><?= $item['whois'] ?></p>
              <p><?= $item['status'] ?></p>
              <p>Инвестиции: <span><?= $item['investments'] ?></span></p>
              <p>Точка окупаемости: <span><?= $item['feedback'] ?></span></p>
              <p>Средний доход в месяц: <span><?= $item['income_approx'] ?> ₽</span></p>
              <p>Офисы: <span><?= $item['offices'] ?></span></p>
              <?php if (!empty($item['video'])) : ?>
                <div class="showers">
                  <a style="cursor: pointer" data-id="<?= $item['id'] ?>" class="linkTelega showVideoRews">
                    <span>Смотреть видео-отзыв</span>
                    <img src="<?= Url::to(['/img/Shape1.webp']) ?>" alt="arrow">
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </article>
        <?php endforeach; ?>
        <div class="backRevs">
          <div class="mainRevs">
            <div class="closeRevs">&times;</div>
            <iframe id="videoId" width="560" height="315" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          </div>
        </div>
      </div>
      <div class="slider">
        <?php foreach ($reviews as $item) : ?>
          <article class="slide">
            <div class="headSlide">
              <div class="ratings">
                <div class="ratingBlock">
                  <div class="rating" style="background-image: url('<?= Url::to(['/img/Star.svg']) ?>'); width: <?= $item->rating ?>%"></div>
                  <div class="rating" style="background-image: url('<?= Url::to(['/img/Star.svg']) ?>'); z-index: 1; filter: grayscale(100%)"></div>
                </div>
                <p class="ratingp"><?= $item->rating ?></p>
              </div>
              <p class="headSlideDate"> <?= date('d-m-Y', strtotime($item->date)) ?></p>
            </div>
            <p class="contentSlide"> <?= $item->content ?></p>
            <p class="autorSlide"> <?= $item->author ?></p>
          </article>
        <?php endforeach; ?>
      </div>
      <div class="slider1">
        <?php foreach ($reviewses as $item) : ?>
          <article class="slide">
            <div class="headSlide">
              <div class="ratings">
                <div class="ratingBlock">
                  <div class="rating" style="background-image: url('<?= Url::to(['/img/Star.svg']) ?>'); width: <?= $item->rating ?>%"></div>
                  <div class="rating" style="background-image: url('<?= Url::to(['/img/Star.svg']) ?>'); z-index: 1; filter: grayscale(100%)"></div>
                </div>
                <p class="ratingp"><?= $item->rating ?></p>
              </div>
              <p class="headSlideDate"> <?= date('d-m-Y', strtotime($item->date)) ?></p>
            </div>
            <p class="contentSlide"> <?= $item->content ?></p>
            <p class="autorSlide"> <?= $item->author ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>
<?php if (!empty($technologies)) : ?>
  <section class="FSec8">
    <div class="container">
      <h4><?= $jfranch->seventh_section->title ?></h4>
      <p class="FSec8P1">Мы предоставляем своим партнерам комплекс продуктов и услуг для развития бизнеса</p>
      <div class="pow FSHelps">
        <?php foreach ($technologies as $k => $item) : ?>
          <div data-click="<?= $item['id'] ?>" class="rol-3 FSHelp HovPopup <?php if ($k == 0) : ?> FSHelp_color <?php elseif ($k == 1) : ?> FSHelp_color1 <?php elseif ($k == 2) : ?> FSHelp_color2 <?php else : ?> FSHelp_color3 <?php endif; ?>">
            <img src="<?= Url::to(['/img/settings.svg']) ?>" alt="icon setting">
            <h5><?= $item['name'] ?></h5>
            <p><?= $item['preview'] ?></p>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
<?php endif; ?>

<section class="GlSec5 closedsPops">
  <div class="container closedsPops">
    <h5>Карта охвата</h5>
    <p class="p1">Офисы партнеров по всей стране</p>
    <?php require_once('maps.php'); ?>
  </div>
</section>

<div class="pakageback">
  <div class="pakagePop">
    <div class="popclosedPack">&times;</div>
    <?= Html::beginForm('', 'post', ['class' => 'finMod2']) ?>
    <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
    <input type="hidden" name="formType" value="Получите финансовую модель бизнеса">
    <input type="hidden" name="pipeline" value="64">
    <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
    <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
    <input type="hidden" name="service" value="">
    <p style="text-align: left" class="finModP1">Получите финансовую модель бизнеса</p>
    <div class="steps1">
      <p style="text-align: left" class="steps1P1">Зарегистрируйтесь в личном кабинете FEMIDA.FORCE и получите
        фин.модель </p>
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
    <?= Html::endForm() ?>
  </div>
</div>
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
      <input type="hidden" name="pipeline" value="64">
      <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
      <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
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
      <p class="giveYslP1">Спасибо за заявку!</p>
      <p class="giveYslP2">Мы свяжемся с вами в ближайшее время</p>
      <div style="text-align: center"><img src="<?= Url::to(['/img/LastRef.webp']) ?>" alt="рука с телефоном">
      </div>
    </div>
  </div>
</div>