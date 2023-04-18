<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainingsBlocks */

$this->title = 'Обновить блок: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => "Skill.Force", 'url' => '/skill-force/main/index'];
$this->params['breadcrumbs'][] = ['label' => "Конструктор курсов", 'url' => '/skill-force/main/constructor'];
$this->params['breadcrumbs'][] = ['label' => 'Блоки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="skill-trainings-blocks-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
