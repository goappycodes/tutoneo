<?php

namespace App\Controllers\Admin\Pages;

class AdminPageList extends \WP_List_Table
{
    const PER_PAGE = 20;

    public function get_args()
    {
        $args = [];
        $orderby = $_GET['orderby'] ?? null;
        $order = $_GET['order'] ?? null;

        if (!empty($orderby) && !empty($order)) {
            $args['orderby'] = $orderby;
            $args['order'] = $order;
        }

        $per_page = self::PER_PAGE;
        $current_page = $this->get_pagenum();
        $limit_start = $per_page * ($current_page - 1);
        $limit_end = $per_page * $current_page;

        $args['limit'] = " LIMIT $limit_start, $limit_end";

        return $args;
    }
}