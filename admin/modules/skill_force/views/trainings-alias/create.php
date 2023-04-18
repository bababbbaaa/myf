<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SkillTrainingsAlias */

$this->title = 'Добавить связь';
$this->params['breadcrumbs'][] = ['label' => "Skill.Force", 'url' => '/skill-force/main/index'];
$this->params['breadcrumbs'][] = ['label' => 'Курсы пользователей', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-trainings-alias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
