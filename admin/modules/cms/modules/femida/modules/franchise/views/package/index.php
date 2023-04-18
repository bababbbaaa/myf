<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FranchisePackageSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пакеты франшиз';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'FEMIDA.FORCE', 'url' => ['/cms/femida/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Конструктор франшиз', 'url' => ['/cms/femida/franchise/main/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="franchise-package-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить пакет франшизы', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
           // ['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',
            //'parent_package',
            //'package_content:ntext',
            'price',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
