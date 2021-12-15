$(document).ready(function () {
    if (typeof student_lesson_calendar !== 'undefined') {

        var lessonActionModal = $('#lesson-action-modal');

        var addLessonModal = $('#add-lesson-modal');
        var addLessonForm = $('#add-lesson-form');
        var lessonFormBooking = addLessonForm.find(':input[name="reference_no"]');
        var lessonFormStartTime = addLessonForm.find(':input[name="start_time"]');

        var lesson_postpone_modal = $('#lesson-postpone-modal');
        var calendarEl = document.getElementById('student-lesson-calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            editable: false,
            eventDurationEditable: false,
            events: student_lesson_calendar.lessons,
            displayEventTime: true,
            initialDate: student_lesson_calendar.initialDate,
            pending: student_lesson_calendar.pending,
            eventContent: function (args) {
                var content = args.event.title;
                return { html: content };
            },
            eventClick: function (eventClickInfo) {
                if (eventClickInfo.event.extendedProps.completed) {
                    return false;
                }
                console.log(eventClickInfo);
                showActionModal(eventClickInfo.event.id);
            }
        });

        calendar.render();
        fillBookings();

        function showActionModal(id)
        {
            var event = calendar.getEventById(id);
            lessonActionModal.find('.lesson-action-btn :input').attr('data-lesson', id);
            lessonActionModal.find('.lesson-action-btn :input').attr('data-start', getFormattedDateTime(event.start));
            lessonActionModal.modal('show');
        }

        if (student_lesson_calendar.url_args.booking !== 'undefined') {
            if (student_lesson_calendar.url_args.action !== 'undefined') {
                switch (student_lesson_calendar.url_args.action) {
                    case 'add': 
                        lessonFormBooking.val(student_lesson_calendar.url_args.booking);
                        addLessonModal.modal('show');
                        break;
                    case 'reschedule': 
                        rescheduleLesson.val(student_lesson_calendar.url_args.lesson);
                        rescheduleLessonModal.modal('show');
                        break;
                    default:
                }
            }
        }

        $('body').on('click', '.lesson-postpone-request', function (e) {
            e.preventDefault();
            lesson_postpone_modal.modal('show');
        });

        function fillBookings() {
            lessonFormBooking.html('');
            student_lesson_calendar.assigned_bookings.forEach(booking => {
                lessonFormBooking.append(
                    '<option value="' + booking.id + '">' + booking.title + '</option>'
                );
            });
        }
    }
}); 