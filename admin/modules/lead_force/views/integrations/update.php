<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Integrations */

$this->title = 'Обновить интеграцию #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Интеграции', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "Интеграция #{$model->id}", 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="integrations-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
