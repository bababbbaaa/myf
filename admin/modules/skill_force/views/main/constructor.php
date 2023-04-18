<?php

use yii\helpers\Url;
use yii\helpers\Html;

$this->title = 'Конструктор курсов';
$this->params['breadcrumbs'][] = ['label' => "Skill.Force", 'url' => 'index'];
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="monospace" style="max-width: 1000px">
    <h1 class="admin-h1">Конструктор курсов</h1>
    <div class="rbac-flex-row">
        <!-- <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/interactive']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Интерактивное создание курсов</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Интерактивное создание курсов Skill.Force
                </div>
            </div>
        </div> -->
        <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/category/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Категории</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Категории курсов и интенсивов Skill.Force
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/trainings/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Курсы</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Курсы и интенсивы Skill.Force
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/blocks/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Блоки (модули)</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Блоки курсов
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/lessons/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Уроки</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Уроки, входящие в состав курсов
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/authors/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Авторы</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Авторы курсов Skill.Force
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/tests/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Тесты</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Тесты, входящие в состав блоков
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/tasks/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Задания</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Задания, входящие в состав уроков
                </div>
            </div>
        </div>
        <div class="open-rbac-page" data-url="<?= Url::to(['/skill-force/teacher/index']) ?>">
            <div>
                <div style="margin-bottom: 5px">
                    <span style="font-weight: 600;">Преподаватели</span>
                </div>
                <hr class="ap-hr">
                <div class="small-text-ap">
                    Преподаватели курсов
                </div>
            </div>
        </div>
    </div>
</div>