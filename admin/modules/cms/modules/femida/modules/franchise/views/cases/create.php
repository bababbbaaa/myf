<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FranchiseCases */

$this->title = 'Добавить кейс';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'FEMIDA.FORCE', 'url' => ['/cms/femida/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Конструктор франшиз', 'url' => ['/cms/femida/franchise/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Кейсы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="franchise-cases-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
