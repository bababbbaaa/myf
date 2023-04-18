<?php

use yii\bootstrap\Dropdown;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\LinkPager;

$this->title = "Лиды с бекдора";

$this->params['breadcrumbs'][] = ['label' => 'LEAD.FORCE', 'url' => ['/lead-force/main/index']];
$this->params['breadcrumbs'][] = ['label' => 'Таблица лидов', 'url' => ['/lead-force/leads/index']];
$this->params['breadcrumbs'][] = $this->title;

$cats = \common\models\LeadsCategory::find()->asArray()->select(['name', 'link_name'])->all();
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);
$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 5});
$('table').on('click', '.show-comment', function(e) {
    e.preventDefault();
    var id = $(this).attr('data-id');
    $(this).remove();
    $('.open-block[data-id="'+ id +'"]').show();
});
$('.select-all').on('input', function() {
    $('.select-one').each(function() {
        $(this).prop('checked', !$(this).prop('checked'))
    });
});
$('.close-popup').on('click', function(e) {
    if (e.target.attributes['data-close'] !== undefined)
        $('.popup-select-action').hide();
});
var ids;
var type;
$('.use-action').on('click', function(e) {
    e.preventDefault();
    type = $(this).attr('data-type');
    ids = $('.select-one').serialize();
    $('.change-text').text(type === 'send-to-cc' ? 'Отправить в КЦ' : 'Отправить в таблицу');
    $('.popup-select-action').show();
});
$('.use-action-popup').on('click', function(e) {
    $.ajax({
        data: {data: ids, type: type, typeLead: $('.typeLead').val(), sourceLead: $('.sourceLead').val()},
        dataType: 'JSON',
        type: "POST",
        url: 'use-backdoor-action',
        beforeSend: function(e) {
            $('.preloader-ajax-forms').fadeIn(100);
        }
    }).done(function(rsp) {
        $('.popup-select-action').hide();
         $('.preloader-ajax-forms').fadeOut(100);
        if (rsp.status === 'success')
            location.reload();
        else {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: rsp.message,
            });
        }
    });
});
JS;
$this->registerJs($js);
?>
<style>
    td {
        max-width: 400px;
        overflow: auto;
    }
    .flex-filter {
        display: flex;
        flex-wrap: wrap;
    }
    .flex-filter > div {
        margin-right: 10px;
        margin-bottom: 10px;
    }
    .popup-select-action {
        z-index: 1055;
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.84);
    }
    .popup-select-action > div {
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
    }
    .popup-select-action > div > div {
        cursor: default;
        background-color: white;
        border-radius: 6px;
        padding: 20px;
        max-width: 320px;
        width: 100%;
        position: relative;
    }
    .close-popup-sign {
        position: absolute;
        transform: rotate(45deg);
        top: 0;
        right: 15px;
        font-size: 24px;
        cursor: pointer;
    }
    table {
        white-space: normal;
        word-break: break-word;
    }
    .active-order-backdoor, .active-order-backdoor * {
        background-color: #815151;
        color: white !important;
    }
</style>
<div class="popup-select-action">
    <div class="close-popup" data-close="1">
        <div class="not-close">
            <div class="close-popup-sign close-popup" data-close="1">+</div>
            <div style="margin-bottom: 15px; font-size: 18px"><b class="change-text">Отправить в КЦ</b></div>
            <div style="margin-bottom: 5px"><b>Категория</b></div>
            <div style="margin-bottom: 10px">
                <select name="select-lead-type" id="" class="chosen-select typeLead">
                    <?php if(!empty($cats)): ?>
                        <?php foreach($cats as $item): ?>
                            <option value="<?= $item['link_name'] ?>"><?= $item['name'] ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
            <div style="margin-bottom: 5px"><b>Источник</b></div>
            <div style="margin-bottom: 20px">
                <input type="text" class="form-control sourceLead" name="source" placeholder="Поумолчанию">
            </div>
            <div class="btn btn-admin use-action-popup">Отправить</div>
        </div>
    </div>
</div>
<hr>
<div>
    <h1>Лиды с бекдора</h1>
    <div>
        <h3>Фильтры</h3>
        <?= \yii\helpers\Html::beginForm('backdoor', 'GET', ['name' => 'form__filter']); ?>
        <div class="flex-filter">
            <div>
                <p><b>Источник</b></p>
                <div><input autocomplete="off" type="text" name="filters[source]" value="<?= $_GET['filters']['source'] ?? '' ?>" class="form-control" placeholder="cfs"></div>
            </div>
            <div>
                <p><b>Регион</b></p>
                <div><input autocomplete="off" type="text" name="filters[region]" value="<?= $_GET['filters']['region'] ?? '' ?>" class="form-control" placeholder="Московская"></div>
            </div>
            <div>
                <p><b>Дата</b></p>
                <div style="display: flex;">
                    <div style="margin-right: 10px">
                        <?php echo DatePicker::widget([
                            'name'  => 'filters[start_date]',
                            'value'  => $_GET['filters']['start_date'] ?? '',
                            'language' => 'ru',
                            'dateFormat' => 'dd.MM.yyyy',
                            'options' => ['class' => 'form-control', 'placeholder' => date('d.m.Y', time() - 3600*24*7), 'autocomplete' => 'off']
                        ]); ?>
                    </div>
                    <div>
                        <?php echo DatePicker::widget([
                            'name'  => 'filters[stop_date]',
                            'value'  => $_GET['filters']['stop_date'] ?? '',
                            'language' => 'ru',
                            'dateFormat' => 'dd.MM.yyyy',
                            'options' => ['class' => 'form-control', 'placeholder' => date('d.m.Y', time()), 'autocomplete' => 'off']
                        ]); ?>
                    </div>
                </div>
            </div>
            <div>
                <p><b>Тип лидов</b></p>
                <select name="filters[empty_log]" class="form-control">
                    <option value="" <?= empty($_GET['filters']['empty_log']) ? 'selected' : '' ?>>любые лиды</option>
                    <option value="empty" <?= !empty($_GET['filters']['empty_log']) ? 'selected' : '' ?>>только неотправленные</option>
                </select>
            </div>
            <div>
                <p><b>Показывать на странице</b></p>
                <select name="setPageSize" class="form-control">
                    <option value="100" <?= empty($_GET['setPageSize']) || $_GET['setPageSize'] == 100 ? 'selected' : '' ?>>100</option>
                    <option value="50" <?= !empty($_GET['setPageSize']) && $_GET['setPageSize'] == 50 ? 'selected' : '' ?>>50</option>
                </select>
            </div>
        </div>
        <div class="flex-filter">
            <div>
                <p><b>Исключать источник</b></p>
                <div><input autocomplete="off" type="text" name="filters[source_exclude]" value="<?= $_GET['filters']['source_exclude'] ?? '' ?>" class="form-control" placeholder="cfs"></div>
            </div>
            <div>
                <p><b>Исключать бекдоры активных заказов</b></p>
                <select name="filters[drop_restricted]" class="form-control">
                    <option value="" <?= empty($_GET['filters']['drop_restricted']) ? 'selected' : '' ?>>нет</option>
                    <option value="1" <?= !empty($_GET['filters']['drop_restricted']) ? 'selected' : '' ?>>да</option>
                </select>
            </div>
        </div>
        <button class="btn btn-admin" type="submit">Поиск</button>
        <button class="btn btn-admin-delete" type="button" onclick="return location.href='backdoor'">Сброс</button>
        <?= \yii\helpers\Html::endForm(); ?>
    </div>
    <div style="margin-top: 25px">
        <h4>Операции</h4>
        <div class="flex-filter">
            <div class="dropdown">
                <div data-toggle="dropdown" class="dropdown-toggle btn btn-admin-help">С выбранными <b class="caret"></b></div>
                <?php
                echo Dropdown::widget([
                    'items' => [
                        ['label' => 'Отправить в КЦ', 'url' => '#', 'linkOptions' => ['class' => 'use-action', 'data-type' => 'send-to-cc']],
                        ['label' => 'Отправить в таблицу лидов', 'url' => '#', 'linkOptions' => ['class' => 'use-action', 'data-type' => 'send-to-table']],
                    ],
                ]);
                ?>
            </div>
            <div>
                <a class="btn btn-admin" href="backdoor-active">Активные бекдоры</a>
            </div>
        </div>
    </div>
    <div style="margin-top: 30px">
        <?php if(!empty($models)): ?>
            <p><b>Всего найдено:</b> <?= $count ?></p>
            <table class="table table-bordered table-responsive">
                <tr>
                    <th><input type="checkbox" class="select-all"></th>
                    <th>ID</th>
                    <th>Источник</th>
                    <th>ФИО</th>
                    <th>Телефон</th>
                    <th>Регион</th>
                    <th>Почта</th>
                    <th>Комментарии</th>
                    <th>Дата</th>
                    <th>Лог</th>
                </tr>
                <?php foreach($models as $item): ?>
                <tr class="<?= in_array($item['source'], $rArr) ? 'active-order-backdoor' : '' ?>">
                    <td><input type="checkbox" class="select-one" name="id[]" value="<?= $item['id'] ?>"></td>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['source'] ?></td>
                    <td><?= !empty($item['name']) ? $item['name'] : '-' ?></td>
                    <td><?= $item['phone'] ?></td>
                    <td><?= !empty($item['region']) ? $item['region'] : '-' ?></td>
                    <td><?= !empty($item['email']) ? $item['email'] : '-' ?></td>
                    <td><?= !empty($item['comments']) ? "<a href='#' class='show-comment' data-id='{$item['id']}'>показать</a><div class='open-block' data-id='{$item['id']}' style='display: none'>". strip_tags($item['comments'], '<br>') ."</div>" : '-' ?></td>
                    <td><?= date('d.m.Y H:i:s', strtotime($item['date'])) ?></td>
                    <td><?= !empty($item['log']) ? $item['log'] : '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
        <p style="color: #9e9e9e">Лиды с бекдора не найдены</p>
        <?php endif; ?>
    </div>
</div>

<?php if(!empty($pages)): ?>
<?php echo LinkPager::widget([
        'pagination' => $pages,
    ]); ?>
<?php endif; ?>
