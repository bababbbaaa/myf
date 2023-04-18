<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */

$this->title = "Заказ #{$model->id}";
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['/lead-force/clients/index']];
$this->params['breadcrumbs'][] = ['label' => 'Заказы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$specialParams = \common\models\CustomParams::find()->where(['OR', ['entity' => 'any'], ['entity' => $model->tableName()]])->asArray()->all();
$specialParamsArr = [];
if (!empty($specialParams)) {
    foreach ($specialParams as $item)
        $specialParamsArr[$item['name']] = $item['description'];
}


$categoryParams = \common\models\LeadsParams::find()->where(['category' => $model->category_link])->asArray()->all();
$categoryParamsArr = [];
if (!empty($categoryParams)) {
    foreach ($categoryParams as $item)
        $categoryParamsArr[$item['name']] = $item['description'];
}
?>
<div class="orders-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Настроить', ['update', 'id' => $model->id], ['class' => 'btn btn-admin']) ?>
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
            'order_name',
            [
                'attribute' => 'client',
                'format' => 'raw',
                'value' => function($model) {
                    if (!empty($model->client))
                        return "<a target='_blank' href='". \yii\helpers\Url::to(['clients/view', 'id' => $model->client]) ."'>Клиент #{$model->client}</a>";
                }
            ],
            'category_link',
            'category_text',
            'status',
            'price',
            'leads_count',
            'leads_get',
            'regions:ntext',
            'emails:ntext',
            [
                'attribute' => 'params_category',
                'format' => 'raw',
                'value' => function ($model) use ($categoryParamsArr) {
                    if (!empty($model->params_category)) {
                        $html = '';
                        $json = json_decode($model->params_category, true);
                        foreach ($json as $key => $item) {
                            if(!is_array($item))
                                $html .= "<b>{$categoryParamsArr[$key]}</b>: {$item} <br>";
                            else
                                $html .= "<b>{$categoryParamsArr[$key]}</b>: ". json_encode($item, JSON_UNESCAPED_UNICODE) ." <br>";
                        }
                        return $html;
                    }
                }
            ],
            'date',
            'date_end',
            'commentary:ntext',
            [
                'attribute' => 'params_special',
                'format' => 'raw',
                'value' => function ($model) use ($specialParamsArr) {
                    if (!empty($model->params_special)) {
                        $html = '';
                        $json = json_decode($model->params_special, true);
                        foreach ($json as $key => $item) {
                            if(!is_array($item))
                                $html .= "<b>{$specialParamsArr[$key]}</b>: {$item} <br>";
                            else
                                $html .= "<b>{$specialParamsArr[$key]}</b>: ". json_encode($item, JSON_UNESCAPED_UNICODE) ." <br>";
                        }
                        return $html;
                    }
                }
            ],
            'leads_waste',
            'sale',
            'archive',
        ],
    ]) ?>

</div>
