<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\Orders;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ClientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Клиенты';
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile(Url::to(['/js/jquery-ui.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerCssFile(Url::to(['/css/jquery-ui.min.css']));
$js = <<<JS
$( ".tooltip-block" ).tooltip();
$('.admin-content').on('change', '.select-change-status', function() {
    var 
        val = $(this).val(),
        id = $(this).attr('data-id');
    $.ajax({
        data: {val: val, id: id},
        dataType: "JSON",
        type: "POST",
        url: "/lead-force/clients/change-order-status"
    }).done(function(rsp) {
        if (rsp.status === 'success')
            location.reload();
        else 
            Swal.fire({
                icon: 'error',
                title: 'Ошибка',
                text: rsp.message,
                onClose: function(e) {
                    location.reload();
                }
            });
    });
});
JS;

$this->registerJs($js);
function getSelected($val) {
    $options = '';
    $statuses = Orders::allowedStatuses();
    foreach ($statuses as $item) {
        if($val === $item)
            $sel = 'selected';
        else
            $sel = '';
        $options .= "<option $sel value='{$item}'>$item</option>";
    }
    return $options;
}
header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=clients.xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
?>
<style>
    tbody td{
        border: transparent !important;
    }
    .special-tr-border {
        border-bottom: 1px solid #ddd;
    }
    .select-change-status {
        border: none;
        background-color: transparent;
        outline: none;
    }
</style>
<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'tableOptions' => ['class' => 'table table-bordered', 'border' => 1],
    //'filterModel' => $searchModel,
    'summary' => false,
    'afterRow' => function($model) {
        if (!empty($model->orders)) {
            $html = "<tr class='special-tr-border' style='padding-bottom: 20px;'><td colspan='5' style='padding: 0 20px 20px 20px; '>";
            foreach ($model->orders as $order) {
                if ($order->archive === 1)
                    continue;
                $badLeads = 0;
                if (!empty($order->badLeadsCount))
                    $badLeads = $order->badLeadsCount;
                $percentage = $order->leads_get > 0 && $order->leads_count + $order->leads_waste > 0 ? round(100*$order->leads_waste / ($order->leads_count + $order->leads_waste), 0) : 0;
                $color = $order->colorGetter();
                $html .= "<div style='display: flex; flex-wrap: wrap; padding: 0 5px; background: {$color}; border-left: 2px solid #303030; border-top: 2px solid #303030'>";
                $regions = json_decode($order->regions);
                $region_text = '';
                foreach ($regions as $key => $rText) {
                    if (array_key_last($regions) === $key)
                        $region_text .= "$rText";
                    else
                        $region_text .= "$rText, ";
                }
                if (!empty($order->order_name)) {
                    $html .= "<div style='margin: 5px auto 5px 0; max-width: 150px; width: 100%;'><span title='Настроить заказ' onclick='return window.open(\"". Url::to(['orders/update', 'id' => $order->id]) ."\")' class='tooltip-block glyphicon glyphicon-cog' aria-hidden='true' style='font-size: 12px; cursor: pointer'></span> <span title='Архив' onclick='return window.open(\"". Url::to(['orders/archive', 'id' => $order->id, 'redirect' => 'clients']) ."\", \"_self\")' class='tooltip-block glyphicon glyphicon-remove' aria-hidden='true' style='font-size: 12px; cursor: pointer'></span> <b>#{$order->id} {$order->order_name}</b></div>";
                } else {
                    $html .= "<div style='margin: 5px auto 5px 0; max-width: 150px; width: 100%;'><span title='Настроить заказ' onclick='return window.open(\"". Url::to(['orders/update', 'id' => $order->id]) ."\")' class='tooltip-block glyphicon glyphicon-cog' aria-hidden='true' style='font-size: 12px; cursor: pointer'></span> <span title='Архив' onclick='return window.open(\"". Url::to(['orders/archive', 'id' => $order->id, 'redirect' => 'clients']) ."\", \"_self\")' class='tooltip-block glyphicon glyphicon-remove' aria-hidden='true' style='font-size: 12px; cursor: pointer'></span> <b>#{$order->id} {$order->category_text}</b></div>";
                }
                if (!empty($order->params_special)) {
                    $pp = json_decode($order->params_special, true);
                    if (!empty($pp) && !empty($pp['daily_leads_min'])) {
                        $need = $pp['daily_leads_min'];
                    } else
                        $need = 0;
                    if (!empty($pp) && !empty($pp['lead_per_day_contract'])) {
                        $contract = $pp['lead_per_day_contract'];
                    } else
                        $contract = 0;
                } else {
                    $need = 0;
                    $contract = 0;
                }
                $getDaily = $order->dailyLeads;
                if ($getDaily >= $need)
                    $color_daily = 'green';
                else
                    $color_daily = 'red';
                $html .= "<div style='margin: 5px auto 5px 0; max-width: 150px; width: 100%;'><span title='Получено / Всего : Брак' class='tooltip-block glyphicon glyphicon-user' aria-hidden='true' style='font-size: 12px;'></span> <b> <a target='_blank' href='".Url::to(['/lead-force/leads/index', 'LeadsSearch[type]' => $order->category_link, 'special_filter[qualityOnlyOrder]' => $order->id])."' style='color: green'>{$order->leads_get}</a> / {$order->leads_count} : <a target='_blank' href='".Url::to(['/lead-force/leads/index', 'LeadsSearch[type]' => $order->category_link, 'special_filter[wasteOnlyOrder]' => $order->id])."' style='color: red'>{$order->leads_waste}</a></b><br>Текущий брак: {$percentage}%<br>Сегодня: <span style='color: $color_daily'>{$need} ({$getDaily}/{$contract})</span></div>";
                $html .= "<div style='margin: 5px auto 5px 0; max-width: 150px; width: 100%;'><span title='Регионы' class='tooltip-block glyphicon glyphicon-globe' aria-hidden='true' style='font-size: 12px;'></span> <b>{$region_text}</b></div>";
                $html .= "<div style='margin: 5px auto 5px 0; max-width: 150px; width: 100%;'><span title='Статус заказа' class='tooltip-block glyphicon glyphicon-info-sign' aria-hidden='true' style='font-size: 12px;'></span> <select data-id='{$order->id}' class='select-change-status' data-id=''>".getSelected($order->status)."</select></div>";
                $html .= "</div>";
            }
            $html .= "<hr style=' margin: 0; border-top: 2px solid #303030'>";
            $html .= "</td></tr>";
            return $html;
        }
    },
    'columns' => [
        [
            'attribute' => 'id',
            'format' => 'html',
            'contentOptions' => ['style' => 'width:100px; text-align:left; padding-left: 15px; font-weight:700; font-size:18px;'],
            'value' => function ($model) {
                if (!empty($model->user_id))
                    return "{$model->id} <a target='_blank' href='/users/view?id={$model->user_id}' style='font-size: 14px'><span class='glyphicon glyphicon-user' aria-hidden='true' title='Клиент ЛК'></span></a>";
                else
                    return "{$model->id}";
            }
        ],
        [
            'attribute' => 'client_name',
            'header' => 'Клиент',
            'value' => function ($model) {
                return "{$model->f} {$model->i}";
            }
        ],
        #'o',
        'email:email',
        //'user_id',
        'commentary',
        //'company_info:ntext',
        //'requisites:ntext',
        //'date',
        //'custom_params:ntext',

        [
            'class' => 'yii\grid\ActionColumn',
            'contentOptions' => ['style' => 'width:100px;',],
            'buttons' => [
                'archive' => function ($url, $model, $key) {
                    return Html::a("<span title='Архив' class='glyphicon glyphicon-remove' aria-hidden='true'></span>", Url::to(['archive', 'id' => $model->id]));
                }
            ],
            'template' => "{view} {update} {archive} {delete}"
        ],
    ],
]); ?>
