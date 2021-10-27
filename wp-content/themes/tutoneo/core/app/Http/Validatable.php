<?php

namespace App\Http;

class Validatable
{
    const REQUIRED = 'required';
    const EMAIL    = 'email';
    const DATE     = 'date';
    const TIME     = 'time';
    const DATETIME = 'datetime';
    const NUMBER   = 'number';
    const POST_META_EXISTS = 'post_meta_exists';
    const ARRAY = 'array';
    const MIN = 'min';
    const MAX = 'max';
    const CONFIRMED = 'confirmed';
    const MAX_VAL = 'max_val';
    const MIN_VAL = 'min_val';
 
    public static function check_required_validation($input_name, $input_value, $message)
    {
        if (empty(trim($input_value))) {
            return $message ?? self::format_input_name($input_name) . __(' is required');
        }
        return null;
    }

    public static function check_email_validation($input_name, $input_value, $message)
    {
        if (!filter_var($input_value, FILTER_VALIDATE_EMAIL)) {
            return $message ?? self::format_input_name($input_name) . __(' is not a valid email');
        }
        return null;
    }

    public static function check_date_validation($input_name, $input_value, $arg, $message)
    {
        $format = empty($arg) ? 'Y-m-d' : $arg;
        if (self::check_date_validation_by_format($input_value, $format)) {
            return null;
        }
        return $message ?? self::format_input_name($input_name) . __(' is not a valid date. Format: ' . $format);
    }

    public static function check_time_validation($input_name, $input_value, $arg, $message)
    {
        $format = empty($arg) ? 'H:i:s' : $arg;
        if (self::check_date_validation_by_format($input_value, $format)) {
            return null;
        }
        return $message ?? self::format_input_name($input_name) . __(' is not a valid time. Format: ' . $format);
    }

    public static function check_datetime_validation($input_name, $input_value, $arg, $message)
    {
        $format = empty($arg) ? 'Y-m-d H:i:s' : $arg;
        if (self::check_date_validation_by_format($input_value, $format)) {
            return null;
        }
        return $message ?? self::format_input_name($input_name) . __(' is not a valid time. Format: ' . $format);
    }

    public static function check_date_validation_by_format($input_value, $format)
    {
        $date = \DateTime::createFromFormat($format, $input_value);
        if ($date && $date->format($format) == $input_value) {
            return true;
        }
        return false;
    }

    public static function check_number_validation($input_name, $input_value, $message)
    {
        if (is_numeric($input_value)) {
            return null;
        }
        return $message ?? self::format_input_name($input_name) . __(' is not a valid number.');
    }

    public static function format_input_name($name)
    {
        return \ucwords(str_replace('_', ' ', $name));
    }

    public static function check_post_meta_exists_validation($input_name, $input_value, $post_type, $message)
    {
        $posts = get_posts([
            'post_type' => $post_type,
            'numberposts' => 1,
            'meta_query' => [
                [
                    'key' => $input_name,
                    'value' => $input_value
                ]
            ]
        ]);
        
        if (count($posts)) {
            return false;
        } else {
            return $message ?? self::format_input_name($input_name) . __(' does not exist.');
        }
    }

    public static function check_array_validation($input_name, $input_value, $message) 
    {
        if (!is_array($input_value)) {
            return $message ?? self::format_input_name($input_name) . __(' should be an array');
        }
        return null;        
    }

    public static function check_min_validation($input_name, $input_value, $length, $message) 
    {
        if (strlen($input_value) < $length) {
            return $message ?? self::format_input_name($input_name) . __(' should be at least ' . $length . ' characters long');
        }
        return null;        
    }

    public static function check_max_validation($input_name, $input_value, $length, $message) 
    {
        if (strlen($input_value) > $length) {
            return $message ?? self::format_input_name($input_name) . __(' should be at most ' . $length . ' characters long');
        }
        return null;        
    }

    public static function check_confirmed_validation($input_name, $input_value, $message) 
    {
        $password_confirmation = $_POST['password_confirmation'] ?? null;
        
        if ($input_value != $password_confirmation) {
            return $message ?? self::format_input_name($input_name) . __(' password confirmation didn\'t match');
        }
        return null;        
    }
    
    public static function check_max_value($input_name, $input_value, $max, $message)
    {
        if ($input_value <= $max) {
            return null;
        }
        return $message ?? self::format_input_name($input_name) . __(' can not be greater than ' . $max);
    }
    
    public static function check_min_value($input_name, $input_value, $min, $message)
    {
        if ($input_value >= $min) {
            return null;
        }
        return $message ?? self::format_input_name($input_name) . __(' can not be less than ' . $min);
    }
}
