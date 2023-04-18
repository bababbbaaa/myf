<?php

use yii\helpers\Url;

$this->title = 'Руководство по технологии';

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
          Технологии
        </span>
      </li>
    </ul>
  </div>
  <h1 class="usermanual_title title-main">Технологии</h1>
  <section class="usermanualmain_info">
    <div class="usermanualmain_info_row">
      <img src="<?= Url::to(['/img/femidaclient/usermanualtechnology-img1.jpg']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
          В разделе технологий вы можете ознакомится с мощными инструментами, собраными нами за годы работы, которые решают проблемы в бизнесе на множественых уровнях.
        </p>
        <p class="usermanualmain_info_row_right-text">
          Для покупки технологий необходимо пополнить <a class="usermanual-link" href="<?= Url::to(['balanc']) ?>">баланс</a>
        </p>
        <p class="usermanualmain_info_row_right-text">
          Мы подготовили видео-инструкцию, чтобы вам было проще разобраться:
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
          1. Вкладки
        </h3>
        <p class="usermanualmain_info_column-text">
          Во вкладке «Все технологии» отображаются все доступные или купленные технологии. Нажав на кнопку «Подробнее» на карточке технологии, вы перейдете на отедльную страницу с подробным описанием самой технологии.
        </p>
        <p class="usermanualmain_info_column-text">
          А так же, купленные технологии будут показаны на карточке и доступны к подробному изучению.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualtechnology-img2.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          2.Вкладка мои технологии
        </h3>
        <p class="usermanualmain_info_column-text">
          Во вкладке «Мои технологии» находятся уже приобритенные технологии, где вы так же можете подробно их изучить. <br>
          1. Вы можете воспользоваться поиском по ключевым словам среди купленных технологий<br>
          2. Подробнее ознакомиться на отдельной странице с самой технологией вы можете после нажатия на кнопку читать или на название самой технологии.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualtechnology-img3.jpg']) ?>" alt="скриншот страницы">
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
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualknowledge']) ?>">
      База знаний
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualauctions']) ?>">
      Аукцион лидов
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