<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FranchiseCasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Кейсы';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'FEMIDA.FORCE', 'url' => ['/cms/femida/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Конструктор франшиз', 'url' => ['/cms/femida/franchise/main/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="franchise-cases-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить кейс', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            #['class' => 'yii\grid\SerialColumn'],

            'id',
            'franchise_id',
            'date',
            'is_active',
            'img',
            //'name',
            //'whois',
            //'status',
            //'investments',
            //'feedback',
            //'income_approx',
            //'offices',
            //'video',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
