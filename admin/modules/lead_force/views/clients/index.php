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
var taskCreation = false;
$('.toggle-task').on('click', function () {
    var 
        type = $(this).attr('data-task-type'),
        cid = $(this).attr('data-cid'),
        oid = $(this).attr('data-oid'),
        btn = $(this);
    if (!taskCreation) {
        taskCreation = true;
        $.ajax({
            data: {type: type, cid: cid, oid: oid},
            url: "/lead-force/clients/new-bx-task",
            dataType: "JSON", 
            type: "POST"
        }).done(function (response) {
            if (response.success) {
                taskCreation = false;
                btn.remove();
                Swal.fire({
                    icon: 'success',
                    title: 'Успешно',
                    text: "Задача поставлена",
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Ошибка',
                    text: response.message,
                    onClose: function(e) {
                        location.reload();
                    }
                });
            }
        });
    }
});
$('.open-pops').on('click', function () {
    var 
        data = $(this).data(),
        btn = $(this);
    if (!taskCreation) {
        taskCreation = true;
        Swal.fire({
          title: 'Укажите текст задачи',
          input: 'textarea',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: 'Отправить',
          cancelButtonText: 'Отмена',
          showLoaderOnConfirm: true,
          preConfirm: (text) => {
            return fetch(`/lead-force/clients/new-bx-task?cid=` + data.cid + '&oid=' + data.oid + '&type=' + data.taskType + '&text=' + text, ).then(response => {
                if (!response.ok) {
                  throw new Error(response.statusText)
                }
                return response.json()
              })
              .catch(error => {
                Swal.showValidationMessage(
                  `Request failed: ` + error
                )
              })
          },
          allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            console.log(result);
          if (result.value.success) {
                taskCreation = false;
                btn.remove();
                Swal.fire({
                    icon: 'success',
                    title: 'Успешно',
                    text: "Задача поставлена",
                });
          } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Ошибка',
                    text: result.message,
                    onClose: function(e) {
                        location.reload();
                    }
                });
            }
        })
    }
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
?>
<style>
    tbody td{
        border: transparent !important;
    }
    .special-tr-border {
        border-bottom: 3px solid #000;
    }
    .table-bordered {
        border: 3px solid #000;
    }
    .select-change-status {
        border: none;
        background-color: transparent;
        outline: none;
    }
</style>
<?php #$alias = \common\models\LeadsSentReport::findOne(['lead_id' => 12]); $old = json_decode($alias->log, 1); $old[] = ['date' => date("d.m.Y H:i:s"), 'text' => 'Брак, причина: Регион']; $alias->log = json_encode($old, JSON_UNESCAPED_UNICODE); $alias->update(); ?>
<div class="clients-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <div style="display: flex; flex-wrap: wrap">
        <div style="margin: 0 10px 10px 0">
            <?= Html::a('Добавить клиента', ['create'], ['class' => 'btn btn-admin']) ?>
        </div>
        <div style="margin: 0 10px 10px 0">
            <?= Html::a('Заказы клиентов', Url::to(['orders/index']), ['class' => 'btn btn-admin-help']) ?>
        </div>
        <?php if(Yii::$app->controller->action->id === 'index'): ?>
            <div style="margin: 0 10px 10px 0">
                <?= Html::a('Клиенты без заказов', Url::to(['clients/empty-orders']), ['class' => 'btn btn-admin-help']) ?>
            </div>
        <?php else: ?>
            <div style="margin: 0 10px 10px 0">
                <?= Html::a('Клиенты с заказами', Url::to(['clients/index']), ['class' => 'btn btn-admin-help']) ?>
            </div>
        <?php endif; ?>
        <div style="margin: 0 10px 10px 0">
            <?= Html::a('Архив', Url::to(['archive-list']), ['class' => 'btn btn-admin-delete']) ?>
        </div>
    </div>

    <div style="display: flex; flex-wrap: wrap">
        <div style="margin: 0 10px 10px 0">
            <?= Html::a('Активные заказы', Url::to(['clients/index']), ['class' => 'btn btn-admin-help']) ?>
        </div>
        <div style="margin: 0 10px 10px 0">
            <?= Html::a('Заказы на модерации', Url::to(['clients/index', 'statusFilter' => Orders::STATUS_MODERATION]), ['class' => 'btn btn-admin-help']) ?>
        </div>
        <div style="margin: 0 10px 10px 0">
            <?= Html::a('Заказы на паузе', Url::to(['clients/index', 'statusFilter' => Orders::STATUS_PAUSE]), ['class' => 'btn btn-admin-help']) ?>
        </div>
        <div style="margin: 0 10px 10px 0">
            <?= Html::a('Остановленные заказы', Url::to(['clients/index', 'statusFilter' => Orders::STATUS_STOPPED]), ['class' => 'btn btn-admin-help']) ?>
        </div>
        <div style="margin: 0 10px 10px 0">
            <?= Html::a('Выполненные заказы', Url::to(['clients/index', 'statusFilter' => Orders::STATUS_FINISHED]), ['class' => 'btn btn-admin-help']) ?>
        </div>

    </div>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'tableOptions' => ['class' => 'table table-bordered'],
        'rowOptions' => ['style' => 'border-color: transparent !important;'],
        'filterModel' => $searchModel,
        'afterRow' => function($model) {
            if (!empty($model->orders)) {
                $html = "<tr class='special-tr-border' style='padding-bottom: 20px;'><td colspan='5' style='padding: 0 20px 20px 20px; '>";
                $orValids = 0;
                $status = $_GET['statusFilter'] ?? Orders::STATUS_PROCESSING;
                foreach ($model->orders as $order) {
                    if ($order->archive === 1)
                        continue;
                    if ($order->status !== $status)
                        continue;
                    $orValids++;
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
                    $html .= "<div style='margin: 5px auto 5px 0; max-width: 50px; width: 100%;'><span title='Продать по новой {$model->f} {$model->i} - заказ {$order->order_name}' class='tooltip-block glyphicon glyphicon-repeat toggle-task' data-task-type='repeat' data-cid='{$model->id}' data-oid='{$order->id}' aria-hidden='true' style='font-size: 12px; cursor: pointer'></span>&nbsp;<span title='Срочная задача {$model->f} {$model->i} - заказ {$order->order_name}' class='tooltip-block glyphicon glyphicon-share-alt open-pops' data-task-type='fast' data-cid='{$model->id}' data-oid='{$order->id}' aria-hidden='true' style='font-size: 12px; cursor: pointer'></span></div>";
                    $html .= "</div>";
                }
                $html .= "<hr style=' margin: 0; border-top: 2px solid #303030'>";
                $html .= "</td></tr>";
                if ($orValids > 0)
                    return $html;
                else
                    return "<tr><td colspan='4'><i style='font-size: 11px'>Заказы со статусом <span style='color: rgb(45,66,125)'>\"{$status}\"</span> не найдены</i></td></tr>";
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


</div>
