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
          Добавить оффер
          </span>
      </li>
    </ul>
  </div>
  <h1 class="usermanual_title title-main">Добавить оффер</h1>
  <section class="usermanualmain_info">
    <div class="usermanualmain_info_row">
      <img src="<?= Url::to(['/img/provider/addoffers.png']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
            В вкладке «Добавить оффер» вы можете выбирать и брать в работу офферы, подходящие вашему предложению.
        </p>
      <p class="usermanualmain_info_row_right-text">
          Мы подготовили видео-инструкцию, чтобы вам было проще разобраться:
      </p>
      <a class="usermanual_info_row_right-link" href="#">
          <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M9 18C13.9706 18 18 13.9706 18 9C18 4.02944 13.9706 0 9 0C4.02944 0 0 4.02944 0 9C0 13.9706 4.02944 18 9 18ZM9 16.6154C4.79414 16.6154 1.38462 13.2059 1.38462 9C1.38462 4.79414 4.79414 1.38462 9 1.38462C13.2059 1.38462 16.6154 4.79414 16.6154 9C16.6154 13.2059 13.2059 16.6154 9 16.6154ZM8.16938 6.29409C7.50305 5.9324 6.69231 6.4148 6.69231 7.17296V10.827C6.69231 11.5852 7.50305 12.0676 8.16937 11.7059L11.5352 9.87887C12.2324 9.50039 12.2324 8.49961 11.5352 8.12113L8.16938 6.29409Z" fill="#007FEA"/>
          </svg>

          <p>Смотреть видео</p>
      </a>
      </div>
    </div>
    <div class="usermanualmain_info_column-wrapp">
      <h2 class="usermanualmain_info_column-wrapp-title">
          Доступные предложения
      </h2>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          1. Сортировка
        </h3>
        <p class="usermanualmain_info_column-text">
            Вы можете отсортировать все офферы по сфере, региону и стоимости, а также по проценту принятия лидов
        </p>
        <img src="<?= Url::to(['/img/provider/sort__lead-add.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">2. Структура горячего оффера</h3>
          <p class="usermanualmain_info_column-text">
              <b>В карточке оффера указаны:</b><br>
              1. пометка горячего оффера;<br>
              2. название оффера;<br>
              3. описание нужных лидов;<br>
              4. условия поставки: необходимое количество и установленное вознаграждение за принятый лид<br>
              5. кнопки для принятия в работу и узнать подробности предложения.
          </p>
        <img src="<?= Url::to(['/img/provider/hotoffer__lead-add.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
          <p class="usermanualmain_info_column-text">
              1. Более подробная информация об оффере: процент принятия лидов, регионы, по которым нужны лиды;
          </p>
        <img src="<?= Url::to(['/img/provider/more__lead-add.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
          <p class="usermanualmain_info_column-text">
              После нажатия кнопки Принять оффер в работу, оффер должен пройти модерацию. После модерации оффер перейдет в статус активных и вы сможете начать отгрузку лидов
          </p>
        <img style="max-width: 700px; align-self: center" src="<?= Url::to(['/img/provider/popup__lead-add.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
            3. Структура стандартного оффера
        </h3>
        <p class="usermanualmain_info_column-text">
            <b>В карточке оффера указаны:</b><br>
            1. название оффера;<br>
            2. описание нужных лидов;<br>
            4. условия поставки: необходимое количество и процент принятия лида;<br>
            5. кнопки для принятия в работу и узнать подробности предложения.
        </p>
        <img src="<?= Url::to(['/img/provider/struct__lead-add.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
            1. Более подробная информация об оффере: процент принятия лидов, регионы, по которым нужны лиды;<br>
            Вам необходимо указать количество лидов в день, которое вы можете поставлять. А также регион, в котором возможна поставка
        </p>
        <img src="<?= Url::to(['/img/provider/more-info__lead-add.png']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
            После нажатия кнопки Принять оффер в работу, оффер должен пройти модерацию. После модерации оффер перейдет в статус активных и вы сможете начать отгрузку лидов
        </p>
      </div>
    </div>
  </section>
  <section class="usermanualmain_other-sections">
    <h2 class="usermanualmain_other-sections-title">
      Другие разделы
    </h2>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['usermanualsprofile']) ?>">
        Профиль
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['usermanualmain', '#' => 'balance']) ?>">
        Баланс
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['usermanualmyoffers']) ?>">
        Мои офферы
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
    <img src="<?= Url::to(['/img/Questions-bro.svg']) ?>" alt="фоновая картинка">
  </aside>

</section>