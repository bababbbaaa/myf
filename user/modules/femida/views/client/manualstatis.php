<?php

use yii\helpers\Url;

$this->title = 'Руководство по статистике';

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
      <img src="<?= Url::to(['/img/femidaclient/usermanualstatis-img1.jpg']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
          На странице статистики вы можете отслеживать движение ваших средств и поступивших лидов.
        </p>
        <p class="usermanualmain_info_row_right-text">
          Для отслеживания статистики у вас должна быть запущен как минимум одна рекламная комания.
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
          Если у вас есть запущенная рекламная компания на один или несколько приобретенных пакетов франшиз, то для отображения статистики вам нужно выбрать сферу бизнеса.
        </p>
        <p class="usermanualmain_info_column-text">
          Вам будут доступны только те сферы, на которые у вас есть запущенная реклама.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualstatis-img2.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          2. Отчетный период
        </h3>
        <p class="usermanualmain_info_column-text">
          После выбора сферы бизнеса, вам будет показана вся доступная статистика на данный момент времени.
          У вас есть возможность изменить отчетный период, за который вы хотите просмотреть статистику: <br>
          1. Неделя
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualstatis-img3.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          2. День
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualstatis-img4.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          3. Месяц
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualstatis-img5.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          4. Год
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualstatis-img6.jpg']) ?>" alt="скриншот страницы">
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
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualcatalog']) ?>">
      Каталог франшиз
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