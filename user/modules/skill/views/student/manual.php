<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Руководство пользователя';

$js = <<< JS
  $('.manualFilter').on('submit', function (e) {
    $.ajax({
        url: "scripts/",
        method: "POST",
        data: $(this).serialize(),
        beforeSend: function (){
        },
    });
    e.preventDefault();
});
JS;
$this->registerJs($js);
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
      <section class="usermanual_feature-list">
        <h2 class="usermanual_feature-list-title">
          Функционал личного кабинета
        </h2>
        <div class="usermanual_feature-list_cards">
          <div class="usermanual_feature-list_card">
            <img src="<?= Url::to(['/img/femidaclient/usermanual_feature-list_card-1.png']) ?>" alt="скриншот главной страницы">
            <div class="usermanual_feature-list_card_info">
              <h3 class="usermanual_feature-list_card_info-title">
                Главная страница
              </h3>
              <p class="usermanual_feature-list_card_info-text">
              После авторизации на сайте пользователь попадает на стартовую страницу
              </p>
              <a class="link--purple" href="<?= Url::to(['manualmain']) ?>">
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
              <a class="link--purple" href="<?= Url::to(['manualprofile']) ?>">
                Читать
              </a>
            </div>
          </div>

          <div class="usermanual_feature-list_card">
            <img src="<?= Url::to(['/img/femidaclient/usermanual_feature-list_card-3.png']) ?>" alt="скриншот страницы баланса">
            <div class="usermanual_feature-list_card_info">
              <h3 class="usermanual_feature-list_card_info-title">
                Баланс
              </h3>
              <p class="usermanual_feature-list_card_info-text">
              Здесь отображается финансовый баланс пользователя на сайте с возможностью его пополнения и историей изменений
              </p>
              <a class="link--purple" href="<?= Url::to(['manualbalance']) ?>">
                Читать
              </a>
            </div>
          </div>

          <div class="usermanual_feature-list_card">
            <img src="<?= Url::to(['/img/femidaclient/usermanual_feature-list_card-7.png']) ?>" alt="скриншот страницы заказов">
            <div class="usermanual_feature-list_card_info">
              <h3 class="usermanual_feature-list_card_info-title">
              Мои бонусы
              </h3>
              <p class="usermanual_feature-list_card_info-text">
              Здесь отображаются бонусные материалы и статус участника клуба MYFORCE
              </p>
              <a class="link--purple" href="<?= Url::to(['manualbonuses']) ?>">
                Читать
              </a>
            </div>
          </div>

          <div class="usermanual_feature-list_card">
            <img src="<?= Url::to(['/img/femidaclient/usermanual_feature-list_card-4.png']) ?>" alt="скриншот страницы заказов">
            <div class="usermanual_feature-list_card_info">
              <h3 class="usermanual_feature-list_card_info-title">
              Моё обучение
              </h3>
              <p class="usermanual_feature-list_card_info-text">
              Здесь собраны ваши программы обучения: курсы, вебинары и интенсивы
              </p>
              <a class="link--purple" href="<?= Url::to(['manualeducation']) ?>">
                Читать
              </a>
            </div>
          </div>

          <div class="usermanual_feature-list_card">
            <img src="<?= Url::to(['/img/femidaclient/usermanual_feature-list_card-8.png']) ?>" alt="скриншот страницы заказов">
            <div class="usermanual_feature-list_card_info">
              <h3 class="usermanual_feature-list_card_info-title">
              Выбрать программу
              </h3>
              <p class="usermanual_feature-list_card_info-text">
              Здесь вы можете выбрать программу обучения
              </p>
              <a class="link--purple" href="<?= Url::to(['manualprograms']) ?>">
                Читать
              </a>
            </div>
          </div>

          <div class="usermanual_feature-list_card">
            <img src="<?= Url::to(['/img/femidaclient/usermanual_feature-list_card-5.png']) ?>" alt="скриншот страницы создания заказа">
            <div class="usermanual_feature-list_card_info">
              <h3 class="usermanual_feature-list_card_info-title">
              Центр карьеры
              </h3>
              <p class="usermanual_feature-list_card_info-text">
              Вы можете  составить своё резюме, заполнив форму и откликнуться на вакансии партнеров сервиса
              </p>
              <a class="link--purple" href="<?= Url::to(['manualcareer']) ?>">
                Читать
              </a>
            </div>
          </div>
        </div>
      </section>
    </main>
    <aside class="usermanual_chat">
      <img src="<?= Url::to(['/img/femidaclient/Questions-bro.svg']) ?>" alt="фоновое изображение">
      <h3 class="usermanual_chat_title">
        Не нашли ответ?
      </h3>
      <p class="usermanual_chat_text">
        Задайте свой вопрос в чате тех.поддержки, мы поможем
      </p>
      <a class="link--purple" href="#">
        Перейти в чат
      </a>
    </aside>
  </div>
</section>