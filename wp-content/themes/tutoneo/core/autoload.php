<?php

if (!defined('THEME_URI')) {
    define('THEME_URI', get_template_directory_uri());
}

if (!defined('THEME_DIR')) {
    define('THEME_DIR', get_template_directory());
}

if (!defined('THEME_CORE_DIR')) {
    define('THEME_CORE_DIR', THEME_DIR . '/core/');
}

function autoload_classes($class)
{
    $base_dir = THEME_CORE_DIR;
    $class = lcfirst(str_replace("\\", DIRECTORY_SEPARATOR, $class));
    $ext = ".php";
    $filename = $base_dir . $class . $ext;
    if (is_readable($filename)) {
        include_once $filename;
        return true;
    }

    return false;
}

spl_autoload_register('autoload_classes');

include_once('utilities/helpers.php');

include_once('vendor/stripe-php-master/init.php');

try {
    \App\App::init();
} catch (\Exception $e) {
    die($e->getMessage());
}