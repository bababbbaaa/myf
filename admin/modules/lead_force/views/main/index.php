<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Lead.Force';
$this->params['breadcrumbs'][] = "LEAD.FORCE";

$user = Yii::$app->getUser();

?>
<div class="monospace">
    <h1 class="admin-h1">Панель управления LEAD.FORCE</h1>
    <div class="rbac-flex-row">
        <?php if(!$user->can('exporter')): ?>
            <?php if($user->can('lead-force')): ?>
                <div class="open-rbac-page" data-url="<?= Url::to(['/lead-force/leads/']) ?>">
                    <div>
                        <div style="margin-bottom: 5px">
                            <span class="glyphicon glyphicon-th-list" style="font-size: 14px" aria-hidden="true"></span>
                            <span style="font-weight: 600;">Таблица лидов</span>
                        </div>
                        <hr class="ap-hr">
                        <div class="small-text-ap">
                            Заявки с сайтов и прочих источников по категориям
                        </div>
                    </div>
                </div>
                <div class="open-rbac-page" data-url="<?= Url::to(['/lead-force/clients/']) ?>">
                    <div>
                        <div style="margin-bottom: 5px">
                            <span class="glyphicon glyphicon-user" style="font-size: 14px" aria-hidden="true"></span>
                            <span style="font-weight: 600;">Клиенты</span>
                        </div>
                        <hr class="ap-hr">
                        <div class="small-text-ap">
                            Клиенты на лиды от FemidaForce
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="open-rbac-page" data-url="<?= Url::to(['/lead-force/main/offers']) ?>">
                <div>
                    <div style="margin-bottom: 5px">
                        <span class="glyphicon glyphicon-tasks" style="font-size: 14px" aria-hidden="true"></span>
                        <span style="font-weight: 600;">Офферы</span>
                    </div>
                    <hr class="ap-hr">
                    <div class="small-text-ap">
                        Таблица офферов для поставщиков лидов
                    </div>
                </div>
            </div>
            <?php if($user->can('lead-force')): ?>
                <div class="open-rbac-page" data-url="<?= Url::to(['/lead-force/integrations/']) ?>">
                    <div>
                        <div style="margin-bottom: 5px">
                            <span class="glyphicon glyphicon-cog" style="font-size: 14px" aria-hidden="true"></span>
                            <span style="font-weight: 600;">Интеграции</span>
                        </div>
                        <hr class="ap-hr">
                        <div class="small-text-ap">
                            Добавить пользовательские интеграции с СРМ для клиентов и заказов
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="open-rbac-page" data-url="<?= Url::to(['/lead-force/lead-templates/index']) ?>">
                <div>
                    <div style="margin-bottom: 5px">
                        <span class="glyphicon glyphicon-floppy-save" style="font-size: 14px" aria-hidden="true"></span>
                        <span style="font-weight: 600;">Шаблоны заказов</span>
                    </div>
                    <hr class="ap-hr">
                    <div class="small-text-ap">
                        Шаблоны заказов для клиентов ЛК и лендинг страницы Lead.Force
                    </div>
                </div>
            </div>
            <?php if($user->can('lead-force')): ?>
                <div class="open-rbac-page" data-url="<?= Url::to(['/lead-force/sources/index']) ?>">
                    <div>
                        <div style="margin-bottom: 5px">
                            <span class="glyphicon glyphicon-flag" style="font-size: 14px" aria-hidden="true"></span>
                            <span style="font-weight: 600;">Источники лидов</span>
                        </div>
                        <hr class="ap-hr">
                        <div class="small-text-ap">
                            Список верифицированных источников лидов
                        </div>
                    </div>
                </div>
                <div class="open-rbac-page" data-url="<?= Url::to(['/lead-force/voice-leads/index']) ?>">
                    <div>
                        <div style="margin-bottom: 5px">
                            <span class="glyphicon glyphicon-apple" style="font-size: 14px" aria-hidden="true"></span>
                            <span style="font-weight: 600;">Голосовые лиды</span>
                        </div>
                        <hr class="ap-hr">
                        <div class="small-text-ap">
                            Список доступных для выгрузки голосовых лидов
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="open-rbac-page" data-url="<?= Url::to(['/lead-force/leads/ltv']) ?>">
                <div>
                    <div style="margin-bottom: 5px">
                        <span class="glyphicon glyphicon-flag" style="font-size: 14px" aria-hidden="true"></span>
                        <span style="font-weight: 600;">LTV</span>
                    </div>
                    <hr class="ap-hr">
                    <div class="small-text-ap">
                        Мои клиенты и продажи
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="rbac-info">
        <b>Модуль LEAD.FORCE</b> — система управления отправкой заявок, настройками заказов, офферов и прочих функций, связанных с поставкой лидов.
    </div>
</div>
