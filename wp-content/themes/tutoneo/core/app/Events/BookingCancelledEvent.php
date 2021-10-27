<?php

namespace App\Events;

use App\Services\Auth;
use App\Models\Booking;
use App\Models\Payment;
use App\Config\Settings;
use App\Models\CreditPointHistory;
use App\Services\StripePaymentService;

class BookingCancelledEvent extends Event
{
    private $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function fire()
    {
        return $this->refund_balance_amount();
    }

    private function refund_balance_amount()
    {
        $amount_to_refund = $this->booking->credits_left() * Settings::student_hourly_rate();

        try {
            $stripe_service = new StripePaymentService();
            $payment = $this->booking->successful_payments()[0];
            $refund = $stripe_service->create_refund($payment->payment_id(), $amount_to_refund);

            $refund_payment = Payment::insert([
                'user_id'      => Auth::user()->get_id(),
                'parent_id'    => $payment->get_id(),
                'booking_id'   => $this->booking->get_id(),
                'txn_id'       => Payment::create_txn_id(),
                'payment_id'   => $refund->id,
                'payment_date' => date('Y-m-d H:i:s'),
                'txn_type'     => Payment::TXN_CR,     
                'amount'       => $amount_to_refund,
                'status'       => Payment::STATUS_SUCCESS
            ]);
    
            if ($refund_payment && !is_wp_error($refund_payment)) {
                
                $this->booking->set_meta(Booking::STATUS, Booking::STATUS_REFUNDED);

                $credit_point_history = CreditPointHistory::insert([
                    'user_id'       => Auth::user()->get_id(),
                    'payment_id'    => $refund_payment->get_id(),
                    'booking_id'    => $this->booking->get_id(),
                    'txn_type'      => CreditPointHistory::TXN_DB,
                    'event_type'    => CreditPointHistory::EVENT_STUDENT_WITHDRAWAL,
                    'credit_points' => $this->booking->credits_left(),
                    'added_at'      => date('Y-m-d H:i:s')
                ]);
            }

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
