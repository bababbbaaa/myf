<?php
/**
 * @var \common\models\CronLog $log
 */
use yii\widgets\LinkPager;
$this->title = "Логи CRON";
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/logs/main/index']),
    'label' => 'ЛОГИ'
];
$this->params['breadcrumbs'][] = "Логи CRON";
?>

<div>
    <?php if(!empty($logs)): ?>
        <?php foreach($logs as $log): ?>
            <?php $json = json_decode($log['log'], 1); ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <b>#<?= $log['id'] ?></b> <?= \common\models\CronLog::returnName($json['action']) ?>
                    <br>
                    <?= $json['system'][0] ?>
                </div>
                <div class="panel-body">
                    <?php if(!empty($json['lead'])): ?>
                        <?php foreach($json['lead'] as $ID => $lead): ?>
                            <p><a target="_blank" href="<?= \yii\helpers\Url::to(['/lead-force/leads/index', 'LeadsSearch[id]' => $ID, 'fromLogs' => 1]) ?>"><b>Лид #<?= $ID ?></b></a></p>
                            <ol>
                                <?php foreach($lead as $data): ?>
                                    <li><?= $data ?></li>
                                <?php endforeach; ?>
                            </ol>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="panel-footer">
                    <?= $json['system'][1] ?>
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
