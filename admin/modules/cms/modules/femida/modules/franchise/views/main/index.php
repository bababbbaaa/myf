<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Конструктор франшиз';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'FEMIDA.FORCE', 'url' => ['/cms/femida/main/index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="monospace" style="max-width: unset">
    <h1 class="admin-h1">Конструктор франшиз</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/femida/franchise/add/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Франшизы</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить новую франшизу, заполнить информационное содержание блоков.
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/femida/franchise/package/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Пакеты франшиз</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить пакеты к существующей франшизе.
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/femida/franchise/technologies/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Технологии</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить новую технологию и описание к ней.
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/femida/franchise/reviews/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Отзывы о франшизе</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить отзывы к существующей франшизе.
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/femida/franchise/cases/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Кейсы</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить кейсы к существующей франшизе.
                </div>
            </div>
        </div>
    </div>
    <div class="rbac-info">
        <b>Конструктор франшиз</b> позволяет в рамках проекта <?= Yii::$app->params['projectName'] ?> добавлять новые франшизы на лендинговой странице FEMIDA.FORCE, а также редактировать отзывы, технологии и информацию о пакетах франшиз.
    </div>
</div>
