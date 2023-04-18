<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'SKILL.FORCE';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">SKILL.FORCE CMS</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/skill/partners/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Партнеры курсов</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Партнеры-поставщики курсов MyForce
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/skill/main/reviews']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Отзывы</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Различные отзывы: о курсах, о проекте, о профессии
                </div>
            </div>
        </div>
    </div>
    <div class="rbac-info">
        <b>Модуль SKILL</b> &ndash; лендинг о курсах, интенсивах и вебинарах от различных авторов и партнеров, проводимых в рамках проекта MyForce
    </div>
</div>
