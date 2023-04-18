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

$css = <<< CSS
.Menu_row:hover .Menu_row-t {
    color: #FED480;
}
.Menu_row.active .Menu_row-t {
    color: #FED480;
}

.Menu_row_LINE-ACTIVE {
    width: 4px;
    height: 24px;
    background: #FED480;
    border-radius: 1px;
    display: none;
}

.Menu_row.active .Menu_row_LINE-ACTIVE {
    display: block;
}
CSS;
$this->registerCss($css);

?>
<header class="HS df">
    <div class="Hcont df jcsb">
        <div style="background-color: #010101" class="Hcont_L">
            <a href="<?= Url::to('https://myforce.ru') ?>">
                <svg width="108" height="16" viewBox="0 0 108 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0.552364 15.7778C0.405067 15.7778 0.2725 15.7259 0.154662 15.6222C0.0515541 15.5037 0 15.3704 0 15.2222V0.777778C0 0.614815 0.0515541 0.481482 0.154662 0.377778C0.2725 0.274074 0.405067 0.222222 0.552364 0.222222H2.93858C3.29209 0.222222 3.54986 0.385185 3.71188 0.711111L7.60053 7.71111L11.4892 0.711111C11.6512 0.385185 11.909 0.222222 12.2625 0.222222H14.6266C14.7886 0.222222 14.9212 0.274074 15.0243 0.377778C15.1421 0.481482 15.201 0.614815 15.201 0.777778V15.2222C15.201 15.3852 15.1421 15.5185 15.0243 15.6222C14.9212 15.7259 14.7886 15.7778 14.6266 15.7778H11.9973C11.8353 15.7778 11.6954 15.7259 11.5775 15.6222C11.4744 15.5185 11.4229 15.3852 11.4229 15.2222V6.88889L8.94829 11.5333C8.75681 11.8741 8.49904 12.0444 8.17498 12.0444H7.02607C6.83458 12.0444 6.67992 12 6.56208 11.9111C6.44424 11.8222 6.34114 11.6963 6.25276 11.5333L3.75607 6.88889V15.2222C3.75607 15.3704 3.70452 15.5037 3.60141 15.6222C3.4983 15.7259 3.36574 15.7778 3.20371 15.7778H0.552364Z" fill="white" />
                    <path d="M23.2683 15.7778C23.121 15.7778 22.9885 15.7259 22.8706 15.6222C22.7675 15.5037 22.716 15.3704 22.716 15.2222V10.4444L17.59 0.933333C17.5458 0.8 17.5237 0.718518 17.5237 0.688889C17.5237 0.57037 17.5679 0.466667 17.6563 0.377778C17.7594 0.274074 17.8773 0.222222 18.0098 0.222222H20.7716C21.0662 0.222222 21.324 0.377778 21.5449 0.688889L24.7045 6.42222L27.8861 0.688889C28.0628 0.377778 28.3206 0.222222 28.6594 0.222222H31.4212C31.5538 0.222222 31.6643 0.274074 31.7526 0.377778C31.841 0.466667 31.8852 0.57037 31.8852 0.688889C31.8852 0.762963 31.8705 0.844444 31.841 0.933333L26.7151 10.4444V15.2222C26.7151 15.3852 26.6562 15.5185 26.5383 15.6222C26.4352 15.7259 26.3026 15.7778 26.1406 15.7778H23.2683Z" fill="white" />
                    <path d="M34.7722 15.7778C34.6249 15.7778 34.4923 15.7259 34.3745 15.6222C34.2714 15.5037 34.2198 15.3704 34.2198 15.2222V0.777778C34.2198 0.614815 34.2714 0.481482 34.3745 0.377778C34.4923 0.274074 34.6249 0.222222 34.7722 0.222222H44.9357C45.0977 0.222222 45.2303 0.274074 45.3334 0.377778C45.4365 0.481482 45.488 0.614815 45.488 0.777778V3.02222C45.488 3.17037 45.4365 3.3037 45.3334 3.42222C45.2303 3.52593 45.0977 3.57778 44.9357 3.57778H38.1084V6.84444H44.4938C44.6558 6.84444 44.7884 6.9037 44.8915 7.02222C44.9946 7.12593 45.0461 7.25926 45.0461 7.42222V9.64444C45.0461 9.79259 44.9946 9.92593 44.8915 10.0444C44.7884 10.1481 44.6558 10.2 44.4938 10.2H38.1084V15.2222C38.1084 15.3852 38.0569 15.5185 37.9538 15.6222C37.8507 15.7259 37.7181 15.7778 37.5561 15.7778H34.7722Z" fill="white" />
                    <path d="M54.5309 16C52.454 16 50.819 15.4889 49.6259 14.4667C48.4328 13.4444 47.7994 11.9407 47.7258 9.95556C47.7111 9.52593 47.7037 8.88889 47.7037 8.04445C47.7037 7.18519 47.7111 6.54074 47.7258 6.11111C47.7994 4.15556 48.4402 2.65185 49.648 1.6C50.8706 0.533333 52.4982 0 54.5309 0C56.5636 0 58.1912 0.533333 59.4138 1.6C60.6364 2.65185 61.2771 4.15556 61.336 6.11111C61.3655 6.97037 61.3802 7.61482 61.3802 8.04445C61.3802 8.45926 61.3655 9.0963 61.336 9.95556C61.2624 11.9407 60.629 13.4444 59.4359 14.4667C58.2428 15.4889 56.6078 16 54.5309 16ZM54.5309 12.8C55.341 12.8 55.9818 12.5556 56.4531 12.0667C56.9392 11.5778 57.197 10.8296 57.2264 9.82222C57.2559 8.96296 57.2706 8.35556 57.2706 8C57.2706 7.61482 57.2559 7.00741 57.2264 6.17778C57.197 5.17037 56.9392 4.42222 56.4531 3.93333C55.9671 3.44444 55.3263 3.2 54.5309 3.2C53.7355 3.2 53.0948 3.44444 52.6087 3.93333C52.1373 4.42222 51.8796 5.17037 51.8354 6.17778C51.8206 6.59259 51.8133 7.2 51.8133 8C51.8133 8.78519 51.8206 9.39259 51.8354 9.82222C51.8796 10.8296 52.1373 11.5778 52.6087 12.0667C53.08 12.5556 53.7208 12.8 54.5309 12.8Z" fill="white" />
                    <path d="M64.9355 15.7778C64.7882 15.7778 64.6557 15.7259 64.5378 15.6222C64.4347 15.5037 64.3832 15.3704 64.3832 15.2222V0.777778C64.3832 0.614815 64.4347 0.481482 64.5378 0.377778C64.6557 0.274074 64.7882 0.222222 64.9355 0.222222H70.9453C72.8748 0.222222 74.3773 0.666666 75.4526 1.55556C76.5425 2.42963 77.0875 3.67407 77.0875 5.28889C77.0875 6.32593 76.8445 7.20741 76.3584 7.93333C75.8723 8.65926 75.2021 9.21482 74.3478 9.6L77.3748 15.0667C77.419 15.1556 77.4411 15.237 77.4411 15.3111C77.4411 15.4296 77.3895 15.5407 77.2864 15.6444C77.198 15.7333 77.0949 15.7778 76.9771 15.7778H74.0385C73.6113 15.7778 73.3094 15.5778 73.1326 15.1778L70.6138 10.2889H68.3602V15.2222C68.3602 15.3852 68.3013 15.5185 68.1834 15.6222C68.0803 15.7259 67.9478 15.7778 67.7857 15.7778H64.9355ZM70.9011 7.13333C71.5786 7.13333 72.0942 6.97037 72.4477 6.64444C72.8012 6.3037 72.978 5.83704 72.978 5.24444C72.978 4.65185 72.8012 4.18519 72.4477 3.84445C72.1089 3.48889 71.5934 3.31111 70.9011 3.31111H68.3602V7.13333H70.9011Z" fill="white" />
                    <path d="M86.3778 16C84.2714 16 82.6217 15.4889 81.4286 14.4667C80.2502 13.4296 79.6242 11.9333 79.5506 9.97778C79.5358 9.57778 79.5285 8.92593 79.5285 8.02222C79.5285 7.1037 79.5358 6.43704 79.5506 6.02222C79.6242 4.0963 80.265 2.61481 81.4728 1.57778C82.6806 0.525926 84.3156 0 86.3778 0C87.674 0 88.8376 0.222223 89.8687 0.666667C90.8998 1.0963 91.7099 1.71852 92.2991 2.53333C92.903 3.33333 93.2124 4.27407 93.2271 5.35556V5.4C93.2271 5.51852 93.1755 5.62222 93.0724 5.71111C92.9841 5.78519 92.8809 5.82222 92.7631 5.82222H89.7803C89.5889 5.82222 89.4416 5.78519 89.3385 5.71111C89.2353 5.62222 89.147 5.46667 89.0733 5.24444C88.8671 4.48889 88.5431 3.96296 88.1012 3.66667C87.6593 3.35556 87.0774 3.2 86.3557 3.2C84.6176 3.2 83.7191 4.17778 83.6601 6.13333C83.6454 6.53333 83.6381 7.14815 83.6381 7.97778C83.6381 8.80741 83.6454 9.43704 83.6601 9.86667C83.7191 11.8222 84.6176 12.8 86.3557 12.8C87.0774 12.8 87.6666 12.6444 88.1233 12.3333C88.5799 12.0074 88.8966 11.4815 89.0733 10.7556C89.1322 10.5333 89.2132 10.3852 89.3164 10.3111C89.4195 10.2222 89.5741 10.1778 89.7803 10.1778H92.7631C92.8957 10.1778 93.0061 10.2222 93.0945 10.3111C93.1976 10.4 93.2418 10.5111 93.2271 10.6444C93.2124 11.7259 92.903 12.6741 92.2991 13.4889C91.7099 14.2889 90.8998 14.9111 89.8687 15.3556C88.8376 15.7852 87.674 16 86.3778 16Z" fill="white" />
                    <path d="M96.5446 15.7778C96.3973 15.7778 96.2647 15.7259 96.1469 15.6222C96.0437 15.5037 95.9922 15.3704 95.9922 15.2222V0.777778C95.9922 0.614815 96.0437 0.481482 96.1469 0.377778C96.2647 0.274074 96.3973 0.222222 96.5446 0.222222H106.863C107.025 0.222222 107.157 0.274074 107.26 0.377778C107.364 0.481482 107.415 0.614815 107.415 0.777778V2.86667C107.415 3.01481 107.364 3.14815 107.26 3.26667C107.157 3.37037 107.025 3.42222 106.863 3.42222H99.8145V6.42222H106.377C106.539 6.42222 106.671 6.48148 106.774 6.6C106.877 6.7037 106.929 6.83704 106.929 7V8.93333C106.929 9.08148 106.877 9.21482 106.774 9.33333C106.671 9.43704 106.539 9.48889 106.377 9.48889H99.8145V12.5778H107.039C107.201 12.5778 107.334 12.6296 107.437 12.7333C107.54 12.837 107.592 12.9704 107.592 13.1333V15.2222C107.592 15.3704 107.54 15.5037 107.437 15.6222C107.334 15.7259 107.201 15.7778 107.039 15.7778H96.5446Z" fill="white" />
                </svg>
            </a>
        </div>
        <div class="Hcont_R df aic jcsb">
            <div class="Wrapburgbal df aic">
                <img class="BURGER-BTN" src="<?= Url::to(['/img/Fburg.svg']) ?>" alt="Бургер">
                <a href="<?= Url::to(['balance']) ?>" class="Hcont_R_Balance uscp df aic jcsb">
                    <img src="<?= Url::to(['/img/money.png']) ?>" alt="Деньги">
                    <p class="HText Hcont_R_Balance-t">Баланс: <span class="gg1"><?= number_format($user['budget'], 2, ',', ' ') ?> </span> <span style="color: #007fea">₽</span>
                    </p>
                </a>
            </div>
            <a href="<?= Url::to(['logout']) ?>">Выход</a>
        </div>
    </div>
</header>
<main class="main df">
    <article class="maincont df">
        <div class="BURGER-BACK"></div>
        <div class="leftMenu-WRAP">
            <nav style="background-color: #010101" class="leftMenu">
                <div class="leftMenu-cont df fdc">
                    <div class="leftMenu-LK">
                        <p class="leftMenu-LK-ttl AText">личный кабинет</p>
                        <div class="Menu_row Menu_row-1 df aic jcsb <?= Yii::$app->controller->action->id == 'prof' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['prof']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/icons/main-profile.png']) ?>" alt="Человек">
                                <img class="menu-image" src="<?= Url::to(['/img/icons/main-profile-hover.png']) ?>" alt="Человек">
                                <p class="BText Menu_row-t">Профиль</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                        <div class="Menu_row Menu_row-2 df aic jcsb <?= Yii::$app->controller->action->id == 'balance' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['balance']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/icons/main-balance.png']) ?>" alt="Деньги">
                                <img class="menu-image" src="<?= Url::to(['/img/icons/main-balance-hover.png']) ?>" alt="Деньги">
                                <p class="BText Menu_row-t">Баланс</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                        <div class="Menu_row Menu_row-3 Menu_row-last df aic jcsb <?= Yii::$app->controller->action->id == 'knowledge' ? 'active' : '' ?>
            <?= Yii::$app->controller->action->id == 'knowledgecat' ? 'active' : '' ?>
            <?= Yii::$app->controller->action->id == 'knowledgearticle' ? 'active' : '' ?>
            <?= Yii::$app->controller->action->id == 'knowledgepage' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['knowledge']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/icons/main-knowladge.png']) ?>" alt="Подключение">
                                <img class="menu-image" src="<?= Url::to(['/img/icons/main-knowladge-hover.png']) ?>" alt="Подключение">
                                <p class="BText Menu_row-t">База знаний</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                    </div>
                    <div class="leftMenu-LG">
                        <p class="leftMenu-LK-ttl AText">Наши проекты</p>
                        <div class="Menu_row Menu_row-3 df aic jcsb <?= Yii::$app->controller->action->id == 'index' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['/']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/icons/main-index.png']) ?>" alt="Дом">
                                <img class="menu-image" src="<?= Url::to(['/img/icons/main-index-hover.png']) ?>" alt="Дом">
                                <p class="BText Menu_row-t">Главная</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                        <div class="fortune-menu Menu_row Menu_row-3 df aic jcsb <?= Yii::$app->controller->action->id == 'fortune' ? 'active' : '' ?>">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['/fortune']) ?>">
                                <svg style="width: 20px; height: 20px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" xml:space="preserve">
                                    <g fill="<?= Yii::$app->controller->action->id == 'fortune' ? '#FED480' : '#fffcfc' ?>" transform="translate(0, 0) scale(1, 1) ">
                                        <path d="M19 8l-4 4h3c0 3.31-2.69 6-6 6-1.01 0-1.97-.25-2.8-.7l-1.46 1.46C8.97 19.54 10.43 20 12 20c4.42 0 8-3.58 8-8h3l-4-4zM6 12c0-3.31 2.69-6 6-6 1.01 0 1.97.25 2.8.7l1.46-1.46C15.03 4.46 13.57 4 12 4c-4.42 0-8 3.58-8 8H1l4 4 4-4H6z">
                                            <animateTransform attributeName="transform" attributeType="XML" type="rotate" from="360 12 12" to="0 12 12" dur="5s" repeatCount="indefinite" />
                                        </path>
                                    </g>
                                </svg>
                                <p class="BText Menu_row-t">Колесо фортуны</p>
                            </a>
                            <div class="Menu_row_LINE-ACTIVE"></div>
                        </div>
                        <style>
                            .fortune-menu svg {
                                transition-duration: 0.3s;
                            }

                            .fortune-menu svg g {
                                transition-duration: 0.3s;
                            }

                            .fortune-menu:hover svg {
                                opacity: 0.6;
                            }
                        </style>
                        <div class="Menu_row Menu_row-3 df aic jcsb">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['/lead-force']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-home.png']) ?>" alt="Дом">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-home-active.png']) ?>" alt="Дом">
                                <p class="BText Menu_row-t">Лидогенерация</p>
                            </a>
                        </div>
                        <!--<div class="Menu_row Menu_row-4 Menu_row df aic jcsb">
                            <a class="Menu_row-butt df aic" href="<?/*= Url::to(['/skill/student']) */?>">
                                <img class="menu-image" src="<?/*= Url::to(['/img/menu-orders.png']) */?>" alt="Блокнот">
                                <img class="menu-image" src="<?/*= Url::to(['/img/menu-orders-active.png']) */?>" alt="Блокнот">
                                <p class="BText Menu_row-t">Обучение</p>
                            </a>
                        </div>-->
                        <div class="Menu_row Menu_row-5 Menu_row df aic jcsb">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['/dev']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-addord.png']) ?>" alt="Плюс">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-addord-active.png']) ?>" alt="Плюс">
                                <p class="BText Menu_row-t">Разработка</p>
                            </a>
                        </div>
                        <div class="Menu_row Menu_row-6 Menu_row df aic jcsb">
                            <a class="Menu_row-butt df aic" href="<?= Url::to(['/femida/client']) ?>">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-lids.png']) ?>" alt="Тележка">
                                <img class="menu-image" src="<?= Url::to(['/img/menu-lids-active.png']) ?>" alt="Тележка">
                                <p class="BText Menu_row-t">Франшиза</p>
                            </a>
                        </div>
                        <!--<div class="Menu_row Menu_row-6 Menu_row df aic jcsb">
                            <a class="Menu_row-butt df aic" href="https://adsforce.eu/">
                                <img class="menu-image" src="<?/*= Url::to(['/img/menu-lids.png']) */?>" alt="Тележка">
                                <img class="menu-image" src="<?/*= Url::to(['/img/menu-lids-active.png']) */?>" alt="Тележка">
                                <p class="BText Menu_row-t">Freelance биржа</p>
                            </a>
                        </div>-->
                    </div>
                </div>
            </nav>
        </div>