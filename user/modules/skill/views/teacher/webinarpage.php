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
      <p class="type-cours">вебинар</p>
      <div class="title_row">
        <h1 class="Bal-ttl title-main">Менеджер клиентского сервиса</h1>
       <div class="title_row_right-col">
            <p class="courses-direction yellow">Маркетинг</p>
            <p style="margin: 0px !important;" class="courses-date">Доступно всем</p>
       </div>
      </div>

      <section class="viewcours_main">
        <article class="viewcours_main_info">
            <section class="viewcours-card vebinar-open">
                <h3 class="vebinar-open-title">Трансляция открыта</h3>
                <h3 class="vebinar-open-title">Трансляция завершена</h3>
                <button class="btn--purple vebinar-open-btn" type="button">Провести вебинар</button>
                <button style="max-width: fit-content;" class="btn--purple vebinar-open-btn" type="button">Сделать автовебинаром</button>
            </section>

            <section class="schedule-autowebinar viewcours-card vebinar-open">
                <h3 class="vebinar-open-title">Расписание автовебинара</h3>
                <div class="schedule-autowebinar_row">
                    <div class="schedule-autowebinar_row_item">
                        <p class="schedule-autowebinar_row_item-day">Пн</p>
                        <p class="schedule-autowebinar_row_item-time">16:30</p>
                    </div>
                    <div class="schedule-autowebinar_row_item">
                        <p class="schedule-autowebinar_row_item-day">Пн</p>
                        <p class="schedule-autowebinar_row_item-time">16:30</p>
                    </div>
                    <div class="schedule-autowebinar_row_item">
                        <p class="schedule-autowebinar_row_item-day">Пн</p>
                        <p class="schedule-autowebinar_row_item-time">16:30</p>
                    </div>
                    <div class="schedule-autowebinar_row_item">
                        <p class="schedule-autowebinar_row_item-day">Пн</p>
                        <p class="schedule-autowebinar_row_item-time">16:30</p>
                    </div>
                    <div class="schedule-autowebinar_row_item">
                        <p class="schedule-autowebinar_row_item-day">Пн</p>
                        <p class="schedule-autowebinar_row_item-time">16:30</p>
                    </div>
                    <div class="schedule-autowebinar_row_item">
                        <p class="schedule-autowebinar_row_item-day">Пн</p>
                        <p class="schedule-autowebinar_row_item-time">16:30</p>
                    </div>
                    <div class="schedule-autowebinar_row_item">
                        <p class="schedule-autowebinar_row_item-day">Пн</p>
                        <p class="schedule-autowebinar_row_item-time">16:30</p>
                    </div>
                </div>
                <a href="<?= Url::to(['']) ?>" class="link--purple" style="text-decoration: none;">Редактировать расписание</a>
            </section>

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
            <section class="lecture-materials viewcours-card">
                <div class="lecture-materials_top">
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
                </div>
                <div class="lecture-materials_main">
                    <div class="lecture-materials_main_row">
                        <p class="lecture-materials_main_row-title">Модераторы</p>
                        <ul class="myprogramm-assistants_row_right_list lecture-materials_main-list">
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                        </ul>
                        <button style="text-decoration: none;" class="link--purple lecture-materials_main-btn">Смотреть все</button>
                        <button style="text-decoration: none; display:none;" class="link--purple lecture-materials_main-btn-close">Скрыть</button>
                    </div>
                    <div class="lecture-materials_main_row">
                        <p class="lecture-materials_main_row-title">Модераторы</p>
                        <ul class="myprogramm-assistants_row_right_list lecture-materials_main-list">
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main-list-item">
                                Ирина Ивановская
                            </li>
                        </ul>
                        <button style="text-decoration: none;" class="link--purple lecture-materials_main-btn">Смотреть все</button>
                        <button style="text-decoration: none; display:none;" class="link--purple lecture-materials_main-btn-close">Скрыть</button>
                    </div>
                    <div class="lecture-materials_main_row">
                        <p class="lecture-materials_main_row-title">Модераторы</p>
                        <ul class="myprogramm-assistants_row_right_list lecture-materials_main_row-list">
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main_row-list-item">
                                Баннер
                                <button style="text-decoration: none;" class="link--purple">Предпросмотр</button>
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main_row-list-item">
                            Кнопка
                                <button style="text-decoration: none;" class="link--purple">Предпросмотр</button>
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main_row-list-item">
                            Кнопка
                                <button style="text-decoration: none;" class="link--purple">Предпросмотр</button>
                            </li>
                            <li class="myprogramm-assistants_row_right_list-item lecture-materials_main_row-list-item">
                                Баннер
                                <button style="text-decoration: none;" class="link--purple">Предпросмотр</button>
                            </li>
                        </ul>
                    </div>
                    <div class="lecture-materials_main_row">
                        <div class="lecture-materials_main_row-item-group">
                            <div class="lecture-materials_main_row-item">
                                <p class="lecture-materials_main_row-title">Модераторы</p>
                                <p class="lecture-materials_main_row-item-text">таймер + картинка</p>
                                <button style="text-decoration: none;" class="link--purple">Предпросмотр</button>
                            </div>
                            <div class="lecture-materials_main_row-item">
                                <p class="lecture-materials_main_row-title">Ссылка после трансляции</p>
                                <p class="lecture-materials_main_row-item-text">http//:jkfdvndfjkv.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </article>
        <aside class="cours-progress webinar-info">
                <h3 class="cours-progress-title">
                Информация о вебинаре
                </h3>
                <div class="mpaside-row">
                    <h4 class="mpaside-subtitle">Прошли курс</h4>
                    <p class="mpaside-text">50</p>
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
                <a href="<?= Url::to(['']) ?>" class="link--purple" style="text-decoration: none;">Редактировать вебинар</a>
            </aside>
    </section>

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