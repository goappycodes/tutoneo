<?php 

namespace App\Controllers\Frontend;

use App\Services\Auth;
use App\Controllers\Controller;
use App\Models\User;

class MessageThreadsController extends Controller
{
    public function __construct()
    {
        add_action('init', [$this, 'check_for_pending_threads_and_create']);
    }

    public function check_for_pending_threads_and_create()
    {
        if (Auth::has_role(User::TEACHER_ROLE)) {
            $threads = Auth::user()->get_message_threads();
            
            if (!is_array($threads)) {
                return;
            }

            foreach ($threads as $user_id => $thread) {
                foreach ($thread as $booking_id => $value) {
                    if ($value['status'] == 'pending') {
                        $msg_data = [
                            'message_to'      => $value['message_to'],
                            'message_top'     => $value['message_top'],
                            'token'           => $value['token'],
                            'fep_action'      => $value['fep_action'],
                            'message_title'   => $value['message_title'],
                            'message_content' => $value['message_content'],
                            'message_to_id'   => [$user_id]
                        ];
                        
                        $response = fep_send_message($msg_data);
                        
                        if ($response) {
                            $value['fep_id'] = $response;
                            $value['status'] = 'success';
                            Auth::user()->set_message_thread($user_id, $booking_id, $value);
                        }
                    }
                }
            }
        }
    }
}