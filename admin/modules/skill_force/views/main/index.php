<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Skill.Force';
$this->params['breadcrumbs'][] = "Skill.Force";



?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">Панель управления Skill.Force</h1>
    <div class="rbac-flex-row">
        <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/main/constructor']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Конструктор курсов</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Функционал создания курсов, категорий, заданий
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/main/vacancies']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Вакансии</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Функционал создания вакансий
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/checking-assignments']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Проверка заданий</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Проверка заданий к курсам
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/trainings-alias']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Пользовательские курсы</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Добавить/изменить связанные курсы у пользователей
                </div>
            </div>
        </div>
    </div>
    <div class="rbac-info">
        <b>Skill.Force</b> — ответвление MyForce, представляющее собой платформу обучения для студентов
    </div>
</div>