<?php

namespace App\Events;

use App\Models\Lesson;
use App\Models\CreditPointHistory;
use App\Notifications\Lesson\LessonCancelledUserNotification;
use App\Notifications\Lesson\LessonCancelledAdminNotification;
use App\Notifications\Lesson\LessonCancelledTeacherNotification;

class LessonCancelledEvent extends Event
{
    private $lesson;

    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    public function fire()
    {
        $this->update_credit_points();
        try {
            (new LessonCancelledUserNotification($this->lesson))->send();
            (new LessonCancelledTeacherNotification($this->lesson))->send();
            (new LessonCancelledAdminNotification($this->lesson))->send();
        } catch (\Exception $e) {
            send_error_email($e);
        }
    }

    public function update_credit_points()
    {
        CreditPointHistory::insert([
            'user_id'       => $this->lesson->student()->get_id(),
            'booking_id'    => $this->lesson->booking()->get_id(),
            'lesson_id'     => $this->lesson->get_id(),
            'txn_type'      => CreditPointHistory::TXN_CR,
            'event_type'    => CreditPointHistory::EVENT_LESSON_CANCELLED,
            'credit_points' => $this->lesson->duration_in_hours(),
            'added_at'      => date('Y-m-d H:i:s')
        ]);
    }
}
