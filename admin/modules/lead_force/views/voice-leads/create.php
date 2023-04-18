<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\VoiceLeads */

$this->title = 'Create Voice Leads';
$this->params['breadcrumbs'][] = ['label' => 'Voice Leads', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="voice-leads-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
