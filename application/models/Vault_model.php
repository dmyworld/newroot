<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vault_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->_check_tables();
    }

    private function _check_tables()
    {
        $this->load->dbforge();

        if (!$this->db->table_exists('geopos_escrow_transactions')) {
            $this->dbforge->add_field(array(
                'id' => array('type' => 'INT', 'constraint' => 11, 'unsigned' => TRUE, 'auto_increment' => TRUE),
                'job_id' => array('type' => 'INT', 'constraint' => 11),
                'customer_id' => array('type' => 'INT', 'constraint' => 11),
                'worker_id' => array('type' => 'INT', 'constraint' => 11),
                'amount' => array('type' => 'DECIMAL', 'constraint' => '10,2', 'default' => '0.00'),
                'status' => array('type' => 'ENUM("held", "released", "refunded")', 'default' => 'held'),
                'created_at' => array('type' => 'DATETIME'),
                'released_at' => array('type' => 'DATETIME', 'null' => TRUE)
            ));
            $this->dbforge->add_key('id', TRUE);
            $this->dbforge->create_table('geopos_escrow_transactions', TRUE);
            $this->db->query("ALTER TABLE `geopos_escrow_transactions` CHANGE `created_at` `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP");
        }
    }

    /**
     * Process payment for a job
     */
    public function process_job_payment($job_id, $customer_id, $amount, $payment_method = 'Cash')
    {
        // 1. Get Job details
        $this->db->select('r.*, w.provider_type, w.owner_id');
        $this->db->from('geopos_marketplace_requests r');
        $this->db->join('geopos_worker_profiles w', 'r.assigned_worker_id = w.user_id', 'left');
        $this->db->where('r.id', $job_id);
        $job = $this->db->get()->row_array();

        if (!$job || !$job['assigned_worker_id']) {
            return ['status' => 'Error', 'message' => 'Invalid job or no worker assigned.'];
        }

        $this->db->trans_start(); // Start Transaction

        if ($job['provider_type'] == 'company') {
            // DIRECT PAY -> Goes to Company Owner
            $owner_id = $job['owner_id'];
            
            // Record direct invoice/transaction for the company owner
            // Using standard transactions table or simply noting it
            $data = [
                'acid' => 0,
                'account' => 'Company Direct',
                'type' => 'Income',
                'cat' => 'Service Payment',
                'debit' => 0,
                'credit' => $amount,
                'payer' => 'Customer #'.$customer_id,
                'payerid' => $customer_id,
                'method' => $payment_method,
                'date' => date('Y-m-d'),
                'eid' => $owner_id,
                'loc' => $this->aauth->get_user()->loc ?? 0,
                'note' => 'Direct payment for Job #'.$job_id
            ];
            $this->db->insert('geopos_transactions', $data);

            $message = 'Payment directly deposited to Company accounts.';

        } else {
            // ESCROW -> Independent Worker
            // Hold funds in Vault
            $escrow_data = [
                'job_id' => $job_id,
                'customer_id' => $customer_id,
                'worker_id' => $job['assigned_worker_id'],
                'amount' => $amount,
                'status' => 'held'
            ];
            $this->db->insert('geopos_escrow_transactions', $escrow_data);

            // Add standard system transaction for holding funds
            $data = [
                'acid' => 0,
                'account' => 'Timber Pro Vault',
                'type' => 'Escrow',
                'cat' => 'Service Payment',
                'debit' => 0,
                'credit' => $amount,
                'payer' => 'Customer #'.$customer_id,
                'payerid' => $customer_id,
                'method' => $payment_method,
                'date' => date('Y-m-d'),
                'eid' => 0,
                'loc' => $this->aauth->get_user()->loc ?? 0,
                'note' => 'Escrow hold for Job #'.$job_id
            ];
            $this->db->insert('geopos_transactions', $data);

            $message = 'Payment held in Timber Pro Vault until job completion.';
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return ['status' => 'Error', 'message' => 'Transaction failed.'];
        }

        return ['status' => 'Success', 'message' => $message];
    }

    /**
     * Release funds from Vault to Freelancer
     */
    public function release_escrow($job_id, $customer_id)
    {
        $this->db->where('job_id', $job_id);
        $this->db->where('customer_id', $customer_id);
        $this->db->where('status', 'held');
        $escrow = $this->db->get('geopos_escrow_transactions')->row_array();

        if (!$escrow) {
            return ['status' => 'Error', 'message' => 'No held funds found for this job.'];
        }

        $this->db->trans_start();

        // Mark as released
        $this->db->where('id', $escrow['id']);
        $this->db->update('geopos_escrow_transactions', [
            'status' => 'released', 
            'released_at' => date('Y-m-d H:i:s')
        ]);

        // Credit Freelancer Wallet/Transaction
        $data = [
            'acid' => 0,
            'account' => 'Freelancer Wallet',
            'type' => 'Income',
            'cat' => 'Service Payment',
            'debit' => 0,
            'credit' => $escrow['amount'],
            'payer' => 'Vault Release',
            'payerid' => $customer_id,
            'method' => 'Internal Transfer',
            'date' => date('Y-m-d'),
            'eid' => $escrow['worker_id'],
            'loc' => 0,
            'note' => 'Vault released for Job #'.$job_id
        ];
        $this->db->insert('geopos_transactions', $data);
        
        // Also close the job request
        $this->db->where('id', $job_id);
        $this->db->update('geopos_marketplace_requests', ['status' => 'closed']);

        // Set worker back to available
        $this->db->where('user_id', $escrow['worker_id']);
        $this->db->update('geopos_worker_profiles', ['availability' => 'available']);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            return ['status' => 'Error', 'message' => 'Failed to release funds.'];
        }

        return ['status' => 'Success', 'message' => 'Funds successfully released to worker.'];
    }
}
