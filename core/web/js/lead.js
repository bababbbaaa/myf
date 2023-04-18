$(document).ready(function () {
    $('.menushow').on('click', function () {
        $('.menushows').fadeIn(1, function () {
            $('.menushows').addClass('showMenu');
        });
        $('.menushow').fadeOut(300, function () {
            $('.menuclose').fadeIn(300);
        });
    });
    $('.menuclose').on('click', function () {
        $('.menushows').fadeOut(500, function () {
            $('.menushows').removeClass('showMenu');
        });
        $('.menuclose').fadeOut(300, function () {
            $('.menushow').fadeIn(300);
        });
    });

    var thisIs = $('input[type="range"]'),
        val = ($(thisIs).val() - $(thisIs).attr('min')) / ($(thisIs).attr('max') - $(thisIs).attr('min')),
        text = $('#text');

    text.on("change input", function () {
        val = ($(thisIs).val() - $(thisIs).attr('min')) / ($(thisIs).attr('max') - $(thisIs).attr('min'));

        $(thisIs).css('background-image',
            '-webkit-gradient(linear, left top, right top, '
            + 'color-stop(' + val + ', #01eb6a),'
            + 'color-stop(' + val + ', #fff)'
            + ')'
        );
    });
    thisIs.on("change mousemove", function () {
        val = ($(this).val() - $(this).attr('min')) / ($(this).attr('max') - $(this).attr('min'));

        $(this).css('background-image',
            '-webkit-gradient(linear, left top, right top, '
            + 'color-stop(' + val + ', #01eb6a),'
            + 'color-stop(' + val + ', #fff)'
            + ')'
        );
    });
    thisIs.css('background-image',
        '-webkit-gradient(linear, left top, right top, '
        + 'color-stop(' + val + ', #01eb6a),'
        + 'color-stop(' + val + ', #fff)'
        + ')'
    );

    $.mask.definitions["9"] = false;
    $.mask.definitions["5"] = "[0-9]";
    $("input[type=tel]")
        .mask("+7(955) 555-5555")
        .on("click", function () {
            $(this).trigger("focus");
        });
    $('.New__btns').on('click', function () {
        if ($('.New__btns').hasClass('active')) {
            $('input[name="filter[new]"]').prop('checked', false)
        } else {
            $('input[name="filter[new]"]').prop('checked', true)
        }
    });
    $('.SPA__btns').on('click', function () {
        if ($('.SPA__btns').hasClass('active')) {
            $('input[name="filter[price]"]').prop('checked', false)
        } else {
            $('input[name="filter[price]"]').prop('checked', true)
        }
    });

    var num = 0;

    // $(".filters > .filters__btn").on("click", function () {
    //     var t = $(this);
    //     $(t).toggleClass("active");
    //     if ($(t).hasClass("active")) {
    //         if ($(".filters__num").hasClass("filters__num--visable")) {
    //         } else {
    //             $(".filters__num").addClass("filters__num--visable");
    //         }
    //     } else {
    //         if ($(".filters > .filters__btn").hasClass("active")) {
    //         } else {
    //             $(".filters__num").removeClass("filters__num--visable");
    //         }
    //     }
    // });

    // $('.reload__filter').on('click', function () {
    //     $('input[name="filter[category][]"]').prop('checked', false);
    //     $('input[name="filter[regions][]"]').prop('checked', false);
    //     $('.filters__btn').removeClass('active');
    //     $('.filters__list').removeClass('filters__list--visable');
    //     $('.filters__btn').removeClass('active--visable');
    //     $('.filters__num').removeClass('filters__num--visable');
    // });
    //
    //
    // $(".filters-select > .filters__btn").on("click", function (e) {
    //
    //     var m = $(this);
    //     var l = $(m).next(".filters__list").find(".filters__label");
    //     var i = $(m).next(".filters__list").find(".filters__input");
    //     $(m).toggleClass("active");
    //     $(m).next(".filters__list").toggleClass("filters__list--visable");
    //     $(i).on("click", function () {
    //         if ($(i).is(":checked")) {
    //             $(m).addClass("active--visable");
    //             if ($(".filters__num").hasClass("filters__num--visable")) {
    //             } else {
    //                 $(".filters__num").addClass("filters__num--visable");
    //             }
    //         } else if (!$(i).is(":checked")) {
    //             if ($(".filters > .filters__btn").hasClass("active")) {
    //                 $(m).removeClass("active--visable");
    //
    //             } else if ($(".filters-select > .filters__btn").hasClass("active--visable")) {
    //                 $(m).removeClass("active--visable");
    //                 $(".filters__num").removeClass("filters__num--visable");
    //             }
    //         } else {
    //             $(m).removeClass("active--visable");
    //             $(".filters__num").removeClass("filters__num--visable");
    //         }
    //     });
    // });
    //
    //
    // $("form-filters-select > .form__filters-btn").on("click", function () {
    //     $(this).toggleClass("active");
    //     $(this).next(".filters__list").toggleClass("filters__list--visable");
    //     $(".filters__label").val(function () {
    //     });
    // });

    // var slider = document.getElementById("myRange");
    // var output = document.getElementById("demo");
    // output.innerHTML = slider.value;
    //
    // slider.oninput = function () {
    //     output.innerHTML = this.value;
    // }

    $('.btn-registration').on('click', function () {
        var textuserinputreg = $('#username_r').val();
        var phonenuminputreg = $('#phone_r').val();
        $('.R_C_phone').text(phonenuminputreg);
        if (textuserinputreg.length > 1 & phonenuminputreg.length >= 10) {
            $('.By__Leads__popap__registr__contant').fadeOut(200);
            setTimeout(function () {
                $('.By__Leads__popap__registr__contant-2').fadeIn(200);
            }, 200);
            var _Seconds = $('.numertimerinsendcode').text(), int;
            int = setInterval(function () {
                if (_Seconds > 0) {
                    _Seconds--;
                    $('.numertimerinsendcode').text(_Seconds);
                } else {
                    $('.sendcodeagain').fadeOut(0);
                    $('.sendcodeagainnow').fadeIn(0);
                }
            }, 1000);
            $('.sendcodeagainnow').on('click', function () {
                //отправка кода повторно;
            });
        }
    });

    $('.linkonbackstap').on('click', function () {
        $('.By__Leads__popap__registr__contant-2').fadeOut(200);
        setTimeout(function () {
            $('.By__Leads__popap__registr__contant').fadeIn(200);
            $('#phone_r').val('');
        }, 200);
    });

    $('.By__Leads__Background__Popap, .Popap_reg_on_leads_page').on('click', function () {
        $('body').css("overflow", "visible");
        $('.By__Leads__Background__Popap').fadeOut(300);
        $('.By__Leads__popap__registr__contant-margin').fadeOut(300);
    });

    // $('input, select').styler({
    //     selectPlaceholder: "Ваш регион",
    // });

    $('#username_r').on('input invalid', function () {
        this.setCustomValidity('')
        if (this.validity.patternMismatch) {
            this.setCustomValidity("Допустимый ввод: A-z, А-я")
        }
    });

    $('#lids').on('input invalid', function () {
        this.setCustomValidity('')
        if (this.validity.patternMismatch) {
            this.setCustomValidity("Допустим ввод только цифр!")
        }
    });

    //.B_L_S4_C_B-card-order, было в нижней строке для вызова попапа
    $('.B_L_S4_C_B5-btn, .BLS5CD_BTN, .showsCons').on('click', function () {
        $('body').css("overflow", "hidden");
        $('.By__Leads__Background__Popap').fadeIn(300);
        $('.By__Leads__popap__consult__contant-margin').fadeIn(300);
    });

    $('.By__Leads__Background__Popap, .Popap_reg_on_leads_page').on('click', function () {
        $('body').css("overflow", "visible");
        $('.By__Leads__Background__Popap').fadeOut(300);
        $('.By__Leads__popap__consult__contant-margin').fadeOut(300);
        $('.By__Leads__popap__form__contant-margin').fadeOut(300);
        $('.By__Leads__popap__LIN__contant-margin').fadeOut(300);
    });

    $('#consultation').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "/site/form",
            method: "POST",
            dataType: 'JSON',
            data: $("#consultation").serialize(),
            beforeSend: function () {
                $('.By__Leads__popap__consult__contant').fadeOut(300, function () {
                    $('.By__Leads__popap__consult__contant-2').fadeIn(300);
                });

            }
        });
    });



  //.B_L_S4_C_B-card-order, было в нижней строке для вызова попапа
  $('.showsCard').on('click', function () {
    $('body').css("overflow", "hidden");
    $('.By__Leads__Background__Popap').fadeIn(300);
    $('.By__Leads__popap__card__contant-margin').fadeIn(300);
  });

  $('.By__Leads__Background__Popap, .Popap_reg_on_leads_page').on('click', function () {
    $('body').css("overflow", "visible");
    $('.By__Leads__Background__Popap').fadeOut(300);
    $('.By__Leads__popap__card__contant-margin').fadeOut(300);
    $('.By__Leads__popap__LIN__contant-margin').fadeOut(300);
  });

  $('#card').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      url: "/site/form",
      method: "POST",
      dataType: 'JSON',
      data: $("#card").serialize(),
      beforeSend: function () {
        $('.By__Leads__popap__card__contant').fadeOut(300, function () {
          $('.By__Leads__popap__card__contant-2').fadeIn(300);
        });

      }
    });
  });

  $('#form-TL_inp8').on('submit', function (e) {
    var form = this;
    e.preventDefault();
    $.ajax({
      url: "/site/form",
      method: "POST",
      dataType: 'JSON',
      data: $("#form-code").serialize(),
      beforeSend: function () {
        form.reset();
        $('.By__Leads__popap__registr__contant').fadeOut(1, function () {
          $('.By__Leads__popap__registr__contant').fadeIn(1)
        });
        $('.By__Leads__Background__Popap, .By__Leads__popap__form__contant-margin').fadeIn(300)
      }
    });
  });

  $('#section__lead, #TL_sec4-form, #tool-form').on('submit', function (e) {
    var form = this;
    e.preventDefault();
    $.ajax({
      url: "/site/form",
      method: "POST",
      dataType: 'JSON',
      data: $(form).serialize(),
      beforeSend: function () {
        form.reset();
        $(".Sec5-step1").fadeOut(300, function () {
          $(".Sec5-step2").fadeIn(300);
        });
      }
    });
  });

    $('.BLS6C__Slide__center').slick({
        centerMode: true,
        centerPadding: '285px',
        slidesToShow: 1,
        arrows: true,
        dots: true,
        infinite: false,
        initialSlide: 1,
        responsive: [
            {
                breakpoint: 1150,
                settings: {
                    centerPadding: '200px',
                },
            },
            {
                breakpoint: 1000,
                settings: {
                    centerPadding: '140px',
                }
            },
            {
                breakpoint: 860,
                settings: {
                    centerPadding: '100px',
                }
            },
            {
                breakpoint: 780,
                settings: {
                    centerPadding: '0px',
                }
            }
        ]
    });
});



