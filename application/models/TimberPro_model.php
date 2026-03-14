<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class TimberPro_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->dbforge();
        
        // Self-healing: Ensure photos table exists
        if (!$this->db->table_exists('geopos_timber_photos')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'lot_id' => array('type' => 'INT', 'constraint' => 11),
                'lot_type' => array('type' => 'VARCHAR', 'constraint' => 50),
                'photo' => array('type' => 'VARCHAR', 'constraint' => 255),
                'created_at' => array('type' => 'DATETIME', 'null' => TRUE)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_timber_photos');
        }

        // Phase 19: Schema Updates for Dual Pricing
        $timber_tables = ['geopos_timber_standing', 'geopos_timber_logs', 'geopos_timber_sawn', 'geopos_timber_machinery'];
        foreach ($timber_tables as $table) {
            if ($this->db->table_exists($table)) {
                if (!$this->db->field_exists('selling_price', $table)) {
                    $this->dbforge->add_column($table, [
                        'selling_price' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00']
                    ]);
                }
                if (!$this->db->field_exists('total_price', $table)) {
                    $this->dbforge->add_column($table, [
                        'total_price' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00']
                    ]);
                }
            }
        }

        // Model C specific: unit_type
        if ($this->db->table_exists('geopos_timber_sawn')) {
            if (!$this->db->field_exists('unit_type', 'geopos_timber_sawn')) {
                $this->dbforge->add_column('geopos_timber_sawn', [
                    'unit_type' => ['type' => 'VARCHAR', 'constraint' => '20', 'default' => 'cubic_ft']
                ]);
            }
        }

        // Standardize total_cubic_feet column
        $vol_tables = ['geopos_timber_standing', 'geopos_timber_sawn'];
        foreach ($vol_tables as $table) {
            if ($this->db->table_exists($table) && !$this->db->field_exists('total_cubic_feet', $table)) {
                $this->dbforge->add_column($table, [
                    'total_cubic_feet' => ['type' => 'DECIMAL', 'constraint' => '15,4', 'default' => '0.0000']
                ]);
            }
        }

        // Phase 20: Districts and Row-level pricing
        $main_tables = ['geopos_timber_standing', 'geopos_timber_logs', 'geopos_timber_sawn', 'geopos_timber_machinery'];
        foreach ($main_tables as $table) {
            if ($this->db->table_exists($table) && !$this->db->field_exists('district', $table)) {
                $this->dbforge->add_column($table, [
                    'district' => ['type' => 'VARCHAR', 'constraint' => '50', 'default' => '']
                ]);
            }
        }

        $item_tables = ['geopos_timber_standing_items', 'geopos_timber_log_items', 'geopos_timber_sawn_items'];
        foreach ($item_tables as $table) {
            if ($this->db->table_exists($table)) {
                if (!$this->db->field_exists('unit_price', $table)) {
                    $this->dbforge->add_column($table, [
                        'unit_price' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00']
                    ]);
                }
                if (!$this->db->field_exists('subtotal', $table)) {
                    $this->dbforge->add_column($table, [
                        'subtotal' => ['type' => 'DECIMAL', 'constraint' => '15,2', 'default' => '0.00']
                    ]);
                }
            }
        }

        // Model D specific: qty
        if ($this->db->table_exists('geopos_timber_machinery')) {
            if (!$this->db->field_exists('qty', 'geopos_timber_machinery')) {
                $this->dbforge->add_column('geopos_timber_machinery', [
                    'qty' => ['type' => 'INT', 'constraint' => '11', 'default' => '1']
                ]);
            }
        }

        // Standardize seller_id and loc columns
        foreach ($main_tables as $table) {
            if ($this->db->table_exists($table)) {
                // 1. Handle seller_id (with legacy 'cid' migration)
                if (!$this->db->field_exists('seller_id', $table)) {
                    if ($this->db->field_exists('cid', $table)) {
                        $this->db->query("ALTER TABLE `$table` CHANGE `cid` `seller_id` INT(11) DEFAULT '0'");
                    } else {
                        $this->dbforge->add_column($table, [
                            'seller_id' => ['type' => 'INT', 'constraint' => '11', 'default' => '0']
                        ]);
                    }
                }
                // 2. Handle 'loc' (Business Location)
                if (!$this->db->field_exists('loc', $table)) {
                    $this->dbforge->add_column($table, [
                        'loc' => ['type' => 'INT', 'constraint' => '11', 'default' => '0']
                    ]);
                }
            }
        }

        // Phase 21: Enterprise Expansion Tables
        
        // 1. Log Purchasing
        if (!$this->db->table_exists('geopos_timber_purchase')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'p_date' => array('type' => 'DATE'),
                'vendor_id' => array('type' => 'INT', 'constraint' => 11),
                'species' => array('type' => 'VARCHAR', 'constraint' => 100),
                'qty' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
                'unit' => array('type' => 'VARCHAR', 'constraint' => 20, 'default' => 'cubic_ft'),
                'price_per_unit' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
                'total_amount' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
                'loc' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
                'status' => array('type' => 'ENUM("pending","received","cancelled")', 'default' => 'pending'),
                'created_at' => array('type' => 'DATETIME', 'null' => TRUE)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_timber_purchase');
        }

        // 2. Sawmill Processing
        if (!$this->db->table_exists('geopos_timber_sawmill')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'process_date' => array('type' => 'DATE'),
                'source_lot_type' => array('type' => 'VARCHAR', 'constraint' => 50),
                'source_lot_id' => array('type' => 'INT', 'constraint' => 11),
                'input_qty' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
                'output_qty' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
                'slabs_qty' => array('type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0),
                'wastage' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
                'operator_id' => array('type' => 'INT', 'constraint' => 11),
                'loc' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
                'created_at' => array('type' => 'DATETIME', 'null' => TRUE)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_timber_sawmill');
        } else {
            // Self-healing: add slabs_qty if missing
            if (!$this->db->field_exists('slabs_qty', 'geopos_timber_sawmill')) {
                $this->dbforge->add_column('geopos_timber_sawmill', array(
                    'slabs_qty' => array('type' => 'DECIMAL', 'constraint' => '15,2', 'default' => 0)
                ));
            }
        }
    
        // 3. Logistics Fleet
        if (!$this->db->table_exists('geopos_logistics_fleet')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'vehicle_no' => array('type' => 'VARCHAR', 'constraint' => 50),
                'vehicle_type' => array('type' => 'VARCHAR', 'constraint' => 50),
                'driver_name' => array('type' => 'VARCHAR', 'constraint' => 100),
                'driver_phone' => array('type' => 'VARCHAR', 'constraint' => 30),
                'capacity' => array('type' => 'VARCHAR', 'constraint' => 50),
                'loc' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
                'status' => array('type' => 'ENUM("active","maintenance","inactive")', 'default' => 'active'),
                'created_at' => array('type' => 'DATETIME', 'null' => TRUE)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_logistics_fleet');
        }

        // 4. Logistics Orders
        if (!$this->db->table_exists('geopos_logistics_orders')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'order_id' => array('type' => 'INT', 'constraint' => 11),
                'vehicle_id' => array('type' => 'INT', 'constraint' => 11),
                'pickup_loc' => array('type' => 'VARCHAR', 'constraint' => 255),
                'delivery_loc' => array('type' => 'VARCHAR', 'constraint' => 255),
                'status' => array('type' => 'ENUM("dispatched","in_transit","delivered","returned")', 'default' => 'dispatched'),
                'loc' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
                'created_at' => array('type' => 'DATETIME', 'null' => TRUE)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_logistics_orders');
        }

        // 5. Job Requests (Workforce/Services)
        if (!$this->db->table_exists('geopos_job_requests')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'customer_id' => array('type' => 'INT', 'constraint' => 11),
                'job_title' => array('type' => 'VARCHAR', 'constraint' => 200),
                'description' => array('type' => 'TEXT'),
                'district' => array('type' => 'VARCHAR', 'constraint' => 50),
                'budget' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
                'status' => array('type' => 'ENUM("open","assigned","completed","closed")', 'default' => 'open'),
                'loc' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
                'created_at' => array('type' => 'DATETIME', 'null' => TRUE)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_job_requests');
        }

        // 6. Byproducts (Slabs/Offcuts)
        if (!$this->db->table_exists('geopos_timber_byproducts')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'job_id' => array('type' => 'INT', 'constraint' => 11),
                'product_name' => array('type' => 'VARCHAR', 'constraint' => 100, 'default' => 'Slabs'),
                'qty' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
                'warehouse_id' => array('type' => 'INT', 'constraint' => 11),
                'loc' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
                'status' => array('type' => 'ENUM("available","sold","used")', 'default' => 'available'),
                'created_at' => array('type' => 'DATETIME', 'null' => TRUE)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_timber_byproducts');
        }

        // 7. Stock Transfers
        if (!$this->db->table_exists('geopos_timber_transfers')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'lot_type' => array('type' => 'ENUM("log","sawn")', 'default' => 'log'),
                'lot_id' => array('type' => 'INT', 'constraint' => 11),
                'from_loc' => array('type' => 'INT', 'constraint' => 11),
                'to_loc' => array('type' => 'INT', 'constraint' => 11),
                'request_qty' => array('type' => 'DECIMAL', 'constraint' => '15,2'),
                'status' => array('type' => 'ENUM("pending","on_way","completed","cancelled")', 'default' => 'pending'),
                'requested_by' => array('type' => 'INT', 'constraint' => 11),
                'approved_by' => array('type' => 'INT', 'constraint' => 11, 'null' => TRUE),
                'created_at' => array('type' => 'DATETIME', 'null' => TRUE),
                'updated_at' => array('type' => 'DATETIME', 'null' => TRUE)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_timber_transfers');
        }

        // 8. Wood Types
        if (!$this->db->table_exists('geopos_timber_wood_types')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'name' => array('type' => 'VARCHAR', 'constraint' => 100),
                'code' => array('type' => 'VARCHAR', 'constraint' => 20, 'null' => TRUE),
                'created_at' => array('type' => 'DATETIME', 'null' => TRUE)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_timber_wood_types');
            
            // Seed defaults
            $defaults = [['name' => 'Teak'], ['name' => 'Mahogany'], ['name' => 'Jack'], ['name' => 'Satinwood']];
            foreach ($defaults as $d) {
                $d['created_at'] = date('Y-m-d H:i:s');
                $this->db->insert('geopos_timber_wood_types', $d);
            }
        }

        // Phase 22: AI Ads & Video Showcases (Revid AI Integration)
        foreach ($main_tables as $table) {
            if ($this->db->table_exists($table) && !$this->db->field_exists('revid_video_url', $table)) {
                $this->dbforge->add_column($table, [
                    'revid_video_url' => ['type' => 'VARCHAR', 'constraint' => '255', 'default' => NULL, 'null' => TRUE]
                ]);
                $this->db->query("ALTER TABLE `$table` ADD INDEX (`revid_video_url`)");
            }
        }

        // Ensure Revid AI config slot exists
        $this->db->where('id', 13);
        $exists_revid = $this->db->get('geopos_config')->row_array();
        if (!$exists_revid) {
            $this->db->insert('geopos_config', array('id' => 13, 'fb_profile_id' => '', 'access_token' => ''));
        }
    }

    public function save_photos($lot_id, $lot_type, $photos)
    {
        if (empty($photos)) { error_log("save_photos: No photos provided."); return; }
        error_log("save_photos: Saving " . count($photos) . " photos for Lot $lot_id");

        foreach ($photos as $photo) {
            $data = array(
                'lot_id' => $lot_id,
                'lot_type' => $lot_type,
                'photo' => $photo,
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('geopos_timber_photos', $data);
        }
    }
    public function save_standing($lot_name, $warehouse_id, $location_gps, $items, $status = 'available', $photos = array(), $loc = null, $selling_price = 0, $total_price = 0, $district = '')
    {
        $this->db->trans_start();

        if (!$loc) $loc = $this->aauth->get_user() ? $this->aauth->get_user()->loc : 0;

        $header = array(
            'lot_name' => $lot_name,
            'seller_id' => $this->aauth->get_user() ? $this->aauth->get_user()->id : 0,
            'warehouse_id' => $warehouse_id,
            'location_gps' => $location_gps,
            'district' => $district,
            'selling_price' => (float)$selling_price,
            'total_price' => (float)$total_price,
            'status' => $status,
            'loc' => $loc
        );

        $this->db->insert('geopos_timber_standing', $header);
        $standing_id = $this->db->insert_id();

        $total_cubic_feet = 0;
        if (is_array($items)) {
            foreach ($items as $item) {
                // (girth/4)^2 * height / 144
                $girth = (float)($item['circumference_avg'] ?? 0);
                $height = (float)($item['height_avg'] ?? $item['est_height'] ?? 0);
                $count = (float)($item['tree_count'] ?? 1);
                
                $v = (pow($girth / 4, 2) * $height) / 144 * $count;
                $total_cubic_feet += $v;
                
                $data = array(
                    'standing_id' => $standing_id,
                    'product_id' => $item['product_id'],
                    'tree_count' => $count,
                    'circumference_avg' => $girth,
                    'est_height' => $height,
                    'unit_price' => (float)($item['unit_price'] ?? 0),
                    'subtotal' => (float)($item['subtotal'] ?? 0)
                );
                $this->db->insert('geopos_timber_standing_items', $data);
            }
        }
        
        // Update header with total volume
        $this->db->where('id', $standing_id)->update('geopos_timber_standing', ['total_cubic_feet' => $total_cubic_feet]);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return array('status' => 'Error', 'message' => 'Failed to save standing trees.');
        } else {
            $this->save_photos($standing_id, 'standing', $photos);
            return array('status' => 'Success', 'message' => 'Standing Trees lot saved successfully.', 'lot_id' => $standing_id);
        }
    }

    public function save_logs($lot_name, $warehouse_id, $logs, $location_gps = null, $status = 'available', $photos = array(), $loc = null, $selling_price = 0, $total_price = 0, $district = '')
    {
        $this->db->trans_start();

        if (!$loc) $loc = $this->aauth->get_user() ? $this->aauth->get_user()->loc : 0;

        $total_cubic_feet = 0;
        if (is_array($logs)) {
            foreach ($logs as $log) {
                $v = ((float)$log['girth'] / 4) ** 2 * (float)$log['length'] / 144;
                $total_cubic_feet += $v;
            }
        }

        $header = array(
            'lot_name' => $lot_name,
            'seller_id' => $this->aauth->get_user() ? $this->aauth->get_user()->id : 0,
            'warehouse_id' => $warehouse_id,
            'total_cubic_feet' => $total_cubic_feet,
            'selling_price' => (float)$selling_price,
            'total_price' => (float)$total_price,
            'location_gps' => $location_gps,
            'district' => $district,
            'status' => $status,
            'loc' => $loc
        );

        $this->db->insert('geopos_timber_logs', $header);
        $log_id = $this->db->insert_id();

        if (is_array($logs)) {
            foreach ($logs as $log) {
                $v = ((float)$log['girth'] / 4) ** 2 * (float)$log['length'] / 144;
                $item = array(
                    'log_id' => $log_id,
                    'length' => (float)$log['length'],
                    'girth' => (float)$log['girth'],
                    'cubic_feet' => $v,
                    'unit_price' => (float)($log['unit_price'] ?? 0),
                    'subtotal' => (float)($log['subtotal'] ?? 0)
                );
                $this->db->insert('geopos_timber_log_items', $item);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return array('status' => 'Error', 'message' => 'Failed to save logs.');
        } else {
            // Record Transaction
            $this->_record_timber_transaction($log_id, 'logs', $total_cubic_feet, 'Logs Acquisition: ' . $lot_name);
            $this->save_photos($log_id, 'logs', $photos);
            return array('status' => 'Success', 'message' => 'Logs saved successfully. Total: ' . number_format($total_cubic_feet, 4) . ' ft3', 'lot_id' => $log_id);
        }
    }

    public function save_sawn($lot_name, $warehouse_id, $location_gps, $items, $status = 'available', $photos = array(), $loc = null, $unit_type = 'cubic_ft', $selling_price = 0, $total_price = 0, $district = '')
    {
        $this->db->trans_start();

        if (!$loc) $loc = $this->aauth->get_user() ? $this->aauth->get_user()->loc : 0;

        $total_cubic_feet = 0;
        if (is_array($items)) {
            foreach ($items as $item) {
                $v = ((float)$item['width'] * (float)$item['thickness'] * (float)$item['length']) / 12 * (float)$item['quantity'];
                $total_cubic_feet += $v;
            }
        }

        $header = array(
            'lot_name' => $lot_name,
            'seller_id' => $this->aauth->get_user() ? $this->aauth->get_user()->id : 0,
            'warehouse_id' => $warehouse_id,
            'total_cubic_feet' => $total_cubic_feet,
            'unit_type' => $unit_type,
            'selling_price' => (float)$selling_price,
            'total_price' => (float)$total_price,
            'location_gps' => $location_gps,
            'district' => $district,
            'status' => $status,
            'loc' => $loc
        );

        $this->db->insert('geopos_timber_sawn', $header);
        $sawn_id = $this->db->insert_id();

        if (is_array($items)) {
            foreach ($items as $item) {
                $v = ((float)$item['width'] * (float)$item['thickness'] * (float)$item['length']) / 12 * (float)$item['quantity'];
                $data = array(
                    'sawn_id' => $sawn_id,
                    'wood_type_id' => $item['wood_type_id'],
                    'width' => (float)$item['width'],
                    'thickness' => (float)$item['thickness'],
                    'length' => (float)$item['length'],
                    'quantity' => (float)$item['quantity'],
                    'cubic_feet' => $v,
                    'unit_price' => (float)($item['unit_price'] ?? 0),
                    'subtotal' => (float)($item['subtotal'] ?? 0)
                );
                $this->db->insert('geopos_timber_sawn_items', $data);
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return array('status' => 'Error', 'message' => 'Failed to save sawn timber.');
        } else {
            // Record Transaction
            $this->_record_timber_transaction($sawn_id, 'sawn', $total_cubic_feet, 'Sawn Timber Acquisition: ' . $lot_name);
            $this->save_photos($sawn_id, 'sawn', $photos);
            return array('status' => 'Success', 'message' => 'Sawn Timber lot saved. Total: ' . number_format($total_cubic_feet, 4) . ' ft3', 'lot_id' => $sawn_id);
        }
    }

    public function save_machinery($item_name, $specs, $warehouse_id, $location_gps, $status = 'available', $photos = array(), $loc = null, $qty = 1, $selling_price = 0, $total_price = 0, $district = '')
    {
        if (!$loc) $loc = $this->aauth->get_user() ? $this->aauth->get_user()->loc : 0;

        $data = array(
            'item_name' => $item_name,
            'specs' => $specs,
            'seller_id' => $this->aauth->get_user() ? $this->aauth->get_user()->id : 0,
            'warehouse_id' => $warehouse_id,
            'location_gps' => $location_gps,
            'district' => $district,
            'qty' => (float)$qty,
            'selling_price' => (float)$selling_price,
            'total_price' => (float)$total_price,
            'status' => $status,
            'loc' => $loc
        );

        if ($this->db->insert('geopos_timber_machinery', $data)) {
            $lot_id = $this->db->insert_id();
            $this->save_photos($lot_id, 'machinery', $photos);
            return array('status' => 'Success', 'message' => 'Machinery asset saved successfully.', 'lot_id' => $lot_id);
        } else {
            return array('status' => 'Error', 'message' => 'Failed to save machinery.');
        }
    }

    public function get_log_details($id)
    {
        $this->db->select('*');
        $this->db->from('geopos_timber_logs');
        $this->db->where('id', $id);
        $header = $this->db->get()->row_array();

        $this->db->select('*');
        $this->db->from('geopos_timber_log_items');
        $this->db->where('log_id', $id);
        $items = $this->db->get()->result_array();

        return array('header' => $header, 'items' => $items);
    }

    /**
     * Bulk save logs from array (e.g. from CSV parser)
     */
    public function bulk_save_logs($lot_name, $warehouse_id, $logs, $location_gps = null, $loc = null)
    {
        return $this->save_logs($lot_name, $warehouse_id, $logs, $location_gps, 'available', array(), $loc);
    }

    /**
     * Bulk save sawn timber from array
     */
    public function bulk_save_sawn($lot_name, $warehouse_id, $items, $location_gps = null, $loc = null)
    {
        return $this->save_sawn($lot_name, $warehouse_id, $location_gps, $items, 'available', array(), $loc);
    }

    private function _record_timber_transaction($target_id, $type, $volume, $note, $price_per_unit = 0)
    {
        $this->db->where('id', 70);
        $config = $this->db->get('univarsal_api')->row_array();

        if ($config && $config['key2'] > 0 && $config['url'] > 0) {
            $inventory_acc = $config['key2'];
            $purchase_acc = $config['url'];
            
            // If price_per_unit is not provided, try to estimate from calculator model if loaded
            if ($price_per_unit <= 0 && $this->load->is_loaded('Timber_Calculator_model')) {
                $estimate = $this->Timber_Calculator_model->estimate_market_price($volume, 'default', 'cubic_ft');
                $price_per_unit = $estimate['price_per_unit'];
            }

            $amount = $volume * $price_per_unit;
            $full_note = $note . " (Volume: " . number_format($volume, 4) . " ft3 @ " . number_format($price_per_unit, 2) . ")";
            
            $user_id = $this->aauth->get_user() ? $this->aauth->get_user()->id : 0;
            $user_loc = $this->aauth->get_user() ? $this->aauth->get_user()->loc : 0;

            // Debit Inventory (Asset Increase)
            $this->db->insert('geopos_transactions', array(
                'acid' => $inventory_acc,
                'account' => $this->_get_acc_name($inventory_acc),
                'type' => 'Income',
                'cat' => 'Purchase',
                'debit' => $amount,
                'credit' => 0,
                'payer' => 'TimberPro internal',
                'date' => date('Y-m-d H:i:s'),
                'eid' => $user_id,
                'tid' => $target_id,
                'note' => $full_note,
                'ext' => 2,
                'loc' => $user_loc
            ));
            
            // Credit Purchase/Cash (Asset Decrease or Liability Increase)
            $this->db->insert('geopos_transactions', array(
                'acid' => $purchase_acc,
                'account' => $this->_get_acc_name($purchase_acc),
                'type' => 'Expense',
                'cat' => 'Purchase',
                'debit' => 0,
                'credit' => $amount,
                'payer' => 'TimberPro internal',
                'date' => date('Y-m-d H:i:s'),
                'eid' => $user_id,
                'tid' => $target_id,
                'note' => $full_note,
                'ext' => 2,
                'loc' => $user_loc
            ));

            // Update balances
            $this->db->set('lastbal', "lastbal+$amount", FALSE);
            $this->db->where('id', $inventory_acc);
            $this->db->update('geopos_accounts');

            $this->db->set('lastbal', "lastbal-$amount", FALSE);
            $this->db->where('id', $purchase_acc);
            $this->db->update('geopos_accounts');
        }
    }

    private function _get_acc_name($id)
    {
        $this->db->select('holder');
        $this->db->where('id', $id);
        $q = $this->db->get('geopos_accounts')->row_array();
        return $q ? $q['holder'] : 'Unknown';
    }


    public function get_dashboard_stats($loc = 0)
    {
        $stats = array();

        // 1. Standing Trees Stats
        $this->db->select('COUNT(*) as total_lots');
        $this->_apply_loc_filter($loc);
        $results = $this->db->get('geopos_timber_standing')->row_array();
        $stats['standing'] = $results ? $results : array('total_lots' => 0);

        // 2. Logs Stats
        $this->db->select('COUNT(*) as total_lots, SUM(total_cubic_feet) as total_volume');
        $this->_apply_loc_filter($loc);
        $results = $this->db->get('geopos_timber_logs')->row_array();
        $stats['logs'] = $results ? $results : array('total_lots' => 0, 'total_volume' => 0);

        // 3. Sawn Timber Stats
        $this->db->select('COUNT(*) as total_lots, SUM(total_cubic_feet) as total_volume');
        $this->_apply_loc_filter($loc);
        $results = $this->db->get('geopos_timber_sawn')->row_array();
        $stats['sawn'] = $results ? $results : array('total_lots' => 0, 'total_volume' => 0);

        // 4. Marketplace Activity (Buyer Requests)
        $this->db->select('COUNT(*) as total_requests');
        $results = $this->db->get('geopos_marketplace_requests')->row_array();
        $stats['requests'] = $results ? $results : array('total_requests' => 0);

        // 5. Total Active Bids
        $this->db->select('COUNT(*) as total_bids');
        $results = $this->db->get('geopos_timber_bids')->row_array();
        $stats['bids'] = $results ? $results : array('total_bids' => 0);

        return $stats;
    }

    // --- Enterprise Phase 2 Logic ---

    /**
     * Records a raw log purchase from a vendor
     */
    public function add_log_purchase($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        if ($this->db->insert('geopos_timber_purchase', $data)) {
            $purchase_id = $this->db->insert_id();

            // Automate stock intake into geopos_timber_logs if status is 'received'
            if ($data['status'] == 'received') {
                $log_data = array(
                    'species' => $data['species'],
                    'total_cubic_feet' => $data['qty'],
                    'price' => $data['total_amount'],
                    'loc' => $data['loc'],
                    'status' => 'available',
                    'seller_id' => 0, // Internal purchase
                    'type' => 'logs',
                    'created_at' => $data['created_at']
                );
                $this->db->insert('geopos_timber_logs', $log_data);
            }
            return $purchase_id;
        }
        return false;
    }

    public function get_logs_at_location($loc = 0)
    {
        $this->_apply_loc_filter($loc);
        $this->db->where('status', 'available');
        return $this->db->get('geopos_timber_logs')->result_array();
    }

    /**
     * Sawmill Operation Logic
     */
    public function add_sawmill_job($data, $items = array(), $lot_name = '', $warehouse_id = 0)
    {
        $this->db->trans_start();
        
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->db->insert('geopos_timber_sawmill', $data);
        $job_id = $this->db->insert_id();
        
        // 1. Deduct from source lot
        if ($data['source_lot_type'] == 'logs') {
            $this->db->set('total_cubic_feet', "total_cubic_feet - " . (float)$data['input_qty'], FALSE);
            $this->db->where('id', $data['source_lot_id']);
            $this->db->update('geopos_timber_logs');
        }
        
        // 2. Create Sawn Lot
        if (!empty($items) && $lot_name && $warehouse_id) {
            $this->save_sawn($lot_name, $warehouse_id, null, $items, 'available', array(), $data['loc']);
        }

        // 3. Create Slab record if exists
        if (isset($data['slabs_qty']) && (float)$data['slabs_qty'] > 0) {
            $byproduct = array(
                'job_id' => $job_id,
                'product_name' => 'Slabs (Sawing Job #' . $job_id . ')',
                'qty' => (float)$data['slabs_qty'],
                'warehouse_id' => $warehouse_id,
                'loc' => $data['loc'],
                'status' => 'available',
                'created_at' => date('Y-m-d H:i:s')
            );
            $this->db->insert('geopos_timber_byproducts', $byproduct);
        }
        
        $this->db->trans_complete();
        
        if ($this->db->trans_status() === FALSE) {
            return false;
        }
        
        return $job_id;
    }

    public function get_sawmill_jobs($loc = 0)
    {
        $this->_apply_loc_filter($loc);
        $this->db->order_by('created_at', 'DESC');
        return $this->db->get('geopos_timber_sawmill')->result_array();
    }

    public function initiate_transfer($data)
    {
        $data['created_at'] = date('Y-m-d H:i:s');
        return $this->db->insert('geopos_timber_transfers', $data);
    }

    public function transfer_lot($transfer_id)
    {
        $this->db->trans_start();
        
        $transfer = $this->db->get_where('geopos_timber_transfers', array('id' => $transfer_id))->row_array();
        if (!$transfer) return false;

        $table = ($transfer['lot_type'] == 'log') ? 'geopos_timber_logs' : 'geopos_timber_sawn';
        
        // Update lot location
        $this->db->where('id', $transfer['lot_id']);
        $this->db->update($table, array('loc' => $transfer['to_loc']));

        // Update transfer status
        $this->db->where('id', $transfer_id);
        $this->db->update('geopos_timber_transfers', array(
            'status' => 'completed',
            'approved_by' => $this->aauth->get_user()->id,
            'updated_at' => date('Y-m-d H:i:s')
        ));

        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_global_inventory()
    {
        $this->db->select('loc, SUM(total_cubic_feet) as vol')->group_by('loc');
        $this->_apply_loc_filter();
        $logs = $this->db->get('geopos_timber_logs')->result_array();

        $this->db->select('loc, SUM(total_cubic_feet) as vol')->group_by('loc');
        $this->_apply_loc_filter();
        $sawn = $this->db->get('geopos_timber_sawn')->result_array();
        
        return array('logs' => $logs, 'sawn' => $sawn);
    }

    private function _apply_loc_filter($loc = 0)
    {
        if ($this->aauth->get_user()->roleid == 1) {
            if ($loc > 0) {
                $this->db->where('loc', $loc);
            }
        } else {
            if ($this->aauth->get_user()->loc) {
                $this->db->where('loc', $this->aauth->get_user()->loc);
            } elseif (!BDATA) {
                $this->db->where('loc', 0);
            }
        }
    }
}
