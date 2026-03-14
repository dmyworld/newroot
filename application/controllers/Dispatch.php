<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dispatch extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dispatch_model');
        $this->load->library('aauth');
    }

    /**
     * Start the dispatch process (Phase 6.3)
     */
    public function start_search() {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
            return;
        }

        $service_id = $this->input->post('service_id');
        $lat = $this->input->post('lat');
        $lng = $this->input->post('lng');
        $address = $this->input->post('address');

        // 1. Create the request
        $request_data = [
            'customer_id' => $this->aauth->get_user_id(),
            'service_id' => $service_id,
            'pickup_lat' => $lat,
            'pickup_lng' => $lng,
            'pickup_address' => $address,
            'status' => 0 // Requested
        ];

        $request_id = $this->Dispatch_model->create_request($request_data);

        // 2. Find closest providers (10km radius originally, maybe start 5km?)
        $providers = $this->Dispatch_model->find_suitable_providers($service_id, $lat, $lng, 10);

        if (empty($providers)) {
            // Fallback logic (Phase 6.3): Expand radius or notify
             echo json_encode([
                'status' => 'fallback', 
                'request_id' => $request_id,
                'message' => 'No one nearby, expanding search...'
            ]);
            return;
        }

        // 3. Populate dispatch queue
        foreach ($providers as $index => $p) {
            $queue_data = [
                'request_id' => $request_id,
                'provider_id' => $p['id'],
                'status' => ($index === 0) ? 'pinged' : 'pending',
                'ping_at' => ($index === 0) ? date('Y-m-d H:i:s') : NULL,
                'expires_at' => ($index === 0) ? date('Y-m-d H:i:s', strtotime('+30 seconds')) : NULL
            ];
            $this->db->insert('tp_dispatch_queue', $queue_data);
        }

        echo json_encode([
            'status' => 'searching',
            'request_id' => $request_id,
            'provider_count' => count($providers),
            'first_provider' => $providers[0]['display_name']
        ]);
    }

    /**
     * Poll status (Phase 6.3)
     */
    public function poll_status($request_id) {
        // Check if any provider has accepted
        $request = $this->Dispatch_model->get_request($request_id);
        
        if ($request['status'] == 2) { // Accepted
            $provider = $this->db->get_where('tp_service_providers', ['id' => $request['provider_id']])->row_array();
            echo json_encode([
                'status' => 'accepted',
                'provider' => $provider
            ]);
            return;
        }

        if ($request['status'] == 5) { // Cancelled
            echo json_encode(['status' => 'cancelled']);
            return;
        }

        // Sequential Ping Logic: Check if current ping expired
        $current_ping = $this->db->get_where('tp_dispatch_queue', [
            'request_id' => $request_id,
            'status' => 'pinged'
        ])->row_array();

        if ($current_ping && strtotime($current_ping['expires_at']) < time()) {
            // Current ping expired, move to next
            $this->db->where('id', $current_ping['id'])->update('tp_dispatch_queue', ['status' => 'timed_out']);
            
            $next_ping = $this->db->get_where('tp_dispatch_queue', [
                'request_id' => $request_id,
                'status' => 'pending'
            ], 1, 0)->row_array();

            if ($next_ping) {
                $this->db->where('id', $next_ping['id'])->update('tp_dispatch_queue', [
                    'status' => 'pinged',
                    'ping_at' => date('Y-m-d H:i:s'),
                    'expires_at' => date('Y-m-d H:i:s', strtotime('+30 seconds'))
                ]);
                
                $provider = $this->db->get_where('tp_service_providers', ['id' => $next_ping['provider_id']])->row_array();
                echo json_encode([
                    'status' => 'pining_next',
                    'provider_name' => $provider['display_name'],
                    'remaining' => 30
                ]);
            } else {
                echo json_encode(['status' => 'no_providers_left']);
            }
            return;
        }

        // Still searching current or wait for next
        $remaining = $current_ping ? (strtotime($current_ping['expires_at']) - time()) : 0;
        echo json_encode([
            'status' => 'searching',
            'remaining' => max(0, $remaining)
        ]);
    }

    /**
     * Cancel search
     */
    public function cancel($request_id) {
        $this->Dispatch_model->update_request_status($request_id, 5); // 5 = Cancelled
        $this->db->where('request_id', $request_id)->update('tp_dispatch_queue', ['status' => 'rejected']);
        echo json_encode(['status' => 'ok']);
    }

    /**
     * Complete a job (Phase 7.1)
     * Handles commission split, wallet credit, and loyalty triggers.
     */
    public function complete_job($request_id) {
        $request = $this->Dispatch_model->get_request($request_id);
        if (!$request || $request['status'] != 3) { // 3 = Ongoing
             echo json_encode(['status' => 'error', 'message' => 'Invalid request state']);
             return;
        }

        $provider_id = $request['provider_id'];
        $customer_id = $request['customer_id'];
        $amount = $request['agreed_price'];

        // 1. Get Commission % for the service
        $this->load->model('services_model', 'services');
        $service = $this->services->get_by_id($request['service_id']);
        $commission_pc = isset($service['admin_commission_pc']) ? (float)$service['admin_commission_pc'] : 20.0;

        $commission_amt = ($amount * $commission_pc) / 100;
        $worker_net = $amount - $commission_amt;

        $this->db->trans_start();

        // 2. Update Request Status
        $this->Dispatch_model->update_request_status($request_id, 4); // 4 = Completed
        $this->db->where('id', $request_id)->update('tp_service_requests', ['completed_at' => date('Y-m-d H:i:s')]);

        // 3. Credit Worker Wallet
        $this->load->model('Wallet_model', 'wallet');
        $this->load->model('providers_model', 'providers');
        $provider = $this->providers->get_by_id($provider_id);
        
        $this->wallet->credit($provider['user_id'], $worker_net, 'service_job', $request_id, [
            'total_amount' => $amount,
            'commission' => $commission_amt,
            'commission_percentage' => $commission_pc
        ]);

        // 4. Record Admin Commission (as a transaction or metadata)
        // For simplicity, we assume the platform holds the total until split.
        
        // 5. Trigger Loyalty Points for Customer
        $this->load->model('Loyalty_model', 'loyalty');
        $this->loyalty->add_points($customer_id, $amount, 'service_request', $request_id);

        // 6. Generate Next-Order Coupon (Phase 7.3)
        $this->load->model('Promo_model', 'promo');
        $coupon_code = $this->promo->generate_next_order_coupon($customer_id);

        $this->db->trans_complete();

        if ($this->db->trans_status()) {
            // Trigger Wow Factor (Phase 7.4)
            require_once APPPATH . 'controllers/Post_Service_Interaction.php';
            $wow = new Post_Service_Interaction();
            $wow->trigger_wow($request_id);

            echo json_encode([
                'status' => 'success',
                'worker_net' => $worker_net,
                'commission' => $commission_amt,
                'coupon' => $coupon_code
            ]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Transaction failed']);
        }
    }
}
