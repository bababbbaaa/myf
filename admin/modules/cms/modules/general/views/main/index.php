<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Редактор главной My.Force';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">CMS для главной My.Force</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/general/cases/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Кейсы партнеров</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить кейсы партнеров на главную страницу
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/general/events/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">События и акции</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить события, мероприятия и акции на главную My.Force
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/general/referal-link/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Реферальные ссылки</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить реферальную ссылку на главную My.Force
                </div>
            </div>
        </div>
    </div>
    <div class="rbac-info">
        <b>Главная страница My.Force</b> &ndash; основной раздел My.Force с основным содержанием каждого модуля</b>
    </div>
</div>
