<?php

namespace App\Controllers\Frontend;

use App\Models\Page;
use App\Config\Config;
use App\Services\Auth;
use App\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        register_page_scripts(Page::FORGOT_PASSWORD, null, null, false);
        add_shortcode(Config::APP_PREFIX . 'forgot_password', [$this, 'get_page_content']);
    }

    public function get_page_content() 
    {
        if (!Auth::check()) {
            $this->view(Config::PUBLIC_VIEWS_DIR . '/forgot-password');
        }
    }
}