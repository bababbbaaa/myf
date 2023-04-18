<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\helpers\UrlHelper;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Блог SKILL.FORCE';

$js = <<<JS

    $('.filterForm').on('submit', function(e) {
      e.preventDefault();
        $.pjax.reload({
          container: '#blogArticle',
          url: "blog",
          type: "GET",
          data: $('.filterForm').serialize(),
        });
    });

    $('.bg-s2__nav').on('mouseup', '.bg-s2__link', function() {
    setTimeout(function() {
      $('.filterForm').submit();
    }, 300)
       
    });
JS;
$this->registerJs($js);

$css =<<< CSS
.pagination{
    display: flex;
    column-gap: 15px;
}
.next:before, .prev:before {
    content: "";
}
.pagination a, .pagination span{
    border-radius: 5px;
    display: block;
    width: 30px;
    height: 30px;
    padding: 3px 0 !important;
    text-align: center;
}
.pagination .active a{
    background-color: #3337b7;
    border-color: #3337b7;
}
CSS;
$this->registerCss($css);

?>
<main class="main">
    <section class="bg-s1">
        <div class="container">
            <div class="bg-s1__inner">
                <h1 class="bg-s1__title">
                    Блог <br> SKILL.FORCE
                </h1>
            </div>
        </div>
    </section>
    <section class="bg-s2">
        <div class="container">
            <div class="bg-s2__search">
                <?= Html::beginForm('', 'get', ['id' => 'filterForm', 'class' => 'filterForm']) ?>
                <div class="CS2C__BTop df jcsb">
                    <label class="df InpSearch">
                        <input minlength="1" placeholder="продажи" type="text" name="Search" class="Search__inp"
                               id="qwe">
                        <img class="SearchBackIcon1" src="<?= Url::to(['/img/Search.svg']) ?>" alt="иконка поиска">
                        <img class="SearchBackIcon2" src="<?= Url::to(['/img/SearchFOCUS.svg']) ?>" alt="">
                    </label>
                    <p class="CS2C__BTop-t">
                        Количество: <span class="NumHowMany"><?= $newsCount ?></span>
                    </p>
                </div>
                <?= Html::endForm(); ?>
            </div>

            <div class="bg-s2__nav">
                <label class="bg-s2__link link-active">
                    <input form="filterForm" type="radio" style="display: none" name="date" value="all">
                    Все
                </label>
                <label class="bg-s2__link">
                    <input form="filterForm" type="radio" style="display: none" name="date" value="day">
                    За сутки
                </label>
                <label class="bg-s2__link">
                    <input form="filterForm" type="radio" style="display: none" name="date" value="week">
                    За неделю
                </label>
                <label class="bg-s2__link">
                    <input form="filterForm" type="radio" style="display: none" name="date" value="month">
                    За месяц
                </label>
                <label class="bg-s2__link">
                    <input form="filterForm" type="radio" style="display: none" name="date" value="year">
                    За год
                </label>
            </div>


            <?php if (!empty($newsNew)): ?>
                <div class="bg-s2__naw">
                    <div class="bg-s2__naw-inner">
                        <div class="bg-s2__naw-img">
                            <img src="<?= UrlHelper::admin($newsNew['og_image']) ?>" alt="<?= $newsNew['title'] ?>"/>
                        </div>
                        <div class="bg-s2__new-content">
                            <span class="bg-s2__naw-info">новое</span>
                            <h2 class="bg-s2__naw-title">
                                <a href="<?= Url::to(['article', 'link' => $newsNew['link']]) ?>"><?= $newsNew['title'] ?></a>
                            </h2>
                            <time data-time="02-04-2021"
                                  class="bg-s2__naw-time"><?= date('d.m.Y', strtotime($newsNew['date'])) ?></time>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
                <?php Pjax::begin(['id' => 'blogArticle']) ?>
            <?php if (!empty($news)): ?>
                <div class="bg-s2__category">
                    <?php foreach ($news as $k => $v): ?>
                        <div class="bg-s2__item" data-cat="teg-p">
                            <div class="bg-s2__item-img">
                                <img src="<?= UrlHelper::admin($v['og_image']) ?>" alt="<?= $v['title'] ?>"/>
                            </div>
                            <div class="bg-s2__item-content">
                                <h3 class="bg-s2__item-title">
                                    <a data-pjax="0"
                                       href="<?= Url::to(['article', 'link' => $v['link']]) ?>"><?= $v['title'] ?></a>
                                </h3>
                                <time data-time="02-04-2021"
                                      class="bg-s2__time"><?= date('d.m.Y', strtotime($v['date'])) ?></time>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?= LinkPager::widget([
                    'pagination' => $pages,
                ]); ?>
            <?php else: ?>
                <div class="CS2C__BB__R-ERROR_OB">
                    <div class="CS2C__BB__R-ERROR df fdc">
                        <p class="CS2C__BB__R-ERROR-t1">По вашему запросу ничего не нашлось</p>
                        <p class="CS2C__BB__R-ERROR-t2">Попробуйте ввести запрос по-другому</p>
                        <img src="<?= Url::to(['/img/CatError.svg']) ?>">
                    </div>
                </div>
            <?php endif; ?>
                <?php Pjax::end() ?>

        </div>
    </section>

</main> 
