<?php

use common\models\UsersNotice;
use yii\helpers\Url;
use common\models\User;
use yii\widgets\Pjax;

$user = Yii::$app->getUser()->getId();

$user = User::find()->where(['id' => $user])->asArray()->one();
$notice = UsersNotice::find()->where(['user_id' => $user['id'], 'active' => 1])->orderBy('date desc')->all();
$bonusesInfo = \common\models\UsersBonuses::find()->where(['user_id' => $user['id']])->asArray()->select('bonus_points')->one();
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
                url: 'read-notice',
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
            <a href="<?= Url::to(['/']) ?>">
                <img src="<?= Url::to(['/img/LEAD.Force.svg']) ?>" alt="logo">
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
                <!--                <p class="club__member">Стать участником Клуба MYFORCE</p>-->
                <!--                          <a style="display: none" class="link" href="-->
                <? //= Url::to(['#']) ?><!--">Бонусная программа</a>-->
            </div>
            <div class="Hcont_R_R df aic">
                <?php if (Yii::$app->controller->id === 'client'): ?>
                    <div class="coins__bonuses">
                        <svg class="svg__coins" width="24" height="24" viewBox="0 0 24 24" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M5.31818 2.5H18.6818L22.5 9.15L12 21.5L1.5 9.15L5.31818 2.5Z" fill="#2CCD65"
                                  stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5.31824 2.5L12.0001 21.5L18.6819 2.5"
                                  fill="#2CCD65"/>
                            <path d="M5.31824 2.5L12.0001 21.5L18.6819 2.5" stroke="white" stroke-width="2"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M1.5 9.15039H22.5H1.5Z" fill="#2CCD65"/>
                            <path d="M1.5 9.15039H22.5" stroke="white" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M7.70459 9.15L12 2.5L16.2955 9.15"
                                  fill="#2CCD65"/>
                            <path d="M7.70459 9.15L12 2.5L16.2955 9.15" stroke="white" stroke-width="2"
                                  stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <p style="margin-left: 10px;"><?= number_format($bonusesInfo['bonus_points'], 0, 0, ' ') ?></p>
                    </div>
                <?php endif; ?>
                <div class="Hcont_R_R-Name">
                    <p class="Hcont_R_R-Name-t MText uscp"><?= $user['username'] ?></p>
                    <div class="User-Menu">
                        <div class="User-Menu-cont df fdc">
                            <a href="<?= Url::to(['prof', '#' => 'item3']) ?>" class="User-Menu-b df aic">
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
                                <?php if (!empty($notice)): ?>
                                    <?php foreach ($notice as $v): ?>
                                        <div class="Notice_block">
                                            <h5 class="Notice__type"><?= $v->type ?></h5>
                                            <p class="Notice__text"><?= $v->text ?></p>
                                        </div>
                                    <?php endforeach; ?>

                                <?php else: ?>
                                    <div class="Notice_block">
                                        <h5 class="Notice__type">Новых уведомлений нет</h5>
                                    </div>
                                    <a data-pjax="0" href="<?= Url::to(['notice']) ?>" class="More_notice">История уведомлений</a>
                                <?php endif; ?>

                            </div>
                        </div>
                        <div class="Notice-Menu-Back"></div>
                        <?php Pjax::end() ?>
                    </div>
                </div>
                <a href="<?= Url::to(['order-lid-add']) ?>" class="Hcont_R_R-AddZ-Block uscp df jcsb aic">
                    <img src="<?= Url::to(['/img/plass.svg']) ?>" alt="Плюс">
                    <p class="BText Hcont_R_R-AddZ-BTN-t"><?= Yii::$app->controller->id == 'provider' ? 'Предложить оффер' : 'Создать заказ'  ?></p>
                </a>
            </div>
        </div>
    </div>
    </div>
</header>
<main class="main df">
    <article class="maincont df">
        <div class="BURGER-BACK"></div>
        <div class="leftMenu-WRAP">
            <div class="leftMenu-logo">
                <a href="">
                    <img src="<?= Url::to(['/img/LEAD.Force.svg']) ?>" alt="logo">
                </a>
            </div>
            <nav class="leftMenu">
                <div class="leftMenu-cont df fdc">
                    <div class="leftMenu-LK">
                        <p class="leftMenu-LK-ttl AText">личный кабинет</p>
                        <div class="Menu_row Menu_row-1 df aic jcsb <?= Yii::$app->controller->action->id == 'prof' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['prof']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-user.png']) ?>" alt="Человек">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-user-active.png']) ?>"
                                     alt="Человек">
                                <p class="BText Menu_row-t">Профиль</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                        <div class="Menu_row Menu_row-2 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'balance' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['balance']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-balance.png']) ?>" alt="Деньги">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-balance-active.png']) ?>"
                                     alt="Деньги">
                                <p class="BText Menu_row-t">Баланс</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                        <div class="Menu_row Menu_row-4 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'knowledge' ? 'active' : '' ?>
            <?= Yii::$app->controller->action->id == 'knowledgecat' ? 'active' : '' ?>
            <?= Yii::$app->controller->action->id == 'knowledgearticle' ? 'active' : '' ?>
            <?= Yii::$app->controller->action->id == 'knowledgepage' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['knowledge']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-orders.png']) ?>" alt="Блокнот">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-orders-active.png']) ?>"
                                     alt="Блокнот">
                                <p class="BText Menu_row-t">База знаний</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                    </div>
                    <div class="leftMenu-LG">
                        <p class="leftMenu-LK-ttl AText">лидогенерация</p>
                        <div class="Menu_row Menu_row-3 df aic jcsb <?= Yii::$app->controller->action->id == 'index' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['index']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-home.png']) ?>" alt="Дом">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-home-active.png']) ?>" alt="Дом">
                                <p class="BText Menu_row-t">Главная</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                        <?php if (Yii::$app->controller->id === 'client'): ?>
                            <div class="Menu_row Menu_row-4 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'myorders' ? 'active' : '' ?><?= Yii::$app->controller->action->id == 'orderpage' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['myorders']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-orders.png']) ?>" alt="Блокнот">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-orders-active.png']) ?>"
                                         alt="Блокнот">
                                    <p class="BText Menu_row-t">Мои заказы</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-5 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'order' ? 'active' : '' ?>  <?= Yii::$app->controller->action->id == 'order-lid' ? 'active' : '' ?><?= Yii::$app->controller->action->id == 'order-lid-add' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['order']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-addord.png']) ?>" alt="Плюс">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-addord-active.png']) ?>"
                                         alt="Плюс">
                                    <p class="BText Menu_row-t">Добавить заказ</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-6 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'auction' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['auction']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-lids.png']) ?>" alt="Тележка">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-lids-active.png']) ?>"
                                         alt="Тележка">
                                    <p class="BText Menu_row-t">Аукцион лидов</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-7 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'integration' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['integration']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-integ.png']) ?>"
                                         alt="Подключение">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-integ-active.png']) ?>"
                                         alt="Подключение">
                                    <p class="BText Menu_row-t">Интеграции</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-8 Menu_row-last df aic jcsb <?= Yii::$app->controller->action->id == 'bonuses' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['bonuses']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-bonuses.png']) ?>"
                                         alt="Подключение">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-bonuses-active.png']) ?>"
                                         alt="Подключение">
                                    <p class="BText Menu_row-t">Мои бонусы</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                        <?php else: ?>
                            <div class="Menu_row Menu_row-4 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'myorders' ? 'active' : '' ?><?= Yii::$app->controller->action->id == 'orderpage' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['myorders']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-orders.png']) ?>" alt="Блокнот">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-orders-active.png']) ?>"
                                         alt="Блокнот">
                                    <p class="BText Menu_row-t">Мои офферы</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-5 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'order' ? 'active' : '' ?>  <?= Yii::$app->controller->action->id == 'order-lid' ? 'active' : '' ?><?= Yii::$app->controller->action->id == 'order-lid-add' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['order']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-addord.png']) ?>" alt="Плюс">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-addord-active.png']) ?>"
                                         alt="Плюс">
                                    <p class="BText Menu_row-t">Добавить оффер</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-6 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'statistics' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['statistics']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/stat__icon.png']) ?>" alt="Тележка">
                                    <img class="menu-image" src="<?= Url::to(['/img/stat__icon-active.png']) ?>"
                                         alt="Тележка">
                                    <p class="BText Menu_row-t">Статистика</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-6 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'guide' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['guide']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-integ.png']) ?>" alt="Тележка">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-integ-active.png']) ?>"
                                         alt="Тележка">
                                    <p class="BText Menu_row-t">Лидогенерация</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-8 Menu_row-last df aic jcsb <?= Yii::$app->controller->action->id == 'referal' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['referal']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-bonuses.png']) ?>"
                                         alt="Подключение">
                                    <img class="menu-image" src="<?= Url::to(['/img/menu-bonuses-active.png']) ?>"
                                         alt="Подключение">
                                    <p class="BText Menu_row-t">Реферал</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!--            <div class="leftMenu-Veinar">-->
                    <!--              <div class="leftMenu-Veinar-row">-->
                    <!--                <p class="leftMenu-Veinar-row-t1">Вебинар</p>-->
                    <!--                <p class="leftMenu-Veinar-row-t2">сегодня, 20:00</p>-->
                    <!--              </div>-->
                    <!--              <p class="leftMenu-Veinar-NAME">Искусство продаж</p>-->
                    <!--              <a href="--><? //= Url::to(['#']) ?><!--">Получить ссылку</a>-->
                    <!--            </div>-->
                                <div class="leftMenu-OP">
                                  <p class="leftMenu-LK-ttl AText">Другие проекты</p>
                                  <div class="df fdc">
                                    <a href="<?= Url::to(['/femida/client']) ?>" class="HText Menu_row-t2 uscp">Франшиза</a>
                                    <a href="<?= Url::to(['/dev']) ?>" class="HText Menu_row-t2 uscp">Разработка</a>
<!--                                    <a target="_blank" href="--><?//= Url::to('https://adsforce.eu') ?><!--" class="HText Menu_row-t2 uscp">Поиск фрилансеров</a>-->
<!--                                    <a href="--><?//= Url::to(['/skill/student']) ?><!--" class="HText Menu_row-t2-last uscp">Обучение</a>-->
                                  </div>
                                </div>
                </div>
            </nav>
        </div>