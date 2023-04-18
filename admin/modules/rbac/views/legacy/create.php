<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItemChild */

$this->title = 'Задать наследование';
$this->params['breadcrumbs'][] = ['label' => 'RBAC', 'url' => ['/rbac/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Наследования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-child-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
