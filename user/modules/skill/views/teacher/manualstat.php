<?php

use yii\helpers\Url;


$this->title = 'Руководство по центру карьеры';

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
                    Статистика
                </span>
            </li>
        </ul>
    </div>
    <h1 class="usermanual_title title-main">Статистика</h1>
    <section class="usermanualmain_info">
        <div class="usermanualmain_info_row">
            <img src="<?= Url::to(['/img/teacher/stat-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                    Здесь отображаются статистика по вашим программам
                </p>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
                Функции
            </h2>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    1. Общая
                </h3>
                <p class="usermanualmain_info_column-text">
                    Здесь представлена общая статистика по всем загруженным вами программам. Вы можете выбарть период, за который хотите ознакомиться
                </p>
                <img src="<?= Url::to(['/img/teacher/stat-2.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    2. По текущим программам
                </h3>
                <p class="usermanualmain_info_column-text">
                    В статистике текщих программа:<br>
                    1. формат и название программы<br>
                    2. вы можете завершить публикацию вашей программы на платформе ил<br>
                    3. дата начала продвижения программы на платформе<br>
                    4. информация о курсе<br>
                    5. статистика курса<br>
                    6. также можно ознакомиться с деталями
                </p>
                <img src="<?= Url::to(['/img/teacher/stat-3.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    При нажатии на Посмотреть детали, открывается блок дополнительной информации
                </p>
                <img src="<?= Url::to(['/img/teacher/stat-4.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    3. По завершенным программам
                </h3>
                <p class="usermanualmain_info_column-text">
                    Если ваша программа завершена по вашей инициаттиве, то вы можете возобновить ее публикацию на сервисе. После выбора Возобновить, программа снова должна пройти этап модерации, а также вы можете ее отредактировать.
                </p>
                <img src="<?= Url::to(['/img/teacher/stat-5.png']) ?>" alt="скриншот страницы">
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