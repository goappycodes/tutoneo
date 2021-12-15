<?php

namespace App\Notifications\User;

use App\Models\User;
use App\Models\EmailTemplate;
use App\Notifications\Notification;
use App\Services\EmailTemplateService;

class UserLoginCredentialsNotification extends Notification
{
    private $user;
    private $template;

    public function __construct(User $user, $temp_password)
    {
        $this->user = $user;
        $this->template = new EmailTemplateService(EmailTemplate::find_by_type(EmailTemplate::LOGIN_CREDENTIALS));
        $this->template->set_user($this->user);
        $this->template->set_temp_password($temp_password);
    }

    public function send()
    {
        $to = $this->user->get_email();
        $subject = $this->template->get_subject();
        $content = $this->template->get_body();

        $template = file_get_contents('/home/tutoneoappycodes/public_html/wp-content/themes/tutoneo/email-template/generic.html');
        $template = str_replace("{{email_subject}}", $subject, $template);
        $template = str_replace("{{email_content}}", $content, $template);
        $body     = $template;

        $this->send_email($to, $subject, $body);
    }
}
