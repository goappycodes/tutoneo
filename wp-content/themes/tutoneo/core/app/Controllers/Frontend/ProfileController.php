<?php

namespace App\Controllers\Frontend;

use App\Models\Page;
use App\Models\User;
use App\Http\Request;
use App\Config\Config;
use App\Controllers\Controller;
use App\Http\Response;
use App\Services\Auth;
use App\Models\StudentUser;
use App\Models\TeacherUser;

class ProfileController extends Controller
{
    const SAVE_STUDENT_PROFILE = Config::APP_PREFIX . 'save_student_profile';
    const SAVE_TEACHER_PROFILE = Config::APP_PREFIX . 'save_teacher_profile';

    public function __construct()
    {
        register_page_scripts([Page::STUDENT_PROFILE, Page::TEACHER_PROFILE], $this, 'enqueue_scripts');
        add_shortcode(Config::APP_PREFIX . 'profile_form', [$this, 'get_profile_form']);
        add_action('wp_ajax_' . self::SAVE_STUDENT_PROFILE, [$this, 'save_student_profile']);
        add_action('wp_ajax_' . self::SAVE_TEACHER_PROFILE, [$this, 'save_teacher_profile']);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style(
            Config::APP_PREFIX . 'profile',
            Config::PUBLIC_CSS_DIR_URI . '/profile.css'
        );

        wp_enqueue_script(
            Config::APP_PREFIX . 'profile',
            Config::PUBLIC_JS_DIR_URI . '/profile.js',
            [Config::PUBLIC_HANDLE],
            '1.0.1',
            true
        );

        wp_enqueue_script(
            Config::APP_PREFIX . 'select2',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js',
            [Config::PUBLIC_HANDLE],
            true
        );

        wp_enqueue_style(
            Config::APP_PREFIX . 'select2',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css'
        );
    }

    public function get_profile_form()
    {
        if (!Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE, User::TEACHER_ROLE)) {
            Auth::show_403();
        }

        if (Auth::check()) {
            $this->view(Config::PUBLIC_VIEWS_DIR . '/profile');
        }
    }

    public function save_student_profile()
    {
        $data = Request::get_validated_data($_POST, [
            'first_name'    => ['required'],
            'last_name'     => ['required'],
            'gender'        => ['required'],
            'date_of_birth' => ['required', 'date:d-m-Y'],
            'city'          => ['required'],
            'phone_no'      => [],
            'skype_id'      => [],
            'zoom_id'       => [],
            'parent_first_name' => [],
            'parent_last_name'  => [],
            'parent_email'  => [],
        ]);
        
        $user = Auth::user();
        $user->update($this->prepare_user_update_data($data));
        $user->update_meta_set($this->prepare_user_meta($data));
        $image_res = $user->set_profile_pic($_FILES);
        
        if ($image_res['error']) {
            Response::error([
                'messages' => [
                    'profile_pic' => $image_res['error']
                ]
            ]);
        }

        Response::success([
            'message' => __('Profile updated successfully!')
        ]);
    }

    public function prepare_user_update_data($data)
    {
        return [
            'user_nicename' => $data['first_name'] . ' ' . $data['last_name'],
        ];
    }

    public function prepare_user_meta($data)
    {
        return [
            StudentUser::FIRST_NAME        => $data['first_name'],
            StudentUser::LAST_NAME         => $data['last_name'],
            StudentUser::GENDER            => $data['gender'],
            StudentUser::DATE_OF_BIRTH     => date('Y-m-d', strtotime($data['date_of_birth'])),
            StudentUser::CITY              => $data['city'],
            StudentUser::PHONE             => $data['phone_no'],
            StudentUser::SKYPE_ID          => $data['skype_id'],
            StudentUser::ZOOM_ID           => $data['zoom_id'],
            StudentUser::PARENT_FIRST_NAME => $data['parent_first_name'],
            StudentUser::PARENT_LAST_NAME  => $data['parent_last_name'],
            StudentUser::PARENT_EMAIL      => $data['parent_email'],
        ];
    }

    public function save_teacher_profile()
    {
        $data = Request::get_validated_data($_POST, [
            'first_name'    => ['required'],
            'last_name'     => ['required'],
            'gender'        => ['required'],
            'occupation'    => ['required'],
            'subjects'      => ['required'],
        ]);

        $user = Auth::user();
        $user->update($this->prepare_user_update_data($data));
        $user->update_meta_set($this->prepare_teacher_meta($data));
        $image_res = $user->set_profile_pic($_FILES);
        
        if ($image_res['error']) {
            Response::error([
                'messages' => [
                    'profile_pic' => $image_res['error']
                ]
            ]);
        }

        Response::success([
            'message' => 'Profile updated successfully!'
        ]);
    }

    public function prepare_teacher_meta($data)
    {
        return [
            TeacherUser::FIRST_NAME => $data['first_name'],
            TeacherUser::LAST_NAME  => $data['last_name'],
            TeacherUser::GENDER     => $data['gender'],
            TeacherUser::SUBJECTS   => $data['subjects'],
            TeacherUser::OCCUPATION => $data['occupation']
        ];
    }
}
