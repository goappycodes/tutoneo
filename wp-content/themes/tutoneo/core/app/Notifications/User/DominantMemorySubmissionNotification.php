<?php 

namespace App\Notifications\User;

use App\Models\User;
use App\Models\EmailTemplate;
use App\Notifications\Notification;
use App\Services\EmailTemplateService;

class DominantMemorySubmissionNotification extends Notification 
{
    private $user;
    private $template;

    public function __construct(User $user)
    {
        $this->user = $user;
        $this->template = new EmailTemplateService(EmailTemplate::find_by_type(EmailTemplate::USER_DOMINANT_RESPONSE));
        $this->template->set_user($this->user);
    }

    public function send()
    {
        $to = $this->user->get_email();
        $subject = $this->template->get_subject();
        $body = $this->template->get_body();
        $this->send_email($to, $subject, $body);
    }
}