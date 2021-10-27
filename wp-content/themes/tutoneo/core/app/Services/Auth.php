<?php

namespace App\Services;

use App\Models\Page;
use App\Models\User;

class Auth
{
    private static $user = null;
    private static $roles = [];

    private function __construct()
    {
        if (!self::$user && get_current_user_id()) {
            self::$user = get_userdata(get_current_user_id());
            self::$roles = self::$user->roles;
        }
    }

    public static function init()
    {
        return new self();
    }

    public static function login($username, $password, $remember = false)
    {
        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => $remember,
        );

        $user = wp_signon($creds, true);

        if (!is_wp_error($user)) {
            return new self();
        }

        return $user;
    }

    public static function check()
    {
        if (self::$user)
            return true;

        return false;
    }

    public static function user()
    {
        return User::get(self::$user);
    }

    public static function redirect_if_not_logged_in()
    {
        if (!self::$user) {
            redirect_to(get_page_url(Page::SIGN_IN));
        }
    }

    public static function redirect_if_logged_in()
    {
        if (self::$user) {

            if (Auth::has_role(User::STUDENT_ROLE, User::PARENT_ROLE)) {
                $redirectTo = get_page_url(Page::STUDENT_DASHBOARD);
            } elseif (Auth::has_role(User::TEACHER_ROLE)) {
                $redirectTo = get_page_url(Page::TEACHER_DASHBOARD);
            } else {
                $redirectTo = '/wp-admin';
            }
            
            redirect_to($redirectTo);
        }
    }

    public static function has_role(...$role)
    {
        $flag = 0;

        if (!self::$user) {
            return false;
        }

        foreach ($role as $value) {
            if (in_array($value, self::$roles)) {
                $flag = 1;
                break;
            }
        }

        return $flag;
    }

    public static function show_403()
    {
        global $wp_query;
        $wp_query->set_403();
        status_header(403);
        get_template_part(403);
        exit();
    }

    public static function check_password($password)
    {
        return wp_check_password($password, self::$user->data->user_pass, self::$user->ID);
    }

    public static function update_password($password)
    {
        return wp_set_password($password, self::$user->ID);
    }
}
