$(document).ready(function () {
    if ($('.select2').length) {
        $('.select2').select2({
            placeholder: 'Choose Option'
        });
    }

    $('#profile_pic').change(function(e) {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.profile-pic img').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});