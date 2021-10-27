<?php

namespace App\Models;

use App\Config\Config;
use App\Config\Settings;
use App\Seeders\Seeder;
use App\Services\Auth;
use App\Services\BelongsToUser;

class User extends Model
{
    use BelongsToUser;

    const STRIPE_CUST_ID = 'stripe_customer_id';

    const STUDENT_ROLE = 'student';
    const PARENT_ROLE  = 'parent';
    const TEACHER_ROLE = 'teacher';
    
    public static $instances = [];
    public $user;

    public static function get($user)
    {
        $called_class = get_called_class();
        $instance = new $called_class();
        $instance->user = self::get_user($user);

        if (!$instance->user) {
            return false;
        }

        self::$instances[$called_class][] = $instance;
        return $instance;
    }

    public static function insert($data = [])
    {
        $user_id = self::add_user($data);

        if (!is_wp_error($user_id) && $user_id) {
            return self::get($user_id);
        }

        return false;
    }

    public static function update($id, $data = [])
    {
        $data += ['ID' => $id];
        $result = self::update_user($data);

        if (!is_wp_error($result) && $result) {
            return self::get($id);
        }

        return false;
    }

    public function set_meta($key, $value)
    {
        return self::set_user_meta($this->user()->ID, $key, $value);
    }

    public function get_meta($key, $single = true)
    {
        return self::get_user_meta($this->user()->ID, $key, $single);
    }

    public function update_meta_set($meta_data = [])
    {
        return self::update_user_meta($this->user()->ID, $meta_data);
    }

    public function delete()
    {
        return self::delete_user($this->user()->ID);
    }

    public function delete_meta($key)
    {
        return self::delete_user_meta($this->user()->ID, $key);
    }

    public static function first_or_create($user_login, $user_data = [])
    {
        $user = self::find_by_username($user_login);

        if ($user) {
            return $user;
        }

        return self::insert($user_data);
    }

    public static function find_by_username($username)
    {
        $user = self::get_user_by('login', $username);
        if ($user) {
            return self::get($user);
        }

        return false;
    }

    public function user()
    {
        return $this->user;
    }

    public function get_id()
    {
        return $this->user()->ID ?? null;
    }

    public function get_name()
    {
        return $this->user()->display_name ?? null;
    }

    public function get_email()
    {
        return $this->user()->user_email ?? null;
    }

    public function get_nicename()
    {
        return $this->user()->user_nicename ?? null;
    }

    public function get_username()
    {
        return $this->user()->user_login ?? null;
    }

    public function is_student()
    {
        if (in_array(User::STUDENT_ROLE, $this->roles())) {
            return true;
        } 

        return false;
    }

    public function is_parent()
    {
        if (in_array(User::PARENT_ROLE, $this->roles())) {
            return true;
        } 

        return false;
    }

    public function is_teacher()
    {
        if (in_array(User::TEACHER_ROLE, $this->roles())) {
            return true;
        } 

        return false;
    }

    public function bookings($args = [])
    {
        $search_field = $this->is_teacher() ? Booking::TEACHER_FIELD : Booking::USER_FIELD;
        
        return Booking::find_by_meta([
            [ $search_field,  $this->get_id() ]
        ], $args);
    }

    public function get_booking_ids()
    {
        $bookings = $this->bookings();
        $booking_ids = [];

        foreach ($bookings as $booking) {
            $booking_ids[] = $booking->get_id();
        }

        return $booking_ids;
    }

    public function get_comma_separated_booking_ids()
    {
        return implode(',', $this->get_booking_ids());
    }

    public function get_lesson_meta_condition()
    {
        return [
            [Lesson::BOOKING, $this->get_comma_separated_booking_ids(), 'IN'],
            [Lesson::IS_CANCELLED, 0]
        ];
    }

    public function lessons($args = [])
    {        
        return Lesson::find_by_meta($this->get_lesson_meta_condition(), $args);
    }

    public function payments($args = [])
    {        
        return Payment::find_by_user($this->get_id(), $args);
    }

    public function set_dominant_memory_response($entry_id)
    {
        return $this->set_meta(StudentUser::DOMINANT_RESPONSE, $entry_id);
    }

    public function has_dominant_response()
    {
        if (empty($this->get_dominant_response_id())) {
            return false;
        }

        return true;
    }

    public function get_dominant_response_id()
    {
        return $this->get_meta(StudentUser::DOMINANT_RESPONSE);
    }

    public function get_dominant_memory_responses()
    {
        $entry_id = $this->get_dominant_response_id();
        $form_id = DominantMemoryForm::ID;
        return get_gf_entry($entry_id, $form_id);
    }

    public function teacher_ledgers()
    {
        return TeacherLedger::find_by_meta([
            [ TeacherLedger::USER, $this->get_id() ]
        ]);
    }

    public function teacher_ledger_earnings()
    {
        return TeacherLedger::find_by_meta([
            [ TeacherLedger::USER, $this->get_id() ],
            [ TeacherLedger::TXN_TYPE, TeacherLedger::TXN_EARNING ]
        ]);
    }

    public function teacher_ledger_payouts()
    {
        return TeacherLedger::find_by_meta([
            [ TeacherLedger::USER, $this->get_id() ],
            [ TeacherLedger::TXN_TYPE, TeacherLedger::TXN_PAYOUT ]
        ]);
    }

    public function get_teacher_earning_amount()
    {
        $amount = 0;
        foreach ($this->teacher_ledger_earnings() as $ledger) {
            $amount += $ledger->amount();
        }

        return $amount;
    }

    public function get_teacher_payout_amount()
    {
        $amount = 0;
        foreach ($this->teacher_ledger_payouts() as $ledger) {
            $amount += $ledger->amount();
        }

        return $amount;
    }

    public function get_wallet_amount($money_formatted = false)
    {
        $amount = $this->get_teacher_earning_amount() - $this->get_teacher_payout_amount();
        return $money_formatted ? money_formatted_amount($amount) : $amount;
    }

    public function set_profile_pic($files)
    {
        $inp_name = 'profile_pic';
        $errors = [];

        if (isset($files[$inp_name])) {
            $file = $files[$inp_name];

            if (strpos($file['type'], 'image') === false) {
                $errors[] = 'File is not an image';
            }

            if ($file['size'] > 500000) { // 500 kb
                $errors[] = 'Size can not be greater than 500KB';
            }

            if (count($errors)) {
                return ['error' => $errors];
            }

            $result = wp_upload_bits(
                (time() . '-' . $file['name']),
                null, 
                file_get_contents($file['tmp_name'])
            ); 
            
            if ($result['error']) {
                $errors[] = $result['error'];
                return ['error' => $errors];
            }   

            $this->remove_profile_pic_file();
            $this->set_meta(StudentUser::PROFILE_PIC_URL, $result['url']);
            $this->set_meta(StudentUser::PROFILE_PIC_FILE, $result['file']);

            return ['error' => false];
        }
    }

    public function has_profile_pic()
    {
        $profile_pic = $this->get_meta(StudentUser::PROFILE_PIC_URL);
        if (!$profile_pic || empty($profile_pic)) {
            return false;
        }

        return true;
    }

    public function is_male()
    {
        return $this->get_meta(StudentUser::GENDER) == 'male';
    }

    public function is_female()
    {
        return $this->get_meta(StudentUser::GENDER) == 'female';
    }

    public function is_other()
    {
        return $this->get_meta(StudentUser::GENDER) == 'other';
    }

    public function get_profile_pic()
    {
        $image = '';

        if (!$this->has_profile_pic()) {
            
            if ($this->is_teacher()) {

                if ($this->is_male()) {
                    $image = Settings::get_teacher_male_image();
                }

                if ($this->is_female()) {
                    $image = Settings::get_teacher_female_image();
                }
            }

            if ($this->is_student()) {

                if ($this->is_male()) {
                    $image = Settings::get_student_male_image();
                }

                if ($this->is_female()) {
                    $image = Settings::get_student_female_image();
                }

            }

            if (empty($image) || ! $image) {
                $image = Config::IMG_DIR_URI . '/avatar/avatar.png';
            }
            
            return $image;
        }

        return $this->get_meta(StudentUser::PROFILE_PIC_URL);
    }

    public function remove_profile_pic_file()
    {
        $profile_pic_file = $this->get_meta(StudentUser::PROFILE_PIC_FILE);
        
        if ($profile_pic_file) {
            $path_arr = explode('wp-content', $profile_pic_file, 2);
            $file = WP_CONTENT_DIR . $path_arr[1];
            
            if (is_file($file)) {
                $this->set_meta(StudentUser::PROFILE_PIC_FILE, null);
                unlink($file);
            }
        }
    }

    public function active_lessons($args = [])
    {
        $meta_conditions_arr = $this->get_lesson_meta_condition();
        $meta_conditions_arr[] = [Lesson::COMPLETED, 0];        
        return Lesson::find_by_meta($meta_conditions_arr, $args);
    }

    public function datewise_sorted_active_lessons($order = 'ASC')
    {
        return $this->active_lessons(Lesson::datewise_sort_condition($order));
    }

    public function get_nearest_lesson_date($format = 'Y-m-d H:i:s')
    {
        $lessons = $this->datewise_sorted_active_lessons();
        if (count($lessons)) {
            return $lessons[0]->get_start_time($format);
        }

        return date($format);
    }

    public function get_message_threads()
    {
        return $this->get_meta(TeacherUser::MESSAGE_THREADS);
    }

    public function get_thread($user_id, $booking_id)
    {
        $threads = $this->get_message_threads();

        return $threads[$user_id][$booking_id] ?? false;
    }

    public function set_message_thread($user_id, $booking_id, $data = [])
    {
        $threads = $this->get_message_threads();
        
        if (!is_array($threads)) {
            $threads = [];
        }
        
        $threads[$user_id][$booking_id] = $data;
        $this->set_meta(TeacherUser::MESSAGE_THREADS, $threads);
    }

    public function roles()
    {
        return $this->user()->roles;
    }

    public function exists()
    {
        if ($this->get_id()) {
            return true;
        }

        return false;
    }

    public function get_stripe_customer_id()
    {
        return $this->get_meta(self::STRIPE_CUST_ID, true);
    }

    public function credit_points_history()
    {
        return CreditPointHistory::find_by([
            ['user_id', $this->get_id()]
        ]);
    }

    public function get_earned_points()
    {
        return CreditPointHistory::sum('credit_points', [
            ['user_id', $this->get_id()],
            ['txn_type', CreditPointHistory::TXN_CR]
        ]);
    }

    public function get_spent_points()
    {
        return CreditPointHistory::sum('credit_points', [
            ['user_id', $this->get_id()],
            ['txn_type', CreditPointHistory::TXN_DB]
        ]);
    }

    public function get_credit_points()
    {
        return $this->get_earned_points() - $this->get_spent_points();
    }

    public function get_chat_link($user_id, $booking_id)
    {
        $thread = $this->get_thread($user_id, $booking_id);
        $fep_id = $thread['fep_id'] ?? null;

        if ($thread && $fep_id) {
            $base_url = Auth::has_role(User::TEACHER_ROLE) ? get_page_url(Page::TEACHER_MESSAGES) : get_page_url(Page::STUDENT_MESSAGES);
            return "{$base_url}?fepaction=viewmessage&fep_id={$fep_id}&feppage=1&fep-filter=show-all";
        }

        return '#';
    }

    public function can_chat_with_teacher(Booking $booking)
    {
        if (!$this->is_teacher() && $booking->teacher() && $booking->teacher()->get_thread($booking->user()->get_id(), $booking->get_id())) {
            return true;
        }

        return false;
    }

    public function can_manage_lessons(Booking $booking)
    {
        if ($booking->has_successful_payment() && $booking->teacher()->get_id() == $this->get_id() 
            && $this->is_teacher() && !$booking->completed() && $booking->is_created()) {
            return true;
        }

        return false;
    }

    public function can_pay_for_booking(Booking $booking)
    {
        if (!$this->is_teacher() && $booking->has_teacher() && !$booking->has_successful_payment()) {
            return true;
        }

        return false;
    }

    public function can_cancel_booking(Booking $booking)
    {
        if (!$this->is_teacher() && $booking->credits_left() && $booking->is_created()) {
            return true;
        }

        return false;
    }
}