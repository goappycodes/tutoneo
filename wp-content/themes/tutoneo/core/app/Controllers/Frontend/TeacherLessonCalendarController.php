<?php

namespace App\Controllers\Frontend;

use App\Config\Config;
use App\Config\Settings;
use App\Controllers\Controller;
use App\Events\LessonCreatedEvent;
use App\Events\LessonCancelledEvent;
use App\Events\LessonCompletedEvent;
use App\Events\LessonUpdatedEvent;
use App\Http\Request;
use App\Http\Response;
use App\Models\Booking;
use App\Models\Lesson;
use App\Models\Page;
use App\Models\User;
use App\Services\Auth;

class TeacherLessonCalendarController extends Controller
{
    const ALL_LESSONS_ACTION     = Config::APP_PREFIX . 'get_all_lessons';
    const GET_LESSON_ACTION      = Config::APP_PREFIX . 'get_lesson';
    const ADD_LESSON_ACTION      = Config::APP_PREFIX . 'add_lesson';
    const UPDATE_LESSON_ACTION   = Config::APP_PREFIX . 'update_lesson';
    const CANCEL_LESSON_ACTION   = Config::APP_PREFIX . 'cancel_lesson';
    const COMPLETE_LESSON_ACTION = Config::APP_PREFIX . 'complete_lesson';

    public function __construct()
    {
        register_page_scripts(Page::TEACHER_LESSONS, $this, 'enqueue_scripts');
        add_shortcode(Config::APP_PREFIX . 'teacher_lesson_calendar', [$this, 'get_calendar']);
        add_action('wp_ajax_' . self::ALL_LESSONS_ACTION, [$this, 'get_all_lessons']);
        add_action('wp_ajax_' . self::ADD_LESSON_ACTION, [$this, 'add_lesson']);
        add_action('wp_ajax_' . self::UPDATE_LESSON_ACTION, [$this, 'update_lesson']);
        add_action('wp_ajax_' . self::CANCEL_LESSON_ACTION, [$this, 'cancel_lesson']);
        add_action('wp_ajax_' . self::COMPLETE_LESSON_ACTION, [$this, 'complete_lesson']);
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
            Config::APP_PREFIX . 'teacher-lesson-calendar',
            Config::PUBLIC_CSS_DIR_URI . '/teacher-lesson-calendar.css',
            [Config::PUBLIC_HANDLE],
            Config::VERSION
        );

        wp_enqueue_style(
            Config::APP_PREFIX . 'teacher_lesson_calendar_css',
            'https://cdn.jsdelivr.net/npm/fullcalendar@5.3.2/main.min.css'
        );

        wp_enqueue_script(
            Config::APP_PREFIX . 'manage_lesson',
            Config::PUBLIC_JS_DIR_URI . '/manage-lesson.js',
            [Config::PUBLIC_HANDLE],
            '1.0.0',
            true
        );

        wp_enqueue_script(
            Config::APP_PREFIX . 'teacher_lesson_calendar',
            Config::PUBLIC_JS_DIR_URI . '/teacher-lesson-calendar.js',
            [Config::APP_PREFIX . 'fullcalendar', Config::APP_PREFIX . 'manage_lesson'],
            '1.0.2',
            true
        );

        wp_localize_script(
            Config::APP_PREFIX . 'teacher_lesson_calendar',
            'teacher_lesson_calendar',
            [
                'assigned_bookings' => $this->get_valid_bookings(),
                'all_lessons'       => $this->get_lessons_as_events(),
                'url_args'          => $_GET, 
                'initialDate'       => $this->get_initial_date()
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
        if (!Auth::has_role(User::TEACHER_ROLE)) {
            Auth::show_403();
        }

        if (Auth::check()) {
            $this->view(Config::PUBLIC_VIEWS_DIR . '/teacher-lesson-calendar');
        }
    }

    public function get_valid_bookings()
    {
        $data = [];
        $bookings = Auth::user()->bookings();

        foreach ($bookings as $booking) {
            if (!$booking->completed() && $booking->has_successful_payment() && $booking->is_created()) {
                $data[] = [
                    'id' => $booking->get_reference(),
                    'title' => $booking->get_title(),
                ];
            }
        }

        return $data;
    }

    public function get_all_lessons()
    {
        return Auth::user()->lessons();
    }

    public function get_lessons_as_events()
    {
        $lesson_events = [];
        $lessons = $this->get_all_lessons();

        foreach ($lessons as $lesson) {
            $id    = $lesson->get_reference();
            $title = $lesson->get_reference();
            $start = $lesson->get_start_time();
            $end   = $lesson->get_end_time();
            $completed = $lesson->completed();

            $lesson_events[] = [
                'id'    => $id,
                'title' => $title,
                'start' => $start,
                'end'   => $end,
                'completed' => $completed,
                'color' => $completed ?
                    Settings::lesson_completed_color() : Settings::lesson_active_color()
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
        ]);

        $lesson_created_event = new LessonCreatedEvent($lesson);
        $lesson_created_event->fire();

        Response::success([
            'message' => __('Lesson added successfully!'),
            'redirect' => get_page_url(Page::TEACHER_LESSONS),
        ]);
    }

    public function update_lesson()
    {
        $data = Request::get_validated_data($_POST, [
            'reference_no' => ['required', 'post_meta_exists:' . Lesson::POST_TYPE],
            'start_time' => ['required', 'datetime:d-m-Y H:i'],
        ]);

        if ($this->check_for_exisiting_lesson($data['start_time'])) {
            Response::error([
                'message' => 'A lesson already exists with this time'
            ]);
        }

        $lesson_hour = Settings::get_default_lesson_duration();
        $end = \DateTime::createFromFormat('d-m-Y H:i', $data['start_time']);
        $end = $end->add(new \DateInterval("PT{$lesson_hour}H"));

        $lesson = Lesson::find_by_ref($data['reference_no']);
        $lesson->set_start_time($data['start_time']);
        $lesson->set_end_time($end->format('Y-m-d H:i:s'));

        $lesson_updated_event = new LessonUpdatedEvent($lesson);
        $lesson_updated_event->fire();

        Response::success([
            'message' => __('Lesson updated successfully!'),
            'redirect' => get_page_url(Page::TEACHER_LESSONS),
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

    public function complete_lesson()
    {
        $data = Request::get_validated_data($_POST, [
            'reference_no' => ['required', 'post_meta_exists:' . Lesson::POST_TYPE],
        ]);

        $lesson = Lesson::find_by_ref($data['reference_no']);

        $lesson_cancelled_event = new LessonCompletedEvent($lesson);
        $lesson_cancelled_event->fire();

        Response::success([
            'message' => __('Lesson completed successfully!'),
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
