<?php 

namespace App\Events;

use App\Models\CreditPointHistory;
use App\Models\User;
use App\Notifications\User\CreditPointsWithdrawalUserNotification;
use App\Notifications\User\CreditPointsWithdrawalAdminNotification;

class CreditPointsWithdrawalEvent extends Event 
{
    private $user;
    private $credit_point_history;

    public function __construct(User $user, CreditPointHistory $credit_point_history)
    {
        $this->user = $user;
        $this->credit_point_history = $credit_point_history;
    }

    public function fire()
    {
        try {
            (new CreditPointsWithdrawalUserNotification($this->user, $this->credit_point_history))->send();
            (new CreditPointsWithdrawalAdminNotification($this->user, $this->credit_point_history))->send();
        } catch (\Exception $e) {
            send_error_email($e);
        }
    }
}