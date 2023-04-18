<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\AuthItemChild */

$this->title = $model->parent;
$this->params['breadcrumbs'][] = ['label' => 'RBAC', 'url' => ['/rbac/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Наследования', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="auth-item-child-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'parent' => $model->parent, 'child' => $model->child], ['class' => 'btn btn-admin']) ?>
        <?= Html::a('Удалить', ['delete', 'parent' => $model->parent, 'child' => $model->child], [
            'class' => 'btn btn-admin-delete',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'parent',
            'child',
        ],
    ]) ?>

</div>
