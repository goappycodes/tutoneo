<?php

namespace App\Models;

use App\Config\Settings;

class Lesson extends Post
{
    const POST_TYPE    = 'lesson';
    const REFERENCE    = 'reference_no';
    const BOOKING      = 'booking';
    const START_TIME   = 'start_datetime';
    const END_TIME     = 'end_datetime';
    const COMPLETED    = 'has_completed';
    const IS_CANCELLED = 'is_cancelled';
    const REASON       = 'cancellation_reason';
    const CANCELLED_BY = 'cancelled_by';

    public function booking()
    {
        return Booking::get($this->get_meta(self::BOOKING));
    }

    public function teacher()
    {
        return $this->booking()->teacher();
    }

    public function student()
    {
        return $this->booking()->user();
    }

    public static function datewise_sort_condition($order = 'ASC')
    {
        return [
            'meta_key' => Lesson::START_TIME,
            'orderby' => 'meta_value_num',
            'meta_type' => 'DATETIME',
            'order' => $order
        ];
    }

    public function set_start_time($value)
    {
        return $this->set_meta(self::START_TIME, $value);
    }

    public function set_end_time($value)
    {
        return $this->set_meta(self::END_TIME, $value);
    }

    public function get_start_time($format = 'Y-m-d H:i:s')
    {
        $start_time = $this->get_meta(self::START_TIME);
        if ($start_time) {
            return date($format, strtotime($start_time));
        }

        return false;
    }

    public function get_end_time($format = 'Y-m-d H:i:s')
    {
        $end_time = $this->get_meta(self::END_TIME);
        if ($end_time) {
            return date($format, strtotime($end_time));
        }

        return false;
    }

    public function get_cancellation_reason()
    {
        return $this->get_meta(self::REASON);
    }

    public function get_cancelled_by_name()
    {
        $user = User::get($this->get_cancelled_by());
        return $user ? $user->get_name() : null;
    }

    public function completed()
    {
        return $this->get_meta(self::COMPLETED) == '1' ? true : false; 
    }

    public function get_teacher_name()
    {
        return $this->teacher()->get_name();
    }

    public function get_teacher_email()
    {
        return $this->teacher()->get_email();
    }

    public function get_user_name()
    {
        return $this->booking()->user()->get_name();
    }

    public function get_user_email()
    {
        return $this->booking()->user()->get_email();
    }

    public static function find_by_ref($ref)
    {
        $lesson = self::find_by_meta([
            [self::REFERENCE, $ref]
        ], ['numberposts' => 1]);
            
        if (is_array($lesson) && count($lesson)) {
            return $lesson[0];
        }

        return false;
    }

    public static function create_reference_no()
    {
        do {
            $ref = uniqid('ls_');
        } while (self::find_by_ref($ref));

        return $ref;
    }

    public function get_reference()
    {
        return $this->get_meta(self::REFERENCE);
    }

    public function mark_cancelled()
    {
        $this->set_meta(self::IS_CANCELLED, 1);
    }

    public function set_cancelled_by($id)
    {
        $this->set_meta(self::CANCELLED_BY, $id);
    }

    public function is_cancelled()
    {
        return $this->get_meta(self::IS_CANCELLED);
    }

    public function get_cancelled_by()
    {
        return $this->get_meta(self::CANCELLED_BY);
    }

    public function set_reason($reason)
    {
        $this->set_meta(self::REASON, $reason);
    }

    public function mark_complete()
    {
        $this->set_meta(self::COMPLETED, 1);
    }

    public function get_student_id()
    {
        return $this->student()->get_id();
    }

    public function get_teacher_id()
    {
        return $this->teacher()->get_id();
    }

    public function get_booking_reference()
    {
        return $this->booking()->get_reference();
    }

    public function is_upcoming()
    {
        $start_date = $this->get_start_time();
        $now = date('Y-m-d H:i:s');

        if (strtotime($start_date) > strtotime($now)) {
            return true;
        }

        return false;        
    }

    public function duration_in_hours()
    {
        $start_time  = strtotime($this->get_start_time());
        $end_time = strtotime($this->get_end_time());
        $diff_in_sec = $end_time - $start_time;
        return round($diff_in_sec/3600, 2);
    }

    public function teacher_amount()
    {
        $rate = Settings::teacher_hourly_rate();
        $hours_booked = $this->duration_in_hours();
        return round($rate * $hours_booked, 2);
    }

    public function can_be_modified()
    {
        if (!$this->completed() && !$this->is_cancelled()) {
            return true;
        }

        return false;
    }
}
