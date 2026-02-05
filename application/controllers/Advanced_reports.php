<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Advanced_reports extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }
        $this->load->model('reports_model');
        $this->li_a = 'adv_reports';
    }

    public function index()
    {
        $head['title'] = "Advanced Report Center";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/index');
        $this->load->view('fixed/footer');
    }

    public function _remap($method, $params = array())
    {
        if (method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        }
        $this->display_report($method);
    }

    private function display_report($type)
    {
        $this->load->model('advanced_reports_model');
        $this->load->helper('inflector');
        
        $data = [];
        $view = '';
        $head['title'] = humanize($type);
        
        switch ($type) {
             case 'consolidated_financials':
                $start = $this->input->get('start') ? $this->input->get('start') : date('Y-01-01');
                $end = $this->input->get('end') ? $this->input->get('end') : date('Y-m-d');
                $data['financials'] = $this->advanced_reports_model->get_consolidated_financials($start, $end);
                $data['start'] = $start;
                $data['end'] = $end;
                $view = 'advanced_reports/financials/consolidated';
                break;
            case 'multi_period_analysis':
                $data['analysis'] = $this->advanced_reports_model->get_multi_period_analysis();
                $view = 'advanced_reports/financials/multi_period';
                break;
            case 'sales_funnel':
                $start = $this->input->get('start') ? $this->input->get('start') : date('Y-01-01');
                $end = $this->input->get('end') ? $this->input->get('end') : date('Y-m-d');
                $data['funnel'] = $this->advanced_reports_model->get_sales_funnel($start, $end);
                $data['start'] = $start;
                $data['end'] = $end;
                $view = 'advanced_reports/sales/funnel';
                break;
            case 'customer_lifetime_value':
                $data['clv_data'] = $this->advanced_reports_model->get_customer_lifetime_value();
                $view = 'advanced_reports/sales/clv';
                break;
             case 'job_profitability':
                $data['projects'] = $this->advanced_reports_model->get_job_profitability();
                $view = 'advanced_reports/projects/profitability';
                break;
             case 'churn_risk':
                $data['churn_risk'] = $this->advanced_reports_model->get_churn_risk();
                $view = 'advanced_reports/customer/churn';
                break;
             case 'nps':
                $data['nps_data'] = $this->advanced_reports_model->get_nps_data();
                $view = 'advanced_reports/customer/nps';
                break;
            case 'labor_cost':
                $data['labor_trends'] = $this->advanced_reports_model->get_labor_cost_trends();
                $view = 'advanced_reports/payroll/labor_cost';
                break;
             case 'vendor_spend':
                $data['vendor_data'] = $this->advanced_reports_model->get_vendor_spend();
                $view = 'advanced_reports/supply_chain/vendor_spend';
                break;
             case 'retail_traffic':
                $data['traffic'] = $this->advanced_reports_model->get_peak_sales_hours();
                $view = 'advanced_reports/industry/retail_traffic';
                break;
             case 'retainage':
                $data['retainage_data'] = $this->advanced_reports_model->get_retainage_estimates();
                $view = 'advanced_reports/industry/retainage';
                break;
            case 'abc_analysis':
                $data['abc_data'] = $this->advanced_reports_model->get_abc_analysis();
                $view = 'advanced_reports/inventory/abc';
                break;
             default:
                show_404();
                return;
        }

        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view($view, $data);
        $this->load->view('fixed/footer');
    }

    public function export_csv($type = '')
    {
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->model('advanced_reports_model');

        $data = [];
        $filename = 'report_' . $type . '_' . date('Ymd') . '.csv';

        switch ($type) {
            case 'consolidated_financials':
                $start = $this->input->get('start') ? $this->input->get('start') : date('Y-01-01');
                $end = $this->input->get('end') ? $this->input->get('end') : date('Y-m-d');
                $data = $this->advanced_reports_model->get_consolidated_financials($start, $end);
                break;
            case 'multi_period_analysis':
                $data = $this->advanced_reports_model->get_multi_period_analysis();
                break;
            case 'sales_funnel':
                $start = $this->input->get('start') ? $this->input->get('start') : date('Y-01-01');
                $end = $this->input->get('end') ? $this->input->get('end') : date('Y-m-d');
                $data = $this->advanced_reports_model->get_sales_funnel($start, $end);
                break;
            case 'customer_lifetime_value':
                $data = $this->advanced_reports_model->get_customer_lifetime_value();
                break;
            case 'abc_analysis':
                $data = $this->advanced_reports_model->get_abc_analysis();
                break;
             case 'job_profitability':
                $data = $this->advanced_reports_model->get_job_profitability();
                break;
            case 'churn_risk':
                $data = $this->advanced_reports_model->get_churn_risk();
                break;
            case 'nps':
                $raw = $this->advanced_reports_model->get_nps_data();
                $data = array_merge($raw['promoters'], $raw['detractors']); // Flatten for CSV
                break;
             case 'labor_cost':
                $data = $this->advanced_reports_model->get_labor_cost_trends();
                break;
            case 'vendor_spend':
                $data = $this->advanced_reports_model->get_vendor_spend();
                break;
            case 'retail_traffic':
                $data = $this->advanced_reports_model->get_peak_sales_hours();
                break;
            case 'retainage':
                $data = $this->advanced_reports_model->get_retainage_estimates();
                break;
            default:
                show_error("Invalid Export Type");
                return;
        }

        if (empty($data)) {
            $this->session->set_flashdata('message', 'No data found to export.');
            redirect('advanced_reports');
            return;
        }

        // Convert array to CSV
        $delimiter = ",";
        $newline = "\r\n";
        $enclosure = '"';

        $out = fopen('php://output', 'w');
        
        // Output headers to browser
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$filename");
        header("Pragma: no-cache");
        header("Expires: 0");

        // generic header from keys
        if (!empty($data)) {
             fputcsv($out, array_keys($data[0]), $delimiter, $enclosure);
        }

        foreach ($data as $row) {
            fputcsv($out, $row, $delimiter, $enclosure);
        }
        
        fclose($out);
        exit;
    }

    // --- FINANCIAL SUITE METHODS ---

    public function consolidated_financials()
    {
        $this->load->model('advanced_reports_model');
        $start = $this->input->get('start') ? $this->input->get('start') : date('Y-01-01');
        $end = $this->input->get('end') ? $this->input->get('end') : date('Y-m-d');
        
        $data['financials'] = $this->advanced_reports_model->get_consolidated_financials($start, $end);
        $data['start'] = $start;
        $data['end'] = $end;

        $head['title'] = "Consolidated Financials";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/financials/consolidated', $data);
        $this->load->view('fixed/footer');
    }

    public function multi_period_analysis()
    {
        $this->load->model('advanced_reports_model');
        $data['analysis'] = $this->advanced_reports_model->get_multi_period_analysis();

        $head['title'] = "Multi-Period Analysis";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/financials/multi_period', $data);
        $this->load->view('fixed/footer');
    }

    // --- SALES ANALYTICS METHODS ---

    public function sales_funnel()
    {
        $this->load->model('advanced_reports_model');
        $start = $this->input->get('start') ? $this->input->get('start') : date('Y-01-01');
        $end = $this->input->get('end') ? $this->input->get('end') : date('Y-m-d');

        $data['funnel'] = $this->advanced_reports_model->get_sales_funnel($start, $end);
        $data['start'] = $start;
        $data['end'] = $end;

        $head['title'] = "Sales Funnel Analysis";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/sales/funnel', $data);
        $this->load->view('fixed/footer');
    }

    public function customer_lifetime_value()
    {
        $this->load->model('advanced_reports_model');
        $data['clv_data'] = $this->advanced_reports_model->get_clv_analytics();

        $head['title'] = "Customer Lifetime Value";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/sales/clv', $data);
        $this->load->view('fixed/footer');
    }

    // --- EXPORT PLACEHOLDERS (Updated) ---

    public function export($type = '')
    {
       // Basic export logic reuse
       // For now, redirect to CSV generation based on model data
       // Implementation pending Phase 3
       echo "Export logic for $type pending implementation.";
    }

    private function export_sales_analytics() {
        // Implementation for sales export
        // ...
    }

    // --- INVENTORY & COSTING METHODS ---

    public function abc_analysis()
    {
        $this->load->model('advanced_reports_model');
        $data['abc_data'] = $this->advanced_reports_model->get_abc_analysis();

        $head['title'] = "ABC Inventory Analysis";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/inventory/abc', $data);
        $this->load->view('fixed/footer');
    }

    public function job_profitability()
    {
        // ... (existing code)
        $this->load->model('advanced_reports_model');
        $data['projects'] = $this->advanced_reports_model->get_job_profitability();

        $head['title'] = "Project Profitability";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/projects/profitability', $data);
        $this->load->view('fixed/footer');
    }

    // --- CUSTOMER & STRATEGY ---

    public function churn_rate()
    {
        $this->load->model('advanced_reports_model');
        $data['churn_risk'] = $this->advanced_reports_model->get_churn_risk();

        $head['title'] = "Churn Risk Analysis";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/customer/churn', $data);
        $this->load->view('fixed/footer');
    }

    public function swot_analysis()
    {
        // ... (Existing code)
        // Static Template for Strategic Planning
        $head['title'] = "SWOT Analysis";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/strategy/swot');
        $this->load->view('fixed/footer');
    }

    // --- PAYROLL & TAX METHODS ---

    public function labor_cost_analysis()
    {
        $this->load->model('advanced_reports_model');
        $data['labor_trends'] = $this->advanced_reports_model->get_labor_cost_trends();

        $head['title'] = "Labor Cost Analysis";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/payroll/labor_cost', $data);
        $this->load->view('fixed/footer');
    }

    public function tax_provision()
    {
        $this->load->model('advanced_reports_model');
        $start = $this->input->get('start') ? $this->input->get('start') : date('Y-01-01');
        $end = $this->input->get('end') ? $this->input->get('end') : date('Y-m-d');
        
        $data['tax_data'] = $this->advanced_reports_model->get_tax_provision_estimate($start, $end);

        $head['title'] = "Tax Provision Estimate";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/tax/provision', $data);
        $this->load->view('fixed/footer');
    }

    // --- SUPPLY CHAIN METHODS ---

    public function vendor_scorecards()
    {
        $this->load->model('advanced_reports_model');
        $data['vendor_data'] = $this->advanced_reports_model->get_vendor_spend();

        $head['title'] = "Vendor Spend Scorecards";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/supply_chain/vendor_spend', $data);
        $this->load->view('fixed/footer');
    }

    // --- TECHNICAL & COMPLIANCE ---

    public function activity_log()
    {
        $this->load->model('advanced_reports_model');
        $data['logs'] = $this->advanced_reports_model->get_user_activity_logs();

        $head['title'] = "System Activity Logs";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/technical/activity_log', $data);
        $this->load->view('fixed/footer');
    }

    // --- INDUSTRY SPECIFIC ---

    public function retail_traffic()
    {
        $this->load->model('advanced_reports_model');
        $data['traffic'] = $this->advanced_reports_model->get_peak_sales_hours();

        $head['title'] = "Retail Traffic Analysis";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/industry/retail_traffic', $data);
        $this->load->view('fixed/footer');
    }

    public function nps()
    {
        $this->load->model('advanced_reports_model');
        $data['nps_data'] = $this->advanced_reports_model->get_nps_data();

        $head['title'] = "Net Promoter Score (NPS)";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/customer/nps', $data);
        $this->load->view('fixed/footer');
    }

    public function system_health()
    {
        $this->load->model('advanced_reports_model');
        $data['health'] = $this->advanced_reports_model->get_system_health();

        $head['title'] = "System Health Status";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/technical/system_health', $data);
        $this->load->view('fixed/footer');
    }

    public function retainage()
    {
        $this->load->model('advanced_reports_model');
        $data['retainage_data'] = $this->advanced_reports_model->get_retainage_estimates();

        $head['title'] = "Construction Retainage Estimator";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('advanced_reports/industry/retainage', $data);
        $this->load->view('fixed/footer');
    }

}
