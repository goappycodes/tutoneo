<?php

namespace App\Events;

use App\Models\Booking;
use App\Notifications\Booking\BookingCancelledAdminNotification;
use App\Notifications\Booking\BookingCancelledTeacherNotification;
use App\Notifications\Booking\BookingCancelledUserNotification;

class BookingCancellationAlerts extends Event
{
    private $booking;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function fire()
    {
        try {
            (new BookingCancelledAdminNotification($this->booking))->send();
            (new BookingCancelledUserNotification($this->booking))->send();
            (new BookingCancelledTeacherNotification($this->booking))->send();
        } catch (\Exception $e) {
            send_error_email($e);
        }
    }
}
