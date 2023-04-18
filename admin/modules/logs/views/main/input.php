<?php

/**
 * @var \yii\web\View $this
 */

use yii\widgets\LinkPager;

$this->title = 'Логи входящих лидов';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/logs/main/index']),
    'label' => 'ЛОГИ'
];
$this->params['breadcrumbs'][] = $this->title;
?>

<div>
    <?php if(!empty($logs)): ?>
        <?php foreach($logs as $log): ?>
            <?php $json = json_decode($log['info'], 1); ?>
            <?php
            if ($json['code'] !== 200)
                $class = 'panel-danger';
            else
                $class = 'panel-success';
            ?>

            <div class="panel <?= $class ?>">
                <div class="panel-heading">
                   <b>ID:<?= $log['id'] ?> / <?= $log['source'] ?></b>
                </div>
                <div class="panel-body">
                    <ul>
                        <?php foreach($json as $type => $data): ?>
                            <li>
                                <?php if(!is_array($data)): ?>
                                    <b><?= $type ?></b>: <?= $data ?>
                                <?php else: ?><b><?= $type ?></b>: <ol>
                                    <?php foreach($data as $arkey => $arr): ?>
                                        <li><b><?= $arkey ?></b>: <?= $arr ?></li>
                                    <?php endforeach; ?>
                                </ol>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="panel-footer">
                    <?= date("d.m.Y H:i:s", strtotime($log['date'])) ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <?php if(!empty($pages)): ?>
        <?php echo LinkPager::widget([
            'pagination' => $pages,
        ]); ?>
    <?php endif; ?>
</div>
