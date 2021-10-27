<?php

namespace App\Events;

use App\Models\Booking;
use App\Notifications\Booking\BookingConfirmationNotification;
use App\Notifications\User\UserLoginCredentialsNotification;
use App\Notifications\Booking\BookingCreatedAdminNotification;

class BookingCreatedEvent extends Event
{
    private $booking;
    private $new_user;
    private $temp_password;

    public function __construct(Booking $booking, $new_user = false, $temp_password = null)
    {
        $this->booking = $booking;
        $this->new_user = $new_user;
        $this->temp_password = $temp_password;
    }

    public function fire()
    {
        try {
            if ($this->new_user) {
                (new UserLoginCredentialsNotification($this->booking->user(), $this->temp_password))->send();
            }
            
            (new BookingConfirmationNotification($this->booking))->send();
            (new BookingCreatedAdminNotification($this->booking))->send();
        } catch (\Exception $e) {
            send_error_email($e);
        }
    }
}
