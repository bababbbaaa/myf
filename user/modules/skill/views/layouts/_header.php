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
            <a href="<?= Url::to(['/']) ?>">
                <img src="<?= Url::to(['/img/skillclient/SKILLFORCE.png']) ?>" alt="logo">
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
                <? //= Url::to(['#'])
                ?>
                <!--">Бонусная программа</a>-->
                <?php if (Yii::$app->controller->id != 'teacher') : ?>
                    <a href="<?= Url::to('https://myforce.ru/club') ?>" target="_blank" class="Hcont-skil-link">Стать участником Клуба MYFORCE</a>
                <?php endif; ?>
            </div>

            <div class="Hcont_R_R df aic">
                <?php if (Yii::$app->controller->id === 'client') : ?>
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
                <a href="<?php if (Yii::$app->controller->id == 'student') : ?><?= Url::to(['programs']) ?><?php endif; ?><?php if (Yii::$app->controller->id == 'teacher') : ?><?= Url::to(['addprogram']) ?>
          <?php endif; ?>
          " class="btn--purple Hcont_R_R-AddZ-Block uscp df jcsb aic">
                    <img src="<?= Url::to(['/img/plass.svg']) ?>" alt="Плюс">
                    <?php if (Yii::$app->controller->id == 'teacher') : ?>
                        <p class="BText Hcont_R_R-AddZ-BTN-t">Добавить программу</p>
                    <?php endif; ?>
                    <?php if (Yii::$app->controller->id == 'student') : ?>
                        <p class="BText Hcont_R_R-AddZ-BTN-t">Выбрать программу</p>
                    <?php endif; ?>
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
                    <img src="<?= Url::to(['/img/skillclient/SKILLFORCE.png']) ?>" alt="logo">
                </a>
            </div>
            <nav class="leftMenu">
                <div class="leftMenu-cont df fdc">
                    <div class="leftMenu-LK">
                        <p class="leftMenu-LK-ttl AText">личный кабинет</p>
                        <div class="Menu_row Menu_row-1 df aic jcsb <?= Yii::$app->controller->action->id == 'profile' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['profile']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-user.png']) ?>" alt="Человек">
                                <img class="menu-image" src="<?= Url::to(['/img/skillclient/icon(4).svg']) ?>"
                                     alt="Человек">
                                <p class="BText Menu_row-t">Профиль</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                        <div class="Menu_row Menu_row-2 df aic jcsb <?= Yii::$app->controller->action->id == 'balance' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['balance']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-balance.png']) ?>" alt="Деньги">
                                <img class="menu-image" src="<?= Url::to(['/img/skillclient/icon(3).svg']) ?>"
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
                                <img class="menu-image" src="<?= Url::to(['/img/menu-bonuses.png']) ?>" alt="Блокнот">
                                <img class="menu-image" src="<?= Url::to(['/img/skillclient/icon(5).svg']) ?>"
                                     alt="Блокнот">
                                <p class="BText Menu_row-t">База знаний</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                        <!--                        --><?php //if (Yii::$app->controller->id != 'teacher') : ?>
                        <!--                            <div class="Menu_row Menu_row-3 Menu_row-last df aic jcsb -->
                        <? //= Yii::$app->controller->action->id == 'bonuses' ? 'active' : '' ?><!--">-->
                        <!--                                <a class="Menu_row-butt df aic" href="-->
                        <? //= Url::to(['bonuses']) ?><!--">-->
                        <!--                                    <img class="menu-image" src="-->
                        <? //= Url::to(['/img/menu-bonuses.png']) ?><!--"-->
                        <!--                                         alt="Подключение">-->
                        <!--                                    <img class="menu-image" src="-->
                        <? //= Url::to(['/img/skillclient/icon(5).svg']) ?><!--"-->
                        <!--                                         alt="Подключение">-->
                        <!--                                    <p class="BText Menu_row-t">Мои бонусы</p>-->
                        <!--                                </a>-->
                        <!--                                <div class="Menu_row_LINE-ACTIVE"></div>-->
                        <!--                            </div>-->
                        <!--                        --><?php //endif; ?>
                    </div>
                    <div class="leftMenu-LG">
                        <p class="leftMenu-LK-ttl AText">обучение</p>
                        <div class="Menu_row Menu_row-3 df aic jcsb <?= Yii::$app->controller->action->id == 'index' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['index']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-home.png']) ?>" alt="Дом">
                                <img class="menu-image" src="<?= Url::to(['/img/skillclient/icon(9).svg']) ?>"
                                     alt="Дом">
                                <p class="BText Menu_row-t">Главная</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                        <?php if (Yii::$app->controller->id != 'teacher') : ?>
                            <div class="Menu_row Menu_row-4 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'catalog' ? 'active' : '' ?>
            <?= Yii::$app->controller->action->id == 'viewcours' ? 'active' : '' ?>
            <?= Yii::$app->controller->action->id == 'mycours' ? 'active' : '' ?>
            <?= Yii::$app->controller->action->id == 'education' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['education']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/icon.svg']) ?>"
                                         alt="иконка сумки">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/icon(6).svg']) ?>"
                                         alt="иконка сумки">
                                    <p class="BText Menu_row-t">Мое обучение</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                        <?php endif; ?>
                        <?php if (Yii::$app->controller->id != 'teacher') : ?>
                            <div class="Menu_row Menu_row-5 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'programs' ? 'active' : '' ?>
            <?= Yii::$app->controller->action->id == 'order-lid' ? 'active' : '' ?>
            <?= Yii::$app->controller->action->id == 'myorder' ? 'active' : '' ?>>
            <?= Yii::$app->controller->action->id == 'orderpage' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['programs']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/icon(1).svg']) ?>"
                                         alt="Иконка стрелки">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/icon(7).svg']) ?>"
                                         alt="Иконка стрелки">
                                    <p class="BText Menu_row-t">Выбрать программу</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                        <?php endif; ?>
                        <?php if (Yii::$app->controller->id != 'teacher') : ?>
                            <div class="Menu_row Menu_row-6 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'careercenter' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['careercenter']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/icon(2).svg']) ?>"
                                         alt="Иконка магистерской шапочки">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/icon(8).svg']) ?>"
                                         alt="Иконка магистерской шапочки">
                                    <p class="BText Menu_row-t">Центр карьеры</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                        <?php endif; ?>
                        <?php if (Yii::$app->controller->id == 'teacher') : ?>
                            <div class="Menu_row Menu_row-6 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'myprograms' ? 'active' : '' ?> <?= Yii::$app->controller->action->id == 'programmpage' ? 'active' : '' ?> <?= Yii::$app->controller->action->id == 'webinarpage' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['myprograms']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/m1.png']) ?>"
                                         alt="Иконка магистерской шапочки">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/m1-1.png']) ?>"
                                         alt="Иконка магистерской шапочки">
                                    <p class="BText Menu_row-t">Мои программы</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-6 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'addprogram' ? 'active' : '' ?> <?= Yii::$app->controller->action->id == 'addintensiv' ? 'active' : '' ?> <?= Yii::$app->controller->action->id == 'addwebinar' ? 'active' : '' ?> <?= Yii::$app->controller->action->id == 'addautowebinar' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['addprogram']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/icon(1).svg']) ?>"
                                         alt="Иконка стрелки">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/icon(7).svg']) ?>"
                                         alt="Иконка стрелки">
                                    <p class="BText Menu_row-t">Добавить программу</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-6 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'mytasks' ? 'active' : '' ?> <?= Yii::$app->controller->action->id == 'taskpage' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['mytasks']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/m2.png']) ?>"
                                         alt="Иконка магистерской шапочки">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/m2-2.png']) ?>"
                                         alt="Иконка магистерской шапочки">
                                    <p class="BText Menu_row-t">Мои задания</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-6 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'help' ? 'active' : '' ?> <?= Yii::$app->controller->action->id == 'help-tasks' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['help']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/m3.png']) ?>"
                                         alt="Иконка магистерской шапочки">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/m3-3.png']) ?>"
                                         alt="Иконка магистерской шапочки">
                                    <p class="BText Menu_row-t">Помогаю проверять</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                            <div class="Menu_row Menu_row-6 Menu_row df aic jcsb <?= Yii::$app->controller->action->id == 'statis' ? 'active' : '' ?>">
                                <a class="Menu_row-butt df aic" href="<?= Url::to(['statis']) ?>">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/m4.png']) ?>"
                                         alt="Иконка магистерской шапочки">
                                    <img class="menu-image" src="<?= Url::to(['/img/skillclient/m4-4.png']) ?>"
                                         alt="Иконка магистерской шапочки">
                                    <p class="BText Menu_row-t">Статистика</p>
                                </a>
                                <div class="Menu_row_LINE-ACTIVE"></div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <!--          --><?php //if (Yii::$app->controller->id != 'teacher') : ?>
                    <!--          <div class="leftMenu-Veinar">-->
                    <!--            <div class="leftMenu-Veinar-row">-->
                    <!--              <p class="leftMenu-Veinar-row-t1">Вебинар</p>-->
                    <!--              <p class="leftMenu-Veinar-row-t2">сегодня, 20:00</p>-->
                    <!--            </div>-->
                    <!--            <p class="leftMenu-Veinar-NAME">Искусство продаж</p>-->
                    <!--            <a href="--><? //= Url::to(['#']) ?><!--">Смотреть вебинар</a>-->
                    <!--          </div>-->
                    <!--          --><?php //endif; ?>

                    <div class="leftMenu-OP">
                        <p class="leftMenu-LK-ttl AText">Другие проекты</p>
                        <div class="leftMenu-add df fdc">
                            <a href="<?= Url::to(['/femida/client']) ?>" class="HText Menu_row-t2 uscp">Франшиза</a>
                            <a href="<?= Url::to(['/lead-force/client']) ?>" class="HText Menu_row-t2 uscp">Лидогенерация</a>
                            <a href="<?= Url::to(['/dev']) ?>" class="HText Menu_row-t2 uscp">Разработка</a>
                            <a target="_blank" href="<?= Url::to('https://adsforce.eu') ?>" class="HText Menu_row-t2 uscp">Поиск фрилансеров</a>
                        </div>
                    </div>
                </div>
            </nav>
        </div>