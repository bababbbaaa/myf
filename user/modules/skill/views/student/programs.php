<?php

use admin\models\Admin;
use common\models\helpers\UrlHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\widgets\LinkPager;

$this->title = 'Выбрать программу';

$js = <<< JS
  $('.programs-filter-reset').on('click', function(){
    location.replace('programs');
  });

  $('.programs-filter-submit').on('mouseup', function(){
    setTimeout(function(){
      $('.programs-filter').submit();
    }, 300);
  });

  $('.programs-filter').on('submit', function (e) {
    $.pjax.reload({
        container: '#filter',
        url: "programs",
        method: "GET",
        data: $(this).serialize()
    });
    e.preventDefault();
  });
  
  $('.popup_buy').on('click', function() {
    Swal.fire({
        icon: 'question',
        title: 'Покупка курса',
        text: 'Вы уверены что хотите купить этот курс?',
    }).then(function(result) {
      if (result.value === true){
          console.log('Покупка курса');
      }
    })
  });
JS;
$this->registerJs($js);
?>

<section style="margin-bottom: 20px" class="rightInfo education">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
            <span class="bcr__link">
            Выбрать программу
            </span>
            </li>

            <li class="bcr__item">
            <span class="bcr__span">
            Все программы
            </span>
            </li>
        </ul>
    </div>
    <div class="title_row">
        <h1 class="Bal-ttl title-main">Выбрать программу</h1>
    </div>

    <div class="programs_wrapper">
        <section class="programs_left-filter">
            <label class="MyOrders_filter-check-l sendActive programs-filter-submit">
                Все направления
                <input form="programs-filter" class="MyOrders_filter-check" type="checkbox" name="category[]"
                       value="all">
            </label>
            <?php foreach ($category as $kay => $val): ?>
                <label class="MyOrders_filter-check-l sendActive programs-filter-submit">
                    <?= $val['name'] ?>
                    <input form="programs-filter" class="MyOrders_filter-check" type="checkbox" name="category[]"
                           value="<?= $val['id'] ?>">
                </label>
            <?php endforeach; ?>
        </section>
        <div class="programs_main-wrap">
            <section class="programs_main-wrap-filter">
                <?= Html::beginForm('', 'get', ['class' => 'programs-filter', 'id' => 'programs-filter']) ?>
                <div class="MyOrders_filter programs_filter">
                    <button class="MyOrders_filter-reset programs-filter-reset" type="reset"></button>

                    <label class="MyOrders_filter-check-l sendActive programs-filter-submit">Вебинары
                        <input class="MyOrders_filter-check" type="checkbox" name="type[]" value="Вебинар">
                    </label>
                    <label class="MyOrders_filter-check-l sendActive programs-filter-submit">Интенсивы
                        <input class="MyOrders_filter-check" type="checkbox" name="type[]" value="Интенсив">
                    </label>
                    <label class="MyOrders_filter-check-l sendActive programs-filter-submit">Учиться бесплатно
                        <input class="MyOrders_filter-check" type="checkbox" name="price[]" value="0">
                    </label>

                    <div class="programs-search-wraper">
                        <input class="programs-search" type="text" name="search" id="programs-search">
                        <label class="programs-search-label" for="programs-search">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                      d="M13.5 3C17.6421 3 21 6.35786 21 10.5C21 14.6421 17.6421 18 13.5 18C11.699 18 10.0464 17.3652 8.75345 16.3072L4.28033 20.7803C3.98744 21.0732 3.51256 21.0732 3.21967 20.7803C2.92678 20.4874 2.92678 20.0126 3.21967 19.7197L7.69279 15.2465C6.63477 13.9536 6 12.301 6 10.5C6 6.35786 9.35786 3 13.5 3ZM19.5 10.5C19.5 7.18629 16.8137 4.5 13.5 4.5C10.1863 4.5 7.5 7.18629 7.5 10.5C7.5 13.8137 10.1863 16.5 13.5 16.5C16.8137 16.5 19.5 13.8137 19.5 10.5Z"
                                      fill="#CBD0E8"/>
                            </svg>
                        </label>
                    </div>
                </div>
                <?= Html::endForm(); ?>
            </section>


            <section class="courses active">
                <div class="courses_container">
                    <?php Pjax::begin(['id' => 'filter']) ?>
                    <?php if (!empty($program)) : ?>
                        <?php foreach ($program as $key => $val): ?>
                            <article class="courses_item">
                                <div class="courses_item_top">
                                    <?php if (!empty($val['type'])) : ?>
                                        <?php
                                        $class = '';
                                        switch ($val['type']) {
                                            case 'Курс':
                                                $class = 'course';
                                                break;
                                            case 'Интенсив':
                                                $class = 'intensive';
                                                break;
                                            case 'Вебинар':
                                                $class = 'webinar';
                                                break;
                                        }
                                        ?>
                                        <div class="courses_item_top-name <?= $class ?>">
                                            <?= $val['type'] ?>
                                            <p class="tooltip"></p>
                                        </div>
                                    <?php endif; ?>
                                    <div class="courses_item_top-right">
                                        <?php if ($val['discount'] > 0 && ($val['discount_expiration_date'] > date('Y-m-d'))) : ?>
                                            <p class="courses-discount">-<?= $val['discount'] ?>%
                                                до <?= date('d.m', strtotime($val['discount_expiration_date'])) ?></p>
                                        <?php endif; ?>
                                        <?php if (!empty($val->category->name)) : ?>
                                            <?php
                                            $color = '';
                                            switch ($val->category->name) {
                                                case 'Маркетинг':
                                                    $color = 'yellow';
                                                    break;
                                                case 'Чарджбек':
                                                    $color = 'yellow';
                                                    break;
                                                case 'Продажи':
                                                    $color = 'light-blue';
                                                    break;
                                                case 'Арбитраж':
                                                    $color = 'dark-blue';
                                                    break;
                                                case 'Дизайн':
                                                    $color = 'pink';
                                                    break;
                                                case 'Программирование':
                                                    $color = 'light-green';
                                                    break;
                                                case 'БФЛ':
                                                    $color = 'blue';
                                                    break;
                                                case 'Управление':
                                                    $color = 'light-pink';
                                                    break;
                                            }
                                            ?>
                                            <p class="courses-direction <?= $color ?>"><?= $val->category->name ?></p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="courses_item_info">
                                    <div class="courses_item_info_left">
                                        <?php if (!empty($val['name'])) : ?>
                                            <h2 class="courses_item_info-title">
                                                <?= $val['name'] ?>
                                            </h2>
                                        <?php endif; ?>
                                        <div class="courses_item_info-stage_row">
                                            <?php if (!empty($val['study_hours'])) : ?>
                                                <div class="courses_item_info-stage_row-column">
                                                    <p class="courses_item_info-teachers">
                                                        Длительность
                                                    </p>
                                                    <p class="courses_item_info-stage_row-column-time">
                                                        <?= $val['study_hours'] ?> часов
                                                    </p>
                                                </div>
                                            <?php endif; ?>
                                            <?php if (!empty($val['date_meetup'])) : ?>
                                                <div class="courses_item_info-stage_row-column">
                                                    <p class="courses_item_info-teachers">
                                                        Дата старта
                                                    </p>
                                                    <p class="courses_item_info-stage_row-column-time">
                                                        <?= date('d.m.Y', strtotime($val['date_meetup'])) ?>
                                                    </p>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <p class="courses_item_info-teachers">
                                            Автор курса
                                        </p>
                                        <div class="courses_item_info_teachers-row">
                                            <div class="courses_item_info_teachers-row-item">
                                                <img src="<?= UrlHelper::admin($val->author->photo) ?>" alt="teacher">
                                                <p class="courses_item_info_teachers-row-item-name">
                                                    <?= $val->author->name ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (!empty($val['preview_logo'])) : ?>
                                        <div class="courses_item_info_image">
                                            <img src="<?= UrlHelper::admin($val['preview_logo']) ?>" alt="type-icon">
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="courses_item_link-row">
                                    <?php if ($val->type == 'Вебинар'): ?>
                                        <a class="btn--purple courses_item_info_right-block-link"
                                           href="<?= Url::to(['vebinarpage', 'link' => $val->link]) ?>">Записаться на
                                            вебинар</a>
                                    <?php elseif ($val->type == 'Интенсив'): ?>
                                        <a class="btn--purple courses_item_info_right-block-link"
                                           href="<?= Url::to(['intensivpage', 'link' => $val->link]) ?>">Записаться на
                                            интенсив</a>
                                    <?php else: ?>
                                        <a href="<?= Url::to(['coursepage', 'link' => $val->link]) ?>"
                                           class="btn--purple courses_item_info_right-block-link">Подробнее о курсе</a>
                                    <?php endif; ?>
                                </div>
                            </article>
                        <?php endforeach; ?>
                        <?= LinkPager::widget([
                            'pagination' => $pages,
                        ]); ?>
                    <?php else: ?>
                        <h3>Нет курсов!</h3>
                    <?php endif; ?>
                    <?php Pjax::end(); ?>
                </div>
            </section>
        </div>
    </div>
</section>