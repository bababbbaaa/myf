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
            <img src="<?= Url::to(['/img/afo/balance-1.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_row_right">
                <h2 class="usermanualmain_info_row_right-title">
                    Общий вид
                </h2>
                <p class="usermanualmain_info_row_right-text">
                    На странице отображается текущий баланс пользователя на сайте с возможностью его пополнения и история изменений баланса.
                </p>
                <p class="usermanualmain_info_row_right-text">
                    Для пополнения баланса необходимо заполнить <a class="link--blue" href="<?= Url::to(['manualprofile']) ?>">профиль</a>.
                </p>
                <p class="usermanualmain_info_row_right-text">
                    Мы подготовили видео-инструкцию, чтобы вам было проще разобраться:
                </p>
                <a class="link-video link--purple" href="#?<?= $_SERVER['#'] ?>">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM12 19.6154C7.79414 19.6154 4.38462 16.2059 4.38462 12C4.38462 7.79414 7.79414 4.38462 12 4.38462C16.2059 4.38462 19.6154 7.79414 19.6154 12C19.6154 16.2059 16.2059 19.6154 12 19.6154ZM11.1694 9.29409C10.5031 8.9324 9.69231 9.4148 9.69231 10.173V13.827C9.69231 14.5852 10.503 15.0676 11.1694 14.7059L14.5352 12.8789C15.2324 12.5004 15.2324 11.4996 14.5352 11.1211L11.1694 9.29409Z" fill="#EB38D2"/></svg>
                    <p style="margin-left: 4px;">Смотреть видео</p>
                </a>
            </div>
        </div>
        <div class="usermanualmain_info_column-wrapp">
            <h2 class="usermanualmain_info_column-wrapp-title">
            Пополнение баланса
            </h2>
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                1. По банковской карте
                </h3>
                <p class="usermanualmain_info_column-text">
                Пополнение баланса
                </p>
                <img src="<?= Url::to(['/img/afo/balance-2.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_row">
                <div class="usermanualmain_info_row_right">
                    <p class="usermanualmain_info_row_right-text">
                    После этого откроется окно в котором необходимо указать сумму пополнения и нажать на кнопку «Продолжить»
                    </p>
                </div>
                <img src="<?= Url::to(['/img/afo/balance-3.png']) ?>" alt="скриншот страницы">
            </div>
            <p class="usermanualmain_info_column-text">
            После этого будет осуществлен переход на страницу банковского сервиса по приему платежей онлайн, в данной форме необходимо указать реквизиты банковской карты или адрес электронной почты. После ввода информации необходимо нажать на кнопку «Оплатить». После оплаты денежные средства будут зачислены на баланс личного кабинета, а на указанный адрес электронной почты поступит электронный чек о совершенной операции 
            </p>
            <img src="<?= Url::to(['/img/afo/balance-4.png']) ?>" alt="скриншот страницы">
            <div class="usermanualmain_info_column">
                <h3 class="usermanualmain_info_column-title">
                2. При оплате счета
                </h3>
                <p class="usermanualmain_info_column-text">
                Для пополнения баланса по счету, требуется сформировать счет в личном кабинете клиента, для этого необходимо выбрать способ пополнения баланса «Счет на оплату»
                </p>
                <img src="<?= Url::to(['/img/afo/balance-5.png']) ?>" alt="скриншот страницы">
            </div>
            <div class="usermanualmain_info_row">
                <div class="usermanualmain_info_row_right">
                    <p class="usermanualmain_info_row_right-text">
                    После этого откроется окно в котором необходимо указать сумму пополнения и нажать на кнопку «Продолжить»
                    </p>
                </div>
                <img src="<?= Url::to(['/img/afo/balance-6.png']) ?>" alt="скриншот страницы">
            </div>
            <p class="usermanualmain_info_column-text">
            Сформируется счет на оплату в формате docx и будет отправлен на почту, указанную в профиле. Также, вы можете самостоятельно скачать счет в разделе «Счета». Данный счет необходимо оплатить. В ближайшее время после оплаты счета денежные средства будут отражены на балансе.
            <br>
            Также вы можете ознакомиться с информацией о предыдущих платежах, а также скачать Акты выполненных работ после выполнения заказов
            </p>
            <img src="<?= Url::to(['/img/afo/balance-7.png']) ?>" alt="скриншот страницы">
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