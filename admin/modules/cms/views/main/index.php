<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'CMS';
$this->params['breadcrumbs'][] = "CMS";


?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">Система управления содержимым</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/general/main/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Основной раздел My.Force</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    CMS для основного раздела My.Force
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/femida/']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">FEMIDA.FORCE</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Управление контентом модуля FEMIDA.<br>Основная ссылка &ndash; myforce.ru/femida
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/femida/news/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Редактор новостей</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить публикацию в новостную ленту проекта MYFORCE: LEAD, FEMIDA, SKILL
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/skill/main/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">SKILL.FORCE</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Управление контентом модуля SKILL.<br>Основная ссылка &ndash; myforce.ru/skill
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/banners/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Баннеры</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Редактор баннеров и сайдблоков для MYFORCE
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/telegram/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Телеграм Бот</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Редактор сообщений ботов Телеграм
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/cms/knowledgebase/main/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">База знаний</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Редактор базы знаний
                </div>
            </div>
        </div>
    </div>
    <div class="rbac-info">
        <b>Система управления содержимым</b> (англ. Content management system, CMS, система управления контентом) — информационная система, используемая для обеспечения и организации совместного процесса создания, редактирования и управления содержимым, иначе — контентом.
    </div>
</div>
