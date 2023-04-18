$(document).ready(function () {

    $.mask.definitions["9"] = false;
    $.mask.definitions["5"] = "[0-9]";
    $("input[type=tel]")
        .mask("+7(955) 555-5555")
        .on("click", function () {
            $(this).trigger("focus");
        });

    $('#form1').on('submit', function (e) {
            $.ajax({
                url: "/site/form",
                type: "POST",
                dataType: 'JSON',
                data: $("#form1").serialize(),
                beforeSend: function () {
                    $('.fst1').fadeOut(300, function () {
                    $('.fst2').fadeIn(300);
                });
                    },
            }).done(function () {

            });
            e.preventDefault();
    });
    $('.closedsPops').on('click', function (e) {
        var classlist = e.target.classList,
            close = false;
        for(var i=0; i<classlist.length; i++){
            if(classlist[i] == 'closedsPops'){
                close = true;
                break;
            }
        }
        if(close){
            $('.hovpas').removeClass('hovpasChecked');
            $('.popup1').fadeOut(300);
        }
    });
    $('.Nf').on('click', function () {
        var nf = $(this);

        if (nf.children('.filterRadio').is(':checked')){
            $(this).addClass('activeNf');
        } else {
            $(this).removeClass('activeNf');
        }
    });

    $('.active__button--filter').on('click', function () {
        $(this).toggleClass('activeNf');
        if ($(this).hasClass('activeNf')){
            $('.change__folter__main').show(200);
        } else {
            $('.change__folter__main').hide(200);
        }
    });


    var step = 1;
    function changeStep() {
        $('.BSec1Step' + step++).fadeOut(300, function () {
            $('.BSec1Step' + step).fadeIn(300);
        });
    }

    $('.BSec1Form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '/site/form',
            data: $('.BSec1Form').serialize(),
            dataType: 'JSON',
            type: 'POST',
        }).done(function() {
            $('.BSec1Step3').fadeOut(300, function() {
                $('.BSec1Step4').fadeIn(300);
            });
        });
    });
    $('.orangeLinkBtn').on('click', function () {
        if (step == 1 && $('select[name="region"]').val() !== ''){
            changeStep();
            return true;
        }
        if (step == 2 && $('.comments[summ]').val() !== ''){
            changeStep();
        }
        if (step == 3 && $('.partFio').val() !== '' && $('.partPhone').val() !== ''){
            $('.BSec1Form').submit();
        }
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
});