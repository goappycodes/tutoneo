<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Events\TeacherRegistrationAcceptedEvent;
use App\Events\TeacherRegistrationDeclinedEvent;
use App\Models\TeacherRegistrationRequest;
use App\Models\TeacherUser;
use App\Models\User;

class TeacherRegistrationConfirmationController extends Controller
{
    public function __construct()
    {
        add_action('acf/save_post', [$this, 'handle_teacher_registration_request'], 10, 1);
        add_action('admin_notices', [$this, 'add_admin_notice']);
    }

    public function handle_teacher_registration_request($post_id)
    {
        $teacher_request = TeacherRegistrationRequest::get($post_id);

        if (!$teacher_request || $teacher_request->get_post_type() != TeacherRegistrationRequest::POST_TYPE) {
            return;
        }
        
        $teacher_request = TeacherRegistrationRequest::get($post_id);
        $status = $teacher_request->get_status();

        $status_pending = TeacherRegistrationRequest::STATUS_PENDING;
        $status_accepted = TeacherRegistrationRequest::STATUS_ACCEPTED;
        $status_declined = TeacherRegistrationRequest::STATUS_DECLINED;
        
        if ($status == $status_accepted) {

            $user_data = $this->prepare_teacher_data($teacher_request);
            $teacher = User::insert($user_data);
            
            if (!$teacher) {
                set_flash_message("User couldn't be added");
                return;
            }

            $teacher->update_meta_set($this->prepare_teacher_meta_data($teacher_request)); 
            $event = new TeacherRegistrationAcceptedEvent($teacher_request, $user_data['user_pass']);
            $event->fire();
        }  
        elseif ($status == $status_declined) {
            $event = new TeacherRegistrationDeclinedEvent($teacher_request);
            $event->fire();
        } 
    }

    public function prepare_teacher_data($teacher_request)
    {
        $password = wp_generate_password();
        return [
            'user_login'    => $teacher_request->get_email(),
            'user_email'    => $teacher_request->get_email(),
            'display_name'  => $teacher_request->get_full_name(),
            'nickname'      => $teacher_request->get_full_name(),
            'user_pass'     => $password,
            'role'          => User::TEACHER_ROLE
        ];
    }

    public function prepare_teacher_meta_data($teacher_request)
    {
        return [ 
            TeacherUser::FIRST_NAME => $teacher_request->get_first_name(),
            TeacherUser::LAST_NAME  => $teacher_request->get_last_name(),
            TeacherUser::GENDER     => $teacher_request->get_gender(),
            TeacherUser::SUBJECTS   => $teacher_request->get_subjects(),
            TeacherUser::OCCUPATION => $teacher_request->get_occupation(),
            TeacherUser::ID_CARD    => $teacher_request->get_id_card_path(),
            TeacherUser::CV         => $teacher_request->get_cv_path(),
        ];
    }

    public function add_admin_notice()
    {
        if (has_flash_message()) {
            echo '
            <div class="notice notice-' . get_flash_message_type() . '">
                <p>'. get_flash_message() .'</p>
            </div>
            ';
        }
    }
}