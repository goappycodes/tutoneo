<?php

namespace App\Http;

class Request
{
    public static function get_validated_data($inputs, $rules = [], $messages = [])
    {
        $errors = [];
        foreach ($inputs as $input_name => $input_value) {
            if (array_key_exists($input_name, $rules)) {
                foreach ($rules[$input_name] as $rule) {
                    $message = $messages[$input_name . '.' . $rule] ?? null;
                    $error = self::get_error($input_name, $rule, $input_value, $message);
                    if ($error) {
                        $errors['messages'][$input_name][] = $error;
                    }
                }
            }
        }

        if (count($errors)) {
            Response::error($errors);
        }

        return $inputs;
    }

    public static function get_error($input_name, $rule, $input_value, $message)
    {
        if (strpos($rule, ':') !== false) {
            $splitted_rule = explode(':', $rule, 2);
            $rule = $splitted_rule[0];
            $arg = $splitted_rule[1];
        } else {
            $arg = null;
        }

        switch ($rule) {
            case Validatable::REQUIRED:
                return Validatable::check_required_validation($input_name, $input_value, $message);
            case Validatable::EMAIL:
                return Validatable::check_email_validation($input_name, $input_value, $message);
            case Validatable::DATE:
                return Validatable::check_date_validation($input_name, $input_value, $arg, $message);
            case Validatable::TIME:
                return Validatable::check_time_validation($input_name, $input_value, $arg, $message);
            case Validatable::DATETIME:
                return Validatable::check_datetime_validation($input_name, $input_value, $arg, $message);
            case Validatable::NUMBER:
                return Validatable::check_number_validation($input_name, $input_value, $message);
            case Validatable::POST_META_EXISTS:
                return Validatable::check_post_meta_exists_validation($input_name, $input_value, $arg, $message);
            case Validatable::ARRAY:
                return Validatable::check_array_validation($input_name, $input_value, $message);
            case Validatable::MIN:
                return Validatable::check_min_validation($input_name, $input_value, $arg, $message);
            case Validatable::MAX:
                return Validatable::check_max_validation($input_name, $input_value, $arg, $message);
            case Validatable::CONFIRMED:
                return Validatable::check_confirmed_validation($input_name, $input_value, $message);
            case Validatable::MAX_VAL:
                return Validatable::check_max_value($input_name, $input_value, $arg, $message);
            case Validatable::MIN_VAL:
                return Validatable::check_min_value($input_name, $input_value, $arg, $message);
            default:
                return null;
        }
    }
}
