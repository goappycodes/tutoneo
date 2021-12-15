<?php

namespace App\Controllers\Frontend;

use App\Controllers\Controller;
use App\Events\PaymentSuccessEvent;
use App\Models\Booking;
use App\Models\Page;
use App\Models\Payment;
use App\Models\PromoCode;
use App\Services\Auth;

class CapturePaymentSuccessController extends Controller
{
    public function __construct()
    {
        add_action('init', [$this, 'capture_payment_success'], 10, 0);
    }

    public function capture_payment_success()
    {
        $type = $_GET['type'] ?? null;

        if ($type == 'payment_response_success') {
            $ref = $_GET['ref'] ?? null;

            $booking = Booking::find_by_ref($ref);

            if (!$booking) {
                show_404();
            }
  
            $payment_success = $booking->has_successful_payment();

            // if (!$payment_success) {
                $payment_success_event = new PaymentSuccessEvent($booking);
                $payment_success_event->fire();
            // }

            $current_user_id = get_current_user_id();
            $payment = Payment::find_by_user($current_user_id, []);
            if(isset($_SESSION['latest_stripe_paid_amount'])){
                unset($_SESSION['latest_stripe_paid_amount']);
            }
            if(isset($_SESSION['latest_promo_code_used'])){
                $promocode_obj     = new PromoCode($_SESSION['latest_promo_code_used']);
                $promocode_obj->add_promo_code();
                unset($_SESSION['latest_promo_code_used']);
            }
            
            redirect_to(get_page_url(Page::STUDENT_DASHBOARD) . '?payment=true&status=success&alert=1');
        }
    }
}
