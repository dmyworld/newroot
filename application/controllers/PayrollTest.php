<?php
class PayrollTest extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function migrate_employees() {
        $query = "ALTER TABLE `geopos_employees` ADD COLUMN `bank_name` VARCHAR(100) NULL AFTER `dept`, ADD COLUMN `bank_ac` VARCHAR(50) NULL AFTER `bank_name`;";
        
        if (!$this->db->field_exists('bank_name', 'geopos_employees')) {
            if ($this->db->query($query)) {
                echo "Migration Successful: Added bank_name and bank_ac columns.";
            } else {
                echo "Migration Failed: " . $this->db->error()['message'];
            }
        } else {
            echo "Migration Skipped: Columns already exist.";
        }
    }
}
