<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AuthRuleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Правила';
$this->params['breadcrumbs'][] = ['label' => 'RBAC', 'url' => ['/rbac/main/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-rule-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="rbac-info">
        Правила служат для ограничения доступа в рамках определенной роли или разрешения по конкретному условию, описанному в классе соответствующего правила. <br> <strong>Внимание: новые правила требуют дополнительных настроек на программном уровне.</strong>
    </div>

    <div    style="margin: 20px 0">
        <?= Html::a('Создать новое правило', ['create'], ['class' => 'btn btn-admin']) ?>
    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'name',
            'data',
            'created_at',
            'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
