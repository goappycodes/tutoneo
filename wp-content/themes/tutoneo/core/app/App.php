<?php

namespace App;

use App\Config\Config;
use App\Controllers\Admin\AdminController;
use App\Controllers\Frontend\FrontendController;
use App\Services\Auth;

class App
{
    private function __construct()
    {
        Auth::init();

        $this->add_global_actions();
        $this->add_global_filters();
        
        if (!is_admin() || wp_doing_ajax()) {
            FrontendController::init();
        }

        if (is_admin()) {
            AdminController::init();
        }
    }

    public static function init()
    {
        return new self();
    }

    private function add_global_actions()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_global_scripts']);
    }

    private function add_global_filters()
    {
    }

    public function enqueue_global_scripts()
    {
        
        wp_enqueue_script(
            'flatpickr',
            'https://cdn.jsdelivr.net/npm/flatpickr'
        );

        wp_enqueue_style(
            'flatpickr',
            'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css'
        );

        wp_enqueue_script(
            'sweet-alert',
            "https://unpkg.com/sweetalert/dist/sweetalert.min.js"
        );

        wp_enqueue_script(
            'moment-js',
            'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js',
            ['jquery'],
            Config::VERSION,
            true
        );

        wp_enqueue_script(
            Config::APP_HANDLE,
            Config::JS_DIR_URI . '/app.js',
            ['jquery', 'moment-js'],
            '1.0.5',
            true
        );

        wp_enqueue_style(
            Config::APP_HANDLE,
            Config::CSS_DIR_URI . '/app.css',
            [],
            Config::VERSION
        );

        wp_localize_script(
            Config::APP_HANDLE,
            'app_obj',
            [
                'ajax_url' => admin_url('admin-ajax.php')
            ]
        );
    }
}
