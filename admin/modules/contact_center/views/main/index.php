<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Контакт-центр';
$this->params['breadcrumbs'][] = "КЦ";
$user = Yii::$app->getUser();
?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">Панель управления КЦ</h1>
    <div class="rbac-flex-row">
        <?php if(!$user->can('qualityControl')): ?>
            <div class="open-rbac-page" data-url="<?= Url::to(['/contact-center/main/leads', 'type' => 'dolgi']) ?>">
                <div>
                    <div style="margin-bottom: 5px">
                        <span class="glyphicon glyphicon-headphones" style="font-size: 14px" aria-hidden="true"></span>
                        <span style="font-weight: 600;">Лиды КЦ</span>
                    </div>
                    <hr class="ap-hr">
                    <div class="small-text-ap">
                        Лиды, которые нуждаются в проверке КЦ
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if($user->can('contactCenter') && !$user->can('qualityControl')): ?>
            <div class="open-rbac-page" data-url="<?= Url::to(['/contact-center/fields/index']) ?>">
                <div>
                    <div style="margin-bottom: 5px">
                        <span class="glyphicon glyphicon-pencil" style="font-size: 14px" aria-hidden="true"></span>
                        <span style="font-weight: 600;">Поля для заполнения</span>
                    </div>
                    <hr class="ap-hr">
                    <div class="small-text-ap">
                        Поля, которые заполняют операторы КЦ, для каждой категории лидов
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php if($user->can('contactCenter')): ?>
        <div class="rbac-flex-row">
            <div class="open-rbac-page" data-url="<?= Url::to(['/contact-center/statistics/index']) ?>">
                <div>
                    <div style="margin-bottom: 5px">
                        <span class="glyphicon glyphicon-info-sign" style="font-size: 14px" aria-hidden="true"></span>
                        <span style="font-weight: 600;">Статистика для модератора</span>
                    </div>
                    <hr class="ap-hr">
                    <div class="small-text-ap">
                        Таблица лидов для статистики и операций
                    </div>
                </div>
            </div>
            <?php if(!$user->can('qualityControl')): ?>
                <div class="open-rbac-page" data-url="<?= Url::to(['/contact-center/settings/index']) ?>">
                    <div>
                        <div style="margin-bottom: 5px">
                            <span class="glyphicon glyphicon-user" style="font-size: 14px" aria-hidden="true"></span>
                            <span style="font-weight: 600;">Настройки операторов КЦ</span>
                        </div>
                        <hr class="ap-hr">
                        <div class="small-text-ap">
                            Задать количество лидов в день, заблокировать оператора и прочее
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="rbac-info">
        <b>Модуль КЦ</b> — модуль для обзвона заявок и учета статистики звонков
    </div>
</div>
