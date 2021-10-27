<?php

namespace App\Config;

class Config
{
    const APP_PREFIX = 'tutoneo_';
    const VERSION    = '1.0.0';

    const PAYMENT_MODE = 'test'; // test|live

    // test keys
    const STRIPE_TEST_PUBLISH_KEY = 'pk_test_51I66HsKP96lDXBGYJSafCD9Amc4uqdynpldWG9iV94zYutZm4L8D0qtyAXB4bWeUG2lYaeyTj93p70v409Lt4xYS00cVnsTIPz';
    const STRIPE_TEST_SECRET_KEY = 'sk_test_51I66HsKP96lDXBGYJnCOz8GDepjsv1AaxLM7sjzUVgtQ1fCoHapTWL9F1sQMWH1AZlxfIiRz9PSX9pCUUcVDOrLG009QfDvfMc';
    
    // live keys
    const STRIPE_LIVE_PUBLISH_KEY = '';
    const STRIPE_LIVE_SECRET_KEY = '';

    const RESOURCES_DIR_URI = THEME_URI . '/core/resources';
    const RESOURCES_DIR     = THEME_DIR . '/core/resources';
    const ASSETS_DIR_URI    = self::RESOURCES_DIR_URI . '/assets';
    
    const APP_HANDLE    = self::APP_PREFIX . 'app';
    const JS_DIR_URI    = self::ASSETS_DIR_URI . '/js';
    const CSS_DIR_URI   = self::ASSETS_DIR_URI . '/css';
    const IMG_DIR_URI   = self::ASSETS_DIR_URI . '/img';
    const ICONS_DIR_URI = self::IMG_DIR_URI . '/icons';
    const VIEWS_DIR     = self::RESOURCES_DIR . '/views';

    const PUBLIC_HANDLE      = self::APP_PREFIX . 'public';
    const PUBLIC_JS_DIR_URI  = self::JS_DIR_URI . '/public';
    const PUBLIC_CSS_DIR_URI = self::CSS_DIR_URI . '/public';
    const PUBLIC_VIEWS_DIR   = self::VIEWS_DIR . '/public';

    const ADMIN_HANDLE      = self::APP_PREFIX . 'admin';
    const ADMIN_JS_DIR_URI  = self::JS_DIR_URI . '/admin';
    const ADMIN_CSS_DIR_URI = self::CSS_DIR_URI . '/admin';
    const ADMIN_VIEWS_DIR   = self::VIEWS_DIR . '/admin';

    public static function get_app_name()
    {
        return get_option('blogname');
    }

    public static function get_admin_email()
    {
        return get_option('admin_email');
    }

    public static function get_default_email_headers()
    {
        return 'Content-Type: text/html; charset=UTF-8';
    }
}