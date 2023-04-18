<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\M3ProjectsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Проекты M3';
$this->params['breadcrumbs'][] = $this->title;
$m3Rsh = \common\models\M3Costs::find()->select(['project_id', 'value'])->asArray()->all();
$costToModel = [];
if(!empty($m3Rsh)) {
    foreach ($m3Rsh as $item) {
        $costToModel[$item['project_id']][] = $item['value'];
    }
}
?>
<style>
    table * {
        font-size: 11px;
    }
    .flex {
        display: flex;
    }
    .flex > div:nth-child(2) {
        margin-left: auto;
    }
</style>
<div class="m3-projects-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            $colors = [
                'отмена' => '#fb9d9d',
                'согласование' => '#f5fb9d',
                'в работе' => '#9efb9d',
                'завершен' => '#14d731',
            ];
            return ['style' => 'background-color:' . $colors[$model->status]];
        },
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            'source',
            'responsible',
            [
                'attribute' => 'date_start',
                'value' => function ($model) {
                    return date("d.m.Y", strtotime($model->date_start));
                }
            ],
            //'specs_link',
            [
                'header' => 'Финансы проекта',
                'contentOptions' => ['style' => 'width:200px'],
                'format' => 'html',
                'value' => function($model) use ($costToModel) {
                    $rshText = isset($costToModel[$model->id]) ? number_format(array_sum($costToModel[$model->id]), 0, ',', ' ') . ' руб.' : 0 . " руб.";
                    $rsh = isset($costToModel[$model->id]) ? array_sum($costToModel[$model->id]) : 0;
                    $p = $model->payment_type === 'ИП' ? 0.1 : 0;
                    $p0 = $model->payment_type === 'ИП' ? 0.9 : 1;
                    $msg = "<div class='flex'><div><b>Цена:</b></div> <div>" . number_format($model->price, 0, ',', ' ') . ' руб.' . "</div></div>";
                    $msg .= "<div class='flex'><div><b>Денег получено:</b> </div> <div>" . number_format($model->money_paid, 0, ',', ' ') . ' руб.' . "</div></div>";
                    $msg .= "<div class='flex'><div><b>Расходы:</b> </div> <div>" . $rshText . "</div></div>";
                    $msg .= "<div class='flex'><div><b>Сальдо:</b> </div> <div>" . number_format(round($model->price - $rsh), 0, ',', ' ') . ' руб.' . "</div></div>";
                    $msg .= "<div class='flex'><div><b>Комиссия:</b> </div> <div>" . number_format(round($model->price * $p), 0, ',', ' ') . ' руб.' . "</div></div>";
                    $msg .= "<div class='flex'><div><b>Доля:</b> </div> <div>" . number_format(round(0.25 * $p0 * ($model->price - $rsh)), 0, ',', ' ') . ' руб.' . "</div></div>";
                    return $msg;
                }
            ],
            'status',

            [
                'attribute' => 'date_end',
                'value' => function ($model) {
                    return !empty($model->date_end) ? date("d.m.Y", strtotime($model->date_end)) : "-";
                }
            ],
            [
                'attribute' => 'money_got',
                'value' => function($model) {
                    return (bool)$model->money_got ? 'да' : 'нет';
                }
            ],
            'payment_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
