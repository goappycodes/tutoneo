<?php

namespace App\Services;

use App\Models\Page;

class PageService 
{
    public static function is_current_page($type)
    {
        $id = [];

        if (is_array($type)) {
            $pages = Page::find_among_types($type);

            foreach ($pages as $page) {
                if ($page) {
                    $id[] = $page->get_id();
                }
            }
        } else {
            $page = Page::find_by_type($type);

            if ($page) {
                $id = $page->get_id();
            }
        }

        if (is_page($id)) {
            return true;
        }

        return false;
    }
}