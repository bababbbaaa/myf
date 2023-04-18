<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = "Реферальная программа";
$js = <<<JS
$('.inp-ref').on('click', function() {
    $(this).select();
});
JS;
$this->registerJs($js);
?>


<style>
    .leadgen-main-div {
        font-size: 14px;
        padding: 20px 20px;
    }
    .inp-spc {
        max-width: 450px;
        width: 100%;
        border-radius: 3px;
        border: 1px solid gainsboro;
        padding: 5px 10px;
        letter-spacing: 0.1em;
    }
    .mb15{
        margin-bottom: 25px;
    }
    .header-h {
        letter-spacing: 0.1em;
        color: black;
    }
    .non-header {
        color: #616161;
    }
    code {
        background-color: #2b3048;
        color: white;
        padding: 3px 7px;
        font-size: 12px;
    }
    .flex-api-block {
        display: flex;
        flex-direction: column;
    }
    .flex-api-block > div {
        margin: 5px;
        display: flex;
        align-items: flex-start;
        width: 600px;
        justify-content: space-between;
        border-bottom: 1px solid gainsboro;
        padding-bottom: 10px;
    }
    .flex-api-block > div:last-child {
        border-bottom: unset;
    }
    .flex-api-block.special {
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
    }
    .flex-api-block > div.special {
        border-bottom: 0;
        width: unset;
    }
    .span-desc {
        color: #636363;
    }
    .spc-ul-1 {
        list-style: circle !important;
        padding-left: 25px !important;
    }
    .spc-ul-1 > li {
        margin-bottom: 10px;
    }
    pre {
        overflow-x: auto;
    }
    .inp-ref {
        padding: 10px;
        width: 100%;
        max-width: 700px;
        border: 1px solid gainsboro;
    }
</style>
<section class="rightInfo adAptive">
    <div class="balance">
        <div class="bcr">
            <ul class="bcr__list">
                <li class="bcr__item">
                  <span class="bcr__link">
                    Реферальная программа
                  </span>
                </li>
            </ul>
        </div>

        <?php if(!empty($provider)): ?>
            <div class="title_row">
                <h1 class="Bal-ttl title-main">Реферальная программа</h1>
            </div>

            <article class="MainInfo">
                <div class="leadgen-main-div">
                    <div style="margin-bottom: 10px"><b>Моя реферальная ссылка</b></div>
                    <div>
                        <input type="text" class="form-control inp-ref" readonly value="https://myforce.ru/lead/about-leads?ref=<?= $provider->referal ?>">
                    </div>
                </div>
                <div style="margin-top: 0px; font-size: 14px; padding: 20px; padding-top: 0">
                    <p style="margin-bottom: 10px"><b>Условия</b></p>
                    <ul>
                        <li style="margin-bottom: 10px">каждый зарегистрированный по вашей ссылке пользователь считается, как пришедший по вашей реферальной программе клиент</li>
                        <li style="margin-bottom: 10px">за каждого целевого, подтвержденного клиента &ndash; вы получаете 250 рублей на счет</li>
                        <li>для зачисления средств на счет &ndash; клиенты, пришедшие по программе, сначала должны пройти модерацию</li>
                    </ul>
                </div>
            </article>
        <?php else: ?>
            <div class="title_row">
                <h1 class="Bal-ttl title-main">Реферальная программа</h1>
            </div>

            <article class="MainInfo">
                <div style="padding: 20px; font-size: 13px">Для работы реферальной программы необходимо заполнить <a style="color: #9e0505" href="prof">профиль</a></div>
            </article>
        <?php endif; ?>
    </div>
</section>