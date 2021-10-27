<?php

namespace App\Events;

use App\Models\Booking;
use App\Notifications\Booking\MatchFoundNotification;
use App\Notifications\Booking\MatchFoundTeacherNotification;
use App\Notifications\Payment\PaymentLinkNotification;

class MatchFoundEvent extends Event
{
    private $booking = null;
    private $notify_user = false;
    private $send_payment_link = false;

    public function __construct(Booking $booking, $notify_user, $send_payment_link)
    {
        $this->booking = $booking;
        $this->notify_user = $notify_user;
        $this->send_payment_link = $send_payment_link;
    }

    public function fire()
    {
        try {
            if ($this->notify_user) {
                $this->booking->reset_notify_user();
                (new MatchFoundNotification($this->booking))->send();
                (new MatchFoundTeacherNotification($this->booking))->send();
            }
    
            if ($this->send_payment_link) {
                $this->booking->reset_send_payment_link();
                (new PaymentLinkNotification($this->booking))->send();
            }
        } catch (\Exception $e) {
            send_error_email($e);
        }
    }
}
