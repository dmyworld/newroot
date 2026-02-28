<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketplace extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library("Aauth");
        // Redirect all marketplace traffic to the new consolidated shop
        redirect('shop', 'location', 301);
        
        $this->load->model('Marketplace_model', 'marketplace');
        $this->li_a = 'stock';
    }

    public function add_request()
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(array('status' => 'Error', 'message' => 'Please login to post a request'));
            return;
        }

        $data = array(
            'user_id' => $this->aauth->get_user()->id,
            'title' => $this->input->post('title'),
            'description' => $this->input->post('description'),
            'budget' => $this->input->post('budget'),
            'location' => $this->input->post('location'),
            'status' => 'active'
        );

        $result = $this->marketplace->create_request($data);
        echo json_encode($result);
    }

    public function index()
    {
        // Get all active lots and featured listings
        $data['lots'] = $this->marketplace->get_all_active_lots();
        $data['featured_lots'] = $this->marketplace->get_featured_listings(5);
        $data['is_logged_in'] = $this->aauth->is_loggedin();
        
        // Get Workers and Buyer Requests
        $this->load->model('Worker_model', 'worker');
        $data['workers'] = $this->worker->get_active_workers();
        $data['requests'] = $this->marketplace->get_active_requests();
        
        if ($this->aauth->is_loggedin()) {
            $data['usernm'] = $this->aauth->get_user()->username;
        }
        
        // Load integrated marketplace with modern header and tabs
        $this->load->view('marketplace/integrated_v2', $data);
    }

    public function view($type, $id)
    {
        $data['lot'] = $this->marketplace->get_lot_details($id, $type);
        $data['type'] = $type;
        $data['id'] = $id;
        
        $head['title'] = "Lot Detail - Marketplace";
        $head['usernm'] = $this->aauth->get_user()->username;
        $this->load->view('fixed/header', $head);
        $this->load->view('timber/market_view', $data);
        $this->load->view('fixed/footer');
    }

    public function place_bid()
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(array('status' => 'Error', 'message' => 'Please login to place a bid', 'redirect' => base_url('user')));
            return;
        }
        
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $amount = $this->input->post('amount');
        $buyer_id = $this->aauth->get_user()->id;

        $res = $this->marketplace->place_bid($id, $type, $buyer_id, $amount);
        echo json_encode($res);
    }

    public function get_latest_bid()
    {
        $id = $this->input->get('id');
        $type = $this->input->get('type');
        $bid = $this->marketplace->get_latest_bid($id, $type);
        echo json_encode($bid);
    }

    public function calculate_yield()
    {
        $volume = $this->input->post('volume');
        $kerf = $this->input->post('kerf'); // percentage 0-1
        $recovery = $volume * (1 - $kerf);
        echo json_encode(array('recovery' => number_format($recovery, 4)));
    }

    public function calculate_logistics()
    {
        $lat1 = $this->input->post('lat1');
        $lng1 = $this->input->post('lng1');
        $lat2 = $this->input->post('lat2');
        $lng2 = $this->input->post('lng2');
        $rate = $this->input->post('rate'); // Rate per KM

        $distance = $this->haversine($lat1, $lng1, $lat2, $lng2);
        $cost = $distance * $rate;
        
        echo json_encode(array(
            'distance' => number_format($distance, 2),
            'cost' => number_format($cost, 2)
        ));
    }

    private function haversine($lat1, $lon1, $lat2, $lon2)
    {
        $earth_radius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earth_radius * $c;
    }
    public function manage_bids()
    {
        $head['title'] = "Manage Bids - Seller";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['bids'] = $this->marketplace->get_incoming_bids($this->aauth->get_user()->id);
        
        $this->load->view('fixed/header', $head);
        $this->load->view('timber/bids_manage', $data);
        $this->load->view('fixed/footer');
    }

    public function my_deals()
    {
        $head['title'] = "My Purchased Timber - Buyer";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['bids'] = $this->marketplace->get_my_bids($this->aauth->get_user()->id);
        
        $this->load->view('fixed/header', $head);
        $this->load->view('timber/my_deals', $data);
        $this->load->view('fixed/footer');
    }

    public function update_bid_status()
    {
        $bid_id = $this->input->post('bid_id');
        $status = $this->input->post('status');
        $this->marketplace->update_bid_status($bid_id, $status);
        echo json_encode(array('status' => 'Success', 'message' => 'Status updated to ' . $status));
    }

    public function record_measurements()
    {
        $bid_id = $this->input->post('bid_id');
        $measurements = $this->input->post('measurements');
        $this->marketplace->submit_measurements($bid_id, $measurements);
        echo json_encode(array('status' => 'Success', 'message' => 'Measurements recorded!'));
    }

    public function set_agreement()
    {
        $bid_id = $this->input->post('bid_id');
        $role = $this->input->post('role'); // buyer or seller
        $state = $this->input->post('state'); // 1 or 0
        $res = $this->marketplace->set_agreement($bid_id, $role, $state);
        echo json_encode($res);
    }

    public function buy_now()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $buyer_id = $this->aauth->get_user()->id;

        $res = $this->marketplace->buy_now($id, $type, $buyer_id);
        echo json_encode($res);
    }

    public function request_buy()
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(array('status' => 'Error', 'message' => 'Please login to request a purchase', 'redirect' => base_url('user')));
            return;
        }
        
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $items = $this->input->post('items'); // Optional, for split logic if supported later
        $price = $this->input->post('price'); // Optional offer price
        $remarks = $this->input->post('remarks');
        $buyer_id = $this->aauth->get_user()->id;

        $res = $this->marketplace->send_buy_request($id, $type, $buyer_id, $items, $price, $remarks);
        echo json_encode($res);
    }

    public function approve_request_buy()
    {
        $bid_id = $this->input->post('bid_id');
        $res = $this->marketplace->approve_buy_request($bid_id);
        echo json_encode($res);
    }

    public function finalize_deal()
    {
        $bid_id = $this->input->post('bid_id');
        $transport_cost = $this->input->post('transport_cost');
        $final_total = $this->input->post('final_total');

        $res = $this->marketplace->finalize_deal_with_transport($bid_id, $transport_cost, $final_total);
        echo json_encode($res);
    }

    public function buy_partial()
    {
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $items = $this->input->post('items');
        $price = $this->input->post('price');
        $buyer_id = $this->aauth->get_user()->id;

        if (empty($items)) {
            echo json_encode(array('status' => 'Error', 'message' => 'No items selected'));
            return;
        }

        $res = $this->marketplace->split_lot($id, $type, $items, $buyer_id, $price);
        echo json_encode($res);
    }

    /**
     * Unified marketplace with Timber and Workers tabs
     */
    public function unified()
    {
        $head['title'] = "Marketplace - Timber & Workers";
        $this->load->view('landing_page/includes/header', $head);
        $this->load->view('landing_page/includes/nav');
        $this->load->view('marketplace/unified');
        $this->load->view('landing_page/includes/footer');
    }

    /**
     * Timber view for iframe (no header/footer)
     */
    public function timber_view()
    {
        $data['lots'] = $this->marketplace->get_active_lots('logs');
        $data['is_logged_in'] = $this->aauth->is_loggedin();
        $this->load->view('marketplace/public_marketplace', $data);
    }

    /**
     * Redesigned marketplace with social sharing
     */
    public function redesign()
    {
        $data['lots'] = $this->marketplace->get_all_active_lots();
        $data['featured_lots'] = $this->marketplace->get_featured_listings(5);
        $data['is_logged_in'] = $this->aauth->is_loggedin();
        
        $head['title'] = "Timber Marketplace - Buy Premium Timber";
        $this->load->view('marketplace/redesign', $data);
    }

    /**
     * Track social media shares
     */
    public function track_share()
    {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        
        if (!$data) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            return;
        }

        $this->db->insert('geopos_marketplace_shares', [
            'listing_id' => $data['listing_id'] ?? null,
            'listing_type' => $data['listing_type'] ?? '',
            'user_id' => $this->aauth->is_loggedin() ? $this->aauth->get_user()->id : null,
            'platform' => $data['platform'] ?? '',
            'share_url' => base_url('marketplace/view/'.$data['listing_type'].'/'.$data['listing_id']),
            'created_at' => date('Y-m-d H:i:s')
        ]);
        
        echo json_encode(['status' => 'success']);
    }

    /**
     * Send a message to the seller
     */
    public function contact_seller()
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(array('status' => 'Error', 'message' => 'Please login to chat with the seller'));
            return;
        }

        $this->load->model('Message_model', 'message');
        $sender_id = $this->aauth->get_user()->id;
        $receiver_id = $this->input->post('seller_id');
        $listing_name = $this->input->post('listing_name');
        $message_text = $this->input->post('message');

        $subject = "Inquiry about: " . $listing_name;
        $res = $this->message->send_message($sender_id, $receiver_id, $subject, $message_text);

        if ($res) {
            echo json_encode(array('status' => 'Success', 'message' => 'Message sent to seller!'));
        } else {
            echo json_encode(array('status' => 'Error', 'message' => 'Failed to send message.'));
        }
    }

    /**
     * Submit a quick offer for a listing
     */
    public function submit_offer()
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(array('status' => 'Error', 'message' => 'Please login to make an offer'));
            return;
        }

        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $amount = $this->input->post('amount');
        $buyer_id = $this->aauth->get_user()->id;

        // Reusing the bid system for quick offers
        $res = $this->marketplace->place_bid($id, $type, $buyer_id, $amount);
        echo json_encode($res);
    }
}
