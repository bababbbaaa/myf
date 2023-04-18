<?php


use yii\helpers\Url;
use yii\widgets\LinkPager;

$this->title = 'LEAD.FORCE';
$this->params['breadcrumbs'][] = [
    'label' => "LEAD.FORCE",
    'url' => Url::to(['index']),
];
$this->params['breadcrumbs'][] = [
    'label' => "Офферы",
    'url' => Url::to(['offers']),
];
$this->params['breadcrumbs'][] = "Поставщики";
?>



<div class="monospace">
    <h1 class="admin-h1">Поставщики лидов</h1>
    <?php if(!empty($models)): ?>
        <table class="table table-bordered table-responsive">
            <tr>
                <th>ID</th>
                <th>Дата</th>
                <th>ФИО</th>
                <th>Пользователь</th>
                <th>Комментарий</th>
                <th>Токен</th>
                <th>Реквизиты</th>
                <th>Подробные данные</th>
            </tr>
            <?php foreach($models as $item): ?>
                <tr>
                    <td>
                        <?= $item['id'] ?>
                    </td>
                    <td>
                        <?= date("d.m.Y", strtotime($item['date'])) ?>
                    </td>
                    <td>
                        <?= "{$item['f']} {$item['i']} {$item['o']}" ?>
                    </td>
                    <td>
                        <a target="_blank" href="<?= Url::to(['/users/view', 'id' => $item['user_id']]) ?>">польз. #{<?= $item['user_id'] ?>}</a>
                    </td>
                    <td>
                        <?= $item['commentary'] ?>
                    </td>
                    <td>
                        <?= $item['provider_token'] ?>
                    </td>
                    <td>
                        <?php $reqs = json_decode($item['requisites'], 1); ?>
                        <?php if(!empty($reqs)): ?>
                            <ul>
                                <?php foreach($reqs as $k => $v): ?>
                                    <?php if(!is_array($v)): ?>
                                        <li><b><?= $k ?></b>: <?= $v ?></li>
                                    <?php else: ?>
                                        <li><b><?= $k ?></b>:
                                            <ul>
                                                <?php foreach($v as $b => $buf): ?>
                                                    <li><b><?= $b ?></b>: <?= $buf ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php $reqs = json_decode($item['company_info'], 1); ?>
                        <?php if(!empty($reqs)): ?>
                            <ul>
                                <?php foreach($reqs as $k => $v): ?>
                                    <?php if(!is_array($v)): ?>
                                        <li><b><?= $k ?></b>: <?= $v ?></li>
                                    <?php else: ?>
                                        <li>
                                            <b><?= $k ?></b>:
                                            <ul>
                                                <?php foreach($v as $b => $buf): ?>
                                                    <li><b><?= $b ?></b>: <?= $buf ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <span>Поставщики не найдены</span>
    <?php endif; ?>
</div>

<?php if(!empty($pages)): ?>
    <?php echo LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
<?php endif; ?>