<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\SkillPartners */

$this->title = 'Добавить партнера';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => '/cms/'];
$this->params['breadcrumbs'][] = ['label' => 'SKILL.FORCE', 'url' => ['/cms/skill/']];
$this->params['breadcrumbs'][] = ['label' => 'Партнеры курсов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="skill-partners-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
