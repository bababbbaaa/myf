<?php

use yii\widgets\LinkPager;

$this->title = "Логи действий";
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/logs/main/index']),
    'label' => 'ЛОГИ'
];
$this->params['breadcrumbs'][] = "Логи действий";
$js = <<<JS
$('.show-next').on('click', function(e) {
    e.preventDefault();
    $(this).next().show();
    $(this).remove();
});
JS;
$this->registerJs($js);
?>
<style>
    pre {
        max-width: 100%; overflow-x: auto; white-space: break-spaces;
        background: #303030;
        color: #ffe1c1;
        padding: 20px;
    }
</style>
<div>
    <?php if(!empty($logs)): ?>
        <?php foreach($logs as $log): ?>
            <?php $json = json_decode($log['params'], 1); ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>#<?= $log['id'] ?></b> / <b>UID:<?= $log['user'] ?></b>
                </div>
                <div class="panel-body">
                    <?php
                        $dyn = print_r($json, 1);
                        if (mb_strlen($dyn) < 1000) {
                            $render = "<pre>".\yii\helpers\Html::encode($dyn)."</pre>";
                        } else {
                            $render = "<a href='#' class='show-next'>показать лог</a><div style='display: none'><pre>".\yii\helpers\Html::encode($dyn)."</pre></div>";
                        }
                    ?>
                    <?= $render ?>
                </div>
                <div class="panel-footer">
                    <b><?= date("d.m.Y H:i", strtotime($log['date'])) ?></b> | <b>controller:</b> <?= $log['controller'] ?> | <b>action:</b> <?= $log['action'] ?>
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
