<?php


/* @var $this yii\web\View */

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\widgets\Pjax;
use common\models\helpers\UrlHelper;

$this->title = 'Новости бизнеса';
$js =<<< JS
$('.FiltrBTN').on('click', function() {
    setTimeout(function() {
        $('.FormFiltr').submit();
    }, 500);
    
});
$('.FormFiltr').on('submit', function(e) {
    e.preventDefault();
    
    $.pjax.reload({
        container: '#Pjax_news',
        url: 'news',
        type: 'GET',
        data: $('.FormFiltr').serialize(),
    })
})
JS;
$this->registerJs($js);


$css =<<< CSS
    .header {
        background: #000E1A;
        border-bottom: none;
    }

    .header__active {
        animation-name: none;
    }
CSS;
$this->registerCss($css)
?>

<section class="newspage-main news">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="<?= Url::to(['/']) ?>">Главная</a>
            <img src="<?= Url::to(['img/mainimg/breadcrumbs.svg']) ?>" alt="разделитель">
            <a>Статьи для бизнеса</a>
        </nav>
        <?php if (!empty($news)) {
            ?>
        <div class="newspage-main_wrap">
            <div class="news-main_sec-wrap">
                <section class="newspage-main_sec-1">
                    <div class="news-main_row">
                        <?php Pjax::begin(['id' => 'Pjax_news']) ?>
                        <?php foreach ($news as $news_page): ?>
                        <?php $date = date('d.m.Y', strtotime($news_page['date'])) ?>
                        <?php if ($date == date('d.m.Y')) {
                                $dateStr = 'Сегодня';
                            } elseif ($date == date('d.m.Y', time() - (60 * 60 * 24))) {
                                $dateStr = 'Вчера';
                            } else $dateStr = $date; ?>
                        <article class="news-main_row-card hoverArticle">

                            <div class="infoG">
                                <div class="info__row">
                                    <h3 class="ttl h3ArticleTitle"><?= $news_page['title'] ?></h3>
                                    <p class="date"><?= $dateStr ?></p>
                                </div>
                                <p class="info">
                                    <?= mb_substr(strip_tags($news_page['content']), 0, 200) ?>...
                                    <a class="read-more"
                                        href="<?= Url::to(['news-page', 'link' => $news_page['link']]) ?> ">Читать
                                        далее</a>
                                </p>

                                <div class="info__control" style="display: none">
                                    <div class="likes">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M10.517 17.3417C10.2337 17.4417 9.76699 17.4417 9.48366 17.3417C7.06699 16.5167 1.66699 13.075 1.66699 7.24167C1.66699 4.66667 3.74199 2.58334 6.30033 2.58334C7.81699 2.58334 9.15866 3.31667 10.0003 4.45C10.842 3.31667 12.192 2.58334 13.7003 2.58334C16.2587 2.58334 18.3337 4.66667 18.3337 7.24167C18.3337 13.075 12.9337 16.5167 10.517 17.3417Z"
                                                fill="url(#paint0_linear_289_1804)"
                                                stroke="url(#paint1_linear_289_1804)" stroke-width="1.5"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                            <defs>
                                                <linearGradient id="paint0_linear_289_1804" x1="10.0003" y1="2.58334"
                                                    x2="10.0003" y2="17.4167" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#DF2C56" />
                                                    <stop offset="1" stop-color="#C81F47" />
                                                </linearGradient>
                                                <linearGradient id="paint1_linear_289_1804" x1="10.0003" y1="2.58334"
                                                    x2="10.0003" y2="17.4167" gradientUnits="userSpaceOnUse">
                                                    <stop stop-color="#DF2C56" />
                                                    <stop offset="1" stop-color="#C81F47" />
                                                </linearGradient>
                                            </defs>
                                        </svg>
                                        <span>0</span>
                                    </div>
                                    <div class="reposts">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none">
                                            <g opacity="0.5">
                                                <path
                                                    d="M6.16641 5.2667L13.2414 2.90836C16.4164 1.85003 18.1414 3.58336 17.0914 6.75836L14.7331 13.8334C13.1497 18.5917 10.5497 18.5917 8.96641 13.8334L8.26641 11.7334L6.16641 11.0334C1.40807 9.45003 1.40807 6.85836 6.16641 5.2667Z"
                                                    stroke="#000E1A" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M8.4248 11.3751L11.4081 8.38338" stroke="#000E1A"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </g>
                                        </svg>
                                        <span>0</span>
                                    </div>
                                    <div class="views">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="16"
                                            viewBox="0 0 22 16" fill="none">
                                            <g opacity="0.5">
                                                <path
                                                    d="M1.26805 8.71318C1.12971 8.49754 1.06054 8.38972 1.02181 8.22342C0.992729 8.0985 0.992729 7.9015 1.02181 7.77658C1.06054 7.61028 1.12971 7.50246 1.26805 7.28682C2.41127 5.50484 5.81418 1 11 1C16.1858 1 19.5887 5.50484 20.7319 7.28682C20.8703 7.50246 20.9395 7.61028 20.9782 7.77658C21.0073 7.9015 21.0073 8.0985 20.9782 8.22342C20.9395 8.38972 20.8703 8.49754 20.7319 8.71318C19.5887 10.4952 16.1858 15 11 15C5.81418 15 2.41127 10.4952 1.26805 8.71318Z"
                                                    stroke="#000E1A" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M11 11C12.6831 11 14.0475 9.65685 14.0475 8C14.0475 6.34315 12.6831 5 11 5C9.31692 5 7.95251 6.34315 7.95251 8C7.95251 9.65685 9.31692 11 11 11Z"
                                                    stroke="#000E1A" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </g>
                                        </svg>
                                        <span>0</span>
                                    </div>
                                    <div class="info__more">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34"
                                            viewBox="0 0 34 34" fill="none">
                                            <path
                                                d="M7.08333 14.1667C5.525 14.1667 4.25 15.4417 4.25 17C4.25 18.5583 5.525 19.8333 7.08333 19.8333C8.64167 19.8333 9.91667 18.5583 9.91667 17C9.91667 15.4417 8.64167 14.1667 7.08333 14.1667Z"
                                                stroke="#000E1A" stroke-width="1.5" />
                                            <path
                                                d="M26.9163 14.1667C25.358 14.1667 24.083 15.4417 24.083 17C24.083 18.5583 25.358 19.8333 26.9163 19.8333C28.4747 19.8333 29.7497 18.5583 29.7497 17C29.7497 15.4417 28.4747 14.1667 26.9163 14.1667Z"
                                                stroke="#000E1A" stroke-width="1.5" />
                                            <path
                                                d="M17.0003 14.1667C15.442 14.1667 14.167 15.4417 14.167 17C14.167 18.5583 15.442 19.8333 17.0003 19.8333C18.5587 19.8333 19.8337 18.5583 19.8337 17C19.8337 15.4417 18.5587 14.1667 17.0003 14.1667Z"
                                                stroke="#000E1A" stroke-width="1.5" />
                                        </svg>

                                    </div>
                                </div>

                            </div>
                        </article>
                        <?php endforeach; ?>
                    </div>
                    <nav>
                        <?= LinkPager::widget([
                                'pagination' => $pages,
                            ]); ?>
                    </nav>
                    <?php Pjax::end(); ?>
                </section>
            </div>
        </div>
        <?
        } else {
        ?>
        <p style="font-weight: 600; color: #df2c56 ">Новости ещё не добавлены</p>
        <?
        }?>

    </div>
</section>