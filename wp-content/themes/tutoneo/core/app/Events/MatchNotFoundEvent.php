<?php

namespace App\Events;

use App\Models\Booking;
use App\Notifications\Booking\MatchNotFoundNotification;

class MatchNotFoundEvent extends Event
{
    private $booking = null;
    private $notify_user = false;

    public function __construct(Booking $booking, $notify_user)
    {
        $this->booking = $booking;
        $this->notify_user = $notify_user;
    }

    public function fire()
    {
        if ($this->notify_user) {
            $this->booking->reset_notify_user();
            
            try {
                (new MatchNotFoundNotification($this->booking))->send();
            } catch (\Exception $e) {
                send_error_email($e);
            }
        }
        
        $this->booking->reset_teacher();
    }
}
