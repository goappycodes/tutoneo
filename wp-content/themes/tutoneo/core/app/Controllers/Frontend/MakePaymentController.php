<?php

namespace App\Controllers\Frontend;

use App\Models\Page;
use App\Config\Config;
use App\Models\Booking;
use App\Controllers\Controller;
use App\Models\User;
use App\Services\PageService;
use App\Services\StripePaymentService;

class MakePaymentController extends Controller
{
    public $stripe_service;
    public $stripe_session;
    public $error_type;
   


    public function __construct()
    {
        $this->stripe_service = new StripePaymentService();

        add_action('wp', [$this, 'check_for_valid_booking']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_shortcode(Config::APP_PREFIX . 'make_payment', [$this, 'show_error_messages']);
    }

    public function check_for_valid_booking()
    {
        if (!PageService::is_current_page(Page::MAKE_PAYMENT)) {
            return;
        }

        $ref = $_GET['ref'] ?? null;
        $booking = Booking::find_by_ref($ref);

        if (!$booking) {
            $this->error_type = 'invalid_booking';
            return;
        }

        if (!$booking->has_teacher()) {
            $this->error_type = 'teacher_not_assigned';
            return;
        }

        if ($booking->has_successful_payment()) {
            $this->error_type = 'payment_done';
            return;
        }

        try {
            $this->stripe_session = $this->create_stripe_session($booking);
        } catch (\Exception $e) {
            $this->error_type = 'stripe_error';
            return;
        }
    }

    public function create_stripe_session(Booking $booking)
    {
        
        $stripe_customer_id = $booking->user()->get_stripe_customer_id();


        if ($stripe_customer_id) {
            $this->stripe_service->set_customer($stripe_customer_id);
        } else {
            $this->stripe_service->set_address_line1($booking->get_meta(Booking::STREET_ADDRESS_FIELD));
            $this->stripe_service->set_address_line2($booking->get_meta(Booking::STREET_ADDRESS_2_FIELD));
            $this->stripe_service->set_city($booking->get_meta(Booking::CITY_FIELD));
            $this->stripe_service->set_country('FR');
            $this->stripe_service->set_postal_code($booking->get_meta(Booking::ZIP_POSTAL_FIELD));
            $this->stripe_service->set_state($booking->get_meta(Booking::STATE_PROVINCE_FIELD));
            $this->stripe_service->set_customer_description('User Id: ' . $booking->user()->get_id());
            $this->stripe_service->set_email($booking->user()->get_email());
            $this->stripe_service->set_name($booking->user()->get_name());
            $this->stripe_service->set_phone($booking->get_meta(Booking::PHONE_FIELD));
            $stripe_customer = $this->stripe_service->create_customer();

            $booking->user()->set_meta(User::STRIPE_CUST_ID, $stripe_customer->id);
        }

        $this->stripe_service->set_success_url($booking->get_payment_success_link());
        $this->stripe_service->set_cancel_url($booking->get_payment_cancel_link());
        $this->stripe_service->set_currencey('EUR');
        $this->stripe_service->set_line_item_name('Booking for ' . $booking->get_hours_booked() . ' hours');
        $this->stripe_service->set_amount($booking->student_amount());
        $stripe_session = $this->stripe_service->create_session();
        
        $booking->set_meta(Booking::STRIPE_SESSION_ID, $stripe_session->id);

        return $stripe_session;
    }

    public function show_error_messages()
    {
        switch ($this->error_type) {
            case 'invalid_booking':
                $this->view(Config::PUBLIC_VIEWS_DIR . '/partials/partial-invalid-booking');
                break;
            case 'payment_done':
                $this->view(Config::PUBLIC_VIEWS_DIR . '/partials/partial-payment-already-done');
                break;
            case 'stripe_error':
                $this->view(Config::PUBLIC_VIEWS_DIR . '/partials/partial-error-occurred');
                break;
            case 'teacher_not_assigned':
                $this->view(Config::PUBLIC_VIEWS_DIR . '/partials/partial-teacher-not-assigned');
                break;

            default:
                $this->view(Config::PUBLIC_VIEWS_DIR . '/make-payment');
                break;
        }
    }

    public function enqueue_scripts()
    {
        if ($this->error_type || !PageService::is_current_page(Page::MAKE_PAYMENT)) {
            return;
        }
        
        wp_enqueue_script(
            Config::APP_PREFIX . 'stripe',
            Config::PUBLIC_JS_DIR_URI . '/stripe.js',
            ['stripe-js'],
            '1.0.0',
            true
        );

        wp_localize_script(
            Config::APP_PREFIX . 'stripe',
            'stripe_obj',
            [
                'publishable_key' => $this->stripe_service->get_publishable_key(),
                'session_id' => $this->stripe_session->id,
            ]
        );
    }
}
