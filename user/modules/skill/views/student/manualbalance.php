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
      <img src="<?= Url::to(['/img/skillclient/balance-1.png']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
        На странице отображается текущий баланс пользователя на сайте с возможностью его пополнения и история изменений баланса.
        </p>
        <p class="usermanualmain_info_row_right-text">
        Для пополнения баланса необходимо заполнить профиль.
        </p>
        <p class="usermanualmain_info_row_right-text">
        Мы подготовили видео-инструкцию, чтобы вам было проще разобраться:
        </p>
        <a class="link-video link--purple" href="#?<?= $_SERVER['#'] ?>">
          <img src="<?= Url::to(['/img/skillclient/playvideo.png']) ?>" alt="иконка">
          <p>Смотреть видео</p>
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
        Вам необходимо выбрать способ пополнения баланса «Банковская карта»
        </p>
        <img src="<?= Url::to(['/img/skillclient/balance-2.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
        После этого откроется окно в котором необходимо указать сумму пополнения и нажать на кнопку «Продолжить»
        </p>
        <img src="<?= Url::to(['/img/skillclient/balance-3.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
        После этого будет осуществлен переход на страницу банковского сервиса по приему платежей онлайн, в данной форме необходимо указать реквизиты банковской карты или адрес электронной почты. После ввода информации необходимо нажать на кнопку «Оплатить». После оплаты денежные средства будут зачислены на баланс личного кабинета, а на указанный адрес электронной почты поступит электронный чек о совершенной операции 
        </p>
        <img src="<?= Url::to(['/img/skillclient/balance-4.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          2. При оплате счета
        </h3>
        <p class="usermanualmain_info_column-text">
        Для пополнения баланса по счету, требуется сформировать счет в личном кабинете клиента, для этого необходимо выбрать способ пополнения баланса «Счет на оплату»
        </p>
        <img src="<?= Url::to(['/img/skillclient/balance-5.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
        После этого откроется окно в котором необходимо указать сумму пополнения и нажать на кнопку «Продолжить»
        </p>
        <img src="<?= Url::to(['/img/skillclient/balance-6.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
        3. История платежей
        </h3>
        <p class="usermanualmain_info_column-text">
        В данной вкладке буду отражены все операции (пополнение баланса, покупка программ), с указанием даты, суммы и информации о программе.
        <br>
        А также вы можете ознакомиться с операциями за выбранный период
        </p>
        <img src="<?= Url::to(['/img/skillclient/balance-7.png']) ?>" alt="скриншот страницы">
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
    <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualbonuses']) ?>">
        Мои бонусы
    </a>
    <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualeducation']) ?>">
    Моё обучение
    </a>
    <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualprograms']) ?>">
    Выбрать программу
    </a>
    <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualcareer']) ?>">
    Центр карьеры
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
      <a class="usermanual_chat_link link--purple" href="<?= Url::to(['support']) ?>">
        Перейти в чат
      </a>
    </div>
    <img src="<?= Url::to(['/img/femidaclient/Questions-bro.svg']) ?>" alt="фоновая картинка">
  </aside>
</section>