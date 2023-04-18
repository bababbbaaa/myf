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
            <a href="<?= Url::to(['myprograms']) ?>" class="bcr__link">
            Мои программы
            </a>
          </li>

          <li class="bcr__item">
            <a href="<?= Url::to(['myprograms']) ?>" class="bcr__link">
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
       <div class="title_row_right-col">
            <p class="courses-direction yellow">Маркетинг</p>
            <p style="margin: 0px !important;" class="courses-date">Доступно всем</p>
       </div>
      </div>

        <div class="mycours-wrap"> 
            <div class="myprogramm-list">
                <div class="myprogramm-list_top myprogramm-list-item">
                    <h2 class="myprogramm-list_top-title">Задания на проверку</h2>
                    <p class="myprogramm-list_top-text">Ожидают проверки</p>
                    <p class="myprogramm-list_top-num">20</p>
                    <a href="<?= Url::to(['']) ?>" class="btn--purple myprogramm-list_top-btn">Перейти к заданиям</a>
                </div>

                <section class="mycours myprogramm-list-item">
                    <h2 class="mycours-title">
                    Программа курса
                    </h2>
                    <ul class="mycours-list">
                        <li class="mycours-list-item">
                            <button type="button" class="mycours-list-item-btn">
                                <h3 class="mycours-list-item-btn-text">Модуль 1 «Основы продаж»</h3>
                            </button>
                            <section class="mycours-list-item_info">
                                <div class="mycours-list-item_info-container">
                                    <div class="mycours-list-item_info-item"></div>
                                </div>
                            </section>
                        </li>
                        <li class="mycours-list-item">
                            <button type="button" class="mycours-list-item-btn">
                                <h3 class="mycours-list-item-btn-text">Модуль 2 «Инструменты менеджера»</h3>
                            </button>
                            <section class="mycours-list-item_info">
                                <div class="mycours-list-item_info-container">
                                    <div class="mycours-list-item_info-item">
                                        <div class="mycours-list-item_info-item-video">
                                            <iframe width="170" height="91" src="https://www.youtube.com/embed/V24IuCFKgEI?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                        <h4 class="mycours-list-item_info-item-name">10.1 Инструменты</h4>
                                    </div>
                                    <div class="mycours-list-item_info-item">
                                        <div class="mycours-list-item_info-item-video">
                                            <iframe width="170" height="91" src="https://www.youtube.com/embed/V24IuCFKgEI?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                        <h4 class="mycours-list-item_info-item-name">10.1 Инструменты</h4>
                                    </div>
                                    <div class="mycours-list-item_info-item">
                                        <div class="mycours-list-item_info-item-video">
                                            <div class="mycours-list-item_info-item-video-locked">
                                                <p class="mycours-list-item_info-item-video-locked-tooltip">Урок будет доступен с 20.09.2021</p>
                                            </div>
    
                                            <iframe width="170" height="91" src="https://www.youtube.com/embed/V24IuCFKgEI?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                        <h4 class="mycours-list-item_info-item-name">10.1 Инструменты</h4>
                                    </div>
                                    <div class="mycours-list-item_info-item">
                                        <div class="mycours-list-item_info-item-video">
                                            <iframe width="170" height="91" src="https://www.youtube.com/embed/V24IuCFKgEI?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                        </div>
                                        <h4 class="mycours-list-item_info-item-name">10.1 Инструменты</h4>
                                    </div>
                                    <div class="mycours-list-item_info-item">
                                        <div class="mycours-list-item_info-item-bacground">
                                            <p>Задание</p>
                                        </div>
                                        <h4 class="mycours-list-item_info-item-status">Зачет</h4>
                                    </div>
                                </div>
                            </section>
                        </li>
                    </ul>
                </section>

                <div class="myprogramm-assistants myprogramm-list-item">
                    <h2 class="myprogramm-assistants-title">Ассистенты</h2>

                    <div class="myprogramm-assistants_row">
                        <div class="myprogramm-assistants_row_left">
                            <div class="myprogramm-assistants_row_left-img">
                                <img src="<?= Url::to('../img/skillclient/ico.svg') ?>" alt="assistent">
                            </div>
                            <p class="myprogramm-assistants_row_left-name">Марина Дьярова</p>
                        </div>
                        <div class="myprogramm-assistants_row_right">
                            <h3 class="myprogramm-assistants_row_right-title">
                            Задания для проверки
                            </h3>
                            <ul class="myprogramm-assistants_row_right_list">
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Инструменты
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Инструменты
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Инструменты
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Инструменты
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Инструменты
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Инструменты
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Инструменты
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Инструменты
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Инструменты
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Иu
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Инструменты
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Иu
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Инструменты
                                </li>
                            </ul>
                            <button style="text-decoration: none;" class="link--purple myprogramm-assistants_row_right_list-btn">Смотреть все</button>
                        </div>
                    </div>
                    <div class="myprogramm-assistants_row">
                        <div class="myprogramm-assistants_row_left">
                            <div class="myprogramm-assistants_row_left-img">
                                <img src="<?= Url::to('../img/skillclient/ico.svg') ?>" alt="assistent">
                            </div>
                            <p class="myprogramm-assistants_row_left-name">Марина Дьярова</p>
                        </div>
                        <div class="myprogramm-assistants_row_right">
                            <h3 class="myprogramm-assistants_row_right-title">
                            Задания для проверки
                            </h3>
                            <ul class="myprogramm-assistants_row_right_list">
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Инструменты
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Инструменты
                                </li>
                                <li class="myprogramm-assistants_row_right_list-item">
                                5.3 Иu
                                </li>
                            </ul>
                            <button style="text-decoration: none;" class="link--purple myprogramm-assistants_row_right_list-btn" href="<?= Url::to(['']) ?>">Смотреть все</button>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="cours-progress">
                <h3 class="cours-progress-title">
                Информация о курсе
                </h3>
                <div class="mpaside-row">
                    <h4 class="mpaside-subtitle">количество активных студентов</h4>
                    <p class="mpaside-text">200</p>
                </div>
                <div class="mpaside-row">
                    <h4 class="mpaside-subtitle">Прошли курс</h4>
                    <p class="mpaside-text">50</p>
                </div>
                <div class="mpaside-row">
                    <h4 class="mpaside-subtitle">Не закончили курс</h4>
                    <p class="mpaside-text">30</p>
                </div>
                <div class="mpaside-row">
                    <h4 class="mpaside-subtitle">Стоимость</h4>
                    <p class="mpaside-text">32 900₽</p>
                </div>
                <div class="mpaside-row">
                    <h4 class="mpaside-subtitle">Доступ к программе</h4>
                    <a href="<?= Url::to(['']) ?>" class="link--purple">скопировать ссылку</a>
                </div>
                <div class="mpaside-row">
                    <h4 class="mpaside-subtitle">Дата запуска</h4>
                    <p class="mpaside-text">23.09.2020</p>
                </div>
                <div class="mpaside-row">
                    <h4 class="mpaside-subtitle">Сертификат</h4>
                    <p class="mpaside-text">Есть</p>
                </div>
                <a href="<?= Url::to(['']) ?>" class="link--purple" style="text-decoration: none;">Редактировать курс</a>
            </aside>
        </div>

        <footer class="footer">
        <div class="">
            <a href="<?= Url::to(['manual']) ?>" class="footer__link">
                Руководство пользователя
            </a>
            <a href="<?= Url::to(['support']) ?>" class="footer__link">
                Тех.поддержка
            </a>
        </div>
    </footer>
</section>