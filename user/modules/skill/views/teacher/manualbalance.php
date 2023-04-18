<?php

use yii\helpers\Url;


$this->title = 'Руководство по балансу';

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
                    Баланс
                </span>
            </li>
        </ul>
    </div>
    <h1 class="usermanual_title title-main">Баланс</h1>
    <section class="usermanualmain_info">
        <div class="usermanualmain_info_row">
            <img src="<?= Url::to(['/img/teacher/balance-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                    На странице отображается текущий баланс пользователя на сайте с возможностью вывода средств за предоставленные услуги.
                </p>
                <p class="usermanualmain_info_row_right-text">
                    Для поолучения средств необходимо заполнить профиль.
                </p>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
                Получение средств
            </h2>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    1. На банковскую карту
                </h3>
                <p class="usermanualmain_info_column-text">
                    Вам необходимо выбрать способ получения средств с баланса «Банковская карта».
                    Важно! Вывод средств доступен не более 2 раз в месяц и не менее 10 000 рублей единоразово
                </p>
                <img src="<?= Url::to(['/img/teacher/balance-2.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    После этого откроется окно в котором необходимо указать сумму пополнения и нажать на кнопку «Продолжить»
                </p>
                <img src="<?= Url::to(['/img/teacher/balance-3.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    2. На счет
                </h3>
                <p class="usermanualmain_info_column-text">
                    Для получения средств на счет, необходимо выбрать «Счет на оплату»
                </p>
                <img src="<?= Url::to(['/img/teacher/balance-4.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <p class="usermanualmain_info_column-text">
                    После этого откроется окно в котором необходимо указать сумму пополнения и нажать на кнопку «Продолжить»
                </p>
                <img src="<?= Url::to(['/img/teacher/balance-5.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    3. История платежей
                </h3>
                <p class="usermanualmain_info_column-text">
                    В данной вкладке буду отражены все операции (пополнение баланса, вывод средств), с указанием даты, суммы и информации о программе<br>
                    А также вы можете ознакомиться с операциями за выбранный период
                </p>
                <img src="<?= Url::to(['/img/teacher/balance-6.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                    4. Аналитика
                </h3>
                <p class="usermanualmain_info_column-text">
                    В данной вкладке отражены движения полученных средств.
                    <br>
                    Вы можете ознакомиться со статистикой за последние неделю, месяц и год
                </p>
                <img src="<?= Url::to(['/img/teacher/balance-7.png']) ?>" alt="скриншот страницы">
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