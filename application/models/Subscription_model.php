<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subscription_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get pending subscription approvals (paid plans with status 0 in aauth_users)
     */
    public function get_pending_approvals()
    {
        $this->db->select('id, username, email, subscription_status, receipt_image, date_created');
        $this->db->from('geopos_users');
        $this->db->where('subscription_status', 'pending');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Get all active subscribers
     */
    public function get_active_subscribers()
    {
        $this->db->select('u.id, u.username, u.email, u.subscription_status, s.plan_id, s.activated_at, s.expires_at');
        $this->db->from('geopos_users u');
        $this->db->join('tp_subscriptions s', 's.user_id = u.id', 'left');
        $this->db->join('aauth_user_to_group ug', 'ug.user_id = u.id', 'left');
        $this->db->where('u.subscription_status', 'active');
        // Accept both current IDs (2, 8) and common owner/provider roles (5, 12, 11) for safety
        $this->db->group_start();
        $this->db->where_in('ug.group_id', [2, 8]);
        $this->db->or_where_in('u.roleid', [5, 12]);
        $this->db->group_end();
        $this->db->group_by('u.id');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Approve a subscription
     */
    public function approve($user_id)
    {
        // 1. Update user status in geopos_users
        $this->db->set('subscription_status', 'active');
        $this->db->where('id', $user_id);
        $this->db->update('geopos_users');

        // 2. Update aauth_users status to 1
        $this->db->set('status', 1);
        $this->db->where('id', $user_id);
        $this->db->update('aauth_users');

        // 3. Create or update tp_subscriptions entry
        $now = date('Y-m-d H:i:s');
        $expires = date('Y-m-d H:i:s', strtotime('+30 days'));
        
        $this->db->where('user_id', $user_id);
        $exists = $this->db->get('tp_subscriptions')->num_rows();

        if ($exists) {
            $this->db->set('status', 'active');
            $this->db->set('activated_at', $now);
            $this->db->set('expires_at', $expires);
            $this->db->where('user_id', $user_id);
            $this->db->update('tp_subscriptions');
        } else {
            $data = [
                'user_id' => $user_id,
                'plan_id' => 2, // Default Paid Plan
                'status' => 'active',
                'activated_at' => $now,
                'expires_at' => $expires
            ];
            $this->db->insert('tp_subscriptions', $data);
        }

        return true;
    }

    /**
     * Get commission logs
     */
    public function get_commissions()
    {
        $this->db->select('c.*, u.username, u.email, i.tid, i.total, s.plan_id');
        $this->db->from('tp_commission_logs c');
        $this->db->join('geopos_users u', 'u.id = c.user_id', 'left');
        $this->db->join('geopos_invoices i', 'i.id = c.invoice_id', 'left');
        $this->db->join('tp_subscriptions s', 's.user_id = u.id', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function delete_commission($id)
    {
        return $this->db->where('id', $id)->delete('tp_commission_logs');
    }

    /**
     * Calculate and log commission for a new invoice
     */
    public function calculate_commission($invoice_id, $user_id, $amount)
    {
        $commission = $amount * 0.03; // 3% Commission
        $data = array(
            'invoice_id' => $invoice_id,
            'user_id' => $user_id,
            'amount' => $commission,
            'payment_status' => 'unpaid'
        );
        return $this->db->insert('tp_commission_logs', $data);
    }

    public function delete_subscription($id)
    {
        // $id is geopos_users.id
        $this->db->where('id', $id)->update('geopos_users', ['subscription_status' => 'expired']);
        return $this->db->where('user_id', $id)->delete('tp_subscriptions');
    }

    public function update_plan($user_id, $plan_id)
    {
        // Update subscription status in geopos_users if it was pending
        $this->db->where('id', $user_id)->update('geopos_users', ['subscription_status' => 'active']);
        
        // Update or insert into tp_subscriptions
        $check = $this->db->where('user_id', $user_id)->get('tp_subscriptions');
        if($check->num_rows() > 0) {
            return $this->db->where('user_id', $user_id)->update('tp_subscriptions', ['plan_id' => $plan_id]);
        } else {
            return $this->db->insert('tp_subscriptions', [
                'user_id' => $user_id,
                'plan_id' => $plan_id,
                'status' => 'active',
                'activated_at' => date('Y-m-d H:i:s'),
                'expires_at' => date('Y-m-d H:i:s', strtotime('+30 days'))
            ]);
        }
    }

    /**
     * Get commission summaries for all business owners on Free Plan (3%)
     */
    public function get_commission_summaries()
    {
        // 1. Get all users on Free Plan (plan_id = 1)
        $this->db->select('u.id, u.username, u.email, u.loc');
        $this->db->from('geopos_users u');
        $this->db->join('tp_subscriptions s', 's.user_id = u.id');
        $this->db->where('s.plan_id', 1);
        $users = $this->db->get()->result_array();

        $summaries = [];
        foreach ($users as $user) {
            $user_id = $user['id'];
            $loc = $user['loc'];

            // Total Sales from invoices (Fixes double entry issue by directly using invoices)
            // Use location ID (loc) as the link between business owner and invoices
            $this->db->select_sum('total');
            $this->db->where('loc', $loc);
            $sales_res = $this->db->get('geopos_invoices')->row();
            $total_sales = $sales_res->total ?? 0;

            // Total Commission (3%)
            $total_commission = $total_sales * 0.03;

            // Total Paid (from tp_commissions)
            $this->db->select_sum('commission_amount');
            $this->db->where('user_id', $user_id);
            $this->db->where('status', 'paid');
            $paid_res = $this->db->get('tp_commissions')->row();
            $total_paid = $paid_res->commission_amount ?? 0;

            // Outstanding
            $outstanding = $total_commission - $total_paid;

            if ($total_sales > 0 || $total_paid > 0) {
                $summaries[] = [
                    'user_id' => $user_id,
                    'username' => $user['username'],
                    'email' => $user['email'],
                    'total_sales' => $total_sales,
                    'total_commission' => $total_commission,
                    'total_paid' => $total_paid,
                    'outstanding' => $outstanding
                ];
            }
        }

        return $summaries;
    }

    /**
     * Settle outstanding commission for a business
     */
    public function settle_payment($user_id, $amount)
    {
        // 1. Log the settlement in tp_commissions
        $data = [
            'user_id' => $user_id,
            'total_invoice_amount' => 0, // Bulk settlement doesn't point to a single invoice
            'commission_amount' => $amount,
            'status' => 'paid',
            'paid_at' => date('Y-m-d H:i:s')
        ];
        $this->db->insert('tp_commissions', $data);

        // 2. Record revenue in main ledger (geopos_transactions)
        $this->record_platform_revenue($user_id, $amount);

        return true;
    }

    /**
     * Record platform revenue in geopos_transactions
     */
    private function record_platform_revenue($user_id, $amount)
    {
        // Find "Platform Revenue" account
        $this->db->where('holder', 'Platform Revenue');
        $acc = $this->db->get('geopos_accounts')->row();
        
        if (!$acc) {
            // Create the account if it doesn't exist
            $data_acc = [
                'acn' => 'PLATFORM-REV',
                'holder' => 'Platform Revenue',
                'lastbal' => 0,
                'code' => 'Platform Service Commission',
                'loc' => 0,
                'account_type' => 'Income'
            ];
            $this->db->insert('geopos_accounts', $data_acc);
            $acid = $this->db->insert_id();
            $account_name = 'Platform Revenue';
        } else {
            $acid = $acc->id;
            $account_name = $acc->holder;
        }

        $data = [
            'acid' => $acid,
            'account' => $account_name,
            'type' => 'Income',
            'cat' => 'Subscription Commission',
            'debit' => 0,
            'credit' => $amount,
            'payer' => 'Business Owner ID: ' . $user_id,
            'payerid' => $user_id,
            'method' => 'Cash',
            'date' => date('Y-m-d'),
            'tid' => rand(100000, 999999),
            'note' => 'Commission settlement'
        ];
        
        $this->db->insert('geopos_transactions', $data);

        // Update account balance
        $this->db->set('lastbal', "lastbal + $amount", FALSE);
        $this->db->where('id', $acid);
        $this->db->update('geopos_accounts');
    }
}
