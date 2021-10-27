<?php

namespace App\Events;

use App\Models\TeacherRegistrationRequest;
use App\Notifications\TeacherRegistration\TeacherRegistrationAcceptedNotification;

class TeacherRegistrationAcceptedEvent extends Event
{
    private $teacher_request;
    private $temp_password;

    public function __construct(TeacherRegistrationRequest $teacher_request, $temp_password = null)
    {
        $this->teacher_request = $teacher_request;
        $this->temp_password = $temp_password;
    }

    public function fire()
    {
        try {
            (new TeacherRegistrationAcceptedNotification($this->teacher_request, $this->temp_password))->send();
        } catch (\Exception $e) {
            send_error_email($e);
        }
    }
}