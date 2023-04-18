<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserModelSearch2 */
/* @var $dataProvider yii\data\ActiveDataProvider */
//test
$this->title = 'Учетные записи АУ';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-model-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить АУ', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            #'is_client',
            'username',
            #'auth_key',
            #'password_hash',
            //'password_reset_token',
            //'email:email',
            //'status',
            //'created_at',
            //'updated_at',
            //'verification_token',
            //'budget',
            //'inner_name',
            //'cc_daily_max',
            //'cc_daily_get',
            //'cc_status',
            //'sms_restore_password',
            //'referal',
            'au_name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
