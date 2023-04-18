<?php

use yii\helpers\Url;

$this->title = 'Руководство по аукциону';

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
          Аукцион лидов
        </span>
      </li>
    </ul>
  </div>
  <h1 class="usermanual_title title-main">Аукцион лидов</h1>
  <section class="usermanualmain_info">
    <div class="usermanualmain_info_row">
      <img src="<?= Url::to(['/img/femidaclient/usermanualauction-img1.jpg']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
          На аукционе лидов вы можете выбирать и покупать лиды, подходящие вашему запросу.
        </p>
        <p class="usermanualmain_info_row_right-text">
          Для покупки лидов необходимо пополнить <a class="usermanual-link" href="<?= Url::to(['balanc']) ?>">баланс</a>
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
        Все лиды
      </h2>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          Сортировка
        </h3>
        <p class="usermanualmain_info_column-text">
          Вы можете отсортировать все лиды по сфере, региону и стоимости.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualauction-img2.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          Сортировка
        </h3>
        <p class="usermanualmain_info_column-text">
          В данном разделе выбраны фильтры по сфере деятельности, региону и стоимости. Вы можете сбросить фильтры нажав на кнопку сбросить.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualauction-img3.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          Сортировка
        </h3>
        <p class="usermanualmain_info_column-text">
          Нажав кнопку сбросить все фильтры возвращаются в исходное состояние.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualauction-img4.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          Выбрав подходящий лид нажмите кнопку Купить лид
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualauction-img5.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          Если на вашем счете недостаточно средств для покупки лида, вы увидите данное оповещение и сможете перейти к пополнению баланса.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualauction-img6.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          Если покупка прошла успешно, то вы сможете перейти к купленным лидам.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualauction-img7.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          В разделе купленные лиды вы можете осуществить поиск лидов по ключевому слову, а такэже просмотреть лиды за интересующий вас период. При вводе запроса кнопка показать становится активной.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualauction-img8.jpg']) ?>" alt="скриншот страницы">
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