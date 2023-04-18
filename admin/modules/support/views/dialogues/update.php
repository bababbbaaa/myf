<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DialoguePeer */

$this->title = 'Обновить тикет #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Поддержка', 'url' => ['/support/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Тикеты', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['chat', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="dialogue-peer-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
