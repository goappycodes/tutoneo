<?php

namespace App\Notifications\Booking;

use App\Config\Config;
use App\Models\Booking;
use App\Models\EmailTemplate;
use App\Notifications\Notification;
use App\Services\EmailTemplateService;

class BookingCreatedAdminNotification extends Notification
{
    private $booking;
    private $template;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $this->template = new EmailTemplateService(EmailTemplate::find_by_type(EmailTemplate::BOOKING_ADMIN));
        $this->template->set_user($this->booking->user());
        $this->template->set_booking($this->booking);
    }

    public function send()
    {
        $to = Config::get_admin_email();
        $subject = $this->template->get_subject();
        $body = $this->template->get_body();
        $this->send_email($to, $subject, $body);
    }
}
