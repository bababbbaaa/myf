var
    cntrlIsPressed = false,
    leadsInterval = null,
    leadsTimeout = null,
    animBlock = $('.anim-ajax-block');

$(".chosen-select").chosen({disable_search_threshold: 0});

function setIntervalLeads() {
    animBlock.show();
    leadsInterval = setInterval(function () {
        //$.pjax.reload({container: "#pjaxMain", async: true, timeout: false});
        $('.grid-view').yiiGridView('applyFilter');
    }, 5000);
}


$('.admin-container').on("click", 'tr', function(e) {
    if(cntrlIsPressed)
        $(this).toggleClass('selected-tr');
});

$(document).bind('keydown', function(event){
    if(event.which === 17)
        cntrlIsPressed = true;
    clearInterval(leadsInterval);
    clearTimeout(leadsTimeout);
    animBlock.hide();
});

$(document).bind('keyup', function(){
    cntrlIsPressed = false;
    animBlock.hide();
    clearInterval(leadsInterval);
    clearTimeout(leadsTimeout);
    leadsTimeout = setTimeout(function () {
        setIntervalLeads();
    }, 10000);
});

$(document).bind('click', function () {
    clearInterval(leadsInterval);
    clearTimeout(leadsTimeout);
    animBlock.hide();
    leadsTimeout = setTimeout(function () {
        setIntervalLeads();
    }, 10000);
});

$(document).bind('mouseover', function () {
    clearInterval(leadsInterval);
    clearTimeout(leadsTimeout);
    animBlock.hide();
    leadsTimeout = setTimeout(function () {
        setIntervalLeads();
    }, 10000);
});


setIntervalLeads();

var rightScroll = null;
var leftScroll = null;

$('.leads-index').on({
    click: function () {
        var block = $(this).prev();
        var table = block.children().children();
        block.scrollLeft(table.width());
    },
    mouseover: function () {
        var block = $(this).prev();
        rightScroll = setInterval(function () {
            var scrollValue = block.scrollLeft() + 10;
            block.scrollLeft(scrollValue)
        }, 10);
    },
    mouseout: function () {
        clearInterval(rightScroll);
    }
}, '.flex-grid-main > div:last-child');

$('.leads-index').on({
    click: function () {
        var block = $(this).next();
        block.scrollLeft(0);
    },
    mouseover: function () {
        var block = $(this).next();
        leftScroll = setInterval(function () {
            var scrollValue = block.scrollLeft() - 10;
            if (scrollValue < 0)
                scrollValue = 0;
            block.scrollLeft(scrollValue)
        }, 10);
    },
    mouseout: function () {
        clearInterval(leftScroll);
    }
}, '.flex-grid-main > div:first-child');

document.addEventListener('scroll', function (event) {
    if (event.target.id === 'scrolled-block') { // or any other filtering condition
        var block = $('#scrolled-block');
        var table = block.children().children();
        if (block.scrollLeft() === 0) {
            block.css('box-shadow', 'inset -8px -8px 15px 0px gainsboro');
        } else if ((table.width() - block.width()) - block.scrollLeft() < 5) {
            block.css('box-shadow', 'inset 8px -8px 15px 0px gainsboro');
        } else {
            block.css('box-shadow', 'inset 0px -8px 11px 5px gainsboro');
        }
    }
}, true /*Capture event*/);

$('#pjaxMain').on('pjax:success', function () {
    var block1 = $('#scrolled-block');
    var table1 = block1.children().children();
    if ((table1.width() - block1.width()) - block1.scrollLeft() < 5) {
        block1.css('box-shadow', 'unset');
    }
});

var block1 = $('#scrolled-block');
var table1 = block1.children().children();
if ((table1.width() - block1.width()) - block1.scrollLeft() < 5) {
    block1.css('box-shadow', 'unset');
}


