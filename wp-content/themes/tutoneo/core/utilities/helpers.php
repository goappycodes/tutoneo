<?php

use App\Models\Page;
use App\Config\Config;
use App\Services\Auth;
use App\Services\PageService;

if (!function_exists('dump')) {
    function dump(...$values)
    {
        foreach ($values as $value) {
            echo "<pre>";
            echo "<div style='background:black;color:yellowgreen;padding:10px'>";
            if (is_object($value) || is_array($value)) {
                print_r($value);
            } else {
                var_dump($value);
            }
            echo "</div>";
            echo "</pre>";
        }

    }
}

if (!function_exists('dd')) {
    function dd(...$values)
    {
        foreach ($values as $value) {
            dump($value);
        }
        die;
    }
}

if (!function_exists('redirect_to')) {
    function redirect_to($path)
    {
        wp_redirect($path);
        die;
    }
}

if (!function_exists('get_page_url')) {
    function get_page_url($type)
    {
        $page = Page::find_by_type($type);

        if ($page) {
            return home_url($page->post()->post_name);
        }

        return null;
    }
}

if (!function_exists('show_404')) {
    function show_404() 
    {
        global $wp_query;
        $wp_query->set_404();
        status_header(404);
        get_template_part(404);
        exit();
    }
}

if (!function_exists('set_flash_message')) {
    function set_flash_message($message, $type = 'error')
    {
        $_SESSION['flash_message'] = [
            'type' => $type,
            'message' => $message
        ];
    }
}

if (!function_exists('get_flash_message')) {
    function get_flash_message($with_html = false)
    {
        if (isset($_SESSION['flash_message'])) {
            $type = $_SESSION['flash_message']['type'] ?? 'error';
            $message = $_SESSION['flash_message']['message'];

            if ($with_html) {

                if ($type == 'error') {
                    $class = 'danger';
                } else {
                    $class = $type;
                }
    
                $message = '<div class="alert alert-' . $class . '">' . $message . '</div>';
            }
            
            unset($_SESSION['flash_message']);

            return $message;
        }
    }
}

if (!function_exists('has_flash_message')) {
    function has_flash_message()
    {
        return isset($_SESSION['flash_message']) ? true : false;
    }
}

if (!function_exists('get_flash_message_type')) {
    function get_flash_message_type()
    {
        return $_SESSION['flash_message']['type'] ?? null;
    }
}

if (!function_exists('get_gf_entry')) {
    function get_gf_entry($entry_id, $form_id)
    {        
        $entry = \GFAPI::get_entry($entry_id);

        if (!$entry_id || !$form_id) {
            return [];
        }
        
        $responses = [];
        
        foreach ($entry as $field_id => $field_value) {
            $field = \GFAPI::get_field($form_id, $field_id);
        
            if (!$field || empty($field_value)) {
                continue;
            }
            
            $responses[$field->label] = $field_value;
        }
        
        return $responses;
    }
}

if (!function_exists('create_gf_entry_url')) {
    function create_gf_entry_url($form_id, $entry_id) 
    {
        return home_url("/wp-admin/admin.php?page=gf_entries&view=entry&id=" . $form_id . "&lid=" . $entry_id . "&order=ASC");
    }
}

if (!function_exists('register_page_scripts')) {
    function register_page_scripts($type, $class = null, $method = null, $login = true) 
    {
        global $wp;

        add_action('template_redirect', function() use ($type, $class, $method, $login, $wp) {
            if (PageService::is_current_page($type)) {
                if (!is_null($login)) {
                    if ($login) {
                        $_SESSION['referer'] = home_url(add_query_arg($_GET, $wp->request));
                        Auth::redirect_if_not_logged_in();
                    } else {
                        Auth::redirect_if_logged_in();
                    }
                }

                if ($class && $method) {
                    add_action('wp_enqueue_scripts', [$class, $method]);
                }
            }
        });
    }
}

if (!function_exists('get_icon'))
{
    function get_icon($sub_dir, $file_name)
    {
        $dir = Config::ICONS_DIR_URI . $sub_dir;
        $path = $dir . '/' . $file_name;
        return "<img src='{$path}' alt='icon'>";
    }
}

if (!function_exists('send_error_email'))
{
    function send_error_email(\Exception $e)
    {
        $message = $e->getFile();
        $message .= '(line:'. $e->getLine() .')';
        $message .= '<br>';
        $message .= $e->getMessage();
        error_log( $message, 1, Config::get_admin_email(), Config::get_default_email_headers() );
    }
}

if (!function_exists('money_formatted_amount'))
{
    function money_formatted_amount($amount)
    {
        return '€ ' . number_format($amount, 2, '.', ',');
    }
}