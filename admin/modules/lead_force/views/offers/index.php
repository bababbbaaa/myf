<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OffersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Принятые офферы';
$this->params['breadcrumbs'] = [
    [
        'label' => "LEAD.FORCE",
        'url' => Url::to(['main/index']),
    ],
    [
        'label' => "Офферы",
        'url' => Url::to(['main/offers']),
    ]
];
$this->params['breadcrumbs'][] = $this->title;

$category = \common\models\LeadsCategory::find()->select(['link_name', 'name'])->asArray()->all();
$catNames = [];
foreach ($category as $item)
    $catNames[$item['link_name']] = $item['name'];

?>
<div class="offers-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить оффер', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
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
            //'leads_confirmed',
            //'leads_waste',
            //'leads_total',
            //'price',
            //'tax',
            //'total_payed',
            //'date',
            //'offer_id',
            //'user_id',
            //'offer_token',
            //'special_params:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'detail_view' => function ($url, $model, $key) {
                        return Html::a("<span title='Просмотр лидов' class='glyphicon glyphicon-info-sign' aria-hidden='true'></span>", Url::to(['offers/detail-view', 'id' => $model->id]));
                    }
                ],
                'template' => "{detail_view}<br>{view}<br>{update}<br>{delete}"
            ],
        ],
    ]); ?>


</div>
