<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LeadsSources */

$this->title = 'Добавить источник';
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Источники лидов', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leads-sources-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
