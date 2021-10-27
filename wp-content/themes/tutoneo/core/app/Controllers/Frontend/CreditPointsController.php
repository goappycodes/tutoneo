<?php

namespace App\Controllers\Frontend;

use App\Config\Config;
use App\Controllers\Controller;
use App\Models\Page;

class CreditPointsController extends Controller
{
    public function __construct()
    {
        add_shortcode(Config::APP_PREFIX . 'credit_points', [$this, 'get_page_content']);
        register_page_scripts(Page::CREDIT_POINTS, $this, 'enqueue_scripts', true);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style(
            Config::APP_PREFIX . 'payments',
            Config::PUBLIC_CSS_DIR_URI . '/payments.css',
            [Config::PUBLIC_HANDLE],
            Config::VERSION
        );
    }

    public function get_page_content()
    {
        print_r($this->view(Config::PUBLIC_VIEWS_DIR . '/credit-points'));
        $this->view(Config::PUBLIC_VIEWS_DIR . '/credit-points');
    }
}