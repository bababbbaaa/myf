<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LeadTemplates */

$this->title = 'Добавить шаблон';
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Шаблоны заказов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lead-templates-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
