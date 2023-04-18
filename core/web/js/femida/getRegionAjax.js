var timeoutAjaxFindRegion = null;
$('.region-finder').on('input', '.chosen-search-input', function () {
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
            url: "/femida/main/get-regions-ajax"
        }).done(
            function (response) {
                if (response !== null && response.region !== undefined) {
                    var
                        html = '',
                        region = response.region;
                    if(region !== null && region !== undefined) {
                        html += "<optgroup label='Республика / Область / Край'>";
                        for (var j = 0; j < region.length; j++)
                            html += "<option value='" + region[j] + "'>" + region[j] + "</option>";
                        html += "</optgroup>";
                    }
                    console.log(results);
                    results.html(html);
                    $(".chosen-select").trigger("chosen:updated");
                }
            }
        );
    }, 1000);
});