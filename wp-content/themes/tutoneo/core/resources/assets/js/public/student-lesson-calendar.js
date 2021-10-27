$(document).ready(function () {
    if (typeof student_lesson_calendar !== 'undefined') {

        var lessonActionModal = $('#lesson-action-modal');

        var lesson_postpone_modal = $('#lesson-postpone-modal');
        var calendarEl = document.getElementById('student-lesson-calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            editable: false,
            eventDurationEditable: false,
            events: student_lesson_calendar.lessons,
            displayEventTime: true,
            initialDate: student_lesson_calendar.initialDate,
            eventContent: function (args) {
                var content = args.event.title;
                return { html: content };
            },
            eventClick: function (eventClickInfo) {
                if (eventClickInfo.event.extendedProps.completed) {
                    return false;
                }
                showActionModal(eventClickInfo.event.id);
            }
        });

        calendar.render();

        function showActionModal(id)
        {
            var event = calendar.getEventById(id);
            lessonActionModal.find('.lesson-action-btn :input').attr('data-lesson', id);
            lessonActionModal.find('.lesson-action-btn :input').attr('data-start', getFormattedDateTime(event.start));
            lessonActionModal.modal('show');
        }

        $('body').on('click', '.lesson-postpone-request', function (e) {
            e.preventDefault();
            lesson_postpone_modal.modal('show');
        });
    }
}); 