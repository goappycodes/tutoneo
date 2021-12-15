<?php

namespace App\Notifications\TeacherRegistration;

use App\Config\Config;
use App\Models\EmailTemplate;
use App\Notifications\Notification;
use App\Services\EmailTemplateService;

class TeacherAmountWithdrawl extends Notification
{
    private $template;

    public function __construct($temp_password = null)
    {
        $this->template = new EmailTemplateService(EmailTemplate::find_by_type(EmailTemplate::TEACHER_AMOUNT_WITHDRAWAL));
        $this->template->set_temp_password($temp_password);
    }

    public function send()
    {
        $to = Config::get_admin_email();
        $subject = $this->template->get_subject();
        $content = $this->template->get_body();

        $template = file_get_contents('/home/tutoneoappycodes/public_html/wp-content/themes/tutoneo/email-template/generic.html');
        $template = str_replace("{{email_subject}}", $subject, $template);
        $template = str_replace("{{email_content}}", $content, $template);
        $body     = $template;

        return $this->send_email($to, $subject, $body);
    }
}