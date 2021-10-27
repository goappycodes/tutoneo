<?php

namespace App\Models;

class CreditPointHistory extends CustomTable
{
    const TABLE = 'wpng_credit_points_history';

    const TXN_CR = 'credit';
    const TXN_DB = 'debit';
    
    const EVENT_STUDENT_BOOKING = 'student_booking';
    const EVENT_STUDENT_WITHDRAWAL = 'student_withdrawal';
    const EVENT_LESSON_CREATED = 'lesson_created';
    const EVENT_LESSON_CANCELLED = 'lesson_cancelled';

    public static function find_by_user($user_id, $args)
    {
        return self::find_by([
            ['user_id', $user_id]
        ], $args);
    }

    public static function find_by_payment_id($payment_id)
    {
        $results = self::find_by([
            ['payment_id', $payment_id]
        ]);

        if (count($results)) {
            return $results[0];
        }

        return false;
    }

    public function user()
    {
        return User::get($this->data()->user_id);
    }

    public function booking()
    {
        return Booking::get($this->data()->booking_id);
    }

    public function lesson()
    {
        return Lesson::get($this->data()->lesson_id);
    }

    public function payment()
    { 
        if (empty($this->data()->payment_id)) {
            return false;
        }
        
        return Payment::get($this->data()->payment_id);
    }

    public function credit_points()
    {
        return $this->data()->credit_points;
    }

    public function added_at($format = 'd/m/Y')
    {
        if (empty($this->data()->added_at)) {
            return null;
        }

        return date($format, strtotime($this->data()->added_at));
    }

    public function is_credit()
    {
        if ($this->data()->txn_type == self::TXN_CR) {
            return true;
        }

        return false;
    }

    public function is_debit()
    {
        if ($this->data()->txn_type == self::TXN_DB) {
            return true;
        }

        return false;
    }

    public function get_event_text()
    {
        switch ($this->data()->event_type) {
            case self::EVENT_STUDENT_BOOKING:
                return __('Booking Created');
                break;
            case self::EVENT_STUDENT_WITHDRAWAL:
                return __('Points Withdrawal');
                break;
            case self::EVENT_LESSON_CREATED:
                return __('Lesson Created');
                break;
            case self::EVENT_LESSON_CANCELLED:
                return __('Lesson Cancelled');
                break;
            
            default:
                return '';
                break;
        }
    }
}