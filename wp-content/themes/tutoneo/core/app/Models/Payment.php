<?php

namespace App\Models;

class Payment extends CustomTable
{
    const TABLE = 'wpng_payments';

    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';

    const TXN_CR = 'credit';
    const TXN_DB = 'debit';

    public static function find_by_user($user_id, $args)
    {
        return self::find_by([
            ['user_id', $user_id]
        ], $args);
    }

    public static function find_by_txn_id($txn_id)
    {
        $results = self::find_by([
            ['txn_id', $txn_id]
        ]);

        if (count($results)) {
            return $results[0];
        }

        return false;
    }

    public static function find_by_booking($booking_id, $args = [])
    {
        return self::find_by([
            ['booking_id', $booking_id]
        ], $args);
    }

    public function user()
    {
        return User::get($this->data()->user_id);
    }

    public function booking()
    { 
        if (empty($this->data()->booking_id)) {
            return false;
        }
        
        return Booking::get($this->data()->booking_id);
    }

    public function lesson()
    {
        if (empty($this->data()->lesson_id)) {
            return false;
        }
        
        return Lesson::get($this->data()->lesson_id);
    }

    public function status()
    {
        return $this->data()->status;
    }

    public function is_pending()
    {
        return ($this->status() == self::STATUS_PENDING) ? true : false;
    }

    public function is_successful()
    {
        return ($this->status() == self::STATUS_SUCCESS) ? true : false;
    }

    public function is_failed()
    {
        return ($this->status() == self::STATUS_FAILED) ? true : false;
    }

    public function amount($money_formatted = false)
    {
        $amount = $this->data()->amount;
        return $money_formatted ? money_formatted_amount($amount) : $this->data()->amount;
    }

    public function credit_points()
    {
        $credit_points_history = CreditPointHistory::find_by_payment_id($this->get_id());
        
        if ($credit_points_history) {
            return $credit_points_history->data()->credit_points;
        }

        return null;
    }

    public function txn_type()
    {
        return $this->data()->txn_type;
    }

    public function is_credit()
    {
        return ($this->txn_type() == self::TXN_CR) ? true : false;
    }

    public function is_debit()
    {
        return ($this->txn_type() == self::TXN_DB) ? true : false;
    }

    public static function create_txn_id()
    {
        do {
            $ref = uniqid('pm_');
        } while (self::find_by_txn_id($ref));

        return $ref;
    }

    public function txn_id()
    {
        return $this->data()->txn_id;
    }

    public function payment_id()
    {
        return $this->data()->payment_id;
    }

    public function payment_date($format = 'd/m/Y')
    {
        if (empty($this->data()->payment_date)) {
            return null;
        }

        return date($format, strtotime($this->data()->payment_date));
    }

    public static function total_amount($user_id, $txn_type) 
    {
        return self::sum('amount', [
            ['user_id', $user_id],
            ['txn_type', $txn_type],
            ['status', self::STATUS_SUCCESS]
        ]);
    }

    public function get_booking_reference()
    {
        if ($this->booking()) {
            return $this->booking()->get_reference();
        }

        return null;
    }

    public function total_refunded()
    {
        return self::sum('amount', [
            ['parent_id', $this->get_id()],
            ['txn_type', self::TXN_CR]
        ]);
    }

    public function can_be_refunded()
    {
        return false;
        $total_refunded = $this->total_refunded();

        if ($total_refunded < $this->amount() && $this->is_debit()) {
            return true;
        }

        return false;
    }

    public function max_deductable_credit_points()
    {
        return $this->booking()->credits_left();
    }
}