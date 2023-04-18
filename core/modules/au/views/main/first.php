<?php

use yii\helpers\Url;
use yii\jui\DatePicker;

$this->title = 'Таблица АУ';
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
$currDate = empty($_GET['filter']['realDate']) ? date("d.m.Y", time()) : $_GET['filter']['realDate'];
$js = <<<JS
$('.main__section').on('change', '.filter-var', function() {
    var 
        inps = $('.filter-var').serialize();
    $.pjax({
        data: inps,
        type: "GET",
        container: "#p0"
    });
});
$('.main__section').on('change', '.client-input-json', function() {
    var 
        inps = $('.client-input-json').serialize(),
        id = $(this).attr('data-id');
    inps += "&id=" + id;
    $.ajax({
        data: inps,
        dataType: "JSON",
        type: "POST",
        url: "/au/main/save-client-json-t"
    }).done(function(rsp) {
        if (rsp.status !== 'success')
            alert(rsp.message);
        else {
            $.pjax.reload({container:"#p0"}); 
        }
    });
});
JS;
$this->registerJs($js);
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
<section class="main__section" style="padding: 20px">
    <h3 style="margin-bottom: 15px">Первое представление / <a href="<?= Url::to(['/au']) ?>">Второе представление</a>
    </h3>
    <?php \yii\widgets\Pjax::begin() ?>
    <?php if (!empty($_SESSION['hide'])): ?>
        <div style="margin-bottom: 20px">
            <div style="display: flex; flex-wrap: wrap; gap: 15px; align-items: center">
                <div><b>Скрытые ключи: </b></div>
                <?php foreach ($_SESSION['hide'] as $key => $item): ?>
                    <div class="remove-session-key" data-key="<?= $key ?>">
                        <?= $descs[$key] ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <table class="table table-bordered client-table">
        <tr>
            <th colspan="10">
                <?php
                echo DatePicker::widget([
                    'name' => 'filter[realDate]',
                    'attribute' => 'filter[realDate]',
                    'options' => ['class' => 'form-control filter-var', 'autocomplete' => 'off', 'placeholder' => date("m.Y")],
                    'value' => $currDate,
                    //'language' => 'ru',
                    'dateFormat' => 'dd.MM.yyyy',
                ]); ?>
            </th>
        </tr>
        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Снято</th>
            <th>Должнику</th>
            <th>КМ</th>
            <th>Статус</th>
            <th>Назначение платежа</th>
            <th>Возмещение</th>
            <th>Партнер</th>
            <th>Получатель</th>
        </tr>
        <tr>
            <th><input type="text" value="<?= $_GET['filter']['id'] ?? '' ?>" placeholder="15"
                       class="form-control filter-var" name="filter[id]"></th>
            <th><input type="text" value="<?= $_GET['filter']['FIO'] ?? '' ?>" placeholder="Иван"
                       class="form-control filter-var" name="filter[FIO]"></th>
            <th><input type="text" value="<?= $_GET['filter']['SumW'] ?? '' ?>" placeholder="15000"
                       class="form-control filter-var" name="filter[SumW]"></th>
            <th><input type="text" value="<?= $_GET['filter']['SumPM'] ?? '' ?>" placeholder="15000"
                       class="form-control filter-var" name="filter[SumPM]"></th>
            <th><input type="text" value="<?= $_GET['filter']['SobKM'] ?? '' ?>" placeholder="15000"
                       class="form-control filter-var" name="filter[SobKM]"></th>
            <th><input type="text" value="<?= $_GET['filter']['month_status'] ?? '' ?>" placeholder="АУ"
                       class="form-control filter-var" name="filter[month_status]"></th>
            <th><input type="text" value="<?= $_GET['filter']['Kom'] ?? '' ?>" placeholder="В работе"
                       class="form-control filter-var" name="filter[Kom]"></th>
            <th><input type="text" value="<?= $_GET['filter']['DutMe'] ?? '' ?>" placeholder="15000"
                       class="form-control filter-var" name="filter[DutMe]"></th>
            <th><input type="text" value="<?= $_GET['filter']['part'] ?? '' ?>" placeholder="Иван"
                       class="form-control filter-var" name="filter[part]"></th>
            <th><input type="text" value="<?= $_GET['filter']['recface'] ?? '' ?>" placeholder="4274"
                       class="form-control filter-var" name="filter[recface]"></th>
        </tr>
        <?php if (!empty($au)): ?>
            <?php
            /**
             * @var \common\models\AuClient $item
             */
            ?>
            <?php foreach ($au as $item): ?>
                <?php $b = false; ?>
                <?php $jsonData = json_decode($item['month'], 1) ?>
                <?php if (!empty($jsonData)): ?>
                    <?php foreach ($jsonData as $jsonId => $k): ?>
                        <?php if ($k['realMonth'] === date("Y-m", strtotime($currDate))): ?>
                            <?php $jsonInfo = $k; $jid = $jsonId;
                            break; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if(!empty($jsonInfo)): ?>
                    <?php foreach($jsonInfo as $k => $v): ?>
                        <?php
                            if (!empty($_GET['filter'][$k]) && mb_stripos($v, $_GET['filter'][$k]) === false) {
                                $b = true;
                                break;
                            }
                        ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if ($b) continue; ?>
                <tr>
                    <td><?= $item['id'] ?></td>
                    <td><?= $item['FIO'] ?></td>
                    <td><?= $jsonInfo['SumW'] ?? 0 ?></td>
                    <td><?= $jsonInfo['SumPM'] ?? 0 ?></td>
                    <td><?= $jsonInfo['SobKM'] ?? 0 ?></td>
                    <td>
                        <select data-id="<?= $item['id'] ?>" class="form-control client-input-json" name="month[<?= $jid ?>][month_status]">
                            <option value="" <?= empty($jsonInfo['month_status']) ? 'selected' : '' ?>>не указан
                            </option>
                            <option <?= $jsonInfo['month_status'] === 'на проверку АУ' ? 'selected' : '' ?>
                                    value="на проверку АУ">на проверку АУ</option>
                            <option <?= $jsonInfo['month_status'] === 'подписан АУ' ? 'selected' : '' ?>
                                    value="подписан АУ">подписан АУ</option>
                            <option <?= $jsonInfo['month_status'] === 'В очереди на исполнение' ? 'selected' : '' ?>
                                    value="В очереди на исполнение">В очереди на исполнение</option>
                            <option <?= $jsonInfo['month_status'] === 'Исполнен (перевели ПМ)' ? 'selected' : '' ?>
                                    value="Исполнен (перевели ПМ)">Исполнен (перевели ПМ)</option>
                        </select>
                    </td>
                    <td><?= $jsonInfo['Kom'] ?? '-' ?></td>
                    <td><?= $jsonInfo['DutMe'] ?? 0 ?></td>
                    <?php if (!empty($item['part'])) $part = json_decode($item['part'], 1); else $part = []; ?>
                    <td>
                        <?php if (!empty($part)): ?>
                            <?php foreach ($part as $k => $v): ?>
                                <p><b><?= $k ?>:</b> <?= $v ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td>
                    <?php if (!empty($item['recface'])) $r = json_decode($item['recface'], 1); else $r = []; ?>
                    <td>
                        <?php if (!empty($r)): ?>
                            <?php foreach ($r as $k => $v): ?>
                                <p><b><?= $k ?>:</b> <?= $v ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td>Записи не найдены. <a href="<?= Url::to(['/au']) ?>">Добавить записи</a></td>
            </tr>
        <?php endif; ?>
    </table>
    <?php \yii\widgets\Pjax::end() ?>
</section>
