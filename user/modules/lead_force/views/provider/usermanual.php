<?php

use yii\helpers\Html;
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
        <span class="bcr__span">
          Руководство пользователя
        </span>
      </li>
    </ul>
  </div>
  <h1 class="usermanual_title title-main">Руководство пользователя</h1>
  <div class="usermanual_info_wrapp">
    <main class="usermanual_info">
      <section class="usermanual_info_questions">
        <h2 class="usermanual_info_questions-title">
          Популярные вопросы
        </h2>
        <nav class="usermanual_info_questions_links">
          <a class="usermanual_info_questions_link" href="<?= Url::to(['usermanualmain']) ?>">
              С чего начать?
          </a>
          <a class="usermanual_info_questions_link" href="<?= Url::to(['usermanualmain', '#' => 'balance']) ?>">
              Как получать средства?
          </a>
          <a class="usermanual_info_questions_link" href="<?= Url::to(['usermanualoffersadd']) ?>">
              Как добавлять офферы в работу?
          </a>
          <a class="usermanual_info_questions_link" href="<?= Url::to(['usermanualsprofile']) ?>">
              Что заполнять в профиле?
          </a>
        </nav>
      </section>
      <section class="usermanual_feature-list">
        <h2 class="usermanual_feature-list-title">
          Функционал личного кабинета
        </h2>
        <div class="usermanual_feature-list_cards">
          <div class="usermanual_feature-list_card">
            <img src="<?= Url::to(['/img/usermanual_feature-list_card-1.png']) ?>" alt="скриншот главной страницы">
            <div class="usermanual_feature-list_card_info">
              <h3 class="usermanual_feature-list_card_info-title">
                Главная страница
              </h3>
              <p class="usermanual_feature-list_card_info-text">
                После авторизации на сайте пользователь попадает на стартовую страницу
              </p>
              <a class="usermanual_feature-list_card_info-link" href="<?= Url::to(['usermanualmain']) ?>">
                Читать
              </a>
            </div>
          </div>
          <div class="usermanual_feature-list_card">
            <img src="<?= Url::to(['/img/usermanual_feature-list_card-2.png']) ?>" alt="скриншот страницы профиля">
            <div class="usermanual_feature-list_card_info">
              <h3 class="usermanual_feature-list_card_info-title">
                Профиль
              </h3>
              <p class="usermanual_feature-list_card_info-text">
                Здесь можно изменять основную информацию о своем аккаунте
              </p>
              <a class="usermanual_feature-list_card_info-link" href="<?= Url::to(['usermanualsprofile']) ?>">
                Читать
              </a>
            </div>
          </div>
          <div class="usermanual_feature-list_card">
            <img src="<?= Url::to(['/img/usermanual_feature-list_card-3.png']) ?>" alt="скриншот страницы баланса">
            <div class="usermanual_feature-list_card_info">
              <h3 class="usermanual_feature-list_card_info-title">
                Баланс
              </h3>
              <p class="usermanual_feature-list_card_info-text">
                Здесь отображается финансовый баланс пользователя на сайте с возможностью его пополнения и историей изменений
              </p>
              <a class="usermanual_feature-list_card_info-link" href="<?= Url::to(['usermanualmain', '#' => 'balance']) ?>">
                Читать
              </a>
            </div>
          </div>
          <div class="usermanual_feature-list_card">
            <img src="<?= Url::to(['/img/usermanual_feature-list_card-4.png']) ?>" alt="скриншот страницы заказов">
            <div class="usermanual_feature-list_card_info">
              <h3 class="usermanual_feature-list_card_info-title">
                  Мои офферы
              </h3>
              <p class="usermanual_feature-list_card_info-text">
                  Здесь вы можете отследить статус своих заказов и узнать подробную информацию о поступивших лидах
              </p>
              <a class="usermanual_feature-list_card_info-link" href="<?= Url::to(['usermanualmyoffers']) ?>">
                Читать
              </a>
            </div>
          </div>
          <div class="usermanual_feature-list_card">
            <img src="<?= Url::to(['/img/usermanual_feature-list_card-5.png']) ?>" alt="скриншот страницы создания заказа">
            <div class="usermanual_feature-list_card_info">
              <h3 class="usermanual_feature-list_card_info-title">
                  Добавить оффер
              </h3>
              <p class="usermanual_feature-list_card_info-text">
                  Тут вы можете выбрать готовый пакет лидов или заказать индивидуальный
              </p>
              <a class="usermanual_feature-list_card_info-link" href="<?= Url::to(['usermanualoffersadd']) ?>">
                Читать
              </a>
            </div>
          </div>
          <div class="usermanual_feature-list_card">
            <img src="<?= Url::to(['/img/usermanual_feature-list_card-6.png']) ?>" alt="скриншот страницы аукцион лидов">
            <div class="usermanual_feature-list_card_info">
              <h3 class="usermanual_feature-list_card_info-title">
                  Статистика
              </h3>
              <p class="usermanual_feature-list_card_info-text">
                  Вы можете приобрести свежие горячие лиды, на которые в данный момент у нас нет покупателей или наши действующие клиенты по какой-то причине не могут их выкупить.
              </p>
              <a class="usermanual_feature-list_card_info-link" href="<?= Url::to(['usermanualstatistics']) ?>">
                Читать
              </a>
            </div>
          </div>
        </div>
      </section>
    </main>
    <aside class="usermanual_chat">
      <img src="<?= Url::to(['/img/Questions-bro.svg']) ?>" alt="фоновое изображение">
      <h3 class="usermanual_chat_title">
        Не нашли ответ?
      </h3>
      <p class="usermanual_chat_text">
        Задайте свой вопрос в чате тех.поддержки, мы поможем
      </p>
      <a class="usermanual_chat_link" href="#">
        Перейти в чат
      </a>
    </aside>
  </div>
</section>
