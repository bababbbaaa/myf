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
        Центр карьеры
        </span>
      </li>
    </ul>
  </div>
  <h1 class="usermanual_title title-main">Центр карьеры</h1>
  <section class="usermanualmain_info">
    <div class="usermanualmain_info_row">
      <img src="<?= Url::to(['/img/skillclient/career-1.png']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
        Здесь вы можете составить резюме и откликнуться на вакансии наших партнеров.
        </p>
      </div>
    </div>
    <div class="usermanualmain_info_column-wrapp">
      <h2 class="usermanualmain_info_column-wrapp-title">
      Функции
      </h2>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
        1. Моё резюме
        </h3>
        <p class="usermanualmain_info_column-text">
        Во данной вкладке вы можете составить резюме, заполнив форму. Вы сможете его редактировать и скачать при необходимости.
        </p>
        <img src="<?= Url::to(['/img/skillclient/career-2.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
        2. Вакансии
        </h3>
        <p class="usermanualmain_info_column-text">
        Во вкладке представлены актуальные вакансии наших партнеров:
        <br>
        фильтр;
        <br>
        карточка вакансии, в которой отражены: должность, компания, город, дата публикации вакансии, а также заработная плата;
        <br>
        вы можете сразу откликнуться на вакансию или узнать подробнее.
        <br>
        При нажатии на Узнать подробнее, вы переходите на страницу вакансии
        </p>
        <img src="<?= Url::to(['/img/skillclient/career-3.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
        3. Отклики
        </h3>
        <p class="usermanualmain_info_column-text">
        В вкладке Отклики сохранены вакансии, на которые вы уже откликнулись.
        </p>
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
    <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualbonuses']) ?>">
    Мои бонусы
    </a>
    <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualeducation']) ?>">
    Моё обучение
    </a>
    <a class="usermanualmain_other-sections-link link--purple" href="<?= Url::to(['manualprograms']) ?>">
    Выбрать программы
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