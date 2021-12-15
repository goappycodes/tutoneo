<?php

namespace App\Controllers\Frontend;

use App\Models\Page;
use App\Models\User;
use App\Http\Request;
use App\Config\Config;
use App\Services\Auth;
use App\Models\Booking;
use App\Controllers\Controller;
use App\Events\BookingCancellationAlerts;
use App\Events\BookingCancelledEvent;
use App\Events\MatchFoundEvent;
use App\Events\BookingCreatedEvent;
use App\Events\PaymentRefundEvent;
use App\Http\Response;
use App\Notifications\Booking\BookingProblemReportNotification;


class BookingsController extends Controller
{
    const GET_DOMINANT_RESPONSE_ACTION = Config::APP_PREFIX . 'get_dominant_memory_response_action';
    const GET_QUESTIONNAIRE_RES_ACTION = Config::APP_PREFIX . 'get_questionnaire_response_action';
    const CLONE_BOOKING_ACTION = Config::APP_PREFIX . 'clone_booking';
    const CLONE_WITHOUT_TEACHER_ACTION = Config::APP_PREFIX . 'clone_booking_without_teacher';
    const CANCEL_BOOKING_ACTION = Config::APP_PREFIX . 'cancel_booking';
    const REPORT_BOOKING_PROBELM = Config::APP_PREFIX. 'report_booking';

    public function __construct()
    {
        register_page_scripts([Page::STUDENT_BOOKINGS, Page::TEACHER_BOOKINGS, Page::BOOKING_DETAILS], $this, 'enqueue_scripts');
        add_shortcode(Config::APP_PREFIX . 'bookings', [$this, 'get_bookings']);
        add_shortcode(Config::APP_PREFIX . 'booking_details', [$this, 'get_booking_details']);
        add_action('wp_ajax_' . self::GET_DOMINANT_RESPONSE_ACTION, [$this, 'get_dominant_memory_response']);
        add_action('wp_ajax_' . self::GET_QUESTIONNAIRE_RES_ACTION, [$this, 'get_questionnaire_response']);
        add_action('wp_ajax_' . self::CLONE_BOOKING_ACTION, [$this, 'clone_booking']);
        add_action('wp_ajax_' . self::CLONE_WITHOUT_TEACHER_ACTION, [$this, 'clone_booking_without_teacher']);
        add_action('wp_ajax_' . self::CANCEL_BOOKING_ACTION, [$this, 'cancel_booking']);
        add_action('wp_ajax_' . self::REPORT_BOOKING_PROBELM, [$this , 'report_booking_problem']);
    }
    
    public function enqueue_scripts()
    {
        wp_enqueue_style(
            Config::APP_PREFIX . 'bookings',
            Config::PUBLIC_CSS_DIR_URI . '/bookings.css',
            [Config::PUBLIC_HANDLE],
            '1.0.3'
        );

        wp_enqueue_script(
            Config::APP_PREFIX . 'manage_lesson',
            Config::PUBLIC_JS_DIR_URI . '/manage-lesson.js',
            [Config::PUBLIC_HANDLE],
            '1.0.0'
        );

        wp_enqueue_script(
            Config::APP_PREFIX . 'bookings',
            Config::PUBLIC_JS_DIR_URI . '/bookings.js',
            [Config::PUBLIC_HANDLE],
            '1.0.1'
        );

        wp_localize_script(
            Config::APP_PREFIX . 'bookings', 
            'bookings_obj', 
            [
                'fetch_d_m_response' => self::GET_DOMINANT_RESPONSE_ACTION,
                'fetch_ques_response' => self::GET_QUESTIONNAIRE_RES_ACTION, 
                'cancel_booking_action' => self::CANCEL_BOOKING_ACTION, 
                'report_booking_action' => self::REPORT_BOOKING_PROBELM,
            ]
        );
    }

    public function get_bookings()
    {
        if (!Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE, User::TEACHER_ROLE)) {
            Auth::show_403();
        }

        if (Auth::check()) {
            $this->view(Config::PUBLIC_VIEWS_DIR . '/bookings');
        }
    }

    public function get_booking_details()
    {
        if (!Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE, User::TEACHER_ROLE)) {
            Auth::show_403();
        }

        $ref = $_GET['ref'] ?? null;
        $booking = Booking::find_by_ref($ref);

        if (!$booking) {
            show_404();
        }

        $this->view(Config::PUBLIC_VIEWS_DIR . '/booking-details');
    }

    public function get_dominant_memory_response()
    {
        $this->view(Config::PUBLIC_VIEWS_DIR . '/partials/partial-dominant-memory-table');
    }

    public function get_questionnaire_response()
    {
        $this->view(Config::PUBLIC_VIEWS_DIR . '/partials/partial-student-questionnaire-response');
    }

    public function clone_booking()
    {
        $this->clone();
    }

    public function clone_booking_without_teacher()
    {
        $this->clone(false);
    }

    public function clone($with_teacher = true)
    {
        $data = Request::get_validated_data($_POST, [
            'reference_no' => ['required', 'post_meta_exists:' . Booking::POST_TYPE]
        ]);

        $booking = Booking::find_by_ref($data['reference_no']);

        $ref = Booking::create_reference_no();
        
        $new_booking = Booking::insert([
            'post_title' => "Booking #" . $ref,
            'post_type' => Booking::POST_TYPE,
            'post_status' => 'publish'
        ]);

        $new_booking->update_meta_set([
            Booking::REFERENCE_NO_FIELD     => $ref,
            Booking::USER_FIELD             => Auth::user()->get_id(),
            Booking::FIRST_NAME_FIELD       => $booking->get_meta(Booking::FIRST_NAME_FIELD),
            Booking::LAST_NAME_FIELD        => $booking->get_meta(Booking::LAST_NAME_FIELD),
            Booking::EMAIL_FIELD            => $booking->get_meta(Booking::EMAIL_FIELD),
            Booking::DATE_OF_BIRTH_FIELD    => $booking->get_meta(Booking::DATE_OF_BIRTH_FIELD),
            Booking::STREET_ADDRESS_FIELD   => $booking->get_meta(Booking::STREET_ADDRESS_FIELD),
            Booking::STREET_ADDRESS_2_FIELD => $booking->get_meta(Booking::STREET_ADDRESS_2_FIELD),
            Booking::CITY_FIELD             => $booking->get_meta(Booking::CITY_FIELD),
            Booking::STATE_PROVINCE_FIELD   => $booking->get_meta(Booking::STATE_PROVINCE_FIELD),
            Booking::ZIP_POSTAL_FIELD       => $booking->get_meta(Booking::ZIP_POSTAL_FIELD),
            Booking::COUNTRY_FIELD          => $booking->get_meta(Booking::COUNTRY_FIELD),
            Booking::PHONE_FIELD            => $booking->get_meta(Booking::PHONE_FIELD),
            Booking::SKYPE_ID_FIELD         => $booking->get_meta(Booking::SKYPE_ID_FIELD),
            Booking::ZOOM_ID_FIELD          => $booking->get_meta(Booking::ZOOM_ID_FIELD),
            Booking::HOURS_BOOKED_FIELD     => $booking->get_meta(Booking::HOURS_BOOKED_FIELD),
            Booking::HAS_THIRD_PARTY_FIELD  => $booking->get_meta(Booking::HAS_THIRD_PARTY_FIELD),
            Booking::PAYER_FIRST_NAME_FIELD => $booking->get_meta(Booking::PAYER_FIRST_NAME_FIELD),
            Booking::PAYER_LAST_NAME_FIELD  => $booking->get_meta(Booking::PAYER_LAST_NAME_FIELD),
            Booking::PAYER_EMAIL_FIELD      => $booking->get_meta(Booking::PAYER_EMAIL_FIELD),
            Booking::QUESTIONNAIRE_RESPONSE => $booking->get_meta(Booking::QUESTIONNAIRE_RESPONSE),
            Booking::QUESTIONNAIRE_RES_ID   => $booking->get_meta(Booking::QUESTIONNAIRE_RES_ID),
            Booking::STATUS                 => Booking::STATUS_CREATED,
        ]);

        (new BookingCreatedEvent($new_booking))->fire();

        if ($with_teacher) {
            $new_booking->set_meta(Booking::IS_MATCH_FOUND_FIELD, Booking::MATCH_FOUND);
            $new_booking->set_meta(Booking::TEACHER_FIELD, $booking->get_meta(Booking::TEACHER_FIELD));
            (new MatchFoundEvent($new_booking, true, true))->fire();
        }

        Response::success([
            'message' => 'Booking created successfully!',
            'reload' => true,
        ]);
    }

    public function cancel_booking()
    {
        try {
            $data = Request::get_validated_data($_POST, [
                'reference_no' => ['required', 'post_exists:' . Booking::POST_TYPE]
            ]);
            $booking = Booking::find_by_ref($data['reference_no']);
    
            if (! $booking || $booking->is_cancelled() || $booking->is_refunded()) {
                Response::error(__('Invalid booking'));
            }
            
            foreach($booking->datewise_sorted_lessons() as $lesson): 
                if(!$lesson->completed()):
                    $payment_refund_event = new PaymentRefundEvent($booking , $lesson);
                    $payment_refund_event->fire();  
                endif;
            endforeach;

            $result = $booking->set_meta(Booking::STATUS, Booking::STATUS_CANCELLED);

            if ($result) {
                
                (new BookingCancellationAlerts($booking))->fire();
            
                // $event_result = (new BookingCancelledEvent($booking))->fire();

                // if ($event_result) {
                    if(Auth::has_role(User::TEACHER_ROLE)){
                        $current_user_id = get_current_user_id();
                        $user = get_user_by('ID' , $current_user_id );
                        $user->set_role('none');
                        wp_logout(); 
                    }
                    Response::success(__('Booking cancelled successfully!'));  
                // } 
            }
        } catch (\Exception $e) {
            send_error_email($e);
            Response::error(__('Server error occurred!'));
        }

    }
    public function report_booking_problem(){
        
        try{
            $data = Request::get_validated_data($_POST, [
                'reference_no' => ['required', 'post_exists:' . Booking::POST_TYPE],
            ]);
            $booking = Booking::find_by_ref($data['reference_no']);
            $message = $data['problem'];

            echo $message;
            die();
            
            if (! $booking || $booking->is_cancelled() || $booking->is_refunded()) {
                Response::error(__('Invalid booking'));
            }
            
            (new BookingProblemReportNotification($booking , $message))->send();  
            Response::success(__('Problem Reported. We will get you shortly.'));   
        }catch(\Exception $e){
            send_error_email($e);
        }
    }
}
