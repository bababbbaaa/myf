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
                    Добавить программу
                </span>
            </li>
        </ul>
    </div>
    <h1 class="usermanual_title title-main">Добавить программу</h1>
    <section class="usermanualmain_info">
        <div class="usermanualmain_info_row">
            <img src="<?= Url::to(['/img/teacher/addprogram-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                    Здесь вы можете добавить свою программу на платформу.
                </p>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
                Задания
            </h2>

            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    Вы можете выбрать формат вашей программы.
                </p>
                <img src="<?= Url::to(['/img/teacher/addprogram-2.png']) ?>" alt="скриншот страницы">
            </div>

            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    При выборе форматов курс или интенсив появится форма для загрузки, которая состоит из 4 шагов для последовательного заполнения.<br>
                    После заполнения шага 1 вы сможете сохранить проект и загружать информацию в удобное вам время<br>
                    Заполнив все шаги, кнопка Загрузить курс станет активной и после ее нажатия, курс будет отправлен на модерацию.
                </p>
                <img src="<?= Url::to(['/img/teacher/addprogram-3.png']) ?>" alt="скриншот страницы">
            </div>

            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    При загрузке вебинара и автовебинара аналогично после заполнения шага 1 кнопка Сохранить проект станет активной и вы сможете продолжить загрузку вебинара в удобное время
                </p>
                <img src="<?= Url::to(['/img/teacher/addprogram-4.png']) ?>" alt="скриншот страницы">
                <p class="usermanualmain_info_column-text">
                    После того, как заполните все шаги не забудьте нажать Загрузить курс!
                </p>
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