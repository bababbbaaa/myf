<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Отзывы';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => '/cms/'];
$this->params['breadcrumbs'][] = ['label' => 'SKILL.FORCE', 'url' => ['/cms/skill/']];
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">Отзывы Skill.Force</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/skill/reviews-about-training']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Отзывы о курсе</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Таблица отзывов от прошедших конкретный курс
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/skill/reviews-video']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Видео-отзывы</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Видео-отзывы о проекте Skill.Force
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/skill/reviews-profession']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Отзывы о профессиях</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Отзывы прошедших курсы Skill.Force и приобретенных профессиях
                </div>
            </div>
        </div>
    </div>
</div>
