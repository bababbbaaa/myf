<?php

use yii\helpers\Html;
use yii\helpers\Url;

    if (!empty($integer)) {
        $params = json_decode($integer['config'], true);
        $config = $params['config'];
        $fields = $params['fields'];
        if (!empty($fields['contacts'])){
            $contacts = json_encode($fields['contacts']);
        } else $contacts = '{}';
        if (!empty($fields['leads'])){
            $leads = json_encode($fields['leads']);
        } else $leads = '{}';
    }

$this->title = 'Обновление Амо интеграции';
$order_id = $_GET['order_id'];
$js = <<< JS
var amoObject = {},
    serverInput = $('input[name="server"]'),
    leads = $leads,
    contacts = $contacts,
    tokenInput = $('input[name="access_token"]');
function getAmoParams() {
    $.ajax({
        data: {access_token: tokenInput.val(), server: serverInput.val()},
        url: 'amo-get-info',
        dataType: 'JSON',
        type: 'POST',
    }).done(function (fields) {
        if (fields.status !== 'success') {
            Swal.fire({
                icon: 'error',
                title: 'ОШИБКА',
                text: fields.message,
            });
        } else {
            var html = '';
            if (fields.data.leads !== undefined) {
                for (var key in fields.data.leads) {
                    html += "<div class='block__lead' data-field='leads' data-type='" + fields.data.leads[key].type + "' data-name='" + fields.data.leads[key].name + "' data-id='" + key + "'>";
                    html += "<span class='block__lead-title'>" + fields.data.leads[key].name + "</span>";
                    html += "<span class='block__lead-subtitle'><b> : </b>" + key + "</span>";
                    if (fields.data.leads[key].enums !== null) {
                        for (var en in fields.data.leads[key].enums) {
                            html += "<p style='font-size:10px; margin-bottom:1px'>";
                            html += "<span style='text-decoration:underline'>" + fields.data.leads[key].enums[en].value + "</span>" + ": " + fields.data.leads[key].enums[en].id;
                            html += "</p>";
                        }
                    }
                    html += '</div>';
                }
            }
            var html2 = '';
            if (fields.data.contacts !== undefined) {
                for (var key in fields.data.contacts) {
                    html2 += "<div class='block__lead' data-field='contacts' data-type='" + fields.data.contacts[key].type + "' data-id='" + key + "'>";
                    html2 += "<span class='block__lead-title'>" + fields.data.contacts[key].name + "</span>";
                    html2 += "<span class='block__lead-subtitle'><b> : </b>" + key + "</span>";
                    if (fields.data.contacts[key].enums !== null) {
                        for (var en in fields.data.contacts[key].enums) {
                            html2 += "<p style='font-size:10px; margin-bottom:1px'>";
                            html2 += "<span style='text-decoration:underline'>" + fields.data.contacts[key].enums[en].value + "</span>" + ": " + fields.data.contacts[key].enums[en].id;
                            html2 += "</p>";
                        }
                    }
                    html2 += '</div>';
                }
            }
            var html3 = '';
            if (fields.data.pipelines !== undefined) {
                for (var key in fields.data.pipelines) {
                    html3 += "<div class='block__lead' data-field='pipelines' data-type='" + fields.data.pipelines[key].type + "' data-id='" + key + "'>";
                    html3 += "<span class='block__lead-title'>" + fields.data.pipelines[key].name + "</span>";
                    html3 += "<span class='block__lead-subtitle'><b> : </b>" + key + "</span>";
                    if (fields.data.pipelines[key].statuses !== null) {
                        for (var en in fields.data.pipelines[key].statuses) {
                            html3 += "<p style='font-size:10px; margin-bottom:1px'>";
                            html3 += "<span style='text-decoration:underline'>" + fields.data.pipelines[key].statuses[en].name + "</span>" + " : " + fields.data.pipelines[key].statuses[en].id;
                            html3 += "</p>";
                        }
                    }
                    html3 += '</div>';
                }
            }
            var html4 = '';
            if (fields.data.users !== undefined) {
                for (var key in fields.data.users) {
                    html4 += "<div class='block__lead' data-field='users' data-type='" + fields.data.users[key].type + "' data-id='" + key + "'>";
                    html4 += "<span class='block__lead-title'>" + fields.data.users[key].name + "</span>";
                    html4 += "<span class='block__lead-subtitle'><b> : </b>" + key + "</span>";
                    html4 += '</div>';
                }
            }
            $('.lead--show').html(html);
            $('.contact--show').html(html2);
            $('.funnels--show').html(html3);
            $('.users--show').html(html4);
        }
    });
    if (amoObject.config === undefined) {
        amoObject = {
            config: {
                access_token: $('#access_token').val(),
                refresh_token: $('#refresh_token').val(),
                expires_in: $('#expires_in').val(),
                client_secret: $('#client_secret').val(),
                client_id: $('#client_id').val(),
                server: $('#server').val()
            },
            fields: {
                contacts: {},
                leads: {}
            }
        };
    }
}

$('.amo_form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        data: $('.amo_form').serialize(),
        url: 'oauth',
        dataType: "JSON",
        type: "POST"
    }).done(function (response) {
        if (response.status === 'error') {
            Swal.fire({
                icon: 'error',
                title: 'ОШИБКА',
                text: response.message,
            });
        } else {
            var timestamp = response.data.expires_in,
                date = new Date(),
                month,
                min,
                strDate = '';
            date.setTime(timestamp * 1000);
            month = date.getMonth() + 1;
            month = month <= 9 ? "0" + month : month;
            min = date.getMinutes();
            min = min <= 9 ? "0" + min : min;
            strDate += date.getDate() + "." + month + "." + date.getFullYear() + " " + date.getHours() + ":" + min;
            $('.input-amoCrm[name="expires_in"]').val(strDate);
            $('.input-amoCrm[name="access_token"]').val(response.data.access_token);
            $('.input-amoCrm[name="refresh_token"]').val(response.data.refresh_token);
            Swal.fire({
                icon: 'success',
                title: 'Успешно',
                text: 'Ключ доступа получен. Внимание: ключ авторизации годен до ' + strDate,
            });
            getAmoParams();
        }
    });
});
var dataType = '';
$('.lead--show').on('click', '.block__lead', function () {
    var data = $(this).attr('data-id'),
        type = $(this).attr('data-type');
    dataType = type;
    $('.input-amoCrm[name="name__lead-title"]').val(data);
    if (type === 'int'){
        $('.input-amoCrm[name="value__lead-value"]').attr('placeholder', 'Числовое значение');
    } else {
        $('.input-amoCrm[name="value__lead-value"]').attr('placeholder', 'Текстовое значение');
    }
});
function renderLeadParams(){
        var html = '';
    for (var key in leads){
        html += "<div class='block__lead' data-id='" + key + "'>";
        html += "<span class='block__lead-title'>" + key + "</span>";
        html += "<span class='block__lead-subtitle'><b> : </b>" + JSON.stringify(leads[key]) + "</span>";
        html += '</div>';
    }
    $('.show--params__lead').html(html);
}
$('.addLeads--params').on('click', function () {
    var name = $('.input-amoCrm[name="name__lead-title"]').val(),
        value = $('.input-amoCrm[name="value__lead-value"]').val();
    if (name.length > 0 && value.length > 0){
        leads[name] = {type:dataType, value:value, enum_id:null};
    }
    renderLeadParams();
    $('.input-amoCrm[name="name__lead-title"]').val('');
    $('.input-amoCrm[name="value__lead-value"]').val('');
});

$('.show--params__lead').on('click', '.block__lead', function () {
    var id = $(this).attr('data-id');
    delete leads[id];
    var html = '';
    renderLeadParams();
});
var typess = '';
$('.contact--show').on('click', '.block__lead', function(){
   var type = $(this).attr('data-type'),
       id = $(this).attr('data-id');
   typess = type;
   if (type === 'multitext'){
       $('.string__values').fadeOut(200, function () {
           $('.text__values').fadeIn(200);
           $('.hook_link[name="text__values-input"]').val(id);
       });
   } else {
       $('.text__values').fadeOut(200, function () {
           $('.string__values').fadeIn(200);
           $('.hook_link[name="string__values-input"]').val(id);
       });
   }
});

function renderMultiParams(){
    var html = '';
        for (var key in contacts){
        html += "<div class='block__lead' data-id='" + key + "'>";
        html += "<span class='block__lead-title'>" + key + "</span>";
        html += "<span class='block__lead-subtitle'><b> : </b>" + JSON.stringify(contacts[key]) + "</span>";
        html += '</div>';
    }
    $('.all-params__add').html(html);
}

$('.addMulti--params').on('click', function(){
    var input = $('.hook_link[name="text__values-input"]').val(),
        lead = $('.hook_link[name="text__values-lead"]').val(),
        values = $('.hook_link[name="text__values-values"]').val();
    if (input.length > 0 && lead.length > 0){
        contacts[input] = {type:typess, value:lead, enum_id:values};
    }
    renderMultiParams();
    $('.hook_link[name="text__values-input"]').val('');
    $('.hook_link[name="text__values-lead"]').val('');
    $('.hook_link[name="text__values-values"]').val('');
});
$('.addText--params').on('click', function(){
    var input = $('.hook_link[name="string__values-input"]').val(),
        lead = $('.hook_link[name="string__values-lead"]').val();
    if (input.length > 0 && lead.length > 0){
        contacts[input] = {type:typess, value:lead, enum_id:null};
    }
    renderMultiParams();
    $('.hook_link[name="string__values-input"]').val('');
    $('.hook_link[name="string__values-lead"]').val('');
});
$('.all-params__add').on('click', '.block__lead', function () {
    var id = $(this).attr('data-id');
    delete contacts[id];
    renderMultiParams();;
});
var configObj = {};
$('.save__amoCrm').on('click', function () {
    var access_token = $('#access_token').val(),
        refresh_token = $('#refresh_token').val(),
        expires_in = $('#expires_in').val(),
        server = $('#server').val(),
        client_secret = $('#client_secret').val(),
        client_id = $('#client_id').val();
    configObj = {
        'config': {
            'access_token':access_token,
            'refresh_token':refresh_token,
            'expires_in':expires_in,
            'server':server,
            'client_secret':client_secret,
            'client_id':client_id
        },
        'fields': {
            contacts,
            leads
        }
    }
    var amoCrm = 'Amo',
        configs = JSON.stringify(configObj);
    $.ajax({
        url: 'create-integration',
        dataType: 'JSON',
        type: 'POST',
        data: {type_integration: amoCrm, config: configs}
    }).done(function(rsp) {
        Swal.fire({
            icon: 'success',
            title: 'Успех!',
            html: "Сохранено",
        });
    });

});
getAmoParams();
renderLeadParams();
renderMultiParams();
JS;
$this->registerJs($js);
?>
<section class="rightInfo">
    <div class="integration">
        <div class="bcr">
            <?php if (!empty($order_id)): ?>
                <ul class="bcr__list">
                    <li class="bcr__item">
                        <a href="<?= Url::to(['myorders']) ?>" class="bcr__link">
                            Интеграция
                        </a>
                    </li>
                    <li class="bcr__item">
                        <a class="bcr__link">Обновление интеграции в заказe № <?= $order_id ?></a>
                    </li>
                </ul>
            <?php else: ?>
                <ul class="bcr__list">
                    <li class="bcr__item">
                        <a href="<?= Url::to(['integration']) ?>" class="bcr__link">
                            Интеграция
                        </a>
                    </li>
                    <li class="bcr__item">
                        <a class="bcr__link">Обновление интеграции</a>
                    </li>
                </ul>
            <?php endif; ?>

        </div>
    </div>

    <?php if (!empty($integer)): ?>
    <div style="display: block" class="forms__step" id="amo_form">
        <h4>Укажите данные для получения ключа аутентификации</h4>
        <?= Html::beginForm('', 'post', ['class' => 'amo_form']) ?>
        <div>
            <div class="line__Label">
                <label class="amo_form-label mw350">
                    Cсылка на сервер AmoCRM
                    <input id="server" type="text" name="server" value="<?= $config['server'] ?>"
                           placeholder="my.amocrm.ru">
                </label>
                <label class="amo_form-label">
                    Идентификатор интеграции
                    <input id="client_id" type="text" name="client_id"
                           value="<?= $config['client_id'] ?>"
                           placeholder="amnci9yn-bvki-fh4k-uuri579kod76">
                </label>
            </div>
            <div class="line__Label">
                <label class="amo_form-label mw350">
                    Секретный ключ
                    <input id="client_secret" type="text" name="client_secret"
                           value="<?= $config['client_secret'] ?>"
                           placeholder="MCNDK7674JKGNWI76">
                </label>
                <label class="amo_form-label">
                    Код авторизации
                    <input type="text" name="code" value="<?= $_SESSION['amoTOKENS']['raw']['code'] ?>"
                           placeholder="htnh4kvn5nkjeht548fkffvh98y">
                </label>
            </div>
            <button style="max-width: fit-content" type="submit" class="confirm_btn amoGetKey">Получить ключ
                аутентификации
            </button>
        </div>
        <?= Html::endForm(); ?>
        <div style="display:block;" class="more__inps">
            <h4>Данные OAuth</h4>
            <div class="line__Label">
                <label class="amo_form-label mw350">
                    EXPIRES IN
                    <input value="<?= date('d.m.Y H:i', strtotime($config['expires_in'])) ?>"
                           class="input-amoCrm" id="expires_in" type="text" name="expires_in"
                           placeholder="15.08.2021 15:35">
                </label>
                <label class="amo_form-label mw350">
                    ACCESS TOKEN
                    <input value="<?= $config['access_token'] ?>" id="access_token"
                           class="input-amoCrm" type="text" name="access_token"
                           placeholder="amnci9ynbvkifh4kuuri579kod76">
                </label>
                <label class="amo_form-label mw350">
                    REFRESH TOKEN
                    <input id="refresh_token" value="<?= $config['refresh_token'] ?>"
                           class="input-amoCrm" type="text" name="refresh_token"
                           placeholder="amnci9yvkifh4kuuri579kod76">
                </label>
            </div>
            <div class="leads__params">
                <div style="margin-top: 20px;">
                    <div class="block__lead--title">Поля лидов</div>
                    <div class="block__leads lead--show">
                        Загрузка параметров...
                    </div>
                </div>
                <div>
                    <p class="text--addparams">Поле AmoCRM и его значение</p>
                    <div class="addParams__block-flex">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link input-amoCrm" type="text"
                               name="name__lead-title" placeholder="UTM_CAMPAIGN">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link input-amoCrm" type="text"
                               name="value__lead-value" placeholder="6487798">
                        <button style="max-width: fit-content; margin-bottom: 15px;"
                                class="confirm_btn addLeads--params">Добавить параметр
                        </button>
                    </div>
                </div>
            </div>
            <div class="leads__params">
                <div style="margin-top: 20px;">
                    <div class="block__lead--title">Поля контактов</div>
                    <div class="block__leads contact--show">
                        Загрузка параметров...
                    </div>
                </div>
                <div style="display: none" class="text__values">
                    <p class="text--addparams">Поле AmoCRM / Указать значение и тип значения</p>
                    <div class="addParams__block-flex">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link" type="text"
                               name="text__values-input" placeholder="6487798">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link" type="text"
                               name="text__values-lead" placeholder="LEAD_PHONE">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link" type="text"
                               name="text__values-values" placeholder="193228">
                        <button style="max-width: fit-content; margin-bottom: 15px;"
                                class="confirm_btn addMulti--params">Добавить параметр
                        </button>
                    </div>
                </div>
                <div class="string__values">
                    <p class="text--addparams">Поле AmoCRM / Текстовое значение</p>
                    <div class="addParams__block-flex">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link" type="text"
                               name="string__values-input" placeholder="6487798">
                        <input style="max-width: 250px; margin-bottom: 15px" class="hook_link" type="text"
                               name="string__values-lead" placeholder="LEAD_NAME">
                        <button style="max-width: fit-content; margin-bottom: 15px;"
                                class="confirm_btn addText--params">Добавить параметр
                        </button>
                    </div>
                </div>
            </div>
            <div class="leads__params">
                <div style="margin-top: 20px;">
                    <div class="block__lead--title">Воронки</div>
                    <div class="block__leads funnels--show">
                        Загрузка параметров...
                    </div>
                </div>
            </div>
            <div class="leads__params">
                <div style="margin-top: 20px;">
                    <div class="block__lead--title">Пользователи</div>
                    <div class="block__leads users--show">
                        Загрузка параметров...
                    </div>
                </div>
            </div>
            <div>
                <h4>Добавленные поля контактов</h4>
                <div class="block__leads show--params__lead">
                    Нет добавленных полей
                </div>
            </div>
            <div>
                <h4>Добавленные поля лидов</h4>
                <div class="block__leads all-params__add">
                    Нет добавленных полей
                </div>
            </div>
            <button style="max-width: fit-content" class="confirm_btn save__amoCrm">Сохранить</button>
        </div>
    </div>
    <?php else: ?>
    <h4>Интеграция не найдена</h4>
    <?php endif; ?>

    <div class="references__int">
        <h3 class="title__references">Справка</h3>
        <div id="amo" class="accortion__reference">
            <div class="header__reference">
                <div class="dot_head">
                    <div class="dot_int"></div>
                    <h4 class="title__reference">Интеграция с AmoCRM</h4>
                </div>
                <svg class="icon_reference" width="10" height="6" viewBox="0 0 10 6" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.06564 0.683058C0.821561 0.438981 0.425834 0.438981 0.181756 0.683058C-0.0623217 0.927136 -0.0623217 1.32286 0.181756 1.56694L4.34842 5.73361C4.5925 5.97769 4.98823 5.97769 5.23231 5.73361L9.39897 1.56694C9.64305 1.32286 9.64305 0.927136 9.39897 0.683058C9.1549 0.438981 8.75917 0.438981 8.51509 0.683058L4.79036 4.40778L1.06564 0.683058Z"
                          fill="#9BA0B7"/>
                </svg>
            </div>
            <div data-id="amo" class="drop__list">
                <ol class="main__list">
                    <li class="main__list-li">
                        Укажите следующие данные для получения ключа аутентификации:
                        <ul class="mark__change" style="padding: 15px 0 0 40px;">
                            <li>Код авторизации</li>
                            <li>ID интеграции</li>
                            <li>Секретный ключ</li>
                            <li>Ссылку на свою AmoCRM в формате company.amocrm.ru</li>
                        </ul>
                    </li>
                    <p class="red__li">Код авторизации годен 20 минут. Интеграция должан быть создана в течение 20
                        минут после ее создания в AmoCRM</p>
                    <li class="main__list-li">Указав данные в соответствующих полях, нажимаете Получить ключ
                        аутентификации
                    </li>
                    <p class="red__li">Полученный код авторизации можно использовать только 1 раз</p>
                    <li class="main__list-li">
                        Далее появится уведомление об ошибке или корректности ключа. Ключ может быть некорректен в
                        следующих случаях:
                        <ul class="mark__change" style="padding: 12px 0 12px 40px;">
                            <li>просроченный ключ</li>
                            <li>повторное использование кода авторизации</li>
                            <li>ошибка в подставляемых параметрах</li>
                            <li>перепутаны поля,в которые подставляют ключи</li>
                        </ul>
                    </li>
                    <li class="main__list-li">В случае корректности ключа появятся значения OAuth и вам доступна
                        настройка параметров интеграции
                    </li>
                    <li class="main__list-li">
                        Задайте значения обязательных полей:
                        <ul class="mark__change" style="padding: 12px 0 12px 40px;">
                            <li>Выберите ответственного за лид и контакт. Нажмите Добавить параметр</li>
                            <li>Выберите Воронку. Нажмите Добавить параметр</li>
                            <li>Выберите Статус сделки. Нажмите Добавить параметр</li>
                        </ul>
                    </li>
                    <li class="main__list-li">Выберите дополнительный параметры из каталога ниже</li>
                    <li class="main__list-li">Введите необходимое значение и нажмите Добавить параметр</li>
                    <li class="main__list-li">При необходимости повторите пункты 6-7</li>
                    <li class="main__list-li">Когда все необходимые параметры добавлены, нажмите Сохранить
                        интеграцию
                    </li>
                </ol>
            </div>
        </div>
        <div id="bitrix" class="accortion__reference">
            <div class="header__reference">
                <div class="dot_head">
                    <div class="dot_int"></div>
                    <h4 class="title__reference">Интеграция с Битрикс24</h4>
                </div>
                <svg class="icon_reference" width="10" height="6" viewBox="0 0 10 6" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.06564 0.683058C0.821561 0.438981 0.425834 0.438981 0.181756 0.683058C-0.0623217 0.927136 -0.0623217 1.32286 0.181756 1.56694L4.34842 5.73361C4.5925 5.97769 4.98823 5.97769 5.23231 5.73361L9.39897 1.56694C9.64305 1.32286 9.64305 0.927136 9.39897 0.683058C9.1549 0.438981 8.75917 0.438981 8.51509 0.683058L4.79036 4.40778L1.06564 0.683058Z"
                          fill="#9BA0B7"/>
                </svg>
            </div>

            <div data-id="bitrix" class="drop__list">
                <ol class="main__list">
                    <li class="main__list-li">
                        Укажите ссылку на вебхук Битрикс24 и нажмите Запросить информацию
                    </li>
                    <li class="main__list-li">
                        Указав данные в соответствующих полях, нажимаете Получить ключ аутентификации
                        <ul class="mark__change" style="padding: 15px 0 0 40px;">
                            <li>указанная ссылка не явояется вебхуком</li>
                            <li>в ссылке присутствует ошибка</li>
                            <li>указанное значение не является ссылкой</li>
                            <li>вебхук не имеет достаточно привелегий</li>
                            <li>вебхук не существует или был удален</li>
                        </ul>
                    </li>
                    <li class="main__list-li">Если вебхук корректный появляются поля лидов Битрикс24, список
                        источников и статусов лидов
                    </li>
                    <li class="main__list-li">В появившемся перечне выберите необходимое поле и кликните по нему
                    </li>
                    <li class="main__list-li">Укажите для данного параметра необходимое значение в тексовом виде или
                        виде специальных значений (приведены ниже)
                    </li>
                    <li class="main__list-li">Когда значение введено нажмите Добавить параметр</li>
                    <li class="main__list-li">При необходимости повторите пункты 4-6</li>
                    <li class="main__list-li">Когда все необходимые параметры добавлены, нажмите Сохранить
                        интеграцию
                    </li>
                </ol>
            </div>
        </div>
        <div id="hook" class="accortion__reference">
            <div class="header__reference">
                <div class="dot_head">
                    <div class="dot_int"></div>
                    <h4 class="title__reference">Интеграция с WebHook</h4>
                </div>
                <svg class="icon_reference" width="10" height="6" viewBox="0 0 10 6" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.06564 0.683058C0.821561 0.438981 0.425834 0.438981 0.181756 0.683058C-0.0623217 0.927136 -0.0623217 1.32286 0.181756 1.56694L4.34842 5.73361C4.5925 5.97769 4.98823 5.97769 5.23231 5.73361L9.39897 1.56694C9.64305 1.32286 9.64305 0.927136 9.39897 0.683058C9.1549 0.438981 8.75917 0.438981 8.51509 0.683058L4.79036 4.40778L1.06564 0.683058Z"
                          fill="#9BA0B7"/>
                </svg>
            </div>
            <div data-id="hook" class="drop__list">
                <ol class="main__list">
                    <li class="main__list-li">Укажите ссылку на внешний сервер, способный принимать внешние
                        POST-запросы
                    </li>
                    <li class="main__list-li">Нажмите Подтвердить. Далее появится уведомление о корректности
                        ссылки
                    </li>
                    <li class="main__list-li">Если вебхук корректный кнопка Сохранить интеграцию станет активной
                    </li>
                    <li class="main__list-li">Нажмите сохранить интеграцию</li>
                </ol>
            </div>
        </div>
        <div id="special" class="accortion__reference">
            <div class="header__reference">
                <div class="dot_head">
                    <div class="dot_int"></div>
                    <h4 class="title__reference">Специальные значения переменных</h4>
                </div>
                <svg class="icon_reference" width="10" height="6" viewBox="0 0 10 6" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.06564 0.683058C0.821561 0.438981 0.425834 0.438981 0.181756 0.683058C-0.0623217 0.927136 -0.0623217 1.32286 0.181756 1.56694L4.34842 5.73361C4.5925 5.97769 4.98823 5.97769 5.23231 5.73361L9.39897 1.56694C9.64305 1.32286 9.64305 0.927136 9.39897 0.683058C9.1549 0.438981 8.75917 0.438981 8.51509 0.683058L4.79036 4.40778L1.06564 0.683058Z"
                          fill="#9BA0B7"/>
                </svg>
            </div>
            <div data-id="special" class="drop__list">
                <ol class="main__list">
                    <li class="main__list-li">
                        Укажите следующие данные для получения ключа аутентификации:
                        <ul class="mark__change" style="padding: 15px 0 0 40px;">
                            <li>Код авторизации</li>
                            <li>ID интеграции</li>
                            <li>Секретный ключ</li>
                            <li>Ссылку на свою AmoCRM в формате company.amocrm.ru</li>
                        </ul>
                    </li>
                    <p class="red__li">Код авторизации годен 20 минут. Интеграция должан быть создана в течение 20
                        минут после ее создания в AmoCRM</p>
                    <li class="main__list-li">Указав данные в соответствующих полях, нажимаете Получить ключ
                        аутентификации
                    </li>
                    <p class="red__li">Полученный код авторизации можно использовать только 1 раз</p>
                    <li class="main__list-li">
                        Далее появится уведомление об ошибке или корректности ключа. Ключ может быть некорректен в
                        следующих случаях:
                        <ul class="mark__change" style="padding: 12px 0 12px 40px;">
                            <li>просроченный ключ</li>
                            <li>повторное использование кода авторизации</li>
                            <li>ошибка в подставляемых параметрах</li>
                            <li>перепутаны поля,в которые подставляют ключи</li>
                        </ul>
                    </li>
                    <li class="main__list-li">В случае корректности ключа появятся значения OAuth и вам доступна
                        настройка параметров интеграции
                    </li>
                    <li class="main__list-li">
                        Задайте значения обязательных полей:
                        <ul class="mark__change" style="padding: 12px 0 12px 40px;">
                            <li>Выберите ответственного за лид и контакт. Нажмите Добавить параметр</li>
                            <li>Выберите Воронку. Нажмите Добавить параметр</li>
                            <li>Выберите Статус сделки. Нажмите Добавить параметр</li>
                        </ul>
                    </li>
                    <li class="main__list-li">Выберите дополнительный параметры из каталога ниже</li>
                    <li class="main__list-li">Введите необходимое значение и нажмите Добавить параметр</li>
                    <li class="main__list-li">При необходимости повторите пункты 6-7</li>
                    <li class="main__list-li">Когда все необходимые параметры добавлены, нажмите Сохранить
                        интеграцию
                    </li>
                </ol>
            </div>
        </div>
    </div>
    </div>
    <div class="popup popup--auct-err">
        <div class="popup__ov">
            <div class="popup__body popup__body--w">
                <div class="popup__content popup__content--err">
                    <p class="popup__title rsp-ajax-title">
                        Ошибка
                    </p>
                    <p class="popup__text rsp-ajax-text">
                    </p>
                    <button class="popup__btn-lid btn">Продолжить</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img//close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
    <div class="popup popup--auct">
        <div class="popup__ov">
            <div class="popup__body popup__body--ok">
                <div class="popup__content popup__content--ok">
                    <p class="popup__title">Успешно</p>
                    <p class="popup__text rsp--ajax__text">
                        Данные корректные.
                    </p>
                    <button class="popup__btn-lid btn">Продолжить</button>
                </div>
                <div class="popup__close">
                    <img src="<?= Url::to(['/img//close.png']) ?>" alt="close">
                </div>
            </div>
        </div>
    </div>
</section>