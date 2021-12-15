<?php

namespace App\Controllers\Frontend;

use App\Config\Config;
use App\Config\Settings;
use App\Controllers\Controller;
use App\Events\LessonCancelledEvent;
use App\Http\Request;
use App\Http\Response;
use App\Models\Booking;
use App\Models\Lesson;
use App\Models\Page;
use App\Models\User;
use App\Services\Auth;

class StudentLessonCalendarController extends Controller
{
    const CANCEL_ACTION = Config::APP_PREFIX . 'cancel_lesson_by_student';

    const ADD_LESSON_ACTION      = Config::APP_PREFIX . 'add_lesson_by_student';

    public function __construct()
    {
        register_page_scripts(Page::STUDENT_LESSONS, $this, 'enqueue_scripts');
        add_shortcode(Config::APP_PREFIX . 'student_lesson_calendar', [$this, 'get_calendar']);

        add_action('wp_ajax_' . self::ADD_LESSON_ACTION, [$this, 'add_lesson']);

        add_action('wp_ajax_' . self::CANCEL_ACTION, [$this, 'cancel_lesson']);
    } 

    public function enqueue_scripts()
    {
        wp_enqueue_script(
            Config::APP_PREFIX . 'fullcalendar',
            'https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.js',
            [Config::APP_HANDLE],
            true
        );

        wp_enqueue_style(
            Config::APP_PREFIX . 'fullcalendar',
            'https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.css'
        );
        
        wp_enqueue_style(
            Config::APP_PREFIX . 'student-lesson-calendar',
            Config::PUBLIC_CSS_DIR_URI . '/student-lesson-calendar.css',
            [Config::PUBLIC_HANDLE],
            '1.0.1'
        );

        wp_enqueue_script(
            Config::APP_PREFIX . 'manage_lesson',
            Config::PUBLIC_JS_DIR_URI . '/manage-lesson.js',
            [Config::PUBLIC_HANDLE],
            '1.0.0',
            true
        );

        wp_enqueue_script(
            Config::APP_PREFIX . 'student_lesson_calendar',
            Config::PUBLIC_JS_DIR_URI . '/student-lesson-calendar.js',
            [Config::APP_PREFIX . 'fullcalendar', Config::APP_PREFIX . 'manage_lesson'],
            '1.0.2',
            true
        );

        wp_localize_script(
            Config::APP_PREFIX . 'student_lesson_calendar',
            'student_lesson_calendar',
            [
                'assigned_bookings' => $this->get_valid_bookings(),
                'lessons' => $this->get_lessons_as_events(),
                'initialDate' => $this->get_initial_date(),
                'url_args'          => $_GET, 
            ]
        );
    }

    public function get_initial_date()
    {
        if (isset($_GET['lesson'])) {
            $lesson = Lesson::find_by_ref($_GET['lesson']);
            if ($lesson) {
                return $lesson->get_start_time();
            }
        }

        return Auth::user()->get_nearest_lesson_date();
    }

    public function get_calendar()
    {
        if (!Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) {
            Auth::show_403();
        }

        if (Auth::check()) {
            $this->view(Config::PUBLIC_VIEWS_DIR . '/student-lesson-calendar');
        }
    }

     public function get_valid_bookings()
    {
        $data = [];
        $bookings = Auth::user()->bookings();

        foreach ($bookings as $booking) {
            
            if (!$booking->completed() && $booking->is_created()) {
                $data[] = [
                    'id' => $booking->get_reference(),
                    'title' => $booking->get_title(),
                ];
            }
        }

        return $data;
    }

    public function get_lessons_as_events()
    {
        $lesson_events = [];
        $lessons = Auth::user()->lessons();

        foreach ($lessons as $lesson) {
            $lesson_events[] = [
                'id' => $lesson->get_reference(),
                'title' => $lesson->get_reference(),
                'start' => $lesson->get_start_time(),
                'end' => $lesson->get_end_time(),
                'completed' => $lesson->completed(),
                // 'color' => $lesson->completed() ?
                //     Settings::lesson_completed_color() : Settings::lesson_active_color()
                'color' => $lesson->completed() ?
                    Settings::lesson_completed_color() : ( $lesson->pending() ? Settings::lesson_pending_color() : Settings::lesson_active_color() )
            ];
        }

        return $lesson_events;
    }

    public function add_lesson()
    {
        $data = Request::get_validated_data($_POST, [
            'reference_no' => ['required', 'post_meta_exists:' . Booking::POST_TYPE],
            'start_time' => ['datetime:d-m-Y H:i', 'required'],
        ]);

        if ($this->check_for_exisiting_lesson($data['start_time'])) {
            Response::error([
                'message' => 'A lesson already exists with this time'
            ]);
        }
        
        $booking = Booking::find_by_ref($data['reference_no']);
        $lesson_hour = Settings::get_default_lesson_duration();
        $end = \DateTime::createFromFormat('d-m-Y H:i', $data['start_time']);
        $end = $end->add(new \DateInterval("PT{$lesson_hour}H"));

        $ref = Lesson::create_reference_no();
        
        $lesson = Lesson::insert([
            'post_title' => 'Lesson #' . $ref,
            'post_type' => Lesson::POST_TYPE,
            'post_status' => 'publish'
        ]);

        $lesson->update_meta_set([
            Lesson::REFERENCE  => $ref,
            Lesson::BOOKING    => $booking->get_id(),
            Lesson::START_TIME => $data['start_time'],
            Lesson::END_TIME   => $end->format('Y-m-d H:i:s'),
            Lesson::COMPLETED  => 0,
            Lesson::IS_CANCELLED => 0,
            Lesson::PENDING => 1,//when student make any booking, it will be pending unless teacher approved it
        ]);

        // $lesson_created_event = new LessonCreatedEvent($lesson);
        // $lesson_created_event->fire();

        Response::success([
            'message' => __('Lesson added successfully!'),
            'redirect' => get_page_url(Page::STUDENT_LESSONS),
        ]);
    }

    public function cancel_lesson()
    {
        $data = Request::get_validated_data($_POST, [
            'reference_no' => ['required', 'post_meta_exists:' . Lesson::POST_TYPE],
            'reason' => ['required']
        ]);

        $lesson = Lesson::find_by_ref($data['reference_no']);
        $lesson->mark_cancelled();
        $lesson->set_cancelled_by(Auth::user()->get_id());
        $lesson->set_reason($data['reason']);

        $lesson_cancelled_event = new LessonCancelledEvent($lesson);
        $lesson_cancelled_event->fire();

        Response::success([
            'message' => __('Lesson cancelled successfully!'),
            'reload' => true,
        ]);
    }

    public function check_for_exisiting_lesson($start_time)
    {
        $existing_lesson = Lesson::find_by_meta([
            [ Lesson::BOOKING, Auth::user()->get_comma_separated_booking_ids(), 'IN' ],
            [ Lesson::START_TIME, $start_time ],
            [ Lesson::IS_CANCELLED, 0 ]
        ], ['numberposts' => 1]);

        if (count($existing_lesson)) {
            return true;
        }

        return false;
    }

}
