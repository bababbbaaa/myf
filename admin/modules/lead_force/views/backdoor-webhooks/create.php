<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BackdoorWebhooks */

$this->title = 'Добавить вебхук';
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Вебхуки Backdoor', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="backdoor-webhooks-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
