<?php

namespace App\Events;

use App\Models\Booking;
use App\Models\Payment;
use App\Models\CreditPointHistory;
use App\Models\Lesson;
use App\Notifications\Payment\PaymentSuccessUserNotification;
use App\Notifications\Payment\PaymentSuccessAdminNotification;

class PaymentRefundEvent extends Event{

    private $booking;
    private $lesson;
    private $payment;
    private $credits;
    private $credits_payed;

    public function __construct(Booking $booking , Lesson $lesson)
    {
        $this->booking = $booking;
        $this->lesson = $lesson;
    }

    public function fire()
    {
        $this->check_if_credited();
        if(!$this->credits_payed){
            $this->credits = CreditPointHistory::get_credit_point_by_lesson_id($this->booking->get_id() , $this->lesson->get_id() );
            $this->create_payment();
            $this->add_credit_to_user();
        }  
    }

    public function create_payment(){
        $this->payment = Payment::insert([
            'user_id'      => $this->booking->user()->get_id(),
            'booking_id'   => $this->booking->get_id(), 
            'txn_id'       => Payment::create_txn_id(),
            'payment_id'   => $this->booking->get_payment_intent_id(),
            'payment_date' => date('Y-m-d H:i:s'),
            'txn_type'     => Payment::TXN_DB,     
            'amount'       => $this->credits->data->credit_points,
            'status'       => Payment::STATUS_SUCCESS
        ]);
    }

    public function add_credit_to_user(){
        CreditPointHistory::insert([
            'user_id'       => $this->booking->user()->get_id(),
            'booking_id'    => $this->booking->get_id(),
            'lesson_id'     => $this->lesson->get_id(),
            'payment_id'    => $this->payment->data()->id,
            'txn_type'      => CreditPointHistory::TXN_CR,
            'event_type'    => CreditPointHistory::EVENT_STUDENT_BOOKING,
            // 'credit_points' => $this->booking->get_hours_booked(),
            'credit_points' => $this->credits->data->credit_points,
            'added_at'      => date('Y-m-d H:i:s')
        ]);
    }

    public function check_if_credited(){
        $this->credits_payed = CreditPointHistory::check_if_credit_exist($this->booking->get_id() , $this->lesson->get_id());
    }

}