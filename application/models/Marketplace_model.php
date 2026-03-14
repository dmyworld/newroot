<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketplace_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_check_tables();
    }

    private function _check_tables()
    {
        if (!$this->db->table_exists('geopos_marketplace_requests')) {
            $this->load->dbforge();
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'user_id' => array('type' => 'INT', 'constraint' => 11),
                'title' => array('type' => 'VARCHAR', 'constraint' => 255),
                'description' => array('type' => 'TEXT'),
                'budget' => array('type' => 'DECIMAL', 'constraint' => '10,2', 'default' => '0.00'),
                'location' => array('type' => 'VARCHAR', 'constraint' => 255),
                'status' => array('type' => 'ENUM("active", "closed")', 'default' => 'active'),
                'created_at' => array('type' => 'DATETIME', 'default' => NULL)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_marketplace_requests', TRUE);
             $this->db->query("ALTER TABLE `geopos_marketplace_requests` CHANGE `created_at` `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
        }

        if (!$this->db->table_exists('geopos_workers')) {
            $this->load->dbforge();
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'name' => array('type' => 'VARCHAR', 'constraint' => 255),
                'category' => array('type' => 'VARCHAR', 'constraint' => 100),
                'phone' => array('type' => 'VARCHAR', 'constraint' => 20),
                'hourly_rate' => array('type' => 'DECIMAL', 'constraint' => '10,2', 'default' => '0.00'),
                'rating' => array('type' => 'DECIMAL', 'constraint' => '3,2', 'default' => '5.00'),
                'loc' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
                'status' => array('type' => 'ENUM("online", "offline")', 'default' => 'online'),
                'created_at' => array('type' => 'DATETIME', 'default' => NULL)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_workers', TRUE);
            $this->db->query("ALTER TABLE `geopos_workers` CHANGE `created_at` `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
            
            // Seed some data for bundling demo
            $this->db->insert_batch('geopos_workers', [
                ['name' => 'Amila Transport', 'category' => 'Transport', 'hourly_rate' => 1500, 'rating' => 4.8],
                ['name' => 'Sunil Sawing', 'category' => 'Sawing', 'hourly_rate' => 2000, 'rating' => 4.9],
                ['name' => 'Kamal Masonry', 'category' => 'Masonry', 'hourly_rate' => 1800, 'rating' => 4.7],
                ['name' => 'Nimal Painting', 'category' => 'Painting', 'hourly_rate' => 1200, 'rating' => 4.6]
            ]);
        }

        // Direct Buy Workflow Migrations
        $fields = array(
            'transport_cost' => array('type' => 'DECIMAL', 'constraint' => '10,2', 'default' => '0.00'),
            'buyer_remarks' => array('type' => 'TEXT', 'default' => NULL),
            'seller_phone_visible' => array('type' => 'ENUM("yes", "no")', 'default' => 'no'),
            'buyer_phone_visible' => array('type' => 'ENUM("yes", "no")', 'default' => 'no')
        );

        $this->load->dbforge();
        foreach ($fields as $key => $field) {
            if (!$this->db->field_exists($key, 'geopos_timber_bids')) {
                $this->dbforge->add_column('geopos_timber_bids', array($key => $field));
            }
        }
    }

    public function get_active_lots($type = null)
    {
        if ($type == 'logs') {
            $this->db->where('status', 'available');
            return $this->db->get('geopos_timber_logs')->result_array();
        } elseif ($type == 'standing') {
            $this->db->where('status', 'available');
            return $this->db->get('geopos_timber_standing')->result_array();
        } elseif ($type == 'sawn') {
            $this->db->where('status', 'available');
            return $this->db->get('geopos_timber_sawn')->result_array();
        }
        
        // Default to logs for now
        return $this->db->get('geopos_timber_logs')->result_array();
    }

    /**
     * Get all active lots from all timber tables
     */
    public function get_all_active_lots()
    {
        $all_lots = [];
        
        // Get logs
        if ($this->db->table_exists('geopos_timber_logs')) {
            $logs = $this->db->where('status', 'available')->get('geopos_timber_logs')->result_array();
            foreach ($logs as &$log) {
                $log['lot_type'] = 'logs';
                $log['type'] = 'logs';
                $log['seller_id'] = $log['seller_id'] ?? $log['cid'] ?? 0;
                $log['seller_name'] = $this->_get_username($log['seller_id']);
            }
            $all_lots = array_merge($all_lots, $logs);
        }
        
        // Get standing
        if ($this->db->table_exists('geopos_timber_standing')) {
            $standing = $this->db->where('status', 'available')->get('geopos_timber_standing')->result_array();
            foreach ($standing as &$tree) {
                $tree['lot_type'] = 'standing';
                $tree['type'] = 'standing';
                $tree['seller_id'] = $tree['seller_id'] ?? $tree['cid'] ?? 0;
                $tree['seller_name'] = $this->_get_username($tree['seller_id']);
            }
            $all_lots = array_merge($all_lots, $standing);
        }
        
        // Get sawn
        if ($this->db->table_exists('geopos_timber_sawn')) {
            $sawn = $this->db->where('status', 'available')->get('geopos_timber_sawn')->result_array();
            foreach ($sawn as &$plank) {
                $plank['lot_type'] = 'sawn';
                $plank['type'] = 'sawn';
                $plank['seller_id'] = $plank['seller_id'] ?? $plank['cid'] ?? 0;
                $plank['seller_name'] = $this->_get_username($plank['seller_id']);
            }
            $all_lots = array_merge($all_lots, $sawn);
        }

        // Get machinery (Placeholder or from geopos_products if tagged)
        if ($this->db->table_exists('geopos_timber_machinery')) {
            $machinery = $this->db->where('status', 'available')->get('geopos_timber_machinery')->result_array();
            foreach ($machinery as &$item) {
                $item['lot_type'] = 'machinery';
                $item['type'] = 'machinery';
                $item['seller_id'] = $item['seller_id'] ?? $item['cid'] ?? 0;
                $item['seller_name'] = $this->_get_username($item['seller_id']);
            }
            $all_lots = array_merge($all_lots, $machinery);
        }
        
        return $all_lots;
    }

    /**
     * Get featured listings
     */
    public function get_featured_listings($limit = 5)
    {
        $featured = [];
        
        // Get featured logs
        $logs = $this->db->where('featured', 1)->where('status', 'available')->limit($limit)->get('geopos_timber_logs')->result_array();
        foreach ($logs as &$log) {
            $log['type'] = 'logs';
        }
        $featured = array_merge($featured, $logs);
        
        // Get featured standing if needed
        if (count($featured) < $limit) {
            $standing = $this->db->where('featured', 1)->where('status', 'available')->limit($limit - count($featured))->get('geopos_timber_standing')->result_array();
            foreach ($standing as &$tree) {
                $tree['type'] = 'standing';
            }
            $featured = array_merge($featured, $standing);
        }
        
        // Get featured sawn if needed
        if (count($featured) < $limit) {
            $sawn = $this->db->where('featured', 1)->where('status', 'available')->limit($limit - count($featured))->get('geopos_timber_sawn')->result_array();
            foreach ($sawn as &$plank) {
                $plank['type'] = 'sawn';
            }
            $featured = array_merge($featured, $sawn);
        }
        
        return $featured;
    }

    public function get_lot_details($id, $type)
    {
        $table_map = [
            'logs' => 'geopos_timber_logs',
            'standing' => 'geopos_timber_standing',
            'sawn' => 'geopos_timber_sawn',
            'machinery' => 'geopos_timber_machinery'
        ];
        $table = $table_map[$type] ?? 'geopos_timber_logs';
        
        $this->db->where('id', $id);
        $header = $this->db->get($table)->row_array();

        if ($type == 'logs') {
            $this->db->where('log_id', $id);
            $header['items'] = $this->db->get('geopos_timber_log_items')->result_array();
        }

        // Get latest bid
        $this->db->where('lot_id', $id);
        $this->db->where('lot_type', $type);
        $this->db->order_by('bid_amount', 'DESC');
        $header['latest_bid'] = $this->db->get('geopos_timber_bids')->row_array();

        return $header;
    }

    public function place_bid($lot_id, $lot_type, $buyer_id, $amount)
    {
        // Check if bid is higher than current
        $this->db->where('lot_id', $lot_id);
        $this->db->where('lot_type', $lot_type);
        $this->db->order_by('bid_amount', 'DESC');
        $current = $this->db->get('geopos_timber_bids')->row_array();

        if ($current && $amount <= $current['bid_amount']) {
            return array('status' => 'Error', 'message' => 'Bid must be higher than ' . $current['bid_amount']);
        }

        $data = array(
            'lot_id' => $lot_id,
            'lot_type' => $lot_type,
            'buyer_id' => $buyer_id,
            'bid_amount' => $amount
        );

        if ($this->db->insert('geopos_timber_bids', $data)) {
            return array('status' => 'Success', 'message' => 'Bid placed successfully!');
        }
        return array('status' => 'Error', 'message' => 'Failed to place bid.');
    }

    public function get_latest_bid($lot_id, $lot_type)
    {
        $this->db->where('lot_id', $lot_id);
        $this->db->where('lot_type', $lot_type);
        $this->db->order_by('bid_amount', 'DESC');
        return $this->db->get('geopos_timber_bids')->row_array();
    }

    public function send_buy_request($lot_id, $lot_type, $buyer_id, $items = null, $offered_price = 0, $remarks = '')
    {
        // 1. Check if already requested
        $this->db->where('lot_id', $lot_id);
        $this->db->where('lot_type', $lot_type);
        $this->db->where('buyer_id', $buyer_id);
        $this->db->where_in('status', ['pending', 'approved', 'measured']);
        $exists = $this->db->get('geopos_timber_bids')->row_array();
        
        if($exists) {
            return array('status' => 'Error', 'message' => 'You already have an active request for this lot.');
        }

        // 2. Get Lot Price if not offered
        if($offered_price <= 0) {
            $lot = $this->get_lot_details($lot_id, $lot_type);
            $offered_price = $lot['direct_price'] > 0 ? $lot['direct_price'] : 0; // Fallback
        }

        $data = array(
            'lot_id' => $lot_id,
            'lot_type' => $lot_type,
            'buyer_id' => $buyer_id,
            'bid_amount' => $offered_price,
            'buyer_remarks' => $remarks,
            'status' => 'pending',
            'bid_time' => date('Y-m-d H:i:s')
        );

        if ($this->db->insert('geopos_timber_bids', $data)) {
            return array('status' => 'Success', 'message' => 'Buy request sent! Waiting for seller approval.');
        }
        return array('status' => 'Error', 'message' => 'Failed to send request.');
    }

    public function approve_buy_request($bid_id)
    {
        // Revealing phone numbers
        $data = array(
            'status' => 'approved',
            'seller_phone_visible' => 'yes',
            'buyer_phone_visible' => 'yes'
        );
        
        $this->db->where('id', $bid_id);
        if($this->db->update('geopos_timber_bids', $data)) {
            // Hide lot from public ? Maybe not yet until Deal Agreed. 
            // User requirement: "Seller post with list... Buyer clicks buy... Seller approves... Phone numbers shown"
            // At this stage, it's just contact establishment.
            return array('status' => 'Success', 'message' => 'Request approved. Contact details are now visible to the buyer.');
        }
        return array('status' => 'Error', 'message' => 'Failed to approve request.');
    }

    public function finalize_deal_with_transport($bid_id, $transport_cost, $final_total)
    {
        // This is the "Seller adds amount and finalizes" step
        $data = array(
            'transport_cost' => $transport_cost,
            'bid_amount' => $final_total - $transport_cost, // Adjust base price if needed, or total is just stored differently. 
            // Actually, bid_amount is usually the item price. Final Total = bid_amount + transport_cost.
            // Let's assume input is separate.
            'status' => 'sold',
            'seller_agreement' => 1,
            'buyer_agreement' => 1 // Assuming this step is final confirmation
        );

        $this->db->where('id', $bid_id);
        if($this->db->update('geopos_timber_bids', $data)) {
            
            // Trigger Sales Logic
            $bid = $this->db->get_where('geopos_timber_bids', array('id' => $bid_id))->row_array();
            
            // Update Lot Status
            $table = ($bid['lot_type'] == 'logs') ? 'geopos_timber_logs' : (($bid['lot_type'] == 'standing') ? 'geopos_timber_standing' : 'geopos_timber_sawn');
            $this->db->where('id', $bid['lot_id']);
            $this->db->update($table, array('status' => 'sold'));

            // Record & ERP
            $this->_record_sale_transaction($bid);
            $this->_intake_to_erp($bid);

            return array('status' => 'Success', 'message' => 'Deal Finalized! Purchase Order created.');
        }
        return array('status' => 'Error', 'message' => 'Failed to finalize deal.');
    }

    public function get_my_bids($buyer_id)
    {
        $this->db->select('b.*, 
            COALESCE(l.lot_name, s.lot_name, sn.lot_name) as lot_title,
            e.phone as seller_phone, u.email as seller_email'); // Fetch seller contact
        $this->db->from('geopos_timber_bids b');
        $this->db->join('geopos_timber_logs l', 'b.lot_id = l.id AND b.lot_type = "logs"', 'left');
        $this->db->join('geopos_timber_standing s', 'b.lot_id = s.id AND b.lot_type = "standing"', 'left');
        $this->db->join('geopos_timber_sawn sn', 'b.lot_id = sn.id AND b.lot_type = "sawn"', 'left');
        
        // Join Seller User and Employee to get contact info correctly
        $this->db->join('geopos_users u', 'l.seller_id = u.id OR s.seller_id = u.id OR sn.seller_id = u.id', 'left');
        $this->db->join('geopos_employees e', 'u.id = e.id', 'left');

        $this->db->where('b.buyer_id', $buyer_id);
        $this->db->order_by('b.bid_time', 'DESC');
        return $this->db->get()->result_array();
    }

    public function get_incoming_bids($seller_id)
    {
        $this->db->select('b.*, 
            COALESCE(l.lot_name, s.lot_name, sn.lot_name) as lot_name, 
            u.username as buyer_name, e.phone as buyer_phone, u.email as buyer_email');
        $this->db->from('geopos_timber_bids b');
        $this->db->join('geopos_timber_logs l', 'b.lot_id = l.id AND b.lot_type = "logs"', 'left');
        $this->db->join('geopos_timber_standing s', 'b.lot_id = s.id AND b.lot_type = "standing"', 'left');
        $this->db->join('geopos_timber_sawn sn', 'b.lot_id = sn.id AND b.lot_type = "sawn"', 'left');
        $this->db->join('geopos_users u', 'b.buyer_id = u.id');
        $this->db->join('geopos_employees e', 'u.id = e.id', 'left');
        
        // Seller filter must check all possible owner IDs
        $this->db->group_start();
        $this->db->where('l.seller_id', $seller_id);
        $this->db->or_where('s.seller_id', $seller_id);
        $this->db->or_where('sn.seller_id', $seller_id);
        $this->db->group_end();
        $this->db->order_by('b.bid_time', 'DESC');
        return $this->db->get()->result_array();
    }

    private function _intake_to_erp($bid)
    {
        $this->load->model('products_model', 'products');
        
        // 1. Get Lot Details
        $lot = $this->get_lot_details($bid['lot_id'], $bid['lot_type']);
        
        // 2. Map to Product
        $product_name = "[Marketplace] " . $lot['lot_name'];
        $product_code = $bid['lot_type'] . '-' . $lot['id'];
        
        // Piece count -> qty, Cubic volume -> qty2
        $piece_count = isset($lot['items']) ? count($lot['items']) : 1;
        $cubic_volume = $lot['total_cubic_feet'];

        // Default constraints (can be refined)
        $cat_id = 1; // General
        $warehouse_id = 1; // Default
        
        // Try to find buyer's warehouse if possible
        $this->db->select('loc');
        $this->db->where('id', $bid['buyer_id']);
        $u = $this->db->get('geopos_users')->row_array();
        if ($u && $u['loc'] > 0) {
            $this->db->select('id');
            $this->db->where('loc', $u['loc']);
            $w = $this->db->get('geopos_warehouse')->row_array();
            if ($w) $warehouse_id = $w['id'];
        }

        // 3. Create Product in ERP
        $this->products->addnew(
            $cat_id, 
            $warehouse_id, 
            $product_name, 
            $product_code, 
            $bid['bid_amount'], // Price
            0, // Factory Price
            0, // Tax
            0, // Discount
            $piece_count, // qty
            0, // Alert Qty
            "Marketplace Lot Acquisition: " . $lot['lot_name'], 
            'timber_default.jpg', 
            'Piece', 
            '', // Barcode
            0, // V Type
            0, // V Stock
            0, // V Alert
            date('Y-m-d'), // Date
            'EAN13', // Code type
            '', '', '', '', '', // Optional fields
            0, 0, // Width, Thickness
            $cubic_volume, // product_quick (qty2)
            $product_code // product_quick_code
        );
    }
    public function buy_now($lot_id, $lot_type, $buyer_id)
    {
        $table = ($lot_type == 'logs') ? 'geopos_timber_logs' : (($lot_type == 'standing') ? 'geopos_timber_standing' : 'geopos_timber_sawn');
        $this->db->where('id', $lot_id);
        $lot = $this->db->get($table)->row_array();

        if (!$lot || $lot['direct_price'] <= 0) {
            return array('status' => 'Error', 'message' => 'Direct buy not available for this lot');
        }

        // Create a bid that is already finalized
        $data = array(
            'lot_id' => $lot_id,
            'lot_type' => $lot_type,
            'buyer_id' => $buyer_id,
            'bid_amount' => $lot['direct_price'],
            'status' => 'sold',
            'buyer_agreement' => 1,
            'seller_agreement' => 1
        );
        $this->db->insert('geopos_timber_bids', $data);
        $bid_id = $this->db->insert_id();

        // Update lot status
        $this->db->where('id', $lot_id);
        $this->db->update($table, array('status' => 'sold'));

        // Record transaction
        $bid = $this->db->get_where('geopos_timber_bids', array('id' => $bid_id))->row_array();
        $this->_record_sale_transaction($bid);
        $this->_intake_to_erp($bid);

        return array('status' => 'Success', 'message' => 'Lot purchased successfully!', 'bid_id' => $bid_id);
    }

    public function split_lot($parent_id, $lot_type, $selected_items, $buyer_id, $price)
    {
        $this->db->trans_start();
        $table = ($lot_type == 'logs') ? 'geopos_timber_logs' : (($lot_type == 'standing') ? 'geopos_timber_standing' : 'geopos_timber_sawn');
        $items_table = ($lot_type == 'logs') ? 'geopos_timber_log_items' : (($lot_type == 'standing') ? 'geopos_timber_standing_items' : 'geopos_timber_sawn_items');
        $id_field = ($lot_type == 'logs') ? 'log_id' : (($lot_type == 'standing') ? 'standing_id' : 'sawn_id');

        // 1. Get Parent Lot
        $this->db->where('id', $parent_id);
        $parent = $this->db->get($table)->row_array();

        // 2. Create Child Lot for the sale
        $child = $parent;
        unset($child['id'], $child['created_at']);
        $child['lot_name'] .= ' (Partial)';
        $child['parent_lot_id'] = $parent_id;
        $child['status'] = 'sold';
        $child['total_cubic_feet'] = 0; // Will update
        $this->db->insert($table, $child);
        $child_id = $this->db->insert_id();

        // 3. Move items to child and update volumes
        $moved_volume = 0;
        foreach ($selected_items as $item_id) {
            $this->db->where('id', $item_id);
            $item = $this->db->get($items_table)->row_array();
            if ($item) {
                $moved_volume += $item['cubic_feet'];
                $this->db->where('id', $item_id);
                $this->db->update($items_table, array($id_field => $child_id));
            }
        }

        // 4. Update Volumes
        $this->db->where('id', $child_id);
        $this->db->update($table, array('total_cubic_feet' => $moved_volume));

        $remaining_volume = $parent['total_cubic_feet'] - $moved_volume;
        $this->db->where('id', $parent_id);
        $this->db->update($table, array('total_cubic_feet' => $remaining_volume));

        // 5. Create final bid for child
        $data = array(
            'lot_id' => $child_id,
            'lot_type' => $lot_type,
            'buyer_id' => $buyer_id,
            'bid_amount' => $price,
            'status' => 'sold',
            'buyer_agreement' => 1,
            'seller_agreement' => 1
        );
        $this->db->insert('geopos_timber_bids', $data);
        $bid_id = $this->db->insert_id();

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return array('status' => 'Error', 'message' => 'Transaction failed');
        }

        // Record finance
        $bid = $this->db->get_where('geopos_timber_bids', array('id' => $bid_id))->row_array();
        $this->_record_sale_transaction($bid);
        $this->_intake_to_erp($bid);

        return array('status' => 'Success', 'message' => 'Partial purchase successful!', 'child_id' => $child_id);
    }

    private function _record_sale_transaction($bid)
    {
        $this->db->where('id', 70);
        $config = $this->db->get('univarsal_api')->row_array();

        if ($config && $config['key1'] > 0 && $config['url'] > 0) {
            $this->load->model('transactions_model', 'transactions');
            
            $table = ($bid['lot_type'] == 'logs') ? 'geopos_timber_logs' : (($bid['lot_type'] == 'standing') ? 'geopos_timber_standing' : 'geopos_timber_sawn');
            $this->db->where('id', $bid['lot_id']);
            $lot = $this->db->get($table)->row_array();
            $lot_name = $lot ? $lot['lot_name'] : 'Lot #' . $bid['lot_id'];

            $note = "Timber Sale: " . $lot_name . " (" . ucfirst($bid['lot_type']) . ")";
        
            $amount = $bid['bid_amount']; // Base amount for commission calculation
            $commission_rate = 0.05; // 5%
            $commission_amount = $amount * $commission_rate;
            $seller_amount = $amount - $commission_amount;

            // Account IDs from univarsal_api
            $bank_account_id = $config['key1']; // Debit (Bank/Cash)
            $sales_income_account_id = $config['url']; // Credit (Sales Income)
            $commission_income_account_id = 7; // Commission Account
            $setup_fee_account_id = 8; // Setup Fee Account

            $user_loc = $bid['loc'] ?? 0;

            // Collect Setup Fee if not already collected for this lot
            $this->collect_setup_fee($bid['lot_id'], $bid['lot_type'], $user_loc);
            // Record the Commission Deduction (Debit Sales Income / Credit Commission Account)
            $this->transactions->add_double_entry(
                $sales_income_account_id, // Debit Account (Sales Income)
                $commission_income_account_id, // Credit Account (Commission Income)
                $commission_amount,
                "Marketplace Commission (5%) - Lot #" . $bid['lot_id'],
                $bid['buyer_id'],
                $this->_get_username($bid['buyer_id']),
                'Marketplace Commission',
                'Marketplace',
                date('Y-m-d H:i:s'),
                $user_loc,
                0,
                $bid['id']
            );

            // Record the Total Sale (Debit Bank)
            $this->transactions->add_double_entry(
                $bank_account_id, // Debit Account (Bank)
                $sales_income_account_id, // Credit Account (Sales Income - Gross)
                $amount, // Full bid amount
                "Marketplace Sale - Lot #" . $bid['lot_id'], // Note
                $bid['buyer_id'], // Payer ID
                $this->_get_username($bid['buyer_id']), // Payer Name
                'Timber Sale', // Category
                'Marketplace', // Method
                date('Y-m-d H:i:s'), // Date
                $user_loc, // Loc
                0, // Ext (0=Customer)
                $bid['id'] // Link ID
            );
        }
    }

    private function _get_username($id)
    {
        $this->db->select('username');
        $this->db->where('id', $id);
        $q = $this->db->get('geopos_users')->row_array();
        return $q ? $q['username'] : 'Marketplace Buyer';
    }

    // --- Enterprise Extension Data Methods ---

    public function get_hardware_products($limit = 12)
    {
        $this->db->select('p.*, c.title as category_name');
        $this->db->from('geopos_products p');
        $this->db->join('geopos_product_cat c', 'p.pcat = c.id', 'left');
        // Filter for hardware-like categories if possible, or just all products for now
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_open_job_requests($limit = 10)
    {
        $this->db->select('j.*, c.name as customer_name');
        $this->db->from('geopos_job_requests j');
        $this->db->join('geopos_customers c', 'j.customer_id = c.id', 'left');
        $this->db->where('j.status', 'open');
        $this->db->order_by('j.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function smart_search($query)
    {
        $results = [];
        $query = $this->db->escape_like_str($query);

        // 1. Search Timber
        $timber = $this->get_all_active_lots();
        foreach ($timber as $t) {
            $name = ($t['species'] ?? '') . ' ' . ($t['lot_name'] ?? '');
            if (stripos($name, $query) !== false) {
                $t['result_type'] = 'timber';
                $results[] = $t;
            }
        }

        // 2. Search Hardware
        $this->db->select('p.*, "hardware" as result_type');
        $this->db->from('geopos_products p');
        $this->db->like('product_name', $query);
        $this->db->limit(10);
        $hardware = $this->db->get()->result_array();
        $results = array_merge($results, $hardware);

        // 3. Search Workforce (geopos_employees as pros)
        $this->db->select('e.*, "pro" as result_type');
        $this->db->from('geopos_employees e');
        $this->db->like('name', $query);
        $this->db->limit(10);
        $pros = $this->db->get()->result_array();
        $results = array_merge($results, $pros);

        return $results;
    }

    // --- Buyer Request Methods ---

    public function create_request($data)
    {
        if ($this->db->insert('geopos_marketplace_requests', $data)) {
            return array('status' => 'Success', 'message' => 'Request posted successfully!');
        }
        return array('status' => 'Error', 'message' => 'Failed to post request.');
    }

    public function get_active_requests($limit = 10, $start = 0, $location = null)
    {
        $this->db->select('r.*, u.username');
        $this->db->from('geopos_marketplace_requests r');
        $this->db->join('geopos_users u', 'r.user_id = u.id');
        $this->db->where('r.status', 'active');
        
        if ($location) {
            $this->db->like('r.location', $location);
        }
        
        $this->db->order_by('r.created_at', 'DESC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result_array();
    }

    public function get_requests_by_user($user_id)
    {
        $this->db->where('user_id', $user_id);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('geopos_marketplace_requests')->result_array();
    }
    public function collect_setup_fee($lot_id, $lot_type, $loc = 0)
    {
        // Logic to collect a one-time setup fee (e.g., $1000) for a marketplace listing
        // We check metadata to see if it's already collected
        $this->db->where('type', 20); // 20 = Marketplace Setup Fee
        $this->db->where('rid', $lot_id);
        $query = $this->db->get('geopos_metadata');

        if ($query->num_rows() == 0) {
            $setup_fee = 1000; // Fixed Setup Fee
            $setup_fee_account_id = 8;
            $bank_account_id = 1; // Default Bank

            $this->load->model('transactions_model', 'transactions');
            $this->transactions->add_double_entry(
                $bank_account_id,
                $setup_fee_account_id,
                $setup_fee,
                "Listing Setup Fee - Lot #$lot_id ($lot_type)",
                0, // Payer ID (System/Seller)
                'Marketplace',
                'Listing Fee',
                'Marketplace',
                date('Y-m-d H:i:s'),
                $loc
            );

            // Mark as collected
            $this->db->insert('geopos_metadata', array('type' => 20, 'rid' => $lot_id, 'col1' => 'Collected'));
        }
    }
}
