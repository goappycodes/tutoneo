$(document).ready(function () {
    if (typeof bookings_obj !== 'undefined') {
        var loader = $('.loader');

        var showDominantMemory = $('.show-dominant-memory-modal');
        var dominantMemoryModal = $('#dominant-memory-modal');
        var dominantMemoryTable = dominantMemoryModal.find('#dominant-memory-table');

        var showStudentQuestionnaireResponse = $('.show-student-questionnaire-response');
        var studentQuestionnaireResponseModal = $('#student-questionnaire-response-modal');
        var studentQuestionnaireResponseTable = studentQuestionnaireResponseModal.find('#questionnaire-table');

        var lesson_complete_modal = $('#lesson-complete-confirmation');
        var lesson_complete_form = $('#lesson-complete-form');
        var complete_form_lesson = lesson_complete_form.find(':input[name="reference_no"]');

        var report_booking_problem = $('#report-problem-action-modal');
        var report_booking_form = $('#report-problem-form');

        showDominantMemory.click(function (e) {
            e.preventDefault();
            var formData = {
                action: bookings_obj.fetch_d_m_response,
                booking: $(this).data('booking')
            };
            fetch_content(formData, dominantMemoryModal, dominantMemoryTable);
        });

        showStudentQuestionnaireResponse.click(function (e) {
            e.preventDefault();
            var formData = {
                action: bookings_obj.fetch_ques_response,
                booking: $(this).data('booking')
            };
            fetch_content(formData, studentQuestionnaireResponseModal, studentQuestionnaireResponseTable);
        });

        function fetch_content(formData, modal, el) {
            modal.modal('show');

            $.ajax({
                type: "post",
                url: app_obj.ajax_url,
                data: formData,
                beforeSend: function () {
                    el.html('');
                    loader.show();
                },
                success: function (response) {
                    el.html(response);
                },
                complete: function () {
                    loader.hide();
                }
            });
        }

        var in_progress = false;

        $('.clone-booking').click(function (e) {
            e.preventDefault();
            if (!in_progress) {
                in_progress = true;
                $(this).parents('.rebooking').find('.clone-booking-form').submit();
            }            
        });

        $('.clone-booking-without-teacher').click(function (e) {
            e.preventDefault();
            if (!in_progress) {
                in_progress = true;
                $(this).parents('.rebooking').find('.clone-booking-without-teacher-form').submit();
            }
        });

        $('.cancel-booking').click(function (e) {
            e.preventDefault();
            var booking_ref = $(this).data('booking');

            swal({
                title: "Are you sure ?",
                text: "Once cancelled, teacher will not be able to assign any lessons to this booking!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        type: "post",
                        url: app_obj.ajax_url,
                        data: {
                            action: bookings_obj.cancel_booking_action,
                            reference_no: booking_ref,
                        },
                        success: function (response) {
                           
                            var response = JSON.parse(response);
                            swal(response.message, "", response.status);
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        },
                        error: function() {
                            swal('Server returned an error!', "", 'error');
                        }
                    });        
                }
            });
        });

        $('.report-booking').click(function (e){
            e.preventDefault();
            var value  = $(this).attr('data-booking');
            console.log(value);
            report_booking_form.find("input[name='reference_no']").val(value);
            report_booking_problem.modal('show');
        });

        //  $('#report_submit').click(function(e){
        //     e.preventDefault();
        //     var booking_ref = report_booking_form.find("input[name='issue']").attr('data-booking');
        //     var message = report_form.find("input[name='issue']").val();
        //     $.ajax({
        //         type: "post",
        //         url: app_obj.ajax_url,
        //         data: {
        //             action: bookings_obj.report_booking_action,
        //             message : message,
        //             reference_no : booking_ref,
        //         },
        //         success: function (response) {
        //            console.log('success');
        //         },
        //         error: function() {
        //             console.log('fail');
        //         }
        //     });  
        // });
    }

});