<?php

use yii\helpers\Url;

$this->title = 'Руководство по сообщениям';
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
                Мои сообщения
                </span>
            </li>
        </ul>
    </div>
    <h1 class="usermanual_title title-main">Мои сообщения</h1>
    <section class="usermanualmain_info">
        <div class="usermanualmain_info_row">
            <img src="<?= Url::to(['/img/afo/message-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                Вы можете написать сообщение любому исполнителю
                </p>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
            Функции
            </h2>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                1. Отправка сообщений
                </h3>
                <p class="usermanualmain_info_column-text">
                Вы можете отправить сообщение собеседнику из списка или перейти на страницу с карточки исполнителя. Также доступен поиск по собеседникам
                </p>
                <img src="<?= Url::to(['/img/afo/message-2.png']) ?>" alt="скриншот страницы">
            </div>
        </div>
    </section>
    <section class="usermanualmain_other-sections">
        <h2 class="usermanualmain_other-sections-title">
            Другие разделы
        </h2>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualbalance']) ?>">
            Баланс
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualmain']) ?>">
            Главная
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualprofile']) ?>">
            Профиль
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualchoose']) ?>">
            Выбрать исполнителя
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualorder']) ?>">
            Мои заказы
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualstart']) ?>">
            Разместить заказ
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualbase']) ?>">
            База знаний
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualmyrating']) ?>">
            Мой рейтинг
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualrating']) ?>">
            Рейтинг исполнителей
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