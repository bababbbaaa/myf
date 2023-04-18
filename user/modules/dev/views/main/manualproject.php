<?php

use yii\helpers\Url;

$this->title = 'Руководство по моим проектам';

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
                    Мои проекты
                </span>
            </li>
        </ul>
    </div>
    <h1 class="usermanual_title title-main">Мои проекты</h1>
    <section class="usermanualmain_info">
        <div class="usermanualmain_info_row">
            <img src="<?= Url::to(['/img/dev/project-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                    На странице представлена информация по всем вашим проектам
                </p>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
                Проекты
            </h2>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                Фильтр проектов
                </h3>
                <p class="usermanualmain_info_column-text">
                    Все проекты разделены на активные, которые сейчас находятся в работе, и архивные, завершенные или приостановленные по вашей инициативе
                </p>
                <img src="<?= Url::to(['/img/dev/project-2.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                2. Карточка проекты
                </h3>
                <p class="usermanualmain_info_column-text">
                    В карточке программы указано:
                    <br>
                    1. Тип и название проекта
                    <br>
                    2. Прогресс
                    <br>
                    3. Предварительная дата завершения
                </p>
                <img src="<?= Url::to(['/img/dev/project-3.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                3 Страница проекта
                </h3>
                <p class="usermanualmain_info_column-text">
                    При нажатии на карточку проекта, вы переходите на страницу, включающую подробную информацию о выбранном проекте:
                    <br>
                    1. Тип и название проекта
                    <br>
                    2. Статус 
                    <br>
                    3. Информация о целях и задачах проектах. Также вы можете 
                    посмотреть сосованное ТЗ
                    <br>
                    4. Предварительная дата завершения проекта
                    <br>
                    5. Информация о текущем этапе
                    <br>
                    6. Инфомрация об оплате проекта
                    <br>
                    7. Информация о всех этапах проекта
                    <br>
                    8. График платежей
                </p>
                <img src="<?= Url::to(['/img/dev/project-4.png']) ?>" alt="скриншот страницы">
            </div>
        </div>
    </section>
    <section class="usermanualmain_other-sections">
        <h2 class="usermanualmain_other-sections-title">
            Другие разделы
        </h2>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualmain']) ?>">
            Главная
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualprofile']) ?>">
            Профиль
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualbalance']) ?>">
            Баланс
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualstart']) ?>">
            Начать проект
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
        <img style="max-width: 134px;" src="<?= Url::to(['/img/dev/manual-aside.png']) ?>" alt="фоновая картинка">
    </aside>
</section>