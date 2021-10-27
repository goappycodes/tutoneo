<?php

namespace App\Notifications\TeacherRegistration;

use App\Models\EmailTemplate;
use App\Notifications\Notification;
use App\Services\EmailTemplateService;
use App\Models\TeacherRegistrationRequest;

class TeacherRegistrationAcceptedNotification extends Notification
{
    private $teacher_request;
    private $template;

    public function __construct(TeacherRegistrationRequest $teacher_request, $temp_password = null)
    {
        $this->teacher_request = $teacher_request;
        $this->template = new EmailTemplateService(EmailTemplate::find_by_type(EmailTemplate::TEACHER_REG_ACCEPTED));
        $this->template->set_teacher_request($this->teacher_request);
        $this->template->set_temp_password($temp_password);
    }

    public function send()
    {
        $to = $this->teacher_request->get_email();
        $subject = $this->template->get_subject();
        $body = $this->template->get_body();
        return $this->send_email($to, $subject, $body);
    }
}