<?php

use yii\helpers\Url;


$this->title = 'Руководство по бонусам';

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
                    Мои программы
                </span>
            </li>
        </ul>
    </div>
    <h1 class="usermanual_title title-main">Мои программы</h1>
    <section class="usermanualmain_info">
        <div class="usermanualmain_info_row">
            <img src="<?= Url::to(['/img/teacher/program-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                    На странице отображаются все ваши программы обучения.
                </p>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
                Функции
            </h2>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    1. Программы
                </h3>
                <p class="usermanualmain_info_column-text">
                    Во вкладке «Активные программы» отображаются программы, котореы прошли модерацию, опубликованы на сервисе и доступны для студентов. В карточке каждой программы указаны: направление, формат программы (курс, интенсив, вебинар), название, информация о программе, а также появляются уведомления о проверке заданий.<br>
                    Вы можете отфильтровать все активные программы по направлениям и формату.<br>
                    Если вы хотите узнать подробнее, вы можете нажать на Подробнее о курсе или название программы.<br>
                    Также в отдельных вкладках собраны программы, которые сейчас проходят модерацию и завершенные программы
                </p>
                <img src="<?= Url::to(['/img/teacher/program-2.png']) ?>" alt="скриншот страницы">
            </div>
            <h2 class="usermanualmain_info_column-wrapp-title">
                Страница курса
            </h2>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    1. Структура страницы
                </h3>
                <p class="usermanualmain_info_column-text">
                    1. Задания на проверку, при их наличии, вы можете сразу перейти к проверке;<br>
                    2. Информация о курсе;<br>
                    3. Программа курса;<br>
                    4. Ассистенты - проверяющие задания вашей программы, с указанием заданий<br>
                    5. Вы можете редактировать курс
                </p>
                <img src="<?= Url::to(['/img/teacher/program-3.png']) ?>" alt="скриншот страницы">
                <p class="usermanualmain_info_column-text">
                    При нажатии на карточку программы, вы переходите на страницу программы
                </p>
            </div>
            <h2 class="usermanualmain_info_column-wrapp-title">
                Страница вебинара
            </h2>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    1. Структура программы
                </h3>
                <p class="usermanualmain_info_column-text">
                    При нажатии на карточку программы, вы переходите на страницу программы<br>
                    1. Запись вашего вебинара;<br>
                    2. Направление и статус доступа;<br>
                    3. Информация о вебинаре;<br>
                    4. Вы можете редактировать вебинар
                </p>
                <img src="<?= Url::to(['/img/teacher/program-4.png']) ?>" alt="скриншот страницы">
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