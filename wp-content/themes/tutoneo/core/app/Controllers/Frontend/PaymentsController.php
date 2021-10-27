<?php

namespace App\Controllers\Frontend;

use App\Models\Page;
use App\Models\User;
use App\Http\Request;
use App\Config\Config;
use App\Services\Auth;
use App\Models\Payment;
use App\Config\Settings;
use App\Controllers\Controller;
use App\Events\CreditPointsWithdrawalEvent;
use App\Http\Response;
use App\Models\CreditPointHistory;
use App\Services\StripePaymentService;

class PaymentsController extends Controller
{
    const WITHDRAW_ACTION = Config::APP_PREFIX . 'withdraw_credit_points';

    public function __construct()
    {
        register_page_scripts(Page::STUDENT_PAYMENTS, $this, 'enqueue_scripts');
        add_shortcode(Config::APP_PREFIX . 'payments', [$this, 'get_payments']);
        add_action('wp_ajax_' . self::WITHDRAW_ACTION, [$this, 'withdraw_credit_points']);
    }
    
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            Config::APP_PREFIX . 'payments',
            Config::PUBLIC_JS_DIR_URI. '/payments.js',
            [Config::PUBLIC_HANDLE],
            Config::VERSION, 
            true
        );

        wp_localize_script(
            Config::APP_PREFIX . 'payments',
            'payments_obj',
            [
                'student_rate' => Settings::student_hourly_rate(),
            ]
        );

        wp_enqueue_style(
            Config::APP_PREFIX . 'payments',
            Config::PUBLIC_CSS_DIR_URI . '/payments.css',
            [Config::PUBLIC_HANDLE],
            Config::VERSION
        );
    }

    public function get_payments()
    {
        if (!Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) {
            Auth::show_403();
        }
        
        if (Auth::check()) {
            $this->view(Config::PUBLIC_VIEWS_DIR . '/payments');
        }
    }

    public function withdraw_credit_points()
    {
        $txn_id = $_POST['txn_id'] ?? null;

        $payment = Payment::find_by_txn_id($txn_id);

        if (!$payment) {
            Response::error([
                'message' => __('Invalid payment selected')
            ]);
        }

        $data = Request::get_validated_data($_POST, [
            'credit_points' => ['required', 'max_value:' . $payment->max_deductable_credit_points(), 'min:1']
        ]);

        $amount = floatval($data['credit_points']) * Settings::student_hourly_rate();
        
        if ( ($amount + $payment->total_refunded()) > $payment->amount() ) {
            Response::error([
                'message' => __('Amount can not be greater than payment amount')
            ]);
        }

        try {
            $stripe_service = new StripePaymentService();
            $refund = $stripe_service->create_refund($payment->payment_id(), $amount);
        } catch (\Exception $e) {
            Response::error([
                'message' => __('Sorry! There was some error with payment gateway')
            ]);
        }

        $refund_payment = Payment::insert([
            'user_id'      => Auth::user()->get_id(),
            'parent_id'    => $payment->get_id(),
            'booking_id'   => $payment->booking() ? $payment->booking()->get_id() : null,
            'txn_id'       => Payment::create_txn_id(),
            'payment_id'   => $refund->id,
            'payment_date' => date('Y-m-d H:i:s'),
            'txn_type'     => Payment::TXN_CR,     
            'amount'       => $amount,
            'status'       => Payment::STATUS_SUCCESS
        ]);

        if (!$refund_payment || is_wp_error($refund_payment)) {
            Response::error([
                'message' => 'Sorry some error occurred'
            ]);
        }

        $credit_point_history = CreditPointHistory::insert([
            'user_id'       => Auth::user()->get_id(),
            'payment_id'    => $refund_payment->get_id(),
            'booking_id'    => $payment->booking() ? $payment->booking()->get_id() : null,
            'txn_type'      => CreditPointHistory::TXN_DB,
            'event_type'    => CreditPointHistory::EVENT_STUDENT_WITHDRAWAL,
            'credit_points' => $data['credit_points'],
            'added_at'      => date('Y-m-d H:i:s')
        ]);

        (new CreditPointsWithdrawalEvent(Auth::user(), $credit_point_history))->fire();

        Response::success([
            'message' => 'Withdrawal was successful!',
            'reload' => true,
        ]);
    }
}
