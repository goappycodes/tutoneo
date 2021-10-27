jQuery(function($) {
    $(document).ready(function () {
        
        var ajax_loader = $('.ajax-loading');

        $('body').on('submit', 'form.ajax-form', function (e) { 
            e.preventDefault();
            sendAjaxRequest($(this));
        });
    
        function sendAjaxRequest(form) {
            var media = form.prop('enctype') == 'multipart/form-data' ? true : false;
            var data = prepapre_form_data(form, media);
            
            var ajaxObj = {
                type: 'post',
                url: app_obj.ajax_url,
                data,
                beforeSend: function () {
                    beforeRequest();
                },
                success: function (response) {
                    handleResponse(response);
                },
                complete: function (response) {
                    completeRequest(response);
                }, 
                error: function () {
                    errorRequest();
                }
            };
    
            if (media) {
                $.extend(ajaxObj, {
                    contentType: false,
                    processData: false,
                });
            }
            
            $.ajax(ajaxObj);
        }
    
        function handleResponse(response) {
            var response = JSON.parse(response);
            if (typeof response.status == 'undefined') {
                return;
            }
    
            if (response.status == 'error') {
                if (typeof response.messages !== 'undefined') {
                    displayErrors(response.messages);
                }
            }
    
            if (typeof response.message !== 'undefined') {
                displayMessage(response.message, response.status);
            }
    
            if (response.status == 'success') {
                if ($('.modal').length) {
                    $('.modal').modal('hide');
                }
            }
    
            if (typeof response.reload !== 'undefined') {
                window.location.reload();
            }
    
            if (typeof response.redirect !== 'undefined') {
                window.location = response.redirect;
            }
        }
    
        function displayErrors(messages) {
            $('.input-error').html('');
            $.each(messages, function (i, v) {
                $(':input[name="' + i + '"]').after(
                    "<div class='input-error'>" + v[0] + "</div>"
                );
            });
        }
    
        function displayMessage(message, type = 'success') {
            swal(type.charAt(0).toUpperCase() + type.slice(1) + '!', message, type);
        }
    
        function beforeRequest() {
            ajax_loader.show();
            $('.input-error').html('');
            $('form').find(':input').prop('disabled', true);
        }
    
        function completeRequest() {
            ajax_loader.hide();
            $('form').find(':input').prop('disabled', false);
        }

        function errorRequest() {
            ajax_loader.hide();
            swal('Error!', 'Server returned an error!', 'error');
        }
    
        function prepapre_form_data(form, media) {
            var formData = media ? new FormData() : {};
            form.find(':input').each(function (e) {
                var name = $(this).attr('name');
                var value = get_input_value($(this), media);
                if (typeof name !== 'undefined') {
                    if (media) {
                        formData.append([name], value);
                    } else {
                        $.extend(formData, { [name]: value });
                    }
                }
            });
    
            return formData;
        }
    
        function get_input_value(input, media) {
            var type = input.attr('type');
            if (type == 'file' && media) {
                return get_input_file(input);
            }
    
            return input.val();
        }
    
        function get_input_file(input) {
            var files = input[0].files;
            var multiple = input.prop('multiple');
            
            if (files.length) {
                return multiple ? files : files[0];
            }
    
            return null;
        }


        $('.custom-datepicker').flatpickr({
            dateFormat: 'd-m-Y',
        });

        $('.custom-datetimepicker').flatpickr({
            dateFormat: 'd-m-Y H:i',
            enableTime: true,
        });

    }); 
});