<?php 

namespace App\Notifications\User;

use App\Config\Config;
use App\Models\CreditPointHistory;
use App\Models\EmailTemplate;
use App\Models\User;
use App\Notifications\Notification;
use App\Services\EmailTemplateService;

class CreditPointsWithdrawalUserNotification extends Notification
{
    private $user;
    private $credit_point_history;
    private $template;

    public function __construct(User $user, CreditPointHistory $credit_point_history)
    {
        $this->user = $user;
        $this->credit_point_history = $credit_point_history;
        $this->template = new EmailTemplateService(EmailTemplate::find_by_type(EmailTemplate::CREDIT_WITHDRAWAL_USER));
        $this->template->set_user($this->user);
        $this->template->set_credit_point_history($this->credit_point_history);
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

        $this->send_email($to, $subject, $body);
    }
}