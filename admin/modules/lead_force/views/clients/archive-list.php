<?php

$this->title = "Архив";

$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Html; ?>

<style>
    .even-block {
        background-color: #fafafa;
    }
    .sp-block {
        padding: 10px 10px;
        border-top: 1px solid gainsboro;
    }
    .sp-block:first-child {
        border-top: none;
    }
</style>

<div>
    <h1><?= Html::encode($this->title) ?></h1>
    <div style="padding: 10px 0">
        <?= Html::beginForm('archive-list', 'GET') ?>
        <div style="display: flex; max-width: 400px;">
            <input value="<?= $_GET['filter'] ?>" name="filter" type="text" class="form-control" placeholder="Поиск по клиентам">
            <button type="submit" class="btn btn-admin">Поиск</button>
        </div>
        <?= Html::endForm() ?>
    </div>
    <?php if (!empty($clients)): ?>
        <div style="margin-top: 10px">
            <?php $numeral = 1; ?>
            <?php foreach ($clients as $item): ?>
                <?php if (!empty($item->archiveOrders) || $item->archive === 1): ?>
                    <div style="display: flex;" class="sp-block <?= $numeral % 2 !== 0 ? 'even-block' : '' ?>">
                        <div style="flex-basis: 50px;"><b><?= $numeral++ ?></b></div>
                        <div>
                            <div>
                                <b>Клиент ID:<?= $item->id ?> <?= "{$item->f} {$item->i}" ?></b>
                                <?php if ($item->archive === 1): ?>
                                    -
                                    <a href="<?= \yii\helpers\Url::to(['restore-archive', 'type' => 'clients', 'id' => $item->id]) ?>">разархивировать</a>
                                <?php endif; ?>
                            </div>
                            <?php if (!empty($item->archiveOrders)): ?>
                                <ul style="margin-top: 10px; margin-bottom: 0">
                                    <?php foreach ($item->archiveOrders as $order): ?>
                                        <li>
                                            Заказ ID:<?= $order->id ?> <?= $order->order_name ?>
                                            <?php if ($order->archive === 1): ?>
                                                -
                                                <a href="<?= \yii\helpers\Url::to(['restore-archive', 'type' => 'orders', 'id' => $order->id]) ?>">разархивировать</a>
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
            <?php if($numeral === 1): ?>
            <b>Архив пуст</b>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>
