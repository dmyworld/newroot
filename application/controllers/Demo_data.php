<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demo_data extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('products_model');
        $this->load->model('customers_model');
        $this->load->model('invoices_model');
    }

    public function index()
    {
        echo '<h1>Demo Data Installer</h1>';
        echo '<p>This will insert demo data for the Owner Dashboard.</p>';
        echo '<a href="' . base_url('demo_data/install') . '">Install Demo Data</a>';
    }

    public function install()
    {
        set_time_limit(600);
        $this->db->db_debug = FALSE;
        echo "<h2>Starting Installation...</h2>";
        $locations = $this->_ensure_locations();
        foreach($locations as $loc) {
            $loc_id = $loc['id'];
            $loc_name = $loc['cname'];
            if ($loc_id == 0) continue; // Skip Main for loop if needed, or handle it
            echo "<h3>Branch: $loc_name ($loc_id)</h3>";
            $wh_id = $this->_ensure_warehouse($loc_id, $loc_name);
            $this->_seed_products($wh_id, $loc_id);
            $this->_seed_invoices($loc_id);
            $this->_seed_transactions($loc_id, $loc_name);
            $this->_seed_staff_scores($loc_id);
            $this->_seed_payroll($loc_id);
            $this->_seed_manufacturing($loc_id);
        }
        echo "<h3>Installation Complete!</h3>";
    }

    public function debug_seed()
    {
        // $this->db->db_debug = FALSE; // Remove to see real errors
        try {
            $locations = $this->_ensure_locations();
            foreach($locations as $loc) {
                $loc_id = isset($loc['id']) ? $loc['id'] : 0;
                $loc_name = isset($loc['cname']) ? $loc['cname'] : 'Unknown';
                echo "<hr><h3>Processing: $loc_name ($loc_id)</h3>";
                
                try {
                     $wh_id = $this->_ensure_warehouse($loc_id, $loc_name);
                     $this->_seed_products($wh_id, $loc_id);
                     $this->_seed_invoices($loc_id);
                     $this->_seed_staff_scores($loc_id);
                     $this->_seed_transactions($loc_id, $loc_name);
                     $this->_seed_payroll($loc_id);
                     $this->_seed_manufacturing($loc_id);
                 } catch (Throwable $e) { /* silent catch for debug_seed */ }
            }
            echo "<h3>Done.</h3>";
        } catch (Throwable $e) {
             echo "<h1>FATAL ERROR: " . $e->getMessage() . "</h1>";
        }
    }

    private function _ensure_locations()
    {
        $locs = $this->db->get('geopos_locations')->result_array();
        if (empty($locs)) {
             $this->db->insert('geopos_locations', ['cname' => 'Ragama', 'address' => 'Ragama', 'city' => 'Ragama', 'country' => 'Sri Lanka']);
             $locs = $this->db->get('geopos_locations')->result_array();
        }
        return $locs;
    }

    private function _ensure_warehouse($loc_id, $loc_name)
    {
        $query = $this->db->get_where('geopos_warehouse', ['loc' => $loc_id]);
        if($query && $query->num_rows() > 0) return $query->row()->id;
        $this->db->insert('geopos_warehouse', ['title' => $loc_name . ' WH', 'loc' => $loc_id]);
        return $this->db->insert_id();
    }

    private function _seed_products($wh_id, $loc_id)
    {
        // 1. High Velocity Hero (Active)
        $code_hv = 'W-TEAK-S-' . $loc_id;
        $this->db->where('product_code', $code_hv)->delete('geopos_products');
        $this->db->insert('geopos_products', [
            'product_name' => 'Solid Teak Wood Plank',
            'product_code' => $code_hv,
            'product_price' => 12000,
            'fproduct_price' => 11000,
            'fproduct_cost' => 8000,
            'qty' => 50,
            'warehouse' => $wh_id,
            'pcat' => 1
        ]);
        
        // 2. Dead Stock Dud (Stagnant)
        $code_dead = 'D-OAK-DEAD-' . $loc_id;
        $this->db->where('product_code', $code_dead)->delete('geopos_products');
        $this->db->insert('geopos_products', [
            'product_name' => 'Stagnant Oak Beam',
            'product_code' => $code_dead,
            'product_price' => 25000,
            'fproduct_price' => 22000,
            'fproduct_cost' => 15000,
            'qty' => 10,
            'warehouse' => $wh_id,
            'pcat' => 1
        ]);
    }

    private function _seed_invoices($loc_id)
    {
        $cust_id = $this->_ensure_customer($loc_id);
        $uid = $this->_get_branch_user($loc_id);
        
        // High Velocity Hero sales
        $code_hv = 'W-TEAK-S-' . $loc_id;
        $hv_prod = $this->db->get_where('geopos_products', ['product_code' => $code_hv])->row_array();
        
        if ($hv_prod) {
            for($i=0; $i<15; $i++) {
                $total = rand(10000, 50000);
                $inv_data = [
                    'tid' => rand(1000, 99999),
                    'invoicedate' => date('Y-m-d', strtotime('-' . rand(0, 7) . ' days')),
                    'total' => $total,
                    'csd' => $cust_id,
                    'eid' => $uid,
                    'status' => 'paid',
                    'loc' => $loc_id
                ];
                $this->db->insert('geopos_invoices', $inv_data);
                $inv_id = $this->db->insert_id();

                // Profit (Type 9)
                $this->db->insert('geopos_metadata', ['type' => 9, 'rid' => $inv_id, 'col1' => $total * 0.3, 'd_date' => date('Y-m-d', strtotime('-' . rand(0, 7) . ' days'))]);

                // Item
                $this->db->insert('geopos_invoice_items', [
                    'tid' => $inv_id,
                    'product' => $hv_prod['pid'],
                    'qty' => rand(1, 5),
                    'price' => $hv_prod['product_price'],
                    'subtotal' => $hv_prod['product_price'] * 1
                ]);
            }
        }
    }

    private function _get_wh($loc_id)
    {
        $q = $this->db->get_where('geopos_warehouse', ['loc' => $loc_id]);
        return ($q->num_rows() > 0) ? $q->row()->id : 1;
    }

    private function _get_branch_user($loc_id)
    {
        // Special: Ensure Ragama Branch (2) has at least one user for demo purposes
        if ($loc_id == 2) {
             $this->db->set('loc', 2)->where('id', 11)->update('geopos_users'); // Move user 'demo' to Loc 2
        }

        $this->db->where('loc', $loc_id);
        $q = $this->db->get('geopos_users');
        if ($q->num_rows() > 0) return $q->row()->id;
        
        // Final fallback to admin (ID 8) if no branch user exists
        return 8;
    }

    private function _ensure_customer($loc_id)
    {
        $query = $this->db->get('geopos_customers');
        if($query->num_rows() > 0) return $query->row()->id;
        $this->db->insert('geopos_customers', ['name' => 'Demo Customer', 'loc' => $loc_id]);
        return $this->db->insert_id();
    }

    private function _seed_transactions($loc_id, $loc_name)
    {
        $uid = $this->_get_branch_user($loc_id);
        $methods = ['Cash', 'Bank', 'Cheque'];
        for($i=0; $i<20; $i++) {
            $method = $methods[array_rand($methods)];
            $amount = rand(5000, 20000);
            $success = $this->db->insert('geopos_transactions', [
                'acid' => 1,
                'account' => 'Cash Account',
                'type' => 'Income',
                'cat' => 'Sales',
                'debit' => 0,
                'credit' => $amount,
                'payer' => 'Walk-in Client',
                'payerid' => 0,
                'method' => $method,
                'date' => date('Y-m-d'),
                'tid' => rand(100, 999),
                'eid' => $uid,
                'loc' => $loc_id
            ]);
        }
    }

    private function _seed_staff_scores($loc_id)
    {
        $uid = $this->_get_branch_user($loc_id);
        $this->db->where('staff_id', $uid)->where('date', date('Y-m-d'))->delete('geopos_staff_scores');
        $this->db->insert('geopos_staff_scores', [
            'staff_id' => $uid,
            'branch_id' => $loc_id,
            'trust_score' => 96,
            'date' => date('Y-m-d'),
            'adjustment_count' => 0
        ]);
    }

    private function _seed_payroll($loc_id)
    {
        // 1. Ensure Departments exist in geopos_hrm (typ=1)
        $departments = [
            10 => 'Manufacturing',
            11 => 'Sales',
            12 => 'Administration'
        ];
        
        foreach($departments as $id => $name) {
            if ($this->db->table_exists('geopos_hrm')) {
                $this->db->where('id', $id)->where('typ', 1)->delete('geopos_hrm');
                $this->db->insert('geopos_hrm', ['id' => $id, 'typ' => 1, 'val1' => $name]);
            }
        }
        
        // 2. Clear existing runs
        if ($this->db->field_exists('loc', 'geopos_payroll_runs')) {
            $this->db->where('loc', $loc_id);
        }
        $start = date('Y-m-01');
        $this->db->where('start_date', $start)->delete('geopos_payroll_runs');
        
        // 3. Create a Pending Run (Audit Required)
        $data = [
            'start_date' => $start, 
            'end_date' => date('Y-m-t'), 
            'status' => 'Pending', 
            'date_created' => date('Y-m-d')
        ];
        if ($this->db->field_exists('loc', 'geopos_payroll_runs')) {
            $data['loc'] = $loc_id;
        }
        $this->db->insert('geopos_payroll_runs', $data);
        $run_id = $this->db->insert_id();

        $uid = $this->_get_branch_user($loc_id);
        
        // 4. Link employees to departments
        $this->db->where('id', $uid)->update('geopos_employees', ['dept' => 10]); 
        
        // 5. Add items
        $this->db->insert('geopos_payroll_items', ['run_id' => $run_id, 'employee_id' => $uid, 'gross_pay' => 75000, 'net_pay' => 75000]);
        if ($this->db->error()['code']) echo "Error items: " . $this->db->error()['message'] . "<br>";
        
        // 6. Add another item for another department (Sales)
        $this->db->insert('geopos_payroll_items', ['run_id' => $run_id, 'employee_id' => 8, 'gross_pay' => 45000, 'net_pay' => 45000]);
        $this->db->set('dept', 11)->where('id', 8)->update('geopos_employees');
    }

    private function _seed_manufacturing($loc_id)
    {
        // Clear existing
        if ($this->db->field_exists('loc', 'geopos_production_batches')) {
            $this->db->where('loc', $loc_id)->delete('geopos_production_batches');
        }

        // Helper to get data with optional loc
        $insert_batch = function($data) use ($loc_id) {
            if ($this->db->field_exists('loc', 'geopos_production_batches')) {
                $data['loc'] = $loc_id;
            }
            $this->db->insert('geopos_production_batches', $data);
            return $this->db->insert_id();
        };

        // 1. Active Batch (In Progress)
        $batch_id = $insert_batch([
            'name' => 'Current Production #' . $loc_id,
            'status' => 'Processing',
            'start_date' => date('Y-m-d'),
            'due_date' => date('Y-m-d', strtotime('+7 days')),
            'priority' => 'Medium'
        ]);
        
        $this->db->insert('geopos_work_orders', [
            'batch_id' => $batch_id,
            'stage_name' => 'Wood Cutting',
            'status' => 'In Progress',
            'qty_to_make' => rand(5, 15)
        ]);

        // 2. Overdue Batch (Velocity Breach Trigger)
        $insert_batch([
            'name' => 'Delayed Order Batch',
            'status' => 'Pending',
            'start_date' => date('Y-m-d', strtotime('-15 days')),
            'due_date' => date('Y-m-d', strtotime('-2 days')), // Overdue
            'priority' => 'High'
        ]);

        // 3. Completed Batches (Velocity Capacity Proxy)
        for($i=0; $i<8; $i++) {
            $insert_batch([
                'name' => 'Finished Batch ' . $i,
                'status' => 'Completed',
                'start_date' => date('Y-m-d', strtotime('-10 days')),
                'due_date' => date('Y-m-d', strtotime('-'.rand(1, 3).' days')),
                'priority' => 'Low'
            ]);
        }
    }

    private function _seed_risk_alerts($locations) { }
    private function _get_uid() { return 1; }
}
