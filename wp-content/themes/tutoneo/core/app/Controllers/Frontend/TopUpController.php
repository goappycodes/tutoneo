<?php

namespace App\Controllers\Frontend;

use App\Config\Config;
use App\Controllers\Controller;
use App\Models\Page;

class TopUpController extends Controller
{

    const PROMO_CODE_ACTION = Config::APP_PREFIX . 'check_promo_code';

    public function __construct()
    {
        
        add_shortcode(Config::APP_PREFIX . 'top_up', [$this, 'get_top_up']);
        register_page_scripts(Page::TOP_UP, $this, 'enqueue_scripts', true);
        add_action('wp_ajax_' . self::PROMO_CODE_ACTION, [$this, 'check_promo_code']);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style(
            Config::APP_PREFIX . 'top-up',
            Config::PUBLIC_CSS_DIR_URI . '/top-up.css',
            [Config::PUBLIC_HANDLE],
            Config::VERSION
        );

        wp_enqueue_script(
            Config::APP_PREFIX . 'top-up',
            Config::PUBLIC_JS_DIR_URI . '/top_up.js',
            [Config::PUBLIC_HANDLE],
            '1.0.0'
        );

        wp_localize_script(
            Config::APP_PREFIX . 'top-up', 
            'top_up_obj', 
            [
                'promo_code_action' => self::PROMO_CODE_ACTION,
            ]
        );

    }

    public function get_top_up()
    {
        $this->view(Config::PUBLIC_VIEWS_DIR . '/top-up');
    }

    public function check_promo_code(){
        $promocodes = get_field('promo_codes' , 'options');
        $user_promocode = $_REQUEST['promocode'];
        $checker = 'false';
        foreach($promocodes as $promocode){
            if(in_array($user_promocode , $promocode)){
                echo "Coupon value ".$promocode['value']." is applied.";
                $checker = 'true';
                break;
            }
        }
        if($checker == 'false'){
            echo 'Invalid promo code';
        }
        die();
    }
}