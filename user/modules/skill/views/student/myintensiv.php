<?php

use common\models\SkillTrainingsTasksAlias;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = $course->name;

$js = <<< JS

JS;
$this->registerJs($js);

?>

<section class="rightInfo education">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <a href="<?= Url::to(['education']) ?>" class="bcr__link">
                    Моё обучение
                </a>
            </li>

            <li class="bcr__item">
                <a href="<?= Url::to(['education']) ?>" class="bcr__link">
                    Активные программы
                </a>
            </li>

            <li class="bcr__item">
                <span class="bcr__span nowpagebrc"><?= $course->name ?></span>
            </li>
        </ul>
    </div>
    <p class="type-cours"><?= $course->type ?></p>
    <div class="title_row">
        <h1 class="Bal-ttl title-main"><?= $course->name ?></h1>
        <p class="cours-rating">Ваш рейтинг <span>98.3</span></p>
    </div>

    <div class="mycours-wrap">
        <section class="mycours">
            <div class="mycours_top">
                <div class="mycours_top-left">
                    <?php $cat = \common\models\SkillTrainingsCategory::findOne(['id' => $course->category_id]) ?>
                    <p class="courses-direction yellow"><?= $cat->name ?></p>
                    <?php if ($course->price == 0): ?>
                        <p class="mycours_top-left-freecourse">Бесплатный интенсив</p>
                    <?php endif; ?>
                </div>
                <?php if (!empty($course->date_end)): ?>
                    <p class="courses-date">Доступно до <?= date('d.m.Y', strtotime($course->date_end)) ?></p>
                <?php endif; ?>
            </div>
            <?php if (!empty($course->skillTrainingsBlocks)): ?>
                <h2 class="mycours-title">
                    Программа курса
                </h2>
                <ul class="mycours-list">
                    <?php foreach ($course->skillTrainingsBlocks as $k => $v): ?>
                        <li class="mycours-list-item">
                            <button type="button" class="mycours-list-item-btn">
                                <h3 class="mycours-list-item-btn-text">Модуль <?= $k + 1 ?> «<?= $v['name'] ?>»</h3>
                                <div class="mycours-list-item-btn-indicator"></div>
                            </button>
                            <section class="mycours-list-item_info">
                                <div class="mycours-list-item_info-container">
                                    <?php if (!empty($courseArr)): ?>
                                        <?php foreach ($courseArr as $key => $val): ?>
                                            <?php if (array_key_exists('main_text', $val)): ?>
                                                <?php if ($v['id'] == $val['block_id']): ?>
                                                    <div class="mycours-list-item_info-item">
                                                        <a class="courses__links"
                                                           href="<?= Url::to(['lesson', 'id' => $val['id']]) ?>"></a>
                                                        <div style="background-image: url(<?= Url::to(['/img/skillclient/ppt.png']) ?>)"
                                                             class="mycours-list-item_info-item-bacground-lesson">
                                                            <?= $val['sort_order'] ?>
                                                            <p>Теория</p>
                                                        </div>
                                                        <h4 class="mycours-list-item_info-item-name"><?= $k + 1 ?>
                                                            .<?= $val['sort_order'] ?> <?= $val['name'] ?></h4>
                                                    </div>
                                                <?php endif; ?>
                                            <?php elseif(array_key_exists('max_tries', $val)): ?>
                                                <?php if ($v['id'] == $val['block_id']): ?>
                                                    <div class="mycours-list-item_info-item">
                                                        <div class="mycours-list-item_info-item-video-locked">
                                                            <p class="mycours-list-item_info-item-video-locked-tooltip">
                                                                Урок
                                                                будет
                                                                доступен с 20.09.2021</p>
                                                        </div>
                                                        <a class="courses__links"
                                                           href="<?= Url::to(['test', 'id' => $val['id']]) ?>"></a>
                                                        <div style="background-image: url(<?= Url::to(['/img/skillclient/full-selection.png']) ?>)"
                                                             class="mycours-list-item_info-item-bacground-test">
                                                            <?= $val['sort_order'] ?>
                                                            <p>Тест</p>
                                                        </div>
                                                        <h4 class="mycours-list-item_info-item--test-status">Зачет</h4>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                    <?php if (!empty($course->skillTrainingsTasks)): ?>
                                        <?php foreach ($course->skillTrainingsTasks as $key => $val): ?>
                                            <?php if ($v['id'] == $val['block_id']): ?>
                                                <div class="mycours-list-item_info-item">
                                                    <a class="courses__links" href="<?= Url::to(['task', 'id' => $val['id']]) ?>"></a>
                                                    <div style="background-image: url(<?= Url::to(['/img/skillclient/bookmark.png']) ?>)" class="mycours-list-item_info-item-bacground">
                                                        <p>Задание</p>
                                                    </div>
                                                    <?php
                                                    $statusTask = SkillTrainingsTasksAlias::find()->asArray()->where(['task_id' => $val['id']])->andWhere(['user_id' => Yii::$app->getUser()->getId()])->select('status')->one();
                                                    switch ($statusTask['status']){
                                                        case 'Доработка' || 'Отправленно':
                                                            $color = 'orange';
                                                            break;
                                                        case 'Не зачет':
                                                            $color = 'red';
                                                            break;
                                                    }
                                                    ?>
                                                    <h4 class="mycours-list-item_info-item-status <?= $color ?>"><?= $statusTask['status'] ?></h4>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </div>
                            </section>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <aside class="cours-progress">
            <h3 class="cours-progress-title">
                Прогресс
            </h3>
            <ul class="cours-progress_subb-group-wrap">
                <li class="cours-progress_subb-group">
                    <h4 class="cours-progress-subtitle">
                        <span><span>1</span>/<span><?= count($course->skillTrainingsLessons) ?></span></span> уроков
                    </h4>
                    <div class="cours-progress-subtitle_line">
                        <div class="cours-progress-subtitle_line-fill"></div>
                    </div>
                </li>
                <li class="cours-progress_subb-group">
                    <h4 class="cours-progress-subtitle">
                        <span><span>1</span>/<span><?= count($course->skillTrainingsTasks) ?></span></span> заданий
                    </h4>
                    <div class="cours-progress-subtitle_line">
                        <div class="cours-progress-subtitle_line-fill"></div>
                    </div>
                </li>
                <li class="cours-progress_subb-group">
                    <h4 class="cours-progress-subtitle">
                        <span><span>0</span>/<span><?= count($course->skillTrainingsTests) ?></span></span> тестов
                    </h4>
                    <div class="cours-progress-subtitle_line">
                        <div class="cours-progress-subtitle_line-fill"></div>
                    </div>
                </li>
            </ul>
        </aside>
    </div>
</section>