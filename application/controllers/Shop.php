<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Consumer Shop - Public timber purchasing portal
 * Regular customers can browse, calculate, request quotes, and submit orders.
 *
 * Routes:
 *  /shop               - Homepage (browse listings)
 *  /shop/view/{type}/{id} - Single product detail
 *  /shop/calculator    - Interactive timber calculator
 *  /shop/request_quote - Submit a quote request
 *  /shop/my_orders     - Logged-in customer orders
 *  /shop/checkout      - Order submission
 *  /shop/track/{order_id} - Order tracking
 */
class Shop extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('Aauth');
        $this->load->model('Marketplace_model', 'mp');
        $this->load->model('Wood_types_model', 'wood');
        $this->load->model('Worker_model', 'worker');
        $this->load->model('Audit_model', 'audit');
        $this->load->model('Categories_model', 'categories');
        $this->_ensure_tables();
    }

    private function _ensure_tables(): void
    {
        if (!$this->db->table_exists('consumer_orders')) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `consumer_orders` (
                  `id`               INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                  `order_number`     VARCHAR(20)  UNIQUE,
                  `customer_id`      INT UNSIGNED DEFAULT 0,
                  `customer_name`    VARCHAR(150) NOT NULL,
                  `customer_phone`   VARCHAR(30)  NOT NULL,
                  `customer_email`   VARCHAR(150) DEFAULT NULL,
                  `customer_address` TEXT,
                  `lot_id`           INT UNSIGNED NOT NULL,
                  `lot_type`         VARCHAR(30)  NOT NULL,
                  `species`          VARCHAR(100) DEFAULT NULL,
                  `quantity`         DECIMAL(10,2) DEFAULT 1,
                  `unit`             VARCHAR(20)  DEFAULT 'pieces',
                  `thickness_inches` DECIMAL(8,2) DEFAULT NULL,
                  `width_inches`     DECIMAL(8,2) DEFAULT NULL,
                  `length_ft`        DECIMAL(8,2) DEFAULT NULL,
                  `custom_size_note` TEXT         DEFAULT NULL,
                  `volume_cuft`      DECIMAL(10,4) DEFAULT NULL,
                  `quoted_price`     DECIMAL(12,2) DEFAULT NULL,
                  `final_price`      DECIMAL(12,2) DEFAULT NULL,
                  `payment_method`   ENUM('cash','bank_transfer','online') DEFAULT 'cash',
                  `status`           ENUM('quote','confirmed','processing','ready','delivered','cancelled') DEFAULT 'quote',
                  `delivery_required` TINYINT(1)  DEFAULT 0,
                  `delivery_address`  TEXT        DEFAULT NULL,
                  `seller_note`      TEXT         DEFAULT NULL,
                  `customer_note`    TEXT         DEFAULT NULL,
                  `branch_id`        INT UNSIGNED DEFAULT 0,
                  `assigned_to`      INT UNSIGNED DEFAULT 0,
                  `created_at`       DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  `updated_at`       DATETIME     ON UPDATE CURRENT_TIMESTAMP,
                  INDEX(`customer_id`),
                  INDEX(`status`),
                  INDEX(`lot_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
            ");
        }
    }

    /* ------------------------------------------------------------------
     * GET /shop
     * Public homepage — browse all available timber
     * ------------------------------------------------------------------ */
    public function index()
    {
        $type     = $this->input->get('type');
        $species  = $this->input->get('species');
        $district = $this->input->get('district');
        $grade    = $this->input->get('grade');
        $max_price= $this->input->get('max_price');

        // 1. Timber Listings
        $lots = $this->mp->get_all_active_lots();
        if ($type)    $lots = array_filter($lots, fn($l) => ($l['lot_type'] ?? '') === $type);
        if ($species) $lots = array_filter($lots, fn($l) => stripos($l['species'] ?? '', $species) !== false);
        if ($grade)   $lots = array_filter($lots, fn($l) => ($l['grade'] ?? '') === $grade);

        foreach ($lots as &$lot) {
            $photos = json_decode($lot['photos'] ?? '[]', true);
            $lot['thumbnail'] = $photos[0] ?? null;
            $lot['is_verified'] = !empty($lot['permit_verified']);
            $lot['price'] = $lot['selling_price'] ?? 0; // Standardize field name for marketplace card
            $lot['location'] = $lot['location'] ?? 'Sri Lanka';
            $lot['name'] = ($lot['species'] ?? '') . ' ' . ucfirst($lot['lot_type'] ?? '');
            $lot['type'] = $lot['lot_type'] ?? 'logs';
        }
        $lots = array_values($lots);

        // 2. Featured Listings
        $featured_lots = $this->mp->get_featured_listings(6);
        foreach ($featured_lots as &$flot) {
            $flot['name'] = ($flot['species'] ?? '') . ' ' . ucfirst($flot['lot_type'] ?? '');
            $flot['price'] = $flot['selling_price'] ?? 0;
            $flot['type'] = $flot['lot_type'] ?? 'logs';
        }

        // 3. Worker Services
        $workers = $this->worker->get_active_workers();

        // 4. Hardware Products
        $hardware = $this->mp->get_hardware_products(12);

        // 5. Job Board (Workforce Requests)
        $jobs = $this->mp->get_open_job_requests(10);

        // 6. Quotation Hub (Product Requests)
        $quote_requests = $this->mp->get_active_requests(10);

        // 7. Market Prices for Strip
        $market_prices = [];
        if ($this->db->table_exists('market_price_tracker')) {
            $this->db->select('t.species, t.price_per_unit, t.unit, t.recorded_at');
            $this->db->from('market_price_tracker t');
            $this->db->join(
                '(SELECT species, unit, MAX(recorded_at) as latest FROM market_price_tracker GROUP BY species, unit) m',
                'm.species = t.species AND m.latest = t.recorded_at AND m.unit = t.unit'
            );
            $this->db->where('t.unit', 'cubic_ft');
            $this->db->limit(10);
            $market_prices = $this->db->get()->result_array();
        }

        // 8. Dynamic Filter Data
        $main_categories = $this->categories->category_list(0);
        
        $location_data = [
            'Western' => ['Colombo', 'Gampaha', 'Kalutara'],
            'Central' => ['Kandy', 'Matale', 'Nuwara Eliya'],
            'Southern' => ['Galle', 'Matara', 'Hambantota'],
            'Northern' => ['Jaffna', 'Kilinochchi', 'Mannar', 'Mullaitivu', 'Vavuniya'],
            'Eastern' => ['Batticaloa', 'Ampara', 'Trincomalee'],
            'North Western' => ['Kurunegala', 'Puttalam'],
            'North Central' => ['Anuradhapura', 'Polonnaruwa'],
            'Uva' => ['Badulla', 'Moneragala'],
            'Sabaragamuwa' => ['Ratnapura', 'Kegalle']
        ];

        $data = [
            'lots'          => $lots,
            'featured_lots' => $featured_lots,
            'workers'       => $workers,
            'hardware'      => $hardware,
            'jobs'          => $jobs,
            'quote_requests'=> $quote_requests,
            'market_prices' => $market_prices,
            'categories'    => $main_categories,
            'locations'     => $location_data,
            'filters'       => compact('type', 'species', 'district', 'grade', 'max_price'),
            'is_logged_in'  => $this->aauth->is_loggedin(),
            'usernm'        => $this->aauth->get_user()->username ?? '',
            'title'         => "TimberPro Ecosystem - Market, Services & Logistics"
        ];

        $this->load->view('public/header', $data);
        $this->load->view('shop/index', $data);
        $this->load->view('public/footer');

    }

    public function track_share()
    {
        $input = json_decode($this->input->raw_input_stream, true);
        if ($input) {
            $this->audit->log('share', 'shop', $input['listing_id'], $input['platform']);
            echo json_encode(['status' => 'Success']);
        }
    }

    /* ------------------------------------------------------------------
     * AJAX: Get Sub-categories for a Main Category
     * ------------------------------------------------------------------ */
    public function get_subcategories()
    {
        $cat_id = $this->input->get('cat_id');
        $subs = $this->categories->category_list(1, $cat_id);
        echo json_encode($subs);
    }

    /* ------------------------------------------------------------------
     * GET /shop/view/{type}/{id}
     * Single product detail page
     * ------------------------------------------------------------------ */
    public function view($type = 'logs', $id = 0)
    {
        $lot = $this->mp->get_lot_details($id, $type);
        if (!$lot) { show_404(); return; }

        // Parse photos
        $lot['photos'] = json_decode($lot['photos'] ?? '[]', true);

        // Latest bid
        $lot['latest_bid'] = $this->mp->get_latest_bid($id, $type);

        // Compute Hoppus volume if logs
        if ($type === 'logs' && !empty($lot['girth_inches']) && !empty($lot['length_ft'])) {
            $g = (float)$lot['girth_inches'];
            $l = (float)$lot['length_ft'];
            $lot['computed_volume'] = round(($g / 4) * ($g / 4) * $l / 144, 3);
        } elseif ($type === 'sawn' && !empty($lot['thickness_inches'])) {
            $lot['computed_volume'] = round(
                ((float)$lot['thickness_inches'] * (float)$lot['width_inches'] * (float)$lot['length_ft']) / 144 * (int)($lot['quantity'] ?? 1),
                3
            );
        }

        // Similar listings
        $similar = array_slice($this->mp->get_all_active_lots(), 0, 4);

        // Standardize lot data for view
        $lot['is_verified'] = !empty($lot['permit_verified']);
        $lot['total_price'] = $lot['total_price'] ?? ($lot['price'] ?? 0);
        $lot['selling_price'] = $lot['selling_price'] ?? 0;
        $lot['location'] = $lot['location'] ?? 'Sri Lanka';
        $lot['name'] = htmlspecialchars($lot['lot_name'] ?? ($lot['species'] ?? 'Timber') . ' ' . ucfirst($type));
        $lot['type'] = $type;

        $head = [
            'title'   => ($lot['species'] ?? 'Timber') . ' - ' . ucfirst($type) . ' | TimberPro Shop',
            'is_shop' => true,
            'og_title'       => ($lot['species'] ?? 'Timber') . ' ' . ucfirst($type),
            'og_description' => "Premium " . ($lot['species'] ?? '') . " " . $type . " available in " . ($lot['location'] ?? 'Sri Lanka') . ". Price: LKR " . number_format($lot['selling_price'] ?? 0),
            'og_image'       => !empty($lot['photos']) ? base_url($lot['photos'][0]) : base_url('assets/images/og-default.jpg'),
            'og_url'         => current_url(),
        ];
        $data = [
            'lot'         => $lot,
            'type'        => $type,
            'similar'     => $similar,
            'is_logged_in'=> $this->aauth->is_loggedin(),
        ];

        $this->load->view('public/header', $head);
        $this->load->view('shop/product_detail', $data);
        $this->load->view('public/footer');
    }

    /* ------------------------------------------------------------------
     * GET /shop/calculator
     * Public Timber Calculator page (no login needed)
     * ------------------------------------------------------------------ */
    public function calculator()
    {
        $data['title'] = "Timber Volume Calculator";
        $this->load->view('public/header', $data);
        $this->load->view('shop/calculator');
        $this->load->view('public/footer');
    }

    /* ------------------------------------------------------------------
     * GET /shop/request_quote
     * POST /shop/submit_quote
     * Customer requests a price quote for a specific lot/custom spec
     * ------------------------------------------------------------------ */
    public function request_quote()
    {
        $data['title'] = "Request a Quote";
        $this->load->view('public/header', $data);
        $this->load->view('shop/request_quote');
        $this->load->view('public/footer');
    }

    public function submit_quote()
    {
        // Validate required fields
        $name  = trim($this->input->post('customer_name'));
        $phone = trim($this->input->post('customer_phone'));
        $lot_id   = (int)$this->input->post('lot_id');
        $lot_type = $this->input->post('lot_type') ?: 'lots';

        if (!$name || !$phone || !$lot_id) {
            echo json_encode(['status' => 'Error', 'message' => 'Name, phone and lot selection are required']);
            return;
        }

        $qty   = (float)($this->input->post('quantity') ?: 1);
        $thick = (float)$this->input->post('thickness_inches');
        $width = (float)$this->input->post('width_inches');
        $len   = (float)$this->input->post('length_ft');

        // Compute volume
        $volume = null;
        if ($thick > 0 && $width > 0 && $len > 0) {
            $volume = round(($thick * $width * $len) / 144 * $qty, 4);
        }

        // Generate order number
        $order_number = 'TPS-' . date('Ym') . '-' . strtoupper(substr(uniqid(), -4));

        $order_data = [
            'order_number'     => $order_number,
            'customer_id'      => $this->aauth->is_loggedin() ? $this->aauth->get_user()->id : 0,
            'customer_name'    => $name,
            'customer_phone'   => $phone,
            'customer_email'   => $this->input->post('customer_email'),
            'customer_address' => $this->input->post('customer_address'),
            'lot_id'           => $lot_id,
            'lot_type'         => $lot_type,
            'species'          => $this->input->post('species'),
            'quantity'         => $qty,
            'unit'             => $this->input->post('unit') ?: 'pieces',
            'thickness_inches' => $thick ?: null,
            'width_inches'     => $width ?: null,
            'length_ft'        => $len ?: null,
            'custom_size_note' => $this->input->post('custom_size_note'),
            'volume_cuft'      => $volume,
            'payment_method'   => $this->input->post('payment_method') ?: 'cash',
            'delivery_required'=> (int)$this->input->post('delivery_required'),
            'delivery_address' => $this->input->post('delivery_address'),
            'customer_note'    => $this->input->post('customer_note'),
            'status'           => 'quote',
        ];

        $this->db->insert('consumer_orders', $order_data);
        $inserted_id = $this->db->insert_id();

        // Audit log
        $this->audit->log([
            'user_id'    => $order_data['customer_id'],
            'action'     => 'QUOTE_REQUEST',
            'entity'     => 'consumer_orders',
            'entity_id'  => $inserted_id,
            'details'    => json_encode(['order_number' => $order_number, 'lot_id' => $lot_id]),
            'ip_address' => $this->input->ip_address(),
        ]);

        echo json_encode([
            'status'       => 'Success',
            'message'      => 'ඔබගේ ඇණවුම් ඉල්ලීම ලැබෙන ලදී! | Quote request received.',
            'order_number' => $order_number,
            'order_id'     => $inserted_id,
        ]);
    }

    /* ------------------------------------------------------------------
     * GET /shop/checkout/{lot_id}/{lot_type}
     * Direct purchase flow
     * ------------------------------------------------------------------ */
    public function checkout($lot_id = 0, $lot_type = 'logs')
    {
        $lot = $this->mp->get_lot_details($lot_id, $lot_type);
        if (!$lot) { show_404(); return; }

        $head = ['title' => 'Checkout | TimberPro Shop', 'is_shop' => true];
        $data = ['lot' => $lot, 'lot_type' => $lot_type];

        $this->load->view('public/header', $head);
        $this->load->view('shop/checkout', $data);
        $this->load->view('public/footer');
    }

    /* ------------------------------------------------------------------
     * GET /shop/track/{order_number}
     * Public order tracking (no login needed)
     * ------------------------------------------------------------------ */
    public function track($order_number = '')
    {
        $order = null;
        if ($order_number) {
            $this->db->where('order_number', $this->db->escape_str($order_number));
            $order = $this->db->get('consumer_orders')->row_array();
        }

        $head = ['title' => 'Track Order | TimberPro Shop', 'is_shop' => true];
        $data = ['order' => $order, 'order_number' => $order_number];

        $this->load->view('public/header', $head);
        $this->load->view('shop/track', $data);
        $this->load->view('public/footer');
    }

    /* ------------------------------------------------------------------
     * GET /shop/my_orders
     * Logged-in customer order history
     * ------------------------------------------------------------------ */
    public function my_orders()
    {
        if (!$this->aauth->is_loggedin()) {
            redirect('/user/', 'refresh');
        }

        $uid = $this->aauth->get_user()->id;
        $this->db->where('customer_id', $uid);
        $this->db->order_by('created_at', 'DESC');
        $orders = $this->db->get('consumer_orders')->result_array();

        $head = ['title' => 'My Orders | TimberPro Shop', 'is_shop' => true];
        $data = ['orders' => $orders];

        $this->load->view('public/header', $head);
        $this->load->view('shop/my_orders', $data);
        $this->load->view('public/footer');
    }

    /* ------------------------------------------------------------------
     * Internal: Admin order management
     * GET /shop/admin_orders  (requires admin role)
     * ------------------------------------------------------------------ */
    public function admin_orders()
    {
        if (!$this->aauth->is_loggedin()) { redirect('/user/'); return; }
        if (!$this->aauth->is_member(5)) { show_error('Access denied', 403); return; }

        $status = $this->input->get('status') ?: '';
        if ($status) $this->db->where('status', $status);
        $this->db->order_by('created_at', 'DESC');
        $orders = $this->db->get('consumer_orders')->result_array();

        $head = ['title' => 'Consumer Orders | Admin', 'usernm' => $this->aauth->get_user()->username];
        $data = ['orders' => $orders, 'status_filter' => $status];

        $this->load->view('fixed/header', $head);
        $this->load->view('shop/admin_orders', $data);
        $this->load->view('fixed/footer');
    }

    public function update_order_status()
    {
        if (!$this->aauth->is_loggedin() || !$this->aauth->is_member(5)) {
            echo json_encode(['status' => 'Error', 'message' => 'Unauthorized']);
            return;
        }

        $order_id   = (int)$this->input->post('order_id');
        $new_status = $this->input->post('status');
        $note       = $this->input->post('seller_note');

        $allowed = ['quote', 'confirmed', 'processing', 'ready', 'delivered', 'cancelled'];
        if (!in_array($new_status, $allowed)) {
            echo json_encode(['status' => 'Error', 'message' => 'Invalid status']);
            return;
        }

        $this->db->where('id', $order_id);
        $this->db->update('consumer_orders', [
            'status'      => $new_status,
            'seller_note' => $note,
        ]);

        $this->audit->log([
            'user_id'   => $this->aauth->get_user()->id,
            'action'    => 'ORDER_STATUS_UPDATE',
            'entity'    => 'consumer_orders',
            'entity_id' => $order_id,
            'details'   => json_encode(['new_status' => $new_status]),
            'ip_address'=> $this->input->ip_address(),
        ]);

        echo json_encode(['status' => 'Success', 'message' => 'Order status updated to ' . $new_status]);
    }

    /* ------------------------------------------------------------------
     * Marketplace B2B Methods (Migrated from Marketplace.php)
     * ------------------------------------------------------------------ */

    public function manage_bids()
    {
        if (!$this->aauth->is_loggedin()) { redirect('/user/'); return; }
        $head['title'] = "Manage Bids - Seller";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['bids'] = $this->mp->get_incoming_bids($this->aauth->get_user()->id);
        
        $this->load->view('fixed/header', $head);
        $this->load->view('timber/bids_manage', $data);
        $this->load->view('fixed/footer');
    }

    public function my_deals()
    {
        if (!$this->aauth->is_loggedin()) { redirect('/user/'); return; }
        $head['title'] = "My Purchased Timber - Buyer";
        $head['usernm'] = $this->aauth->get_user()->username;
        $data['bids'] = $this->mp->get_my_bids($this->aauth->get_user()->id);
        
        $this->load->view('fixed/header', $head);
        $this->load->view('timber/my_deals', $data);
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
        $res = $this->mp->place_bid($id, $type, $buyer_id, $amount);
        echo json_encode($res);
    }

    public function buy_now()
    {
        if (!$this->aauth->is_loggedin()) {
            echo json_encode(array('status' => 'Error', 'message' => 'Please login to buy', 'redirect' => base_url('user')));
            return;
        }
        $id = $this->input->post('id');
        $type = $this->input->post('type');
        $buyer_id = $this->aauth->get_user()->id;
        $res = $this->mp->buy_now($id, $type, $buyer_id);
        echo json_encode($res);
    }

    public function finalize_deal()
    {
        if (!$this->aauth->is_loggedin()) return;
        $bid_id = $this->input->post('bid_id');
        $transport_cost = $this->input->post('transport_cost');
        $final_total = $this->input->post('final_total');
        $res = $this->mp->finalize_deal_with_transport($bid_id, $transport_cost, $final_total);
        echo json_encode($res);
    }

    public function approve_request_buy()
    {
        if (!$this->aauth->is_loggedin()) return;
        $bid_id = $this->input->post('bid_id');
        $res = $this->mp->approve_request_buy($bid_id);
        echo json_encode($res);
    }

    public function update_bid_status()
    {
        if (!$this->aauth->is_loggedin()) return;
        $bid_id = $this->input->post('bid_id');
        $status = $this->input->post('status');
        $res = $this->mp->update_bid_status($bid_id, $status);
        echo json_encode($res);
    }

    public function record_measurements()
    {
        if (!$this->aauth->is_loggedin()) return;
        $bid_id = $this->input->post('bid_id');
        $measurements = $this->input->post('measurements');
        $res = $this->mp->record_measurements($bid_id, $measurements);
        echo json_encode($res);
    }

    public function set_agreement()
    {
        if (!$this->aauth->is_loggedin()) return;
        $bid_id = $this->input->post('bid_id');
        $role = $this->input->post('role');
        $state = $this->input->post('state');
        $res = $this->mp->set_agreement($bid_id, $role, $state);
        echo json_encode($res);
    }

    public function smart_search()
    {
        $query = $this->input->get('q');
        if (!$query) { echo json_encode([]); return; }
        
        $results = $this->mp->smart_search($query);
        echo json_encode($results);
    }

    /* ------------------------------------------------------------------
     * Marketplace Admin Stubs
     * ------------------------------------------------------------------ */

    public function listings()
    {
        if (!$this->aauth->is_loggedin()) { redirect('/user/'); return; }
        $head['title'] = "My Marketplace Listings";
        $data['lots'] = $this->mp->get_all_active_lots(); // For now show all, usually filter by seller_id
        
        $this->load->view('fixed/header', $head);
        $this->load->view('shop/admin_listings', $data);
        $this->load->view('fixed/footer');
    }

    public function quotations()
    {
        if (!$this->aauth->is_loggedin()) { redirect('/user/'); return; }
        $head['title'] = "Received Quotations & Requests";
        $data['quotes'] = $this->db->where('status', 'quote')->get('consumer_orders')->result_array();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('shop/admin_quotations', $data);
        $this->load->view('fixed/footer');
    }

    public function orders()
    {
        if (!$this->aauth->is_loggedin()) { redirect('/user/'); return; }
        $head['title'] = "Marketplace Orders";
        $data['orders'] = $this->db->where_not_in('status', 'quote')->get('consumer_orders')->result_array();
        
        $this->load->view('fixed/header', $head);
        $this->load->view('shop/admin_orders_list', $data);
        $this->load->view('fixed/footer');
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
}
