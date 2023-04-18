<?php

use core\assets\AppAsset;
use yii\helpers\Url;

$this->title = 'Заявка';
$js = <<< JS
 $('form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      url: "/site/form",
      method: "POST",
      dataType: 'JSON',
      data: $(this).serialize(),
      beforeSend: function () {
        $('.preloader').fadeIn(300);
      }
    }).done(function () {
        $('.preloader').fadeOut(1);
        $('.thanks-step-1').fadeOut(300, function () {
            $(".thanks-step-2").fadeIn(300);
        })
    })
  });
JS;
$css =<<< CSS
    .header {
        background: #000E1A;
        border-bottom: none;
    }

    .main {
        margin-top: 78px;
    }

    .header__active {
        animation-name: none;
    }

    @media (max-width: 890px) {
        .thanks-background {
            margin-top: 72px;
         }
    }

    @media (max-width: 600px) {
      .thanks-background {
        margin-top: 70px;
      }
    }

    @media (max-width: 400px) {
      .thanks-background {
        margin-top: 64px;
      }
    }
CSS;
$this->registerCss($css);
$this->registerJs($js);
$this->registerCssFile(Url::to(['/css/arbitraj/arbitration-thanks.css']), ['depends' => [AppAsset::className()]]);
?>
<div class="thanks-background">
    <div class="container">
        <div class="form-background">
            <section style="display: block;" class="thanks-step-1" hidden>
                <h2>Укажите ваши данные для связи</h2>
                <form action="">
                    <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
                    <input type="hidden" name="formType" value="Форма со страницы арбитража">
                    <input type="hidden" name="pipeline" value="110">
                    <input type="hidden" value="" name="city">
                    <input type="hidden" value="" name="new_region">
                    <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
                    <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
                    <input type="hidden" name="service" value="">
                    <input type="text" required name="name" placeholder="Имя">
                    <input type="tel" required name="phone" placeholder="Телефон">
                    <button class="arbitration-thanks-btn">Узнать подробнее</button>
                    <div class="thanks-step-1__info">
                        Нажимая «Зарегистрироваться» Вы соглашаетесь, что ознакомлены
                        с <a href="">условиями использования</a> и <a href="">политикой конфиденциальности</a>
                    </div>
                </form>
            </section>

            <section class="thanks-step-2" hidden>
                <h2>Благодарим за заявку!</h2>
                <div>Менеджер свяжется с вами в течение 3 минут и подробно вас проконсультирует</div>
            </section>
        </div>
    </div>
</div>
<div class="preloader">
    <div class="preloader_body">
        <div class="lds-dual-ring"></div>
        <p>Идет отправка ожидайте...</p>
    </div>
</div>