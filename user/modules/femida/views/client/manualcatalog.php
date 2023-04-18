<?php

use yii\helpers\Url;

$this->title = 'Руководство по каталогу франшиз';

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
          Каталог франшиз
        </span>
      </li>
    </ul>
  </div>
  <h1 class="usermanual_title title-main">Каталог франшиз</h1>
  <section class="usermanualmain_info">
    <div class="usermanualmain_info_row">
      <img src="<?= Url::to(['/img/femidaclient/usermanualcatalog-img1.jpg']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
          В каталоге франшиз вы можете подробно ознакомиться со всеми актуальными пакетами франшиз, которые мы предлагаем.
        </p>
        <p class="usermanualmain_info_row_right-text">
          Для покупки пакетов франшиз необходимо пополнить <a class="usermanual-link" href="<?= Url::to(['balanc']) ?>">баланс</a>
        </p>
        <p class="usermanualmain_info_row_right-text">
          Мы подготовили видео-инструкцию, чтобы вам было легче заполнить
        </p>
        <a class="usermanual_info_row_right-link" href="<?= Url::to(['#']) ?>">
          <img src="<?= Url::to(['/img/femidaclient/imgplayvideo.svg']) ?>" alt="иконка">
          <p>Смотреть видео</p>
        </a>
      </div>
    </div>
    <div class="usermanualmain_info_column-wrapp">
      <h2 class="usermanualmain_info_column-wrapp-title">
        Функции
      </h2>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          1. Выбор направления франшизы
        </h3>
        <p class="usermanualmain_info_column-text">
          Вы можете ознакомиться с кратким описанием предоставленных пакетов франшиз, выбрать наиболее подходящую и ознакомиться подробнее со всеми предоставленными тарифами по нажатию на любую карточку.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualcatalog-img2.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          2. Подробнее о франшизе
        </h3>
        <p class="usermanualmain_info_column-text">
          На странице о франшизе вы можете ознакомиться с подробностями о направлении бизнеса, а так же внизу страницы вы можете ознакомиться со всеми предлагаемыми тарифами по данному направлению франшизы.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualcatalog-img3.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          Все предлагаеме тарифы по данному направлению франшизы.<br>
          Если вы хотите получить подробную информацию о пакете, в том числе фин. модель бизнеса, то вы можете нажать на кнопку «Получить фин.модель»
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualcatalog-img4.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          После нажатия будет открыта форма, для заполнения данных, чтобы отправить вам подробную инфлормацию о пакете, включаю фин. модель.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualcatalog-img5.jpg']) ?>" alt="скриншот страницы">
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
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualbalanc']) ?>">
      Баланс
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualpromotion']) ?>">
      Запуск рекламы
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualstatis']) ?>">
      Статистика
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualtechnology']) ?>">
      Технологии
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualauctions']) ?>">
      Аукцион лидов
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualknowlenge']) ?>">
      База знаний
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