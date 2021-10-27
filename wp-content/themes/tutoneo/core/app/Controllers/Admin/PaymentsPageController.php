<?php

namespace App\Controllers\Admin;

use App\Controllers\Admin\Pages\PaymentsList;
use App\Controllers\Controller;

class PaymentsPageController extends Controller 
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'payments_page_menu']);
    }

    public function payments_page_menu()
    {
        add_menu_page(
            __('Payments'),     // page title
            __('Payments'),     // menu title
            'manage_options',   // capability
            PaymentsList::PAGE,     // menu slug
            [$this, 'payments_page_content'],
            'dashicons-admin-post',
            30
        );    
    }

    public function payments_page_content()
    {
        $payments_list = new PaymentsList();
        $payments_list->prepare_items(); 
        echo '<div class="wrap"><h2>Payments</h2>';
        echo '<form action="admin.php">';
        echo '<input type="hidden" name="page" value="' . PaymentsList::PAGE . '">';
        $payments_list->search_box('Search', 'search');
        echo '</form>';
        $payments_list->display();
        echo '</div>';
    }
}