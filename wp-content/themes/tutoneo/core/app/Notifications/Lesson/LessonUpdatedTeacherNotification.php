<?php

namespace App\Notifications\Lesson;

use App\Models\Lesson;
use App\Models\EmailTemplate;
use App\Notifications\Notification;
use App\Services\EmailTemplateService;

class LessonUpdatedTeacherNotification extends Notification
{
    private $lesson;
    private $template;

    public function __construct(Lesson $lesson)
    {
        $this->lesson = $lesson;
        $this->template = new EmailTemplateService(EmailTemplate::find_by_type(EmailTemplate::LESSON_UPDATION_TEACHER));
        $this->template->set_user($this->lesson->student());
        $this->template->set_lesson($this->lesson);
    }

    public function send()
    {
        $to = $this->lesson->get_teacher_email();
        $subject = $this->template->get_subject();
        $content = $this->template->get_body();

        $template = file_get_contents('/home/tutoneoappycodes/public_html/wp-content/themes/tutoneo/email-template/generic.html');
        $template = str_replace("{{email_subject}}", $subject, $template);
        $template = str_replace("{{email_content}}", $content, $template);
        $body     = $template;

        $this->send_email($to, $subject, $body);
    }
}
