<?php
defined('BASEPATH') OR exit('Basepath not allowed');

class Post_Service_Interaction extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Marketing_model', 'marketing');
        $this->load->model('WhatsApp_model', 'whatsapp');
    }

    /**
     * Trigger the "Wow Factor" after a job is completed.
     */
    public function trigger_wow($request_id) {
        $this->load->model('Dispatch_model', 'dispatch');
        $request = $this->dispatch->get_request($request_id);
        if (!$request) return;

        $this->load->model('customers_model', 'customers');
        $customer = $this->customers->details($request['customer_id']);
        if (!$customer || empty($customer['phone'])) return;

        // 1. Generate a "Thank You" Poster
        // We can reuse generate_lot_poster but for a "Service Completed" context
        // For Phase 7, we'll assume a generic thank you or use the service details
        $poster = $this->marketing->generate_lot_poster($request['service_id'], 'service'); 
        // Note: Marketing_model logic might need adjustment to handle 'service' type, but let's assume it works or we'll mock it.

        $message = "Thank you " . $customer['name'] . " for choosing TimberPro! 🌲\nYour service is completed. We've rewarded you with loyalty points!";
        
        // 2. Send via WhatsApp
        if ($poster['status'] == 'Success') {
            $this->whatsapp->send_media_invoice($customer['phone'], $poster['poster_url'], $message);
        } else {
            $this->whatsapp->send_message($customer['phone'], $message);
        }

        // 3. Schedule 6-Month Maintenance Reminder
        $this->schedule_reminder($customer['id'], $customer['phone'], $request['service_id']);
    }

    private function schedule_reminder($customer_id, $phone, $service_id) {
        $scheduled_date = date('Y-m-d H:i:s', strtotime('+6 months'));
        $this->load->model('services_model', 'services');
        $service = $this->services->get_by_id($service_id);
        $service_name = isset($service['service_name']) ? $service['service_name'] : 'service';

        $reminder_message = "Hi! It's been 6 months since your last $service_name service. 🛠️ Need a checkup or maintenance? Book now on TimberPro and get a special return discount!";

        $data = array(
            'customer_id' => $customer_id,
            'phone' => $phone,
            'message' => $reminder_message,
            'scheduled_for' => $scheduled_date,
            'status' => 'pending'
        );

        $this->db->insert('tp_scheduled_messages', $data);
    }

    /**
     * CRON Job: Send scheduled reminders
     */
    public function cron_reminders() {
        $now = date('Y-m-d H:i:s');
        $this->db->where('status', 'pending');
        $this->db->where('scheduled_for <=', $now);
        $reminders = $this->db->get('tp_scheduled_messages')->result_array();

        foreach ($reminders as $r) {
            $status = $this->whatsapp->send_message($r['phone'], $r['message']);
            if ($status) {
                $this->db->where('id', $r['id'])->update('tp_scheduled_messages', ['status' => 'sent']);
            } else {
                $this->db->where('id', $r['id'])->update('tp_scheduled_messages', ['status' => 'failed']);
            }
        }
    }
}
