<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UsersCertificatesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Акты';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/logs/main/index']),
    'label' => 'ЛОГИ'
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-certificates-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

            'id',
            'name',
            'user_id',
            #'link',
            'date',

            ['class' => 'yii\grid\ActionColumn', 'template' => "{view}<br>{delete}"],
        ],
    ]); ?>


</div>
