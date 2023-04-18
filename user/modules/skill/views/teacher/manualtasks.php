<?php

use yii\helpers\Url;


$this->title = 'Руководство по обучению';

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
                    Мои задания
                </span>
            </li>
        </ul>
    </div>
    <h1 class="usermanual_title title-main">Мои задания</h1>
    <section class="usermanualmain_info">
        <div class="usermanualmain_info_row">
            <img src="<?= Url::to(['/img/teacher/tasks-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                    На странице отображаются задания ваших программ.
                </p>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
                Проверяю я
            </h2>
            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    Во данной вкладке представлены задания ваших программ, которые должны проверить вы.<br>
                    1. фильтр по заданиям;<br>
                    2. карточка программы;<br>
                    3. в боковом меню можно отфильтровать все задания по активным программам
                </p>
                <img src="<?= Url::to(['/img/teacher/tasks-2.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    1. Карточка программы
                </h3>
                <p class="usermanualmain_info_column-text">
                    В карточке программы:<br>
                    1. формат и название программы;<br>
                    2. крайний срок проверки;<br>
                    3. сколько заданий ожидают проверки;<br>
                    4. вы можете сразу перейти на страницу задания для проверки.<br>
                </p>
                <img src="<?= Url::to(['/img/teacher/tasks-3.png']) ?>" alt="скриншот страницы">
            </div>
            <h2 class="usermanualmain_info_column-wrapp-title">
                Страница задания
            </h2>
            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    Вкладка Ассистенты аналогична по структуре вкладке Проверяю я
                </p>
                <img src="<?= Url::to(['/img/teacher/tasks-4.png']) ?>" alt="скриншот страницы">
            </div>
            <h2 class="usermanualmain_info_column-wrapp-title">
                Ассистенты
            </h2>
            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    На странице задания вы можете ознакомиться с решениями студентов программы, которые можно отфильтровать по статусу проверки.<br>
                    В боковом меню представлены все задания программы, а также фильтр по ассистентам
                </p>
                <img src="<?= Url::to(['/img/teacher/tasks-5.png']) ?>" alt="скриншот страницы">
            </div>
            <h2 class="usermanualmain_info_column-wrapp-title">
                Страница задания ассистента
            </h2>
            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    Аналогично на странице задания есть описание самого задания, фильтр по решениям студентов, а также по всем заданиям программы, которые проверяет выбранный ассистент.<br>
                    В правом углу указано имя ассистента.<br>
                    В меню Действия вы можете заменить ассистента. При этом вам будет необходимо указать данные другого ассистента или выбрать себя в качестве проверяющего.
                </p>
                <img src="<?= Url::to(['/img/teacher/tasks-6.png']) ?>" alt="скриншот страницы">
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