<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function init_accounts()
    {
        // 1. Ensure Default Account
        $this->db->where('id', 1);
        if ($this->db->count_all_results('geopos_accounts') == 0) {
            $data = array(
                'id' => 1,
                'holder' => 'Business Bank',
                'adate' => date('Y-m-d'),
                'lastbal' => 0.00,
                'loc' => 0
            );
            $this->db->insert('geopos_accounts', $data);
            echo "Created Default Account (ID 1).<br>";
        } else {
            echo "Default Account (ID 1) exists.<br>";
        }
        
        // 2. Ensure Default Category
        $this->db->where('id', 1);
        if ($this->db->count_all_results('geopos_trans_cat') == 0) {
            $data = array(
                'id' => 1,
                'name' => 'Sales', // Default for Income
                'type' => 'Income'
            );
            $this->db->insert('geopos_trans_cat', $data);
             echo "Created Default Category (ID 1).<br>";
        } else {
             echo "Default Category (ID 1) exists.<br>";
        }
    }

    public function check_schema_products()
    {
        echo "<h1>Schema: geopos_products</h1>";
        $row = $this->db->get('geopos_products')->row_array();
        echo "<pre>";
        print_r(array_keys($row));
        echo "</pre>";
    }
}
