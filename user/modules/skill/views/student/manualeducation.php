<?php

use yii\helpers\Url;


$this->title = 'Руководство по обучению';

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
            Моё обучение
        </span>
      </li>
    </ul>
  </div>
  <h1 class="usermanual_title title-main">Моё обучение</h1>
  <section class="usermanualmain_info">
    <div class="usermanualmain_info_row">
      <img src="<?= Url::to(['/img/skillclient/education-1.png']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
        На странице отображаются все ваши текущие программы обучение.
        </p>
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
        Во вкладке «Активные» отображаются программы, котореы вы сейчас изучаете. В карточке каждой программы указаны: направление, формат программы (курс, интенсив, вебинар), ваш прогресс изучения, преподаватели.
        <br>
        Вы можете отфильтровать все активные программы по направлениям и формату.
        <br>
        Во вкладке «Архив» находятся уже завершенные вами программы или программы, к которым ограничен доступ       .
        </p>
        <img src="<?= Url::to(['/img/skillclient/education-2.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
        2. Структура программы
        </h3>
        <p class="usermanualmain_info_column-text">
        В шапке заказа указаны:
        <br>
        1. формат программы (курс, вебинар, интенсив);
        <br>
        2. направление;
        <br>
        3. ваш прогресс;
        <br>
        4. преподаватели.
        </p>
        <img src="<?= Url::to(['/img/skillclient/education-3.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
        При нажатии на карточку программы, вы переходите на страницу программы
        </p>
      </div>
      <h2 class="usermanualmain_info_column-wrapp-title">
      Страница программы
      </h2>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
        1. Структура программы
        </h3>
        <p class="usermanualmain_info_column-text">
        При нажатии на карточку программы, вы переходите на страницу программы
        <br>
        1. Период доступа;
        <br>
        2. Ваш прогресс. При наличии сертификата о прохождении, под блоком прогресса появится возможность скачать документ;
        <br>
        3. Открытый модуль;
        <br>
        4. Название блока, индикатор пройденного блока;
        <br>
        5. Название блока, индикатор непройденного блока;
        <br>
        6. Урок, доступ к которому открыт;
        <br>
        7. Урок, доступ к которому закрыт, при наведении появлется информация о том, когда урок будет доступен;
        <br>
        8. Задание, под заданием будет отображаться статус (Крайний срок сдачи, Зачтено или отправлено на доработку);
        <br>
        9. Тест, под которым также будет отображаться статус (пройден или не пройден);
        <br>
        10. Неразвернутые модули
        </p>
        <img src="<?= Url::to(['/img/skillclient/education-4.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
        При нажатии на Урок, Задание или Тест, вы переходите на соответствующие страницы
        </p>
      </div>
      <h2 class="usermanualmain_info_column-wrapp-title">
      Страница Урока
      </h2>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
        1. Структура урока
        </h3>
        <p class="usermanualmain_info_column-text">
        На странице программы:
        <br>
        1. Название урока, описание;
        <br>
        2. Название блока, с названием каждого урока;
        <br>
        3. Видеолекция;
        <br>
        4. Материалы для изучения, котореы можно скачать;
        <br>
        5. дополнительные материалы для изучения, котореы также можно скачать.
        </p>
        <img src="<?= Url::to(['/img/skillclient/education-5.png']) ?>" alt="скриншот страницы">
      </div>
      <h2 class="usermanualmain_info_column-wrapp-title">
      Страница Задания
      </h2>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
        1. Структура задания
        </h3>
        <p class="usermanualmain_info_column-text">
        На странице задания:
        <br>
        1. Название задания, описание;
        <br>
        2. Структура блока, с названием каждого урока;
        <br>
        3. Материалы к заданию, котореы можно скачать и изучить;
        <br>
        4. Форма для загрузки задания: можно прикрепить ссылку на проект и оставить комментарий к решению;
        <br>
        5. Не забудьте нажать Загрузить задание
        </p>
        <img src="<?= Url::to(['/img/skillclient/education-6.png']) ?>" alt="скриншот страницы">
      </div>
      <h2 class="usermanualmain_info_column-wrapp-title">
      Страница Теста
      </h2>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
        При нажатии кнопки Начать, появятся вопросы. После завершения теста и нажатия на кнопку Заавершить тестирование, появится ваш результат
        </p>
        <img src="<?= Url::to(['/img/skillclient/education-7.png']) ?>" alt="скриншот страницы">
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