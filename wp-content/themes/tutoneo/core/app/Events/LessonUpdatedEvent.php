<?php

namespace App\Events;

use App\Models\Lesson;
use App\Notifications\Lesson\LessonUpdatedAdminNotification;
use App\Notifications\Lesson\LessonUpdatedTeacherNotification;
use App\Notifications\Lesson\LessonUpdatedUserNotification;

class LessonUpdatedEvent extends Event
{
    private $lesson;

    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    public function fire()
    {
        try {
            (new LessonUpdatedUserNotification($this->lesson))->send();
            (new LessonUpdatedTeacherNotification($this->lesson))->send();
            (new LessonUpdatedAdminNotification($this->lesson))->send();    
        } catch (\Exception $e) {
            send_error_email($e);
        }
    }
}
