<?php

namespace App\Models;

use App\Models\Post;
use App\Config\Settings;
use App\Services\StripePaymentService;

class Booking extends Post
{
    const POST_TYPE              = 'booking';
    const REFERENCE_NO_FIELD     = 'reference_no';
    const USER_FIELD             = 'user';
    const FIRST_NAME_FIELD       = 'first_name';
    const LAST_NAME_FIELD        = 'last_name';
    const EMAIL_FIELD            = 'email';
    const GENDER_FIELD           = 'gender';
    const DATE_OF_BIRTH_FIELD    = 'date_of_birth';
    const STREET_ADDRESS_FIELD   = 'street_address';
    const STREET_ADDRESS_2_FIELD = 'address_line_2';
    const CITY_FIELD             = 'city';
    const STATE_PROVINCE_FIELD   = 'state_province';
    const ZIP_POSTAL_FIELD       = 'zip_postal_code';
    const COUNTRY_FIELD          = 'country';
    const PHONE_FIELD            = 'phone_number';
    const SKYPE_ID_FIELD         = 'skype_id';
    const ZOOM_ID_FIELD          = 'zoom_id';
    const HOURS_BOOKED_FIELD     = 'hours_booked';
    const LESSON_OFFERED         = 'lesson_offered';
    const HAS_THIRD_PARTY_FIELD  = 'has_third_party_payment';
    const PAYER_FIRST_NAME_FIELD = 'payer_first_name';
    const PAYER_LAST_NAME_FIELD  = 'payer_last_name';
    const PAYER_EMAIL_FIELD      = 'payer_email';
    const IS_MATCH_FOUND_FIELD   = 'is_match_found';
    const REASON_FIELD           = 'match_not_found_reason';
    const TEACHER_FIELD          = 'teacher';
    const NOTIFY_USER_FIELD      = 'notify_user';
    const PAYMENT_LINK_FIELD     = 'send_payment_link';
    const QUESTIONNAIRE_RESPONSE = 'questionnaire_response';
    const QUESTIONNAIRE_RES_ID   = 'questionnaire_response_id';
    const MATCH_FOUND            = 'yes';
    const MATCH_NOT_FOUND        = 'no';
    const STRIPE_SESSION_ID      = 'stripe_session_id';
    const STATUS                 = 'status';
    const STATUS_CREATED         = 'Created';
    const STATUS_CANCELLED       = 'Cancelled';
    const STATUS_REFUNDED        = 'Refunded';
    const LEVEL                  =   'level';

    public function user()
    {
        $user = $this->get_meta(self::USER_FIELD);
        return User::get($user);
    }

    public function teacher()
    {
        $teacher = $this->get_meta(self::TEACHER_FIELD);
        return User::get($teacher);
    }

    public function lessons($args = [])
    {
        return Lesson::find_by_meta([
            [Lesson::BOOKING, $this->get_id()],
            [Lesson::IS_CANCELLED, 0]
        ], $args);
    }

    public function payments($args = [])
    {
        return Payment::find_by_booking($this->get_id(), $args);
    }

    public function successful_payments()
    {
        return Payment::find_by([
            ['booking_id', $this->get_id()],
            ['status', Payment::STATUS_SUCCESS]
        ]);
    }

    public function has_third_party_payment()
    {
        if ($this->get_meta(self::HAS_THIRD_PARTY_FIELD)) {
            return true;
        }

        return false;
    }

    public function get_reference()
    {
        return $this->get_meta(self::REFERENCE_NO_FIELD);
    }

    public function get_payment_link()
    {
        return get_page_url(Page::MAKE_PAYMENT) . '?ref=' . $this->get_reference();
    }

    public function get_payment_success_link()
    {
        return home_url('/payment/?type=payment_response_success&ref=' . $this->get_reference());
    }
    
    public function get_payment_cancel_link()
    {
        return get_page_url(Page::STUDENT_DASHBOARD) . '?payment=true&status=error&alert=1';
        // return get_page_url(Page::PAYMENT_FAILED_PAGE);
    }

    public static function find_by_ref($ref)
    {
        $booking = self::find_by_meta([
            [self::REFERENCE_NO_FIELD, $ref]
        ], ['numberposts' => 1]);

        if (is_array($booking) && count($booking)) {
            return $booking[0];
        }

        return false;
    }

    public static function find_by_email($email)
    {
        $booking = self::find_by_meta([
            [self::EMAIL_FIELD, $email]
        ], ['numberposts' => 1]);

        if (is_array($booking) && count($booking)) {
            return $booking[0];
        }

        return false;
    }

    public function has_successful_payment()
    {
        $payments = $this->successful_payments();
        
        if (count($payments)) {
            return true;
        }

        return false;
    }

    public function get_payer_full_name()
    {
        return $this->get_meta(self::PAYER_FIRST_NAME_FIELD) . ' ' . $this->get_meta(self::PAYER_FIRST_NAME_FIELD);
    }

    public function get_user_full_name()
    {
        return $this->get_meta(self::FIRST_NAME_FIELD) . ' ' . $this->get_meta(self::LAST_NAME_FIELD);
    }

    public function get_active_lessons()
    {
        return Lesson::find_by_meta([
            [Lesson::BOOKING, $this->get_id()],
            [Lesson::IS_CANCELLED, 0],
            [Lesson::COMPLETED, 0]
        ]);
    }

    public function has_lessons()
    {
        if (count($this->lessons())) {
            return true;
        }

        return false;
    }

    public function has_active_lessons()
    {
        if (count($this->get_active_lessons())) {
            return true;
        }

        return false;
    }

    public function get_user_email()
    {
        return $this->get_meta(self::EMAIL_FIELD);
    }

    public function get_payer_email()
    {
        return $this->get_meta(self::PAYER_EMAIL_FIELD);
    }

    public function reset_notify_user()
    {
        $this->set_meta(self::NOTIFY_USER_FIELD, null);
    }

    public function reset_send_payment_link()
    {
        $this->set_meta(self::PAYMENT_LINK_FIELD, null);
    }

    public function reset_teacher()
    {
        $this->set_meta(self::TEACHER_FIELD, null);
    }

    public function get_hours_booked()
    {
        return floatval($this->get_meta(self::HOURS_BOOKED_FIELD));
    }

    public function get_reason()
    {
        return $this->get_meta(self::REASON_FIELD);
    }

    public static function create_reference_no()
    {
        do {
            $ref = uniqid('bk_');
        } while (self::find_by_ref($ref));

        return $ref;
    }

    public function get_teacher_name()
    {
        return $this->teacher() ? $this->teacher()->get_name() : null;
    }

    public function get_teacher_email()
    {
        return $this->teacher() ? $this->teacher()->get_email() : null;
    }

    public function get_user_full_address()
    {
        $address_arr = [
            self::get_post_meta($this->get_id(), self::STREET_ADDRESS_FIELD),
            self::get_post_meta($this->get_id(), self::STREET_ADDRESS_2_FIELD),
            self::get_post_meta($this->get_id(), self::CITY_FIELD),
            self::get_post_meta($this->get_id(), self::STATE_PROVINCE_FIELD),
            self::get_post_meta($this->get_id(), self::ZIP_POSTAL_FIELD),
            self::get_post_meta($this->get_id(), self::COUNTRY_FIELD),
        ];
        return implode(',', $address_arr);
    }

    public function get_booking_date($format = 'd M, Y')
    {
        return $this->get_date($format);
    }

    public function get_phone_number()
    {
        return self::get_post_meta($this->get_id(), self::PHONE_FIELD);
    }

    public function get_skype_id()
    {
        return self::get_post_meta($this->get_id(), self::SKYPE_ID_FIELD);
    }

    public function get_zoom_id()
    {
        return self::get_post_meta($this->get_id(), self::ZOOM_ID_FIELD);
    }

    public function has_teacher()
    {
        if ($this->teacher()) {
            return true;
        }

        return false;
    }

    public function get_questionnaire_response_id()
    {
        return $this->get_meta(self::QUESTIONNAIRE_RES_ID);
    }

    public function get_questionnaire_responses()
    {
        $entry_id = $this->get_questionnaire_response_id();
        $form_id = StudentQuestionnaireForm::ID;
        return get_gf_entry($entry_id, $form_id);
    }

    public function has_questionnaire_response()
    {
        if (empty($this->get_questionnaire_response_id())) {
            return false;
        }

        return true;
    }

    public function student_amount()
    {
        $rate = Settings::student_hourly_rate();
        $hours_booked = $this->get_hours_booked();
        return round($rate * $hours_booked, 2);
    }

    public function datewise_sorted_lessons($order = 'ASC')
    {
        return $this->lessons(Lesson::datewise_sort_condition($order));
    }

    public function completed()
    {
        if ($this->has_lessons() && !$this->credits_left()) 
            return true;

        return false;
    }

    public function get_payment_intent_id()
    {
        $session_id = $this->get_meta(Booking::STRIPE_SESSION_ID);
        
        if (!$session_id) {
            return false;
        }

        $stripe_service = new StripePaymentService();
        $stripe_service->set_session($session_id);
        $stripe_session = $stripe_service->get_session();

        if ($stripe_session) {
            return $stripe_session->payment_intent;
        }

        return null;
    }

    public function total_earned_credit_points()
    {
        return CreditPointHistory::sum('credit_points', [
            [ 'booking_id', $this->get_id() ],
            [ 'txn_type', CreditPointHistory::TXN_CR ]
        ]);
    }

    public function total_spent_credit_points()
    {
        return CreditPointHistory::sum('credit_points', [
            [ 'booking_id', $this->get_id() ],
            [ 'txn_type', CreditPointHistory::TXN_DB ]
        ]);
    }

    public function credits_left()
    {
        return $this->total_earned_credit_points() - $this->total_spent_credit_points();
    }

    public static function is_student_form($form)
    {
        return ($form['id'] == StudentBookingForm::ID);
    }

    public function status()
    {
        return $this->get_meta(self::STATUS);
    }

    public function is_created()
    {
        return ($this->status() == self::STATUS_CREATED) || empty($this->status());
    }

    public function is_cancelled()
    {
        return ($this->status() == self::STATUS_CANCELLED);
    }

    public function is_refunded()
    {
        return ($this->status() == self::STATUS_REFUNDED);
    }

    public function get_status_label()
    {
        $class = 'primary';

        if ($this->is_created()) {
            $class = 'success';
        }  
        elseif ($this->is_cancelled()) {
            $class = 'danger';
        } 
        elseif ($this->is_refunded()) {
            $class = 'info';
        } 

        return "<span class='badge badge-{$class}'>{$this->status()}</span>";
    }

    public function get_payment_status_label()
    {
        if ($this->has_successful_payment()) {
            $class = 'success';
            $status = 'Success';
        } else {
            $class = 'warning';
            $status = 'Pending';
        }

        return "<span class='badge badge-{$class}'>{$status}</span>";
    }

    public function get_teacher_or_not_assigned_label()
    {
        if ($this->has_teacher()) {
            return $this->get_teacher_name();
        }
        
        $class = 'warning';
        $label = 'Not Assigned';
        return "<span class='badge badge-{$class}'>{$label}</span>";

    }
}
