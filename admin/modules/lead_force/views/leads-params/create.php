<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LeadsParams */

$this->title = 'Добавить параметр';
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Таблица лидов', 'url' => ['/lead-force/leads/index']];
$this->params['breadcrumbs'][] = ['label' => 'Параметры лидов', 'url' => ['/lead-force/leads-params/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leads-params-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
