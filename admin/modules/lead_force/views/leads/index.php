<?php

use common\models\LeadsParams;
use common\models\LeadsParamsValues;
use kartik\datetime\DateTimePicker;
use yii\bootstrap\Dropdown;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use admin\models\Admin;
use yii\widgets\Pjax;
use common\models\Orders;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LeadsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Таблица лидов';
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJsFile(Url::to(['/js/lead.force.js']), ['depends' => \yii\web\JqueryAsset::class]);
$functions = new Admin('leads');
$leadParams = LeadsParams::find()->all();
$this->registerJsFile(Url::to(['/js/jquery-ui.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerCssFile(Url::to(['/css/jquery-ui.min.css']));
$orders = Orders::find()
    ->select(['id', 'order_name', 'category_text'])
    ->where(['!=', 'status', Orders::STATUS_FINISHED])
    ->andWhere(['!=', 'archive', 1])
    ->asArray()
    ->all();
$orderArray = [];

foreach ($orders as $item)
    $orderArray[$item['id']] = empty($item['order_name']) ? "#{$item['id']} {$item['category_text']}" : "#{$item['id']} {$item['order_name']}";

if(!empty($_GET['special_filter'])) {
    $spf = $_GET['special_filter'];
    if(!empty($spf['wasteOnlyOrder'])) {
        $title = "Брак по заказу №{$spf['wasteOnlyOrder']}";
    }
    elseif(!empty($spf['qualityOnlyOrder']))
        $title = "Все лиды по заказу №{$spf['qualityOnlyOrder']}";
    else
        $title = Html::encode($this->title);
} else
    $title = Html::encode($this->title);
if(!empty($_GET['LeadsSearch']['utm_analysis']))
    $title = 'UTM-аналитика';


$js1 = <<<JS
$('.leads-index').on('click', '.toggle-id-text', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-toggle-id');
    $('.data-goggle[data-toggle-id="'+ id +'"]').toggle();
    $(this).parent().remove();
});

$('.leads-index').on('click', '.hide-column', function (e) {
    e.preventDefault();
    $.ajax({
        data: {change: 1},
        type: "POST",
        url: '/lead-force/leads/change-log-visibility'
    }).done(function () {
        location.reload();
    });
});

$('.leads-index').on('click', '.hide-column0', function (e) {
    e.preventDefault();
    $.ajax({
        data: {change: 1},
        type: "POST",
        url: '/lead-force/leads/change-log-visibility0'
    }).done(function () {
        location.reload();
    });
});
$('.select-cc-count-table').on('click', function() {
    var pageSize = parseInt($(this).text());
    $.ajax({
        data: {pageSize: pageSize},
        url: '/lead-force/leads/cc-prop-change',
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
})
JS;

$this->registerJs($js1);

?>
<style>
    .select-cc-count-table{
        background-color: whitesmoke; color: #303030; padding: 5px 20px; border: 1px solid #303030; transition: 0.3s ease;
        cursor: pointer;
    }
    .select-cc-count-table-selected, .select-cc-count-table:hover{
        background-color: #303030; color: whitesmoke; padding: 5px 20px; border: 1px solid #303030;
    }
</style>
<style>
    .opens-block-inner-table {
        font-size: 10px;
    }
    .content-block {
        overflow-x: auto;
    }
    td {
        max-width: 250px;
        overflow: auto;
    }
    td > div {
        max-width: 250px;
        white-space: normal;
        text-align: right;
        font-size: 11px;
    }
    td, th, table, td>input {
        border-color: #505a70 !important;
    }
    .table-bordered > thead > tr > th, .table-bordered > thead > tr > td {
        border-bottom-width: 0;
    }
    tr:hover {
        background: #fafafa;
    }
    td > .empty {
        text-align: left;
    }
</style>
<div class="admin-simple-modal-bg close-modal-admin">
    <div class="admin-simple-modal">
        <div class="click-destroy close-modal-admin">
            +
        </div>
        <p><b>Выбрать заказ</b></p>
        <p><select name="order" id="selectOrder" class="form-control chosen-select">
                <?php foreach($orderArray as $key => $item): ?>
                    <option value="<?= $key ?>"><?= $item ?></option>
                <?php endforeach; ?>
            </select></p>
        <p><div class="btn btn-admin succeed-action-order" data-action="">Подтвердить</div></p>
    </div>
</div>
<div class="admin-simple-modal-bg-2 close-modal-admin">
    <div class="admin-simple-modal">
        <div class="click-destroy close-modal-admin">
            +
        </div>
        <p><b>Выбрать заказ</b></p>
        <p><select name="order" id="selectOrder_2" class="form-control chosen-select">
                <?php foreach($orderArray as $key => $item): ?>
                    <option value="<?= $key ?>"><?= $item ?></option>
                <?php endforeach; ?>
            </select></p>
        <p><b>Указать время начала</b></p>
        <p>
            <?php
            $t = date("d.m.Y H:i", time() + 60*60);
            echo DateTimePicker::widget([
                'name' => 'start_time',
                'value' => $t,
                'options' => ['placeholder' => $t, 'id' => 'selectOrder_start'],
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'dd.mm.yyyy hh:ii',
                ]
            ]); ?>
        </p>
        <p><b>Интервал (минут)</b></p>
        <p><input type="number" name="interval_input" id="selectOrder_interval" placeholder="5" class="form-control" min="1" max="1440" step="1"></p>
        <p><div class="btn btn-admin succeed-action-order" data-action="">Подтвердить</div></p>
    </div>
</div>
<div class="admin-simple-modal-bg-3 close-modal-admin">
    <div class="admin-simple-modal">
        <div class="click-destroy close-modal-admin">
            +
        </div>
        <p><b>Указать цену за лида</b></p>
        <input id="inputAuctionPrice" type="number" placeholder="500" min="1" step="10" class="form-control">
        <p><div class="btn btn-admin succeed-action-order" data-action="">Подтвердить</div></p>
    </div>
</div>
<div class="leads-index" >

    <h1><?= $title ?></h1>

    <div style="display: flex; flex-wrap: wrap">
        <div style="margin-right: 10px; margin-bottom: 10px;">
            <a href="<?= Url::to(['create']) ?>" class="btn btn-admin">Добавить лида</a>
        </div>
        <div style="margin-right: 10px; margin-bottom: 10px;">
            <a href="<?= Url::to(['/lead-force/leads-category/']) ?>" class="btn btn-admin">Категории лидов</a>
        </div>
        <div style="margin-right: 10px; margin-bottom: 10px;">
            <a href="<?= Url::to(['/lead-force/leads-params/']) ?>" class="btn btn-admin">Параметры лидов</a>
        </div>
    </div>
    <div style="display: flex; flex-wrap: wrap">
        <div style="margin-right: 10px; margin-bottom: 10px;">
            <a href="<?= Url::to(['backdoor']) ?>" class="btn btn-admin">Backdoor Лиды</a>
        </div>
        <div style="margin-right: 10px; margin-bottom: 10px;">
            <a href="<?= Url::to(['backdoor-deals']) ?>" class="btn btn-admin">Backdoor Сделки</a>
        </div>
        <div style="margin-right: 10px; margin-bottom: 10px;">
            <div class="dropdown">
                <a style="padding: 5px 40px" href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-admin-help">Операции <b class="caret"></b></a>
                <?php
                echo Dropdown::widget([
                    'items' => $functions->operationsDropdown(),
                ]);
                ?>
            </div>
        </div>
    </div>
    <div style="display: flex; flex-wrap: wrap">
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

    <?php
        $defaultColumns = [
            ['class' => 'yii\grid\ActionColumn', 'template' => "{view}<br>{alias}<br>{update}<br>{delete}", 'buttons' => [
                'alias' => function ($url, $model, $key) {
                    return Html::a("<span title='Просмотр связей' class='glyphicon glyphicon-retweet' aria-hidden='true'></span>", Url::to(['leads/alias', 'id' => $model->id]));
                }
            ]],
            [
                'header' => 'Сводка',
                'attribute' => 'id',
                'format' => 'raw',
                'value' => function ($model) {
                    if ($model->status === 'брак' && !empty($model->leadsSentReports[0]->status_commentary)) {
                        $add = "<span style='font-size: 10px; vertical-align: middle'> ({$model->leadsSentReports[0]->status_commentary})</span>";
                        if ($model->leadsSentReports[0]->status_confirmed == 1)
                            $add .= "<br><span style='font-size: 10px; vertical-align: middle; text-decoration: underline'>статус подтвержден</span>";
                    }
                    else
                        $add = '';
                    if ($model->status === \common\models\Leads::STATUS_WASTE)
                        $color = '#A2441B';
                    elseif ($model->status === \common\models\Leads::STATUS_SENT)
                        $color = '#2ea26c';
                    elseif ($model->status === \common\models\Leads::STATUS_MODERATE)
                        $color = '#d69759';
                    elseif ($model->status === \common\models\Leads::STATUS_INTERVAL)
                        $color = '#e013b4';
                    elseif ($model->status === \common\models\Leads::STATUS_CONFIRMED)
                        $color = '#1d724a';
                    elseif ($model->status === \common\models\Leads::STATUS_AUCTION)
                        $color = '#13a7e0';
                    else
                        $color = '#1370e0';
                    $ccT = '';
                    if ($model->cc_check === 1)
                        $ccT = "<span title='Проверен КЦ' class='glyphicon glyphicon-headphones' aria-hidden='true' style='font-size: 11px; color: #9e0505'></span>";
                    return "<b>ID: <span style='color: {$color}'>{$model->id} {$ccT}</span></b><br><b style=''>Статус: <span style='color: $color'>{$model->status}$add</span></b><br><b style=''><span style='color: $color'>". date("d-m-Y H:i", strtotime($model->date_income)) ."</span></b><br><span style='color: #60a8ff'>{$model->ip}</span>";
                }
            ],
            [
                'attribute' => 'source',
                'format' => 'html',
                'contentOptions' => ['style' => ' word-break: break-all; white-space: break-spaces;']
            ],
            #'date_income',
            [
                'attribute' => 'name',
                'contentOptions' => ['style' => ' word-break: keep-all; white-space: break-spaces;']
            ],
            'phone',
            [
                'attribute' => 'region',
                'contentOptions' => ['style' => 'white-space:normal'],
            ],
            [
                'attribute' => 'city',
                'contentOptions' => ['style' => 'white-space:normal'],
            ],
        ];
        if(!empty($_GET['LeadsSearch']['utm_analysis'])) {
            array_unshift($defaultColumns, 'utm_source',
                'utm_campaign', 'utm_medium', 'utm_content', 'utm_term', 'utm_title', 'utm_device_type', 'utm_age', 'utm_inst', 'utm_special');
        }
        if(!empty($leadParams)) {
            foreach ($leadParams as $item)
                if ($item->category === $searchModel->type)
                    $defaultColumns[] = [
                        #'attribute' => "leadsParamsValues",
                        'header' => $item->description,
                        'headerOptions' => ['style' => 'color:#af0000'],
                        'filter' => "<input autocomplete=\"off\" type=\"text\" class=\"form-control\" name=\"LeadsSearch[{$item->name}]\" value='{$_GET['LeadsSearch'][$item->name]}'>",
                        /*'value' => function ($model) use ($item) {
                            foreach ($model->leadsParamsValues as $k)
                                if ($k->param === $item->name)
                                    return $k->value;
                            return null;
                        },*/
                        'value' => function($model) use ($item) {
                            if (!empty($model->params[$item->name]))
                                return $model->params[$item->name];
                            else
                                return null;
                        }
                        /*function($model) use ($item) {
                            return $model->params[$item->name];
                        }*/
                    ];
        }
        if (!Yii::$app->getUser()->can('ropView')) {
            $defaultColumns[] = [
                'attribute' => 'system_data',
                'header' => 'Лог <a href="#" class="hide-column">' . ($_SESSION['log_hidden'] ? '<|>' : '>|<') . '</a>',
                'contentOptions' => [/*'style' => 'max-width:400px; word-break:break-word; white-space:normal'*/],
                'format' => 'raw',
                'value' => function ($model) {
                    $returnText = '';
                    if ($_SESSION['log_hidden'])
                        return "<i style='font-size: 11px'># # #</i>";
                    if (!empty($model->system_data) && is_array($model->system_data)) {
                        $c = count($model->system_data);
                        if ($c <= 2) {
                            for ($i = $c - 1; $i >= 0; $i--) {
                                $returnText .= "<div><b>{$model->system_data[$i]['date']}</b><br> {$model->system_data[$i]['text']}</div>";
                                if ($i !== 0)
                                    $returnText .= "<hr style='margin: 10px auto'>";
                            }
                        } else {
                            $k = $c - 1;
                            for ($i = $c - 1; $i >= 0; $i--) {
                                $returnText .= "<div><b>{$model->system_data[$i]['date']}</b><br> {$model->system_data[$i]['text']}</div><hr style='margin: 10px auto'>";
                                if ($k - $i >= 1) {
                                    $k = $i;
                                    break;
                                }
                            }
                            $returnText .= "<div style='text-align: right; font-size: 10px'><a class='toggle-id-text' data-toggle-id='{$model->id}'>показать еще</a></div><div style='display: none' class='data-goggle' data-toggle-id='{$model->id}'>";
                            for ($i = $k - 1; $i >= 0; $i--) {
                                $returnText .= "<div><b>{$model->system_data[$i]['date']}</b><br> {$model->system_data[$i]['text']}</div>";
                                if ($i !== 0)
                                    $returnText .= "<hr style='margin: 10px auto'>";
                            }
                            $returnText .= "</div>";
                        }

                        /*foreach ($model->system_data as $key => $sd) {

                        }*/
                    }
                    return $returnText;
                }
            ];
        }
        $defaultColumns[] =             [
            'attribute' => 'opens',
            'header' => 'Отправки в КЦ <a href="#" class="hide-column0">' . ($_SESSION['log_hidden0'] ? '<|>' : '>|<') . '</a>',
            'format' => 'html',
            'value' => function ($model) {
                $opens = $model->opens;
                if (!empty($opens) && !$_SESSION['log_hidden0']) {
                    $html = '<div class="opens-block-inner-table">';
                    $html .= "<div><b>Всего:</b> ". count($opens) ."</div>";
                    foreach ($opens as $key => $item) {
                        $html .= '<div style="margin: 10px 0">'. ($key + 1) . ") " . date("d.m.Y", strtotime($item['date'])) .'</div>';
                    }
                    $html .= '</div>';
                    return $html;
                } else
                    return "# # #";
            }
        ];
        ?>



    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="overflow--" style="overflow-x: auto;">

        <div style="display: flex; align-items: center; margin-bottom: 10px; flex-wrap: wrap; padding: 0 10px">
            <div style="margin-right: 15px; margin-bottom: 10px;">
                <h4 style="font-weight: 700; ">Просмотр категории</h4>
            </div>
            <div style="margin-bottom: 10px;">
                <div class="dropdown">
                    <a href="#" data-toggle="dropdown" class="dropdown-toggle btn btn-admin" style="padding: 0px 5px 0px 7px"><?= !empty($_GET['LeadsSearch']['type']) ? isset($cArray[$_GET['LeadsSearch']['type']]) ? $cArray[$_GET['LeadsSearch']['type']] : $cArray[array_key_first($cArray)] : $cArray[array_key_first($cArray)] ?> <b class="caret"></b></a>
                    <?php
                        $arr = [];
                        foreach ($cArray as $key => $item) {
                            if (in_array($key, \common\models\LeadsCategory::$special_categories))
                                continue;
                            $arr[] = ['label' => $item, 'url' => Url::to(['index', 'LeadsSearch[type]' => $key])];
                        }
                        echo Dropdown::widget([
                            'items' => $arr,
                        ]);
                    ?>
                </div>
            </div>
            <div class="anim-ajax-block anim-ajax-small" style="display: none;">
                <div class="cssload-spin-box"></div>
            </div>
        </div>
        <?php Pjax::begin(['id' => 'pjaxMain', 'enablePushState'  => true, 'timeout' => 1500, 'options' => ['style' => ""]]) ?>
        <div style="padding: 0 10px;">
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
                            'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => '01-09-2021'],
                            'value' => $searchModel->dateStartFilter,
                            //'language' => 'ru',
                            'dateFormat' => 'dd-MM-yyyy',
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
                            'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => '02-09-2021'],
                            //'language' => 'ru',
                            'dateFormat' => 'dd-MM-yyyy',
                        ]);?>
                    </div>
                </div>
                <div style="margin: 0 10px 10px 0">
                    <div style="height: 25px"></div>
                    <button type="submit" style="padding-top: 6px; padding-bottom: 6px;" class="btn btn-admin-help">Поиск</button>
                    <button onclick="return location.href='<?= Url::to(['index', 'LeadsSearch[type]' => $searchModel->type]) ?>'" type="reset" style="padding-top: 6px; padding-bottom: 6px;" class="btn btn-admin-delete">Очистить</button>
                </div>
            </div>
            <?= Html::endForm() ?>
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
                            <button onclick="return location.href='<?= Url::to(['index', 'LeadsSearch[type]' => $searchModel->type]) ?>'" type="reset" style="padding-top: 6px; padding-bottom: 6px;" class="btn btn-admin-delete">Очистить</button>
                        </div>
                    </div>
                    <?= Html::endForm() ?>
                </div>
        </div>

        <div class="flex-grid-main">
            <div></div>
            <div style="overflow: auto" id="scrolled-block">
                <?= GridView::widget([
                    #'summary' => "<p><b>Всего записей</b>: {totalCount}</p>",
                    'summary' => "<div style='background: white!important;'>Всего найдено <b>{totalCount}</b> записей</div>",
                    'dataProvider' => $dataProvider,
                    'tableOptions' => ['style' => 'white-space:nowrap; ', 'class' => 'table table-bordered table-move-left-right'],
                    'rowOptions' => ['class' => 'leads-row'],
                    'filterModel' => $searchModel,
                    'columns' => $defaultColumns,
                ]); ?>
            </div>
            <div></div>
        </div>

        <?php Pjax::end() ?>


    </div>


    <h4 style="margin: 40px 0">Справка</h4>
    <div class="rbac-info rbac-info-leads" style="max-width: unset">
        <p>Кнопка <code>Операции</code> позволяет выполнять различные манипуляции с выборкой лидов (выгрузка и прочее).</p>
        <p>Для выбора (снятия выбора) строк - использовать <code>cntrl + click</code>.</p>
        <hr>
        <p>Для того чтобы полностью сбросить текущую выборку и отменить действия операций - используйте кнопку <code>Сбросить фильтр</code> в операциях</p>
        <hr>
        <p>Категория отображаемых лидов поумолчанию - "Долги". Для смены категории - выбрать необходимую в разделе "Просмотр категории".</p>
        <p>Анимированный индикатор возле выбранной категории свидетельствует о синхронизации с сервером - в текущий момент таблица лидов обновляется. Синхронизация останавливается при любых действиях пользователя и будет возобновлена автоматически при бездействии.</p>
        <hr>
        <p>Для каждой <a target="_blank" href="<?= Url::to(['leads-category/index']) ?>">категории лидов</a> указаны <a
                    target="_blank" href="<?= Url::to(['leads-params/index']) ?>">определенные параметры</a>, характерные только для данной категории. Данные параметры в таблице выделены <span style="color: #af0000; font-weight: 700;">другим цветом</span> и могут быть отредактированы по указанным ссылкам.</p>
        <p>Способ фильтрации "категория-зависимого параметра" можно задать в его настройках: равенство или подобие. При указании "равенство" - фильтрация будет происходить по принципу равенства данного параметра указанному значению в фильтре (например: сумма долга строго равна 100000), в противном случае - по наличию фрагмента текста в запрашиваемом поле (указано 100 - найдет 100 и 1000 и 10000 и так далее).</p>
        <p>Поиск по "категория-зависимым параметрам" может иметь некоторую погрешность (например: поиск по "ро" не найдет "Россия", необходимо соблюдать регистр - "Ро"), обусловленную особенностями поиска по динамическим полям. </p>
        <hr>
        <p>Поле <code>Сводка</code> позволяет осуществлять фильтрацию по ID, статусу, дате или IP.</p>
        <ul>
            <li>Для фильтрации <b>по статусу</b> - указать статус</li>
            <li>Для фильтрации <b>по ID</b> - указать ID</li>
            <li>Для фильтрации <b>по дате</b> - указать фрагмент даты и знак "-", пример: `01-03` или `-05` и т.д. Формат даты <code>d-m-Y</code> (пример: 01-02-2021 - первое февраля 2021 года). <br><b>Поиск по часам не поддерживается.</b></li>
            <li>Для фильтрации <b>по IP</b> - указать фрагмент IP и знак ".", пример: `192.168.3` или `.23` и т.д.</li>
        </ul>
        <hr>
        <p><b>Способ проверки</b> в параметрах лидов обозначает механизм, с которым будет выполняться проверка данного параметра (если он отмечен, как обязательный) при подборе клиента, которому данный лид будет отправлен.</p>
        <ul>
            <li><code>Не пустой</code> означает, что данный параметр содержит любое значение.</li>
            <li><code>Интервал</code> означает, что данный параметр будет проверяться на вхождение в интервал значений (указывать только для параметров типа "число"), указанных при создании заказа, например - сумма долга в диапазоне от 0 до 100 000 рублей.</li>
            <li><code>Точное соответствие</code> означает, что данный параметр будет проверяться на точное соответствие значению, указанному при создании заказа: например, страна = Республика Беларусь.</li>
        </ul>
        <hr>
        <p>Если навести на край таблицы, то произойдет плавный скролл в указанную сторону, а при клике - мгновенный перенос в конец.</p>
    </div>


</div>
