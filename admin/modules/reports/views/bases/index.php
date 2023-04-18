<?php

use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel admin\models\BasesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Базы';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['/reports/main/index']),
    'label' => 'Статистика'
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bases-index">
    <h1><?= Html::encode($this->title) ?></h1>
        <div style="display: flex; flex-wrap: wrap">
            <div style="margin-right: 10px; margin-bottom: 10px;"><?= Html::a('Добавить базу', ['create'], ['class' => 'btn btn-admin']) ?></div>
            <div style="margin-right: 10px; margin-bottom: 10px;" class="dropdown">
                <a href="/reports/bases/index" class="btn btn-admin-delete">Сбросить фильтры</a>
            </div>
            <div style="margin-right: 10px; margin-bottom: 10px;"><?= Html::a('UTM-метки', ['utms'], ['class' => 'btn btn-admin-help']) ?></div>
            <div style="margin-right: 10px; margin-bottom: 10px;"><?= Html::a('Контакты', ['contacts'], ['class' => 'btn btn-admin-help']) ?></div>
            <div style="margin-right: 10px; margin-bottom: 10px;"><?= Html::a('Статистика', ['stats'], ['class' => 'btn btn-admin-help-2']) ?></div>
        </div>
    <hr>
    <h4>Показать базы, в которых есть</h4>
    <?= Html::beginForm('/reports/bases/index', 'GET') ?>
    <div style="display: flex; flex-wrap: wrap">
        <div style="margin-right: 10px; margin-bottom: 10px;">
            <div style="margin-bottom: 5px"><b>Метка</b></div>
            <div><input class="form-control" type="text" name="filter[utm]" placeholder="221021" value="<?= $_GET['filter']['utm'] ?? '' ?>"></div>
        </div>
        <div style="margin-right: 10px; margin-bottom: 10px;">
            <div style="margin-bottom: 5px"><b>Единичка</b></div>
            <div>
                <select class="form-control" name="filter[is_1]" id="">
                    <option value="" <?= !isset($_GET['filter']['is_1']) || strlen($_GET['filter']['is_1']) === 0 ? 'selected' : ''  ?>>Выбрать</option>
                    <option value="0" <?= strlen($_GET['filter']['is_1']) > 0 && $_GET['filter']['is_1'] == 0 ? 'selected' : ''  ?>>нет</option>
                    <option value="1" <?= !empty($_GET['filter']['is_1']) && $_GET['filter']['is_1'] == 1 ? 'selected' : ''  ?>>да</option>
                </select>
            </div>
        </div>
    </div>
    <div>
        <button type="submit" class="btn btn-admin">Применить</button>
    </div>
    <?= Html::endForm() ?>
    <hr>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php $default = 'white;' ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered table-special'],
        'columns' => [

            'id',
            'name',
            'category',
            'provider',
            'geo',
            'date_create',
            [
                'attribute' => 'is_new',
                'filter' => Html::activeDropDownList($searchModel, 'is_new', [0 => 'нет', 1 => 'да'],['class'=>'form-control', 'prompt' => '']),
                'value' => function ($model) {
                    return $model->is_new === 1 ? 'да' : 'нет';
                }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
