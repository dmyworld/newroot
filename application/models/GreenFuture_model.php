<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Green Future Model
 * Section 11: CSR — Donations, Tree Planting (with Certificates), Maintenance Fund
 */
class GreenFuture_model extends CI_Model
{
    const T_FUND        = 'tp_donation_fund';
    const T_PLANT       = 'tp_tree_planting_requests';
    const T_PAYOUT      = 'tp_tree_maintenance_payouts';
    const T_MAINTENANCE = 'tp_maintenance_requests';

    public function __construct()
    {
        parent::__construct();
        $this->_ensure_tables();
    }

    private function _ensure_tables()
    {
        // Core donation fund table
        if (!$this->db->table_exists(self::T_FUND)) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `" . self::T_FUND . "` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `donor_user_id` INT UNSIGNED DEFAULT 0,
                `amount` DECIMAL(12,2) NOT NULL DEFAULT 0,
                `donation_type` ENUM('manual','invoice_percent','event') DEFAULT 'manual',
                `invoice_id` INT UNSIGNED DEFAULT NULL,
                `invoice_percent` DECIMAL(5,2) DEFAULT NULL,
                `fund_balance_before` DECIMAL(14,2) DEFAULT 0,
                `fund_balance_after` DECIMAL(14,2) DEFAULT 0,
                `note` TEXT,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX(`donor_user_id`), INDEX(`donation_type`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        // Tree planting requests table (with certificate columns)
        if (!$this->db->table_exists(self::T_PLANT)) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `" . self::T_PLANT . "` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `requested_by` INT UNSIGNED NOT NULL,
                `province` VARCHAR(100) DEFAULT NULL,
                `district` VARCHAR(100) NOT NULL,
                `grama_niladhari_cert` VARCHAR(255) DEFAULT NULL,
                `sabhapathi_cert` VARCHAR(255) DEFAULT NULL,
                `location_type` ENUM('roadside','paddy_field','other') DEFAULT 'other',
                `tree_species` VARCHAR(100) NOT NULL,
                `trees_requested` INT NOT NULL DEFAULT 0,
                `trees_planted` INT DEFAULT 0,
                `cost_per_tree` DECIMAL(10,2) DEFAULT 150.00,
                `total_cost` DECIMAL(12,2) DEFAULT 0,
                `funded_from_donation` TINYINT(1) DEFAULT 1,
                `status` ENUM('pending','approved','planted','rejected') DEFAULT 'pending',
                `admin_note` TEXT,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
                INDEX(`requested_by`), INDEX(`status`), INDEX(`district`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        } else {
            // Add missing columns if table already existed
            $cols = $this->db->query("SHOW COLUMNS FROM `" . self::T_PLANT . "`")->result_array();
            $existing = array_column($cols, 'Field');
            $add = [];
            if (!in_array('grama_niladhari_cert', $existing)) $add[] = "ADD COLUMN `grama_niladhari_cert` VARCHAR(255) DEFAULT NULL";
            if (!in_array('sabhapathi_cert', $existing))       $add[] = "ADD COLUMN `sabhapathi_cert` VARCHAR(255) DEFAULT NULL";
            if (!in_array('location_type', $existing))         $add[] = "ADD COLUMN `location_type` ENUM('roadside','paddy_field','other') DEFAULT 'other'";
            if (!in_array('trees_planted', $existing))         $add[] = "ADD COLUMN `trees_planted` INT DEFAULT 0";
            if (!in_array('admin_note', $existing))            $add[] = "ADD COLUMN `admin_note` TEXT";
            if (!in_array('updated_at', $existing))            $add[] = "ADD COLUMN `updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP";
            if (!empty($add)) {
                $this->db->query("ALTER TABLE `" . self::T_PLANT . "` " . implode(', ', $add));
            }
        }

        // Tree maintenance payouts table
        if (!$this->db->table_exists(self::T_PAYOUT)) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `" . self::T_PAYOUT . "` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `planting_request_id` INT UNSIGNED NOT NULL,
                `landowner_user_id` INT UNSIGNED DEFAULT 0,
                `payout_type` VARCHAR(50) DEFAULT 'monthly',
                `amount` DECIMAL(12,2) NOT NULL,
                `payment_method` VARCHAR(50) DEFAULT 'bank_transfer',
                `status` ENUM('pending','paid','cancelled') DEFAULT 'pending',
                `paid_at` DATETIME,
                `note` TEXT,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                INDEX(`planting_request_id`), INDEX(`landowner_user_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }

        // Maintenance fund applications (photo-verified monthly stipend)
        if (!$this->db->table_exists(self::T_MAINTENANCE)) {
            $this->db->query("CREATE TABLE IF NOT EXISTS `" . self::T_MAINTENANCE . "` (
                `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                `planting_request_id` INT UNSIGNED DEFAULT NULL,
                `applicant_user_id` INT UNSIGNED DEFAULT 0,
                `applicant_name` VARCHAR(150) NOT NULL,
                `applicant_phone` VARCHAR(30),
                `applicant_address` TEXT,
                `province` VARCHAR(100),
                `district` VARCHAR(100),
                `location_description` TEXT,
                `tree_count` INT DEFAULT 0,
                `photo_path` VARCHAR(255),
                `bank_name` VARCHAR(100),
                `bank_account_no` VARCHAR(50),
                `bank_branch` VARCHAR(100),
                `monthly_amount` DECIMAL(10,2) DEFAULT 1500.00,
                `status` ENUM('pending','verified','paid','rejected') DEFAULT 'pending',
                `verified_by` INT UNSIGNED DEFAULT NULL,
                `verified_at` DATETIME,
                `paid_at` DATETIME,
                `admin_note` TEXT,
                `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
                `updated_at` DATETIME ON UPDATE CURRENT_TIMESTAMP,
                INDEX(`applicant_user_id`), INDEX(`status`), INDEX(`district`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
        }
    }

    // ── FUND BALANCE ──────────────────────────────────────────────────────────

    public function get_fund_balance()
    {
        $row = $this->db->select_sum('amount')->get(self::T_FUND)->row_array();
        return $row['amount'] ?: 0;
    }

    public function get_fund_balance_breakdown()
    {
        $manual  = $this->db->where('donation_type', 'manual')->select_sum('amount')->get(self::T_FUND)->row_array()['amount'] ?: 0;
        $invoice = $this->db->where('donation_type', 'invoice_percent')->select_sum('amount')->get(self::T_FUND)->row_array()['amount'] ?: 0;
        $payouts = $this->db->select_sum('amount')->get(self::T_PAYOUT)->row_array()['amount'] ?: 0;
        $maint   = $this->db->where('status', 'paid')->select_sum('monthly_amount')->get(self::T_MAINTENANCE)->row_array()['monthly_amount'] ?: 0;
        return compact('manual', 'invoice', 'payouts', 'maint');
    }

    // ── STATS ─────────────────────────────────────────────────────────────────

    public function get_stats()
    {
        $total_planted        = $this->db->select_sum('trees_planted')->get(self::T_PLANT)->row_array()['trees_planted'] ?: 0;
        $total_requested      = $this->db->select_sum('trees_requested')->get(self::T_PLANT)->row_array()['trees_requested'] ?: 0;
        $total_donors         = $this->db->count_all(self::T_FUND);
        $total_payouts        = $this->db->select_sum('amount')->get(self::T_PAYOUT)->row_array()['amount'] ?: 0;
        $pending_plantings    = $this->db->where('status', 'pending')->count_all_results(self::T_PLANT);
        $maintenance_active   = $this->db->where('status', 'verified')->count_all_results(self::T_MAINTENANCE);
        $invoice_donations    = $this->db->where('donation_type', 'invoice_percent')->select_sum('amount')->get(self::T_FUND)->row_array()['amount'] ?: 0;
        return compact('total_planted', 'total_requested', 'total_donors', 'total_payouts',
                       'pending_plantings', 'maintenance_active', 'invoice_donations');
    }

    // ── DONATIONS ─────────────────────────────────────────────────────────────

    public function get_recent_donors($limit = 5)
    {
        return $this->db->order_by('created_at', 'DESC')->limit($limit)->get(self::T_FUND)->result_array();
    }

    public function get_all_donors($limit = 50)
    {
        return $this->db->order_by('created_at', 'DESC')->limit($limit)->get(self::T_FUND)->result_array();
    }

    public function get_all_donors_v2($limit = 50, $user_id = 0)
    {
        if ($user_id) $this->db->where('donor_user_id', $user_id);
        return $this->db->order_by('created_at', 'DESC')->limit($limit)->get(self::T_FUND)->result_array();
    }

    public function add_donation($data)
    {
        return $this->db->insert(self::T_FUND, $data);
    }

    /**
     * Called when an invoice is finalized — donates percent% of invoice total to the fund
     */
    public function record_invoice_donation($invoice_id, $invoice_total, $percent, $user_id)
    {
        $amount         = round($invoice_total * ($percent / 100), 2);
        $balance_before = $this->get_fund_balance();
        return $this->add_donation([
            'donor_user_id'       => $user_id,
            'amount'              => $amount,
            'donation_type'       => 'invoice_percent',
            'invoice_id'          => $invoice_id,
            'invoice_percent'     => $percent,
            'fund_balance_before' => $balance_before,
            'fund_balance_after'  => $balance_before + $amount,
            'note'                => "Auto-donated {$percent}% of Invoice #{$invoice_id}",
            'created_at'          => date('Y-m-d H:i:s'),
        ]);
    }

    // ── PLANTING REQUESTS ─────────────────────────────────────────────────────

    public function get_recent_planting($limit = 10)
    {
        return $this->db->order_by('created_at', 'DESC')->limit($limit)->get(self::T_PLANT)->result_array();
    }

    public function get_all_planting($filters = [])
    {
        if (!empty($filters['status']))   $this->db->where('status', $filters['status']);
        if (!empty($filters['district'])) $this->db->where('district', $filters['district']);
        if (!empty($filters['province'])) $this->db->where('province', $filters['province']);
        return $this->db->order_by('created_at', 'DESC')->get(self::T_PLANT)->result_array();
    }

    public function get_planting($id)
    {
        return $this->db->where('id', $id)->get(self::T_PLANT)->row_array();
    }

    public function add_planting_request($data)
    {
        $this->db->insert(self::T_PLANT, $data);
        return $this->db->insert_id();
    }

    public function update_planting($id, $data)
    {
        return $this->db->where('id', $id)->update(self::T_PLANT, $data);
    }

    public function save_certificate($id, $field, $path)
    {
        return $this->db->where('id', $id)->update(self::T_PLANT, [$field => $path]);
    }

    // ── PAYOUTS ───────────────────────────────────────────────────────────────

    public function add_payout($data)
    {
        return $this->db->insert(self::T_PAYOUT, $data);
    }

    public function get_payouts_for($planting_id)
    {
        return $this->db->where('planting_request_id', $planting_id)->get(self::T_PAYOUT)->result_array();
    }

    // ── MAINTENANCE FUND ──────────────────────────────────────────────────────

    public function get_all_maintenance($status = '', $user_id = 0)
    {
        if ($status) $this->db->where('status', $status);
        if ($user_id) $this->db->where('applicant_user_id', $user_id);
        return $this->db->order_by('created_at', 'DESC')->get(self::T_MAINTENANCE)->result_array();
    }

    public function get_maintenance($id)
    {
        return $this->db->where('id', $id)->get(self::T_MAINTENANCE)->row_array();
    }

    public function add_maintenance_request($data)
    {
        $this->db->insert(self::T_MAINTENANCE, $data);
        return $this->db->insert_id();
    }

    public function update_maintenance($id, $data)
    {
        return $this->db->where('id', $id)->update(self::T_MAINTENANCE, $data);
    }

    public function verify_maintenance($id, $admin_user_id, $amount = null)
    {
        $upd = [
            'status'      => 'verified',
            'verified_by' => $admin_user_id,
            'verified_at' => date('Y-m-d H:i:s'),
        ];
        if ($amount) $upd['monthly_amount'] = $amount;
        return $this->db->where('id', $id)->update(self::T_MAINTENANCE, $upd);
    }

    public function pay_maintenance($id)
    {
        return $this->db->where('id', $id)->update(self::T_MAINTENANCE, [
            'status'  => 'paid',
            'paid_at' => date('Y-m-d H:i:s'),
        ]);
    }

    // ── INVOICE DONATION SETTINGS ─────────────────────────────────────────────

    public function get_invoice_donation_percent()
    {
        if (!$this->db->table_exists('system_settings')) return 0;
        $row = $this->db->where('skey', 'green_invoice_percent')->get('system_settings')->row_array();
        return $row ? (float)$row['svalue'] : 0;
    }

    public function set_invoice_donation_percent($percent)
    {
        if (!$this->db->table_exists('system_settings')) return false;
        $exists = $this->db->where('skey', 'green_invoice_percent')->count_all_results('system_settings');
        if ($exists) {
            return $this->db->where('skey', 'green_invoice_percent')->update('system_settings', ['svalue' => $percent]);
        } else {
            return $this->db->insert('system_settings', ['skey' => 'green_invoice_percent', 'svalue' => $percent]);
        }
    }
}
