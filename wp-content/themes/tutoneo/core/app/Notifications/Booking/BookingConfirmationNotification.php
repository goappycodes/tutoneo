<?php

namespace App\Notifications\Booking;

use App\Models\Booking;
use App\Models\EmailTemplate;
use App\Notifications\Notification;
use App\Services\EmailTemplateService;

class BookingConfirmationNotification extends Notification
{
    private $booking;
    private $template;

    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
        $this->template = new EmailTemplateService(EmailTemplate::find_by_type(EmailTemplate::BOOKING_USER));
        $this->template->set_user($this->booking->user());
        $this->template->set_booking($this->booking);
    }

    public function send()
    {
        $to = $this->booking->get_user_email();
        $subject = $this->template->get_subject();
        $content = $this->template->get_body();

        $template = file_get_contents('/home/tutoneoappycodes/public_html/wp-content/themes/tutoneo/email-template/generic.html');
        $template = str_replace("{{email_subject}}", $subject, $template);
        $template = str_replace("{{email_content}}", $content, $template);
        $body     = $template;

        $this->send_email($to, $subject, $body);

        if ($this->booking->has_third_party_payment()) {
            $this->send_email($this->booking->get_payer_email(), $subject, $body);
        }
    }
}
