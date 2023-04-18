<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'LEAD.FORCE';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">LEAD.FORCE CMS</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/lead/offer/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Офферы</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить офферы на лиды для поставщиков FemidaForce
                </div>
            </div>
        </div>

    </div>
    <div class="rbac-info">
        <b>Модуль LEAD</b> &ndash; лендинг-ответвление от главного сайта <?= Yii::$app->params['projectName'] ?> для предоставления рекламной информации об офферах на лиды от FemidaForce, а также об информации для поставщиков лидов. <br> <b>Также данный модуль позволяет управлять контентом личного кабинета FemidaForce.</b>
    </div>
</div>
