<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'Мои программы';

$js = <<< JS
    $('.programs-filter-reset').on('click', function(){
    location.replace('myprograms');
  });

  $('.programs-filter-submit').on('mouseup', function(){
      if ($(this).closest(".MyOrders_filter-select")){
         $(this).closest(".MyOrders_filter-select").find(".jq-selectbox__select").addClass("active");
      }
      
    setTimeout(function(){
      $('.myprograms-filter').submit();
    }, 300);
  });

  $('.MyOrders_filter-opinion').on('mouseup',function (){
      let parent = $(this).closest("MyOrders_filter-select");
      if (!parent.hasClass("active")){
          parent.addClass("active");
      }
  })

  $('.myprograms-filter').on('submit', function (e) {
    $.pjax.reload({
        container: '#filter',
        url: "/skill/teacher/myprograms",
        method: "GET",
        data: $(this).serialize()
    });
    e.preventDefault();
  });
  
  $(document).on("pjax:complete",changeCategoryColor);
  changeCategoryColor();
  
  function changeCategoryColor(){
      $(".myprogramm_right_top_right-teg-text").each(function () {
        var status = $(this).text(),
            block = $(this).parents(".myprogramm_right"),
            icon = block.find(".myprogramm_icon"),
            teg = $(this).parents(".myprogramm_right_top_right-teg"),
            blockAdd = block.find(".myprogramm_right_bottom_block");
    
            console.log(blockAdd);
            
    
        if(blockAdd.length == 0) {
            if(status == "Продажи") {
                icon.attr("src", "/img/teacher/teacher-sale.svg");
                teg.css("background", "#D5FFFA");
            } else if (status == "Маркетинг") {
                icon.attr("src", "/img/teacher/teacher-market.svg");
                teg.css("background", "rgba(255, 220, 54, 0.8)");
            } else if (status == "Арбитраж") {
                icon.attr("src", "/img/teacher/teacher-arbitr.svg");
                teg.css("background", "#DCDFFF");
            } else if (status == "Дизайн") {
                icon.attr("src", "/img/teacher/teacher-design.svg");
                teg.css("background", "#DCDFFF");
            } else if (status == "Программирование") {
                icon.attr("src", "/img/teacher/teacher-program.svg");
                teg.css("background", "#DAFFE4");
            } else if (status == "БФЛ") {
                icon.attr("src", "/img/teacher/teacher-bfl.svg");
                teg.css("background", "#BDDBFF");
            } else if (status == "Чарджбек") {
                icon.attr("src", "/img/teacher/teacher-chargback.svg");
                teg.css("background", "rgba(255, 220, 54, 0.8)");
            } else if (status == "Управление") {
                icon.attr("src", "/img/teacher/teacher-control.svg");
                teg.css("background", "#FFCCCC");
            }
        } else {
            icon.css("display", "none");
            if(status == "Продажи") {
                teg.css("background", "#D5FFFA");
            } else if (status == "Маркетинг") {
                teg.css("background", "rgba(255, 220, 54, 0.8)");
            } else if (status == "Арбитраж") {
                teg.css("background", "#DCDFFF");
            } else if (status == "Дизайн") {
                teg.css("background", "#DCDFFF");
            } else if (status == "Программирование") {
                teg.css("background", "#DAFFE4");
            } else if (status == "БФЛ") {
                teg.css("background", "#BDDBFF");
            } else if (status == "Чарджбек") {
                teg.css("background", "rgba(255, 220, 54, 0.8)");
            } else if (status == "Управление") {
                teg.css("background", "#FFCCCC");
            }
            }
        })
  }
  
JS;
$this->registerJs($js);
?>
<style>
    .jq-selectbox__select.active {
        color: #4135F1;
        background: #FFFFFF;
        border: 1px solid #4135F1;
        box-shadow: inset 0px 0px 15px rgb(24 18 64 / 3%);
    }
</style>
<section class="rightInfo education">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <span class="bcr__link">
                    Мои программы
                </span>
            </li>

            <li class="bcr__item">
                <span class="bcr__span">
                    Активные программы
                </span>
            </li>
        </ul>
    </div>
    <div class="title_row">
        <h1 class="Bal-ttl title-main">Мои программы</h1>
        <a href="<?= Url::to(['']) ?>" class="link--purple">Что такое мои программы?</a>
    </div>
    <nav class="ChangePageBalance df mypr">
        <div class="ChangePage-Item df jcsb aic">
            <a href="#page1" class="mypr-btn HText ChangePage-Item-t ChangePage-Item-t1 uscp CIT-active">Активные
                программы</a>
            <div class="ChangePage-Item-line ChangePage-Item-line1 CIL-active"></div>
        </div>
        <div class="ChangePage-Item df jcsb aic">
            <a href="#page2" class="mypr-btn HText ChangePage-Item-t ChangePage-Item-t2 uscp">На модерации</a>
            <div class="ChangePage-Item-line ChangePage-Item-line2"></div>
        </div>
        <div class="ChangePage-Item df jcsb aic">
            <a href="#page3" class="mypr-btn HText ChangePage-Item-t ChangePage-Item-t5 uscp">Архив</a>
            <div class="ChangePage-Item-line ChangePage-Item-line3"></div>
        </div>
    </nav>

    <div class="programs_wrapper">
        <div class="programs_main-wrap">
            <section class="programs_main-wrap-filter">
                <?= Html::beginForm('', 'get', ['class' => 'myprograms-filter', 'id' => 'programs-filter']) ?>
                <div class="MyOrders_filter programs_filter">
                    <button class="MyOrders_filter-reset programs-filter-reset" type="reset"></button>
                    <select class=" MyOrders_filter-select" name="category">
                        <option selected disabled>Направление</option>
                        <?php foreach ($category as $kay => $val): ?>
                            <option value="<?= $val['id'] ?>" class="MyOrders_filter-opinion programs-filter-submit"><?= $val['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label class="MyOrders_filter-check-l sendActive programs-filter-submit">Вебинары
                        <input class="MyOrders_filter-check" type="checkbox" name="type[]" value="Вебинар">
                    </label>
                    <label class="MyOrders_filter-check-l sendActive programs-filter-submit ">Интенсивы
                        <input class="MyOrders_filter-check" type="checkbox" name="type[]" value="Интенсив">
                    </label>
                </div>
                <?= Html::endForm(); ?>
            </section>
            <!--Активные программы-->
            <section class="myprs myprs-1 active">
                <section class="courses active">
                    <div class="courses_container">
                        <?php Pjax::begin(['id' => 'filter']) ?>
                            <?php if (!empty($posts)) : ?>
                                <?php foreach ($posts as $key => $val): ?>
                                    <article class="courses_item">
                                        <div class="myprogramm-container">
                                            <div class="myprogramm_left">
                                                <?php $class = '';?>
                                                <?php if (!empty($val['type'])) : ?>
                                                <?php
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
                                                <p class="myprogramm_left-type  <?= $class ?>">
                                                    <?= $val['type'] ?>
                                                </p>
                                                <?php endif; ?>
                                                <?php if (!empty($val['name'])) : ?>
                                                    <h2 class="myprogramm_left-title"> <?= $val['name'] ?></h2>
                                                <?php endif; ?>
                                                <?php $time = ""?>
                                                <?php if (!empty($val["date_end"]) && !empty($val['date_meetup'])) {
                                                        $time = date_diff(new DateTime($val["date_end"]), new DateTime($val['date_meetup']));
                                                    }
                                                ?>
                                                <?php if ($class == "webinar"):?>
                                                    <?php if(!empty($time)):?>
                                                        <h3 class="myprogramm_left-subtitle">Длительность</h3>
                                                        <ul class="myprogramm_left-list">
                                                            <li class="myprogramm_left-list-item">
                                                                <?= $time->h<10?"0".$time->h:$time->h?> :
                                                                <?= $time->i<10?"0".$time->i:$time->i?> :
                                                                <?= $time->s<10?"0".$time->s:$time->s?>
                                                            </li>
                                                        </ul>
                                                    <?php endif;?>
                                                <?php else:?>
                                                    <h3 class="myprogramm_left-subtitle">О программе</h3>
                                                    <ul class="myprogramm_left-list">
                                                        <?php if(!empty($val['lessons_count'])):?>
                                                            <li class="myprogramm_left-list-item">
                                                                <?= $val['lessons_count'] ?> уроков
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if(!empty($val['study_hours'])):?>
                                                            <li class="myprogramm_left-list-item">
                                                                <?= $val['study_hours'] ?> часов
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                <?php endif;?>
                                                <?php if ($val->type == 'Вебинар'): ?>
                                                    <a class="btn--purple courses_item_info_right-block-link"
                                                       href="<?= Url::to(['vebinarpage', 'link' => $val->link]) ?>">Подробнее о
                                                        вебинаре</a>
                                                <?php elseif ($val->type == 'Интенсив'): ?>
                                                    <a class="btn--purple courses_item_info_right-block-link"
                                                       href="<?= Url::to(['intensivpage', 'link' => $val->link]) ?>">Подробнее о
                                                        интенсиве</a>
                                                <?php else: ?>
                                                    <a href="<?= Url::to(['coursepage', 'link' => $val->link]) ?>"
                                                       class="btn--purple courses_item_info_right-block-link">Подробнее о курсе</a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="myprogramm_right">
                                                <div class="myprogramm_right_top">
                                                    <div class="myprogramm_right_top_spoiler">
                                                        <button class="myprogramm_right_top_spoiler-btn">
                                                            Действия
                                                        </button>
                                                        <ul class="myprogramm_right_top_spoiler_list">
                                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--active">
                                                                    Активен
                                                                </button>
                                                            </li>
                                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--moderation">
                                                                    Модерация
                                                                </button>
                                                            </li>
                                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--stop">
                                                                    Завершен
                                                                </button>
                                                            </li>
                                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--pause">
                                                                    Пауза
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="myprogramm_right_top_right">
                                                        <div class="myprogramm_right_top_right-teg">
                                                            <div class="myprogramm_right_top_right-teg-point"></div>
                                                            <p class="myprogramm_right_top_right-teg-text"><?= $val->category->name?></p>
                                                        </div>
                                                        <?php if (!empty($val['date_meetup'])) : ?>
                                                            <p class="myprogramm_right_top_right-date">
                                                                от
                                                                <?= date('d.m.Y', strtotime($val['date_meetup'])) ?>
                                                            </p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="myprogramm_right_bottom">
                                                    <?php $tasks = $val->skillTrainingsTests;?>
                                                    <?php if (!empty($tasks)):?>
                                                    <div class="myprogramm_right_bottom_block">
                                                        <h4 class="myprogramm_right_bottom_block-title">
                                                            Проверьте задание
                                                        </h4>
                                                        <h5 class="myprogramm_right_bottom_block-subtitle">Заданий на проверку</h5>
                                                        <p class="myprogramm_right_bottom_block-text"><?= count($tasks)?></p>
                                                        <a style="max-width: fit-content;" href="<?= Url::to('') ?>" class="btn--purple">Проверить
                                                            сейчас</a>
                                                    </div>
                                                    <?php else:?>
                                                            <img class="myprogramm_icon" src="<?= Url::to('/img/teacher/teacher-all.svg') ?>" alt="icon">
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                                <?= LinkPager::widget([
                                    'pagination' => $pages,
                                ]); ?>
                            <?php else: ?>
                                <!--Если нет программ-->
                                <section class="courses_none">
                                    <img src="<?= Url::to('/img/skillclient/education-none-curses.png') ?>" alt="icon">
                                    <p>Здесь будут отражены все ваши активные программы обучения.</p>
                                    <a href="<?= Url::to(['']) ?>" class="link--purple">Загрузить программу</a>
                                </section>
                            <?php endif; ?>
                        <?php Pjax::end(); ?>
                    </div>
                </section>
            </section>
            <section class="myprs myprs-2">
                <section class="courses active">
                    <div class="courses_container">
                        <?php Pjax::begin(['id' => 'filter']) ?>
                            <?php if (!empty($posts)) : ?>
                                <?php foreach ($posts as $key => $val): ?>
                                    <article class="courses_item">
                                        <div class="myprogramm-container">
                                            <div class="myprogramm_left">
                                                <?php $class = '';?>
                                                <?php if (!empty($val['type'])) : ?>
                                                <?php
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
                                                <p class="myprogramm_left-type  <?= $class ?>">
                                                    <?= $val['type'] ?>
                                                </p>
                                                <?php endif; ?>
                                                <?php if (!empty($val['name'])) : ?>
                                                    <h2 class="myprogramm_left-title"> <?= $val['name'] ?></h2>
                                                <?php endif; ?>
                                                <?php $time = ""?>
                                                <?php if (!empty($val["date_end"]) && !empty($val['date_meetup'])) {
                                                    $time = date_diff(new DateTime($val["date_end"]), new DateTime($val['date_meetup']));
                                                }
                                                ?>
                                                <?php if ($class == "webinar"):?>
                                                    <?php if(!empty($time)):?>
                                                    <h3 class="myprogramm_left-subtitle">Длительность</h3>
                                                    <ul class="myprogramm_left-list">
                                                        <li class="myprogramm_left-list-item">
                                                            <?= $time->h<10?"0".$time->h:$time->h?> :
                                                            <?= $time->i<10?"0".$time->i:$time->i?> :
                                                            <?= $time->s<10?"0".$time->s:$time->s?>
                                                        </li>
                                                    </ul>
                                                    <?php endif;?>
                                                <?php else:?>
                                                    <h3 class="myprogramm_left-subtitle">О программе</h3>
                                                    <ul class="myprogramm_left-list">
                                                        <?php if(!empty($val['lessons_count'])):?>
                                                            <li class="myprogramm_left-list-item">
                                                                <?= $val['lessons_count'] ?> уроков
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if(!empty($val['study_hours'])):?>
                                                            <li class="myprogramm_left-list-item">
                                                                <?= $val['study_hours'] ?> часов
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                <?php endif;?>
                                                <?php if ($val->type == 'Вебинар'): ?>
                                                    <a class="btn--purple courses_item_info_right-block-link"
                                                       href="<?= Url::to(['vebinarpage', 'link' => $val->link]) ?>">Подробнее о
                                                        вебинаре</a>
                                                <?php elseif ($val->type == 'Интенсив'): ?>
                                                    <a class="btn--purple courses_item_info_right-block-link"
                                                       href="<?= Url::to(['intensivpage', 'link' => $val->link]) ?>">Подробнее о
                                                        интенсиве</a>
                                                <?php else: ?>
                                                    <a href="<?= Url::to(['coursepage', 'link' => $val->link]) ?>"
                                                       class="btn--purple courses_item_info_right-block-link">Подробнее о курсе</a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="myprogramm_right">
                                                <div class="myprogramm_right_top">
                                                    <div class="myprogramm_right_top_spoiler">
                                                        <button class="myprogramm_right_top_spoiler-btn">
                                                            Действия
                                                        </button>
                                                        <ul class="myprogramm_right_top_spoiler_list">
                                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--active">
                                                                    Активен
                                                                </button>
                                                            </li>
                                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--moderation">
                                                                    Модерация
                                                                </button>
                                                            </li>
                                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--stop">
                                                                    Завершен
                                                                </button>
                                                            </li>
                                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--pause">
                                                                    Пауза
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="myprogramm_right_top_right">
                                                        <div class="myprogramm_right_top_right-teg">
                                                            <div class="myprogramm_right_top_right-teg-point"></div>
                                                            <p class="myprogramm_right_top_right-teg-text"><?= $val->category->name?></p>
                                                        </div>
                                                        <?php if (!empty($val['date_meetup'])) : ?>
                                                            <p class="myprogramm_right_top_right-date">
                                                                от
                                                                <?= date('d.m.Y', strtotime($val['date_meetup'])) ?>
                                                            </p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="myprogramm_right_bottom">
                                                    <?php $tasks = $val->skillTrainingsTests;?>
                                                    <?php if (!empty($tasks)):?>
                                                    <div class="myprogramm_right_bottom_block">
                                                        <h4 class="myprogramm_right_bottom_block-title">
                                                            Проверьте задание
                                                        </h4>
                                                        <h5 class="myprogramm_right_bottom_block-subtitle">Заданий на проверку</h5>
                                                        <p class="myprogramm_right_bottom_block-text"><?= count($tasks)?></p>
                                                        <a style="max-width: fit-content;" href="<?= Url::to('') ?>" class="btn--purple">Проверить
                                                            сейчас</a>
                                                    </div>
                                                    <?php else:?>
                                                            <img class="myprogramm_icon" src="<?= Url::to('/img/teacher/teacher-all.svg') ?>" alt="icon">
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                                <?= LinkPager::widget([
                                    'pagination' => $pages,
                                ]); ?>
                            <?php else: ?>
                                <!--Если нет программ-->
                                <section class="courses_none">
                                    <img src="<?= Url::to('/img/skillclient/education-none-curses.png') ?>" alt="icon">
                                    <p>Здесь будут отражены все ваши активные программы обучения.</p>
                                    <a href="<?= Url::to(['']) ?>" class="link--purple">Загрузить программу</a>
                                </section>
                            <?php endif; ?>
                        <?php Pjax::end(); ?>
                    </div>
                </section>
            </section>
            <section class="myprs myprs-3">
                <section class="courses active">
                    <div class="courses_container">
                        <?php Pjax::begin(['id' => 'filter']) ?>
                            <?php if (!empty($posts)) : ?>
                                <?php foreach ($posts as $key => $val): ?>
                                    <article class="courses_item">
                                        <div class="myprogramm-container">
                                            <div class="myprogramm_left">
                                                <?php $class = '';?>
                                                <?php if (!empty($val['type'])) : ?>
                                                <?php
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
                                                <p class="myprogramm_left-type  <?= $class ?>">
                                                    <?= $val['type'] ?>
                                                </p>
                                                <?php endif; ?>
                                                <?php if (!empty($val['name'])) : ?>
                                                    <h2 class="myprogramm_left-title"> <?= $val['name'] ?></h2>
                                                <?php endif; ?>
                                                <?php $time = ""?>
                                                <?php if (!empty($val["date_end"]) && !empty($val['date_meetup'])) {
                                                    $time = date_diff(new DateTime($val["date_end"]), new DateTime($val['date_meetup']));
                                                }
                                                ?>
                                                <?php if ($class == "webinar"):?>
                                                  <?php if(!empty($time)):?>
                                                    <h3 class="myprogramm_left-subtitle">Длительность</h3>
                                                    <ul class="myprogramm_left-list">
                                                        <li class="myprogramm_left-list-item">
                                                            <?= $time->h<10?"0".$time->h:$time->h?> :
                                                            <?= $time->i<10?"0".$time->i:$time->i?> :
                                                            <?= $time->s<10?"0".$time->s:$time->s?>
                                                        </li>
                                                    </ul>
                                                    <?php endif;?>
                                                <?php else:?>
                                                    <h3 class="myprogramm_left-subtitle">О программе</h3>
                                                    <ul class="myprogramm_left-list">
                                                        <?php if(!empty($val['lessons_count'])):?>
                                                            <li class="myprogramm_left-list-item">
                                                                <?= $val['lessons_count'] ?> уроков
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if(!empty($val['study_hours'])):?>
                                                            <li class="myprogramm_left-list-item">
                                                                <?= $val['study_hours'] ?> часов
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                <?php endif;?>
                                                <?php if ($val->type == 'Вебинар'): ?>
                                                    <a class="btn--purple courses_item_info_right-block-link"
                                                       href="<?= Url::to(['vebinarpage', 'link' => $val->link]) ?>">Подробнее о
                                                        вебинаре</a>
                                                <?php elseif ($val->type == 'Интенсив'): ?>
                                                    <a class="btn--purple courses_item_info_right-block-link"
                                                       href="<?= Url::to(['intensivpage', 'link' => $val->link]) ?>">Подробнее о
                                                        интенсиве</a>
                                                <?php else: ?>
                                                    <a href="<?= Url::to(['coursepage', 'link' => $val->link]) ?>"
                                                       class="btn--purple courses_item_info_right-block-link">Подробнее о курсе</a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="myprogramm_right">
                                                <div class="myprogramm_right_top">
                                                    <div class="myprogramm_right_top_spoiler">
                                                        <button class="myprogramm_right_top_spoiler-btn">
                                                            Действия
                                                        </button>
                                                        <ul class="myprogramm_right_top_spoiler_list">
                                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--active">
                                                                    Активен
                                                                </button>
                                                            </li>
                                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--moderation">
                                                                    Модерация
                                                                </button>
                                                            </li>
                                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--stop">
                                                                    Завершен
                                                                </button>
                                                            </li>
                                                            <li class="myprogramm_right_top_spoiler_list-item">
                                                                <button class="myprogramm_right_top_spoiler_list-item-btn btn--pause">
                                                                    Пауза
                                                                </button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="myprogramm_right_top_right">
                                                        <div class="myprogramm_right_top_right-teg">
                                                            <div class="myprogramm_right_top_right-teg-point"></div>
                                                            <p class="myprogramm_right_top_right-teg-text"><?= $val->category->name?></p>
                                                        </div>
                                                        <?php if (!empty($val['date_meetup'])) : ?>
                                                            <p class="myprogramm_right_top_right-date">
                                                                от
                                                                <?= date('d.m.Y', strtotime($val['date_meetup'])) ?>
                                                            </p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="myprogramm_right_bottom">
                                                    <?php $tasks = $val->skillTrainingsTests;?>
                                                    <?php if (!empty($tasks)):?>
                                                    <div class="myprogramm_right_bottom_block">
                                                        <h4 class="myprogramm_right_bottom_block-title">
                                                            Проверьте задание
                                                        </h4>
                                                        <h5 class="myprogramm_right_bottom_block-subtitle">Заданий на проверку</h5>
                                                        <p class="myprogramm_right_bottom_block-text"><?= count($tasks)?></p>
                                                        <a style="max-width: fit-content;" href="<?= Url::to('') ?>" class="btn--purple">Проверить
                                                            сейчас</a>
                                                    </div>
                                                    <?php else:?>
                                                            <img class="myprogramm_icon" src="<?= Url::to('/img/teacher/teacher-all.svg') ?>" alt="icon">
                                                    <?php endif;?>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                <?php endforeach; ?>
                                <?= LinkPager::widget([
                                    'pagination' => $pages,
                                ]); ?>
                            <?php else: ?>
                                <!--Если нет программ-->
                                <section class="courses_none">
                                    <img src="<?= Url::to('/img/skillclient/education-none-curses.png') ?>" alt="icon">
                                    <p>Здесь будут отражены все ваши активные программы обучения.</p>
                                    <a href="<?= Url::to(['']) ?>" class="link--purple">Загрузить программу</a>
                                </section>
                            <?php endif; ?>
                        <?php Pjax::end(); ?>
                    </div>
                </section>
            </section>
        </div>
    </div>

    <footer class="footer">
        <div class="">
            <a href="<?= Url::to(['manual']) ?>" class="footer__link">
                Договор-оферта
            </a>
            <a href="<?= Url::to(['manual']) ?>" class="footer__link">
                Руководство пользователя
            </a>
            <a href="<?= Url::to(['support']) ?>" class="footer__link">
                Тех.поддержка
            </a>
        </div>
    </footer>
</section>
