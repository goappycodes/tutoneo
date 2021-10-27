<?php

namespace App\Models;

class Payout extends Post
{
    const POST_TYPE = 'payout';

    const REFERENCE = 'reference_no';
    const USER = 'user';
    const LESSON = 'lesson';
    const BOOKING = 'booking';
    const AMOUNT = 'amount';
    const STATUS = 'status';

    const STATUS_PENDING = 'Pending';
    const STATUS_SUCCESS = 'Success';
    const STATUS_FAILED = 'Failed';

    public function user()
    {
        return User::get($this->get_meta(self::USER));
    }

    public function lesson()
    {
        return Lesson::get($this->get_meta(self::LESSON));
    }

    public function booking()
    {
        return Booking::get($this->get_meta(self::BOOKING));
    }

    public function get_reference()
    {
        return $this->get_meta(self::REFERENCE);
    }

    public static function find_by_ref($ref)
    {
        $payout = self::find_by_meta([
            [self::REFERENCE, $ref]
        ], ['numberposts' => 1]);

        if (is_array($payout) && count($payout)) {
            return $payout[0];
        }

        return false;
    }

    public static function create_reference_no()
    {
        do {
            $ref = uniqid('po_');
        } while (self::find_by_ref($ref));

        return $ref;
    }

    public function amount()
    {
        return (float)$this->get_meta(self::AMOUNT);
    }

    public function status()
    {
        return $this->get_meta(self::STATUS);
    }

    public function is_pending()
    {
        return ($this->status() == self::STATUS_PENDING);
    }

    public function is_success()
    {
        return ($this->status() == self::STATUS_SUCCESS);
    }

    public function is_failed()
    {
        return ($this->status() == self::STATUS_FAILED);
    }

    public function get_alert_class()
    {
        if ($this->is_pending()) {
            return 'warning';
        } elseif ($this->is_success()) {
            return 'success';
        } else {
            return 'danger';
        }
    }
}