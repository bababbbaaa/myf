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

    const slider = document.getElementById("slider"),
        min = slider.min,
        max = slider.max,
        value = slider.value;

    $('#text').on('input', function () {
        showTextValue();
        slider.style.background = `linear-gradient(180deg, #DF2C56 0%, #C81F47 100%)`;
    });

    $('#slider').on('input', function () {
        showSliderValue();
    });
    // linear-gradient(to right, #0093D5 0%, #01EB6A ${(slider.value-slider.min)/(slider.max-slider.min)*100}%, rgb(250 252 255) ${(slider.value-slider.min)/(slider.max-slider.min)*100}%,
    // linear-gradient(to right, #0093D5, #01EB6A ${(value-min)/(max-min)*100}%, rgb(250, 252, 255) ${(value-min)/(max-min)*100}%,
        slider.style.background = `rgb(235 237 239) 100%)`;
    // linear-gradient(to right, #0093D5 0%, #01EB6A ${(this.value-this.min)/(this.max-this.min)*100}%, rgb(250 252 255) ${(this.value-this.min)/(this.max-this.min)*100}%,
    slider.oninput = function() {
        this.style.background = `rgb(235 237 239) 100%)`;
    };

    $('#result').val(2125000);

    $('#text, #slider').on('input', function(){
        var a = $('#slider').val();
        var c = (a * 0.095 * 50000) - (500 * a);
        $('#result').val(c);
    });

});

const inpuT = document.querySelector('.TL_input_range');
const spanRange = document.querySelector('.Tl__wrapp span');

inpuT.addEventListener('input', () => {
    spanRange.style.width = `${inpuT.value / 1000 * 100}%`;
});

