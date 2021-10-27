$(document).ready(function () {
    if (typeof payments_obj !== 'undefined') {
        var form = $('#credit-points-withdrawal-form');
        var credit_points_el = form.find('#credit_points');
        var txn_id = form.find('input[name="txn_id"]');

        credit_points_el.on('keyup change', function(e) {
            var val = parseFloat($(this).val());
            $('.converted_amount').html(val * payments_obj.student_rate);
        });

        $('.withdraw-credit-points').click(function(e) {
            var id = $(this).data('id');
            var max = $(this).data('max');
            txn_id.val(id);
            credit_points_el.prop('max', max);
        });
    }
});