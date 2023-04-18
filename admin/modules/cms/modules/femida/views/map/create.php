<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Map */

$this->title = 'Добавить партнера';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'FEMIDA.FORCE', 'url' => ['/cms/femida/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Партнеры по регионам', 'url' => ['/cms/femida/map/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="map-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
