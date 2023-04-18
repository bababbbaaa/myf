<?php

use yii\helpers\Url;

$this->title = 'Руководство по моим заказам';
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
                    Мои заказы
                </span>
            </li>
        </ul>
    </div>
    <h1 class="usermanual_title title-main">Мои заказы</h1>
    <section class="usermanualmain_info">
        <div class="usermanualmain_info_row">
            <img src="<?= Url::to(['/img/afo/order-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                На странице представлена информация по всем вашим заказам
                </p>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
            Заказы
            </h2>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                Сортировка заказов
                </h3>
                <p class="usermanualmain_info_column-text">
                Все проекты разделены на следующие категории:
                <br><br>
                - Поиск исполнителя - все заказы, для которых еще не одобрены исполнители, а также заказы, которые были предложены конкретным исполнителям, но еще не взятые ими в работу
                <br>
                - Активные - заказы в работе, остановленные по инициативе исполнителя или вашей, а также завершенные заказы, которые ожидают подтверждения выполнения
                <br>
                - Архив - выполненные заказы
                <br><br>
                Вы также можете отфильтровать заказы по специализации и площадкам
                </p>
                <img src="<?= Url::to(['/img/afo/order-2.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                2. Карточка заказа
                </h3>
                <p class="usermanualmain_info_column-text">
                В карточке программы указано:
                <br>
                <br>
                1. Статус заказа
                <br>
                2. Название и описание заказа
                <br>
                3. Условия для исполнителя
                <br>
                4. Переход на страницу заказа, на которой можно ознакомиться с откликами исполнителей, а также отредактировать описание
                <br>
                5.Дата публикации в каталоге заказов
                </p>
                <img src="<?= Url::to(['/img/afo/order-3.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                3. Страница заказа
                </h3>
                <p class="usermanualmain_info_column-text">
                При нажатии на карточку проекта, вы переходите на страницу, включающую подробную информацию о выбранном заказе:
                <br><br>
                1. Название заказа
                <br>
                2. Дата публикации заказа
                <br>
                3. Описание заказа и условия для исполнителя 
                <br>
                4. Возможность редактировать описание и условия
                <br>
                5. Отклики исполнителей, при нажатии на имя исполнителя, вы можете ознакомиться с информацией о нем более подробно
                <br>
                6. Вы можете сразу одобрить исполнителя и начать с ним взаимодействовать или отклонить
                <br>
                7. Прогресс заказа
                <br>
                8. Карточка исполнителя, в которой будет информация о выбранном вами специалисте
                <br>
                9. Карточка этапа, в которой вы также можете ознакомиться с заказом более подробно
                </p>
                <img src="<?= Url::to(['/img/afo/order-4.png']) ?>" alt="скриншот страницы">
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