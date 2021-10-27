<?php

namespace App\Controllers\Frontend;

use App\Config\Config;
use App\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use App\Services\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        register_page_scripts([Page::STUDENT_DASHBOARD, Page::TEACHER_DASHBOARD], $this, 'enqueue_scripts');
        add_shortcode(Config::APP_PREFIX . 'dashboard', [$this, 'get_dashboard']);
    }
    
    public function enqueue_scripts()
    {
        wp_enqueue_style(
            Config::APP_PREFIX . 'dashboard',
            Config::PUBLIC_CSS_DIR_URI . '/dashboard.css',
            [Config::PUBLIC_HANDLE],
            Config::VERSION
        );
    }

    public function get_dashboard()
    {
        if (!Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE, User::TEACHER_ROLE)) {
            Auth::show_403();
        }
        
        if (Auth::check()) {
            $this->view(Config::PUBLIC_VIEWS_DIR . '/dashboard');
        }
    }
}
