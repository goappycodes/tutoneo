$(document).ready(function () {
    if (typeof teacher_lesson_calendar !== 'undefined') {

        var calendarEl = document.getElementById('teacher-lesson-calendar');

        var lessonActionModal = $('#lesson-action-modal');

        var addLessonModal = $('#add-lesson-modal');
        var addLessonForm = $('#add-lesson-form');
        var lessonFormBooking = addLessonForm.find(':input[name="reference_no"]');
        var lessonFormStartTime = addLessonForm.find(':input[name="start_time"]');

        var rescheduleLessonModal = $('#lesson-reschedule-modal');
        var rescheduleLessonForm = $('#lesson-reschedule-form');
        var rescheduleLesson = rescheduleLessonForm.find(':input[name="reference_no"]');
        var rescheduleStartTime = rescheduleLessonForm.find(':input[name="start_time"]');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'timeGridWeek',
            editable: true,
            eventDurationEditable: false,
            events: teacher_lesson_calendar.all_lessons,
            displayEventTime: true,
            initialDate: teacher_lesson_calendar.initialDate,
            dateClick: function (dateClickInfo) {
                // addLesson(dateClickInfo);
            },
            eventDrop: function (eventClickInfo) {
                updateLesson(eventClickInfo);
            },
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
        fillBookings();

        function showActionModal(id)
        {
            var event = calendar.getEventById(id);
            lessonActionModal.find('.lesson-action-btn :input').attr('data-lesson', id);
            lessonActionModal.find('.lesson-action-btn :input').attr('data-start', getFormattedDateTime(event.start));
            lessonActionModal.modal('show');
        }
        
        if (teacher_lesson_calendar.url_args.booking !== 'undefined') {
            if (teacher_lesson_calendar.url_args.action !== 'undefined') {
                switch (teacher_lesson_calendar.url_args.action) {
                    case 'add': 
                        lessonFormBooking.val(teacher_lesson_calendar.url_args.booking);
                        addLessonModal.modal('show');
                        break;
                    case 'reschedule': 
                        rescheduleLesson.val(teacher_lesson_calendar.url_args.lesson);
                        rescheduleLessonModal.modal('show');
                        break;
                    default:
                }
            }
        }

        function addLesson(dateClickInfo) {
            addLessonModal.modal('show');
            lessonFormBooking.val('');
            lessonFormStartTime.val(getFormattedDateTime(dateClickInfo.date));
        }

        function updateLesson(eventClickInfo) {
            var event = eventClickInfo.event;

            if (event.extendedProps.completed == 1) {
                eventClickInfo.revert();
                return;
            }

            swal({
                title: "Warning!",
                text: "Do you really want to reschedule this lesson?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((result) => {
                if (result) {
                    rescheduleLesson.val(event.id);
                    rescheduleStartTime.val(getFormattedDateTime(event.start));
                    rescheduleLessonForm.submit();
                } else {
                    eventClickInfo.revert();
                }
            });
        }

        function fillBookings() {
            lessonFormBooking.html('');
            teacher_lesson_calendar.assigned_bookings.forEach(booking => {
                lessonFormBooking.append(
                    '<option value="' + booking.id + '">' + booking.title + '</option>'
                );
            });
        }
    } // end of condition
}); 