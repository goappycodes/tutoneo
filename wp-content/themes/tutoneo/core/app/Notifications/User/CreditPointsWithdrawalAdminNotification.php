<?php 

namespace App\Notifications\User;

use App\Config\Config;
use App\Models\CreditPointHistory;
use App\Models\EmailTemplate;
use App\Models\User;
use App\Notifications\Notification;
use App\Services\EmailTemplateService;

class CreditPointsWithdrawalAdminNotification extends Notification
{
    private $user;
    private $credit_point_history;
    private $template;

    public function __construct(User $user, CreditPointHistory $credit_point_history)
    {
        $this->user = $user;
        $this->credit_point_history = $credit_point_history;
        $this->template = new EmailTemplateService(EmailTemplate::find_by_type(EmailTemplate::CREDIT_WITHDRAWAL_ADMIN));
        $this->template->set_user($this->user);
        $this->template->set_credit_point_history($this->credit_point_history);
    }

    public function send()
    {
        $to = Config::get_admin_email();
        $subject = $this->template->get_subject();
        $body = $this->template->get_body();
        $this->send_email($to, $subject, $body);
    }
}