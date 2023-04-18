$(document).ready(function () {

    var hash = location.hash,
        search = location.search,
        headerLink = $('.header--link'),
        tab = $('.tab'),
        tab6 = $('.tab6'),
        tab5 = $('.tab5'),
        bSetCardBack = $('.banks--set-card-back'),
        setCard = $('.banks--set-card'),
        container;
    if (hash === '#tab1' || hash === '') {
        container = 'case_in_work';
    } else if (hash === '#tab2') {
        container = 'aspb';
    } else if (hash === '#tab3') {
        container = 'primary_department';
    } else if (hash === '#tab4') {
        container = 'case_aspb';
    } else if (hash === '#tab5') {
        container = 'bank_withdrawals';
    } else if (hash === '#tab6') {
        container = 'withdrawal_register';
    } else if (hash === '#tab7') {
        container = 'debt_with';
    }
    if (search !== ''){
        location.search = '';
    }

    if (hash !== 0) {
        headerLink.each(function () {
            if (hash === $(this).attr('href')) {
                var tab = '.' + hash.substr(1);
                $(".tab").removeClass('active');
                $(tab).addClass('active');
                headerLink.removeClass('active');
                $(this).addClass('active');
            }
        });
    }

    var cont = $('#' + container);
    cont.on('click', '.pager_link-a', function () {
        var href = $(this).attr('href');
        $(this).attr('href', href + hash);
    });


    var intervals = setInterval(function () {
        var block = $('#' + container).children('.inputs-group-wrapper').children('.inputs-group'),
            sTop = block.scrollTop(),
            sLeft = block.scrollLeft();
        $.pjax.reload({container: '#' + container}).done(function () {
            $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollTop(sTop);
            $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollLeft(sLeft);
        });
    }, 60000);
    $('body').on('mousemove', function () {
        clearInterval(intervals);
        intervals = setInterval(function () {
            var block = $('#' + container).children('.inputs-group-wrapper').children('.inputs-group'),
                sTop = block.scrollTop(),
                sLeft = block.scrollLeft();
            $.pjax.reload({container: '#' + container}).done(function () {
                $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollTop(sTop);
                $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollLeft(sLeft);
            });
        }, 60000);
    });

    headerLink.on('click', function () {
        var tab = '.' + $(this).attr('href').substr(1);
        $(".tab").removeClass('active');
        $(tab).addClass('active');
        headerLink.removeClass('active');
        $(this).addClass('active');
        setTimeout(function () {
            location.reload();
        }, 1);

    });

    var scrollInterval;
    tab.on('mouseenter', '.scroll', function () {
        var scrollNow = $(this).parent().find('.inputs-group').scrollLeft();
        if ($(this).hasClass('right')) {
            scrollInterval = setInterval(function () {
                scrollNow = scrollNow + 4;
                $('.inputs-group').scrollLeft(scrollNow);
            }, 1);
        } else {
            scrollInterval = setInterval(function () {
                scrollNow = scrollNow - 4;
                $('.inputs-group').scrollLeft(scrollNow);
            }, 1);
        }
    });

    tab.on('click', '.scroll', function () {
        if ($(this).hasClass('right')) {
            $(this).parent().find('.inputs-group').scrollLeft(10000000);
        } else {
            $(this).parent().find('.inputs-group').scrollLeft(0);
        }
        clearInterval(scrollInterval);
    });

    tab.on('mouseleave', '.scroll', function () {
        clearInterval(scrollInterval);
    });

    $(".chosen-select").chosen({disable_search_threshold: 0});

    var caseSetId;
    tab.on('click', '.case--set', function () {
        $('.case--set-card-back').fadeIn(300);
        caseSetId = $(this);
    });
    $('.case--set-card-back').on('click', function (e) {
        var card = $('.case--set-card');
        if (!card.is(e.target) && card.has(e.target).length === 0) {
            $(this).fadeOut(300);
            caseSetId = '';
        }
    });

    tab.on('click', '.add--ay', function () {
        $('.ay--set-card-back').fadeIn(300);
    });
    $('.ay--set-card-back').on('click', function (e) {
        var card = $('.ay--set-card');
        if (!card.is(e.target) && card.has(e.target).length === 0) {
            $(this).fadeOut(300);
        }
    });

    tab.on('click', '.add--partner', function () {
        $('.partner--set-card-back').fadeIn(300);
    });
    $('.partner--set-card-back').on('click', function (e) {
        var card = $('.partner--set-card');
        if (!card.is(e.target) && card.has(e.target).length === 0) {
            $(this).fadeOut(300);
        }
    });
    tab.on('click', '.add--responsible', function () {
        $('.responsible--set-card-back').fadeIn(300);
    });
    $('.responsible--set-card-back').on('click', function (e) {
        var card = $('.responsible--set-card');
        if (!card.is(e.target) && card.has(e.target).length === 0) {
            $(this).fadeOut(300);
        }
    });
    tab6.on('click', '.add__withdrawals', function () {
        $('.withdrawals--set-card-back').fadeIn(300);
    });
    $('.withdrawals--set-card-back').on('click', function (e) {
        var card = $('.withdrawals--set-card');
        if (!card.is(e.target) && card.has(e.target).length === 0) {
            $(this).fadeOut(300);
        }
    });
    tab.on('click', '.add__remove', function () {
        $('.remove--set-card-back').fadeIn(300);
    });
    $('.remove--set-card-back').on('click', function (e) {
        var card = $('.remove--set-card');
        if (!card.is(e.target) && card.has(e.target).length === 0) {
            $(this).fadeOut(300);
        }
    });
    tab.on('click', '.add__helper', function () {
        $('.helper--set-card-back').fadeIn(300);
    });
    $('.helper--set-card-back').on('click', function (e) {
        var card = $('.helper--set-card');
        if (!card.is(e.target) && card.has(e.target).length === 0) {
            $(this).fadeOut(300);
        }
    });

    $('.confirm--case').on('click', function () {
        var caseNum = $('.input-case[name="case-number"]'),
            caseLink = $('.input-case[name="case-link"]'),
            link = caseSetId.parent().find('.case-link');

        link.text(caseNum.val());
        link.attr('href', caseLink.val());
        var str = {};
        str.number = caseNum.val();
        str.link = caseLink.val();
        var name = link.attr('data-name'),
            value = JSON.stringify(str),
            type = link.attr('data-type'),
            id = link.attr('data-id');

        caseNum.val('');
        caseLink.val('');
        $.ajax({
            url: '/aspb/main/save-params',
            type: 'POST',
            dataType: 'JSON',
            data: {name: name, val: value, id: id, type: type},
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (r) {
            $('.preloader').fadeOut(300);
            if (r.status !== 'success') {
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(r.message);
            }
        });
        $('.case--set-card-back').fadeOut();
    });

    $('.add__client').on('click', function () {
        $.ajax({
            url: '/aspb/main/add-client',
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (e) {
            $('.preloader').fadeOut(300);
            if (e.status === 'success') {
                var block = $('#' + container).children('.inputs-group-wrapper').children('.inputs-group'),
                    sTop = block.scrollTop(),
                    sLeft = block.scrollLeft();
                $.pjax.reload({container: '#' + container}).done(function () {
                    $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollTop(sTop);
                    $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollLeft(sLeft);
                });
            } else {
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(e.message);
            }
        });
    });
    $('.popup__error--close, .popup__error--confirm, .popup__error--back').on('click', function (e) {
        if (e.target === this) $('.popup__error--back').fadeOut(300);
    });
    tab.on('click', '.delete__client', function () {
        var id = $(this).attr('data-id');
        if (confirm('Вы уверены что хотите удалить этого клиента?') === true) {
            $.ajax({
                url: '/aspb/main/remove-client',
                type: 'POST',
                dataType: 'JSON',
                data: {id: id},
                beforeSend: function () {
                    $('.preloader').fadeIn(300);
                }
            }).done(function (e) {
                $('.preloader').fadeOut(300);
                if (e.status === 'success') {
                    var block = $('#' + container).children('.inputs-group-wrapper').children('.inputs-group'),
                        sTop = block.scrollTop(),
                        sLeft = block.scrollLeft();
                    $.pjax.reload({container: '#' + container}).done(function () {
                        $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollTop(sTop);
                        $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollLeft(sLeft);
                    });
                } else {
                    $('.popup__error--back').fadeIn(300);
                    $('.popup__error--text').text(e.message);
                }
            });
        }
    });


    $('.tab5, .tab7').on('click', '.delete__remove', function () {
        var id = $(this).attr('data-id');
        if (confirm('Вы уверены что хотите удалить этого клиента?') === true) {
            $.ajax({
                url: '/aspb/main/remove-remove',
                type: 'POST',
                dataType: 'JSON',
                data: {id: id},
                beforeSend: function () {
                    $('.preloader').fadeIn(300);
                }
            }).done(function (e) {
                $('.preloader').fadeOut(300);
                if (e.status === 'success') {
                    var block = $('#' + container).children('.inputs-group-wrapper').children('.inputs-group'),
                        sTop = block.scrollTop(),
                        sLeft = block.scrollLeft();
                    $.pjax.reload({container: '#' + container, async: false}).done(function () {
                        $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollTop(sTop);
                        $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollLeft(sLeft);
                    });
                } else {
                    $('.popup__error--back').fadeIn(300);
                    $('.popup__error--text').text(e.message);
                }
            });
        }
    });

    tab6.on('click', '.delete__withdrawals', function () {
        var id = $(this).attr('data-id');
        if (confirm('Вы уверены что хотите удалить этого клиента?') === true) {
            $.ajax({
                url: '/aspb/main/remove-withdrawal',
                type: 'POST',
                dataType: 'JSON',
                data: {id: id},
                beforeSend: function () {
                    $('.preloader').fadeIn(300);
                }
            }).done(function (e) {
                $('.preloader').fadeOut(300);
                if (e.status === 'success') {
                    var block = $('#' + container).children('.inputs-group-wrapper').children('.inputs-group'),
                        sTop = block.scrollTop(),
                        sLeft = block.scrollLeft();
                    $.pjax.reload({container: '#' + container}).done(function () {
                        $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollTop(sTop);
                        $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollLeft(sLeft);
                    });
                } else {
                    $('.popup__error--back').fadeIn(300);
                    $('.popup__error--text').text(e.message);
                }
            });
        }
    });

    $('select[name="status_affairs"]').on('change', function () {
        if ($(this).val() === 'Признан') {
            $(this).parent().next().removeClass('disabled');
        } else {
            $(this).parent().next().addClass('disabled');
        }

        if ($(this).val() === 'Завершено') {
            $(this).parent().parent().find('.input-wrapper-last').removeClass('disabled');
        } else {
            $(this).parent().parent().find('.input-wrapper-last').addClass('disabled');
        }
    });

    var caseDiffId;
    tab.on('click', '.case--diff', function () {
        caseDiffId = $(this).prev();
        $('select[name="income"]').attr('data-id', $(this).attr('data-id'));
        $('select[name="property_in_sale"]').attr('data-id', $(this).attr('data-id'));
        $('select[name="transactions_for_contesting"]').attr('data-id', $(this).attr('data-id'));
        $('select[name="active_creditors"]').attr('data-id', $(this).attr('data-id'));
        $('.case--diff-card-back').fadeIn(300);
    });

    tab.on('click', '.case--diff-card-back', function (e) {
        var card = $('.case--diff-card');
        if (!card.is(e.target) && card.has(e.target).length === 0) {
            caseDiffId = '';
            $(this).fadeOut(300);
        }
    });

    tab.on('click', '.confirm--diff-case', function (e) {
        var cIncome = +$('select[name="income"]').val();
        var cProperty = +$('select[name="property_in_sale"]').val();
        var cDeals = +$('select[name="transactions_for_contesting"]').val();
        var cCreditors = +$('select[name="active_creditors"]').val();

        var summ = cIncome + cProperty + cDeals + cCreditors;
        caseDiffId.text(summ);
        $('.case--diff-card-back').fadeOut(300);
    });

    tab.on('change', '.input-send', function () {
        var name = $(this).attr('name'),
            value = $(this).val(),
            type = $(this).attr('data-type'),
            id = $(this).attr('data-id');
        $.ajax({
            url: '/aspb/main/save-params',
            type: 'POST',
            dataType: 'JSON',
            data: {name: name, val: value, id: id, type: type},
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (r) {
            $('.preloader').fadeOut(300);
            if (r.status !== 'success') {
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(r.message);
            }
        });
    });

    tab6.on('change', '.input-removing', function () {
        var name = $(this).attr('name'),
            value = $(this).val(),
            type = $(this).attr('data-type'),
            id = $(this).attr('data-id');
        $.ajax({
            url: '/aspb/main/save-withdrawal',
            type: 'POST',
            dataType: 'JSON',
            data: {name: name, val: value, id: id, type: type},
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (r) {
            $('.preloader').fadeOut(300);
            if (r.status !== 'success') {
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(r.message);
            }
        });
    });
    tab5.on('change', '.input-removing', function () {
        var name = $(this).attr('name'),
            value = $(this).val(),
            type = $(this).attr('data-type'),
            id = $(this).attr('data-id');
        $.ajax({
            url: '/aspb/main/save-removing',
            type: 'POST',
            dataType: 'JSON',
            data: {name: name, val: value, id: id, type: type},
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (r) {
            $('.preloader').fadeOut(300);
            if (r.status !== 'success') {
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(r.message);
            }
        });
    });
    $('.add__ay').on('click', function () {
        $.ajax({
            url: '/aspb/main/add-ay',
            type: 'POST',
            dataType: 'JSON',
            data: {
                ay__fio: $('input[name="ay__fio"]').val(),
                reg_number: $('input[name="reg_number"]').val(),
                address: $('input[name="address"]').val(),
                email: $('input[name="email"]').val()
            },
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (e) {
            $('.preloader').fadeOut(300);
            $('input[name="ay__fio"]').val('');
            if (e.status === 'success') {
                var block = $('#' + container).children('.inputs-group-wrapper').children('.inputs-group'),
                    sTop = block.scrollTop(),
                    sLeft = block.scrollLeft();
                $.pjax.reload({container: '#' + container}).done(function () {
                    $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollTop(sTop);
                    $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollLeft(sLeft);
                });
                $('.ay--set-card-back').fadeOut(300);
            } else {
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(e.message);
            }
        });
    });
    $('.calc').on('change', function () {
        var id = $(this).attr('data-id'),
            pay = $('#calc1-' + id).val(),
            paid = $('#calc2-' + id).val();
        if (pay !== 0 && paid !== 0) {
            $('#calc-result-' + id).val(pay - paid);
        }
    });
    $('.additiondl_calc').on('change', function () {
        var id = $(this).attr('data-id'),
            pay = $('#additional_payments_pay-' + id).val(),
            paid = $('#additional_payments_paid-' + id).val();
        if (pay !== 0 && paid !== 0) {
            $('#result_additiondl_calc-' + id).val(pay - paid);
        }
    });
    $('.add__partner').on('click', function () {
        $.ajax({
            url: '/aspb/main/add-partner',
            type: 'POST',
            dataType: 'JSON',
            data: {partner__fio: $('input[name="partner__fio"]').val()},
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (e) {
            $('.preloader').fadeOut(300);
            $('input[name="partner__fio"]').val('');
            if (e.status === 'success') {
                var block = $('#' + container).children('.inputs-group-wrapper').children('.inputs-group'),
                    sTop = block.scrollTop(),
                    sLeft = block.scrollLeft();
                $.pjax.reload({container: '#' + container}).done(function () {
                    $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollTop(sTop);
                    $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollLeft(sLeft);
                });
                $('.partner--set-card-back').fadeOut(300);
            } else {
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(e.message);
            }
        });
    });
    $('.add__responsible').on('click', function () {
        $.ajax({
            url: '/aspb/main/add-responsible',
            type: 'POST',
            dataType: 'JSON',
            data: {responsible__fio: $('input[name="responsible__fio"]').val()},
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (e) {
            $('.preloader').fadeOut(300);
            $('input[name="responsible__fio"]').val('');
            if (e.status === 'success') {
                var block = $('#' + container).children('.inputs-group-wrapper').children('.inputs-group'),
                    sTop = block.scrollTop(),
                    sLeft = block.scrollLeft();
                $.pjax.reload({container: '#' + container}).done(function () {
                    $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollTop(sTop);
                    $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollLeft(sLeft);
                });
                $('.responsible--set-card-back').fadeOut(300);
            } else {
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(e.message);
            }
        });
    });
    $('.add__helpers').on('click', function () {
        $.ajax({
            url: '/aspb/main/add-helpers',
            type: 'POST',
            dataType: 'JSON',
            data: {
                helper__fio: $('input[name="helper__fio"]').val(),
                helper__phone: $('input[name="helper__phone"]').val()
            },
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (e) {
            $('.preloader').fadeOut(300);
            $('input[name="helper__fio"]').val('');
            $('input[name="helper__phone"]').val('');
            if (e.status === 'success') {
                var block = $('#' + container).children('.inputs-group-wrapper').children('.inputs-group'),
                    sTop = block.scrollTop(),
                    sLeft = block.scrollLeft();
                $.pjax.reload({container: '#' + container}).done(function () {
                    $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollTop(sTop);
                    $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollLeft(sLeft);
                });
                $('.helper--set-card-back').fadeOut(300);
            } else {
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(e.message);
            }
        });
    });
    $('.add__remove-send').on('click', function () {
        $.ajax({
            url: '/aspb/main/add-remove',
            data: {id: $('select[name="removes__add"]').val()},
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (r) {
            if (r.status === 'success') {
                location.reload();
            } else {
                $('.preloader').fadeOut(300);
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(r.message);
            }
        });
    });
    $('.add__withdrawals-send').on('click', function () {
        $.ajax({
            url: '/aspb/main/add-withdrawals',
            data: {id: $('select[name="withdrawals__add"]').val()},
            type: 'POST',
            dataType: 'JSON',
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (r) {
            if (r.status === 'success') {
                location.reload();
            } else {
                $('.preloader').fadeOut(300);
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(r.message);
            }
        });
    });
    $('.tab1').on('change', '.input-sends', function () {
        var val = {},
            id = $(this).attr('data-id');
        val.send = $('#additional_documents_send-' + id).val();
        val.get = $('#additional_documents_get-' + id).val();
        var name = 'additional_documents',
            value = JSON.stringify(val),
            type = $(this).attr('data-type');
        $.ajax({
            url: '/aspb/main/save-params',
            type: 'POST',
            dataType: 'JSON',
            data: {name: name, val: value, id: id, type: type},
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (r) {
            $('.preloader').fadeOut(300);
            if (r.status !== 'success') {
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(r.message);
            }
        });
    });
    $('.save__komersant--info').on('change', function () {
        var val = {},
            id = $(this).attr('data-id');
        val.summ = $('#kommersant_paid--summ-' + id).val();
        val.date = $('#kommersant_paid--date-' + id).val();
        var name = 'kommersant_paid',
            value = JSON.stringify(val),
            type = $(this).attr('data-type');
        $.ajax({
            url: '/aspb/main/save-params',
            type: 'POST',
            dataType: 'JSON',
            data: {name: name, val: value, id: id, type: type},
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (r) {
            $('.preloader').fadeOut(300);
            if (r.status !== 'success') {
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(r.message);
            }
        });
    });

    tab.on('click', '.family--set', function () {
        $(this).prev().fadeIn(300);
    });
    $('.family--set-card-back').on('click', function (e) {
        var card = $('.family--set-card');
        if (!card.is(e.target) && card.has(e.target).length === 0) {
            $(this).fadeOut(300);
        }
    });

    /*----BANKS----*/
    tab5.on('click', '.banks--sets', function () {
        var id = $(this).attr('data-id')
        $.ajax({
            url: '/aspb/main/show-bank',
            data: {id: id},
            type: 'POST',
        }).done(function (r) {
            $('.sets__banks').html(r);
            bSetCardBack.fadeIn(300);
        });
    });

    bSetCardBack.on('click', function (e) {
        var card = $('.banks--set-card')
        if (!card.is(e.target) && card.has(e.target).length === 0) {
            $(this).fadeOut(300);
        }
    });
    var banks = [];
    setCard.on('click', '.banks--set-add', function () {
        var count = $('input[name="bank_count"]'),
            bic = $('input[name="bank_bic"]'),
            bank = $('input[name="bank_name"]'),
            obj = {};
        obj.count = count.val();
        obj.bic = bic.val();
        obj.bank = bank.val();
        banks.push(JSON.stringify(obj));
        $.ajax({
            url: '/aspb/main/set-bank',
            data: {banks: banks, id: $(this).attr('data-id')},
            type: 'POST',
        }).done(function (r) {
            $('.sets__banks').html(r);
        })
        count.val('');
        bic.val('');
        bank.val('');
    });
    setCard.on('click', '.banks--remove', function () {
        $.ajax({
            url: '/aspb/main/remove-bank',
            data: {id: $(this).attr('data-id'), id_bank: $(this).attr('data-bank')},
            type: 'POST',
        }).done(function (r) {
            $('.sets__banks').html(r);
        })
    });
    /*----BANKS----*/
    /*----REQUISITES----*/
    tab5.on('click', '.requisites--set', function () {
        var id = $(this).attr('data-id')
        $.ajax({
            url: '/aspb/main/show-requisites',
            data: {id: id},
            type: 'POST',
        }).done(function (r) {
            $('.sets__banks').html(r);
            bSetCardBack.fadeIn(300);
        });
    });
    var requisites = [];
    setCard.on('click', '.requisites--set-add', function () {
        var count = $('input[name="requisites_count"]'),
            bic = $('input[name="requisites_bic"]'),
            bank = $('input[name="requisites_name"]'),
            fio = $('input[name="requisites_fio"]'),
            obj = {};
        obj.count = count.val();
        obj.bic = bic.val();
        obj.bank = bank.val();
        obj.fio = fio.val();
        requisites.push(JSON.stringify(obj));
        $.ajax({
            url: '/aspb/main/set-requisites',
            data: {requisites: requisites, id: $(this).attr('data-id')},
            type: 'POST',
        }).done(function (r) {
            $('.sets__banks').html(r);
        })
        count.val('');
        bic.val('');
        bank.val('');
        fio.val('');
    });
    setCard.on('click', '.requisites--remove', function () {
        $.ajax({
            url: '/aspb/main/remove-requisites',
            data: {id: $(this).attr('data-id'), id_bank: $(this).attr('data-bank')},
            type: 'POST',
        }).done(function (r) {
            $('.sets__banks').html(r);
        })
    });
    /*----REQUISITES----*/
    /*----INCOMES----*/
    tab5.on('click', '.incomes--set', function () {
        var id = $(this).attr('data-id')
        $.ajax({
            url: '/aspb/main/show-incomes',
            data: {id: id},
            type: 'POST',
        }).done(function (r) {
            $('.sets__banks').html(r);
            bSetCardBack.fadeIn(300);
        });
    });
    var incomes = [];
    setCard.on('click', '.incomes--set-add', function () {
        var name = $('input[name="incomes_name"]'),
            summ = $('input[name="incomes_summ"]'),
            obj = {};
        obj.name = name.val();
        obj.summ = summ.val();
        incomes.push(JSON.stringify(obj));
        $.ajax({
            url: '/aspb/main/set-incomes',
            data: {incomes: incomes, id: $(this).attr('data-id')},
            type: 'POST',
        }).done(function (r) {
            $('.sets__banks').html(r);
        })
        name.val('');
        summ.val('');
    });
    setCard.on('click', '.incomes--remove', function () {
        $.ajax({
            url: '/aspb/main/remove-incomes',
            data: {id: $(this).attr('data-id'), id_bank: $(this).attr('data-bank')},
            type: 'POST',
        }).done(function (r) {
            $('.sets__banks').html(r);
        })
    });
    /*----INCOMES----*/

    /*----TAB6----*/
    tab6.on('click', '.banks--sets', function () {
        var id = $(this).attr('data-id')
        $.ajax({
            url: '/aspb/main/show-bank-info',
            data: {id: id},
            type: 'POST',
        }).done(function (r) {
            $('.sets__banks').html(r);
            bSetCardBack.fadeIn(300);
        });
    });
    tab6.on('click', '.requisites--set', function () {
        var id = $(this).attr('data-id')
        $.ajax({
            url: '/aspb/main/show-requisites-info',
            data: {id: id},
            type: 'POST',
        }).done(function (r) {
            $('.sets__banks').html(r);
            bSetCardBack.fadeIn(300);
        });
    });

    bSetCardBack.on('click', function (e) {
        var card = $('.banks--set-card');
        if (!card.is(e.target) && card.has(e.target).length === 0) {
            $(this).fadeOut(300);
        }
    });
    /*----TAB6----*/

    $('.input-konk').on('change', function () {
        var val = {},
            id = $(this).attr('data-id');
        val.summ = $('#konk-mass-' + id).val();
        val.date = $('#konk-date-' + id).val();
        var name = 'bankruptcy_estate_distributed',
            value = JSON.stringify(val),
            type = $(this).attr('data-type');
        $.ajax({
            url: '/aspb/main/save-removing',
            type: 'POST',
            dataType: 'JSON',
            data: {name: name, val: value, id: id, type: type},
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (r) {
            $('.preloader').fadeOut(300);
            if (r.status !== 'success') {
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(r.message);
            }
        });
    });
    $('.rest-send').on('change', function () {
        var val = {},
            id = $(this).attr('data-id');
        val.summ = $('#rest-summ-' + id).val();
        val.date = $('#rest-date-' + id).val();
        var name = 'rest_transferred_debtor',
            value = JSON.stringify(val),
            type = $(this).attr('data-type');
        $.ajax({
            url: '/aspb/main/save-removing',
            type: 'POST',
            dataType: 'JSON',
            data: {name: name, val: value, id: id, type: type},
            beforeSend: function () {
                $('.preloader').fadeIn(300);
            }
        }).done(function (r) {
            $('.preloader').fadeOut(300);
            if (r.status !== 'success') {
                $('.popup__error--back').fadeIn(300);
                $('.popup__error--text').text(r.message);
            }
        });
    });

    tab6.on('change', '.pb-deb', function () {
        setTimeout(function () {
            var block = $('#' + container).children('.inputs-group-wrapper').children('.inputs-group'),
                sTop = block.scrollTop(),
                sLeft = block.scrollLeft();
            $.pjax.reload({container: '#' + container}).done(function () {
                $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollTop(sTop);
                $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollLeft(sLeft);
            });
        }, 300)
    });


    $('#aspb_searchform').on('submit', function (e) {
        e.preventDefault();
        var block = $('#' + container).children('.inputs-group-wrapper').children('.inputs-group'),
            sTop = block.scrollTop(),
            sLeft = block.scrollLeft();
        $.pjax.reload({
            container: '#' + container,
            data: $(this).serialize(),
            type: 'POST'
        }).done(function () {
            $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollTop(sTop);
            $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollLeft(sLeft);
        });
    });

    $(tab).on('change', '.sort__btn', function () {
        $('#aspb_searchform').submit();
    });

    $(document).on('keydown', function (e) {
        if (e.keyCode === 116){
            e.preventDefault();
            var block = $('#' + container).children('.inputs-group-wrapper').children('.inputs-group'),
                sTop = block.scrollTop(),
                sLeft = block.scrollLeft();
            $.pjax.reload({container: '#' + container}).done(function () {
                $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollTop(sTop);
                $(this).children('.inputs-group-wrapper').children('.inputs-group').scrollLeft(sLeft);
            });
        }
    })

});