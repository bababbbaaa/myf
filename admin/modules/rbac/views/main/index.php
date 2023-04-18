<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'RBAC';
$this->params['breadcrumbs'][] = "RBAC";

?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">Role-based Access Control</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/rbac/roles/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-book" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Роли и разрешения</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Редактор ролей или разрешений для пользователей панели администратора, ЛК и других платформ.
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/rbac/assignments/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-resize-small" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Связи</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Редактор связей для привязки существующих пользователей к определенному правилу или роли.
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/rbac/legacy/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-object-align-vertical" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Наследования</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Просмотр и установка дочерних и родительских ролей, их связей, правил и ограничений.
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/rbac/rules/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-log-in" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Правила</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Просмотр и редактирование правил и ограничений.
                </div>
            </div>
        </div>
    </div>
    <div class="rbac-info">
        Система <b>RBAC</b> позволяет назначать пользователям определенные роли, создавать новые правила и ограничения в рамках всего проекта &laquo;MY.FORCE&raquo;. Установленные роли могут быть унаследованы друг от друга и иметь общие права и привилегии.
    </div>
</div>
