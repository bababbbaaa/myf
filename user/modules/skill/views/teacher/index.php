<?php

use yii\helpers\Url;
use user\modules\skill\controllers\TeacherController;
use common\models\UsersNotice;

$this->title = 'Главная';
?>

<section class="rightInfo">
    <div class="cab__wrapp">
        <div class="cab__main">
            <?php if (!TeacherController::fullInfo($client)) :
                ?>
                <div class="mass mass--cab">
                    <div class="mass__content mass__content--cab">
                        <p class="mass__text">
                            Пожалуйста, заполните данные профиля, чтобы получить доступ к пополнению баланса
                        </p>
                        <a href="<?= Url::to(['prof']) ?>" style="max-width: fit-content;"
                           class="mass__link btn--purple">
                            Перейти в профиль
                        </a>
                        <span class="mass__close">
            <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.0732231 10.0585 -0.0732231 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.0732233 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.0732231 0.987437 -0.0732231 1.28033 0.21967L5.28553 4.22487Z"
                    fill="#FFA800"/>
            </svg>
          </span>
                    </div>
                </div>
            <?php endif;
            ?>
            <?php foreach ($notice as $k => $v) :
                ?>
                <?php if ($v->type !== UsersNotice::TYPE_MAINPAGE_MODERATION_SUCCESS) :
                ?>
                <div class="mass mass--prov">
                    <div class="mass__content mass__content--prov">
                        <p class="mass__title">Уведомление о проверке</p>
                        <p class="mass__text">Ваша программа “Маркетолог с нуля” проверяется модератором</p>
                        <span class="mass__close">
            <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.0732231 10.0585 -0.0732231 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.0732233 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.0732231 0.987437 -0.0732231 1.28033 0.21967L5.28553 4.22487Z"
                    fill="#A3CCF4"/>
            </svg>
          </span>
                    </div>
                </div>
            <?php else :
                ?>
                <div class="mass mass--zak">
                    <div class="mass__content mass__content--zak">
                        <p class="mass__title">Программа одобрена</p>
                        <p class="mass__text">Ваша программа “Маркетолог с нуля” одобрена модератором.</p>
                        <span class="mass__close">
            <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.0732231 10.0585 -0.0732231 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.0732233 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.0732231 0.987437 -0.0732231 1.28033 0.21967L5.28553 4.22487Z"
                    fill="#C1DFC9"/>
            </svg>
          </span>
                    </div>
                </div>
            <?php endif;
                ?>
            <?php endforeach;
            ?>


            <div class="cab__box">
                <article class="cab__item1 item mainpage_column-item-balance">
                    <div class="item__content">
                        <h2 class="item__title">
                            Баланс
                        </h2>
                        <?php if (!empty($user_info)): ?>
                            <span class="item__summ"><?= number_format($user_info['budget'], 2, ',', ' ') ?></span>
                        <?php endif; ?>
                        <?php if (TeacherController::fullInfo($client)) : ?>
                            <a class="link" href="<?= Url::to(['balance']) ?>">Получить средства</a>
                        <?php endif; ?>
                    </div>
                </article>
                <article class="cab__item2 item">
                    <h2 class="item__title">
                        Последние транзакции
                    </h2>
                    <?php if (empty($budget_log)) : ?>
                        <!-- Блок пустой -->
                        <div class="item__content2 item__content--tran">
                            <p class="item__info">
                                Здесь будут отображаться движения средств на балансе личного кабинета
                            </p>
                        </div>
                        <!-- / Блок пустой / -->
                    <?php else : ?>
                        <!-- Блок заполненный -->
                        <div class="item__content">
                            <?php foreach ($budget_log as $k => $v) : ?>
                                <div class="item__li">
                                    <div class="item__li-inner">
                                        <div class="item__li-box">
                                            <div class="item__li-box-row">
                                                <p class="item__li-text"><?= $v['text'] ?></p>
                                                <p class="item__li-text-price"><?= $v["budget"]?></p>
                                            </div>
                                            <span class="item__li-info"><?= date('d.m.Y', strtotime($v['date'])) ?></span>
                                            <span class="item__li-info"><?= date('h:i', strtotime($v['date'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                        </div>
                        <a href="<?= Url::to(['balance#page2']) ?>" class="item__link link">
                            Посмотреть все транзакции
                        </a>
                        <!-- / Блок заполненный / -->
                    <?php endif; ?>
                </article>
                <article class="cab__item3 item">
                    <h2 class="item__title">
                        Статистика
                    </h2>
                    <?php if ($count < 2) : ?>
                        <!-- Блок пустой -->
                        <div class="item__content2 item__content--stat">
                            <p class="item__info">
                                Сюда мы будем выводить вашу статистику личного кабинета за прошедшую неделю
                            </p>
                        </div>
                        <!-- / Блок пустой / -->
                    <?php else : ?>
                        <?php $this->registerJs($newJs); ?>
                        <!-- Блок заполненный -->
                        <canvas id="myChart" width="auto" height="200"></canvas>
                        <!-- / Блок заполненный / -->
                    <?php endif; ?>
                </article>
            </div>
        </div>
    </div>


    <div class="popup">
        <div class="popup__ov">
            <div class="popup__body">
                <div class="popup__content-1">
                    <div class="popup__text">
                        <p>Заполните данные профиля для получения доступа к пополнению баланса</p>
                        <a href="<?= Url::to(['prof']) ?>" class="link popup__link">
                            Перейти к заполнению
                        </a>
                    </div>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img/close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
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