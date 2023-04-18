<?php

/**
 * @var \yii\web\View $this
 */

$this->title = "Статистика по меткам";
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/reports/main/index']),
    'label' => 'Статистика'
];
$this->params['breadcrumbs'][] = ['label' => 'Базы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

use yii\helpers\Url; ?>
<div class="monospace">
    <h1 class="admin-h1">Модуль статистики</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/reports/bases/utm-stats/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-dashboard" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">За период</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Просмотр статистических данных по нескольким меткам
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/reports/bases/utm-dynamic']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-paste" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Динамическая статистика прозвона</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Статистика по всем меткам
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/reports/bases/utm-region-total']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-zoom-in" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Суммарная статистика по регионам</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Статистика меток по регионам с детализацией
                </div>
            </div>
        </div>
    </div>
</div>
