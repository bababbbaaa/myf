<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DevServices */

$this->title = 'Добавить услугу';
$this->params['breadcrumbs'][] = ['label' => "Dev.Force", 'url' => '/dev-force/main/index'];
$this->params['breadcrumbs'][] = ['label' => 'Dev.Services', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dev-services-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
