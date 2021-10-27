<?php

namespace App\Models;

class EmailTemplate extends Post
{
    const POST_TYPE = 'email_template';
    const TYPE = 'template_type';
    const SUBJECT = 'subject';
    const BODY = 'body';

    // types
    const REGISTRATION                = 'registration';
    const LOGIN_CREDENTIALS           = 'login_credentials';
    const BOOKING_ADMIN               = 'booking_admin';
    const BOOKING_USER                = 'booking_user';
    const BOOKING_CANCEL_ADMIN        = 'booking_cancel_admin';
    const BOOKING_CANCEL_USER         = 'booking_cancel_user';
    const BOOKING_CANCEL_TEACHER      = 'booking_cancel_teacher';
    const TEACHER_REG_ACCEPTED        = 'teacher_reg_accepted';
    const TEACHER_REG_DECLINED        = 'teacher_reg_declined';
    const MATCH_FOUND_TEACHER         = 'match_found_teacher';
    const MATCH_FOUND_USER            = 'match_found_user';
    const MATCH_NOT_FOUND_USER        = 'match_not_found_user';
    const PAYMENT_REQUEST             = 'payment_request';
    const PAYMENT_SUCCESS_USER        = 'payment_success_user';
    const PAYMENT_SUCCESS_ADMIN       = 'payment_success_admin';
    const LESSON_CREATION_USER        = 'lesson_creation_user';
    const LESSON_CREATION_TEACHER     = 'lesson_creation_teacher';
    const LESSON_CREATION_ADMIN       = 'lesson_creation_admin';
    const LESSON_UPDATION_USER        = 'lesson_updation_user';
    const LESSON_UPDATION_TEACHER     = 'lesson_updation_teacher';
    const LESSON_UPDATION_ADMIN       = 'lesson_updation_admin';
    const LESSON_CANCELLATION_USER    = 'lesson_cancellation_user';
    const LESSON_CANCELLATION_TEACHER = 'lesson_cancellation_teacher';
    const LESSON_CANCELLATION_ADMIN   = 'lesson_cancellation_admin';
    const LESSON_COMPLETION_USER      = 'lesson_completion_user';
    const LESSON_COMPLETION_TEACHER   = 'lesson_completion_teacher';
    const LESSON_COMPLETION_ADMIN     = 'lesson_completion_admin';
    const TEACHER_FEEDBACK            = 'teacher_feedback';
    const USER_DOMINANT_RESPONSE      = 'user_dominant_response';
    const CREDIT_WITHDRAWAL_USER      = 'credit_withdrawal_user';
    const CREDIT_WITHDRAWAL_ADMIN     = 'credit_withdrawal_admin';

    public static function find_by_type($type)
    {
        $posts = self::find_by_meta([
            [ self::TYPE, $type]
        ]);

        if (count($posts)) {
            return $posts[0];
        }

        return null;
    }
}
