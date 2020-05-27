$(document).ready(function() {
    $('#dataTable').DataTable();

    $("#usage_unlimited").on("click", function() {
        console.log('snnfnfhndf');
        if ($('#usage_amount').is(":disabled")) {
            $('#usage_amount').prop('disabled', false);
        } else {
            $('#usage_amount').prop('disabled', true);
        }
    });
    console.log('dddd');
    $('#delete-btn').on('click', function(e) {
        e.preventDefault();
        $('#delete-coupon-form').submit();
    });
});