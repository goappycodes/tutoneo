<?php

namespace App\Controllers\Frontend;

use App\Models\Page;
use App\Models\User;
use App\Http\Request;
use App\Config\Config;
use App\Http\Response;
use App\Services\Auth;
use App\Controllers\Controller;

class TeacherBankDetailsController extends Controller
{
    const SAVE_DETAILS_ACTION = Config::APP_PREFIX . 'save_teacher_bank_details';

    public function __construct()
    {
        register_page_scripts(Page::TEACHER_BANK_DETAILS, $this, 'enqueue_scripts');
        add_shortcode(Config::APP_PREFIX . 'teacher_bank_details', [$this, 'get_view']);
        add_action('wp_ajax_' . self::SAVE_DETAILS_ACTION, [$this, 'save_bank_details']);
    }

    public function enqueue_scripts()
    {
        
    }

    public function get_view()
    {
        if (!Auth::has_role(User::TEACHER_ROLE)) {
            Auth::show_403();
        }

        if (Auth::check()) {
            $this->view(Config::PUBLIC_VIEWS_DIR . '/teacher-bank-details');
        }
    }

    public function save_bank_details()
    {
        $data = Request::get_validated_data($_POST, [
            'bank_name'        => ['required'],
            'bank_bic'         => ['required'],
            'bank_iban'        => ['required'],
            'bank_country'     => ['required'],
            'bank_address'     => ['required'],
            'beneficiary_name' => ['required'],
        ]);
        
        $user = Auth::user();
        $user->update_meta_set($data);

        Response::success([
            'message' => __('Bank details updated successfully!')
        ]);
    }
}
