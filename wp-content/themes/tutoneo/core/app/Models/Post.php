<?php

namespace App\Models;

use App\Services\BelongsToPost;

abstract class Post extends Model
{
    use BelongsToPost;

    public static $instances = [];
    public $post;

    public static function get($post)
    {
        $called_class = get_called_class();
        $instance = new $called_class();
        $instance->post = self::get_post($post);

        if (!$instance->post) {
            return false;
        }
        
        self::$instances[$called_class][] = $instance;
        return $instance;
    }

    public static function insert($data = [])
    {
        $post_id = self::add_post($data);
        
        if (!is_wp_error($post_id) && $post_id) {
            return self::get($post_id);
        }

        return false;
    }

    public static function update($id, $data = [])
    {
        $data += ['ID' => $id];
        $result = self::update_post($data);

        if (!is_wp_error($result) && $result) {
            return self::get($id);
        }

        return false;
    }

    public static function find_by_meta($meta_data = [], $args = [])
    { 
        $called_class = get_called_class();
        $posts = self::get_post_by_meta($meta_data, $args + ['post_type' => $called_class::POST_TYPE]);
        
        
        $data = [];
        foreach ($posts as $post) {
            $data[] = self::get($post);
        }
        return $data;
    }

    public function set_meta($key, $value)
    {
        return self::set_post_meta($this->post()->ID, $key, $value);
    }

    public function get_meta($key, $single = true)
    {
        return self::get_post_meta($this->post()->ID, $key, $single);
    }

    public function update_meta_set($meta_data = [])
    {
        return self::update_post_meta($this->post()->ID, $meta_data);
    }

    public function delete()
    {
        return self::delete_post($this->post()->ID);
    }

    public function delete_meta($key)
    {
        return self::delete_post_meta($this->post()->ID, $key);
    }

    public function post()
    {
        return $this->post;
    }

    public function get_id()
    {
        return $this->post()->ID ?? null;
    }

    public function get_title()
    {
        return $this->post()->post_title ?? null;
    }

    public function get_date($format = 'd M, Y')
    {
        return date($format, strtotime($this->post()->post_date));
    }

    public function get_post_type()
    {
        return $this->post()->post_type ?? null;
    }
}
