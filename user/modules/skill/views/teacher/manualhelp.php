<?php

use yii\helpers\Url;


$this->title = 'Руководство по программам';

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
                    Помогаю проверять
                </span>
            </li>
        </ul>
    </div>
    <h1 class="usermanual_title title-main">Помогаю проверять</h1>
    <section class="usermanualmain_info">
        <div class="usermanualmain_info_row">
            <img src="<?= Url::to(['/img/teacher/help-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                    Здесь задания других авторов, которые выбрали вас в качестве ассистента для проверки заданий их курсов и интенсивов.
                </p>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
                Задания
            </h2>
            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    На странице отображены задания, которые ожидают проверки. Вы можете ознакомиться со всеми задания, нажам на кнопку Все задания.<br>
                    Также вы можете отфильтровать задания по программам, к которым вас привлекли в статусе ассистента
                </p>
                <img src="<?= Url::to(['/img/teacher/help-2.png']) ?>" alt="скриншот страницы">
            </div>
            <h2 class="usermanualmain_info_column-wrapp-title">
                Страница задания
            </h2>
            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    На странице задания представлено описание задания, фильтр по решениям студентов.<br>
                    Также можно перемещаться по всем заданиям курса или интенсива, которые вам доверили проверять
                </p>
                <img src="<?= Url::to(['/img/teacher/help-3.png']) ?>" alt="скриншот страницы">
            </div>
        </div>
    </section>
    <section class="usermanualmain_other-sections">
        <h2 class="usermanualmain_other-sections-title">
            Другие разделы
        </h2>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualmain']) ?>">
            Главная страница
        </a>
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