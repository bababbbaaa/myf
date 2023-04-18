<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'ЛОГИ';
$this->params['breadcrumbs'][] = "ЛОГИ";



?>
<div class="monospace">
    <h1 class="admin-h1">Модуль логгирования</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/logs/main/cron/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-barcode" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Логи CRON</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Просмотр отчетов работы CRON и фоновых программ
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/logs/main/sent/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-open-file" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Логи отправки лидов</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Просмотр отчетов отправки лидов
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/logs/main/input/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-copy" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Логи входящих лидов</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Просмотр отчетов входящих лидов с сайтов и от поставщиков
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/logs/budget/index/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-ruble" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Логи баланса</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Просмотр изменения баланса пользователей по датам
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/logs/robokassa/index/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-usd" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Логи Robokassa</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Просмотр логов, приходящих от Robokassa
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/logs/main/action-logs/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-list-alt" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Логи действий</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Лог по действиям пользователей панели администратора
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/logs/bills/index/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-credit-card" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Счета</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Счета на оплату пользователей ЛК
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/logs/acts/index/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-paste" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Акты</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Акты приема-передачи услуг
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/logs/main/providers/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-folder-close" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Документы поставщиков</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Счета и отчеты агентов, загруженные поставщиками
                </div>
            </div>
        </div>
    </div>

    <div class="rbac-info">
        <b>Модуль логгирования</b> — система сбора информации для возможности контроля соблюдения правил работы, установленных для различных сущностей.
    </div>
</div>
