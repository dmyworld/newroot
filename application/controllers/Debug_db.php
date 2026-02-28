<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug_db extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index()
    {
        header('Content-Type: text/plain');
        
        if ($this->input->get('describe')) {
            $table = $this->input->get('describe');
            echo "DESCRIBE $table\n";
            $q = $this->db->query("DESCRIBE $table");
            foreach ($q->result_array() as $row) {
                print_r($row);
            }
            return;
        }

        if ($this->input->get('list')) {
            $table = $this->input->get('list');
            echo "LIST $table\n";
            $q = $this->db->get($table);
            if ($q) {
                print_r($q->result_array());
            } else {
                echo "Query Failed\n";
            }
            return;
        }

        echo "PHP Version: " . phpversion() . "\n";
        echo "Database Debug\n";
        echo "Tables Found:\n";
        $tables = $this->db->list_tables();
        foreach ($tables as $table) {
            echo " - $table\n";
        }
        echo "\n";
        
        // Products
        $hv = $this->db->where("product_code LIKE 'HV-HERO%'")->count_all_results('geopos_products');
        $ds = $this->db->where("product_code LIKE 'DS-DUD%'")->count_all_results('geopos_products');
        $all_prod = $this->db->count_all('geopos_products');
        
        echo "Products\n";
        echo "High Velocity (HV-HERO): " . intval($hv) . "\n";
        echo "Dead Stock (DS-DUD): " . intval($ds) . "\n";
        echo "Total Products: " . intval($all_prod) . "\n\n";
        
        // Invoices
        $inv_count = $this->db->count_all('geopos_invoices');
        $this->db->select('pmethod, count(*) as c');
        $this->db->group_by('pmethod');
        $inv_methods = $this->db->get('geopos_invoices')->result_array();
        
        echo "Invoices\n";
        echo "Total Invoices: $inv_count\n";
        echo "Methods:\n";
        foreach($inv_methods as $m) {
            echo " - {$m['pmethod']}: {$m['c']}\n";
        }
        echo "\n";
        
        // Staff Scores
        $score_count = $this->db->count_all('geopos_staff_scores');
        echo "Staff Scores\n";
        echo "Total Scores: $score_count\n\n";
        
        // Warehouses
        $wh = $this->db->get('geopos_warehouse')->result_array();
        echo "Warehouses\n";
        foreach($wh as $w) {
            echo "ID: {$w['id']} - Title: {$w['title']} - Loc: {$w['loc']}\n";
        }
        echo "\n";

        // Transactions
        $trans_count = $this->db->count_all('geopos_transactions');
        echo "Transactions\n";
        echo "Total Transactions: $trans_count\n\n";

        // Payroll
        echo "Payroll\n";
        echo "Total Runs: " . $this->db->count_all('geopos_payroll_runs') . "\n";
        echo "Total Items: " . $this->db->count_all('geopos_payroll_items') . "\n\n";

        // Manufacturing
        echo "Manufacturing\n";
        echo "Work Orders: " . $this->db->count_all('geopos_work_orders') . "\n";
        echo "Batches: " . $this->db->count_all('geopos_production_batches') . "\n\n";
        
        // Verify Users and Locations
        echo "Users & Locations\n";
        $users = $this->db->select('id, username, loc')->limit(10)->get('geopos_users')->result_array();
        foreach($users as $u) {
            echo "ID: {$u['id']} - User: {$u['username']} - Loc: {$u['loc']}\n";
        }

        // Employees
        echo "\nEmployees\n";
        echo "Total Employees: " . $this->db->count_all('geopos_employees') . "\n";
        
    }
}
