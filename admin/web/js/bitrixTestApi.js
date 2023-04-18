var
    fields = [],
    globalURL = '',
    urlCheck2 = $('.integration-btn-bitrix[data-type="urlCheck"]'),
    paramsBlock = $('.params-bitrix-block');
urlCheck2.on('click', function () {
    var
        url = $('.input-bitrix').val(),
        urlCheck = null;
    try {
        urlCheck = new URL(url);
    } catch (e) {
        console.log(e);
    }
    if (urlCheck === null) {
        Swal.fire({
            icon: 'error',
            title: 'Ошибка',
            text: "Указанный вебхук Битрикс24 не является валидным URL-адресом",
        });
    } else {
        var
            newUrl = urlCheck.origin,
            splits = urlCheck.pathname.split('/');
        for (var i = 1; i < splits.length; i++) {
            newUrl += "/" + splits[i];
            if (i === 3)
                break;
        }
        globalURL = newUrl;
        console.log(newUrl);
        $('#integrations-url').val(newUrl);
        $.ajax({
            url: newUrl + "/crm.lead.fields",
            dataType: "JSON"
        }).done(function(e){
            if (e.result === undefined) {
                Swal.fire({
                    icon: 'error',
                    title: 'ОШИБКА',
                    text: "Вероятно, указанная ссылка не является валидным вебхуком Битрикс24",
                });
            } else {
                fields = e.result;
                Swal.fire({
                    icon: 'success',
                    title: 'ОК',
                    text: "Ссылка на вебхук корректная, и имеет необходимые привилегии",
                });
                var html = "<p style='padding-left: 10px;'><b>Поля лидов:</b></p><div style='display: flex; flex-wrap: wrap; padding-left: 5px'>";
                for (var key in fields) {
                    if (fields[key].isReadOnly === true)
                        continue;
                    html += "<div class='generated-flex'><div><b class='click-key-add-bitrix'>"+ key +"</b>: ";
                    if (fields[key].listLabel !== undefined)
                        html += fields[key].listLabel +"</div>";
                    else
                        html += fields[key].title +"</div>";
                    if (fields[key].type === 'enumeration') {
                        html += "<div>";
                        for (var keyItem in fields[key].items) {
                            html += "<span style='font-size: 11px'>";
                            html += "<i>" + fields[key].items[keyItem].VALUE + "</i>: <b>" + fields[key].items[keyItem].ID + "</b>";
                            html += ", </span>";
                        }
                        html += "</div>";
                    }
                    html += "</div>";
                }
                html += "</div>";
                $.ajax({
                    url: newUrl + "/crm.status.entity.items?entityId=SOURCE",
                    dataType: "JSON"
                }).done(function (rsp) {
                    if (rsp.result !== undefined) {
                        html += "<div style='margin-top: 10px; padding: 0 10px;'><p><b>Источники:</b></p><div style='display: flex; flex-wrap: wrap'>";
                            for (var i = 0; i < rsp.result.length; i++) {
                                html += "<div class='source-bitrix-block'><b class='sbb-b' data-id='"+ rsp.result[i].STATUS_ID +"'>"+ rsp.result[i].NAME +":</b> "+ rsp.result[i].STATUS_ID +"</div>";
                            }
                        html += "</div><div style='margin-top: 10px;' class='btn btn-admin-help addSourceFemida'>Добавить источник Lead.Force</div></div>";
                        $.ajax({
                            url: newUrl + "/crm.status.entity.items?entityId=STATUS",
                            dataType: "JSON"
                        }).done(function (rsp2) {
                            if (rsp2.result !== undefined) {
                                html += "<div style='margin-top: 10px; padding: 0 10px;'><p><b>Статусы лидов:</b></p><div style='display: flex; flex-wrap: wrap'>";
                                for (var i = 0; i < rsp2.result.length; i++) {
                                    html += "<div class='status-bitrix-block'><b class='stbb-b' data-id='"+ rsp2.result[i].STATUS_ID +"'>"+ rsp2.result[i].NAME +":</b> "+ rsp2.result[i].STATUS_ID +"</div>";
                                }
                                html += "</div></div>";
                                paramsBlock.html(html).css('border', '1px solid gainsboro').css('padding', '10px');
                                console.log($('#integrations-url').val());
                            }
                        });
                    }
                });
            }
        }).fail(function (x) {
            if (x.responseJSON !== undefined && x.responseJSON.error_description !== undefined) {
                Swal.fire({
                    icon: 'error',
                    title: 'Код ошибки BITRIX24:',
                    text: x.responseJSON.error_description,
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'ОШИБКА',
                    text: "Вероятно, указанная ссылка не принадлежит к доменной зоне Битрикс24 или не является валидным вебхуком Битрикс24",
                });
            }
        });
    }
});
paramsBlock.on('click', '.addSourceFemida', function () {
    $.ajax({
        url: globalURL + "/crm.status.add?fields[ENTITY_ID]=SOURCE&fields[STATUS_ID]=LeadForce&fields[NAME]=Lead.Force&fields[SORT]=10000",
        dataType: "JSON"
    }).done(function (x) {
        if (x.result !== undefined) {
            urlCheck2.trigger('click');
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Код ошибки BITRIX24:',
                text: x.error_description,
            });
        }
    }).fail(function (x) {
        Swal.fire({
            icon: 'error',
            title: 'Код ошибки BITRIX24:',
            text: x.responseJSON.error_description,
        });
    });
});