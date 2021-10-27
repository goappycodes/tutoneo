<?php

namespace App\Notifications;

use App\Config\Config;

abstract class Notification
{
    abstract protected function send();

    public function send_email($to, $subject = null, $body = null, $headers = [])
    {
        if (!$subject) {
            $subject = __('Mail form ' . get_option('blogname'));
        }

        $default_headers = [];
        $default_headers[] = Config::get_default_email_headers();
        $headers = array_merge($default_headers, $headers);

        return wp_mail($to, $subject, $body, $headers);
    }
}
