$('.card-notif-close').on('click', function(){
    $(this).parent().hide();
});

$('.ChangePage-Item-t').on('click', function(){   
    $('.ChangePage-Item-t').removeClass('CIT-active');
    $('.ChangePage-Item-line').removeClass('CIL-active');
    $(this).addClass('CIT-active');
    $(this).next().addClass('CIL-active');
    var id = $(this).attr('id');
    var ide = ".balance-tab." + id;
    $('.balance-tab').hide();
    $(ide).show();
});

if(location.hash == "#page3"){
    $('.change__section').removeClass('active');
}


//MyEducation - tabs
$('.MyEducation_tabs .tab').on('click', function(){
    $('.MyEducation_tabs .tab').removeClass('active');
    $(this).addClass('active');
    setTimeout(function(){
        if(location.hash == "#1"){
            $('.courses').removeClass('active');
            $('.courses_active').addClass('active');
        }else if(location.hash == "#2"){
            $('.courses').removeClass('active');
            $('.courses_archive').addClass('active');
        }
    }, 1);
});

if(location.hash == "#2"){
    $('.MyEducation_tabs .tab1, .courses').removeClass('active');
    $('.MyEducation_tabs .tab2, .courses_archive').addClass('active');
}

$('.MyOrders_filter-check-l').on('click', function(){
    if ($(this).children().is(':checked')){
        $('.MyOrders_filter-check-l').removeClass('active');
        $(this).addClass('active');
    } else {
        $(this).removeClass('active');
    }
});

var a = 0,
    b = 0,
    c = 0,
    d = 0,
    result = 0
;
$('.courses_item').each(function(){
    $(this).find('.courses_item_info-stage_row-text span span').each(function(e){
        switch (e){
            case 0:
                a = $(this).text();
            break;
            case 1:
                b = $(this).text();
            break;
            case 2:
                c = $(this).text();
            break;
            case 3:
                d = $(this).text();
            break;
        } 
    });
    result = (((a/b)+(c/d))/2)*100 + "%";
    $(this).find('.courses_item_info-stage_line-fill').css({
        width: result,
    });
});

$('.courses_item_top-name').hover(function(){
    $(this).children().toggleClass('active');
    if($(this).hasClass('course')){
        $(this).children().text('Курс - расширенная программа для погружения в профессию');
    }else if($(this).hasClass('intensive')){
        $(this).children().text('Интенсив - короткая программа для освоения навыков');
    }else if($(this).hasClass('webinar')){
        $(this).children().text('Вебинар - это просто вебинар и ничего более!');
    }else if($(this).hasClass('autowebinar')){
        $(this).children().text('Автовебинар - чухня какая-то!');
    }
});

$('.mycours-list-item-btn').on('click', function(){ 
    $(this).toggleClass('active');
    if($(this).hasClass('active')){
        $(this).next().slideDown(300);
    }else{
        $(this).next().slideUp(300);
    }
});

let firstnum = 0,
    lastnum = 0,
    resultpercent = 0
;
$('.cours-progress_subb-group').each(function(){
    $(this).find('.cours-progress-subtitle span span').each(function(e){
        switch (e){
            case 0:
                firstnum = $(this).text();
                break;
            case 1:
                lastnum = $(this).text();
                break;
        }
    });
    resultpercent = (firstnum / lastnum) * 100 + "%";
    $(this).find('.cours-progress-subtitle_line-fill').css({
        width: resultpercent,
    });
});

$('.learning-btn').on('click', function(){ 
    $(this).toggleClass('active');
    if($(this).hasClass('active')){
        $(this).next().slideDown(300);
    }else{
        $(this).next().slideUp(300);
    }
});

$('.viewcours-structure-list-item').on('click', function(){
    $('.viewcours-structure-list-item a').removeClass('active');
    $(this).children().addClass('active');
});

$('.viewcours-structure-btn').on('click', function(){
    $('.viewcours-structure_main').fadeOut(300, function(){
        $('.viewcours-structure_all').fadeIn(300);
    });
});

$('.viewcours-structure_all_module-btn').on('click', function(){
    $(this).next().toggleClass('active');
});
$('.viewcours-structure_all_module-block-btn').on('click', function(){
    $(this).next().toggleClass('active');
});


$('.viewcours_test-radio').styler();

$('.vebinar-notif-btn').on('click', function(){
    $('.vebinar_notif-pop-back').fadeIn(300);
});

$('.pop-close, .vebinar_notif-pop-btn').on('click', function(){
    $('.vebinar_notif-pop-back').fadeOut(300);
});

$('.vebinar_notif-pop-back').on('click', function(e){
    if (!$('.vebinar_notif-pop').is(e.target)
        && $('.vebinar_notif-pop').has(e.target).length === 0) {
        $('.vebinar_notif-pop-back').fadeOut(300);
    }
});

$('.career_nav_list-item').on('click', function(){
    if(!$(this).hasClass('active')){
        $('.career_nav_list-item').removeClass('active');
        $(this).addClass('active');
    }
});

$('.create-resume-open-btn').on('click', function(){
    $('.create-resume-form').addClass('active');
    $('.create-resume').hide();
});



$('.viewcours_test-radio').styler();

$('.career_nav_list-item-link').on('click', function(){
    setTimeout(function(){
        let page = location.hash;
        if(page == '#page1'){
            $('.career-pages').removeClass('active');
            $('.resume').addClass('active');
        }else if(page == '#page2'){
            $('.career-pages').removeClass('active');
            $('.vacancies').addClass('active');
        }else if(page == '#page3'){
            $('.career-pages').removeClass('active');
            $('.reviews').addClass('active');
        }
    }, 1);
});

let page = location.hash;
if(page == '#page1'){
    $('.career-pages, .career_nav_list-item').removeClass('active');
    $('.resume, .career1').addClass('active');
}else if(page == '#page2'){
    $('.career-pages, .career_nav_list-item').removeClass('active');
    $('.vacancies, .career2').addClass('active');
}else if(page == '#page3'){
    $('.career-pages, .career_nav_list-item').removeClass('active');
    $('.reviews, .career3').addClass('active');
}else {
    $('.career-pages, .career_nav_list-item').removeClass('active');
    $('.resume, .career1').addClass('active');
}

$('.vacancy-reply').on('click', function(){
    $('.vebinar_notif-pop-back').fadeIn(300);
    $('.vacancy-reply-done').addClass('active');
});

$('.myprogramm_right_top_spoiler-btn').on('click', function(){
    $(this).parent().toggleClass('active');
});

$('body').on('click', function(e){
    if (!$('.myprogramm_right_top_spoiler').is(e.target) && $('.myprogramm_right_top_spoiler').has(e.target).length === 0) {
        $('.myprogramm_right_top_spoiler').removeClass('active');
	}
});

$('.mypr-btn').on('click', function(){
    setTimeout(function(){
        if(location.hash == '#page1' && !$('.myprs-1').hasClass('active')){
            $('.myprs').removeClass('active');
            $('.myprs-1').addClass('active');
        }else if(location.hash == '#page2' && !$('.myprs-2').hasClass('active')){
            $('.myprs').removeClass('active');
            $('.myprs-2').addClass('active');
        }else if(location.hash == '#page3' && !$('.myprs-3').hasClass('active')){
            $('.myprs').removeClass('active');
            $('.myprs-3').addClass('active');
        }
    }, 1);
});

$('.stat_list_card_bottom-btn').on('click', function(){
    $('.stat_list_card-detales').toggleClass('active');
    $(this).toggleClass('active');
    if($(this).hasClass('active')){
        $(this).text('Скрыть детали');
    }else{
        $(this).text('Показать детали');
    }
});

$('.myprogramm-assistants_row_right_list').each(function(){
    $(this).children().each(function(e){
        if(e > 7){
            $(this).hide();
            $(this).parent().next().addClass('active');
        }
    });
});

$('.myprogramm-assistants_row_right_list-btn').on('click', function(){
    $(this).prev().children().each(function(e){
        if(e > 7){
            $(this).show();
            $(this).parent().next().removeClass('active');
        }
    });
});

$('.lecture-materials_main-list').each(function(){
    $(this).children().each(function(e){
        if(e > 3){
            $(this).hide();
            $(this).parent().next().addClass('active');
        }
    });
});

$('.lecture-materials_main-btn').on('click', function(){
    $(this).prev().children().each(function(e){
        if(e > 3){
            $(this).parent().next().hide();
            $(this).parent().next().next().show();
            $(this).show();
        }
    });
});

$('.lecture-materials_main-btn-close').on('click', function(){
    $(this).prev().prev().children().each(function(e){
        if(e > 3){
            $(this).hide();
            $(this).parent().next().show();
            $(this).parent().next().next().hide();
        }
    });
});