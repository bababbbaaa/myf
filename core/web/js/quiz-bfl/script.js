$('html, body').animate({scrollTop: '0px'}, 300);

$(document).ready(function(){
    $.mask.definitions["9"] = false;
    $.mask.definitions["5"] = "[0-9]";
    $("input[type=tel]")
        .mask("8(955) 555-5555")
        .on("click", function () {
        $(this).trigger("focus");
    });
    ymaps.ready(init);

    function init() {
        ymaps.geolocation.get({
                provider: "yandex"
            })
            .then(function (res) {
                var g = res.geoObjects.get(0);
                $("input[name=city]").val(g.getLocalities()[0]);
                $("input[name=new_region]").val(g.getAdministrativeAreas()[0]);
            })
            .catch(function (err) {
                console.log('Не удалось установить местоположение', err);
            });
    }
});

$('.btn--main').on('click',function(){
    $('.quiz').addClass('open');
    $('html, body').animate({scrollTop: '0px'}, 300);
    $('body').css({
        'overflow': 'hidden',
    });
    setTimeout(function(){
        $('.main_info').fadeOut();
    }, 300);
});

$('.radio').on('change', function(){
    if($(this).is(':checked')){
        $('.label').removeClass('checked');
        $(this).parent().addClass('checked');
    }
});

$('.Stap1 .radio').on('click', function(){
    $('.Stap1').removeClass('vis');
    $('.Stap1').fadeOut(300);
    setTimeout(function(){
        $('.Stap2').fadeIn(300);
        setTimeout(function(){
            $('.Stap2').addClass('vis');
            $('.Stap2 .fill').css({
                'width': '50%',
            });
        },300);
    },300);
});
$('.Stap2 .radio').on('click', function(){
    $('.Stap2').removeClass('vis');
    $('.Stap2').fadeOut(300);
    setTimeout(function(){
        $('.Stap3').fadeIn(300);
        setTimeout(function(){
            $('.Stap3').addClass('vis');
            $('.Stap3 .fill').css({
                'width': '75%',
            });
        },300);
    },300);
});
$('.Stap3 .radio').on('click', function(){
    $('.Stap3').removeClass('vis');
    $('.Stap3').fadeOut(300);
    setTimeout(function(){
        $('.Stap4').fadeIn(300);
        setTimeout(function(){
            $('.Stap4').addClass('vis');
            $('.Stap4 .fill').css({
                'width': '100%',
            });
        },300);
    },300);
});
$('.Stap4 .radio').on('click', function(){
    $('.Stap4').removeClass('vis');
    $('.Stap4').fadeOut(300);
    setTimeout(function(){
        $('.Stap5').fadeIn(300);
        setTimeout(function(){
            $('.Stap5').addClass('vis');
        },300);
    },300);
});

$('.Stap5 .btn--back').on('click', function(){
    $('.Stap5').removeClass('vis');
    $('.Stap5').fadeOut(300);
    setTimeout(function(){
        $('.Stap4').fadeIn(300);
        setTimeout(function(){
            $('.Stap4').addClass('vis');
            $('.Stap4 .fill').css({
                'width': '100%',
            });
        },300);
    },300);
});
$('.Stap4 .btn--back').on('click', function(){
    $('.Stap4').removeClass('vis');
    $('.Stap4').fadeOut(300);
    setTimeout(function(){
        $('.Stap3').fadeIn(300);
        setTimeout(function(){
            $('.Stap3').addClass('vis');
            $('.Stap3 .fill').css({
                'width': '75%',
            });
        },300);
    },300);
});
$('.Stap3 .btn--back').on('click', function(){
    $('.Stap3').removeClass('vis');
    $('.Stap3').fadeOut(300);
    setTimeout(function(){
        $('.Stap2').fadeIn(300);
        setTimeout(function(){
            $('.Stap2').addClass('vis');
            $('.Stap2 .fill').css({
                'width': '50%',
            });
        },300);
    },300);
});
$('.Stap2 .btn--back').on('click', function(){
    $('.Stap2').removeClass('vis');
    $('.Stap2').fadeOut(300);
    setTimeout(function(){
        $('.Stap1').fadeIn(300);
        setTimeout(function(){
            $('.Stap1').addClass('vis');
            $('.Stap1 .fill').css({
                'width': '25%',
            });
        },300);
    },300);
});
$('.Stap1 .btn--back').on('click', function(){
    $('.main_info').fadeIn();
    $('.quiz').removeClass('open');
    $('html, body').animate({scrollTop: '0px'}, 300);
    $('body').css({
        'overflow': 'auto',
        'overflow-x': 'hidden',
    });
});

$('.btn--popup').on('click',function(){
    $('.back, .popup-wrap').addClass('visible');
    $('body').css({
        'overflow': 'hidden',
    });
});
$('.btn-popup-close, .back').on('click',function(){
    $('.back, .popup-wrap').removeClass('visible');
    $('body').css({
        'overflow': 'auto',
    });
});

$('.quiz-form').on('submit', function (e) {
    e.preventDefault();
    $.ajax({
        url: "/site/bfl-send",
        method: "POST",
        data: $(this).serialize(),
    }).done(function () {
        location.replace('thanks');
    })
});
console.log('ok');
$('.popup-form').on('submit', function (e) {
    $.ajax({
        url: "/site/bfl-send",
        method: "POST",
        data: $(this).serialize(),
        beforeSend: function (){
            $('.popup_stap1').addClass('close');
            $('.popup_stap2').fadeIn(function(){
                $(this).css({
                    'display': 'flex',
                });
            });
            setTimeout(function(){
                $('.popup_stap1').hide();
                $('.popup_stap2').addClass('open');
            },600);
        },
    });
    e.preventDefault();
});

let animationItems = document.querySelectorAll('.animate');

if(animationItems.length > 0){
    window.addEventListener('scroll', animationOnScroll);
    function animationOnScroll(){
        for(let index = 0; index < animationItems.length; index++){
            const animationItem = animationItems[index];
            const animationItemHeight = animationItem.offsetHeight;
            const animationItemOffset = offset(animationItem).top;
            const animationStart = 4;

            let animationItemPoint = window.innerHeight - animationItemHeight / animationStart;

            if(animationItemHeight > window.innerHeight){
                animationItemPoint = window.innerHeight - window.innerHeight / animationStart;
            }

            if(pageYOffset > (animationItemOffset - animationItemPoint) && pageYOffset < (animationItemOffset + animationItemHeight)){
                $(animationItem).addClass('active');
            } else {
                $(animationItem).removeClass('active');
            }
        }
    }
    function offset(el){
        const rect = el.getBoundingClientRect(),
            scrollLeft = window.pageXOffset || document.documentElement.scrollLeft,
            scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        return { top: rect.top + scrollTop, left: rect.left + scrollLeft }
    }
    
}
animationOnScroll();