<?php

namespace App\Controllers\Frontend;

use App\Models\Page;
use App\Models\User;
use App\Config\Config;
use App\Controllers\Controller;
use App\Http\Request;
use App\Http\Response;
use App\Models\Payment;
use App\Services\Auth;

class TeacherWalletController extends Controller
{
    const WITHDRAWAL_ACTION = Config::APP_PREFIX . 'wallet_withdrawal';

    public function __construct()
    {
        register_page_scripts(Page::TEACHER_WALLET, $this, 'enqueue_scripts');
        add_shortcode(Config::APP_PREFIX . 'teacher_wallet', [$this, 'get_transactions']);
        add_action('wp_ajax_' . self::WITHDRAWAL_ACTION, [$this, 'withdrawal']);
    }

    public function enqueue_scripts()
    {
        wp_enqueue_style(
            Config::APP_PREFIX . 'payments',
            Config::PUBLIC_CSS_DIR_URI . '/payments.css',
            [Config::PUBLIC_HANDLE],
            Config::VERSION
        );

        wp_enqueue_script(
            Config::APP_PREFIX . 'wallet',
            Config::PUBLIC_JS_DIR_URI . '/wallet.js',
            [Config::PUBLIC_HANDLE],
            Config::VERSION
        );

        wp_localize_script(
            Config::APP_PREFIX . 'wallet',
            'wallet_obj',
            [
                'withdrawal_action' => self::WITHDRAWAL_ACTION
            ]
        );
    }

    public function get_transactions()
    {
        if (!Auth::has_role(User::TEACHER_ROLE)) {
            Auth::show_403();
        }

        if (Auth::check()) {
            $this->view(Config::PUBLIC_VIEWS_DIR . '/wallet');
        }
    }

    public function withdrawal()
    {
        $teacher = Auth::user();

        $data = Request::get_validated_data($_POST, [
            'amount' => ['number', 'max_val:' . $teacher->get_wallet_amount(), 'min_val:1']
        ]);

        $result = Payment::insert([
            'user_id'      => $teacher->get_id(),
            'txn_id'       => Payment::create_txn_id(),
            'payment_id'   => null,     
            'payment_date' => date('Y-m-d H:i:s'),     
            'txn_type'     => Payment::TXN_DB,     
            'amount'       => $data['amount'],     
            'status'       => Payment::STATUS_SUCCESS
        ]);

        if (!is_wp_error($result) && $result) {
            Response::success([
                'message' => 'Success! Amount has been debited from wallet',
                'redirect' => get_page_url(Page::TEACHER_WALLET)
            ]);
        } else {
            Response::error([
                'message' => 'Sorry! We can\'t process your request at this moment'
            ]);
        }
    }
}
