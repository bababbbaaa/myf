<?php
/**
 * @var \common\models\LogProcessor $log
 */
use yii\widgets\LinkPager;
use common\models\Worker;

$this->title = "Логи отправки лидов";
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/logs/main/index']),
    'label' => 'ЛОГИ'
];
$this->params['breadcrumbs'][] = "Логи отправки лидов";
?>

<div>
    <?php if(!empty($logs)): ?>
        <?php foreach($logs as $log): ?>
            <?php
                if ($log['status'] === Worker::LOG_STATUS_ERROR)
                    $class = 'panel-danger';
                elseif($log['status'] === Worker::LOG_STATUS_SUCCESS)
                    $class = 'panel-success';
                else
                    $class = 'panel-default';
            ?>
            <?php $json = json_decode($log['data'], 1); ?>
            <div class="panel <?= $class ?>">
                <div class="panel-heading">
                    <b>#<?= $log['id'] ?></b> <?= $log['date'] ?> - <a target="_blank" href="<?= \yii\helpers\Url::to(['/lead-force/leads/index', 'LeadsSearch[id]' => $log['lead_id'], 'fromLogs' => 1]) ?>"><b>Лид #<?= $log['lead_id'] ?></b></a>
                </div>
                <div class="panel-body">
                    <ul>
                        <?php if(is_array($json) || is_object($json)): ?>
                            <?php foreach($json as $type => $data): ?>
                                <li><b><?= $type ?></b>: <?= is_array($data) ? json_encode($data, JSON_UNESCAPED_UNICODE) : \yii\helpers\Html::encode($data) ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li><?= empty($json) ? $log['data'] : $json ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="panel-footer">
                    <?php $entityArray = \common\models\LogProcessor::returnEntity($log['entity']) ?>
                    <b><a target="_blank" href="<?= \yii\helpers\Url::to(["/lead-force/{$entityArray['type']}/view", 'id' => $entityArray['id']]) ?>">Объектная модель: <?= $entityArray['type'] ?> #<?= $entityArray['id'] ?></a></b>
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
