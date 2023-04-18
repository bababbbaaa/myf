<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Dev.Force';
$this->params['breadcrumbs'][] = "Dev.Force";



?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">Панель управления Dev.Force</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/dev-force/dev-cases/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Кейсы</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Выполненые заказы
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/dev-force/dev-services/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Услуги</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Услуги Dev.Force
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/dev-force/dev-project/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Проекты</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Проекты Dev.Force
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/dev-force/dev-payments-alias/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Графики оплат</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Графики оплат по проектам Dev.Force
                </div>
            </div>
        </div>
    </div>
    <div class="rbac-info">
        <b>Dev.Force</b> — ответвление MyForce, представляющее собой платформу разработки
    </div>
</div>
