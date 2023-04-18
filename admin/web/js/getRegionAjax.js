var timeoutAjaxFindRegion = null;
$('.region-block').on('input', '#findRegionSelect_chosen', function () {
    var
        value = $('.chosen-search-input', this).val(),
        results = $("#findRegionSelect");
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
                if (response !== null) {
                    var
                        html = '',
                        city = response.city,
                        region = response.region;
                    if(region !== null && region !== undefined) {
                        html += "<optgroup label='Республика / Область / Край'>";
                        for (var j = 0; j < region.length; j++)
                            html += "<option value='" + region[j] + "'>" + region[j] + "</option>";
                        html += "</optgroup>";
                    }
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
    }, 1000);
});