<?php
/* @var $this yii\web\View */

use yii\helpers\Url;
use common\models\helpers\UrlHelper;

$guest = Yii::$app->user->isGuest;
$this->title = $author->name;

$js = <<<JS

JS;
$this->registerJs($js);

$countStudents = 0;
foreach ($author->skillTrainings as $v) {
    $countStudents += $v['students'];
}
$CookieName = "AuthorStudents{$author->id}";
if (empty($_COOKIE[$CookieName])){
    $studentsCol = rand(100,200) + $countStudents;
    setcookie($CookieName, $studentsCol, time()+3600*24*30*12*10);
}
?>
<main class="main">
    <section class="gu-s1">
        <div class="container">
            <div class="gu-s1__inner">
                <div class="gu-s1__content">
                    <a href="<?= !empty($_GET['back']) ? Url::to(['coursepage', 'link' => $_GET['back']]) : Url::to(['/skill']) ?>"
                       class="cp-s1__nav">
                        Вернуться к каталогу
                        <svg width="16" height="13" viewBox="0 0 16 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M7.37361 12.5401C6.98309 12.9306 6.34992 12.9306 5.9594 12.5401L0.626065 7.20678C0.235541 6.81626 0.235541 6.18309 0.626065 5.79257L5.9594 0.459234C6.34992 0.0687095 6.98309 0.0687096 7.37361 0.459234C7.76414 0.849758 7.76414 1.48292 7.37361 1.87345L3.74739 5.49967L14.6665 5.49967C15.2188 5.49967 15.6665 5.94739 15.6665 6.49967C15.6665 7.05196 15.2188 7.49967 14.6665 7.49967L3.74739 7.49967L7.37361 11.1259C7.76414 11.5164 7.76414 12.1496 7.37361 12.5401Z"
                                  fill="#5C687E"/>
                        </svg>
                    </a>
                    <h1 class="gu-s1__title">
                        <?= $author->name ?>
                    </h1>
                    <p class="gu-s1__subtitle">
                        <?= $author->small_description ?>
                    </p>
                    <div class="gu-s1__plus">
                        <div class="gu-s1__item">
                            <?php $countTraining = count($author->skillTrainings) ?>
                            <p class="gu-s1__num gu-s1__num--1"><?= $countTraining ?></p>
                            <?php
                            if ($countTraining === 1) {
                                $textTrainings = 'курс';
                            } elseif ($textTrainings < 5) {
                                $textTrainings = 'курса';
                            } else {
                                $textTrainings = 'курсов';
                            }
                            ?>
                            <p class="gu-s1__text"><?= $textTrainings ?></p>
                        </div>

                        <div class="gu-s1__item">
                            <p class="gu-s1__num gu-s1__num--2"><?= empty($_COOKIE[$CookieName]) ? $studentsCol : $_COOKIE[$CookieName] ?></p>
                            <p class="gu-s1__text">студента</p>
                        </div>

                        <div class="gu-s1__item gu-s1__item--3 ">
                            <p class="gu-s1__num"><?= $author->practice ?></p>
                            <p class="gu-s1__text">лет опыта</p>
                        </div>
                    </div>
                </div>
                <div class="gu-s1__img">
                    <img src="<?= UrlHelper::admin($author->photo) ?>" alt="фото преподователя"/>
                </div>
            </div>
        </div>
    </section>

    <section class="gu-s2">
        <div class="container">
            <div class="gu-s2__inner">
                <div class="gu-s2__video">
                    <?php
                        parse_str($new = parse_url($author->video, PHP_URL_QUERY), $link);
                    ?>
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $link['v'] ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

                </div>
                <div class="gu-s2__content">
                    <p class="gu-s2__hi">
                        Привет!
                    </p>
                    <p class="gu-s2__title title">
                        Я — <?= $author->name ?>
                    </p>
                    <p class="gu-s2__text">
                        <?= $author->about ?>
                    </p>
                    <p class="gu-s2__plus">
                        <?= $author->small_description ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="he-s6 gu-s3">
        <div class="container">
            <?php if (!empty($author->skillTrainings)): ?>
            <h2 class="he-s6__title gu-s3__title title">
                Курсы от автора
            </h2>
            <div class="he-s6__inner gu-s3__inner">
                <?php foreach ($author->skillTrainings as $k => $v): ?>
                    <div class="he-s6__item">
                        <a href="<?= Url::to(['coursepage', 'link' => $v['link']]) ?>" class="he-s6__link link">
                            Подробнее о курсе
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M10.6264 3.95891C11.0169 3.56838 11.6501 3.56838 12.0406 3.95891L17.3739 9.29224C17.7645 9.68277 17.7645 10.3159 17.3739 10.7065L12.0406 16.0398C11.6501 16.4303 11.0169 16.4303 10.6264 16.0398C10.2359 15.6493 10.2359 15.0161 10.6264 14.6256L14.2526 10.9993H3.3335C2.78121 10.9993 2.3335 10.5516 2.3335 9.99935C2.3335 9.44706 2.78121 8.99935 3.3335 8.99935H14.2526L10.6264 5.37312C10.2359 4.9826 10.2359 4.34943 10.6264 3.95891Z"
                                      fill="#4135F1"/>
                            </svg>
                        </a>
                        <div class="he-s6__img">
                            <img src="<?= UrlHelper::admin($v['preview_logo']) ?>" alt="фото"/>
                        </div>
                        <div class="he-s6__info">
                            <?php $tags = explode(';', $v['tags']) ?>
                            <?php foreach ($tags as $key => $val): ?>
                                <?php if (strlen($val) > 0): ?>
                                    <span class="he-s6__teg  <?php if ($key === 0): ?> teg-b <?php elseif ($key % 2 == 0): ?>teg-i <?php else: ?>teg-s<?php endif; ?>"><?= $val ?></span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                        <h3 class="he-s6__item-title">
                            <?= $v['name'] ?>
                        </h3>
                        <p class="he-s6__time">
                            Старт <?= date('d.m.Y', strtotime($v['date_meetup'])) ?>
                        </p>
<?php if ($guest): ?>
                            <a href="<?= Url::to(['registr']) ?>" class="he-s6__btn btn btn--blue">
                                Записаться
                            </a>
<?php else: ?>
                            <a href="<?= Url::to('https://user.myforce.ru/') ?>" class="he-s6__btn btn btn--blue">
                                Записаться
                            </a>
<?php endif; ?>
                    </div>

                <?php endforeach; ?>
            </div>
            <?php endif; ?>
            <?php if (!empty($author->comment_article)): ?>
                <div class="gu-s3__comment">
                    <div class="gu-s3__comment-inner">
                        <div class="gu-s3__img">
                            <img src="<?= UrlHelper::admin($author->photo) ?>" alt="фото"/>
                        </div>
                        <div class="gu-s3__content">
                            <h2 class="gu-s3__comment-title title">
                                <?= $author->comment_article ?>
                            </h2>
                            <p class="gu-s3__text">
                                <?= $author->comment_text ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <div class="S3">
        <div class="S3C">
            <p class="S3C-t1">Больше о новых курсах и акциях на нашем канале</p>
            <div class="S3C__inner">
                <img src="<?= Url::to(['/img/tg-circle.svg']) ?>">
                <a href="<?= Url::to('https://t.me/myforce_business') ?>" class="uscp S3C-telegramm">
                    <p>Подписаться</p>
                    <img src="<?= Url::to(['/img/ArrowRightteleg.svg']) ?>">
                </a>
            </div>
        </div>
    </div>

</main> 
