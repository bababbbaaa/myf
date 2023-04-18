<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Breadcrumbs;
use core\assets\SkillAsset;
use common\widgets\Alert;
use common\models\SkillTrainings;
use common\models\SkillTrainingsCategory;

$category = SkillTrainingsCategory::find()
    ->asArray()
    ->select('name, id')
    ->limit(4)
    ->all();
$cat = [];
$arr = [];
foreach ($category as $item) {
    $cat[] = $item['id'];
}
$moreCources = SkillTrainings::find()
    ->asArray()
    ->where(['in', 'category_id', $cat])
    ->all();

foreach ($category as $i) {
    $arr[$i['name']] = SkillTrainings::find()->asArray()->where(['category_id' => $i['id']])->limit(4)->all();
}

$guest = Yii::$app->user->isGuest;

SkillAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <?php $this->head() ?>
    <!-- Yandex.Metrika counter -->
    <script type="text/javascript">
        (function(m, e, t, r, i, k, a) {
            m[i] = m[i] || function() {
                (m[i].a = m[i].a || []).push(arguments)
            };
            m[i].l = 1 * new Date();
            k = e.createElement(t), a = e.getElementsByTagName(t)[0], k.async = 1, k.src = r, a.parentNode.insertBefore(k, a)
        })
        (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

        ym(89146084, "init", {
            clickmap: true,
            trackLinks: true,
            accurateTrackBounce: true,
            webvisor: true
        });
    </script>
    <noscript>
        <div><img src="https://mc.yandex.ru/watch/89146084" style="position:absolute; left:-9999px;" alt="" /></div>
    </noscript>
    <!-- /Yandex.Metrika counter -->
</head>

<body>
    <?php $this->beginBody() ?>

    <div class="wrap headTelss">
        <div class="compMenu">
            <div class="header">
                <div class="container">
                    <div class="pow naviget">
                        <div class="pow rol-7 navg">
                            <a class="log" href="<?= Url::to(['index']) ?>">SKILL.Force</a>
                            <div class="nav pow linkgroup">
                                <a style="padding-right: 10px;" href="<?= Url::to(['/']) ?>">MYFORCE</a>
                                <a style="padding-right: 10px;" href="<?= Url::to(['/club']) ?>"> Клуб MYFORCE </a>
                                <a href="<?= Url::to(['about']) ?>">О проекте</a>
                            </div>
                        </div>
                        <?php if (!$guest) : ?>
                            <div class="rol-3 butgroop">
                                <?= Html::a('Выход', 'https://myforce.ru/site/logout/', ['class' => 'enter']) ?>
                                <?= Html::a('Кабинет', 'https://user.myforce.ru/', ['class' => 'register']) ?>
                            </div>
                        <?php else : ?>
                            <div class="rol-3 butgroop">
                                <?= Html::a('Войти', '/registr', ['class' => 'enter']) ?>
                                <?= Html::a('Регистрация', '/registr', ['class' => 'register']) ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="header1">
                <div class="container">
                    <div class="pow navibet">
                        <a class="linnav <?= Yii::$app->controller->action->id === 'index' ? 'linnavActive' : '' ?>" href="<?= Url::to(['index']) ?>">
                            <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.44194 1.70088C9.19786 1.4568 8.80213 1.4568 8.55806 1.70088L2.755 7.50394C2.36796 7.89098 2.16936 8.42782 2.21134 8.97357L2.65938 14.798C2.68442 15.1236 2.95595 15.3751 3.28254 15.3751H7.125V12.2501C7.125 11.2145 7.96446 10.3751 9 10.3751C10.0355 10.3751 10.875 11.2145 10.875 12.2501V15.3751H14.7175C15.044 15.3751 15.3156 15.1236 15.3406 14.798L15.7887 8.97357C15.8306 8.42782 15.632 7.89098 15.245 7.50394L9.44194 1.70088ZM7.67417 0.816997C8.40641 0.0847641 9.59359 0.0847641 10.3258 0.816997L16.1289 6.62005C16.774 7.26512 17.1049 8.15986 17.035 9.06944L16.5869 14.8939C16.5118 15.8707 15.6972 16.6251 14.7175 16.6251H10.875C10.1846 16.6251 9.625 16.0654 9.625 15.3751V12.2501C9.625 11.9049 9.34517 11.6251 9 11.6251C8.65482 11.6251 8.375 11.9049 8.375 12.2501V15.3751C8.375 16.0654 7.81535 16.6251 7.125 16.6251H3.28254C2.30278 16.6251 1.4882 15.8707 1.41306 14.8939L0.965026 9.06944C0.895059 8.15986 1.22604 7.26512 1.87111 6.62005L7.67417 0.816997Z" fill="#23213D" />
                            </svg>
                            <span>Главная</span>
                        </a>
                        <a class="linnav <?= Yii::$app->controller->action->id === 'webinars' ? 'linnavActive' : '' ?>" href="<?= Url::to(['webinars']) ?>">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.69534 1.81464C9.88926 1.72845 10.1106 1.72845 10.3045 1.81464L17.8045 5.14797C18.0754 5.26835 18.2499 5.53694 18.2499 5.83333C18.2499 6.12972 18.0754 6.39832 17.8045 6.51869L10.3045 9.85203C10.1106 9.93821 9.88926 9.93821 9.69534 9.85203L2.19534 6.51869C1.92449 6.39832 1.74994 6.12972 1.74994 5.83333C1.74994 5.53694 1.92449 5.26835 2.19534 5.14797L9.69534 1.81464ZM4.3466 5.83333L9.99994 8.34593L15.6533 5.83333L9.99994 3.32074L4.3466 5.83333ZM1.81458 9.6954C1.98281 9.31688 2.42603 9.14641 2.80455 9.31464L9.99994 12.5126L17.1953 9.31464C17.5739 9.14641 18.0171 9.31688 18.1853 9.6954C18.3535 10.0739 18.1831 10.5171 17.8045 10.6854L10.3045 14.0187C10.1106 14.1049 9.88926 14.1049 9.69534 14.0187L2.19534 10.6854C1.81683 10.5171 1.64636 10.0739 1.81458 9.6954ZM2.80455 13.4813C2.42603 13.3131 1.98281 13.4835 1.81458 13.8621C1.64636 14.2406 1.81683 14.6838 2.19534 14.852L9.69534 18.1854C9.88926 18.2715 10.1106 18.2715 10.3045 18.1854L17.8045 14.852C18.1831 14.6838 18.3535 14.2406 18.1853 13.8621C18.0171 13.4835 17.5739 13.3131 17.1953 13.4813L9.99994 16.6793L2.80455 13.4813Z" fill="#23213D" />
                            </svg>
                            <span>Вебинары</span>
                        </a>
                        <a class="linnav <?= Yii::$app->controller->action->id === 'intensive' ? 'linnavActive' : '' ?>" href="<?= Url::to(['intensive']) ?>">
                            <svg width="10" height="17" viewBox="0 0 10 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M7.10936 0.420672C7.38782 0.533305 7.54677 0.828098 7.48786 1.12264L6.38738 6.62507H8.75C8.97863 6.62507 9.18901 6.74991 9.29857 6.95058C9.40813 7.15125 9.39937 7.39572 9.27574 7.58804L3.65074 16.338C3.48831 16.5907 3.1691 16.6921 2.89064 16.5795C2.61218 16.4668 2.45323 16.172 2.51214 15.8775L3.61262 10.3751H1.25C1.02137 10.3751 0.810987 10.2502 0.70143 10.0496C0.591874 9.84889 0.600631 9.60441 0.724264 9.4121L6.34926 0.662096C6.5117 0.409425 6.8309 0.308039 7.10936 0.420672ZM2.39479 9.12507H4.375C4.56225 9.12507 4.73963 9.20902 4.85834 9.35382C4.97705 9.49863 5.02459 9.68903 4.98786 9.87264L4.38578 12.8831L7.60521 7.87507H5.625C5.43776 7.87507 5.26037 7.79112 5.14166 7.64631C5.02295 7.50151 4.97542 7.31111 5.01214 7.1275L5.61422 4.11706L2.39479 9.12507Z" fill="#23213D" />
                            </svg>
                            <span>Интенсивы</span>
                        </a>
                        <a class="linnav <?= Yii::$app->controller->action->id === 'profession' ? 'linnavActive' : '' ?>" href="<?= Url::to(['profession']) ?>">
                            <svg width="18" height="17" viewBox="0 0 18 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.2392 0.422594C14.4727 0.519332 14.625 0.747229 14.625 1.00002V1.99113L15.4331 1.18308C15.6771 0.938999 16.0729 0.938999 16.3169 1.18308C16.561 1.42715 16.561 1.82288 16.3169 2.06696L15.5089 2.87502H16.5C16.7528 2.87502 16.9807 3.02729 17.0774 3.26084C17.1742 3.49439 17.1207 3.76321 16.9419 3.94196L14.4419 6.44196C14.3247 6.55917 14.1658 6.62502 14 6.62502H11.7589L9.58267 8.80124C9.61028 8.90451 9.62501 9.01304 9.62501 9.12502C9.62501 9.81537 9.06536 10.375 8.37501 10.375C7.68465 10.375 7.12501 9.81537 7.12501 9.12502C7.12501 8.43466 7.68465 7.87502 8.37501 7.87502C8.48698 7.87502 8.59552 7.88974 8.69878 7.91736L10.875 5.74114V3.50002C10.875 3.33426 10.9409 3.17529 11.0581 3.05808L13.5581 0.558077C13.7368 0.379328 14.0056 0.325855 14.2392 0.422594ZM12.125 4.49113L13.375 3.24113V2.5089L12.125 3.7589V4.49113ZM13.0089 5.37502H13.7411L14.9911 4.12502H14.2589L13.0089 5.37502Z" fill="#23213D" />
                                <path d="M5.44081 3.6066C6.60619 2.98695 7.93781 2.75215 9.24484 2.93584C9.58666 2.98388 9.9027 2.74573 9.95074 2.40391C9.99878 2.06209 9.76062 1.74605 9.4188 1.69801C7.85037 1.47758 6.25242 1.75934 4.85397 2.50291C3.45552 3.24648 2.32836 4.41369 1.63405 5.83724C0.93974 7.26079 0.713917 8.8676 0.988949 10.4274C1.26398 11.9872 2.02575 13.4198 3.16507 14.5201C4.30439 15.6203 5.76278 16.3316 7.33121 16.552C8.89964 16.7725 10.4976 16.4907 11.896 15.7471C13.2945 15.0036 14.4216 13.8364 15.116 12.4128C15.8103 10.9893 16.0361 9.38244 15.7611 7.82266C15.7011 7.48273 15.377 7.25574 15.037 7.31568C14.6971 7.37562 14.4701 7.69979 14.5301 8.03972C14.7592 9.33954 14.5711 10.6785 13.9925 11.8648C13.4139 13.0511 12.4746 14.0238 11.3092 14.6434C10.1438 15.2631 8.8122 15.4979 7.50518 15.3142C6.19815 15.1305 4.98283 14.5378 4.03339 13.6209C3.08396 12.704 2.44915 11.5101 2.21996 10.2103C1.99077 8.9105 2.17895 7.57149 2.75754 6.3852C3.33614 5.19891 4.27543 4.22624 5.44081 3.6066Z" fill="#23213D" />
                                <path d="M6.90791 6.36581C7.4906 6.05599 8.15641 5.93859 8.80992 6.03043C9.15174 6.07847 9.46778 5.84031 9.51582 5.4985C9.56386 5.15668 9.32571 4.84064 8.98389 4.7926C8.06897 4.66401 7.13683 4.82837 6.32107 5.26212C5.50531 5.69587 4.8478 6.37674 4.44278 7.20714C4.03777 8.03755 3.90604 8.97486 4.06647 9.88473C4.22691 10.7946 4.67127 11.6303 5.33588 12.2721C6.00048 12.9139 6.85121 13.3289 7.76612 13.4574C8.68104 13.586 9.61318 13.4217 10.4289 12.9879C11.2447 12.5542 11.9022 11.8733 12.3072 11.0429C12.7122 10.2125 12.844 9.27518 12.6835 8.36531C12.6236 8.02537 12.2994 7.79839 11.9595 7.85833C11.6196 7.91827 11.3926 8.24243 11.4525 8.58237C11.5671 9.23228 11.473 9.90178 11.1837 10.4949C10.8944 11.0881 10.4248 11.5744 9.84211 11.8842C9.25942 12.194 8.5936 12.3115 7.94009 12.2196C7.28658 12.1278 6.67892 11.8314 6.2042 11.373C5.72948 10.9145 5.41208 10.3176 5.29748 9.66767C5.18289 9.01776 5.27698 8.34826 5.56628 7.75511C5.85557 7.16196 6.32522 6.67563 6.90791 6.36581Z" fill="#23213D" />
                            </svg>
                            <span>Профессия за 30 дней</span>
                        </a>
                        <a class="linnav <?= Yii::$app->controller->action->id === 'career' ? 'linnavActive' : '' ?>" href="<?= Url::to(['career']) ?>">
                            <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.875 2.5V1.875C5.875 0.839466 6.71447 0 7.75 0L10.25 0C11.2855 0 12.125 0.839466 12.125 1.875V2.5H15.25C16.2855 2.5 17.125 3.33947 17.125 4.375V6.69271C17.125 7.23694 16.8898 7.74202 16.4991 8.09117C16.4997 8.10237 16.5 8.11365 16.5 8.125V13.125C16.5 14.1605 15.6605 15 14.625 15H3.375C2.33947 15 1.5 14.1605 1.5 13.125L1.5 8.125C1.5 8.11365 1.5003 8.10237 1.5009 8.09117C1.11016 7.74201 0.875 7.23694 0.875 6.69271L0.875 4.375C0.875 3.33947 1.71447 2.5 2.75 2.5H5.875ZM7.125 1.875C7.125 1.52982 7.40482 1.25 7.75 1.25H10.25C10.5952 1.25 10.875 1.52982 10.875 1.875V2.5L7.125 2.5V1.875ZM10.8214 10.447L15.25 8.70721V13.125C15.25 13.4702 14.9702 13.75 14.625 13.75H3.375C3.02982 13.75 2.75 13.4702 2.75 13.125L2.75 8.70721L7.17862 10.447C7.37911 11.2667 8.11852 11.875 9 11.875C9.88148 11.875 10.6209 11.2667 10.8214 10.447ZM9.625 9.98574C9.62481 9.99393 9.62478 10.0021 9.62492 10.0104C9.61939 10.3508 9.34172 10.625 9 10.625C8.65828 10.625 8.38061 10.3508 8.37508 10.0104C8.37522 10.0021 8.37519 9.99393 8.375 9.98574V9.375H9.625V9.98574ZM10.875 9.08296L15.4785 7.27443C15.7177 7.18047 15.875 6.94969 15.875 6.69271V4.375C15.875 4.02982 15.5952 3.75 15.25 3.75L2.75 3.75C2.40482 3.75 2.125 4.02982 2.125 4.375V6.69271C2.125 6.94969 2.28229 7.18047 2.52147 7.27443L7.125 9.08296V8.75C7.125 8.40482 7.40482 8.125 7.75 8.125H10.25C10.5952 8.125 10.875 8.40482 10.875 8.75V9.08296Z" fill="#23213D" />
                            </svg>
                            <span>Карьера</span>
                        </a>
                        <a class="linnav <?= Yii::$app->controller->action->id === 'prepodavanie' ? 'linnavActive' : '' ?>" href="<?= Url::to(['prepodavanie']) ?>">
                            <svg width="18" height="16" viewBox="0 0 18 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.625 1.25C14.625 1.03339 14.5128 0.832223 14.3286 0.718344C14.1443 0.604465 13.9142 0.594112 13.7205 0.690984L13.7198 0.691318L13.7187 0.691881L13.7151 0.693692L13.7027 0.699994C13.6921 0.705368 13.677 0.713068 13.6579 0.722941C13.6198 0.742676 13.5654 0.771149 13.4986 0.807128C13.3653 0.878937 13.1808 0.981421 12.9753 1.10469C12.6262 1.31419 12.1803 1.60487 11.8267 1.92229L5.86551 3.11452L5.84832 3.11182C5.76206 3.09836 5.6397 3.08085 5.49066 3.0638C5.19406 3.02989 4.78451 2.99696 4.33952 3.00316C3.89821 3.00931 3.39844 3.05413 2.93099 3.1877C2.46771 3.32007 1.98074 3.55572 1.63735 3.98408C1.35988 4.3302 1.16094 4.67208 1.0367 5.05684C0.913673 5.43783 0.875 5.82684 0.875 6.25C0.875 6.67316 0.913673 7.06218 1.0367 7.44316C1.16094 7.82792 1.35988 8.1698 1.63735 8.51593C1.98074 8.94428 2.46771 9.17993 2.93099 9.3123C3.32783 9.4257 3.74798 9.47513 4.13586 9.49123L5.26213 15.1226C5.32056 15.4147 5.57707 15.625 5.87499 15.625H7.74999C8.09517 15.625 8.37499 15.3452 8.37499 15V9.88738L11.8267 10.5777C12.1803 10.8951 12.6262 11.1858 12.9753 11.3953C13.1808 11.5186 13.3653 11.6211 13.4986 11.6929C13.5654 11.7289 13.6198 11.7573 13.6579 11.7771C13.677 11.7869 13.6921 11.7946 13.7027 11.8L13.7151 11.8063L13.7205 11.809C13.9142 11.9059 14.1443 11.8955 14.3286 11.7817C14.5128 11.6678 14.625 11.4666 14.625 11.25V8.75C16.0057 8.75 17.125 7.63071 17.125 6.25C17.125 4.86929 16.0057 3.75 14.625 3.75V1.25ZM7.12499 9.63738L5.86551 9.38548L5.84832 9.38818C5.76206 9.40165 5.6397 9.41915 5.49066 9.4362C5.46199 9.43948 5.43227 9.44274 5.40157 9.44597L6.38737 14.375H7.12499V9.63738ZM15.875 6.25C15.875 6.94036 15.3154 7.5 14.625 7.5V5C15.3154 5 15.875 5.55964 15.875 6.25ZM12.5669 2.94194C12.7687 2.74014 13.069 2.52286 13.375 2.32724V10.1728C13.069 9.97715 12.7687 9.75986 12.5669 9.55806C12.4797 9.47081 12.3686 9.41134 12.2476 9.38714L6.5 8.23762V4.26238L12.2476 3.11286C12.3686 3.08866 12.4797 3.02919 12.5669 2.94194ZM2.61265 4.76593C2.73357 4.61508 2.94751 4.483 3.27442 4.38959C3.59715 4.29738 3.97683 4.25834 4.35695 4.25304C4.68791 4.24843 5.00141 4.26953 5.25 4.29502V8.20499C5.00141 8.23047 4.68791 8.25157 4.35695 8.24696C3.97683 8.24166 3.59715 8.20262 3.27442 8.11041C2.94751 8.017 2.73357 7.88492 2.61265 7.73408C2.40735 7.47798 2.29378 7.26828 2.22622 7.05905C2.15744 6.84606 2.125 6.59868 2.125 6.25C2.125 5.90132 2.15744 5.65395 2.22622 5.44095C2.29378 5.23172 2.40735 5.02202 2.61265 4.76593Z" fill="#23213D" />
                            </svg>
                            <span>Преподавание</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="tel_header">
            <a class="log" href="<?= Url::to(['index']) ?>">skill.force</a>
            <div class="iconBurg">
                <img class="menushow" src="<?= Url::to(['/img/burg.webp']) ?>" alt="Burger Menu">
                <img class="menuclose" src="<?= Url::to(['/img/closeburg.webp']) ?>" alt="Burger Menu">
            </div>
            <nav class="menushows">
                <a href="<?= Url::to(['/']) ?>">MYFORCE</a>
                <a href="<?= Url::to(['/club']) ?>"> Клуб MYFORCE </a>
                <hr>
                <a class="<?= Yii::$app->controller->action->id == 'index' ? 'linkgroupActive' : '' ?>" href="<?= Url::to(['index']) ?>">Главная</a>
                <a class="<?= Yii::$app->controller->action->id == 'webinars' ? 'linkgroupActive' : '' ?>" href="<?= Url::to(['webinars']) ?>">Вебинары</a>
                <a class="<?= Yii::$app->controller->action->id == 'intensive' ? 'linkgroupActive' : '' ?>" href="<?= Url::to(['intensive']) ?>">Интенсивы</a>
                <a class="<?= Yii::$app->controller->action->id == 'profession' ? 'linkgroupActive' : '' ?>" href="<?= Url::to(['profession']) ?>">Профессия за 30 дней</a>
                <a class="<?= Yii::$app->controller->action->id == 'career' ? 'linkgroupActive' : '' ?>" href="<?= Url::to(['career']) ?>">Карьера</a>
                <a class="<?= Yii::$app->controller->action->id == 'teaching' ? 'linkgroupActive' : '' ?>" href="<?= Url::to(['/skill/teaching']) ?>">Преподавание</a>
                <a class="<?= Yii::$app->controller->action->id == 'about' ? 'linkgroupActive' : '' ?>" href="<?= Url::to(['about']) ?>">О проекте</a>
                <?php if (!$guest) : ?>
                    <div class="butgroop">
                        <?= Html::a('Выход', 'https://myforce.ru/site/logout/', ['class' => 'enter']) ?>
                        <?= Html::a('Кабинет', 'https://user.myforce.ru/', ['class' => 'register']) ?>
                    </div>
                <?php else : ?>
                    <div class="butgroop">
                        <?= Html::a('Войти', '/registr', ['class' => 'enter']) ?>
                        <?= Html::a('Регистрация', '/registr', ['class' => 'register']) ?>
                    </div>
                <?php endif; ?>
            </nav>
        </div>
    </div>

    <div><?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?></div>
    <div><?= Alert::widget() ?></div>
    <div><?= $content ?></div>

    <?php if (Yii::$app->controller->action->id !== 'profession') : ?>
        <?php if (!empty($arr)) : ?>
            <section style="<?php if (Yii::$app->controller->action->id === 'index') : ?> background-color: white <?php endif; ?>" class="cp-s8">
                <div class="container">
                    <h2 class="cp-s8__title title">
                        Выберите свой курс
                    </h2>
                    <div class="cp-s8__inner">
                        <?php foreach ($arr as $k => $v) : ?>
                            <?php if (!empty($v)) : ?>
                                <div class="cp-s8__box">
                                    <p class="cp-s8__article">
                                        <?= $k ?>
                                    <ul class="cp-s8__list">
                                        <?php foreach ($v as $key => $val) : ?>
                                            <li class="cp-s8__item"><a href="<?= Url::to(['coursepage', 'link' => $val['link']]) ?>" class="cp-s8__link"><?= $val['name'] ?></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <a href="<?= Url::to(['profession']) ?>" class="cp-s8__box-link link">
                        Перейти в каталог
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.6264 3.95891C11.0169 3.56838 11.6501 3.56838 12.0406 3.95891L17.3739 9.29224C17.7645 9.68277 17.7645 10.3159 17.3739 10.7065L12.0406 16.0398C11.6501 16.4303 11.0169 16.4303 10.6264 16.0398C10.2359 15.6493 10.2359 15.0161 10.6264 14.6256L14.2526 10.9993H3.3335C2.78121 10.9993 2.3335 10.5516 2.3335 9.99935C2.3335 9.44706 2.78121 8.99935 3.3335 8.99935H14.2526L10.6264 5.37312C10.2359 4.9826 10.2359 4.34943 10.6264 3.95891Z" fill="#4135F1" />
                        </svg>
                    </a>
                </div>
            </section>
        <?php endif; ?>
    <?php endif; ?>
    <footer class="footer">
        <div class="container">
            <div class="footer__inner">
                <div class="footer__item footer__item--big">
                    <a href="<?= Url::to(['/skill']) ?>" class="footer__logo">
                        <img src="<?= Url::to(['/img/footerlogo.png']) ?>" alt="logo" />
                    </a>

                    <ul class="footer__social">
                        <li class="footer__social-item">
                            <a href="<?= Url::to('https://www.instagram.com/myforce.ru/') ?>" class="footer__social-link" target="_blank">
                                <img src="<?= Url::to(['/img/ig-circle.svg']) ?>" alt="instagram logo" />
                            </a>
                        </li>
                        <!--            <li class="footer__social-item">-->
                        <!--              <a href="--><? //= Url::to(['#'])
                                                        ?>
                        <!--" class="footer__social-link">-->
                        <!--                <img src="-->
                        <? //= Url::to(['/img/ok-circle.svg'])
                        ?>
                        <!--" alt="OK logo" />-->
                        <!--              </a>-->
                        <!--            </li>-->
                        <li class="footer__social-item">
                            <a href="<?= Url::to('https://t.me/myforce_business') ?>" target="_blank" class="footer__social-link">
                                <img src="<?= Url::to(['/img/tg-circle.svg']) ?>" alt="telegram logo" />
                            </a>
                        </li>
                        <!--            <li class="footer__social-item">-->
                        <!--              <a href="--><? //= Url::to(['#'])
                                                        ?>
                        <!--" class="footer__social-link">-->
                        <!--                <img src="-->
                        <? //= Url::to(['/img/whatsapp-circle.svg'])
                        ?>
                        <!--" alt="whatsapp logo" />-->
                        <!--              </a>-->
                        <!--            </li>-->
                        <!--            <li class="footer__social-item">-->
                        <!--              <a href="--><? //= Url::to(['#'])
                                                        ?>
                        <!--" class="footer__social-link">-->
                        <!--                <img src="-->
                        <? //= Url::to(['/img/vk-circle.svg'])
                        ?>
                        <!--" alt="vk logo" />-->
                        <!--              </a>-->
                        <!--            </li>-->
                        <li class="footer__social-item">
                            <a href="<?= Url::to('https://www.tiktok.com/@skill_force?_d=secCgYIASAHKAESMgowYnN9r9%2Bc%2FlQol2f8WGa5%2BtoWx2DlAr5DwAVHm%2FX3iSEZHIIe1nzgPVgZIKgYtpXUGgA%3D&checksum=e4dcfee0c613c5df9f6af8965a3cb1fedc8f5425ead43bc39ceae3b21341b824&language=ru&sec_uid=MS4wLjABAAAAtXzppLzKjsRNMwpIBXh2Gre7h_EnXW3W5fqdW0OGF0peRWH1jZFdxImbjoJaJnWM&sec_user_id=MS4wLjABAAAABkyHW0z6H2Pa_n6t4j3JBdxaSCNxPLQtP9O_bji5B15mpPzdhqdH7u6rYvJVvPmj&share_app_id=1233&share_author_id=6987481267394774017&share_link_id=305E3400-7AE0-4D3C-99F6-A2A052BB7B01&tt_from=copy&u_code=d45afdmgik5fe4&user_id=6645337629532848134&utm_campaign=client_share&utm_medium=ios&utm_source=copy&source=h5_m&_r=1') ?>" target="_blank" class="footer__social-link">
                                <img src="<?= Url::to(['/img/tt-circle.svg']) ?>" alt="tiktok logo" />
                            </a>
                        </li>
                    </ul>

                    <button type="button" class="footer__link popup-link">Подписаться на рассылку</button>
                    <a href="<?= Url::to(['/policy.pdf']) ?>" target="_blank" class="footer__link-copy">
                        *отправляя формы на данном сайте, вы даете согласие на обработку персональных данных в
                        соответствии с 152-ФЗ
                    </a><br>
                    <a href="<?= Url::to(['/oferta.pdf?v=16']) ?>" target="_blank" class="footer__link-copy">Договор публичной оферты</a><br>
                    <a href="<?= Url::to(['/oferta-diarova.pdf?v=16']) ?>" target="_blank" class="footer__link-copy">Договор оферты</a>
                </div>

                <div class="footer__item">
                    <p class="footer__item-title">Меню</p>
                    <ul class="footer__item-list">
                        <li class="footer__item-li">
                            <a href="<?= Url::to(['/skill']) ?>" class="footer__item-link">
                                Главная
                            </a>
                        </li>
                        <li class="footer__item-li">
                            <a href="<?= Url::to(['/skill/webinars']) ?>" class="footer__item-link">
                                Вебинары
                            </a>
                        </li>
                        <li class="footer__item-li">
                            <a href="<?= Url::to(['/skill/intensive']) ?>" class="footer__item-link">
                                Интенсивы
                            </a>
                        </li>
                        <li class="footer__item-li">
                            <a href="<?= Url::to(['/skill/profession']) ?>" class="footer__item-link">
                                Профессия за 30 дней
                            </a>
                        </li>
                        <li class="footer__item-li">
                            <a href="<?= Url::to(['/skill/career']) ?>" class="footer__item-link">
                                Карьера
                            </a>
                        </li>
                        <li class="footer__item-li">
                            <a href="<?= Url::to(['/skill/teaching']) ?>" class="footer__item-link">
                                Преподавание
                            </a>
                        </li>
                        <li class="footer__item-li">
                            <a href="<?= Url::to(['/skill/about']) ?>" class="footer__item-link">
                                О проекте
                            </a>
                        </li>
                        <li class="footer__item-li">
                            <a href="<?= Url::to(['/skill/blog']) ?>" class="footer__item-link">
                                Блог
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="footer__item">
                    <p class="footer__item-title">Другие проекты</p>
                    <ul class="footer__item-list">
                        <li class="footer__item-li">
                            <a href="<?= Url::to(['/femida/franchizes']) ?>" class="footer__item-link">
                                Франшиза
                            </a>
                        </li>
                        <!-- <li class="footer__item-li">
              <a href="<?= Url::to(['#']) ?>" class="footer__item-link">
                Реклама
              </a>
            </li> -->
                        <li class="footer__item-li">
                            <a href="<?= Url::to(['/lead']) ?>" class="footer__item-link">
                                Лидогенерация
                            </a>
                        </li>
                        <!-- <li class="footer__item-li">
              <a href="<?= Url::to(['#']) ?>" class="footer__item-link">
                Разработка
              </a>
            </li> -->
                        <!-- <li class="footer__item-li">
              <a href="<?= Url::to(['#']) ?>" class="footer__item-link">
                Арбитражное управление
              </a>
            </li> -->
                    </ul>
                </div>

                <div class="footer__item footer__item--big">
                    <div class="footer__phone">
                        <a class="footer__phone-link" href="tel:84951183934">
                            8 495 118 39 34
                        </a>
                        <p class="footer__text">Бесплатный звонок для всех городов России</p>
                    </div>

                    <div class="footer__mail">
                        <a class="footer__mail-link" href="mailto:general@myforce.ru">
                            general@myforce.ru
                        </a>
                    </div>

                    <address class="footer__address">
                        <p class="footer__address-text">
                            344000, Россия, г. Ростов-на-Дону, пр-т Ворошиловский , д 82/4. оф. 99, 7 этаж
                        </p>
                        <p class="footer__address-text">
                            ИНН: 6167130086
                        </p>
                        <p class="footer__address-text">
                            ОГРН: 1156196049415
                        </p>
                    </address>
                </div>
            </div>
        </div>
    </footer>

    <div id="consult" class="popup">
        <div class="popup__body">
            <div class="popup__content">
                <div class="popup__close">
                    <img src="<?= Url::to(['/img/mainimg/close.png']) ?>" alt="иконка закрыть" />
                </div>
                <?= Html::beginForm('', 'post', ['class' => 'popup__form']) ?>
                <input type="hidden" name="URL" value="<?= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
                <input type="hidden" name="formType" value="Подписка на рассылку">
                <input type="hidden" name="pipeline" value="104">
                <input type="hidden" name="utm_source" value="<?= $_SESSION['utm_source'] ?>">
                <input type="hidden" name="utm_campaign" value="<?= $_SESSION['utm_campaign'] ?>">
                <input type="hidden" name="service" value="">
                <input type="hidden" name="section" value="Подписка на рассылку со страницы:<?= $this->title ?>">
                <input type="hidden" name="ip" value="<?= $_SERVER['REMOTE_ADDR'] ?>">
                <div class="popup__step step1">
                    <p class="popup__title">
                        Получать рассылку
                    </p>
                    <p class="popup__text">
                        Оставьте свои данные для получения рассылки с новыми курсами на почту
                    </p>

                    <div class="popup__inputs">
                        <label class="popup__label" aria-label="Введите ФИО">
                            <input type="text" name="name" class="popup__input" placeholder="ФИО" required />
                        </label>

                        <label class="popup__label" aria-label="Введите почту">
                            <input type="email" name="email" class="popup__input" placeholder="Почта" required />
                        </label>
                    </div>

                    <div class="popup__box">
                        <button class="popup__btn btn" type="submit">Отправить</button>
                        <p class="popup__policy">
                            Нажимая на кнопку «Отправить», я соглашаюсь с условиями обработки <a href="<?= Url::to(['/policy.pdf']) ?>" target="_blank">персональных данных</a>
                        </p>
                    </div>
                </div>

                <div class="popup__step step2">
                    <p class="popup__title">
                        Спасибо за подписку!
                    </p>
                    <p class="popup__text">
                        Мы отправили информацию по подобранным курсам вам на почту
                    </p>
                    <div class="popup__img">
                        <img src="<?= Url::to(['/img/mainimg/popup-img.png']) ?>" alt="картинка ноутбука" />
                    </div>
                </div>
                <?= Html::endForm() ?>
            </div>
        </div>
    </div>
    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>