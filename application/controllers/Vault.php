<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vault extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        $this->load->model('vault_model', 'vault');
        
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(['status' => 'Error', 'message' => 'Not logged in']);
            exit;
        }
    }

    /**
     * Process Job Payment
     */
    public function process_payment()
    {
        $customer_id = $this->aauth->get_user()->id;
        $job_id = $this->input->post('job_id', true);
        $amount = $this->input->post('amount', true);
        $payment_method = $this->input->post('payment_method', true) ?: 'Cash';

        if (!$job_id || !$amount) {
            echo json_encode(['status' => 'Error', 'message' => 'Missing job ID or amount.']);
            return;
        }

        $result = $this->vault->process_job_payment($job_id, $customer_id, $amount, $payment_method);
        echo json_encode($result);
    }

    /**
     * Release Escrow Funds
     */
    public function release()
    {
        $customer_id = $this->aauth->get_user()->id;
        $job_id = $this->input->post('job_id', true);

        if (!$job_id) {
            echo json_encode(['status' => 'Error', 'message' => 'Missing job ID.']);
            return;
        }

        $result = $this->vault->release_escrow($job_id, $customer_id);
        echo json_encode($result);
    }
}
