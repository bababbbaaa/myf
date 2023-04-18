<?php

use yii\helpers\Url;

$this->title = 'Руководство по базе знаний';

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
          База знаний
        </span>
      </li>
    </ul>
  </div>
  <h1 class="usermanual_title title-main">База знаний</h1>
  <section class="usermanualmain_info">
    <div class="usermanualmain_info_row">
      <img src="<?= Url::to(['/img/femidaclient/usermanualknow-img1.jpg']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
          В базе знаний вы можете выбирать и ознакомиться с интересующей вас статьей или документацией.
        </p>
        <p class="usermanualmain_info_row_right-text">
          Для покупки некоторы статей необходимо пополнить <a class="usermanual-link" href="<?= Url::to(['balanc']) ?>">баланс</a>
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
        Каталог
      </h2>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          1. Категории
        </h3>
        <p class="usermanualmain_info_column-text">
          На странице расположены категории с входящими в них разделами статей:<br>
          1. Можно воспользоваться поиском по ключевым словам, который отсортирует все категории по вашему запросу<br>
          2. Вы можете нажать на категорию статей и перейти на страницу подкатегорий выбранной тематики в каталоге<br>
          3. Так же, можно перейти к конкретному разделу по нажатию на название раздела и сразу на название раздела<br>
          4. Сбоку расположены наиболее популярне статьи, вы можете перейти сразу к конкретной статье по нажатию на название статьи
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualknow-img2.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          2. Категория статей
        </h3>
        <p class="usermanualmain_info_column-text">
          На это странице разположены категории статей на выбранную тему из каталога статей. При нажатии на название категории статей, вы попадаете на раздел статей выбранной тематиики.
        </p>
        <p class="usermanualmain_info_column-text">
          Здесь так же вы можете воспользоваться поиском по ключевым словам в разделе базы знаний.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualknow-img3.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          3. Раздел статей
        </h3>
        <p class="usermanualmain_info_column-text">
          На этой странице находятся все статьи по выбранной тематике и категории.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualknow-img4.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          4. Статья
        </h3>
        <p class="usermanualmain_info_column-text">
          На странице статьи вы можете ознакомиться с материалами статьи.
        </p>
        <p class="usermanualmain_info_column-text">
          А так же, вы моежете нажать на предлагаемые ключевые слова и перейти на поисквую страницу с предложенными статьями.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualknow-img5.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          Внизу страницы статьи есть кнопка, которая перенесет вас обратно к категориям статей.
        </p>
        <p class="usermanualmain_info_column-text">
          Так же, внизу расположены подобные или смежные статьи, нажав на название которых, вы перейдете к этим статьям.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualknow-img6.jpg']) ?>" alt="скриншот страницы">
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