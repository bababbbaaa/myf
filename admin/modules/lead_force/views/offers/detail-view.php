<?php

use common\models\Leads;

/**
 * @var $offer \common\models\Leads[]
 */

use yii\helpers\Url;

$this->title = "Просмотр информации по офферу";
$this->params['breadcrumbs'] = [
    [
        'label' => "LEAD.FORCE",
        'url' => Url::to(['main/index']),
    ],
    [
        'label' => "Офферы",
        'url' => Url::to(['main/offers']),
    ],
    [
        'label' => "Принятые офферы",
        'url' => Url::to(['offers/index']),
    ]
];
$this->params['breadcrumbs'][] = $this->title;

function getColor ($status) {
    if ($status === Leads::STATUS_MODERATE)
        return '#eb9e39';
    elseif ($status === Leads::STATUS_WASTE)
        return '#eb3939';
    elseif ($status === Leads::STATUS_NEW)
        return '#3978eb';
    else
        return '#21b933';
}

?>

<div>
    <h3>Просмотр информации по офферу №<?= $_GET['id'] ?></h3>
    <table class="table table-bordered table-responsive">
        <tr style="background: #303030; color: whitesmoke">
            <th>ID связи</th>
            <th>Клиент</th>
            <th>Заказ</th>
            <th>Лид</th>
            <th>Статус</th>
        </tr>
        <?php if(!empty($offer)): ?>
            <?php foreach($offer as $item): ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><a target="_blank" href="<?= Url::to(['/lead-force/clients/view', 'id' => $item['client_id']]) ?>">#<?= $item['client_id'] ?></a></td>
                    <td><?php if(!empty($item['order_id'])):?><a target="_blank" href="<?= Url::to(['/lead-force/orders/view', 'id' => $item['order_id']]) ?>">#<?= $item['order_id'] ?></a><?php else: ?>-<?php endif; ?></td>
                    <td><a target="_blank" href="<?= Url::to(['/lead-force/leads/view', 'id' => $item['lead_id']]) ?>">#<?= $item['lead_id'] ?></a></td>
                    <td style="color: <?= getColor($item['status']) ?>"><?= $item['status'] ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="4">Данные отстутвуют</td>
        </tr>
        <?php endif; ?>
    </table>
</div>

