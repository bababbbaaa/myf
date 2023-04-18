<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Настройки и мониторинг';
$this->params['breadcrumbs'][] = "Настройки и мониторинг";



?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">Модуль мониторинга</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/settings/systemd/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-cd" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Фоновые процессы</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Просмотр фоновых демон-процессов в системе
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/settings/main/validation-open']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-eye-close" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Валидация рабочих мест</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Настройки валидации рабочих мест
                </div>
            </div>
        </div>
    </div>

    <div class="rbac-info">
        <b>Модуль мониторинга</b> — система настроек работы панели администрации и прочих серверных функций
    </div>
</div>
