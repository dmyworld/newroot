<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_transfer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('stock_transfer_model');
        $this->load->library('aauth');
        
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
    }
    
    // Main view page
    public function index()
    {
        $data['warehouses'] = $this->stock_transfer_model->get_warehouses();
        $data['last_transfer'] = $this->stock_transfer_model->get_last_transfer_id();
        
        $head['title'] = "Stock Transfer";
        $head['usernm'] = $this->aauth->get_user()->username;
        
        $this->load->view('fixed/header', $head);
        $this->load->view('stock_transfer/index', $data);
        $this->load->view('fixed/footer');
    }
    
    // Search product by code
    public function search_product()
    {
        $this->output->set_content_type('application/json');
        
        $warehouse_id = $this->input->post('warehouse_id', true);
        $product_code = $this->input->post('product_code', true);
        
        if (!$warehouse_id || !$product_code) {
            echo json_encode([
                'success' => false,
                'message' => 'Warehouse and product code are required'
            ]);
            return;
        }
        
        $product = $this->stock_transfer_model->search_product_by_code($warehouse_id, $product_code);
        
        if ($product) {
            echo json_encode([
                'success' => true,
                'product' => $product
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Product not found'
            ]);
        }
    }
    
    // Process stock transfer
    public function process_transfer()
    {
        $this->output->set_content_type('application/json');
        
        try {
            // Get POST data
            $from_warehouse = $this->input->post('from_warehouse', true);
            $to_warehouse = $this->input->post('to_warehouse', true);
            $invocieno = $this->input->post('invocieno', true);
            $invoicedate = $this->input->post('invoicedate', true);
            $notes = $this->input->post('notes', true);
            
            // Get products array
            $products_l = $this->input->post('products_l');
            $products_qty = $this->input->post('products_qty', true);
            
            // Validate
            if (empty($from_warehouse) || empty($to_warehouse)) {
                throw new Exception('Please select both warehouses');
            }
            
            if ($from_warehouse == $to_warehouse) {
                throw new Exception('Source and destination cannot be the same');
            }
            
            if (empty($products_l) || empty($products_qty)) {
                throw new Exception('No products selected');
            }
            
            // Convert to arrays
            if (!is_array($products_l)) {
                $products_l = explode(',', $products_l);
            }
            
            $quantities = explode(',', $products_qty);
            
            // Prepare products array for model
            $products = [];
            for ($i = 0; $i < count($products_l); $i++) {
                if (isset($products_l[$i]) && isset($quantities[$i])) {
                    $products[] = [
                        'pid' => intval($products_l[$i]),
                        'qty' => floatval($quantities[$i])
                    ];
                }
            }
            
            if (empty($products)) {
                throw new Exception('No valid products to transfer');
            }
            
            // Prepare transfer data
            $transfer_data = [
                'from_warehouse' => $from_warehouse,
                'to_warehouse' => $to_warehouse,
                'invocieno' => $invocieno,
                'invoicedate' => $invoicedate,
                'notes' => $notes,
                'products' => $products
            ];
            
            // Process transfer
            $result = $this->stock_transfer_model->process_stock_transfer($transfer_data);
            
            echo json_encode([
                'success' => true,
                'message' => 'Stock transfer completed successfully!',
                'transfer_id' => $result['transfer_id'],
                'items_count' => $result['items_count']
            ]);
            
        } catch (Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    
    // Test endpoint
    public function test()
    {
        $this->output->set_content_type('application/json');
        
        echo json_encode([
            'success' => true,
            'message' => 'API is working',
            'server_time' => date('Y-m-d H:i:s'),
            'php_version' => phpversion()
        ]);
    }
}