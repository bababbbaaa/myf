<?php

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Франшиза Экосистема для предпринимателей MYFORCE';
$js = <<< JS
$('.package-card__link').on('click', function() {
  $('.catalogpage__popup').fadeIn(300);
});
$('.catalogpage__main-link').click(function(){
    $('html, body').stop().animate({
      scrollTop: $($(this).attr('href')).offset().top - 80
    }, 300);
    return false;
  });

    var idPackage,
        idFranchize,
        type;
    $('.byFranchize').on('click', function() {
      idPackage = $(this).attr('data-package');
      idFranchize = $(this).attr('data-franchize');
      type = $(this).attr('data-type');
    });

    $('.popup__btn-ok1').on('click', function() {
      $.ajax({
        url: '/femida/client/by-franchize',
        data: {idPackage:idPackage, idFranchize:idFranchize, type:type},
        type: 'POST',
        dataType: 'JSON',
      }).done(function(rsp) {
          if (rsp.status === 'balance'){
              $('.catalogpage__popup').fadeOut(1);
            Swal.fire({
              icon: 'error',
              title: 'Не достаточно средств на балансе',
              text: 'Перейти к пополнению баланса?',
            }).then(function(result) {
              if (result.value === true){
                  location.href = "../balance";
              }
            })
          }
          if (rsp.status === 'error'){
              $('.catalogpage__popup').fadeOut(1);
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: rsp.message,
            })
          }
          if (rsp.status === 'success'){
              location.reload();
          }
      })
    });
    
    tinkoff.methods.on(tinkoff.constants.SUCCESS, onMessage);
    tinkoff.methods.on(tinkoff.constants.REJECT, onMessage);
    tinkoff.methods.on(tinkoff.constants.CANCEL, onMessage);
    function onMessage(data) {
      switch (data.type) {
        case tinkoff.constants.SUCCESS:
          $.ajax({
            data: {id: idCredit, hex: hex},
            dataType: "JSON",
            type: "POST",
            url: "/cabinet/buy-franchise-credit",
          }).done(function(rsp) {
              if (rsp.status === 'success') {
                Swal.fire({
                  icon: 'success',
                  title: 'Успешно!',
                  text: "Франшиза куплена! Пожалуйста свяжитесь с технической поддержкой для получения дополнительной информации.",
                  onClose: function(){
                      location.reload();
                  }
                });
            } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Ошибка',
                  text: 'Статус: '+rsp.reason
                });
            }
          });
          break;
        case tinkoff.constants.REJECT:
          Swal.fire({
              icon: 'error',
              title: 'ОТКАЗ',
              text: 'В предоставлении кредита отказано.'
            });
          break;
        case tinkoff.constants.CANCEL:
          Swal.fire({
              icon: 'error',
              title: 'ОТМЕНА',
              text: 'Процедура завершена по отказу пользователя.'
            });
          break;
        default:
          return;
      }
      tinkoff.methods.off(tinkoff.constants.SUCCESS, onMessage);
      tinkoff.methods.off(tinkoff.constants.REJECT, onMessage);
      tinkoff.methods.off(tinkoff.constants.CANCEL, onMessage);
      data.meta.iframe.destroy();
    }
    var
        hex = null,
        idCredit = null;
    $('.credit-add-btn').on('click', function() {
        idCredit = $(this).attr('data-id');
        hex = $(this).attr('data-hex');
    });

JS;
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/alert.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile("https://forma.tinkoff.ru/static/onlineScript.js");
$this->registerJsFile("https://shop.otpbank.ru/form/js/form.min.js");
$this->registerJs($js);

$render = json_decode($franchize['render_data'], true)
?>
<section class="rightInfo">
    <div class="catalogpage">
        <div class="bcr">
            <ul class="bcr__list">
                <li class="bcr__item">
                    <a href="<?= Url::to(['catalog']) ?>" class="bcr__link">
                        Каталог франшиз
                    </a>
                </li>
                <li class="bcr__item">
          <span class="bcr__span">
            <?= $franchize['name'] ?>
          </span>
                </li>
            </ul>
        </div>
        <div class="catalogpage__main">
            <div class="catalogpage__wrapp">
                <div class="catalogpage__main-inner">
                    <div class="catalogpage__main-content">
                        <h1 class="catalogpage__title">
                            <?= $franchize['name'] ?>
                        </h1>
                        <p class="catalogpage__main-subtext">
                            <?= $franchize['category'] ?>
                        </p>

                        <div class="catalogpage__main-info">
                            <div class="catalogpage__main-item">
                                <p class="catalogpage__main-dec">
                                    Размер инвестиций
                                </p>
                                <p class="catalogpage__main-num">
                                    <?= number_format($franchize['price'], 0, 0, ' ') ?> руб
                                </p>
                            </div>

                            <div class="catalogpage__main-item">
                                <p class="catalogpage__main-dec">
                                    Срок окупаемсти
                                </p>
                                <p class="catalogpage__main-num">
                                    <?= $render['first_section']['feedback'] ?>
                                </p>
                            </div>
                        </div>

                        <a href="#package" class="catalogpage__main-link">Открыть бизнес</a>
                    </div>
                    <div class="catalogpage__main-img">
                        <img src="<?= Url::to([$franchize['vendor']]) ?>" alt="<?= $franchize['name'] ?>"/>
                    </div>
                </div>

                <h2 class="catalogpage__main-title">
                    <?= $render['second_section']['article'] ?>
                </h2>

                <div class="catalogpage__article">
                    <div class="catalogpage__article-content">
                        <div class="catalogpage__article-text">
                            <?= $render['second_section']['text'] ?>
                        </div>
                        <h3 class="catalogpage__main-title">
                            <?= $render['third_section']['article'] ?>
                        </h3>
                        <p class="catalogpage__article-text">
                            <?= $render['third_section']['text'] ?>
                        </p>

                        <ul class="catalogpage__article-list">
                            <?php foreach ($render['third_section']['advantage'] as $k => $v): ?>
                                <li class="catalogpage__article-item">
                                    <?= $v ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <aside class="catalogpage__article-aside aside">
                        <div class="aside__main">
                            <p class="aside__main-title">
                                Факты о <?= $render['first_section']['vendor'] ?>
                            </p>
                            <div class="aside__main-item">
                                <p class="aside__main-info">
                                    Собственных офисов:
                                </p>
                                <p class="aside__main-num">
                                    <?= $render['second_section']['office'] ?>
                                </p>
                            </div>

                            <div class="aside__main-item">
                                <p class="aside__main-info">
                                    Франшизных офисов:
                                </p>
                                <p class="aside__main-num">
                                    <?= $render['second_section']['office_franchise'] ?>
                                </p>
                            </div>

                            <div class="aside__main-item">
                                <p class="aside__main-info">
                                    Год основания франшизы:
                                </p>
                                <p class="aside__main-num">
                                    <?= $render['second_section']['year'] ?> г.
                                </p>
                            </div>
                        </div>
                    </aside>
                </div>
            </div>
            <div id="package" class="catalogpage__package">
                <h2 class="catalogpage__package-title">
                    Стоимость франшизы Digital агентства
                </h2>
                <p class="catalogpage__package-subtitle">
                    Сколько стоит франшиза экосистемы для предпринимателей MYFORCE
                </p>
                <?php foreach ($packages as $v): ?>
                    <article class="catalogpage__package-card package-card">
                        <div class="package-card__top">
                            <p class="package-card__info">
                                Пакет
                            </p>
                            <h3 class="package-card__title">
                                <?= $v['name'] ?>
                            </h3>
                        </div>
                        <div class="package-card__inner">
                            <div class="package-card__content">
                                <?= $v['package_content'] ?>
                            </div>

                            <div class="package-card__main">

                                <div class="package-card__price">
                                    <span class="package-card__price-text">Стоимость:</span>
                                    <span class="package-card__price-summ"><?= number_format($v['price'], 0,0,' ') ?> ₽</span>
                                </div>
<!--                                <?php /*$hex = md5("::{$franchize['id']}::createSimpleTinkoffHexForValid::"); */?>
                                <button data-franchize="<?/*= $franchize['id'] */?>" data-package="<?/*= $v['id'] */?>" data-type="credit" type="button" class="catalog__cards-btn catalog__cards-btn--white byFranchize" onclick="javascript:otpform.start({
                                        view: 'newTab',
                                        /*accessID: '7852',
                                        tradeID: '15078',*/
                                        accessID: '7852',
                                        tradeID: '15078',
                                        creditFirstPaymentFrom: '',
                                        creditFirstPaymentTo: '',
                                        creditTermFrom: '3',
                                        creditTermTo: '36',
                                        creditType: '2',
                                        nometrika: 'Y',
                                        hostname: 'https://femidafors.ru/cabinet/buy-franchise-credit?hex=<?/*=$hex*/?>&id=<?/*=$v['id']*/?>',
                                        items: [
                                        {
                                        name: 'Франшиза: <?/*= str_replace("\"","", $franchize['name']) */?>',
                                        price: '<?/*= $v['price'] */?>',
                                        count: '1',
                                        }
                                        ],
                                        });">Купить в кредит</button>-->
                                <button data-franchize="<?= $franchize['id'] ?>" data-package="<?= $v['id'] ?>" data-type="pay" type="button" class="package-card__link byFranchize">
                                    Купить франшизу
                                </button>

                                <a href="<?= Url::to(['support']) ?>" class="package-card__btn">
                                    Получить фин.модель
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="popup popup--ok catalogpage__popup">
        <div class="popup__ov">
            <div class="popup__body popup__body--ok">
                <div class="popup__content popup__content--ok">
                    <p class="popup__title">Вы уверены что хотите купить эту франшизу?</p>
                    <div style="display: flex">
                        <button class="popup__btn-ok1 btn">Да</button>
                        <button style="background-color: #fb593b" class="popup__btn-ok btn">Нет</button>
                    </div>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
</section>