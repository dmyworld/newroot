<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class RiskEngine extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('risk_model');
        $this->load->model('intelligence_model');
        $this->load->model('analytics_model');
        $this->load->model('cronjob_model'); 
        $this->load->library("Aauth");
    }

    public function run_nightly_check()
    {
        // Security: Check token similar to Cronjob controller
        $corn = $this->cronjob_model->config();
        $cornkey = $corn['cornkey'];
        
        $token = $this->input->get('token');
        
        if ($cornkey !== $token && !$this->input->is_cli_request()) {
            exit("Access Denied: Invalid Token");
        }

        echo "Starting Risk Engine Nightly Check...\n";

        try {
            // 1. Detect Fraud Patterns (Master Plan Logic)
            echo "Running Fraud Pattern Detection... ";
            $this->risk_model->detect_fraud_patterns(); 
            echo "Done.\n";

            // 2. Detect Stock Loss (Master Plan Logic)
            echo "Running Stock Loss Detection... ";
            $this->risk_model->detect_stock_loss(); // Updated logic inside model
            echo "Done.\n";

            // 3. Update Staff Trust Scores (Master Plan Logic)
            echo "Updating Staff Trust Scores... ";
            $this->intelligence_model->calculate_staff_trust_score();
            echo "Done.\n";

            // 4. Predict Dead Stock
            echo "Analyzing Dead Stock... ";
            $this->risk_model->detect_dead_stock(); // Moved logic to risk/analytics model wrapper if needed
            echo "Done.\n";

            // 5. Generate Business Health Index
            echo "Generating Business Health Index... ";
            $this->intelligence_model->generate_business_health_index();
            echo "Done.\n";

            echo "Risk Scan & Intelligence Engine Completed Successfully.\n";
            
        } catch (Exception $e) {
            echo "CRITICAL ERROR: " . $e->getMessage() . "\n";
            log_message('error', 'RiskEngine Nightly Check Failed: ' . $e->getMessage());
        }
    }
}
