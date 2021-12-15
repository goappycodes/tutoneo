<?php

namespace App\Controllers\Frontend;

use App\Config\Config;
use App\Models\User;
use App\Models\Booking;
use App\Models\StudentUser;
use App\Controllers\Controller;
use App\Services\BookingService;
use App\Models\ParentBookingForm;
use App\Models\StudentBookingForm;
use App\Events\BookingCreatedEvent;
use App\Models\Page;

class BookingController extends Controller
{
    public function __construct()
    {
        add_action('gform_post_submission_' . StudentBookingForm::ID, [$this, 'submit'], 10, 2);
        add_action('gform_post_submission_' . ParentBookingForm::ID, [$this, 'submit'], 10, 2);
        add_shortcode(Config::APP_PREFIX . 'student_booking', [$this, 'student_booking_form']);
        add_shortcode(Config::APP_PREFIX . 'parent_booking', [$this, 'parent_booking_form']);
        register_page_scripts([Page::STUDENT_BOOKING, Page::PARENT_BOOKING], $this, 'enqueue_scripts', null);
    }

    public function student_booking_form()
    {
        $this->view(Config::PUBLIC_VIEWS_DIR . '/student-booking');
    }

    public function parent_booking_form()
    {
        $this->view(Config::PUBLIC_VIEWS_DIR . '/parent-booking');
    }

    public function enqueue_scripts()
    {
        wp_enqueue_script(
            Config::APP_PREFIX . 'booking',
            Config::PUBLIC_JS_DIR_URI . '/booking.js',
            [ Config::PUBLIC_HANDLE ],
            Config::VERSION,
            true
        );

        $message = isset($_GET['from_questionnaire']) ? 
            __('All of our sessions are available online by teachers trained in distance learning. We use the best tools to guarantee optimal sessions.') 
            : '';

        wp_localize_script(
            Config::APP_PREFIX . 'booking',
            'booking_obj',
            [
                'message' => $message,
            ]
        );
    }

    public function submit($entry, $form)
    {
        $user_id = $entry['created_by'];
        $new_user = false;
        $temp_password = null;

        if (!$user_id) {

            $email_field = Booking::is_student_form($form) ? 
                StudentBookingForm::EMAIL_FIELD : ParentBookingForm::EMAIL_FIELD; 
            
            $email = rgar($entry, $email_field);
            $user = User::find_by_username($email);
            
            if (!$user) {
                $temp_password = wp_generate_password();
                $user_data = self::prepare_user_data($entry, $form, $temp_password);
                $user_meta = self::prepare_user_meta_data($entry, $form);
                $user = User::insert($user_data);
                $user->update_meta_set($user_meta);
                $new_user = true;
            }

            $user_id = $user->get_id();
        }

        $booking_data = BookingService::prepare_booking_data($entry, $form);
        $booking_meta = BookingService::prepare_booking_meta($entry, $form);
        $booking_meta += [ Booking::USER_FIELD => $user_id ];
        
        $booking = Booking::insert($booking_data);
        $booking->update_meta_set($booking_meta);
        
        $booking_created_event = new BookingCreatedEvent($booking, $new_user, $temp_password);
        $booking_created_event->fire();
    }

    private static function prepare_user_data($entry, $form, $temp_password)
    {        
        $email_field = Booking::is_student_form($form) ? StudentBookingForm::EMAIL_FIELD : ParentBookingForm::EMAIL_FIELD;
        $first_field = Booking::is_student_form($form) ? StudentBookingForm::FIRST_NAME_FIELD : ParentBookingForm::FIRST_NAME_FIELD;
        $last_field = Booking::is_student_form($form) ? StudentBookingForm::LAST_NAME_FIELD : ParentBookingForm::LAST_NAME_FIELD;
        $role = Booking::is_student_form($form) ? User::STUDENT_ROLE : User::PARENT_ROLE;

        return [
            'user_login'    => rgar($entry, $email_field),
            'user_email'    => rgar($entry, $email_field),
            'user_pass'     => $temp_password,
            'display_name'  => rgar($entry, $first_field) . ' ' . rgar($entry, $last_field),
            'nickname'      => rgar($entry, $first_field) . ' ' . rgar($entry, $last_field),
            'role'          => $role
        ];
    }

    private static function prepare_user_meta_data($entry, $form) 
    {
        $first_name      = Booking::is_student_form($form) ? StudentBookingForm::FIRST_NAME_FIELD : ParentBookingForm::FIRST_NAME_FIELD;
        $last_name       = Booking::is_student_form($form) ? StudentBookingForm::LAST_NAME_FIELD : ParentBookingForm::LAST_NAME_FIELD;
        $date_of_birth   = Booking::is_student_form($form) ? StudentBookingForm::DATE_OF_BIRTH_FIELD : ParentBookingForm::DATE_OF_BIRTH_FIELD;
        $gender          = Booking::is_student_form($form) ? StudentBookingForm::GENDER_FIELD : ParentBookingForm::GENDER_FIELD;
        $steet_address   = Booking::is_student_form($form) ? StudentBookingForm::STREET_ADDRESS_FIELD : ParentBookingForm::STREET_ADDRESS_FIELD;
        $street_address2 = Booking::is_student_form($form) ? StudentBookingForm::STREET_ADDRESS_2_FIELD : ParentBookingForm::STREET_ADDRESS_2_FIELD;
        $city            = Booking::is_student_form($form) ? StudentBookingForm::CITY_FIELD : ParentBookingForm::CITY_FIELD;
        $state_province  = Booking::is_student_form($form) ? StudentBookingForm::STATE_PROVINCE_FIELD : ParentBookingForm::STATE_PROVINCE_FIELD;
        $zip_postal      = Booking::is_student_form($form) ? StudentBookingForm::ZIP_POSTAL_FIELD : ParentBookingForm::ZIP_POSTAL_FIELD;
        $country         = Booking::is_student_form($form) ? StudentBookingForm::COUNTRY_FIELD : ParentBookingForm::COUNTRY_FIELD;
        $phone           = Booking::is_student_form($form) ? StudentBookingForm::PHONE_FIELD : ParentBookingForm::PHONE_FIELD;
        $skype           = Booking::is_student_form($form) ? StudentBookingForm::SKYPE_ID_FIELD : ParentBookingForm::SKYPE_ID_FIELD;
        $zoom            = Booking::is_student_form($form) ? StudentBookingForm::ZOOM_ID_FIELD : ParentBookingForm::ZOOM_ID_FIELD;
        
        $meta_data = [ 
            StudentUser::FIRST_NAME        => rgar($entry, $first_name),
            StudentUser::LAST_NAME         => rgar($entry, $last_name),
            StudentUser::DATE_OF_BIRTH     => rgar($entry, $date_of_birth),
            StudentUser::GENDER            => rgar($entry, $gender),
            StudentUser::STREET_ADDRESS    => rgar($entry, $steet_address),
            StudentUser::STREET_ADDRESS_2  => rgar($entry, $street_address2),
            StudentUser::CITY              => rgar($entry, $city),
            StudentUser::STATE_PROVINCE    => rgar($entry, $state_province),
            StudentUser::ZIP_POSTAL        => rgar($entry, $zip_postal),
            StudentUser::COUNTRY           => rgar($entry, $country),
            StudentUser::PHONE             => rgar($entry, $phone),
            StudentUser::SKYPE_ID          => rgar($entry, $skype),
            StudentUser::ZOOM_ID           => rgar($entry, $zoom)
        ];

        if (Booking::is_student_form($form)) {
            $meta_data += [
                StudentUser::PARENT_FIRST_NAME => rgar($entry, StudentBookingForm::PAYER_FIRST_NAME_FIELD),
                StudentUser::PARENT_LAST_NAME  => rgar($entry, StudentBookingForm::PAYER_LAST_NAME_FIELD),
                StudentUser::PARENT_EMAIL      => rgar($entry, StudentBookingForm::PAYER_EMAIL_FIELD),
            ];
        }

        return $meta_data;
    }
}
