<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'controllers/api/Api_base.php';

/**
 * Action Module API (Phase 2 - Uber-style matching)
 *
 * Key endpoints:
 *  - POST /api/action/device/register       → register FCM token
 *  - POST /api/action/provider/ping        → update provider GPS
 *  - POST /api/action/provider/availability→ toggle is_available
 *  - POST /api/action/request/create       → create request (single item)
 *  - GET  /api/action/request/status       → poll request status
 *  - POST /api/action/request/accept       → provider accepts
 *  - POST /api/action/request/reject       → provider declines
 *  - GET  /api/action/nearby_markers       → generic map markers
 *  - POST /api/action/request/complete     → mark completed + wallet/commission
 *  - POST /api/action/rating/add           → customer rating
 *  - GET  /api/action/rating/list          → provider ratings
 */
class Action extends Api_base
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Action_request_model', 'actions');
        $this->load->library('Fcm_lib');
    }

    /* -------------------------------------------------------------
     * Device & Provider Location
     * ------------------------------------------------------------- */

    /**
     * POST /api/action/device/register
     * Body: { device_id, platform: android|ios|web, fcm_token }
     * Auth required.
     */
    public function register_device_post()
    {
        if (!$this->_authenticate()) return;

        $device_id = trim((string)$this->post('device_id'));
        $platform  = (string)$this->post('platform');
        $token     = trim((string)$this->post('fcm_token'));

        if ($device_id === '' || $token === '' || !in_array($platform, ['android','ios','web'], true)) {
            $this->_fail('device_id, platform and fcm_token are required');
            return;
        }

        $data = [
            'user_id'   => (int)$this->current_user_id,
            'device_id' => $device_id,
            'platform'  => $platform,
            'fcm_token' => $token,
        ];

        $this->db->where('user_id', (int)$this->current_user_id)
            ->where('device_id', $device_id)
            ->delete('tp_push_tokens');
        $this->db->insert('tp_push_tokens', $data);

        $this->_success([], 'Device registered');
    }

    /**
     * POST /api/action/provider/ping
     * Body: { lat, lng }
     * Auth required (provider).
     * Updates tp_vendor_profiles last_lat/last_long/last_seen_at.
     */
    public function provider_ping_post()
    {
        if (!$this->_authenticate()) return;

        $lat = (float)$this->post('lat');
        $lng = (float)$this->post('lng');

        if (!$lat || !$lng) {
            $this->_fail('lat and lng are required');
            return;
        }

        $user_id = (int)$this->current_user_id;

        // Upsert into tp_vendor_profiles
        $row = $this->db->where('user_id', $user_id)
            ->get('tp_vendor_profiles')
            ->row_array();

        $data = [
            'user_id'      => $user_id,
            'last_lat'     => $lat,
            'last_long'    => $lng,
            'last_seen_at' => date('Y-m-d H:i:s'),
        ];

        if ($row) {
            $this->db->where('user_id', $user_id)->update('tp_vendor_profiles', $data);
        } else {
            $data['bio']        = '';
            $data['rating']     = 0.00;
            $data['is_online']  = 1;
            $data['is_available'] = 1;
            $this->db->insert('tp_vendor_profiles', $data);
        }

        $this->_success([], 'Location updated');
    }

    /**
     * POST /api/action/provider/availability
     * Body: { is_online: 0|1, is_available: 0|1 }
     * Auth required (provider).
     */
    public function provider_availability_post()
    {
        if (!$this->_authenticate()) return;

        $user_id     = (int)$this->current_user_id;
        $is_online   = $this->post('is_online');
        $is_available= $this->post('is_available');

        $data = [];
        if ($is_online !== null)   $data['is_online']   = (int)(bool)$is_online;
        if ($is_available !== null)$data['is_available']= (int)(bool)$is_available;

        if (empty($data)) {
            $this->_fail('Nothing to update');
            return;
        }

        $row = $this->db->where('user_id', $user_id)
            ->get('tp_vendor_profiles')
            ->row_array();

        if ($row) {
            $this->db->where('user_id', $user_id)->update('tp_vendor_profiles', $data);
        } else {
            $data['user_id'] = $user_id;
            $data['last_seen_at'] = date('Y-m-d H:i:s');
            $this->db->insert('tp_vendor_profiles', $data);
        }

        $this->_success([], 'Availability updated');
    }

    /* -------------------------------------------------------------
     * Requests & Matching
     * ------------------------------------------------------------- */

    /**
     * POST /api/action/request/create
     * Body: {
     *   category_id, item_id (optional), type: Product|Service,
     *   lat, lng, radius_km (5/10/20 etc), group_id (optional UUID)
     * }
     * Auth required (customer).
     */
    public function request_create_post()
    {
        if (!$this->_authenticate()) return;

        $category_id = (int)$this->post('category_id');
        $item_id     = $this->post('item_id') ? (int)$this->post('item_id') : null;
        $type        = $this->post('type') ?: 'Service';
        $lat         = (float)$this->post('lat');
        $lng         = (float)$this->post('lng');
        $radius_km   = (float)($this->post('radius_km') ?: 10);
        $group_id    = trim((string)$this->post('group_id'));

        if (!$category_id || !$lat || !$lng) {
            $this->_fail('category_id, lat and lng are required');
            return;
        }

        if ($radius_km <= 0) $radius_km = 10;
        if ($group_id === '') {
            $group_id = $this->_generate_uuid_v4();
        }

        $request_id = $this->actions->create_request(
            $this->current_user_id,
            $category_id,
            $item_id,
            $type,
            $lat,
            $lng,
            $radius_km,
            $group_id
        );

        $this->_success([
            'request_id' => (int)$request_id,
            'group_id'   => $group_id,
        ], 'Request created', 201);
    }

    /**
     * GET /api/action/request/status?request_id=
     */
    public function request_status_get()
    {
        if (!$this->_authenticate()) return;

        $request_id = (int)$this->get('request_id');
        if (!$request_id) {
            $this->_fail('request_id is required');
            return;
        }

        $req = $this->actions->get_request_with_rings($request_id);
        if (!$req) {
            $this->_fail('Request not found', 404);
            return;
        }

        // Hide internal fields if needed
        $this->_success($req);
    }

    /**
     * POST /api/action/request/accept
     * Body: { request_id }
     * Auth required (provider).
     */
    public function request_accept_post()
    {
        if (!$this->_authenticate()) return;

        $request_id = (int)$this->post('request_id');
        if (!$request_id) {
            $this->_fail('request_id is required');
            return;
        }

        $ok = $this->actions->accept($request_id, $this->current_user_id);
        if (!$ok) {
            $this->_fail('Request already taken or expired', 409);
            return;
        }

        $this->_success([], 'Request accepted');
    }

    /**
     * POST /api/action/request/reject
     * Body: { request_id }
     * Auth required (provider).
     */
    public function request_reject_post()
    {
        if (!$this->_authenticate()) return;

        $request_id = (int)$this->post('request_id');
        if (!$request_id) {
            $this->_fail('request_id is required');
            return;
        }

        $this->actions->decline($request_id, $this->current_user_id);
        $this->_success([], 'Request declined');
    }

    /**
     * POST /api/action/request/complete
     * Body: { request_id, amount }
     * Auth required (customer). Triggers wallet credit + commission deduction.
     */
    public function request_complete_post()
    {
        if (!$this->_authenticate()) return;

        $request_id = (int)$this->post('request_id');
        $amount     = (float)$this->post('amount');

        if (!$request_id || $amount <= 0) {
            $this->_fail('request_id and positive amount are required');
            return;
        }

        $req = $this->db->where('id', $request_id)->get('tp_action_requests')->row_array();
        if (!$req) {
            $this->_fail('Request not found', 404);
            return;
        }

        // Only customer who created the request or admin (role >=5) can complete
        $role = isset($this->current_user['role']) ? (int)$this->current_user['role'] : 0;
        if ($this->current_user_id !== (int)$req['customer_id'] && $role < 5) {
            $this->_fail('You are not allowed to complete this request', 403);
            return;
        }

        $result = $this->actions->complete_with_wallet($request_id, $amount);
        if ($result === false) {
            $this->_fail('Request is not in an accepted state or already completed', 409);
            return;
        }

        $this->_success($result, 'Request completed and wallet settled');
    }

    /**
     * GET /api/action/nearby_markers?lat=&lng=&radius_km=&type=Product|Service
     * Returns generic provider markers for map view (no PII).
     */
    public function nearby_markers_get()
    {
        $lat       = (float)$this->get('lat');
        $lng       = (float)$this->get('lng');
        $radius_km = (float)($this->get('radius_km') ?: 10);
        $type      = $this->get('type') ?: null;

        if (!$lat || !$lng) {
            $this->_fail('lat and lng are required');
            return;
        }
        if ($radius_km <= 0) $radius_km = 10;

        $params = [
            'cust_lat'  => $lat,
            'cust_lng'  => $lng,
            'radius_km' => $radius_km,
        ];

        $sql = "
            SELECT 
                vp.user_id,
                vp.last_lat,
                vp.last_long,
                (6371 * ACOS(
                    COS(RADIANS(:cust_lat)) * COS(RADIANS(vp.last_lat)) *
                    COS(RADIANS(vp.last_long) - RADIANS(:cust_lng)) +
                    SIN(RADIANS(:cust_lat)) * SIN(RADIANS(vp.last_lat))
                )) AS distance_km
            FROM tp_vendor_profiles vp
            WHERE vp.is_online = 1
              AND vp.is_available = 1
              AND vp.last_lat IS NOT NULL
              AND vp.last_long IS NOT NULL
              AND vp.last_seen_at >= (NOW() - INTERVAL 15 MINUTE)
        ";

        if ($type) {
            $sql .= "
              AND EXISTS (
                    SELECT 1 FROM tp_vendor_services vs
                     WHERE vs.user_id = vp.user_id
                       AND vs.type = :marker_type
                       AND vs.status = 1
              )
            ";
            $params['marker_type'] = $type === 'Product' ? 'Product' : 'Service';
        }

        $sql .= "
            HAVING distance_km <= :radius_km
            ORDER BY distance_km ASC
            LIMIT 200
        ";

        $rows = $this->db->query($sql, $params)->result_array();

        $markers = [];
        foreach ($rows as $r) {
            $markers[] = [
                'lat'        => (float)$r['last_lat'],
                'lng'        => (float)$r['last_long'],
                'distance_km'=> (float)$r['distance_km'],
            ];
        }

        $this->_success([
            'center'  => ['lat' => $lat, 'lng' => $lng],
            'radius'  => $radius_km,
            'markers' => $markers,
        ]);
    }

    /* -------------------------------------------------------------
     * Helpers
     * ------------------------------------------------------------- */

    private function _generate_uuid_v4(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /* -------------------------------------------------------------
     * Ratings
     * ------------------------------------------------------------- */

    /**
     * POST /api/action/rating/add
     * Body: { request_id, provider_id, stars, punctuality?, work_quality?, comment? }
     * Auth required (customer).
     */
    public function rating_add_post()
    {
        if (!$this->_authenticate()) return;

        $request_id  = (int)$this->post('request_id');
        $provider_id = (int)$this->post('provider_id');
        $stars       = (int)$this->post('stars');
        $punctuality = $this->post('punctuality') !== null ? (int)$this->post('punctuality') : null;
        $work_quality= $this->post('work_quality') !== null ? (int)$this->post('work_quality') : null;
        $comment     = trim((string)$this->post('comment'));

        if (!$request_id || !$provider_id || $stars < 1 || $stars > 5) {
            $this->_fail('request_id, provider_id and stars (1-5) are required');
            return;
        }

        $req = $this->db->where('id', $request_id)->get('tp_action_requests')->row_array();
        if (!$req) {
            $this->_fail('Request not found', 404);
            return;
        }

        if ((int)$req['customer_id'] !== (int)$this->current_user_id) {
            $this->_fail('Only the customer can rate this request', 403);
            return;
        }

        if ((int)$req['chosen_provider_id'] !== $provider_id) {
            $this->_fail('Provider does not match this request', 400);
            return;
        }

        // Avoid duplicate rating per request+customer
        $exists = $this->db->where('request_id', $request_id)
            ->where('customer_id', (int)$this->current_user_id)
            ->get('tp_provider_ratings')
            ->row_array();
        if ($exists) {
            $this->_fail('You have already rated this job', 409);
            return;
        }

        $data = [
            'request_id'  => $request_id,
            'provider_id' => $provider_id,
            'customer_id' => (int)$this->current_user_id,
            'stars'       => $stars,
            'punctuality' => $punctuality,
            'work_quality'=> $work_quality,
            'comment'     => $comment ?: null,
            'created_at'  => date('Y-m-d H:i:s'),
        ];
        $this->db->insert('tp_provider_ratings', $data);

        // Recalculate provider aggregate rating
        $row = $this->db->select('AVG(stars) AS avg_stars')
            ->from('tp_provider_ratings')
            ->where('provider_id', $provider_id)
            ->get()
            ->row_array();
        $avg = $row && $row['avg_stars'] !== null ? round((float)$row['avg_stars'], 2) : 0.0;

        $this->db->where('user_id', $provider_id)
            ->update('tp_vendor_profiles', ['rating' => $avg]);

        $this->_success(['provider_id' => $provider_id, 'rating' => $avg], 'Rating saved');
    }

    /**
     * GET /api/action/rating/list?provider_id=&page=&per_page=
     */
    public function rating_list_get()
    {
        $provider_id = (int)$this->get('provider_id');
        if (!$provider_id) {
            $this->_fail('provider_id is required');
            return;
        }

        $page     = max(1, (int)($this->get('page') ?: 1));
        $per_page = min(100, (int)($this->get('per_page') ?: 20));
        $offset   = ($page - 1) * $per_page;

        $this->db->where('provider_id', $provider_id);
        $total = $this->db->count_all_results('tp_provider_ratings');

        $this->db->where('provider_id', $provider_id)
            ->order_by('created_at', 'DESC')
            ->limit($per_page, $offset);
        $rows = $this->db->get('tp_provider_ratings')->result_array();

        $this->_paginated($rows, $total, $page, $per_page);
    }
}

