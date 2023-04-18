<?php


use yii\helpers\Url;

?>
<?php include_once('header.php')?>
            <main class="main">
                <section class="main_info">
                    <div class="container">
                        <h1 class="title animate">
                            Создай 
                            <br>
                            <span>непрерывный поток Клиентов</span>
                            <br>
                            по банкротству вместе с нами
                        </h1>

                        <p class="main_info-descripton animate">
                            Нажми на кнопку и ответь на 4 вопроса, чтобы получить приветственный бонус в виде
                            <br>
                            <span>первых 10 лидов на банкротство <br> с суммой долга от 250 000 рублей</span>
                        </p>

                        <div class="main_info_btn-row">
                            <div class="main_info_btn-row-arrow-left animate">
                                <img src="<?= Url::to(['img/quiz-bfl/left-arrow.svg']) ?>" alt="arrow-left">
                            </div>

                            <button type="button" class="btn btn--main animate">
                                    <p>Создать поток</p>
                            </button>

                            <div class="main_info_btn-row-arrow-right animate">
                                <img src="<?= Url::to(['img/quiz-bfl/right-arrow.svg']) ?>" alt="arrow-right">
                            </div>
                        </div>

                        <div class="main_info_cards animate">
                            <div class="main_info_cards-item">
                                <img src="<?= Url::to(['img/quiz-bfl/people.svg']) ?>" alt="users">
                                <h3 class="main_info_cards-item-title">
                                    Клиенты для юристов
                                </h3>
                                <p class="main_info_cards-item-text">
                                    Возможность привлечения клиентов для юристов, юридических компаний без затрат на создание сайтов и настройки новой рекламы
                                </p>
                            </div>

                            <div class="main_info_cards-item">
                                <img src="<?= Url::to(['img/quiz-bfl/touchscreen.svg']) ?>" alt="users">
                                <h3 class="main_info_cards-item-title">
                                    Удобство
                                </h3>
                                <p class="main_info_cards-item-text">
                                    Привлечение клиентов за фиксированный рекламный бюджет, не нужно создавать маркетинговые ловушки для поиска новых заявок
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
<?php include_once('footer.php')?>
