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
      <img src="<?= Url::to(['/img/femidaclient/imgusermanualbalance-img1.jpg']) ?>" alt="скриншот страницы">
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
        <a class="usermanual_info_row_right-link" href="#">
          <img src="<?= Url::to(['/img/femidaclient/imgplayvideo.svg']) ?>" alt="иконка">
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
        <img src="<?= Url::to(['/img/femidaclient/usermanualbalance-img2.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          Вам необходимо выбрать способ пополнения баланса «Банковская карта»
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualbalance-img3.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          После этого будет осуществлен переход на страницу банковского сервиса по приему платежей онлайн, в данной форме необходимо указать реквизиты банковской карты или адрес электронной почты. После ввода информации необходимо нажать на кнопку «Оплатить». После оплаты денежные средства будут зачислены на баланс личного кабинета, а на указанный адрес электронной почты поступит электронный чек о совершенной операции
        </p>
        <img src="<?= Url::to(['/img/usermanualbalance-img4.svg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          2. При оплате счета
        </h3>
        <p class="usermanualmain_info_column-text">
          Для пополнения баланса по счету, требуется сформировать счет в личном кабинете клиента, для этого необходимо выбрать способ пополнения баланса «Счет на оплату»
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualbalance-img5.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          После этого откроется окно в котором необходимо указать сумму пополнения и нажать на кнопку «Продолжить»
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualbalance-img6.jpg']) ?>" alt="скриншот страницы">
        <p class="usermanualmain_info_column-text">
          Сформируется счет на оплату в формате docx и будет отправлен на почту, указанную в профиле. Также, вы можете самостоятельно скачать счет в разделе «Счета». Данный счет необходимо оплатить. В ближайшее время после оплаты счета денежные средства будут отражены на балансе.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualbalance-img7.jpg']) ?>" alt="скриншот страницы">
      </div>
    </div>
  </section>
  <section class="usermanualmain_other-sections">
    <h2 class="usermanualmain_other-sections-title">
      Другие разделы
    </h2>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualmain']) ?>">
      Главная страница
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualprofi']) ?>">
      Профиль
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualpromotion']) ?>">
      Запуск рекламы
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualauctions']) ?>">
      Аукцион лидов
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualcatalog']) ?>">
      Каталог франшиз
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualknowledge']) ?>">
      База знаний
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualtechnology']) ?>">
      Технологии
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualstatis']) ?>">
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
      <a class="usermanual_chat_link" href="<?= $_SERVER['backing'] ?>">
        Перейти в чат
      </a>
    </div>
    <img src="<?= Url::to(['/img/femidaclient/Questions-bro.svg']) ?>" alt="фоновая картинка">
  </aside>
</section>