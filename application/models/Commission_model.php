<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Commission_model
 * Automated platform commission engine.
 * Records and tracks commission splits on every completed sale.
 *
 * Commission is sourced from:
 *  1. Category-level rate (geopos_labor_categories.commission_rate or geopos_product_categories.commission_rate)
 *  2. Business-level override (geopos_users.commission_rate)
 *  3. System-wide default (univarsal_api / settings table)
 */
class Commission_model extends CI_Model
{
    const DEFAULT_RATE = 3.00; // Default 3% commission

    public function __construct()
    {
        parent::__construct();
        $this->_ensure_schema();
    }

    // ─────────────────────────────────────────────
    // SCHEMA
    // ─────────────────────────────────────────────

    private function _ensure_schema()
    {
        if (!$this->db->table_exists('geopos_commissions')) {
            $this->db->query("CREATE TABLE `geopos_commissions` (
                `id`              INT(11) NOT NULL AUTO_INCREMENT,
                `invoice_id`      INT(11) NOT NULL,
                `business_id`     INT(11) NOT NULL DEFAULT '0',
                `seller_id`       INT(11) NOT NULL DEFAULT '0',
                `loc`             INT(11) NOT NULL DEFAULT '0',
                `invoice_total`   DECIMAL(19,4) NOT NULL DEFAULT '0.0000',
                `rate`            DECIMAL(6,3)  NOT NULL DEFAULT '3.000',
                `commission_amt`  DECIMAL(19,4) NOT NULL DEFAULT '0.0000',
                `seller_payout`   DECIMAL(19,4) NOT NULL DEFAULT '0.0000',
                `category`        VARCHAR(100)  DEFAULT NULL,
                `status`          ENUM('pending','settled','waived') NOT NULL DEFAULT 'pending',
                `settled_at`      DATETIME      DEFAULT NULL,
                `notes`           TEXT,
                `created_at`      TIMESTAMP     NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `invoice_id`  (`invoice_id`),
                KEY `business_id` (`business_id`),
                KEY `seller_id`   (`seller_id`),
                KEY `status`      (`status`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        }

        // Add commission_rate column to geopos_users if not present
        if (!$this->db->field_exists('commission_rate', 'geopos_users')) {
            $this->db->query("ALTER TABLE `geopos_users` ADD `commission_rate` DECIMAL(6,3) DEFAULT NULL COMMENT 'Override rate; NULL = use system default'");
        }
    }

    // ─────────────────────────────────────────────
    // RATE RESOLUTION (with priority chain)
    // ─────────────────────────────────────────────

    /**
     * Returns the effective commission rate for a given seller.
     * Priority: Business Override → System Setting → Default (3%)
     */
    public function get_rate($seller_id)
    {
        // 1. Business-level override
        $this->db->select('commission_rate');
        $this->db->from('geopos_users');
        $this->db->where('id', $seller_id);
        $user = $this->db->get()->row_array();
        if ($user && $user['commission_rate'] !== null) {
            return (float) $user['commission_rate'];
        }

        // 2. System-wide default from settings
        $this->db->select('key2');
        $this->db->from('univarsal_api');
        $this->db->where('id', 63); // Commission settings row
        $setting = $this->db->get()->row_array();
        if ($setting && is_numeric($setting['key2']) && $setting['key2'] > 0) {
            return (float) $setting['key2'];
        }

        // 3. Hardcoded default
        return self::DEFAULT_RATE;
    }

    // ─────────────────────────────────────────────
    // AUTO-SPLIT: Record commission on invoice save
    // ─────────────────────────────────────────────

    /**
     * Called after a successful invoice insert.
     * Calculates and stores the platform commission split.
     *
     * @param int   $invoice_id
     * @param float $total
     * @param int   $seller_id
     * @param int   $loc
     * @param int   $business_id
     * @param string $category
     * @return bool
     */
    public function record_commission($invoice_id, $total, $seller_id, $loc = 0, $business_id = 0, $category = null)
    {
        $rate           = $this->get_rate($seller_id);
        $commission_amt = round($total * ($rate / 100), 4);
        $seller_payout  = round($total - $commission_amt, 4);

        $data = [
            'invoice_id'     => $invoice_id,
            'business_id'    => $business_id,
            'seller_id'      => $seller_id,
            'loc'            => $loc,
            'invoice_total'  => $total,
            'rate'           => $rate,
            'commission_amt' => $commission_amt,
            'seller_payout'  => $seller_payout,
            'category'       => $category,
            'status'         => 'pending',
        ];

        $this->db->insert('geopos_commissions', $data);
        return $this->db->insert_id();
    }

    // ─────────────────────────────────────────────
    // QUERIES
    // ─────────────────────────────────────────────

    public function get_all($limit = 100, $offset = 0)
    {
        $this->db->select('c.*, i.tid AS invoice_no, i.invoicedate, u.username AS seller_name, u.email');
        $this->db->from('geopos_commissions c');
        $this->db->join('geopos_invoices i', 'i.id = c.invoice_id', 'left');
        $this->db->join('geopos_users u',    'u.id = c.seller_id', 'left');
        $this->db->order_by('c.created_at', 'DESC');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result_array();
    }

    public function get_by_loc($loc, $limit = 100)
    {
        $this->db->select('c.*, i.tid AS invoice_no, i.invoicedate, u.username AS seller_name');
        $this->db->from('geopos_commissions c');
        $this->db->join('geopos_invoices i', 'i.id = c.invoice_id', 'left');
        $this->db->join('geopos_users u',    'u.id = c.seller_id', 'left');
        $this->db->where('c.loc', $loc);
        $this->db->order_by('c.created_at', 'DESC');
        $this->db->limit($limit);
        return $this->db->get()->result_array();
    }

    public function get_summary()
    {
        $this->db->select('
            COUNT(*) AS total_records,
            SUM(invoice_total)  AS total_sales,
            SUM(commission_amt) AS total_commission,
            SUM(seller_payout)  AS total_payouts,
            SUM(CASE WHEN status="pending"  THEN commission_amt ELSE 0 END) AS pending_commission,
            SUM(CASE WHEN status="settled"  THEN commission_amt ELSE 0 END) AS settled_commission
        ');
        $this->db->from('geopos_commissions');
        return $this->db->get()->row_array();
    }

    public function settle($id)
    {
        $this->db->set('status', 'settled');
        $this->db->set('settled_at', date('Y-m-d H:i:s'));
        $this->db->where('id', $id);
        $this->db->update('geopos_commissions');
        return $this->db->affected_rows() > 0;
    }

    public function settle_all_pending()
    {
        $this->db->set('status', 'settled');
        $this->db->set('settled_at', date('Y-m-d H:i:s'));
        $this->db->where('status', 'pending');
        $this->db->update('geopos_commissions');
        return $this->db->affected_rows();
    }

    public function waive($id)
    {
        $this->db->set('status', 'waived');
        $this->db->where('id', $id);
        $this->db->update('geopos_commissions');
        return $this->db->affected_rows() > 0;
    }

    public function set_business_rate($user_id, $rate)
    {
        $this->db->set('commission_rate', $rate);
        $this->db->where('id', $user_id);
        $this->db->update('geopos_users');
        return $this->db->affected_rows() > 0;
    }

    public function datatables_query($status = null)
    {
        $this->db->select('c.id, c.invoice_id, i.tid AS invoice_no, c.invoice_total, c.rate, c.commission_amt, c.seller_payout, c.status, c.created_at, u.username AS seller_name, c.loc');
        $this->db->from('geopos_commissions c');
        $this->db->join('geopos_invoices i', 'i.id = c.invoice_id', 'left');
        $this->db->join('geopos_users u',    'u.id = c.seller_id', 'left');
        if ($status) $this->db->where('c.status', $status);
        $search = $this->input->post('search');
        if (!empty($search['value'])) {
            $this->db->group_start();
            $this->db->like('i.tid', $search['value']);
            $this->db->or_like('u.username', $search['value']);
            $this->db->group_end();
        }
        if ($this->input->post('order')) {
            $col_map = [0=>'c.id',1=>'i.tid',2=>'u.username',3=>'c.invoice_total',4=>'c.rate',5=>'c.commission_amt',6=>'c.status',7=>'c.created_at'];
            $col_idx = (int)($this->input->post('order')[0]['column'] ?? 0);
            $dir     = $this->input->post('order')[0]['dir'] ?? 'desc';
            $this->db->order_by($col_map[$col_idx] ?? 'c.id', $dir);
        } else {
            $this->db->order_by('c.id', 'DESC');
        }
    }

    public function datatables_data()
    {
        $this->datatables_query();
        if ($this->input->post('length') != -1)
            $this->db->limit($this->input->post('length'), $this->input->post('start'));
        return $this->db->get()->result_array();
    }

    public function datatables_count()
    {
        $this->datatables_query();
        return $this->db->get()->num_rows();
    }
}
