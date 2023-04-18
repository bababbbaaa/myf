<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Вакансии';
$this->params['breadcrumbs'][] = ['label' => "Skill.Force", 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">Конструктор вакансий</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/jobs/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Вакансии</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить вакансии
                </div>
            </div>
        </div>
    </div>
</div>
