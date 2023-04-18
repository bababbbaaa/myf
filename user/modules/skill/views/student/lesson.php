<?php

use common\models\SkillTrainingsTasksAlias;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = $lesson->name;

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

            <?php if ($lesson->training->type === 'Курс'): ?>
                <li class="bcr__item">
                    <a href="<?= Url::to(['mycours', 'link' => $lesson->training->link]) ?>" class="bcr__link">
                        <?= $lesson->training->name ?>
                    </a>
                </li>
            <?php elseif ($lesson->training->type === 'Интенсив'): ?>
                <li class="bcr__item">
                    <a href="<?= Url::to(['myintensiv', 'link' => $lesson->training->link]) ?>" class="bcr__link">
                        <?= $lesson->training->name ?>
                    </a>
                </li>
            <?php else: ?>
                <li class="bcr__item">
                    <a href="<?= Url::to(['myvebinar', 'link' => $lesson->training->link]) ?>" class="bcr__link">
                        <?= $lesson->training->name ?>
                    </a>
                </li>
            <?php endif; ?>

            <li class="bcr__item">
                <span class="bcr__span nowpagebrc"><?= $lesson->name ?></span>
            </li>
        </ul>
    </div>
    <p class="type-cours"><?= $lesson->training->type ?></p>
    <div class="title_row">
        <h1 class="Bal-ttl title-main"><?= $lesson->training->name ?></h1>
    </div>

    <h2 class="viewcours-title">
        <?= $lesson->block->sort_order . '.' . $lesson->sort_order . ' ' . $lesson->name ?>
    </h2>
    <section class="viewcours_main">
        <article class="viewcours_main_info">
            <div class="viewcours-prev-text"><?= $lesson->main_text ?></div>

            <section class="viewcours-video viewcours-card">

                <?php if (!empty($lesson->video)): ?>
                <?php $videos = json_decode($lesson->video, 1) ?>
                    <?php foreach ($videos as $v): ?>
                        <div class="viewcours-video_video">
                            <?php parse_str(parse_url($v, PHP_URL_QUERY), $video); ?>
                            <iframe src="https://www.youtube.com/embed/<?= $video['v'] ?>?controls=0" frameborder="0"
                                    allowfullscreen></iframe>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <?php if (!empty($lesson->material)): ?>
                    <?php $material = json_decode($lesson->material, 1) ?>
                    <h3 class="viewcours-video-title">
                        Материалы к лекции
                    </h3>
                    <ul class="viewcours-video-list">
                        <?php foreach ($material as $k => $v): ?>
                            <li class="viewcours-video-list-item">
                                <div class="viewcours-video-list-item_container">
                                    <p><?= $v['name'] ?></p>
                                    <a class="link--purple" href="<?= Url::to([$v['file']]) ?>" download="">Скачать</a>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </section>

            <?php if (!empty($lesson->content)): ?>
                <section class="learning viewcours-card">
                    <button class="learning-btn" type="button">
                        Материал для изучения
                    </button>

                    <div class="learning_info">
                        <div class="learning_info_container">
                            <div class="learning_info-text"><?= $lesson->content ?></div>
                            <?php if (!empty($lesson->material)): ?>
                                <ul class="viewcours-video-list">
                                    <?php foreach ($material as $k => $v): ?>
                                        <li class="viewcours-video-list-item">
                                            <div class="viewcours-video-list-item_container">
                                                <p><?= $v['name'] ?></p>
                                                <a class="link--purple" href="<?= Url::to([$v['file']]) ?>" download="">Скачать</a>
                                            </div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
            <?php endif; ?>
        </article>
        <?php if (!empty($blocksLessons) && !empty($blocksTasks) && !empty($blocksTests)): ?>
            <aside class="viewcours-structure">
                <div class="viewcours-structure_main">
                    <div class="viewcours-structure_container">
                        <h3 class="viewcours-structure-titel">Структура</h3>
                        <ul class="viewcours-structure-list">

                            <?php if (!empty($blocksLessons)): ?>
                                <?php foreach ($blocksLessons as $k => $v): ?>
                                    <li class="viewcours-structure-list-item">
                                        <a class="" href="<?= Url::to(['lesson', 'id' => $v['id']]) ?>">
                                            <h4 class="viewcours-structure-list-item-title"><?= $lesson->block->sort_order . '.' . $v['sort_order'] . ' ' . $v['name'] ?></h4>
                                            <div class="viewcours-structure-list-item-indicator"></div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if (!empty($blocksTasks)): ?>
                                <?php foreach ($blocksTasks as $k => $v): ?>
                                    <li class="viewcours-structure-list-item">
                                        <a href="<?= Url::to(['task', 'id' => $v['id']]) ?>">
                                            <h4 class="viewcours-structure-list-item-title"><?= $lesson->block->sort_order ?>
                                                .<?= count($blocksLessons) + $k + 2 ?> Задание</h4>
                                            <?php
                                            $status = SkillTrainingsTasksAlias::find()->select('status')
                                                ->where(['task_id' => $v['id']])
                                                ->andWhere(['user_id' => Yii::$app->getUser()->getId()])
                                                ->asArray()
                                                ->one();
                                            switch ($status['status']) {
                                                case 'Отправленно' || 'Доработка':
                                                    $color = 'orange';
                                                    break;
                                                case 'Не зачет':
                                                    $color = 'red';
                                                    break;
                                            }
                                            ?>
                                            <div class="viewcours-structure-list-item-indicator text <?= $color ?>"><?= $status['status'] ?></div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if (!empty($blocksTests)): ?>
                                <?php foreach ($blocksTests as $k => $v): ?>
                                    <li class="viewcours-structure-list-item">
                                        <a class="" href="<?= Url::to(['test', 'id' => $v['id']]) ?>">
                                            <h4 class="viewcours-structure-list-item-title"><?= $lesson->block->sort_order ?>
                                                .<?= count($blocksLessons) + count($blocksTasks) + $k + 2 ?> <?= $v['name'] ?></h4>
                                            <div class="viewcours-structure-list-item-indicator"></div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                        <!--                    <div class="viewcours-structure_last">-->
                        <!--                        <button class="viewcours-structure-btn" type="button">-->
                        <!--                            <svg width="11" height="10" viewBox="0 0 11 10" fill="none"-->
                        <!--                                 xmlns="http://www.w3.org/2000/svg">-->
                        <!--                                <path fill-rule="evenodd" clip-rule="evenodd"-->
                        <!--                                      d="M5.71831 0.45464C6.01957 0.755902 6.01957 1.24434 5.71831 1.54561L2.86379 4.40012L10.5509 4.40012C10.7994 4.40012 11.0009 4.75829 11.0009 5.20012C11.0009 5.64195 10.7994 6.00012 10.5509 6.00012L3.03522 6.00012L5.71831 8.68321C6.01957 8.98447 6.01957 9.47291 5.71831 9.77418C5.41704 10.0754 4.9286 10.0754 4.62734 9.77418L0.513056 5.65989C0.211794 5.35863 0.211794 4.87019 0.513056 4.56893L4.62734 0.45464C4.9286 0.153379 5.41704 0.153379 5.71831 0.45464Z"-->
                        <!--                                      fill="#4135F1"/>-->
                        <!--                            </svg>-->
                        <!--                            <p>Все модули</p>-->
                        <!--                        </button>-->
                        <!--                    </div>-->
                    </div>
                </div>

                <!--            <div class="viewcours-structure_all">-->
                <!--                <div class="viewcours-structure_container">-->
                <!--                    <h3 class="viewcours-structure-titel">Все модули</h3>-->
                <!---->
                <!--                    <ul class="viewcours-structure_all_modules">-->
                <!--                        <li class="viewcours-structure_all_module">-->
                <!--                            <button type="button" class="viewcours-structure_all_module-btn">-->
                <!--                                Основы-->
                <!--                            </button>-->
                <!---->
                <!--                            <ul class="viewcours-structure_all_module_bloks">-->
                <!--                                <li class="viewcours-structure_all_module-block">-->
                <!--                                    <button type="button" class="viewcours-structure_all_module-block-btn">-->
                <!--                                        10 Инструменты-->
                <!--                                        <div class="viewcours-structure_all_module-block-btn-indicator"></div>-->
                <!--                                    </button>-->
                <!---->
                <!--                                    <ul class="viewcours-structure_all_module-block_lessons">-->
                <!--                                        <li class="viewcours-structure_all_module-block-lesson">-->
                <!--                                            <a class="viewcours-structure_all_module-block-lesson-link" href="">-->
                <!--                                                10.2 Инструменты работы с клиентом-->
                <!--                                            </a>-->
                <!--                                        </li>-->
                <!--                                    </ul>-->
                <!--                                </li>-->
                <!--                            </ul>-->
                <!--                        </li>-->
                <!--                    </ul>-->
                <!--                </div>-->
                <!--            </div>-->
            </aside>
        <?php endif; ?>
    </section>
</section>