<?php

namespace App\Controllers\Frontend;

use App\Config\Config;
use App\Controllers\Controller;
use App\Models\Page;

class TopUpController extends Controller
{
    public function __construct()
    {
        
        add_shortcode(Config::APP_PREFIX . 'top_up', [$this, 'get_top_up']);
        register_page_scripts(Page::TOP_UP, $this, 'enqueue_scripts', true);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style(
            Config::APP_PREFIX . 'top-up',
            Config::PUBLIC_CSS_DIR_URI . '/top-up.css',
            [Config::PUBLIC_HANDLE],
            Config::VERSION
        );
    }

    public function get_top_up()
    {
        $this->view(Config::PUBLIC_VIEWS_DIR . '/top-up');
    }
}