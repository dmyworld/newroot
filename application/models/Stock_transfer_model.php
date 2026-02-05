<?php // defined('BASEPATH') OR exit('No direct script access allowed');

class Stock_transfer_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_warehouses()
    {
        $this->db->select('id, title, extra as description');
        $this->db->where('id !=', 0);
        $this->db->order_by('title', 'asc');
        $query = $this->db->get('geopos_warehouse');
        
        return $query->result_array();
    }
    
    public function search_product_by_code($warehouse_id, $product_code)
    {
        $this->db->select('p.*, w.title as warehouse_name');
        $this->db->from('geopos_products p');
        $this->db->join('geopos_warehouse w', 'w.id = p.warehouse', 'left');
        $this->db->where('p.warehouse', $warehouse_id);
        $this->db->where('p.product_code', $product_code);
        $this->db->limit(1);
        
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        
        return false;
    }
    
    public function get_product_by_id($product_id, $warehouse_id)
    {
        $this->db->where('pid', $product_id);
        $this->db->where('warehouse', $warehouse_id);
        $query = $this->db->get('geopos_products');
        
        return $query->row_array();
    }
    
    public function check_stock_availability($product_id, $warehouse_id, $quantity)
    {
        $product = $this->get_product_by_id($product_id, $warehouse_id);
        
        if (!$product) {
            return [
                'available' => false,
                'message' => 'Product not found in warehouse',
                'current_qty' => 0
            ];
        }
        
        if ($product['qty'] < $quantity) {
            return [
                'available' => false,
                'message' => 'Insufficient stock. Available: ' . $product['qty'],
                'current_qty' => $product['qty']
            ];
        }
        
        return [
            'available' => true,
            'message' => 'Stock available',
            'current_qty' => $product['qty']
        ];
    }
    
public function process_stock_transfer($transfer_data)
{
    // Start transaction
    $this->db->trans_start();
    
    try {
        // Debug logging
        error_log("=== Starting Stock Transfer ===");
        error_log("Transfer Data: " . print_r($transfer_data, true));
        
        // Validate all products before processing
        foreach ($transfer_data['products'] as $product) {
            $stock_check = $this->check_stock_availability(
                $product['pid'],
                $transfer_data['from_warehouse'],
                $product['qty']
            );
            
            if (!$stock_check['available']) {
                throw new Exception($stock_check['message']);
            }
        }
        
        // Get warehouse names
        $from_name = $this->get_warehouse_name($transfer_data['from_warehouse']);
        $to_name = $this->get_warehouse_name($transfer_data['to_warehouse']);
        
        // Create transfer record
        $transfer_record = [
            'tid' => $transfer_data['invocieno'],
            'invoicedate' => $transfer_data['invoicedate'],
            'from_warehouse' => $from_name,
            'to_warehouse' => $to_name,
            'items' => count($transfer_data['products']),
            'refer' => 'admin',
            'total' => 0.00,
            'status' => 'completed',
            'eid' => 8,
            'notes' => $transfer_data['notes']
        ];
        
        error_log("Inserting transfer record: " . print_r($transfer_record, true));
        $this->db->insert('geopos_stock_transfer', $transfer_record);
        $transfer_id = $this->db->insert_id();
        error_log("Transfer ID created: $transfer_id");
        
        $total_value = 0;
        
        // Process each product
        foreach ($transfer_data['products'] as $product) {
            $product_id = $product['pid'];
            $quantity = $product['qty'];
            
            error_log("Processing Product ID: $product_id, Quantity: $quantity");
            
            // Get product details from source warehouse
            $product_details = $this->get_product_by_id($product_id, $transfer_data['from_warehouse']);
            
            if (!$product_details) {
                throw new Exception("Product ID $product_id not found in source warehouse");
            }
            
            error_log("Product details: " . print_r($product_details, true));
            
            // 1. DEDUCT FROM SOURCE WAREHOUSE
            error_log("Deducting from source warehouse...");
            $this->db->where('pid', $product_id);
            $this->db->where('warehouse', $transfer_data['from_warehouse']);
            $this->db->set('qty', "qty - $quantity", false);
            $this->db->update('geopos_products');
            
            if ($this->db->affected_rows() == 0) {
                throw new Exception("Failed to deduct product ID $product_id from source warehouse");
            }
            
            // 2. ADD TO DESTINATION WAREHOUSE
            error_log("Checking destination warehouse...");
            $this->db->where('pid', $product_id);
            $this->db->where('warehouse', $transfer_data['to_warehouse']);
            $dest_exists = $this->db->get('geopos_products')->row();
            
            if ($dest_exists) {
                // UPDATE existing
                error_log("Product exists in destination, updating...");
                $this->db->where('pid', $product_id);
                $this->db->where('warehouse', $transfer_data['to_warehouse']);
                $this->db->set('qty', "qty + $quantity", false);
                $this->db->update('geopos_products');
                
                if ($this->db->affected_rows() == 0) {
                    error_log("Update query failed: " . $this->db->last_query());
                    throw new Exception("Failed to update product ID $product_id in destination warehouse");
                }
            } else {
                // INSERT new record
                error_log("Product doesn't exist in destination, inserting...");
                
                // Get source product data WITHOUT warehouse filter to get base product
                error_log("Getting base product data for PID: $product_id");
                $this->db->where('pid', $product_id);
                $this->db->limit(1); // Get first occurrence
                $source_product = $this->db->get('geopos_products')->row_array();
                
                if (!$source_product) {
                    error_log("No product found with PID: $product_id");
                    throw new Exception("Could not find base product data for product ID $product_id");
                }
                
                error_log("Source product data retrieved: " . print_r($source_product, true));
                
                // Remove ID for auto-increment
                unset($source_product['id']);
                
                // Update warehouse and quantity
                $source_product['warehouse'] = $transfer_data['to_warehouse'];
                $source_product['qty'] = $quantity;
                
                // Reset alert if exists
                if (isset($source_product['alert'])) {
                    $source_product['alert'] = 0;
                }
                
                error_log("Prepared product data for insert: " . print_r($source_product, true));
                
                // Try to insert
                $insert_result = $this->db->insert('geopos_products', $source_product);
                $new_id = $this->db->insert_id();
                
                error_log("Insert result: " . ($insert_result ? "Success" : "Failed"));
                error_log("New ID: $new_id");
                error_log("Last query: " . $this->db->last_query());
                
                // Check for database errors
                $error = $this->db->error();
                if ($error['code'] != 0) {
                    error_log("Database error: " . print_r($error, true));
                }
                
                if (!$new_id) {
                    throw new Exception("Failed to insert product ID $product_id into destination warehouse. DB Error: " . $error['message']);
                }
            }
            
            // Calculate value
            $total_value += ($product_details['product_price'] ?? 0) * $quantity;
            
            // 3. Add transfer item
            $item_data = [
                'tid' => $transfer_data['invocieno'],
                'pid' => $product_id,
                'qty' => $quantity,
                'product_name' => $product_details['product_name'] ?? '',
                'product_code' => $product_details['product_code'] ?? ''
            ];
            $this->db->insert('geopos_stock_transfer_items', $item_data);
            
            // 4. Log movements
            $movement1 = [
                'd_type' => 1,
                'rid1' => $product_id,
                'rid2' => -$quantity,
                'rid3' => $transfer_data['from_warehouse'],
                'note' => "Transferred to $to_name",
                'd_time' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('geopos_movers', $movement1);
            
            $movement2 = [
                'd_type' => 1,
                'rid1' => $product_id,
                'rid2' => $quantity,
                'rid3' => $transfer_data['to_warehouse'],
                'note' => "Received from $from_name",
                'd_time' => date('Y-m-d H:i:s')
            ];
            $this->db->insert('geopos_movers', $movement2);
        }
        
        // Update total
        $this->db->where('id', $transfer_id);
        $this->db->update('geopos_stock_transfer', ['total' => $total_value]);
        
        // Complete transaction
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            $error = $this->db->error();
            throw new Exception("Transaction failed: " . ($error['message'] ?? 'Unknown error'));
        }
        
        error_log("=== Transfer completed successfully ===");
        
        return [
            'success' => true,
            'message' => 'Stock transfer completed successfully!',
            'transfer_id' => $transfer_id,
            'transfer_no' => $transfer_data['invocieno']
        ];
        
    } catch (Exception $e) {
        $this->db->trans_rollback();
        error_log("Transfer failed with error: " . $e->getMessage());
        return [
            'success' => false,
            'message' => $e->getMessage()
        ];
    }
}
    
    private function get_warehouse_name($warehouse_id)
    {
        $this->db->select('title');
        $this->db->where('id', $warehouse_id);
        $query = $this->db->get('geopos_warehouse');
        
        if ($query->num_rows() > 0) {
            return $query->row()->title;
        }
        
        return false;
    }
    
    private function log_movement($product_id, $quantity, $note, $warehouse_id = null)
    {
        $data = [
            'd_type' => 1,
            'rid1' => $product_id,
            'rid2' => $quantity,
            'rid3' => $warehouse_id ?: 0,
            'note' => $note,
            'd_time' => date('Y-m-d H:i:s')
        ];
        
        return $this->db->insert('geopos_movers', $data);
    }
    
    public function get_last_transfer_id()
    {
        $this->db->select_max('tid');
        $query = $this->db->get('geopos_stock_transfer');
        
        $result = $query->row();
        
        if ($result && $result->tid) {
            return intval($result->tid) + 1;
        }
        
        return 1000;
    }
    
    public function get_recent_transfers($limit = 5)
    {
        $this->db->select('*');
        $this->db->order_by('id', 'DESC');
        $this->db->limit($limit);
        $query = $this->db->get('geopos_stock_transfer');
        
        return $query->result_array();
    }
    
    public function get_warehouse_products_count($warehouse_id)
    {
        $this->db->where('warehouse', $warehouse_id);
        return $this->db->count_all_results('geopos_products');
    }
}