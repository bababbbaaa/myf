<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\TgMessagesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Телеграм сообщения';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tg-messages-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить новое', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'peer',
            'bot',
            'message:ntext',
            'is_loop',
            //'date_to_post',
            //'days_to_post:ntext',
            //'is_done',
            //'minimum_time:datetime',
            //'date_create',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
