<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\bootstrap\Alert;

/**
 * @var $this \yii\web\View
 */

$this->title = 'Выгрузка лидов по фильтрам';
$this->params['breadcrumbs'][] = [
    'url' => \yii\helpers\Url::to(['main/index']),
    'label' => 'КЦ'
];
$this->params['breadcrumbs'][] = ['label' => 'Статистика', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
var ordersObj = {};
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
        else {
            location.href = rsp.url;
        }
    }).fail(function (jqXHR, textStatus) {
        Swal.fire({
          icon: 'error',
          title: 'Внимание',
          text: 'Возникла ошибка при генерации xlsx-файла. Возмжно проблема обусловлена слишком большой выборкой.',
        });
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
        <div class="col-md-8" style="margin-bottom: 10px">
            <p><b>Оператор</b></p>
            <div>
                <select class="form-control chosen-select" name="filter[operator]" id="">
                    <option value="">Любой</option>
                    <?php if(!empty($names)): ?>
                        <?php foreach($names as $item): ?>
                            <option value="<?= $item['id'] ?>"><?= $item['inner_name'] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>
    </div>
    <div style="margin-top: 20px; display: flex; ">
        <div style="margin-right: 20px">
            <?= Html::submitButton('Выгрузить', ['class' => 'btn btn-admin']) ?>
        </div>
        <div>
            <div onclick="return location.reload()" class="btn btn-admin-delete">Сбросить фильтр</div>
        </div>
    </div>
    <?= Html::endForm() ?>
</div>
