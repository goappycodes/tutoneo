<?php

namespace App\Events;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\CreditPointHistory;
use App\Notifications\Payment\PaymentSuccessUserNotification;
use App\Notifications\Payment\PaymentSuccessAdminNotification;

class PaymentSuccessEvent extends Event
{
    private $booking;
    private $payment;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function fire()
    {
        $this->create_payment();
        $this->add_credit_to_user();
        $this->create_message_thread();
        $this->send_notifications();
    }

    public function create_payment()
    {
        $this->payment = Payment::insert([
            'user_id'      => $this->booking->user()->get_id(),
            'booking_id'   => $this->booking->get_id(), 
            'txn_id'       => Payment::create_txn_id(),
            'payment_id'   => $this->booking->get_payment_intent_id(),
            'payment_date' => date('Y-m-d H:i:s'),
            'txn_type'     => Payment::TXN_DB,     
            'amount'       => $this->booking->student_amount(),  
            'status'       => Payment::STATUS_SUCCESS
        ]);
    }

    public function add_credit_to_user()
    {        
        CreditPointHistory::insert([
            'user_id'       => $this->booking->user()->get_id(),
            'booking_id'    => $this->booking->get_id(),
            'payment_id'    => $this->payment->data()->id,
            'txn_type'      => CreditPointHistory::TXN_CR,
            'event_type'    => CreditPointHistory::EVENT_STUDENT_BOOKING,
            'credit_points' => $this->booking->get_hours_booked(),
            'added_at'      => date('Y-m-d H:i:s')
        ]);
    }

    public function create_message_thread()
    {
        if (!$this->booking->teacher()) 
            return;
        
        if ($this->booking->teacher()->get_thread($this->booking->user()->get_id(), $this->booking->get_id())) {
            return;
        }
        
        $this->booking->teacher()->set_message_thread(
            $this->booking->user()->get_id(), 
            $this->booking->get_id(), [
                'message_to'      => $this->booking->user()->get_nicename(),
                'message_top'     => $this->booking->user()->get_name(),
                'token'           => wp_create_nonce('fep-form'),
                'fep_action'      => 'newmessage',
                'message_title'   => 'Booking #' . $this->booking->get_reference() . ' ' . $this->booking->get_user_full_name() . ' - ' . $this->booking->get_teacher_name(),
                'message_content' => __('Hello, you can chat here to schedule the lessons'),
                'status'          => 'pending'
            ]
        );
    }

    public function send_notifications()
    {
        try {
            (new PaymentSuccessUserNotification($this->booking))->send();
            (new PaymentSuccessAdminNotification($this->booking))->send();
        } catch (\Exception $e) {
            send_error_email($e);
        }
    }
}
