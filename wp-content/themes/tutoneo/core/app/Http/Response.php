<?php

namespace App\Http;

class Response
{
    public static function success($data = null)
    {
        $return_data = [
            'status' => 'success'
        ];

        $return_data += self::prepare_return_array($data);

        echo json_encode($return_data);
        die;
    }

    public static function error($data = null)
    {
        $return_data = [
            'status' => 'error'
        ];

        $return_data += self::prepare_return_array($data);

        echo json_encode($return_data);
        die;
    }

    public static function prepare_return_array($data)
    {
        if (is_array($data)) {
            return $data;
        }

        return ['message' => $data];
    }
}
