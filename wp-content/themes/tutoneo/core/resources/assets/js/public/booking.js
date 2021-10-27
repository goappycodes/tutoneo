$(document).ready(function () {

    if (typeof booking_obj !== 'undefined') {
        if (booking_obj.message != '') {
            swal(booking_obj.message);
        }
    }

});