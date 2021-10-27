<?php

namespace App\Events;

use App\Models\TeacherRegistrationRequest;
use App\Notifications\TeacherRegistration\TeacherRegistrationDeclinedNotification;

class TeacherRegistrationDeclinedEvent extends Event
{
    private $teacher_request;

    public function __construct(TeacherRegistrationRequest $teacher_request)
    {
        $this->teacher_request = $teacher_request;
    }

    public function fire()
    {
        try {
            (new TeacherRegistrationDeclinedNotification($this->teacher_request))->send();
        } catch (\Exception $e) {
            send_error_email($e);
        }
    }
}