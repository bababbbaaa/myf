var timeoutAjaxFindRegion = null;
$('.city-finder').on('input', '.chosen-search-input', function () {
    var
        value = $(this).val(),
        results = $(this).parent().parent().parent().prev();
    if (timeoutAjaxFindRegion !== null)
        clearTimeout(timeoutAjaxFindRegion);
    timeoutAjaxFindRegion = setTimeout(function () {
        $.ajax({
            data: {find: value},
            dataType: "JSON",
            type: "POST",
            url: "/lead-force/main/get-regions-ajax"
        }).done(
            function (response) {
                if (response !== null && response.city !== undefined) {
                    var
                        html = '',
                        city = response.city;
                    if(city !== null && city !== undefined) {
                        html += "<optgroup label='Города'>";
                        for (var i = 0; i < city.length; i++)
                            html += "<option value='" + city[i] + "'>" + city[i] + "</option>";
                        html += "</optgroup>";
                    }
                    results.html(html);
                    $(".chosen-select").trigger("chosen:updated");
                }
            }
        );
    }, 500);
});