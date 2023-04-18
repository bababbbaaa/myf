<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'LEAD.FORCE';
$this->params['breadcrumbs'][] = [
    'label' => "LEAD.FORCE",
    'url' => Url::to(['index']),
];
$this->params['breadcrumbs'][] = "Офферы";

$user = Yii::$app->getUser();

?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">Офферы для поставщиков</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/lead-force/offer-type/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span class="glyphicon glyphicon-save" style="font-size: 14px" aria-hidden="true"></span>
                    <span style="font-weight: 600;">Офферы от Lead.Force</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Офферы, размещенные от Lead.Force в личном кабинете поставщика и на лендинге
                </div>
            </div>
        </div>
        <?php if($user->can('lead-force')): ?>
            <div class="open-rbac-page" data-url="<?= Url::to(['/lead-force/offers/']) ?>">
                <div>
                    <div style="margin-bottom: 5px">
                        <span class="glyphicon glyphicon-saved" style="font-size: 14px" aria-hidden="true"></span>
                        <span style="font-weight: 600;">Принятые офферы</span>
                    </div>
                    <hr class="ap-hr">
                    <div class="small-text-ap">
                        Принятые офферы пользователями личного кабинета для поставки лидов
                    </div>
                </div>
            </div>
            <div class="open-rbac-page" data-url="<?= Url::to(['/lead-force/main/providers']) ?>">
                <div>
                    <div style="margin-bottom: 5px">
                        <span class="glyphicon glyphicon-link" style="font-size: 14px" aria-hidden="true"></span>
                        <span style="font-weight: 600;">Поставщики лидов</span>
                    </div>
                    <hr class="ap-hr">
                    <div class="small-text-ap">
                        Список сущностей поставщиков лидов, зарегистрированных на проекте
                    </div>
                </div>
            </div>
            <div class="open-rbac-page" data-url="<?= Url::to(['/lead-force/utms']) ?>">
                <div>
                    <div style="margin-bottom: 5px">
                        <span class="glyphicon glyphicon-tags" style="font-size: 14px" aria-hidden="true"></span>
                        <span style="font-weight: 600;">UTM-метки поставщиков</span>
                    </div>
                    <hr class="ap-hr">
                    <div class="small-text-ap">
                        Список UTM-меток поставщиков лидов
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <div class="rbac-info">
        <b>Офферы Lead.Force</b> — заказы от Lead.Force для провайдеров на поставку лидов в систему (таблицу лидов).
    </div>
</div>
