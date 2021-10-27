<?php

namespace App\Models;

class TeacherLedger extends Post
{
    const POST_TYPE = 'teacher-ledger';

    const REFERENCE = 'reference_no';
    const USER = 'user';
    const LESSON = 'lesson';
    const BOOKING = 'booking';
    const AMOUNT = 'amount';
    const TXN_TYPE = 'txn_type';

    const TXN_EARNING = 'Earning';
    const TXN_PAYOUT = 'Payout';

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
        $teacher_ledger = self::find_by_meta([
            [self::REFERENCE, $ref]
        ], ['numberposts' => 1]);

        if (is_array($teacher_ledger) && count($teacher_ledger)) {
            return $teacher_ledger[0];
        }

        return false;
    }

    public static function create_reference_no()
    {
        do {
            $ref = uniqid('tl_');
        } while (self::find_by_ref($ref));

        return $ref;
    }

    public function amount($money_formatted = false)
    {
        $amount = (float)$this->get_meta(self::AMOUNT);
        return $money_formatted ? money_formatted_amount($amount) : $amount;
    }

    public function txn_type()
    {
        return $this->get_meta(self::TXN_TYPE);
    }

    public function is_earning()
    {
        return ($this->txn_type() == self::TXN_EARNING);
    }

    public function is_payout()
    {
        return ($this->txn_type() == self::TXN_PAYOUT);
    }

    public function get_alert_class()
    {
        if ($this->is_earning()) {
            return 'success';
        } else {
            return 'danger';
        }
    }
}