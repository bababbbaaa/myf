<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Offers */

$this->title = $model->name;
$this->params['breadcrumbs'] = [
    [
        'label' => "LEAD.FORCE",
        'url' => Url::to(['main/index']),
    ],
    [
        'label' => "Офферы",
        'url' => Url::to(['main/offers']),
    ],
    [
        'label' => "Принятые офферы",
        'url' => Url::to(['offers/index']),
    ],
];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$category = \common\models\LeadsCategory::find()->select(['link_name', 'name'])->asArray()->all();
$catNames = [];
foreach ($category as $item)
    $catNames[$item['link_name']] = $item['name'];


?>
<div class="offers-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-admin']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
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
            'id',
            'name',
            'status',
            [
                'attribute' => 'category',
                'value' => function ($model) use ($catNames) {
                    return $catNames[$model->category];
                }
            ],
            'regions:ntext',
            'leads_need',
            'leads_confirmed',
            'leads_waste',
            'leads_total',
            'price',
            'tax',
            'total_payed',
            'date',
            'offer_id',
            'user_id',
            'offer_token',
            'special_params:ntext',
        ],
    ]) ?>

</div>
