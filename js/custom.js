/**
 * Created by guillaumevandecasteele on 06/06/16.
 */
//Not really worth putting in its own script file, but I wanted to limit the amount of places a person could reserve
//with the amount of available tickets.
$("#inputDay").change(function () {
    var maxAvailable = $('option:selected', this).attr('amount');
    var price = $('option:selected', this).attr('price');
    $("#price").html(price + "&euro;");
    $("#inputAmount").prop('max', maxAvailable);
    $("#inputAmount").prop('value', 1);
});

$('#dateTimePicker').datetimepicker({
});