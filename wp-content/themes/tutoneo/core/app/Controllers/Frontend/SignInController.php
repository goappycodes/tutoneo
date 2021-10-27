<?php

namespace App\Controllers\Frontend;

use App\Config\Config;
use App\Controllers\Controller;
use App\Http\Request;
use App\Http\Response;
use App\Models\Page;
use App\Services\Auth;

class SignInController extends Controller
{
    const SIGNIN_ACTION = Config::APP_PREFIX . 'sign_in';

    public function __construct()
    {
        register_page_scripts(Page::SIGN_IN, $this, 'enqueue_scripts', false);
        add_shortcode(Config::APP_PREFIX . 'sign_in', [$this, 'get_signin_form']);
        add_action('wp_ajax_nopriv_' . self::SIGNIN_ACTION, [$this, 'sign_in']);
    }

    public function enqueue_scripts()
    {
        
    }

    public function get_signin_form()
    {
        if (!Auth::check()) {
            $this->view(Config::PUBLIC_VIEWS_DIR . '/sign-in');
        }
    }

    public function sign_in()
    {
        $data = Request::get_validated_data($_POST, [
            'username' => ['required'],
            'password' => ['required'],
        ]);
            
        $user = Auth::login($data['username'], $data['password'], $_POST['remember'] ?? false);

        if (is_wp_error($user)) {
            $field = 'username';
            $message = $user->get_error_message();
            
            if ($user->get_error_code() == 'incorrect_password') {
                $field = 'password';
                $message = "The password you entered is incorrect";
            }
            
            Response::error([
                'messages' => [
                    $field => [$message]
                ]
            ]);
        } else {
            if (isset($_SESSION['referer']) && !empty($_SESSION['referer'])) {
                $success_arr = [ 'redirect' => $_SESSION['referer'] ];
                unset($_SESSION['referer']);
            } else {
                $success_arr = [ 'reload' => true ];
            }

            Response::success($success_arr);
        }
    }
}
