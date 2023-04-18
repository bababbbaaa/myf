<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Руководство пользователя';

$js = <<< JS

$('.manualFilter').on('submit', function (e) {
  $.ajax({
      url: "",
      method: "GET",
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
            <?= Html::beginForm('', 'get', ['class' => 'manualFilter']) ?>
                <input class="input-t" placeholder="Я ищу…" type="text" name="search" id="manuasearch">
                <label class="manuasearch" for="manuasearch"></label>
            <?= Html::endForm(); ?>
            <section class="usermanual_feature-list">
                <h2 class="usermanual_feature-list-title">
                    Популярные вопросы
                </h2>
                <div class="usermanual_feature-list-link-wrap">
                    <a href="<?= Url::to(['manualmain']) ?>" class="link--blue usermanual_feature-list-link">С чего начать?</a>
                    <a href="<?= Url::to(['manualbalance']) ?>" class="link--blue usermanual_feature-list-link">Как пополнить баланс?</a>
                    <a href="<?= Url::to(['manualproject']) ?>" class="link--blue usermanual_feature-list-link">Как заказать проект?</a>
                    <a href="<?= Url::to(['manualprofile']) ?>" class="link--blue usermanual_feature-list-link">Что заполнять в профиле?</a>
                </div>
            </section>
            <section class="usermanual_feature-list">
                <h2 class="usermanual_feature-list-title">
                    Функционал личного кабинета
                </h2>
                <div class="usermanual_feature-list_cards">
                    <div class="usermanual_feature-list_card">
                        <img src="<?= Url::to(['/img/dev/manual-1.png']) ?>" alt="скриншот главной страницы">
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
                        <img src="<?= Url::to(['/img/dev/manual-2.png']) ?>" alt="скриншот страницы профиля">
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
                        <img src="<?= Url::to(['/img/dev/manual-3.png']) ?>" alt="скриншот страницы баланса">
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
                        <img src="<?= Url::to(['/img/dev/manual-4.png']) ?>" alt="скриншот страницы заказов">
                        <div class="usermanual_feature-list_card_info">
                            <h3 class="usermanual_feature-list_card_info-title">
                                Мои проекты
                            </h3>
                            <p class="usermanual_feature-list_card_info-text">
                                Здесь вы можете отследить статус своих заказов и узнать подробную информацию о поступивших лидах
                            </p>
                            <a class="link--purple" href="<?= Url::to(['manualproject']) ?>">
                                Читать
                            </a>
                        </div>
                    </div>

                    <div class="usermanual_feature-list_card">
                        <img src="<?= Url::to(['/img/dev/manual-5.png']) ?>" alt="скриншот страницы заказов">
                        <div class="usermanual_feature-list_card_info">
                            <h3 class="usermanual_feature-list_card_info-title">
                                Начать проект
                            </h3>
                            <p class="usermanual_feature-list_card_info-text">
                                Тут вы можете выбрать готовый пакет лидов или заказать индивидуальный
                            </p>
                            <a class="link--purple" href="<?= Url::to(['manualstart']) ?>">
                                Читать
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <aside class="usermanual_chat">
            <img src="<?= Url::to(['/img/dev/manual-aside.png']) ?>" alt="фоновое изображение">
            <h3 class="usermanual_chat_title">
                Не нашли ответ?
            </h3>
            <p class="usermanual_chat_text">
                Задайте свой вопрос в чате тех.поддержки, мы поможем
            </p>
            <a class="link--purple" href="<?= Url::to(['']) ?>">
                Перейти в чат
            </a>
        </aside>
    </div>
</section>