<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loyalty_model extends CI_Model
{
    const T_LOGS = 'tp_loyalty_logs';
    const T_CUSTOMERS = 'geopos_customers';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add loyalty points to a customer based on amount spent.
     * 1 point per Rs. X (ratio from system settings).
     */
    public function add_points($customer_id, $amount, $ref_type = 'invoice', $ref_id = null)
    {
        // Get ratio from system
        $ratio = $this->db->select('loyalty_ratio')->from('geopos_system')->where('id', 1)->get()->row()->loyalty_ratio;
        if (!$ratio) $ratio = 100;

        $points = floor($amount / $ratio);
        if ($points <= 0) return 0;

        $this->db->trans_start();

        // Update customer points
        $this->db->set('loyalty_points', 'loyalty_points + ' . $points, FALSE);
        $this->db->where('id', $customer_id);
        $this->db->update(self::T_CUSTOMERS);

        // Log transaction
        $this->db->insert(self::T_LOGS, array(
            'customer_id' => $customer_id,
            'points' => $points,
            'direction' => 'credit',
            'ref_type' => $ref_type,
            'ref_id' => $ref_id,
            'description' => "Earned $points points for spending LKR " . number_format($amount)
        ));

        $this->db->trans_complete();
        return $this->db->trans_status() ? $points : 0;
    }

    /**
     * Redeem points for wallet balance.
     * 1 point = Rs. 1 (simple 1:1 redemption ratio for now)
     */
    public function redeem_to_wallet($customer_id, $points)
    {
        $customer = $this->db->select('loyalty_points')->from(self::T_CUSTOMERS)->where('id', $customer_id)->get()->row_array();
        if (!$customer || $customer['loyalty_points'] < $points) {
            return array('status' => 'Error', 'message' => 'Insufficient points');
        }

        $this->load->model('Wallet_model', 'wallet');
        
        $this->db->trans_start();

        // Deduct points
        $this->db->set('loyalty_points', 'loyalty_points - ' . $points, FALSE);
        $this->db->where('id', $customer_id);
        $this->db->update(self::T_CUSTOMERS);

        // Credit Wallet
        // Assuming geopos_customers has a user_id mapping or we use customer balance
        // The current project uses geopos_customers balance field for client wallet.
        $this->db->set('balance', 'balance + ' . $points, FALSE);
        $this->db->where('id', $customer_id);
        $this->db->update(self::T_CUSTOMERS);

        // Log transaction
        $this->db->insert(self::T_LOGS, array(
            'customer_id' => $customer_id,
            'points' => $points,
            'direction' => 'debit',
            'ref_type' => 'redemption',
            'description' => "Redeemed $points points for Wallet Credit"
        ));

        $this->db->trans_complete();

        return array('status' => 'Success', 'message' => "$points points redeemed successfully");
    }

    public function get_logs($customer_id)
    {
        return $this->db->where('customer_id', $customer_id)
                        ->order_by('created_at', 'DESC')
                        ->get(self::T_LOGS)->result_array();
    }
}
