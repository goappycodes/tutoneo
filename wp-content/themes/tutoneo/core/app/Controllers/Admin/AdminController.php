<?php

namespace App\Controllers\Admin;

use App\Config\Config;
use App\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'enqueue_scripts']);
        $this->load_classes();
    }

    public function load_classes()
    {
        SaveBookingController::init();
        RegisterShortCodesController::init();
        TeacherRegistrationConfirmationController::init();
        PaymentsPageController::init();
        CreditPointsPageController::init();
    }
    
    public function enqueue_scripts()
    {
        wp_enqueue_script(
            Config::ADMIN_HANDLE,
            Config::ADMIN_JS_DIR_URI . '/admin.js',
            [Config::APP_HANDLE],
            Config::VERSION,
            true
        );

        wp_enqueue_style(
            Config::ADMIN_HANDLE,
            Config::ADMIN_CSS_DIR_URI . '/admin.css',
            [Config::APP_HANDLE],
            Config::VERSION
        );

        wp_localize_script(
            Config::ADMIN_HANDLE,
            'admin_obj',
            []
        );
    }
}
