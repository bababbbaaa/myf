<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\bootstrap\Alert;

/**
 * @var $this \yii\web\View
 */

$this->title = 'Выгрузка лидов по фильтрам';
$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
if (!Yii::$app->getUser()->can('exporter')) {
    $this->params['breadcrumbs'][] = ['label' => 'Таблица лидов', 'url' => ['/lead-force/leads/index']];
}
$this->params['breadcrumbs'][] = $this->title;

$clientArray = [];
if (!empty($clients)) {
    foreach ($clients as $client)
        $clientArray[$client['id']] = "#{$client['id']} {$client['f']} {$client['i']}";
}

$ordersArray = [];
if (!empty($orders)) {
    foreach ($orders as $order)
        $ordersArray[$order['client']][] = ['id' => $order['id'], 'name' => !empty($order['order_name']) ? $order['order_name'] : "#{$order['id']} - {$order['category_text']}", 'category_link' => $order['category_link']];
}

if(!empty($ordersArray))
    $json = json_encode($ordersArray);
else
    $json = '{}';

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
var ordersObj = $json;
$(".chosen-select").chosen({disable_search_threshold: 0});
$('.selectChangeClient').on('input', function() {
    var
        val = $(this).val(),
        html = '<option value="">Без заказа</option>';
    if(val.length > 0) {
        if (ordersObj[val] !== undefined) {
            for (var j = 0; j < ordersObj[val].length; j++) {
                html += '<option data-type="'+ ordersObj[val][j].category_link +'" value="'+ ordersObj[val][j].id +'">'+ ordersObj[val][j].name +'</option>';
            }
        }
    }
    $('.onChangeClient').html(html).trigger('chosen:updated').trigger('input');
});
$('select[name="filter[type]"]').on('input', function() {
    var val = $(this).val();
    $('.param-category').hide();
    $('.param-category[data-category="'+ val +'"]').show();
});
$('.onChangeClient').on('input', function() {
    var 
        option = $('option:selected', this),
        val = option.val(),
        type = option.attr('data-type');
    if (val.length > 0) 
        $('select[name="filter[type]"]')
            .val(type).prop('disabled', true)
            .trigger('chosen:updated')
            .prop('disabled', false)
            .trigger('input');
    else {
        $('select[name="filter[type]"]')
            .val('')
            .prop('disabled', false)
            .trigger('chosen:updated');
        $('.param-category').hide();
    }
});
$('form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        data: $(this).serialize(),
        type: "POST",
        url: $(this).attr('action'),
        beforeSend: function () {
            $('.preloader-ajax-forms').fadeIn(100);
        }
    }).done(function(rsp) {
        $('.preloader-ajax-forms').fadeOut(100);
        if (rsp.status !== 'success')
            location.reload();
        else
            window.open(rsp.url, "_blank");
    });
});
$('.reloadRegionSelect').on('click', function() {
    $('#findRegionSelect').html("<option value disabled selected>Введите город или регион</option>").trigger('chosen:updated');
});
JS;
$this->registerJsFile(Url::to(['/js/getRegionAjax.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);
$responseXls = Yii::$app->session->getFlash('emptyResponse');
?>
<style>
    .chosen-single {
        border-radius: 0 !important;
    }
</style>
<div>
    <?php if(!empty($responseXls)): ?>
    <?php echo Alert::widget([
            'options' => [
                'class' => 'alert-warning',
            ],
            'body' => $responseXls,
        ]); ?>
    <?php endif; ?>
    <h1>Задать параметры выборки</h1>
    <?= Html::beginForm(Url::to(['use-lead-export-filter']), 'POST', ['id' => 'useFormFilter']) ?>
        <div class="row" style="margin-top: 15px;">
            <div class="col-md-4" style="margin-bottom: 10px;">
                <p><b>Начиная с даты</b></p>
                <div>
                    <?php
                    echo DatePicker::widget([
                        'name' => 'filter[dateStart]',
                        'attribute' => 'dateStartFilter',
                        'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => date("Y-m-d", time() - 24*3600)],
                        'value' => '',
                        //'language' => 'ru',
                        'dateFormat' => 'yyyy-MM-dd 00:00:00',
                    ]);?>
                </div>
            </div>
            <div class="col-md-4" style="margin-bottom: 10px;">
                <p><b>Заканчивая датой</b></p>
                <div>
                    <?php
                    echo DatePicker::widget([
                        'name' => 'filter[dateStop]',
                        'attribute' => 'dateStopFilter',
                        'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => date("Y-m-d")],
                        'value' => '',
                        //'language' => 'ru',
                        'dateFormat' => 'yyyy-MM-dd 23:59:59',
                    ]);?>
                </div>
            </div>
        </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-4" style="margin-bottom: 10px">
            <p><b>Связать с клиентом</b></p>
            <div>
                <select name="filter[client]" id="" class="chosen-select form-control selectChangeClient">
                    <option value="">Без клиента</option>
                    <?php foreach($clientArray as $key => $item): ?>
                        <option value="<?= $key ?>"><?= $item ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="col-md-4" style="margin-bottom: 10px">
            <p><b>Связать с заказом</b></p>
            <div>
                <select name="filter[order]" id="" class="chosen-select form-control onChangeClient">
                    <option value="">Без заказа</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-8" style="margin-bottom: 10px">
            <p><b>Статус</b></p>
            <div>
                <select class="form-control chosen-select" name="filter[status]" id="">
                    <option value="">Любой</option>
                    <option value="брак">Брак</option>
                    <option value="отправлен">Отправлен</option>
                    <option value="новый">Новый</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-8" style="margin-bottom: 10px">
            <p><b>Сфера</b></p>
            <div>
                <select class="form-control chosen-select" name="filter[type]" id="">
                    <option value="">Любая</option>
                    <?php if(!empty($categories)): ?>
                    <?php $paramsArray = []; ?>
                        <?php foreach($categories as $item): ?>
                            <?php


                            if(!empty($params)) {
                                foreach ($params as $p)
                                    if($p['category'] === $item['link_name'])
                                        $paramsArray[$item['link_name']][] = $p;
                                }

                            ?>
                            <option value="<?= $item['link_name'] ?>"><?= $item['name'] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 15px;">
        <div class="col-md-8" style="margin-bottom: 10px">
            <p><b>Источник</b></p>
            <div>
                <select class="form-control chosen-select" name="filter[source]" id="">
                    <option value="">Любой</option>
                    <option value="Контакт-центр">Контакт-центр</option>
                    <?php if(!empty($sources)): ?>
                        <?php foreach($sources as $item): ?>
                            <option value="<?= $item['name'] ?>"><?= $item['name'] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="row region-block" style="margin-top: 15px;">
        <div class="col-md-6" style="margin-bottom: 10px">
            <p><b>Регион или город</b></p>
            <div>
                <select name="filter[region]" id="findRegionSelect" type="text" class="chosen-select form-control region-city-ajax-block inputRegionArray" >
                    <option  value="" selected disabled>Введите город или регион</option>
                </select>
            </div>
        </div>
        <div class="col-md-2" style="margin-bottom: 10px">
            <p style="height: 22px;"> </p>
            <div class="btn btn-admin-help reloadRegionSelect">Сбросить</div>
        </div>
    </div>
    <div class="row region-block" style="margin-top: 15px;">
        <div class="col-md-6" style="margin-bottom: 10px">
            <p><b style="vertical-align: top;">Выгрузить только телефоны</b> <input name="filter[onlyPhone]" type="checkbox"></p>
        </div>
    </div>
    <?php if(!empty($paramsArray)): ?>
        <?php foreach($paramsArray as $key => $param): ?>
            <div class="param-category" style="margin-top: 15px; display: none" data-category="<?= $key ?>">
                <?php foreach($param as $item): ?>
                    <div class="row">
                        <div class="col-md-8" style="margin-bottom: 15px;">
                            <p><b><?= $item['description'] ?></b></p>
                            <div>
                                <?php if($item['comparison_type'] === 'interval'): ?>
                                <div style="display: flex; flex-wrap: wrap">
                                    <div style="margin-right: 10px; width: 100%; max-width: 200px">
                                        от <input type="text" placeholder="0" class="form-control" name="filter[special][<?= $item['comparison_type'] ?>][<?= $item['name'] ?>][]">
                                    </div>
                                    <div style="margin-right: 10px; width: 100%; max-width: 200px">
                                        до <input type="text" placeholder="<?= $item['provider_example'] ?>" class="form-control" name="filter[special][<?= $item['comparison_type'] ?>][<?= $item['name'] ?>][]">
                                    </div>
                                </div>
                                <?php else: ?>
                                    <input type="text" class="form-control" placeholder="<?= $item['provider_example'] ?>" name="filter[special][<?= $item['comparison_type'] ?>][<?= $item['name'] ?>]">
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <div style="margin-top: 20px; display: flex; ">
        <div style="margin-right: 20px">
            <?= Html::submitButton('Выгрузить', ['class' => 'btn btn-admin']) ?>
        </div>
        <div>
            <div onclick="return location.reload()" class="btn btn-admin-delete">Сбросить фильтр</div>
        </div>
    </div>
    <?= Html::endForm() ?>

    <h4 style="margin: 40px 0">Справка</h4>
    <div class="row">
        <div class="col-md-12">
            <div class="rbac-info rbac-info-leads" style="max-width: unset">
                <p><code>Выборка по датам</code> - заполнить поля с выбором даты. В случае, если:</p>
                <ul>
                    <li><b>не указана дата начала</b> - выгрузка произойдет за все время до указанной даты</li>
                    <li><b>не указана дата окончания</b> - выгрузка произойдет за все время, начиная с указанной даты, и до сегодняшнего дня</li>
                    <li><b>оба поля пустых</b> - выгрузка произойдет за все время <b style="color: red">(НЕ РЕКОМЕНДУЕТСЯ)</b></li>
                </ul>
                <p><b>Важно:</b> при выгрузке лидов, несвязанных с клиентом (заказом), - выборка по датам происходит по дате поступления лида в СРМ, иначе - по дате отгрузки лида.</p>
                <hr>
                <p><code>Выгрузка по клиенту (или заказу)</code> - связать выгрузку с нужным клиентом (заказом). В случае, если:</p>
                <ul>
                    <li><b>указан клиент, но не указан заказ</b> - выгрузка произойдет по всем заказам клиента</li>
                    <li><b>указан клиент и указан заказ</b> - выгрузка произойдет по конкретному заказу клиента</li>
                    <li><b>не указан заказ и клиент</b> - выгрузка будет выполнена без привязки к конкретному клиенту (заказу)</li>
                </ul>
                <hr>
                <p>Для выбора сферы отгружаемых лидов - использовать поле "сфера". При выборе заказа данное поле заполняется автоматически, в соответствии с заказом.</p>
                <p>От выбранной сферы зависят специальные параметры лидов, характерные для указанной категории (сферы).</p>
                <p>Способ поиска по специальным параметрам зависит от указанного способа сравнения данного параметра:</p>
                <ul>
                    <li><b>Интервальный</b> - значение лежит в диапазоне между двумя числами</li>
                    <li><b>Точное соответствие и проч.</b> - параметр точно соответствует указанному (с учетом регистра)</li>
                </ul>
                <hr>
                <p><code>Поиск по региону (городу)</code> - указать регион (или город) из перечня. Перечень городов появлется через 1000 мс после момента окончания ввода в поле "Регион или город".</p>
                <p>Для сброса значения поля с выбором регионов - использовать кнопку <code>Сбросить</code></p>
                <hr>
                <p>После установки всех нужных фильтров - нажать кнопку <code>Выгрузить</code> для получения XLSX документа с лидами</p>
                <p>Если выборка окажется пустой - на данной странице появится соответсвующее уведомление</p>
                <p>Для сброса всех указанных фильтров использовать кнопку <code>Сбросить фильтр</code></p>
            </div>
        </div>
    </div>
</div>
