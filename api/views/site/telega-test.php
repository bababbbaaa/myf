<?php

/**
 * @var \yii\web\View $this
 */

$js = <<<JS
var id;
var size;
var chat;
$('.kek').on('click', function() {
    $(this).toggleClass('kek-marked');
});
window.Telegram.WebApp.MainButton.text = 'Продолжить';
window.Telegram.WebApp.MainButton.isVisible = false;
window.Telegram.WebApp.ready();
window.Telegram.WebApp.MainButton.onClick(function() {
    chat = window.Telegram.WebApp.initDataUnsafe.user.id;
    $.ajax({
        url: "https://api.myforce.ru/statistics/telegram-test?chat=" + chat + '&id=' + id + '&size=' + size ,
        type: "GET"
    }).done(function() {
          window.Telegram.WebApp.close();
    });
});
$('.open-tg-pop').on('click', function() {
    id = $(this).attr('data-id');
    $('.image-placeholder').attr('src', '/images/tg_merch_' + id + '.jpg');
    $('.num-name').text(id);
    $('.popup').fadeIn(300);
});
$('.close-pps').on('click', function(e) {
    if (e.target.className === 'close-pps') {
        $('.popup').hide();
        window.Telegram.WebApp.MainButton.isVisible = false;
        $('.pick-size').each(function() {
            $(this).removeClass('pick-size-picked');
        });
    }
});
$('.pick-size').on('click', function() {
    $('.pick-size').each(function() {
        $(this).removeClass('pick-size-picked');
    });
    $(this).toggleClass('pick-size-picked');
    size = $(this).attr('data-size');
    window.Telegram.WebApp.MainButton.isVisible = true;
});
JS;

$this->registerJsFile("https://telegram.org/js/telegram-web-app.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJs($js);
?>
<style>
    .kek {
        color: white; background: darkgray; padding: 20px; width: 200px; border-radius: 10px; border: 0;
        transition: 0.3s ease;
    }
    .kek-marked {
        background: black;
    }
    .flex-block {
        display: flex; flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 15px;
        justify-content: center;
    }
    .flex-block > div {
        border-radius: 8px;
        box-shadow: 3px 3px 4px #ededed;
        padding: 10px;
        background: linear-gradient(0deg, #fff3f3ad, #ffffff);
        max-width: 100px;
        width: 100%;
        text-align: center;
        transition: 0.3s ease;
    }
    .flex-block img {
        max-width: 100px;
        width: 100%;
        height: 100px;
        object-fit: cover;
        object-position: top;
        margin: 0 auto;
    }
    .merch_name {
        font-weight: 700;
        font-size: 12px;
        margin: 10px 0 0;
    }
    .wrap > .container {
        padding: 0;
    }
    .wrap {
        background: linear-gradient(180deg, #f3fcff, #dfdfdf)
    }
    .popup {
        display: none;
        position: fixed;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        background: white;
        overflow: auto;
    }
    .close-pps{
        display: block;
        position: absolute;
        top: 25px;
        right: 25px;
        cursor: pointer;
    }
    .image-placeholder {
        object-fit: cover;
        object-position: top;
        width: 100%;
        height: 300px;
    }
    .popup-merch-title {
        font-size: 20px;
        font-weight: 700;
    }
    .pick-size-picked {
        background: linear-gradient(0deg, rgb(255 198 198 / 62%), #ffffff) !important;
    }
</style>
<div>
    <div class="flex-block">
        <h3 style="font-family: monospace; font-size: 15px">Официальный магазин мерча Kit</h3>
    </div>
    <div class="flex-block">
        <div class="open-tg-pop" data-id="1">
            <div>
                <img src="<?= \yii\helpers\Url::to(['/images/tg_merch_1.jpg']) ?>" alt="">
            </div>
            <div class="merch_name">Футболка 1</div>
        </div>
        <div class="open-tg-pop" data-id="2">
            <img src="<?= \yii\helpers\Url::to(['/images/tg_merch_2.jpg']) ?>" alt="">
            <div class="merch_name">Футболка 2</div>
        </div>
        <div class="open-tg-pop" data-id="3">
            <img src="<?= \yii\helpers\Url::to(['/images/tg_merch_3.jpg']) ?>" alt="">
            <div class="merch_name">Футболка 3</div>
        </div>
    </div>
    <div class="flex-block">
        <div class="open-tg-pop" data-id="4">
            <img src="<?= \yii\helpers\Url::to(['/images/tg_merch_4.jpg']) ?>" alt="">
            <div class="merch_name">Футболка 4</div>
        </div>
        <div class="open-tg-pop" data-id="5">
            <img src="<?= \yii\helpers\Url::to(['/images/tg_merch_5.jpg']) ?>" alt="">
            <div class="merch_name">Футболка 5</div>
        </div>
        <div class="open-tg-pop" data-id="6">
            <img src="<?= \yii\helpers\Url::to(['/images/tg_merch_6.jpg']) ?>" alt="">
            <div class="merch_name">Футболка 6</div>
        </div>
    </div>
</div>
<div class="popup">
    <div class="close-pps">&#9587;</div>
    <div>
        <img src="" class="image-placeholder" alt="">
        <div style="padding: 20px">
            <div class="popup-merch-title">Футболка <span class="num-name"></span></div>
            <div>1999 руб.</div>
            <div>Любое описание ...</div>
            <hr>
            <div style="text-align: center; margin-bottom: 20px">Выбрать Размер</div>
            <div class="flex-block">
                <div class="pick-size" data-size="S"><b>S</b></div>
                <div class="pick-size" data-size="M"><b>M</b></div>
                <div class="pick-size" data-size="L"><b>L</b></div>
            </div>
        </div>
    </div>
</div>

