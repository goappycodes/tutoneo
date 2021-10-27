<?php

namespace App\Models;

abstract class CustomTable extends Model
{
    public static $instances = [];
    public $table = null;
    public $data = null;

    public static function all($conditions = [], $args = [], $output = 'ARRAY_A')
    {
        global $wpdb;
        
        $called_class = get_called_class();
        $instance = new $called_class();
        
        $table = $instance::TABLE;
        $where_clause = self::prepare_where_clause($conditions);
        $order_limit_clause = self::prepare_order_limit_clause($args);
        
        $result = $wpdb->get_results( "SELECT * FROM {$table} {$where_clause} {$order_limit_clause}", $output );
        
        if (is_wp_error($result) || !$result) {
            return false;
        }

        return $result;
    }

    public static function get($id)
    {
        global $wpdb;

        if (empty($id)) {
            return false;
        }

        $called_class = get_called_class();
        $instance = new $called_class();

        $instance->table = $instance::TABLE;
        $table = $instance->table;

        $result = $wpdb->get_results( "SELECT * FROM {$table} WHERE id = {$id}" );
        
        if (is_wp_error($result) || !$result) {
            return false;
        }
        
        $instance->data = $result[0];

        $instances[$called_class][] = $instance;
        return $instance;
    }

    public static function insert($data)
    {
        global $wpdb;

        $called_class = get_called_class();
        $instance = new $called_class();

        $table = $instance::TABLE;
        
        $result = $wpdb->insert($table, $data);
        
        if (is_wp_error($result) || !$result) {
            return $result;
        }
        
        return self::get($wpdb->insert_id);
    }

    public static function find_by($condition_arr = [], $args = [])
    {
        global $wpdb;

        $called_class = get_called_class();
        $instance = new $called_class();

        $where_clause = self::prepare_where_clause($condition_arr);
        $order_limit_clause = self::prepare_order_limit_clause($args);

        $table = $instance::TABLE;
        $result = $wpdb->get_results( "SELECT * FROM {$table} {$where_clause} {$order_limit_clause}" );
        
        if (is_wp_error($result) || !$result) {
            return [];
        }
        
        $data = [];
        foreach ($result as $res) {
            $data[] = self::get($res->id);
        }

        return $data;
    }

    public static function prepare_where_clause($conditions = [])
    {
        $where = '';
        if (count($conditions)) {
            $where = " WHERE ";
            foreach ($conditions as $key => $condition) {
                $conjuction = $conditions[$key - 1][3] ?? ($key ? 'AND' : null);
                $where .= $conjuction ? " {$conjuction} " : '';
                $field = $condition[0] ?? null;
                $value = $condition[1] ?? null;
                $value = is_string($value) ? "'" . $value . "'" : $value;
                $compare = $condition[2] ?? '=';
                if ($field && $value) {
                    $where .= "{$field} {$compare} {$value}";
                }
            }
        }

        return $where;
    }

    public static function prepare_order_limit_clause($args = [])
    {
        $result_string = ' ORDER BY ';
        $result_string .= $args['orderby'] ?? 'id';
        $result_string .= ' ';
        $result_string .= $args['order'] ?? 'DESC';
        $result_string .= ' ';
        $result_string .= $args['limit'] ?? '';
        
        return $result_string;
    }

    public static function sum($field, $conditions = []) 
    {
        global $wpdb;

        $called_class = get_called_class();
        $instance = new $called_class();

        $table = $instance::TABLE;
        $where_clause = self::prepare_where_clause($conditions);

        $result = $wpdb->get_results( "SELECT SUM({$field}) as {$field} FROM {$table} {$where_clause}");
        
        if (is_wp_error($result) || !$result) {
            return false;
        }
        
        return (float)$result[0]->{$field};
    }

    public static function count($conditions = []) 
    {
        global $wpdb;

        $called_class = get_called_class();
        $instance = new $called_class();

        $table = $instance::TABLE;
        $where_clause = self::prepare_where_clause($conditions);

        $result = $wpdb->get_results( "SELECT COUNT(*) as count FROM {$table} {$where_clause}");
        
        if (is_wp_error($result) || !$result) {
            return false;
        }
        
        return (int)$result[0]->count;
    }

    public function data()
    {
        return $this->data;
    }

    public function get_id()
    {
        return $this->data()->id;
    }
}