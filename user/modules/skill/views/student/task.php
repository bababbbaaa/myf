<?php

use common\models\SkillTrainingsTasksAlias;
use yii\helpers\Url;

$this->title = 'Задание';

$js = <<< JS
$('.send_task').on('click', function () {
    
})
JS;
$this->registerJs($js);
$css = <<< CSS
#taskCont{
    width: 100%;
}
CSS;
$this->registerCss($css);
?>

<section class="rightInfo education">
    <div class="bcr">
        <ul class="bcr__list">
            <li class="bcr__item">
                <a href="<?= Url::to(['education']) ?>" class="bcr__link">
                    Моё обучение
                </a>
            </li>

            <?php if ($task->training->type === 'Курс') : ?>
                <li class="bcr__item">
                    <a href="<?= Url::to(['mycours', 'link' => $task->training->link]) ?>" class="bcr__link">
                        <?= $task->training->name ?>
                    </a>
                </li>
            <?php elseif ($task->training->type === 'Интенсив') : ?>
                <li class="bcr__item">
                    <a href="<?= Url::to(['myintensiv', 'link' => $task->training->link]) ?>" class="bcr__link">
                        <?= $task->training->name ?>
                    </a>
                </li>
            <?php else : ?>
                <li class="bcr__item">
                    <a href="<?= Url::to(['myvebinar', 'link' => $task->training->link]) ?>" class="bcr__link">
                        <?= $task->training->name ?>
                    </a>
                </li>
            <?php endif; ?>

            <li class="bcr__item">
                <span class="bcr__span nowpagebrc">Задание</span>
            </li>
        </ul>
    </div>
    <p class="type-cours"><?= $task->training->type ?></p>
    <div class="title_row">
        <h1 class="Bal-ttl title-main"><?= $task->training->name ?></h1>
    </div>

    <h2 class="viewcours-title">
        <?= $task->block->sort_order ?>.1 Задание
    </h2>

    <section class="viewcours_main">
        <article class="viewcours_main_info">
            <div class="viewcours-prev-text"><?= $task->content ?></div>

            <?php if (!empty($task->video) || (!empty($task->materials) && $task->materials != '[]')) : ?>
                <section class="viewcours-video viewcours-card">
                    <?php if (!empty($task->video)) : ?>
                        <div class="viewcours-video_video">
                            <?php parse_str(parse_url($task->video, PHP_URL_QUERY), $video); ?>
                            <iframe src="https://www.youtube.com/embed/<?= $video['v'] ?>?controls=0" frameborder="0" allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($task->materials) && $task->materials != '[]') : ?>
                        <?php $material = json_decode($task->materials, 1) ?>
                        <h3 class="viewcours-video-title">
                            Материалы к лекции
                        </h3>
                        <ul class="viewcours-video-list">
                            <?php foreach ($material as $k => $v) : ?>
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
            <?php endif; ?>
            <section class="viewcours_home-work viewcours-card">
                <?php if (!empty($task->questions)) : ?>
                    <?php foreach (json_decode($task->questions, 1) as $k => $ques) : ?>
                        <div class="viewcours_home-work_container">
                            <h3 class="viewcours_home-work-title"><?= $k + 1 ?>. <?= $ques['title'] ?></h3>
                            <h4 class="viewcours_home-work-subtitle">
                                <?= $ques['body'] ?>
                            </h4>
                            <h4 class="viewcours_home-work-subtitle">
                                Введите ваш ответ
                            </h4>
                            <textarea required minlength="1" class="input-t" placeholder="Введите текст" name="comment" cols="30" rows="3"></textarea>
                        </div>
                    <?php endforeach; ?>
                    <button class="btn--purple viewcours_home-work-submit send_task" type="button">Отправить задание</button>
                <?php endif; ?>

            </section>
        </article>

        <aside class="viewcours-structure">
            <div class="viewcours-structure_main">
                <div class="viewcours-structure_container">
                    <h3 class="viewcours-structure-titel">Структура</h3>
                    <ul class="viewcours-structure-list">

                        <?php if (!empty($blocksLessons)) : ?>
                            <?php foreach ($blocksLessons as $k => $v) : ?>
                                <li class="viewcours-structure-list-item">
                                    <a class="" href="<?= Url::to(['lesson', 'id' => $v['id']]) ?>">
                                        <h4 class="viewcours-structure-list-item-title"><?= $task->block->sort_order . '.' . $v['sort_order'] . ' ' . $v['name'] ?></h4>
                                        <div class="viewcours-structure-list-item-indicator"></div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <?php if (!empty($blocksTasks)) : ?>
                            <?php foreach ($blocksTasks as $k => $v) : ?>
                                <li class="viewcours-structure-list-item">
                                    <a href="<?= Url::to(['task', 'id' => $v['id']]) ?>">
                                        <h4 class="viewcours-structure-list-item-title"><?= $task->block->sort_order ?>
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
                        <?php if (!empty($blocksTests)) : ?>
                            <?php foreach ($blocksTests as $k => $v) : ?>
                                <li class="viewcours-structure-list-item">
                                    <a class="" href="<?= Url::to(['test', 'id' => $v['id']]) ?>">
                                        <h4 class="viewcours-structure-list-item-title"><?= $task->block->sort_order ?>
                                            .<?= count($blocksLessons) + count($blocksTasks) + $k + 2 ?> <?= $v['name'] ?></h4>
                                        <div class="viewcours-structure-list-item-indicator"></div>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </aside>
    </section>
</section>