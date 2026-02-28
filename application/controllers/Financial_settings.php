<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Financial_settings extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {
            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');
        }
        $this->load->model('settings_model', 'settings');
        $this->load->model('accounts_model', 'accounts');
    }

    public function index()
    {
        $head['title'] = "Financial Mapping Settings";
        $data['accounts'] = $this->accounts->accountslist();
        
        // Load existing mappings
        $data['mappings'] = array(
            'sales_income_acc' => $this->settings->get_setting('sales_income_acc'),
            'inventory_asset_acc' => $this->settings->get_setting('inventory_asset_acc'),
            'cogs_acc' => $this->settings->get_setting('cogs_acc'),
            'tax_liability_acc' => $this->settings->get_setting('tax_liability_acc'),
            'bank_acc' => $this->settings->get_setting('bank_acc'),
            'accounts_receivable_acc' => $this->settings->get_setting('accounts_receivable_acc'),
            'accounts_payable_acc' => $this->settings->get_setting('accounts_payable_acc')
        );

        $this->load->view('fixed/header-va', $head);
        $this->load->view('settings/financial_mapping', $data);
        $this->load->view('fixed/footer');
    }

    public function update_mappings()
    {
        $mappings = array(
            'sales_income_acc' => $this->input->post('sales_income_acc'),
            'inventory_asset_acc' => $this->input->post('inventory_asset_acc'),
            'cogs_acc' => $this->input->post('cogs_acc'),
            'tax_liability_acc' => $this->input->post('tax_liability_acc'),
            'bank_acc' => $this->input->post('bank_acc'),
            'accounts_receivable_acc' => $this->input->post('accounts_receivable_acc'),
            'accounts_payable_acc' => $this->input->post('accounts_payable_acc')
        );

        foreach ($mappings as $key => $value) {
            $this->settings->update_setting($key, $value);
        }

        echo json_encode(array('status' => 'Success', 'message' => 'Financial Mappings Updated Successfully'));
    }
}
