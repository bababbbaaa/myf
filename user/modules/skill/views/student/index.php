<?php

use yii\helpers\Url;
use user\modules\skill\controllers\StudentController;
use common\models\UsersNotice;
use common\models\helpers\UrlHelper;

$this->title = 'Главная';
?>

<section class="rightInfo">
    <article class="mainpage">
        <?php if (!StudentController::fullInfo($client)) : ?>
            <section class="card-notif card-notif-1">
                <button type="button" class="close card-notif-close">×</button>
                <h2 class="card-notif-text">
                    Пожалуйста, заполните данные профиля, чтобы получить доступ к пополнению баланса
                </h2>
                <a href="<?= Url::to(['profile']) ?>" class="card-notif-link btn--purple">Перейти в профиль</a>
            </section>
        <?php endif; ?>
        <?php if (!empty($notice)): ?>
            <?php foreach ($notice as $k => $v): ?>
                <?php if ($v['type'] = UsersNotice::TYPE_MAINPAGE_MODERATION): ?>
                    <section class="card-notif card-notif-green card-notif-3">
                        <button type="button" class="close card-notif-close">×</button>
                        <h2 class="card-notif-text card-notif-text-title">
                            Решение проверено
                            <br>
                            <p class="card-notif-text-info">Решение к заданию №5 курса “Менеджер первичного контакта”
                                проверено</p>
                        </h2>
                        <a href="<?= Url::to(['']) ?>" class="card-notif-link btn--purple">Перейти к заданию</a>
                    </section>
                <?php else: ?>
                    <section class="card-notif card-notif-5">
                        <button type="button" class="close card-notif-close">×</button>
                        <h2 class="card-notif-text card-notif-text-title">
                            Вебинар начался
                            <br>
                            <p class="card-notif-text-info">Вебинар “Как начать зарабатывать” уже идет. Присоединяйтесь
                                к трансляции</p>
                        </h2>
                        <a href="<?= Url::to(['']) ?>" class="card-notif-link btn--purple">Смотреть вебинар</a>
                    </section>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="mainpage_wrapper">
            <div class="mainpage_column">
                <section class="mainpage_column-item mainpage_column-item-balance">
                    <div class="mainpage_column-item_container">
                        <h2 class="mainpage_column-item-title">
                            Баланс
                        </h2>
                        <p class="mainpage_column-item-balance-baclance"><?= number_format($user_info['budget'], 0, ' ', ' ') ?>
                            ₽</p>
                        <a class="link--purple" href="<?= Url::to(['balance']) ?>">Пополнить</a>
                    </div>
                </section>
                <?php if (!empty($freeWeb)): ?>
                    <section class="mainpage_column-item mainpage_column-item-free">
                        <div class="mainpage_column-item_container">
                            <h2 class="mainpage_column-item-title">
                                Смотрите бесплатное занятие
                            </h2>
                            <?php foreach ($freeWeb as $k => $v): ?>
                                <div class="mainpage_column-item-free_row">
                                    <div class="mainpage_column-item-free_row_left">
                                        <p class="mainpage_column-item-free_row_left-type">Маркетинг</p>
                                        <h3 class="mainpage_column-item-free_row_left-title">
                                            <?= $v->name ?>
                                        </h3>
                                        <p class="mainpage_column-item-free_row-date">
                                            <?= date('d.m.Y H:i', strtotime($v->date_meetup)) ?>
                                        </p>
                                        <a href="<?= Url::to(['']) ?>" class="btn--purple mainpage_column-item-link">Смотреть
                                            бесплатное занятие</a>
                                    </div>
                                    <div class="mainpage_column-item-free_row_right">
                                        <div class="mainpage_column-item-free_row_right-img">
                                            <img src="<?= UrlHelper::admin($v->author->photo) ?>" alt="portret">
                                        </div>
                                        <p class="mainpage_column-item-free_row_right-status">лектор</p>
                                        <p class="mainpage_column-item-free_row_right-name">
                                            <?= $v->author->name ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            </div>

            <aside class="next-meeting">
                <h3 class="next-meeting-title">
                    Предстоящие мероприятия
                </h3>

                    <ul class="next-meeting_list">
                <?php if (!empty($upcoming_events)): ?>
                        <?php foreach ($upcoming_events as $k => $v): ?>
                            <li class="next-meeting_list-item">
                                <div class="next-meeting_list-item_top">
                                    <p class="next-meeting_list-item_top-what-is">
                                        <?= $v['type'] ?>
                                    </p>
                                    <p class="next-meeting_list-item_top-date mainpage_column-item-free_row-date">
                                        <?= date('d.m.Y', strtotime($v['date_meetup'])) ?>
                                    </p>
                                </div>
                                <h4 class="next-meeting_list-item-title"><?= $v['name'] ?></h4>
                                <div class="next-meeting_list-item_row">
                                    <p class="next-meeting_list-item_row-prise">
                                        Стоимость участия
                                    </p>
                                    <p class="next-meeting_list-item_row-num">
                                        <?= $v['price'] ?>₽
                                    </p>
                                </div>
                                <a class="link--purple" href="<?= Url::to(['']) ?>">Смотреть вебинар</a>
                            </li>
                        <?php endforeach; ?>
                <?php else: ?>
                    <li class="next-meeting_list-item">
                        <h4 style="color: grey" class="next-meeting_list-item-title">Тут вы будете видеть уведомления о предстоящих мероприятиях</h4>
                    </li>
                <?php endif; ?>
                    </ul>

            </aside>
        </div>
    </article>
</section>