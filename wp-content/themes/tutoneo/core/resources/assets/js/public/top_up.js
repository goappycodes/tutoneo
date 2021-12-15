$(document).ready(function () {
    if (typeof top_up_obj !== 'undefined') {
        $(document).ajaxSend(function() {
            $('.spinner-border').removeClass('d-none');
        });
        $('#apply_promo_code').on('click' , function(){
            let user_promo_code = $('#promo_code_val').val();
            let discount = 0;
            if( user_promo_code != null){
                $.ajax({
                    type: "post",
                    url: app_obj.ajax_url,
                    data: {
                        action: top_up_obj .promo_code_action,
                        promocode : user_promo_code,
                    },
                    success: function (response) {
                        document.getElementById("promo_msg").innerHTML = response;
                    },
                    error: function(response) {
                        document.getElementById("promo_msg").innerHTML = response;
                    }
                }).done(function() {
                    setTimeout(function(){
                        $('.spinner-border').addClass('d-none');
                    });
                });
            }
        });
    }
});