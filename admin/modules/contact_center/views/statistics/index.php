<?php

use admin\models\Admin;
use yii\bootstrap\Dropdown;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CcLeadsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Статистика';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['main/index']),
    'label' => 'КЦ'
];
$this->params['breadcrumbs'][] = $this->title;
$category = \common\models\LeadsCategory::find()->asArray()->select(['name', 'link_name'])->all();
$ca = [];
if (!empty($category)) {
    foreach ($category as $item) {
        $ca[$item['link_name']] = $item['name'];
    }
}
$ccUsers = [];
$cc = \common\models\AuthAssignment::find()->where(['item_name' => 'cc'])->asArray()->select(['item_name', 'user_id'])->all();
if (!empty($cc)) {
    foreach ($cc as $item)
        $ccUsers[] = $item['user_id'];
}

$usArr = [null => 'Любой'];
$usersRender = \common\models\UserModel::find()->where(['in', 'id', $ccUsers])->andWhere(['status' => \common\models\User::STATUS_ACTIVE])->select(['inner_name', 'id'])->asArray()->all();
if (!empty($usersRender)) {
    foreach ($usersRender as $item) {
        $usArr[$item['id']] = $item['inner_name'];
    }
}
$functions = new Admin('contact-center');
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 0});
$('[name="check-all"]').on('input', function() {
    var check = $(this).prop('checked');
    $('[name="check-one"]').prop('checked', check);
});
$('.select-cc-count-table').on('click', function() {
    var pageSize = parseInt($(this).text());
    $.ajax({
        data: {pageSize: pageSize},
        url: '/contact-center/main/cc-prop-change',
        dataType: "JSON",
        type: "POST"
    }).done(function(rsp) {
        if (rsp.status === 'success')
            location.reload();
        else {
             Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: 'Неизвестное значение',
            });
        }
    });
});
JS;
$this->registerJs($js);

?>
<style>
    .select-cc-count-table{
        background-color: whitesmoke; color: #303030; padding: 5px 20px; border: 1px solid #303030; transition: 0.3s ease;
        cursor: pointer;
    }
    .select-cc-count-table-selected, .select-cc-count-table:hover{
        background-color: #303030; color: whitesmoke; padding: 5px 20px; border: 1px solid #303030;
    }
    .opens-block-inner-table {
        font-size: 10px;
    }
</style>
<div class="cc-leads-index">
    <div class="admin-simple-modal-bg close-modal-admin">
        <div class="admin-simple-modal">
            <div class="click-destroy close-modal-admin">
                +
            </div>
            <p><b>Выбрать оператора</b></p>
            <p><select name="order" id="selectOP" class="form-control chosen-select">
                    <?php foreach($usArr as $key => $item): ?>
                        <option value="<?= $key ?>"><?= $item ?></option>
                    <?php endforeach; ?>
                </select></p>
            <p><div class="btn btn-admin succeed-action-order" data-action="">Подтвердить</div></p>
        </div>
    </div>
    <h1><?= Html::encode($this->title) ?></h1>
    <div style="display: flex; flex-wrap: ">
        <div style="margin-right: 10px; margin-bottom: 10px;">
            <a href="create" class="btn btn-admin">Добавить лида</a>
        </div>
        <div style="margin-right: 10px; margin-bottom: 10px;">
            <div class="dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-admin">Операции <b class="caret"></b></a>
                <?php
                echo Dropdown::widget([
                    'items' => $functions->operationsDropdown(),
                ]);
                ?>
            </div>
        </div>
        <div style="margin-right: 10px; margin-bottom: 10px;">
            <div class="select-cc-count-table <?= empty($_SESSION['pageSizeCC']) || $_SESSION['pageSizeCC'] == 50 ? 'select-cc-count-table-selected' : '' ?>">
                50
            </div>
        </div>
        <div style="margin-right: 10px; margin-bottom: 10px;">
            <div class="select-cc-count-table <?= !empty($_SESSION['pageSizeCC']) && $_SESSION['pageSizeCC'] == 100 ? 'select-cc-count-table-selected' : '' ?>">
                100
            </div>
        </div>
        <div style="margin-right: 10px; margin-bottom: 10px;">
            <div class="select-cc-count-table <?= !empty($_SESSION['pageSizeCC']) && $_SESSION['pageSizeCC'] == 200 ? 'select-cc-count-table-selected' : '' ?>">
                200
            </div>
        </div>
    </div>
    <hr>
    <div>
        <h4><b>Выборка за диапазон</b></h4>
        <?= Html::beginForm(Url::to(array_merge(['index'], Yii::$app->request->queryParams)), 'GET') ?>
        <div style="display: flex; flex-wrap: wrap">
            <div style="margin: 0 10px 10px 0">
                <label for="">Начиная с даты</label>
                <div>
                    <?php
                    echo DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'dateStartFilter',
                        'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => date("d.m.Y", time() - 60*60*24)],
                        'value' => $searchModel->dateStartFilter,
                        //'language' => 'ru',
                        'dateFormat' => 'dd.MM.yyyy',
                    ]);?>
                </div>
            </div>
            <div style="margin: 0 10px 10px 0">
                <label for="">Заканчивая датой</label>
                <div>
                    <?php
                    echo DatePicker::widget([
                        'model' => $searchModel,
                        'attribute' => 'dateStopFilter',
                        'value' => $searchModel->dateStopFilter,
                        'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => date("d.m.Y")],
                        //'language' => 'ru',
                        'dateFormat' => 'dd.MM.yyyy',
                    ]);?>
                </div>
            </div>
            <div style="margin: 0 10px 10px 0">
                <label for="">По какой дате</label>
                <div>
                    <?= Html::dropDownList('CcLeadsSearch[dateType]', isset($_GET['CcLeadsSearch']['dateType']) ? $_GET['CcLeadsSearch']['dateType'] : null, [1 => 'По дате поступления', 2 => 'По дате ФС'], ['class' => 'form-control']) ?>
                </div>
            </div>
            <div style="margin: 0 10px 10px 0">
                <div style="height: 25px"></div>
                <button type="submit" style="padding-top: 6px; padding-bottom: 6px;" class="btn btn-admin-help">Поиск</button>
                <button onclick="return location.href='<?= Url::to(['index', 'LeadsSearch[category]' => $searchModel->category]) ?>'" type="reset" style="padding-top: 6px; padding-bottom: 6px;" class="btn btn-admin-delete">Очистить</button>
            </div>
        </div>
        <?= Html::endForm() ?>
    </div>
        <div>
            <h4><b>Выборка по открытиям</b></h4>
            <?= Html::beginForm(Url::to(array_merge(['index'], Yii::$app->request->queryParams)), 'GET') ?>
            <div style="display: flex; flex-wrap: wrap">
                <div style="margin: 0 10px 10px 0">
                    <label for="">Начиная с даты</label>
                    <div>
                        <?php
                        echo DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'dateStartFilterOpened',
                            'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => date("d.m.Y", time() - 60*60*24)],
                            'value' => $searchModel->dateStartFilterOpened,
                            //'language' => 'ru',
                            'dateFormat' => 'dd.MM.yyyy',
                        ]);?>
                    </div>
                </div>
                <div style="margin: 0 10px 10px 0">
                    <label for="">Заканчивая датой</label>
                    <div>
                        <?php
                        echo DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'dateStopFilterOpened',
                            'value' => $searchModel->dateStopFilterOpened,
                            'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => date("d.m.Y")],
                            //'language' => 'ru',
                            'dateFormat' => 'dd.MM.yyyy',
                        ]);?>
                    </div>
                </div>
                <div style="margin: 0 10px 10px 0">
                    <div style="height: 25px"></div>
                    <button type="submit" style="padding-top: 6px; padding-bottom: 6px;" class="btn btn-admin-help">Поиск</button>
                    <button onclick="return location.href='<?= Url::to(['index', 'LeadsSearch[category]' => $searchModel->category]) ?>'" type="reset" style="padding-top: 6px; padding-bottom: 6px;" class="btn btn-admin-delete">Очистить</button>
                </div>
            </div>
            <?= Html::endForm() ?>
        </div>
    <hr>
    <p style="display: none">
        <?= Html::a('Добавить данные', ['create'], ['class' => 'btn btn-admin']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions' => function ($model, $key, $index, $grid) {
            if(in_array($model->status, \common\models\CcLeads::$succeedStatuses))
                $color = "#fbfff7";
            elseif(in_array($model->status, \common\models\CcLeads::$wasteStatuses)) {
                $color = "#fff7f7";
            }
            else
            {
                if (!empty($model->status_temp))
                    $color = "#f0f4ff";
                else
                    $color = 'transparent';
            }
            return ['style' => 'background-color:' . $color ];
        },
        'columns' => [
            [
                'header' => Html::checkbox('check-all', false),
                'headerOptions' => ['style' => 'text-align:center;'],
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::checkbox('check-one', false, ['data-id' => $model->id]);
                }
            ],
            'id',
            [
                'attribute' => 'category',
                'filter' => $ca,
                'value' => function ($model) use ($ca) {
                    return $ca[$model->category];
                }
            ],
            'phone',
            [
                'attribute' => 'sum',
                'value' => function ($model) {
                    if ($model->category === 'dolgi') {
                        $params = json_decode($model->params, 1);
                        return !empty($params['sum']) ? $params['sum'] : '-';
                    } else
                        return '-';
                }
            ],
            [
                'attribute' => 'source',
                'contentOptions' => ['style' => 'word-break: break-word']
            ],
            'region',
            'utm_source',
            'status',
            [
                'attribute' => 'assigned_to',
                'filter' => $usArr,
                'format' => 'html',
                'filterInputOptions' => ['class' => 'form-control chosen-select', 'data-placeholder' => 'Любой'],
                'value' => function ($model) use ($usArr) {
                    if (!empty($model->assigned_to))
                        return $usArr[$model->assigned_to];
                    else
                        return "<b style='color: red'>не указан</b>";
                }
            ],
            [
                'header' => 'Дата',
                'format' => 'html',
                'contentOptions' => ['style' => 'font-size:11px; text-align:right, width:150px'],
                'headerOptions' => ['style' => 'width:150px'],
                'value' => function ($model) {
                    $in = date("d.m.Y H:i", strtotime($model->date_income));
                    if (!empty($model->date_outcome))
                        $out = date("d.m.Y H:i", strtotime($model->date_outcome));
                    $text = "<span style='text-align: right; width: 100%'><span class='glyphicon glyphicon-import' title='Поступил' aria-hidden='true'></span> {$in}";
                    if (!empty($out))
                        $text .= "<div style='margin-bottom: 5px'></div><span class='glyphicon glyphicon-export' title='Указан ФС' aria-hidden='true'></span> {$out}";
                    $text .= "</span>";
                    return $text;
                }
            ],
            #'date_income',
            #'date_outcome',
            //'status_temp',
            //'name',
            //'city',
            //'category',
            //'params:ntext',
            //'info:ntext',
            [
                'attribute' => 'opens',
                'format' => 'html',
                'value' => function ($model) {
                    $opens = $model->opens;
                    if (!empty($opens)) {
                        $html = '<div class="opens-block-inner-table">';
                            $html .= "<div><b>Всего:</b> ". count($opens) ."</div>";
                            foreach ($opens as $key => $item) {
                                $html .= '<div style="margin: 10px 0">'. ($key + 1) . ") " . date("d.m.Y", strtotime($item['date'])) .'</div>';
                            }
                        $html .= '</div>';
                        return $html;
                    }
                }
            ],

            ['class' => 'yii\grid\ActionColumn', 'template' => "{view}<br>{update}"],
        ],
    ]); ?>


</div>
