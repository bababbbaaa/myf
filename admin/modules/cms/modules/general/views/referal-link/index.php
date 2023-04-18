<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReferalLinkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Реферальные ссылки';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактор главной My.Force', 'url' => ['/cms/general/main/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="referal-link-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить реферальную ссылку', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'link',
            'text_advantages:ntext',
            'sub_title:ntext',
            //'date',
            //'logo',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
