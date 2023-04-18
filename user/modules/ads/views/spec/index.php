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
                <h2 class="card-notif-text card-notif-title">
                    Проект приостановлен
                </h2>
                <p class="card-notif-txt">Пожалуйста, заполните данные профиля, чтобы получить доступ к пополнению баланса</p>
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
                        <a class="link--purple" href="<?= Url::to(['balance']) ?>">Вывести средства</a>
                    </div>
                </section>
                <section class="mainpage_column-item">

                    <h2 class="mainpage_column-item-title">
                        Ваш статус в этом месяце
                    </h2>
                    <div class="mainpage_column-lider">
                        <img style="max-width: 76px;" src="<?= Url::to('/img/afo/lider.png') ?>" alt="эксперт">
                        <p>эксперт</p>
                    </div>
                    <p class="mainpage_column-lider-ttl">Вам доступны бонусы</p>
                    <div class="mainpage_column-lider-group">
                        <div class="mainpage_column-lider-group-item">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M12.4135 17.8812L17.1419 20.8769C17.7463 21.2598 18.4967 20.6903 18.3173 19.9847L16.9512 14.6108C16.9127 14.4611 16.9173 14.3036 16.9643 14.1564C17.0114 14.0092 17.0991 13.8783 17.2172 13.7787L21.4573 10.2496C22.0144 9.78588 21.7269 8.86126 21.0111 8.81481L15.4738 8.45544C15.3247 8.44479 15.1816 8.39198 15.0613 8.30317C14.941 8.21437 14.8484 8.09321 14.7943 7.95382L12.7292 2.75323C12.673 2.60528 12.5732 2.4779 12.443 2.38802C12.3127 2.29814 12.1582 2.25 12 2.25C11.8418 2.25 11.6873 2.29814 11.557 2.38802C11.4268 2.4779 11.327 2.60528 11.2708 2.75323L9.20568 7.95382C9.15157 8.09321 9.05897 8.21437 8.93868 8.30317C8.81838 8.39198 8.67533 8.44479 8.52618 8.45544L2.98894 8.81481C2.27315 8.86126 1.9856 9.78588 2.54272 10.2496L6.78278 13.7787C6.90095 13.8783 6.9886 14.0092 7.03566 14.1564C7.08272 14.3036 7.08727 14.4611 7.0488 14.6108L5.78188 19.5945C5.56667 20.4412 6.46715 21.1246 7.19243 20.6651L11.5865 17.8812C11.71 17.8025 11.8535 17.7607 12 17.7607C12.1465 17.7607 12.29 17.8025 12.4135 17.8812V17.8812Z" stroke="#EB38D2" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <p>+30 бонусов за каждый выполненный заказ с оценкой 5</p>
                        </div>
                        <div class="mainpage_column-lider-group-item">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_1296_54312)"><path fill-rule="evenodd" clip-rule="evenodd" d="M12.3255 8.3645C13.7175 6.482 15.2565 5 17.2245 5C20.94 5 24 9.7295 24.0015 15.3605C24.0015 18.7955 22.5225 20.948 19.866 20.948C17.5515 20.948 16.2735 19.649 13.98 15.812L12.9795 14.1275L12.8025 13.832C12.5416 13.391 12.2766 12.9525 12.0075 12.5165L10.2405 15.6365C7.731 20.024 6.318 20.948 4.356 20.948C1.629 20.948 0 18.8255 0 15.4595C0 10.082 2.9925 5 6.897 5C7.3755 5 7.8345 5.0585 8.283 5.183C8.748 5.312 9.1995 5.513 9.6525 5.7935C10.518 6.332 11.3835 7.166 12.3255 8.3645ZM14.5995 11.7005C14.2215 11.0855 13.8585 10.52 13.509 10.001L13.5 9.989C14.7675 8.0315 15.8145 7.058 17.058 7.058C19.6425 7.058 21.711 10.8635 21.711 15.5375C21.711 17.3195 21.126 18.353 19.9185 18.353C18.759 18.353 18.2055 17.588 16.0035 14.048L14.598 11.7005H14.5995ZM7.269 7.634C8.3565 7.784 9.3465 8.585 10.779 10.6355C9.95245 11.9012 9.13493 13.1727 8.3265 14.45C6.291 17.639 5.5875 18.3545 4.455 18.3545C3.2895 18.3545 2.595 17.3315 2.595 15.5045C2.595 11.6015 4.542 7.6085 6.864 7.6085C7.0005 7.6085 7.1355 7.6175 7.269 7.6355V7.634Z" fill="#EB38D2"/></g><defs><clipPath id="clip0_1296_54312"><rect width="24" height="24" fill="white"/></clipPath></defs></svg>
                            <p>Индивидуальное продвижение в соц.сетях</p>
                        </div>
                    </div>
                    <a class="link--purple" href="<?= Url::to(['bonuses']) ?>">Посмотреть все бонусы</a>

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
                                <a class="link--purple" href="<?= Url::to(['orders']) ?>">Посмотреть все заказы</a>
                            <?php endforeach; ?>
                            
                        <?php else: ?>
                            <li style="align-items: center; text-align: center;" class="next-meeting_list-item">
                                <img style="margin-bottom: 12px; max-width: 204px;" src="<?= Url::to('/img/afo/mlb.png') ?>" alt="">
                                <h4 style="color: grey" class="next-meeting_list-item-title">Сюда мы будем выводить информацию о ваших активных заказах</h4>
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
                                    <p class="next-meeting_list-item-top-summ"></p>
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
                            <img style="margin-bottom: 12px;" src="<?= Url::to('/img/afo/mlb2.png') ?>" alt="">
                            <h4 style="color: grey" class="next-meeting_list-item-title">Здесь будут отображаться движения средств на балансе личного кабинета</h4>
                        </li>
                    <?php endif; ?>
                </ul>
            </section>
        </div>
    </article>

    <footer class="footer">
        <div class="container container--body">
            <a href="<?= Url::to(['manual']) ?>" class="footer__link">
                Руководство пользователя
            </a>
            <a href="<?= Url::to(['support']) ?>" class="footer__link">
                Тех.поддержка
            </a>
        </div>
    </footer>
</section>