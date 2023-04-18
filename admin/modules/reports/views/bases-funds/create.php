<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model admin\models\BasesFunds */

$this->title = 'Добавить запись';
$this->params['breadcrumbs'][] = ['url' => \yii\helpers\Url::to(['/reports/main/index']), 'label' => 'Статистика'];
$this->params['breadcrumbs'][] = ['label' => 'Расходы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bases-funds-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
