<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\DevPaymentsAlias */

$this->title = 'Добавить график оплаты';
$this->params['breadcrumbs'][] = ['label' => "Dev.Force", 'url' => '/dev-force/main/index'];
$this->params['breadcrumbs'][] = ['label' => 'Dev.Payment', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dev-payments-alias-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
