<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Поддержка';
$this->params['breadcrumbs'][] = "Поддержка";



?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">Модуль обратной связи</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/support/dialogues/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-comment" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Тикеты</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Просмотр пользовательских тикетов
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/support/notices/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-info-sign" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Уведомления пользователям</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Push-уведомления для пользователей личного кабинета
                </div>
            </div>
        </div>
    </div>

    <div class="rbac-info">
        <b>Модуль обратной связи</b> позволяет отвечать на вопросы пользователей личного кабинета и отправлять уведомления.
    </div>
</div>
