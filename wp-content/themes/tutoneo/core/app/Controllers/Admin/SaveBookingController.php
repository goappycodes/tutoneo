<?php

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Events\MatchFoundEvent;
use App\Events\MatchNotFoundEvent;
use App\Models\Booking;

class SaveBookingController extends Controller
{
    public function __construct()
    {
        add_action('acf/save_post', [$this, 'save_booking'], 10, 1);
    }

    public function save_booking($post_id)
    {
        $booking = Booking::get($post_id);
        
        if (!$booking || $booking->get_post_type() != Booking::POST_TYPE) {
            return;
        }

        $match_found = get_field(Booking::IS_MATCH_FOUND_FIELD);
        $notify_user = get_field(Booking::NOTIFY_USER_FIELD);
        $send_payment_link = get_field(Booking::PAYMENT_LINK_FIELD);

        if ($match_found == Booking::MATCH_FOUND) {
            $match_found_event = new MatchFoundEvent($booking, $notify_user, $send_payment_link);
            $match_found_event->fire();
        } else {
            $match_not_found_event = new MatchNotFoundEvent($booking, $notify_user);
            $match_not_found_event->fire();
        }
    }
}
