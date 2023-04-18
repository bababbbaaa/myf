<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AuthAssignmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Связи';
$this->params['breadcrumbs'][] = ['label' => 'RBAC', 'url' => ['/rbac/main/index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="auth-assignment-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="rbac-info">
        Связи определяют соотношения между пользователями и их доступами, основанными на выбранной роли и/или разрешениях.
    </div>

    <div style="margin: 20px 0">
        <?= Html::a('Создать новую связь', ['create'], ['class' => 'btn btn-admin']) ?>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'item_name',
            [
                    'attribute' => 'user_id',
                    'format' => 'raw',
                    'value' => function($model) {
                        return \common\models\User::findOne($model->user_id)->username;
                    }
            ],
            //'created_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
