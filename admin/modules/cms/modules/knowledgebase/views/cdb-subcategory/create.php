<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CdbSubcategory */

$this->title = 'Добавить подкатегорию в базу знаний';
$this->params['breadcrumbs'][] = ['label' => 'CMS', 'url' => ['/cms/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Редактор базы знаний My.Force', 'url' => ['/cms/knowledgebase/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Подкатегории базы знаний', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cdb-subcategory-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
