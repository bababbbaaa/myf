<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\helpers\UrlHelper;

$this->title = $course->name;

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
                <span class="bcr__span nowpagebrc"><?= $course->name ?></span>
            </li>
        </ul>
    </div>
    <p class="type-cours"><?= $course->type ?></p>
    <div class="title_row">
        <h1 class="Bal-ttl title-main"><?= $course->name ?></h1>
        <div class="title_row_right">
            <div class="title_row_right_top">
                <?php $cat = \common\models\SkillTrainingsCategory::findOne(['id' => $course->category_id]) ?>
                <p class="courses-direction yellow"><?= $cat->name ?></p>
                <?php if ($course->price == 0): ?>
                    <p class="mycours_top-left-freecourse">Бесплатный вебинар</p>
                <?php endif; ?>
            </div>
            <?php if (!empty($course->date_end)): ?>
                <p class="courses-date">Доступно до <?= $course->date_end ?></p>
            <?php endif; ?>
        </div>
    </div>

    <div class="vebinar-prev-text"><?= $course->content_subtitle ?></div>

    <section class="viewcours_main">
        <article class="viewcours_main_info">

            <?php if (date('d.m.Y', strtotime($course->date_meetup)) > date('d.m.Y')): ?>
                <section class="vebinar-none viewcours-card">
                    <img src="<?= Url::to('/img/skillclient/education-none-curses.png') ?>" alt="">
                    <p class="vebinar-prev-text">Вебинар
                        состоится <?= date('d.m.Y', strtotime($course->date_meetup)) ?></p>
                    <button class="btn--purple vebinar-notif-btn" type="button">Напомнить о вебинаре</button>

                    <p class="vebinar-prev-text">Мы отправим вам напоминание о вебинаре на почту за сутки и за час до
                        начала трансляции</p>
                </section>

                <section class="vebinar_notif-pop-back">
                    <div class="vebinar_notif-pop-wrap">
                        <div class="vebinar_notif-pop">
                            <button class="pop-close"></button>

                            <img src="<?= Url::to('/img/skillclient/nice-done.svg') ?>" alt="angle">
                            <h3 class="vebinar_notif-pop-title">Напоминание создано</h3>
                            <p class="vebinar_notif-pop-text">Мы отправим вам напоминание о вебинаре на почту за сутки и
                                за час до начала трансляции</p>
                            <button class="vebinar_notif-pop-btn btn--purple">Спасибо</button>
                        </div>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (date('d.m.Y', strtotime($course->date_meetup)) < date('d.m.Y')): ?>
                <section class="viewcours-video viewcours-card">
                    <?php parse_str(parse_url($course->free_lessons, PHP_URL_QUERY), $video); ?>
                    <div class="viewcours-video_video">
                        <iframe src="https://www.youtube.com/embed/<?= $video['v'] ?>?controls=0" frameborder="0"
                                allowfullscreen></iframe>
                    </div>
                    <!--                <h3 class="viewcours-video-title">-->
                    <!--                    Материалы к лекции-->
                    <!--                </h3>-->
                    <!--                <ul class="viewcours-video-list">-->
                    <!--                    <li class="viewcours-video-list-item">-->
                    <!--                        <div class="viewcours-video-list-item_container">-->
                    <!--                            <p>Презентация</p>-->
                    <!--                            <a class="link--purple" href="-->
                    <? //= Url::to(['']) ?><!--">Скачать</a>-->
                    <!--                        </div>-->
                    <!--                    </li>-->
                    <!--                    <li class="viewcours-video-list-item">-->
                    <!--                        <div class="viewcours-video-list-item_container">-->
                    <!--                            <p>Чек-лист</p>-->
                    <!--                            <a class="link--purple" href="-->
                    <? //= Url::to(['']) ?><!--">Скачать</a>-->
                    <!--                        </div>-->
                    <!--                    </li>-->
                    <!--                    <li class="viewcours-video-list-item">-->
                    <!--                        <div class="viewcours-video-list-item_container">-->
                    <!--                            <p>Инструкция</p>-->
                    <!--                            <a class="link--purple" href="-->
                    <? //= Url::to(['']) ?><!--">Скачать</a>-->
                    <!--                        </div>-->
                    <!--                    </li>-->
                    <!--                </ul>-->
                </section>
            <?php endif; ?>

            <section class="learning viewcours-card">
                <button class="learning-btn" type="button">
                    Материал для изучения
                </button>

                <div class="learning_info">
                    <div class="learning_info_container">
                        <div class="learning_info-text"><?= $course->content_about ?></div>

                        <?php if (!empty($course->material)): ?>
                            <ul class="viewcours-video-list">
                                <?php foreach (json_decode($course->material, 1) as $k => $v): ?>
                                    <li class="viewcours-video-list-item">
                                        <div class="viewcours-video-list-item_container">
                                            <p><?= $v['name'] ?></p>
                                            <a class="link--purple" download="" href="<?= UrlHelper::admin($v['file']) ?>">Скачать</a>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            </section>
        </article>
        <?php if (!empty($course->skillTrainingsTeachers)): ?>
            <aside class="vebinar-speakers">
                <h3 class="vebinar-speakers-title">
                    Спикеры
                </h3>
                <ul class="vebinar-speakers-group">
                    <?php foreach ($course->skillTrainingsTeachers as $k => $v): ?>
                        <li class="vebinar-speakers-group-item">
                            <div class="vebinar-speakers-group-item-img">
                                <img src="<?= UrlHelper::admin($v['photo']) ?>" alt="<?= $v['name'] ?>">
                            </div>
                            <h4 class="vebinar-speakers-group-item-name">
                                <?= $v['name'] ?>
                            </h4>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>
        <?php endif; ?>
    </section>
</section>