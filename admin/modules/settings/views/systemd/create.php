<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Systemd */

$this->title = 'Добавить фоновый процесс';
$this->params['breadcrumbs'][] = ['label' => "Настройки и мониторинг", 'url' => '/systemd/'];
$this->params['breadcrumbs'][] = ['label' => 'Фоновые процессы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="systemd-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
