<?php

use yii\bootstrap\Alert;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Integrations */
/* @var $form yii\widgets\ActiveForm */


$getOrdersID = \common\models\Orders::find()->where(['!=', 'archive', 1])->select('id, order_name, category_text')->asArray()->orderBy('id desc')->all();
$getClientsID = \common\models\Clients::find()->where(['!=', 'archive', 1])->select('id, f, i')->asArray()->orderBy('id desc')->all();

$orders = [];
$clients = [];

if(!empty($getOrdersID)) {
    foreach ($getOrdersID as $item) {
        $orders[$item['id']] = empty($item['order_name']) ? "#{$item['id']} - {$item['category_text']}" : "#{$item['id']} - {$item['order_name']}";
    }
}

if(!empty($getClientsID)) {
    foreach ($getClientsID as $item) {
        $clients[$item['id']] = "#{$item['id']} {$item['f']} {$item['i']}";
    }
}

$ordersJSON = json_encode($orders, JSON_UNESCAPED_UNICODE);
$clientsJSON = json_encode($clients, JSON_UNESCAPED_UNICODE);

$frontendConfig = $model->config ?? "{}";
$frontendType = $model->integration_type ?? '';

$webhookUrl = !empty($model->config) ? json_decode($model->config, 1)['WEBHOOK_URL'] : '';

$this->registerCssFile(Url::to(['/css/chosen.min.css']));
$this->registerJsFile(Url::to(['/js/chosen.jquery.min.js']), ['depends' => \yii\web\JqueryAsset::class]);

if ($model->integration_type === 'amo') {
    $leadObject = json_decode($frontendConfig, true)['fields']['leads'] ?? "{}";
    $contactObject = json_decode($frontendConfig, true)['fields']['contacts'] ?? "{}";
} else {
    $leadObject = "{}";
    $contactObject = "{}";
}

$integrations_special = \common\models\IntegrationsSpecialParams::find()->asArray()->all();

$leadCategory = \common\models\LeadsCategory::find()->asArray()->all();
if(!empty($leadCategory)) {
    foreach ($leadCategory as $lc) {
        $leadCatArr[$lc['link_name']] = $lc['name'];
    }
}

$LeadParams = \common\models\LeadsParams::find()->asArray()->all();
if (!empty($LeadParams) && !empty($leadCatArr)) {
    foreach ($LeadParams as $p) {
        $paramArray[$leadCatArr[$p['category']]][$p['name']] = $p['description'];
    }
}

$tgParams = !empty($model->config) ? $model->config : '{}';

$js = <<<JS
$(".chosen-select").chosen({disable_search_threshold: 0});
var 
    orders = $ordersJSON,
    clients = $clientsJSON,
    configObject = $frontendConfig,
    configType = '$frontendType',
    integrationConfig = $('#integrations-config'),
    paramBlock = $('.added-params'),
    changeIntegrationType = $('.changeIntegrationType'),
    paramBlockCLICK = $('.params-bitrix-block'),
    bitrixParamInp = $('.paramNameAdd-bitrix');
if (configType.length > 0) 
    renderConfig(configType);
$('.changeEntity').on('input', function() {
    var 
        val = $(this).val(),
        entitySelect = $('.entitySelect'),
        html = '',
        buffer = {};
    if (val === 'order') {
        buffer = Object.assign({}, orders);
    } else {
        buffer = Object.assign({}, clients);
    }
    for (var key in buffer) {
        html += "<option value='"+ key +"'>"+ buffer[key] +"</option>";
    }
    entitySelect.html(html);
    entitySelect.trigger('chosen:updated');
});
paramBlockCLICK.on('click', '.click-key-add-bitrix', function() {
    var param = $(this).text();
    bitrixParamInp.val(param).focus();
    $('.paramValueAdd-bitrix').val('');
});

function renderConfig(type) {
    var 
        renderBlock = $('.added-params[data-type="'+ type +'"]'),
        html = '<div style="margin: 20px 0;"><b>Добавленные параметры:</b></div><div class="flex-params-block">';
    if (type === 'bitrix') {
        for (var key in configObject) {
            if (key === 'WEBHOOK_URL')
                continue;
            html += "<div class='param-click-added' data-type='bitrix' data-id='"+ key +"'>";
                html += "<b>" + key + "</b>: " + configObject[key];
            html += "</div>";
        }
        html += '</div>';
        renderBlock.html(html);
    } else {
        
    }
    integrationConfig.text(JSON.stringify(configObject));
}
paramBlock.on('click', '.param-click-added', function() {
    var 
        key = $(this).attr('data-id'),
        type = $(this).attr('data-type');
    delete configObject[key];
    renderConfig(type);
});
$('.addparambtn-bitrix').on('click', function() {
    var
        param = $('.paramNameAdd-bitrix').val(),
        value = $('.paramValueAdd-bitrix').val();
    if (param.length > 0 && value.length > 0) {
        configObject[param] = value;
    }
    renderConfig('bitrix');
});
paramBlockCLICK.on('click', '.sbb-b', function() {
  var id = $(this).attr('data-id');
  $('.paramNameAdd-bitrix').val('SOURCE_ID');
  $('.paramValueAdd-bitrix').val(id).trigger('focus');
});
paramBlockCLICK.on('click', '.stbb-b', function() {
  var id = $(this).attr('data-id');
  $('.paramNameAdd-bitrix').val('STATUS_ID');
  $('.paramValueAdd-bitrix').val(id).trigger('focus');
});
changeIntegrationType.on('input', function() {
    var 
        type = $(this).val(),
        url = $('.URL-input');
    $('.param-click-added').each(function() {
        var id = $(this).attr('data-id');
        delete configObject[id];
    });
    $('.hidden-block-int').hide();
    $('.block-' + type).show();
    renderConfig(type);
    integrationConfig.text('');
    url.val('');
    configObject = {};
});

/*  AMO   */

var 
    serverInput = $('input[name="server"]'),
    amoObject = $frontendConfig ,
    contactObject = $contactObject ,
    leadObject = $leadObject ,
    tokenInput = $('input[name="access_token"]'),
    hiddenAmoBlock = $('.hidden-amo-blocks'),
    amoparamBlock = $('.amo-fields-block');

function getAmoParams() {
    amoparamBlock.show();
    $.ajax({
        data: {access_token: tokenInput.val(), server: serverInput.val()},
        url: '/lead-force/main/amo-get-info',
        dataType: "JSON",
        type: "POST"
    }).done(function(fields) {
        if (fields.status !== 'success') {
            Swal.fire({
                icon: 'error',
                title: 'ОШИБКА',
                text: fields.message,
            });
        } else {
            var html = '';
            if (fields.data.leads !== undefined) {
                html += "<p style='margin-left:5;'><b>Поля лидов</b></p><div style='display:flex; flex-wrap: wrap;'>";
                for (var key in fields.data.leads) {
                    html += "<div class='amoCustomBlocksLead'>";
                        html += "<div><b class='field-amo' data-field='leads' data-type='"+ fields.data.leads[key].type +"' data-id='"+ key +"'>" + fields.data.leads[key].name + '</b>: ' + key + "</div>";
                        if(fields.data.leads[key].enums !== null) {
                            for (var en in fields.data.leads[key].enums) {
                                html += "<p style='font-size:10px; margin-bottom:1px'>";
                                    html += "<span style='text-decoration:underline'>" + fields.data.leads[key].enums[en].value + "</span>" + ": " + fields.data.leads[key].enums[en].id;
                                html += "</p>";
                            }
                        }
                    html += "</div>";
                }
                html += '</div><hr>';
            }
            if (fields.data.contacts !== undefined) {
                html += "<p style='margin-left:5;'><b>Поля контактов</b></p><div style='display:flex; flex-wrap: wrap;'>";
                for (var key in fields.data.contacts) {
                    html += "<div class='amoCustomBlocksContact'>";
                        html += "<div><b class='field-amo' data-field='contacts' data-type='"+ fields.data.contacts[key].type +"' data-id='"+ key +"'>" + fields.data.contacts[key].name + '</b>: ' + key + "</div>";
                        if(fields.data.contacts[key].enums !== null) {
                            for (var en in fields.data.contacts[key].enums) {
                                html += "<p style='font-size:10px; margin-bottom:1px'>";
                                    html += "<span style='text-decoration:underline'>" + fields.data.contacts[key].enums[en].value + "</span>" + ": " + fields.data.contacts[key].enums[en].id;
                                html += "</p>";
                            }
                        }
                    html += "</div>";
                }
                html += '</div>';
            }
            if (fields.data.pipelines !== undefined) {
                html += "<p style='margin-left:5;'><b>Воронки</b></p><div style='display:flex; flex-wrap: wrap;'>";
                for (var key in fields.data.pipelines) {
                    html += "<div class='amoCustomBlocksPipelines'>";
                        html += "<div><b class='' data-field='pipelines' data-type='"+ fields.data.pipelines[key].type +"' data-id='"+ key +"'>" + fields.data.pipelines[key].name + '</b>: ' + key + "</div>";
                        if(fields.data.pipelines[key].statuses !== null) {
                            for (var en in fields.data.pipelines[key].statuses) {
                                html += "<p style='font-size:10px; margin-bottom:1px'>";
                                    html += "<span style='text-decoration:underline'>" + fields.data.pipelines[key].statuses[en].name + "</span>" + ": " + fields.data.pipelines[key].statuses[en].id;
                                html += "</p>";
                            }
                        }
                    html += "</div>";
                }
                html += '</div>';
            }
            if (fields.data.users !== undefined) {
                html += "<p style='margin-left:5;'><b>Пользователи</b></p><div style='display:flex; flex-wrap: wrap;'>";
                for (var key in fields.data.users) {
                    html += "<div class='amoCustomBlocksUsers'>";
                        html += "<div><b class='' data-field='users' data-type='"+ fields.data.users[key].type +"' data-id='"+ key +"'>" + fields.data.users[key].name + '</b>: ' + key + "</div>";
                    html += "</div>";
                }
                html += '</div>';
            }
            amoparamBlock.html(html);
        }
    });
    if (amoObject.config === undefined) {
        amoObject = {
            config: {
                access_token: $('.input-amoCRM[name="access_token"]').val(),
                refresh_token: $('.input-amoCRM[name="refresh_token"]').val(),
                expires_in: $('.input-amoCRM[name="expires_in"]').val(),
                client_secret: $('.input-amo[name="client_secret"]').val(),
                client_id: $('.input-amo[name="client_id"]').val(),
                server: $('.input-amo[name="server"]').val(),
            },
            fields: {
                contacts: {},
                leads: {}
            }
        };
    }
    $('#integrations-config').text(JSON.stringify(amoObject));
}

$('.amoGetKeyBtn').on('click', function() {
    var post = $('.input-amo').serialize();
    $.ajax({
        data: post,
        url: '/lead-force/main/oauth',
        dataType: "JSON",
        type: "POST"
    }).done(function(response) {
        if (response.status === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'ОШИБКА',
                text: response.message,
            });
        } else {
            var 
                timestamp = response.data.expires_in,
                date = new Date(),
                month,
                min,
                strDate = '';
            date.setTime(timestamp*1000);
            month = date.getMonth() + 1;
            month = month <= 9 ? "0" + month : month;
            min = date.getMinutes();
            min = min <= 9 ? "0" + min : min;
            strDate += date.getDate() + "." + month + "." + date.getFullYear() + " " + date.getHours() + ":" + min;
            $('.input-amoCRM[name="expires_in"]').val(strDate);
            $('.input-amoCRM[name="access_token"]').val(response.data.access_token);
            $('.input-amoCRM[name="refresh_token"]').val(response.data.refresh_token);
            Swal.fire({
                icon: 'success',
                title: 'Успешно',
                text: 'Ключ доступа получен. Внимание: ключ авторизации годен до ' + strDate,
            });
            getAmoParams();
            $('#integrations-config').text(JSON.stringify(amoObject));
        }
    });
});
var clickObject = {};
amoparamBlock.on('click', '.field-amo', function() {
    var 
        type = $(this).attr('data-type'),
        id = $(this).attr('data-id'),
        noOneShow = true,
        field = $(this).attr('data-field');
    clickObject = {
        type: type,
        id: id,
        field: field,
    };
    hiddenAmoBlock.hide();
    hiddenAmoBlock.each(function() {
        if ($(this).attr('data-type') === type) {
            $(this).show();
            noOneShow = false;
        }
    });
    if (noOneShow) {
        $('.hidden-amo-blocks[data-type="text"]').show();
    }
    $('.amoCrmCustomField[data-name="fieldAmoID"]').val(id).trigger('focus');
});
$('.amoAddField').on('click', function() {
    if ($('input[data-name="fieldAmoID"]').val().length <= 0) {
        Swal.fire({
            icon: 'error',
            title: 'Ошибка',
            text: 'Необходимо выбрать поле и заполнить значение',
        });
    } else {
        if (clickObject.field === 'leads') {
            if (clickObject.type !== 'multitext') {
                leadObject[clickObject.id] = {
                    type: clickObject.type,
                    value: $('.amoCrmCustomField[data-name="fieldAmoVal_'+ clickObject.type +'"]').val() !== undefined ? $('.amoCrmCustomField[data-name="fieldAmoVal_'+ clickObject.type +'"]').val() : $('.amoCrmCustomField[data-name="fieldAmoVal_text"]').val(),
                    enum_id: null
                };
            } else {
                leadObject[clickObject.id] = {
                    type: clickObject.type,
                    value: $('.amoCrmCustomField[data-name="fieldAmoVal_'+ clickObject.type +'"][data-type="text"]').val(), 
                    enum_id: $('.amoCrmCustomField[data-name="fieldAmoVal_'+ clickObject.type +'"][data-type="enum"]').val()
                };
            }
            amoObject.fields.leads = leadObject;
            renderLeadFields();
            $('#integrations-config').text(JSON.stringify(amoObject));
        } else {
            if (clickObject.type !== 'multitext') {
                contactObject[clickObject.id] = {
                    type: clickObject.type,
                    value: $('.amoCrmCustomField[data-name="fieldAmoVal_'+ clickObject.type +'"]').val(),
                    enum_id: null
                };
            } else {
                contactObject[clickObject.id] = {
                    type: clickObject.type,
                    value: $('.amoCrmCustomField[data-name="fieldAmoVal_'+ clickObject.type +'"][data-type="text"]').val(),
                    enum_id: $('.amoCrmCustomField[data-name="fieldAmoVal_'+ clickObject.type +'"][data-type="enum"]').val()
                };
            }
            amoObject.fields.contacts = contactObject;
            renderContactFields();
            $('#integrations-config').text(JSON.stringify(amoObject));
        }
        $('.amoCrmCustomField').each(function() {
            $(this).val('');
        });
    }
});
function renderContactFields() {
    var 
       html = '<div style="margin-right:10px; "><b>Добавленные поля контактов</b></div>',
        fieldsDiv = $('.contactObjectFields');
    for (var key in contactObject) {
        html += "<div class='added-param-amo' data-type='contact' data-id='"+ key +"'>";
            html += key + ": " + JSON.stringify(contactObject[key]);
        html += "</div>";
    }
    fieldsDiv.html(html);
}
function renderLeadFields() {
    var 
        html = '<div style="margin-right:10px; "><b>Добавленные поля лидов</b></div>',
        fieldsDiv = $('.leadObjectFields');
    for (var key in leadObject) {
        html += "<div class='added-param-amo' data-type='lead' data-id='"+ key +"'>";
            html += key + ": " + JSON.stringify(leadObject[key]);
        html += "</div>";
    }
    fieldsDiv.html(html);
}
if(serverInput.val().length > 0) {
    getAmoParams();
} else {
    if (amoObject.config !== undefined) {
        $('.input-amoCRM[name="access_token"]').val(amoObject.config.access_token);
        $('.input-amoCRM[name="refresh_token"]').val(amoObject.config.refresh_token);
        $('.input-amoCRM[name="expires_in"]').val(amoObject.config.expires_in);
        $('.input-amo[name="client_secret"]').val(amoObject.config.client_secret);
        $('.input-amo[name="client_id"]').val(amoObject.config.client_id);
        $('.input-amo[name="server"]').val(amoObject.config.server);
    }
    if(serverInput.val().length > 0) {
        getAmoParams();
        contactObject = amoObject.fields.contacts;
        if (Object.keys(contactObject).length !== 0) {
            renderContactFields();
        }
        leadObject = amoObject.fields.leads;
        if (Object.keys(leadObject).length !== 0) {
            renderLeadFields();
        }
    }
}
$('.supervisor-amo-fields').on('click', '.added-param-amo', function() {
    var
        type = $(this).attr('data-type'),
        key = $(this).attr('data-id');
    if (type === 'lead') {
        delete leadObject[key];
        amoObject.fields.leads = leadObject;
        renderLeadFields();
        if (Object.keys(leadObject).length === 0) {
           $('.leadObjectFields').html('');
        }
        $('#integrations-config').text(JSON.stringify(amoObject));
    } else {
        delete contactObject[key];
        amoObject.fields.contacts = contactObject;
        renderContactFields();
        if (Object.keys(contactObject).length === 0) {
           $('.contactObjectFields').html('');
        }
        $('#integrations-config').text(JSON.stringify(amoObject));
    }
});


$('.webhook-accept-btn').on('click', function() {
    var
        url = $('input[name="webhook-url-true"]').val();
    if (url.length > 0) {
        $.ajax({
            url: '/lead-force/main/webhook-accept',
            data: {url: url},
            dataType: "JSON",
            type: "POST"
        }).done(function(rsp) {
            if (rsp.status === 'error') {
                Swal.fire({
                    icon: 'error',
                    title: 'Ошибка',
                    html: rsp.message,
                });
            } else  {
                $('.URL-input').val(url);
                $('#integrations-config').text(JSON.stringify({WEBHOOK_URL: url}));
                Swal.fire({
                    icon: 'success',
                    title: 'ОК',
                    text: 'Вебхук является валидной ссылкой и возвращает ответ 200.',
                });
                
            }
        });
    }
});
$('.click-open-hidden-faq').on('click', function() {
    var 
        type = $(this).attr('data-type');
    $('.hidden-open-faq').hide();
    $('.hidden-open-faq[data-type="'+ type +'"]').show();
});
var fakeT = undefined;
$('.input-fake').on('input', function() {
    var val = $(this).val();
    if (val.length > 0) {
        if (fakeT !== undefined) {
            clearTimeout(fakeT);
        }
        fakeT = setTimeout(function() {
            var objBuf = {email_fake: val};
            $('#integrations-config').val(JSON.stringify(objBuf));
        }, 500);
    } else {
        $('#integrations-config').val('');
    }
});
var tgObj = $tgParams;
$('.input-telegram').on('input', function() {
    var name = $(this).attr('name');
    if (name === 'telegram[peer]')
        tgObj.peer = $(this).val();
    else if (name === 'telegram[id]') {
        tgObj.id = $(this).val();
    } else {
        tgObj.comments = $(this).val();
    }
    $('#integrations-config').val(JSON.stringify(tgObj));
});
JS;
$this->registerJsFile(Url::to(['/js/bitrixTestApi.js']), ['depends' => \yii\web\JqueryAsset::class]);
$this->registerJs($js);

$responseXls = Yii::$app->session->getFlash('webhookEmpty');
?>

<style>

</style>

<?php if(!empty($responseXls)): ?>
    <?php echo Alert::widget([
        'options' => [
            'class' => 'alert-danger',
        ],
        'body' => $responseXls,
    ]); ?>
<?php endif; ?>
<?php if(!empty($model->config)): ?>
    <?php $cfg = json_decode($model->config, 1); ?>
<?php endif; ?>
<div class="integrations-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'entity')->dropDownList(['order' => 'Заказ', 'client' => 'Клиент', ], ['class' => 'form-control changeEntity']) ?>

    <?= $form->field($model, 'entity_id')->dropDownList(!empty($model->entity) && $model->entity === 'client' ? $clients : $orders, ['class' => 'form-control entitySelect chosen-select']) ?>

    <?= $form->field($model, 'integration_type')->dropDownList([ 'bitrix' => 'Битрикс24', 'amo' => 'AmoCRM', 'webhook' => 'Вебхук', 'fake' => 'Фейк', 'telegram' => 'Telegram'], ['class' => 'form-control changeIntegrationType']) ?>

    <div style="display: none">
        <?= $form->field($model, 'url')->textInput(['class' => 'URL-input', 'value' => $webhookUrl]) ?>
    </div>

    <hr>
    <h4>Настройки параметров секции</h4>
    <div class="hidden-block-int block-bitrix" style="display: <?= empty($frontendType) || $frontendType === 'bitrix' ? 'block' : 'none' ?>">
        <p><b style="font-size: 24px;">Битрикс24</b></p>
        <p><b>Ссылка на вебхук Битрикс24</b></p>
        <div style="display: flex; flex-wrap: wrap; margin-bottom: 20px;">
            <div style="margin-right: 10px; max-width: 500px; width: 100%;">
                <input type="text" class="form-control input-bitrix" value="<?= $webhookUrl ?>" name="url" placeholder="https://femidaforce.bitrix24.ru/rest/14/1z1jzohhj1erp17x/">
            </div>
            <div class="btn btn-admin-help integration-btn-bitrix" data-type="urlCheck">Запрос информации</div>
        </div>
        <div class="params-bitrix-block" style="max-height: 400px; overflow: auto">

        </div>
        <div class="added-params" data-type="bitrix">

        </div>
        <div style="margin-top: 25px;">
            <p><b>Задать пару "Ключ : Значение"</b></p>
            <div style="display: flex; flex-wrap: wrap; align-items: flex-end">
                <div style="margin: 0 5px 5px 0">
                    <div><b>Параметр</b></div>
                    <div>
                        <input placeholder="TITLE" type="text" class="form-control paramNameAdd-bitrix">
                    </div>
                </div>
                <div style="margin: 0 5px 5px 0">
                    <div><b>Значение</b></div>
                    <div>
                        <input type="text" placeholder="LEAD_NAME" class="form-control paramValueAdd-bitrix">
                    </div>
                </div>
                <div style="margin: 0 5px 5px 0">
                    <div class="btn btn-admin-delete addparambtn-bitrix">Добавить параметр</div>
                </div>
            </div>
        </div>
    </div>

    <div class="hidden-block-int block-fake" style="display: <?= $frontendType === 'fake' ? 'block' : 'none' ?>">
        <p><b style="font-size: 24px;">Фейковый отправитель</b></p>
        <p><b>Email пользователя</b></p>
        <div style="display: flex; flex-wrap: wrap; margin-bottom: 5px;">
            <div style="margin-right: 10px; max-width: 500px; width: 100%;">
                <input type="email" class="form-control input-fake" value="<?= !empty($cfg['email_fake']) ? $cfg['email_fake'] : '' ?>" name="fake[email]" placeholder="andrey123@gmail.com">
            </div>
        </div>
        <div style="color: #9e9e9e; font-size: 12px">
            на эту почту будет идти отправка лидов от нас, но это будет выглядеть как "не от нас"<br>
            <span style="color: red"><b>внимание</b> - убрать почту у клиента и из заказа, если используете эту интеграцию</span>
        </div>
    </div>

    <div class="hidden-block-int block-telegram" style="display: <?= $frontendType === 'telegram' ? 'block' : 'none' ?>">
        <p><b style="font-size: 24px;">Интеграция с телеграм</b></p>
        <p><b>ID чата</b></p>
        <div style="display: flex; flex-wrap: wrap; margin-bottom: 15px;">
            <div style="margin-right: 10px; max-width: 500px; width: 100%;">
                <input type="text" class="form-control input-telegram" value="<?= !empty($cfg['peer']) ? $cfg['peer'] : '' ?>" name="telegram[peer]" placeholder="-67452335">
            </div>
        </div>
        <p><b>ID бота</b></p>
        <div style="display: flex; flex-wrap: wrap; margin-bottom: 15px;">
            <div style="margin-right: 10px; max-width: 500px; width: 100%;">
                <input type="text" class="form-control input-telegram" value="<?= !empty($cfg['id']) ? $cfg['id'] : '' ?>" name="telegram[id]" placeholder="bot1969107691:AAGM85BG7jqg2mxIWND0diPFeCs0qkLMbgQ">
            </div>
        </div>
        <p><b>Отправлять комментарий</b></p>
        <div style="display: flex; flex-wrap: wrap; margin-bottom: 5px;">
            <div style="margin-right: 10px; max-width: 500px; width: 100%;">
                <select name="telegram[comments]" class="form-control input-telegram">
                    <option <?= !empty($cfg['comments']) && $cfg['comments'] === 'нет' ? 'selected' : '' ?> value="нет">нет</option>
                    <option <?= !empty($cfg['comments']) && $cfg['comments'] === 'да' ? 'selected' : '' ?> value="да">да</option>
                </select>
            </div>
        </div>
        <div style="color: #9e9e9e; font-size: 12px">
            указать айди чата, в котором состоит бот с указанным ID и имеет привилегии администратора
        </div>
    </div>


    <div class="hidden-block-int block-amo" style="display: <?= $frontendType === 'amo' ? 'block' : 'none' ?>">
        <p><b style="font-size: 24px;">AmoCRM</b></p>
        <div style="display: flex; flex-wrap: wrap; ">
            <div style="max-width: 210px; width: 100%; margin-right: 10px; margin-bottom: 20px">
                <p><b>Ссылка на <span style="text-decoration:underline;">сервер</span> AmoCRM</b></p>
                <div>
                    <input type="text" class="form-control input-amo" value="<?= $_SESSION['amoTOKENS']['raw']['server'] ?>" name="server" placeholder="my.amocrm.ru">
                </div>
            </div>
            <div style="max-width: 633px; width: 100%; margin-bottom: 20px;">
                <p><b>Идентификатор интеграции</b></p>
                <div>
                    <input type="text" class="form-control input-amo" value="<?= $_SESSION['amoTOKENS']['raw']['client_id'] ?>" name="client_id" placeholder="a750ef6s-a18c-4fr6-8ca6-0c88ce1ef014">
                </div>
            </div>
        </div>
        <div style="display: flex; flex-wrap: wrap; ">
            <div style="max-width: 340px; width: 100%; margin-right: 10px; margin-bottom: 20px;">
                <p><b>Секретный ключ</b></p>
                <div>
                    <input type="text" class="form-control input-amo" value="<?= $_SESSION['amoTOKENS']['raw']['client_secret'] ?>" name="client_secret" placeholder="NWRbuX00fQDdI7hHnAk6QwHjCo4bUdlEt61sxlXY2FyXhqicBMTt89HuJIgmkKVN">
                </div>
            </div>
            <div style="max-width: 503px; width: 100%; margin-bottom: 20px;">
                <p><b>Код авторизации</b></p>
                <div>
                    <input type="text" class="form-control input-amo" value="<?= $_SESSION['amoTOKENS']['raw']['code'] ?>" name="code" placeholder="def502001d51eb15abaf4a1a43afd5faca6063de4f99582d5d332a183ba1ee4984d26e4cabd8fd696eced981e8a6273273a6d451d9f992ad59ee0128ff821beef3ca78a8cd4e07f8ae640a736029bbdec40925bdecdeff047c5fd2bd7863d5f452cd0b473c25939398f70c3f67f3f22df31d4134bca42c6625ebd4221a4110c9d08574714a6b4f54899aaffa67d2adc8a7e85cd4ead76c7db7bead59297b03def8cda782ec5a8cdd5c3264509fcdb44e094af5e5e07ba0dcd34a971bbff94ada025e4c997f26caf0625adc5f36bf52798da2f7a45e9e5c30defcfe9743e9a9828af544593bdcb2094dff4171d7eedda846c8565c1a3031fd63eb05be73498561ff0e9351028c0a9dbabc7c900822fd0bd2cfddd7b759aa5c61b17d7d63545e77f0f9b5251e18daab84fcd388b5d055a6f64f49fbd0b416d9790a42f9e1d1e11addeb6e16532494615d0fe91899d6c7543504466ddf36b65e892d8d918f2f23ee9527829c23ff5f65d22162db21fd0234f04c8a14bc009434ba2f4642287e2b1d62b052c0bb0fa57f9f4b13aed00a0ff52f552886aafbeb4c327256bbc829d5a86074efb7cd5c9cc04691e4fedf43abe5d2f8f90e4c1b2f3d0dfc3b835a95f9">
                </div>
            </div>
        </div>
        <div style="" class="btn btn-admin-delete amoGetKeyBtn">
            Получить ключ аутентификации
        </div>

        <div style="margin-top: 20px">
            <p><b style="font-size: 24px;">Данные OAuth</b></p>
            <div style="display: flex; flex-wrap: wrap; ">
                <div style="max-width: 200px; width: 100%; margin-right: 10px; margin-bottom: 20px">
                    <p><b>EXPIRES IN</b></p>
                    <div>
                        <input type="text" readonly class="form-control input-amoCRM" value="<?= $_SESSION['amoTOKENS'] ? date('d.m.Y H:i', $_SESSION['amoTOKENS']['response']['expires_in']) : '' ?>" name="expires_in" placeholder="<?= date('d.m.Y H:i') ?>">
                    </div>
                </div>
                <div style="max-width: 310px; width: 100%; margin-right: 10px; margin-bottom: 20px;">
                    <p><b>ACCESS TOKEN</b></p>
                    <div>
                        <input type="text" readonly class="form-control input-amoCRM" value="<?= $_SESSION['amoTOKENS']['response']['access_token'] ?>" name="access_token" placeholder="eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6IjVjYzMyMzQxMTlmYjI3YzUzMGNjMzc0NGU1OWJlMTFmYTQ2Zjg3OWE4MjgyN2UyN2YyODFiNWJlZGU3OWNhZjYyZWNlMGE4OTk2YzgyYTU1In0.eyJhdWQiOiIyNzMwOGNlZS03NDUwLTQ1YWMtODU5Ni1iNTVlZDFjZWYzZDkiLCJqdGkiOiI1Y2MzMjM0MTE5ZmIyN2M1MzBjYzM3NDRlNTliZTExZmE0NmY4NzlhODI4MjdlMjdmMjgxYjViZWRlNzljYWY2MmVjZTBhODk5NmM4MmE1NSIsImlhdCI6MTYxODQ4MDE4MSwibmJmIjoxNjE4NDgwMTgxLCJleHAiOjE2MTg1NjY1ODEsInN1YiI6IjY5NjIyMzYiLCJhY2NvdW50X2lkIjoyOTQyNzY1OCwic2NvcGVzIjpbInB1c2hfbm90aWZpY2F0aW9ucyIsImNybSIsIm5vdGlmaWNhdGlvbnMiXX0.ph7nPhj4B7neQgFcSXYavlED0AAPY4SjjhnSclP5ecdGS2befQfDry9XCJbpTTuJFnT9tZ1T4gWSKMn95tUIdjyHZGI7f8VBEIGi7zZWm3fUWzU2K5EGxeAGr6EhUv02eQxNlJDpB_GWEfLNjSvc0xy22bIfy-nrJ1tuDotrCSlWodyYpUCZNbWKrdCDSm2N2-F6P1YXNTBjGwIvSoqsTfRbggsWpHCizP_kBNV22ssgznkhGDrWs7QGeANWEtOkXyNTsBbDpMDunfVRfBXytLIDaTTUUTCigzpkxjzQLGSMxcOXsXaR4j7ndjHygCsUDoDUgsrI3EdxF5JxXCjQ">
                    </div>
                </div>
                <div style="max-width: 310px; width: 100%; margin-right: 10px; margin-bottom: 20px;">
                    <p><b>REFRESH TOKEN</b></p>
                    <div>
                        <input type="text" readonly class="form-control input-amoCRM" value="<?= $_SESSION['amoTOKENS']['response']['refresh_token'] ?>" name="refresh_token" placeholder="def50200d510c45799342733f81fd9cc7e2db1b65c1acc223df9354da186f623ef763e5def931ddff395b4438265b6a82c5efc32acc3afb07dcf0465430b8e7e6ea23bf30019607423a6eec567cba74de67772a34cf63efb22e8068b425de846309261b0ad242fb98c97f5d32f913867046faa1d49c8b6031725cb2cf9549529286cf483a36b6230f85aaa4ba48f6de89817cee2f74b021f57908af0b2dcdd8f103f937c85ddfae6212582fd894dcfcf793706ea383e8e0be38f17003c3566da07cb37efe496d62e0026449a0310acec3d7b93f6d2855e23bd4f4483510d4c1591ae86e125d81018b153dba7284db9ba21f33050aa01c5c30799a18a7adb55cc4c0471ba46f1f86ce4be2bac24abf8663d16364df854194e634fe5c2cbc629c7adbb46181ef6c6245cd117a153db097a53af920a8c117280c7597233552702f52ca40808a92047bf79336ca4bdaa88b754867b4b2e2b523af5b138c26038bb2f2dbdc0ab8f8b876dbfa458f3792d4794e5665b54d60c8dc2c1a243f0a9f38969ac6105b347139ded0c5e5e51558994dd383a705ae53cf23627a669330bcbe9fd250c34ba9355d77793861c7a98a264c6bcc2fbb3f875dabd33309037aec6c0ee59d8175355dac455b206">
                    </div>
                </div>
            </div>
        </div>
        <div style="display: none; margin-top: 20px; margin-bottom: 25px" class="amo-fields-block">
            <span style="font-size: 18px; letter-spacing: 0.1em">Получение полей ...</span>
        </div>


        <div style="margin-top: 10px;">
            <p><b>Задать значения полей</b></p>
            <div class="row">
                <div class="col-md-4" style="margin-bottom: 10px;">
                    <p><b>Поле AmoCRM</b></p>
                    <div>
                        <input type="text" placeholder="responsible_user_id" class="amoCrmCustomField form-control" data-name="fieldAmoID">
                    </div>
                    <div class="btn btn-admin-help amoAddField" style="margin-top: 10px;">
                        Добавить поле
                    </div>
                </div>
                <div class="col-md-8" style="margin-bottom: 10px;">
                    <div class="hidden-amo-blocks" data-type="int">
                        <p><b>Числовое значение</b></p>
                        <div>
                            <input type="number" min="0" step="1" max="2000000000" placeholder="1000" class="amoCrmCustomField form-control" data-name="fieldAmoVal_int">
                        </div>
                    </div>
                    <div class="hidden-amo-blocks" data-type="text">
                        <p><b>Текстовое значение</b></p>
                        <div>
                            <input type="text" placeholder="LEAD_NAME" class="amoCrmCustomField form-control" data-name="fieldAmoVal_text">
                        </div>
                    </div>
                    <div class="hidden-amo-blocks" data-type="tracking_data">
                        <p><b>Текстовое значение</b></p>
                        <div>
                            <input type="text" placeholder="UTM_SOURCE" class="amoCrmCustomField form-control" data-name="fieldAmoVal_tracking_data">
                        </div>
                    </div>
                    <div class="hidden-amo-blocks" data-type="select">
                        <p><b>Одно значение из перечня</b></p>
                        <div>
                            <input type="text" placeholder="9702135" class="amoCrmCustomField form-control" data-name="fieldAmoVal_select">
                        </div>
                    </div>
                    <div class="hidden-amo-blocks" data-type="multiselect">
                        <p><b>Несколько значений через запятую</b></p>
                        <div>
                            <input type="text" placeholder="9702135,82977210" class="amoCrmCustomField form-control" data-name="fieldAmoVal_multiselect">
                        </div>
                    </div>
                    <div class="hidden-amo-blocks" data-type="multitext">
                        <p><b>Указать значение и тип значения</b></p>
                        <div class="row">
                            <div class="col-sm-6" style="margin-bottom: 10px;">
                                <input type="text" placeholder="LEAD_PHONE" class="amoCrmCustomField form-control" data-name="fieldAmoVal_multitext" data-type="text">
                            </div>
                            <div class="col-sm-6" style="margin-bottom: 10px;">
                                <input type="text" placeholder="193226" class="amoCrmCustomField form-control" data-name="fieldAmoVal_multitext" data-type="enum">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="supervisor-amo-fields">
            <div class="contactObjectFields" style="display: flex; flex-wrap: wrap; margin-top: 10px;">

            </div>
            <div class="leadObjectFields" style="display: flex; flex-wrap: wrap; margin-top: 10px;">

            </div>
        </div>
    </div>

    <div class="hidden-block-int block-webhook" style="display: <?= $frontendType === 'webhook' ? 'block' : 'none' ?>">
        <p><b style="font-size: 24px;">WebHook</b></p>
        <div class="row">
            <div style="margin-bottom: 10px" class="col-md-8">
                <input class="form-control" placeholder="https://mysite.ru/webhook.php" value="<?= $webhookUrl ?>" type="text" name="webhook-url-true">
            </div>
            <div style="margin-bottom: 10px" class="col-md-4">
                <div class="btn btn-admin-help webhook-accept-btn">Подтвердить</div>
            </div>
        </div>
    </div>


    <div style="margin-top: 15px;">
        <?= $form->field($model, 'config')->textarea(['rows' => 3, 'readonly' => true, 'style' => 'resize:none']) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-admin']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    <h4 style="margin: 40px 0">Справка</h4>
    <div class="rbac-info rbac-info-leads" style="max-width: unset">
        <p>Сущность <code>"Интеграция"</code> теперь является обобщающей конфигурацией интеграций 3 типов для сущностей <code>"Клиент"</code> и <code>"Заказ"</code></p>
        <p>На первоначальном этапе необходимо выбрать - для какой сущности создавать интеграцию:</p>
        <ul>
            <li>Для заказа: <ul>
                    <li>интеграция сработает для конкретного заказа клиента</li>
                    <li>интеграция имеет приоритет <code>выше</code>, чем интеграция клиента</li>
                    <li>в случае создания нового заказа клиентом - ему нужно будет добавить новую интеграцию</li>
                </ul></li>
            <li>Для клиента <ul>
                    <li>интеграция сработает на все заказы указанного клиента</li>
                    <li>интеграция имеет приоритет <code>ниже</code>, чем интеграция конкретного заказа</li>
                </ul></li>
        </ul>
        <p>Выбрав сущность, указывается ID сущности, к которой будет применена интеграция</p>
        <p>Следующий этап - выбор типа интеграции</p>
        <p style="margin-bottom: 0"><b class="click-open-hidden-faq" data-type="bitrix" style="color: #d9534f">1. Интеграция с Битрикс24</b></p>
        <div class="hidden-open-faq" data-type="bitrix" style="display: <?= $model->integration_type === 'bitrix' ? 'block' : 'none' ?>">
            <div style="margin-bottom: 7px"><b>Порядок установки интеграции с Битрикс24</b></div>
            <ol class="special-int-ol">
                <li>Получить ссылку на вебхук у клиента или сделать ее <a target="_blank" href="<?= Url::to(['/uploads/guide_bitrix.pdf']) ?>">самостоятельно (смотреть руководство)</a> в клиентском Битрикс24, при наличии доступов</li>
                <li><code>Указать ссылку на вебхук</code> и нажать на кнопку <code>Запрос информации</code></li>
                <li>Оценить полученный ответ от сервера в отношении указанной ссылки: <ul>
                        <li>ошибки могут возникнуть в случае: <ul>
                                <li>если указанная ссылка не является вебхуком Битрикс24</li>
                                <li>если в вебхуке присутствует ошибка</li>
                                <li>если указанное значение не является ссылкой</li>
                                <li>если вебхук не имеет достаточно привилегий</li>
                                <li>если вебхук фактически не существует или был удален</li>
                            </ul></li>
                        <li>"зеленый" статус успеха обозначает, что с данным вебхуком можно работать</li>
                    </ul></li>
                <li><code>В случае правильности вебхука</code> будет указан перечень полей лидов Битрикс24, список источников и статусов лидов для данной учетной записи<ul>
                        <li>если в списке источников отсутствует необходимый источник - кликнуть на кнопку <code>Добавить источник Lead.Force</code> - это добавит новый источник в клиентский Битрикс24</li>
                        <li>если клиенту нужен заранее определенный источник - выбрать источник из перечня</li>
                    </ul></li>
                <li>В указанном перечне полей найти необходимое поле (для передачи данных в него) и кликнуть по нему</li>
                <li>Для данного поля указать необходимое значение в виде текста или в виде <code>специальных значений</code> (см. раздел "Специальные значения переменных")</li>
                <li>Когда значение добавлено - нажать на кнопку <code>Добавить параметр</code></li>
                <li>При необходимости - повторить пункты 5-7</li>
                <li>Когда все необходимые поля добавлены - нажать на кнопку <code>Сохранить</code></li>
            </ol>
        </div>
        <p style="margin-bottom: 0"><b class="click-open-hidden-faq" data-type="amo" style="color: #d9534f">2. Интеграция с AmoCRM</b></p>
        <div class="hidden-open-faq" data-type="amo" style="display: <?= $model->integration_type === 'amo' ? 'block' : 'none' ?>">
            <div style="margin-bottom: 7px"><b>Порядок установки интеграции с AmoCRM</b></div>
            <ol class="special-int-ol">
                <li>Если клиент не предоставляет доступ к своей AmoCRM, то он должен: <ul>
                        <li>создать новую интеграцию в разделе "Настройки > Интеграции"</li>
                        <li>в новой интеграции указать ссылку для перенаправления - https://myforce.ru</li>
                        <li>отметить - "Предоставить доступ: Все"</li>
                        <li>указать любое название интеграции и любое описание, и сохранить интеграцию</li>
                        <li>в разделе "Ключи и доступы" данной интеграции скопировать и передать нашему модератору 4 параметра: <ul>
                                <li>Секретный ключ</li>
                                <li>ID интеграции</li>
                                <li>Код авторизации</li>
                                <li>Ссылку на свою AmoCRM в виде: company.amocrm.ru</li>
                            </ul></li>
                        <li><b><code>Внимание:</code></b> код авторизации годен всего 20 минут. Интеграция должна быть создана в течение 20 минут после момента ее создания в AmoCRM</li>
                    </ul></li>
                <li>Если клиент предоставил доступ к своей AmoCRM (предоставил логин и пароль админа): <ul>
                        <li>авторизуетесь по ссылке клиента с указанным логином и паролем</li>
                        <li>дальнейший порядок действий в <a target="_blank" href="<?= Url::to(['/uploads/guide_amo.pdf']) ?>">руководстве (смотреть)</a></li>
                    </ul></li>
                <li>Получив 4 параметра, указанных выше - заполняете форму (как указано в руководстве, последний слайд) и получаете данные OAuth (ключи аутентификации) <ul>
                        <li><code><b>Внимание:</b></code> для получения ключей аутентификации у вас есть всего 20 минут, с момента создания интеграции. Если ключ просрочен - вам придется создавать новую интеграцию</li>
                        <li><code><b>Внимание:</b></code> полученный код авторизации можно использовать <code>ТОЛЬКО 1 РАЗ</code>. Не пытайтесь нажимать на кнопку повторно после получения ключей аутентификации.</li>
                        <li>После нажатия на кнопку вы можете получить уведомление об ошибке или успехе получения ключей: <ul>
                                <li>ошибка может быть обусловлена: <ul>
                                        <li>просроченностью ключа</li>
                                        <li>повторным использованием кода авторизации</li>
                                        <li>ошибкой в подставляемых параметрах</li>
                                        <li>перепутанными полями, в которых подставляются ключи</li>
                                    </ul></li>
                                <li>в случае успеха - вы получите уведомление о сроке годности ключа аутентификации и получите перечень полей лидов и контактов, а также айди воронок, статусов лидов в них и пользователей CRM</li>
                            </ul></li>
                    </ul></li>
                <li><b>Следующие шаги нужно выполнить <code>обязательно:</code></b> <ol>
                        <li>нажимаем в "Поля лидов" на <code>Ответственный пользователь (ID)</code> и указываем ID ответсвтенного за лида из перечня пользователей, или узнаем желаемый айди напрямую у клиента. Нажимаем <code>Добавить поле</code></li>
                        <li>аналогично для <code>Ответственный пользователь (ID)</code> в "Поля контактов" указываем точно такой же ID. Нажимаем <code>Добавить поле</code></li>
                        <li>нажимаем в "Поля лидов" на <code>Воронка (ID)</code> и указываем ID воронки из перечня воронок. Нажимаем <code>Добавить поле</code></li>
                        <li>нажимаем в "Поля лидов" на <code>Статус сделки (ID)</code> и указываем ID первого статуса (или на выбор клиента) из перечня статусов (под названием воронки). Нажимаем <code>Добавить поле</code></li>
                        <li>нажимаем в "Поля лидов" на <code>Название сделки</code> и указываем LEAD_NAME. Нажимаем <code>Добавить поле</code></li>
                        <li>нажимаем в "Поля контактов" на <code>Название контакта</code> и указываем LEAD_NAME. Нажимаем <code>Добавить поле</code></li>
                        <li>нажимаем в "Поля контактов" на <code>Телефон</code> и указываем LEAD_PHONE и ID поля для типа WORK во второе пустое поле. Нажимаем <code>Добавить поле</code></li>
                        <li>нажимаем в "Поля контактов" на <code>Email</code> и указываем LEAD_EMAIL и ID поля для типа WORK во второе пустое поле. Нажимаем <code>Добавить поле</code></li>
                    </ol></li>
                <li>Далее, по аналогии с предыдущим пунктом, - можно добавить прочие поля, если есть необходимость.</li>
                <li>Когда все необходимые поля добавлены - нажимаем кнопку <code>Сохранить</code></li>
            </ol>
        </div>
        <p style="margin-bottom: 0"><b class="click-open-hidden-faq" data-type="webhook" style="color: #d9534f">3. Интеграция типа "WebHook"</b></p>
        <div class="hidden-open-faq" data-type="webhook" style="display: <?= $model->integration_type === 'webhook' ? 'block' : 'none' ?>">
            <div style="margin-bottom: 7px"><b>Порядок установки интеграции типа "WebHook"</b></div>
            <ol class="special-int-ol">
                <li>Если предоставляемый Lead.Force способ интеграции с AmoCRM и Битрикс24 не устраивает клиента, или у него есть самописная СРМ - он может воспользоваться вебхуком. <ul>
                        <li>Клиент создает PHP-скрипт или скрипт на любом другом языке, способный принимать HTTP запрос POST в формате JSON</li>
                        <li>Сообщает URL-адрес к данному скрипту менеджеру / специалисту тех. поддержки, который занимается интеграцией</li>
                        <li>Данный URL указывается в соответствующее поле</li>
                        <li>Далее необходимо нажать кнопку <code>Подтвердить</code></li>
                        <li><b>Важно</b>, чтобы предоставленный URL отдавал HTTP код 200. В противном случае - данную ссылку, в качестве вебхука, будет невозможно использовать.</li>
                        <li>Если вебхук был успешно добавлен - нажимаем на кнопку <code>Сохранить</code></li>
                        <li>При каждом новом лиде - на указанный вебхук будут отправлены все данные о лиде в формате JSON, за исключением системных полей.</li>
                        <li>Пример реализации вебхука на PHP:</li>
                    </ul></li>
            </ol>
<pre>
&lt;?php
    # получаем данные лида

    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    # в $json хранится вся информация о лиде в формате JSON, в $data - в виде массива
    # запишем $json в файл и посмотрим, какие данные приходят на вебхук

    file_put_contents('some_file.log', $json . PHP_EOL, FILE_APPEND);

    # теперь при поступлении лида - вся информация будет сохраняться с каждой новой строки файла
    # JSON данные, записанные в файл, можно использовать для отладки и проверки структуры объекта, который приходит в POST
?&gt;
</pre>
        </div>
        <p style="margin-bottom: 0"><b class="click-open-hidden-faq" data-type="telegram" style="color: #d9534f">4. Интеграция с Телеграм</b></p>
        <div class="hidden-open-faq" data-type="telegram" style="display: <?= $model->integration_type === 'telegram' ? 'block' : 'none' ?>">
            <div style="margin-bottom: 7px"><b>Порядок установки интеграции типа "Telegram"</b></div>
            <ol class="special-int-ol">
                <li>
                    Создать чат-бота в телеграм <a target="_blank" href="https://telegram.me/botfather">по ссылке</a> или использовать имеющегося
                </li>
                <li>
                    Получить айди бота в виде <code>1969107691:AAGM85BG7jqg2mxIWND0diPFeCs0qkLMbgQ</code>. Скопировать айди и добавить <code>bot</code> спереди. Подставить значение в соответствующее поле.
                </li>
                <li>
                    Добавить бота в группу, куда необходимо отправлять заявки. Предоставить боту админские права в группе.
                </li>
                <li>
                    Перейти по ссылке, используя ранее полученный айди: <br>
                    <span style="user-select: text !important;"><span style="color: #006dcc">https://api.telegram.org/bot</span><span style="color: #2ea26c">1969107691:AAGM85BG7jqg2mxIWND0diPFeCs0qkLMbgQ</span><span style="color: #006dcc">/getUpdates</span></span>
                </li>
                <li>На странице выделить и скопировать весь текст (Cntrl+A + Cntrl+C). Перейти по ссылке <a
                            href="https://jsonformatter.org/json-parser" target="_blank">JSON-парсера</a></li>
                <li>Вставить текст в левый столбец. Закрыть уведомления об ошибках, в случае их возникновения.</li>
                <li>В правом столбце найти <code>chat {N}</code> <span style="color: #9e9e9e; font-size: 12px">(N - любое число)</span>, у которого <code>title</code> будет соответствовать названию группы, в которую нужно лить заявки.</li>
                <li>В найденном чате &ndash; скопировать <code>id</code> и подставить в соответствующее поле</li>
                <li>Сохранить и протестировать интеграцию</li>
            </ol>
        </div>
        <p style="margin-bottom: 0"><b class="click-open-hidden-faq" data-type="fake" style="color: #d9534f">5. Фейковый отправитель</b></p>
        <div class="hidden-open-faq" data-type="fake" style="display: <?= $model->integration_type === 'fake' ? 'block' : 'none' ?>">
            <div style="margin-bottom: 7px"><b>Порядок установки интеграции типа "Фейк"</b></div>
            <ol class="special-int-ol">
                <li>
                    Указать в поле почту клиента, на которую нужно отправлять заявки
                </li>
                <li>
                    Сохранить интеграцию
                </li>
                <li>
                    <b>Важно: Зайти в настройки заказа и клиента, и удалить из них почты для отправки</b>
                </li>
            </ol>
        </div>
        <p style="margin-top: 10px;"><b>Специальные значения переменных</b></p>
        <?php if(!empty($integrations_special)): ?>
            <?php foreach($integrations_special as $param): ?>
                    <div style="margin-bottom: 7px;"><code style="user-select: text"><?= $param['name'] ?></code> - <?= $param['description'] ?></div>
            <?php endforeach; ?>
        <?php endif; ?>
        <?php if(!empty($paramArray)): ?>
            <?php foreach($paramArray as $key => $item): ?>
                <p><b>Специальные значения переменных категории &laquo;<?= $key ?>&raquo;</b></p>
                <div>
                    <?php foreach($item as $j => $i): ?>
                        <div style="margin-bottom: 7px;"><code style="user-select: text">LEAD_PARAM_<?= $j ?></code> - Подставит вместо специального значения, в указанном месте, значение параметра &laquo;<?= $i ?>&raquo;.</div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

</div>
