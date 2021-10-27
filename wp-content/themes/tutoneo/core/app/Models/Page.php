<?php

namespace App\Models;

class Page extends Post 
{
    const POST_TYPE = 'page';
    const PAGE_TYPE_META = 'page_type';

    const SIGN_IN                 = 'sign_in';
    const FORGOT_PASSWORD         = 'forgot_password';
    const MAKE_PAYMENT            = 'make_payment';
    const PAYMENT_SUCCESS_PAGE    = 'payment_success';
    const PAYMENT_FAILED_PAGE     = 'payment_failed';
    const STUDENT_QUESTIONNAIRE   = 'student_questionnaire';
    const STUDENT_BOOKING         = 'student_booking';
    const STUDENT_DASHBOARD       = 'dashboard';
    const STUDENT_PROFILE         = 'profile'; 
    const STUDENT_DOMINANT_MEMORY = 'dominant_memory';
    const STUDENT_MESSAGES        = 'messages';
    const STUDENT_PAYMENTS        = 'payments';
    const STUDENT_BOOKINGS        = 'bookings';
    const BOOKING_DETAILS         = 'booking_details';
    const STUDENT_SECURITY        = 'security';
    const STUDENT_LESSONS         = 'student_lesson_calendar';
    const CREDIT_POINTS           = 'credit_points';  
    const PARENT_QUESTIONNAIRE    = 'parent_questionnaire';
    const PARENT_BOOKING          = 'parent_booking';
    const TEACHER_REGISTRATION    = 'teacher_registration';
    const TEACHER_DASHBOARD       = 'teacher_dashboard';
    const TEACHER_PROFILE         = 'teacher_profile';
    const TEACHER_MESSAGES        = 'teacher_messages';
    const TEACHER_WALLET          = 'teacher_wallet';
    const TEACHER_BOOKINGS        = 'teacher_bookings';
    const TEACHER_LESSONS         = 'teacher_lesson_calendar';
    const TEACHER_SECURITY        = 'teacher_security';
    const TEACHER_BANK_DETAILS    = 'teacher_bank_details';
    
    /*added by BB*/
    const TOP_UP                    =   'top_up';
    const TOP_UP_PAYMENT            =   'top_up_payment';

    public static function find_by_type($type)
    {
        $posts = self::find_by_meta([
            [ self::PAGE_TYPE_META, $type ]
        ], [ 'numberposts' => 1 ]);

        if (count($posts)) {
            return $posts[0];
        }

        return null;
    }

    public static function find_among_types($types)
    {
        return self::find_by_meta([
            [ self::PAGE_TYPE_META, $types, 'IN' ]
        ]);
    }
}