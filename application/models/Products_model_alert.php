<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products_model_alert extends CI_Model
{
    var $table = 'geopos_products';
    
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_alert_datatables($start = 0, $length = 100, $search = '', $warehouse = '', $category = '', $subcategory = '', $alert_level = '', $minus_qty = '', $unit = '', $start_date = '', $end_date = '')
    {
        $this->_get_alerts_query($search, $warehouse, $category, $subcategory, $alert_level, $minus_qty, $unit, $start_date, $end_date);
        
        $this->db->limit($length, $start);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_filtered_alerts($search = '', $warehouse = '', $category = '', $subcategory = '', $alert_level = '', $minus_qty = '', $unit = '', $start_date = '', $end_date = '')
    {
        $this->_get_alerts_query($search, $warehouse, $category, $subcategory, $alert_level, $minus_qty, $unit, $start_date, $end_date);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_alerts()
    {
        $this->db->from($this->table . ' p');
        $this->db->join('geopos_warehouse w', 'w.id = p.warehouse', 'left');
        $this->db->join('geopos_product_cat pc', 'pc.id = p.pcat', 'left');
        $this->db->join('geopos_product_cat psc', 'psc.id = p.sub_id', 'left');
        
        if ($this->aauth->get_user()->loc) {
            $this->db->where('w.loc', $this->aauth->get_user()->loc);
        }
        
        return $this->db->count_all_results();
    }



    public function get_alert_statistics($warehouse = '', $category = '', $subcategory = '', $alert_level = '', $minus_qty = '', $unit = '')
    {
        $this->db->select("
            COUNT(*) as total_products,
            SUM(CASE WHEN p.qty < 10 THEN 1 ELSE 0 END) as critical_count,
            SUM(CASE WHEN p.qty >= 10 AND p.qty < 20 THEN 1 ELSE 0 END) as warning_count,
            SUM(CASE WHEN p.qty >= 20 AND p.qty < 30 THEN 1 ELSE 0 END) as info_count,
            SUM(CASE WHEN p.qty >= 30 THEN 1 ELSE 0 END) as normal_count,
            SUM(CASE WHEN p.qty < p.alert THEN (p.alert - p.qty) ELSE 0 END) as total_shortage,
            SUM(p.qty) as total_pieces,
            SUM(p.sqft * p.qty) as total_sqft,
            SUM(p.qty2) as total_cubic
        ");
        
        $this->_apply_filters('', $warehouse, $category, $subcategory, $alert_level, $minus_qty, $unit);
        
        $query = $this->db->get();
        return $query->row_array();
    }

    private function _apply_filters($search = '', $warehouse = '', $category = '', $subcategory = '', $alert_level = '', $minus_qty = '', $unit = '', $start_date = '', $end_date = '') 
    {
       $this->db->from($this->table . ' p');
       $this->db->join('geopos_warehouse w', 'w.id = p.warehouse', 'left');
       $this->db->join('geopos_product_cat pc', 'pc.id = p.pcat', 'left');
       $this->db->join('geopos_product_cat psc', 'psc.id = p.sub_id', 'left');
        
        // Apply location filter
        if ($this->aauth->get_user()->loc) {
            $this->db->where('w.loc', $this->aauth->get_user()->loc);
        }
        
        // Apply search filter
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('p.product_name', $search);
            $this->db->or_like('p.product_code', $search);
            $this->db->or_like('p.barcode', $search);
            $this->db->group_end();
        }
        
        // Apply warehouse filter
        if (!empty($warehouse) && $warehouse != 'all') {
            $this->db->where('p.warehouse', $warehouse);
        }
        
        // Apply category filter
        if (!empty($category) && $category != 'all') {
            $this->db->where('p.pcat', $category);
        }
        
        // Apply subcategory filter
        if (!empty($subcategory) && $subcategory != 'all') {
            $this->db->where('p.sub_id', $subcategory);
        }

        // Apply unit filter
        if (!empty($unit) && $unit != 'all') {
            $this->db->where('p.unit', $unit);
        }
        
        // Apply minus quantity filter
        if ($minus_qty == 'yes') {
            $this->db->where('p.qty <', 0);
        } elseif ($minus_qty == 'no') {
              $this->db->where('p.qty >=', 0);
        }
        
        // Apply date range filter
        if (!empty($start_date) && !empty($end_date)) {
            $this->db->where('p.updated_at >=', date('Y-m-d 00:00:00', strtotime($start_date)));
            $this->db->where('p.updated_at <=', date('Y-m-d 23:59:59', strtotime($end_date)));
        }
        
        // Apply alert level filter
        if (!empty($alert_level) && $alert_level != 'all') {
            switch ($alert_level) {
                case 'critical':
                    $this->db->where('p.qty <', 10);
                    break;
                case 'warning':
                    $this->db->where('p.qty >=', 10);
                    $this->db->where('p.qty <', 20);
                    break;
                case 'info':
                    $this->db->where('p.qty >=', 20);
                    $this->db->where('p.qty <', 30);
                    break;
                case 'normal':
                    $this->db->where('p.qty >=', 30);
                    break;
            }
        }
    }

    private function _get_alerts_query($search = '', $warehouse = '', $category = '', $subcategory = '', $alert_level = '', $minus_qty = '', $unit = '', $start_date = '', $end_date = '')
    {
        $this->db->select('p.*, w.title as warehouse_name, pc.title as category_name, psc.title as subcategory_name');
        $this->_apply_filters($search, $warehouse, $category, $subcategory, $alert_level, $minus_qty, $unit, $start_date, $end_date);
        
        $this->db->order_by('p.qty', 'ASC');
        $this->db->order_by('p.alert', 'DESC');
    }

    public function get_chart_data($warehouse = '', $category = '', $unit = '')
    {
        // Doughnut chart data
        $this->db->select("
            SUM(CASE WHEN p.qty < 10 THEN 1 ELSE 0 END) as critical,
            SUM(CASE WHEN p.qty >= 10 AND p.qty < 20 THEN 1 ELSE 0 END) as warning,
            SUM(CASE WHEN p.qty >= 20 AND p.qty < 30 THEN 1 ELSE 0 END) as low,
            SUM(CASE WHEN p.qty >= 30 THEN 1 ELSE 0 END) as normal
        ");
        $this->db->from($this->table . ' p');
        $this->db->join('geopos_warehouse w', 'w.id = p.warehouse', 'left');
        
        if ($this->aauth->get_user()->loc) {
            $this->db->where('w.loc', $this->aauth->get_user()->loc);
        }
        
        if (!empty($warehouse) && $warehouse != 'all') {
            $this->db->where('p.warehouse', $warehouse);
        }
        
        if (!empty($category) && $category != 'all') {
            $this->db->where('p.pcat', $category);
        }

        if (!empty($unit) && $unit != 'all') {
            $this->db->where('p.unit', $unit);
        }
        
        $query = $this->db->get();
        $doughnut_data = $query->row_array();
        
        // Bar chart data (by warehouse)
        $this->db->select("
            w.title as warehouse,
            COUNT(*) as total,
            SUM(CASE WHEN p.qty < 10 THEN 1 ELSE 0 END) as critical,
            SUM(CASE WHEN p.qty >= 10 AND p.qty < 20 THEN 1 ELSE 0 END) as warning
        ");
        $this->db->from($this->table . ' p');
        $this->db->join('geopos_warehouse w', 'w.id = p.warehouse', 'left');
        
        if ($this->aauth->get_user()->loc) {
            $this->db->where('w.loc', $this->aauth->get_user()->loc);
        }
        
        $this->db->group_by('p.warehouse');
        $this->db->order_by('critical', 'DESC');
        $this->db->limit(10);
        
        $query = $this->db->get();
        $bar_data = $query->result_array();
        
        return [
            'doughnut' => $doughnut_data,
            'bar' => $bar_data
        ];
    }

    public function get_low_stock_alerts($type = 'critical', $limit = 5)
    {
        $this->db->select('p.pid, p.product_name, p.product_code, p.qty, p.alert, w.title');
        $this->db->from($this->table . ' p');
        $this->db->join('geopos_warehouse w', 'w.id = p.warehouse', 'left');
        
        if ($this->aauth->get_user()->loc) {
            $this->db->where('w.loc', $this->aauth->get_user()->loc);
        }
        
        switch ($type) {
            case 'critical':
                $this->db->where('p.qty <', 10);
                break;
            case 'warning':
                $this->db->where('p.qty >=', 10);
                $this->db->where('p.qty <', 20);
                break;
        }
        
        $this->db->order_by('p.qty', 'ASC');
        $this->db->limit($limit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_product_details($pid)
    {
        $this->db->select('p.*, w.title as warehouse_name, pc.title as category_name, psc.title as subcategory_name');
        $this->db->from($this->table . ' p');
        $this->db->join('geopos_warehouse w', 'w.id = p.warehouse', 'left');
        $this->db->join('geopos_product_cat pc', 'pc.id = p.pcat', 'left');
        $this->db->join('geopos_product_cat psc', 'psc.id = p.sub_id', 'left');
        $this->db->where('p.pid', $pid);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function update_alert_quantity($pid, $alert_qty, $reason = '')
    {
        $data = array(
            'alert' => $alert_qty,
            'updated_at' => date('Y-m-d H:i:s')
        );
        
        $this->db->where('pid', $pid);
        $result = $this->db->update($this->table, $data);
        
        // Log the change
        if ($result) {
            $log_data = array(
                'product_id' => $pid,
                'old_alert_qty' => $this->get_current_alert($pid),
                'new_alert_qty' => $alert_qty,
                'reason' => $reason,
                'changed_by' => $this->aauth->get_user()->id,
                'changed_at' => date('Y-m-d H:i:s')
            );
            
            $this->db->insert('geopos_alert_logs', $log_data);
        }
        
        return $result;
    }

    public function get_alerts_for_export($warehouse = '', $category = '', $subcategory = '', $alert_level = '', $minus_qty = '', $unit = '')
    {
        $this->_get_alerts_query('', $warehouse, $category, $subcategory, $alert_level, $minus_qty, $unit);
        
        $query = $this->db->get();
        return $query->result_array();
    }

    private function get_current_alert($pid)
    {
        $this->db->select('alert');
        $this->db->where('pid', $pid);
        $query = $this->db->get($this->table);
        $result = $query->row_array();
        return $result['alert'] ?? 0;
    }

    // Test functions
    public function test_critical_alerts()
    {
        $this->db->where('qty <', 10);
        $count = $this->db->count_all_results($this->table);
        
        return [
            'success' => true,
            'message' => "Found $count critical alerts",
            'count' => $count
        ];
    }

    public function test_warning_alerts()
    {
        $this->db->where('qty >=', 10);
        $this->db->where('qty <', 20);
        $count = $this->db->count_all_results($this->table);
        
        return [
            'success' => true,
            'message' => "Found $count warning alerts",
            'count' => $count
        ];
    }

    public function test_all_alerts()
    {
        $stats = $this->get_alert_statistics();
        
        return [
            'success' => true,
            'message' => "Alert system test completed",
            'data' => $stats
        ];
    }
}