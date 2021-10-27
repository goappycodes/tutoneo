<?php 

namespace App\Services;

trait BelongsToPost 
{
    public static function add_post($data)
    {
        return wp_insert_post($data);
    }

    public static function update_post_meta($post_id, $meta_data)
    {
        foreach ($meta_data as $key => $value) {
            self::set_post_meta($post_id, $key, $value);
        }
    }

    public static function set_post_meta($post_id, $key, $value)
    {
        return update_post_meta($post_id, $key, $value);
    }

    public static function update_post($data)
    {
        return wp_update_post($data);
    }

    public static function get_post($post)
    {
        if (!$post) {
            return false;
        }

        return is_object($post) ? $post : get_post($post);
    }

    public static function get_post_by_meta($meta_data, $args = [])
    {
        if (!array_key_exists('post_type', $args)) {
            throw new \Exception('Invalid post type');
        } 

        if (!array_key_exists('numberposts', $args)) {
            $args['numberposts'] = -1;
        }

        if (!array_key_exists('orderby', $args)) {
            $args['orderby'] = 'ID';
        }

        if (!array_key_exists('sort_order', $args)) {
            $args['orderby'] = 'DESC';
        }
        
        return get_posts(array(
            'meta_query' => self::get_post_meta_query($meta_data),
        ) + $args);
    }

    public static function get_post_meta_query($array)
    {
        return array_map(function ($arr) {
            return [
                'key' => $arr[0],
                'value' => $arr[1],
                'compare' => $arr[2] ?? '='
            ];
        }, $array);
    }

    public static function get_post_meta($post_id, $key, $single = true)
    {
        return get_post_meta($post_id, $key, $single);
    }

    public static function delete_post($post_id)
    {
        return wp_delete_post($post_id, true);
    }

    public static function delete_post_meta($post_id, $key)
    {
        return delete_post_meta($post_id, $key);
    }
}