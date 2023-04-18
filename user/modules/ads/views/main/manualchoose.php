<?php

use yii\helpers\Url;


$this->title = 'Руководство по выбору исполнителя';

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
                Выбрать исполнителя
                </span>
            </li>
        </ul>
    </div>
    <h1 class="usermanual_title title-main">Выбрать исполнителя</h1>
    <section class="usermanualmain_info">
        <div class="usermanualmain_info_row">
            <img src="<?= Url::to(['/img/afo/choose-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                На данной странице вы можете выбрать исполнителя для своего проекта
                </p>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
            Функции
            </h2>
            <div class="usermanualmain_info_row">
                <div style="  margin-left: 0px;" class="usermanualmain_info_row_right">
                    <h3 class="usermanualmain_info_column-title">
                        1. Фильтр исполнителей
                    </h3>
                    <p class="usermanualmain_info_row_right-text">
                    Вы можете отфильтровать всех исполнителей по 
                    <br><br>
                    - специализации
                    <br>
                    - по наличию отзывов на исполнителя других заказчиков
                    <br>
                    - по площадке, на которых работают исполнители
                    <br><br>
                    Также вы можете найти исполнителя, используя поисковую строку
                    </p>
                </div>
                <img src="<?= Url::to(['/img/afo/choose-2.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_row">
                <div style="  margin-left: 0px;" class="usermanualmain_info_row_right">
                    <h3 class="usermanualmain_info_column-title">
                        2. Карточка исполнителя
                    </h3>
                    <p class="usermanualmain_info_row_right-text">
                    В карточке программы указано:
                    <br><br>
                    1. Имя и аватар исполнителя
                    <br>
                    2. Число выполненных заказов
                    <br>
                    3. Специализации исполнителя
                    <br>
                    4. Вы можете сразу предложить заказ исполнителю или оставить отзыв, если уже с ним взаимодействовали
                    <br>
                    5. Число отзывов
                    <br>
                    6. Средняя оценка за выполненные заказы
                    <br>
                    7.Статус лидера рейтинга
                    </p>
                </div>
                <img src="<?= Url::to(['/img/afo/choose-3.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                3. Страница исполнителя
                </h3>
                <p class="usermanualmain_info_column-text">
                При нажатии на карточку проекта, вы переходите на страницу, включающую подробную информацию о выбранном заказе:
                <br><br>
                1. Имя 
                <br>
                2. Информация об исполнителе
                <br>
                3. Портфолио исполнителя, при нажатии на название проекта, вы можете кзнать о нем больше
                <br>
                4. Выполненные заказы и отзывы заказчиков
                <br>
                5. Средняя оценка исполнителя и статус (актуально для лидеров рейтинга)
                <br>
                6. Специализации исполнителя
                <br>
                7. Статистика заказов
                <br>
                8. Вы можете предложить исполнителю заказ и сформировать индивидуальное предложение или написать сообщения
                </p>
                <img src="<?= Url::to(['/img/afo/choose-4.png']) ?>" alt="скриншот страницы">
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
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualmain']) ?>">
            Главная
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualorder']) ?>">
            Мои заказы
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualbalance']) ?>">
            Баланс
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualstart']) ?>">
            Разместить заказ
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualrating']) ?>">
            Рейтинг исполнителей
        </a>
        <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualbase']) ?>">
            База знаний
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