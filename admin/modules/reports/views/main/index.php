<?php

/**
 * @var \yii\web\View $this
 */

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = "Статистика";



?>
<div class="monospace">
    <h1 class="admin-h1">Модуль статистики</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/reports/main/leads/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-user" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Лиды</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Статистические данные по лидам
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/reports/bases/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-book" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Базы</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Статистика по базам контактов
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/reports/bases-funds/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-rub" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Расходы</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Таблица расходов
                </div>
            </div>
        </div>
    </div>
    <div class="rbac-info">
        <b>Модуль статистики</b> позволяет вести аналитику, на основании различных отчетов из подразделов проекта MYFORCE
    </div>
</div>
