<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'FEMIDA.FORCE';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">FEMIDA.FORCE CMS</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/femida/map/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Партнеры по регионам</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить информацию о партнерах в регионах для интерактивной карты.
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/femida/franchise/main/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Конструктор франшиз</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить франшизу, технологию, пакеты франшиз или отзывы к существующим франшизам.
                </div>
            </div>
        </div>
    </div>
    <div class="rbac-info">
        <b>Модуль FEMIDA</b> &ndash; лендинг-ответвление от главного сайта <?= Yii::$app->params['projectName'] ?> для предоставления рекламной информации о FemidaForce.
    </div>
</div>
