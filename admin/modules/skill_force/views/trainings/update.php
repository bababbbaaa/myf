<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainings */

$this->title = 'Обновить курс: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => "Skill.Force", 'url' => '/skill-force/main/index'];
$this->params['breadcrumbs'][] = ['label' => "Конструктор курсов", 'url' => '/skill-force/main/constructor'];
$this->params['breadcrumbs'][] = ['label' => 'Курсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="skill-trainings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
