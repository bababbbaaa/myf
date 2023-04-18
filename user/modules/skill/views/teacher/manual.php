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
            <?= Html::beginForm('', 'get', ['class' => 'manualFilter']) ?>
            <input class="input-t" placeholder="Я ищу…" type="text" name="search" id="manuasearch">
            <label class="manuasearch" for="manuasearch"></label>
            <?= Html::endForm(); ?>
            <section class="usermanual_feature-list">
                <h2 class="usermanual_feature-list-title">
                    Функционал личного кабинета
                </h2>
                <div class="usermanual_feature-list_cards">
                    <div class="usermanual_feature-list_card">
                        <img src="<?= Url::to(['/img/skillclient/manual-main.png']) ?>" alt="скриншот главной страницы">
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
                        <img src="<?= Url::to(['/img/skillclient/manual-prof.png']) ?>" alt="скриншот страницы профиля">
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
                        <img src="<?= Url::to(['/img/skillclient/manual-bal.png']) ?>" alt="скриншот страницы баланса">
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
                        <img src="<?= Url::to(['/img/skillclient/manual-prog.png']) ?>" alt="скриншот страницы заказов">
                        <div class="usermanual_feature-list_card_info">
                            <h3 class="usermanual_feature-list_card_info-title">
                                Мои программы
                            </h3>
                            <p class="usermanual_feature-list_card_info-text">
                                Здесь собраны ваши программы обучения: курсы, вебинары и интенсивы
                            </p>
                            <a class="link--purple" href="<?= Url::to(['manualprogram']) ?>">
                                Читать
                            </a>
                        </div>
                    </div>

                    <div class="usermanual_feature-list_card">
                        <img src="<?= Url::to(['/img/skillclient/manual-tasks.png']) ?>" alt="скриншот страницы заказов">
                        <div class="usermanual_feature-list_card_info">
                            <h3 class="usermanual_feature-list_card_info-title">
                                Мои задания
                            </h3>
                            <p class="usermanual_feature-list_card_info-text">
                                Здесь вы можете выбрать программу обучения
                            </p>
                            <a class="link--purple" href="<?= Url::to(['manualtasks']) ?>">
                                Читать
                            </a>
                        </div>
                    </div>

                    <div class="usermanual_feature-list_card">
                        <img src="<?= Url::to(['/img/skillclient/manual-help.png']) ?>" alt="скриншот страницы заказов">
                        <div class="usermanual_feature-list_card_info">
                            <h3 class="usermanual_feature-list_card_info-title">
                                Помогаю проверять
                            </h3>
                            <p class="usermanual_feature-list_card_info-text">
                                Вы можете составить своё резюме, заполнив форму и откликнуться на вакансии партнеров сервиса
                            </p>
                            <a class="link--purple" href="<?= Url::to(['manualhelp']) ?>">
                                Читать
                            </a>
                        </div>
                    </div>

                    <div class="usermanual_feature-list_card">
                        <img src="<?= Url::to(['/img/skillclient/manual-stat.png']) ?>" alt="скриншот страницы создания заказа">
                        <div class="usermanual_feature-list_card_info">
                            <h3 class="usermanual_feature-list_card_info-title">
                                Статистика
                            </h3>
                            <p class="usermanual_feature-list_card_info-text">
                                Вы можете составить своё резюме, заполнив форму и откликнуться на вакансии партнеров сервиса
                            </p>
                            <a class="link--purple" href="<?= Url::to(['manualstat']) ?>">
                                Читать
                            </a>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <aside class="usermanual_chat">
            <img src="<?= Url::to(['/img/skillclient/manual.svg']) ?>" alt="фоновое изображение">
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