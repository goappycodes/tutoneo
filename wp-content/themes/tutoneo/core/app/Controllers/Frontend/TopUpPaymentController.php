<?php

namespace App\Controllers\Frontend;

use App\Models\Page;
use App\Config\Config;
use App\Models\Booking;
use App\Controllers\Controller;
use App\Models\PromoCode;
use App\Models\User;
use App\Services\PageService;
use App\Services\StripePaymentService;

class TopUpPaymentController extends Controller
{
    public $stripe_service;
    public $stripe_session;
    public $error_type;
    // public $amount;

    public function __construct()
    {
        $this->stripe_service = new StripePaymentService();

        add_action('wp', [$this, 'stripe_session']);
        // add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_shortcode(Config::APP_PREFIX . 'top_up_payment', [$this, 'get_top_up']);
    }
    
    public function stripe_session(){
        try{
            $this->stripe_session = $this->create_stripe_session_user();
        }
        catch(\Exception $e) {
            return;
        }
    }

    public function create_stripe_session_user()
    {
        if (!PageService::is_current_page(Page::TOP_UP_PAYMENT)) {
            return;
        }

        $amount = $_GET['amount'] ?? null;
        if($amount < 15 || $amount == null ){
            echo 'Insufficient Amount or Invalid Amount';
            die();
        }
        //storing the amount in a session
        $_SESSION['latest_stripe_paid_amount'] = $amount;

        $current_user = wp_get_current_user();
        $user_email =  $current_user->user_email;
        $booking = Booking::find_by_email($user_email);
        $user_promocode = isset( $_GET['promocode']) ?  $_GET['promocode'] : null;
        $_SESSION['latest_promo_code_used'] = $user_promocode;

        $promocode_obj     = new PromoCode($user_promocode);
        $is_promocode_used = $promocode_obj->check_if_exist();
        if($is_promocode_used == 'true'){
            echo "Promo code Alredy used.";
            die();
        }
        $promocodes = get_field('promo_codes' , 'options');
        
        if($user_promocode != null){
            foreach($promocodes as $promocode){
                if($user_promocode == $promocode['code']){
                    $amount -=$promocode['value'];
                    break;
                }
            }
        }
        
        $stripe_customer_id = $booking->user()->get_stripe_customer_id();

        if ($stripe_customer_id) {
            $this->stripe_service->set_customer($stripe_customer_id);
        } else {
            $this->stripe_service->set_email($booking->user()->get_email());

            $stripe_customer = $this->stripe_service->create_customer();
            $booking->user()->set_meta(User::STRIPE_CUST_ID, $stripe_customer->id);

        }

        $this->stripe_service->set_success_url($booking->get_payment_success_link($amount));
        $this->stripe_service->set_cancel_url($booking->get_payment_cancel_link());
        $this->stripe_service->set_currencey('EUR');
        $this->stripe_service->set_line_item_name('Amount');
        $this->stripe_service->set_amount($amount);
        $stripe_session = $this->stripe_service->create_session();
        $booking->set_meta(Booking::STRIPE_SESSION_ID, $stripe_session->id);
        
        return $stripe_session;

    }

    public function get_top_up()
    {
        $this->view(Config::PUBLIC_VIEWS_DIR . '/top-up-payment');
    }

     public function enqueue_scripts()
    {
        if ($this->error_type || !PageService::is_current_page(Page::TOP_UP_PAYMENT)) {
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