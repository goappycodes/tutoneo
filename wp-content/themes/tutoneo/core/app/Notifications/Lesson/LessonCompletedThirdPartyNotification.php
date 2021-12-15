<?php

namespace App\Notifications\Lesson;

use App\Models\Lesson;
use App\Models\EmailTemplate;
use App\Notifications\Notification;
use App\Services\EmailTemplateService;

class LessonCompletedThirdPartyNotification extends Notification
{
    private $lesson;
    private $template;
    private $review;

    public function __construct(Lesson $lesson, $review)
    {
        $this->lesson = $lesson;
        $this->review = $review;
        $this->template = new EmailTemplateService(EmailTemplate::find_by_type(EmailTemplate::TEACHER_FEEDBACK_FOR_PARENT));
        $this->template->set_user($this->lesson->student());
        $this->template->set_lesson($this->lesson);
    }

    public function send()
    {

        $to = $this->lesson->booking()->get_payer_email();
        $subject = $this->template->get_subject();
        $content = $this->review;

        $template = file_get_contents('/home/tutoneoappycodes/public_html/wp-content/themes/tutoneo/email-template/generic.html');
        $template = str_replace("{{email_subject}}", $subject, $template);
        $template = str_replace("{{email_content}}", $content , $template);
        $body     = $template;

        // $body = $this->template->get_body();
        $this->send_email($to, $subject, $body);
    }
}


// $to = $this->lesson->booking()->get_payer_email();
//         $subject = $this->template->get_subject();
//         $body = $this->template->get_body();
//         $this->send_email($to, $subject, $body);