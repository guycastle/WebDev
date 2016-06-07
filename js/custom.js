/**
 * Created by guillaumevandecasteele on 06/06/16.
 */
//Not really worth putting in its own script file, but I wanted to limit the amount of places a person could reserve
//with the amount of available tickets.
$("#inputDay").change(function () {
    var maxAvailable = $('option:selected', this).attr('amount');
    var price = $('option:selected', this).attr('price');
    var inputAmount = $("#inputAmount");
    $("#price").html(price + "&euro;");
    inputAmount.prop('max', maxAvailable);
    inputAmount.prop('value', 1);
});

$(".dropdown-selector").mouseup(function () {
    var day = $(this).attr('day');
    console.log(day);
    $("#inputDay").val(day).trigger('change');
});