<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\OrdersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заказы';
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Клиенты', 'url' => ['/lead-force/clients/index']];
$this->params['breadcrumbs'][] = $this->title;
$js = <<<JS
$(document).keyup(function(e) {
     if (e.key === "Escape") { 
         $('.popup-wrapper-date').hide();
    }
});
$('.spawn-date-popup').on('click', function (e) {
    e.preventDefault();
    $('.popup-wrapper-date').css('display', 'flex');
});
$('#dateForm').on('submit', function (e) {
    e.preventDefault();
    var
        data = $(this).serialize();
    $.ajax({
        data: data,
        dataType: "JSON",
        type: "POST",
        url: "/lead-force/orders/get-finished-orders-csv"
    }).done(function (response) {
        if (response.status) {
            $('.popup-wrapper-date').hide();
            Swal.fire({
              icon: 'success',
              title: 'Файл готов',
              html: "<a href='"+ response.file +"'>Нажмите сюда</a>, чтобы скачать файл",
            });
        } else {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: response.message,
            });
        }
    });
});
JS;
$this->registerJs($js);
?>
<style>
    .popup-wrapper-date {
        justify-content: center;
        align-items: center;
        position: fixed;
        display: none;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #0a0a0a30;
    }
    .inner-popup-block {
        background: white;
        max-width: 400px;
        width: 100%;
        padding: 20px;
        border: 1px solid black;
    }
</style>
<div class="popup-wrapper-date">
    <div class="inner-popup-block">
        <?= Html::beginForm('index', 'POST', ['id' => 'dateForm']) ?>
        <div style="text-align: center"><b>Выгрузка по датам</b></div>
        <div style="margin: 10px 0">
            <p><b>Начиная с даты</b></p>
            <p><?= \yii\jui\DatePicker::widget([
                    'name' => 'startDate',
                    'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
                    'dateFormat' => 'dd.MM.yyyy',

                ]) ?></p>
        </div>
        <div style="margin-bottom: 10px">
            <p><b>Заканчивая датой</b></p>
            <p><?= \yii\jui\DatePicker::widget([
                    'name' => 'endDate',
                    'options' => ['class' => 'form-control', 'autocomplete' => 'off'],
                    'dateFormat' => 'dd.MM.yyyy'
                ]) ?></p>
        </div>
        <div style="margin-top: 20px">
            <button type="submit" class="btn btn-admin get-csv-data">Выгрузить</button>
        </div>
        <?= Html::endForm() ?>
    </div>
</div>
<div class="orders-index">
    <style>
        thead tr th {
            white-space: nowrap;
        }
    </style>
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить заказ', ['create'], ['class' => 'btn btn-admin']) ?>
        <?= Html::a('Выгрузка выполненных', ['#'], ['class' => 'btn btn-admin-help spawn-date-popup']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="overflow--" style="overflow-x: auto;">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'id',
                    'header' => 'ID / Название',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if (!empty($model->order_name))
                            return "<b>ID:{$model->id}</b> {$model->order_name}";
                        else
                            return "<b>ID:{$model->id}</b>";
                    }
                ],
                [
                    'attribute' => 'client',
                    'format' => 'raw',
                    'value' => function($model) {
                        if (!empty($model->client))
                            return "<a target='_blank' href='". \yii\helpers\Url::to(['clients/view', 'id' => $model->client]) ."'>Клиент #{$model->client}</a>";
                    }
                ],
                [
                    'header' => 'Данные выгрузки',
                    'format' => 'raw',
                    'value' => function ($model) {
                        $waste = $model->leads_waste;
                        $count = $model->leads_count;
                        $received = $model->leads_get;
                        return "<a href='" . Url::to(['/lead-force/leads/index', 'LeadsSearch[type]' => $model->category_link, 'special_filter[qualityOnlyOrder]' => $model->id]) . "' target='_blank' style='color: #2ea26c'>{$received}</a> / <span style='color: #303030'>{$count}</span> / <a target='_blank' href='" . Url::to(['/lead-force/leads/index', 'LeadsSearch[type]' => $model->category_link, 'special_filter[wasteOnlyOrder]' => $model->id]) . "'>{$waste}</a>";
                    }
                ],
                [
                    'attribute' => 'regions',
                    'contentOptions' => ['style' => 'white-space:normal; max-width:300px; word-break:break-word']
                ],
                'category_text',
                [
                    'attribute' => 'status',
                    'format' => 'raw',
                    'value' => function ($model) {
                        if ($model->status === 'модерация')
                            $color = '#7184ff';
                        elseif ($model->status === 'пауза')
                            $color = '#c18d00';
                        elseif ($model->status === 'остановлен')
                            $color = '#c10000';
                        elseif ($model->status === 'выполнен')
                            $color = '#9e9e9e';
                        else
                            $color = '#00c131';
                        return "<span style='color:{$color};'>{$model->status}</span>";
                    }
                ],
                [
                    'attribute' => 'price',
                    'value' => function ($model) {
                        return "{$model->price} руб.";
                    }
                ],
                //'leads_count',
                //'leads_get',
                //'params_category:ntext',
                //'date',
                //'date_end',
                //'commentary:ntext',
                //'params_special:ntext',
                //'leads_waste',
                //'sale',
                //'archive',

                [
                    'class' => 'yii\grid\ActionColumn',
                    'buttons' => [
                        'archive' => function ($url, $model, $key) {
                            return Html::a("<span title='Архив' class='glyphicon glyphicon-remove' aria-hidden='true'></span>", Url::to(['archive', 'id' => $model->id]));
                        }
                    ],
                    'template' => "{view}<br>{update}<br>{archive}<br>{delete}"
                ],
            ],
        ]); ?>
    </div>

</div>
