$(document).ready(function () {

    var lesson_action_modal = $('#lesson-action-modal');
    var lesson_action_btn = lesson_action_modal.find('.lesson-action-btn :input');

    var lesson_complete_modal = $('#lesson-complete-confirmation');
    var lesson_complete_form = $('#lesson-complete-form');
    var complete_form_lesson = lesson_complete_form.find(':input[name="reference_no"]');
    var complete_form_lesson_payer_mail = lesson_complete_form.find(':input[name="payer_mail"]');
    var report_for_parent_field = $('#report_for_parent');

    var rescheduleLessonModal = $('#lesson-reschedule-modal');
    var rescheduleLessonForm = $('#lesson-reschedule-form');
    var rescheduleLesson = rescheduleLessonForm.find(':input[name="reference_no"]');
    var rescheduleStartTime = rescheduleLessonForm.find(':input[name="start_time"]');

    var lesson_cancel_modal = $('#lesson-cancel-confirmation');
    var lesson_cancel_form = $('#lesson-cancel-form');
    var lesson_field = lesson_cancel_form.find(':input[name="reference_no"]');

    $('body').on('click', '.lesson-action', function (e) {
        e.preventDefault();
        var reference_no = $(this).data('lesson');
        var start = $(this).data('start');
        var payer_mail = $(this).attr('data-payer_mail');
        lesson_action_btn.attr('data-lesson', reference_no);
        lesson_action_btn.attr('data-start', start);
        lesson_action_btn.attr('data-payer_mail', payer_mail);
        lesson_action_modal.modal('show');
    });

    $('body').on('click', '.lesson-complete-request', function (e) {
        e.preventDefault();
        let reference_no = $(this).attr('data-lesson');
        let payer_mail = $(this).attr('data-payer_mail');
        lesson_complete_modal.modal('show');
        complete_form_lesson.val(reference_no);
        if (payer_mail) {
            $('#report_for_parent').removeClass('d-none');
            complete_form_lesson_payer_mail.val(payer_mail);
        } else {
            $('#report_for_parent').addClass('d-none');
        }
    });

    $('body').on('click', '.lesson-reschedule-request', function () {
        var lesson = $(this).data('lesson');
        var start = $(this).data('start');
        rescheduleLesson.val(lesson);
        rescheduleStartTime.val(start);
        rescheduleLessonModal.modal('show');
    });

    $('body').on('click', '.lesson-cancel-request', function (e) {
        e.preventDefault();
        var lesson = $(this).data('lesson');
        swal({
            title: "Warning!",
            text: "If you cancel, your student will be notified of the cancellation, do you want to pursue with the cancallation?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((result) => {
                if (result) {
                    lesson_field.val(lesson);
                    lesson_cancel_modal.modal('show');
                }
            });
    });
});