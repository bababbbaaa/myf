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
                <section class="mainpage_column-item">
                    <h2 class="mainpage_column-item-title">
                        Мои проекты
                    </h2>
                    <ul class="mainpage_column-item_list">
                        <?php if (!empty($project)): ?>
                            <?php foreach ($project as $v): ?>
                                <li class="mainpage_column-item_list-item">
                                    <div class="mainpage_column-item_list-item_left">
                                        <p class="mainpage_column-item_list-item_left-title"><?= $v['name'] ?></p>
                                        <p class="mainpage_column-item_list-item_left-type"><?= $v['type'] ?></p>
                                    </div>
                                    <?php switch ($v['status']){
                                        case 'Выполнен':
                                            $color = 'blue';
                                            break;
                                        case 'Модерация':
                                            $color = 'orange';
                                            break;
                                        case 'В работе':
                                            $color = 'green';
                                            break;
                                        case 'Остановлен':
                                            $color = 'red';
                                            break;
                                    } ?>
                                    <div class="activeproject-status <?= $color ?> courses_item_top-name">
                                        <div class="activeproject-status-point"></div>
                                        <span><?= $v['status'] ?></span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                            <a class="link--purple" href="<?= Url::to(['myprojects']) ?>">Посмотреть все проекты</a>
                        <?php else: ?>
                            <li style="align-items: center; text-align: center;" class="next-meeting_list-item">
                                <img style="margin-bottom: 12px;" src="<?= Url::to('/img/dev/mlb.png') ?>" alt="">
                                <h4 style="color: grey" class="next-meeting_list-item-title">Здесь будут отображаться
                                    ваши активные проекты</h4>
                            </li>
                        <?php endif; ?>
                    </ul>
                </section>
            </div>

            <section class="next-meeting">
                <h3 class="next-meeting-title">
                    Последние транзакции
                </h3>
                <ul class="next-meeting_list">
                    <?php if (!empty($budget_log)): ?>
                        <?php foreach ($budget_log as $k => $v): ?>
                            <li class="next-meeting_list-item">
                                <div class="next-meeting_list-item-top">
                                    <p class="next-meeting_list-item-top-name"><?= $v['text'] ?></p>
                                </div>
                                <div class="next-meeting_list-item-bottom">
                                    <p class="next-meeting_list-item-bottom-date"><?= date('d.m.Y', strtotime($v['date'])) ?></p>
                                    <p class="next-meeting_list-item-bottom-date"><?= date('h:i', strtotime($v['date'])) ?></p>
                                </div>
                            </li>
                        <?php endforeach; ?>
                        <a class="link--purple" href="<?= Url::to(['balance']) ?>">Посмотреть все транзакции</a>
                    <?php else: ?>
                        <li style="align-items: center; text-align: center;" class="next-meeting_list-item">
                            <img style="margin-bottom: 12px;" src="<?= Url::to('/img/dev/mlb.png') ?>" alt="">
                            <h4 style="color: grey" class="next-meeting_list-item-title">Здесь будут отображаться
                                движения средств на балансе личного кабинета</h4>
                        </li>
                    <?php endif; ?>
                </ul>
            </section>
        </div>
    </article>
</section>