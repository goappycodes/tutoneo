<?php 

namespace App\Services;

use App\Models\Booking;
use App\Models\CreditPointHistory;
use App\Models\EmailTemplate;
use App\Models\Lesson;
use App\Models\TeacherRegistrationRequest;
use App\Models\User;

class EmailTemplateService 
{
    private $template;
    private $user;
    private $booking;
    private $lesson;
    private $teacher_request;
    private $temp_password;
    private $credit_point_history;

    public function __construct(EmailTemplate $template)
    {
        $this->template = $template;
    }

    public function set_user(User $user)
    {
        $this->user = $user;
    }

    public function set_booking(Booking $booking)
    {
        $this->booking = $booking;
    }

    public function set_lesson(Lesson $lesson)
    {
        $this->lesson = $lesson;
    }

    public function set_teacher_request(TeacherRegistrationRequest $teacher_request)
    {
        $this->teacher_request = $teacher_request;
    }

    public function set_temp_password($temp_password)
    {
        $this->temp_password = $temp_password;
    }

    public function set_credit_point_history(CreditPointHistory $credit_point_history)
    {
        $this->credit_point_history = $credit_point_history;
    }

    public function get_subject()
    {            
        return $this->replace_short_codes($this->template->get_meta(EmailTemplate::SUBJECT));
    }

    public function get_body()
    {
        return $this->replace_short_codes($this->template->get_meta(EmailTemplate::BODY));
    }

    public function replace_short_codes($content)
    {
        $content = ShortCodeService::replace_app_related_short_codes($content);
        if ($this->user) {
            $content = ShortCodeService::replace_user_related_short_codes($content, $this->user);
        }
        if ($this->booking) {
            $content = ShortCodeService::replace_booking_related_short_codes($content, $this->booking);
        }
        if ($this->lesson) {
            $content = ShortCodeService::replace_lesson_related_short_codes($content, $this->lesson);
        }
        if ($this->teacher_request) {
            $content = ShortCodeService::replace_teacher_reg_related_short_codes($content, $this->teacher_request);
        }
        if ($this->temp_password) {
            $content = ShortCodeService::replace_temp_password_short_code($content, $this->temp_password);
        }
        if ($this->credit_point_history) {
            $content = ShortCodeService::replace_credit_point_history_short_code($content, $this->credit_point_history);
        }
        return $content;
    }
}