<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CdbArticleSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статьи базы знаний';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактор базы знаний My.Force', 'url' => ['/cms/knowledgebase/main/index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cdb-article-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить статью в базу', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'category_id',
//            'subcategory_id',
            'title',
            'description:ntext',
            //'text:ntext',
            //'link',
            //'date',
            //'img',
            //'minimum_status',
            //'price',
            //'author',
            //'tags',
            //'views',
            //'likes',
            //'downloads',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
