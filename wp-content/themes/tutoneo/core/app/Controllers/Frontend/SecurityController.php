<?php

namespace App\Controllers\Frontend;

use App\Models\Page;
use App\Models\User;
use App\Http\Request;
use App\Config\Config;
use App\Controllers\Controller;
use App\Http\Response;
use App\Services\Auth;

class SecurityController extends Controller
{
    const ACTION = Config::APP_PREFIX . 'security';

    public function __construct()
    {
        register_page_scripts([Page::STUDENT_SECURITY, Page::TEACHER_SECURITY], $this, 'enqueue_scripts');
        add_shortcode(Config::APP_PREFIX . 'security', [$this, 'change_password_form']);
        add_action('wp_ajax_' . self::ACTION, [$this, 'change_password']);
    }

    public function enqueue_scripts()
    {
        
    }

    public function change_password_form()
    {
        if (!Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE, User::TEACHER_ROLE)) {
            Auth::show_403();
        }
        
        if (Auth::check()) {
            $this->view(Config::PUBLIC_VIEWS_DIR . '/security');
        }
    }

    public function change_password()
    {
        $data = Request::get_validated_data($_POST, [
            'current_password' => ['required'],
            'new_password' => ['required', 'min:8', 'confirmed']
        ]);

        if (!Auth::check_password($data['current_password'])) {
            Response::error([
                'messages' => [
                    'current_password' => ['Current password didn\'t match']
                ]
            ]);
        }

        Auth::update_password($data['new_password']);

        Response::success([
            'message' => 'Password updated!',
            'reload' => true,
        ]);
    }
}
