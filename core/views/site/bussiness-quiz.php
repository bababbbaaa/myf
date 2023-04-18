<?php use yii\helpers\Url;


include_once('header-b.php')?>
            <main class="main">
                <section class="main_info">
                    <div class="container">
                        <h1 class="title animate">
                            Создай 
                            <br>
                            <span>непрерывный поток Клиентов</span>
                            <br>
                            для своего бизнеса вместе с нами
                        </h1>

                        <p class="main_info-descripton animate">
                            Нажми на кнопку и ответь на 4 вопроса, чтобы получить приветственный бонус в виде
                            <br>
                            <span>первых 10 клиентов нужных именно тебе</span>
                        </p>

                        <div class="main_info_btn-row">
                            <div class="main_info_btn-row-arrow-left animate">
                                <img src="<?= Url::to(['img/quiz-bussiness/left-arrow.svg']) ?>" alt="arrow-left">
                            </div>

                            <button type="button" class="btn btn--main animate">
                                    <p>Создать поток</p>
                            </button>

                            <div class="main_info_btn-row-arrow-right animate">
                                <img src="<?= Url::to(['img/quiz-bussiness/right-arrow.svg']) ?>" alt="arrow-right">
                            </div>
                        </div>

                        <div class="main_info_cards animate">
                            <div class="main_info_cards-item">
                                <img src="<?= Url::to(['img/quiz-bussiness/people.svg']) ?>" alt="users">
                                <h3 class="main_info_cards-item-title">
                                    Клиенты для Твоего бизнеса
                                </h3>
                                <p class="main_info_cards-item-text">
                                    Возможность привлечения клиентов для салонов красоты, автомагазинов и других видов бизнеса, без затрат на создание сайтов и настройку новой рекламы
                                </p>
                            </div>

                            <div class="main_info_cards-item">
                                <img src="<?= Url::to(['img/quiz-bussiness/touchscreen.svg']) ?>" alt="users">
                                <h3 class="main_info_cards-item-title">
                                    Удобство
                                </h3>
                                <p class="main_info_cards-item-text">
                                    Привлечение клиентов за фиксированный рекламный бюджет, не нужно создавать маркетинговые ловушки для поиска новых заявок
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
<?php include_once('footer-b.php')?>