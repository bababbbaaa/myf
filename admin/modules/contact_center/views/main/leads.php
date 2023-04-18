<?php

/**
 * @var $this \yii\web\View
 */

use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
use yii\jui\DatePicker;
use common\models\UserModel;

$this->title = 'Лиды КЦ';
$this->params['breadcrumbs'][] = [
    'label' => "КЦ",
    'url' => 'index'
];
$this->params['breadcrumbs'][] = $this->title;
$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

$sources = \common\models\LeadsSources::find()->where(['cc' => 1])->asArray()->all();

$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 0});
var btn = $('.saveBtn');
btn.on('click', function() {
    var 
        id = $(this).attr('data-id'),
        thisBtn = $(this),
        elems = $('[data-id="' + id + '"]'),
        data = elems.serialize();
    $.ajax({
        data: data,
        type: "POST",
        dataType: "JSON",
        url: "save-cc-lead"
    }).done(function(rsp) {
        if (rsp.status === 'success') {
            Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Сохранен',
              showConfirmButton: false,
              timer: 1500,
              backdrop: false,
              allowOutsideClick: false
            });
            if (rsp.block) {
                thisBtn.remove();
                $('[data-response-id="'+ id +'"]')
                    .css('background-color', rsp.color)
                    .toggleClass(rsp.class);
                $('[data-response-id="'+ id +'"] input').prop('disabled', true);
                $('[data-response-id="'+ id +'"] select').prop('disabled', true);
                $('[data-response-id="'+ id +'"] .chosen-select').trigger('chosen:updated');
            }
        } else {
            Swal.fire({
              icon: 'error',
              title: 'Ошибка',
              text: rsp.message,
            });
        }
    });
});
$('.change-my-status-cc').on('click', function() {
    var 
        btn = $(this),
        id = btn.attr('data-id'),
        hash = btn.attr('data-hash');
    $.ajax({
        data: {id: id, hash: hash},
        dataType: "JSON",
        type: "POST",
        url: "change-cc-status"
    }).done(function(rsp) {
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
$('.clear-select').on('click', function(e) {
    e.preventDefault();
    var 
        type = $(this).attr('data-type'),
        id = $(this).attr('data-id'),
        text = type === 'region' ? 'регион' : 'город',
        input = $('[name="serialize['+type+']"][data-id="'+ id +'"]');
    if (!input.prop('disabled')) {
        input.html('<option value="">Указать '+ text +'</option>');
        $('.chosen-select').trigger('chosen:updated');
    }
});
JS;
$this->registerJsFile(Url::to(['/js/getRegionAjax_cc.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJsFile(Url::to(['/js/getCityAjax_cc.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);
?>

<style>
    .flex-category {
        margin: 0 10px 10px 0;
        border-radius: 4px;
        padding: 5px 20px;
        background-color: #303030;
        color: white;
        cursor: pointer;
        transition: 0.3s ease;
        border: 1px solid black;
    }
    .flex-category:hover, .flex-checked, .flex-category:focus{
        background-color: whitesmoke;
        color: #303030;
        text-decoration: unset;
    }
    .flex-div-lead-element{
        border-radius: 10px;
        box-shadow: 1px 1px 6px #efefef;
        margin-bottom: 30px;
        padding: 10px;
        border: 1px solid #eaeaea;
        display: flex;
        flex-wrap: wrap;
        flex-direction: column;
        transition: 0.3s ease;
    }

    .flex-div-lead-element:hover{
        box-shadow: 1px 1px 6px #b7b7b7;
    }

    .flex-div-lead-element > div {
        display: flex;
        flex-wrap: wrap;
    }
    .flex-div-lead-element > div.first {
        justify-content: space-between;
    }
    .flex-div-lead-element > div > div {
        margin: 10px 10px;
    }
    .success-lead-cc input, .success-lead-cc select, .success-lead-cc .chosen-container, .success-lead-cc .chosen-container-single .chosen-single {
        background: rgb(242 255 229) !important;
    }
    .waste-lead-cc input, .waste-lead-cc select, .waste-lead-cc .chosen-container, .waste-lead-cc .chosen-container-single .chosen-single {
        background:rgb(253 225 225) !important;
    }
</style>
<?php $tStatuses = \common\models\CcLeads::$tmpStatuses; ?>
<?php $fStatuses = \common\models\CcLeads::$endStatus; ?>
<?php

function getBkColor($status, $type, $anketa) {
    if (in_array($status, \common\models\CcLeads::$succeedStatuses)) {
        if ($type !== 'audit' && $anketa === 0)
            return "#fbfff7";
        else
            return "#feffd9";
    }
    elseif (in_array($status, \common\models\CcLeads::$wasteStatuses))
        return "#fff7f7";
    else
        return 'white';
}

function getClass($status) {
    if (in_array($status, \common\models\CcLeads::$succeedStatuses))
        return "success-lead-cc";
    elseif (in_array($status, \common\models\CcLeads::$wasteStatuses))
        return "waste-lead-cc";
    else
        return '';
}

function isDisabled($status) {
    if (!empty($status))
        return 'disabled';
    else
        return '';
}
$me = UserModel::find()->where(['id' => Yii::$app->getUser()->getId()])->asArray()->one();
$myRole = Yii::$app->authManager->getRolesByUser($me['id']);
?>
<style>
    .flex-filter {
        display: flex; flex-wrap: wrap; align-items: flex-end;
    }
    .flex-filter > div {
        margin-bottom: 10px; margin-right: 5px;
    }
</style>
<div class="monospace">
    <h1 class="admin-h1">Лиды КЦ</h1>
    <?php if(isset($myRole['cc'])): ?>
        <hr>
        <div><b>Мой статус:</b> <span style="color: <?= (int)$me['cc_status'] === UserModel::STATUS_SLEEP ? 'red' : 'green' ?>; font-weight: 700"><?= UserModel::$statusText[$me['cc_status']] ?></span></div>
        <div style="margin-top: 10px">
            <div data-id="<?= $me['id'] ?>" data-hash="<?= md5("{$me['id']}::change_token_suppress") ?>" class="btn change-my-status-cc <?= (int)$me['cc_status'] === UserModel::STATUS_SLEEP ? 'btn-admin-delete' : 'btn-admin' ?>"><?= (int)$me['cc_status'] === UserModel::STATUS_SLEEP ? 'Начать рабочий день' : 'Закончить рабочий день' ?></div>
        </div>
        <hr>
    <?php endif; ?>
    <?php if(!empty($categories)): ?>
        <div style="display: flex; flex-wrap: wrap; margin: 15px 0 10px;">
            <?php foreach($categories as $item): ?>
                <a href="leads?type=<?= $item['link_name'] ?>" class="flex-category <?= !empty($_GET['type']) && $_GET['type'] === $item['link_name'] ? 'flex-checked' : '' ?>">
                    <?= $item['name'] ?>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <hr>
    <div style="">
        <b>Всего лидов: <?= !empty($totalCount) ? number_format($totalCount, 0, '', ' ') : 0 ?>.</b>
         Показаны <?= empty($_GET['page']) || $_GET['page'] == 1 ? '1 - 25' : (($_GET['page'] - 1) * 25 + 1) . " - " . ($_GET['page']*25) ?>
    </div>
    <hr>
    <?= \yii\helpers\Html::beginForm('leads?type=' . $_GET['type'], 'GET') ?>
    <div>
        <p><b>Фильтры</b></p>
        <div class="flex-filter">
            <div>
                <p style="margin-bottom: 5px"><b>ID</b></p>
                <div><input type="text" class="form-control" placeholder="6312" name="filter[id]" value="<?= !empty($_GET['filter']['id']) ? $_GET['filter']['id'] : '' ?>"></div>
            </div>
            <div>
                <p style="margin-bottom: 5px"><b>Источник</b></p>
                <div><input type="text" class="form-control" placeholder="Обзвон" name="filter[source]" value="<?= !empty($_GET['filter']['source']) ? $_GET['filter']['source'] : '' ?>"></div>
            </div>
            <div>
                <p style="margin-bottom: 5px"><b>UTM</b></p>
                <div><input type="text" class="form-control" placeholder="MSK" name="filter[utm_source]" value="<?= !empty($_GET['filter']['utm_source']) ? $_GET['filter']['utm_source'] : '' ?>"></div>
            </div>
            <div>
                <p style="margin-bottom: 5px"><b>Регион</b></p>
                <div><input type="text" class="form-control" placeholder="Москва" name="filter[region]" value="<?= !empty($_GET['filter']['region']) ? $_GET['filter']['region'] : '' ?>"></div>
            </div>
            <div>
                <p style="margin-bottom: 5px"><b>Телефон</b></p>
                <div><input type="text" class="form-control" placeholder="7918" name="filter[phone]" value="<?= !empty($_GET['filter']['phone']) ? $_GET['filter']['phone'] : '' ?>"></div>
            </div>
            <div>
                <p style="margin-bottom: 5px"><b>Промежуточный статус</b></p>
                <div><select class="form-control" name="filter[status_temp]" >
                        <option value="">Выбрать статус...</option>
                        <?php foreach($tStatuses as $tSt): ?>
                            <option <?= !empty($_GET['filter']['status_temp']) && $_GET['filter']['status_temp'] === $tSt ? 'selected' : '' ?> value="<?= $tSt ?>"><?= mb_convert_case($tSt, MB_CASE_TITLE) ?></option>
                        <?php endforeach; ?>
                    </select></div>
            </div>
            <div>
                <p style="margin-bottom: 5px"><b>Финальный статус</b></p>
                <div><select class="form-control" name="filter[status]" >
                        <option value="">Выбрать статус...</option>
                        <?php foreach($fStatuses as $tSt): ?>
                            <option <?= !empty($_GET['filter']['status']) && $_GET['filter']['status'] === $tSt ? 'selected' : '' ?> value="<?= $tSt ?>"><?= mb_convert_case($tSt, MB_CASE_TITLE) ?></option>
                        <?php endforeach; ?>
                    </select></div>
            </div>
        </div>
        <div class="flex-filter">
            <div>
                <p style="margin-bottom: 5px"><b>Начиная с даты</b></p>
                <div>
                    <?php
                    echo DatePicker::widget([
                        'name' => 'filter[date_start]',
                        'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => '2021-10-01'],
                        'value' => !empty($_GET['filter']['date_start']) ? $_GET['filter']['date_start'] : '',
                        //'language' => 'ru',
                        'dateFormat' => 'dd-MM-yyyy',
                    ]);?>
                </div>
            </div>
            <div>
                <p style="margin-bottom: 5px"><b>Заканчивая датой</b></p>
                <div>
                    <?php
                    echo DatePicker::widget([
                        'name' => 'filter[date_stop]',
                        'options' => ['class' => 'form-control', 'autocomplete' => 'off', 'placeholder' => '2021-10-05'],
                        'value' => !empty($_GET['filter']['date_stop']) ? $_GET['filter']['date_stop'] : '',
                        //'language' => 'ru',
                        'dateFormat' => 'dd-MM-yyyy',
                    ]);?>
                </div>
            </div>
            <div>
                <p style="margin-bottom: 5px"><b>Тип даты</b></p>
                <div><select class="form-control" name="filter[date_type]" >
                        <?php $dTypes = ['income' => 'По дате поступления','fs' => 'По дате ФС',]; ?>
                        <?php foreach($dTypes as $key => $tSt): ?>
                            <option <?= !empty($_GET['filter']['date_type']) && $_GET['filter']['date_type'] === $key ? 'selected' : '' ?> value="<?= $key ?>"><?= $tSt ?></option>
                        <?php endforeach; ?>
                    </select></div>
            </div>
            <div>
                <button type="submit" class="btn btn-admin-help" style="padding: 6px 20px">Применить</button>
            </div>
        </div>
    </div>
    <?= \yii\helpers\Html::endForm() ?>
    <hr>
    <div style="display: flex; flex-direction: column">
        <?php if(!empty($leads)): ?>
            <?php foreach($leads as $item): ?>
                <input type="hidden" name="serialize[id]" value="<?= $item['id'] ?>" data-id="<?= $item['id'] ?>">
            <?php $paramValues = json_decode($item['params'], true); ?>
            <div class="flex-div-lead-element <?= getClass($item['status']) ?>" data-response-id="<?= $item['id'] ?>" style="background-color: <?= getBkColor($item['status'], $item['category'], $item['sms_got']) ?>">
                <div class="first">
                    <div><b>ID: </b><?= $item['id'] ?></div>
                    <div><b>Источник: </b><span style="color: gray; font-style: italic"><?= "скрыт"#$item['source'] ?></span></div>
                    <div><b>UTM: </b><?= $item['utm_source'] ?></div>
                    <div><b>Поступил: </b><?= date("d.m.Y H:i", strtotime($item['date_income'])) ?></div>
                </div>
                <div style="border-top: 1px solid #efefef; margin-top: 10px; padding-top: 10px">
                    <div>
                        <p><b>Телефон</b>
                        <?php if(!empty($item['info'])): ?>
                        <?php $info = json_decode($item['info'], true);?>
                            <span style="font-size: 10px; ">
                                (<?= "{$info['region']}, МСК{$info['msk']}" ?>)
                            </span>
                        <?php endif; ?>
                        </p>
                        <div><input data-id="<?= $item['id'] ?>" type="text" name="serialize[phone]" readonly placeholder="89188916603" value="<?= $item['phone'] ?>" class="form-control"></div>
                    </div>
                    <div>
                        <p><b>Имя</b></p>
                        <div><input <?= isDisabled($item['status']) ?> data-id="<?= $item['id'] ?>" type="text" name="serialize[name]" placeholder="Олег" value="<?= $item['name'] ?>" class="form-control"></div>
                    </div>
                    <div style="width: 200px">
                        <p><b>Регион</b> <?php if(isDisabled($item['status']) !== 'disabled'): ?><a href="#" class="clear-select" data-id="<?= $item['id'] ?>" data-type="region">(очистить)</a><?php endif; ?></p>
                        <div class="region-finder">
                            <select <?= isDisabled($item['status']) ?> data-id="<?= $item['id'] ?>" class="form-control chosen-select select-region-ajax" name="serialize[region]" >
                                <?php if(!empty($item['region'])): ?>
                                    <option value="<?= $item['region'] ?>" selected><?= $item['region'] ?></option>
                                <?php else: ?>
                                    <option value="" selected>Указать регион</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <div style="width: 200px">
                        <p><b>Город</b> <?php if(isDisabled($item['status']) !== 'disabled'): ?><a href="#" class="clear-select" data-id="<?= $item['id'] ?>" data-type="city">(очистить)</a><?php endif; ?></p>
                        <div class="city-finder">
                            <select <?= isDisabled($item['status']) ?> data-id="<?= $item['id'] ?>" class="form-control chosen-select select-city-ajax" name="serialize[city]" >
                                <?php if(!empty($item['city'])): ?>
                                    <option value="<?= $item['city'] ?>" selected><?= $item['city'] ?></option>
                                <?php else: ?>
                                    <option value="" selected>Указать город</option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>
                    <?php if(!empty($leadParams)): ?>
                        <?php foreach($leadParams as $lParam): ?>
                            <div>
                                <p><b><?= $lParam['description'] ?></b></p>
                                <?php if(empty($lParam['cc_vars'])): ?>
                                    <div>
                                        <input autocomplete="off" <?= isDisabled($item['status']) ?> data-id="<?= $item['id'] ?>" value="<?= !empty($paramValues[$lParam['name']]) ? $paramValues[$lParam['name']] : null ?>" name="serialize[leadParams][<?= $lParam['name'] ?>]" class="form-control" type="<?= $lParam['type'] === 'number' ? 'number' : 'text' ?>" placeholder="Указать...">
                                    </div>
                                <?php else: ?>
                                <?php $vars = json_decode($lParam['cc_vars'], 1); ?>
                                    <div>
                                        <select data-id="<?= $item['id'] ?>" <?= isDisabled($item['status']) ?> name="serialize[leadParams][<?= $lParam['name'] ?>]" class="form-control">
                                            <?php if(!empty($vars)): ?>
                                                <option <?= empty($paramValues[$lParam['name']]) ? 'selected' : '' ?> value="">Выбрать...</option>
                                                <?php foreach($vars as $vv): ?>
                                                    <option <?= !empty($paramValues[$lParam['name']]) && $vv === $paramValues[$lParam['name']] ? 'selected' : '' ?> value="<?= $vv ?>"><?= $vv ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(!empty($ccFields)): ?>
                        <?php foreach($ccFields as $field): ?>
                            <div>
                                <p><b><?= $field['name'] ?></b></p>
                                <?php if($field['type'] === 'array'): ?>
                                    <div style="width: 200px">
                                        <select <?= isDisabled($item['status']) ?> data-id="<?= $item['id'] ?>" class="form-control chosen-select " name="serialize[params][<?= $field['name'] ?>]" >
                                            <option value="">Выбрать из списка...</option>
                                            <?php $optArr = json_decode($field['params'], true); ?>
                                            <?php if(!empty($optArr)): ?>
                                                <?php foreach($optArr as $opt): ?>
                                                    <option <?= !empty($paramValues[$field['name']]) && $paramValues[$field['name']] === $opt ? 'selected' : '' ?> value="<?= $opt ?>"><?= $opt ?></option>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                <?php elseif($field['type'] === 'number'): ?>
                                    <div>
                                        <input <?= isDisabled($item['status']) ?> data-id="<?= $item['id'] ?>" type="number" value="<?= !empty($paramValues[$field['name']]) ? $paramValues[$field['name']] : null ?>" name="serialize[params][<?= $field['name'] ?>]" class="form-control" placeholder="Указать число...">
                                    </div>
                                <?php elseif($field['type'] === 'text'): ?>
                                    <div>
                                        <input <?= isDisabled($item['status']) ?> data-id="<?= $item['id'] ?>" type="text" value="<?= !empty($paramValues[$field['name']]) ? $paramValues[$field['name']] : null ?>" name="serialize[params][<?= $field['name'] ?>]" class="form-control" placeholder="Указать текст...">
                                    </div>
                                <?php else: ?>
                                    <div>
                                        <?php

                                            echo DateTimePicker::widget([
                                                'name' => "serialize[params][{$field['name']}]",
                                                'options' => ['placeholder' => 'Выбрать время', "data-id" => $item['id'], 'disabled' => empty($item['status']) ? false : true, 'autocomplete' => 'off'],
                                                'convertFormat' => true,
                                                'type' => DateTimePicker::TYPE_INPUT,
                                                'value' =>  !empty($paramValues[$field['name']]) ? $paramValues[$field['name']] : null,
                                                'pluginOptions' => [
                                                    'format' => 'dd.MM.yyyy hh:i',
                                                    'startDate' => date("d.m.Y H:i"),
                                                    'todayHighlight' => true
                                                ]
                                            ]);

                                        ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if(!empty($sources) && $_GET['type'] !== 'audit'): ?>
                        <div style="width: 200px">
                            <p><b>Специальный источник</b></p>
                            <div class="">
                                <select <?= isDisabled($item['status']) ?> data-id="<?= $item['id'] ?>" class="form-control chosen-select select-city-ajax" name="serialize[special_source]" >
                                    <option value="">Указать источник</option>
                                    <?php foreach($sources as $spc): ?>
                                        <option value="<?= $spc['name'] ?>" <?= $item['special_source'] === $spc['name'] ? 'selected' : '' ?>><?= $spc['name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                    <?php endif; ?>
                </div>
                <div style="border-top: 1px solid #efefef; margin-top: 10px; padding-top: 10px; align-items: flex-end">
                    <div>
                        <p><b>Промежуточный статус</b></p>
                        <div>
                            <select <?= isDisabled($item['status']) ?> data-id="<?= $item['id'] ?>" class="form-control" name="serialize[status_temp]" >
                                <option value="">Выбрать статус...</option>
                                <?php foreach($tStatuses as $tSt): ?>
                                    <option <?= !empty($item['status_temp']) && $item['status_temp'] === $tSt ? 'selected' : '' ?> value="<?= $tSt ?>"><?= mb_convert_case($tSt, MB_CASE_TITLE) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div>
                        <p><b>Финальный статус</b></p>
                        <div>
                            <select <?= isDisabled($item['status']) ?> data-id="<?= $item['id'] ?>" class="form-control" name="serialize[status]" >
                                <option value="">Выбрать статус...</option>
                                <?php foreach($fStatuses as $eSt): ?>
                                    <option <?= !empty($item['status']) && $item['status'] === $eSt ? 'selected' : '' ?> value="<?= $eSt ?>"><?= mb_convert_case($eSt, MB_CASE_TITLE) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <?php if(!empty($item['date_outcome'])): ?>
                        <div>
                            <p><b>Дата ФС</b></p>
                            <input class="form-control" type="text" readonly value="<?= date('d.m.Y H:i', strtotime($item['date_outcome'])) ?>">
                        </div>
                    <?php endif; ?>
                    <?php if(empty($item['status'])): ?>
                        <div>
                            <div class="btn btn-admin saveBtn" data-id="<?= $item['id'] ?>">Сохранить</div>
                        </div>
                    <?php endif; ?>
                </div>
                <div>
                    <?php if (!empty($item['date_last_tmp'])): ?>
                        <div style="font-size: 12px"><b>Дата последнего промежуточного статуса: </b><?= date("d.m.Y H:i", strtotime($item['date_last_tmp'])) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
        <div>Лиды не найдены</div>
        <?php endif; ?>
    </div>
    <?php if(!empty($pages)): ?>
        <? echo \yii\widgets\LinkPager::widget([
            'pagination' => $pages,
            'registerLinkTags' => true
        ]); ?>
    <?php endif; ?>
</div>

