<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Редактор базы знаний My.Force';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">CMS для базы знаний My.Force</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/knowledgebase/cdb-article/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Статьи базы знаний</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить статью в базу знаний
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/knowledgebase/cdb-category/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Категории базы знаний</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить категорию в базу знаний
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/knowledgebase/cdb-subcategory/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Подкатегории базы знаний</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить подкатегорию в базу знаний
                </div>
            </div>
        </div>
    </div>
    <div class="rbac-info">
        <b>Главная страница My.Force</b> &ndash; основной раздел My.Force с основным содержанием каждого модуля
    </div>
</div>