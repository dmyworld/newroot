<?php
/**
 * D Business Solutions  -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Dashan Korala Hewage. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@dmyworld.com
 *  Website: https://www.dmyworld.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from D My World, Please read the full License from
 *  * here- https://dmyworld.com/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Setup_chart_of_accounts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->model('accounts_model');
        $this->load->model('locations_model');
    }

    public function index()
    {
        echo "<h1>Setting up Chart of Accounts...</h1>";

        // 0. Update Schema
        if (!$this->db->field_exists('dual_acid', 'geopos_trans_cat')) {
            $this->db->query("ALTER TABLE `geopos_trans_cat` ADD COLUMN `dual_acid` INT(11) DEFAULT '0'");
            echo "Column 'dual_acid' added to 'geopos_trans_cat'.<br>";
        }

        // 1. Setup Locations
        $head_office_id = $this->get_or_create_location('Head Office', 'Main Address');
        $branch_01_id = $this->get_or_create_location('Branch 01', 'Branch Address');

        echo "Head Office ID: $head_office_id<br>";
        echo "Branch 01 ID: $branch_01_id<br><hr>";

        // 2. Define Accounts
        $accounts = [
            // Income Accounts (Common - Location 0)
            ['Income', 'Timber Sales Income', 'Timber Sales Income', 0],
            ['Income', 'General Sales', 'Standard sales income', 0],
            ['Income', 'Service Income / Transport Charges', 'Income from transport', 0],
            ['Income', 'Asset Sales', 'Income from selling assets', 0],
            ['Income', 'Miscellaneous Income', 'Other income sources', 0],

            // Expense Accounts (Operating - Common - Location 0)
            ['Expenses', 'Purchases', 'Timber purchase cost', 0],
            ['Expenses', 'Electricity Expense', 'Electricity bill', 0],
            ['Expenses', 'Water Expense', 'Water bill', 0],
            ['Expenses', 'Rent Expense', 'Building rent', 0],
            ['Expenses', 'Telephone & Internet', 'Communication cost', 0],
            ['Expenses', 'Insurance Expense', 'Business insurance', 0],

            // Expense Accounts (Personnel - Common - Location 0)
            ['Expenses', 'Salaries & Wages', 'Employee salaries', 0],
            ['Expenses', 'EPF/ETF Expenses', 'Employee funds', 0],

            // Expense Accounts (Other - Common - Location 0)
            ['Expenses', 'Transport & Fuel', 'Fuel and transport', 0],
            ['Expenses', 'Repairs & Maintenance', 'Machine/Vehicle repairs', 0],
            ['Expenses', 'Office Supplies & Stationery', 'Office supplies', 0],
            ['Expenses', 'Advertising', 'Advertising costs', 0],
            ['Expenses', 'Bank Charges', 'Monthly bank fees', 0],
            ['Expenses', 'Taxes & Licenses', 'Business taxes', 0],
            ['Expenses', 'Miscellaneous Expense', 'Other expenses', 0],

            // Asset Accounts (Specific Locations)
            ['Assets', 'Cash Account - Head Office', 'Cash at Head Office', $head_office_id],
            ['Assets', 'Cash Account - Branch 01', 'Cash at Branch 01', $branch_01_id],

            // Asset Accounts (Common - Location 0)
            ['Assets', 'Petty Cash', 'Daily small expenses', 0],
            ['Assets', 'Sampath Bank Account', 'Bank Account', 0],
            ['Assets', 'Inventory / Stock Account', 'Total Wood Stock Value', 0]
        ];

        foreach ($accounts as $acc) {
            $type = $acc[0];
            $name = $acc[1];
            $note = $acc[2];
            $loc = $acc[3];

            $this->create_account_if_not_exists($name, $type, $note, $loc);
        }
        echo "<hr>";

        // 3. Setup Transaction Categories & Dual Entry Mappings
        $cat_mappings = [
            'Timber Sales' => 'Timber Sales Income',
            'General Sales' => 'General Sales',
            'Service Income' => 'Service Income / Transport Charges',
            'Asset Sales' => 'Asset Sales',
            'Miscellaneous Income' => 'Miscellaneous Income',
            'Purchases' => 'Purchases',
            'Salaries' => 'Salaries & Wages',
            'EPF/ETF' => 'EPF/ETF Expenses',
            'Rent' => 'Rent Expense',
            'Electricity Bill' => 'Electricity Expense',
            'Water Bill' => 'Water Expense',
            'Communication' => 'Telephone & Internet',
            'Fuel' => 'Transport & Fuel',
            'Maintenance' => 'Repairs & Maintenance',
            'Stationery' => 'Office Supplies & Stationery',
            'Bank Charges' => 'Bank Charges',
            'Advertising' => 'Advertising',
            'Insurance' => 'Insurance Expense',
            'Taxes' => 'Taxes & Licenses',
            'Miscellaneous Expense' => 'Miscellaneous Expense'
        ];

        foreach ($cat_mappings as $cat_name => $acc_name) {
            $cat_id = $this->get_or_create_category($cat_name);
            $acc_query = $this->db->get_where('geopos_accounts', ['holder' => $acc_name, 'loc' => 0]);
            $acc = $acc_query->row();
            if ($acc) {
                $this->db->where('id', $cat_id);
                $this->db->update('geopos_trans_cat', ['dual_acid' => $acc->id]);
                echo "Mapped Category '$cat_name' to Account '$acc_name' (ID: {$acc->id})<br>";
            } else {
                 echo "Warning: Targeting Account '$acc_name' for category '$cat_name' not found.<br>";
            }
        }

        echo "<h3>Setup Complete!</h3>";
    }

    private function get_or_create_location($name, $address)
    {
        // Simple check by name
        $query = $this->db->get_where('geopos_locations', ['cname' => $name]);
        $row = $query->row();

        if ($row) {
            echo "Location '$name' found (ID: {$row->id})<br>";
            return $row->id;
        } else {
            // Create
            // create($name, $address, $city, $region, $country, $postbox, $phone, $email, $taxid, $image, $cur_id, $ac_id, $wid)
            // Using placeholder values for non-critical fields
            $this->locations_model->create($name, $address, 'City', 'Region', 'Country', '00000', '000-000-0000', 'email@example.com', 'TAXID', 'logo.png', 1, 0, 0);
            $id = $this->db->insert_id();
            echo "Location '$name' created (ID: $id)<br>";
            return $id;
        }
    }

    private function create_account_if_not_exists($holder, $type, $note, $loc)
    {
        // Check if exists
        $this->db->where('holder', $holder);
        $this->db->where('loc', $loc);
        $query = $this->db->get('geopos_accounts');

        if ($query->num_rows() > 0) {
            echo "Account '$holder' (Loc: $loc) already exists.<br>";
        } else {
            // Generate a simple account number (random for now to avoid collision, or sequential if possible)
            $accno = rand(100000, 999999); 
            $intbal = 0; // Initial balance 0

            // addnew($accno, $holder, $intbal, $acode, $lid, $account_type)
            // Note: addnew echoes json, which might mess up our simple output, but we can suppress or just let it be.
            // Ideally we'd use a silent version, but for a setup script, we will just call the model function.
            // Be aware addnew uses echo json_encode... so we might see JSON in the output.
            
            // To avoid JSON output cluttering too much, we could replicate the insert logic here, 
            // OR just accept the noise. Let's replicate logic for cleaner output and safety.
             $data = array(
                'acn' => $accno,
                'holder' => $holder,
                'adate' => date('Y-m-d H:i:s'),
                'lastbal' => $intbal,
                'code' => $note,
                'loc' => $loc,
                'account_type'=> $type
            );

            if ($this->db->insert('geopos_accounts', $data)) {
                 $id = $this->db->insert_id();
                 echo "Created Account: $holder (Type: $type, Loc: $loc, ID: $id)<br>";
                 // Also log?
                 $this->aauth->applog("[Account Created via Setup] $accno - $holder ID " . $id, $this->aauth->get_user()->username);
            } else {
                echo "Failed to create Account: $holder<br>";
            }
        }
    }

    private function get_or_create_category($name)
    {
        $query = $this->db->get_where('geopos_trans_cat', ['name' => $name]);
        $row = $query->row();
        if ($row) {
            return $row->id;
        } else {
            $this->db->insert('geopos_trans_cat', ['name' => $name]);
            return $this->db->insert_id();
        }
    }
}
