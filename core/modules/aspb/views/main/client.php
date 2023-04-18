<?php

use common\models\AspbAy;
use common\models\AspbRemovingInBanks;
use yii\helpers\Url;
use yii\widgets\Pjax;

$this->title = 'Клиент № ' . $data['id'];

$js = <<< JS
$("select").on('change', function() {
    var date = $(this).val();
    $.pjax.reload({
        container: '#clientInfo',
        url: '',
        data:{date: date},
        type: 'POST',
    });
});
JS;
$this->registerJs($js);


?>
<div class="container" style="padding: 40px 20px;">
    <ul class="client-table-list">
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">АУ</p>
            </div>
            <div class="client-table-item_name">
                <p class="client-table-item_name-value"><?= !empty($ay['fio']) ? $ay['fio'] : 'АУ не указан' ?></p>
            </div>
        </li>
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">ФИО должника</p>
            </div>
            <div class="client-table-item_name">
                <p class="client-table-item_name-value"><?= !empty($data['fio']) ? $data['fio'] : 'Имя не указано' ?></p>
            </div>
        </li>
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">Номер дела</p>
            </div>
            <div class="client-table-item_name">
                <?php if (!empty($data['number_affairs'])): ?>
                    <?php $link = json_decode($data['number_affairs'], 1) ?>
                    <a href="<?= $link['link'] ?>" class="client-table-item_name-value"><?= $link['number'] ?></a>
                <?php else: ?>
                    <p>Номер дела не указан</p>
                <?php endif; ?>
            </div>
        </li>
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">Статус дела</p>
            </div>
            <div class="client-table-item_name">
                <p class="client-table-item_name-value"><?= !empty($data['status_affairs']) ? $data['status_affairs'] : 'Статус не указан' ?></p>
            </div>
        </li>
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">Процедура</p>
            </div>
            <div class="client-table-item_name">
                <p class="client-table-item_name-value"><?= !empty($data['proc']) ? $data['proc'] : 'Процедура не указана' ?></p>
            </div>
        </li>
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">Распоряжение на снятие</p>
            </div>
            <div class="client-table-item_name">
                <p class="client-table-item_name-value"><?= !empty($respbank['withdrawal_order']) ? $respbank['withdrawal_order'] : 'Не указано' ?></p>
            </div>
        </li>
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">Дата отправки распоряжения</p>
            </div>
            <div class="client-table-item_name">
                <p class="client-table-item_name-value"><?= !empty($respbank['date_order_sent']) ? date('d-m-Y', strtotime($respbank['date_order_sent'])) : 'Дата не указана' ?></p>
            </div>
        </li>
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">Дата СЗ по завершению</p>
            </div>
            <div class="client-table-item_name">
                <p class="client-table-item_name-value"><?= !empty($data['sz_date_upon_completion']) ? date('d-m-Y', strtotime($data['sz_date_upon_completion'])) : 'Дата не указана' ?></p>
            </div>
        </li>
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">Банки</p>
            </div>
            <div class="client-table-item_name">
                <div class="banks-popup-row">
                    <?php if (!empty($respbank['banks']) && $respbank['banks'] !== '[]'): ?>
                        <?php foreach (json_decode($respbank['banks'], 1) as $k => $v): ?>
                            <?php $arr = json_decode($v, 1) ?>
                            <div class="banks-popup-row-item">
                                <p><?= $arr['count'] ?></p>
                                <p><?= $arr['bic'] ?></p>
                                <p><?= $arr['bank'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Информация о банках отсутствует</p>
                    <?php endif; ?>
                </div>
            </div>
        </li>
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">Реквизиты для ПМ</p>
            </div>
            <div class="client-table-item_name">
                <div class="banks-popup-row">
                    <?php if (!empty($respbank['requisites']) && $respbank['requisites'] !== '[]'): ?>
                        <?php foreach (json_decode($respbank['requisites'], 1) as $k => $v): ?>
                            <?php $arr = json_decode($v, 1) ?>
                            <div class="banks-popup-row-item">
                                <p><?= $arr['count'] ?></p>
                                <p><?= $arr['bic'] ?></p>
                                <p><?= $arr['bank'] ?></p>
                                <p><?= $arr['fio'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Информация о реквизитах отсутствует</p>
                    <?php endif; ?>
                </div>
            </div>
        </li>
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">Состав ПМ</p>
            </div>
            <div class="client-table-item_name">
                <div class="banks-popup-row-item">
                    <p>-_-</p>
                </div>
            </div>
        </li>
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">ПМ по региону или РФ</p>
            </div>
            <div class="client-table-item_name">
                <p class="client-table-item_name-value"><?= !empty($respbank['pm_region_rf']) ? $respbank['pm_region_rf'] : 'Не указан' ?></p>
            </div>
        </li>
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">Доходы</p>
            </div>
            <div class="client-table-item_name">
                <div class="banks-popup-row">
                    <?php if (!empty($respbank['incomes']) && $respbank['incomes'] !== '[]'): ?>
                        <?php foreach (json_decode($respbank['incomes'], 1) as $k => $v): ?>
                            <?php $arr = json_decode($v, 1) ?>
                            <div class="banks-popup-row-item">
                                <p><?= $arr['name'] ?></p>
                                <p><?= $arr['summ'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>Информация о доходах отсутствует</p>
                    <?php endif; ?>
                </div>
            </div>
        </li>
        <li class="client-table-item">
            <div class="client-table-item_name">
                <p class="client-table-item_name-text">Сложность дела</p>
            </div>
            <div class="client-table-item_name">
                <p class="client-table-item_name-value"><?= !empty($data['complexity_case']) ? $data['complexity_case'] : 'Сложность дела не указана' ?></p>
            </div>
        </li>
    </ul>

    <br><br><br>
    <div class="client-select-wrapper">
        <select class="chosen-select date__filter">
            <option disabled selected value="">Выберите месяц</option>
            <option value="01.01.<?= date('Y') ?>">Январь</option>
            <option value="01.02.<?= date('Y') ?>">Февраль</option>
            <option value="01.03.<?= date('Y') ?>">Март</option>
            <option value="01.04.<?= date('Y') ?>">Апрель</option>
            <option value="01.05.<?= date('Y') ?>">Май</option>
            <option value="01.06.<?= date('Y') ?>">Июнь</option>
            <option value="01.07.<?= date('Y') ?>">Июль</option>
            <option value="01.08.<?= date('Y') ?>">Август</option>
            <option value="01.09.<?= date('Y') ?>">Сентябрь</option>
            <option value="01.10.<?= date('Y') ?>">Октябрь</option>
            <option value="01.11.<?= date('Y') ?>">Ноябрь</option>
            <option value="01.12.<?= date('Y') ?>">Декабрь</option>
        </select>
    </div>
    <div class="client-table-list">
        <div class="client-table-row top">
            <div class="client-table-item">
                <p class="client-table-item_name-text">Снятия</p>
            </div>
            <div class="client-table-item">
                <p class="client-table-item_name-text">Переводы ПМ</p>
            </div>
            <div class="client-table-item">
                <p class="client-table-item_name-text">Конкурсная масса</p>
            </div>
            <div class="client-table-item">
                <p class="client-table-item_name-text">Дата</p>
            </div>
            <div class="client-table-item">
                <p class="client-table-item_name-text">Статус</p>
            </div>
        </div>

        <?php Pjax::begin(['id' => 'clientInfo']) ?>
        <?php if (!empty($with)): ?>
        <?php $allWith = 0; $allPm = 0; ?>
            <?php foreach ($with as $val): ?>
            <?php
                $allWith +=  $val['withdrawal_summ'];
                $allPm +=  $val['pm_debtor'];

                ?>
                <div class="client-table-row">
                    <div class="client-table-item_name">
                        <p class="client-table-item_name-value"><?= $val['withdrawal_summ'] ?></p>
                    </div>
                    <div class="client-table-item_name">
                        <p class="client-table-item_name-value"><?= $val['pm_debtor'] ?></p>
                    </div>
                    <div class="client-table-item_name">
                        <p class="client-table-item_name-value"><?= $val['withdrawal_summ'] - $val['pm_debtor'] ?></p>
                    </div>
                    <div class="client-table-item_name">
                        <p class="client-table-item_name-value"><?= date('d.m.Y', strtotime($val['withdrawal_date'])) ?></p>
                    </div>
                    <div class="client-table-item_name">
                        <p class="client-table-item_name-value"><?= $val['transfer_status'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="client-table-row top">
                <div class="client-table-item">
                    <p class="client-table-item_name-text">Итого</p>
                </div>
            </div>
            <div class="client-table-row">
                <div class="client-table-item_name">
                    <p class="client-table-item_name-value"><?= $allWith ?></p>
                </div>
                <div class="client-table-item_name">
                    <p class="client-table-item_name-value"><?= $allPm ?></p>
                </div>
                <div class="client-table-item_name">
                    <p class="client-table-item_name-value"><?= $allWith - $allPm ?></p>
                </div>
                <div class="client-table-item_name"></div>
                <div class="client-table-item_name"></div>
            </div>
        <?php else: ?>
            <div class="client-table-row">
                Информация отсутствует
            </div>
        <?php endif; ?>
        <?php Pjax::end(); ?>
    </div>
</div>