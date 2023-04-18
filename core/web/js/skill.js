$(document).ready(function () {
  //popup;
  $(".popup__form").on("submit", function (e) {
    var formThis = this;
    $.ajax({
      url: "/site/form",
      type: "POST",
      data: $(this).serialize(),
      beforeSend: function () {
        $(formThis).children('.popup__btn').prop('disabled', true);
      }
    }).done(function () {
      $(formThis)
          .children(".popup__step.step1")
          .fadeOut(300, function () {
            $(formThis).children(".popup__step.step2").fadeIn(300);
          });
    });
    e.preventDefault();
  });

  $(".popup-link").on("click", function () {
    $("#consult").addClass("open");
    $("body").css("overflow", "hidden");
  });

  $(".popup__close").on("click", function () {
    $("#consult").removeClass("open");
    $("body").css("overflow", "auto");
  });

  $('.popup__body').click(function (e) {
    if ($(e.target).closest('.popup__content').length == 0) {
      $("#consult").removeClass("open");
      $("body").css("overflow", "auto");
    }
  });
  /*------*/
  
  $(".footer__item-list").hover(function () {
    $(this).prev(".footer__item-title").css("color", "#FFDC36");
  }, function () {
    $(this).prev(".footer__item-title").css("color", "rgba(209, 221, 238, 0.82)");
  });

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

  /*Страница "О Проекте"*/
  /*--------------------------------------------------------*/
  var v = true;

  $(document).ready(function () {
    setInterval(function () {
      if (v == true) {
        $('.topVid-1').fadeOut(300);
        setTimeout(function () {
          $('.topVid-2').fadeIn(300);
        }, 300);
        v = false;
      } else if (v == false) {
        $('.topVid-2').fadeOut(300);
        setTimeout(function () {
          $('.topVid-1').fadeIn(300);
        }, 300);
        v = true;
      }
    }, 20000);
  });
  /*--------------------------------------------------------*/
  /*Конец страницы "О Проекте"*/


  /*Страница "Преподавание"*/
  /*--------------------------------------------------------*/
  $('.PS2CB2_down-tf_B1').addClass('PS2CB2_down-tf_B-ACTIVE');

  $('.PS2CB2_down-tf_B1').on('click', function () {
    $('.PS2CB2_down-tf_B1').addClass('PS2CB2_down-tf_B-ACTIVE');
    $('.PS2CB2_down-tf_B2').removeClass('PS2CB2_down-tf_B-ACTIVE');
    $('.PS2CB2_down-tf_B3').removeClass('PS2CB2_down-tf_B-ACTIVE');
    $('.PS2CB2_down-F3').fadeOut(200);
    $('.PS2CB2_down-F2').fadeOut(200);
    setTimeout(function () {
      $('.PS2CB2_down-F1').fadeIn(200);
    }, 200);
  });
  $('.PS2CB2_down-tf_B2').on('click', function () {
    $('.PS2CB2_down-tf_B2').addClass('PS2CB2_down-tf_B-ACTIVE');
    $('.PS2CB2_down-tf_B1').removeClass('PS2CB2_down-tf_B-ACTIVE');
    $('.PS2CB2_down-tf_B3').removeClass('PS2CB2_down-tf_B-ACTIVE');
    $('.PS2CB2_down-F1').fadeOut(200);
    $('.PS2CB2_down-F3').fadeOut(200);
    setTimeout(function () {
      $('.PS2CB2_down-F2').fadeIn(200);
    }, 200);
  });
  $('.PS2CB2_down-tf_B3').on('click', function () {
    $('.PS2CB2_down-tf_B3').addClass('PS2CB2_down-tf_B-ACTIVE');
    $('.PS2CB2_down-tf_B1').removeClass('PS2CB2_down-tf_B-ACTIVE');
    $('.PS2CB2_down-tf_B2').removeClass('PS2CB2_down-tf_B-ACTIVE');
    $('.PS2CB2_down-F1').fadeOut(200);
    $('.PS2CB2_down-F2').fadeOut(200);
    setTimeout(function () {
      $('.PS2CB2_down-F3').fadeIn(200);
    }, 200);
  });

  $('.PS4C_B1_slider').slick({
    focusOnSelect: false,
  });
  /*--------------------------------------------------------*/
  /*Конец страницы "Преподавание"*/

  /*Страница "Каталог"*/
  /*--------------------------------------------------------*/
  var list1 = "close";
  $('.CS2C__BB__L-F-C_BTN-1').on('click', function () {
    if (list1 == "close") {
      $('.CS2C__BB__L-F-C_BTN-1').addClass('open');
      $('.CS2C__BB__L-F-C_List-1').addClass('lopen');
      list1 = "open";
    } else if (list1 == "open") {
      $('.CS2C__BB__L-F-C_BTN-1').removeClass('open');
      $('.CS2C__BB__L-F-C_List-1').removeClass('lopen');
      list1 = "close";
    }
  });
  var list2 = "close";
  $('.CS2C__BB__L-F-C_BTN-2').on('click', function () {
    if (list2 == "close") {
      $('.CS2C__BB__L-F-C_BTN-2').addClass('open');
      $('.CS2C__BB__L-F-C_List-2').addClass('lopen');
      list2 = "open";
    } else if (list2 == "open") {
      $('.CS2C__BB__L-F-C_BTN-2').removeClass('open');
      $('.CS2C__BB__L-F-C_List-2').removeClass('lopen');
      list2 = "close";
    }
  });
  var list3 = "close";
  $('.CS2C__BB__L-F-C_BTN-3').on('click', function () {
    if (list3 == "close") {
      $('.CS2C__BB__L-F-C_BTN-3').addClass('open');
      $('.CS2C__BB__L-F-C_List-3').addClass('lopen');
      list3 = "open";
    } else if (list3 == "open") {
      $('.CS2C__BB__L-F-C_BTN-3').removeClass('open');
      $('.CS2C__BB__L-F-C_List-3').removeClass('lopen');
      list3 = "close";
    }
  });
  var list4 = "close";
  $('.CS2C__BB__L-F-C_BTN-4').on('click', function () {
    if (list4 == "close") {
      $('.CS2C__BB__L-F-C_BTN-4').addClass('open');
      $('.CS2C__BB__L-F-C_List-4').addClass('lopen');
      list4 = "open";
    } else if (list4 == "open") {
      $('.CS2C__BB__L-F-C_BTN-4').removeClass('open');
      $('.CS2C__BB__L-F-C_List-4').removeClass('lopen');
      list4 = "close";
    }
  });
  var list5 = "close";
  $('.CS2C__BB__L-F-C_BTN-5').on('click', function () {
    if (list5 == "close") {
      $('.CS2C__BB__L-F-C_BTN-5').addClass('open');
      $('.CS2C__BB__L-F-C_List-5').addClass('lopen');
      list5 = "open";
    } else if (list5 == "open") {
      $('.CS2C__BB__L-F-C_BTN-5').removeClass('open');
      $('.CS2C__BB__L-F-C_List-5').removeClass('lopen');
      list5 = "close";
    }
  });
  $('input[name="typeoftrain"], input[name="level"], input[name="price"], input[name="work"], input[name="partner"]').styler(); //конечно же тут можно поставить input[type="radio"], но я специально поставил через имя, так как в других местах может быть что-то другое, если нужно - поменяйте
  $('button[type="reset"]').click(function () {
    $('.jq-radio').removeClass('checked');
    $('.jq-checkbox').removeClass('checked');
    $('.CS2C__BB__L-F-C_BTN-5').fadeOut(300);
    if (list5 == "open") {
      $('.CS2C__BB__L-F-C_BTN-5').removeClass('open');
      $('.CS2C__BB__L-F-C_List-5').removeClass('lopen');
      list5 = "close";
    }
  });
  $('.inputWorkOB').on('click', function () {
    if ($('.inputWork.jq-checkbox').hasClass('checked')) {
      $('.CS2C__BB__L-F-C_BTN-5').fadeIn(300);
    } else {
      $('.CS2C__BB__L-F-C_BTN-5').fadeOut(300);
      if (list5 == "open") {
        $('.CS2C__BB__L-F-C_BTN-5').removeClass('open');
        $('.CS2C__BB__L-F-C_List-5').removeClass('lopen');
        list5 = "close";
      }
    }
  });
  $('.BurgerMenufilter').on('click', function () {
    $('.BurgerMenufilterBACK').fadeIn(300);
    $('.CS2C__BB__L-F').addClass('burger');
  });
  $('.BurgerMenufilterBACK, .FiltCloseB').on('click', function () {
    $('.BurgerMenufilterBACK').fadeOut(300);
    $('.CS2C__BB__L-F').removeClass('burger');
  });
  /*--------------------------------------------------------*/
  /*Конец страницы "Каталог"*/



  //    Толик
  //слайдер;
  $('.cp-s4__slider').slick({
    infinite: true,
    slidesToScroll: 1,
    slidesToShow: 3,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 2
        }
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }
    ]
  });

  $('.car-s3__coments-slider').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 1,
    responsive: [
      {
        breakpoint: 992,
        settings: {
          slidesToShow: 1,
        }
      },
      {
        breakpoint: 686,
        settings: {
          slidesToShow: 1,
        }
      }
    ]
  });

  $('.he-s9__slider').slick({
    infinite: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    responsive: [

    ]
  });

  //спойлеры;
  $(".cp-s5__tab-title").on("click", function () {
    $(this).toggleClass("active");
    $(this).offsetParent().toggleClass("active");
    $(this).next(".cp-s5__tab-content").fadeIn(300);
    if (!$(this).hasClass("active")) {
      $(this).next(".cp-s5__tab-content").fadeOut(300);
    }
  });

  //скрол при клике
  $('a.cp-s1__link').on('click', function (e) {
    e.preventDefault();
    $('html, body').animate({
      scrollTop: $($.attr(this, 'href')).offset().top
    }, 1500);
  });


  $('.bg-s2__link').on('click', function () {
    $('.bg-s2__link').removeClass('link-active');
    $(this).addClass('link-active');
  });

  //test
  $(".test__btn").on("click", function () {
    var th = $(this).parent();
    var inp = $(this).prev().find(".test__inp");
    if (inp.is(":checked")) {
      th.fadeOut(300, function () {
        th.next().fadeIn(300);
        $(window).scrollTop(0);
      });
    }
  });


  $(".test__btn-result").on("click", function () {
    var inp1 = $(this).prev().find(".test__inp");
    var test1 = $("#test1").is(":checked");
    var test2 = $("#test2").is(":checked");
    var test3 = $("#test3").is(":checked");
    var test4 = $("#test4").is(":checked");
    var test5 = $("#test5").is(":checked");
    var test6 = $("#test6").is(":checked");
    var test7 = $("#test7").is(":checked");
    var test8 = $("#test8").is(":checked");
    var test9 = $("#test9").is(":checked");
    var test10 = $("#test10").is(":checked");
    var test11 = $("#test11").is(":checked");
    var test12 = $("#test12").is(":checked");
    $("[data-category]").each(function () {
      $(this).hide();
    });

    if (test1) {
      $("#test-result").text("продажам, коммерческой деятельности");
    }
    else if (test2) {
      $("#test-result").text("программированию, аналитике, тестированию");
    }
    else if (test3) {
      $("#test-result").text("предпринимательству, продажам, коммерции, лидерству");
    }
    else if (test4) {
      $("#test-result").text("маркетингу, аналитике, тестированию");
    }
    else if (test5) {
      $("#test-result").text("софт-скиллам, руководству, принятию решений, организации ");
    }
    else if (test6) {
      $("#test-result").text("предпринимательству, продажам, коммерции, лидерству");
    }
    else if (test7) {
      $("#test-result").text("дизайну, творчеству, аналитике, конструированию");
    }
    else if (test8) {
      $("#test-result").text("программированию, аналитике, тестированию, дизайну");
    }
    else if (test9) {
      $("#test-result").text("юридическим наукам, законотворчеству");
    }
    else if (test10) {
      $("#test-result").text("преподаванию, развитию навыков");
    }
    else if (test11) {
      $("#test-result").text("творчеству, дизайну, аналитике, конструированию");
    }
    else if (test12) {
      $("#test-result").text("общению, руководству, аналитике");
    }

    if (inp1.is(":checked")) {
      $(".test-ask").fadeOut(300, function () {
        $(".test__resul").fadeIn(300);
        $(window).scrollTop(0);
      });
    }
  });

  //партнеры наведение и клик
  $(".avatar__item").mouseover(function () {
    if (!$(".avatar__img").hasClass("index")) {
      $(".avatar__img").addClass("no-active");
      $(this).children(".avatar__img").removeClass("no-active");
    }
  });

  $(".avatar__item").mouseout(function () {
    if (!$(".avatar__img").hasClass("index")) {
      $(".avatar__img").removeClass("no-active");
    }
  });
});

