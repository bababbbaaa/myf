<?php

use yii\helpers\Url;


$this->title = 'Руководство по базе знаний';

?>
<section class="rightInfo">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <a href="<?= Url::to(['index']) ?>" class="bcr__link">
                    Главная
                </a>
            </li>
            <li class="bcr__item">
                <a href="<?= Url::to(['manual']) ?>" class="bcr__link">
                    Руководство пользователя
                </a>
            </li>
            <li class="bcr__item">
                <span class="bcr__span">
                База знаний
                </span>
            </li>
        </ul>
    </div>
    <h1 class="usermanual_title title-main">База знаний</h1>
    <section class="usermanualmain_info">
        <div class="usermanualmain_info_row">
            <img src="<?= Url::to(['/img/afo/base-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                На данной странице собрана вся актуальная информация о рекламе, продвижении, маркетинге и подборе специалистов для ваших проектов
                </p>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
            Функции
            </h2>
            <div class="usermanualmain_info_row">
                <div class="usermanualmain_info_row_right">
                    <h3 class="usermanualmain_info_column-title">
                        1. Фильтр по статьям
                    </h3>
                    <p class="usermanualmain_info_row_right-text">
                    Вы можете отфильтровать статьи по 
                    <br><br>
                    - направлению в рекламе
                    <br>
                    - по наличию видео
                    <br>
                    - по рекламной площадке
                    <br><br>
                    Также вы можете найти статью, используя поисковую строку
                    </p>
                </div>
                <img src="<?= Url::to(['/img/afo/base-2.png']) ?>" alt="скриншот страницы">
            </div>
            <h3 class="usermanualmain_info_column-title">
            2. Статьи и подборки
            </h3>
            <p class="usermanualmain_info_column-text">
            На странице представлены текстовые статьи и стаьи с видеоматериалами на различные тематики в сфере рекламы, а также объединенные в подборки
            </p>
            <img src="<?= Url::to(['/img/afo/base-3.png']) ?>" alt="скриншот страницы">
        </div>
    </section>
    <section class="usermanualmain_other-sections">
        <h2 class="usermanualmain_other-sections-title">
            Другие разделы
        </h2>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualprofile']) ?>">
            Профиль
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualmain']) ?>">
            Главная
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualorder']) ?>">
            Мои заказы
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualchoose']) ?>">
            Выбрать исполнителя
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualstart']) ?>">
            Разместить заказ
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualrating']) ?>">
            Рейтинг исполнителей
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualbalance']) ?>">
            Баланс
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualmyrating']) ?>">
            Мой рейтинг
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualmessage']) ?>">
            Мои сообщения
        </a>
    </section>
    <aside class="usermanualmain_chat">
        <div class="usermanualmain_chat-text">
            <h3 class="usermanual_chat_title">
                Не нашли ответ?
            </h3>
            <p class="usermanual_chat_text">
                Задайте свой вопрос в чате тех.поддержки, мы поможем
            </p>
            <a class="usermanual_chat_link link--purple" href="<?= $_SERVER['backing'] ?>">
                Перейти в чат
            </a>
        </div>
        <img style="max-width: 134px;" src="<?= Url::to(['/img/afo/manual-aside.png']) ?>" alt="фоновая картинка">
    </aside>