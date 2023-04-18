<?php

use common\models\SkillTrainingsCategory;
use common\models\SkillTrainingsTeachers;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use common\models\helpers\UrlHelper;

$this->title = 'Мое обучение';

$js = <<< JS
$('.sendActive').on('click', function() {
    setTimeout(function() {
        $('.activeFilter').submit();
    }, 100);
});
$('.activeFilter').on('submit', function(e) {
  e.preventDefault();
  $.pjax.reload({
    container: '#filters',
    data: $(this).serialize(),
    type: 'POST',
    url: 'education'
  });
})
JS;
$this->registerJs($js);
?>

<section style="margin-bottom: 20px" class="rightInfo education">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
            <span class="bcr__link">
            Моё обучение
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
        <h1 class="Bal-ttl title-main">Моё обучение</h1>
    </div>

    <nav class="MyOrders_tabs MyEducation_tabs">
        <div class="tab tab1 active">
            <a href="#1" class="tabsChange"></a>
            <p class="name">Активные программы</p>
            <div class="string act1"></div>
        </div>
        <div class="tab tab2">
            <a href="#2" class="tabsChange"></a>
            <p class="name">Архив</p>
            <div class="string act2"></div>
        </div>
    </nav>

    <section class="">
        <?= Html::beginForm('', 'get', ['class' => 'activeFilter']) ?>
        <div class="MyOrders_filter">
            <a class="MyOrders_filter-reset" href="<?= Url::to(['education']) ?>"></a>
            <select class="MyOrders_filter-select" name="status" id="">
                <option selected disabled>Статус</option>
                <?php if (!empty($category)): ?>
                    <?php foreach ($category as $k => $v): ?>
                        <option class="sendActive" value="<?= $v['id'] ?>"><?= $v['name'] ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>

            </select>

            <label class="MyOrders_filter-check-l sendActive">Вебинары
                <input class="MyOrders_filter-check" type="radio" value="web" name="type">
            </label>
            <label class="MyOrders_filter-check-l sendActive">Интенсивы
                <input class="MyOrders_filter-check" type="radio" value="int" name="type">
            </label>
        </div>
        <?= Html::endForm(); ?>
    </section>
    <?php Pjax::begin(['id' => 'filters']) ?>
    <section class="courses_active courses active">
        <div class="courses_container">
            <?php if (!empty($myCourse)): ?>
                <?php foreach ($myCourse as $k => $v): ?>
                    <?php $url = '';
                    switch ($v['type']) {
                        case 'Курс';
                            $url = 'mycours';
                            break;
                        case 'Вебинар';
                            $url = 'myvebinar';
                            break;
                        case 'Интенсив';
                            $url = 'myintensiv';
                            break;
                    }
                    ?>
                    <a href="<?= Url::to([$url, 'link' => $v['link']]) ?>" class="courses-card">
                        <article class="courses_item">
                            <div class="courses_item_top">
                                <p class="courses_item_top-name"><?= $v['type'] ?></p>
                                <?php $cat = SkillTrainingsCategory::findOne(['id' => $v['category_id']]) ?>
                                <p class="courses-direction yellow"><?= $cat->name ?></p>
                            </div>
                            <div class="courses_item_info">
                                <div class="courses_item_info_left">
                                    <h2 class="courses_item_info-title">
                                        <?= $v['name'] ?>
                                    </h2>
                                    <?php if ($v['type'] !== 'Вебинар'): ?>
                                        <p class="courses_item_info-stage">
                                            Пройдено
                                        </p>
                                        <div class="courses_item_info-stage_row">
                                            <p class="courses_item_info-stage_row-text">
                                                <span><span>1</span>/<span><?= count($v->skillTrainingsLessons) ?></span></span> уроков
                                            </p>
                                            <p class="courses_item_info-stage_row-text">
                                                <span><span>0</span>/<span><?= count($v->skillTrainingsTasks) ?></span></span> заданий
                                            </p>
                                        </div>
                                        <div class="courses_item_info-stage_line">
                                            <div class="courses_item_info-stage_line-fill"></div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($v['teacher_id'])): ?>
                                        <?php
                                        $teacherArr = json_decode($v['teacher_id'], 1);
                                        $teacher = SkillTrainingsTeachers::find()
                                            ->asArray()
                                            ->where(['in', 'id', $teacherArr])
                                            ->select(['name', 'photo'])
                                            ->all();
                                        ?>
                                        <p class="courses_item_info-teachers">
                                            Преподаватели
                                        </p>
                                        <div class="courses_item_info_teachers-row">
                                            <?php foreach ($teacher as $key => $val): ?>
                                                <div class="courses_item_info_teachers-row-item">
                                                    <img src="<?= UrlHelper::admin($val['photo']) ?>" alt="teacher">
                                                    <p class="courses_item_info_teachers-row-item-name">
                                                        <?= $val['name'] ?>
                                                    </p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="courses_item_info_image">
                                    <img src="<?= UrlHelper::admin($v['preview_logo']) ?>" alt="type-icon">
                                </div>
                            </div>
                        </article>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <article class="courses_none">
                    <img src="<?= Url::to(['/img/skillclient/education-none-curses.png']) ?>" alt="screen">
                    <h2 class="courses_none-title">
                        Здесь будут отражены все ваши активные программы обучения.
                    </h2>
                    <a class="link--purple" href="<?= Url::to(['programs']) ?>">Выбрать программу</a>
                </article>
            <?php endif; ?>


            <!--            <a href="--><? //= Url::to(['']) ?><!--" class="courses-card">-->
            <!--              <article class="courses_item">-->
            <!--                <div class="courses_item_top">-->
            <!--                  <p class="courses_item_top-name">курс</p>-->
            <!--                  <p class="courses-direction yellow">Маркетинг</p>-->
            <!--                </div>-->
            <!--                <div class="courses_item_info">-->
            <!--                  <div class="courses_item_info_left">-->
            <!--                    <h2 class="courses_item_info-title">-->
            <!--                      Менеджер клиентского сервиса-->
            <!--                    </h2>-->
            <!--                    <p class="courses_item_info-stage">-->
            <!--                    Пройдено-->
            <!--                    </p>-->
            <!--                    <div class="courses_item_info-stage_row">-->
            <!--                      <p class="courses_item_info-stage_row-text">-->
            <!--                        <span><span>4</span>/<span>27</span></span> уроков-->
            <!--                      </p>-->
            <!--                      <p class="courses_item_info-stage_row-text">-->
            <!--                      <span><span>2</span>/<span>12</span></span> заданий-->
            <!--                      </p>-->
            <!--                    </div>-->
            <!--                    <div class="courses_item_info-stage_line">-->
            <!--                      <div class="courses_item_info-stage_line-fill"></div>-->
            <!--                    </div>-->
            <!--                    <p class="courses_item_info-teachers">-->
            <!--                    Преподаватели-->
            <!--                    </p>-->
            <!--                    <div class="courses_item_info_teachers-row">-->
            <!--                      <div class="courses_item_info_teachers-row-item">-->
            <!--                        <img src="--><? //= Url::to('img/skillclient/ico.svg') ?><!--" alt="teacher">-->
            <!--                        <p class="courses_item_info_teachers-row-item-name">-->
            <!--                        Марина Дьярова-->
            <!--                        </p>-->
            <!--                      </div>-->
            <!--                      <div class="courses_item_info_teachers-row-item">-->
            <!--                        <img src="--><? //= Url::to('img/skillclient/ico.svg') ?><!--" alt="teacher">-->
            <!--                        <p class="courses_item_info_teachers-row-item-name">-->
            <!--                        Марина Дьярова-->
            <!--                        </p>-->
            <!--                      </div>-->
            <!--                      <div class="courses_item_info_teachers-row-item">-->
            <!--                        <img src="--><? //= Url::to('img/skillclient/ico.svg') ?><!--" alt="teacher">-->
            <!--                        <p class="courses_item_info_teachers-row-item-name">-->
            <!--                        Марина Дьярова-->
            <!--                        </p>-->
            <!--                      </div>-->
            <!--                      <div class="courses_item_info_teachers-row-item">-->
            <!--                        <img src="--><? //= Url::to('img/skillclient/ico.svg') ?><!--" alt="teacher">-->
            <!--                        <p class="courses_item_info_teachers-row-item-name">-->
            <!--                        Марина Дьярова-->
            <!--                        </p>-->
            <!--                      </div>-->
            <!--                    </div>-->
            <!--                  </div>-->
            <!--                  <div class="courses_item_info_image">-->
            <!--                    <div class="courses_item_info_right-block">-->
            <!--                      <p class="courses_item_info_right-block-title">Выполните задание</p>-->
            <!--                      <p class="courses_item_info_right-block-text">Выполните задание к Уроку 12 “Инструменты онлайн”</p>-->
            <!--                      <p class="courses_item_info_right-block-time">Крайний срок</p>-->
            <!--                      <p class="courses_item_info_right-block-date">-->
            <!--                      06.09.2021-->
            <!--                      </p>-->
            <!--                      <object><a class="btn--purple courses_item_info_right-block-link" href="-->
            <? //= Url::to(['']) ?><!--">Выполнить задание</a></object>-->
            <!--                    </div>-->
            <!--                  </div>-->
            <!--                </div>-->
            <!--              </article>-->
            <!--            </a>-->

            <!--            <a href="--><? //= Url::to(['']) ?><!--" class="courses-card">-->
            <!--              <article class="courses_item">-->
            <!--                <div class="courses_item_top">-->
            <!--                  <p class="courses_item_top-name">курс</p>-->
            <!--                  <p class="courses-direction yellow">Маркетинг</p>-->
            <!--                </div>-->
            <!--                <div class="courses_item_info">-->
            <!--                  <div class="courses_item_info_left">-->
            <!--                    <h2 class="courses_item_info-title">-->
            <!--                      Менеджер клиентского сервиса-->
            <!--                    </h2>-->
            <!--                    <p class="courses_item_info-stage">-->
            <!--                    Пройдено-->
            <!--                    </p>-->
            <!--                    <div class="courses_item_info-stage_row">-->
            <!--                      <p class="courses_item_info-stage_row-text">-->
            <!--                        <span><span>0</span>/<span>27</span></span> уроков-->
            <!--                      </p>-->
            <!--                      <p class="courses_item_info-stage_row-text">-->
            <!--                      <span><span>0</span>/<span>12</span></span> заданий-->
            <!--                      </p>-->
            <!--                    </div>-->
            <!--                    <div class="courses_item_info-stage_line">-->
            <!--                      <div class="courses_item_info-stage_line-fill"></div>-->
            <!--                    </div>-->
            <!--                    <p class="courses_item_info-teachers">-->
            <!--                    Преподаватели-->
            <!--                    </p>-->
            <!--                    <div class="courses_item_info_teachers-row">-->
            <!--                      <div class="courses_item_info_teachers-row-item">-->
            <!--                        <img src="--><? //= Url::to('img/skillclient/ico.svg') ?><!--" alt="teacher">-->
            <!--                        <p class="courses_item_info_teachers-row-item-name">-->
            <!--                        Марина Дьярова-->
            <!--                        </p>-->
            <!--                      </div>-->
            <!--                      <div class="courses_item_info_teachers-row-item">-->
            <!--                        <img src="--><? //= Url::to('img/skillclient/ico.svg') ?><!--" alt="teacher">-->
            <!--                        <p class="courses_item_info_teachers-row-item-name">-->
            <!--                        Марина Дьярова-->
            <!--                        </p>-->
            <!--                      </div>-->
            <!--                      <div class="courses_item_info_teachers-row-item">-->
            <!--                        <img src="--><? //= Url::to('img/skillclient/ico.svg') ?><!--" alt="teacher">-->
            <!--                        <p class="courses_item_info_teachers-row-item-name">-->
            <!--                        Марина Дьярова-->
            <!--                        </p>-->
            <!--                      </div>-->
            <!--                      <div class="courses_item_info_teachers-row-item">-->
            <!--                        <img src="--><? //= Url::to('img/skillclient/ico.svg') ?><!--" alt="teacher">-->
            <!--                        <p class="courses_item_info_teachers-row-item-name">-->
            <!--                        Марина Дьярова-->
            <!--                        </p>-->
            <!--                      </div>-->
            <!--                    </div>-->
            <!--                  </div>-->
            <!--                  <div class="courses_item_info_image">-->
            <!--                    <div class="courses_item_info_right-block green">-->
            <!--                      <p class="courses_item_info_right-block-title">Задание проверено</p>-->
            <!--                      <p class="courses_item_info_right-block-text">Ваше задание к Уроку 12 “Инструменты онлайн” проверено</p>-->
            <!--                      <p class="courses_item_info_right-block-time">Статус</p>-->
            <!--                      <p class="courses_item_info_right-block-date">-->
            <!--                      Зачет-->
            <!--                      </p>-->
            <!--                      <object><a class="btn--purple courses_item_info_right-block-link" href="-->
            <? //= Url::to(['']) ?><!--">Смотреть результаты</a></object>-->
            <!--                    </div>-->
            <!--                  </div>-->
            <!--                </div>-->
            <!--                <object><a class="btn--purple courses_item_info_right-block-link courses_item-link" href="-->
            <? //= Url::to(['']) ?><!--">Начать обучение</a></object>-->
            <!--              </article>-->
            <!--            </a>-->


        </div>
    </section>
    <section class="courses_archive courses">
        <div class="courses_container">
            <article class="courses_none">
                <img src="<?= Url::to('/img/skillclient/education-none-curses.png') ?>" alt="screen">
                <h2 class="courses_none-title">
                    Здесь будут отражены все ваши активные программы обучения.
                </h2>
                <a class="link--purple" href="<?= Url::to(['programs']) ?>">Выбрать программу</a>
            </article>
        </div>
    </section>
    <?php Pjax::end(); ?>
</section>