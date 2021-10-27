<?php

namespace App\Services;

use App\Config\Config;

class FrontendAlertService
{
    public static function show_alerts()
    {
        $type = self::get_type();

        if ($type) {
            include_once(Config::PUBLIC_VIEWS_DIR . '/partials/partial-alerts.php');
        }
    }

    public static function get_message()
    {
        $type = self::get_type();
        $message = '';

        if (isset($_GET['payment']) && $type == 'success') {
            $message = __('Your payment was successful!');
        }

        if (isset($_GET['payment']) && $type == 'error') {
            $message = __('Sorry! We could not process your payment.');
        }

        return $message;
    }

    public static function get_type()
    {
        if (isset($_GET['alert']) && isset($_GET['status'])) {
            return $_GET['status'];
        }

        return null;
    }
}