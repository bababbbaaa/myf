var amoObject = {},
    serverInput = $('input[name="server"]'),
    leads = {},
    contacts = {},
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
            $('.more__inps').fadeIn(300);
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

$('.addLeads--params').on('click', function () {
    var name = $('.input-amoCrm[name="name__lead-title"]').val(),
        value = $('.input-amoCrm[name="value__lead-value"]').val();
    if (name.length > 0 && value.length > 0){
        leads[name] = {type:dataType, value:value, enum_id:null};
    }
    var html = '';
    for (var key in leads){
        html += "<div class='block__lead' data-id='" + key + "'>";
        html += "<span class='block__lead-title'>" + key + "</span>";
        html += "<span class='block__lead-subtitle'><b> : </b>" + JSON.stringify(leads[key]) + "</span>";
        html += '</div>';
    }
    $('.input-amoCrm[name="name__lead-title"]').val('');
    $('.input-amoCrm[name="value__lead-value"]').val('');
    $('.show--params__lead').html(html);
});

$('.show--params__lead').on('click', '.block__lead', function () {
    var id = $(this).attr('data-id');
    delete leads[id];
    var html = '';
    for (var key in leads){
        html += "<div class='block__lead' data-id='" + key + "'>";
        html += "<span class='block__lead-title'>" + key + "</span>";
        html += "<span class='block__lead-subtitle'><b> : </b>" + JSON.stringify(leads[key]) + "</span>";
        html += '</div>';
    }
    $('.show--params__lead').html(html);
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

$('.addMulti--params').on('click', function(){
    var input = $('.hook_link[name="text__values-input"]').val(),
        lead = $('.hook_link[name="text__values-lead"]').val(),
        values = $('.hook_link[name="text__values-values"]').val();
    if (input.length > 0 && lead.length > 0){
        contacts[input] = {type:typess, value:lead, enum_id:values};
    }
    var html = '';
    for (var key in contacts){
        html += "<div class='block__lead' data-id='" + key + "'>";
        html += "<span class='block__lead-title'>" + key + "</span>";
        html += "<span class='block__lead-subtitle'><b> : </b>" + JSON.stringify(contacts[key]) + "</span>";
        html += '</div>';
    }
    $('.all-params__add').html(html);
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
    var html = '';
    for (var key in contacts){
        html += "<div class='block__lead' data-id='" + key + "'>";
        html += "<span class='block__lead-title'>" + key + "</span>";
        html += "<span class='block__lead-subtitle'><b> : </b>" + JSON.stringify(contacts[key]) + "</span>";
        html += '</div>';
    }
    $('.all-params__add').html(html);
    $('.hook_link[name="string__values-input"]').val('');
    $('.hook_link[name="string__values-lead"]').val('');
});
$('.all-params__add').on('click', '.block__lead', function () {
    var id = $(this).attr('data-id');
    delete contacts[id];
    var html = '';
    for (var key in contacts){
        html += "<div class='block__lead' data-id='" + key + "'>";
        html += "<span class='block__lead-title'>" + key + "</span>";
        html += "<span class='block__lead-subtitle'><b> : </b>" + JSON.stringify(contacts[key]) + "</span>";
        html += '</div>';
    }
    $('.all-params__add').html(html);
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
    var getParams = (new URL(document.location)).searchParams,
        order_id = getParams.get('order_id'),
        amoCrm = 'Amo',
        configs = JSON.stringify(configObj);
    $.ajax({
        url: 'create-integration',
        dataType: 'JSON',
        type: 'POST',
        data: {type_integration: amoCrm, config: configs, order_id:order_id}
    }).done(function(rsp) {
        console.log(rsp)
        Swal.fire({
            icon: 'success',
            title: 'Успех!',
            html: "Сохранено",
        });
    });
});
