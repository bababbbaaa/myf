<?php


/* @var $this yii\web\View */
use yii\helpers\Url;
use common\models\helpers\UrlHelper;
$this->title = $news['og_title'];

$js = <<<JS
// Нумерация списка ol
const li = document.querySelectorAll('ol li');

li.forEach((value, i) => {
    const liDiv = document.createElement('div');
    liDiv.classList.add('page-number');
    liDiv.innerHTML = i + 1;
    value.prepend(liDiv);
});

JS;



$css =<<< CSS
    .header {
        background: #000E1A;
        border-bottom: none;
    }

    .header__active {
        animation-name: none;
    }
CSS;
$this->registerCss($css);
$this->registerJs($js);
?>
<style>
.info p,
.info span,
.info li {
    font-family: "Rubik", sans-serif !important;
    font-weight: normal !important;
    font-size: 20px !important;
    line-height: 1.7 !important;
    color: #010101 !important;
    margin-bottom: 15px;
}

.info a {
    color: #df2c56 !important;
}

.info h3,h2 {
    font-weight: 600;
    font-size: 22px;
    line-height: 37px;
    text-transform: uppercase;
    color: #DF2C56;
    margin-bottom: 15px;
}

.info * {
    text-align: left !important;
}

.info ul {
    display: flex;
    flex-direction: column;
    gap: 30px;
    list-style-image: url(../img/mainimg/purple-marker.svg);
    margin-top: 6px;
    margin-bottom: 21px;
}

.info ol {
    list-style-type: none;
    padding-left: 73px;
}

.info ol li {
    position: relative;
    margin-top: 6px;
    margin-bottom: 21px;
}

.page-number {
    display: inline;
    font-weight: 600;
    font-size: 36px;
    text-transform: uppercase;
    color: #000E1A;
    position: absolute;
    top: -8px;
    left: -73px;
}

.info ul li {
    padding-left: 20px;
}

@media (max-width: 600px) {
    .info ul li {
        margin-bottom: 15px;
    }

    .newspage-main_sec-1 .ttl {
        font-size: 22px;
        line-height: 31px;
        margin-bottom: 12px;
    }

    .date {
        margin-bottom: 35px;
    }

    .info h2,h3 {
        font-size: 18px;
        line-height: 31px;
        margin-bottom: 23px;
    }

    .info p {
        font-size: 16px !important;
        line-height: 27px !important;
        margin-bottom: 20px !important;
    }

    .info ul li, .info ol li {
        font-size: 16px !important;
        line-height: 27px !important;
        margin-bottom: 20px !important;
        gap: 20px;
    }
}
</style>

<article class="newspage-main">
    <div class="container">
        <nav class="breadcrumbs">
            <a href="<?= Url::to(['/']) ?>">Главная</a>
            <img src="<?= Url::to(['img/mainimg/breadcrumbs.svg']) ?>" alt="разделитель">
            <a href="<?= Url::to(['news']) ?>">Новости</a>
            <img src="<?= Url::to(['img/mainimg/breadcrumbs.svg']) ?>" alt="разделитель">
            <a><?= $news['title'] ?></a>
        </nav>
        <div class="newspage-main_wrap">
            <section class="newspage-main_sec-1">
                <h1 class="ttl">
                    <?= $news['title'] ?>
                </h1>
                <p class="date"><?= date('d.m.Y', strtotime($news['date'])) ?></p>
                <div class="info">
                    <?= $news['content'] ?>
                    <div class="info__image">
                        <img src="<?= UrlHelper::admin($news['og_image']) ?>" alt="<?= $news['title'] ?>">
                    </div>
                    <p class="from">Автор: <?= $news['author'] ?></p>
                    <p class="from">Источник: <?= $news['source'] ?></p>


                </div>

            </section>
            <?php if (!empty($lastNews)): ?>
            <div class="OutherNews">
                <h3 class="More__news--main">Другие новости</h3>
                <ul class="outher-news__list">
                    <?php foreach ($lastNews as $k => $v): ?>
                    <li>
                        <a href="<?= Url::to(['news-page', 'link' => $v['link']]) ?>"><?= $v['title'] ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
        </div>
    </div>
</article>