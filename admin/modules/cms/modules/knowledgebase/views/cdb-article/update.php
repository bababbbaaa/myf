<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CdbArticle */

$this->title = 'Обновить статью базы знаний: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактор базы знаний My.Force', 'url' => ['/cms/knowledgebase/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Статьи базы знаний', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="cdb-article-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
