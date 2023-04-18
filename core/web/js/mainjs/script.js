
let btnInput = document.querySelectorAll("#formType");

let modalWrap = document.querySelector('.C_C_up__wrap');

let modalError = function (error) {
  modalWrap.querySelector('img').style.display = 'none';
  modalWrap.querySelectorAll('p')[0].textContent = 'Ошибка';
  modalWrap.querySelectorAll('p')[0].style.color = '#df2c56';
  modalWrap.querySelectorAll('p')[1].textContent = error;
};

$(document).ready(function () {
  $.mask.definitions["9"] = false;
  $.mask.definitions["5"] = "[0-9]";
  $("input[type=tel]")
    .mask("+7 955 555-5555")
    .on("click", function () {
      $(this).trigger("focus");
    });
  // $('#code_r').mask('555555');

  //     ymaps.ready(init);

  //     function init() {
  //         ymaps.geolocation.get({
  //                 provider: "yandex"
  //             })
  //             .then(function (res) {
  //                 var g = res.geoObjects.get(0);
  //                 $("input[name=city]").val(g.getLocalities()[0]);
  //                 $("input[name=new_region]").val(g.getAdministrativeAreas()[0]);
  //             })
  //             .catch(function (err) {
  //                 console.log('Не удалось установить местоположение', err);
  //             });
  //     }
  // });



  /*--попап карты клуба--*/

  $('.showsCard').each(function(index, element) {
    $(element).on('click', function () {
      $('body').css("overflow", "hidden");
      $('.By__Leads__Background__Popap').fadeIn(300);
      $('.By__Leads__popap__card__contant-margin').fadeIn(300);

      btnInput.forEach((i) => {
        i.value = element.dataset.formName;
      });

    });
  });

  $('.By__Leads__Background__Popap, .Popap_reg_on_leads_page').on('click', function () {
    $('body').css("overflow", "visible");
    $('.By__Leads__Background__Popap').fadeOut(300);
    $('.By__Leads__popap__card__contant-margin').fadeOut(300);
    $('.By__Leads__popap__LIN__contant-margin').fadeOut(300);
  });

  $('.btn-modal-prev').on('click', function () {
    $('.By__Leads__popap__card__contant-2').fadeOut(300, function () {
      $('.By__Leads__popap__card__contant').fadeIn(300);
    });

    $('body').css("overflow", "hidden");
    $('.By__Leads__Background__Popap').fadeIn(300);
    $('.By__Leads__popap__card__contant-margin').fadeIn(300);
    modalError = null;
  });

  $('#card').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      url: "/site/form",
      method: "POST",
      dataType: 'JSON',
      data: $("#card").serialize(),

      success: function(response) {
        if (response.status === 'error') {
          modalError(response.message);
          $('.By__Leads__popap__card__contant').fadeOut(300, function () {
            $('.By__Leads__popap__card__contant-2').fadeIn(300);
          });
        } else {
            $('.By__Leads__popap__card__contant').fadeOut(300, function () {
              $('.By__Leads__popap__card__contant-2').fadeIn(300);
            });
        }



      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.log(textStatus, errorThrown); // выводим ошибку в консоль
      }
    });
  });

  /*-----------*/

  $('.showsCons').on('click', function () {
    $('body').css("overflow", "hidden");
    $('.By__Leads__Background__Popap').fadeIn(300);
    $('.By__Leads__popap__consult__contant-margin').fadeIn(300);
  });

  $('.club-forms').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
      url: "/site/form",
      method: "POST",
      dataType: 'JSON',
      data: $(".club-forms").serialize(),
      beforeSend: function () {
        $('.club-form__innner--step1').fadeOut(300, function () {
          $('.club-form__innner--step2').fadeIn(300);
        });
      }
    });
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
  var a = 1,
    b = 2;
  $('.slider__item').each(function (i) {
    if (a == i) {
      $(this).addClass('slider__item--2');
      a = a + 3;
    }
    if (b == i) {
      $(this).addClass('slider__item--3');
      b = b + 3;
    }
  });

  $(".club-ask__query").on("click", function () {
    $(this).toggleClass("club-ask__query--active");
    $(this).next().toggleClass("club-ask__answer--open");
  });

  $(".card-s5__tab").on("click", function (e) {
    var th = $(this);
    var content = th.attr("href");
    var img = th.attr("data-img");

    $(".card-s5__tab").removeClass("active");
    th.addClass("active");

    $(".card-s5__tab-content").removeClass("active");
    $(content).addClass("active");

    $(".card-s5__tab-img").removeClass("active");
    $(img).addClass("active");

    e.preventDefault();
  });


  var burger = 0;
  const burgerButton = document.querySelector('.burger')
  const burgermenu = document.querySelector('.Burger-menu')
  const header = document.querySelector('.header_cont')
  $('.BTN-burger, .Burger-menu-back').on('click', function () {
    if (burger == 0) {

      $('.burger-strip-1, .burger-strip-2, .burger-strip-3, .BTN-burger').addClass('active');
      $('.Burger-menu').addClass('active');
      $('.Burger-menu-back').fadeIn(300);
      burgermenu.insertAdjacentElement("afterbegin", burgerButton)
      burger = 1;
    } else {
      $('.burger-strip-1, .burger-strip-2, .burger-strip-3, .BTN-burger').removeClass('active');
      $('.Burger-menu').removeClass('active');
      $('.Burger-menu-back').fadeOut(300);
      header.insertAdjacentElement("beforeend", burgerButton)
      burger = 0;
    }
  });

  $(document).on("change", ".FiltrRadio", function () {
    $(this).closest(".FormFiltr").trigger("submit");
  });

  $(".article-event-form").on("submit", function (e) {
    $.ajax({
      url: "/site/event-send",
      type: "post",
      data: $(this).serialize()
    }).done(function () {
      $(".article-event-form__container").hide();
      $(".article-event-form__success").show();
    });
    e.preventDefault();
    return false;
  });

});
