<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = '';

$js = <<< JS

JS;
$this->registerJs($js);

?>

<section class="rightInfo education">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <a href="<?= Url::to(['education']) ?>" class="bcr__link">
                    Моё обучение
                </a>
            </li>

            <li class="bcr__item">
                <a href="<?= Url::to(['education']) ?>" class="bcr__link">
                    Активные программы
                </a>
            </li>

            <li class="bcr__item">
                <span class="bcr__span nowpagebrc"></span>
            </li>
        </ul>
    </div>
    <p class="type-cours">курс</p>
    <div class="title_row">
        <h1 class="Bal-ttl title-main">Менеджер клиентского сервиса</h1>
    </div>

    <h2 class="viewcours-title">
        10.1 Инструменты взаимодействия
    </h2>

    <section class="viewcours_main">
        <article class="viewcours_main_info">
            <p class="viewcours-prev-text">Любую CRM-систему используют в качестве базового инструмента для автоматизации бизнес-процессов. В систему, представляющую собой программное обеспечение, оператор вводит все доступные сведения о заказчиках, используя готовые клиентские базы либо вводя вручную информацию по каждому покупателю.</p>

            <section class="viewcours-video viewcours-card">
                <div class="viewcours-video_video">
                    <iframe src="https://www.youtube.com/embed/V24IuCFKgEI?controls=0" frameborder="0" allowfullscreen></iframe>
                </div>
                <h3 class="viewcours-video-title">
                    Материалы к лекции
                </h3>
                <ul class="viewcours-video-list">
                    <li class="viewcours-video-list-item">
                        <div class="viewcours-video-list-item_container">
                            <p>Презентация</p>
                            <a class="link--purple" href="<?= Url::to(['']) ?>">Скачать</a>
                        </div>
                    </li>
                    <li class="viewcours-video-list-item">
                        <div class="viewcours-video-list-item_container">
                            <p>Чек-лист</p>
                            <a class="link--purple" href="<?= Url::to(['']) ?>">Скачать</a>
                        </div>
                    </li>
                    <li class="viewcours-video-list-item">
                        <div class="viewcours-video-list-item_container">
                            <p>Инструкция</p>
                            <a class="link--purple" href="<?= Url::to(['']) ?>">Скачать</a>
                        </div>
                    </li>
                </ul>
            </section>

            <section class="learning viewcours-card">
                <button class="learning-btn" type="button">
                    Материал для изучения
                </button>

                <div class="learning_info">
                    <div class="learning_info_container">
                        <p class="learning_info-text">Любую CRM-систему используют в качестве базового инструмента для автоматизации бизнес-процессов. В систему, представляющую собой программное обеспечение, оператор вводит все доступные сведения о заказчиках, используя готовые клиентские базы либо вводя вручную информацию по каждому покупателю. Дальнейшая работа в программе позволяет осуществлять целый ряд функций:
                            данные о клиентах можно группировать исходя из конкретных задач, например в одну группу добавить клиентов, с которыми предстоит встреча или телефонный разговор, а в другую – тех, с кем уже удалось пообщаться;
                            перемещать заказчиков с одной ступени воронки продаж на другую. Перевод сопровождается получением подробной информации о сделке, включая итоговую сумму или причину остановки работ по договору;
                            быстро формировать отчетность. Программа анализирует и создает отчеты, основываясь на данных, которые ввел менеджер. Пользуясь этой функцией, менеджер имеет возможность дать оценку своей работе и эффективности маркетинговых каналов, а также спрогнозировать сделки;
                            автоматизированная система управления – щелкнув мышью несколько раз, менеджер получает возможность сформировать правильный документ и предоставить его руководителю в виде отчета.</p>

                        <ul class="viewcours-video-list">
                            <li class="viewcours-video-list-item">
                                <div class="viewcours-video-list-item_container">
                                    <p>Презентация</p>
                                    <a class="link--purple" href="<?= Url::to(['']) ?>">Скачать</a>
                                </div>
                            </li>
                            <li class="viewcours-video-list-item">
                                <div class="viewcours-video-list-item_container">
                                    <p>Чек-лист</p>
                                    <a class="link--purple" href="<?= Url::to(['']) ?>">Скачать</a>
                                </div>
                            </li>
                            <li class="viewcours-video-list-item">
                                <div class="viewcours-video-list-item_container">
                                    <p>Инструкция</p>
                                    <a class="link--purple" href="<?= Url::to(['']) ?>">Скачать</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </section>

            <!-- Дальше идёт та непонятная чушь с кучей карточек
                     Я сделал всё в одной форме
                -->
            <?= Html::beginForm('', 'get', ['class' => 'home-work']) ?>

            <!-- Первая и вторая карты в одном-->
            <section class="viewcours_home-work viewcours-card">
                <div class="viewcours_home-work_container">
                    <h3 class="viewcours_home-work-title">
                        Загрузите домашнее задание
                    </h3>
                    <h4 class="viewcours_home-work-subtitle">
                        Прикрепите ссылку на проект
                    </h4>
                    <input required minlength="1" class="input-t" placeholder="Ссылка на проект" type="text" name="link">
                    <h4 class="viewcours_home-work-subtitle">
                        Комментарий к заданию
                    </h4>
                    <textarea required minlength="1" class="input-t" placeholder="Введите текст" minlength="1" class="input-t" placeholder="Введите текст" name="comment" cols="30" rows="2"></textarea>
                    <button class="btn--purple viewcours_home-work-submit" type="submit">Загрузить задание</button>
                </div>
            </section>

            <!-- Третья карта -->
            <section class="viewcours_home-work viewcours-card">
                <div class="viewcours_home-work_top-row">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M32 16C32 24.8366 24.8366 32 16 32C7.16344 32 0 24.8366 0 16C0 7.16344 7.16344 0 16 0C24.8366 0 32 7.16344 32 16ZM2.46181 16.0004C2.46181 23.4775 8.52318 29.5389 16.0003 29.5389C23.4774 29.5389 29.5387 23.4775 29.5387 16.0004C29.5387 8.52336 23.4774 2.46199 16.0003 2.46199C8.52318 2.46199 2.46181 8.52336 2.46181 16.0004Z" fill="#2CCD65" />
                        <path d="M9.33638 15.7951C8.87457 15.2577 8.07233 15.2032 7.54453 15.6735C7.01674 16.1437 6.96326 16.9605 7.42508 17.4979L11.8695 22.6696C12.3627 23.2435 13.2341 23.2604 13.7484 22.706L24.542 11.0696C25.0236 10.5505 25.0006 9.73217 24.4907 9.24187C23.9809 8.75158 23.1772 8.77496 22.6956 9.29409L12.861 19.8965L9.33638 15.7951Z" fill="#2CCD65" />
                    </svg>
                    <p class="viewcours_home-work_top-row-date">25.08.2021</p>
                </div>
                <div class="viewcours_home-work_container">
                    <h3 class="viewcours_home-work-title">
                        Домашнее задание добавлено!
                    </h3>
                    <h4 class="viewcours_home-work-subtitle">
                        Ваше задание будет проверено в течение 3 дней.
                    </h4>
                </div>
            </section>

            <!-- Четвёртая карта -->
            <section class="viewcours_home-work viewcours-card viewcours-card-pd">
                <div class="viewcours_home-work_container">
                    <div class="viewcours_home-work_top-row viewcours-card-pd-inside">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M16.077 2.46154C15.3972 2.46154 14.8462 3.01257 14.8462 3.69231C14.8462 4.37204 15.3972 4.92308 16.077 4.92308C16.7567 4.92308 17.3077 4.37204 17.3077 3.69231C17.3077 3.01257 16.7567 2.46154 16.077 2.46154ZM12.3847 3.69231C12.3847 1.6531 14.0378 0 16.077 0C18.1162 0 19.7693 1.6531 19.7693 3.69231C19.7693 4.36408 19.5899 4.99396 19.2764 5.53663C22.4503 6.80668 24.6923 9.91026 24.6923 13.5379V19.6923C24.6923 20.5531 25.1419 21.5324 25.7164 22.3942C25.9903 22.8051 26.266 23.1499 26.473 23.3913C26.5759 23.5114 26.6603 23.6042 26.7171 23.665C26.7454 23.6954 26.7668 23.7177 26.7799 23.7312L26.7933 23.745C27.1449 24.097 27.2506 24.6266 27.0602 25.0864C26.8697 25.5463 26.4209 25.8462 25.9231 25.8462H20.7847C20.9181 26.2296 21 26.6424 21 27.0769C21 29.7959 18.7959 32 16.077 32C13.358 32 11.1539 29.7959 11.1539 27.0769C11.1539 26.6424 11.2358 26.2296 11.3693 25.8462H6.23081C5.73301 25.8462 5.28422 25.5463 5.09372 25.0864C4.90351 24.6272 5.00821 24.0987 5.35893 23.7467L5.35996 23.7457L5.37402 23.7312C5.38715 23.7177 5.40847 23.6954 5.43681 23.665C5.49358 23.6042 5.57803 23.5114 5.68095 23.3913C5.88788 23.1499 6.1636 22.8051 6.43751 22.3942C7.01203 21.5324 7.46157 20.5531 7.46157 19.6923V13.5379C7.46157 9.91026 9.70364 6.80668 12.8776 5.53663C12.5641 4.99396 12.3847 4.36408 12.3847 3.69231ZM14.163 25.8462C13.8172 26.2809 13.6154 26.7246 13.6154 27.0769C13.6154 28.4364 14.7175 29.5385 16.077 29.5385C17.4364 29.5385 18.5385 28.4364 18.5385 27.0769C18.5385 26.7246 18.3368 26.2809 17.9909 25.8462H14.163ZM22.2308 19.6923C22.2308 21.101 22.8359 22.418 23.4283 23.3846H8.72559C9.31804 22.418 9.92311 21.101 9.92311 19.6923V13.5379C9.92311 10.1394 12.6782 7.38462 16.077 7.38462C19.4757 7.38462 22.2308 10.1394 22.2308 13.5379V19.6923Z" fill="#FFA800"/>
                        </svg>
                        <p class="viewcours_home-work_top-row-date-of">Загрузить до 25.09.2021</p>
                    </div>
                    <div class="viewcours-card-pd-inside viewcours-card-pd-wrap">
                        <h3 class="viewcours_home-work-title">
                            Домашнее задание отправлено на доработку!
                        </h3>
                        <h4 class="viewcours_home-work-subtitle">
                            Ознакомьтесь с комментариями преподавателя и загрузите задание
                        </h4>
                    </div>
                    <section class="viewcours_home-work-dark">
                        <p class="viewcours_home-work_top-row-date viewcours_home-work_top-row-date-dark">25.08.2021</p>
                        <h4 class="viewcours_home-work-subtitle">
                            Прикрепите ссылку на проект
                        </h4>
                        <input disabled value="http://pdjfvsjnbjkbjntfhymjfghm" required minlength="1" class="input-t" placeholder="Ссылка на проект" type="text" name="link">
                        <h4 class="viewcours_home-work-subtitle">
                            Комментарий к заданию
                        </h4>
                        <textarea disabled required minlength="1" class="input-t" placeholder="Введите текст" minlength="1" class="input-t" placeholder="Введите текст" name="comment" cols="30" rows="2">Интересное задание. Не смог сообразить с причинами отказа, поэтому создал отдельную ветку ...</textarea>
                        <h4 class="viewcours_home-work-subtitle">
                            Комментарий к заданию
                        </h4>
                        <textarea required minlength="1" class="input-t" placeholder="Введите текст" minlength="1" class="input-t" placeholder="Введите текст" name="comment" cols="30" rows="2">Интересное задание. Не смог сообразить с причинами отказа, поэтому создал отдельную ветку ...</textarea>
                    </section>
                    <div class="viewcours-card-pd-inside viewcours-card-pd-wrap">
                        <h4 class="viewcours_home-work-subtitle">
                            Прикрепите ссылку на проект
                        </h4>
                        <input required minlength="1" class="input-t" placeholder="Ссылка на проект" type="text" name="link">
                        <h4 class="viewcours_home-work-subtitle">
                            Комментарий к заданию
                        </h4>
                        <textarea required minlength="1" class="input-t" placeholder="Введите текст" minlength="1" class="input-t" placeholder="Введите текст" name="comment" cols="30" rows="2"></textarea>
                        <button class="btn--purple viewcours_home-work-submit" type="submit">Загрузить задание</button>
                    </div>
                </div>
            </section>

            <!-- Пятая карта -->
            <section class="viewcours_home-work viewcours-card viewcours-card-pd">
                <div class="viewcours_home-work_container">
                    <div class="viewcours_home-work_top-row viewcours-card-pd-inside">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M32 16C32 24.8366 24.8366 32 16 32C7.16344 32 0 24.8366 0 16C0 7.16344 7.16344 0 16 0C24.8366 0 32 7.16344 32 16ZM2.46181 16.0004C2.46181 23.4775 8.52318 29.5389 16.0003 29.5389C23.4774 29.5389 29.5387 23.4775 29.5387 16.0004C29.5387 8.52336 23.4774 2.46199 16.0003 2.46199C8.52318 2.46199 2.46181 8.52336 2.46181 16.0004Z" fill="#2CCD65" />
                            <path d="M9.33638 15.7951C8.87457 15.2577 8.07233 15.2032 7.54453 15.6735C7.01674 16.1437 6.96326 16.9605 7.42508 17.4979L11.8695 22.6696C12.3627 23.2435 13.2341 23.2604 13.7484 22.706L24.542 11.0696C25.0236 10.5505 25.0006 9.73217 24.4907 9.24187C23.9809 8.75158 23.1772 8.77496 22.6956 9.29409L12.861 19.8965L9.33638 15.7951Z" fill="#2CCD65" />
                        </svg>
                        <p class="viewcours_home-work_top-row-date">25.08.2021</p>
                    </div>
                    <div class="viewcours-card-pd-inside viewcours-card-pd-wrap">
                        <h3 class="viewcours_home-work-title">
                            Домашнее задание отправлено на доработку!
                        </h3>
                        <h4 class="viewcours_home-work-subtitle">
                            Ознакомьтесь с комментариями преподавателя и загрузите задание
                        </h4>
                    </div>
                    <section class="viewcours_home-work-dark">
                        <p class="viewcours_home-work_top-row-date viewcours_home-work_top-row-date-dark">25.08.2021</p>
                        <h4 class="viewcours_home-work-subtitle">
                            Прикрепите ссылку на проект
                        </h4>
                        <input disabled value="http://pdjfvsjnbjkbjntfhymjfghm" required minlength="1" class="input-t" placeholder="Ссылка на проект" type="text" name="link">
                        <h4 class="viewcours_home-work-subtitle">
                            Комментарий к заданию
                        </h4>
                        <textarea disabled required minlength="1" class="input-t" placeholder="Введите текст" minlength="1" class="input-t" placeholder="Введите текст" name="comment" cols="30" rows="2">Интересное задание. Не смог сообразить с причинами отказа, поэтому создал отдельную ветку ...</textarea>
                        <h4 class="viewcours_home-work-subtitle">
                            Комментарий к заданию
                        </h4>
                        <textarea required minlength="1" class="input-t" placeholder="Введите текст" minlength="1" class="input-t" placeholder="Введите текст" name="comment" cols="30" rows="2">Интересное задание. Не смог сообразить с причинами отказа, поэтому создал отдельную ветку ...</textarea>
                    </section>
                </div>
            </section>

            <!-- Шестая карта -->
            <section class="viewcours_home-work viewcours-card">
                <div class="viewcours_home-work_top-row">
                    <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M32 16C32 24.8366 24.8366 32 16 32C7.16344 32 0 24.8366 0 16C0 7.16344 7.16344 0 16 0C24.8366 0 32 7.16344 32 16ZM2.46181 16.0004C2.46181 23.4775 8.52318 29.5389 16.0003 29.5389C23.4774 29.5389 29.5387 23.4775 29.5387 16.0004C29.5387 8.52336 23.4774 2.46199 16.0003 2.46199C8.52318 2.46199 2.46181 8.52336 2.46181 16.0004Z" fill="#2CCD65" />
                        <path d="M9.33638 15.7951C8.87457 15.2577 8.07233 15.2032 7.54453 15.6735C7.01674 16.1437 6.96326 16.9605 7.42508 17.4979L11.8695 22.6696C12.3627 23.2435 13.2341 23.2604 13.7484 22.706L24.542 11.0696C25.0236 10.5505 25.0006 9.73217 24.4907 9.24187C23.9809 8.75158 23.1772 8.77496 22.6956 9.29409L12.861 19.8965L9.33638 15.7951Z" fill="#2CCD65" />
                    </svg>
                    <p class="viewcours_home-work_top-row-status">Зачет</p>
                </div>
                <div class="viewcours_home-work_container">
                    <h3 class="viewcours_home-work-title">
                        Домашнее задание добавлено!
                    </h3>
                    <h4 class="viewcours_home-work-subtitle">
                        Ваше задание будет проверено в течение 3 дней.
                    </h4>
                    <p class="viewcours_home-work_top-row-date viewcours_home-work_top-row-date-dark">25.08.2021</p>
                        <h4 class="viewcours_home-work-subtitle">
                            Прикрепите ссылку на проект
                        </h4>
                        <input disabled value="http://pdjfvsjnbjkbjntfhymjfghm" required minlength="1" class="input-t" placeholder="Ссылка на проект" type="text" name="link">
                        <h4 class="viewcours_home-work-subtitle">
                            Комментарий к заданию
                        </h4>
                        <textarea disabled required minlength="1" class="input-t" placeholder="Введите текст" minlength="1" class="input-t" placeholder="Введите текст" name="comment" cols="30" rows="2">Интересное задание. Не смог сообразить с причинами отказа, поэтому создал отдельную ветку ...</textarea>
                        <h4 class="viewcours_home-work-subtitle">
                            Комментарий к заданию
                        </h4>
                        <textarea required minlength="1" class="input-t" placeholder="Введите текст" minlength="1" class="input-t" placeholder="Введите текст" name="comment" cols="30" rows="2">Интересное задание. Не смог сообразить с причинами отказа, поэтому создал отдельную ветку ...</textarea>
                </div>
            </section>

            <h3 class="viewcours-video-title">
                Тестирование к блоку «Инструменты»
            </h3>
            <a href="<?= Url::to(['']) ?>" class="btn--purple viewcours-start-test">Начать</a>

            <!-- Карточка с тестом -->
            <section class="viewcours_test viewcours-card">
                <div class="viewcours_home-work_container">
                    <h3 class="viewcours_test-title">1. Текстовый вопрос, неограниченное количество строк. Один вариант ответа</h3>
                    <ul class="viewcours_test_group">
                        <li class="viewcours_test_group-item">
                            <label class="viewcours_test_group-item-label">
                                <input class="viewcours_test-radio" type="radio" name="task1" value="">
                                <p class="viewcours_test_group-item-label-text">Вариант ответа 1</p>
                            </label>
                        </li> 
                        <li class="viewcours_test_group-item">
                            <label class="viewcours_test_group-item-label">
                                <input class="viewcours_test-radio" type="radio" name="task1" value="">
                                <p class="viewcours_test_group-item-label-text">Вариант ответа 1</p>
                            </label>
                        </li> 
                    </ul>
                    <h3 class="viewcours_test-title">2. Текстовый вопрос, неограниченное количество строк. Один вариант ответа</h3>
                    <ul class="viewcours_test_group">
                        <li class="viewcours_test_group-item">
                            <label class="viewcours_test_group-item-label">
                                <input class="viewcours_test-radio" type="radio" name="task2" value="">
                                <p class="viewcours_test_group-item-label-text">Вариант ответа 1</p>
                            </label>
                        </li> 
                        <li class="viewcours_test_group-item">
                            <label class="viewcours_test_group-item-label">
                                <input class="viewcours_test-radio" type="radio" name="task2" value="">
                                <p class="viewcours_test_group-item-label-text">Вариант ответа 1</p>
                            </label>
                        </li> 
                    </ul>
                    <h3 class="viewcours_test-title">3. Текстовый вопрос, неограниченное количество строк. Один вариант ответа</h3>
                    <input class="input-t viewcours_test-input-text" placeholder="Введите текст" type="text" name="text">
                    <h3 class="viewcours_test-title">4. Текстовый вопрос, неограниченное количество строк. Один вариант ответа</h3>
                    <div class="viewcours_test-img">
                        <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                    </div>
                    <ul class="viewcours_test_group">
                        <li class="viewcours_test_group-item">
                            <label class="viewcours_test_group-item-label">
                                <input class="viewcours_test-radio" type="radio" name="task3" value="">
                                <p class="viewcours_test_group-item-label-text">Вариант ответа 1</p>
                            </label>
                        </li> 
                        <li class="viewcours_test_group-item">
                            <label class="viewcours_test_group-item-label">
                                <input class="viewcours_test-radio" type="radio" name="task3" value="">
                                <p class="viewcours_test_group-item-label-text">Вариант ответа 1</p>
                            </label>
                        </li> 
                    </ul>
                    <h3 class="viewcours_test-title">5. Текстовый вопрос, неограниченное количество строк. Один вариант ответа</h3>
                    <div class="viewcours_test-img">
                        <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                    </div>
                    <input class="input-t viewcours_test-input-text" placeholder="Введите текст" type="text" name="text">
                    <h3 class="viewcours_test-title">5. Текстовый вопрос, неограниченное количество строк. Один вариант ответа</h3>
                    <ul class="viewcours_test_group-wrap">
                        <li class="viewcours_test_group-wrap-item">
                            <label class="viewcours_test_group-wrap-item-label">
                                <input class="viewcours_test-radio" type="radio" name="task5" value="">
                                <div class="viewcours_test_group-item-label-img">
                                    <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                </div>
                            </label>
                        </li>
                        <li class="viewcours_test_group-wrap-item">
                            <label class="viewcours_test_group-wrap-item-label">
                                <input class="viewcours_test-radio" type="radio" name="task5" value="">
                                <div class="viewcours_test_group-item-label-img">
                                    <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                </div>
                            </label>
                        </li>
                        <li class="viewcours_test_group-wrap-item">
                            <label class="viewcours_test_group-wrap-item-label">
                                <input class="viewcours_test-radio" type="radio" name="task5" value="">
                                <div class="viewcours_test_group-item-label-img">
                                    <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                </div>
                            </label>
                        </li>
                        <li class="viewcours_test_group-wrap-item">
                            <label class="viewcours_test_group-wrap-item-label">
                                <input class="viewcours_test-radio" type="radio" name="task5" value="">
                                <div class="viewcours_test_group-item-label-img">
                                    <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                </div>
                            </label>
                        </li>
                    </ul>
                    <h3 class="viewcours_test-title">5. Текстовый вопрос, неограниченное количество строк. Один вариант ответа</h3>
                    <div class="viewcours_test_rows">
                        <div class="viewcours_test_rows_laft-wrap">
                            <div class="viewcours_test_rows-item-left">
                                1
                            </div>
                            <div class="viewcours_test_rows-item-left">
                                2
                            </div>
                            <div class="viewcours_test_rows-item-left">
                                3
                            </div>
                            <div class="viewcours_test_rows-item-left">
                                4
                            </div>
                        </div>
                        <div class="tasks__list">
                            <div draggable="true" class="tasks__item viewcours_test_rows-item-rigth">
                                Ответ 1 
                            </div>
                            <div draggable="true" class="tasks__item viewcours_test_rows-item-rigth">
                                Ответ 2 
                            </div>
                            <div draggable="true" class="tasks__item viewcours_test_rows-item-rigth">
                                Ответ 3
                            </div>
                            <div draggable="true" class="tasks__item viewcours_test_rows-item-rigth">
                                Ответ 4 
                            </div>
                        </div>
                    </div>
<script>
    const tasksListElement = document.querySelector(`.tasks__list`);
    const taskElements = tasksListElement.querySelectorAll(`.tasks__item`);
    tasksListElement.addEventListener(`dragstart`, (evt) => {
        evt.target.classList.add(`selected`);
    })
    tasksListElement.addEventListener(`dragend`, (evt) => {
        evt.target.classList.remove(`selected`);
        evt.target.classList.add(`active`);
    });
    tasksListElement.addEventListener(`dragover`, (evt) => {
        evt.preventDefault();
        const activeElement = tasksListElement.querySelector(`.selected`);
        const currentElement = evt.target;
        const isMoveable = activeElement !== currentElement &&
        currentElement.classList.contains(`tasks__item`);
        if (!isMoveable) {
            return;
        }     
        const nextElement = (currentElement === activeElement.nextElementSibling) ?
        currentElement.nextElementSibling :
        currentElement;
        tasksListElement.insertBefore(activeElement, nextElement);
    });
    const getNextElement = (cursorPosition, currentElement) => {
        const currentElementCoord = currentElement.getBoundingClientRect();
        const currentElementCenter = currentElementCoord.y + currentElementCoord.height / 2;
        const nextElement = (cursorPosition < currentElementCenter) ?
            currentElement :
            currentElement.nextElementSibling;
        return nextElement;
    };
    tasksListElement.addEventListener(`dragover`, (evt) => {
        evt.preventDefault();
        const activeElement = tasksListElement.querySelector(`.selected`);
        const currentElement = evt.target;
        const isMoveable = activeElement !== currentElement &&
        currentElement.classList.contains(`tasks__item`);
        if (!isMoveable) {
            return;
        }
        const nextElement = getNextElement(evt.clientY, currentElement);
        if (
            nextElement &&  
            activeElement === nextElement.previousElementSibling ||
            activeElement === nextElement
            ) {
            return;
        }
        tasksListElement.insertBefore(activeElement, nextElement);
    });
</script>
                    <h3 class="viewcours_test-title">6. Текстовый вопрос, неограниченное количество строк. Один вариант ответа</h3>
                    <ul class="viewcours_test_columns">
                        <li class="viewcours_test_columns-item">
                            <p class="viewcours_test_columns-item-text">
                            Категория 1
                            </p>
                            <div class="viewcours_test_columns-item-img-dropzone" ondragover="onDragOver(event);" ondrop="onDrop(event);" ondragend = "dragEnd(event);">
                                <div id="draggable-1" draggable="true" ondragstart="onDragStart(event);" class=" viewcours_test_columns-item-img">
                                    <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                </div>
                                <div id="draggable-2" draggable="true" ondragstart="onDragStart(event);" class=" viewcours_test_columns-item-img">
                                    <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                </div>
                            </div>
                        </li>
                        <li class="viewcours_test_columns-item">
                            <p class="viewcours_test_columns-item-text">
                            Категория 2
                            </p>
                            <div class="viewcours_test_columns-item-img-dropzone" ondragover="onDragOver(event);" ondrop="onDrop(event);" ondragend = "dragEnd(event);">
                                <div id="draggable-3" draggable="true" ondragstart="onDragStart(event);" class=" viewcours_test_columns-item-img">
                                    <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                </div>
                                <div id="draggable-4" draggable="true" ondragstart="onDragStart(event);" class=" viewcours_test_columns-item-img">
                                    <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                </div>
                            </div>
                        </li>
                        <li class="viewcours_test_columns-item">
                            <p class="viewcours_test_columns-item-text">
                            Категория 3
                            </p>
                            <div class="viewcours_test_columns-item-img-dropzone" ondragover="onDragOver(event);" ondrop="onDrop(event);" ondragend = "dragEnd(event);">
                                <div id="draggable-5" draggable="true" ondragstart="onDragStart(event);" class=" viewcours_test_columns-item-img">
                                    <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                </div>
                                <div id="draggable-6" draggable="true" ondragstart="onDragStart(event);" class=" viewcours_test_columns-item-img">
                                    <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                </div>
                            </div>
                        </li>
                        <li class="viewcours_test_columns-item">
                            <p class="viewcours_test_columns-item-text">
                            Категория 4
                            </p>
                            <div class="viewcours_test_columns-item-img-dropzone" ondragover="onDragOver(event);" ondrop="onDrop(event);" ondragend = "dragEnd(event);">
                                <div id="draggable-7" draggable="true" ondragstart="onDragStart(event);" class=" viewcours_test_columns-item-img">
                                    <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                </div>
                                <div id="draggable-8" draggable="true" ondragstart="onDragStart(event);" class=" viewcours_test_columns-item-img">
                                    <img src="<?= Url::to('/img/skillclient/ico.svg') ?>" alt="image">
                                </div>
                            </div>
                        </li>
                    </ul>
<script>
    function onDragStart(event) {
        event
            .dataTransfer
            .setData('text/plain', event.target.id);
        
        setTimeout(function(){
            event.target.classList.add('hide');
            document.querySelector('.viewcours_test_rows.second').classList.add('disabled');
        }, 0);
    }
    function onDragOver(event) {
        event.preventDefault();
    }
    function dragEnd(event){
        event.target.classList.remove('hide');
        document.querySelector('.viewcours_test_rows.second').classList.remove('disabled');
    }
    function onDrop(event) {
        const id = event
            .dataTransfer
            .getData('text');
        const draggableElement = document.getElementById(id);
        draggableElement.classList.remove('hide');
        const dropzone = event.target;
        console.log('1');
        if(dropzone.classList.contains('viewcours_test_columns-item-img-dropzone')){
            dropzone.appendChild(draggableElement);
            event
                .dataTransfer
                .clearData();
        }else {
            dropzone.parentElement.appendChild(draggableElement);
            event
                .dataTransfer
                .clearData();  
        }
    }
</script>
                    <h3 class="viewcours_test-title">7. Текстовый вопрос, неограниченное количество строк. Один вариант ответа</h3>
                    <ul class="viewcours_test_rows second">
                        <li class="viewcours_test_rows-item second">
                            <div class="viewcours_test_rows-item-left category second">
                            Категория 1
                            </div>
                            <div class="viewcours_test_rows-item-rigth-wrapper-s"  ondragover="onDragOver2(event);" ondrop="onDrop2(event);" ondragend = "dragEnd2(event);">
                                <div id="draggable2-1" draggable="true" ondragstart="onDragStart2(event);" class="viewcours_test_rows-item-rigth second">
                                Ответ 1 
                                </div>
                            </div>
                        </li>
                        <li class="viewcours_test_rows-item second">
                            <div class="viewcours_test_rows-item-left category second">
                            Категория 2
                            </div>
                            <div class="viewcours_test_rows-item-rigth-wrapper-s"  ondragover="onDragOver2(event);" ondrop="onDrop2(event);" ondragend = "dragEnd2(event);">
                                <div id="draggable2-2" draggable="true" ondragstart="onDragStart2(event);" class="viewcours_test_rows-item-rigth second">
                                Ответ 2 
                                </div>
                            </div>
                        </li>
                        <li class="viewcours_test_rows-item second">
                            <div class="viewcours_test_rows-item-left category second">
                            Категория 3
                            </div>
                            <div class="viewcours_test_rows-item-rigth-wrapper-s"  ondragover="onDragOver2(event);" ondrop="onDrop2(event);" ondragend = "dragEnd2(event);">
                                <div id="draggable2-3" draggable="true" ondragstart="onDragStart2(event);" class="viewcours_test_rows-item-rigth second">
                                Ответ 3 
                                </div>
                            </div>
                        </li>
                        <li class="viewcours_test_rows-item second">
                            <div class="viewcours_test_rows-item-left category second">
                            Категория 4
                            </div>
                            <div class="viewcours_test_rows-item-rigth-wrapper-s"  ondragover="onDragOver2(event);" ondrop="onDrop2(event);" ondragend = "dragEnd2(event);">
                                <div id="draggable2-4" draggable="true" ondragstart="onDragStart2(event);" class="viewcours_test_rows-item-rigth second">
                                Ответ 4
                                </div>
                            </div>
                        </li>
                    </ul>
                    <script>
    function onDragStart2(event) {
        event
            .dataTransfer
            .setData('text/plain', event.target.id);

        setTimeout(function(){
            document.querySelector('.viewcours_test_columns').classList.add('disabled');
        }, 0);
    }
    function onDragOver2(event) {
        event.preventDefault();
    }
    function dragEnd2(event){
        event.target.classList.add('active');
        document.querySelector('.viewcours_test_columns').classList.remove('disabled');
    }
    function onDrop2(event) {
        const id = event
            .dataTransfer
            .getData('text');
        const draggableElement = document.getElementById(id);
        const dropzone = event.target;
        console.log('2');
        if(dropzone.classList.contains('viewcours_test_rows-item-rigth-wrapper-s')){
            dropzone.appendChild(draggableElement);
            event
                .dataTransfer
                .clearData();
        }else {
            dropzone.parentElement.appendChild(draggableElement);
            event
                .dataTransfer
                .clearData();  
        }
    }
</script>
                    <button class="btn--purple viewcours_test-submit" type="submit">Завершить тестирование</button>
                </div>
            </section>

            <h3 class="viewcours_test-title">Ваш результат</h3>
            <p class="viewcours_test-result">
            35/40
            </p>
            <button class="btn--purple viewcours_test-again" type="submit">Пройти снова</button>
            <?= Html::endForm(); ?>
        </article>

        <aside class="viewcours-structure">
            <div class="viewcours-structure_main">
                <div class="viewcours-structure_container">
                    <h3 class="viewcours-structure-titel">Структура</h3>
                    <ul class="viewcours-structure-list">
                        <li class="viewcours-structure-list-item">
                            <a class="active" href="<?= Url::to(['']) ?>">
                                <h4 class="viewcours-structure-list-item-title">10.2 Инструменты работы с клиентом</h4>
                                <div class="viewcours-structure-list-item-indicator"></div>
                            </a>
                        </li>
                        <li class="viewcours-structure-list-item">
                            <a href="<?= Url::to(['']) ?>">
                                <h4 class="viewcours-structure-list-item-title">10.2 Инструменты работы с клиентом</h4>
                                <div class="viewcours-structure-list-item-indicator"></div>
                            </a>
                        </li>
                        <li class="viewcours-structure-list-item">
                            <a href="<?= Url::to(['']) ?>">
                                <h4 class="viewcours-structure-list-item-title">10.4 Задание</h4>
                                <div class="viewcours-structure-list-item-indicator text">Зачет</div>
                            </a>
                        </li>
                        <li class="viewcours-structure-list-item">
                            <a href="<?= Url::to(['']) ?>">
                                <h4 class="viewcours-structure-list-item-title">10.4 Задание</h4>
                                <div class="viewcours-structure-list-item-indicator text orange">Проверка</div>
                            </a>
                        </li>
                        <li class="viewcours-structure-list-item">
                            <a href="<?= Url::to(['']) ?>">
                                <h4 class="viewcours-structure-list-item-title">10.4 Задание</h4>
                                <div class="viewcours-structure-list-item-indicator text red">Просрочено</div>
                            </a>
                        </li>
                    </ul>
                    <div class="viewcours-structure_last">
                        <button class="viewcours-structure-btn" type="button">
                            <svg width="11" height="10" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.71831 0.45464C6.01957 0.755902 6.01957 1.24434 5.71831 1.54561L2.86379 4.40012L10.5509 4.40012C10.7994 4.40012 11.0009 4.75829 11.0009 5.20012C11.0009 5.64195 10.7994 6.00012 10.5509 6.00012L3.03522 6.00012L5.71831 8.68321C6.01957 8.98447 6.01957 9.47291 5.71831 9.77418C5.41704 10.0754 4.9286 10.0754 4.62734 9.77418L0.513056 5.65989C0.211794 5.35863 0.211794 4.87019 0.513056 4.56893L4.62734 0.45464C4.9286 0.153379 5.41704 0.153379 5.71831 0.45464Z" fill="#4135F1" />
                            </svg>
                            <p>Все модули</p>
                        </button>
                    </div>
                </div>
            </div>

            <div class="viewcours-structure_all">
                <div class="viewcours-structure_container">
                    <h3 class="viewcours-structure-titel">Все модули</h3>

                    <ul class="viewcours-structure_all_modules">
                        <li class="viewcours-structure_all_module">
                            <button type="button" class="viewcours-structure_all_module-btn">
                                Основы
                            </button>

                            <ul class="viewcours-structure_all_module_bloks">
                                <li class="viewcours-structure_all_module-block">
                                    <button type="button" class="viewcours-structure_all_module-block-btn">
                                        10 Инструменты
                                        <div class="viewcours-structure_all_module-block-btn-indicator"></div>
                                    </button>

                                    <ul class="viewcours-structure_all_module-block_lessons">
                                        <li class="viewcours-structure_all_module-block-lesson">
                                            <a class="viewcours-structure_all_module-block-lesson-link" href="">
                                                10.2 Инструменты работы с клиентом
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
    </section>
</section>