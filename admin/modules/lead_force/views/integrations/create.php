<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Integrations */

$this->title = 'Добавить интеграцию';
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Интеграции', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="integrations-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
