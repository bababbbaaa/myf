<?php

use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\VoiceLeads */

$this->title = 'Редактировать: ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => "LEAD.FORCE",
    'url' => Url::to(['main/index']),
];
$this->params['breadcrumbs'][] = ['label' => 'Голосовые лиды', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="voice-leads-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
