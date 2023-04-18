<?php

use yii\helpers\Url;


$this->title = 'Руководство по программам';

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
        Выбрать программу
        </span>
      </li>
    </ul>
  </div>
  <h1 class="usermanual_title title-main">Выбрать программу</h1>
  <section class="usermanualmain_info">
    <div class="usermanualmain_info_row">
      <img src="<?= Url::to(['/img/skillclient/programs-1.png']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
        На странице отображаются все программы обучения.
        </p>
      </div>
    </div>
    <div class="usermanualmain_info_column-wrapp">
      <h2 class="usermanualmain_info_column-wrapp-title">
      Функции
      </h2>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
        1. Фильтр
        </h3>
        <p class="usermanualmain_info_column-text">
        В боковом меню представлены популярные направления обучения, вы можете отфильтровать все программы, выбрав интересующее.
        <br>
        А также вы можете отфильтровать программы по формату и выбрать для отображения только бесплатные программы.
        </p>
        <img src="<?= Url::to(['/img/skillclient/programs-2.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
        2. Карточка вебинара
        </h3>
        <p class="usermanualmain_info_column-text">
        В карточке вебинара:
        <br>
        формат и название программы;
        <br>
        направление;
        <br>
        дата трансляции;
        <br>
        спикеры;
        <br>
        Не забудьте записаться на вебинар!
        <br>
        При нажатии на карточку вебинара, вы переходите на страницу вебинара
        </p>
        <img src="<?= Url::to(['/img/skillclient/programs-3.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
        При нажатии на карточку программы, вы переходите на страницу программы
        </p>
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
        3. Карточки курсов и интенсивов
        </h3>
        <p class="usermanualmain_info_column-text">
        В карточках курсов и интенсивов:
        <br>
        формат и название программы;
        <br>
        направление и оповещение о скидках, при наличии;
        <br>
        дата старта курса и длительность;
        <br>
        спикеры;
        <br>
        Вы можете присоединиться к курсу или узнать о программе подробнее
        <br>
        При нажатии на карточку курса или кнопки Подробнее о курсе, вы переходите на страницу курса
        </p>
        <img src="<?= Url::to(['/img/skillclient/programs-4.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
        При нажатии на Урок, Задание или Тест, вы переходите на соответствующие страницы
        </p>
      </div>
      <h2 class="usermanualmain_info_column-wrapp-title">
      Страница вебинара
      </h2>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
        В странице вебинара:
        <br>
        формат и название;
        <br>
        направление;
        <br>
        стоимость;
        <br>
        видео и материалы для изучения, если вебинар предстоит и записи еще нет, вы также можете приобрести его и создать напоминание о мероприятии;
        <br>
        спикеры вебинара
        <br>
        При нажатии на карточку вебинара, вы переходите на страницу вебинара
        </p>
        <img src="<?= Url::to(['/img/skillclient/programs-5.png']) ?>" alt="скриншот страницы">
      </div>
      <h2 class="usermanualmain_info_column-wrapp-title">
      Страницы курса и интенсива
      </h2>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
        В страницах курсов и интенсивов также представлена информация о курсе: название, описание, направление, стоимость, длительность и дата старта, преподаватели и программа курса.
        <br>
        При наличии бесплатного урока, вы можете с ним ознакомиться на странице курса и продолжить обучение после просмотра.
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