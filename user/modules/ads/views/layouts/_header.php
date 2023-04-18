<?php

use common\models\UsersNotice;
use yii\helpers\Url;
use common\models\User;
use yii\widgets\Pjax;

$user = Yii::$app->getUser()->getId();

$user = User::find()->where(['id' => $user])->asArray()->one();
$notice = UsersNotice::find()->where(['user_id' => $user['id'], 'active' => 1])->orderBy('date desc')->all();
$bonusesInfo = \common\models\UsersBonuses::find()->where(['user_id' => $user])->asArray()->select('bonus_points')->one();

$js = <<< JS
    /* Notice */
    var LName = 0;
    $(".HeaderNotification").on('click', function () {
        if (LName == 0) {
            $(".Notice-Menu").addClass('menu-open');
            $(".Notice-Menu-Back").fadeIn(300);
            LName = 1;
        } else if (LName == 1) {
            $(".Notice-Menu").removeClass('menu-open');
            $(".Notice-Menu-Back").fadeOut(300);
            LName = 0;
            $.ajax({
                url: '/skill/student/read-notice',
                type: 'POST',
                dataType: 'JSON',
                data: {read:false}
            }).done(function(rsp) {
                $.pjax.reload({container: '#noticeContainer',});
            })
        }
    });
    /* Notice */
JS;

$this->registerJs($js);
?>

<header class="HS df">
    <div class="Hcont df jcsb">
        <div class="Hcont_L">
            <a href="<?= Url::to(['index']) ?>">
                <img style="max-width: 130px;" src="<?= Url::to(['/img/afo/ads-logo.png']) ?>" alt="logo">
            </a>
        </div>
        <div class="Hcont_R df aic jcsb">
            <div class="Wrapburgbal df aic">
                <img class="BURGER-BTN" src="<?= Url::to(['/img/Fburg.svg']) ?>" alt="Бургер">
                <a href="<?= Url::to(['balance']) ?>" class="Hcont_R_Balance uscp df aic jcsb">
                    <img src="<?= Url::to(['/img/money.png']) ?>" alt="Деньги">
                    <p class="HText Hcont_R_Balance-t">Баланс: <span><?= number_format($user['budget'], 2, ',', ' ') ?> ₽</span>
                    </p>
                </a>
            </div>

            <div class="Hcont_R_R df aic">
                <div class="Hcont_R_R-Name">
                    <p class="Hcont_R_R-Name-t MText uscp"><?= $user['username'] ?></p>
                    <div class="User-Menu">
                        <div class="User-Menu-cont df fdc">
                            <a href="<?= Url::to(['profile', '#' => 'item3']) ?>" class="User-Menu-b df aic">
                                <img src="<?= Url::to(['/img/setting.png']) ?>" alt="Шестерёнка">
                                <p class="User-Menu-b-t">Сменить пароль</p>
                            </a>
                            <a href="<?= Url::to(['support']) ?>" class="User-Menu-b df aic">
                                <img src="<?= Url::to(['/img/chat.png']) ?>" alt="Чат">
                                <p class="User-Menu-b-t">Чат тех.поддержки</p>
                            </a>
                            <a href="<?= Url::to(['/logout']) ?>" class="User-Menu-b df aic">
                                <img src="<?= Url::to(['/img/exit.png']) ?>" alt="Выйти">
                                <p class="User-Menu-b-t User-Menu-b3-t">Выйти</p>
                            </a>
                        </div>
                    </div>
                    <div class="User-Menu-Back"></div>
                </div>
                <div class="Hcont_R_R-AddZ df jcsb aic">
                    <div class="HeaderNotification uscp">
                        <?php Pjax::begin(['id' => 'noticeContainer']) ?>
                        <img class="HeaderNotif" src="<?= Url::to(['/img/notif.svg']) ?>" alt="Уведомления">
                        <p class="Notif-Num"><?= count($notice) ?></p>
                        <div class="Notice-Menu">
                            <div class="Notice-Menu-cont df fdc">
                                <?php if (!empty($notice)) : ?>
                                    <?php foreach ($notice as $v) : ?>
                                        <div class="Notice_block">
                                            <h5 class="Notice__type"><?= $v->type ?></h5>
                                            <p class="Notice__text"><?= $v->text ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="Notice_block">
                                        <h5 class="Notice__type">У Вас нет уведомлений</h5>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="Notice-Menu-Back"></div>
                        <?php Pjax::end() ?>
                    </div>
                </div>
                <div class="Hcont_R_R-AddZ df jcsb aic sec">
                    <div class="HeaderNotification uscp">
                        <?php Pjax::begin(['id' => 'noticeContainer']) ?>
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M4.125 5.25C3.50368 5.25 3 5.75368 3 6.375V17.625C3 18.2463 3.50368 18.75 4.125 18.75H19.875C20.4963 18.75 21 18.2463 21 17.625V6.375C21 5.75368 20.4963 5.25 19.875 5.25H4.125ZM1.5 6.375C1.5 4.92525 2.67525 3.75 4.125 3.75H19.875C21.3247 3.75 22.5 4.92525 22.5 6.375V17.625C22.5 19.0747 21.3247 20.25 19.875 20.25H4.125C2.67525 20.25 1.5 19.0747 1.5 17.625V6.375Z" fill="#5B617C"/><path fill-rule="evenodd" clip-rule="evenodd" d="M4.65799 7.03954C4.91229 6.71258 5.3835 6.65368 5.71046 6.90799L12 11.7999L18.2895 6.90799C18.6165 6.65368 19.0877 6.71258 19.342 7.03954C19.5963 7.36651 19.5374 7.83771 19.2105 8.09201L12.4605 13.342C12.1896 13.5527 11.8104 13.5527 11.5395 13.342L4.78954 8.09201C4.46258 7.83771 4.40368 7.36651 4.65799 7.03954Z" fill="#5B617C"/></svg>
                        <p class="Notif-Num"><?= count($notice) ?></p>
                        <div class="Notice-Menu">
                            <div class="Notice-Menu-cont df fdc">
                                <?php if (!empty($notice)) : ?>
                                    <?php foreach ($notice as $v) : ?>
                                        <div class="Notice_block">
                                            <h5 class="Notice__type"><?= $v->type ?></h5>
                                            <p class="Notice__text"><?= $v->text ?></p>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <div class="Notice_block">
                                        <h5 class="Notice__type">У Вас нет сообщений</h5>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="Notice-Menu-Back"></div>
                        <?php Pjax::end() ?>
                    </div>
                </div>
                <a href="<?= Url::to(['createorder']) ?>" class="btn--purple Hcont_R_R-AddZ-Block uscp df jcsb aic">
                    <img src="<?= Url::to(['/img/plass.svg']) ?>" alt="Плюс">
                        <p class="BText Hcont_R_R-AddZ-BTN-t">Разместить заказ</p>
                </a>
            </div>
        </div>
    </div>
</header>
<main class="main df">
    <article class="maincont df">
        <div class="BURGER-BACK"></div>
        <div class="leftMenu-WRAP">
            <div class="leftMenu-logo">
                <a href="<?= Url::to(['index']) ?>">
                    <img style="max-width: 130px;" src="<?= Url::to(['/img/afo/ads-logo.png']) ?>" alt="logo">
                </a>
            </div>
            <nav class="leftMenu">
                <div class="leftMenu-cont df fdc">
                    <div class="leftMenu-LK">
                        <p class="leftMenu-LK-ttl AText">личный кабинет</p>
                        <div class="Menu_row Menu_row-1 df aic jcsb <?= Yii::$app->controller->action->id == 'profile' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['profile']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-user.png']) ?>" alt="Человек">
                                <img class="menu-image" src="<?= Url::to(['/img/afo/pb.svg']) ?>"
                                     alt="Человек">
                                <p class="BText Menu_row-t">Профиль</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                        <div class="Menu_row Menu_row-2 df aic jcsb <?= Yii::$app->controller->action->id == 'balance' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['balance']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-balance.png']) ?>" alt="Деньги">
                                <img class="menu-image" src="<?= Url::to(['/img/afo/bb.svg']) ?>"
                                     alt="Деньги">
                                <p class="BText Menu_row-t">Баланс</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                    </div>
                    <div class="leftMenu-LG">
                        <p class="leftMenu-LK-ttl AText">лидогенерация</p>
                        <div class="Menu_row Menu_row-3 df aic jcsb <?= Yii::$app->controller->action->id == 'index' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['index']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-home.png']) ?>" alt="Дом">
                                <img class="menu-image" src="<?= Url::to(['/img/afo/hb.svg']) ?>"
                                     alt="Дом">
                                <p class="BText Menu_row-t">Главная</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                            <div class="Menu_row Menu_row-4 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'myorders' ? 'active' : '' ?> <?= Yii::$app->controller->action->id == 'orderpage' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['myorders']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/afo/od.svg']) ?>"
                                         alt="иконка сумки">
                                    <img class="menu-image" src="<?= Url::to(['/img/afo/ob.svg']) ?>"
                                         alt="иконка сумки">
                                    <p class="BText Menu_row-t">Мои заказы</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-5 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'choose' ? 'active' : '' ?> <?= Yii::$app->controller->action->id == 'specialist' ? 'active' : '' ?> <?= Yii::$app->controller->action->id == 'specialistorder' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['choose']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/afo/man.svg']) ?>"
                                         alt="Иконка стрелки">
                                    <img class="menu-image" src="<?= Url::to(['/img/afo/manb.svg']) ?>"
                                         alt="Иконка стрелки">
                                    <p class="BText Menu_row-t">Выбрать исполнителя</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-5 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'createorder' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['createorder']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/icon(1).svg']) ?>"
                                         alt="Иконка стрелки">
                                    <img class="menu-image" src="<?= Url::to(['/img/afo/plb.svg']) ?>"
                                         alt="Иконка стрелки">
                                    <p class="BText Menu_row-t">Разместить заказ</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-5 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'ratingspecialist' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['ratingspecialist']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/afo/rat.svg']) ?>"
                                         alt="Иконка стрелки">
                                    <img class="menu-image" src="<?= Url::to(['/img/afo/ratb.svg']) ?>"
                                         alt="Иконка стрелки">
                                    <p class="BText Menu_row-t">Рейтинг исполнителей</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-5 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'base' ? 'active' : '' ?> <?= Yii::$app->controller->action->id == 'baseset' ? 'active' : '' ?> <?= Yii::$app->controller->action->id == 'article' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['base']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/afo/base.svg']) ?>"
                                         alt="Иконка стрелки">
                                    <img class="menu-image" src="<?= Url::to(['/img/afo/baseb.svg']) ?>"
                                         alt="Иконка стрелки">
                                    <p class="BText Menu_row-t">База знаний</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-5 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'myrating' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['myrating']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/afo/rt.svg']) ?>"
                                         alt="Иконка стрелки">
                                    <img class="menu-image" src="<?= Url::to(['/img/afo/rtb.svg']) ?>"
                                         alt="Иконка стрелки">
                                    <p class="BText Menu_row-t">Мой рейтинг</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                    </div>

                    <div class="leftMenu-OP">
                        <p class="leftMenu-LK-ttl AText">Другие проекты</p>
                        <div class="leftMenu-add df fdc">
                            <a href="<?= Url::to(['/femida/client']) ?>" class="HText Menu_row-t2 uscp">Франшиза</a>
                            <a href="<?= Url::to(['']) ?>" class="HText Menu_row-t2 uscp">Реклама</a>
                            <a href="<?= Url::to(['/lead-force/client']) ?>" class="HText Menu_row-t2 uscp">Лидогенерация</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>