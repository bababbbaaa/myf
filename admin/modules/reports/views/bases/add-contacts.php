<?php

/**
 * @var \yii\web\View $this
 * @var \admin\models\Bases $model
 */

use yii\helpers\Html;

$this->title = 'Добавить контакты к базе: ' . $model->name;
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/reports/main/index']),
    'label' => 'Статистика'
];
$this->params['breadcrumbs'][] = ['label' => 'Базы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Добавить контакты';

?>

<div>
    <h3><?= Html::encode($this->title) ?></h3>
    <?= Html::beginForm('add-contacts?id=' . $model->id, 'POST', ['enctype' => 'multipart/form-data']) ?>
    <div style="margin-top: 15px">
        <div style="margin-bottom: 5px"><b>База, .txt-файл*</b></div>
        <div><input required accept=".txt" type="file" class="form-control" name="base" placeholder=""></div>
        <div style="color: #9e9e9e; font-size: 12px">*каждый номер с новой строки</div>
    </div>
    <div style="margin-top: 15px;">
        <button type="submit" class="btn btn-admin">Добавить</button>
    </div>
    <?= Html::endForm() ?>
    <?php if(!empty($err)): ?>
        <div style="margin-top: 20px">
            <?php foreach($err as $item): ?>
                <p><b style="color: red"><?= $item ?></b></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
