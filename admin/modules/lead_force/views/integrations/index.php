<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\IntegrationsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Интеграции';
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = $this->title;
$orders = \common\models\Orders::find()->asArray()->select(['order_name', 'id', 'category_text'])->all();
$clients = \common\models\Clients::find()->asArray()->select(['f', 'i', 'id'])->all();
$orArr = [];
$cArr = [];
if (!empty($orders)) {
    foreach ($orders as $item) {
        $orArr[$item['id']] = empty($item['order_name']) ? "#{$item['id']} - {$item['category_text']}" : "#{$item['id']} - {$item['order_name']}";
    }
}
if (!empty($clients)) {
    foreach ($clients as $item) {
        $cArr[$item['id']] = "#{$item['id']} {$item['f']} {$item['i']}";
    }
}
?>
<div class="integrations-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить интеграцию', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            //'entity',
            [
                'attribute' => 'entity_id',
                'format' => 'html',
                'value' => function ($model) use ($orArr, $cArr) {
                    if ($model->entity === 'order') {
                        $text = "<a target='_blank' href='/lead-force/orders/view?id={$model->entity_id}'><b>Заказ: {$orArr[$model->entity_id]}</b></a>";
                    } else
                        $text = "<a target='_blank' href='/lead-force/clients/view?id={$model->entity_id}'><b>Клиент: {$cArr[$model->entity_id]}</b></a>";
                    return $text;
                }
            ],
            #'user_id',
            'integration_type',
            [
                'attribute' => 'config',
                'format' => 'html',
                'value' => function ($model) {
                    $json = json_decode($model->config, true);
                    switch ($model->integration_type) {
                        case "bitrix":
                        case "webhook":
                            return $json['WEBHOOK_URL'];
                        case "telegram":
                            return $json['id'];
                        case "amo":
                            return $json['config']['server'];
                    }
                }
            ],
            [
                'attribute' => 'uuid',
                'format' => 'html',
                'contentOptions' => ['style' => 'font-size:10px'],
                'value' => function ($model) {
                    return "<a target='_blank' href='https://api.myforce.ru/rest/{$model->uuid}/crm.lead.list'>{$model->uuid}</a>";
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
