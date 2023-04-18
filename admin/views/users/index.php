<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UsersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить пользователя', ['create'], ['class' => 'btn btn-admin']) ?>
        <?= Html::a('Скрыть служебные', ['index', 'hide' => 1], ['class' => 'btn btn-admin-help']) ?>
        <?= Html::a('Сброс', ['index'], ['class' => 'btn btn-admin-delete']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions' => function($model) {
            if ($model->status === \common\models\User::STATUS_DELETED)
                $color =  'background: #fff5f5';
            elseif ($model->status === \common\models\User::STATUS_INACTIVE)
                $color =  'background: #ffffa6';
            else
                $color = '';
            $options['style'] = $color;
            return $options;
        },
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'username',
            'email',
            #'password_hash',
            #'password_reset_token',
            [
                'attribute' => 'is_client',
                'contentOptions' => function ($model) {
                    if ($model->is_client === 1)
                        $color = 'red';
                    elseif ($model->is_client === -1)
                        $color = 'blue';
                    else
                        $color = 'magenta';
                    return ['style' => 'color:' . $color];
                },
                'filter' => [0 => 'Не определен', 1 => 'Клиент', -1 => 'Поставщик'],
                'value' => function ($model) {
                    if ($model->is_client === 1)
                        $text = 'клиент';
                    elseif ($model->is_client === -1)
                        $text = 'поставщик';
                    else
                        $text = 'не определен';
                    return $text;
                }
            ],
            //'status',
            //'created_at',
            //'updated_at',
            //'verification_token',
            //'budget',
            //'inner_name',
            //'cc_daily_max',
            //'cc_daily_get',
            //'cc_status',

            [
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'ban' => function ($url, $model, $key) {
                        if($model->status === \common\models\User::STATUS_ACTIVE)
                            return Html::a("<span aria-hidden='true' class='glyphicon glyphicon-remove'></span>", \yii\helpers\Url::to(['users/ban', 'id' => $model->id]), ['title' => 'Заблокировать']);
                        elseif($model->status === \common\models\User::STATUS_INACTIVE)
                            return Html::a("<span aria-hidden='true' class='glyphicon glyphicon-ok'></span>", \yii\helpers\Url::to(['users/ban', 'id' => $model->id]), ['title' => 'Активировать']);
                        else
                            return Html::a("<span aria-hidden='true' class='glyphicon glyphicon-ok'></span>", \yii\helpers\Url::to(['users/ban', 'id' => $model->id]), ['title' => 'Разблокировать']);
                    }
                ],
                'template' => "{view}<br>{update}<br>{ban}<br>{delete}"
            ],
        ],
    ]); ?>


</div>
