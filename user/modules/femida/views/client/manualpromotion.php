<?php

use yii\helpers\Url;

$this->title = 'Руководство по продвижению';

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
          Продвижение
        </span>
      </li>
    </ul>
  </div>
  <h1 class="usermanual_title title-main">Продвижение</h1>
  <section class="usermanualmain_info">
    <div class="usermanualmain_info_row">
      <img src="<?= Url::to(['/img/femidaclient/usermanualpromotion-img1.jpg']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
          На странице отображаются все ваши текущие заказы.
        </p>
        <p class="usermanualmain_info_row_right-text">
          Для создания заказа необходимо пополнить <a class="usermanual-link" href="<?= Url::to(['balanc']) ?>">баланс</a>
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
          Во вкладке «Мои рекламные компании» отображаются заказы со статусом «Исполняются», «Пауза», «Остановлен», «Модерация». В статус «Модерация» заказ попадпет сразу после создания, и будет там находиться, пока модератор не одобрит его.
        </p>
        <p class="usermanualmain_info_column-text">
          Во вкладке «Архив» находятся завершенные заказы.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualpromotion-img2.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          2. Структура заказа
        </h3>
        <p class="usermanualmain_info_column-text">
          <b>В шапке заказа указаны:</b><br>
          1. название заказа;<br>
          2. статистика — данные по поступлению лидов в графическом виде;<br>
          3. прогресс выполнения заказа (в процентах);<br>
          4. действия, которые вы можете выполнить с заказом (например, поставить на паузу);<br>
          5. статус заказа (модерация — заказ создан, ожидает подтверждения модератора; исполняется — заказ выполняется, вам поступают лиды; остановлен — заказ приостановлен модератором; пауза — заказ присотановлен вами; выполнен — заказ завершен)<br>
          6. дата создания заказа.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualpromotion-img3.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          1. Информация о заказе; <br>
          2. Информация об отгрузке;
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualpromotion-img4.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          1. Более подробная информация о заказе (+таблица с поступившими лидами и отбраковка);<br>
          2. Настройка интеграции;
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualpromotion-img5.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          3. Детали заказа
        </h3>
        <p class="usermanualmain_info_column-text">
          В «Деталях заказ» вы можете посмотреть более подробную информацию, а также изменить время отгрузки и отбраковать или принять новые лиды. <br>
          <b>Первая часть экрана разделена на три карточки:</b><br>
          1. Информация о заказе — все то, что вы заполняли при создании заказа, в этой карточке вы можете поставить заказ на паузу (пункт «Действия») и настроить интеграцию.<br>
          2. Подробности — здесь указано время отгрузки лидов (их можно изменить) и прогресс выполнения заказа.<br>
          3. Информация об отгрузке лидов — вся статистика по заказу.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualpromotion-img6.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          4. Таблица с лидами
        </h3>
        <p class="usermanualmain_info_column-text">
          <b>Вкладки:</b> <br>
          1. Все лиды - все поступившие вам лиды, а также отбракованные;<br>
          2. Новые лиды - лиды, которые поступили, но вы еще не приняли их;<br>
          3. Не подходит по условиям - лиды, которые по какой-то причине не подошли вам. Категория используется только для полных статистичеких данных в разделе Статистика.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualpromotion-img7.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          <b>Строки таблицы:</b> <br>
          У каждого лида есть статус, лиды со статусом «Новый» вы можете принять.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualpromotion-img8.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          По кнопке «Подробнее» вы можете посмотреть всю информацию о лиде.
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualpromotion-img9.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          Процесс пометки лида, как не подходящий по условиям лида
        </h3>
        <p class="usermanualmain_info_column-text">
          Пометить такой лид можно двумя способами. <br>
          <b>Первый способ:</b><br>
          Выбираете новый лид в таблице и нажимаете кнопку «Не подходит по условиям». Затем в всплывающем окне указываете причину и нажимаете кнопку «Продолжить».
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualpromotion-img10.jpg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          <b>Второй способ:</b><br>
          Нажимаете кнопку «Подробнее», вам открывается всплывающее окно с полной информацией о лиде. Внизу окна нажимаете на кнопку «Не подходит по условиям», затем так же отмечате причину и подтверждаете свое решение кнопкой «Продолжить».
        </p>
        <img src="<?= Url::to(['/img/femidaclient/usermanualpromotion-img11.jpg']) ?>" alt="скриншот страницы">
        <img src="<?= Url::to(['/img/femidaclient/usermanualpromotion-img12.jpg']) ?>" alt="скриншот страницы">
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
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['manualtechnology']) ?>">
      Технологии
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