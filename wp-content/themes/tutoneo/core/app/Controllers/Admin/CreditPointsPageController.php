<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\Pages\CreditPointsList;
use App\Controllers\Controller;

class CreditPointsPageController extends Controller 
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'menu_content']);
    }

    public function menu_content()
    {
        add_menu_page(
            __('Credit Points'),     // page title
            __('Credit Points'),     // menu title
            'manage_options',   // capability
            CreditPointsList::PAGE,     // menu slug
            [$this, 'page_content'],
            'dashicons-admin-post',
            30
        );    
    }

    public function page_content()
    {
        $payments_list = new CreditPointsList();
        $payments_list->prepare_items(); 
        echo '<div class="wrap"><h2>Credit Points</h2>';
        echo '<form action="admin.php">';
        echo '<input type="hidden" name="page" value="' . CreditPointsList::PAGE . '">';
        // $payments_list->search_box('Search', 'search');
        echo '</form>';
        $payments_list->display();
        echo '</div>';
    }
}