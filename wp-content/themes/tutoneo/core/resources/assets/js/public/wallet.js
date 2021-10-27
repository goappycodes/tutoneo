$(document).ready(function () {
    if (typeof wallet_obj !== 'undefined') {
        var modal = $('#wallet-withdraw-modal');
        var form = $('#wallet-withdrawal-form');
        
        form.submit(function(e) {
            e.preventDefault();
            var formData = {
                action: wallet_obj.withdrawal_action,
                amount: form.find('#amount').val()
            };

            sendAjaxRequest(formData);
        });
    }
});