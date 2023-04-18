<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\helpers\UrlHelper;

$this->title = $course->name;

$js = <<< JS
$('.get__course').on('click', function() {
  var id = '$course->id';
    Swal.fire({
    icon: 'info',
    title: 'Добавить курс',
    text: 'Вы желаете добавить себе этот курс?',
    showCloseButton: true,
    showCancelButton: true,
    cancelButtonText:'Отмена',
  }).then(function(result) {
    if (result.value === true){
      $.ajax({
        url: '/skill/student/buy-course',
        data: {id:id},
        type: 'POST',
        dataType: 'JSON',
      }).done(function(rsp) {
        console.log(rsp);
        if (rsp.status === 'success'){
            location.href = 'education';
        } else {
            Swal.fire({
            icon: 'error',
            title: 'Ошибка',
            text: rsp.message,
            });
        }
      });
    }
});
    });
JS;
$this->registerJsFile(Yii::$app->request->baseUrl . '/js/alert.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJs($js);

?>

<section class="rightInfo education coursepage">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <a href="<?= Url::to(['education']) ?>" class="bcr__link">
                    Моё обучение
                </a>
            </li>

            <li class="bcr__item">
                <a href="<?= Url::to(['programs']) ?>" class="bcr__link">
                    Выбрать программу
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
                <?php if ($course->discount > 0 && $course->discount_expiration_date > date('Y-m-d H:i:s')) : ?>
                    <p class="courses-discount">-<?= $course->discount ?>%
                        до <?= date('d.m', strtotime($course->discount_expiration_date)) ?></p>
                <?php endif; ?>
                <p class="courses-direction yellow"><?= $course->category->name ?></p>
                <?php if ($course->price == 0) : ?>
                    <p class="mycours_top-left-freecourse vebipage_top-left-freecourse">Бесплато</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="vebinar_prev-block">
        <div class="vebinar-prev-text">
            <?= $course->content_about ?>
        </div>


        <?php if ($course->price > 0) : ?>
            <div class="vebinar_prev-block_right">
                <p class="vebinar_prev-block_right-price">
                    <?php if ($course->discount == 0 || $course->discount_expiration_date < date('Y-m-d H:i:s')) : ?>
                        <?= number_format($course->price, 0, ' ', ' ') ?>₽
                    <?php else : ?>
                        <?= number_format($course->price - (($course->price * $course->discount) / 100), 0, ' ', ' ') ?>₽
                    <?php endif; ?>
                </p>

                <?php if ($course->discount > 0 && $course->discount_expiration_date > date('Y-m-d H:i:s')) : ?>
                    <p class="vebinar_prev-block_right-price-none">
                        <?= number_format(($course->price * $course->discount) / 100, 0, ' ', ' ') ?>₽
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="course-buy_time">
        <div class="course-buy_time_left">
            <p class="course-buy_time-title">
                Продолжительность
            </p>
            <p class="course-buy_time-subtitle">
                <?= $course->study_hours ?> часов обучения
            </p>
        </div>
        <div class="course-buy_time_right">
            <p class="course-buy_time-title">
                Старт курса
            </p>
            <p class="course-buy_time-subtitle">
                <?= date('d.m.Y', strtotime($course->date_meetup)) ?>
            </p>
        </div>
    </div>

    <?php if ($course->price > 0) : ?>
        <a class="btn--purple vebinar-buy get__course">Купить курс</a>
    <?php else : ?>
        <a class="btn--purple vebinar-buy get__course">Начать обучение</a>
    <?php endif; ?>

    <section class="viewcours_main">
        <article class="viewcours_main_info">
            <section class="benefits__course">
                <h3 class="benefits__course-headText">Чему вы научитесь</h3>
                <div class="benefits__course-block">
                    <?php foreach (json_decode($course->content_what_study, true) as $k => $v) : ?>
                        <div class="benefits__course-item benefits__item">
                            <div class="benefits__item-image benefits__item-image-<?= $k + 1 ?>"></div>
                            <p class="benefits__item-title"><?= $v['title'] ?></p>
                            <p class="benefits__item-subtitle"><?= $v['text'] ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <?php if (!empty($course->free_lessons)) : ?>
                <section class="viewcours-video viewcours-card">
                    <h3 class="first__lessons--free">Смотрите первый урок бесплатно</h3>
                    <?php parse_str($new = parse_url($course->free_lessons, PHP_URL_QUERY), $link); ?>
                    <div class="viewcours-video_video">
                        <iframe src="https://www.youtube.com/embed/<?= $link['v'] ?>" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <a class="btn--purple vebinar-buy get__course">Продолжить обучение</a>
                </section>
            <?php endif; ?>
            <?php if (!empty($course->skillTrainingsBlocks)) : ?>
                <section class="mycours viewcours-card">
                    <h2 class="mycours-title">
                        Программа курса
                    </h2>
                    <ul class="mycours-list">
                        <?php foreach ($course->skillTrainingsBlocks as $k => $v) : ?>
                            <li class="mycours-list-item">
                                <button type="button" class="mycours-list-item-btn">
                                    <h3 class="mycours-list-item-btn-text">Модуль <?= $k + 1 ?> «<?= $v->name ?>»</h3>
                                </button>
                                <section class="mycours-list-item_info">
                                    <?php if (!empty($v->skillTrainingsLessons)) : ?>
                                        <?php foreach ($v->skillTrainingsLessons as $ket => $i) : ?>
                                            <div class="mycours-list-item_info-close-item">
                                                &bull; <?= $i['name'] ?></div>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </section>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </section>
            <?php endif; ?>
        </article>
        <aside class="course-buy_aside">
            <?php if (!empty($course->content_block_income)) : ?>
                <div class="profit__course course-buy_aside-item">
                    <svg width="32" height="25" viewBox="0 0 32 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 23.8928V0.5C0 0.223858 0.223858 0 0.5 0H12.5C12.7761 0 13 0.223858 13 0.5V13.3159C13 13.4594 12.9383 13.596 12.8306 13.691L0.830612 24.2679C0.507706 24.5525 0 24.3232 0 23.8928Z" fill="#FFDC36" />
                        <path d="M19 23.8928V0.5C19 0.223858 19.2239 0 19.5 0H31.5C31.7761 0 32 0.223858 32 0.5V13.3159C32 13.4594 31.9383 13.596 31.8306 13.691L19.8306 24.2679C19.5077 24.5525 19 24.3232 19 23.8928Z" fill="#FFDC36" />
                    </svg>
                    <p style="font-size: <?= $course->content_block_income > 99999 ? '38px' : '' ?>;" class="profit__course-price"><?= number_format($course->content_block_income, 0, ' ', ' ') ?> ₽</p>
                    <p class="profit__course-title">В среднем зарабатывает специалист данной ниши в месяц</p>
                    <?php $cor = json_encode($_REQUEST, JSON_UNESCAPED_UNICODE) ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($course->author)) : ?>
                <div class="autor__cource">
                    <p class="autor__cource-title">Автор курса</p>
                    <img class="autor__cource-image" src="<?= UrlHelper::admin($course->author->photo) ?>" alt="<?= $course->author->name ?>">
                    <h4 class="autor__cource-name"><?= $course->author->name ?></h4>
                    <div class="autor__cource-description"><?= $course->author->small_description ?></div>
                    <?php if (!empty($course->author->specs)) : ?>
                        <?php $specs = json_decode($course->author->specs, 1) ?>
                        <p class="autor__cource-speck">Специализация:</p>
                        <?php foreach ($specs as $k => $v) : ?>
                            <p class="autor__cource-speck-item">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15.2008 7.99999C15.2008 11.9764 11.9772 15.2 8.00078 15.2C4.02434 15.2 0.800781 11.9764 0.800781 7.99999C0.800781 4.02354 4.02434 0.799988 8.00078 0.799988C11.9772 0.799988 15.2008 4.02354 15.2008 7.99999ZM11.4539 5.94056C11.7718 5.48889 11.6633 4.86509 11.2116 4.54726C10.7599 4.22942 10.1361 4.33791 9.81831 4.78957L6.80031 9.07831L5.78674 8.04599C5.39981 7.6519 4.76668 7.6461 4.37259 8.03302C3.9785 8.41995 3.97269 9.05309 4.35962 9.44718L6.21393 11.3358C6.42186 11.5476 6.71311 11.6561 7.00891 11.6319C7.30472 11.6077 7.5745 11.4534 7.7453 11.2107L11.4539 5.94056Z" fill="#D60BC8" />
                                </svg>
                                <?= $v ?>
                            </p>
                        <?php endforeach; ?>
                    <?php endif; ?>

                </div>
            <?php endif; ?>

            <?php if (!empty($course->skillTrainingsTeachers)) : ?>
                <div class="vebinar-speakers course-buy_aside-item">
                    <h3 class="vebinar-speakers-title">
                        Преподаватели
                    </h3>
                    <ul class="vebinar-speakers-group">
                        <?php foreach ($course->skillTrainingsTeachers as $k => $v) : ?>
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
                </div>
            <?php endif; ?>
            <?php if (count($course->skillTrainingsLessons) > 0 || count($course->skillTrainingsTasks) > 0 || count($course->skillTrainingsTests) > 0) : ?>
                <div class="course-buy_about course-buy_aside-item">
                    <h3 class="vebinar-speakers-title">
                        О курсе
                    </h3>
                    <ul class="course-buy_about-list">
                        <?php if (count($course->skillTrainingsLessons) > 0) : ?>
                            <li class="course-buy_about-list-item">
                                <p><span><?= count($course->skillTrainingsLessons) ?></span> уроков</p>
                            </li>
                        <?php endif; ?>
                        <?php if (count($course->skillTrainingsTasks) > 0) : ?>
                            <li class="course-buy_about-list-item">
                                <p><span><?= count($course->skillTrainingsTasks) ?></span> тестов</p>
                            </li>
                        <?php endif; ?>
                        <?php if (count($course->skillTrainingsTests) > 0) : ?>
                            <li class="course-buy_about-list-item">
                                <p><span><?= count($course->skillTrainingsTests) ?></span> заданий</p>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </aside>
    </section>
</section>