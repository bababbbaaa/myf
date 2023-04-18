<?php

use yii\helpers\Url;

$this->title = 'Руководство по главной странице';

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
                    Главная страница
                </span>
            </li>
        </ul>
    </div>
    <h1 class="usermanual_title title-main">Главная страница</h1>
    <section class="usermanualmain_info">
        <div class="usermanualmain_info_row">
            <img src="<?= Url::to(['/img/teacher/main-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                    После регистрации на сайте вы попадаете на стартовую страницу. Здесь вы можете найти основную информацию о балансе, последних транзакциях.
                </p>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
                Функции
            </h2>

            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    1. Уведомления
                </h3>
                <p class="usermanualmain_info_column-text">
                    Важные сообщения всегда будут в самой верхней части страницы, обычно это уведомления о статусах взятого в работу оффера, новых правилах или системные предупреждения.
                    <br>
                    В верхнем меню есть иконка колокольчика — там будут оповещения от тех.поддержки.
                </p>
                <img src="<?= Url::to(['/img/teacher/main-2.png']) ?>" alt="скриншот страницы">
            </div>

            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    2. Баланс
                </h3>
                <p class="usermanualmain_info_column-text">
                    С главной страницы вы можете сразу перейти к получению средств
                </p>
                <img src="<?= Url::to(['/img/teacher/main-3.png']) ?>" alt="скриншот страницы">
            </div>
        </div>
    </section>
    <section class="usermanualmain_other-sections">
        <h2 class="usermanualmain_other-sections-title">
            Другие разделы
        </h2>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualprofile']) ?>">
            Профиль
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualbalance']) ?>">
            Баланс
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualprogram']) ?>">
            Мои программы
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualtasks']) ?>">
            Мои задания
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualhelp']) ?>">
            Помогаю проверять
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualstat']) ?>">
            Статистика
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
        <img src="<?= Url::to(['/img/skillclient/manual.svg']) ?>" alt="фоновая картинка">
    </aside>