$(document).ready(function () {
    function showSliderValue() {
        var sliderValue = document.getElementById("slider").value;
        var text = document.getElementById("text");
        text.value = sliderValue;
    }
    function showTextValue() {
        var textValue = document.getElementById("text").value;
        var slider = document.getElementById("slider");
        slider.value = textValue;
    }

    $('#text').on('input', function () {
        showTextValue();
        slider.style.background = `rgb(235 237 239) 100%)`;
    });

    $('#slider').on('input', function () {
        showSliderValue();
    });


    slider.style.background = `rgb(235 237 239) 100%)`;

    slider.oninput = function() {
        this.style.background = `rgb(235 237 239) 100%)`;
    };

    $('#result').val(500 * 150 * 0.75);
    $('#text, #slider').on('input', function(){
        var a = $('#slider').val();
        var c = a * 150 * 0.75;
        $('#result').val(c);
    });

});



