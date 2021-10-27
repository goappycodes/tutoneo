<?php 

namespace App\Services;

trait BelongsToUser 
{
    public static function add_user($data)
    {
        return wp_insert_user($data);
    }

    public static function update_user_meta($user_id, $data)
    {
        foreach($data as $key => $value) {
            update_user_meta($user_id, $key, $value );
        }
    }

    public static function update_user($data)
    {
        return wp_update_user($data);
    }

    public static function get_user($user)
    {
        return is_object($user) ? $user : self::get_user_by('ID', $user);
    }

    public static function get_user_by($field, $value)
    {
        return get_user_by($field, $value);
    }

    public static function get_user_meta($user_id, $key, $single = true)
    {
        return get_user_meta($user_id, $key, $single);
    }

    public static function set_user_meta($user_id, $key, $value)
    {
        return update_user_meta($user_id, $key, $value);
    }

    public static function delete_user($user_id, $reassign = null)
    {
        return wp_delete_user($user_id, $reassign);
    }

    public static function delete_user_meta($user_id, $key)
    {
        return delete_user_meta($user_id, $key);
    }
}