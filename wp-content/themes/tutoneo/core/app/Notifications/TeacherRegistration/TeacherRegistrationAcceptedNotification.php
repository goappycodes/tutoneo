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
        $content = $this->template->get_body();

        $template = file_get_contents('/home/tutoneoappycodes/public_html/wp-content/themes/tutoneo/email-template/generic.html');
        $template = str_replace("{{email_subject}}", $subject, $template);
        $template = str_replace("{{email_content}}", $content, $template);
        $body     = $template;

        return $this->send_email($to, $subject, $body);
    }
}