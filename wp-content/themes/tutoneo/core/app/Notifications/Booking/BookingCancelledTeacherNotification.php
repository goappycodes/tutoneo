<?php

namespace App\Notifications\Booking;

use App\Models\Booking;
use App\Models\EmailTemplate;
use App\Notifications\Notification;
use App\Services\EmailTemplateService;

class BookingCancelledTeacherNotification extends Notification
{
    private $booking;
    private $template;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $this->template = new EmailTemplateService(EmailTemplate::find_by_type(EmailTemplate::BOOKING_CANCEL_TEACHER));
        $this->template->set_user($this->booking->user());
        $this->template->set_booking($this->booking);
    }

    public function send()
    {
        $to = $this->booking->get_teacher_email();
        $subject = $this->template->get_subject();
        $body = $this->template->get_body();
        $this->send_email($to, $subject, $body);
    }
}
