<?php
/**
 * Service Accounting Model
 * Backend logic for commission splits
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Service_accounting_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Calculate and record commission split
     * To be called when a service request is completed
     */
    public function process_split($service_id, $total_amount, $promo_code = null)
    {
        // 1. Get service details
        $this->db->where('id', $service_id);
        $service = $this->db->get('tp_services')->row_array();
        
        if (!$service) return false;

        $commission_pc = $service['admin_commission_pc'];
        
        // 2. Check for surge pricing at time of booking (implied in business logic)
        
        // 3. Handle Promo Code
        $discount = 0;
        if ($promo_code) {
            $this->db->where('code', $promo_code);
            $promo = $this->db->get('tp_promo_codes')->row_array();
            if ($promo) {
                if ($promo['discount_pc'] > 0) {
                    $discount = ($total_amount * $promo['discount_pc']) / 100;
                } else {
                    $discount = $promo['discount_fixed'];
                }

                // If promo deducts from admin commission
                if ($promo['deduct_from_admin'] == 1) {
                    // Logic to handle admin share reduction
                }
            }
        }

        $net_amount = $total_amount - $discount;
        $admin_share = ($net_amount * $commission_pc) / 100;
        $worker_share = $net_amount - $admin_share;

        // 4. Update geopos_accounts (using Query Builder)
        // This is a placeholder for actual account IDs which should be configurable
        $admin_account_id = 1; 
        
        $this->db->set('lastbal', "lastbal + $admin_share", FALSE);
        $this->db->where('id', $admin_account_id);
        $this->db->update('geopos_accounts');

        return array(
            'total' => number_format($total_amount, 2, '.', ''),
            'discount' => number_format($discount, 2, '.', ''),
            'admin_share' => number_format($admin_share, 2, '.', ''),
            'worker_share' => number_format($worker_share, 2, '.', '')
        );
    }
}
