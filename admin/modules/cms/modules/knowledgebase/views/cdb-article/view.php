<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\CdbArticle */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактор базы знаний My.Force', 'url' => ['/cms/knowledgebase/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Статьи базы знаний', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="cdb-article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-admin']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-admin-delete',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'category_id',
            'subcategory_id',
            'title',
            'description:ntext',
            'text:ntext',
            'link',
            'date',
            'img',
            'minimum_status',
            'price',
            'author',
            'tags',
            'views',
            'likes',
            'downloads',
        ],
    ]) ?>

</div>
