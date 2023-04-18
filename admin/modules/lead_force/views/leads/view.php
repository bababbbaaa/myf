<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Leads */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Таблица лидов', 'url' => ['/lead-force/leads/index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="leads-view">

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
            'ip',
            'date_income',
            'date_change',
            'status',
            [
                'attribute' => 'system_data',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = '';
                    if (!empty($model->system_data)) {
                        foreach ($model->system_data as $key => $value)
                            if(!is_array($value))
                                $text .= strip_tags("{$key}: {$value}") . "<br>";
                            else
                                $text .= strip_tags("{$key}: ") . json_encode($value, JSON_UNESCAPED_UNICODE) . "<br>";
                    }
                    return $text;
                }
            ],
            'type',
            'name',
            'email:email',
            'phone',
            'region',
            'city',
            'comments:html',
            [
                'attribute' => 'params',
                'format' => 'raw',
                'value' => function ($model) {
                    $text = '';
                    if (!empty($model->params))
                        foreach ($model->params as $key => $value)
                            $text .= strip_tags("{$key}: {$value}") . "<br>";
                    return $text;
                }
            ],
        ],
    ]) ?>

</div>
