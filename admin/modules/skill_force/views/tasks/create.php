<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainingsTasks */

$this->title = 'Добавить задание';
$this->params['breadcrumbs'][] = ['label' => 'Skill.Force', 'url' => '/skill-force/main/index'];
$this->params['breadcrumbs'][] = ['label' => "Конструктор курсов", 'url' => '/skill-force/main/constructor'];
$this->params['breadcrumbs'][] = ['label' => 'Задания', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-trainings-tasks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>