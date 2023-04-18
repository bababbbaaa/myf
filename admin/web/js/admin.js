$(document).ready(function () {

    /*GLOBALS start*/

    var
        adminBurger = $('.topline-burger span'),
        hiddenMenu = $('.hidden-menu'),
        rbacOpen = $('.open-rbac-page'),
        appendBtn = $('.append-btn'),
        textToLink = $('#textToLink'),
        linkToText = $('#linkText'),
        form = $('form'),
        composedObjectBase = $('.composed-object'),
        objectInputClass = '.object-admin-input',
        prevent = $('.preventDefault'),
        actionStart = $('.actionBtn'),
        closeModal = $('.close-modal-admin'),
        modal = $('.admin-simple-modal-bg'),
        modal2 = $('.admin-simple-modal-bg-2'),
        modal3 = $('.admin-simple-modal-bg-3'),
        orderAction = $('.succeed-action-order'),
        globalTimeout = null;

    /*GLOBALS end*/

    /*function declaration part start*/

    function createLink ( str ) {
        var ru = {
            'а': 'a', 'б': 'b', 'в': 'v', 'г': 'g', 'д': 'd',
            'е': 'e', 'ё': 'e', 'ж': 'j', 'з': 'z', 'и': 'i',
            'к': 'k', 'л': 'l', 'м': 'm', 'н': 'n', 'о': 'o',
            'п': 'p', 'р': 'r', 'с': 's', 'т': 't', 'у': 'u',
            'ф': 'f', 'х': 'h', 'ц': 'c', 'ч': 'ch', 'ш': 'sh',
            'щ': 'shch', 'ы': 'y', 'э': 'e', 'ю': 'u', 'я': 'ya'
        }, n_str = [];
        str = str.replace(/[ъь]+/g, '').replace(/й/g, 'i');
        for ( var i = 0; i < str.length; ++i ) {
            n_str.push(
                ru[ str[i] ]
                || ru[ str[i].toLowerCase() ] === undefined && str[i]
                || ru[ str[i].toLowerCase() ].replace(/^(.)/, function ( match ) { return match.toUpperCase() })
            );
        }
        return n_str.join('');
    }

    /*function declaration part end*/

    $(window).on({
        resize: function () {
            hiddenMenu.hide();
        },
        click: function (e) {
            if (e.target !== adminBurger[0])
                hiddenMenu.hide();
        }
    });

    adminBurger.on('click', function () {
        hiddenMenu.slideToggle(250);
    });

    rbacOpen.on('click', function () {
        var url = $(this).attr('data-url');
        window.open(url, "_self");
    });

    textToLink.on('input',function() {
        var j = createLink($(this).val());
        j = j.replace(/ /g, '-');
        j = j.replace(/,-/g, '-');
        j = j.replace(/\\/g, '-');
        j = j.replace(/\//g, '-');
        linkToText.val(j.toLowerCase());
    });

    appendBtn.on('click', function () {
        var
            block = $(this).attr('data-append-block'),
            param = $(this).attr('data-append-param'),
            key = $(this).attr('data-append-key');
        $(block).append('<div><input class="object-admin-input" type="text" name="'+param+'['+key+'][]" placeholder="Укажите значение для пункта списка"></div>');
    });

    function goSaveData() {
        var
            objectInput = $(objectInputClass);
        if (globalTimeout !== null && globalTimeout !== undefined)
            clearTimeout(globalTimeout);
        globalTimeout = setTimeout(function () {
            var
                dynamic = {};
            objectInput.each(function () {
                var
                    attrName = $(this).attr('name'),
                    attrValue = $(this).val(),
                    reg = attrName.match(/(\w+)\[(\w+)]/),
                    propName = reg[1],
                    keyName = reg[2];
                if (dynamic[propName] === undefined)
                    dynamic[propName] = {};
                if (reg.input.indexOf('[]') !== -1) {
                    if (dynamic[propName][keyName] === undefined)
                        dynamic[propName][keyName] = [];
                    dynamic[propName][keyName].push(attrValue);
                } else
                    dynamic[propName][keyName] = attrValue;
            });
            composedObjectBase.text(JSON.stringify(dynamic));
        }, 100);
    }
    var checkSave = false;
    $('.save-btn-special-query').on('submit', function (e) {
        if (checkSave === false) {
            e.preventDefault();
            var form00 = $(this);
            goSaveData();
            setTimeout(function () {
                checkSave = true;
                form00.submit();
            }, 300);
        }
    });

    form.on({
        input: function () {
            goSaveData();
        },
        selector: $(objectInputClass)
    });

    prevent.on('click', function (e) {
        e.preventDefault();
    });

    actionStart.on('click', function () {
        var action = $(this).attr('href');
        switch (action) {
            case 'excel-export':
            case 'delete-selected':
            case 'submit-waste':
            case 'cc-send':
                var keys = [];
                $('.selected-tr').each(function () {
                    var key = $(this).attr('data-key');
                    keys.push(key);
                });
                if (keys.length > 0)
                    keys = JSON.stringify(keys);
                else
                    keys = null;
                $.ajax({
                    data: {keys: keys},
                    url: action,
                    dataType: "JSON",
                    type: "POST",
                    beforeSend: function () {
                        $('.preloader-ajax-forms').fadeIn(100);
                    }
                }).done(function (rsp) {
                    $('.preloader-ajax-forms').fadeOut(100);
                    if (rsp.status === 'success') {
                        if (rsp.url !== 'refresh')
                            window.open(rsp.url, '_blank');
                        else
                            $('.grid-view').yiiGridView('applyFilter');
                    }
                    else
                        Swal.fire({
                            icon: 'error',
                            title: 'Ошибка',
                            text: rsp.message
                        });
                });
                break;
            case 'mass-export':
            case 'set-operator':
                orderAction.attr('data-action', action);
                modal.css('display', 'flex');
                break;
            case 'interval-query':
                orderAction.attr('data-action', action);
                modal2.css('display', 'flex');
                break;
            case 'auction-send':
                orderAction.attr('data-action', action);
                modal3.css('display', 'flex');
                break;
            case 'select-all':
                var tr = $('.leads-row');
                tr.removeClass('selected-tr').addClass('selected-tr');
                break;
            case 'show-unsent':
                location.href = location.href + "&LeadsSearch[id]=не отправлен";
                break;
            case 'await':
                location.href = "index?CcLeadsSearch[showAwait]=1";
                break;
            case 'cc-check-show':
                location.href = location.href + "&LeadsSearch[cc_check]=1";
                break;
            case 'show-waste':
                location.href = location.href + "&LeadsSearch[id]=брак";
                break;
            case 'excel-filtration-utm':
                location.href = "excel-filtration-utm";
                break;
            case 'import-txt':
            case 'import-xlsx':
            case 'import-excel':
                location.href = action;
                break;
            //case 'monthly-kpi':
            case 'monthly-kpi-v2':
                $.ajax({
                    url: "/lead-force/leads/" + action,
                    type: "GET",
                    dataType: "JSON",
                    beforeSend: function () {
                        $('.preloader-ajax-forms').fadeIn(100);
                    }
                }).done(function (xx) {
                    $('.preloader-ajax-forms').fadeOut(100);
                    if (xx.status === 'error') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ошибка',
                            text: xx.message
                        });
                    } else
                        location.href = xx.url;
                });
                break;
            case 'clear':
                location.href = "index";
                break;
            case 'utm-analysis':
                location.href = location.href + "&LeadsSearch[utm_analysis]=1";
                break;
            case 'excel-filter-export':
                window.open("excel-filtration", '_blank');
                break;
            case 'excel-filter-export-bd':
                window.open("excel-filtration-bd", '_blank');
                break;
            case 'open':
            case 'reset-leads':
                var ckeys = [];
                $('[name="check-one"]').each(function () {
                    var key = $(this).attr('data-id');
                    if ($(this).prop('checked')) {
                        ckeys.push(key);
                    }
                });
                if (ckeys.length > 0)
                    ckeys = JSON.stringify(ckeys);
                else
                    ckeys = null;
                $.ajax({
                    data: {keys: ckeys},
                    url: action,
                    dataType: "JSON",
                    type: "POST",
                    beforeSend: function () {
                        $('.preloader-ajax-forms').fadeIn(100);
                    }
                }).done(function (rsp) {
                    $('.preloader-ajax-forms').fadeOut(100);
                    if (rsp.status === 'success') {
                        if (rsp.url !== 'refresh')
                            window.open(rsp.url, '_blank');
                        else {
                            $('.grid-view').yiiGridView('applyFilter');
                        }
                    }
                    else
                        Swal.fire({
                            icon: 'error',
                            title: 'Ошибка',
                            text: rsp.message
                        });
                });
                break;
        }
    });

    closeModal.on('click', function (e) {
        if (e.target.classList.value.indexOf('close-modal-admin') !== -1) {
            modal.hide();
            modal2.hide();
            modal3.hide();
        }
    });

    orderAction.on('click', function () {
        var
            keys = [],
            data = {},
            action = $(this).attr('data-action');
        if (action === 'set-operator') {
            $('[name="check-one"]:checked').each(function () {
                var key = $(this).attr('data-id');
                keys.push(key);
            });
        } else {
            $('.selected-tr').each(function () {
                var key = $(this).attr('data-key');
                keys.push(key);
            });
        }
        if (keys.length > 0)
            keys = JSON.stringify(keys);
        else
            keys = null;
        switch (action) {
            default:
            case 'mass-export':
                data.keys = keys;
                data.order = $('#selectOrder').val();
                break;
            case 'set-operator':
                data.keys = keys;
                data.op = $('#selectOP').val();
                break;
            case 'interval-query':
                data.keys = keys;
                data.order = $('#selectOrder_2').val();
                data.start_time = $('#selectOrder_start').val();
                data.interval = $('#selectOrder_interval').val();
                break;
            case 'auction-send':
                data.keys = keys;
                data.price = $('#inputAuctionPrice').val();
                break;
        }
        $.ajax({
            data: data,
            url: action,
            dataType: "JSON",
            type: "POST",
            beforeSend: function () {
                $('.preloader-ajax-forms').fadeIn(100);
            }
        }).done(function (rsp) {
            $('.preloader-ajax-forms').fadeOut(100);
            if (rsp.status === 'success') {
                location.reload();
            }
            else
                Swal.fire({
                    icon: 'error',
                    title: 'Ошибка',
                    text: rsp.message
                });
        });
    });

    $('.fade-sidebar').on('click', function () {
        $.ajax({
            url: "/site/fade-sidebar",
            data: {fade: 1},
            type: "POST",
        }).done(function () {
            location.reload();
        });
    });

    $('.hvp').on('click', function () {
        $('.preloader-ajax-forms').fadeIn(100);
    });


});