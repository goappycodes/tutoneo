<?php

namespace App\Events;

use App\Models\Lesson;
use App\Models\CreditPointHistory;
use App\Notifications\Lesson\LessonCreatedUserNotification;
use App\Notifications\Lesson\LessonCreatedAdminNotification;
use App\Notifications\Lesson\LessonCreatedTeacherNotification;

class LessonCreatedEvent extends Event
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
            (new LessonCreatedUserNotification($this->lesson))->send();
            (new LessonCreatedTeacherNotification($this->lesson))->send();
            (new LessonCreatedAdminNotification($this->lesson))->send();
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
            'txn_type'      => CreditPointHistory::TXN_DB,
            'event_type'    => CreditPointHistory::EVENT_LESSON_CREATED,
            'credit_points' => $this->lesson->duration_in_hours(),
            'added_at'      => date('Y-m-d H:i:s')
        ]);        
    }
}
