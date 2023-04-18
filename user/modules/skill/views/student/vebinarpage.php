<?php

use common\models\helpers\UrlHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = $veb->name;

$js = <<< JS
$('.get__course').on('click', function() {
  var id = '$veb->id';
    Swal.fire({
    icon: 'info',
    title: 'Добавить курс',
    text: 'Вы желаете добавить себе этот курс?',
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

<section class="rightInfo education">
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
                <span class="bcr__span nowpagebrc"><?= $veb->name ?></span>
            </li>
        </ul>
    </div>
    <p class="type-cours"><?= $veb->type ?></p>
    <div class="title_row">
        <h1 class="Bal-ttl title-main"><?= $veb->name ?></h1>
        <div class="title_row_right">
            <div class="title_row_right_top">
                <?php if ($veb->discount > 0 && $veb->discount_expiration_date > date('Y-m-d H:i:s')): ?>
                    <p class="courses-discount">-<?= $veb->discount ?>%
                        до <?= date('d.m', strtotime($veb->discount_expiration_date)) ?></p>
                <?php endif; ?>
                <p class="courses-direction yellow"><?= $cat['name'] ?></p>
                <?php if ($veb->price == 0): ?>
                    <p class="mycours_top-left-freecourse vebipage_top-left-freecourse">Бесплато</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="vebinar_prev-block">
        <p class="vebinar-prev-text"><?= $veb->content_block_description ?></p>

        <?php if ($veb->price > 0): ?>
            <div class="vebinar_prev-block_right">
                <p class="vebinar_prev-block_right-price">
                    <?php if ($veb->discount == 0 || $veb->discount_expiration_date < date('Y-m-d H:i:s')): ?>
                        <?= number_format($veb->price, 0, ' ', ' ') ?>₽
                    <?php else: ?>
                        <?= number_format($veb->price - (($veb->price * $veb->discount) / 100), 0, ' ', ' ') ?>₽
                    <?php endif; ?>
                </p>

                <?php if ($veb->discount > 0 && $veb->discount_expiration_date > date('Y-m-d H:i:s')): ?>
                    <p class="vebinar_prev-block_right-price-none">
                        <?= number_format(($veb->price * $veb->discount) / 100, 0, ' ', ' ') ?>₽
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (date('d.m.Y H:i', strtotime($veb->date_meetup)) > date('d.m.Y H:i')): ?>
        <div class="date__start">
            <div class="date__start-item">
                <p class="date__start-item-title">Дата трансляции</p>
                <p class="date__start-item-info"><?= date('d.m.Y', strtotime($veb->date_meetup)) ?></p>
            </div>
            <div class="date__start-item">
                <p class="date__start-item-title">Время трансляции</p>
                <p class="date__start-item-info"><?= date('H:i', strtotime($veb->date_meetup)) ?></p>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($veb->price > 0): ?>
        <a class="get__course btn--purple vebinar-buy get__course">Купить вебинар</a>
    <?php endif; ?>
    <?php if ($veb->price == 0): ?>
        <a class="get__course btn--purple vebinar-buy get__course">Начать обучение</a>
    <?php endif; ?>

    <section class="viewcours_main">
        <article class="viewcours_main_info">
            <?php if ($veb->price == 0 && (date('d.m.Y') < date('d.m.Y', strtotime($veb->date_meetup)))): ?>
                <section class="viewcours-card vebinar-open">
                    <p class="vebinar-open-title">Трансляция открыта</p>
                    <button class="get__course btn--purple vebinar-open-btn get__course" type="button">Смотреть
                        вебинар
                    </button>
                </section>
            <?php endif; ?>

            <?php if (date('d.m.Y', strtotime($veb->date_meetup)) < date('d.m.Y') && $veb->price == 0): ?>
                <section class="vebinar-none viewcours-card">
                    <img src="<?= Url::to('/img/skillclient/education-none-curses.png') ?>" alt="">
                    <p class="vebinar-prev-text">Вебинар
                        состоится <?= date('d.m.Y', strtotime($veb->date_meetup)) ?></p>
                    <button class="btn--purple vebinar-notif-btn get__course" type="button">Напомнить о вебинаре
                    </button>

                    <!--                    <p class="vebinar-prev-text">Мы отправим вам напоминание о вебинаре на почту за сутки и за час до-->
                    <!--                        начала-->
                    <!--                        трансляции</p>-->
                </section>
            <?php endif; ?>

            <section class="vebinar_notif-pop-back">
                <div class="vebinar_notif-pop-wrap">
                    <div class="vebinar_notif-pop">
                        <button class="pop-close"></button>

                        <img src="<?= Url::to('/img/skillclient/nice-done.svg') ?>" alt="angle">
                        <h3 class="vebinar_notif-pop-title">Напоминание создано</h3>
                        <p class="vebinar_notif-pop-text">Мы отправим вам напоминание о вебинаре на почту за сутки и за
                            час до начала трансляции</p>
                        <button class="vebinar_notif-pop-btn btn--purple">Спасибо</button>
                    </div>
                </div>
            </section>

            <section class="viewcours-video viewcours-card">
                <?php if ($veb->price > 0 && date('d.m.Y') > date('d.m.Y', strtotime($veb->date_meetup))): ?>
                    <div class="viewcours-video_video">
                        <img src="<?= Url::to(['/img/skillclient/video.png']) ?>" alt="">
                    </div>
                <?php endif; ?>
                <?php if (!empty($veb->material)): ?>
                    <?php $material = json_decode($veb->material, 1) ?>
                    <?php if (count($material) > 0): ?>
                        <h3 class="viewcours-video-title">
                            Материалы к лекции
                        </h3>
                        <ul class="viewcours-video-list">
                            <?php foreach ($material as $k => $v): ?>
                                <li class="viewcours-video-list-item">
                                    <div class="viewcours-video-list-item_container">
                                        <p><?= $v['name'] ?></p>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                <?php endif; ?>
            </section>

            <!--            <section class="learning viewcours-card">-->
            <!--                <button class="learning-btn" type="button">-->
            <!--                    Материал для изучения-->
            <!--                </button>-->
            <!---->
            <!--                <div class="learning_info">-->
            <!--                    <div class="learning_info_container">-->
            <!--                        <p class="learning_info-text">Любую CRM-систему используют в качестве базового инструмента для-->
            <!--                            автоматизации бизнес-процессов. В систему, представляющую собой программное обеспечение,-->
            <!--                            оператор вводит все доступные сведения о заказчиках, используя готовые клиентские базы либо-->
            <!--                            вводя вручную информацию по каждому покупателю. Дальнейшая работа в программе позволяет-->
            <!--                            осуществлять целый ряд функций:-->
            <!--                            данные о клиентах можно группировать исходя из конкретных задач, например в одну группу-->
            <!--                            добавить клиентов, с которыми предстоит встреча или телефонный разговор, а в другую – тех, с-->
            <!--                            кем уже удалось пообщаться;-->
            <!--                            перемещать заказчиков с одной ступени воронки продаж на другую. Перевод сопровождается-->
            <!--                            получением подробной информации о сделке, включая итоговую сумму или причину остановки работ-->
            <!--                            по договору;-->
            <!--                            быстро формировать отчетность. Программа анализирует и создает отчеты, основываясь на-->
            <!--                            данных, которые ввел менеджер. Пользуясь этой функцией, менеджер имеет возможность дать-->
            <!--                            оценку своей работе и эффективности маркетинговых каналов, а также спрогнозировать сделки;-->
            <!--                            автоматизированная система управления – щелкнув мышью несколько раз, менеджер получает-->
            <!--                            возможность сформировать правильный документ и предоставить его руководителю в виде-->
            <!--                            отчета.</p>-->
            <!---->
            <!--                        <ul class="viewcours-video-list">-->
            <!--                            <li class="viewcours-video-list-item">-->
            <!--                                <div class="viewcours-video-list-item_container">-->
            <!--                                    <p>Презентация</p>-->
            <!--                                    <a class="link--purple" href="-->
            <? //= Url::to(['']) ?><!--">Скачать</a>-->
            <!--                                </div>-->
            <!--                            </li>-->
            <!--                            <li class="viewcours-video-list-item">-->
            <!--                                <div class="viewcours-video-list-item_container">-->
            <!--                                    <p>Чек-лист</p>-->
            <!--                                    <a class="link--purple" href="-->
            <? //= Url::to(['']) ?><!--">Скачать</a>-->
            <!--                                </div>-->
            <!--                            </li>-->
            <!--                            <li class="viewcours-video-list-item">-->
            <!--                                <div class="viewcours-video-list-item_container">-->
            <!--                                    <p>Инструкция</p>-->
            <!--                                    <a class="link--purple" href="-->
            <? //= Url::to(['']) ?><!--">Скачать</a>-->
            <!--                                </div>-->
            <!--                            </li>-->
            <!--                        </ul>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </section>-->
        </article>
        <?php if (!empty($veb->skillTrainingsTeachers)): ?>
            <aside class="vebinar-speakers">
                <h3 class="vebinar-speakers-title">
                    Спикеры
                </h3>
                <ul class="vebinar-speakers-group">
                    <?php foreach ($veb->skillTrainingsTeachers as $k => $v): ?>
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