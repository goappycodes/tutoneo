<?php

namespace App\Controllers\Frontend;

use App\Models\Page;
use App\Models\User;
use App\Config\Config;
use App\Controllers\Controller;
use App\Services\Auth;

class MessagesController extends Controller
{
    public function __construct()
    {
        register_page_scripts([Page::STUDENT_MESSAGES, Page::TEACHER_MESSAGES]);
        add_shortcode(Config::APP_PREFIX . 'messages', [$this, 'get_messages']);
    }

    public function get_messages()
    {
        if (!Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE, User::TEACHER_ROLE)) {
            Auth::show_403();
        }
        
        if (Auth::check()) {
            $this->view(Config::PUBLIC_VIEWS_DIR . '/messages');
        }
    }
}
