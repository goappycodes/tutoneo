<?php

namespace App\Controllers\Admin\Pages;

use App\Models\User;
use App\Models\Lesson;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\CreditPointHistory;
use App\Controllers\Admin\Pages\AdminPageList;

class CreditPointsList extends AdminPageList
{
    const PAGE = 'credit-points';
    const PER_PAGE = 20;

    public function get_columns()
    {
        $columns = array(
            'user_id'       => 'User',
            'booking_id'    => 'Booking',
            'lesson_id'     => 'Lesson',
            'payment_id'    => 'Payment',
            'event_type'    => 'Event',
            'credit_points' => 'Points',
            'added_at'      => 'Added At'
        );

        return $columns;
    }

    public function prepare_items()
    {
        $total_items = CreditPointHistory::count($this->get_conditions());
        $items = CreditPointHistory::all($this->get_conditions(), $this->get_args());

        $this->_column_headers = array($this->get_columns(), [], $this->get_sortable_columns());
        $this->set_pagination_args(['total_items' => $total_items, 'per_page' => self::PER_PAGE]);
        $this->items = $items;
    }

    public function column_default($item, $column_name)
    {
        $value = $item[$column_name] ?? null;

        if ($column_name == 'user_id') {
            $user = User::get($value);
            if ($user->exists()) {
                return $user->get_name() . '(' . ucwords(implode($user->roles())) . ')';
            }
            return '';
        }
        
        if ($column_name == 'booking_id') {
            $booking = Booking::get($value);
            if ($booking) {
                return $booking->get_title();
            }
            return '';
        }
        
        if ($column_name == 'lesson_id') {
            $lesson = Lesson::get($value);
            if ($lesson) {
                return $lesson->get_title();
            }
            return '';
        }
        
        if ($column_name == 'payment_id') {
            $payment = Payment::get($value);
            if ($payment) {
                return $payment->txn_id();
            }
            return '';
        }

        if ($column_name == 'txn_type') {
            $value = strtoupper($value);
            if ($value == 'DEBIT') {
                return '<span style="color:red;font-weight:bold">' . $value . '</span>';
            } else {
                return '<span style="color:green;font-weight:bold">' . $value . '</span>';
            }
        }

        if ($column_name == 'credit_points') {
            $txn_type = $item['txn_type'];
            if ($txn_type == 'debit') {
                return '<span style="color:red;font-weight:bold">-' . $value . '</span>';
            } else {
                return '<span style="color:green;font-weight:bold">+' . $value . '</span>';
            }
        }

        if ($column_name == 'event_type') {
            $credit_point_history = CreditPointHistory::get($item['id']);
            return $credit_point_history->get_event_text();
        }

        return $value;
    }

    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'credit_points' => ['credit_points', true],
            'added_at' => ['added_at', true]
        );
        return $sortable_columns;
    }

    public function no_items() 
    {
        _e( 'No item found.' );
    }

    private function get_conditions()
    {
        $conditions = [];
        $search = $_GET['s'] ?? null;
        if (!empty($search)) {
            $conditions = [
                [ 'txn_id', "%{$search}%", 'LIKE', 'OR' ],
                [ 'payment_id', "%{$search}%", 'LIKE' ]
            ];
        }

        return $conditions;
    }
}
