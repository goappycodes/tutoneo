<?php

namespace App\Services;

use App\Models\User;
use App\Config\Config;
use App\Models\Lesson;
use App\Models\Booking;
use App\Models\EmailTemplate;
use App\Models\CreditPointHistory;
use App\Models\TeacherRegistrationRequest;

class ShortCodeService
{
    const APP_NAME                   = 'app_name';
    const USER_NAME                  = 'user_name';
    const USER_EMAIL                 = 'user_email';
    const BOOKING_TITLE              = 'booking_title';
    const BOOKING_CANCEL_REASON      = 'booking_cancellation_reason';
    const PAYMENT_LINK               = 'payment_link';
    const TEACHER_NAME               = 'teacher_name';
    const TEACHER_EMAIL              = 'teacher_email';
    const TEMP_PASSWORD              = 'temp_password';
    const LESSON_TITLE               = 'lesson_title';
    const LESSON_START_TIME          = 'lesson_start_time';
    const LESSON_END_TIME            = 'lesson_end_time';
    const LESSON_CANCELLATION_REASON = 'lesson_cancellation_reason';
    const LESSON_CANCELLED_BY        = 'lesson_cancelled_by';
    const AVL_CREDIT_POINTS          = 'available_credit_points';
    const CREDIT_POINTS              = 'credit_points';

    public static function replace_app_related_short_codes($content)
    {
        return str_replace("[" . self::APP_NAME . "]", Config::get_app_name(), $content);
    }

    public static function replace_user_related_short_codes($content, User $user)
    {
        $content = str_replace("[" . self::USER_NAME . "]", $user->get_name(), $content);
        $content = str_replace("[" . self::USER_EMAIL . "]", $user->get_email(), $content);
        $content = str_replace("[" . self::AVL_CREDIT_POINTS . "]", $user->get_credit_points(), $content);
        return $content;
    }

    public static function replace_teacher_related_short_codes($content, User $user)
    {
        $content = str_replace("[" . self::TEACHER_NAME . "]", $user->get_name(), $content);
        $content = str_replace("[" . self::TEACHER_EMAIL . "]", $user->get_email(), $content);
        return $content;
    }

    public static function replace_booking_related_short_codes($content, Booking $booking)
    {
        $content = str_replace("[" . self::BOOKING_TITLE . "]", $booking->get_title(), $content);
        $content = str_replace("[" . self::BOOKING_CANCEL_REASON . "]", $booking->get_reason(), $content);
        $content = str_replace("[" . self::PAYMENT_LINK . "]", $booking->get_payment_link(), $content);
        $content = self::replace_user_related_short_codes($content, $booking->user());
        if ($booking->teacher()) {
            $content = self::replace_teacher_related_short_codes($content, $booking->teacher());
        }
        return $content;
    }

    public static function replace_lesson_related_short_codes($content, Lesson $lesson)
    {
        $content = str_replace("[" . self::LESSON_TITLE . "]", $lesson->get_title(), $content);
        $content = str_replace("[" . self::LESSON_START_TIME . "]", $lesson->get_start_time(), $content);
        $content = str_replace("[" . self::LESSON_END_TIME . "]", $lesson->get_end_time(), $content);
        $content = str_replace("[" . self::LESSON_CANCELLATION_REASON . "]", $lesson->get_cancellation_reason(), $content);
        $content = str_replace("[" . self::LESSON_CANCELLED_BY . "]", $lesson->get_cancelled_by_name(), $content);
        $content = self::replace_user_related_short_codes($content, $lesson->student());
        $content = self::replace_teacher_related_short_codes($content, $lesson->teacher());
        return $content;
    }

    public static function replace_teacher_reg_related_short_codes($content, TeacherRegistrationRequest $teacher_reg_req)
    {
        $content = str_replace("[" . self::TEACHER_NAME . "]", $teacher_reg_req->get_full_name(), $content);
        $content = str_replace("[" . self::TEACHER_EMAIL . "]", $teacher_reg_req->get_email(), $content);
        return $content;
    }

    public static function replace_temp_password_short_code($content, $temp_password)
    {
        $content = str_replace("[" . self::TEMP_PASSWORD . "]", $temp_password, $content);
        return $content;
    }

    public static function replace_credit_point_history_short_code($content, CreditPointHistory $credit_point_history)
    {
        $content = str_replace("[" . self::CREDIT_POINTS . "]", $credit_point_history->credit_points(), $content);
        return $content;
    }

    public static function get_template_related_codes($template_id)
    {
        $type = EmailTemplate::get_post_meta($template_id, EmailTemplate::TYPE);
        
        switch ($type) {
            case EmailTemplate::REGISTRATION:
                $short_codes = [
                    self::USER_NAME,
                    self::USER_EMAIL,
                ];
                break;
            case EmailTemplate::LOGIN_CREDENTIALS:
                $short_codes = [
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEMP_PASSWORD,
                ];
                break;
            case EmailTemplate::BOOKING_ADMIN:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                ];
                break;
            case EmailTemplate::BOOKING_USER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                ];
                break;
            case EmailTemplate::BOOKING_CANCEL_ADMIN:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                ];
                break;
            case EmailTemplate::BOOKING_CANCEL_USER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                ];
                break;
            case EmailTemplate::BOOKING_CANCEL_TEACHER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                ];
                break;
            case EmailTemplate::TEACHER_REG_ACCEPTED:
                $short_codes = [
                    self::TEMP_PASSWORD,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                ];
                break;
            case EmailTemplate::TEACHER_REG_DECLINED:
                $short_codes = [
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                ];
                break;
            case EmailTemplate::MATCH_FOUND_TEACHER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                ];
                break;
            case EmailTemplate::MATCH_FOUND_USER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                ];
                break;
            case EmailTemplate::MATCH_NOT_FOUND_USER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::BOOKING_CANCEL_REASON,
                    self::USER_NAME,
                    self::USER_EMAIL,
                ];
                break;
            case EmailTemplate::PAYMENT_REQUEST:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                    self::PAYMENT_LINK,
                ];
                break;
            case EmailTemplate::PAYMENT_SUCCESS_USER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                ];
                break;
            case EmailTemplate::PAYMENT_SUCCESS_ADMIN:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                ];
                break;
            case EmailTemplate::LESSON_CREATION_USER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                    self::LESSON_TITLE,
                    self::LESSON_START_TIME,
                    self::LESSON_END_TIME,
                ];
                break;
            case EmailTemplate::LESSON_CREATION_TEACHER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                    self::LESSON_TITLE,
                    self::LESSON_START_TIME,
                    self::LESSON_END_TIME,
                ];
                break;
            case EmailTemplate::LESSON_CREATION_ADMIN:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                    self::LESSON_TITLE,
                    self::LESSON_START_TIME,
                    self::LESSON_END_TIME,
                ];
                break;
            case EmailTemplate::LESSON_UPDATION_USER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                    self::LESSON_TITLE,
                    self::LESSON_START_TIME,
                    self::LESSON_END_TIME,
                ];
                break;
            case EmailTemplate::LESSON_UPDATION_TEACHER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                    self::LESSON_TITLE,
                    self::LESSON_START_TIME,
                    self::LESSON_END_TIME,
                ];
                break;
            case EmailTemplate::LESSON_UPDATION_ADMIN:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                    self::LESSON_TITLE,
                    self::LESSON_START_TIME,
                    self::LESSON_END_TIME,
                ];
                break;
            case EmailTemplate::LESSON_CANCELLATION_USER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                    self::LESSON_TITLE,
                    self::LESSON_START_TIME,
                    self::LESSON_END_TIME,
                    self::LESSON_CANCELLATION_REASON,
                    self::LESSON_CANCELLED_BY,
                ];
                break;
            case EmailTemplate::LESSON_CANCELLATION_TEACHER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                    self::LESSON_TITLE,
                    self::LESSON_START_TIME,
                    self::LESSON_END_TIME,
                    self::LESSON_CANCELLATION_REASON,
                    self::LESSON_CANCELLED_BY,
                ];
                break;
            case EmailTemplate::LESSON_CANCELLATION_ADMIN:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                    self::LESSON_TITLE,
                    self::LESSON_START_TIME,
                    self::LESSON_END_TIME,
                    self::LESSON_CANCELLATION_REASON,
                    self::LESSON_CANCELLED_BY,
                ];
                break;
            case EmailTemplate::LESSON_COMPLETION_USER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                    self::LESSON_TITLE,
                    self::LESSON_START_TIME,
                    self::LESSON_END_TIME,
                ];
                break;
            case EmailTemplate::LESSON_COMPLETION_TEACHER:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                    self::LESSON_TITLE,
                    self::LESSON_START_TIME,
                    self::LESSON_END_TIME,
                ];
                break;
            case EmailTemplate::LESSON_COMPLETION_ADMIN:
                $short_codes = [
                    self::BOOKING_TITLE,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                    self::LESSON_TITLE,
                    self::LESSON_START_TIME,
                    self::LESSON_END_TIME,
                ];
                break;
            case EmailTemplate::TEACHER_FEEDBACK:
                $short_codes = [
                    self::APP_NAME,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                ];
                break;
            case EmailTemplate::USER_DOMINANT_RESPONSE:
                $short_codes = [
                    self::APP_NAME,
                    self::USER_NAME,
                    self::USER_EMAIL,
                    self::TEACHER_NAME,
                    self::TEACHER_EMAIL,
                ];
                break;
            case EmailTemplate::CREDIT_WITHDRAWAL_USER:
                $short_codes = [
                    self::APP_NAME,
                    self::USER_EMAIL,
                    self::USER_NAME,
                    self::AVL_CREDIT_POINTS,
                    self::CREDIT_POINTS,
                ];
                break;
            case EmailTemplate::CREDIT_WITHDRAWAL_ADMIN:
                $short_codes = [
                    self::APP_NAME,
                    self::USER_EMAIL,
                    self::USER_NAME,
                    self::AVL_CREDIT_POINTS,
                    self::CREDIT_POINTS,
                ];
                break;
            
            default:
                $short_codes = [];
                break;
        }

        return $short_codes + [self::APP_NAME];
    }
}
