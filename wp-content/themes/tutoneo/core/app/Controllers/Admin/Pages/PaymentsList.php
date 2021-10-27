<?php

namespace App\Controllers\Admin\Pages;

use App\Models\User;
use App\Models\Payment;

class PaymentsList extends AdminPageList
{
    const PAGE = 'payments';
    const PER_PAGE = 20;

    public function get_columns()
    {
        $columns = array(
            'txn_id'       => 'Txn Id',
            'payment_id'   => 'Payment ID',
            'user_id'      => 'User',
            'txn_type'     => 'Txn Type',
            'amount'       => 'Amount',
            'status'       => 'Status',
            'payment_date' => 'Date'
        );

        return $columns;
    }

    public function prepare_items()
    {
        $total_items = Payment::count($this->get_conditions());
        $items = Payment::all($this->get_conditions(), $this->get_args());

        $this->_column_headers = array($this->get_columns(), [], $this->get_sortable_columns());
        $this->set_pagination_args(['total_items' => $total_items, 'per_page' => self::PER_PAGE]);
        $this->items = $items;
    }

    public function get_txn_color($value)
    {
        if ($value == 'DEBIT' || 'Failed') 
            return 'red';
        elseif ($value == 'Pending')
            return 'yellow';

        return 'green';
    }

    public function column_default($item, $column_name)
    {
        $value = $item[$column_name] ?? null;
        if ($column_name == 'user_id') {
            $user = User::get($value);
            if ($user->exists()) {
                return $user->get_name() . '(' . ucwords(implode(',', $user->roles())) . ')';
            }
            return '';
        }

        if ($column_name == 'txn_type') {
            $value = strtoupper($value);
            return '<span style="color:'. $this->get_txn_color($value) .';font-weight:bold">' . $value . '</span>';
        }
        
        if ($column_name == 'amount') {
            return '<span style="color:'. $this->get_txn_color($item['txn_type']) .';font-weight:bold">' . money_formatted_amount($value) . '</span>';
        }
        
        if ($column_name == 'status') {
            $value = ucfirst($value);
            return '<span style="color:'. $this->get_txn_color($value) .';font-weight:bold">' . $value . '</span>';
        }

        return $value;
    }

    public function get_sortable_columns()
    {
        $sortable_columns = array(
            'txn_type'     => ['txn_type', true],
            'amount'       => ['amount', true],
            'status'       => ['status', true],
            'payment_date' => ['payment_date', true]
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
