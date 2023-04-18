$(document).ready(function () {
    $.mask.definitions["9"] = false;
    $.mask.definitions["5"] = "[0-9]";
    $("input[type=tel]")
        .mask("+7(955) 555-5555")
        .on("click", function () {
            //$(this).trigger("focus");
        });

    $('input[name="info[jur][inn]"]').mask('55555 55555').on("click", function (e) {
        e.preventDefault();
        //$(this).trigger("focus");
    });
    $('input[name="info[jur][ogrn]"]').mask('55555 55555 555?55').on("click", function () {
        //$(this).trigger("focus");
    });
    $('input[name="info[jur][kpp]"]').mask('55555 5555').on("click", function () {
        //$(this).trigger("focus");
    });
    $('input[name="info[jur][bik]"]').mask('55555 5555').on("click", function () {
        //$(this).trigger("focus");
    });
    $('input[name="info[jur][rs]"]').mask('55555 55555 55555 55555').on("click", function () {
        //$(this).trigger("focus");
    });
    $('input[name="info[jur][ks]"]').mask('55555 55555 55555 55555').on("click", function () {
        //$(this).trigger("focus");
    });

    // cabinet //
    /*var balanceTop = $(".Hcont_R_Balance-t span").text();
    $(".item__summ").text(parseInt(balanceTop));*/

    $(".mass__close").on("click", function () {
        var mass = $(this).parents(".mass");
        mass.hide();
    });

    //cabinet//
    var RName = 0;
    $(".Hcont_R_R-Name").on('click', function () {
        if (RName == 0) {
            $(".Hcont_R_R-Name-t").addClass('tclick');
            $(".User-Menu").addClass('menu-open');
            $(".User-Menu-Back").fadeIn(300);
            RName = 1;
        } else if (RName == 1) {
            $(".Hcont_R_R-Name-t").removeClass('tclick');
            $(".User-Menu").removeClass('menu-open');
            $(".User-Menu-Back").fadeOut(300);
            RName = 0;
        }
    });


    $(".BURGER-BTN").on('click', function () {
        $(".leftMenu-WRAP").addClass('menu-open');
        $(".BURGER-BACK").fadeIn(300);
        $('body').css({"overflow": "hidden"});
    });
    $(".BURGER-BACK").on('click', function () {
        $(".leftMenu-WRAP").removeClass('menu-open');
        $(".BURGER-BACK").fadeOut(300);
        $('body').css({"overflow": "auto"});
    });
    $('.toogle-pages').fadeOut(300);

    var IDAlength = 0;
    $(document).on('input', '.InputDonateAmount', function () {
        IDAlength = $(this).val().length;
        if (IDAlength >= 1) {
            $('.InputDonateAmount').addClass('validation');
        } else {
            $('.InputDonateAmount').removeClass('validation');
        }
    });
    var IDAlength2 = 0;
    $(document).on('input', '.InputDonateAmount2', function () {
        IDAlength2 = $(this).val().length;
        if (IDAlength2 >= 1) {
            $('.InputDonateAmount2').addClass('validation');
        } else {
            $('.InputDonateAmount2').removeClass('validation');
        }
    });

    // $('input[type="checkbox"]').styler();

    $('.PopapDBC_Form').on('submit', function (e) {
        $.ajax({
            url: "send.php",
            method: "POST",
            data: $(".PopapDBC_Form").serialize(),
            beforeSend: function () {
            },
        });
        e.preventDefault();
    });
    $('.PopapDCD_Form').on('submit', function (e) {
        $.ajax({
            url: "send.php",
            method: "POST",
            data: $(".PopapDCD_Form").serialize(),
            beforeSend: function () {
                $('.PopapDCD').fadeOut(300);
                setTimeout(function () {
                    $('.PopapDCD2').fadeIn(300);
                }, 300);
            },
        });
        e.preventDefault();
    });

    $('.PopapDBC_Form, .PopapDCD_Form').on('reset', function (e) {
        $('.jq-checkbox').removeClass('checked');
        $('.InputDonateAmount').removeClass('validation');
        $('.PopapBack').fadeOut(300);
        $('.PopapDBCWrap').fadeOut(300);
        $('.PopapDBC').fadeOut(300);
        $('.PopapDCD').fadeOut(300);
    });
    $('.Page1-Donate_BC').on('click', function () {
        $('.PopapBack').fadeIn(300);
        $('.PopapDBCWrap').fadeIn(300);
        $('.PopapDBC').fadeIn(300);
    });
    $('.PopapBack, .PopapExidIcon').on('click', function () {
        $('.PopapBack').fadeOut(300);
        $('.PopapDBCWrap').fadeOut(300);
        $('.PopapDBC').fadeOut(300);
    });
    $('.Page1-Donate_CL').on('click', function () {
        $('.PopapBack').fadeIn(300);
        $('.PopapDBCWrap').fadeIn(300);
        $('.PopapDCD').fadeIn(300);
    });
    $('.PopapBack, .PopapExidIcon, .PopapDCD2_Form-BTN').on('click', function () {
        $('.PopapBack').fadeOut(300);
        $('.PopapDBCWrap').fadeOut(300);
        $('.PopapDCD').fadeOut(300);
        $('.PopapDCD2').fadeOut(300);
    });
    $('.rty').on('click', function () {
        $('.PopapBack').fadeIn(300);
        $('.PopapDBCWrap').fadeIn(300);
        $('.PopapDCD-Error').fadeIn(300);
    });


    /*-----Появление попапа "Заполните профиль!"--------*/
    $('.PopapBack, .PopapExidIcon, .PopapDCD-Error-Reset').on('click', function () {
        $('.PopapBack').fadeOut(300);
        $('.PopapDBCWrap').fadeOut(300);
        $('.PopapDCD-Error').fadeOut(300);
    });
    /*---------------------------------*/

    $('.PopapDCD-Error_Form-BTN').on('click', function () {
        $('.PopapBack').fadeOut(300);
        $('.PopapDBCWrap').fadeOut(300);
        $('.PopapDCD-Error').fadeOut(300);
        //Переход на заполнение профиля
    });

    $('.MyOrders_filter-select').styler();

    $('.MyOrders_filter-reset').on('click', function () {
        $('.MyOrders_filter-check').removeClass('checked');
    });


    $('.popup__close, .popup__ov').on('click', function (e) {
        if (e.target === this) $('.popup').fadeOut(300);
    })

    $('.OrderPage_StatisticsFilter-Select').styler();

    $('.OrderPage_StatisticsFilter_top-label:first-child').addClass('active');
    $('.OrderPage_StatisticsFilter_top-label').on('click', function () {
        var number = $(this).children().attr('id');
        if ($(this).children().is(":checked")) {
            $('.OrderPage_StatisticsFilter_top-label').removeClass('active');
            $(this).addClass('active');
        }
        if (number == "radio2") {
            $('.OrderPage_StatisticsFilter_bottom').fadeIn(300);
        } else {
            $('.OrderPage_StatisticsFilter_bottom').fadeOut(300);
        }
    });

    $('.order-page_alert-zero-balance-close').click(function () {
        $(this).parent().slideUp(300);
    });

    $('.order-page_leads_tab1').fadeIn(0);
    $('.order-page_leads-tab').on('click', function () {
        $('.order-page_leads-tab').removeClass('active');
        $(this).addClass('active');
    });
    $('.leads_filter_checkbox').styler({});

    $('.leads_filter_checkbox').on('change', function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().find('.order-page_leads_name-1, .order-page_leads_name-2, .order-page_leads_name-3').css({
                "color": "#007FEA",
            });
            return false;
        } else {
            $(this).parent().parent().find('.order-page_leads_name-1, .order-page_leads_name-2, .order-page_leads_name-3').css({
                "color": "#2B3048",
            });
            return false;
        }
    });

    $('.leads_filter_maincheckbox').on('change', function () {
        if ($(this).is(':checked')) {
            $('.leads_filter_checkbox').prop('checked', true);
            $('.jq-checkbox').addClass('checked');
            $('.leads_filter_checkbox').parent().find('.order-page_leads_name-1, .order-page_leads_name-2, .order-page_leads_name-3').css({
                "color": "#007FEA",
            });
            return false;
        } else {
            $('.leads_filter_checkbox').prop('checked', false);
            $('.jq-checkbox').removeClass('checked');
            $('.leads_filter_checkbox').parent().find('.order-page_leads_name-1, .order-page_leads_name-2, .order-page_leads_name-3').css({
                "color": "#2B3048",
            });
            return false;
        }
    });


    $('.order-page_lead_popap_back, .order-page_lead_popap-close, .order-page_leads_filter_BTN-close').on('click', function () {
        $('.order-page_lead_popap_back').fadeOut(300);
        $('.order-page_lead_popap-wrap').fadeOut(300);
    });

    $('.PopapSelect').styler({});

    $('.order-page_leads_filter_BTN-go-brak, .order-page_leads_filter_BTN-go-brak').on('click', function () {
        $('.PopapBack').fadeIn(300);
        $('.Popap-go-brak, .Popap-go-brak1-1').fadeIn(300);
    });



    //табы;
    // $(".prof__nav--fix").on("click", '.prof__nav-li',function (e) {
    //     e.preventDefault();
    //     var val = $(this).text();
    //     $(".bcr__span").text(val);
    //
    //     $(".prof__nav-li").removeClass("active");
    //     $(".prof__item").removeClass("active");
    //
    //     $(this).addClass("active");
    //     $($(this).attr("href")).addClass("active");
    // });

    $(".prof__item-nav-li--1").on("click", function () {
        if ($('#box1').is(':checked')) {
            $('.boxe1').addClass('active');
            $('.boxe2').removeClass('active');
            $('.box2').fadeOut(300, function () {
                $('.box1').fadeIn(300);
            });
        }
        if ($('#box2').is(':checked')) {
            $('.boxe2').addClass('active');
            $('.boxe1').removeClass('active');
            $('.box1').fadeOut(300, function () {
                $('.box2').fadeIn(300);
            });
        }
        if ($('#box3').is(':checked')) {
            $('.boxe3').addClass('active');
            $('.boxe4').removeClass('active');
            $('.box4').fadeOut(300, function () {
                $('.box3').fadeIn(300);
            });
        }
        if ($('#box4').is(':checked')) {
            $('.boxe4').addClass('active');
            $('.boxe3').removeClass('active');
            $('.box3').fadeOut(300, function () {
                $('.box4').fadeIn(300);
            });
        }
    });


    $("a.prof__item-nav-li--2").on("click", function (e) {
        e.preventDefault();

        $("a.prof__item-nav-li--2").removeClass("active");
        $(".prof__item-box--2").removeClass("active");

        $(this).addClass("active");
        $($(this).attr("href")).addClass("active");
    });



    $('.prof__select').styler();


    $(".prof__add-btn4").on("click", function () {
        $(".popup--w2").show();
        $('.errors__texts2').text('');
        $("body").css("overflow", "hidden");
    });

    $(".prof__add-btn1").on("click", function () {
        $(".popup--w3").show();
        $('.errors__texts').text('');
        $("body").css("overflow", "hidden");
    });



    $(".prof__add-btn-push").on("click", function () {
        $(".popup--ok").show();
        $("body").css("overflow", "hidden");
    });




    // $(".popup__btn1").on("click", function () {
    //     var item = $(".prof__item-nav-li--1");
    //     var itemDel = item.not(".active");
    //     itemDel.hide();
    // });

    $(".popup__close, .popup__btn-close, .popup__btn-ok, .popup__btn--err").on("click", function () {
        $(".popup").fadeOut();
        $("body").css("overflow", "auto");
    });

    $('.popup__ov').click(function (e) {
        if ($(e.target).closest('.popup__body').length == 0) {
            $(".popup").fadeOut();
            $("body").css("overflow", "auto");
        }
    });

    var num = 1;

    $(".filters > .filters__btn").on("click", function () {
        var t = $(this);
        $(t).toggleClass("active");

        if ($(t).hasClass("active")) {
            if ($(".filters__num").hasClass("filters__num--visable")) {
                $(".filters__num").text(num++);
            } else {
                $(".filters__num").addClass("filters__num--visable");
                $(".filters__num").text(num++);
            }
        } else {
            if ($(".filters > .filters__btn").hasClass("active")) {
                $(".filters__num").text(--num - 1);
            } else {
                $(".filters__num").removeClass("filters__num--visable");
                $(".filters__num").text(num--);
            }
        }
    });




    $('.order-lid__input[name="lead_count"], .order-lid__input[name="summ-lid"]').on('input', function () {
        var err = 0;
        $('.first-step-create-valid').each(function () {
            if ($(this).val().length <= 0)  {
                err++;
            }
        });
        if (err > 0) {
            $(".order-lid__btn--1").prop('disabled', true);
            $(".add--3").prop('disabled', true);
        } else {
            $(".order-lid__btn--1").prop('disabled', false);
            $(".add--3").prop('disabled', false);
        }
    });

    $(".order-lid__btn--1").on("click", function () {
        var
            // inp1 = parseInt($("input[name='summ-lid']").val()),
            inp2 = parseInt($("input[name='lead_count']").val()),
            step = $(this).parents(".step"),
            nextStep = step.next(),
            err = 0,
            msg = '';
        // if (isNaN(inp1)) {
        //     err++;
        //     msg += 'Необходимо указать количество лидов в день<br>';
        // }
        if (isNaN(inp2)) {
            err++;
            msg += 'Необходимо указать количество лидов в день<br>';
        }
        // if(inp1 < 5) {
        //     err++;
        //     msg += 'Количество лидов в день - не менее пяти<br>';
        // }
        if(inp2 < 10) {
            err++;
            msg += 'Количество лидов в заказе - не менее десяти<br>';
        }
        // if(inp2/inp1 < 2) {
        //     err++;
        //     msg += "Количество лидов в день не должно быть более, чем 1:2 по отношению к числу лидов в заказе";
        // }
        if (err === 0) {
            $('.create-order-err-block').html('');
            step.hide();
            nextStep.show();
        } else {
            $('.create-order-err-block').html(msg);
            $(this).prop('disabled', true);
        }
    });

    $(".order-lid__main-select").styler();

    $("input[name='sfera']").keyup(function () {
        var sfera = $("input[name='sfera']").val();
        var lenSfera = sfera.length;

        if (sfera != 0 && lenSfera != 0) {
            $(".add--1").removeAttr("disabled");
        } else if (lenSfera == 0 || sfera == 0) {
            $(".add--1").attr('disabled', 'disabled');
        }
    });

    $(".add").on("click", function () {
        var
            inp1 = parseInt($("input[name='summ-lid']").val()),
            inp2 = parseInt($("input[name='price']").val()),
            step = $(this).parents(".step"),
            nextStep = step.next(),
            err = 0,
            msg = '';
        if (step[0].className === 'order-lid__step3 order-lid__step3--add step') {
            if (isNaN(inp1)) {
                err++;
                msg += 'Необходимо указать количество лидов в день<br>';
            }
            if (isNaN(inp2)) {
                err++;
                msg += 'Необходимо указать желаемую цену лида<br>';
            }
            if(inp1 < 5) {
                err++;
                msg += 'Количество лидов в день - не менее пяти<br>';
            }
            // if(inp2 < 10) {
            //     err++;
            //     msg += 'Количество лидов в заказе - не менее десяти<br>';
            // }
            // if(inp2/inp1 < 2) {
            //     err++;
            //     msg += "Количество лидов в день не должно быть более, чем 1:2 по отношению к числу лидов в заказе";
            // }
            if (err === 0) {
                $('.create-order-err-block').html('');
                step.hide();
                nextStep.show();
            } else {
                $('.create-order-err-block').html(msg);
                $(this).prop('disabled', true);
            }
        } else {
            $('.create-order-err-block').html('');
            step.hide();
            nextStep.show();
        }
    });


    $(".order-lid__main-select").change(function () {
        var opcion = $(this).val();
        $('.jq-selectbox__select-text').addClass('placeholder');
        $('.jq-selectbox__select-text').text('Выбирете');

        if (opcion === 'Краснодарский край') {
            $(".shose").show();
            $(".shose__inner--1").addClass("active");
            $(".add--2").prop("disabled", false);
        } else if (opcion === "Ростовская область") {
            $(".shose").show();
            $(".shose__inner--2").addClass("active");
            $(".add--2").prop("disabled", false);
        } else if (opcion === "Вся Россия") {
            $(".shose").show();
            $(".shose__inner--3").addClass("active");
            $(".add--2").prop("disabled", false);
        }
    });

    $(".shose__close").on("click", function () {
        var parent = $(this).parent(".shose__inner");
        parent.removeClass("active");

        $(".shose__inner").each(function () {
            if (!$(".shose__inner--1, .shose__inner--2, .shose__inner--3").hasClass("active")) {
                $(".shose").hide();
                $(".add--2").prop("disabled", true);
            }
        });
    });


    //--------------auction__tabs--------------//
    $('.auction__tabs .tab1').addClass('active');
    $('.auction__tabs .tab').on('click', function () {
        var btn = $(this);
        $('.auction__tabs .tab').removeClass('active');
        $(this).addClass('active');
        $('.bcr__span').text($(this).children().text());


        if ($('.auction__tabs .tab1').hasClass('active')) {
            $('.auction__content-item').removeClass('active');
            $('.auction__content-item--1').addClass('active');
        } else if ($('.auction__tabs .tab2').hasClass('active')) {
            $('.auction__content-item').removeClass('active');
            $('.auction__content-item--2').addClass('active');
        }
    });

    $(".auction__lid").on("click", function () {
        $(this).toggleClass("active");
    });


    /*    $(".card-a__link").on("click", function () {
            var item = $(this).parent(".card-a__top-item");
            var itemPrice = item.find(".card-a__price");
            var priceText = itemPrice.text();
            var price = parseInt(priceText);

            var balanceText = $(".HText Hcont_R_Balance-t, span").text();
            var balance = parseInt(balanceText);

            if (price <= balance) {
                $(".popup--auct").fadeIn();
                $("body").css("overflow", "hidden");
            } else if (price > balance) {
                $(".popup--auct-err").fadeIn();
                $("body").css("overflow", "hidden");
            }
        });*/

    $(".popup__btn-lid").on("click", function () {
        $(".tab").removeClass("active");
        $(".tab2").addClass("active");

        $(".auction__content-item").removeClass("active");
        $(".auction__content-item--2").addClass("active");

        $(".popup--auct").fadeOut();
        $("body").css("overflow", "auto");
    });

    // главная - есть контент || нет контента

    $(".item").each(function () {
        var contentItem = $(this).find(".item__content");
        var contentToo = $(this).find(".item__content2");

        if (contentItem.length == 0) {
            contentToo.addClass("active");
        } else {
            contentToo.removeClass("active");
        }
    });


    $(".item__btn").on("click", function () {
        $(".popup").show();
        $("body").css("overflow", "hidden");
    });

    $('.accortion__reference').on('click', '.header__reference', function () {
        var parent = $(this).parent('div');
        console.log(parent);
        var id = parent.attr('id'),
            dataid = $('.drop__list');
        dataid.each(function () {
            if ($(this).attr('data-id') === id){
                dataid = $(this);
            }
        });
        if (parent.hasClass('active')){
            parent.removeClass('active backfone');
            dataid.hide(500);
        } else {
            parent.addClass('active backfone');
            dataid.show(500);
        }
    });

    $('.integration__label').on('click', '.check__integration', function () {
        var id = $(this).attr('value');
        $('.forms__step').fadeOut(1, function () {
            $('.my_integration').fadeOut(1);
            $('#'+id+'_form').fadeIn(1);
        });
    });

    $('.params_tab').on('click', function () {
        var id = $(this).attr('id'),
            dataid = $('.params__fields');
        dataid.each(function () {
            if ($(this).attr('data-id') === id){
                dataid = $(this);
            }
        });
        $('.params_tab').removeClass('params_tab-active');
        $(this).addClass('params_tab-active');
        $('.params__fields').addClass('fields__none');
        dataid.removeClass('fields__none');
    });


    //Statistic-femida-client
    // $('.Stat-top select').styler({
    //     locales: {
    //         'ru': {
    //             selectPlaceholder: 'Выбрать сферу бизнеса',
    //         }
    //     }
    // });

    //techno

    let alltech = $('.techno-top-tab1'),
        mytech = $('.techno-top-tab2')
    ;
    $('.techno-top-tab').on('click', function(){
        $('.techno-top-tab').removeClass('active');
        $(this).addClass('active');

        if($(this).hasClass('techno-top-tab1') && $('.my-techno').is(":visible")){
            $('.my-techno').fadeOut(300, function(){
                $('.all-techno').fadeIn(300);
            });
        }else if($(this).hasClass('techno-top-tab2') && $('.all-techno').is(":visible")){
            $('.all-techno').fadeOut(300, function(){
                $('.my-techno').fadeIn(300);
            });
        }
    });
    if(location.hash == "#page3"){
        $('.change__section').removeClass('active');
    }
});