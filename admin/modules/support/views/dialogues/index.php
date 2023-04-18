<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DialoguePeerSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Тикеты';
$this->params['breadcrumbs'][] = ['label' => 'Поддержка', 'url' => ['/support/main/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dialogue-peer-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Создать тикет', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-bordered'],
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            return ['style' => $model->status === \common\models\DialoguePeer::STATUS_OPENED ? 'background-color:#f8fff8' : 'background-color:#fffef8'];
        },
        'columns' => [

            'id',
            'user_id',
            'date',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return \common\models\DialoguePeer::$textStatus[$model->status];
                }
            ],

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'response' => function ($url, $model, $key) {
                        return Html::a("<span class='glyphicon glyphicon-comment'></span>", \yii\helpers\Url::to(['chat', 'id' => $model->id]));
                    }
                ],
                'template' => "{response}<br>{update}<br>{delete}<br>"
            ],
        ],
    ]); ?>


</div>
