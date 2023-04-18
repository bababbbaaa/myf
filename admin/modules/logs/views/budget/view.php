<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BudgetLog */

$this->title = $model->id;
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/logs/main/index']),
    'label' => 'ЛОГИ'
];
$this->params['breadcrumbs'][] = ['label' => 'Логи баланса', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="budget-log-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'text',
            'date',
            'user_id',
            'budget_was',
        ],
    ]) ?>

</div>
