<?php

/* @var $this yii\web\View */

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
          Профиль
        </span>
      </li>
    </ul>
  </div>
  <h1 class="usermanual_title title-main">Профиль</h1>
  <section class="usermanualmain_info">
    <div class="usermanualmain_info_row">
      <img src="<?= Url::to(['/img/provider/profile__image.png']) ?>" alt="скриншот страницы">
      <div class="usermanualmain_info_row_right">
        <h2 class="usermanualmain_info_row_right-title">
          Общий вид
        </h2>
        <p class="usermanualmain_info_row_right-text">
          Перед тем, как пополнять баланс личного кабинета, необходимо заполнить свой профиль.
        </p>
        <p class="usermanualmain_info_row_right-text">
          В профиле вы можете заполнить личные данные, информацию об оплате услуг кабинета, сменить пароль и настроить уведомления, которые мы вам присылаем.
        </p>
        <p class="usermanualmain_info_row_right-text">
          Мы подготовили видео-инструкцию, чтобы вам было легче заполнить
        </p>
        <a class="usermanual_info_row_right-link" href="#?<?= $_SERVER['#'] ?>">
          <img src="<?= Url::to(['/img/playvideo.svg']) ?>" alt="иконка">
          <p>Смотреть видео</p>
        </a>
      </div>
    </div>
    <div class="usermanualmain_info_column-wrapp">
      <h2 class="usermanualmain_info_column-wrapp-title">
        Заполнение профиля
      </h2>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          1. Ваши данные
        </h3>
        <p class="usermanualmain_info_column-text">
          В пункте «Контактные данные» показаны ваши контакты с регистрации, если они поменялись — можете их сменить. Не забудьте добавить почту, на нее будут присылаться акты выполненных работ и оповещения о начале и окончании отгрузки лидов.
        </p>
        <img src="<?= Url::to(['/img/usermanualprofile-img7.svg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
            Далее вам нужно выбрать в качестве какого лица вы регистрируетесь в личном кабинете — физического или юридического, и заполнить все поля. Данный выбор влияет на способ получения оплаты за ваши услуги.
        </p>
        <img src="<?= Url::to(['/img/usermanualprofile-img6.svg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          Не забудьте сохранить изменения!
        </p>
        <img src="<?= Url::to(['/img/usermanualprofile-img5.svg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          2. Информация для оплаты
        </h3>
        <p class="usermanualmain_info_column-text">
          В этом пункте вы можете выбрать, как хотите оплачивать услуги — как юридическое лицо или как физическое, либо обоими способами сразу.
          <br>
          Выберите вид плательщика, заполните поля и сохраните данные.
        </p>
        <img src="<?= Url::to(['/img/usermanualprofile-img4.svg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <p class="usermanualmain_info_column-text">
          Когда вы создадите первого плательщика (например, как на фото ниже — физическое лицо), у вас есть возможность создать второго плательщика — юридическое лицо. При оплате услуг у вас будет выбор, каким способом оплачивать.
        </p>
        <img src="<?= Url::to(['/img/usermanualprofile-img3.svg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          3. Сменить пароль
        </h3>
        <p class="usermanualmain_info_column-text">
          Вы можете изменить пароль личного кабинета. Не забудьте сохранить данные!
        </p>
        <img src="<?= Url::to(['/img/usermanualprofile-img2.svg']) ?>" alt="скриншот страницы">
      </div>
      <div class="usermanualmain_info_column">
        <h3 class="usermanualmain_info_column-title">
          4. Уведомления
        </h3>
        <p class="usermanualmain_info_column-text">
          Вы можете поменять настройки уведомлений, которые приходят на почту и в личном кабинете
        </p>
        <img src="<?= Url::to(['/img/usermanualprofile-img8.svg']) ?>" alt="скриншот страницы">
      </div>
    </div>
  </section>
  <section class="usermanualmain_other-sections">
    <h2 class="usermanualmain_other-sections-title">
      Другие разделы
    </h2>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['usermanualmain', '#' => 'balance']) ?>">
        Баланс
    </a>
    <a class="usermanualmain_other-sections-link" href="<?= Url::to(['usermanualmyoffers']) ?>">
        Мои офферы
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
    <img src="<?= Url::to(['/img/Questions-bro.svg']) ?>" alt="фоновая картинка">
  </aside>

</section>