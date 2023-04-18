<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Настройки операторов КЦ';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['main/index']),
    'label' => 'КЦ'
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><a class="btn btn-admin" href="create">Добавить оператора</a></p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            $color = $model->status === 0 ? '#ffedeb' : 'transparent';
            return ['style' => "background-color: $color"];
        },
        'columns' => [

            'id',
            'username',
            #'auth_key',
            #'password_hash',
            #'password_reset_token',
            #'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            //'verification_token',
            //'budget',
            'inner_name',
            //'cc_daily_max',
            //'cc_daily_get',
            [
                'attribute' => 'cc_status',
                'value' => function ($model) {
                    return $model->cc_status === \common\models\UserModel::STATUS_WORKING ? 'работает' : 'не работает';
                }
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => "{view}<div></div>{update}<div></div>{ban}", 'buttons' => [
                'ban' => function ($url, $model, $key) {
                    $text = $model->status === 0 ? 'Разблокировать' : 'Блокировать';
                    $class = $model->status === 0 ? 'repeat' : 'remove';
                    return Html::a("<span title='$text' class='glyphicon glyphicon-$class' aria-hidden='true'></span>", Url::to(['settings/ban', 'id' => $model->id]));
                }
            ]],
        ],
    ]); ?>


</div>
