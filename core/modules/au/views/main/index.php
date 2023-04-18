<?php

use yii\helpers\Url;
use yii\jui\DatePicker;

$this->title = 'Таблица АУ';
$js = <<<JS
var timer = null;
var counter = 0;
$('.main__section').on('click', '.add-new', function(e) {
    e.preventDefault();
    $.ajax({
        url: '/au/main/add-new',
        data: {add: true},
        type: "POST",
        dataType: "JSON"
    }).done(function(e) {
        if (e.status === 'success')
            $.pjax.reload({container:"#p0"});
        else
            alert(e.message);
    });
});
$('.main__section').on('change', '.client-input', function() {
    var 
        id = $(this).attr('data-id'),
        val = $(this).val(),
        name = $(this).attr('name');
    if (timer !== null)
        clearTimeout(timer);
    timer = setTimeout(function() {
        $.ajax({
            data: {id: id, val: val, name: name},
            dataType: "JSON",
            type: "POST",
            url: "/au/main/save-client"
        }).done(function(rsp) {
            if (rsp.status !== 'success')
                alert(rsp.message);
            else
                $.pjax.reload({container:"#p0"})
        });
    }, 300);
});
$('.main__section').on('change', '.client-input-json', function() {
    var
        data = $(this).serialize(),
        id = $(this).attr('data-id');
    data += "&id=" + id;
    var idElem = $(this).attr('id');
    timer = setTimeout(function() {
        $.ajax({
            data: data,
            dataType: "JSON",
            type: "POST",
            url: "/au/main/save-client-json"
        }).done(function(rsp) {
            if (rsp.status !== 'success')
                alert(rsp.message);
            else {
                $.pjax.reload({container:"#p0"}).done(function() {
                    location.href = "#" + idElem;
                }); 
            }
        });
    }, 300);
});
var opened = null;
$('.main__section').on('click', '.edit-client-json', function(e) {
    e.preventDefault();
    var
        id = $(this).attr('data-id'),
        json = $(this).attr('data-json');
    $('.put-id[name="id"]').val(id);
    opened = $(this).attr('data-param');
    if (json.length > 0) {
        var obj = JSON.parse(json);
        if (opened !== 'bankall') {
            for (var p in obj) {
                $('.'+ opened +'-input[name="'+ opened +'['+ p +']"]').val(obj[p]);
            }
        } else {
            countBank = 0;
            rs = [];
            var 
                countBanks = obj.length, 
                ob = $('.bank-placer'),
                i = 0;
            ob.html('');
            for (i; i < countBanks; i++) {
                $.ajax({
                    url: "/au/main/get-bank-form",
                    data: {c: countBank++, json: json},
                    type: "POST"
                }).done(function(html) {
                    ob.append(html);
                    var rsLength = obj[i - 1].rs.length;
                    if (obj[i - 1].rs !== undefined && rsLength > 0) {
                        var id0 = i - 1;
                        var ob2 = $('.rs-placer[data-place="' + id0 + '"]');
                        for (var j = 0; j < rsLength; j++) {
                            rs[id0] = rs[id0] === undefined ? 0 : ++rs[id0];
                            $.ajax({
                                url: "/au/main/get-rs",
                                data: {c: rs[id0], bank: id0, json: json},
                                type: "POST"
                            }).done(function(html) {
                                ob2.append(html);
                            });
                        }
                    }
                });
            }
        }
    }
    $('.popup-' + opened).show();
});
$('.close-popup').on('click', function(obj) {
    if (obj.target.classList.value.indexOf('close-popup') !== -1)
        $('.popup-container').hide();
});
$('.saveBtn').on('click', function() {
    var 
        data = $('.' + opened + "-input").serialize(),
        save = $(this).attr('data-save'),
        url = '';
    switch (save) {
        case "part":
            url = "/au/main/save-client-partner";
            break;
        case "recface":
            url = "/au/main/save-client-pm";
            break;
        case "bankall":
            url = "/au/main/save-client-bank";
            break;
    }
    $.ajax({
        data: data,
        dataType: "JSON",
        type: "POST",
        url: url
    }).done(function(rsp) {
        if (rsp.status === 'success') {
            $.pjax.reload({container:"#p0"}).done(function() {
                $('.popup-container').hide();
            }); 
        }
    });
});
var countBank = 0;
$('.addBank').on('click', function() {
    var ob = $('.bank-placer');
    $.ajax({
        url: "/au/main/get-bank-form",
        data: {c: countBank++},
        type: "POST"
    }).done(function(html) {
        ob.append(html);
    });
});
var rs = [];
$('.bank-placer').on('click', '.addRS', function(e) {
    var id = $(this).attr('data-bank');
    rs[id] = rs[id] === undefined ? 0 : ++rs[id];
    var ob = $('.rs-placer[data-place="' + id + '"]');
    $.ajax({
        url: "/au/main/get-rs",
        data: {c: rs[id], bank: id},
        type: "POST"
    }).done(function(html) {
        ob.append(html);
    });
});
$('.main__section').on('click', '.clear-bank', function(e) {
    var id = $(this).attr('data-id');
    e.preventDefault();
    $.ajax({
        data: {id: id},
        url: "/au/main/clear-bank",
        dataType: "JSON",
        type: "POST"
    }).done(function(rsp) {
        if (rsp.status !== 'success')
            alert(rsp.message);
        else {
            $.pjax.reload({container:"#p0"}); 
        }
    });
});
$.pjax.defaults.scrollTo = false;
$('.main__section').on('change', '.filter-var', function() {
    var inps = $('.filter-var').serialize();
    $.pjax({
        data: inps,
        type: "GET",
        container: "#p0"
    });
});
$('.main__section').on('click', '.hide-col', function(e) {
    e.preventDefault();
    var col = $(this).attr('data-col');
    $.ajax({
        data: {col: col},
        type: "POST",
        dataType: "JSON",
        url: "/au/main/hide-col"
    }).done(function(resp) {
        if (resp.status === 'success') {
            $.pjax.reload({container:"#p0"}); 
        } else {
            alert(resp.message);
        }
    });
});
$('.main__section').on('click', '.remove-session-key', function() {
    var 
        k = $(this).attr('data-key');
    $.ajax({
        data: {k: k},
        type: "POST",
        dataType: "JSON",
        url: "/au/main/restore-col"
    }).done(function(resp) {
        if (resp.status === 'success') {
            $.pjax.reload({container:"#p0"}); 
        } else {
            alert(resp.message);
        }
    });
});
JS;
$this->registerJs($js);
$auName = \common\models\UserModel::findOne(Yii::$app->getUser()->getId());
$descs = [
    'id' => 'ID',
    'FIO' => 'ФИО',
    'au_name_text' => 'АУ',
    'Nkad' => 'Номер дела',
    'part' => 'Партнер',
    'RaspCheck' => 'Распоряжение (наличие)',
    'RaspDate' => 'Распорядение отправка',
    'bankall' => 'Банки',
    'recface' => 'Реквизиты для ПМ',
    'PMall' => 'Состав ПМ',
    'BflDate' => 'Дата признания',
    'FinDate' => 'Планируемое завершение',
    'RealDate' => 'Реальная дата завершения',
    'Pmreg' => 'ПМ в регионе',
    'dohod' => 'Доходы',
    'SumGlobal' => 'Снятия (всего)',
    'PMGlobal' => 'Перечисленный ПМ',
    'KMGlobal' => 'КМ общая',
    'DutGlobal' => 'Долг (общий)',
    'CosGlobal' => 'Расходы АУ общие',
    'SaleGlobal' => 'КМ с торгов общие',
    'RemGlobal' => 'Вознаграждение АУ общие',
    'RasGlobal' => 'Распределение КМ общее',
    'pubSUM' => 'Сумма оплаты публикаций',
    'pubDATE' => 'Дата оплаты публикаций',
    'depDATE' => 'Дата перечисления депозита',
    'month' => 'Ежемесячно',
    'DayW' => 'Дата снятия средств',
    'SumW' => 'Сумма снятия',
    'DayPM' => 'Дата выплаты ПМ клиенту',
    'SumPM' => 'Сумма выплаты ПМ',
    'DutPM' => 'Долг из своих клиенту',
    'DutMe' => 'Долг погасили из КМ',
    'CosAY' => 'Расходы АУ по чекам',
    'SaleKM' => 'КМ с торгов',
    'RemAY' => 'Вознаграждение АУ',
    'SobKM' => 'Собрана КМ',
    'RasPM' => 'Распределение КМ',
    'Kom' => 'Комментарий к проводке',
    'month_status' => 'Статус',
];
$arrayColSpan = [
    'DayW',
    'SumW',
    'DayPM',
    'SumPM',
    'DutPM',
    'DutMe',
    'CosAY',
    'SaleKM',
    'RemAY',
    'SobKM',
    'RasPM',
    'Kom',
    'month_status',
];
$colspan = 13;
if (!empty($_SESSION['hide'])) {
    foreach ($_SESSION['hide'] as $key => $item) {
        if (in_array($key, $arrayColSpan))
            --$colspan;
    }
}
?>
<style>
    .client-table * {
        font-size: 10px !important;
    }
    .client-table th {
        white-space: nowrap;
    }

    .client-table th:first-child {
        min-width: 100px;
    }

    ::-webkit-scrollbar {
        width: 10px;
        margin-left: -5px;
    }

    ::-webkit-scrollbar-track {
        background: #f0f0f0;
    }

    ::-webkit-scrollbar-thumb {
        background-color: #b1b9bd;
        border: 1px solid #b1b9bd;
        border-radius: 0 !important;
    }

    .popup-container {
        position: fixed;
        background: rgba(0, 0, 0, 0.81);
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
        display: none;
    }

    .popup-inner-container {
        display: flex;
        width: 100%;
        height: 100%;
        justify-content: center;
        align-items: center;
    }

    .popup-inner-container > div {
        background: whitesmoke;
        padding: 20px;
        max-width: 600px;
        width: 100%;
        position: relative;
    }

    .popup-inner-container div {
        cursor: default;
    }

    .close-popup-mark {
        transform: rotate(45deg);
        position: absolute;
        right: 10px;
        top: 3px;
        font-size: 25px;
        cursor: pointer !important;
    }
    .hidden-col {
        display: none;
    }
    .remove-session-key {
        background-color: #fafafa;
        border: 1px solid gainsboro;
        padding: 7px 15px;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
<div class="popup-part popup-container">
    <div class="popup-inner-container close-popup">
        <div>
            <div class="close-popup-mark close-popup">+</div>
            <div style="text-align: center"><b>Заполнить данные о партнере</b></div>
            <div style="margin-bottom: 10px">
                <p><b>Название</b></p>
                <p><input type="text" class="form-control part-input" name="part[Название]" placeholder="OOO 123"></p>
            </div>
            <div style="margin-bottom: 10px">
                <p><b>Адрес партнера</b></p>
                <p><input type="text" class="form-control part-input" name="part[Адрес]"
                          placeholder="Ростов-на-Дону, ул. Нагибина, д. 43"></p>
            </div>
            <div style="margin-bottom: 10px">
                <p><b>Телефон партнера</b></p>
                <p><input type="text" class="form-control part-input" name="part[Телефон]" placeholder="79188916600">
                </p>
            </div>
            <div style="margin-bottom: 10px">
                <p><b>Почта партнера</b></p>
                <p><input type="text" class="form-control part-input" name="part[Почта]" placeholder="ceo.uk@gmail.com">
                </p>
            </div>
            <div style="margin-bottom: 20px">
                <p><b>Тег партнера</b></p>
                <p><input type="text" class="form-control part-input" name="part[Тег]" placeholder="ooo_tag"></p>
            </div>
            <input type="hidden" class="part-input put-id" name="id" value="">
            <div class="btn btn-success saveBtn" data-save="part" style="cursor: pointer">
                Сохранить
            </div>
        </div>
    </div>
</div>
<div class="popup-recface popup-container">
    <div class="popup-inner-container close-popup">
        <div>
            <div class="close-popup-mark close-popup">+</div>
            <div style="text-align: center"><b>Реквизиты для ПМ</b></div>
            <div style="margin-bottom: 10px">
                <p><b>Расчетный счет третьего лица</b></p>
                <p><input type="text" class="form-control recface-input" name="recface[Расчетный счет]"
                          placeholder="9515285727148"></p>
            </div>
            <div style="margin-bottom: 10px">
                <p><b>Карта третьего лица</b></p>
                <p><input type="text" class="form-control recface-input" name="recface[Карта]"
                          placeholder="4274 7435 2362 3111"></p>
            </div>
            <div style="margin-bottom: 10px">
                <p><b>Банк третьего лица</b></p>
                <p><input type="text" class="form-control recface-input" name="recface[Банк]" placeholder="АО Сбербанк">
                </p>
            </div>
            <div style="margin-bottom: 10px">
                <p><b>БИК третьего лица</b></p>
                <p><input type="text" class="form-control recface-input" name="recface[БИК]" placeholder="044525957">
                </p>
            </div>
            <div style="margin-bottom: 20px">
                <p><b>Корсчет третьего лица </b></p>
                <p><input type="text" class="form-control recface-input" name="recface[Кор.счет]"
                          placeholder="30101643600000000957"></p>
            </div>
            <div style="margin-bottom: 20px">
                <p><b>ФИО третьего лица</b></p>
                <p><input type="text" class="form-control recface-input" name="recface[ФИО]"
                          placeholder="Иванов Виталий Александрович"></p>
            </div>
            <input type="hidden" class="recface-input put-id" name="id" value="">
            <div class="btn btn-success saveBtn" data-save="recface" style="cursor: pointer">
                Сохранить
            </div>
        </div>
    </div>
</div>
<div class="popup-bankall popup-container">
    <div class="popup-inner-container close-popup">
        <div style="max-height: 500px; overflow: auto">
            <div class="close-popup-mark close-popup">+</div>
            <div style="text-align: center"><b>Банки</b></div>
            <div class="btn addBank" data-save="bankall"
                 style="cursor: pointer; margin: 20px 0; background: #2b569a; border-radius: 0; box-shadow: unset">
                Добавить банк +
            </div>
            <div class="bank-placer">

            </div>
            <input type="hidden" class="bankall-input put-id" name="id" value="">
            <div class="btn btn-success saveBtn" data-save="bankall" style="cursor: pointer">
                Сохранить
            </div>
        </div>
    </div>
</div>
<section class="main__section" style="padding: 20px">
    <h3 style="margin-bottom: 15px"><a href="<?= Url::to(['/au/main/first']) ?>">Первое представление</a> / Второе представление</h3>
    <?php \yii\widgets\Pjax::begin() ?>
    <?php if(!empty($_SESSION['hide'])): ?>
        <div style="margin-bottom: 20px">
            <div style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center">
                <div><b>Скрытые ключи: </b></div>
                <?php foreach($_SESSION['hide'] as $key => $item): ?>
                    <div class="remove-session-key" data-key="<?= $key ?>">
                        <?= $descs[$key] ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <table class="table table-bordered table-striped client-table">
        <tr style="background-color: #d9f0ff">
            <th class="<?= !empty($_SESSION['hide']['id']) ? 'hidden-col' : '' ?>" data-col="id">ID <a href="#" class="hide-col" data-col="id" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['FIO']) ? 'hidden-col' : '' ?>" data-col="FIO" style="min-width: 150px">ФИО <a href="#" class="hide-col" data-col="FIO" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['au_name_text']) ? 'hidden-col' : '' ?>" data-col="au_name_text" style="min-width: 150px">АУ <a href="#" class="hide-col" data-col="au_name_text" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['Nkad']) ? 'hidden-col' : '' ?>" data-col="Nkad" style="min-width: 150px">Номер дела <a href="#" class="hide-col" data-col="Nkad" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['part']) ? 'hidden-col' : '' ?>" data-col="part" style="min-width: 300px">Партнер <a href="#" class="hide-col" data-col="part" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['RaspCheck']) ? 'hidden-col' : '' ?>" data-col="RaspCheck">Распоряжение наличие <a href="#" class="hide-col" data-col="RaspCheck" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['RaspDate']) ? 'hidden-col' : '' ?>" data-col="RaspDate">Распоряжение отправка <a href="#" class="hide-col" data-col="RaspDate" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['bankall']) ? 'hidden-col' : '' ?>" data-col="bankall" style="min-width: 300px">Банки <a href="#" class="hide-col" data-col="bankall" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['recface']) ? 'hidden-col' : '' ?>" data-col="recface" style="min-width: 300px">Реквизиты для ПМ <a href="#" class="hide-col" data-col="recface" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['PMall']) ? 'hidden-col' : '' ?>" data-col="PMall">Состав ПМ <a href="#" class="hide-col" data-col="PMall" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['BflDate']) ? 'hidden-col' : '' ?>" data-col="BflDate">Дата признания <a href="#" class="hide-col" data-col="BflDate" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['FinDate']) ? 'hidden-col' : '' ?>" data-col="FinDate">Планируемое завершение <a href="#" class="hide-col" data-col="FinDate" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['RealDate']) ? 'hidden-col' : '' ?>" data-col="RealDate">Реальная дата завершения <a href="#" class="hide-col" data-col="RealDate" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['Pmreg']) ? 'hidden-col' : '' ?>" data-col="Pmreg">ПМ в регионе <a href="#" class="hide-col" data-col="Pmreg" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['dohod']) ? 'hidden-col' : '' ?>" data-col="dohod" style="min-width: 500px">Доходы <a href="#" class="hide-col" data-col="dohod" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['SumGlobal']) ? 'hidden-col' : '' ?>" data-col="SumGlobal">Снятия (всего) <a href="#" class="hide-col" data-col="SumGlobal" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['PMGlobal']) ? 'hidden-col' : '' ?>" data-col="PMGlobal">Перечисленный ПМ <a href="#" class="hide-col" data-col="PMGlobal" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['KMGlobal']) ? 'hidden-col' : '' ?>" data-col="KMGlobal">КМ общая <a href="#" class="hide-col" data-col="KMGlobal" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['DutGlobal']) ? 'hidden-col' : '' ?>" data-col="DutGlobal">Долг (общий) <a href="#" class="hide-col" data-col="DutGlobal" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['CosGlobal']) ? 'hidden-col' : '' ?>" data-col="CosGlobal">Расходы АУ общие <a href="#" class="hide-col" data-col="CosGlobal" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['SaleGlobal']) ? 'hidden-col' : '' ?>" data-col="SaleGlobal">КМ с торгов общие <a href="#" class="hide-col" data-col="SaleGlobal" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['RemGlobal']) ? 'hidden-col' : '' ?>" data-col="RemGlobal">Вознаграждение АУ общие <a href="#" class="hide-col" data-col="RemGlobal" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['RasGlobal']) ? 'hidden-col' : '' ?>" data-col="RasGlobal">Распределение КМ общее <a href="#" class="hide-col" data-col="RasGlobal" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['pubSUM']) ? 'hidden-col' : '' ?>" data-col="pubSUM">Сумма оплаты публикаций <a href="#" class="hide-col" data-col="pubSUM" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['pubDATE']) ? 'hidden-col' : '' ?>" data-col="pubDATE">Дата оплаты публикаций <a href="#" class="hide-col" data-col="pubDATE" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['depDATE']) ? 'hidden-col' : '' ?>" data-col="depDATE">Дата перечисления депозита <a href="#" class="hide-col" data-col="depDATE" style="font-size: 8px">(скрыть)</a></th>
            <th class="<?= !empty($_SESSION['hide']['month']) ? 'hidden-col' : '' ?>" data-col="month" style="min-width: unset">Ежемесячно <a href="#" class="hide-col" data-col="month" style="font-size: 8px">(скрыть)</a></th>
        </tr>
        <tr style="background-color: #d9f0ff">
            <th class="<?= !empty($_SESSION['hide']['id']) ? 'hidden-col' : '' ?>" data-col="id"><input value="<?= $_GET['filter']['id'] ?? '' ?>" type="text" placeholder="15" class="form-control filter-var" name="filter[id]"></th>
            <th class="<?= !empty($_SESSION['hide']['FIO']) ? 'hidden-col' : '' ?>" data-col="FIO"><input value="<?= $_GET['filter']['FIO'] ?? '' ?>" type="text" placeholder="Иван" class="form-control filter-var" name="filter[FIO]"></th>
            <th class="<?= !empty($_SESSION['hide']['au_name_text']) ? 'hidden-col' : '' ?>" data-col="au_name_text"><input value="<?= $_GET['filter']['au_name_text'] ?? '' ?>" type="text" placeholder="Иван" class="form-control filter-var" name="filter[au_name_text]"></th>
            <th class="<?= !empty($_SESSION['hide']['Nkad']) ? 'hidden-col' : '' ?>" data-col="Nkad"><input type="text" value="<?= $_GET['filter']['Nkad'] ?? '' ?>" placeholder="15162" class="form-control filter-var" name="filter[Nkad]"></th>
            <th class="<?= !empty($_SESSION['hide']['part']) ? 'hidden-col' : '' ?>" data-col="part" style="min-width: 300px"><input value="<?= $_GET['filter']['part'] ?? '' ?>" type="text" placeholder="Петров" class="form-control filter-var" name="filter[part]"></th>
            <th class="<?= !empty($_SESSION['hide']['RaspCheck']) ? 'hidden-col' : '' ?>" data-col="RaspCheck">
                <select class="form-control filter-var" name="filter[RaspCheck]" id="">
                    <option <?= $_GET['filter']['RaspCheck'] === '' ? 'selected' : '' ?> value=""></option>
                    <option <?= !empty($_GET['filter']['RaspCheck']) && $_GET['filter']['RaspCheck'] == 1 ? 'selected' : '' ?> value="1">да</option>
                    <option <?= !empty($_GET['filter']['RaspCheck']) && $_GET['filter']['RaspCheck'] == 0 ? 'selected' : '' ?> value="0">нет</option>
                </select>
            </th>
            <th class="<?= !empty($_SESSION['hide']['RaspDate']) ? 'hidden-col' : '' ?>" data-col="RaspDate"><?php
                echo DatePicker::widget([
                    'name' => 'filter[RaspDate]',
                    'attribute' => 'filter[RaspDate]',
                    'options' => ['class' => 'form-control filter-var', 'autocomplete' => 'off', 'placeholder' => date("d.m.Y")],
                    'value' => !empty($_GET['filter']['RaspDate']) ? date("d.m.Y", strtotime($_GET['filter']['RaspDate'])) : '',
                    //'language' => 'ru',
                    'dateFormat' => 'dd.MM.yyyy',
                ]); ?></th>
            <th class="<?= !empty($_SESSION['hide']['bankall']) ? 'hidden-col' : '' ?>" data-col="bankall" style="min-width: 300px"><input type="text" value="<?= $_GET['filter']['bankall'] ?? '' ?>" placeholder="Сбербанк" class="form-control filter-var" name="filter[bankall]"></th>
            <th class="<?= !empty($_SESSION['hide']['recface']) ? 'hidden-col' : '' ?>" data-col="recface" style="min-width: 300px"><input type="text" value="<?= $_GET['filter']['recface'] ?? '' ?>" placeholder="4274" class="form-control filter-var" name="filter[recface]"></th>
            <th class="<?= !empty($_SESSION['hide']['PMall']) ? 'hidden-col' : '' ?>" data-col="PMall"></th>
            <th class="<?= !empty($_SESSION['hide']['BflDate']) ? 'hidden-col' : '' ?>" data-col="BflDate"><?php
                echo DatePicker::widget([
                    'name' => 'filter[BflDate]',
                    'attribute' => 'filter[BflDate]',
                    'options' => ['class' => 'form-control filter-var', 'autocomplete' => 'off', 'placeholder' => date("d.m.Y")],
                    'value' => !empty($_GET['filter']['BflDate']) ? date("d.m.Y", strtotime($_GET['filter']['BflDate'])) : '',
                    //'language' => 'ru',
                    'dateFormat' => 'dd.MM.yyyy',
                ]); ?></th>
            <th class="<?= !empty($_SESSION['hide']['FinDate']) ? 'hidden-col' : '' ?>" data-col="FinDate"><?php
                echo DatePicker::widget([
                    'name' => 'filter[FinDate]',
                    'attribute' => 'filter[FinDate]',
                    'options' => ['class' => 'form-control filter-var', 'autocomplete' => 'off', 'placeholder' => date("d.m.Y")],
                    'value' => !empty($_GET['filter']['FinDate']) ? date("d.m.Y", strtotime($_GET['filter']['FinDate'])) : '',
                    //'language' => 'ru',
                    'dateFormat' => 'dd.MM.yyyy',
                ]); ?></th>
            <th class="<?= !empty($_SESSION['hide']['RealDate']) ? 'hidden-col' : '' ?>" data-col="RealDate"><?php
                echo DatePicker::widget([
                    'name' => 'filter[RealDate]',
                    'attribute' => 'filter[RealDate]',
                    'options' => ['class' => 'form-control filter-var', 'autocomplete' => 'off', 'placeholder' => date("d.m.Y")],
                    'value' => !empty($_GET['filter']['RealDate']) ? date("d.m.Y", strtotime($_GET['filter']['RealDate'])) : '',
                    //'language' => 'ru',
                    'dateFormat' => 'dd.MM.yyyy',
                ]); ?></th>
            <th class="<?= !empty($_SESSION['hide']['Pmreg']) ? 'hidden-col' : '' ?>" data-col="Pmreg"><input type="text" value="<?= $_GET['filter']['Pmreg'] ?? '' ?>" placeholder="15000" class="form-control filter-var" name="filter[Pmreg]"></th>
            <th class="<?= !empty($_SESSION['hide']['dohod']) ? 'hidden-col' : '' ?>" data-col="dohod" style="min-width: 500px"></th>
            <th class="<?= !empty($_SESSION['hide']['SumGlobal']) ? 'hidden-col' : '' ?>" data-col="SumGlobal"><input type="text" value="<?= $_GET['filter']['SumGlobal'] ?? '' ?>" placeholder="15000" class="form-control filter-var" name="filter[SumGlobal]"></th>
            <th class="<?= !empty($_SESSION['hide']['PMGlobal']) ? 'hidden-col' : '' ?>" data-col="PMGlobal"><input type="text" value="<?= $_GET['filter']['PMGlobal'] ?? '' ?>" placeholder="15000" class="form-control filter-var" name="filter[PMGlobal]"></th>
            <th class="<?= !empty($_SESSION['hide']['KMGlobal']) ? 'hidden-col' : '' ?>" data-col="KMGlobal"><input type="text" value="<?= $_GET['filter']['KMGlobal'] ?? '' ?>" placeholder="15000" class="form-control filter-var" name="filter[KMGlobal]"></th>
            <th class="<?= !empty($_SESSION['hide']['DutGlobal']) ? 'hidden-col' : '' ?>" data-col="DutGlobal"><input type="text" value="<?= $_GET['filter']['DutGlobal'] ?? '' ?>" placeholder="15000" class="form-control filter-var" name="filter[DutGlobal]"></th>
            <th class="<?= !empty($_SESSION['hide']['CosGlobal']) ? 'hidden-col' : '' ?>" data-col="CosGlobal"><input type="text" value="<?= $_GET['filter']['CosGlobal'] ?? '' ?>" placeholder="15000" class="form-control filter-var" name="filter[CosGlobal]"></th>
            <th class="<?= !empty($_SESSION['hide']['SaleGlobal']) ? 'hidden-col' : '' ?>" data-col="SaleGlobal"><input type="text" value="<?= $_GET['filter']['SaleGlobal'] ?? '' ?>" placeholder="15000" class="form-control filter-var" name="filter[SaleGlobal]"></th>
            <th class="<?= !empty($_SESSION['hide']['RemGlobal']) ? 'hidden-col' : '' ?>" data-col="RemGlobal"><input type="text" value="<?= $_GET['filter']['RemGlobal'] ?? '' ?>" placeholder="15000" class="form-control filter-var" name="filter[RemGlobal]"></th>
            <th class="<?= !empty($_SESSION['hide']['RasGlobal']) ? 'hidden-col' : '' ?>" data-col="RasGlobal"><input type="text" value="<?= $_GET['filter']['RasGlobal'] ?? '' ?>" placeholder="15000" class="form-control filter-var" name="filter[RasGlobal]"></th>
            <th class="<?= !empty($_SESSION['hide']['pubSUM']) ? 'hidden-col' : '' ?>" data-col="pubSUM"><input type="text" value="<?= $_GET['filter']['pubSUM'] ?? '' ?>" placeholder="15000" class="form-control filter-var" name="filter[pubSUM]"></th>
            <th class="<?= !empty($_SESSION['hide']['pubDATE']) ? 'hidden-col' : '' ?>" data-col="pubDATE"><?php
                echo DatePicker::widget([
                    'name' => 'filter[pubDATE]',
                    'attribute' => 'filter[pubDATE]',
                    'options' => ['class' => 'form-control filter-var', 'autocomplete' => 'off', 'placeholder' => date("d.m.Y")],
                    'value' => !empty($_GET['filter']['pubDATE']) ? date("d.m.Y", strtotime($_GET['filter']['pubDATE'])) : '',
                    //'language' => 'ru',
                    'dateFormat' => 'dd.MM.yyyy',
                ]); ?></th>
            <th class="<?= !empty($_SESSION['hide']['depDATE']) ? 'hidden-col' : '' ?>" data-col="depDATE"><?php
                echo DatePicker::widget([
                    'name' => 'filter[depDATE]',
                    'attribute' => 'filter[depDATE]',
                    'options' => ['class' => 'form-control filter-var', 'autocomplete' => 'off', 'placeholder' => date("d.m.Y")],
                    'value' => !empty($_GET['filter']['depDATE']) ? date("d.m.Y", strtotime($_GET['filter']['depDATE'])) : '',
                    //'language' => 'ru',
                    'dateFormat' => 'dd.MM.yyyy',
                ]); ?></th>
            <th class="<?= !empty($_SESSION['hide']['month']) ? 'hidden-col' : '' ?>" data-col="month" style="min-width: unset"></th>
        </tr>
        <?php if (!empty($au)): ?>
            <?php
            /**
             * @var \common\models\AuClient $item
             */
            ?>
            <?php foreach ($au as $item): ?>
                <tr>
                    <td class="<?= !empty($_SESSION['hide']['id']) ? 'hidden-col' : '' ?>" data-col="id">
                        <?= $item['id'] ?>
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['FIO']) ? 'hidden-col' : '' ?>" data-col="FIO">
                        <input name="FIO" type="text" placeholder="Иванов Иван Иванович"
                               class="form-control client-input" data-id="<?= $item['id'] ?>"
                               value="<?= $item['FIO'] ?>">
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['au_name_text']) ? 'hidden-col' : '' ?>" data-col="au_name_text">
                        <input name="au_name_text" type="text" placeholder="Иванов Иван Иванович"
                               class="form-control client-input" data-id="<?= $item['id'] ?>"
                               value="<?= $item['au_name_text'] ?>">
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['Nkad']) ? 'hidden-col' : '' ?>" data-col="Nkad">
                        <input name="Nkad" type="text" placeholder="A/125...." class="form-control client-input"
                               data-id="<?= $item['id'] ?>" value="<?= $item['Nkad'] ?>">
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['part']) ? 'hidden-col' : '' ?>" data-col="part">
                        <?php if (!empty($item['part'])): ?>
                            <?php $json = json_decode($item['part'], 1); ?>
                            <?php foreach ($json as $k => $v): ?>
                                <p><b><?= $k ?>:</b> <?= $v ?></p>
                            <?php endforeach; ?>
                            <p><a href="#" class="edit-client-json" data-json='<?= $item['part'] ?>' data-param="part"
                                  data-id="<?= $item['id'] ?>">редактировать</a></p>
                        <?php else: ?>
                            <a href="#" class="edit-client-json" data-json="" data-param="part"
                               data-id="<?= $item['id'] ?>">заполнить</a>
                        <?php endif; ?>
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['RaspCheck']) ? 'hidden-col' : '' ?>" data-col="RaspCheck"><input value="<?= $item['RaspCheck'] == 0 ? 1 : 0 ?>"
                               type="checkbox" <?= $item['RaspCheck'] ? 'checked' : '' ?> class="client-input"
                               data-id="<?= $item['id'] ?>" name="RaspCheck"></td>
                    <td class="<?= !empty($_SESSION['hide']['RaspDate']) ? 'hidden-col' : '' ?>" data-col="RaspDate">                    <?php
                        echo DatePicker::widget([
                            'name' => 'RaspDate',
                            'attribute' => 'RaspDate',
                            'options' => ['class' => 'form-control client-input', 'autocomplete' => 'off', 'data-id' => $item['id'], 'placeholder' => date("d.m.Y")],
                            'value' => !empty($item['RaspDate']) ? date("d.m.Y", strtotime($item['RaspDate'])) : '',
                            //'language' => 'ru',
                            'dateFormat' => 'dd.MM.yyyy',
                        ]); ?>
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['bankall']) ? 'hidden-col' : '' ?>" data-col="bankall">
                        <?php if (!empty($item['bankall'])): ?>
                            <?php
                            $banks = json_decode($item['bankall'], 1);
                            ?>
                            <?php foreach ($banks as $z => $x): ?>
                                <?php foreach ($x as $k => $v): ?>
                                    <?php if ($k !== 'rs'): ?>
                                        <p><b><?= $k ?>:</b> <?= $v ?></p>
                                    <?php else: ?>
                                        <?php foreach($v as $oo => $pp): ?>
                                            <ul style="list-style: circle; padding-left: 25px">
                                                <?php foreach($pp as $kk => $vv): ?>
                                                    <li><b><?= $kk ?>:</b> <?= $vv ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                            <p style="display: flex; justify-content: space-between">
                                <a href="#" class="edit-client-json" data-json='<?= $item['bankall'] ?>' data-param="bankall"
                                  data-id="<?= $item['id'] ?>">изменить</a> <a style="color: red" class="clear-bank" data-id="<?= $item['id'] ?>" href="#">очистить</a>
                            </p>
                        <?php else: ?>
                            <a href="#" class="edit-client-json" data-json=''
                               data-param="bankall" data-id="<?= $item['id'] ?>">заполнить</a>
                        <?php endif; ?>
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['recface']) ? 'hidden-col' : '' ?>" data-col="recface">
                        <?php if (!empty($item['recface'])): ?>
                            <?php $json = json_decode($item['recface'], 1); ?>
                            <?php foreach ($json as $k => $v): ?>
                                <p><b><?= $k ?>:</b> <?= $v ?></p>
                            <?php endforeach; ?>
                            <p><a href="#" class="edit-client-json" data-json='<?= $item['recface'] ?>' data-param="recface"
                                  data-id="<?= $item['id'] ?>">заполнить</a></p>
                        <?php else: ?>
                            <a href="#" class="edit-client-json" data-json=''
                               data-param="recface" data-id="<?= $item['id'] ?>">заполнить</a>
                        <?php endif; ?>
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['PMall']) ? 'hidden-col' : '' ?>" data-col="PMall">
                        <div style="display:flex; gap: 10px">
                            <div>
                                <p><b>ПМ по доходу</b></p>
                                <p><input name="PMzp" type="number" class="form-control client-input"
                                          data-id="<?= $item['id'] ?>" value="<?= $item['PMzp'] ?>" min="0"
                                          placeholder="15000"></p>
                            </div>
                            <div>
                                <p><b>ПМ на ребенка</b></p>
                                <p><input name="PMch" type="number" class="form-control client-input"
                                          data-id="<?= $item['id'] ?>" value="<?= $item['PMch'] ?>" min="0"
                                          placeholder="15000"></p>
                            </div>
                        </div>

                        <div style="display:flex; gap: 10px; margin-top: 15px">
                            <div style="width: 150px">
                                <p><b>ПМ соц. выплата</b></p>
                                <p><input name="PMsc" type="number" class="form-control client-input"
                                          data-id="<?= $item['id'] ?>" value="<?= $item['PMsc'] ?>" min="0"
                                          placeholder="15000"></p>
                            </div>
                            <div style="width: 150px">
                                <p><b>ПМ прочий</b></p>
                                <p><input name="PMpr" type="number" class="form-control client-input"
                                          data-id="<?= $item['id'] ?>" value="<?= $item['PMpr'] ?>" min="0"
                                          placeholder="15000"></p>
                            </div>
                        </div>
                        <div style="margin-top: 15px;">
                            <p><b>ПМ общий</b></p>
                            <p><input name="PMall" type="number" class="form-control client-input"
                                      data-id="<?= $item['id'] ?>" value="<?= $item['PMall'] ?>" min="0"
                                      placeholder="15000"></p>
                        </div>
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['BflDate']) ? 'hidden-col' : '' ?>" data-col="BflDate"><?php
                        echo DatePicker::widget([
                            'name' => 'BflDate',
                            'attribute' => 'BflDate',
                            'options' => ['class' => 'form-control client-input', 'autocomplete' => 'off', 'data-id' => $item['id'], 'placeholder' => date("d.m.Y")],
                            'value' => !empty($item['BflDate']) ? date("d.m.Y", strtotime($item['BflDate'])) : '',
                            //'language' => 'ru',
                            'dateFormat' => 'dd.MM.yyyy',
                        ]); ?>
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['FinDate']) ? 'hidden-col' : '' ?>" data-col="FinDate"><?php
                        echo DatePicker::widget([
                            'name' => 'FinDate',
                            'attribute' => 'FinDate',
                            'options' => ['class' => 'form-control client-input', 'autocomplete' => 'off', 'data-id' => $item['id'], 'placeholder' => date("d.m.Y")],
                            'value' => !empty($item['FinDate']) ? date("d.m.Y", strtotime($item['FinDate'])) : '',
                            //'language' => 'ru',
                            'dateFormat' => 'dd.MM.yyyy',
                        ]); ?>
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['RealDate']) ? 'hidden-col' : '' ?>" data-col="RealDate"><?php
                        echo DatePicker::widget([
                            'name' => 'RealDate',
                            'attribute' => 'RealDate',
                            'options' => ['class' => 'form-control client-input', 'autocomplete' => 'off', 'data-id' => $item['id'], 'placeholder' => date("d.m.Y")],
                            'value' => !empty($item['RealDate']) ? date("d.m.Y", strtotime($item['RealDate'])) : '',
                            //'language' => 'ru',
                            'dateFormat' => 'dd.MM.yyyy',
                        ]); ?>
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['Pmreg']) ? 'hidden-col' : '' ?>" data-col="Pmreg">
                        <input name="Pmreg" type="number" class="form-control client-input" data-id="<?= $item['id'] ?>"
                               value="<?= $item['Pmreg'] ?>" min="0" placeholder="15000">
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['dohod']) ? 'hidden-col' : '' ?>" data-col="dohod" style="width: 400px;">
                        <div style="display:flex; gap: 10px; margin-bottom: 10px">
                            <div>
                                <p><b>Дата (ЗП)</b></p>
                                <p>
                                    <?php
                                    echo DatePicker::widget([
                                        'name' => 'ZPDateD',
                                        'attribute' => 'ZPDateD',
                                        'options' => ['class' => 'form-control client-input', 'autocomplete' => 'off', 'data-id' => $item['id'], 'placeholder' => date("d.m.Y")],
                                        'value' => !empty($item['ZPDateD']) ? date("d.m.Y", strtotime($item['ZPDateD'])) : '',
                                        //'language' => 'ru',
                                        'dateFormat' => 'dd.MM.yyyy',
                                    ]); ?>
                                </p>
                            </div>
                            <div>
                                <p><b>ЗП (размер)</b></p>
                                <p><input name="ZPSUM" type="number" class="form-control client-input"
                                          data-id="<?= $item['id'] ?>" value="<?= $item['ZPSUM'] ?>" min="0"
                                          placeholder="15000"></p>
                            </div>
                            <div>
                                <p><b>Формат снятия</b></p>
                                <p>
                                    <select data-id="<?= $item['id'] ?>" class="form-control client-input" name="ZPMet">
                                        <option value="" <?= empty($item['ZPMet']) ? 'selected' : '' ?>>выбрать...
                                        </option>
                                        <option <?= $item['ZPMet'] === 'мы снимаем' ? 'selected' : '' ?>
                                                value="мы снимаем">мы снимаем
                                        </option>
                                        <option <?= $item['ZPMet'] === 'снимает партнер' ? 'selected' : '' ?>
                                                value="снимает партнер">снимает партнер
                                        </option>
                                        <option <?= $item['ZPMet'] === 'снимает клиент' ? 'selected' : '' ?>
                                                value="снимает клиент">снимает клиент
                                        </option>
                                    </select>
                                </p>
                            </div>
                        </div>
                        <div style="display:flex; gap: 10px; margin-bottom: 10px">
                            <div>
                                <p><b>Дата (пенсия)</b></p>
                                <p>
                                    <?php
                                    echo DatePicker::widget([
                                        'name' => 'PNDateD',
                                        'attribute' => 'PNDateD',
                                        'options' => ['class' => 'form-control client-input', 'autocomplete' => 'off', 'data-id' => $item['id'], 'placeholder' => date("d.m.Y")],
                                        'value' => !empty($item['PNDateD']) ? date("d.m.Y", strtotime($item['PNDateD'])) : '',
                                        //'language' => 'ru',
                                        'dateFormat' => 'dd.MM.yyyy',
                                    ]); ?>
                                </p>
                            </div>
                            <div>
                                <p><b>Пенсия (размер)</b></p>
                                <p><input name="PNSUM" type="number" class="form-control client-input"
                                          data-id="<?= $item['id'] ?>" value="<?= $item['PNSUM'] ?>" min="0"
                                          placeholder="15000"></p>
                            </div>
                            <div>
                                <p><b>Формат снятия</b></p>
                                <p>
                                    <select data-id="<?= $item['id'] ?>" class="form-control client-input" name="PNMet">
                                        <option value="" <?= empty($item['PNMet']) ? 'selected' : '' ?>>выбрать...
                                        </option>
                                        <option <?= $item['PNMet'] === 'мы снимаем' ? 'selected' : '' ?>
                                                value="мы снимаем">мы снимаем
                                        </option>
                                        <option <?= $item['PNMet'] === 'снимает партнер' ? 'selected' : '' ?>
                                                value="снимает партнер">снимает партнер
                                        </option>
                                        <option <?= $item['PNMet'] === 'снимает клиент' ? 'selected' : '' ?>
                                                value="снимает клиент">снимает клиент
                                        </option>
                                    </select>
                                </p>
                            </div>
                        </div>
                        <div style="display:flex; gap: 10px; margin-bottom: 10px">
                            <div>
                                <p><b>Дата (соц. пос.)</b></p>
                                <p>
                                    <?php
                                    echo DatePicker::widget([
                                        'name' => 'SCDateD',
                                        'attribute' => 'SCDateD',
                                        'options' => ['class' => 'form-control client-input', 'autocomplete' => 'off', 'data-id' => $item['id'], 'placeholder' => date("d.m.Y")],
                                        'value' => !empty($item['SCDateD']) ? date("d.m.Y", strtotime($item['SCDateD'])) : '',
                                        //'language' => 'ru',
                                        'dateFormat' => 'dd.MM.yyyy',
                                    ]); ?>
                                </p>
                            </div>
                            <div>
                                <p><b>Соц. пос. (размер)</b></p>
                                <p><input name="SCSUM" type="number" class="form-control client-input"
                                          data-id="<?= $item['id'] ?>" value="<?= $item['SCSUM'] ?>" min="0"
                                          placeholder="15000"></p>
                            </div>
                            <div>
                                <p><b>Формат снятия</b></p>
                                <p>
                                    <select data-id="<?= $item['id'] ?>" class="form-control client-input" name="SCMet">
                                        <option value="" <?= empty($item['SCMet']) ? 'selected' : '' ?>>выбрать...
                                        </option>
                                        <option <?= $item['SCMet'] === 'мы снимаем' ? 'selected' : '' ?>
                                                value="мы снимаем">мы снимаем
                                        </option>
                                        <option <?= $item['SCMet'] === 'снимает партнер' ? 'selected' : '' ?>
                                                value="снимает партнер">снимает партнер
                                        </option>
                                        <option <?= $item['SCMet'] === 'снимает клиент' ? 'selected' : '' ?>
                                                value="снимает клиент">снимает клиент
                                        </option>
                                    </select>
                                </p>
                            </div>
                        </div>
                        <div style="display:flex; gap: 10px; margin-bottom: 10px">
                            <div>
                                <p><b>Дата (проч.)</b></p>
                                <p>
                                    <?php
                                    echo DatePicker::widget([
                                        'name' => 'PRDateD',
                                        'attribute' => 'PRDateD',
                                        'options' => ['class' => 'form-control client-input', 'autocomplete' => 'off', 'data-id' => $item['id'], 'placeholder' => date("d.m.Y")],
                                        'value' => !empty($item['PRDateD']) ? date("d.m.Y", strtotime($item['PRDateD'])) : '',
                                        //'language' => 'ru',
                                        'dateFormat' => 'dd.MM.yyyy',
                                    ]); ?>
                                </p>
                            </div>
                            <div>
                                <p><b>Проч. (размер)</b></p>
                                <p><input name="PRSUM" type="number" class="form-control client-input"
                                          data-id="<?= $item['id'] ?>" value="<?= $item['PRSUM'] ?>" min="0"
                                          placeholder="15000"></p>
                            </div>
                            <div>
                                <p><b>Формат снятия</b></p>
                                <p>
                                    <select data-id="<?= $item['id'] ?>" class="form-control client-input" name="PRMet">
                                        <option value="" <?= empty($item['PRMet']) ? 'selected' : '' ?>>выбрать...
                                        </option>
                                        <option <?= $item['PRMet'] === 'мы снимаем' ? 'selected' : '' ?>
                                                value="мы снимаем">мы снимаем
                                        </option>
                                        <option <?= $item['PRMet'] === 'снимает партнер' ? 'selected' : '' ?>
                                                value="снимает партнер">снимает партнер
                                        </option>
                                        <option <?= $item['PRMet'] === 'снимает клиент' ? 'selected' : '' ?>
                                                value="снимает клиент">снимает клиент
                                        </option>
                                    </select>
                                </p>
                            </div>
                        </div>
                        <div>
                            <p><b>Общий доход (размер)</b></p>
                            <p><input name="DHALL" type="number" class="form-control client-input"
                                      data-id="<?= $item['id'] ?>" value="<?= $item['DHALL'] ?>" min="0"
                                      placeholder="15000"></p>
                        </div>
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['SumGlobal']) ? 'hidden-col' : '' ?>" data-col="SumGlobal"><input readonly name="SumGlobal" type="number" class="form-control client-input"
                               data-id="<?= $item['id'] ?>" value="<?= $item['SumGlobal'] ?>" min="0"
                               placeholder="15000"></td>
                    <td class="<?= !empty($_SESSION['hide']['PMGlobal']) ? 'hidden-col' : '' ?>" data-col="PMGlobal"><input readonly name="PMGlobal" type="number" class="form-control client-input"
                               data-id="<?= $item['id'] ?>" value="<?= $item['PMGlobal'] ?>" min="0"
                               placeholder="15000"></td>
                    <td class="<?= !empty($_SESSION['hide']['KMGlobal']) ? 'hidden-col' : '' ?>" data-col="KMGlobal"><input readonly name="KMGlobal" type="number" class="form-control client-input"
                               data-id="<?= $item['id'] ?>" value="<?= $item['KMGlobal'] ?>" min="0"
                               placeholder="15000"></td>
                    <td class="<?= !empty($_SESSION['hide']['DutGlobal']) ? 'hidden-col' : '' ?>" data-col="DutGlobal"><input readonly name="DutGlobal" type="number" class="form-control client-input"
                               data-id="<?= $item['id'] ?>" value="<?= $item['DutGlobal'] ?>" min="0"
                               placeholder="15000"></td>
                    <td class="<?= !empty($_SESSION['hide']['CosGlobal']) ? 'hidden-col' : '' ?>" data-col="CosGlobal"><input readonly name="CosGlobal" type="number" class="form-control client-input"
                               data-id="<?= $item['id'] ?>" value="<?= $item['CosGlobal'] ?>" min="0"
                               placeholder="15000"></td>
                    <td class="<?= !empty($_SESSION['hide']['SaleGlobal']) ? 'hidden-col' : '' ?>" data-col="SaleGlobal"><input readonly name="SaleGlobal" type="number" class="form-control client-input"
                               data-id="<?= $item['id'] ?>" value="<?= $item['SaleGlobal'] ?>" min="0"
                               placeholder="15000"></td>
                    <td class="<?= !empty($_SESSION['hide']['RemGlobal']) ? 'hidden-col' : '' ?>" data-col="RemGlobal"><input readonly name="RemGlobal" type="number" class="form-control client-input"
                               data-id="<?= $item['id'] ?>" value="<?= $item['RemGlobal'] ?>" min="0"
                               placeholder="15000"></td>
                    <td class="<?= !empty($_SESSION['hide']['RasGlobal']) ? 'hidden-col' : '' ?>" data-col="RasGlobal"><input readonly name="RasGlobal" type="number" class="form-control client-input"
                               data-id="<?= $item['id'] ?>" value="<?= $item['RasGlobal'] ?>" min="0"
                               placeholder="15000"></td>
                    <td class="<?= !empty($_SESSION['hide']['pubSUM']) ? 'hidden-col' : '' ?>" data-col="pubSUM"><input name="pubSUM" type="number" class="form-control client-input"
                               data-id="<?= $item['id'] ?>" value="<?= $item['pubSUM'] ?>" min="0" placeholder="15000">
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['pubDATE']) ? 'hidden-col' : '' ?>" data-col="pubDATE"><?php
                        echo DatePicker::widget([
                            'name' => 'pubDATE',
                            'attribute' => 'pubDATE',
                            'options' => ['class' => 'form-control client-input', 'autocomplete' => 'off', 'data-id' => $item['id'], 'placeholder' => date("d.m.Y")],
                            'value' => !empty($item['pubDATE']) ? date("d.m.Y", strtotime($item['pubDATE'])) : '',
                            //'language' => 'ru',
                            'dateFormat' => 'dd.MM.yyyy',
                        ]); ?>
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['depDATE']) ? 'hidden-col' : '' ?>" data-col="depDATE"><?php
                        echo DatePicker::widget([
                            'name' => 'depDATE',
                            'attribute' => 'depDATE',
                            'options' => ['class' => 'form-control client-input', 'autocomplete' => 'off', 'data-id' => $item['id'], 'placeholder' => date("d.m.Y")],
                            'value' => !empty($item['depDATE']) ? date("d.m.Y", strtotime($item['depDATE'])) : '',
                            //'language' => 'ru',
                            'dateFormat' => 'dd.MM.yyyy',
                        ]); ?>
                    </td>
                    <td class="<?= !empty($_SESSION['hide']['month']) ? 'hidden-col' : '' ?>" data-col="month" style="max-width: 1000px; overflow: auto">
                        <?php if (!empty($item['month'])): ?>
                            <table class="table table-bordered">
                                <tr>
                                    <?php $json = json_decode($item['month'], 1); ?>
                                    <?php foreach ($json as $k => $v): ?>
                                        <td colspan="<?= $colspan ?>"><b><?= date("m.Y", strtotime($v['realMonth'])) ?></b></td>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <?php foreach ($json as $k => $v): ?>
                                        <th class="<?= !empty($_SESSION['hide']['DayW']) ? 'hidden-col' : '' ?>">Дата снятия средств <a href="#" class="hide-col" data-col="DayW" style="font-size: 8px">(скрыть)</a></th>
                                        <th class="<?= !empty($_SESSION['hide']['SumW']) ? 'hidden-col' : '' ?>">Сумма снятия <a href="#" class="hide-col" data-col="SumW" style="font-size: 8px">(скрыть)</a></th>
                                        <th class="<?= !empty($_SESSION['hide']['DayPM']) ? 'hidden-col' : '' ?>">Дата выплаты ПМ клиенту <a href="#" class="hide-col" data-col="DayPM" style="font-size: 8px">(скрыть)</a></th>
                                        <th class="<?= !empty($_SESSION['hide']['SumPM']) ? 'hidden-col' : '' ?>">Сумма выплаты ПМ <a href="#" class="hide-col" data-col="SumPM" style="font-size: 8px">(скрыть)</a></th>
                                        <th class="<?= !empty($_SESSION['hide']['DutPM']) ? 'hidden-col' : '' ?>">Долг из своих клиенту <a href="#" class="hide-col" data-col="DutPM" style="font-size: 8px">(скрыть)</a></th>
                                        <th class="<?= !empty($_SESSION['hide']['DutMe']) ? 'hidden-col' : '' ?>">Долг погасили из КМ <a href="#" class="hide-col" data-col="DutMe" style="font-size: 8px">(скрыть)</a></th>
                                        <th class="<?= !empty($_SESSION['hide']['CosAY']) ? 'hidden-col' : '' ?>">Расходы АУ по чекам <a href="#" class="hide-col" data-col="CosAY" style="font-size: 8px">(скрыть)</a></th>
                                        <th class="<?= !empty($_SESSION['hide']['SaleKM']) ? 'hidden-col' : '' ?>">КМ с торгов <a href="#" class="hide-col" data-col="SaleKM" style="font-size: 8px">(скрыть)</a></th>
                                        <th class="<?= !empty($_SESSION['hide']['RemAY']) ? 'hidden-col' : '' ?>">Вознаграждение АУ <a href="#" class="hide-col" data-col="RemAY" style="font-size: 8px">(скрыть)</a></th>
                                        <th class="<?= !empty($_SESSION['hide']['SobKM']) ? 'hidden-col' : '' ?>">Собрана КМ <a href="#" class="hide-col" data-col="SobKM" style="font-size: 8px">(скрыть)</a></th>
                                        <th class="<?= !empty($_SESSION['hide']['RasPM']) ? 'hidden-col' : '' ?>">Распределение КМ <a href="#" class="hide-col" data-col="RasPM" style="font-size: 8px">(скрыть)</a></th>
                                        <th class="<?= !empty($_SESSION['hide']['Kom']) ? 'hidden-col' : '' ?>">Комментарий к проводке <a href="#" class="hide-col" data-col="Kom" style="font-size: 8px">(скрыть)</a></th>
                                        <th class="<?= !empty($_SESSION['hide']['month_status']) ? 'hidden-col' : '' ?>" style="min-width: 150px">Статус <a href="#" class="hide-col" data-col="month_status" style="font-size: 8px">(скрыть)</a></th>
                                    <?php endforeach; ?>
                                </tr>
                                <tr>
                                    <?php foreach ($json as $k => $v): ?>
                                        <td class="<?= !empty($_SESSION['hide']['DayW']) ? 'hidden-col' : '' ?>"><?php
                                            echo DatePicker::widget([
                                                'name' => 'month[' . $k . '][DayW]',
                                                'attribute' => 'month[' . $k . '][DayW]',
                                                'options' => ['class' => 'form-control client-input-json', 'autocomplete' => 'off', 'id' => "buf_{$item['id']}_{$k}_DayW", 'data-id' => $item['id'], 'placeholder' => date("d.m.Y")],
                                                'value' => !empty($v['DayW']) ? date("d.m.Y", strtotime($v['DayW'])) : '',
                                                //'language' => 'ru',
                                                'dateFormat' => 'dd.MM.yyyy',
                                            ]); ?>
                                        </td>
                                        <td class="<?= !empty($_SESSION['hide']['SumW']) ? 'hidden-col' : '' ?>"><input name="month[<?= $k ?>][SumW]" type="number"
                                                   id="buf_<?= $item['id'] ?>_<?= $k ?>_SumW"
                                                   class="form-control client-input-json" data-id="<?= $item['id'] ?>"
                                                   value="<?= $v['SumW'] ?>" min="0" placeholder="15000"></td>
                                        <td class="<?= !empty($_SESSION['hide']['DayPM']) ? 'hidden-col' : '' ?>"><?php
                                            echo DatePicker::widget([
                                                'name' => 'month[' . $k . '][DayPM]',
                                                'attribute' => 'month[' . $k . '][DayPM]',
                                                'options' => ['class' => 'form-control client-input-json', 'autocomplete' => 'off', 'id' => "buf_{$item['id']}_{$k}_DayPM", 'data-id' => $item['id'], 'placeholder' => date("d.m.Y")],
                                                'value' => !empty($v['DayPM']) ? date("d.m.Y", strtotime($v['DayPM'])) : '',
                                                //'language' => 'ru',
                                                'dateFormat' => 'dd.MM.yyyy',
                                            ]); ?>
                                        </td>
                                        <td class="<?= !empty($_SESSION['hide']['SumPM']) ? 'hidden-col' : '' ?>"><input name="month[<?= $k ?>][SumPM]"
                                                   id="buf_<?= $item['id'] ?>_<?= $k ?>_SumPM" type="number"
                                                   class="form-control client-input-json" data-id="<?= $item['id'] ?>"
                                                   value="<?= $v['SumPM'] ?>" min="0" placeholder="15000"></td>
                                        <td class="<?= !empty($_SESSION['hide']['DutPM']) ? 'hidden-col' : '' ?>"><input name="month[<?= $k ?>][DutPM]"
                                                   id="buf_<?= $item['id'] ?>_<?= $k ?>_DutPM" type="number"
                                                   class="form-control client-input-json" data-id="<?= $item['id'] ?>"
                                                   value="<?= $v['DutPM'] ?>" min="0" placeholder="15000"></td>
                                        <td class="<?= !empty($_SESSION['hide']['DutMe']) ? 'hidden-col' : '' ?>"><input name="month[<?= $k ?>][DutMe]"
                                                   id="buf_<?= $item['id'] ?>_<?= $k ?>_DutMe" type="number"
                                                   class="form-control client-input-json" data-id="<?= $item['id'] ?>"
                                                   value="<?= $v['DutMe'] ?>" min="0" placeholder="15000"></td>
                                        <td class="<?= !empty($_SESSION['hide']['CosAY']) ? 'hidden-col' : '' ?>"><input name="month[<?= $k ?>][CosAY]"
                                                   id="buf_<?= $item['id'] ?>_<?= $k ?>_CosAY" type="number"
                                                   class="form-control client-input-json" data-id="<?= $item['id'] ?>"
                                                   value="<?= $v['CosAY'] ?>" min="0" placeholder="15000"></td>
                                        <td class="<?= !empty($_SESSION['hide']['SaleKM']) ? 'hidden-col' : '' ?>"><input name="month[<?= $k ?>][SaleKM]"
                                                   id="buf_<?= $item['id'] ?>_<?= $k ?>_SaleKM" type="number"
                                                   class="form-control client-input-json" data-id="<?= $item['id'] ?>"
                                                   value="<?= $v['SaleKM'] ?>" min="0" placeholder="15000"></td>
                                        <td class="<?= !empty($_SESSION['hide']['RemAY']) ? 'hidden-col' : '' ?>"><input name="month[<?= $k ?>][RemAY]"
                                                   id="buf_<?= $item['id'] ?>_<?= $k ?>_RemAY" type="number"
                                                   class="form-control client-input-json" data-id="<?= $item['id'] ?>"
                                                   value="<?= $v['RemAY'] ?>" min="0" placeholder="15000"></td>
                                        <td class="<?= !empty($_SESSION['hide']['SobKM']) ? 'hidden-col' : '' ?>"><input name="month[<?= $k ?>][SobKM]"
                                                   id="buf_<?= $item['id'] ?>_<?= $k ?>_SobKM" type="number"
                                                   class="form-control client-input-json" data-id="<?= $item['id'] ?>"
                                                   value="<?= $v['SobKM'] ?>" min="0" placeholder="15000"></td>
                                        <td class="<?= !empty($_SESSION['hide']['RasPM']) ? 'hidden-col' : '' ?>"><input name="month[<?= $k ?>][RasPM]"
                                                   id="buf_<?= $item['id'] ?>_<?= $k ?>_RasPM" type="number"
                                                   class="form-control client-input-json" data-id="<?= $item['id'] ?>"
                                                   value="<?= $v['RasPM'] ?>" min="0" placeholder="15000"></td>
                                        <td class="<?= !empty($_SESSION['hide']['Kom']) ? 'hidden-col' : '' ?>"><input name="month[<?= $k ?>][Kom]"
                                                   id="buf_<?= $item['id'] ?>_<?= $k ?>_Kom" type="text"
                                                   class="form-control client-input-json" data-id="<?= $item['id'] ?>"
                                                   value="<?= $v['Kom'] ?>" placeholder="Комментарий"></td>
                                        <td class="<?= !empty($_SESSION['hide']['month_status']) ? 'hidden-col' : '' ?>">
                                            <select id="buf_<?= $item['id'] ?>_<?= $k ?>_month_status" data-id="<?= $item['id'] ?>" class="form-control client-input-json" name="month[<?= $k ?>][month_status]">
                                                <option value="" <?= empty($v['month_status']) ? 'selected' : '' ?>>не указан
                                                </option>
                                                <option <?= $v['month_status'] === 'на проверку АУ' ? 'selected' : '' ?>
                                                        value="на проверку АУ">на проверку АУ</option>
                                                <option <?= $v['month_status'] === 'подписан АУ' ? 'selected' : '' ?>
                                                        value="подписан АУ">подписан АУ</option>
                                                <option <?= $v['month_status'] === 'В очереди на исполнение' ? 'selected' : '' ?>
                                                        value="В очереди на исполнение">В очереди на исполнение</option>
                                                <option <?= $v['month_status'] === 'Исполнен (перевели ПМ)' ? 'selected' : '' ?>
                                                        value="Исполнен (перевели ПМ)">Исполнен (перевели ПМ)</option>
                                            </select>
                                        </td>
                                    <?php endforeach; ?>
                                </tr>
                            </table>
                        <?php else: ?>
                            <span style="font-style: italic">Сначала необходимо указать "Дата признания" и "Планируемое завершение" (или "Реальная дата завершения")</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="29"><a href="#" class="add-new">Добавить клиента...</a></td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="29">Таблица пуста</td>
            </tr>
            <tr>
                <td colspan="29"><a href="#" class="add-new">Добавить клиента...</a></td>
            </tr>
        <?php endif; ?>
    </table>
    <?php \yii\widgets\Pjax::end() ?>
</section>


