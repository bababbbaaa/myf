<?php

use yii\helpers\Url;


$this->title = 'Руководство по бонусам';

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
        Мои бонусы
        </span>
      </li>
    </ul>
  </div>
  <h1 class="usermanual_title title-main">Мои бонусы</h1>
  <section class="usermanualmain_info">
    <div class="usermanualmain_info_row">
      <img src="<?= Url::to(['/img/skillclient/bonuses-1.png']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
        Здесь отображаются ваши бонусы, которые вы можете получить за участие в программе лояльности сервиса
        </p>
      </div>
    </div>
    <div class="usermanualmain_info_column-wrapp">
      <h2 class="usermanualmain_info_column-wrapp-title">
      Функции
      </h2>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
        1. Бонусные материалы
        </h3>
        <p class="usermanualmain_info_column-text">
        Страница содержит вкладки Бонусные материалы и Карта клуба.
        <br>
        Бонусные материалы вы можете получить при участии в различных мероприятия экосистемы MYFORCE
        </p>
        <img src="<?= Url::to(['/img/skillclient/bonuses-2.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
        2. Карта клуба
        </h3>
        <p class="usermanualmain_info_column-text">
        При наличии у вас Карты клуба MYFORCE, в соответствующей вкладке будет отражаться количество бонусных баллов и сервисы, в которых вы можете использовать накопленные баллы
        </p>
        <img src="<?= Url::to(['/img/skillclient/bonuses-3.png']) ?>" alt="скриншот страницы">
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