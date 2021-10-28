<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\ParentBookingForm;
use App\Models\StudentBookingForm;
use App\Models\StudentQuestionnaireForm;

use App\Models\User;

class BookingService
{
    private static $reference;

    private static function get_reference()
    {
        if (!self::$reference) {
            self::$reference = Booking::create_reference_no();
        }

        return self::$reference;
    }

    public static function prepare_booking_data($entry, $form)
    {
        return [
            'post_title' => "Booking #" . self::get_reference(),
            'post_type' => Booking::POST_TYPE,
            'post_status' => 'publish'
        ];
    }

    public static function prepare_booking_meta($entry, $form)
    {
        $questionnaire_response = $_SESSION['questionnaire_response'] ?? [];
        $questionnaire_response_id = $questionnaire_response['id'] ?? null;

        $first_name_field       = Booking::is_student_form($form) ? StudentBookingForm::FIRST_NAME_FIELD : ParentBookingForm::FIRST_NAME_FIELD;
        $last_name_field        = Booking::is_student_form($form) ? StudentBookingForm::LAST_NAME_FIELD : ParentBookingForm::LAST_NAME_FIELD;
        $email_field            = Booking::is_student_form($form) ? StudentBookingForm::EMAIL_FIELD : ParentBookingForm::EMAIL_FIELD;
        $date_of_birth_field    = Booking::is_student_form($form) ? StudentBookingForm::DATE_OF_BIRTH_FIELD : ParentBookingForm::DATE_OF_BIRTH_FIELD;
        $gender_field           = Booking::is_student_form($form) ? StudentBookingForm::GENDER_FIELD : ParentBookingForm::GENDER_FIELD;
        $street_address_field   = Booking::is_student_form($form) ? StudentBookingForm::STREET_ADDRESS_FIELD : ParentBookingForm::STREET_ADDRESS_FIELD;
        $street_address_2_field = Booking::is_student_form($form) ? StudentBookingForm::STREET_ADDRESS_2_FIELD : ParentBookingForm::STREET_ADDRESS_2_FIELD;
        $city_field             = Booking::is_student_form($form) ? StudentBookingForm::CITY_FIELD : ParentBookingForm::CITY_FIELD;
        $state_province_field   = Booking::is_student_form($form) ? StudentBookingForm::STATE_PROVINCE_FIELD : ParentBookingForm::STATE_PROVINCE_FIELD;
        $zip_postal_field       = Booking::is_student_form($form) ? StudentBookingForm::ZIP_POSTAL_FIELD : ParentBookingForm::ZIP_POSTAL_FIELD;
        $country_field          = Booking::is_student_form($form) ? StudentBookingForm::COUNTRY_FIELD : ParentBookingForm::COUNTRY_FIELD;
        $phone_field            = Booking::is_student_form($form) ? StudentBookingForm::PHONE_FIELD : ParentBookingForm::PHONE_FIELD;
        $skype_id_field         = Booking::is_student_form($form) ? StudentBookingForm::SKYPE_ID_FIELD : ParentBookingForm::SKYPE_ID_FIELD;
        $zoom_id_field          = Booking::is_student_form($form) ? StudentBookingForm::ZOOM_ID_FIELD : ParentBookingForm::ZOOM_ID_FIELD;
        $hours_booked_field     = Booking::is_student_form($form) ? StudentBookingForm::HOURS_BOOKED_FIELD : ParentBookingForm::HOURS_BOOKED_FIELD;

        $booking_meta = [
            Booking::REFERENCE_NO_FIELD     => self::get_reference(),
            // User::REFERENCE_NO_FIELD     => self::get_reference(),
            Booking::FIRST_NAME_FIELD       => rgar($entry, $first_name_field),
            // User::FIRST_NAME_FIELD       => rgar($entry, $first_name_field),
            Booking::LAST_NAME_FIELD        => rgar($entry, $last_name_field),
            // User::LAST_NAME_FIELD        => rgar($entry, $last_name_field),
            Booking::EMAIL_FIELD            => rgar($entry, $email_field),
            Booking::GENDER_FIELD           => rgar($entry, $gender_field),
            Booking::DATE_OF_BIRTH_FIELD    => rgar($entry, $date_of_birth_field),
            Booking::STREET_ADDRESS_FIELD   => rgar($entry, $street_address_field),
            Booking::STREET_ADDRESS_2_FIELD => rgar($entry, $street_address_2_field),
            Booking::CITY_FIELD             => rgar($entry, $city_field),
            Booking::STATE_PROVINCE_FIELD   => rgar($entry, $state_province_field),
            Booking::ZIP_POSTAL_FIELD       => rgar($entry, $zip_postal_field),
            Booking::COUNTRY_FIELD          => rgar($entry, $country_field),
            Booking::PHONE_FIELD            => rgar($entry, $phone_field),
            Booking::SKYPE_ID_FIELD         => rgar($entry, $skype_id_field),
            Booking::ZOOM_ID_FIELD          => rgar($entry, $zoom_id_field),
            Booking::HOURS_BOOKED_FIELD     => rgar($entry, $hours_booked_field),
            Booking::QUESTIONNAIRE_RESPONSE => create_gf_entry_url(StudentQuestionnaireForm::ID, $questionnaire_response_id),
            Booking::QUESTIONNAIRE_RES_ID   => $questionnaire_response_id,
        ];

        if (Booking::is_student_form($form)) {
            $booking_meta += [
                Booking::HAS_THIRD_PARTY_FIELD  => rgar($entry, StudentBookingForm::HAS_THIRD_PARTY_FIELD) == 'Yes' ? 1 : 0,
                Booking::PAYER_FIRST_NAME_FIELD => rgar($entry, StudentBookingForm::PAYER_FIRST_NAME_FIELD),
                Booking::PAYER_LAST_NAME_FIELD  => rgar($entry, StudentBookingForm::PAYER_LAST_NAME_FIELD),
                Booking::PAYER_EMAIL_FIELD      => rgar($entry, StudentBookingForm::PAYER_EMAIL_FIELD),
            ];
        }

        return $booking_meta;
    }
}
