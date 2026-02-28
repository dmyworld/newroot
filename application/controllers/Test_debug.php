<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Test_debug extends CI_Controller
{
    public function index()
    {
        $this->load->database();

        echo "<h2>Products with Unit (First 10)</h2>";
        $this->db->select('pid, product_name, product_price, unit');
        $queryP = $this->db->get('geopos_products', 10);
        echo "<pre>";
        print_r($queryP->result_array());
        echo "</pre>";
    }
}
