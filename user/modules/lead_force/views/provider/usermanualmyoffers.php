<?php

use yii\helpers\Url;

$this->title = "Руководство";
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
        <a href="<?= Url::to(['usermanual']) ?>" class="bcr__link">
          Руководство пользователя
        </a>
      </li>
      <li class="bcr__item">
        <span class="bcr__span">
            Мои офферы
        </span>
      </li>
    </ul>
  </div>
  <h1 class="usermanual_title title-main">Мои офферы</h1>
  <section class="usermanualmain_info">
    <div class="usermanualmain_info_row">
      <img src="<?= Url::to(['/img/provider/offers__image.png']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
            На странице отображаются все ваши текущие офферы.
        </p>
        <p class="usermanualmain_info_row_right-text">
          Для создания заказа необходимо пополнить баланс.
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
        <p class="usermanualmain_info_column-text">Во вкладке «Активные» отображаются заказы со статусом «Исполняются» и «Остановлен».<br>
            Во вкладку «На модерации» попадают офферы сразу после их создания, и будут там находиться, пока модератор не одобрит их.<br>
            Во вкладке «Завершенные» попадают офферы сразу после завершения отгрузки всех лидов.<br>
            Во вкладке «Все» находятся все офферы.</p>
        <img src="<?= Url::to(['/img/provider/offers__head.png']) ?>" alt="скриншот страницы"><br>
        <img src="<?= Url::to(['/img/provider/offers__stop.png']) ?>" alt="скриншот страницы">

      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          2. Структура оффера
        </h3>
        <p class="usermanualmain_info_column-text">
            <b>В шапке заказа указаны:</b><br><br>
            1. название оффера;<br><br>
            2. прогресс выполнения заказа (в процентах);<br><br>
            3. статус заказа (модерация — заказ создан, ожидает подтверждения модератора; исполняется — заказ выполняется, вам поступают лиды; остановлен — заказ приостановлен модератором; выполнен — заказ завершен;)<br><br>
            4. дата создания заказа.
        </p>
        <img src="<?= Url::to(['/img/provider/offers__info.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          1. Информация об оффере;
          <br>
          2. Информация об отгрузке;
        </p>
        <img src="<?= Url::to(['/img/provider/offres__info-stage.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
            1. Более подробная информация о заказе (+таблица с поступившими лидами и отбраковка);
        </p>
        <img src="<?= Url::to(['/img/provider/offers__more.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          3. Детали заказа
        </h3>
        <p class="usermanualmain_info_column-text">
            В «Деталях оффера» вы можете посмотреть более подробную информацию:<br>
            1. Информация об оффере — условия отгрузки.<br>
            2. Подробности — здесь указано текущее состояние отгрузки: требуемый объем лидов, сколько уже поставлено партнерам, сколько непринято лидов, сколько получено средств по текущему офферу.<br>
            3.Статистика оффера — сколько поставлено лидов, сколько отбраковано, сколько принято в работу.
        </p>
        <img src="<?= Url::to(['/img/provider/offers__detail.png']) ?>" alt="скриншот страницы">
      </div>
<!--      <div class="usermanualmain_info_column">-->
<!--        <h3 class="usermanualmain_info_column-title">-->
<!--          4. Таблица с лидами-->
<!--        </h3>-->
<!--        <p class="usermanualmain_info_column-text">-->
<!--          Вкладки:-->
<!--          <br>-->
<!--          Все лиды - все поступившие вам лиды, а также отбракованные;-->
<!--          <br>-->
<!--          Новые лиды - лиды, которые поступили, но вы еще не приняли их или отбраковали;-->
<!--          <br>-->
<!--          Отправлено в брак - лиды, которые вы отметили некачественными, но еще не одобренные модератором;-->
<!--          <br>-->
<!--          Отбракованные лиды, принятые модератором.-->
<!--        </p>-->
<!--        <img src="--><?//= Url::to(['/img//usermanualmeorders-img7.svg']) ?><!--" alt="скриншот страницы">-->
<!--      </div>-->
<!--      <div class="usermanualmain_info_column">-->
<!--        <h3 class="usermanualmain_info_column-title">-->
<!--          Строки таблицы:-->
<!--        </h3>-->
<!--        <p class="usermanualmain_info_column-text">-->
<!--          У каждого лида есть статус, лиды со статусом «Новый» вы можете принять или отбраковать (если он некачественный).-->
<!--        </p>-->
<!--        <img src="--><?//= Url::to(['/img//usermanualmeorders-img8.svg']) ?><!--" alt="скриншот страницы">-->
<!--      </div>-->
<!--      <div class="usermanualmain_info_column">-->
<!--        <p class="usermanualmain_info_column-text">-->
<!--          По кнопке «Подробнее» вы можете посмотреть всю информацию о лиде и отбраковать лид.-->
<!--        </p>-->
<!--        <img src="--><?//= Url::to(['/img//usermanualmeorders-img9.svg']) ?><!--" alt="скриншот страницы">-->
<!--      </div>-->
<!--      <div class="usermanualmain_info_column">-->
<!--        <h3 class="usermanualmain_info_column-title">-->
<!--          Отбраковка лида-->
<!--        </h3>-->
<!--        <p class="usermanualmain_info_column-text">-->
<!--          Отбраковать лид можно двумя способами.-->
<!--          <br>-->
<!--          Первый способ:-->
<!--          <br>-->
<!--          Выбираете новый лид в таблице и нажимаете кнопку «Отправить в брак». Затем в всплывающем окне указываете причину отбраковки и нажимаете кнопку «Продолжить».-->
<!--        </p>-->
<!--        <img src="--><?//= Url::to(['/img//usermanualmeorders-img10.svg']) ?><!--" alt="скриншот страницы">-->
<!--      </div>-->
<!--      <div class="usermanualmain_info_column">-->
<!--        <p class="usermanualmain_info_column-text">-->
<!--          Второй способ:-->
<!--          <br>-->
<!--          Нажимаете кнопку «Подробнее», вам открывается всплывающее окно с полной информацией о лиде. Внизу окна нажимаете на кнопку «Отправить в брак», затем так же отмечате причину брака и подтверждаете свое решение кнопкой «Продолжить».-->
<!--        </p>-->
<!--        <img src="--><?//= Url::to(['/img//usermanualmeorders-img11.svg']) ?><!--" alt="скриншот страницы">-->
<!--      </div>-->
<!--      <div class="usermanualmain_info_column">-->
<!--        <img src="--><?//= Url::to(['/img//usermanualmeorders-img12.svg']) ?><!--" alt="скриншот страницы">-->
<!--      </div>-->
    </div>
  </section>
  <section class="usermanualmain_other-sections">
    <h2 class="usermanualmain_other-sections-title">
      Другие разделы
    </h2>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['usermanualmain']) ?>">
      Главная страница
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['usermanualsprofile']) ?>">
      Профиль
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['usermanualmain', '#' => 'balance']) ?>">
      Баланс
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['usermanualoffersadd']) ?>">
        Добавить оффер
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['usermanualstatistics']) ?>">
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
      <a class="usermanual_chat_link" href="<?= Url::to(['support']) ?>">
        Перейти в чат
      </a>
    </div>
    <img src="<?= Url::to(['/img//Questions-bro.svg']) ?>" alt="фоновая картинка">
  </aside>

</section>