<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AuthItemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->params['breadcrumbs'][] = ['label' => 'RBAC', 'url' => ['/rbac/main/index']];
$this->title = 'Роли и разрешения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="rbac-info">
        Роли и разрешения служат для привязки доступа пользователей к определенному действию или ряду действий в рамках проекта <?= Yii::$app->params['projectName'] ?>
    </div>

    <div style="margin: 20px 0">
        <?= Html::a('Добавить новое значение', ['create'], ['class' => 'btn btn-admin']) ?>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                    'attribute' => 'type',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return $model->type === 1 ? 'Роль' : 'Разрешение';
                    }
            ],
            'description:ntext',
            //'rule_name',
            //'data',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
