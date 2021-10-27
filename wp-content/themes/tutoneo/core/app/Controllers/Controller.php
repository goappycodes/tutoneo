<?php

namespace App\Controllers;

abstract class Controller 
{
    public static function init()
    {
        $called_class = get_called_class();
        return new $called_class();
    }

    public function view($path)
    {   
        include_once($path . '.php');
    }
}