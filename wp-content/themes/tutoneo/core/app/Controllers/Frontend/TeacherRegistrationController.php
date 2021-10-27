<?php 

namespace App\Controllers\Frontend;

use App\Config\Config;
use App\Controllers\Controller;
use App\Models\TeacherRegistrationForm;
use App\Models\TeacherRegistrationRequest;
use App\Models\User;
use App\Services\TeacherRegistrationService;

class TeacherRegistrationController extends Controller
{
    public function __construct()
    {
        add_action('gform_post_submission_' . TeacherRegistrationForm::ID, [$this, 'submit'], 10, 2);
        add_shortcode(Config::APP_PREFIX . 'teacher_registration', [$this, 'get_content']);
    }

    public function get_content()
    {
        $this->view(Config::PUBLIC_VIEWS_DIR . '/teacher-registration');
    }

    public function submit($entry, $form)
    {
        $post_data = TeacherRegistrationService::prepare_request_data($entry, $form);
        $post_meta = TeacherRegistrationService::prepare_request_meta_data($entry, $form);

        $user = User::find_by_username($post_meta[TeacherRegistrationRequest::EMAIL]);
        
        if (!$user) {
            $teacher_request = TeacherRegistrationRequest::insert($post_data);
            $teacher_request->update_meta_set($post_meta);
        }
    }
}