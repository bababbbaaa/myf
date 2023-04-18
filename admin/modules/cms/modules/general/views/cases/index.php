<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Кейсы';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактор главной My.Force', 'url' => ['/cms/general/main/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cases-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить кейс', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            #'link',
            'name',
            'type',
            #'logo',
            //'boss_img',
            //'small_description',
            //'input:ntext',
            //'result:ntext',
            //'from_to:ntext',
            //'comment:ntext',
            //'boss_name',
            //'boss_op',
            //'big_description:ntext',
            //'date',
            //'active',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
