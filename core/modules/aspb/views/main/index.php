<?php

use common\models\AspbWithdrawalRegister;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\jui\DatePicker;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$this->title = 'АСПБ таблица';
$js = <<< JS

JS;
$this->registerJs($js);
?>
<section class="tab tab1 active">
    <div class="container">
        <h1 class="tab-title">Прием дел в работу</h1>
        <?php Pjax::begin(['id' => 'case_in_work']) ?>
        <?php $jss = <<< JS
            $(".chosen-select").chosen({disable_search_threshold: 0});
JS;
        $this->registerJs($jss);
        ?>
        <div class="inputs-group-wrapper">
            <button class="scroll left">❮</button>
            <button class="scroll right">❯</button>

            <div class="inputs-group">
                <div class="inputs-group-row head__group">
                    <div style="min-width: 70px; max-width: 70px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('id', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="id" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">№</p>
                        </label>
                    </div>
                    <div class="inputs-group-name fixed__column">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('fio', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="fio" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">ФИО должника</p>
                        </label>
                    </div>
                    <div style="min-width: 160px; max-width: 160px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('date_create', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="date_create" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Дата приема дела</p>
                        </label>
                    </div>
                    <div style="min-width: 175px; max-width: 175px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('date_send_sro', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="date_send_sro" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Дата отправки в СРО</p>
                        </label>
                    </div>
                    <div class="inputs-group-name" style="min-width: 300px; max-width: 300px">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('ay', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="ay" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">АУ</p>
                        </label>
                    </div>
                    <div style="min-width: 220px; max-width: 220px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Номер дела</p>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('partner', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="partner" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Партнёр</p>
                        </label>
                    </div>
                    <div style="min-width: 215px; max-width: 215px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('date_session', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="date_session" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Дата судебного заседания</p>
                        </label>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('status_affairs', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="status_affairs" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Статус дела</p>
                        </label>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('proc', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="proc" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Процедура</p>
                        </label>
                    </div>
                    <div style="min-width: 230px; max-width: 230px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('date_send_sro_confirm', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="date_send_sro_confirm" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Дата отправки согласия СРО</p>
                        </label>
                    </div>
                    <div style="min-width: 210px; max-width: 210px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('document', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="document" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Пакет документов</p>
                        </label>
                    </div>
                    <div style="min-width: 180px; max-width: 180px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Сложность дела</p>
                    </div>
                    <div class="inputs-group-name">
                        <p class="inputs-group-name-text" style="font-size: 14px;">Запрос на дополнительные
                            документы</p>
                    </div>
                    <div style="min-width: 180px; max-width: 180px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('deposit', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="deposit" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Депозит из Суда</p>
                        </label>
                    </div>
                    <div style="min-width: 220px; max-width: 220px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('deposit_receipt', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="deposit_receipt" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Дата получения депозита</p>
                        </label>
                    </div>
                </div>
                <?php if (!empty($clients)) : ?>
                    <?php foreach ($clients as $k => $v) : ?>
                        <div class="inputs-group-row">
                            <label style="min-width: 70px" class="input-wrapper">
                                <p class="inputs-group-name-text"><?= $v['id'] ?></p>
                            </label>

                            <label class="input-wrapper fixed__column">
                                <input data-type="string" data-id="<?= $v['id'] ?>" class="input-send input-t" type="text" placeholder="Фио" value="<?= !empty($v['fio']) ? $v['fio'] : '' ?>" name="fio">
                            </label>

                            <label style="min-width: 160px; max-width: 160px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'date_create',
                                    'value' => !empty($v['date_create']) ? date('d-m-Y', strtotime($v['date_create'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label style="min-width: 175px; max-width: 175px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'date_send_sro',
                                    'value' => !empty($v['date_send_sro']) ? date('d-m-Y', strtotime($v['date_send_sro'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label class="input-wrapper" style="min-width: 300px; max-width: 300px">
                                <select class="chosen-select input-send" name="ay" data-id="<?= $v['id'] ?>" data-type="int">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($ay)) : ?>
                                        <?php foreach ($ay as $key => $val) : ?>
                                            <option <?= $v['ay'] === $val['id'] ? 'selected' : '' ?> value="<?= $val['id'] ?>"><?= $val['fio'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>

                            <div style="min-width: 220px; max-width: 220px" class="input-wrapper">
                                <?php $href = json_decode($v['number_affairs'], 1) ?>
                                <a data-type="string" data-id="<?= $v['id'] ?>" data-name="number_affairs" target="_blank" href="<?= Url::to($href['link']) ?>" class="case-link"><?= !empty($href['number']) ? $href['number'] : 'Не указано' ?></a>
                                <button type="button" class="case--set link--btn">Редактировать</button>
                            </div>

                            <label class="input-wrapper">
                                <select class="chosen-select input-send" name="partner" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($partner)) : ?>
                                        <?php foreach ($partner as $key => $val) : ?>
                                            <option <?= $v['partner'] === $val['name'] ? 'selected' : '' ?> value="<?= $val['name'] ?>"><?= $val['name'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>

                            <label style="min-width: 215px; max-width: 215px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'date_session',
                                    'value' => !empty($v['date_session']) ? date('d-m-Y', strtotime($v['date_session'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper">
                                <select class="chosen-select input-send" name="status_affairs" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['status_affairs'] === 'Не признан' ? 'selected' : '' ?> value="Не признан">Не признан
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Признан' ? 'selected' : '' ?> value="Признан">
                                        Признан
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Завершено' ? 'selected' : '' ?> value="Завершено">Завершено
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Прекращено' ? 'selected' : '' ?> value="Прекращено">Прекращено
                                    </option>
                                </select>
                            </label>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper <?= $v['status_affairs'] === 'Признан' ? '' : 'disabled' ?>">
                                <select class="chosen-select input-send" name="proc" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['proc'] === 'Реализация' ? 'selected' : '' ?> value="Реализация">
                                        Реализация
                                    </option>
                                    <option <?= $v['proc'] === 'Реструктуризация' ? 'selected' : '' ?> value="Реструктуризация">Реструктуризация
                                    </option>
                                </select>
                            </label>

                            <label style="min-width: 230px; max-width: 230px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'date_send_sro_confirm',
                                    'value' => !empty($v['date_send_sro_confirm']) ? date('d-m-Y', strtotime($v['date_send_sro_confirm'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label style="min-width: 210px; max-width: 210px" class="input-wrapper">
                                <select class="chosen-select input-send" name="document" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['document'] === 'Да' ? 'selected' : '' ?> value="Да">Да</option>
                                    <option <?= $v['document'] === 'Нет' ? 'selected' : '' ?> value="Нет">Нет</option>
                                    <option <?= $v['document'] === 'Не хватает документов' ? 'selected' : '' ?> value="Не хватает документов">Не хватает документов
                                    </option>
                                </select>
                            </label>

                            <div style="min-width: 180px; max-width: 180px" class="input-wrapper">
                                <?php if (isset($v['income']) && isset($v['property_in_sale']) && isset($v['transactions_for_contesting']) && isset($v['active_creditors'])) {
                                    $summ = $v['income'] + $v['property_in_sale'] + $v['transactions_for_contesting'] + $v['active_creditors'];
                                } else {
                                    $summ = 0;
                                } ?>
                                <div class="diff-case-wrapper">
                                    <p class="diff-case"><?= $summ ?></p>
                                    <button data-id="<?= $v['id'] ?>" type="button" class="case--diff link--btn">
                                        Редактировать
                                    </button>
                                </div>
                            </div>

                            <div style="min-width: 300px; max-width: 300px; box-sizing: border-box" class="input-wrapper">
                                <div class="dop-docs">
                                    <?php $date = json_decode($v['additional_documents'], 1) ?>
                                    <label class="dop-docs-label">
                                        Отправка
                                        <?= DatePicker::widget([
                                            'value' => !empty($date['send']) ? date('d-m-Y', strtotime($date['send'])) : date('Y-m-d'),
                                            'options' => ['class' => 'input-sends input-t', 'data-id' => $v['id'], 'data-type' => 'string', 'id' => "additional_documents_send-{$v['id']}"],
                                            'language' => 'ru',
                                            'dateFormat' => 'dd-MM-yyyy',
                                        ]); ?>
                                    </label>
                                    <label class="dop-docs-label">
                                        Получение
                                        <?= DatePicker::widget([
                                            'name' => 'additional_documents_get',
                                            'value' => !empty($date['get']) ? date('d-m-Y', strtotime($date['get'])) : date('Y-m-d'),
                                            'options' => ['class' => 'input-sends input-t', 'data-id' => $v['id'], 'data-type' => 'string', 'id' => "additional_documents_get-{$v['id']}"],
                                            'language' => 'ru',
                                            'dateFormat' => 'dd-MM-yyyy',
                                        ]); ?>
                                    </label>
                                </div>
                            </div>

                            <label style="min-width: 180px; max-width: 180px" class="input-wrapper">
                                <input class="input-send input-t" type="number" value="<?= !empty($v['deposit']) ? $v['deposit'] : 25000 ?>" name="deposit" data-id="<?= $v['id'] ?>" data-type="int">
                            </label>

                            <label style="min-width: 220px; max-width: 220px" class="input-wrapper input-wrapper-last <?= $v['status_affairs'] === 'Завершено' ? '' : 'disabled' ?>">
                                <?= DatePicker::widget([
                                    'name' => 'deposit_receipt',
                                    'value' => !empty($v['deposit_receipt']) ? date('d-m-Y', strtotime($v['deposit_receipt'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <button type="button" data-id="<?= $v['id'] ?>" class="delete__client">
                                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.073223 10.0585 -0.0732228 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.073223 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.073223 0.987437 -0.0732228 1.28033 0.21967L5.28553 4.22487Z" fill="red" />
                                </svg>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p style="text-align: center" class="inputs-group-name-text">Клиенты не найдены</p>
                <?php endif; ?>
            </div>
            <?= LinkPager::widget([
                'pagination' => $pagesC,
                'options' => ['class' => 'pager_link'],
                'linkOptions' => ['class' => 'pager_link-a'],
                'maxButtonCount' => 3,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
                'disableCurrentPageButton' => true,
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
        <div class="button__group">
            <button type="button" class="add__client btn--orange">Добавить клиента</button>
            <button type="button" class="add--ay btn--orange">Добавить АУ</button>
            <button type="button" class="add--partner btn--orange">Добавить партнера</button>
        </div>
    </div>

    <div class="case--set-card-back">
        <div class="case--set-card">
            <input class="input-case input-t" type="text" placeholder="Номер дела" name="case-number">
            <input class="input-case input-t" type="text" placeholder="Ссылка на дело" name="case-link">
            <button class="confirm--case btn--orange">Подтвердить</button>
        </div>
    </div>

    <div class="ay--set-card-back">
        <div class="ay--set-card">
            <p class="popup__error--title">Добавить АУ</p>
            <input class="input-t" type="text" placeholder="ФИО" name="ay__fio">
            <input class="input-t" type="text" placeholder="Регистрационный номер" name="reg_number">
            <input class="input-t" type="text" placeholder="Почтовый адресс" name="address">
            <input class="input-t" type="email" placeholder="Email" name="email">
            <button class="add__ay btn--orange">Подтвердить</button>
        </div>
    </div>

    <div class="partner--set-card-back">
        <div class="partner--set-card">
            <p class="popup__error--title">Добавить партнера</p>
            <input class="input-t" type="text" placeholder="ФИО" name="partner__fio">
            <input class="input-t" type="tel" placeholder="+79481115555" name="partner__phone">
            <button class="add__partner btn--orange">Подтвердить</button>
        </div>
    </div>
</section>
<section class="tab tab2">
    <div class="container">
        <h1 class="tab-title">Финансы АСПБ</h1>
        <?php Pjax::begin(['id' => 'aspb']) ?>
        <?php $jss = <<< JS
            $(".chosen-select").chosen({disable_search_threshold: 0});
JS;
        $this->registerJs($jss);
        ?>
        <div class="inputs-group-wrapper">
            <button class="scroll left">❮</button>
            <button class="scroll right">❯</button>

            <div class="inputs-group">
                <div class="inputs-group-row head__group">
                    <div style="min-width: 70px; max-width: 70px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('id', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="id" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">№</p>
                        </label>
                    </div>
                    <div class="inputs-group-name fixed__column">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('fio', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="fio" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">ФИО должника</p>
                        </label>
                    </div>
                    <div class="inputs-group-name" style="min-width: 300px; max-width: 300px">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('ay', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="ay" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">АУ</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('partner', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="partner" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Партнёр</p>
                        </label>
                    </div>
                    <div style="min-width: 215px; max-width: 215px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('date_session', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="date_session" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Дата судебного заседания</p>
                        </label>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('status_affairs', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="status_affairs" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Статус дела</p>
                        </label>
                    </div>
                    <div style="min-width: 195px; max-width: 195px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('additional_deposit', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="additional_deposit" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text" style="font-size: 12px;">Дополнительный депозит в суде</p>
                        </label>
                    </div>
                    <div style="min-width: 240px; max-width: 240px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('mandatory_payments_pay', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="mandatory_payments_pay" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text" style="font-size: 12px;">Размер обязательных платежей к
                                оплате</p>
                        </label>
                    </div>
                    <div style="min-width: 260px; max-width: 260px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('mandatory_payments_paid', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="mandatory_payments_paid" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text" style="font-size: 12px;">Размер обязательных платежей
                                оплаченных</p>
                        </label>
                    </div>
                    <div style="min-width: 160px; max-width: 160px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Долг по делу</p>
                    </div>
                    <div style="min-width: 255px; max-width: 255px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('additional_payments_pay', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="additional_payments_pay" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text" style="font-size: 12px;">Размер дополнительных платежей к
                                оплате</p>
                        </label>
                    </div>
                    <div style="min-width: 275px; max-width: 275px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('additional_payments_paid', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="additional_payments_paid" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text" style="font-size: 12px;">Размер дополнительных платежей
                                оплаченных</p>
                        </label>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Долг по делу доп.</p>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('expenses_kommersant', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="expenses_kommersant" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Расходы комерсант</p>
                        </label>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('expenses_efrsb', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="expenses_efrsb" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Расходы ЕФРСБ</p>
                        </label>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('expenses_pochta', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="expenses_pochta" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Расходы Почта</p>
                        </label>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('expenses_helpers', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="expenses_helpers" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Расходы Помощники</p>
                        </label>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('deposit', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="deposit" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Депозиты</p>
                        </label>
                    </div>
                    <div style="min-width: 225px; max-width: 225px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('deposit_receipt', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="deposit_receipt" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text" style="font-size: 12px">Дата получения депозита
                                (депозитов)</p>
                        </label>
                    </div>
                </div>
                <?php if (!empty($clients)) : ?>
                    <?php foreach ($clients as $k => $v) : ?>
                        <div class="inputs-group-row">
                            <label style="min-width: 70px" class="input-wrapper">
                                <p class="inputs-group-name-text"><?= $v['id'] ?></p>
                            </label>

                            <label class="input-wrapper fixed__column">
                                <input data-type="string" data-id="<?= $v['id'] ?>" class="input-send input-t" type="text" placeholder="Фио" value="<?= !empty($v['fio']) ? $v['fio'] : '' ?>" name="fio">
                            </label>

                            <label class="input-wrapper" style="min-width: 300px; max-width: 300px">
                                <select class="chosen-select input-send" name="ay" data-id="<?= $v['id'] ?>" data-type="int">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($ay)) : ?>
                                        <?php foreach ($ay as $key => $val) : ?>
                                            <option <?= $v['ay'] === $val['id'] ? 'selected' : '' ?> value="<?= $val['id'] ?>"><?= $val['fio'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>

                            <label class="input-wrapper">
                                <select class="chosen-select input-send" name="partner" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($partner)) : ?>
                                        <?php foreach ($partner as $key => $val) : ?>
                                            <option <?= $v['partner'] === $val['name'] ? 'selected' : '' ?> value="<?= $val['name'] ?>"><?= $val['name'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>

                            <label style="min-width: 215px; max-width: 215px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'date_session',
                                    'value' => !empty($v['date_session']) ? date('d-m-Y', strtotime($v['date_session'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper">
                                <select class="chosen-select input-send" name="status_affairs" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['status_affairs'] === 'Не признан' ? 'selected' : '' ?> value="Не признан">Не признан
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Признан' ? 'selected' : '' ?> value="Признан">
                                        Признан
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Завершено' ? 'selected' : '' ?> value="Завершено">Завершено
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Прекращено' ? 'selected' : '' ?> value="Прекращено">Прекращено
                                    </option>
                                </select>
                            </label>

                            <label style="min-width: 195px; max-width: 195px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-send input-t" type="number" value="<?= !empty($v['additional_deposit']) ? $v['additional_deposit'] : '' ?>" placeholder="25000" name="additional_deposit">
                            </label>

                            <label style="min-width: 240px; max-width: 240px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-send calc input-t" type="number" id="calc1-<?= $v['id'] ?>" value="<?= !empty($v['mandatory_payments_pay']) ? $v['mandatory_payments_pay'] : '' ?>" placeholder="25000" name="mandatory_payments_pay">
                            </label>

                            <label style="min-width: 260px; max-width: 260px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-send calc input-t" type="number" id="calc2-<?= $v['id'] ?>" value="<?= !empty($v['mandatory_payments_paid']) ? $v['mandatory_payments_paid'] : '' ?>" placeholder="25000" name="mandatory_payments_paid">
                            </label>

                            <label style="min-width: 160px; max-width: 160px" class="input-wrapper">
                                <input class="input-send calc_result input-t" type="number" id="calc-result-<?= $v['id'] ?>" value="<?= $v['mandatory_payments_pay'] - $v['mandatory_payments_paid'] ?>">
                            </label>

                            <label style="min-width: 255px; max-width: 255px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" id="additional_payments_pay-<?= $v['id'] ?>" class="input-send additiondl_calc input-t" type="number" value="<?= !empty($v['additional_payments_pay']) ? $v['additional_payments_pay'] : '' ?>" placeholder="25000" name="additional_payments_pay">
                            </label>

                            <label style="min-width: 275px; max-width: 275px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" id="additional_payments_paid-<?= $v['id'] ?>" class="input-send additiondl_calc input-t" type="number" placeholder="25000" value="<?= !empty($v['additional_payments_paid']) ? $v['additional_payments_paid'] : '' ?>" name="additional_payments_paid">
                            </label>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper">
                                <input class="input-send result_additiondl_calc input-t" type="number" id="result_additiondl_calc-<?= $v['id'] ?>" value="<?= $v['additional_payments_pay'] - $v['additional_payments_paid'] ?>">
                            </label>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-send input-t" type="number" value="<?= !empty($v['expenses_kommersant']) ? $v['expenses_kommersant'] : '' ?>" name="expenses_kommersant" placeholder="0">
                            </label>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-send input-t" type="number" value="<?= !empty($v['expenses_efrsb']) ? $v['expenses_efrsb'] : '' ?>" name="expenses_efrsb" placeholder="0">
                            </label>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-send input-t" type="number" value="<?= !empty($v['expenses_pochta']) ? $v['expenses_pochta'] : '' ?>" name="expenses_pochta" placeholder="0">
                            </label>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-send input-t" type="number" value="<?= !empty($v['expenses_helpers']) ? $v['expenses_helpers'] : '' ?>" name="expenses_helpers" placeholder="0">
                            </label>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-send input-t" type="number" value="<?= !empty($v['deposit']) ? $v['deposit'] : '' ?>" name="deposit" placeholder="0">
                            </label>

                            <label style="min-width: 225px; max-width: 225px" class="input-wrapper input-wrapper-last <?= $v['status_affairs'] === 'Завершено' ? '' : 'disabled' ?>">
                                <?= DatePicker::widget([
                                    'name' => 'deposit_receipt',
                                    'value' => !empty($v['deposit_receipt']) ? date('d-m-Y', strtotime($v['deposit_receipt'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <button type="button" data-id="<?= $v['id'] ?>" class="delete__client">
                                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.073223 10.0585 -0.0732228 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.073223 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.073223 0.987437 -0.0732228 1.28033 0.21967L5.28553 4.22487Z" fill="red" />
                                </svg>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p style="text-align: center" class="inputs-group-name-text">Клиенты не найдены</p>
                <?php endif; ?>
            </div>
            <?= LinkPager::widget([
                'pagination' => $pagesC,
                'options' => ['class' => 'pager_link'],
                'linkOptions' => ['class' => 'pager_link-a'],
                'maxButtonCount' => 3,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
                'disableCurrentPageButton' => true,
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
        <div class="button__group">
            <!--            <button type="button" class="add__client btn--orange">Добавить клиента</button>-->
        </div>
    </div>
</section>
<section class="tab tab3">
    <div class="container">
        <h1 class="tab-title">Первичный отдел</h1>
        <?php Pjax::begin(['id' => 'primary_department']) ?>
        <?php $jss = <<< JS
            $(".chosen-select").chosen({disable_search_threshold: 0});
JS;
        $this->registerJs($jss);
        ?>
        <div class="inputs-group-wrapper">
            <button class="scroll left">❮</button>
            <button class="scroll right">❯</button>

            <div class="inputs-group">
                <div class="inputs-group-row head__group">
                    <div style="min-width: 70px; max-width: 70px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('id', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="id" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">№</p>
                        </label>
                    </div>
                    <div class="inputs-group-name fixed__column">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('fio', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="fio" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">ФИО должника</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('ay', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="ay" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">АУ</p>
                        </label>
                    </div>
                    <div style="min-width: 220px; max-width: 220px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Номер дела</p>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('partner', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="partner" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Партнёр</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('responsible_primary_work', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="responsible_primary_work" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text" style="font-size: 14px;">Ответственный за Первичную
                                работу</p>
                        </label>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('status_affairs', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="status_affairs" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Статус дела</p>
                        </label>
                    </div>
                    <div style="min-width: 215px; max-width: 215px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('date_session', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="date_session" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Дата судебного заседания</p>
                        </label>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('proc', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="proc" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Процедура</p>
                        </label>
                    </div>
                    <div style="min-width: 160px; max-width: 160px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('efrsb', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="efrsb" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">ЕФРСБ</p>
                        </label>
                    </div>
                    <div style="min-width: 160px; max-width: 160px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('kommersant', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="kommersant" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Коммерсант</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <p class="inputs-group-name-text">Коммерсант оплата </p>
                    </div>
                    <div style="min-width: 220px; max-width: 220px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('request_to_debtor', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="request_to_debtor" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Отправка запроса должнику</p>
                        </label>
                    </div>
                    <div style="min-width: 180px; max-width: 180px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('sending_to_government_agencies', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="sending_to_government_agencies" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Отправка в госорганы</p>
                        </label>
                    </div>
                    <div style="min-width: 180px; max-width: 180px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('order_usrn', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="order_usrn" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Заказ ЕГРН</p>
                        </label>
                    </div>
                    <div style="min-width: 180px; max-width: 180px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('sending_creditors', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="sending_creditors" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Отправка кредиторам</p>
                        </label>
                    </div>
                </div>
                <?php if (!empty($aspbInfo)) : ?>
                    <?php foreach ($aspbInfo as $k => $v) : ?>
                        <div class="inputs-group-row">
                            <label style="min-width: 70px" class="input-wrapper">
                                <p class="inputs-group-name-text">#<?= $v['id'] ?></p>
                            </label>

                            <label class="input-wrapper fixed__column">
                                <input data-type="string" data-id="<?= $v['id'] ?>" class="input-send input-t" type="text" placeholder="Фио" value="<?= !empty($v['fio']) ? $v['fio'] : '' ?>" name="fio">
                            </label>

                            <label class="input-wrapper">
                                <select class="chosen-select input-send" name="ay" data-id="<?= $v['id'] ?>" data-type="int">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($ay)) : ?>
                                        <?php foreach ($ay as $key => $val) : ?>
                                            <option <?= $v['ay'] === $val['id'] ? 'selected' : '' ?> value="<?= $val['id'] ?>"><?= $val['fio'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>

                            <div style="min-width: 220px; max-width: 220px" class="input-wrapper">
                                <?php $href = json_decode($v['number_affairs'], 1) ?>
                                <a data-type="string" data-id="<?= $v['id'] ?>" data-name="number_affairs" target="_blank" href="<?= Url::to($href['link']) ?>" class="case-link"><?= !empty($href['number']) ? $href['number'] : 'Не указано' ?></a>
                            </div>

                            <label class="input-wrapper">
                                <select class="chosen-select input-send" name="partner" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($partner)) : ?>
                                        <?php foreach ($partner as $key => $val) : ?>
                                            <option <?= $v['partner'] === $val['name'] ? 'selected' : '' ?> value="<?= $val['name'] ?>"><?= $val['name'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>

                            <label class="input-wrapper">
                                <select class="chosen-select input-send" data-id="<?= $v['id'] ?>" data-type="string" name="responsible_primary_work">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($responsible)) : ?>
                                        <?php foreach ($responsible as $key => $val) : ?>
                                            <option <?= $v['responsible_primary_work'] === $val['fio'] ? 'selected' : '' ?> value="<?= $val['fio'] ?>"><?= $val['fio'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper">
                                <select class="chosen-select input-send" name="status_affairs" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['status_affairs'] === 'Не признан' ? 'selected' : '' ?> value="Не признан">Не признан
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Признан' ? 'selected' : '' ?> value="Признан">
                                        Признан
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Завершено' ? 'selected' : '' ?> value="Завершено">Завершено
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Прекращено' ? 'selected' : '' ?> value="Прекращено">Прекращено
                                    </option>
                                </select>
                            </label>

                            <label style="min-width: 215px; max-width: 215px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'date_session',
                                    'value' => !empty($v['date_session']) ? date('d-m-Y', strtotime($v['date_session'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper <?= $v['status_affairs'] === 'Признан' ? '' : 'disabled' ?>">
                                <select class="chosen-select input-send" name="proc" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['proc'] === 'Реализация' ? 'selected' : '' ?> value="Реализация">
                                        Реализация
                                    </option>
                                    <option <?= $v['proc'] === 'Реструктуризация' ? 'selected' : '' ?> value="Реструктуризация">Реструктуризация
                                    </option>
                                </select>
                            </label>

                            <label style="min-width: 160px; max-width: 160px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'efrsb',
                                    'value' => !empty($v['efrsb']) ? date('d-m-Y', strtotime($v['efrsb'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label style="min-width: 160px; max-width: 160px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'kommersant',
                                    'value' => !empty($v['kommersant']) ? date('d-m-Y', strtotime($v['kommersant'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <div class="input-wrapper">
                                <div class="dop-docs">
                                    <?php $komersant_info = json_decode($v['kommersant_paid'], 1) ?>
                                    <label class="dop-docs-label">
                                        Сумма
                                        <input class="input-send save__komersant--info input-t" type="number" value="<?= !empty($komersant_info) ? $komersant_info['summ'] : 0 ?>" name="kommersant_paid--summ" data-id="<?= $v['id'] ?>" id="kommersant_paid--summ-<?= $v['id'] ?>" data-type="string">
                                    </label>

                                    <?php $date = json_decode($v['additional_documents'], 1) ?>
                                    <label class="dop-docs-label">
                                        Дата
                                        <?= DatePicker::widget([
                                            'name' => 'kommersant_paid--date',
                                            'value' => !empty($komersant_info['date']) ? date('d-m-Y', strtotime($komersant_info['date'])) : date('d-m-Y'),
                                            'options' => ['class' => 'input-sends save__komersant--info input-t', 'data-id' => $v['id'], 'data-type' => 'string', 'id' => "kommersant_paid--date-{$v['id']}"],
                                            'language' => 'ru',
                                            'dateFormat' => 'dd-MM-yyyy',
                                        ]); ?>
                                    </label>
                                </div>
                            </div>

                            <label style="min-width: 220px; max-width: 220px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'request_to_debtor',
                                    'value' => !empty($v['request_to_debtor']) ? date('d-m-Y', strtotime($v['request_to_debtor'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label style="min-width: 180px; max-width: 180px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'sending_to_government_agencies',
                                    'value' => !empty($v['sending_to_government_agencies']) ? date('d-m-Y', strtotime($v['sending_to_government_agencies'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label style="min-width: 180px; max-width: 180px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'order_usrn',
                                    'value' => !empty($v['order_usrn']) ? date('d-m-Y', strtotime($v['order_usrn'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label style="min-width: 180px; max-width: 180px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'sending_creditors',
                                    'value' => !empty($v['sending_creditors']) ? date('d-m-Y', strtotime($v['sending_creditors'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <button type="button" data-id="<?= $v['id'] ?>" class="delete__client">
                                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.073223 10.0585 -0.0732228 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.073223 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.073223 0.987437 -0.0732228 1.28033 0.21967L5.28553 4.22487Z" fill="red" />
                                </svg>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p style="text-align: center" class="inputs-group-name-text">Клиенты не найдены</p>
                <?php endif; ?>
            </div>
            <?= LinkPager::widget([
                'pagination' => $pagesI,
                'options' => ['class' => 'pager_link'],
                'linkOptions' => ['class' => 'pager_link-a'],
                'maxButtonCount' => 3,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
                'disableCurrentPageButton' => true,
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
        <div class="button__group">
            <button type="button" class="add--responsible btn--orange">Добавить ответственного</button>
        </div>
    </div>

    <div class="responsible--set-card-back">
        <div class="responsible--set-card">
            <p class="popup__error--title">Добавить ответственного</p>
            <input class="input-t" type="text" placeholder="ФИО" name="responsible__fio">
            <button class="add__responsible btn--orange">Подтвердить</button>
        </div>
    </div>
</section>
<section class="tab tab4">
    <div class="container">
        <h1 class="tab-title">Дела АСПБ</h1>
        <?php Pjax::begin(['id' => 'case_aspb']) ?>
        <?php $jss = <<< JS
            $(".chosen-select").chosen({disable_search_threshold: 0});
JS;
        $this->registerJs($jss);
        ?>
        <div class="inputs-group-wrapper">
            <button class="scroll left">❮</button>
            <button class="scroll right">❯</button>

            <div class="inputs-group">
                <div class="inputs-group-row head__group">
                    <div style="min-width: 70px; max-width: 70px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('id', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="id" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">№</p>
                        </label>
                    </div>
                    <div class="inputs-group-name fixed__column">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('fio', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="fio" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">ФИО должника</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('ay', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="ay" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">АУ</p>
                        </label>
                    </div>
                    <div style="min-width: 220px; max-width: 220px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Номер дела</p>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('partner', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="partner" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Партнёр</p>
                        </label>
                    </div>
                    <div style="min-width: 215px; max-width: 215px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('date_session', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="date_session" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Дата судебного заседания</p>
                        </label>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('status_affairs', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="status_affairs" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Статус дела</p>
                        </label>
                    </div>
                    <div style="min-width: 195px; max-width: 195px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('additional_deposit', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="additional_deposit" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text" style="font-size: 12px;">Дополнительный депозит в суде</p>
                        </label>
                    </div>
                    <div style="min-width: 215px; max-width: 215px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('additional_deposit_date', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="additional_deposit_date" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text" style="font-size: 12px;">Дополнительный депозит
                                получен</p>
                        </label>
                    </div>
                    <div style="min-width: 150px; max-width: 150px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Сложность дела</p>
                    </div>
                    <div style="min-width: 180px; max-width: 180px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('income', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="income" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Доход</p>
                        </label>
                    </div>
                    <div style="min-width: 180px; max-width: 180px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('property_in_sale', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="property_in_sale" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text" style="font-size: 12px;">Имущество в реализацию</p>
                        </label>
                    </div>
                    <div style="min-width: 180px; max-width: 180px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('transactions_for_contesting', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="transactions_for_contesting" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text" style="font-size: 12px;">Сделки под оспаривание</p>
                        </label>
                    </div>
                    <div style="min-width: 180px; max-width: 180px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('active_creditors', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="active_creditors" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text" style="font-size: 12px;">Активные кредиторы</p>
                        </label>
                    </div>
                    <div style="min-width: 180px; max-width: 180px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('inventory_of_property', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="inventory_of_property" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Опись имущества</p>
                        </label>
                    </div>
                    <div style="min-width: 180px; max-width: 180px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('deliberate_fictitious', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="deliberate_fictitious" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text" style="font-size: 12px;">Преднамеренное фиктивное</p>
                        </label>
                    </div>
                    <div style="min-width: 180px; max-width: 180px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('assembly_of_creditors', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="assembly_of_creditors" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Собрание кредиторов</p>
                        </label>
                    </div>
                    <div style="min-width: 195px; max-width: 195px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('sz_date_upon_completion', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="sz_date_upon_completion" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Дата СЗ по завершению</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('directed_to_sz', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="directed_to_sz" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Направлено к СЗ</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('verified_sent_sz', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="verified_sent_sz" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Проверено что отправлено к СЗ</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['check']) && in_array('responsible_assistant', $_POST['check']) ? 'checked' : '' ?> type="checkbox" value="responsible_assistant" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="check[]">
                            <p class="inputs-group-name-text">Ответственный помощник</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <p class="inputs-group-name-text">Комментарий к делу</p>
                    </div>
                </div>
                <?php if (!empty($aspbInfo)) : ?>
                    <?php foreach ($aspbInfo as $k => $v) : ?>
                        <div class="inputs-group-row">
                            <label style="min-width: 70px" class="input-wrapper">
                                <p class="inputs-group-name-text">#<?= $v['id'] ?></p>
                            </label>

                            <label class="input-wrapper fixed__column">
                                <input data-type="string" data-id="<?= $v['id'] ?>" class="input-send input-t" type="text" placeholder="Фио" value="<?= !empty($v['fio']) ? $v['fio'] : '' ?>" name="fio">
                            </label>

                            <label class="input-wrapper">
                                <select class="chosen-select input-send" name="ay" data-id="<?= $v['id'] ?>" data-type="int">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($ay)) : ?>
                                        <?php foreach ($ay as $key => $val) : ?>
                                            <option <?= $v['ay'] === $val['id'] ? 'selected' : '' ?> value="<?= $val['id'] ?>"><?= $val['fio'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>
                            <div style="min-width: 220px; max-width: 220px" class="input-wrapper">
                                <?php $href = json_decode($v['number_affairs'], 1) ?>
                                <a data-type="string" data-id="<?= $v['id'] ?>" data-name="number_affairs" target="_blank" href="<?= Url::to($href['link']) ?>" class="case-link"><?= !empty($href['number']) ? $href['number'] : 'Не указано' ?></a>
                            </div>

                            <label class="input-wrapper">
                                <select class="chosen-select input-send" name="partner" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($partner)) : ?>
                                        <?php foreach ($partner as $key => $val) : ?>
                                            <option <?= $v['partner'] === $val['name'] ? 'selected' : '' ?> value="<?= $val['name'] ?>"><?= $val['name'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>

                            <label style="min-width: 215px; max-width: 215px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'date_session',
                                    'value' => !empty($v['date_session']) ? date('d-m-Y', strtotime($v['date_session'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper">
                                <select class="chosen-select input-send" name="status_affairs" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['status_affairs'] === 'Не признан' ? 'selected' : '' ?> value="Не признан">Не признан
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Признан' ? 'selected' : '' ?> value="Признан">
                                        Признан
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Завершено' ? 'selected' : '' ?> value="Завершено">Завершено
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Прекращено' ? 'selected' : '' ?> value="Прекращено">Прекращено
                                    </option>
                                </select>
                            </label>

                            <label style="min-width: 195px; max-width: 195px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-send input-t" type="number" value="<?= !empty($v['additional_deposit']) ? $v['additional_deposit'] : '' ?>" placeholder="25000" name="additional_deposit">
                            </label>

                            <label style="min-width: 215px; max-width: 215px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'additional_deposit_date',
                                    'value' => !empty($v['additional_deposit_date']) ? date('d-m-Y', strtotime($v['additional_deposit_date'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <div style="min-width: 150px; max-width: 150px" class="input-wrapper">
                                <?php if (isset($v['income']) && isset($v['property_in_sale']) && isset($v['transactions_for_contesting']) && isset($v['active_creditors'])) {
                                    $summ = $v['income'] + $v['property_in_sale'] + $v['transactions_for_contesting'] + $v['active_creditors'];
                                } else {
                                    $summ = 0;
                                } ?>
                                <div class="diff-case-wrapper">
                                    <p class="diff-case"><?= $summ ?></p>
                                </div>
                            </div>

                            <label style="min-width: 180px; max-width: 180px" class="input-wrapper">
                                <input min="0" max="2" data-id="<?= $v['id'] ?>" data-type="int" class="input-send input-t" type="number" value="<?= !empty($v['income']) ? $v['income'] : '' ?>" placeholder="0" name="income">
                            </label>

                            <label style="min-width: 180px; max-width: 180px" class="input-wrapper">
                                <input min="0" max="2" data-id="<?= $v['id'] ?>" data-type="int" class="input-send input-t" type="number" value="<?= !empty($v['property_in_sale']) ? $v['property_in_sale'] : '' ?>" placeholder="0" name="property_in_sale">
                            </label>

                            <label style="min-width: 180px; max-width: 180px" class="input-wrapper">
                                <input min="0" max="2" data-id="<?= $v['id'] ?>" data-type="int" class="input-send input-t" type="number" value="<?= !empty($v['transactions_for_contesting']) ? $v['transactions_for_contesting'] : '' ?>" placeholder="0" name="transactions_for_contesting">
                            </label>

                            <label style="min-width: 180px; max-width: 180px" class="input-wrapper">
                                <input min="0" max="2" data-id="<?= $v['id'] ?>" data-type="int" class="input-send input-t" type="number" value="<?= !empty($v['active_creditors']) ? $v['active_creditors'] : '' ?>" placeholder="0" name="active_creditors">
                            </label>
                            <?php
                            $iOP = !empty($v['inventory_of_property']) ? json_decode($v['inventory_of_property'], 1) : null;
                            if (!empty($iOP)) {
                                $value = $iOP['confirm'] === 1 ? 0 : 1;
                                $checked = $iOP['confirm'] === 1 ? 'checked' : '';
                                $background = $iOP['date'] < date('Y-m-d') && $iOP['confirm'] !== 1 ? 'red' : '#272b30';
                            }
                            ?>
                            <div style="min-width: 180px; max-width: 180px; background-color: <?= $background ?>" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'inventory_of_property',
                                    'value' => !empty($iOP['date']) ? date('Y-m-d', strtotime($iOP['date'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-t', 'disabled' => true],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                                <label class="custom-checkbox-label">
                                    <input <?= $checked ?> type="checkbox" class="input-send input-hide input-checkbox" name="confirm_inventory_of_property" value="<?= $value ?>" data-id="<?= $v['id'] ?>" data-type="int">
                                    <div class="custom-checkbox-wrapper">
                                        <div class="custom-checkbox">
                                            <div class="custom-checkbox-circle"></div>
                                        </div>
                                        <span>Выполнено</span>
                                    </div>
                                </label>
                            </div>

                            <?php
                            $iOP = !empty($v['deliberate_fictitious']) ? json_decode($v['deliberate_fictitious'], 1) : null;
                            if (!empty($iOP)) {
                                $value = $iOP['confirm'] === 1 ? 0 : 1;
                                $checked = $iOP['confirm'] === 1 ? 'checked' : '';
                                $background = $iOP['date'] < date('Y-m-d') && $iOP['confirm'] !== 1 ? 'red' : '#272b30';
                            }
                            ?>
                            <div style="min-width: 180px; max-width: 180px; background-color: <?= $background ?>" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'deliberate_fictitious',
                                    'value' => !empty($iOP['date']) ? date('Y-m-d', strtotime($iOP['date'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-t', 'disabled' => true],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                                <label class="custom-checkbox-label">
                                    <input <?= $checked ?> type="checkbox" class="input-send input-hide input-checkbox" name="confirm_deliberate_fictitious" value="<?= $value ?>" data-id="<?= $v['id'] ?>" data-type="int">
                                    <div class="custom-checkbox-wrapper">
                                        <div class="custom-checkbox">
                                            <div class="custom-checkbox-circle"></div>
                                        </div>
                                        <span>Выполнено</span>
                                    </div>
                                </label>
                            </div>
                            <?php
                            $iOP = !empty($v['assembly_of_creditors']) ? json_decode($v['assembly_of_creditors'], 1) : null;
                            if (!empty($iOP)) {
                                $value = $iOP['confirm'] === 1 ? 0 : 1;
                                $checked = $iOP['confirm'] === 1 ? 'checked' : '';
                                $background = $iOP['date'] < date('Y-m-d') && $iOP['confirm'] !== 1 ? 'red' : '#272b30';
                            }
                            ?>
                            <div style="min-width: 180px; max-width: 180px; background-color: <?= $background ?>" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'assembly_of_creditors',
                                    'value' => !empty($iOP['date']) ? date('Y-m-d', strtotime($iOP['date'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-t', 'disabled' => true],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                                <label class="custom-checkbox-label">
                                    <input <?= $checked ?> type="checkbox" class="input-send input-hide input-checkbox" name="confirm_assembly_of_creditors" value="<?= $value ?>" data-id="<?= $v['id'] ?>" data-type="int">
                                    <div class="custom-checkbox-wrapper">
                                        <div class="custom-checkbox">
                                            <div class="custom-checkbox-circle"></div>
                                        </div>
                                        <span>Выполнено</span>
                                    </div>
                                </label>
                            </div>

                            <label style="min-width: 195px; max-width: 195px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'sz_date_upon_completion',
                                    'value' => !empty($v['sz_date_upon_completion']) ? date('d-m-Y', strtotime($v['sz_date_upon_completion'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-send input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label class="input-wrapper">
                                <select class="chosen-select input-send" name="directed_to_sz" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['directed_to_sz'] === 'Продление' ? 'selected' : '' ?> value="Продление">Продление
                                    </option>
                                    <option <?= $v['directed_to_sz'] === 'Отложение' ? 'selected' : '' ?> value="Отложение">Отложение
                                    </option>
                                    <option <?= $v['directed_to_sz'] === 'Перерыв' ? 'selected' : '' ?> value="Перерыв">
                                        Перерыв
                                    </option>
                                    <option <?= $v['directed_to_sz'] === 'Переход в РИГ' ? 'selected' : '' ?> value="Переход в РИГ">Переход в РИГ
                                    </option>
                                    <option <?= $v['directed_to_sz'] === 'План' ? 'selected' : '' ?> value="План">План
                                    </option>
                                    <option <?= $v['directed_to_sz'] === 'Завершение' ? 'selected' : '' ?> value="Завершение">Завершение
                                    </option>
                                </select>
                            </label>

                            <label class="input-wrapper">
                                <select class="chosen-select input-send" name="verified_sent_sz" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['verified_sent_sz'] === 'Да' ? 'selected' : '' ?> value="Да">Да
                                    </option>
                                    <option <?= $v['verified_sent_sz'] === 'Нет' ? 'selected' : '' ?> value="Нет">Нет
                                    </option>
                                    <option <?= $v['verified_sent_sz'] === 'В работе' ? 'selected' : '' ?> value="В работе">В работе
                                    </option>
                                </select>
                            </label>

                            <label class="input-wrapper">
                                <select class="chosen-select input-send" data-id="<?= $v['id'] ?>" data-type="string" name="responsible_assistant">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($helpers)) : ?>
                                        <?php foreach ($helpers as $key => $val) : ?>
                                            <option <?= $v['responsible_assistant'] === $val['fio'] ? 'selected' : '' ?> value="<?= $val['fio'] ?>"><?= $val['fio'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>

                            <label class="input-wrapper">
                                <textarea data-id="<?= $v['id'] ?>" data-type="string" name="comment_case" class="input-t input-textarea input-send" placeholder="Коментарий..."><?= !empty($v['comment_case']) ? $v['comment_case'] : '' ?></textarea>
                            </label>

                            <button type="button" data-id="<?= $v['id'] ?>" class="delete__client">
                                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.073223 10.0585 -0.0732228 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.073223 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.073223 0.987437 -0.0732228 1.28033 0.21967L5.28553 4.22487Z" fill="red" />
                                </svg>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p style="text-align: center" class="inputs-group-name-text">Клиенты не найдены</p>
                <?php endif; ?>
            </div>
            <?= LinkPager::widget([
                'pagination' => $pagesC,
                'options' => ['class' => 'pager_link'],
                'linkOptions' => ['class' => 'pager_link-a'],
                'maxButtonCount' => 3,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
                'disableCurrentPageButton' => true,
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
        <button type="button" class="add__helper btn--orange">Добавить помощника</button>


        <div class="helper--set-card-back">
            <div class="helper--set-card">
                <p class="popup__error--title">Добавить помощника</p>
                <input class="input-t" type="text" placeholder="ФИО" name="helper__fio">
                <input class="input-t" type="tel" placeholder="+79481115555" name="helper__phone">
                <button class="add__helpers btn--orange">Подтвердить</button>
            </div>
        </div>
    </div>
</section>
<section class="tab tab5">
    <div class="container">
        <h1 class="tab-title">Снятие в банках</h1>
        <?php Pjax::begin(['id' => 'bank_withdrawals']) ?>
        <?php $jss = <<< JS
            $(".chosen-select").chosen({disable_search_threshold: 0});
JS;
        $this->registerJs($jss);
        ?>
        <div class="inputs-group-wrapper">
            <button class="scroll left">❮</button>
            <button class="scroll right">❯</button>

            <div class="inputs-group">
                <div class="inputs-group-row head__group">
                    <div style="min-width: 70px; max-width: 70px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('id', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="id" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">№</p>
                        </label>
                    </div>
                    <div class="inputs-group-name fixed__column">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('fio', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="fio" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">ФИО должника</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('ay', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="ay" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">АУ</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('partner', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="partner" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">Партнёр</p>
                        </label>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('status_affairs', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="status_affairs" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">Статус дела</p>
                        </label>
                    </div>
                    <div style="min-width: 195px; max-width: 195px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('withdrawal_order', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="withdrawal_order" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text" style="font-size: 14px;">Распоряжение на снятие</p>
                        </label>
                    </div>
                    <div style="min-width: 240px; max-width: 240px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('date_order_sent', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="date_order_sent" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text" style="font-size: 14px;">Дата отправки распоряжения</p>
                        </label>
                    </div>
                    <div style="min-width: 195px; max-width: 195px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('sz_date_upon_completion', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="sz_date_upon_completion" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">Дата СЗ по завершению</p>
                        </label>
                    </div>
                    <div style="min-width: 160px; max-width: 160px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Банки</p>
                    </div>
                    <div style="min-width: 215px; max-width: 215px" class="inputs-group-name sort__btn">
                        <p class="inputs-group-name-text">Реквизиты для ПМ</p>
                    </div>
                    <div style="min-width: 160px; max-width: 160px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Состав ПМ</p>
                    </div>
                    <div style="min-width: 215px; max-width: 215px" class="inputs-group-name sort__btn">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('pm_region_rf', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="pm_region_rf" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">ПМ по региону или РФ</p>
                        </label>
                    </div>
                    <div style="min-width: 160px; max-width: 160px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Доходы</p>
                    </div>
                    <div style="min-width: 160px; max-width: 160px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Снятия</p>
                    </div>
                    <div style="min-width: 215px; max-width: 215px" class="inputs-group-name sort__btn">
                        <p class="inputs-group-name-text">Перечисление ПМ</p>
                    </div>
                    <div style="min-width: 215px; max-width: 215px" class="inputs-group-name sort__btn">
                        <p class="inputs-group-name-text">Переведено из своих</p>
                    </div>
                    <div style="min-width: 240px; max-width: 240px" class="inputs-group-name">
                        <p class="inputs-group-name-text" style="font-size: 12px;">Конкурсная масса сформирована</p>
                    </div>
                    <div style="min-width: 300px; max-width: 300px" class="inputs-group-name">
                        <p class="inputs-group-name-text" style="font-size: 12px;">Конкурсная масса распределена</p>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('rest_debtor', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="rest_debtor" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">Остаток</p>
                        </label>
                    </div>
                    <div style="min-width: 300px; max-width: 300px" class="inputs-group-name">
                        <p class="inputs-group-name-text" style="font-size: 12px;">Остаток переведен Должнику</p>
                    </div>
                </div>
                <?php if (!empty($withdrawals)) : ?>
                    <?php foreach ($withdrawals as $k => $v) : ?>
                        <div class="inputs-group-row">
                            <label style="min-width: 70px" class="input-wrapper">
                                <p class="inputs-group-name-text">#<?= $v['id'] ?></p>
                            </label>

                            <label class="input-wrapper fixed__column">
                                <input data-type="string" data-id="<?= $v['id'] ?>" class="input-removing input-t" type="text" placeholder="Фио" value="<?= !empty($v['fio']) ? $v['fio'] : '' ?>" name="fio">
                            </label>

                            <label class="input-wrapper">
                                <select class="chosen-select input-removing" name="ay" data-id="<?= $v['id'] ?>" data-type="int">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($ay)) : ?>
                                        <?php foreach ($ay as $key => $val) : ?>
                                            <option <?= $v['ay'] === $val['id'] ? 'selected' : '' ?> value="<?= $val['id'] ?>"><?= $val['fio'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>

                            <label class="input-wrapper">
                                <select class="chosen-select input-removing" name="partner" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($partner)) : ?>
                                        <?php foreach ($partner as $key => $val) : ?>
                                            <option <?= $v['partner'] === $val['name'] ? 'selected' : '' ?> value="<?= $val['name'] ?>"><?= $val['name'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper">
                                <select class="chosen-select input-removing" name="status_affairs" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['status_affairs'] === 'Не признан' ? 'selected' : '' ?> value="Не признан">Не признан
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Признан' ? 'selected' : '' ?> value="Признан">
                                        Признан
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Завершено' ? 'selected' : '' ?> value="Завершено">Завершено
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Прекращено' ? 'selected' : '' ?> value="Прекращено">Прекращено
                                    </option>
                                </select>
                            </label>

                            <label style="min-width: 195px; max-width: 195px" class="input-wrapper">
                                <select class="chosen-select input-removing" name="withdrawal_order" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['withdrawal_order'] === 'Да' ? 'selected' : '' ?> value="Да">Да
                                    </option>
                                    <option <?= $v['withdrawal_order'] === 'Нет' ? 'selected' : '' ?> value="Нет">
                                        Нет
                                    </option>
                                </select>
                            </label>

                            <label style="min-width: 240px; max-width: 240px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'date_order_sent',
                                    'value' => !empty($v['date_order_sent']) ? date('d-m-Y', strtotime($v['date_order_sent'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-removing input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label style="min-width: 195px; max-width: 195px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'sz_date_upon_completion',
                                    'value' => !empty($v['sz_date_upon_completion']) ? date('d-m-Y', strtotime($v['sz_date_upon_completion'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-removing input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label style="min-width: 160px; max-width: 160px" class="input-wrapper">
                                <button data-id="<?= $v['id'] ?>" type="button" class="banks--sets link--btn">
                                    Редактировать
                                </button>
                            </label>

                            <label style="min-width: 215px; max-width: 215px" class="input-wrapper">
                                <button data-id="<?= $v['id'] ?>" type="button" class="requisites--set link--btn">
                                    Редактировать
                                </button>
                            </label>

                            <label style="min-width: 160px; max-width: 160px" class="input-wrapper">
                                <div class="family--set-card-back card-back">
                                    <div class="family--set-card card">
                                        <select class="chosen-select input-removing" name="family-satus" data-type="string" data-id="<?= $v['id'] ?>">
                                            <option disabled selected value="">Выберите вариант</option>
                                            <option value="В браке">В браке</option>
                                            <option value="Холост">Холост</option>
                                            <option value="В разводе">В разводе</option>
                                        </select>
                                        <div style="max-width: 100%; width: 100%; display: flex; gap: 20px; justify-content: space-between;">
                                            <div>
                                                <input style="margin-bottom: 12px;" class="input-case input-t input-removing" type="number" placeholder="Соц пособия" name="qwe" data-id="<?= $v['id'] ?>">
                                                <input class="input-case input-t" type="number" placeholder="ЕДВ" name=" qwe" data-id="<?= $v['id'] ?>">
                                            </div>
                                            <div>
                                                <input style="margin-bottom: 12px;" class="input-case input-t input-removing" type="number" placeholder="Дети" name="kids-count" data-id="<?= $v['id'] ?>">
                                                <input class="input-case input-t" type="number" placeholder="Исключено по суду" name="qwe" data-id="<?= $v['id'] ?>">
                                            </div>
                                        </div>

                                        <button class="btn--orange">Подтвердить</button>
                                    </div>
                                </div>

                                <button type="button" class="family--set link--btn">Редактировать</button>
                            </label>

                            <label style="min-width: 215px; max-width: 215px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-removing additiondl_calc input-t" type="number" placeholder="25000" value="<?= !empty($v['pm_region_rf']) ? $v['pm_region_rf'] : '' ?>" name="pm_region_rf">
                            </label>

                            <label style="min-width: 160px; max-width: 160px" class="input-wrapper">
                                <button data-id="<?= $v['id'] ?>" type="button" class="incomes--set link--btn">
                                    Редактировать
                                </button>
                            </label>

                            <?php
                            $w = AspbWithdrawalRegister::find()->asArray()->where(['id_removing' => $v['id']])->all();
                            $removing_all = 0;
                            $transfer_pm = 0;
                            $from_their = 0;
                            foreach ($w as $value) {
                                $removing_all += $value['withdrawal_summ'];
                                $transfer_pm += $value['pm_debtor'];
                                $from_their += $value['from_their'];
                            }
                            ?>
                            <label style="min-width: 160px; max-width: 160px" class="input-wrapper">
                                <input disabled data-id="<?= $v['id'] ?>" data-type="int" class="input-removing input-t" type="number" value="<?= $removing_all ?>" name="removing_all">
                            </label>
                            <label style="min-width: 215px; max-width: 215px" class="input-wrapper">
                                <input disabled data-id="<?= $v['id'] ?>" data-type="int" class="input-removing input-t" type="number" value="<?= $transfer_pm ?>" name="transfer_pm">
                            </label>

                            <label style="min-width: 215px; max-width: 215px" class="input-wrapper">
                                <input disabled data-id="<?= $v['id'] ?>" data-type="int" class="input-removing input-t" type="number" value="<?= $from_their ?>" name="translated_from_their_own">
                            </label>

                            <label style="min-width: 240px; max-width: 240px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-removing input-t" type="number" value="<?= !empty($v['competitive_mass_formed']) ? $v['competitive_mass_formed'] : '' ?>" name="competitive_mass_formed">
                            </label>

                            <div style="min-width: 300px; max-width: 300px; box-sizing: border-box" class="input-wrapper">
                                <?php $arr = json_decode($v['bankruptcy_estate_distributed'], 1) ?>
                                <div class="dop-docs">
                                    <?php $date = json_decode($v['additional_documents'], 1) ?>
                                    <label class="dop-docs-label">
                                        Сумма
                                        <input data-id="<?= $v['id'] ?>" data-type="int" class="input-t" type="number" placeholder="1000" value="<?= !empty($arr['summ']) ? $arr['summ'] : 0 ?>" id="konk-mass-<?= $v['id'] ?>">
                                    </label>
                                    <label class="dop-docs-label">
                                        Cтатус
                                        <select class="chosen-select input-konk" id="konk-date-<?= $v['id'] ?>" data-id="<?= $v['id'] ?>" data-type="string">
                                            <option <?= $arr['date'] === 'Да' ? 'selected' : '' ?> value="Да">
                                                Да
                                            </option>
                                            <option <?= empty($arr['date']) || $arr['date'] === 'Нет' ? 'selected' : '' ?> value="Нет">
                                                Нет
                                            </option>
                                        </select>
                                    </label>
                                </div>
                            </div>

                            <label style="min-width: 170px; max-width: 170px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-removing input-t" type="number" placeholder="1000" value="<?= !empty($v['rest_debtor']) ? $v['rest_debtor'] : '' ?>" name="rest_debtor">
                            </label>

                            <div style="min-width: 300px; max-width: 300px; box-sizing: border-box" class="input-wrapper">
                                <?php $arr = json_decode($v['rest_transferred_debtor'], 1) ?>
                                <div class="dop-docs">
                                    <label class="dop-docs-label">
                                        Cумма
                                        <input data-id="<?= $v['id'] ?>" data-type="string" class="rest-send input-t" type="number" placeholder="1000" value="<?= !empty($arr['summ']) ? $arr['summ'] : '' ?>" id="rest-summ-<?= $v['id'] ?>">
                                    </label>
                                    <label class="dop-docs-label">
                                        Дата перевода
                                        <?= DatePicker::widget([
                                            'value' => !empty($arr['date']) ? date('d-m-Y', strtotime($arr['date'])) : date('Y-m-d'),
                                            'options' => ['class' => 'rest-send input-t', 'data-id' => $v['id'], 'data-type' => 'string', 'id' => "rest-date-{$v['id']}"],
                                            'language' => 'ru',
                                            'dateFormat' => 'dd-MM-yyyy',
                                        ]); ?>
                                    </label>
                                </div>
                            </div>

                            <button type="button" data-id="<?= $v['id'] ?>" class="delete__remove">
                                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.073223 10.0585 -0.0732228 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.073223 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.073223 0.987437 -0.0732228 1.28033 0.21967L5.28553 4.22487Z" fill="red" />
                                </svg>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p style="text-align: center" class="inputs-group-name-text">Клиенты не найдены</p>
                <?php endif; ?>
            </div>
            <?= LinkPager::widget([
                'pagination' => $pagesW,
                'options' => ['class' => 'pager_link'],
                'linkOptions' => ['class' => 'pager_link-a'],
                'maxButtonCount' => 3,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
                'disableCurrentPageButton' => true,
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
        <div class="button__group">
            <button type="button" class="add__remove btn--orange">Добавить клиента</button>
        </div>
        <div class="remove--set-card-back">
            <div class="remove--set-card">
                <p class="popup__error--title">Добавить клиента</p>
                <select class="chosen-select" name="removes__add" data-id="<?= $v['id'] ?>" data-type="string">
                    <option disabled selected value="">Выберите вариант</option>
                    <?php if (!empty($arrClient)) : ?>
                        <?php foreach ($arrClient as $key => $val) : ?>
                            <option value="<?= $key ?>"><?= $val ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <button class="add__remove-send btn--orange">Подтвердить</button>
            </div>
        </div>
    </div>
</section>
<section class="tab tab6">
    <div class="container">
        <h1 class="tab-title">Реестр снятий</h1>
        <?php Pjax::begin(['id' => 'withdrawal_register']) ?>
        <?php $jss = <<< JS
            $(".chosen-select").chosen({disable_search_threshold: 0});
JS;
        $this->registerJs($jss);
        ?>
        <div class="inputs-group-wrapper">
            <button class="scroll left">❮</button>
            <button class="scroll right">❯</button>

            <div class="inputs-group">
                <div class="inputs-group-row head__group">
                    <div style="min-width: 70px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['chec']) && in_array('id', $_POST['chec']) ? 'checked' : '' ?> type="checkbox" value="id" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="chec[]">
                            <p class="inputs-group-name-text">№</p>
                        </label>
                    </div>
                    <div class="inputs-group-name fixed__column">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['chec']) && in_array('fio', $_POST['chec']) ? 'checked' : '' ?> type="checkbox" value="fio" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="chec[]">
                            <p class="inputs-group-name-text">ФИО должника</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['chec']) && in_array('withdrawal_date', $_POST['chec']) ? 'checked' : '' ?> type="checkbox" value="withdrawal_date" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="chec[]">
                            <p class="inputs-group-name-text">Дата снятия</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['chec']) && in_array('withdrawal_summ', $_POST['chec']) ? 'checked' : '' ?> type="checkbox" value="withdrawal_summ" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="chec[]">
                            <p class="inputs-group-name-text">Сумма снятия</p>
                        </label>
                    </div>
                    <div style="min-width: 170px; max-width: 170px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['chec']) && in_array('pm_debtor', $_POST['chec']) ? 'checked' : '' ?> type="checkbox" value="pm_debtor" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="chec[]">
                            <p class="inputs-group-name-text">ПМ должнику</p>
                        </label>
                    </div>
                    <div style="min-width: 200px; max-width: 200px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['chec']) && in_array('rest_km_withdrawal', $_POST['chec']) ? 'checked' : '' ?> type="checkbox" value="rest_km_withdrawal" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="chec[]">
                            <p class="inputs-group-name-text">Остаток в КМ со снятия </p>
                        </label>
                    </div>
                    <div style="min-width: 140px; max-width: 140px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['chec']) && in_array('from_their', $_POST['chec']) ? 'checked' : '' ?> type="checkbox" value="from_their" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="chec[]">
                            <p class="inputs-group-name-text">Из своих</p>
                        </label>
                    </div>
                    <div style="min-width: 215px; max-width: 215px" class="inputs-group-name sort__btn">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['chec']) && in_array('transfer_status', $_POST['chec']) ? 'checked' : '' ?> type="checkbox" value="transfer_status" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="chec[]">
                            <p class="inputs-group-name-text">Статус перевода</p>
                        </label>
                    </div>
                    <div style="min-width: 215px; max-width: 215px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Реквизиты 3-го лица</p>
                    </div>
                    <div style="min-width: 160px; max-width: 160px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['chec']) && in_array('date_transfer', $_POST['chec']) ? 'checked' : '' ?> type="checkbox" value="date_transfer" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="chec[]">
                            <p class="inputs-group-name-text">Дата перевода</p>
                        </label>
                    </div>
                    <div style="min-width: 160px; max-width: 160px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Банк</p>
                    </div>
                    <div style="min-width: 215px; max-width: 215px" class="inputs-group-name">
                        <p class="inputs-group-name-text">Комментарий</p>
                    </div>
                    <div style="min-width: 215px; max-width: 215px" class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['chec']) && in_array('withdrawal_status', $_POST['chec']) ? 'checked' : '' ?> type="checkbox" value="withdrawal_status" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="chec[]">
                            <p class="inputs-group-name-text">Статус снятия</p>
                        </label>
                    </div>
                </div>
                <?php if (!empty($withdrawal_register)) : ?>
                    <?php foreach ($withdrawal_register as $k => $v) : ?>
                        <div class="inputs-group-row" style="background-color: <?= $v['from_their'] > 0 ? 'orange' : 0 ?>">
                            <label style="min-width: 70px" class="input-wrapper">
                                <p class="inputs-group-name-text">#<?= $v['id'] ?></p>
                            </label>

                            <label class="input-wrapper fixed__column">
                                <input data-type="string" data-id="<?= $v['id'] ?>" class="input-removing input-t" type="text" placeholder="Фио" value="<?= !empty($v['fio']) ? $v['fio'] : '' ?>" name="fio">
                            </label>

                            <label class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'withdrawal_date',
                                    'value' => !empty($v['withdrawal_date']) ? date('d-m-Y', strtotime($v['withdrawal_date'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-removing input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-removing input-t" type="number" value="<?= !empty($v['withdrawal_summ']) ? $v['withdrawal_summ'] : '' ?>" name="withdrawal_summ">
                            </label>

                            <?php
                            switch ($v['transfer_status']) {
                                case AspbWithdrawalRegister::STATUS_AGREEMENT:
                                    $color = '#00a0fc';
                                    break;
                                case AspbWithdrawalRegister::STATUS_CONFIRMED:
                                    $color = '#5d00fc';
                                    break;
                                case AspbWithdrawalRegister::STATUS_PROBLEM:
                                    $color = '#fc0000';
                                    break;
                                case AspbWithdrawalRegister::STATUS_TRANSFERRED:
                                    $color = '#fce300';
                                    break;
                                default:
                                    $color = '';
                            }
                            ?>
                            <label style="min-width: 170px; max-width: 170px; background-color: <?= $color ?>" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-removing pb-deb input-t" placeholder="1000" type="number" value="<?= !empty($v['pm_debtor']) ? $v['pm_debtor'] : '' ?>" name="pm_debtor">
                            </label>

                            <label style="min-width: 200px; max-width: 200px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-removing input-t" placeholder="1000" type="number" value="<?= !empty($v['rest_km_withdrawal']) ? $v['rest_km_withdrawal'] : '' ?>" name="rest_km_withdrawal">
                            </label>

                            <label style="min-width: 140px; max-width: 140px" class="input-wrapper">
                                <input data-id="<?= $v['id'] ?>" data-type="int" class="input-removing input-t" type="number" value="<?= !empty($v['from_their']) ? $v['from_their'] : '' ?>" name="from_their">
                            </label>

                            <label style="min-width: 215px; max-width: 215px" class="input-wrapper">
                                <select <?= !empty($v['pm_debtor']) ? '' : 'disabled' ?> class="chosen-select input-removing" name="transfer_status" data-id="<?= $v['id'] ?>" id="pm-deb-<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['transfer_status'] === 'На согласовании у АУ' ? 'selected' : '' ?> value="На согласовании у АУ">На согласовании у АУ
                                    </option>
                                    <option <?= $v['transfer_status'] === 'Согласован' ? 'selected' : '' ?> value="Согласован">
                                        Согласован
                                    </option>
                                    <option <?= $v['transfer_status'] === 'Переведено' ? 'selected' : '' ?> value="Переведено">Переведено
                                    </option>
                                    <option <?= $v['transfer_status'] === 'Проблема' ? 'selected' : '' ?> value="Проблема">Проблема
                                    </option>
                                </select>
                            </label>

                            <label style="min-width: 215px; max-width: 215px" class="input-wrapper">
                                <button data-id="<?= $v['id'] ?>" type="button" class="requisites--set link--btn">
                                    Показать
                                </button>
                            </label>

                            <label style="min-width: 160px; max-width: 160px" class="input-wrapper">
                                <?= DatePicker::widget([
                                    'name' => 'date_transfer',
                                    'value' => !empty($v['date_transfer']) ? date('d-m-Y', strtotime($v['date_transfer'])) : date('Y-m-d'),
                                    'options' => ['class' => 'input-removing input-t', 'data-id' => $v['id'], 'data-type' => 'date'],
                                    'language' => 'ru',
                                    'dateFormat' => 'dd-MM-yyyy',
                                ]); ?>
                            </label>

                            <label style="min-width: 160px; max-width: 160px" class="input-wrapper">
                                <button data-id="<?= $v['id'] ?>" type="button" class="banks--sets link--btn">
                                    Показать
                                </button>
                            </label>

                            <label style="min-width: 215px; max-width: 215px" class="input-wrapper">
                                <textarea data-id="<?= $v['id'] ?>" data-type="string" name="comments" class="input-t input-textarea input-removing" placeholder="Коментарий..."><?= !empty($v['comments']) ? $v['comments'] : '' ?></textarea>
                            </label>


                            <label style="min-width: 215px; max-width: 215px" class="input-wrapper">
                                <select class="chosen-select input-removing" name="withdrawal_status" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['withdrawal_status'] === 'КМ' ? 'selected' : '' ?> value="КМ">КМ
                                    </option>
                                    <option <?= $v['withdrawal_status'] === 'Внесение' ? 'selected' : '' ?> value="Внесение">
                                        Внесение
                                    </option>
                                    <option <?= $v['withdrawal_status'] === 'Наличными в кассу' ? 'selected' : '' ?> value="Наличными в кассу">Наличными в кассу
                                    </option>
                                </select>
                            </label>

                            <button type="button" data-id="<?= $v['id'] ?>" class="delete__withdrawals">
                                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.073223 10.0585 -0.0732228 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.073223 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.073223 0.987437 -0.0732228 1.28033 0.21967L5.28553 4.22487Z" fill="red" />
                                </svg>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p style="text-align: center" class="inputs-group-name-text">Клиенты не найдены</p>
                <?php endif; ?>
            </div>
            <?= LinkPager::widget([
                'pagination' => $pagesR,
                'options' => ['class' => 'pager_link'],
                'linkOptions' => ['class' => 'pager_link-a'],
                'maxButtonCount' => 3,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
                'disableCurrentPageButton' => true,
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
        <div class="button__group">
            <button type="button" class="add__withdrawals btn--orange">Добавить снятие</button>
        </div>
        <div class="withdrawals--set-card-back card-back">
            <div class="withdrawals--set-card card">
                <p class="popup__error--title">Добавить снятие</p>
                <select class="chosen-select" name="withdrawals__add" data-id="<?= $v['id'] ?>" data-type="string">
                    <option disabled selected value="">Выберите вариант</option>
                    <?php if (!empty($arrWithdrawals)) : ?>
                        <?php foreach ($arrWithdrawals as $key => $val) : ?>
                            <option value="<?= $key ?>"><?= $val ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
                <button class="add__withdrawals-send btn--orange">Подтвердить</button>
            </div>
        </div>
    </div>
</section>
<section class="tab tab7">
    <div class="container">
        <h1 class="tab-title">Должники и снятия</h1>
        <?php Pjax::begin(['id' => 'debt_with']) ?>
        <?php $jss = <<< JS
            $(".chosen-select").chosen({disable_search_threshold: 0});
JS;
        $this->registerJs($jss);
        ?>
        <div class="inputs-group-wrapper">
            <button class="scroll left">❮</button>
            <button class="scroll right">❯</button>

            <div class="inputs-group">
                <div class="inputs-group-row head__group">
                    <div style="min-width: 70px; max-width: 70px" class="inputs-group-name sort__btn">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('id', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="id" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">№</p>
                        </label>
                    </div>
                    <div class="inputs-group-name fixed__column">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('fio', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="fio" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">ФИО должника</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('ay', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="ay" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">АУ</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('number_affairs', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="number_affairs" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">Номер дела</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('partner', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="partner" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">Партнёр</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <label class="group-name-label">
                            <input <?= !empty($_POST['checks']) && in_array('status_affairs', $_POST['checks']) ? 'checked' : '' ?> type="checkbox" value="status_affairs" class="input-hide input-checkbox sort__btn" form="aspb_searchform" name="checks[]">
                            <p class="inputs-group-name-text">Статус дела</p>
                        </label>
                    </div>
                    <div class="inputs-group-name">
                        <p class="inputs-group-name-text">Долг</p>
                    </div>
                    <div class="inputs-group-name">
                        <p class="inputs-group-name-text">Месяц снятия</p>
                    </div>
                    <div class="inputs-group-name">
                        <p class="inputs-group-name-text">Снято средств</p>
                    </div>
                    <div class="inputs-group-name">
                        <p class="inputs-group-name-text">ПМ должнику</p>
                    </div>
                    <div class="inputs-group-name">
                        <p class="inputs-group-name-text">Остаток в КМ со снятия</p>
                    </div>
                    <div class="inputs-group-name">
                        <p class="inputs-group-name-text">Карточка клиента</p>
                    </div>
                </div>
                <?php if (!empty($withdrawals)) : ?>
                    <?php foreach ($withdrawals as $k => $v) : ?>
                        <div class="inputs-group-row">
                            <label style="min-width: 70px" class="input-wrapper">
                                <p class="inputs-group-name-text"><?= $v['id'] ?></p>
                            </label>

                            <label class="input-wrapper fixed__column">
                                <input data-type="string" data-id="<?= $v['id'] ?>" class="input-send input-t" type="text" placeholder="Фио" value="<?= !empty($v['fio']) ? $v['fio'] : '' ?>" name="fio">
                            </label>

                            <label class="input-wrapper">
                                <select class="chosen-select input-send" name="ay" data-id="<?= $v['id'] ?>" data-type="int">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($ay)) : ?>
                                        <?php foreach ($ay as $key => $val) : ?>
                                            <option <?= $v['ay'] === $val['id'] ? 'selected' : '' ?> value="<?= $val['id'] ?>"><?= $val['fio'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>

                            <div class="input-wrapper">
                                <?php $href = json_decode($v['number_affairs'], 1) ?>
                                <a data-type="string" data-id="<?= $v['id'] ?>" data-name="number_affairs" target="_blank" href="<?= Url::to($href['link']) ?>" class="case-link"><?= !empty($href['number']) ? $href['number'] : 'Не указано' ?></a>
                            </div>

                            <label class="input-wrapper">
                                <select class="chosen-select input-send" name="partner" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <?php if (!empty($partner)) : ?>
                                        <?php foreach ($partner as $key => $val) : ?>
                                            <option <?= $v['partner'] === $val['name'] ? 'selected' : '' ?> value="<?= $val['name'] ?>"><?= $val['name'] ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </label>

                            <label class="input-wrapper">
                                <select class="chosen-select input-send" name="status_affairs" data-id="<?= $v['id'] ?>" data-type="string">
                                    <option disabled selected value="">Выберите вариант</option>
                                    <option <?= $v['status_affairs'] === 'Не признан' ? 'selected' : '' ?> value="Не признан">Не признан
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Признан' ? 'selected' : '' ?> value="Признан">
                                        Признан
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Завершено' ? 'selected' : '' ?> value="Завершено">Завершено
                                    </option>
                                    <option <?= $v['status_affairs'] === 'Прекращено' ? 'selected' : '' ?> value="Прекращено">Прекращено
                                    </option>
                                </select>
                            </label>

                            <label class="input-wrapper">
                                <input <?= $v['debt'] > 0 ? '' : 'disabled' ?> data-id="<?= $v['id'] ?>" data-type="int" class="input-send input-t" type="number" placeholder="0" value="<?= !empty($v['debt']) ? $v['debt'] : '' ?>" name="debt">
                            </label>

                            <label class="input-wrapper">
                                <?php $with = AspbWithdrawalRegister::find()->asArray()
                                    ->where("MONTH(`withdrawal_date`) = MONTH(NOW()) AND YEAR(`withdrawal_date`) = YEAR(NOW())")->select('withdrawal_date, withdrawal_summ, pm_debtor, rest_km_withdrawal')->all() ?>
                                <div style="display: flex; flex-wrap: wrap; gap: 10px">
                                    <?php
                                    $withSumm = 0;
                                    $withPm = 0;
                                    $withKm = 0;
                                    foreach ($with as $vals) {
                                        $withSumm += $vals['withdrawal_summ'];
                                        $withPm += $vals['pm_debtor'];
                                        $withKm += $vals['rest_km_withdrawal'];
                                        echo '<p style="font-size: 12px;">' . date('d.m.Y', strtotime($vals['withdrawal_date'])) . ';</p>';
                                    } ?>
                                </div>
                            </label>

                            <label class="input-wrapper">
                                <input disabled class="input-send input-t" value="<?= $withSumm ?>">
                            </label>
                            <label class="input-wrapper">
                                <input disabled class="input-send input-t" value="<?= $withPm ?>">
                            </label>
                            <label class="input-wrapper">
                                <input disabled class="input-send input-t" value="<?= $withKm ?>">
                            </label>

                            <label class="input-wrapper">
                                <a data-pjax="0" href="<?= Url::to(['client', 'id' => $v['client_id']]) ?>" class="btn--orange">Посмотреть карточку клиента</a>
                            </label>

                            <button type="button" data-id="<?= $v['id'] ?>" class="delete__remove">
                                <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.28553 4.22487L9.29074 0.21967C9.58363 -0.0732233 10.0585 -0.0732233 10.3514 0.21967C10.6443 0.512563 10.6443 0.987437 10.3514 1.28033L6.34619 5.28553L10.3514 9.29074C10.6443 9.58363 10.6443 10.0585 10.3514 10.3514C10.0585 10.6443 9.58363 10.6443 9.29074 10.3514L5.28553 6.34619L1.28033 10.3514C0.987437 10.6443 0.512563 10.6443 0.21967 10.3514C-0.073223 10.0585 -0.0732228 9.58363 0.21967 9.29074L4.22487 5.28553L0.21967 1.28033C-0.073223 0.987437 -0.0732233 0.512563 0.21967 0.21967C0.512563 -0.073223 0.987437 -0.0732228 1.28033 0.21967L5.28553 4.22487Z" fill="red" />
                                </svg>
                            </button>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <p style="text-align: center" class="inputs-group-name-text">Клиенты не найдены</p>
                <?php endif; ?>
            </div>
            <?= LinkPager::widget([
                'pagination' => $pagesW,
                'options' => ['class' => 'pager_link'],
                'linkOptions' => ['class' => 'pager_link-a'],
                'maxButtonCount' => 3,
                'firstPageLabel' => true,
                'lastPageLabel' => true,
                'disableCurrentPageButton' => true,
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
        <div class="button__group">
            <!--            <button type="button" class="add__client btn--orange">Добавить клиента</button>-->
        </div>
    </div>

    <div class="case--set-card-back">
        <div class="case--set-card">
            <input class="input-case input-t" type="text" placeholder="Номер дела" name="case-number">
            <input class="input-case input-t" type="text" placeholder="Ссылка на дело" name="case-link">
            <button class="confirm--case btn--orange">Подтвердить</button>
        </div>
    </div>
</section>
<section style="display: block" class="tab">
    <div class="case--diff-card-back">
        <div class="case--diff-card">
            <div class="select-group">
                <div class="select-wrapp">
                    Доход
                    <select class="chosen-select input-send" name="income" data-id="<?= $v['id'] ?>" data-type="int">
                        <option>Выберите вариант</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div class="select-wrapp">
                    Имущество в реализацию
                    <select class="chosen-select input-send" name="property_in_sale" data-id="<?= $v['id'] ?>" data-type="int">
                        <option>Выберите вариант</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div class="select-wrapp">
                    Сделки под оспаривание
                    <select class="chosen-select input-send" name="transactions_for_contesting" data-id="<?= $v['id'] ?>" data-type="int">
                        <option>Выберите вариант</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
                <div class="select-wrapp">
                    Активные кредиторы
                    <select class="chosen-select input-send" name="active_creditors" data-id="<?= $v['id'] ?>" data-type="int">
                        <option>Выберите вариант</option>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                    </select>
                </div>
            </div>
            <button class="confirm--diff-case btn--orange">Подтвердить</button>
        </div>
    </div>
    <div class="banks--set-card-back card-back">
        <div class="banks--set-card sets__banks card">

        </div>
    </div>
</section>