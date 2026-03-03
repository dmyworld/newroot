<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * WhatsApp Settings & Automation Controller
 * Manages API credentials, templates, and sends on-demand messages.
 */
class WhatsApp extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        $this->load->model('plugins_model', 'plugins');
        $this->load->model('WhatsApp_model', 'whatsapp');
        if (!$this->aauth->is_loggedin()) { redirect('/user/'); }
        $this->li_a = 'whatsapp';
    }

    /**
     * Settings & Template Management UI
     */
    public function index()
    {
        $head['title'] = "WhatsApp Automation";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['settings'] = $this->plugins->universal_api(10);
        $data['templates'] = $this->_get_templates();

        $this->load->view('fixed/header-va', $head);
        $this->load->view('whatsapp/index', $data);
        $this->load->view('fixed/footer');
    }

    /**
     * Save API settings (key1=token, key2=instance_id, url=gateway_url, other=auto_invoice)
     */
    public function save_settings()
    {
        $key1   = $this->input->post('wa_token');
        $key2   = $this->input->post('wa_instance');
        $url    = $this->input->post('wa_gateway_url');
        $other  = (int)$this->input->post('auto_invoice');
        $active = (int)$this->input->post('wa_active');

        $data = ['key1' => $key1, 'key2' => $key2, 'url' => $url, 'other' => $other, 'active' => $active];
        $this->db->where('id', 10)->update('univarsal_api', $data);

        echo json_encode(['status' => 'Success', 'message' => 'WhatsApp settings saved.']);
    }

    /**
     * Save a message template (text stored in geopos_templates.other)
     */
    public function save_template()
    {
        $id   = $this->input->post('template_id');
        $text = $this->input->post('template_text');
        $this->db->where('id', $id)->update('geopos_templates', ['other' => $text]);
        echo json_encode(['status' => 'Success', 'message' => 'Template updated.']);
    }

    /**
     * Send a test WhatsApp message
     */
    public function send_test()
    {
        $to  = $this->input->post('to');
        $msg = $this->input->post('message');
        $result = $this->whatsapp->send_message($to, $msg);
        echo json_encode($result);
    }

    /**
     * Cronjob-callable: send reminders for HP installments due in 3 days
     */
    public function send_reminders()
    {
        $target_date = date('Y-m-d', strtotime('+3 days'));
        $this->db->select('i.id, i.due_date, i.amount, i.installment_num, c.customer_id, c.id as contract_id');
        $this->db->from('geopos_hp_installments i');
        $this->db->join('geopos_hp_contracts c', 'c.id = i.contract_id');
        $this->db->where('i.status', 'unpaid');
        $this->db->where('i.due_date', $target_date);
        $due_rows = $this->db->get()->result_array();

        $sent = 0;
        foreach ($due_rows as $row) {
            $customer = $this->db->select('name,phone')->where('id', $row['customer_id'])->get('geopos_customers')->row_array();
            if (!empty($customer['phone'])) {
                $this->whatsapp->send_template($customer['phone'], 42, [
                    'Name'           => $customer['name'],
                    'Amount'         => number_format($row['amount'], 2),
                    'DueDate'        => $row['due_date'],
                    'InstallmentNum' => $row['installment_num'],
                    'ContractID'     => $row['contract_id'],
                ]);
                $sent++;
            }
        }
        echo json_encode(['status' => 'Success', 'sent' => $sent]);
    }

    // ─────── Private ───────
    private function _get_templates()
    {
        // IDs 40–42 reserved for WhatsApp templates
        $this->db->where_in('id', [40, 41, 42]);
        $rows = $this->db->get('geopos_templates')->result_array();
        // Ensure templates exist; seed defaults if missing
        $defaults = [
            40 => ['name' => 'WA: Invoice Created',      'text' => 'Dear {Name}, your Invoice #{BillNumber} for {Amount} has been created. Due on {DueDate}. Thank you! - Timber Pro'],
            41 => ['name' => 'WA: HP Payment Confirmed',  'text' => 'Dear {Name}, your HP payment of LKR {Amount} for Installment #{InstallmentNum} (Contract #{ContractID}) has been received. Thank you!'],
            42 => ['name' => 'WA: Installment Reminder',  'text' => 'Reminder: Dear {Name}, your HP installment #{InstallmentNum} (Contract #{ContractID}) of LKR {Amount} is due on {DueDate}. Please arrange payment.'],
        ];
        $existing_ids = array_column($rows, 'id');
        foreach ($defaults as $tid => $def) {
            if (!in_array($tid, $existing_ids)) {
                $this->db->insert('geopos_templates', ['id' => $tid, 'name' => $def['name'], 'type' => 'whatsapp', 'other' => $def['text']]);
                $rows[] = ['id' => $tid, 'name' => $def['name'], 'type' => 'whatsapp', 'other' => $def['text']];
            }
        }
        return $rows;
    }
}
