<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * QuoteRequests Controller
 * Handles geo-fenced peer-to-peer quotation requests for the marketplace.
 * Buyers post requests; nearby sellers receive and respond with bids.
 */
class QuoteRequests extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        $this->load->model('QuoteRequest_model', 'qr');
        $this->load->model('Marketplace_model', 'mp');
    }

    /**
     * Public listing of all active geo-fenced quote requests.
     * Shown in the "Bidding" tab on shop/index.php.
     */
    public function index()
    {
        $data['quote_requests'] = $this->qr->get_active_requests();
        $data['is_logged_in']   = $this->aauth->is_loggedin();
        $data['title']          = 'Open Quotation Requests';
        $this->load->view('public/header', $data);
        $this->load->view('quote_requests/index', $data);
        $this->load->view('public/footer');
    }

    /**
     * Dashboard for logged-in buyers: see their requests & responses.
     * Kanban view: Requested → Received Bids → Accepted → Completed
     */
    public function dashboard()
    {
        if (!$this->aauth->is_loggedin()) { redirect('user'); return; }

        $user_id = $this->aauth->get_user()->id;
        $data['my_requests']  = $this->qr->get_my_requests($user_id);
        $data['title']        = 'My Quote Requests';
        $data['is_logged_in'] = true;
        $this->load->view('public/header', $data);
        $this->load->view('quote_requests/dashboard', $data);
        $this->load->view('public/footer');
    }

    /**
     * AJAX: Post a new geo-fenced quote request.
     */
    public function post_request()
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(['status' => 'Error', 'message' => 'Please login first.']);
            return;
        }

        $user_id     = $this->aauth->get_user()->id;
        $product     = $this->input->post('product_name', true);
        $description = $this->input->post('description', true);
        $quantity    = $this->input->post('quantity');
        $budget_min  = $this->input->post('budget_min');
        $budget_max  = $this->input->post('budget_max');
        $province    = $this->input->post('province', true);
        $district    = $this->input->post('district', true);
        $lat         = $this->input->post('lat');
        $lng         = $this->input->post('lng');
        $radius_km   = $this->input->post('radius_km') ?: 50;

        if (!$product || !$quantity) {
            echo json_encode(['status' => 'Error', 'message' => 'Product name and quantity are required.']);
            return;
        }

        $data = [
            'user_id'      => $user_id,
            'product_name' => $product,
            'description'  => $description,
            'quantity'     => $quantity,
            'budget_min'   => $budget_min ?: 0,
            'budget_max'   => $budget_max ?: 0,
            'province'     => $province,
            'district'     => $district,
            'lat'          => $lat ?: 0,
            'lng'          => $lng ?: 0,
            'radius_km'    => $radius_km,
            'status'       => 'open',
            'expires_at'   => date('Y-m-d', strtotime('+7 days')),
        ];

        $id = $this->qr->create_request($data);

        if ($id) {
            echo json_encode(['status' => 'Success', 'message' => 'Your request has been broadcast to nearby sellers!', 'id' => $id]);
        } else {
            echo json_encode(['status' => 'Error', 'message' => 'Failed to post request. Please try again.']);
        }
    }

    /**
     * AJAX: Submit a bid/quote in response to a request.
     */
    public function submit_bid()
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(['status' => 'Error', 'message' => 'Please login to submit a bid.']);
            return;
        }

        $request_id  = $this->input->post('request_id');
        $seller_id   = $this->aauth->get_user()->id;
        $amount      = $this->input->post('amount');
        $notes       = $this->input->post('notes', true);
        $delivery_days = $this->input->post('delivery_days') ?: 7;

        if (!$request_id || !$amount) {
            echo json_encode(['status' => 'Error', 'message' => 'Request ID and bid amount are required.']);
            return;
        }

        $data = [
            'request_id'    => $request_id,
            'seller_id'     => $seller_id,
            'amount'        => $amount,
            'notes'         => $notes,
            'delivery_days' => $delivery_days,
            'status'        => 'pending',
            'submitted_at'  => date('Y-m-d H:i:s'),
        ];

        $result = $this->qr->create_bid($data);

        if ($result) {
            echo json_encode(['status' => 'Success', 'message' => 'Your bid has been submitted successfully!']);
        } else {
            echo json_encode(['status' => 'Error', 'message' => 'Failed to submit bid.']);
        }
    }

    /**
     * AJAX: Accept a bid (by the buyer). Changes request status to accepted.
     */
    public function accept_bid()
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(['status' => 'Error', 'message' => 'Unauthorized.']);
            return;
        }

        $bid_id     = $this->input->post('bid_id');
        $request_id = $this->input->post('request_id');
        $user_id    = $this->aauth->get_user()->id;

        $result = $this->qr->accept_bid($bid_id, $request_id, $user_id);

        if ($result) {
            echo json_encode(['status' => 'Success', 'message' => 'Bid accepted! The seller will be notified.']);
        } else {
            echo json_encode(['status' => 'Error', 'message' => 'Failed to accept bid.']);
        }
    }

    /**
     * AJAX: Get bids for a specific request.
     */
    public function get_bids()
    {
        $request_id = $this->input->get('request_id');
        $bids = $this->qr->get_bids_for_request($request_id);
        echo json_encode($bids);
    }

    /**
     * AJAX: Geo-filter — get requests within a certain radius of a lat/lng.
     */
    public function nearby()
    {
        $lat       = $this->input->get('lat');
        $lng       = $this->input->get('lng');
        $radius_km = $this->input->get('radius') ?: 50;

        if (!$lat || !$lng) {
            echo json_encode([]);
            return;
        }

        $requests = $this->qr->get_nearby_requests($lat, $lng, $radius_km);
        echo json_encode($requests);
    }

    /**
     * AJAX: Update Kanban card status (for drag-and-drop board).
     */
    public function update_status()
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(['status' => 'Error', 'message' => 'Unauthorized.']);
            return;
        }

        $request_id = $this->input->post('request_id');
        $new_status = $this->input->post('status');
        $user_id    = $this->aauth->get_user()->id;

        $allowed_statuses = ['open', 'bids_received', 'accepted', 'completed', 'cancelled'];
        if (!in_array($new_status, $allowed_statuses)) {
            echo json_encode(['status' => 'Error', 'message' => 'Invalid status.']);
            return;
        }

        $result = $this->qr->update_request_status($request_id, $new_status, $user_id);
        echo json_encode(['status' => $result ? 'Success' : 'Error']);
    }
}
