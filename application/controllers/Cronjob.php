<?php
/**
 * D Business Solutions  -  Accounting,  Invoicing  and CRM Application
 * Copyright (c) Dashan Korala Hewage. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@dmyworld.com
 *  Website: https://www.dmyworld.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from D My World, Please read the full License from
 *  * here- https://dmyworld.com/licenses/standard/
 * ***********************************************************************
 */

defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob extends CI_Controller
{


    public function __construct()
    {
        parent::__construct();

        $this->load->model('cronjob_model', 'cronjob');
        $this->load->library("Aauth");
        $this->li_a = 'advance';
    }


    public function index()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
        }
        if ($this->aauth->get_user()->roleid < 5) {

            exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

        }
        $data['message'] = false;
        $data['corn'] = $this->cronjob->config();
        $head['usernm'] = $this->aauth->get_user()->username;
        $head['title'] = 'Cron Job Panel';
        $this->load->view('fixed/header', $head);
        $this->load->view('cronjob/info', $data);
        $this->load->view('fixed/footer');
    }


    public function generate()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/hub/login', 'refresh');
            if ($this->aauth->get_user()->roleid < 5) {

                exit('<h3>Sorry! You have insufficient permissions to access this section</h3>');

            }
        }


        if ($this->cronjob->generate()) {

            $data['message'] = true;


            $data['corn'] = $this->cronjob->config();
            $head['usernm'] = $this->aauth->get_user()->username;
            $head['title'] = 'Generate New Key';
            $this->load->view('fixed/header', $head);
            $this->load->view('cronjob/info', $data);
            $this->load->view('fixed/footer');
        }


    }


    function due_invoices_email()
    {

        $corn = $this->cronjob->config();
        $this->load->library('parser');

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for due invoices-------\n";


        if ($cornkey == $this->input->get('token')) {
            $i = 1;

            $emails = $this->cronjob->due_mail();
            $this->load->model('templates_model', 'templates');
            $template = $this->templates->template_info(7);

            $this->load->model('communication_model', 'communication');

            foreach ($emails as $invoice) {


                $validtoken = hash_hmac('ripemd160', $invoice['id'], $this->config->item('encryption_key'));

                $link = base_url('billing/view?id=' . $invoice['id'] . '&token=' . $validtoken);

                $loc = location($invoice['loc']);

                $data = array(
                    'Company' => $loc['cname'],
                    'BillNumber' => $invoice['tid']
                );
                $subject = $this->parser->parse_string($template['key1'], $data, TRUE);


                $data = array(
                    'Company' => $loc['cname'],
                    'BillNumber' => $invoice['tid'],
                    'URL' => "<a href='$link'>$link</a>",
                    'CompanyDetails' => '<h6><strong>' . $loc['cname'] . ',</strong></h6>
<address>' . $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['country'] . '</address>
            Phone: ' . $loc['phone'] . '<br> Email: ' . $loc['email'],
                    'DueDate' => dateformat($invoice['invoiceduedate']),
                    'Amount' => amountExchange($invoice['total'], $invoice['multi'])
                );
                $message = $this->parser->parse_string($template['other'], $data, TRUE);

                if ($this->communication->send_corn_email($invoice['email'], $invoice['name'], $subject, $message)) {
                    echo "---------------$i. Email Sent! -------------------------\n";
                } else {

                    echo "---------------$i. Error! -------------------------\n";
                }


                $i++;

            }


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }
    }


    function reports()
    {

        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];


        echo "---------------Updating Reports-------\n";


        if ($cornkey == $this->input->get('token')) {


            echo "---------------Cron started-------\n";

            $this->cronjob->reports();

            echo "---------------Task Done-------\n";

        }


    }


    public function update_exchange_rate()
    {

        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];

        echo "---------------Updating Exchange Rates-------\n";
        if ($cornkey == $this->input->get('token')) {

            echo "---------------Cron started-------\n";
            $this->load->model('plugins_model', 'plugins');
            $exchange = $this->plugins->universal_api(5);
            if ($exchange['active']) {
                $endpoint = $exchange['key2'];
                $access_key = $exchange['key1'];
                $base = $exchange['url'];


                $ch = curl_init('http://apilayer.net/api/' . $endpoint . '?access_key=' . $access_key . '');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


                $json = curl_exec($ch);
                curl_close($ch);


                $exchangeRates = json_decode($json, true);


                $this->cronjob->exchange_rate($base, $exchangeRates['quotes']);
                echo "---------------Task Done-------\n";
            }
        }


    }

    public function subscription()
    {
        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for subscription-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";

            if ($this->cronjob->subs()) {

                echo "---------------Success! Process Done! -------------------------\n";
            } else {
                echo "---------------Error! Process Halted! -------------------------\n";
            }


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }


    public function cleandrafts()
    {
        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for clean drafts-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";

            // $ndate = date("Y-m-d", strtotime(date('Y-m-d') . " -7 days"));
            $this->db->where('tid>', 1);
            $this->db->delete('geopos_draft');
            $this->db->where('tid>', 1);
            $this->db->delete('geopos_draft_items');

            echo "---------------Success! Process Done! -------------------------\n";


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }

    public function promo()
    {
        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for promo update-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";


            $data = array(
                ' active' => 2

            );
            $this->db->set($data);
            $this->db->where('valid<', date('Y-m-d'));


            $this->db->update('geopos_promo');


            echo "---------------Success! Process Done! -------------------------\n";


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }

    public function stock_alert()
    {
        $corn = $this->cronjob->config();
        $this->load->model('communication_model', 'communication');

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for product stock alert-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";
            $subject = 'Stock Alert ' . date('Y-m-d H:i:s');

            if ($this->communication->send_corn_email($this->config->item('email'), $this->config->item('cname'), $subject, $this->cronjob->stock())) {
                echo "-------------- Email Sent! -------------------------\n";
            } else {

                echo "---------------. Error! -------------------------\n";
            }


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }

    public function dbbackup()
    {
        $corn = $this->cronjob->config();
        //  $this->load->model('communication_model', 'communication');

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for database backup-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";
            $bdate = 'backup_' . date('Y_m_d_H_i_s');
            $this->load->dbutil();
            $backup = $this->dbutil->backup();
            $this->load->helper('file');
            write_file(FCPATH . 'userfiles/' . $bdate . '-' . rand(99, 999) . '.gz', $backup);


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }

    public function cleanlog()
    {
        $corn = $this->cronjob->config();

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job to clean 7days old log-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";

            // $ndate = date("Y-m-d", strtotime(date('Y-m-d') . " -7 days"));
            $this->db->where('DATE(created)<', date('Y-m-d', strtotime(date('Y-m-d') . " -7 days")));
            $this->db->delete('geopos_log');

            echo "---------------Success! Process Done! -------------------------\n";


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }

    public function expiry_alert()
    {
        $corn = $this->cronjob->config();
        $this->load->model('communication_model', 'communication');

        $cornkey = $corn['cornkey'];


        echo "---------------Cron job for product expiry alert-------\n";


        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";
            $subject = 'Expiry Alert ' . date('Y-m-d H:i:s');

            if ($this->communication->send_corn_email($this->config->item('email'), $this->config->item('cname'), $subject, $this->cronjob->expiry())) {
                echo "-------------- Email Sent! -------------------------\n";
            } else {

                echo "---------------. Error! -------------------------\n";
            }


        } else {

            echo "---------------Error! Invalid Token! -------------------------\n";
        }


    }

    /**
     * Owner Dashboard Intelligence Processing
     * Run nightly to calculate staff scores, business health, detect fraud patterns, and analyze stock
     * URL: /cronjob/nightly_intelligence_processing?token=YOUR_TOKEN
     */
    public function nightly_intelligence_processing()
    {
        $corn = $this->cronjob->config();
        $cornkey = $corn['cornkey'];

        echo "---------------Cron job for Owner Dashboard Intelligence Processing-------\n";

        if ($cornkey == $this->input->get('token')) {

            echo "---------------Process Started -------------------------\n";
            
            // Load required models
            $this->load->model('intelligence_model');
            $this->load->model('risk_model');
            $this->load->model('analytics_model');
            
            // 1. Calculate Staff Trust Scores
            echo "1. Calculating Staff Trust Scores...\n";
            try {
                $this->intelligence_model->calculate_staff_trust_score();
                echo "   ✓ Staff scores updated\n";
            } catch (Exception $e) {
                echo "   ✗ Error: " . $e->getMessage() . "\n";
            }
            
            // 2. Generate Business Health Index
            echo "2. Generating Business Health Index...\n";
            try {
                $this->intelligence_model->generate_business_health_index();
                echo "   ✓ Business health index calculated\n";
            } catch (Exception $e) {
                echo "   ✗ Error: " . $e->getMessage() . "\n";
            }
            
            // 3. Detect Fraud Patterns
            echo "3. Scanning for Fraud Patterns...\n";
            try {
                $this->risk_model->detect_fraud_patterns();
                echo "   ✓ Fraud detection completed\n";
            } catch (Exception $e) {
                echo "   ✗ Error: " . $e->getMessage() . "\n";
            }
            
            // 4. Detect Stock Loss
            echo "4. Checking for Stock Loss...\n";
            try {
                $loss = $this->risk_model->detect_stock_loss(date('Y-m-d'));
                echo "   ✓ Stock loss check completed (Loss: " . $loss . ")\n";
            } catch (Exception $e) {
                echo "   ✗ Error: " . $e->getMessage() . "\n";
            }
            
            // 5. Generate Branch KPI Snapshots
            echo "5. Creating Branch KPI Snapshots...\n";
            try {
                $date = date('Y-m-d');
                $this->load->model('locations_model');
                $branches = $this->locations_model->locations_list();
                
                foreach ($branches as $branch) {
                    $branch_id = $branch['id'];
                    
                    // Get today's metrics for this branch
                    $sales = $this->intelligence_model->get_aggregated_sales($date, $branch_id);
                    $profit = $this->intelligence_model->get_aggregated_profit($date, $branch_id);
                    
                    // Count invoices for today
                    $this->db->where('DATE(invoicedate)', $date);
                    $this->db->where('loc', $branch_id);
                    $invoice_count = $this->db->count_all_results('geopos_invoices');
                    
                    // Count unique customers
                    $this->db->distinct();
                    $this->db->select('csd');
                    $this->db->where('DATE(invoicedate)', $date);
                    $this->db->where('loc', $branch_id);
                    $this->db->from('geopos_invoices');
                    $customer_count = $this->db->count_all_results();
                    
                    $avg_transaction = ($invoice_count > 0) ? ($sales / $invoice_count) : 0;
                    
                    // Insert snapshot
                    $snapshot_data = array(
                        'date' => $date,
                        'branch_id' => $branch_id,
                        'sales_amount' => $sales,
                        'profit_amount' => $profit,
                        'invoice_count' => $invoice_count,
                        'customer_count' => $customer_count,
                        'avg_transaction' => $avg_transaction
                    );
                    
                    $this->db->insert('geopos_branch_kpi_snapshots', $snapshot_data);
                }
                
                echo "   ✓ Branch KPI snapshots created for " . count($branches) . " branches\n";
            } catch (Exception $e) {
                echo "   ✗ Error: " . $e->getMessage() . "\n";
            }

            echo "---------------Success! All Intelligence Processing Done! -------------------------\n";

        } else {
            echo "---------------Error! Invalid Token! -------------------------\n";
        }
    }


    /**
     * WhatsApp: HP Installment Reminders
     * Sends payment reminders to HP customers 3 days and 1 day before due date.
     * Cron: Run daily → /cronjob/whatsapp_hp_reminders?token=YOUR_TOKEN
     */
    public function whatsapp_hp_reminders()
    {
        $corn = $this->cronjob->config();
        $cornkey = $corn['cornkey'];

        echo "--- WhatsApp HP Installment Reminder Cron ---\n";

        if ($cornkey != $this->input->get('token')) {
            echo "--- Error! Invalid Token! ---\n";
            return;
        }

        $this->load->model('WhatsApp_model', 'whatsapp');
        $sent = 0;
        $errors = 0;

        foreach ([3, 1] as $days_ahead) {
            $target_date = date('Y-m-d', strtotime("+{$days_ahead} days"));

            $this->db->select('i.id, i.installment_num, i.amount, i.due_date, i.contract_id, c.customer_id');
            $this->db->from('geopos_hp_installments i');
            $this->db->join('geopos_hp_contracts c', 'c.id = i.contract_id');
            $this->db->where('i.status', 'unpaid');
            $this->db->where('i.due_date', $target_date);
            $due_rows = $this->db->get()->result_array();

            echo count($due_rows) . " installments due in {$days_ahead} day(s).\n";

            foreach ($due_rows as $row) {
                $customer = $this->db->select('name, phone')
                    ->where('id', $row['customer_id'])
                    ->get('geopos_customers')->row_array();

                if (empty($customer['phone'])) continue;

                $result = $this->whatsapp->send_template($customer['phone'], 42, [
                    'Name'           => $customer['name'],
                    'Amount'         => number_format($row['amount'], 2),
                    'DueDate'        => $row['due_date'],
                    'InstallmentNum' => $row['installment_num'],
                    'ContractID'     => $row['contract_id'],
                ]);

                if (isset($result['status']) && $result['status'] == 'Success') {
                    $sent++;
                    echo "  ✓ Sent to {$customer['name']} ({$customer['phone']})\n";
                } else {
                    $errors++;
                    echo "  ✗ Failed for {$customer['name']}: " . ($result['message'] ?? 'Unknown') . "\n";
                }
            }
        }

        echo "--- Done. Sent: {$sent} | Errors: {$errors} ---\n";
    }

    /**
     * Action Module: process expired rings and auto-forward to next provider.
     * URL: /cronjob/action_timeouts?token=YOUR_TOKEN
     */
    public function action_timeouts()
    {
        $corn   = $this->cronjob->config();
        $cornkey= $corn['cornkey'];

        echo "---------------Cron job for Action Request Timeouts-------\n";

        if ($cornkey != $this->input->get('token')) {
            echo "---------------Error! Invalid Token! -------------------------\n";
            return;
        }

        echo "---------------Process Started -------------------------\n";

        $this->load->model('Action_request_model', 'actions');
        $this->actions->process_timeouts();

        echo "---------------Success! Process Done! -------------------------\n";
    }

    /**
     * WhatsApp: Overdue Invoice Alerts
     * Sends WhatsApp notifications for invoices past their due date (unpaid).
     * Cron: Run daily → /cronjob/whatsapp_overdue_invoices?token=YOUR_TOKEN
     */
    public function whatsapp_overdue_invoices()
    {
        $corn = $this->cronjob->config();
        $cornkey = $corn['cornkey'];

        echo "--- WhatsApp Overdue Invoice Alert Cron ---\n";

        if ($cornkey != $this->input->get('token')) {
            echo "--- Error! Invalid Token! ---\n";
            return;
        }

        $this->load->model('WhatsApp_model', 'whatsapp');

        // Get invoices past due and not fully paid
        $this->db->select('i.id, i.tid, i.invoiceduedate, i.total, i.multi, c.name, c.phone, i.loc');
        $this->db->from('geopos_invoices i');
        $this->db->join('geopos_customers c', 'c.id = i.csd', 'left');
        $this->db->where('DATE(i.invoiceduedate) <', date('Y-m-d'));
        $this->db->where('i.status !=', 'Paid');
        $this->db->where('i.status !=', 'Draft');
        $this->db->where('c.phone !=', '');
        $this->db->where('c.phone IS NOT NULL', null, false);

        // Avoid re-alerting the same invoice today: skip if already messaged today
        // (check via geopos_metadata type=99)
        $today_tagged = $this->db->select('rid')
            ->where('type', 99)
            ->where('DATE(d_date)', date('Y-m-d'))
            ->get('geopos_metadata')->result_array();
        $already_alerted = array_column($today_tagged, 'rid');

        $this->db->select('i.id, i.tid, i.invoiceduedate, i.total, i.multi, c.name, c.phone, i.loc');
        $this->db->from('geopos_invoices i');
        $this->db->join('geopos_customers c', 'c.id = i.csd', 'left');
        $this->db->where('DATE(i.invoiceduedate) <', date('Y-m-d'));
        $this->db->where('i.status !=', 'Paid');
        $this->db->where('i.status !=', 'Draft');
        if (!empty($already_alerted)) {
            $this->db->where_not_in('i.id', $already_alerted);
        }
        $invoices = $this->db->get()->result_array();

        echo count($invoices) . " overdue invoices to alert.\n";

        $sent = 0;
        $errors = 0;

        foreach ($invoices as $invoice) {
            if (empty($invoice['phone'])) continue;

            $validtoken = hash_hmac('ripemd160', $invoice['id'], $this->config->item('encryption_key'));
            $link = base_url('billing/view?id=' . $invoice['id'] . '&token=' . $validtoken);

            $result = $this->whatsapp->send_template($invoice['phone'], 40, [
                'Name'       => $invoice['name'],
                'BillNumber' => $invoice['tid'],
                'Amount'     => amountExchange($invoice['total'], $invoice['multi']),
                'DueDate'    => dateformat($invoice['invoiceduedate']),
            ]);

            if (isset($result['status']) && $result['status'] == 'Success') {
                $sent++;
                // Tag as alerted to prevent duplicates
                $this->db->insert('geopos_metadata', [
                    'type' => 99, 'rid' => $invoice['id'], 'd_date' => date('Y-m-d H:i:s')
                ]);
                echo "  ✓ Alerted: Invoice #{$invoice['tid']} → {$invoice['name']}\n";
            } else {
                $errors++;
                echo "  ✗ Failed: Invoice #{$invoice['tid']} → " . ($result['message'] ?? 'Unknown') . "\n";
            }
        }

        echo "--- Done. Sent: {$sent} | Errors: {$errors} ---\n";
    }


}
