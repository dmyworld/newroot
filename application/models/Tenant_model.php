<?php
/**
 * Tenant Model
 * handles initialization of isolated workspaces for new users.
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Tenant_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Initialize a full tenant environment
     */
    public function initialize_tenant($user_id, $username)
    {
        // 1. Create Location
        $loc_name = $username . "'s Office";
        $loc_id = $this->create_location($loc_name);

        if (!$loc_id) return false;

        // 2. Create Warehouse
        $warehouse_name = $username . "'s Warehouse";
        $wid = $this->create_warehouse($warehouse_name, $loc_id);

        if (!$wid) return $loc_id; // Return loc_id anyway so registration can proceed

        // 3. Clone Product Catalog (Zero Stock)
        // We clone products from the main warehouse (assumed ID 1) to the new tenant warehouse
        $this->clone_catalog(1, $wid);

        // 4. Create Basic Accounts
        $this->create_basic_accounts($loc_id, $username);

        return $loc_id;
    }

    private function create_location($name)
    {
        $data = array(
            'cname' => $name,
            'address' => 'Private',
            'city' => 'Private',
            'region' => 'Private',
            'country' => 'Sri Lanka',
            'postbox' => '00000',
            'phone' => '0000000000',
            'email' => 'private@tenant.com',
            'taxid' => '0',
            'logo' => 'logo.png',
            'ext' => 0,
            'cur' => 1, // Default Currency ID
            'ware' => 0 // Will update after warehouse creation
        );

        if ($this->db->insert('geopos_locations', $data)) {
            return $this->db->insert_id();
        }
        return false;
    }

    private function create_warehouse($name, $loc_id)
    {
        $data = array(
            'title' => $name,
            'extra' => 'Auto-generated for tenant',
            'loc' => $loc_id
        );

        if ($this->db->insert('geopos_warehouse', $data)) {
            $wid = $this->db->insert_id();
            // Update location with this warehouse
            $this->db->where('id', $loc_id);
            $this->db->update('geopos_locations', array('ware' => $wid));
            return $wid;
        }
        return false;
    }

    private function clone_catalog($source_wid, $target_wid)
    {
        // Get all products from source warehouse
        $this->db->where('warehouse', $source_wid);
        $query = $this->db->get('geopos_products');
        $products = $query->result_array();

        if (empty($products)) return;

        $batch = array();
        foreach ($products as $p) {
            unset($p['pid']); // Let the DB generate new IDs
            $p['warehouse'] = $target_wid;
            $p['qty'] = 0; // Fresh start with zero stock
            
            // If product_code must be unique, we might need a prefix
            // However, if the system doesn't enforce global uniqueness in code, we are fine.
            // Usually in multi-location ERPs, codes can be the same if we filter by loc.
            
            $batch[] = $p;
            
            // Insert in chunks to avoid memory/SQL limits
            if (count($batch) >= 100) {
                $this->db->insert_batch('geopos_products', $batch);
                $batch = array();
            }
        }

        if (!empty($batch)) {
            $this->db->insert_batch('geopos_products', $batch);
        }
    }

    private function create_basic_accounts($loc_id, $username)
    {
        $accounts = array(
            array(
                'acn' => 'CASH-' . strtoupper($username),
                'holder' => $username,
                'adate' => date('Y-m-d H:i:s'),
                'lastbal' => 0,
                'code' => 'CASH',
                'note' => 'Default Cash Account',
                'loc' => $loc_id
            ),
            array(
                'acn' => 'BANK-' . strtoupper($username),
                'holder' => $username,
                'adate' => date('Y-m-d H:i:s'),
                'lastbal' => 0,
                'code' => 'BANK',
                'note' => 'Default Bank Account',
                'loc' => $loc_id
            )
        );

        $this->db->insert_batch('geopos_accounts', $accounts);
    }
}
