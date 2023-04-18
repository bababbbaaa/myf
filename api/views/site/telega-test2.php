<?php

/**
 * @var \yii\web\View $this
 */

$js = <<<JS
var id;
var name;
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
        url: "https://api.myforce.ru/statistics/telegram-test2?chat=" + chat + '&id=' + id + '&name=' + name ,
        type: "GET"
    }).done(function() {
          window.Telegram.WebApp.close();
    });
});
$('.open-tg-pop').on('click', function() {
    id = $(this).attr('data-id');
    name = $(this).attr('data-name');
    $('.image-placeholder').attr('src', '/images/tg_info_' + id + '.jpg');
    $('.name').text(name);
    $('.popup').fadeIn(300, function() {
            window.Telegram.WebApp.MainButton.isVisible = true;
    });
});
$('.close-pps').on('click', function(e) {
    if (e.target.className === 'close-pps') {
        $('.popup').hide();
        window.Telegram.WebApp.MainButton.isVisible = false;
    }
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
        box-shadow: 3px 3px 4px #000000;
        padding: 10px;
        background: linear-gradient(0deg, rgba(13, 10, 10, 0.68), #0f3163);
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
    .info_name {
        font-weight: 700;
        font-size: 12px;
        margin: 10px 0 0;
    }
    .wrap > .container {
        padding: 0;
    }
    .wrap {
        background: #303030;
        color: white !important;
    }
    .popup {
        display: none;
        position: fixed;
        height: 100%;
        width: 100%;
        top: 0;
        left: 0;
        background: black;
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
    .popup-info-title {
        font-size: 20px;
        font-weight: 700;
    }
    .pick-size-picked {
        background: linear-gradient(0deg, rgb(255 198 198 / 62%), #ffffff) !important;
    }
</style>
<div>
    <div class="flex-block">
        <h3 style="font-family: monospace; font-size: 15px">Популярные курсы</h3>
    </div>
    <div class="flex-block">
        <div class="open-tg-pop" data-id="1" data-name='Курс "Веб-разработчик"'>
            <div>
                <img src="<?= \yii\helpers\Url::to(['/images/tg_info_1.jpg']) ?>" alt="">
            </div>
            <div class="info_name">JS-разработчик</div>
        </div>
        <div class="open-tg-pop" data-id="2" data-name='Курс "Data Scientist"'>
            <img src="<?= \yii\helpers\Url::to(['/images/tg_info_2.jpg']) ?>" alt="">
            <div class="info_name">Data Scientist</div>
        </div>
        <div class="open-tg-pop" data-id="3" data-name='Курс "DevOps"'>
            <img src="<?= \yii\helpers\Url::to(['/images/tg_info_3.jpg']) ?>" alt="">
            <div class="info_name">DevOps</div>
        </div>
    </div>
    <div class="flex-block">
        <div class="open-tg-pop" data-id="4" data-name='Курс "Программная инженерия"'>
            <img src="<?= \yii\helpers\Url::to(['/images/tg_info_4.jpg']) ?>" alt="">
            <div class="info_name">Программная инженерия</div>
        </div>
        <div class="open-tg-pop" data-id="5" data-name='Курс "C++ за 90 дней"'>
            <img src="<?= \yii\helpers\Url::to(['/images/tg_info_5.jpg']) ?>" alt="">
            <div class="info_name">C++ за 90 дней</div>
        </div>
        <div class="open-tg-pop" data-id="6" data-name='Курс "Маркетинг с нуля"'>
            <img src="<?= \yii\helpers\Url::to(['/images/tg_info_6.jpg']) ?>" alt="">
            <div class="info_name">Маркетинг с нуля</div>
        </div>
    </div>
</div>
<div class="popup">
    <div class="close-pps" style="color: black">&#9587;</div>
    <div>
        <img src="" class="image-placeholder" alt="">
        <div style="padding: 20px">
            <div class="popup-info-title"><span class="name"></span></div>
            <div style="color: #00e200; margin: 10px 0">19 999 руб.</div>
            <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam commodi corporis cumque deleniti dignissimos, dolorum earum, eos facilis harum illo labore mollitia non obcaecati quas quibusdam reprehenderit sapiente tenetur velit?</div>
        </div>
    </div>
</div>

