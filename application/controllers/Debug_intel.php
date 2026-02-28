<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Debug_intel extends CI_Controller {
    public function index() {
        ob_start();
        $loc = $this->input->get('loc') ?: 2;
        $this->load->model('intelligence_model');
        
        echo "<h1>Stock Debug (Loc: $loc)</h1>";

        // Check products in loc
        echo "<h2>Products in Loc $loc</h2>";
        $p_fields = $this->db->list_fields('geopos_products');
        echo "Fields: " . implode(', ', $p_fields) . "<br>";
        $this->db->select('p.pid, p.product_name, p.product_code, p.qty, p.warehouse, w.loc');
        $this->db->from('geopos_products p');
        $this->db->join('geopos_warehouse w', 'p.warehouse = w.id', 'left');
        $this->db->where('w.loc', $loc);
        $products = $this->db->get();
        echo "Total Products: " . $products->num_rows() . "<br>";
        echo "<pre>" . print_r($products->result_array(), true) . "</pre>";

        // Check invoice items for these products
        if ($products->num_rows() > 0) {
            $pids = array_column($products->result_array(), 'pid');
            echo "<h2>Invoice Items for Products</h2>";
            $this->db->select('i.product, COUNT(*) as count, MAX(ii.invoicedate) as last_sold');
            $this->db->from('geopos_invoice_items i');
            $this->db->join('geopos_invoices ii', 'i.tid = ii.id', 'left');
            $this->db->where_in('i.product', $pids);
            $this->db->group_by('i.product');
            $items = $this->db->get();
            echo "Sold products count: " . $items->num_rows() . "<br>";
            echo "<pre>" . print_r($items->result_array(), true) . "</pre>";
        }

        echo "<h2>Dead Stock Raw</h2>";
        $dead_raw = $this->intelligence_model->get_dead_stock($loc);
        echo "Count: " . count($dead_raw) . "<br>";
        if ($this->db->error()['code']) echo "Error: " . $this->db->error()['message'] . "<br>";
        echo "Query: " . $this->db->last_query() . "<br>";
        echo "<pre>" . print_r(array_slice($dead_raw, 0, 5), true) . "</pre>";

        echo "<h2>Fast Moving Raw</h2>";
        $fast_raw = $this->intelligence_model->get_fast_moving_stock($loc);
        echo "Count: " . count($fast_raw) . "<br>";
        if ($this->db->error()['code']) echo "Error: " . $this->db->error()['message'] . "<br>";
        echo "Query: " . $this->db->last_query() . "<br>";
        echo "<pre>" . print_r(array_slice($fast_raw, 0, 5), true) . "</pre>";

        echo "<h2>Dead Stock Summary</h2>";
        $dead = $this->intelligence_model->get_dead_stock_summary($loc);
        echo "<pre>" . print_r($dead, true) . "</pre>";

        echo "<h2>High Velocity Summary</h2>";
        $fast = $this->intelligence_model->get_fast_moving_summary($loc);
        echo "<pre>" . print_r($fast, true) . "</pre>";

        $output = ob_get_clean();
        file_put_contents(FCPATH . 'debug_log.txt', strip_tags($output));
        echo $output;
    }
}
