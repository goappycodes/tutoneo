<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Services\ShortCodeService;

class RegisterShortCodesController extends Controller
{
    public function __construct()
    {
        add_action('acf/render_field/name=short_codes', [$this, 'display_short_codes']);
    }

    public function get_short_codes()
    {
        global $post;
        return ShortCodeService::get_template_related_codes($post->ID);
    }

    public function display_short_codes()
    {

        echo "<ul>";
        foreach ($this->get_short_codes() as $short_code) {
            echo "<li>[" . $short_code . "]</li>";
        }
        echo "</ul>";
    }
}
